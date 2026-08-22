<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\Order;
use App\Models\Country;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class CheckoutController extends Controller
{
    public function show(string $slug): View
    {
        $package = Package::where('slug', $slug)->active()->with('features')->firstOrFail();
        $countries = Country::active()->ordered()->get();
        
        // Calculate discount if coupon exists in session
        $couponCode = session('coupon_code');
        $discountAmount = 0;
        $finalPrice = $package->price;
        $coupon = null;

        if ($couponCode) {
            $coupon = \App\Models\Coupon::active()->where('code', $couponCode)->first();
            if ($coupon && $coupon->isValid()) {
                $discountAmount = $coupon->calculateDiscount($package->price);
                $finalPrice = max(0, $package->price - $discountAmount);
            } else {
                session()->forget('coupon_code');
            }
        }

        $referralCodePrefill = old('referral_code', app(\App\Services\AffiliateService::class)->getReferralCode());

        return view('checkout.show', compact('package', 'countries', 'discountAmount', 'finalPrice', 'coupon', 'referralCodePrefill'));
    }

    public function applyCoupon(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'coupon_code' => 'required|string',
            'package_id' => 'required|exists:packages,id'
        ]);

        $couponCode = strtoupper($request->coupon_code);
        $package = Package::find($request->package_id);
        
        $coupon = \App\Models\Coupon::where('code', $couponCode)->first();

        if (!$coupon) {
            return response()->json([
                'valid' => false,
                'message' => 'Invalid coupon code.'
            ], 422);
        }

        if (!$coupon->isValid()) {
            return response()->json([
                'valid' => false,
                'message' => 'This coupon has expired or reached its usage limit.'
            ], 422);
        }

        // Store in session
        session(['coupon_code' => $couponCode]);

        $discount = $coupon->calculateDiscount($package->price);
        $finalPrice = max(0, $package->price - $discount);

        return response()->json([
            'valid' => true,
            'message' => 'Coupon applied successfully!',
            'discount_amount' => number_format($discount, 2),
            'final_price' => number_format($finalPrice, 2)
        ]);
    }

    public function process(Request $request, string $slug): RedirectResponse
    {
        $package = Package::where('slug', $slug)->active()->firstOrFail();

        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'nullable|string|max:50',
            'notes' => 'nullable|string|max:1000',
            'payment_method' => 'required|in:stripe,crypto',
            'selected_countries' => 'nullable|array',
            'referral_code' => 'nullable|string|max:20',
            'crypto_currency' => 'nullable|required_if:payment_method,crypto|string',
        ]);

        // Validate Payment Method Availability
        $stripeEnabled = \App\Models\Setting::get('stripe_enabled', '1') === '1';
        $nowpaymentsEnabled = \App\Models\Setting::get('nowpayments_enabled', '0') === '1';

        if ($validated['payment_method'] === 'stripe' && !$stripeEnabled) {
             return back()->withInput()->withErrors(['payment_method' => 'Stripe payment is currently disabled.']);
        }
        if ($validated['payment_method'] === 'crypto' && !$nowpaymentsEnabled) {
             return back()->withInput()->withErrors(['payment_method' => 'Cryptocurrency payment is currently disabled.']);
        }

        // Handle Coupon
        $couponCode = session('coupon_code');
        $discountAmount = 0;
        $finalPrice = $package->price;
        $appliedCoupon = null;

        if ($couponCode) {
            $appliedCoupon = \App\Models\Coupon::active()->where('code', $couponCode)->first();
            if ($appliedCoupon && $appliedCoupon->isValid()) {
                $discountAmount = $appliedCoupon->calculateDiscount($package->price);
                $finalPrice = max(0, $package->price - $discountAmount);
                $appliedCoupon->incrementUsage();
                session()->forget('coupon_code'); // Clear after use
            }
        }

        // Validate referral code if provided, or apply from cookie
        $referralCode = $validated['referral_code'] ?? null;
        $affiliateService = app(\App\Services\AffiliateService::class);

        if (!$referralCode) {
            $referralCode = $affiliateService->getReferralCode();
        }

        if ($referralCode) {
            $affiliate = \App\Models\Affiliate::where('referral_code', $referralCode)
                ->where('is_active', true)
                ->first();

            if (!$affiliate) {
                return back()->withInput()->with('error', 'Invalid referral code.');
            }

            if ($affiliate->user_id === auth()->id()) {
                return back()->withInput()->with('error', 'You cannot use your own referral code.');
            }

            $affiliateService->applyReferralForUser(auth()->user(), $referralCode);
        }

        // Create order
        \Log::info('CheckoutController: Creating order for package ID: ' . $package->id);
        $order = Order::create([
            'order_number' => Order::generateOrderNumber(),
            'user_id' => auth()->id(),
            'package_id' => $package->id,
            'customer_name' => $validated['customer_name'],
            'customer_email' => $validated['customer_email'],
            'customer_phone' => $validated['customer_phone'] ?? null,
            'amount' => $finalPrice, // Use discounted price
            'payment_method' => $finalPrice > 0 ? $validated['payment_method'] : 'free',
            'notes' => $validated['notes'] ?? null,
            'selected_countries' => $validated['selected_countries'] ?? null,
            'coupon_code' => $appliedCoupon ? $appliedCoupon->code : null,
            'discount_amount' => $discountAmount,
            // If price is 0, mark as paid immediately
            'payment_status' => $finalPrice <= 0 ? 'completed' : 'pending',
            'order_status' => $finalPrice <= 0 ? 'pending' : 'pending', // Keep pending for manual review or auto-process
        ]);

        // Attach countries if selected
        if (!empty($validated['selected_countries'])) {
            $order->countries()->attach($validated['selected_countries']);
        }

        // Notify Admin of new order creation (with fallback to From Address)
        try {
            $adminEmail = \App\Models\Setting::get('admin_notification_email')
                ?: \App\Models\Setting::get('mail_from_address')
                ?: config('mail.from.address');
            if ($adminEmail) {
                \Mail::to($adminEmail)->send(new \App\Mail\NewOrderNotification($order));
            }
        } catch (\Exception $e) {
            \Log::error('Failed to send new order admin notification: ' . $e->getMessage());
        }

        // Handle Free Orders (Price = 0)
        if ($finalPrice <= 0) {
            // Send confirmation email (Order model handles logic for free vs paid emails)
            try {
                $order->sendConfirmationEmail();
            } catch (\Exception $e) {
                \Log::error('Failed to send confirmation email: ' . $e->getMessage());
            }

            return redirect()->route('checkout.success', $order->order_number);
        }

        // If order was created already paid (edge case), process referral commission
        if ($order->payment_status === 'completed') {
            $order->processAffiliateCommissionIfPaid();
        }

        // Redirect based on payment method
        if ($validated['payment_method'] === 'stripe') {
            \Log::info('CheckoutController: Redirecting to Stripe for order: ' . $order->order_number);
            return redirect()->route('stripe.checkout', $order->order_number);
        }

        if ($validated['payment_method'] === 'crypto') {
            // Store selected currency in session for NOWPayments
            session(['crypto_currency' => $validated['crypto_currency']]);
            
            // Redirect to NOWPayments invoice creation
            return redirect()->route('nowpayments.invoice', $order->id);
        }

        // For other methods, show pending payment page
        return redirect()
            ->route('checkout.pending', $order->order_number)
            ->with('info', 'Please complete your payment to finalize the order.');
    }

    public function success(string $orderNumber): View
    {
        $order = Order::where('order_number', $orderNumber)->with('package')->firstOrFail();
        $package = $order->package;

        return view('checkout.success', compact('order', 'package'));
    }

    public function pending(string $orderNumber): View
    {
        $order = Order::where('order_number', $orderNumber)->with('package')->firstOrFail();

        return view('checkout.pending', compact('order'));
    }
}
