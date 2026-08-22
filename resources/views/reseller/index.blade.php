@extends('layouts.app')
@section('title', 'Become a Reseller - Live IPTV Now')

@section('content')
@include('layouts.page-hero', [
    'heroImage'      => '/page_hero_bg.png',
    'breadcrumb'     => 'Reseller Program',
    'badge'          => 'EARN 60%+ PROFIT MARGIN',
    'badgeIcon'      => 'ri-flashlight-fill',
    'title'          => 'Start Your Own',
    'accent'         => 'IPTV Business',
    'subtitle'       => 'Wholesale prices, white-label panel, and 24/7 dedicated support. We provide the infrastructure; you keep 100% of the profits.',
    'desc'           => 'Join our network of 500+ successful resellers. Buy credits in bulk and sell at your own prices. No technical knowledge required — we handle everything.',
    'highlights' => [
        ['icon' => 'ri-dashboard-3-line',  'text' => 'Branded Multi-DNS Panel',          'sub' => 'Manage users, lines, and trials easily'],
        ['icon' => 'ri-exchange-dollar-line', 'text' => 'Best Rates in the Market',        'sub' => 'Higher margins for your business'],
        ['icon' => 'ri-shield-star-line',    'text' => 'Premium 4K Infrastructure',        'sub' => 'Anti-freeze technology included'],
    ],
    'ctaPrimary'     => 'View Packages',
    'ctaPrimaryUrl'  => '#reseller-packages',
    'ctaPrimaryIcon' => 'ri-price-tag-3-line',
    'ctaGhost'       => 'Contact Sales',
    'ctaGhostUrl'    => route('contact'),
    'ctaGhostIcon'   => 'ri-whatsapp-line',
    'stats' => [
        ['icon' => 'ri-group-line',       'text' => '500+ Resellers'],
        ['icon' => 'ri-global-line',      'text' => 'Global Coverage'],
        ['icon' => 'ri-timer-flash-line', 'text' => 'Instant Setup'],
        ['icon' => 'ri-customer-service-2-line', 'text' => '24/7 Support'],
    ],
])

<!-- Why Become a Reseller -->
<section class="rs-section">
    <div class="wrap">
        <div class="rs-header" data-aos="fade-up">
            <span class="rs-tag">OPPORTUNITY</span>
            <h2 class="rs-title">Why Become a <span>Reseller?</span></h2>
            <p class="rs-desc">Everything you need to launch a profitable streaming brand.</p>
        </div>

        <div class="rs-grid">
            @php
                $benefits = [
                    ['icon' => 'ri-money-dollar-box-line', 'color' => '#f59e0b', 'bg' => '#fef3c7', 'title' => 'High Profit Margins', 'text' => 'Purchase credits at wholesale rates and sell them at retail prices. Keep up to 60-70% profit.'],
                    ['icon' => 'ri-layout-3-line', 'color' => '#2563eb', 'bg' => '#dbeafe', 'title' => 'Full White Label', 'text' => 'Branded dashboard with your logo and own DNS. Your customers will never know we exist.'],
                    ['icon' => 'ri-flashlight-line', 'color' => '#059669', 'bg' => '#d1fae5', 'title' => 'Instant Automation', 'text' => 'Generate lines, trials, and manage renewals instantly through our powerful reseller panel.'],
                    ['icon' => 'ri-database-line', 'color' => '#7c3aed', 'bg' => '#ede9fe', 'title' => 'Flexible Credit System', 'text' => 'Credits never expire. Buy them in bulk and use them whenever you have a new customer.'],
                    ['icon' => 'ri-headphone-line', 'color' => '#dc2626', 'bg' => '#fee2e2', 'title' => 'Priority Support', 'text' => 'Dedicated technical support team for resellers to help with setup, migration, and troubleshooting.'],
                    ['icon' => 'ri-tv-2-line', 'color' => '#0d9488', 'bg' => '#ccfbf1', 'title' => 'Premium 4K Content', 'text' => 'Offer 20,000+ live channels and 50,000+ VODs in crystal clear 4K & HD quality.'],
                ];
            @endphp

            @foreach($benefits as $benefit)
            <div class="rs-card" data-aos="fade-up">
                <div class="rs-card-icon" style="background-color: {{ $benefit['bg'] }}; color: {{ $benefit['color'] }}">
                    <i class="{{ $benefit['icon'] }}"></i>
                </div>
                <h3 class="rs-card-title">{{ $benefit['title'] }}</h3>
                <p class="rs-card-text">{{ $benefit['text'] }}</p>
                <div class="rs-card-border" style="background: {{ $benefit['color'] }}"></div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- How it Works -->
<section class="rs-steps-section">
    <div class="wrap">
        <div class="rs-header" data-aos="fade-up">
            <span class="rs-tag">HOW IT WORKS</span>
            <h2 class="rs-title">Launch in <span>3 Easy Steps</span></h2>
        </div>

        <div class="rs-steps-grid">
            <div class="rs-step-item" data-aos="fade-right">
                <div class="rs-step-content">
                    <div class="rs-step-num">01</div>
                    <div class="rs-step-icon"><i class="ri-shopping-bag-3-line"></i></div>
                    <h3>Purchase Credits</h3>
                    <p>Choose a package below to get your reseller panel and credits.</p>
                </div>
            </div>
            
            <div class="rs-step-line d-desktop"></div>

            <div class="rs-step-item" data-aos="fade-up">
                <div class="rs-step-content">
                    <div class="rs-step-num">02</div>
                    <div class="rs-step-icon"><i class="ri-user-settings-line"></i></div>
                    <h3>Setup Your Panel</h3>
                    <p>Add your branding and start generating lines for your customers.</p>
                </div>
            </div>

            <div class="rs-step-line d-desktop"></div>

            <div class="rs-step-item" data-aos="fade-left">
                <div class="rs-step-content">
                    <div class="rs-step-num">03</div>
                    <div class="rs-step-icon"><i class="ri-money-dollar-circle-line"></i></div>
                    <h3>Earn & Grow</h3>
                    <p>Set your own prices and scale your business with full control.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Pricing -->
<section class="rs-pricing-section" id="reseller-packages">
    <div class="wrap">
        <div class="rs-header" data-aos="fade-up">
            <span class="rs-tag">PRICING</span>
            <h2 class="rs-title">Reseller <span>Packages</span></h2>
            <p class="rs-desc">Select the perfect starting point for your business.</p>
        </div>

        @if($packages->count() > 0)
        <div class="rs-pricing-grid">
            @foreach($packages as $package)
            <div class="rs-price-card {{ $package->is_featured ? 'featured' : '' }}" data-aos="zoom-in">
                @if($package->is_featured)
                <div class="rs-popular-tag">MOST POPULAR</div>
                @endif
                <div class="rs-price-header">
                    <h3 class="rs-price-name">{{ $package->name }}</h3>
                    <div class="rs-price-amount">
                        <span class="currency">$</span>
                        <span class="number">{{ number_format($package->price, 0) }}</span>
                    </div>
                </div>

                <ul class="rs-price-features">
                    @php 
                        $features = json_decode($package->features_list) ?? []; 
                    @endphp
                    @foreach($features as $feat)
                    <li><i class="ri-checkbox-circle-fill"></i> {{ $feat }}</li>
                    @endforeach
                    @if(empty($features))
                        <li><i class="ri-checkbox-circle-fill"></i> Branded Multi-DNS Panel</li>
                        <li><i class="ri-checkbox-circle-fill"></i> Credits Never Expire</li>
                        <li><i class="ri-checkbox-circle-fill"></i> Unlimited Trials</li>
                        <li><i class="ri-checkbox-circle-fill"></i> 24/7 Priority Support</li>
                    @endif
                </ul>

                <a href="{{ route('checkout.show', $package->slug) }}" class="rs-price-btn">
                    Get Started <i class="ri-arrow-right-line"></i>
                </a>
            </div>
            @endforeach
        </div>
        @else
        <div class="rs-empty">
            <i class="ri-folder-info-line"></i>
            <h3>No packages available</h3>
            <p>Please contact support for custom reseller pricing.</p>
            <a href="{{ route('contact') }}" class="btn-primary">Contact Support</a>
        </div>
        @endif
    </div>
</section>

@push('styles')
<style>
    :root {
        --rs-bg-white: #ffffff;
        --rs-bg-soft: #f8fafc;
        --rs-primary: #2563eb;
        --rs-text-bold: #0f172a;
        --rs-text-muted: #64748b;
        --rs-card-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
        --rs-card-shadow-hover: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }

    .rs-section {
        padding: 80px 0;
        background-color: var(--rs-bg-white);
    }

    .rs-header {
        text-align: center;
        margin-bottom: 50px;
    }

    .rs-tag {
        display: inline-block;
        padding: 6px 14px;
        background: rgba(37, 99, 235, 0.08);
        color: var(--rs-primary);
        font-weight: 800;
        font-size: 0.75rem;
        border-radius: 100px;
        margin-bottom: 12px;
        letter-spacing: 1px;
    }

    .rs-title {
        font-size: clamp(2rem, 5vw, 2.8rem);
        color: var(--rs-text-bold);
        margin-bottom: 16px;
        font-weight: 800;
    }

    .rs-title span {
        color: var(--rs-primary);
    }

    .rs-desc {
        color: var(--rs-text-muted);
        max-width: 600px;
        margin: 0 auto;
        font-size: 1.05rem;
    }

    /* Card Layout */
    .rs-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        gap: 24px;
    }

    .rs-card {
        background: var(--rs-bg-white);
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        padding: 40px;
        position: relative;
        transition: all 0.3s ease;
        box-shadow: var(--rs-card-shadow);
        overflow: hidden;
    }

    .rs-card:hover {
        transform: translateY(-8px);
        box-shadow: var(--rs-card-shadow-hover);
        border-color: #cbd5e1;
    }

    .rs-card-icon {
        width: 60px;
        height: 60px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        margin-bottom: 24px;
        transition: transform 0.3s ease;
    }

    .rs-card:hover .rs-card-icon {
        transform: scale(1.1);
    }

    .rs-card-title {
        font-size: 1.25rem;
        color: var(--rs-text-bold);
        margin-bottom: 10px;
        font-weight: 700;
    }

    .rs-card-text {
        color: var(--rs-text-muted);
        line-height: 1.6;
        font-size: 0.95rem;
    }

    .rs-card-border {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 0%;
        height: 4px;
        transition: width 0.3s ease;
    }

    .rs-card:hover .rs-card-border {
        width: 100%;
    }

    /* Steps */
    .rs-steps-section {
        padding: 80px 0;
        background-color: var(--rs-bg-soft);
    }

    .rs-steps-grid {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 0;
        max-width: 900px;
        margin: 0 auto;
    }

    .rs-step-item {
        flex: 1;
        position: relative;
        padding: 20px;
    }

    .rs-step-num {
        font-size: 3rem;
        font-weight: 900;
        color: rgba(37, 99, 235, 0.08);
        position: absolute;
        top: 0;
        left: 50%;
        transform: translateX(-50%);
        z-index: 1;
    }

    .rs-step-content {
        position: relative;
        z-index: 2;
        text-align: center;
    }

    .rs-step-icon {
        width: 70px;
        height: 70px;
        background: #fff;
        border: 2px solid #e2e8f0;
        color: var(--rs-primary);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        margin: 0 auto 20px;
        box-shadow: var(--rs-card-shadow);
        transition: all 0.3s ease;
    }

    .rs-step-item:hover .rs-step-icon {
        background: var(--rs-primary);
        color: #fff;
        border-color: var(--rs-primary);
    }

    .rs-step-item h3 {
        color: var(--rs-text-bold);
        font-size: 1.2rem;
        margin-bottom: 8px;
        font-weight: 700;
    }

    .rs-step-item p {
        color: var(--rs-text-muted);
        font-size: 0.9rem;
    }

    .rs-step-line {
        width: 100px;
        height: 2px;
        background: #e2e8f0;
        margin: 0 10px;
        margin-top: -40px;
    }

    /* Pricing Card */
    .rs-pricing-section {
        padding: 80px 0 140px;
        background-color: var(--rs-bg-white);
    }

    .rs-pricing-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(290px, 1fr));
        gap: 24px;
        max-width: 960px;
        margin: 0 auto;
    }

    .rs-price-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 24px;
        padding: 40px 30px;
        text-align: center;
        transition: all 0.3s ease;
        position: relative;
        box-shadow: var(--rs-card-shadow);
    }

    .rs-price-card:hover {
        transform: scale(1.02);
        box-shadow: var(--rs-card-shadow-hover);
        border-color: var(--rs-primary);
    }

    .rs-price-card.featured {
        border-color: var(--rs-primary);
        background: linear-gradient(180deg, #f0f7ff 0%, #ffffff 100%);
    }

    .rs-popular-tag {
        position: absolute;
        top: 20px;
        left: 50%;
        transform: translateX(-50%);
        background: #0f172a;
        color: #fff;
        padding: 4px 14px;
        border-radius: 100px;
        font-size: 0.65rem;
        font-weight: 800;
        letter-spacing: 1px;
    }

    .rs-price-name {
        color: var(--rs-text-muted);
        font-size: 0.9rem;
        font-weight: 800;
        letter-spacing: 2px;
        margin-bottom: 20px;
    }

    .rs-price-amount {
        display: flex;
        justify-content: center;
        align-items: flex-start;
        color: var(--rs-text-bold);
        margin-bottom: 30px;
    }

    .rs-price-amount .currency { font-size: 1.5rem; font-weight: 700; margin-top: 10px; margin-right: 4px; }
    .rs-price-amount .number { font-size: 3.5rem; font-weight: 800; line-height: 1; }

    .rs-price-features { list-style: none; padding: 0; margin: 0 0 30px; text-align: left; }
    .rs-price-features li { color: #475569; margin-bottom: 12px; font-size: 0.95rem; display: flex; align-items: center; gap: 12px; }
    .rs-price-features i { color: #10b981; font-size: 1.1rem; }

    .rs-price-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        background: var(--rs-bg-soft);
        color: var(--rs-text-bold);
        padding: 16px;
        border-radius: 14px;
        text-decoration: none;
        font-weight: 700;
        transition: all 0.3s ease;
        border: 1px solid #e2e8f0;
    }

    .featured .rs-price-btn {
        background: var(--rs-primary);
        color: #fff;
        border: none;
    }

    .rs-price-btn:hover {
        background: var(--rs-text-bold);
        color: #fff;
        transform: translateY(-2px);
    }

    .d-desktop { display: block; }

    @media (max-width: 768px) {
        .rs-steps-grid { flex-direction: column; gap: 30px; }
        .d-desktop { display: none; }
        .rs-grid { grid-template-columns: 1fr; }
        .rs-price-card.featured { transform: none; }
    }
</style>
@endpush
@endsection
