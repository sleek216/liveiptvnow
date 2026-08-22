@extends('layouts.app')
@section('title', 'Affiliate Program — Earn 20% Commission | Live IPTV Now')

@section('content')
@include('layouts.page-hero', [
    'heroImage'      => '/page_hero_bg.png',
    'breadcrumb'     => 'Affiliate Program',
    'badge'          => 'Partner Program — Earn 20% Commission',
    'badgeIcon'      => 'ri-percent-fill',
    'title'          => 'Earn Money with',
    'accent'         => 'Live IPTV Now',
    'subtitle'       => 'Join our affiliate program and earn 20% recurring commission on every customer you refer. No earning caps, no expiry, no limits.',
    'desc'           => 'Over 5,000 active partners are already earning with us. Share your unique link on social media, YouTube, blogs, or WhatsApp and watch the commissions roll in.',
    'highlights' => [
        ['icon' => 'ri-percent-fill',      'text' => '20% recurring commission on every referral',    'sub' => 'One of the highest rates in the IPTV industry'],
        ['icon' => 'ri-wallet-fill',       'text' => 'Flexible payouts: Bitcoin, PayPal, bank transfer','sub' => 'Minimum $50 — paid within 24 hours of request'],
        ['icon' => 'ri-window-fill',       'text' => 'Real-time dashboard: clicks, sales & earnings',  'sub' => 'Full transparency, live analytics always available'],
    ],
    'ctaPrimary'     => auth()->check() ? 'Affiliate Center' : 'Join for Free',
    'ctaPrimaryUrl'  => auth()->check() ? route('profile') . '#affiliate' : route('register'),
    'ctaPrimaryIcon' => auth()->check() ? 'ri-dashboard-fill' : 'ri-user-add-fill',
    'ctaGhost'       => 'Learn More',
    'ctaGhostUrl'    => route('contact'),
    'ctaGhostIcon'   => 'ri-information-line',
    'stats' => [
        ['icon' => 'ri-percent-fill',      'text' => '20% Commission'],
        ['icon' => 'ri-group-fill',        'text' => '5,000+ Partners'],
        ['icon' => 'ri-hourglass-fill',    'text' => '30-Day Cookie'],
        ['icon' => 'ri-money-dollar-circle-fill', 'text' => '$50 Min Payout'],
    ],
])

{{-- Stats Strip --}}
<div class="aff-stats-bar">
    <div class="wrap">
        <div class="aff-stats" data-aos="fade-up">
            <div class="aff-stat"><div class="aff-stat-ic"><i class="ri-percent-fill"></i></div><strong>20%</strong><span>Commission Rate</span></div>
            <div class="aff-stat-sep"></div>
            <div class="aff-stat"><div class="aff-stat-ic"><i class="ri-hourglass-fill"></i></div><strong>30 Days</strong><span>Cookie Duration</span></div>
            <div class="aff-stat-sep"></div>
            <div class="aff-stat"><div class="aff-stat-ic"><i class="ri-money-dollar-circle-fill"></i></div><strong>$50</strong><span>Min. Payout</span></div>
            <div class="aff-stat-sep"></div>
            <div class="aff-stat"><div class="aff-stat-ic"><i class="ri-flashlight-fill"></i></div><strong>24h</strong><span>Processing Time</span></div>
            <div class="aff-stat-sep"></div>
            <div class="aff-stat"><div class="aff-stat-ic"><i class="ri-group-fill"></i></div><strong>5,000+</strong><span>Active Partners</span></div>
        </div>
    </div>
</div>

{{-- Benefits --}}
<section class="aff-sec">
    <div class="wrap">
        <div class="aff-sec-head" data-aos="fade-up">
            <h2>Why Partner <em>With Us?</em></h2>
            <p>Everything you need to build a successful passive income stream through referrals.</p>
        </div>
        <div class="aff-benefits" data-aos="fade-up">
            <div class="aff-benefit">
                <div class="aff-ben-ic"><i class="ri-line-chart-fill"></i></div>
                <h3>High Commission</h3>
                <p>Earn 20% on every sale — one of the highest rates in the IPTV industry. High-value packages mean big commissions.</p>
                <span class="aff-tag">Up to $30/sale</span>
            </div>
            <div class="aff-benefit">
                <div class="aff-ben-ic" style="background:rgba(16,185,129,0.1);color:#10b981;border-color:rgba(16,185,129,0.2);"><i class="ri-window-fill"></i></div>
                <h3>Real-Time Dashboard</h3>
                <p>Track every click, conversion, and commission in real-time through our partner portal. Full transparency always.</p>
                <span class="aff-tag" style="background:rgba(16,185,129,0.1);color:#10b981;border:1px solid rgba(16,185,129,0.2);">Live Analytics</span>
            </div>
            <div class="aff-benefit">
                <div class="aff-ben-ic" style="background:rgba(139,92,246,0.1);color:#8b5cf6;border-color:rgba(139,92,246,0.2);"><i class="ri-wallet-fill"></i></div>
                <h3>Flexible Payouts</h3>
                <p>Withdraw via Bitcoin, Ethereum, PayPal, or bank transfer. Minimum $50 payout processed within 24 hours.</p>
                <span class="aff-tag" style="background:rgba(139,92,246,0.1);color:#8b5cf6;border:1px solid rgba(139,92,246,0.2);">Multiple Methods</span>
            </div>
        </div>
    </div>
</section>

{{-- Steps --}}
<section class="aff-steps-sec">
    <div class="wrap">
        <div class="aff-sec-head" data-aos="fade-up">
            <h2>3 Steps to <em>Start Earning</em></h2>
            <p>Getting started takes less than 2 minutes.</p>
        </div>
        <div class="aff-steps" data-aos="fade-up">
            <div class="aff-step">
                <div class="aff-step-num">01</div>
                <div class="aff-step-ic"><i class="ri-user-add-fill"></i></div>
                <h3>Register Free</h3>
                <p>Create your account and get instant access to your unique affiliate partner link and dashboard.</p>
            </div>
            <div class="aff-steps-arrow"><i class="ri-arrow-right-line"></i></div>
            <div class="aff-step">
                <div class="aff-step-num">02</div>
                <div class="aff-step-ic" style="background:rgba(16,185,129,0.1);color:#10b981;"><i class="ri-share-fill"></i></div>
                <h3>Share Your Link</h3>
                <p>Share on YouTube, blogs, social media, or anywhere your audience can find it. No restrictions.</p>
            </div>
            <div class="aff-steps-arrow"><i class="ri-arrow-right-line"></i></div>
            <div class="aff-step">
                <div class="aff-step-num" style="background:var(--primary);color:#fff;">03</div>
                <div class="aff-step-ic" style="background:rgba(255,77,28,0.1);color:var(--primary);"><i class="ri-money-dollar-circle-fill"></i></div>
                <h3>Earn Commissions</h3>
                <p>Commissions accumulate with every referral. Withdraw once you hit the $50 threshold.</p>
            </div>
        </div>
    </div>
</section>

{{-- Calculator --}}
<section class="aff-calc-sec">
    <div class="wrap">
        <div class="aff-calc-card" data-aos="zoom-in">
            <div class="aff-calc-header">
                <h2>Earnings <em>Calculator</em></h2>
                <p>See how much you can earn based on your monthly referrals.</p>
            </div>
            <div class="aff-calc-grid">
                <div class="aff-calc-item">
                    <span>Average Package Price</span>
                    <strong>$50</strong>
                </div>
                <div class="aff-calc-div"><i class="ri-close-line"></i></div>
                <div class="aff-calc-item">
                    <span>Your Commission (20%)</span>
                    <strong style="color:var(--primary);">$10</strong>
                </div>
                <div class="aff-calc-div"><i class="ri-close-line"></i></div>
                <div class="aff-calc-item">
                    <span>100 Monthly Referrals</span>
                    <strong class="aff-big-num">$1,000</strong>
                </div>
            </div>
            <p class="aff-calc-note">* Based on average subscription performance. Results may vary.</p>
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="cta-banner">
    <div class="wrap cta-inner">
        <h2>Start Your Earning <em style="font-style:normal;color:rgba(255,255,255,0.85);">Journey Today</em></h2>
        <p>Join 5,000+ active partners already earning with Live IPTV Now.</p>
        <div class="cta-btns">
            @auth
            <a href="{{ route('profile') }}#affiliate" class="btn btn-white btn-lg"><i class="ri-dashboard-fill"></i> Partner Portal</a>
            @else
            <a href="{{ route('register') }}" class="btn btn-white btn-lg"><i class="ri-user-add-fill"></i> Apply Now — Free</a>
            <a href="{{ route('login') }}" class="btn btn-lg" style="background:rgba(255,255,255,0.12);color:#fff;border:2px solid rgba(255,255,255,0.3);">Sign In</a>
            @endauth
        </div>
    </div>
</section>

@endsection

@push('styles')
<style>
/* Stats bar */
.aff-stats-bar { background: var(--dark); padding: 24px 0; }
.aff-stats { display: flex; align-items: center; justify-content: center; flex-wrap: wrap; }
.aff-stat { display: flex; align-items: center; gap: 12px; padding: 8px 28px; }
.aff-stat-ic {
    width: 40px; height: 40px; border-radius: 10px;
    background: rgba(255,77,28,0.15); display: grid; place-items: center;
    font-size: 1.1rem; color: var(--primary); flex-shrink: 0;
}
.aff-stat strong { display: block; font-size: 1.4rem; font-weight: 900; color: #fff; line-height: 1; }
.aff-stat span { font-size: 0.72rem; color: rgba(255,255,255,0.45); text-transform: uppercase; letter-spacing: 1px; font-weight: 600; }
.aff-stat-sep { width: 1px; height: 36px; background: rgba(255,255,255,0.1); }

/* Sections */
.aff-sec { padding: 72px 0; }
.aff-steps-sec { background: var(--bg2); border-top: var(--bdr); border-bottom: var(--bdr); padding: 72px 0; }
.aff-calc-sec { padding: 72px 0; }

.aff-sec-head { text-align: center; max-width: 560px; margin: 0 auto 48px; }
.aff-sec-head h2 { font-size: clamp(1.8rem,3vw,2.4rem); color: var(--ink); margin-bottom: 10px; }
.aff-sec-head h2 em { font-style: normal; color: var(--primary); }
.aff-sec-head p { color: var(--ink4); }

/* Benefits */
.aff-benefits { display: grid; grid-template-columns: repeat(3,1fr); gap: 24px; }
.aff-benefit {
    background: #fff; border: 1.5px solid #e5e7eb;
    border-radius: 20px; padding: 36px 28px;
    text-align: center; transition: var(--ts);
    box-shadow: var(--s1);
}
.aff-benefit:hover { transform: translateY(-7px); box-shadow: var(--s4); border-color: var(--primary-glow); }
.aff-ben-ic {
    width: 64px; height: 64px; border-radius: 18px;
    background: var(--primary-soft); border: 1px solid var(--primary-glow);
    display: grid; place-items: center;
    font-size: 1.7rem; color: var(--primary);
    margin: 0 auto 20px; transition: var(--t);
}
.aff-benefit:hover .aff-ben-ic { background: var(--primary); color: #fff; border-color: var(--primary); }
.aff-benefit h3 { font-size: 1.15rem; color: var(--ink); margin-bottom: 10px; }
.aff-benefit p { font-size: 0.88rem; color: var(--ink4); line-height: 1.65; margin-bottom: 18px; }
.aff-tag {
    display: inline-block; padding: 5px 14px;
    background: var(--primary-soft);
    border: 1px solid var(--primary-glow);
    border-radius: var(--rr);
    font-size: 0.75rem; font-weight: 800; color: var(--primary);
}

/* Steps */
.aff-steps { display: flex; align-items: center; justify-content: center; gap: 0; flex-wrap: wrap; }
.aff-step { flex: 1; min-width: 180px; max-width: 260px; text-align: center; }
.aff-step-num {
    width: 40px; height: 40px; border-radius: 50%;
    background: var(--bg3); color: var(--ink3);
    border: 2px solid var(--bg4);
    display: grid; place-items: center;
    font-size: 0.82rem; font-weight: 900;
    margin: 0 auto 16px; transition: var(--t);
}
.aff-step:hover .aff-step-num { background: var(--primary); color: #fff; border-color: var(--primary); }
.aff-step-ic {
    width: 64px; height: 64px; border-radius: 18px;
    background: var(--primary-soft);
    display: grid; place-items: center;
    font-size: 1.7rem; color: var(--primary);
    margin: 0 auto 18px; transition: var(--t);
}
.aff-step h3 { font-size: 1.1rem; color: var(--ink); margin-bottom: 8px; }
.aff-step p { font-size: 0.85rem; color: var(--ink4); line-height: 1.6; max-width: 220px; margin: 0 auto; }
.aff-steps-arrow { color: var(--ink5); font-size: 1.5rem; padding: 0 8px; flex-shrink: 0; }

/* Calculator */
.aff-calc-card {
    max-width: 780px; margin: 0 auto;
    background: #fff; border: var(--bdr);
    border-radius: 24px; padding: 60px 48px;
    text-align: center; box-shadow: var(--s3);
    position: relative; overflow: hidden;
}
.aff-calc-card::before { content:''; position:absolute; top:0; left:0; right:0; height:4px; background:var(--primary); }
.aff-calc-header h2 { font-size: 2rem; margin-bottom: 6px; color: var(--ink); }
.aff-calc-header h2 em { font-style:normal; color: var(--primary); }
.aff-calc-header p { color: var(--ink4); margin-bottom: 40px; }

.aff-calc-grid {
    display: flex; align-items: center; justify-content: center;
    gap: 0; background: var(--bg2); border: var(--bdr);
    border-radius: 16px; padding: 32px 24px; margin-bottom: 20px;
    flex-wrap: wrap;
}
.aff-calc-item { padding: 0 28px; flex: 1; min-width: 140px; }
.aff-calc-item span { display: block; font-size: 0.75rem; text-transform: uppercase; font-weight: 800; letter-spacing: 1.5px; color: var(--ink5); margin-bottom: 8px; }
.aff-calc-item strong { font-size: 2.4rem; font-weight: 900; color: var(--ink); letter-spacing: -1px; }
.aff-big-num { font-size: 3rem !important; color: var(--primary) !important; }
.aff-calc-div { font-size: 1.4rem; color: var(--ink5); flex-shrink: 0; padding: 0 4px; }
.aff-calc-note { font-size: 0.78rem; color: var(--ink5); font-style: italic; }

@media(max-width:1024px) { .aff-benefits { grid-template-columns: 1fr; } }
@media(max-width:768px) {
    .aff-stats { justify-content: flex-start; overflow-x: auto; flex-wrap: nowrap; }
    .aff-stat { flex-shrink: 0; }
    .aff-steps-arrow { display: none; }
    .aff-steps { gap: 28px; }
    .aff-calc-card { padding: 36px 24px; }
    .aff-calc-grid { flex-direction: column; gap: 20px; padding: 24px; }
    .aff-calc-div { display: none; }
    .aff-benefits { grid-template-columns: 1fr; }
}
</style>
@endpush
