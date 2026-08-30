@extends('layouts.app')
@section('title', 'Payment Pending - Live IPTV Now')

@section('content')
<section class="cx-result">
    <div class="wrap">
        <div class="cx-card" data-aos="fade-up">
            <div class="cx-icon pending"><i class="ri-time-fill"></i></div>
            <h1>Payment <i>Pending</i></h1>
            <p>Your order has been created. Complete the payment to activate.</p>

            @if(session('error'))
            <div class="co-alert co-alert-err" style="margin-bottom: 20px; padding: 14px; background: #fee2e2; border: 1px solid #fca5a5; border-radius: 8px; color: #b91c1c; display: flex; align-items: center; gap: 8px; justify-content: center; font-size: 0.9rem;">
                <i class="ri-close-circle-fill" style="font-size: 1.1rem; color: #ef4444;"></i>
                <span style="font-weight: 500;">{{ session('error') }}</span>
            </div>
            @endif

            @if(session('info'))
            <div class="co-alert co-alert-info" style="margin-bottom: 20px; padding: 14px; background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 8px; color: #1e40af; display: flex; align-items: center; gap: 8px; justify-content: center; font-size: 0.9rem;">
                <i class="ri-information-fill" style="font-size: 1.1rem; color: #3b82f6;"></i>
                <span style="font-weight: 500;">{{ session('info') }}</span>
            </div>
            @endif

            <div class="cx-details">
                <div class="cx-row"><span>Order Number</span><strong>{{ $order->order_number }}</strong></div>
                <div class="cx-row"><span>Package</span><strong>{{ $order->package->name }}</strong></div>
                <div class="cx-row"><span>Amount</span><strong>${{ number_format($order->amount, 2) }}</strong></div>
                <div class="cx-row"><span>Payment</span><strong>{{ $order->payment_method === 'stripe' ? 'Stripe (Credit/Debit Card)' : ucfirst($order->payment_method) }}</strong></div>
            </div>

            @if($order->payment_method === 'stripe' && $order->payment_status !== 'completed')
            <div class="cx-inst" style="background: #f8fafc; border: 1px solid #e2e8f0; padding: 20px; border-radius: 12px; margin-bottom: 18px;">
                <h3 style="color: #475569; display: flex; align-items: center; justify-content: center; gap: 8px; margin-bottom: 8px; font-weight: 700;"><i class="ri-bank-card-fill" style="color: #635bff;"></i> Credit / Debit Card</h3>
                <p style="color: #64748b; font-size: 0.9rem; margin-bottom: 15px;">Please click the button below to complete your payment of <strong>${{ number_format($order->amount, 2) }}</strong> securely via Stripe.</p>
                <a href="{{ route('stripe.checkout', $order->order_number) }}" class="hb hb-b" style="display: inline-flex; align-items: center; gap: 8px; padding: 12px 24px; background: #635bff; color: #fff; border-radius: 99px; text-decoration: none; font-weight: 700; transition: background 0.2s;">
                    <i class="ri-lock-2-line"></i> Pay Now with Card
                </a>
            </div>
            @elseif($order->payment_method === 'paypal')
            <div class="cx-inst"><h3><i class="ri-paypal-fill"></i> PayPal</h3><p>Send <strong>${{ number_format($order->amount, 2) }}</strong> to our PayPal and include order <strong>{{ $order->order_number }}</strong>.</p><a href="https://paypal.me/LiveIPTVNow" target="_blank" class="hb hb-b"><i class="ri-external-link-line"></i> Pay with PayPal</a></div>
            @elseif($order->payment_method === 'crypto')
            <div class="cx-inst"><h3><i class="ri-bitcoin-fill"></i> Crypto</h3><p>Contact our support team for the wallet address.</p><a href="{{ route('contact') }}" class="hb hb-b"><i class="ri-chat-1-line"></i> Contact Support</a></div>
            @endif
            <div class="cx-note"><i class="ri-information-line"></i><span>Once confirmed, you'll receive credentials via email within 24 hours.</span></div>
            <div class="cx-actions"><a href="{{ route('profile') }}" class="hb hb-g"><i class="ri-user-line"></i> My Profile</a><a href="{{ route('contact') }}" class="hb hb-g">Need Help?</a></div>
        </div>
    </div>
</section>

@push('styles')
<style>
.cx-result { padding: 180px 0 120px; min-height: 100vh; }
.cx-card { max-width: 540px; margin: 0 auto; background: var(--white); border: var(--bdr); border-radius: var(--r3); padding: 48px; text-align: center; box-shadow: var(--s3); }
.cx-icon { width: 88px; height: 88px; margin: 0 auto 24px; border-radius: 50%; display: grid; place-items: center; font-size: 3rem; }
.cx-icon.pending { background: #fef3c7; color: #f59e0b; }
.cx-card h1 { font-size: 1.8rem; margin-bottom: 8px; }
.cx-card h1 i { font-family: var(--display); font-style: italic; font-weight: 400; }
.cx-card > p { color: var(--ink3); margin-bottom: 24px; }
.cx-details { background: var(--bg2); border-radius: var(--r); padding: 18px; margin-bottom: 24px; text-align: left; }
.cx-row { display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid rgba(0,0,0,0.04); font-size: 0.9rem; }
.cx-row:last-child { border: none; }
.cx-row span { color: var(--ink4); }
.cx-inst { background: var(--primary-soft); border: 1px solid var(--primary-glow); border-radius: var(--r); padding: 24px; margin-bottom: 18px; }
.cx-inst h3 { display: flex; align-items: center; justify-content: center; gap: 6px; font-size: 1.1rem; margin-bottom: 8px; color: var(--primary); }
.cx-inst p { color: var(--ink3); margin-bottom: 14px; line-height: 1.5; }
.cx-note { display: flex; align-items: flex-start; gap: 8px; padding: 12px; background: var(--bg2); border-radius: var(--r); text-align: left; margin-bottom: 18px; }
.cx-note i { color: var(--primary); font-size: 1.1rem; flex-shrink: 0; margin-top: 2px; }
.cx-note span { font-size: 0.82rem; color: var(--ink3); line-height: 1.4; }
.cx-actions { display: flex; gap: 10px; justify-content: center; }
.hb-g { display: inline-flex; align-items: center; gap: 6px; padding: 12px 24px; background: transparent; color: var(--primary); border: 2px solid var(--primary); border-radius: var(--rr); font-weight: 800; font-size: 0.88rem; transition: var(--t); }
.hb-g:hover { background: var(--primary); color: #fff; }
@media(max-width:768px) { .cx-result { padding: 140px 0 80px; } .cx-card { padding: 36px 24px; } .cx-card h1 { font-size: 1.5rem; } .cx-icon { width: 72px; height: 72px; font-size: 2.4rem; } .cx-inst { padding: 18px; } }
@media(max-width:640px) { .cx-card { padding: 28px 20px; } .cx-actions { flex-direction: column; } }
@media(max-width:480px) { .cx-result { padding: 120px 0 60px; } .cx-card h1 { font-size: 1.3rem; } .cx-icon { width: 64px; height: 64px; font-size: 2rem; } .cx-inst { padding: 16px; } .cx-details { padding: 14px; } }
</style>
@endpush
@endsection
