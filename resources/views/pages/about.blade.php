@extends('layouts.app')
@section('title', 'About Us — Live IPTV Now | Our Story')

@section('content')

@include('layouts.page-hero', [
    'heroImage'      => '/page_hero_bg.png',
    'breadcrumb'     => 'About Us',
    'badge'          => 'Our Story — Since 2019',
    'badgeIcon'      => 'ri-heart-fill',
    'title'          => 'The Streaming Platform',
    'accent'         => 'Built for Everyone',
    'subtitle'       => 'Delivering world-class entertainment to 100,000+ customers across 150+ countries since 2019 — with a team focused on reliability, speed, and quality.',
    'desc'           => 'We believe premium IPTV should be affordable, easy, and rock-solid. Our mission: put 40,000+ channels and 100K+ movies into every household around the world.',
    'highlights' => [
        ['icon' => 'ri-group-fill',        'text' => '100,000+ happy customers in 150+ countries',    'sub' => 'Growing every day since 2019'],
        ['icon' => 'ri-shield-check-fill', 'text' => '99.9% uptime with anti-freeze technology',       'sub' => 'Redundant servers across multiple regions'],
        ['icon' => 'ri-headphone-fill',    'text' => 'Multilingual 24/7 support team available',       'sub' => 'English, Arabic, French, Spanish & more'],
    ],
    'ctaPrimary'     => 'View Our Plans',
    'ctaPrimaryUrl'  => route('packages.index'),
    'ctaPrimaryIcon' => 'ri-play-fill',
    'ctaGhost'       => 'Contact Us',
    'ctaGhostUrl'    => route('contact'),
    'ctaGhostIcon'   => 'ri-mail-line',
    'stats' => [
        ['icon' => 'ri-group-fill',        'text' => '100K+ Customers'],
        ['icon' => 'ri-global-fill',       'text' => '150+ Countries'],
        ['icon' => 'ri-calendar-fill',     'text' => 'Since 2019'],
        ['icon' => 'ri-shield-check-fill', 'text' => '99.9% Uptime'],
    ],
])

{{-- Stats Bar --}}
<div class="ab-stats-bar">
    <div class="wrap">
        <div class="ab-stats-grid" data-aos="fade-up">
            <div class="ab-stat"><strong>40K+</strong><span>Live Channels</span></div>
            <div class="ab-stat-sep"></div>
            <div class="ab-stat"><strong>100K+</strong><span>VOD Library</span></div>
            <div class="ab-stat-sep"></div>
            <div class="ab-stat"><strong>150+</strong><span>Countries</span></div>
            <div class="ab-stat-sep"></div>
            <div class="ab-stat"><strong>99.9%</strong><span>Uptime</span></div>
            <div class="ab-stat-sep"></div>
            <div class="ab-stat"><strong>100K+</strong><span>Happy Customers</span></div>
        </div>
    </div>
</div>

{{-- Who We Are --}}
<section class="ab-sec">
    <div class="wrap">
        <div class="ab-split" data-aos="fade-up">
            <div class="ab-split-txt">
                <div class="ab-label">Who We Are</div>
                <h2>Pioneering the Next Era of <em>Entertainment</em></h2>
                <p>Live IPTV Now is a leading provider of premium IPTV services, dedicated to delivering the ultimate streaming experience to households around the world.</p>
                <p>Founded with a simple mission — to make world-class entertainment accessible and affordable — our team works around the clock to ensure you always have access to the best live TV, movies, and series.</p>
                <ul class="ab-list">
                    <li><i class="ri-check-fill"></i> Crystal-clear HD & 4K quality</li>
                    <li><i class="ri-check-fill"></i> 24/7 multilingual support</li>
                    <li><i class="ri-check-fill"></i> Transparent, no-contract pricing</li>
                    <li><i class="ri-check-fill"></i> Anti-freeze reliability technology</li>
                </ul>
            </div>
            <div class="ab-split-vis">
                <div class="ab-vis-card">
                    <div class="ab-vc-row">
                        <div class="ab-vc-item"><i class="ri-tv-2-fill"></i><span>Smart TV</span></div>
                        <div class="ab-vc-item"><i class="ri-smartphone-fill"></i><span>Mobile</span></div>
                        <div class="ab-vc-item"><i class="ri-fire-fill"></i><span>FireStick</span></div>
                        <div class="ab-vc-item"><i class="ri-computer-fill"></i><span>PC / Mac</span></div>
                    </div>
                    <div class="ab-vc-badge">Works on All Devices</div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Mission --}}
<section class="ab-mission-sec">
    <div class="wrap">
        <div class="ab-split rev" data-aos="fade-up">
            <div class="ab-split-txt">
                <div class="ab-label">Our Mission</div>
                <h2>Driven to Deliver <em>Excellence</em></h2>
                <p>We believe premium entertainment should not be expensive or complicated. Every product decision we make is guided by three core principles.</p>
                <div class="ab-pillars">
                    <div class="ab-pillar"><div class="ab-pillar-ic"><i class="ri-heart-fill"></i></div><div><strong>Customer First</strong><span>Your experience is at the center of everything we build.</span></div></div>
                    <div class="ab-pillar"><div class="ab-pillar-ic"><i class="ri-shield-check-fill"></i></div><div><strong>Reliability</strong><span>99.9% uptime guaranteed with anti-freeze technology.</span></div></div>
                    <div class="ab-pillar"><div class="ab-pillar-ic"><i class="ri-price-tag-3-fill"></i></div><div><strong>Fair Pricing</strong><span>Premium service at a fraction of the cost of cable TV.</span></div></div>
                </div>
            </div>
            <div class="ab-split-vis">
                <div class="ab-orb-wrap">
                    <div class="ab-orb"><i class="ri-focus-2-fill"></i></div>
                    <div class="ab-orb-ring"></div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Core Values --}}
<section class="ab-values-sec">
    <div class="wrap">
        <div class="ab-values-head" data-aos="fade-up">
            <h2>Why Customers <em>Choose Us</em></h2>
        </div>
        <div class="ab-values-grid" data-aos="fade-up">
            <div class="ab-val"><div class="ab-val-ic"><i class="ri-shield-check-fill"></i></div><h3>Reliable</h3><p>99.9% uptime with redundant servers worldwide.</p></div>
            <div class="ab-val"><div class="ab-val-ic" style="background:rgba(16,185,129,0.1);color:#10b981;border-color:rgba(16,185,129,0.2);"><i class="ri-flashlight-fill"></i></div><h3>Fast Setup</h3><p>Instant activation within 5 minutes of payment.</p></div>
            <div class="ab-val"><div class="ab-val-ic" style="background:rgba(139,92,246,0.1);color:#8b5cf6;border-color:rgba(139,92,246,0.2);"><i class="ri-headphone-fill"></i></div><h3>24/7 Support</h3><p>Expert team available around the clock, every day.</p></div>
            <div class="ab-val"><div class="ab-val-ic" style="background:rgba(245,158,11,0.1);color:#f59e0b;border-color:rgba(245,158,11,0.2);"><i class="ri-device-fill"></i></div><h3>All Devices</h3><p>Smart TVs, phones, tablets, PCs and streaming boxes.</p></div>
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="cta-banner">
    <div class="wrap cta-inner">
        <h2>Ready to <em style="font-style:normal;color:rgba(255,255,255,0.85);">Get Started?</em></h2>
        <p>Join thousands of happy customers. No contracts, no setup fees.</p>
        <div class="cta-btns">
            <a href="{{ route('packages.index') }}" class="btn btn-white btn-lg"><i class="ri-play-fill"></i> View Plans</a>
            <a href="{{ route('contact') }}" class="btn btn-lg" style="background:rgba(255,255,255,0.12);color:#fff;border:2px solid rgba(255,255,255,0.3);">Contact Us</a>
        </div>
    </div>
</section>

@endsection

@push('styles')
<style>
/* Stats Bar */
.ab-stats-bar { background: var(--dark); padding: 22px 0; }
.ab-stats-grid { display: flex; align-items: center; justify-content: center; gap: 0; flex-wrap: wrap; }
.ab-stat { text-align: center; padding: 8px 36px; }
.ab-stat strong { display: block; font-size: 1.8rem; font-weight: 900; color: var(--primary); letter-spacing: -1px; }
.ab-stat span { font-size: 0.75rem; color: rgba(255,255,255,0.5); text-transform: uppercase; letter-spacing: 1.5px; font-weight: 600; }
.ab-stat-sep { width: 1px; height: 40px; background: rgba(255,255,255,0.1); }

/* Sections */
.ab-sec { padding: 80px 0; }
.ab-mission-sec { background: var(--bg2); border-top: var(--bdr); border-bottom: var(--bdr); padding: 80px 0; }
.ab-values-sec { padding: 80px 0; }

/* Split layout */
.ab-split { display: grid; grid-template-columns: 1fr 1fr; gap: 64px; align-items: center; }
.ab-split.rev { direction: rtl; }
.ab-split.rev > * { direction: ltr; }

.ab-label {
    display: inline-block;
    font-size: 0.72rem; font-weight: 900;
    text-transform: uppercase; letter-spacing: 2.5px;
    color: var(--primary);
    background: var(--primary-soft);
    border: 1px solid var(--primary-glow);
    padding: 5px 14px; border-radius: var(--rr);
    margin-bottom: 18px;
}
.ab-split-txt h2 { font-size: clamp(1.8rem, 3vw, 2.4rem); margin-bottom: 16px; color: var(--ink); line-height: 1.2; }
.ab-split-txt h2 em { font-style: normal; color: var(--primary); }
.ab-split-txt p { color: var(--ink4); line-height: 1.75; margin-bottom: 14px; font-size: 0.97rem; }

.ab-list { display: flex; flex-direction: column; gap: 10px; margin-top: 20px; }
.ab-list li { display: flex; align-items: center; gap: 10px; font-size: 0.92rem; font-weight: 600; color: var(--ink3); }
.ab-list i { color: var(--success); font-size: 1rem; width: 22px; height: 22px; background: rgba(16,185,129,0.1); border-radius: 50%; display: grid; place-items: center; font-size: 0.85rem; flex-shrink: 0; }

/* Vis Card */
.ab-vis-card {
    background: #fff;
    border: var(--bdr);
    border-radius: 20px;
    padding: 36px;
    box-shadow: var(--s3);
}
.ab-vc-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 20px; }
.ab-vc-item {
    display: flex; flex-direction: column; align-items: center;
    gap: 10px; padding: 24px 16px;
    background: var(--bg2); border: var(--bdr);
    border-radius: 14px; transition: var(--t);
    font-size: 2rem; color: var(--ink4);
}
.ab-vc-item:hover { border-color: var(--primary); color: var(--primary); background: var(--primary-soft); transform: translateY(-3px); }
.ab-vc-item span { font-size: 0.8rem; font-weight: 700; color: var(--ink3); }
.ab-vc-badge {
    text-align: center; padding: 12px;
    background: var(--primary-soft);
    border: 1px solid var(--primary-glow);
    border-radius: 10px;
    font-size: 0.82rem; font-weight: 800; color: var(--primary);
}

/* Orb */
.ab-orb-wrap { display: flex; justify-content: center; align-items: center; position: relative; height: 320px; }
.ab-orb {
    width: 200px; height: 200px; border-radius: 50%;
    background: var(--primary-soft);
    border: 2px dashed var(--primary-glow);
    display: grid; place-items: center;
    font-size: 4rem; color: var(--primary);
    animation: float 5s ease-in-out infinite;
    position: relative; z-index: 2;
}
.ab-orb-ring {
    position: absolute;
    width: 280px; height: 280px; border-radius: 50%;
    border: 1px solid var(--primary-glow);
    animation: float 7s ease-in-out infinite reverse;
}

/* Pillars */
.ab-pillars { display: flex; flex-direction: column; gap: 16px; margin-top: 28px; }
.ab-pillar { display: flex; align-items: flex-start; gap: 14px; }
.ab-pillar-ic {
    width: 42px; height: 42px; flex-shrink: 0;
    border-radius: 10px; background: var(--primary-soft);
    border: 1px solid var(--primary-glow);
    display: grid; place-items: center;
    font-size: 1.1rem; color: var(--primary);
}
.ab-pillar strong { display: block; font-size: 0.92rem; font-weight: 800; color: var(--ink); margin-bottom: 3px; }
.ab-pillar span { font-size: 0.84rem; color: var(--ink4); }

/* Values */
.ab-values-head { text-align: center; margin-bottom: 40px; }
.ab-values-head h2 { font-size: clamp(1.8rem, 3vw, 2.4rem); color: var(--ink); }
.ab-values-head h2 em { font-style: normal; color: var(--primary); }
.ab-values-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; }
.ab-val {
    text-align: center; padding: 36px 24px;
    background: #fff; border: 1.5px solid #e5e7eb;
    border-radius: 18px; transition: var(--ts);
    box-shadow: var(--s1);
}
.ab-val:hover { transform: translateY(-6px); box-shadow: var(--s4); border-color: var(--primary-glow); }
.ab-val-ic {
    width: 56px; height: 56px; border-radius: 14px;
    background: var(--primary-soft); border: 1px solid var(--primary-glow);
    display: grid; place-items: center; font-size: 1.4rem;
    color: var(--primary); margin: 0 auto 18px;
    transition: var(--t);
}
.ab-val:hover .ab-val-ic { background: var(--primary); color: #fff; border-color: var(--primary); }
.ab-val h3 { font-size: 1.05rem; color: var(--ink); margin-bottom: 8px; }
.ab-val p { font-size: 0.85rem; color: var(--ink4); line-height: 1.6; }

@keyframes float { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-14px)} }

@media(max-width:1024px) {
    .ab-split { grid-template-columns: 1fr; gap: 40px; }
    .ab-split.rev { direction: ltr; }
    .ab-values-grid { grid-template-columns: repeat(2,1fr); }
    .ab-stats-grid { gap: 0; }
    .ab-stat { padding: 8px 20px; }
}
@media(max-width:640px) {
    .ab-stats-bar { overflow-x: auto; }
    .ab-stats-grid { flex-wrap: nowrap; }
    .ab-stat-sep { flex-shrink: 0; }
    .ab-values-grid { grid-template-columns: 1fr 1fr; }
}
</style>
@endpush
