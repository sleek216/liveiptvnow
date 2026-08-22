@extends('layouts.app')
@section('title', $package->name . ' - ' . $package->duration_label . ' - Live IPTV Now')

@section('content')
<!-- Package Hero -->
<section class="pkd-hero">
    <div class="pkd-bg"><div class="pkd-grad"></div><div class="pkd-dots"></div></div>
    <div class="wrap">
        <div class="pkd-hero-in">
            <a href="{{ route('packages.index') }}" class="pkd-back" data-aos="fade-right"><i class="ri-arrow-left-line"></i> Back to All Plans</a>
            <div data-aos="fade-up">
                @if($package->is_featured)<span class="pkd-pop"><i class="ri-star-fill"></i> Most Popular</span>@endif
                <h1>{{ $package->name }}</h1>
                <p class="pkd-dur">{{ $package->duration_label }} Subscription</p>
                <div class="pkd-price-box">
                    @if($package->original_price)<del>${{ number_format($package->original_price, 2) }}</del>@endif
                    <strong>${{ number_format($package->price, 2) }}</strong>
                    @if($package->original_price)<span class="pkd-save">Save {{ round((($package->original_price - $package->price) / $package->original_price) * 100) }}%</span>@endif
                </div>
                <p class="pkd-desc">{{ $package->description }}</p>
            </div>
        </div>
    </div>
</section>

<section class="pkd-details">
    <div class="wrap">
        <div class="pkd-grid">
            <div class="pkd-left" data-aos="fade-right">
                <div class="pkd-card"><h3><i class="ri-checkbox-circle-fill"></i> What's Included</h3><ul class="pkd-feat">@foreach(json_decode($package->features_list ?? '[]') as $f)<li><i class="ri-checkbox-circle-fill"></i>{{ $f }}</li>@endforeach</ul></div>
                <div class="pkd-card"><h3><i class="ri-device-fill"></i> Compatible Devices</h3><div class="pkd-devices">@foreach([['ri-tv-2-line','Smart TV'],['ri-smartphone-line','Android'],['ri-apple-line','iOS'],['ri-computer-line','Windows'],['ri-fire-line','Firestick'],['ri-gamepad-line','MAG Box']] as $d)<div class="pkd-dev"><i class="{{ $d[0] }}"></i><span>{{ $d[1] }}</span></div>@endforeach</div></div>
                <div class="pkd-card"><h3><i class="ri-shield-check-fill"></i> Our Guarantee</h3><div class="pkd-guar">@foreach([['ri-refund-2-fill','24-Hour Money Back','Full refund within 24 hours'],['ri-flashlight-fill','Instant Activation','Start within minutes'],['ri-headphone-fill','24/7 Support','Always here to help']] as $g)<div class="pkd-g"><div class="pkd-gi"><i class="{{ $g[0] }}"></i></div><div><h4>{{ $g[1] }}</h4><p>{{ $g[2] }}</p></div></div>@endforeach</div></div>
            </div>
            <div class="pkd-right" data-aos="fade-left">
                <div class="pkd-order">
                    <h3>Order Summary</h3>
                    <div class="pkd-pkg"><div class="pkd-pkg-ic"><i class="ri-tv-2-fill"></i></div><div><h4>{{ $package->name }}</h4><span>{{ $package->duration_label }} • {{ $package->connections }} {{ $package->connections > 1 ? 'Connections' : 'Connection' }}</span></div></div>
                    <div class="pkd-rows"><div class="pkd-row"><span>Plan Price</span><span>${{ number_format($package->price, 2) }}</span></div><div class="pkd-row"><span>Connections</span><span>{{ $package->connections }}</span></div><div class="pkd-row"><span>Duration</span><span>{{ $package->duration_label }}</span></div>@if($package->original_price)<div class="pkd-row save"><span>You Save</span><span>-${{ number_format($package->original_price - $package->price, 2) }}</span></div>@endif</div>
                    <div class="pkd-total"><span>Total</span><span>${{ number_format($package->price, 2) }}</span></div>
                    <a href="{{ route('checkout.show', $package->slug) }}" class="hb hb-b" style="width:100%;justify-content:center;padding:14px;font-size:1rem;"><i class="ri-shopping-cart-line"></i> Proceed to Checkout</a>
                    <div class="pkd-secure"><i class="ri-lock-fill"></i> Secure checkout with SSL encryption</div>
                    <div class="pkd-methods"><span>PayPal</span><span>Stripe</span><span>Crypto</span></div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Related -->
<section style="padding:60px 0 120px;">
    <div class="wrap">
        <div class="sec-top" data-aos="fade-up"><h2 class="sec-h">Other Plans You Might <i>Like</i></h2></div>
        <div class="pkd-related">
            @foreach($relatedPackages ?? [] as $related)
            <div class="pkd-rel" data-aos="fade-up">
                <h4>{{ $related->name }}</h4><span class="pkd-rel-dur">{{ $related->duration_label }}</span>
                <div class="pkd-rel-price"><strong>${{ number_format($related->price, 2) }}</strong><span>{{ $related->connections }} {{ $related->connections > 1 ? 'Connections' : 'Connection' }}</span></div>
                <a href="{{ route('packages.show', $related->slug) }}" class="hb hb-g" style="width:100%;justify-content:center;">View Plan</a>
            </div>
            @endforeach
        </div>
    </div>
</section>

@push('styles')
<style>
.pkd-hero { position: relative; padding: 180px 0 80px; text-align: center; overflow: hidden; }
.pkd-bg { position: absolute; inset: 0; z-index: -1; }
.pkd-grad { position: absolute; inset: 0; background: linear-gradient(135deg, #eff6ff, #dbeafe); }
.pkd-dots { position: absolute; inset: 0; background-image: radial-gradient(rgba(37,99,235,0.06) 1px, transparent 1px); background-size: 40px 40px; opacity: 0.5; }
.pkd-hero-in { max-width: 600px; margin: 0 auto; color: var(--ink); }
.pkd-back { display: inline-flex; align-items: center; gap: 6px; color: var(--ink4); font-size: 0.88rem; margin-bottom: 24px; transition: var(--t); }
.pkd-back:hover { color: var(--blue); }
.pkd-pop { display: inline-flex; align-items: center; gap: 4px; padding: 6px 14px; background: linear-gradient(135deg,var(--blue),var(--violet)); border-radius: var(--rr); font-size: 0.78rem; font-weight: 800; color: #fff; margin-bottom: 12px; }
.pkd-hero h1 { font-size: clamp(2rem,4vw,3rem); font-weight: 900; margin-bottom: 6px; }
.pkd-dur { font-size: 1.05rem; color: var(--ink4); margin-bottom: 18px; }
.pkd-price-box { display: flex; align-items: center; justify-content: center; gap: 12px; margin-bottom: 18px; }
.pkd-price-box del { font-size: 1.3rem; color: var(--ink4); }
.pkd-price-box strong { font-size: 3rem; background: linear-gradient(90deg,#2563eb,#7c3aed); -webkit-background-clip: text; -webkit-text-fill-color: transparent; letter-spacing: -1px; }
.pkd-save { padding: 4px 10px; background: rgba(16,185,129,0.15); color: #10b981; border-radius: var(--rr); font-size: 0.82rem; font-weight: 800; }
.pkd-desc { color: var(--ink3); }

.pkd-details { padding: 60px 0; }
.pkd-grid { display: grid; grid-template-columns: 1fr 380px; gap: 28px; align-items: start; }
.pkd-left { display: flex; flex-direction: column; gap: 18px; }
.pkd-card { background: #fff; border: var(--bdr); border-radius: var(--r2); padding: 28px; box-shadow: var(--s-card); }
.pkd-card h3 { display: flex; align-items: center; gap: 8px; font-size: 1.15rem; margin-bottom: 18px; padding-bottom: 14px; border-bottom: 1px solid #e2e8f0; }
.pkd-card h3 i { color: var(--blue); font-size: 1.3rem; }
.pkd-feat { display: flex; flex-direction: column; gap: 10px; }
.pkd-feat li { display: flex; align-items: center; gap: 8px; font-size: 0.92rem; color: var(--ink3); }
.pkd-feat i { color: var(--emerald); font-size: 1.1rem; }
.pkd-devices { display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px; }
.pkd-dev { display: flex; flex-direction: column; align-items: center; gap: 6px; padding: 14px; background: #f8fafc; border-radius: var(--r); text-align: center; transition: var(--t); }
.pkd-dev:hover { background: var(--bluesoft); }
.pkd-dev i { font-size: 1.5rem; color: var(--blue); }
.pkd-dev span { font-size: 0.78rem; font-weight: 700; color: var(--ink3); }
.pkd-guar { display: flex; flex-direction: column; gap: 16px; }
.pkd-g { display: flex; gap: 12px; }
.pkd-gi { width: 44px; height: 44px; background: var(--bluesoft); border-radius: 12px; display: grid; place-items: center; flex-shrink: 0; }
.pkd-gi i { font-size: 1.2rem; color: var(--blue); }
.pkd-g h4 { font-size: 0.95rem; margin-bottom: 2px; }
.pkd-g p { font-size: 0.82rem; color: var(--ink4); }

.pkd-order { position: sticky; top: 100px; background: #fff; border: 2px solid #e2e8f0; border-radius: var(--r2); padding: 28px; box-shadow: var(--s-card); }
.pkd-order h3 { font-size: 1.2rem; margin-bottom: 18px; padding-bottom: 14px; border-bottom: 1px solid #e2e8f0; }
.pkd-pkg { display: flex; align-items: center; gap: 12px; padding: 14px; background: #f8fafc; border-radius: var(--r); margin-bottom: 18px; }
.pkd-pkg-ic { width: 44px; height: 44px; background: linear-gradient(135deg,var(--blue),var(--violet)); border-radius: 12px; display: grid; place-items: center; color: #fff; font-size: 1.2rem; }
.pkd-pkg h4 { font-size: 0.95rem; margin-bottom: 2px; }
.pkd-pkg span { font-size: 0.78rem; color: var(--ink4); }
.pkd-rows { margin-bottom: 14px; padding-bottom: 14px; border-bottom: 1px solid #e2e8f0; }
.pkd-row { display: flex; justify-content: space-between; padding: 6px 0; font-size: 0.88rem; color: var(--ink3); }
.pkd-row.save { color: var(--emerald); font-weight: 700; }
.pkd-total { display: flex; justify-content: space-between; font-size: 1.15rem; font-weight: 900; margin-bottom: 18px; }
.pkd-total span:last-child { color: var(--blue); }
.pkd-secure { display: flex; align-items: center; justify-content: center; gap: 6px; margin-top: 14px; font-size: 0.78rem; color: var(--ink4); }
.pkd-secure i { color: var(--emerald); }
.pkd-methods { display: flex; align-items: center; justify-content: center; gap: 14px; margin-top: 12px; padding-top: 12px; border-top: 1px solid #e2e8f0; }
.pkd-methods span { font-size: 0.72rem; font-weight: 700; color: var(--ink4); }

.sec-top { text-align: center; max-width: 540px; margin: 0 auto 40px; }
.sec-h { font-size: clamp(1.8rem,3vw,2.3rem); margin-bottom: 8px; }
.sec-h i { font-family: var(--display); font-style: italic; font-weight: 400; }
.pkd-related { display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 14px; max-width: 820px; margin: 0 auto; }
.pkd-rel { background: #fff; border: var(--bdr); border-radius: var(--r2); padding: 24px; text-align: center; transition: var(--t); }
.pkd-rel:hover { transform: translateY(-4px); box-shadow: var(--s-hover); }
.pkd-rel h4 { font-size: 1.15rem; margin-bottom: 2px; }
.pkd-rel-dur { font-size: 0.78rem; color: var(--ink4); display: block; margin-bottom: 14px; }
.pkd-rel-price { margin-bottom: 14px; }
.pkd-rel-price strong { font-size: 1.6rem; color: var(--blue); display: block; margin-bottom: 2px; }
.pkd-rel-price span { font-size: 0.78rem; color: var(--ink4); }
.hb-g { display: inline-flex; align-items: center; gap: 6px; padding: 10px 18px; background: transparent; color: var(--blue); border: 2px solid var(--blue); border-radius: var(--rr); font-weight: 800; font-size: 0.82rem; transition: var(--t); }
.hb-g:hover { background: var(--blue); color: #fff; }

@media(max-width:1024px) { .pkd-grid { grid-template-columns: 1fr; } .pkd-order { position: static; } }
@media(max-width:768px) { .pkd-hero { padding: 140px 0 60px; } .pkd-hero h1 { font-size: 2rem; } .pkd-price-box strong { font-size: 2.4rem; } .pkd-devices { grid-template-columns: repeat(2, 1fr); } }
</style>
@endpush
@endsection
