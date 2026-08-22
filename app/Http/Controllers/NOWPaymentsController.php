<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\NOWPaymentsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class NOWPaymentsController extends Controller
{
    protected NOWPaymentsService $nowPayments;

    public function __construct(NOWPaymentsService $nowPayments)
    {
        $this->nowPayments = $nowPayments;
    }

    /**
     * Create a payment for an order
     */
    public function createPayment(Request $request, Order $order)
    {
        if (!$this->nowPayments->isEnabled()) {
            return back()->with('error', 'Cryptocurrency payment is currently unavailable.');
        }

        $validated = $request->validate([
            'pay_currency' => 'required|string',
        ]);

        try {
            // Create payment
            $result = $this->nowPayments->createPayment([
                'price_amount' => $order->amount,
                'price_currency' => 'usd',
                'pay_currency' => $validated['pay_currency'],
                'ipn_callback_url' => route('nowpayments.ipn'),
                'order_id' => $order->order_number,
                'order_description' => "Order #{$order->order_number} - {$order->package->name}",
                'success_url' => route('nowpayments.success', $order->order_number),
                'cancel_url' => route('nowpayments.cancel', $order->order_number),
            ]);

            if ($result['success']) {
                // Update order with payment details
                $order->update([
                    'payment_method' => 'nowpayments',
                    'payment_id' => $result['payment']['payment_id'],
                    'payment_status' => 'pending',
                ]);

                // Redirect to payment URL
                return redirect($result['payment']['pay_address'] ?? $result['payment']['invoice_url']);
            }

            return back()->with('error', $result['error'] ?? 'Failed to create payment.');
        } catch (\Exception $e) {
            Log::error('NOWPayments Create Payment Error: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while processing your payment.');
        }
    }

    /**
     * Create an invoice for an order
     */
    public function createInvoice(Request $request, Order $order)
    {
        if (!$this->nowPayments->isEnabled()) {
            return back()->with('error', 'Cryptocurrency payment is currently unavailable.');
        }

        try {
            // Create invoice
            $invoiceData = [
                'price_amount' => $order->amount,
                'price_currency' => 'usd',
                'order_id' => $order->order_number,
                'order_description' => "Order #{$order->order_number} - {$order->package->name}",
                'ipn_callback_url' => route('nowpayments.ipn'),
                'success_url' => route('nowpayments.success', $order->order_number),
                'cancel_url' => route('nowpayments.cancel', $order->order_number),
            ];

            if (session()->has('crypto_currency')) {
                $invoiceData['pay_currency'] = session('crypto_currency');
            }

            $result = $this->nowPayments->createInvoice($invoiceData);

            if ($result['success']) {
                // Update order with invoice details
                $order->update([
                    'payment_method' => 'nowpayments',
                    'payment_id' => $result['invoice']['id'],
                    'payment_status' => 'pending',
                ]);

                // Redirect to invoice URL
                return redirect($result['invoice']['invoice_url']);
            }

            return back()->with('error', $result['error'] ?? 'Failed to create invoice.');
        } catch (\Exception $e) {
            Log::error('NOWPayments Create Invoice Error: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while processing your payment.');
        }
    }

    /**
     * Handle IPN callback
     */
    public function handleIPN(Request $request)
    {
        try {
            $signature = $request->header('x-nowpayments-sig');
            $data = $request->all();

            // Verify signature
            if (!$this->nowPayments->verifyIPN($data, $signature)) {
                Log::warning('NOWPayments IPN verification failed', $data);
                return response()->json(['error' => 'Invalid signature'], 400);
            }

            // Find order
            $order = Order::where('order_number', $data['order_id'])->first();

            if (!$order) {
                Log::warning('NOWPayments IPN: Order not found', $data);
                return response()->json(['error' => 'Order not found'], 404);
            }

            // Update order based on payment status
            $paymentStatus = $data['payment_status'];

            switch ($paymentStatus) {
                case 'finished':
                case 'confirmed':
                    if ($order->payment_status === 'completed') {
                        break;
                    }
                    $order->update([
                        'payment_status' => 'completed',
                    ]);
                    
                    // Send confirmation email to customer
                    try {
                        $order->sendConfirmationEmail();
                    } catch (\Exception $e) {
                        Log::error('Failed to send confirmation email: ' . $e->getMessage());
                    }
                    
                    // Create affiliate commission
                    try {
                        $affiliateService = app(\App\Services\AffiliateService::class);
                        $order->processAffiliateCommissionIfPaid();
                    } catch (\Exception $e) {
                        Log::error('Failed to create commission: ' . $e->getMessage());
                    }
                    break;

                case 'partially_paid':
                    $order->update([
                        'payment_status' => 'partially_paid',
                    ]);
                    break;

                case 'failed':
                case 'expired':
                    $order->update([
                        'payment_status' => 'failed',
                        'order_status' => 'cancelled',
                    ]);
                    break;

                case 'sending':
                case 'waiting':
                    $order->update([
                        'payment_status' => 'pending',
                    ]);
                    break;
            }

            Log::info('NOWPayments IPN processed', [
                'order' => $order->order_number,
                'status' => $paymentStatus,
            ]);

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error('NOWPayments IPN Error: ' . $e->getMessage(), [
                'data' => $request->all(),
            ]);
            return response()->json(['error' => 'Internal error'], 500);
        }
    }

    /**
     * Success callback
     */
    public function success($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)->firstOrFail();
        
        return redirect()->route('checkout.success', $orderNumber)
            ->with('success', 'Your cryptocurrency payment is being processed. You will receive a confirmation email shortly.');
    }

    /**
     * Cancel callback
     */
    public function cancel($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)->firstOrFail();
        
        $order->update([
            'payment_status' => 'cancelled',
            'order_status' => 'cancelled',
        ]);

        return redirect()->route('packages.index')
            ->with('error', 'Payment was cancelled.');
    }

    /**
     * Get available currencies (AJAX)
     */
    public function getCurrencies()
    {
        if (!$this->nowPayments->isEnabled()) {
            return response()->json(['error' => 'Service unavailable'], 503);
        }

        $result = $this->nowPayments->getAvailableCurrencies();

        if ($result['success']) {
            return response()->json($result['currencies']);
        }

        return response()->json(['error' => $result['error']], 500);
    }

    /**
     * Get estimated price (AJAX)
     */
    public function getEstimate(Request $request)
    {
        if (!$this->nowPayments->isEnabled()) {
            return response()->json(['error' => 'Service unavailable'], 503);
        }

        $validated = $request->validate([
            'amount' => 'required|numeric|min:0',
            'currency' => 'required|string',
        ]);

        $result = $this->nowPayments->getEstimatedPrice(
            $validated['amount'],
            'usd',
            $validated['currency']
        );

        if ($result['success']) {
            return response()->json($result['data']);
        }

        return response()->json(['error' => $result['error']], 500);
    }
}
