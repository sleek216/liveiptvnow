<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Setting;
use App\Mail\NewOrderNotification;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;
use Stripe\Exception\ApiErrorException;

class StripeController extends Controller
{
    public function __construct()
    {
        $this->initializeStripe();
    }

    protected function getStripeSecretKey(): ?string
    {
        $key = Setting::get('stripe_secret_key') ?: config('services.stripe.secret') ?: env('STRIPE_SECRET');
        if (!$key) {
            return null;
        }

        $key = trim($key);
        // If key accidentally has prefix like 'adm', extract standard sk_live, sk_test, rk_live, rk_test
        if (preg_match('/(sk_live_[a-zA-Z0-9]+|sk_test_[a-zA-Z0-9]+|rk_live_[a-zA-Z0-9]+|rk_test_[a-zA-Z0-9]+)/', $key, $matches)) {
            $key = $matches[1];
        }

        return $key;
    }

    protected function initializeStripe(): void
    {
        $secretKey = $this->getStripeSecretKey();
        if ($secretKey) {
            Stripe::setApiKey($secretKey);
        } else {
            \Log::warning('StripeController: Secret key is missing in settings, config, and env.');
        }
    }

    /**
     * Create Stripe checkout session for an existing order
     */
    public function checkout(string $orderNumber): RedirectResponse
    {
        \Log::info('StripeController: Entered checkout method for order: ' . $orderNumber);
        $order = Order::where('order_number', $orderNumber)->with('package')->firstOrFail();

        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        if (!$order->package) {
            \Log::error('StripeController: Package not found for order: ' . $orderNumber);
            return redirect()
                ->route('checkout.pending', $order->order_number)
                ->with('error', 'Package not found. Please contact support.');
        }

        $secretKey = $this->getStripeSecretKey();
        if (!$secretKey) {
            \Log::error('StripeController: Attempted checkout but Stripe Secret Key is not set.');
            return redirect()
                ->route('checkout.pending', $order->order_number)
                ->with('error', 'Stripe Payment Gateway is not configured. Please set Secret Key in Admin Panel.');
        }

        Stripe::setApiKey($secretKey);

        if ($order->payment_status === 'completed') {
            return redirect()->route('stripe.success', ['order' => $order->order_number]);
        }

        try {
            $unitAmount = (int) round(((float) $order->amount) * 100);
            \Log::info('StripeController: Creating session for Order ' . $order->order_number . ' Amount: $' . $order->amount . ' (cents: ' . $unitAmount . ')');

            if ($unitAmount < 50) {
                return redirect()
                    ->route('checkout.pending', $order->order_number)
                    ->with('error', 'Order amount is too low for card payment (minimum $0.50).');
            }

            $session = StripeSession::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => $order->package->name,
                            'description' => $order->package->description ?? 'IPTV Subscription Package',
                        ],
                        'unit_amount' => $unitAmount,
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => route('stripe.success', ['order' => $order->order_number]) . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('stripe.cancel', ['order' => $order->order_number]),
                'customer_email' => $order->customer_email,
                'metadata' => [
                    'order_number' => $order->order_number,
                    'package_id' => $order->package_id,
                    'user_id' => $order->user_id,
                ],
            ]);

            $order->update(['stripe_session_id' => $session->id]);

            \Log::info('StripeController: Redirecting to Stripe session: ' . $session->id);
            return redirect($session->url);
        } catch (ApiErrorException $e) {
            \Log::error('StripeController: Stripe API Error: ' . $e->getMessage());
            
            $order->update([
                'payment_status' => 'failed',
                'admin_notes' => 'Stripe Error: ' . $e->getMessage(),
            ]);

            return redirect()
                ->route('checkout.pending', $order->order_number)
                ->with('error', 'Card payment processing is temporarily unavailable. Please try again in a few moments or contact support.');
        } catch (\Exception $e) {
            \Log::error('StripeController: Unexpected error: ' . $e->getMessage());

            return redirect()
                ->route('checkout.pending', $order->order_number)
                ->with('error', 'We could not initiate card payment at this time. Please try again or contact support.');
        }
    }

    public function success(Request $request, string $order): View|RedirectResponse
    {
        $order = Order::where('order_number', $order)->with('package')->firstOrFail();
        $package = $order->package;

        if ($request->has('session_id')) {
            try {
                $session = StripeSession::retrieve($request->session_id);

                if ($session->payment_status === 'paid') {
                    if ($order->payment_status === 'completed') {
                        return view('checkout.success', compact('order', 'package'));
                    }

                    $order->update([
                        'stripe_payment_id' => $session->payment_intent,
                        'payment_status' => 'completed',
                    ]);

                    // Send confirmation email to customer
                    try {
                        $order->sendConfirmationEmail();
                    } catch (\Exception $e) {
                        \Log::error('Failed to send confirmation email: ' . $e->getMessage());
                    }

                    // Create affiliate commission
                    try {
                        $order->processAffiliateCommissionIfPaid();
                    } catch (\Exception $e) {
                        \Log::error('Failed to create commission: ' . $e->getMessage());
                    }
                }
            } catch (ApiErrorException $e) {
                \Log::error('StripeController: Success Method Error: ' . $e->getMessage());
            }
        }

        return view('checkout.success', compact('order', 'package'));
    }

    public function cancel(string $order): View
    {
        $order = Order::where('order_number', $order)->with('package')->firstOrFail();

        $order->update([
            'payment_status' => 'failed',
            'order_status' => 'cancelled',
        ]);

        return view('checkout.cancel', compact('order'));
    }

    public function webhook(Request $request)
    {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $webhookSecret = Setting::get('stripe_webhook_secret');

        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload, $sigHeader, $webhookSecret
            );
        } catch (\Exception $e) {
            return response()->json(['error' => 'Webhook verification failed'], 400);
        }

        switch ($event->type) {
            case 'checkout.session.completed':
                $session = $event->data->object;
                $this->handleSuccessfulPayment($session);
                break;

            case 'payment_intent.payment_failed':
                $paymentIntent = $event->data->object;
                $this->handleFailedPayment($paymentIntent);
                break;
        }

        return response()->json(['status' => 'success']);
    }

    protected function handleSuccessfulPayment($session): void
    {
        $order = Order::where('stripe_session_id', $session->id)->first();

        if ($order && $order->payment_status !== 'completed') {
            $order->update([
                'stripe_payment_id' => $session->payment_intent,
                'payment_status' => 'completed',
            ]);

            // Send confirmation email to customer
            try {
                $order->sendConfirmationEmail();
            } catch (\Exception $e) {
                \Log::error('Failed to send confirmation email: ' . $e->getMessage());
            }

            // Create affiliate commission
            try {
                $order->processAffiliateCommissionIfPaid();
            } catch (\Exception $e) {
                \Log::error('Failed to create commission: ' . $e->getMessage());
            }

            // Send admin notification
            $adminEmail = Setting::get('admin_notification_email');
            if ($adminEmail) {
                try {
                    Mail::to($adminEmail)->send(new NewOrderNotification($order));
                } catch (\Exception $e) {
                    // Log error
                }
            }
        }
    }

    protected function handleFailedPayment($paymentIntent): void
    {
        $order = Order::where('stripe_payment_id', $paymentIntent->id)->first();

        if ($order) {
            $order->update([
                'payment_status' => 'failed',
                'admin_notes' => 'Payment failed: ' . ($paymentIntent->last_payment_error->message ?? 'Unknown error'),
            ]);
        }
    }
}
