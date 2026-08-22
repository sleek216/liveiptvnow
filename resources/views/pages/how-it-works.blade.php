@extends('layouts.app')
@section('title', 'How It Works — Get Started in Minutes | Live IPTV Now')

@section('content')

@include('layouts.page-hero', [
    'heroImage'      => '/page_hero_bg.png',
    'breadcrumb'     => 'How It Works',
    'badge'          => 'Setup Guide — 3 Minutes to Stream',
    'badgeIcon'      => 'ri-settings-3-fill',
    'title'          => 'Get Started in',
    'accent'         => 'Under 3 Minutes',
    'subtitle'       => 'From sign-up to streaming in just a few simple steps. No technical skills required — we guide you every step of the way until you are watching live TV.',
    'desc'           => 'Choose a plan, pay securely, receive your credentials, and start streaming. It really is that simple. Our team is available 24/7 to help if you get stuck.',
    'highlights' => [
        ['icon' => 'ri-box-3-fill',        'text' => 'Pick any plan that suits your needs & budget',  'sub' => 'Monthly, 3M, 6M, 12M, Lifetime options'],
        ['icon' => 'ri-flashlight-fill',   'text' => 'Credentials delivered within 5 minutes',         'sub' => 'M3U & Xtream codes straight to your email'],
        ['icon' => 'ri-device-fill',       'text' => 'Works on 50+ apps across all your devices',      'sub' => 'IPTV Smarters, TiviMate, VLC, Smart IPTV & more'],
    ],
    'ctaPrimary'     => 'Get Started Now',
    'ctaPrimaryUrl'  => route('packages.index'),
    'ctaPrimaryIcon' => 'ri-play-fill',
    'ctaGhost'       => 'Free Trial',
    'ctaGhostUrl'    => route('contact'),
    'ctaGhostIcon'   => 'ri-gift-line',
    'stats' => [
        ['icon' => 'ri-timer-fill',        'text' => 'Setup in < 3 Min'],
        ['icon' => 'ri-device-fill',       'text' => '50+ Compatible Apps'],
        ['icon' => 'ri-flashlight-fill',   'text' => 'Instant Delivery'],
        ['icon' => 'ri-headphone-fill',    'text' => '24/7 Setup Help'],
    ],
])

{{-- Steps Timeline --}}
<section class="hiw-sec">
    <div class="wrap">
        <div class="hiw-steps">
            @foreach([
                ['01', 'ri-box-3-fill',       'var(--primary)',  'Choose Your Plan',    'Browse our subscription tiers and select the plan that best fits your entertainment needs and budget.',          ['1–5 concurrent connections', 'Flexible duration options', '24-hour free trial available'], route('packages.index'), 'View Plans'],
                ['02', 'ri-shield-check-fill', '#10b981',        'Secure Checkout',     'Complete your order through our encrypted payment gateway. We accept cards, PayPal, and cryptocurrency.',      ['256-bit SSL encryption', 'Multiple payment methods', 'Instant payment validation'], null, null],
                ['03', 'ri-flashlight-fill',   '#8b5cf6',        'Instant Delivery',    'Your M3U playlist and login credentials are sent to your email inbox within 5 minutes — 24/7, no waiting.',    ['Real-time email dispatch', 'Xtream & M3U formats', 'Works immediately'], null, null],
                ['04', 'ri-device-fill',        '#f59e0b',        'Setup Your Device',   'Follow our easy guides to connect your IPTV player. Works with IPTV Smarters, TiviMate, VLC, and 50+ more apps.', ['Step-by-step video guides', 'Expert live setup help', 'Works on all platforms'], null, null],
            ] as [$num, $icon, $color, $title, $desc, $checks, $link, $linkLabel])
            <div class="hiw-step" data-aos="fade-up">
                <div class="hiw-step-num" style="background:{{ $color }}20;color:{{ $color }};border-color:{{ $color }}30;">{{ $num }}</div>
                <div class="hiw-line"></div>
                <div class="hiw-card">
                    <div class="hiw-ic" style="background:{{ $color }}18;color:{{ $color }};border-color:{{ $color }}30;">
                        <i class="{{ $icon }}"></i>
                    </div>
                    <h3>{{ $title }}</h3>
                    <p>{{ $desc }}</p>
                    <ul class="hiw-checks">
                        @foreach($checks as $c)
                        <li><i class="ri-check-fill"></i> {{ $c }}</li>
                        @endforeach
                    </ul>
                    @if($link)
                    <a href="{{ $link }}" class="btn btn-primary btn-sm" style="margin-top:20px;display:inline-flex;">
                        {{ $linkLabel }} <i class="ri-arrow-right-line"></i>
                    </a>
                    @endif
                </div>
            </div>
            @endforeach

            {{-- Final Step --}}
            <div class="hiw-step hiw-final" data-aos="fade-up">
                <div class="hiw-step-num" style="background:var(--primary);color:#fff;border-color:var(--primary);">05</div>
                <div class="hiw-card hiw-card-primary">
                    <div class="hiw-final-icon">🍿</div>
                    <h3>Start Streaming!</h3>
                    <p>Enjoy 40,000+ channels and 100,000+ VOD content in stunning 4K HDR quality — anywhere, anytime.</p>
                    <a href="{{ route('channels') }}" class="btn btn-white btn-sm" style="margin-top:20px;display:inline-flex;">
                        Browse Channels <i class="ri-arrow-right-line"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Compatible Devices --}}
<section class="hiw-devices-sec">
    <div class="wrap">
        <div class="hiw-sec-head" data-aos="fade-up">
            <h2>Works on <em>Every Device</em></h2>
            <p>One subscription, unlimited devices. Access your entertainment on any screen you own.</p>
        </div>
        <div class="hiw-devices" data-aos="fade-up">
            @foreach([
                ['ri-tv-2-fill',        'Smart TV',   'Samsung, LG, Sony & more'],
                ['ri-smartphone-fill',  'Mobile',     'iOS & Android phones'],
                ['ri-tablet-fill',      'Tablet',     'iPad & Android tablets'],
                ['ri-fire-fill',        'Fire TV',    'FireStick & Fire TV Cube'],
                ['ri-computer-fill',    'PC / Mac',   'Windows & macOS browsers'],
                ['ri-gamepad-fill',     'Gaming',     'Xbox, PlayStation & more'],
                ['ri-router-fill',      'MAG Box',    'All MAG devices supported'],
                ['ri-tv-fill',          'Android TV', 'NVIDIA Shield & Mi Box'],
            ] as [$icon, $name, $sub])
            <div class="hiw-device" data-aos="zoom-in">
                <i class="{{ $icon }}"></i>
                <strong>{{ $name }}</strong>
                <span>{{ $sub }}</span>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Speed Requirements --}}
<section class="hiw-speed-sec">
    <div class="wrap">
        <div class="hiw-sec-head" data-aos="fade-up">
            <h2>Internet Speed <em>Requirements</em></h2>
            <p>Our streams adapt to your connection. Here are the recommended speeds for each quality level.</p>
        </div>
        <div class="hiw-speed-grid" data-aos="fade-up">
            <div class="hiw-sp"><div class="hiw-sp-bar" style="--pct:25%;--clr:#10b981;"></div><strong>5 Mbps</strong><span>SD Quality</span><p>Standard definition streaming on any connection.</p></div>
            <div class="hiw-sp"><div class="hiw-sp-bar" style="--pct:50%;--clr:#3b82f6;"></div><strong>10 Mbps</strong><span>HD Quality</span><p>720p/1080p high-definition picture.</p></div>
            <div class="hiw-sp"><div class="hiw-sp-bar" style="--pct:75%;--clr:#8b5cf6;"></div><strong>15 Mbps</strong><span>FHD Quality</span><p>1080p Full HD — cinema-quality detail.</p></div>
            <div class="hiw-sp"><div class="hiw-sp-bar" style="--pct:100%;--clr:var(--primary);"></div><strong>25 Mbps</strong><span>4K / UHD</span><p>Ultra HD 4K with HDR for the ultimate experience.</p></div>
        </div>
    </div>
</section>

{{-- Quick FAQ --}}
<section class="hiw-faq-sec">
    <div class="wrap">
        <div class="hiw-faq-inner" data-aos="fade-up">
            <div class="hiw-faq-left">
                <h2>Common <em>Questions</em></h2>
                <p>Everything you need to know before getting started.</p>
                <a href="{{ route('faq') }}" class="btn btn-primary" style="margin-top:20px;">
                    Full FAQ <i class="ri-arrow-right-line"></i>
                </a>
            </div>
            <div class="hiw-faq-right">
                <div class="hiw-qb"><i class="ri-flashlight-fill"></i><div><strong>How fast is delivery?</strong><p>Instant — credentials land in your inbox within 5 minutes of payment, 24/7.</p></div></div>
                <div class="hiw-qb"><i class="ri-wifi-fill"></i><div><strong>What internet speed do I need?</strong><p>Minimum 5 Mbps for SD. We recommend 25 Mbps for 4K Ultra HD.</p></div></div>
                <div class="hiw-qb"><i class="ri-headphone-fill"></i><div><strong>Is setup support included?</strong><p>Yes! Our team provides 24/7 live setup help for all devices at no extra cost.</p></div></div>
            </div>
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="cta-banner">
    <div class="wrap cta-inner">
        <h2>Ready to <em style="font-style:normal;color:rgba(255,255,255,0.85);">Start Watching?</em></h2>
        <p>Join 100,000+ happy customers streaming today.</p>
        <div class="cta-btns">
            <a href="{{ route('packages.index') }}" class="btn btn-white btn-lg"><i class="ri-play-fill"></i> Get Started</a>
            <a href="{{ route('contact') }}" class="btn btn-lg" style="background:rgba(255,255,255,0.12);color:#fff;border:2px solid rgba(255,255,255,0.3);">Free Trial</a>
        </div>
    </div>
</section>

@endsection

@push('styles')
<style>
/* Steps */
.hiw-sec { padding: 72px 0; }
.hiw-steps { max-width: 720px; margin: 0 auto; display: flex; flex-direction: column; gap: 0; }

.hiw-step { display: flex; gap: 0; align-items: flex-start; }
.hiw-step-num {
    width: 48px; height: 48px; border-radius: 50%;
    border: 2px solid; flex-shrink: 0;
    display: grid; place-items: center;
    font-size: 0.82rem; font-weight: 900;
    position: relative; z-index: 2;
    background: #fff;
}
.hiw-line {
    width: 2px; flex-shrink: 0;
    background: var(--bg3); margin-left: -25px;
    min-height: 100%; align-self: stretch;
}
.hiw-card {
    flex: 1; margin-left: 24px; margin-bottom: 32px;
    background: #fff; border: 1.5px solid #e5e7eb;
    border-radius: 18px; padding: 30px 28px;
    box-shadow: var(--s1); transition: var(--ts);
}
.hiw-card:hover { box-shadow: var(--s3); border-color: var(--primary-glow); transform: translateX(4px); }

.hiw-ic {
    width: 50px; height: 50px; border-radius: 13px;
    border: 1px solid; display: grid; place-items: center;
    font-size: 1.3rem; margin-bottom: 16px;
}
.hiw-card h3 { font-size: 1.15rem; color: var(--ink); margin-bottom: 8px; }
.hiw-card p { color: var(--ink4); font-size: 0.9rem; line-height: 1.65; margin-bottom: 14px; }
.hiw-checks { display: flex; flex-direction: column; gap: 8px; }
.hiw-checks li { display: flex; align-items: center; gap: 8px; font-size: 0.85rem; color: var(--ink3); font-weight: 600; }
.hiw-checks i { color: var(--success); font-size: 0.95rem; width: 18px; height: 18px; background: rgba(16,185,129,0.1); border-radius: 50%; display: grid; place-items: center; font-size: 0.75rem; flex-shrink: 0; }

.hiw-card-primary {
    background: var(--primary);
    border-color: var(--primary);
    color: #fff;
}
.hiw-card-primary h3, .hiw-card-primary p { color: rgba(255,255,255,0.95); }
.hiw-card-primary p { color: rgba(255,255,255,0.7); }
.hiw-final-icon { font-size: 2.4rem; margin-bottom: 12px; }
.hiw-final .hiw-line { background: var(--primary); opacity: 0.3; }

/* Devices */
.hiw-devices-sec { background: var(--bg2); border-top: var(--bdr); border-bottom: var(--bdr); padding: 72px 0; }
.hiw-sec-head { text-align: center; max-width: 560px; margin: 0 auto 40px; }
.hiw-sec-head h2 { font-size: clamp(1.7rem,3vw,2.3rem); color: var(--ink); margin-bottom: 10px; }
.hiw-sec-head em { font-style: normal; color: var(--primary); }
.hiw-sec-head p { color: var(--ink4); }

.hiw-devices { display: grid; grid-template-columns: repeat(8,1fr); gap: 14px; }
.hiw-device {
    display: flex; flex-direction: column; align-items: center; gap: 8px;
    padding: 24px 12px; background: #fff;
    border: var(--bdr); border-radius: 14px;
    text-align: center; transition: var(--ts);
    font-size: 2rem; color: var(--ink4);
}
.hiw-device:hover { transform: translateY(-5px); box-shadow: var(--s3); border-color: var(--primary-glow); color: var(--primary); }
.hiw-device strong { font-size: 0.82rem; color: var(--ink2); font-weight: 800; }
.hiw-device span { font-size: 0.7rem; color: var(--ink5); }

/* Speed */
.hiw-speed-sec { padding: 72px 0; }
.hiw-speed-grid { display: grid; grid-template-columns: repeat(4,1fr); gap: 20px; }
.hiw-sp { background: #fff; border: var(--bdr); border-radius: 16px; padding: 28px 24px; box-shadow: var(--s1); transition: var(--ts); }
.hiw-sp:hover { transform: translateY(-5px); box-shadow: var(--s3); }
.hiw-sp-bar { height: 6px; background: #e5e7eb; border-radius: 6px; margin-bottom: 20px; overflow: hidden; position: relative; }
.hiw-sp-bar::after { content:''; position:absolute; inset:0; width:var(--pct); background:var(--clr); border-radius:6px; }
.hiw-sp strong { display: block; font-size: 1.8rem; font-weight: 900; color: var(--ink); letter-spacing: -1px; }
.hiw-sp span { font-size: 0.75rem; text-transform: uppercase; font-weight: 800; color: var(--ink5); letter-spacing: 1px; display: block; margin-bottom: 10px; }
.hiw-sp p { font-size: 0.84rem; color: var(--ink4); line-height: 1.55; }

/* FAQ quick */
.hiw-faq-sec { background: var(--bg2); border-top: var(--bdr); padding: 72px 0; }
.hiw-faq-inner { display: grid; grid-template-columns: 1fr 1.5fr; gap: 56px; align-items: center; }
.hiw-faq-left h2 { font-size: clamp(1.7rem,3vw,2.3rem); color: var(--ink); margin-bottom: 12px; }
.hiw-faq-left h2 em { font-style: normal; color: var(--primary); }
.hiw-faq-left p { color: var(--ink4); line-height: 1.7; }
.hiw-faq-right { display: flex; flex-direction: column; gap: 14px; }
.hiw-qb {
    display: flex; gap: 16px; align-items: flex-start;
    background: #fff; border: var(--bdr);
    border-radius: 14px; padding: 20px 22px;
    border-left: 3px solid var(--primary);
}
.hiw-qb > i { font-size: 1.2rem; color: var(--primary); margin-top: 2px; flex-shrink: 0; }
.hiw-qb strong { display: block; font-size: 0.92rem; color: var(--ink); margin-bottom: 4px; }
.hiw-qb p { font-size: 0.84rem; color: var(--ink4); line-height: 1.55; margin: 0; }

@media(max-width:1024px) {
    .hiw-devices { grid-template-columns: repeat(4,1fr); }
    .hiw-speed-grid { grid-template-columns: repeat(2,1fr); }
    .hiw-faq-inner { grid-template-columns: 1fr; }
}
@media(max-width:640px) {
    .hiw-devices { grid-template-columns: repeat(2,1fr); }
    .hiw-step { flex-direction: column; }
    .hiw-card { margin-left: 0; }
    .hiw-line { display: none; }
}
</style>
@endpush
