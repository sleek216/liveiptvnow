@extends('layouts.app')
@section('title', 'Payment Cancelled')

@section('content')
<section class="cx-result">
    <div class="wrap">
        <div class="cx-card" data-aos="fade-up">
            <div class="cx-icon err"><i class="ri-close-circle-fill"></i></div>
            <h1>Payment <i>Cancelled</i></h1>
            <p>No charges have been made to your account.</p>
            @if($order->package)
            <div class="cx-details"><div class="cx-row"><span>Package</span><strong>{{ $order->package->name }}</strong></div><div class="cx-row"><span>Amount</span><strong>${{ number_format($order->amount, 2) }}</strong></div></div>
            @endif
            <div class="cx-actions"><a href="{{ route('checkout.show', $order->package->slug ?? '') }}" class="hb hb-b"><i class="ri-refund-2-line"></i> Try Again</a><a href="{{ route('packages.index') }}" class="hb hb-g">Other Plans</a></div>
        </div>
    </div>
</section>

@push('styles')
<style>
.cx-result { padding: 180px 0 120px; min-height: 100vh; }
.cx-card { max-width: 540px; margin: 0 auto; background: var(--white); border: var(--bdr); border-radius: var(--r3); padding: 48px; text-align: center; box-shadow: var(--s3); }
.cx-icon { width: 88px; height: 88px; margin: 0 auto 24px; border-radius: 50%; display: grid; place-items: center; font-size: 3rem; }
.cx-icon.err { background: #fef2f2; color: #ef4444; }
.cx-card h1 { font-size: 1.8rem; margin-bottom: 8px; }
.cx-card h1 i { font-family: var(--display); font-style: italic; font-weight: 400; }
.cx-card > p { color: var(--ink3); margin-bottom: 24px; }
.cx-details { background: var(--bg2); border-radius: var(--r); padding: 18px; margin-bottom: 24px; }
.cx-row { display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid rgba(0,0,0,0.04); }
.cx-row:last-child { border: none; }
.cx-row span { color: var(--ink4); font-size: 0.88rem; }
.cx-row strong { font-size: 0.92rem; }
.cx-actions { display: flex; gap: 10px; justify-content: center; }
.hb-g { display: inline-flex; align-items: center; gap: 6px; padding: 12px 24px; background: transparent; color: var(--blue); border: 2px solid var(--blue); border-radius: var(--rr); font-weight: 800; font-size: 0.88rem; transition: var(--t); }
.hb-g:hover { background: var(--blue); color: #fff; }
@media(max-width:768px) { .cx-result { padding: 140px 0 80px; } .cx-card { padding: 36px 24px; } .cx-card h1 { font-size: 1.5rem; } .cx-icon { width: 72px; height: 72px; font-size: 2.4rem; } }
@media(max-width:640px) { .cx-card { padding: 28px 20px; } .cx-actions { flex-direction: column; } }
@media(max-width:480px) { .cx-result { padding: 120px 0 60px; } .cx-card h1 { font-size: 1.3rem; } .cx-icon { width: 64px; height: 64px; font-size: 2rem; } .cx-details { padding: 14px; } }
</style>
@endpush
@endsection
