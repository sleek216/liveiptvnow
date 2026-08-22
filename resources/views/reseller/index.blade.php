@extends('layouts.app')
@section('title', 'Become an IPTV Reseller — White Label Panel & Bulk Credits | Live IPTV Now')
@section('meta_description', 'Start your own profitable IPTV business today. Buy IPTV credits in bulk with white-label panel, branded DNS, 40,000+ channels, 24/7 priority support and 60%+ profit margins.')

@section('content')
{{-- ═══════════════════════════════════════════════════════════
     HERO SECTION
     ═══════════════════════════════════════════════════════════ --}}
@include('layouts.page-hero', [
    'heroImage'      => '/page_hero_bg.png',
    'breadcrumb'     => 'Reseller Program',
    'badge'          => 'EARN 60%+ PROFIT MARGINS',
    'badgeIcon'      => 'ri-fire-fill',
    'title'          => 'Start Your Own',
    'accent'         => 'IPTV Streaming Business',
    'subtitle'       => 'Get wholesale credit rates, full white-label branded panel, multi-DNS, and 24/7 dedicated engineering support. You keep 100% of the profits.',
    'desc'           => 'Join our global network of 500+ active resellers. Generate lines, trials, and sub-resellers instantly with zero technical headache — our enterprise infrastructure powers your brand.',
    'highlights' => [
        ['icon' => 'ri-shield-star-line',     'text' => 'Full White-Label Multi-DNS Panel',       'sub' => 'Your domain, your brand — 100% hidden backend'],
        ['icon' => 'ri-money-dollar-circle-line', 'text' => 'High Profit Margins (Up to 70%)',      'sub' => 'Buy credits wholesale, sell at your custom retail prices'],
        ['icon' => 'ri-infinite-line',        'text' => 'Credits Never Expire',                  'sub' => 'Use credits on demand whenever you sign new clients'],
        ['icon' => 'ri-flashlight-line',      'text' => 'Anti-Freeze™ 4K/FHD Stream Network',    'sub' => '40,000+ live channels and 100,000+ movies/series'],
    ],
    'ctaPrimary'     => 'Explore Reseller Packages',
    'ctaPrimaryUrl'  => '#reseller-packages',
    'ctaPrimaryIcon' => 'ri-price-tag-3-line',
    'ctaGhost'       => 'Reseller Inquiries',
    'ctaGhostUrl'    => route('contact'),
    'ctaGhostIcon'   => 'ri-chat-voice-line',
    'stats' => [
        ['icon' => 'ri-group-line',              'text' => '500+ Active Resellers'],
        ['icon' => 'ri-server-line',             'text' => '99.99% Server Uptime'],
        ['icon' => 'ri-flashlight-line',         'text' => 'Instant Panel Setup'],
        ['icon' => 'ri-customer-service-2-line', 'text' => '24/7 Priority Support'],
    ],
])

{{-- ═══════════════════════════════════════════════════════════
     TRUST STRIP
     ═══════════════════════════════════════════════════════════ --}}
<div class="rs-trust-strip">
    <div class="wrap">
        <div class="rs-trust-inner">
            <div class="rs-ts-item"><i class="ri-shield-check-fill"></i> 100% White Label Branded Panel</div>
            <div class="rs-ts-sep"></div>
            <div class="rs-ts-item"><i class="ri-flashlight-fill"></i> Instant Automatic Activation</div>
            <div class="rs-ts-sep"></div>
            <div class="rs-ts-item"><i class="ri-calendar-check-fill"></i> Credits Never Expire</div>
            <div class="rs-ts-sep"></div>
            <div class="rs-ts-item"><i class="ri-gift-fill"></i> Unlimited 24h Free Trials</div>
            <div class="rs-ts-sep"></div>
            <div class="rs-ts-item"><i class="ri-headphone-fill"></i> Dedicated Reseller Manager</div>
        </div>
    </div>
</div>

{{-- ═══════════════════════════════════════════════════════════
     WHY BECOME A RESELLER (BENEFITS)
     ═══════════════════════════════════════════════════════════ --}}
<section class="rs-section rs-bg-white">
    <div class="wrap">
        <div class="rs-header" data-aos="fade-up">
            <span class="rs-pill-badge"><i class="ri-sparkling-fill"></i> BUSINESS OPPORTUNITY</span>
            <h2 class="rs-title">Why Become an <span>IPTV Reseller?</span></h2>
            <p class="rs-desc">Everything you need to launch, scale, and automate your own profitable IPTV streaming brand with minimal startup capital.</p>
        </div>

        <div class="rs-grid-benefits">
            @php
                $benefits = [
                    [
                        'icon' => 'ri-money-dollar-box-line', 
                        'color' => '#2563eb', 
                        'bg' => 'rgba(37,99,235,0.08)', 
                        'badge' => 'High ROI',
                        'title' => 'Massive Profit Margins', 
                        'text' => 'Buy credits in bulk starting at wholesale rates and sell standard subscriptions at $10–$20/month. Keep 60% to 80% net margin on every sale.'
                    ],
                    [
                        'icon' => 'ri-layout-3-line', 
                        'color' => '#059669', 
                        'bg' => 'rgba(5,150,105,0.08)', 
                        'badge' => 'White Label',
                        'title' => 'Custom Branded Panel & DNS', 
                        'text' => 'You get a private dashboard branded with your name and custom DNS domains. Your customers never see Live IPTV Now — only your brand.'
                    ],
                    [
                        'icon' => 'ri-flashlight-line', 
                        'color' => '#f59e0b', 
                        'bg' => 'rgba(245,158,11,0.08)', 
                        'badge' => 'Automated',
                        'title' => 'Instant Line Creation', 
                        'text' => 'Generate subscription accounts, create free trials, reset lines, and manage renewals in real time in seconds through your web control panel.'
                    ],
                    [
                        'icon' => 'ri-infinite-line', 
                        'color' => '#7c3aed', 
                        'bg' => 'rgba(124,58,237,0.08)', 
                        'badge' => 'No Risk',
                        'title' => 'Non-Expiring Credits', 
                        'text' => 'Credits have zero expiration date. Purchase packages now and spend them over days, months, or years as you onboard new customers.'
                    ],
                    [
                        'icon' => 'ri-tv-2-line', 
                        'color' => '#dc2626', 
                        'bg' => 'rgba(220,38,38,0.08)', 
                        'badge' => 'Top Quality',
                        'title' => '40,000+ Channels & 4K VOD', 
                        'text' => 'Give your customers access to crystal clear 4K/FHD live sports, premium movies, local worldwide channels, and anti-buffering load balancers.'
                    ],
                    [
                        'icon' => 'ri-customer-service-2-line', 
                        'color' => '#0284c7', 
                        'bg' => 'rgba(2,132,199,0.08)', 
                        'badge' => '24/7 Support',
                        'title' => 'Dedicated Reseller Support', 
                        'text' => 'Direct VIP access to our engineering team for stream assistance, server monitoring, panel troubleshooting, and migration help.'
                    ],
                ];
            @endphp

            @foreach($benefits as $benefit)
            <div class="rs-benefit-card" data-aos="fade-up" data-aos-delay="{{ $loop->index * 60 }}">
                <div class="rs-bcard-top">
                    <div class="rs-bcard-icon" style="background-color: {{ $benefit['bg'] }}; color: {{ $benefit['color'] }}">
                        <i class="{{ $benefit['icon'] }}"></i>
                    </div>
                    <span class="rs-bcard-tag" style="color: {{ $benefit['color'] }}; background: {{ $benefit['bg'] }}">{{ $benefit['badge'] }}</span>
                </div>
                <h3 class="rs-bcard-title">{{ $benefit['title'] }}</h3>
                <p class="rs-bcard-text">{{ $benefit['text'] }}</p>
                <div class="rs-bcard-accent" style="background: {{ $benefit['color'] }}"></div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════
     INTERACTIVE PROFIT CALCULATOR
     ═══════════════════════════════════════════════════════════ --}}
<section class="rs-calc-section">
    <div class="wrap">
        <div class="rs-header" data-aos="fade-up">
            <span class="rs-pill-badge"><i class="ri-calculator-line"></i> ROI SIMULATOR</span>
            <h2 class="rs-title">Calculate Your <span>Reseller Earnings</span></h2>
            <p class="rs-desc">See how much profit you can generate with our wholesale IPTV credit packages.</p>
        </div>

        <div class="rs-calc-box" data-aos="fade-up">
            <div class="rs-calc-grid">
                <div class="rs-calc-controls">
                    <h3 class="rs-calc-heading"><i class="ri-equalizer-line"></i> Select Your Parameters</h3>

                    {{-- Credit Pack selector --}}
                    <div class="rs-calc-group">
                        <label class="rs-calc-label">Choose Credit Package:</label>
                        <div class="rs-credit-options">
                            <button type="button" class="rs-opt-btn active" data-credits="100" data-cost="220">
                                <strong>100 Credits</strong>
                                <span>$220 ($2.20/ea)</span>
                            </button>
                            <button type="button" class="rs-opt-btn" data-credits="500" data-cost="1100">
                                <strong>500 Credits</strong>
                                <span>$1,100 ($2.20/ea)</span>
                            </button>
                            <button type="button" class="rs-opt-btn" data-credits="1000" data-cost="2400">
                                <strong>1,000 Credits</strong>
                                <span>$2,400 ($2.40/ea)</span>
                            </button>
                        </div>
                    </div>

                    {{-- Selling Price Range --}}
                    <div class="rs-calc-group">
                        <div class="rs-slider-header">
                            <label class="rs-calc-label" for="resellPriceRange">Your Retail Selling Price per Month:</label>
                            <span class="rs-slider-val" id="resellPriceDisplay">$15 / month</span>
                        </div>
                        <input type="range" class="rs-slider" id="resellPriceRange" min="8" max="25" step="1" value="15">
                        <div class="rs-slider-ticks">
                            <span>$8</span>
                            <span>$12</span>
                            <span>$15 (Recommended)</span>
                            <span>$20</span>
                            <span>$25</span>
                        </div>
                    </div>
                </div>

                {{-- Live Results Projection --}}
                <div class="rs-calc-results">
                    <div class="rs-calc-result-header">
                        <h4>Projected Profit Overview</h4>
                        <span class="rs-calc-badge"><i class="ri-funds-fill"></i> High Return</span>
                    </div>

                    <div class="rs-result-metrics">
                        <div class="rs-metric-item">
                            <span class="lbl">Wholesale Investment</span>
                            <span class="val" id="resellCostVal">$220</span>
                        </div>
                        <div class="rs-metric-item">
                            <span class="lbl">Gross Sales Revenue</span>
                            <span class="val" id="resellRevenueVal">$1,500</span>
                        </div>
                        <div class="rs-metric-item highlight">
                            <span class="lbl">Estimated Net Profit</span>
                            <span class="val profit" id="resellProfitVal">+$1,280</span>
                        </div>
                        <div class="rs-metric-item">
                            <span class="lbl">Return On Investment (ROI)</span>
                            <span class="val roi" id="resellRoiVal">+582%</span>
                        </div>
                    </div>

                    <a href="#reseller-packages" class="rs-calc-cta">
                        Claim This Package Now <i class="ri-arrow-right-line"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════
     HOW IT WORKS (3 EASY STEPS)
     ═══════════════════════════════════════════════════════════ --}}
<section class="rs-steps-section">
    <div class="wrap">
        <div class="rs-header" data-aos="fade-up">
            <span class="rs-pill-badge"><i class="ri-road-map-line"></i> QUICK SETUP</span>
            <h2 class="rs-title">Launch in <span>3 Easy Steps</span></h2>
            <p class="rs-desc">Go from zero to a fully operational IPTV business in under 15 minutes.</p>
        </div>

        <div class="rs-steps-grid">
            <div class="rs-step-card" data-aos="fade-up" data-aos-delay="0">
                <div class="rs-step-top">
                    <span class="rs-step-badge">STEP 01</span>
                    <div class="rs-step-icon"><i class="ri-shopping-bag-3-line"></i></div>
                </div>
                <h3>Purchase Reseller Credits</h3>
                <p>Choose your starting credit bundle (100, 500, or 1000 credits). Complete checkout securely with instant delivery.</p>
            </div>

            <div class="rs-step-arrow"><i class="ri-arrow-right-line"></i></div>

            <div class="rs-step-card" data-aos="fade-up" data-aos-delay="100">
                <div class="rs-step-top">
                    <span class="rs-step-badge">STEP 02</span>
                    <div class="rs-step-icon"><i class="ri-dashboard-3-line"></i></div>
                </div>
                <h3>Access Your Branded Panel</h3>
                <p>Receive your reseller panel login credentials via email. Connect your custom DNS or use our white-label server links.</p>
            </div>

            <div class="rs-step-arrow"><i class="ri-arrow-right-line"></i></div>

            <div class="rs-step-card" data-aos="fade-up" data-aos-delay="200">
                <div class="rs-step-top">
                    <span class="rs-step-badge">STEP 03</span>
                    <div class="rs-step-icon"><i class="ri-money-dollar-circle-line"></i></div>
                </div>
                <h3>Create Lines & Keep Profits</h3>
                <p>Generate Xtream Codes or M3U playlists for your buyers. Set any price you want and retain 100% of the sales earnings.</p>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════
     PRICING PACKAGES SECTION
     ═══════════════════════════════════════════════════════════ --}}
<section class="rs-pricing-section" id="reseller-packages">
    <div class="wrap">
        <div class="rs-header" data-aos="fade-up">
            <span class="rs-pill-badge"><i class="ri-price-tag-3-fill"></i> WHOLESALE PRICING</span>
            <h2 class="rs-title">Reseller <span>Packages</span></h2>
            <p class="rs-desc">Select the ideal credit bundle for your business scale. No recurring monthly fees — top up credits whenever needed.</p>
        </div>

        @if($packages->count() > 0)
        @php
            // Check if any package is explicitly featured or if middle one should be featured
            $featuredCount = $packages->where('is_featured', true)->count();
            $popularCount = $packages->where('is_popular', true)->count();
        @endphp
        <div class="rs-pricing-grid">
            @foreach($packages as $index => $package)
            @php
                // Extract credit count from name
                preg_match('/(\d+)/', $package->name, $matches);
                $credits = !empty($matches[1]) ? (int)$matches[1] : 0;
                $perCredit = $credits > 0 ? round($package->price / $credits, 2) : round($package->price / 100, 2);

                // Smart badge decision to avoid duplicate "Most Popular" badges on all cards
                $isFeaturedCard = false;
                $badgeText = null;
                $badgeIcon = 'ri-star-fill';

                if ($packages->count() === 3) {
                    if ($index === 0) {
                        $badgeText = 'STARTER CHOICE';
                        $badgeIcon = 'ri-flashlight-line';
                    } elseif ($index === 1) {
                        $isFeaturedCard = true;
                        $badgeText = 'MOST POPULAR';
                        $badgeIcon = 'ri-fire-fill';
                    } elseif ($index === 2) {
                        $badgeText = 'BEST VALUE / PRO';
                        $badgeIcon = 'ri-vip-crown-fill';
                    }
                } else {
                    if ($package->is_popular || ($package->is_featured && $featuredCount === 1)) {
                        $isFeaturedCard = true;
                        $badgeText = 'MOST POPULAR';
                        $badgeIcon = 'ri-fire-fill';
                    } elseif ($package->is_featured) {
                        $badgeText = 'FEATURED PACK';
                        $badgeIcon = 'ri-star-fill';
                    }
                }
            @endphp

            <div class="rs-price-card {{ $isFeaturedCard ? 'featured-card' : '' }}" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                {{-- Clean floating top badge --}}
                @if($badgeText)
                <div class="rs-card-badge {{ $isFeaturedCard ? 'rs-badge-highlight' : 'rs-badge-subtle' }}">
                    <i class="{{ $badgeIcon }}"></i> {{ $badgeText }}
                </div>
                @endif

                {{-- Header / Credits Title --}}
                <div class="rs-price-head">
                    <div class="rs-credit-title-pill">
                        <i class="ri-coins-line"></i>
                        <span>{{ $package->name }}</span>
                    </div>

                    {{-- Main Price --}}
                    <div class="rs-price-amount-box">
                        <span class="currency">$</span>
                        <span class="number">{{ number_format($package->price, 0) }}</span>
                        <span class="period">/ one-time</span>
                    </div>

                    {{-- Per credit rate & profit projection --}}
                    <div class="rs-rate-pill">
                        <i class="ri-check-line"></i> Only <strong>${{ number_format($perCredit, 2) }}</strong> per credit
                    </div>
                </div>

                <div class="rs-card-hr"></div>

                {{-- Feature List --}}
                <ul class="rs-features-list">
                    @php 
                        $features = json_decode($package->features_list) ?? []; 
                    @endphp
                    @if(!empty($features))
                        @foreach($features as $feat)
                        <li><i class="ri-checkbox-circle-fill"></i> <span>{{ $feat }}</span></li>
                        @endforeach
                    @elseif($package->features && $package->features->isNotEmpty())
                        @foreach($package->features as $feat)
                        <li><i class="ri-checkbox-circle-fill"></i> <span>{{ $feat->name }}</span></li>
                        @endforeach
                    @else
                        <li><i class="ri-checkbox-circle-fill"></i> <span>Full Branded Multi-DNS Reseller Panel</span></li>
                        <li><i class="ri-checkbox-circle-fill"></i> <span>Credits Never Expire (Lifetime validity)</span></li>
                        <li><i class="ri-checkbox-circle-fill"></i> <span>Unlimited 24-Hour Free Test Trials</span></li>
                        <li><i class="ri-checkbox-circle-fill"></i> <span>Create &amp; Manage Sub-Resellers</span></li>
                        <li><i class="ri-checkbox-circle-fill"></i> <span>40,000+ 4K/FHD Live Channels &amp; VOD</span></li>
                        <li><i class="ri-checkbox-circle-fill"></i> <span>Instant Automated Activation</span></li>
                        <li><i class="ri-checkbox-circle-fill"></i> <span>24/7 Dedicated VIP Reseller Support</span></li>
                    @endif
                </ul>

                {{-- CTA Button --}}
                <div class="rs-card-footer">
                    <a href="{{ route('checkout.show', $package->slug) }}" class="rs-buy-btn {{ $isFeaturedCard ? 'rs-btn-featured' : 'rs-btn-standard' }}">
                        <span>Get Started Now</span>
                        <i class="ri-arrow-right-line"></i>
                    </a>

                    <div class="rs-guarantee-note">
                        <i class="ri-shield-check-line"></i> Instant Panel Setup &amp; Delivery
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="rs-empty-box">
            <i class="ri-folder-info-line"></i>
            <h3>No Reseller Packages Found</h3>
            <p>Please contact our sales team directly for custom bulk credit packages and wholesale inquiries.</p>
            <a href="{{ route('contact') }}" class="rs-buy-btn rs-btn-featured" style="display:inline-flex; width:auto; padding:12px 30px;">
                Contact Reseller Support
            </a>
        </div>
        @endif

        {{-- Custom Package Banner --}}
        <div class="rs-custom-banner" data-aos="fade-up">
            <div class="rs-cb-left">
                <div class="rs-cb-icon"><i class="ri-building-4-line"></i></div>
                <div>
                    <h4>Need 2,500+ Credits or Custom Dedicated Server Streams?</h4>
                    <p>We provide enterprise solutions, master reseller panels, and custom load-balanced IPTV streams with bespoke pricing.</p>
                </div>
            </div>
            <a href="{{ route('contact') }}" class="rs-cb-btn">
                <i class="ri-whatsapp-line"></i> Talk to Wholesale Manager
            </a>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════
     RESELLER PANEL FEATURES SHOWCASE
     ═══════════════════════════════════════════════════════════ --}}
<section class="rs-section rs-bg-soft">
    <div class="wrap">
        <div class="rs-header" data-aos="fade-up">
            <span class="rs-pill-badge"><i class="ri-dashboard-2-line"></i> POWERFUL DASHBOARD</span>
            <h2 class="rs-title">What You Get in Your <span>Reseller Panel</span></h2>
            <p class="rs-desc">Industry-standard Xtream Codes dashboard designed for effortless management and maximum uptime.</p>
        </div>

        <div class="rs-panel-grid">
            <div class="rs-panel-card" data-aos="fade-up" data-aos-delay="0">
                <div class="rs-pc-icon"><i class="ri-links-line"></i></div>
                <h4>Custom DNS &amp; Domain</h4>
                <p>Connect your custom domain name or use our rotating anti-block multi-DNS URLs so your users never experience downtime.</p>
            </div>

            <div class="rs-panel-card" data-aos="fade-up" data-aos-delay="50">
                <div class="rs-pc-icon"><i class="ri-user-add-line"></i></div>
                <h4>Sub-Reseller Creation</h4>
                <p>Create sub-reseller accounts under your master panel, set their credit pricing, and build your own reseller distribution network.</p>
            </div>

            <div class="rs-panel-card" data-aos="fade-up" data-aos-delay="100">
                <div class="rs-pc-icon"><i class="ri-timer-line"></i></div>
                <h4>Unlimited 24h Free Trials</h4>
                <p>Generate instant test lines for your potential buyers at zero credit cost. Boost trial-to-paid conversion rates effortlessly.</p>
            </div>

            <div class="rs-panel-card" data-aos="fade-up" data-aos-delay="150">
                <div class="rs-pc-icon"><i class="ri-pulse-line"></i></div>
                <h4>Real-Time Stream Diagnostics</h4>
                <p>Monitor live connections, viewer IPs, active channels, bandwidth, and kill stream or change passwords with one click.</p>
            </div>

            <div class="rs-panel-card" data-aos="fade-up" data-aos-delay="200">
                <div class="rs-pc-icon"><i class="ri-apps-2-line"></i></div>
                <h4>Broad App Compatibility</h4>
                <p>Works natively with IPTV Smarters Pro, TiviMate, XCIPTV, IBO Player, Android, FireStick, Smart TVs, iOS, and MAG boxes.</p>
            </div>

            <div class="rs-panel-card" data-aos="fade-up" data-aos-delay="250">
                <div class="rs-pc-icon"><i class="ri-refresh-line"></i></div>
                <h4>Instant Top-Up &amp; Scalability</h4>
                <p>Never run out of inventory. Top up credits 24/7 with automatic credit delivery added straight to your existing balance.</p>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════
     RESELLER FAQ SECTION
     ═══════════════════════════════════════════════════════════ --}}
<section class="rs-section rs-bg-white">
    <div class="wrap">
        <div class="rs-header" data-aos="fade-up">
            <span class="rs-pill-badge"><i class="ri-questionnaire-line"></i> FAQ</span>
            <h2 class="rs-title">Frequently Asked <span>Questions</span></h2>
            <p class="rs-desc">Everything you need to know about our reseller credits, panel, and rules.</p>
        </div>

        <div class="rs-faq-wrap" data-aos="fade-up">
            @php
                $faqs = [
                    [
                        'q' => 'How does the credit system work?',
                        'a' => 'Credits are your wholesale inventory currency. 1 Credit typically corresponds to 1 Month of subscription (or 3 credits for 3 months, 6 for 6 months, 12 for 1 year). You can create subscriptions in any duration directly from your panel.'
                    ],
                    [
                        'q' => 'Do reseller credits ever expire?',
                        'a' => 'No! Your purchased credits never expire. You can keep them in your account for weeks, months, or years until you create a client line.'
                    ],
                    [
                        'q' => 'Is the reseller panel 100% white label?',
                        'a' => 'Yes. The panel has zero Live IPTV Now branding. You can add your own logo, connect your custom DNS domain, and your clients will never know where the stream originates.'
                    ],
                    [
                        'q' => 'Can I create free trials for my customers?',
                        'a' => 'Yes, our panel allows you to generate unlimited 24-hour test lines at 0 credit cost so you can prove the quality to potential buyers.'
                    ],
                    [
                        'q' => 'Can I create sub-resellers under my panel?',
                        'a' => 'Yes! All our packages (100+ credits) include full sub-reseller privileges. You can create accounts for your own resellers and transfer credits to them at your own rates.'
                    ],
                    [
                        'q' => 'How fast do I get my reseller panel after payment?',
                        'a' => 'Panel activation is instant. As soon as your order is confirmed, your panel URL, username, password, and loaded credits are emailed to you within 5 to 15 minutes.'
                    ]
                ];
            @endphp

            @foreach($faqs as $faq)
            <div class="rs-faq-item">
                <button type="button" class="rs-faq-toggle" aria-expanded="false">
                    <span>{{ $faq['q'] }}</span>
                    <i class="ri-add-line"></i>
                </button>
                <div class="rs-faq-answer">
                    <p>{{ $faq['a'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════
     BOTTOM CTA BANNER
     ═══════════════════════════════════════════════════════════ --}}
<section class="rs-bottom-cta-sec">
    <div class="wrap">
        <div class="rs-bcta-card" data-aos="zoom-in">
            <div class="rs-bcta-content">
                <span class="rs-bcta-tag"><i class="ri-rocket-fill"></i> INSTANT DISPATCH</span>
                <h2>Ready to Start Your IPTV Empire?</h2>
                <p>Join 500+ global entrepreneurs earning recurring monthly income with our white-label reseller infrastructure.</p>
                
                <div class="rs-bcta-btns">
                    <a href="#reseller-packages" class="rs-bcta-primary">
                        <i class="ri-shopping-cart-2-line"></i> Choose Your Package
                    </a>
                    <a href="{{ route('contact') }}" class="rs-bcta-secondary">
                        <i class="ri-chat-voice-line"></i> Contact Reseller Support
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

@push('styles')
<style>
    /* ═══════════════════════════════════════════════════════════
       RESELLER STYLING SYSTEM
       ═══════════════════════════════════════════════════════════ */
    :root {
        --rs-primary: #2563eb;
        --rs-primary-dark: #1d4ed8;
        --rs-primary-light: #3b82f6;
        --rs-primary-glow: rgba(37, 99, 235, 0.18);
        --rs-dark: #0f172a;
        --rs-slate-800: #1e293b;
        --rs-slate-600: #475569;
        --rs-slate-500: #64748b;
        --rs-slate-200: #e2e8f0;
        --rs-slate-100: #f1f5f9;
        --rs-slate-50: #f8fafc;
        --rs-card-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.05), 0 8px 10px -6px rgba(15, 23, 42, 0.03);
        --rs-card-shadow-hover: 0 20px 35px -5px rgba(37, 99, 235, 0.12), 0 12px 16px -6px rgba(37, 99, 235, 0.08);
    }

    .rs-section {
        padding: 84px 0;
        position: relative;
    }

    .rs-bg-white { background-color: #ffffff; }
    .rs-bg-soft { background-color: var(--rs-slate-50); }

    /* Section Header */
    .rs-header {
        text-align: center;
        max-width: 760px;
        margin: 0 auto 54px;
    }

    .rs-pill-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 16px;
        background: rgba(37, 99, 235, 0.08);
        border: 1px solid rgba(37, 99, 235, 0.2);
        color: var(--rs-primary);
        font-weight: 800;
        font-size: 0.75rem;
        border-radius: 999px;
        margin-bottom: 14px;
        letter-spacing: 1.5px;
        text-transform: uppercase;
    }

    .rs-title {
        font-size: clamp(2rem, 4vw, 2.75rem);
        color: var(--rs-dark);
        margin-bottom: 14px;
        font-weight: 900;
        line-height: 1.15;
        letter-spacing: -0.5px;
    }

    .rs-title span {
        color: var(--rs-primary);
        position: relative;
    }

    .rs-desc {
        color: var(--rs-slate-500);
        font-size: 1.05rem;
        line-height: 1.65;
        margin: 0 auto;
    }

    /* Trust Strip */
    .rs-trust-strip {
        background: var(--rs-dark);
        padding: 18px 0;
        border-bottom: 1px solid rgba(255,255,255,0.08);
    }

    .rs-trust-inner {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 20px;
        flex-wrap: wrap;
    }

    .rs-ts-item {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: rgba(255,255,255,0.85);
        font-size: 0.82rem;
        font-weight: 700;
    }

    .rs-ts-item i {
        color: #10b981;
        font-size: 1rem;
    }

    .rs-ts-sep {
        width: 4px;
        height: 4px;
        border-radius: 50%;
        background: rgba(255,255,255,0.25);
    }

    /* Benefits Grid */
    .rs-grid-benefits {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        gap: 26px;
    }

    .rs-benefit-card {
        background: #ffffff;
        border: 1px solid var(--rs-slate-200);
        border-radius: 20px;
        padding: 32px 28px;
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
        box-shadow: var(--rs-card-shadow);
        display: flex;
        flex-direction: column;
    }

    .rs-benefit-card:hover {
        transform: translateY(-6px);
        border-color: rgba(37, 99, 235, 0.4);
        box-shadow: var(--rs-card-shadow-hover);
    }

    .rs-bcard-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
    }

    .rs-bcard-icon {
        width: 54px;
        height: 54px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.65rem;
        transition: transform 0.3s ease;
    }

    .rs-benefit-card:hover .rs-bcard-icon {
        transform: scale(1.08);
    }

    .rs-bcard-tag {
        font-size: 0.72rem;
        font-weight: 800;
        text-transform: uppercase;
        padding: 4px 10px;
        border-radius: 999px;
        letter-spacing: 0.5px;
    }

    .rs-bcard-title {
        font-size: 1.22rem;
        color: var(--rs-dark);
        font-weight: 800;
        margin-bottom: 10px;
        line-height: 1.3;
    }

    .rs-bcard-text {
        color: var(--rs-slate-600);
        font-size: 0.9375rem;
        line-height: 1.6;
        margin: 0;
    }

    .rs-bcard-accent {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 0%;
        height: 3px;
        transition: width 0.35s ease;
    }

    .rs-benefit-card:hover .rs-bcard-accent {
        width: 100%;
    }

    /* Calculator Section */
    .rs-calc-section {
        padding: 84px 0;
        background: linear-gradient(180deg, #f8fafc 0%, #edf2f7 100%);
    }

    .rs-calc-box {
        background: #ffffff;
        border: 1px solid var(--rs-slate-200);
        border-radius: 24px;
        padding: 40px;
        box-shadow: 0 20px 40px -10px rgba(15, 23, 42, 0.08);
        max-width: 1060px;
        margin: 0 auto;
    }

    .rs-calc-grid {
        display: grid;
        grid-template-columns: 1.2fr 0.9fr;
        gap: 40px;
        align-items: center;
    }

    .rs-calc-heading {
        font-size: 1.25rem;
        font-weight: 800;
        color: var(--rs-dark);
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .rs-calc-heading i { color: var(--rs-primary); }

    .rs-calc-group { margin-bottom: 26px; }

    .rs-calc-label {
        display: block;
        font-size: 0.875rem;
        font-weight: 700;
        color: var(--rs-slate-800);
        margin-bottom: 12px;
    }

    .rs-credit-options {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 10px;
    }

    .rs-opt-btn {
        background: var(--rs-slate-50);
        border: 1.5px solid var(--rs-slate-200);
        border-radius: 12px;
        padding: 12px 10px;
        cursor: pointer;
        text-align: center;
        transition: all 0.2s ease;
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .rs-opt-btn strong {
        font-size: 0.9rem;
        color: var(--rs-dark);
    }

    .rs-opt-btn span {
        font-size: 0.72rem;
        color: var(--rs-slate-500);
        font-weight: 600;
    }

    .rs-opt-btn:hover {
        border-color: var(--rs-primary);
        background: #ffffff;
    }

    .rs-opt-btn.active {
        background: rgba(37, 99, 235, 0.06);
        border-color: var(--rs-primary);
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
    }

    .rs-opt-btn.active strong { color: var(--rs-primary); }

    .rs-slider-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
    }

    .rs-slider-val {
        font-size: 0.95rem;
        font-weight: 800;
        color: var(--rs-primary);
        background: rgba(37, 99, 235, 0.08);
        padding: 4px 12px;
        border-radius: 999px;
    }

    .rs-slider {
        width: 100%;
        height: 8px;
        border-radius: 5px;
        background: #cbd5e1;
        outline: none;
        -webkit-appearance: none;
        cursor: pointer;
    }

    .rs-slider::-webkit-slider-thumb {
        -webkit-appearance: none;
        width: 22px;
        height: 22px;
        border-radius: 50%;
        background: var(--rs-primary);
        cursor: pointer;
        box-shadow: 0 2px 8px rgba(37, 99, 235, 0.5);
        border: 2px solid #ffffff;
    }

    .rs-slider-ticks {
        display: flex;
        justify-content: space-between;
        font-size: 0.7rem;
        color: var(--rs-slate-500);
        font-weight: 600;
        margin-top: 8px;
    }

    /* Calculator Results Card */
    .rs-calc-results {
        background: var(--rs-dark);
        border-radius: 20px;
        padding: 32px;
        color: #ffffff;
        box-shadow: 0 15px 30px rgba(15, 23, 42, 0.2);
    }

    .rs-calc-result-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
        padding-bottom: 16px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .rs-calc-result-header h4 {
        font-size: 1.1rem;
        font-weight: 800;
        margin: 0;
        color: #ffffff;
    }

    .rs-calc-badge {
        font-size: 0.72rem;
        font-weight: 800;
        background: rgba(16, 185, 129, 0.2);
        color: #34d399;
        padding: 4px 10px;
        border-radius: 999px;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .rs-result-metrics {
        display: flex;
        flex-direction: column;
        gap: 14px;
        margin-bottom: 24px;
    }

    .rs-metric-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 0.9rem;
    }

    .rs-metric-item .lbl { color: rgba(255,255,255,0.7); }
    .rs-metric-item .val { font-weight: 800; color: #ffffff; }

    .rs-metric-item.highlight {
        background: rgba(255,255,255,0.06);
        padding: 12px 14px;
        border-radius: 12px;
        border: 1px solid rgba(255,255,255,0.1);
    }

    .rs-metric-item.highlight .lbl { color: #ffffff; font-weight: 700; }
    .rs-metric-item .val.profit { font-size: 1.4rem; color: #34d399; font-weight: 900; }
    .rs-metric-item .val.roi { color: #60a5fa; font-weight: 800; }

    .rs-calc-cta {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        width: 100%;
        background: linear-gradient(135deg, var(--rs-primary) 0%, #1d4ed8 100%);
        color: #ffffff;
        padding: 14px;
        border-radius: 12px;
        font-weight: 800;
        font-size: 0.9375rem;
        text-decoration: none;
        transition: all 0.25s ease;
        box-shadow: 0 4px 14px rgba(37, 99, 235, 0.4);
    }

    .rs-calc-cta:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(37, 99, 235, 0.5);
        color: #ffffff;
    }

    /* Steps Section */
    .rs-steps-section {
        padding: 84px 0;
        background: #ffffff;
    }

    .rs-steps-grid {
        display: grid;
        grid-template-columns: 1fr auto 1fr auto 1fr;
        gap: 16px;
        align-items: center;
        max-width: 1100px;
        margin: 0 auto;
    }

    .rs-step-card {
        background: var(--rs-slate-50);
        border: 1px solid var(--rs-slate-200);
        border-radius: 20px;
        padding: 32px 24px;
        transition: all 0.3s ease;
    }

    .rs-step-card:hover {
        background: #ffffff;
        border-color: var(--rs-primary);
        transform: translateY(-4px);
        box-shadow: var(--rs-card-shadow);
    }

    .rs-step-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
    }

    .rs-step-badge {
        font-size: 0.72rem;
        font-weight: 900;
        letter-spacing: 1px;
        background: rgba(37, 99, 235, 0.1);
        color: var(--rs-primary);
        padding: 4px 12px;
        border-radius: 999px;
    }

    .rs-step-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        background: #ffffff;
        border: 1px solid var(--rs-slate-200);
        color: var(--rs-primary);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
        box-shadow: 0 2px 6px rgba(0,0,0,0.04);
    }

    .rs-step-card h3 {
        font-size: 1.15rem;
        font-weight: 800;
        color: var(--rs-dark);
        margin-bottom: 10px;
    }

    .rs-step-card p {
        font-size: 0.9rem;
        color: var(--rs-slate-600);
        line-height: 1.55;
        margin: 0;
    }

    .rs-step-arrow {
        color: var(--rs-slate-400);
        font-size: 1.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* ═══════════════════════════════════════════════════════════
       PRICING PACKAGES (FIXED OVERLAP & PREMIUM DESIGN)
       ═══════════════════════════════════════════════════════════ */
    .rs-pricing-section {
        padding: 90px 0 110px;
        background: linear-gradient(180deg, #f8fafc 0%, #edf2f7 100%);
    }

    .rs-pricing-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 28px;
        max-width: 1140px;
        margin: 0 auto 50px;
        align-items: stretch;
    }

    .rs-price-card {
        background: #ffffff;
        border: 1.5px solid var(--rs-slate-200);
        border-radius: 24px;
        padding: 44px 30px 32px;
        position: relative;
        transition: all 0.3s ease;
        box-shadow: var(--rs-card-shadow);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .rs-price-card:hover {
        transform: translateY(-8px);
        box-shadow: var(--rs-card-shadow-hover);
        border-color: rgba(37, 99, 235, 0.4);
    }

    /* Featured Card Styling */
    .rs-price-card.featured-card {
        border-color: var(--rs-primary);
        background: linear-gradient(180deg, #f0f7ff 0%, #ffffff 100%);
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15), var(--rs-card-shadow-hover);
        transform: scale(1.02);
    }

    .rs-price-card.featured-card:hover {
        transform: scale(1.02) translateY(-8px);
    }

    /* Floating Badges on top border - NEVER OVERLAPS */
    .rs-card-badge {
        position: absolute;
        top: -14px;
        left: 50%;
        transform: translateX(-50%);
        padding: 6px 18px;
        border-radius: 999px;
        font-size: 0.72rem;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: 1px;
        white-space: nowrap;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        z-index: 10;
    }

    .rs-badge-highlight {
        background: linear-gradient(135deg, var(--rs-primary) 0%, #1d4ed8 100%);
        color: #ffffff;
        box-shadow: 0 4px 14px rgba(37, 99, 235, 0.4);
    }

    .rs-badge-subtle {
        background: var(--rs-dark);
        color: #ffffff;
        box-shadow: 0 4px 10px rgba(15, 23, 42, 0.25);
    }

    /* Price Header Elements */
    .rs-price-head {
        text-align: center;
        margin-bottom: 24px;
    }

    .rs-credit-title-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: rgba(37, 99, 235, 0.08);
        color: var(--rs-primary);
        font-weight: 800;
        font-size: 0.875rem;
        padding: 6px 16px;
        border-radius: 999px;
        margin-bottom: 18px;
        letter-spacing: 0.5px;
    }

    .rs-credit-title-pill i { font-size: 1rem; }

    .rs-price-amount-box {
        display: flex;
        align-items: baseline;
        justify-content: center;
        gap: 4px;
        color: var(--rs-dark);
        margin-bottom: 12px;
    }

    .rs-price-amount-box .currency {
        font-size: 1.8rem;
        font-weight: 800;
        color: var(--rs-dark);
    }

    .rs-price-amount-box .number {
        font-size: 3.4rem;
        font-weight: 900;
        line-height: 1;
        letter-spacing: -1px;
    }

    .rs-price-amount-box .period {
        font-size: 0.85rem;
        color: var(--rs-slate-500);
        font-weight: 600;
    }

    .rs-rate-pill {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        font-size: 0.8rem;
        color: #059669;
        background: #ecfdf5;
        border: 1px solid #a7f3d0;
        padding: 4px 12px;
        border-radius: 999px;
        font-weight: 700;
    }

    .rs-card-hr {
        height: 1px;
        background: var(--rs-slate-200);
        margin: 0 0 24px;
    }

    /* Features List */
    .rs-features-list {
        list-style: none;
        padding: 0;
        margin: 0 0 32px;
        display: flex;
        flex-direction: column;
        gap: 13px;
        text-align: left;
    }

    .rs-features-list li {
        font-size: 0.92rem;
        color: var(--rs-slate-600);
        display: flex;
        align-items: flex-start;
        gap: 10px;
        line-height: 1.45;
    }

    .rs-features-list li i {
        color: #10b981;
        font-size: 1.15rem;
        flex-shrink: 0;
        margin-top: 1px;
    }

    .rs-features-list li span {
        color: var(--rs-slate-800);
        font-weight: 600;
    }

    /* Footer Buttons */
    .rs-card-footer {
        margin-top: auto;
    }

    .rs-buy-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        width: 100%;
        padding: 16px 20px;
        border-radius: 14px;
        font-size: 0.95rem;
        font-weight: 800;
        text-decoration: none;
        transition: all 0.25s ease;
    }

    .rs-btn-featured {
        background: linear-gradient(135deg, var(--rs-primary) 0%, #1d4ed8 100%);
        color: #ffffff;
        box-shadow: 0 6px 20px rgba(37, 99, 235, 0.35);
    }

    .rs-btn-featured:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(37, 99, 235, 0.45);
        color: #ffffff;
    }

    .rs-btn-standard {
        background: var(--rs-slate-100);
        color: var(--rs-dark);
        border: 1px solid var(--rs-slate-200);
    }

    .rs-btn-standard:hover {
        background: var(--rs-dark);
        color: #ffffff;
        border-color: var(--rs-dark);
        transform: translateY(-2px);
    }

    .rs-guarantee-note {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        font-size: 0.76rem;
        color: var(--rs-slate-500);
        margin-top: 12px;
        font-weight: 600;
    }

    .rs-guarantee-note i {
        color: #10b981;
        font-size: 0.9rem;
    }

    /* Custom Banner */
    .rs-custom-banner {
        background: var(--rs-dark);
        border-radius: 20px;
        padding: 30px 36px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 24px;
        color: #ffffff;
        box-shadow: 0 10px 30px rgba(15, 23, 42, 0.15);
        max-width: 1140px;
        margin: 0 auto;
    }

    .rs-cb-left {
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .rs-cb-icon {
        width: 56px;
        height: 56px;
        border-radius: 16px;
        background: rgba(37, 99, 235, 0.2);
        color: #60a5fa;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        flex-shrink: 0;
    }

    .rs-cb-left h4 {
        font-size: 1.15rem;
        font-weight: 800;
        margin-bottom: 6px;
        color: #ffffff;
    }

    .rs-cb-left p {
        font-size: 0.88rem;
        color: rgba(255,255,255,0.7);
        margin: 0;
        line-height: 1.5;
    }

    .rs-cb-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #25d366;
        color: #ffffff;
        padding: 14px 24px;
        border-radius: 12px;
        font-weight: 800;
        font-size: 0.9rem;
        text-decoration: none;
        white-space: nowrap;
        transition: all 0.2s ease;
    }

    .rs-cb-btn:hover {
        background: #1eb956;
        color: #ffffff;
        transform: translateY(-2px);
    }

    /* Panel Features Grid */
    .rs-panel-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        gap: 24px;
    }

    .rs-panel-card {
        background: #ffffff;
        border: 1px solid var(--rs-slate-200);
        border-radius: 20px;
        padding: 32px 26px;
        transition: all 0.3s ease;
        box-shadow: var(--rs-card-shadow);
    }

    .rs-panel-card:hover {
        transform: translateY(-5px);
        border-color: var(--rs-primary);
        box-shadow: var(--rs-card-shadow-hover);
    }

    .rs-pc-icon {
        width: 50px;
        height: 50px;
        border-radius: 14px;
        background: rgba(37, 99, 235, 0.08);
        color: var(--rs-primary);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin-bottom: 20px;
    }

    .rs-panel-card h4 {
        font-size: 1.15rem;
        font-weight: 800;
        color: var(--rs-dark);
        margin-bottom: 10px;
    }

    .rs-panel-card p {
        font-size: 0.92rem;
        color: var(--rs-slate-600);
        line-height: 1.6;
        margin: 0;
    }

    /* FAQ Section */
    .rs-faq-wrap {
        max-width: 820px;
        margin: 0 auto;
        display: flex;
        flex-direction: column;
        gap: 14px;
    }

    .rs-faq-item {
        background: #ffffff;
        border: 1.5px solid var(--rs-slate-200);
        border-radius: 16px;
        overflow: hidden;
        transition: border-color 0.2s ease;
    }

    .rs-faq-item.open {
        border-color: var(--rs-primary);
        box-shadow: 0 4px 16px rgba(37, 99, 235, 0.08);
    }

    .rs-faq-toggle {
        width: 100%;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px 24px;
        background: transparent;
        border: none;
        font-size: 1.05rem;
        font-weight: 800;
        color: var(--rs-dark);
        text-align: left;
        cursor: pointer;
        transition: color 0.2s ease;
    }

    .rs-faq-toggle:hover {
        color: var(--rs-primary);
    }

    .rs-faq-toggle i {
        font-size: 1.3rem;
        color: var(--rs-primary);
        transition: transform 0.3s ease;
        flex-shrink: 0;
    }

    .rs-faq-item.open .rs-faq-toggle i {
        transform: rotate(45deg);
    }

    .rs-faq-answer {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.3s ease, padding 0.3s ease;
        padding: 0 24px;
    }

    .rs-faq-item.open .rs-faq-answer {
        max-height: 300px;
        padding: 0 24px 20px;
    }

    .rs-faq-answer p {
        margin: 0;
        color: var(--rs-slate-600);
        font-size: 0.95rem;
        line-height: 1.65;
    }

    /* Bottom CTA Section */
    .rs-bottom-cta-sec {
        padding: 60px 0 100px;
        background: #ffffff;
    }

    .rs-bcta-card {
        background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 100%);
        border-radius: 28px;
        padding: 60px 40px;
        text-align: center;
        color: #ffffff;
        position: relative;
        overflow: hidden;
        box-shadow: 0 25px 50px -12px rgba(15, 23, 42, 0.25);
    }

    .rs-bcta-tag {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: rgba(255, 255, 255, 0.12);
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: #93c5fd;
        font-size: 0.75rem;
        font-weight: 800;
        padding: 6px 16px;
        border-radius: 999px;
        margin-bottom: 20px;
        letter-spacing: 1px;
    }

    .rs-bcta-content h2 {
        font-size: clamp(2rem, 4vw, 2.8rem);
        font-weight: 900;
        margin-bottom: 16px;
        color: #ffffff;
        letter-spacing: -0.5px;
    }

    .rs-bcta-content p {
        font-size: 1.1rem;
        color: rgba(255, 255, 255, 0.8);
        max-width: 620px;
        margin: 0 auto 36px;
        line-height: 1.6;
    }

    .rs-bcta-btns {
        display: flex;
        justify-content: center;
        gap: 16px;
        flex-wrap: wrap;
    }

    .rs-bcta-primary {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: linear-gradient(135deg, var(--rs-primary) 0%, #1d4ed8 100%);
        color: #ffffff;
        padding: 16px 32px;
        border-radius: 14px;
        font-weight: 800;
        font-size: 1rem;
        text-decoration: none;
        box-shadow: 0 6px 20px rgba(37, 99, 235, 0.4);
        transition: all 0.25s ease;
    }

    .rs-bcta-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 30px rgba(37, 99, 235, 0.55);
        color: #ffffff;
    }

    .rs-bcta-secondary {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(255, 255, 255, 0.08);
        border: 1.5px solid rgba(255, 255, 255, 0.25);
        color: #ffffff;
        padding: 16px 32px;
        border-radius: 14px;
        font-weight: 700;
        font-size: 1rem;
        text-decoration: none;
        backdrop-filter: blur(8px);
        transition: all 0.25s ease;
    }

    .rs-bcta-secondary:hover {
        background: rgba(255, 255, 255, 0.16);
        border-color: #ffffff;
        color: #ffffff;
        transform: translateY(-2px);
    }

    /* Empty state */
    .rs-empty-box {
        text-align: center;
        background: #ffffff;
        border: 1px solid var(--rs-slate-200);
        border-radius: 20px;
        padding: 60px 20px;
        max-width: 600px;
        margin: 0 auto;
    }

    .rs-empty-box i {
        font-size: 3rem;
        color: var(--rs-primary);
        margin-bottom: 16px;
        display: block;
    }

    /* ═══════════════════════════════════════════════════════════
       RESPONSIVE DESIGN
       ═══════════════════════════════════════════════════════════ */
    @media (max-width: 1024px) {
        .rs-calc-grid {
            grid-template-columns: 1fr;
            gap: 30px;
        }

        .rs-steps-grid {
            grid-template-columns: 1fr;
            gap: 20px;
        }

        .rs-step-arrow {
            transform: rotate(90deg);
            margin: -5px 0;
        }

        .rs-custom-banner {
            flex-direction: column;
            text-align: center;
        }

        .rs-cb-left {
            flex-direction: column;
            text-align: center;
        }
    }

    @media (max-width: 768px) {
        .rs-section { padding: 60px 0; }
        .rs-pricing-section { padding: 60px 0 80px; }
        .rs-credit-options { grid-template-columns: 1fr; }
        .rs-calc-box { padding: 24px; }
        .rs-price-card.featured-card { transform: none; }
        .rs-price-card.featured-card:hover { transform: translateY(-5px); }
        .rs-bcta-card { padding: 40px 20px; }
        .rs-bcta-btns { flex-direction: column; }
        .rs-bcta-primary, .rs-bcta-secondary { width: 100%; justify-content: center; }
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // ─── PROFIT CALCULATOR LOGIC ───
    const optButtons = document.querySelectorAll('.rs-opt-btn');
    const priceSlider = document.getElementById('resellPriceRange');
    const priceDisplay = document.getElementById('resellPriceDisplay');
    const costVal = document.getElementById('resellCostVal');
    const revenueVal = document.getElementById('resellRevenueVal');
    const profitVal = document.getElementById('resellProfitVal');
    const roiVal = document.getElementById('resellRoiVal');

    let currentCredits = 100;
    let currentCost = 220;

    function updateCalculator() {
        const retailPrice = parseInt(priceSlider.value, 10);
        priceDisplay.textContent = '$' + retailPrice + ' / month';

        const totalRevenue = currentCredits * retailPrice;
        const netProfit = totalRevenue - currentCost;
        const roi = Math.round((netProfit / currentCost) * 100);

        costVal.textContent = '$' + currentCost.toLocaleString();
        revenueVal.textContent = '$' + totalRevenue.toLocaleString();
        profitVal.textContent = '+$' + netProfit.toLocaleString();
        roiVal.textContent = '+' + roi + '%';
    }

    optButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            optButtons.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            currentCredits = parseInt(this.getAttribute('data-credits'), 10);
            currentCost = parseInt(this.getAttribute('data-cost'), 10);
            updateCalculator();
        });
    });

    if (priceSlider) {
        priceSlider.addEventListener('input', updateCalculator);
        updateCalculator();
    }

    // ─── FAQ ACCORDION LOGIC ───
    const faqItems = document.querySelectorAll('.rs-faq-item');
    faqItems.forEach(item => {
        const toggleBtn = item.querySelector('.rs-faq-toggle');
        toggleBtn.addEventListener('click', function() {
            const isOpen = item.classList.contains('open');
            // Close all others
            faqItems.forEach(f => {
                f.classList.remove('open');
                f.querySelector('.rs-faq-toggle').setAttribute('aria-expanded', 'false');
            });

            if (!isOpen) {
                item.classList.add('open');
                toggleBtn.setAttribute('aria-expanded', 'true');
            }
        });
    });
});
</script>
@endpush
@endsection
