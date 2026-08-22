@extends('layouts.app')
@section('title', 'Live IPTV Now — #1 Premium IPTV | 40,000+ Channels HD & 4K')

@push('styles')
<style>
/* ═══════ HOME PAGE — Specific Styles ═══════ */

/* ── HERO — Full Background Image with Text Overlay ── */
.hero {
    position: relative;
    min-height: 92vh;
    display: flex;
    align-items: center;
    overflow: hidden;
}

/* Background image layer */
.hero-bg {
    position: absolute;
    inset: 0;
    z-index: 0;
}
.hero-bg img {
    width: 100%; height: 100%;
    object-fit: cover;
    object-position: center;
    display: block;
}
/* gradient overlay: dark on left, more transparent right */
.hero-bg::after {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(
        105deg,
        rgba(10, 10, 20, 0.88) 0%,
        rgba(10, 10, 20, 0.72) 50%,
        rgba(10, 10, 20, 0.30) 100%
    );
}

/* Content sits above overlay */
.hero-content {
    position: relative;
    z-index: 2;
    padding: 120px 0 100px;
    max-width: 680px;
}

.hero-eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(255,77,28,0.18);
    border: 1px solid rgba(255,77,28,0.4);
    color: #ff7a55;
    font-size: 0.78rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 2px;
    padding: 6px 16px;
    border-radius: var(--rr);
    margin-bottom: 24px;
}
.hero-eyebrow span {
    display: inline-block;
    width: 8px; height: 8px;
    background: var(--primary);
    border-radius: 50%;
    animation: pulse-dot 1.8s ease-in-out infinite;
}
@keyframes pulse-dot {
    0%, 100% { transform: scale(1); opacity:1; }
    50%       { transform: scale(1.5); opacity:0.6; }
}

.hero h1 {
    font-size: clamp(2.8rem, 5.5vw, 4.8rem);
    font-weight: 900;
    line-height: 1.06;
    letter-spacing: -2px;
    color: #fff;
    margin-bottom: 22px;
    text-shadow: 0 2px 20px rgba(0,0,0,0.3);
}
.hero h1 .accent { color: var(--primary); }

.hero-desc {
    font-size: 1.1rem;
    color: rgba(255,255,255,0.78);
    line-height: 1.75;
    margin-bottom: 38px;
    max-width: 580px;
}

.hero-cta {
    display: flex;
    flex-wrap: wrap;
    gap: 14px;
    margin-bottom: 48px;
}

.hero-trust {
    display: flex;
    align-items: center;
    gap: 16px;
    flex-wrap: wrap;
}
.ht-avatars { display: flex; }
.ht-avatars span {
    width: 36px; height: 36px;
    border-radius: 50%;
    border: 2px solid rgba(255,255,255,0.5);
    margin-left: -10px;
    display: grid; place-items: center;
    font-size: 0.65rem;
    font-weight: 700;
    color: #fff;
}
.ht-avatars span:nth-child(1) { background: #6366f1; margin-left: 0; }
.ht-avatars span:nth-child(2) { background: #8b5cf6; }
.ht-avatars span:nth-child(3) { background: #ec4899; }
.ht-avatars span:nth-child(4) { background: var(--primary); }
.ht-avatars span:nth-child(5) { background: #10b981; }

.ht-text { font-size: 0.82rem; color: rgba(255,255,255,0.65); }
.ht-text strong { color: #fff; font-weight: 800; }
.ht-stars { display: flex; gap: 2px; color: #f59e0b; font-size: 0.78rem; }

/* Floating badge — bottom right of hero */
.hero-float-badge {
    position: absolute;
    bottom: 40px; right: 60px;
    z-index: 3;
    background: rgba(255,255,255,0.12);
    backdrop-filter: blur(12px);
    border: 1px solid rgba(255,255,255,0.20);
    border-radius: 18px;
    padding: 18px 24px;
    display: flex;
    gap: 20px;
    align-items: center;
}
.hfb-item { text-align: center; }
.hfb-item strong { display: block; font-size: 1.4rem; font-weight: 900; color: #fff; line-height: 1; }
.hfb-item span { font-size: 0.7rem; text-transform: uppercase; letter-spacing: 1px; color: rgba(255,255,255,0.55); font-weight: 600; }
.hfb-sep { width: 1px; background: rgba(255,255,255,0.15); align-self: stretch; }

/* ── STATS BAR ── */
.stats-bar {
    background: var(--dark);
    padding: 0;
}
.stats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
}
.stat-item {
    padding: 36px 20px;
    text-align: center;
    border-right: 1px solid rgba(255,255,255,0.07);
    transition: var(--t);
}
.stat-item:last-child { border-right: none; }
.stat-item:hover { background: rgba(255,77,28,0.06); }
.stat-num {
    font-size: 2.4rem;
    font-weight: 900;
    color: #fff;
    line-height: 1;
    margin-bottom: 6px;
    letter-spacing: -1px;
}
.stat-num span { color: var(--primary); }
.stat-label { font-size: 0.78rem; text-transform: uppercase; letter-spacing: 2px; color: rgba(255,255,255,0.4); font-weight: 600; }

/* ── FEATURES ── */
.features-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 24px;
}
.feature-card {
    background: #fff;
    border: var(--bdr);
    border-radius: var(--r3);
    padding: 36px 28px;
    transition: var(--ts);
    position: relative;
    overflow: hidden;
}
.feature-card::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 3px;
    background: var(--primary);
    transform: scaleX(0);
    transform-origin: left;
    transition: transform 0.35s ease;
}
.feature-card:hover { transform: translateY(-8px); box-shadow: var(--s4); border-color: var(--primary-glow); }
.feature-card:hover::before { transform: scaleX(1); }
.feature-card:hover .feat-ic { background: var(--primary); color: #fff; }

.feat-ic {
    width: 58px; height: 58px;
    border-radius: 14px;
    background: var(--primary-soft);
    border: 1px solid var(--primary-glow);
    display: grid; place-items: center;
    font-size: 1.5rem;
    color: var(--primary);
    margin-bottom: 22px;
    transition: var(--t);
}
.feature-card h3 { font-size: 1.15rem; margin-bottom: 12px; color: var(--ink); }
.feature-card p { font-size: 0.9rem; color: var(--ink4); line-height: 1.7; }
.feature-card .read-more {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    margin-top: 18px;
    font-size: 0.86rem;
    font-weight: 700;
    color: var(--primary);
}
.feature-card .read-more:hover { gap: 10px; }

/* ── SPLIT SECTION ── */
.split-sec {
    padding: var(--sec-py) 0;
    background: var(--bg2);
}
.split-inner {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 80px;
    align-items: center;
}
.split-img {
    border-radius: 20px;
    overflow: hidden;
    box-shadow: var(--s4);
}
.split-img img { width: 100%; display: block; }
.split-text .sec-tag { margin-bottom: 18px; }
.split-text h2 { font-size: clamp(1.8rem, 3.5vw, 2.6rem); margin-bottom: 18px; letter-spacing: -0.5px; }
.split-text p { color: var(--ink4); margin-bottom: 28px; line-height: 1.75; font-size: 0.97rem; }
.split-list { display: flex; flex-direction: column; gap: 14px; margin-bottom: 34px; }
.split-list li {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    font-size: 0.92rem;
    color: var(--ink3);
}
.split-list li i {
    color: var(--primary);
    font-size: 1.1rem;
    margin-top: 2px;
    flex-shrink: 0;
}
.split-list li strong { font-weight: 700; color: var(--ink); }

/* ── PRICING ── */
.pricing-tabs {
    display: flex;
    justify-content: center;
    gap: 6px;
    background: var(--bg3);
    padding: 6px;
    border-radius: var(--r2);
    width: fit-content;
    margin: 0 auto 48px;
}
.pk-tab {
    padding: 10px 24px;
    font-size: 0.88rem;
    font-weight: 700;
    border-radius: var(--r);
    color: var(--ink4);
    cursor: pointer;
    transition: var(--t);
    border: none;
    background: transparent;
    font-family: var(--font);
}
.pk-tab.active {
    background: #fff;
    color: var(--primary);
    box-shadow: var(--s2);
}
.pricing-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 28px;
    max-width: 980px;
    margin: 0 auto;
}
.price-card {
    background: #fff;
    border: 1.5px solid #e5e7eb;
    border-radius: 20px;
    padding: 40px 32px;
    text-align: center;
    display: flex;
    flex-direction: column;
    transition: var(--ts);
    position: relative;
}
.price-card:hover { transform: translateY(-8px); box-shadow: var(--s4); border-color: var(--primary-glow); }
.price-card.featured {
    border-color: var(--primary);
    box-shadow: 0 0 0 4px var(--primary-glow), var(--s3);
    transform: scale(1.03);
}
.price-card.featured:hover { transform: scale(1.03) translateY(-8px); }
.pc-badge {
    position: absolute;
    top: -14px; left: 50%;
    transform: translateX(-50%);
    background: var(--primary);
    color: #fff;
    padding: 4px 20px;
    border-radius: var(--rr);
    font-size: 0.68rem;
    font-weight: 900;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    white-space: nowrap;
}
.price-card h3 { font-size: 1.2rem; margin-bottom: 6px; }
.price-card .pc-duration { font-size: 0.82rem; color: var(--ink5); margin-bottom: 24px; }
.price-amt {
    font-size: 3.2rem;
    font-weight: 900;
    color: var(--ink);
    line-height: 1;
    margin-bottom: 4px;
    letter-spacing: -2px;
}
.price-amt sup { font-size: 1.2rem; vertical-align: top; margin-top: 8px; font-weight: 700; }
.price-amt .price-suffix { font-size: 0.95rem; color: var(--ink5); font-weight: 600; margin-left: 4px; }
.price-card .pc-desc { font-size: 0.82rem; color: var(--ink5); margin-bottom: 28px; }
.pc-features {
    text-align: left;
    flex: 1;
    margin-bottom: 28px;
    border-top: var(--bdr);
    padding-top: 20px;
}
.pc-features li {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 8px 0;
    font-size: 0.88rem;
    color: var(--ink3);
    border-bottom: 1px solid #f8fafc;
}
.pc-features li:last-child { border-bottom: none; }
.pc-features i.ri-check-line { color: var(--success); font-size: 1rem; flex-shrink: 0; }
.pc-features i.ri-close-line { color: var(--ink5); font-size: 1rem; flex-shrink: 0; }

/* ── TESTIMONIALS ── */
.reviews-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 24px;
}
.review-card {
    background: #fff;
    border: var(--bdr);
    border-radius: var(--r3);
    padding: 28px;
    transition: var(--ts);
}
.review-card:hover { transform: translateY(-5px); box-shadow: var(--s3); }
.rev-stars { display: flex; gap: 3px; color: #f59e0b; font-size: 0.9rem; margin-bottom: 14px; }
.rev-text { font-size: 0.9rem; color: var(--ink3); line-height: 1.75; margin-bottom: 18px; font-style: italic; }
.rev-author { display: flex; align-items: center; gap: 12px; }
.rev-av {
    width: 44px; height: 44px;
    border-radius: 50%;
    background: var(--primary);
    display: grid; place-items: center;
    font-weight: 900; font-size: 0.75rem;
    color: #fff;
    flex-shrink: 0;
}
.rev-name { font-weight: 800; font-size: 0.9rem; color: var(--ink); }
.rev-loc { font-size: 0.75rem; color: var(--ink5); }

/* ── WHY US ── */
.why-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 60px;
    align-items: center;
}
.why-list { display: flex; flex-direction: column; gap: 24px; }
.why-item {
    display: flex;
    gap: 18px;
    align-items: flex-start;
    padding: 22px 24px;
    background: #fff;
    border: var(--bdr);
    border-radius: var(--r2);
    transition: var(--ts);
}
.why-item:hover { border-color: var(--primary-glow); box-shadow: var(--s2); transform: translateX(6px); }
.why-ic {
    width: 50px; height: 50px;
    border-radius: 12px;
    background: var(--primary-soft);
    border: 1px solid var(--primary-glow);
    display: grid; place-items: center;
    font-size: 1.35rem;
    color: var(--primary);
    flex-shrink: 0;
    transition: var(--t);
}
.why-item:hover .why-ic { background: var(--primary); color: #fff; }
.why-item h4 { font-size: 1rem; margin-bottom: 5px; color: var(--ink); }
.why-item p { font-size: 0.87rem; color: var(--ink4); line-height: 1.6; }
.why-img {
    border-radius: 20px;
    overflow: hidden;
    box-shadow: var(--s4);
    position: relative;
}
.why-img img { width: 100%; display: block; }
.why-over {
    position: absolute;
    bottom: 24px; right: 24px;
    background: var(--primary);
    color: #fff;
    border-radius: 14px;
    padding: 14px 20px;
    text-align: center;
    box-shadow: var(--s-primary);
}
.why-over strong { display: block; font-size: 1.6rem; font-weight: 900; line-height: 1; }
.why-over span { font-size: 0.72rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; opacity: 0.85; }

/* ── DEVICES ── */
.devices-strip {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 16px;
}
.device-card {
    background: #fff;
    border: var(--bdr);
    border-radius: var(--r2);
    padding: 22px 16px;
    text-align: center;
    transition: var(--ts);
}
.device-card:hover { border-color: var(--primary); background: var(--primary-soft); transform: translateY(-5px); }
.device-card:hover .device-ic { color: var(--primary); }
.device-ic { font-size: 2rem; color: var(--ink4); margin-bottom: 10px; display: block; }
.device-card span { font-size: 0.82rem; font-weight: 700; color: var(--ink3); }

/* ── HOW IT WORKS ── */
.steps-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 32px;
    position: relative;
}
.steps-grid::before {
    content: '';
    position: absolute;
    top: 36px; left: 12.5%; right: 12.5%;
    height: 2px;
    background: linear-gradient(90deg, var(--primary-glow), var(--primary), var(--primary-glow));
    z-index: 0;
}
.step-card {
    text-align: center;
    position: relative;
    z-index: 1;
}
.step-num {
    width: 72px; height: 72px;
    border-radius: 50%;
    background: #fff;
    border: 2px solid var(--primary-glow);
    display: grid; place-items: center;
    margin: 0 auto 20px;
    font-size: 1.4rem;
    font-weight: 900;
    color: var(--primary);
    box-shadow: 0 0 0 8px #fff, var(--s2);
    transition: var(--ts);
}
.step-card:hover .step-num {
    background: var(--primary);
    color: #fff;
    border-color: var(--primary);
    box-shadow: 0 0 0 8px #fff, var(--s-primary);
    transform: scale(1.08);
}
.step-card h4 { font-size: 1rem; margin-bottom: 8px; color: var(--ink); }
.step-card p { font-size: 0.85rem; color: var(--ink4); line-height: 1.6; }

/* ── CTA BANNER ── */
.cta-banner {
    background: var(--primary);
    padding: 80px 0;
    text-align: center;
    position: relative;
    overflow: hidden;
}
.cta-banner::before {
    content: '';
    position: absolute;
    inset: 0;
    background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.04'%3E%3Ccircle cx='30' cy='30' r='4'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
}
.cta-inner { position: relative; z-index: 2; }
.cta-inner h2 { font-size: clamp(1.9rem, 4vw, 3rem); color: #fff; margin-bottom: 16px; }
.cta-inner p { font-size: 1.1rem; color: rgba(255,255,255,0.8); margin-bottom: 36px; max-width: 560px; margin-left: auto; margin-right: auto; }
.cta-btns { display: flex; gap: 14px; justify-content: center; flex-wrap: wrap; }
.cta-trust-strip {
    display: flex;
    justify-content: center;
    gap: 28px;
    margin-top: 36px;
    flex-wrap: wrap;
}
.cta-trust-item {
    display: flex;
    align-items: center;
    gap: 7px;
    font-size: 0.82rem;
    color: rgba(255,255,255,0.7);
    font-weight: 600;
}
.cta-trust-item i { color: rgba(255,255,255,0.9); font-size: 1rem; }

/* ── HOME RESPONSIVE ── */
@media (max-width: 1024px) {
    .features-grid { grid-template-columns: repeat(2, 1fr); }
    .reviews-grid  { grid-template-columns: repeat(2, 1fr); }
    .steps-grid    { grid-template-columns: repeat(2, 1fr); gap: 28px; }
    .steps-grid::before { display: none; }
    .devices-strip { grid-template-columns: repeat(3, 1fr); }
    .why-grid      { grid-template-columns: 1fr; gap: 40px; }
    .why-img       { max-width: 540px; margin: 0 auto; }
    .pricing-grid  { grid-template-columns: 1fr; max-width: 380px; }
    .price-card.featured { transform: none; }
    .price-card.featured:hover { transform: translateY(-8px); }
    .hero-float-badge { right: 30px; bottom: 30px; }
}

@media (max-width: 768px) {
    .hero { min-height: 85vh; }
    .hero-content { padding: 80px 0 120px; max-width: 100%; text-align: center; }
    .hero-cta { justify-content: center; }
    .hero-trust { justify-content: center; }
    .hero-float-badge { bottom: 20px; right: 50%; transform: translateX(50%); flex-wrap: wrap; justify-content: center; gap: 14px; padding: 14px 20px; }
    .hfb-sep { display: none; }
    .stats-grid { grid-template-columns: repeat(2, 1fr); }
    .stat-item { border-right: none; border-bottom: 1px solid rgba(255,255,255,0.07); }
    .split-inner { grid-template-columns: 1fr; gap: 40px; }
    .features-grid { grid-template-columns: 1fr; }
    .reviews-grid  { grid-template-columns: 1fr; max-width: 500px; margin: 0 auto; }
    .devices-strip { grid-template-columns: repeat(2, 1fr); }
    .why-list { gap: 14px; }
    .steps-grid { grid-template-columns: 1fr; }
    .cta-trust-strip { gap: 16px; }
}

@media (max-width: 480px) {
    .hero { min-height: 80vh; }
    .hero h1 { letter-spacing: -1px; font-size: 2.3rem; }
    .hero-float-badge { font-size: 0.85rem; }
    .stats-grid { grid-template-columns: repeat(2, 1fr); }
    .stat-num { font-size: 1.8rem; }
    .devices-strip { grid-template-columns: repeat(2, 1fr); }
    .pricing-tabs { flex-wrap: wrap; }
    .cta-btns .btn { width: 100%; justify-content: center; }
}
</style>
@endpush

@section('content')

{{-- ═══ HERO ═══ --}}
<section class="hero">
    {{-- Background Image --}}
    <div class="hero-bg">
        <img src="/iptv_hero_people_watching_tv_1772364978982.png"
             alt="Family enjoying premium IPTV streaming"
             loading="eager">
    </div>

    {{-- Text Content --}}
    <div class="wrap" style="width:100%;">
        <div class="hero-content" data-aos="fade-up">
            <h1>
                Where <span class="accent">Innovation</span><br>
                Meets Entertainment<br>
                <span class="accent">Excellence</span>
            </h1>
            <p class="hero-desc">
                Unlock 40,000+ premium live channels in stunning 4K and HD. Stream movies, sports, news, and shows on any device — zero buffering, zero contracts. Join 100,000+ happy viewers worldwide.
            </p>
            <div class="hero-cta">
                @if($freeTrialPackage)
                    <a href="{{ route('checkout.show', $freeTrialPackage->slug) }}" class="btn btn-primary btn-lg">
                        <i class="ri-play-fill"></i> Start Free Trial
                    </a>
                @else
                    <a href="{{ route('packages.index') }}" class="btn btn-primary btn-lg">
                        <i class="ri-play-fill"></i> View All Plans
                    </a>
                @endif
                <a href="#features" class="btn btn-lg" style="background:rgba(255,255,255,0.12);color:#fff;border:2px solid rgba(255,255,255,0.30);backdrop-filter:blur(6px);">
                    <i class="ri-information-line"></i> Learn More
                </a>
            </div>
            <div class="hero-trust">
                <div class="ht-avatars">
                    <span>MJ</span><span>SK</span><span>AL</span><span>RD</span><span>+</span>
                </div>
                <div>
                    <div class="ht-stars">
                        <i class="ri-star-fill"></i><i class="ri-star-fill"></i>
                        <i class="ri-star-fill"></i><i class="ri-star-fill"></i>
                        <i class="ri-star-fill"></i>
                    </div>
                    <div class="ht-text"><strong>100,000+</strong> happy customers worldwide</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Floating Stats Badge (bottom right) --}}
    <div class="hero-float-badge">
        <div class="hfb-item">
            <strong>40K+</strong>
            <span>Live Channels</span>
        </div>
        <div class="hfb-sep"></div>
        <div class="hfb-item">
            <strong>4K</strong>
            <span>Ultra HD</span>
        </div>
        <div class="hfb-sep"></div>
        <div class="hfb-item">
            <strong>99.9%</strong>
            <span>Uptime</span>
        </div>
    </div>
</section>

{{-- ═══ STATS BAR ═══ --}}
<div class="stats-bar">
    <div class="wrap">
        <div class="stats-grid">
            <div class="stat-item" data-aos="fade-up">
                <div class="stat-num">{{ $stats['channels'] }}</div>
                <div class="stat-label">Live Channels</div>
            </div>
            <div class="stat-item" data-aos="fade-up" data-aos-delay="80">
                <div class="stat-num">100K<span>+</span></div>
                <div class="stat-label">Movies & VOD</div>
            </div>
            <div class="stat-item" data-aos="fade-up" data-aos-delay="160">
                <div class="stat-num">{{ $stats['countries'] }}</div>
                <div class="stat-label">Countries</div>
            </div>
            <div class="stat-item" data-aos="fade-up" data-aos-delay="240">
                <div class="stat-num">{{ $stats['uptime'] }}</div>
                <div class="stat-label">Uptime SLA</div>
            </div>
        </div>
    </div>
</div>

{{-- ═══ FEATURES ═══ --}}
<section id="features" class="sec">
    <div class="wrap">
        <div class="sec-top" data-aos="fade-up">
            <span class="sec-tag"><i class="ri-sparkling-fill"></i> Why Choose Us</span>
            <h2 class="sec-h">Everything You Need for<br><em>Perfect Streaming</em></h2>
            <p class="sec-d">Enterprise-grade infrastructure delivering crystal-clear content to every screen, every time.</p>
        </div>

        <div class="features-grid" data-stagger>
            <div class="feature-card" data-aos="fade-up">
                <div class="feat-ic"><i class="ri-flashlight-fill"></i></div>
                <h3>Lightning Fast Servers</h3>
                <p>Our global CDN with 600+ edge nodes ensures buffering is a thing of the past. Sub-second channel switching guaranteed.</p>
                <a href="{{ route('how-it-works') }}" class="read-more">Read More <i class="ri-arrow-right-line"></i></a>
            </div>
            <div class="feature-card" data-aos="fade-up" data-aos-delay="80">
                <div class="feat-ic"><i class="ri-4k-fill"></i></div>
                <h3>4K & HD Quality</h3>
                <p>Experience ultra-high definition clarity with HDR support. Watch your favorite content in cinema-quality resolution.</p>
                <a href="{{ route('packages.index') }}" class="read-more">View Plans <i class="ri-arrow-right-line"></i></a>
            </div>
            <div class="feature-card" data-aos="fade-up" data-aos-delay="160">
                <div class="feat-ic"><i class="ri-shield-check-fill"></i></div>
                <h3>99.9% Uptime SLA</h3>
                <p>Our redundant multi-CDN infrastructure guarantees rock-solid reliability. Never miss a moment of your favorite content.</p>
                <a href="{{ route('faq') }}" class="read-more">Learn More <i class="ri-arrow-right-line"></i></a>
            </div>
            <div class="feature-card" data-aos="fade-up" data-aos-delay="80">
                <div class="feat-ic"><i class="ri-device-line"></i></div>
                <h3>All Devices Supported</h3>
                <p>Smart TV, Firestick, Android, iOS, Windows, Mac, and more. Stream seamlessly across up to 5 simultaneous connections.</p>
                <a href="#devices" class="read-more">See Devices <i class="ri-arrow-right-line"></i></a>
            </div>
            <div class="feature-card" data-aos="fade-up" data-aos-delay="160">
                <div class="feat-ic"><i class="ri-customer-service-2-fill"></i></div>
                <h3>24/7 Expert Support</h3>
                <p>Real humans, real solutions. Live chat, WhatsApp, and email support with under 10-minute average response time.</p>
                <a href="{{ route('contact') }}" class="read-more">Contact Us <i class="ri-arrow-right-line"></i></a>
            </div>
            <div class="feature-card" data-aos="fade-up" data-aos-delay="240">
                <div class="feat-ic"><i class="ri-movie-2-fill"></i></div>
                <h3>100K+ VOD Library</h3>
                <p>Latest blockbusters, classic films, TV series, and documentaries. New content added daily from Hollywood to Bollywood.</p>
                <a href="{{ route('packages.index') }}" class="read-more">Browse Plans <i class="ri-arrow-right-line"></i></a>
            </div>
        </div>
    </div>
</section>

{{-- ═══ SPLIT - SPEED SECTION ═══ --}}
<section class="split-sec">
    <div class="wrap">
        <div class="split-inner">
            <div class="split-img" data-aos="fade-right">
                <img src="/speed_test_speedometer.png" alt="Ultra High Speed Internet Speedometer">
            </div>
            <div class="split-text" data-aos="fade-left" data-aos-delay="100">
                <span class="sec-tag"><i class="ri-speed-fill"></i> Ultra Performance</span>
                <h2>Unleash the Power of<br><em>High Speed Streaming</em></h2>
                <p>Our proprietary anti-freeze technology and adaptive bitrate delivery ensures you always get the best picture quality your connection allows. No more buffering rings, no more pixelated screens.</p>
                <ul class="split-list">
                    <li>
                        <i class="ri-checkbox-circle-fill"></i>
                        <div><strong>Multi-Device Streaming</strong> — Watch on up to 5 screens simultaneously</div>
                    </li>
                    <li>
                        <i class="ri-checkbox-circle-fill"></i>
                        <div><strong>Instant Activation</strong> — Your credentials arrive within minutes of payment</div>
                    </li>
                    <li>
                        <i class="ri-checkbox-circle-fill"></i>
                        <div><strong>No Contracts</strong> — Cancel or upgrade anytime, no hidden fees</div>
                    </li>
                    <li>
                        <i class="ri-checkbox-circle-fill"></i>
                        <div><strong>Electronic Program Guide</strong> — Full EPG with schedules for all channels</div>
                    </li>
                </ul>
                <a href="{{ route('packages.index') }}" class="btn btn-primary">
                    <i class="ri-play-circle-fill"></i> Get Started Today
                </a>
            </div>
        </div>
    </div>
</section>

{{-- ═══ PRICING ═══ --}}
<section class="sec" id="pricing">
    <div class="wrap">
        <div class="sec-top" data-aos="fade-up">
            <span class="sec-tag"><i class="ri-price-tag-3-fill"></i> Pricing Plans</span>
            <h2 class="sec-h">Your Gateway to a<br><em>Connected World</em></h2>
            <p class="sec-d">Simple, transparent pricing. No hidden fees. Choose any plan and upgrade anytime.</p>
        </div>

        {{-- Pricing Tabs --}}
        <div class="pricing-tabs" role="tablist" aria-label="Subscription duration">
            <button class="pk-tab active" data-tab="1_month" role="tab">1 Month</button>
            <button class="pk-tab" data-tab="3_months" role="tab">3 Months</button>
            <button class="pk-tab" data-tab="6_months" role="tab">6 Months</button>
            <button class="pk-tab" data-tab="12_months" role="tab">1 Year</button>
            <button class="pk-tab" data-tab="lifetime" role="tab">Lifetime</button>
        </div>

        {{-- Pricing Cards per Duration --}}
        @foreach(['1_month', '3_months', '6_months', '12_months', 'lifetime'] as $key)
        <div class="pricing-grid pk-panel" id="panel-{{ $key }}"
             style="{{ $key !== '1_month' ? 'display:none;' : '' }}"
             data-duration="{{ $key }}">
            @forelse($packagesByDuration[$key] as $pkg)
            <div class="price-card {{ $pkg->is_popular ? 'featured' : '' }}"
                 data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                @if($pkg->is_popular)
                <div class="pc-badge">Most Popular</div>
                @endif
                <h3>{{ $pkg->name }}</h3>
                <div class="pc-duration">{{ \App\Support\PackageDurations::cardLabel($pkg) }}</div>
                <div class="price-amt">
                    <sup>$</sup>{{ number_format($pkg->price, 0) }}
                    @if($suffix = \App\Support\PackageDurations::priceSuffix($pkg))
                    <span class="price-suffix">{{ $suffix }}</span>
                    @endif
                </div>
                @if($pkg->description)
                <p class="pc-desc">{{ $pkg->description }}</p>
                @endif
                <ul class="pc-features">
                    @foreach($pkg->features as $feat)
                    <li><i class="ri-check-line"></i> {{ $feat->name }}</li>
                    @endforeach
                </ul>
                <a href="{{ route('checkout.show', $pkg->slug) }}"
                   class="btn {{ $pkg->is_popular ? 'btn-primary' : 'btn-outline' }} btn-full">
                   Order Now <i class="ri-arrow-right-line"></i>
                </a>
            </div>
            @empty
            <div style="grid-column:1/-1;text-align:center;padding:40px;color:var(--ink4);">
                <i class="ri-store-2-line" style="font-size:3rem;display:block;margin-bottom:14px;color:var(--ink5);"></i>
                No plans available for this duration yet. Check other tabs!
            </div>
            @endforelse
        </div>
        @endforeach
    </div>
</section>

{{-- ═══ WHY US ═══ --}}
<section class="sec sec-alt">
    <div class="wrap">
        <div class="why-grid">
            <div data-aos="fade-right">
                <span class="sec-tag"><i class="ri-award-fill"></i> Our Advantage</span>
                <h2 class="sec-h" style="text-align:left;margin-bottom:36px;">Why 100K+ Customers<br><em>Trust Us</em></h2>
                <div class="why-list">
                    <div class="why-item" data-aos="fade-up" data-aos-delay="0">
                        <div class="why-ic"><i class="ri-global-fill"></i></div>
                        <div>
                            <h4>Global Content Coverage</h4>
                            <p>Access channels from 150+ countries — USA, UK, India, Arabic, French, Spanish and more.</p>
                        </div>
                    </div>
                    <div class="why-item" data-aos="fade-up" data-aos-delay="80">
                        <div class="why-ic"><i class="ri-lock-2-fill"></i></div>
                        <div>
                            <h4>Secure &amp; Private</h4>
                            <p>Your data stays safe. SSL encryption on all transactions, no logs, no tracking.</p>
                        </div>
                    </div>
                    <div class="why-item" data-aos="fade-up" data-aos-delay="160">
                        <div class="why-ic"><i class="ri-refund-2-fill"></i></div>
                        <div>
                            <h4>Money-Back Guarantee</h4>
                            <p>Not satisfied within 24 hours? We'll give you a full refund, no questions asked.</p>
                        </div>
                    </div>
                    <div class="why-item" data-aos="fade-up" data-aos-delay="240">
                        <div class="why-ic"><i class="ri-thunderstorms-fill"></i></div>
                        <div>
                            <h4>Instant Setup</h4>
                            <p>No technician needed. Get your credentials in minutes and set up in under 5 minutes.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="why-img" data-aos="fade-left" data-aos-delay="200">
                <img src="/iptv_hero_people_watching_tv_1772364978982.png" alt="Happy customers using Live IPTV Now">
                <div class="why-over">
                    <strong>4.9 ★</strong>
                    <span>Customer Rating</span>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ═══ SUPPORTED DEVICES ═══ --}}
<section class="sec" id="devices">
    <div class="wrap">
        <div class="sec-top" data-aos="fade-up">
            <span class="sec-tag"><i class="ri-device-fill"></i> Compatible Devices</span>
            <h2 class="sec-h">Watch on <em>Any Screen</em></h2>
            <p class="sec-d">Works on all major platforms and devices. No restrictions, no limitations.</p>
        </div>
        <div class="devices-strip">
            <div class="device-card" data-aos="zoom-in">
                <i class="ri-tv-2-fill device-ic"></i>
                <span>Smart TV</span>
            </div>
            <div class="device-card" data-aos="zoom-in" data-aos-delay="60">
                <i class="ri-tv-fill device-ic"></i>
                <span>Firestick</span>
            </div>
            <div class="device-card" data-aos="zoom-in" data-aos-delay="120">
                <i class="ri-smartphone-fill device-ic"></i>
                <span>Android / iOS</span>
            </div>
            <div class="device-card" data-aos="zoom-in" data-aos-delay="180">
                <i class="ri-mac-fill device-ic"></i>
                <span>Laptop / PC</span>
            </div>
            <div class="device-card" data-aos="zoom-in" data-aos-delay="240">
                <i class="ri-tablet-fill device-ic"></i>
                <span>Tablet / iPad</span>
            </div>
        </div>
    </div>
</section>

{{-- ═══ HOW IT WORKS ═══ --}}
<section class="sec sec-alt">
    <div class="wrap">
        <div class="sec-top" data-aos="fade-up">
            <span class="sec-tag"><i class="ri-route-fill"></i> Getting Started</span>
            <h2 class="sec-h">Up and Running in<br><em>Under 5 Minutes</em></h2>
            <p class="sec-d">No technical skills required. Follow these four simple steps and start streaming.</p>
        </div>
        <div class="steps-grid" data-aos="fade-up" data-aos-delay="100">
            <div class="step-card">
                <div class="step-num">1</div>
                <h4>Choose Your Plan</h4>
                <p>Browse our transparent pricing and pick the subscription that fits your needs and budget.</p>
            </div>
            <div class="step-card">
                <div class="step-num">2</div>
                <h4>Secure Payment</h4>
                <p>Pay safely with credit card, PayPal, or cryptocurrency. All transactions are SSL encrypted.</p>
            </div>
            <div class="step-card">
                <div class="step-num">3</div>
                <h4>Receive Credentials</h4>
                <p>Your M3U URL and Xtream codes arrive in your email inbox within minutes of payment.</p>
            </div>
            <div class="step-card">
                <div class="step-num">4</div>
                <h4>Start Streaming</h4>
                <p>Enter your credentials in any compatible app and enjoy 40,000+ channels instantly.</p>
            </div>
        </div>
    </div>
</section>

{{-- ═══ TESTIMONIALS ═══ --}}
@if($testimonials->count() > 0)
<section class="sec">
    <div class="wrap">
        <div class="sec-top" data-aos="fade-up">
            <span class="sec-tag"><i class="ri-star-fill"></i> Customer Reviews</span>
            <h2 class="sec-h">What Our Customers Say<br>About <em>Live IPTV Now</em></h2>
        </div>
        <div class="reviews-grid">
            @foreach($testimonials->take(6) as $t)
            <div class="review-card" data-aos="fade-up" data-aos-delay="{{ $loop->index * 80 }}">
                <div class="rev-stars">
                    @for($i = 0; $i < ($t->rating ?? 5); $i++)<i class="ri-star-fill"></i>@endfor
                </div>
                <p class="rev-text">"{{ $t->content }}"</p>
                <div class="rev-author">
                    <div class="rev-av">{{ strtoupper(substr($t->name, 0, 2)) }}</div>
                    <div>
                        <div class="rev-name">{{ $t->name }}</div>
                        <div class="rev-loc">{{ $t->location ?? 'Verified Customer' }}</div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ═══ FAQ PREVIEW ═══ --}}
@if($faqs->count() > 0)
<section class="sec sec-alt">
    <div class="wrap">
        <div class="sec-top" data-aos="fade-up">
            <span class="sec-tag"><i class="ri-question-fill"></i> FAQ</span>
            <h2 class="sec-h">Frequently Asked<br><em>Questions</em></h2>
            <p class="sec-d">Quick answers to the most common questions about our service.</p>
        </div>
        <div class="faq-wrap" style="max-width:780px;margin:0 auto;" data-aos="fade-up">
            @foreach($faqs->take(6) as $faq)
            <div class="fq {{ $loop->first ? 'on' : '' }}">
                <button class="fq-q" aria-expanded="{{ $loop->first ? 'true' : 'false' }}">
                    <span>{{ $faq->question }}</span>
                    <i class="ri-arrow-down-s-line"></i>
                </button>
                <div class="fq-a">{{ $faq->answer }}</div>
            </div>
            @endforeach
        </div>
        <div style="text-align:center;margin-top:36px;" data-aos="fade-up">
            <a href="{{ route('faq') }}" class="btn btn-outline">View All FAQs <i class="ri-arrow-right-line"></i></a>
        </div>
    </div>
</section>
@endif

{{-- ═══ CTA BANNER ═══ --}}
<section class="cta-banner">
    <div class="wrap cta-inner">
        <h2 data-aos="fade-up">Ready to Start Streaming?</h2>
        <p data-aos="fade-up" data-aos-delay="80">Join 100,000+ happy customers worldwide. Get instant access to 40,000+ channels, movies, and shows today.</p>
        <div class="cta-btns" data-aos="fade-up" data-aos-delay="160">
            <a href="{{ route('packages.index') }}" class="btn btn-white btn-lg">
                <i class="ri-play-fill"></i> View All Plans
            </a>
            <a href="{{ route('contact') }}" class="btn btn-lg" style="background:rgba(255,255,255,0.12);color:#fff;border:2px solid rgba(255,255,255,0.3);">
                <i class="ri-customer-service-2-line"></i> Talk to Support
            </a>
        </div>
        <div class="cta-trust-strip" data-aos="fade-up" data-aos-delay="240">
            <div class="cta-trust-item"><i class="ri-shield-check-fill"></i> SSL Secured</div>
            <div class="cta-trust-item"><i class="ri-flashlight-fill"></i> Instant Delivery</div>
            <div class="cta-trust-item"><i class="ri-time-fill"></i> 99.9% Uptime</div>
            <div class="cta-trust-item"><i class="ri-refund-2-fill"></i> 24h Money Back</div>
            <div class="cta-trust-item"><i class="ri-customer-service-2-fill"></i> 24/7 Support</div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
// Pricing tab switching
document.querySelectorAll('.pk-tab').forEach(tab => {
    tab.addEventListener('click', function() {
        const dur = this.dataset.tab;

        document.querySelectorAll('.pk-tab').forEach(t => t.classList.remove('active'));
        this.classList.add('active');

        document.querySelectorAll('.pk-panel').forEach(panel => {
            if (panel.dataset.duration === dur) {
                panel.style.display = 'grid';
                panel.style.animation = 'fadein 0.4s ease';
            } else {
                panel.style.display = 'none';
            }
        });
    });
});
</script>
@endpush
