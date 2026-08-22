@extends('layouts.app')
@section('title', 'Pricing Plans — Live IPTV Now')

@section('content')

{{-- Page Hero --}}
@include('layouts.page-hero', [
    'heroImage'      => '/page_hero_bg.png',
    'breadcrumb'     => 'Pricing',
    'badge'          => 'Pricing Plans — No Hidden Fees',
    'badgeIcon'      => 'ri-price-tag-3-fill',
    'title'          => 'Simple, Transparent',
    'accent'         => 'Pricing Plans',
    'subtitle'       => 'No contracts. No hidden fees. All plans include 40,000+ channels, HD & 4K quality, and 24/7 expert support — starting from just a few dollars.',
    'desc'           => 'From 1-month to lifetime plans, choose what works for you. Every plan comes with instant delivery, full EPG, anti-freeze tech, and multi-device support.',
    'highlights' => [
        ['icon' => 'ri-flashlight-fill',  'text' => 'Instant delivery within 5 minutes of payment', 'sub' => 'M3U & Xtream codes sent directly to your email'],
        ['icon' => 'ri-device-fill',      'text' => 'Works on all your devices simultaneously',      'sub' => 'Smart TV, phone, tablet, PC, FireStick & more'],
        ['icon' => 'ri-refund-2-fill',    'text' => '24-hour money-back guarantee included',          'sub' => 'Full refund no questions asked within 24 hours'],
    ],
    'ctaPrimary'     => 'Browse Plans',
    'ctaPrimaryUrl'  => '#pkGrid',
    'ctaPrimaryIcon' => 'ri-price-tag-3-line',
    'ctaGhost'       => 'Free Trial',
    'ctaGhostUrl'    => route('contact'),
    'ctaGhostIcon'   => 'ri-gift-line',
    'stats' => [
        ['icon' => 'ri-tv-2-fill',        'text' => '40,000+ Channels'],
        ['icon' => 'ri-movie-2-fill',     'text' => '100K+ VOD'],
        ['icon' => 'ri-flashlight-fill',  'text' => 'Instant Delivery'],
        ['icon' => 'ri-shield-check-fill','text' => '24h Money-Back'],
    ],
])

{{-- Trust Strip --}}
<div class="trust-strip">
    <div class="wrap">
        <div class="trust-strip-inner">
            <div class="ts-item"><i class="ri-flashlight-fill"></i> Instant Delivery</div>
            <div class="ts-sep"></div>
            <div class="ts-item"><i class="ri-shield-check-fill"></i> SSL Secured Payment</div>
            <div class="ts-sep"></div>
            <div class="ts-item"><i class="ri-refund-2-fill"></i> 24h Money-Back Guarantee</div>
            <div class="ts-sep"></div>
            <div class="ts-item"><i class="ri-customer-service-2-fill"></i> 24/7 Support</div>
            <div class="ts-sep"></div>
            <div class="ts-item"><i class="ri-tv-2-fill"></i> Up to 5 Connections</div>
        </div>
    </div>
</div>

{{-- Duration Tabs --}}
<section class="pk-page-sec">
    <div class="wrap">
        <div class="pk-tabs-wrap" data-aos="fade-up">
            <div class="pk-tabs" role="tablist">
                <button class="pk-tab active" data-tab="all" role="tab">All Plans</button>
                <button class="pk-tab" data-tab="1_month" role="tab">1 Month</button>
                <button class="pk-tab" data-tab="3_months" role="tab">3 Months</button>
                <button class="pk-tab" data-tab="6_months" role="tab">6 Months</button>
                <button class="pk-tab" data-tab="12_months" role="tab">
                    12 Months
                    <span class="pk-tab-best">Best Value</span>
                </button>
                <button class="pk-tab" data-tab="recharge" role="tab">Recharge</button>
                <button class="pk-tab" data-tab="lifetime" role="tab">
                    <i class="ri-infinity-line"></i> Lifetime
                </button>
            </div>
        </div>

        {{-- Packages Grid --}}
        @if($packagesByDuration['all']->count() > 0)
        <div class="pk-grid" id="pkGrid">
            @foreach($packagesByDuration['all'] as $package)
                @php $durationKey = \App\Support\PackageDurations::filterKeyFor($package); @endphp
                <div class="pk-card {{ $package->is_popular ? 'pk-popular' : '' }}"
                     data-duration="{{ $durationKey }}"
                     style="display:flex;"
                     data-aos="fade-up"
                     data-aos-delay="{{ ($loop->index % 4) * 80 }}">

                    {{-- Popular Badge --}}
                    @if($package->is_popular)
                    <div class="pk-badge">
                        <i class="ri-vip-crown-fill"></i> Most Popular
                    </div>
                    @endif

                    {{-- Discount Badge --}}
                    @if($package->discount_percentage)
                    <div class="pk-discount">{{ $package->discount_percentage }}% OFF</div>
                    @endif

                    {{-- Header --}}
                    <div class="pk-card-head">
                        <div class="pk-icon">
                            <i class="ri-play-fill"></i>
                        </div>
                        <div>
                            <h3>{{ $package->name }}</h3>
                            <p>{{ $package->devices }} {{ $package->devices > 1 ? 'Devices' : 'Device' }} · {{ \App\Support\PackageDurations::cardLabel($package) }}</p>
                        </div>
                    </div>

                    {{-- Price --}}
                    <div class="pk-price-wrap">
                        @if($package->original_price)
                        <div class="pk-original">${{ number_format($package->original_price, 0) }}</div>
                        @endif
                        <div class="pk-price">
                            <sup>$</sup>{{ number_format($package->price, 0) }}
                            @if($suffix = \App\Support\PackageDurations::priceSuffix($package))
                            <span class="pk-price-suffix">{{ $suffix }}</span>
                            @endif
                        </div>
                    </div>

                    {{-- Divider --}}
                    <hr class="pk-divider">

                    {{-- Features --}}
                    <ul class="pk-features">
                        <li><i class="ri-check-fill"></i> 40,000+ Live Channels</li>
                        <li><i class="ri-check-fill"></i> HD & 4K Quality</li>
                        <li><i class="ri-check-fill"></i> Full EPG / TV Guide</li>
                        <li><i class="ri-check-fill"></i> Anti-Freeze Technology</li>
                        <li><i class="ri-check-fill"></i> Instant Delivery</li>
                        <li><i class="ri-check-fill"></i> 24/7 Expert Support</li>
                        @if($package->devices >= 2)
                        <li><i class="ri-check-fill"></i> {{ $package->devices }} Simultaneous Streams</li>
                        @endif
                    </ul>

                    {{-- CTA --}}
                    <a href="{{ route('checkout.show', $package->slug) }}"
                       class="pk-btn {{ $package->is_popular ? 'pk-btn-primary' : 'pk-btn-outline' }}">
                        <i class="ri-shopping-cart-2-line"></i>
                        Get Started
                    </a>

                    @if($package->is_popular)
                    <p class="pk-guarantee"><i class="ri-shield-check-line"></i> 24-hour money-back guarantee</p>
                    @endif
                </div>
            @endforeach
        </div>
        @else
        <div class="pk-empty">
            <i class="ri-price-tag-3-line"></i>
            <h3>No Plans Available</h3>
            <p>No packages found at the moment. Please check back soon.</p>
        </div>
        @endif

    </div>
</section>

{{-- Features Comparison --}}
<section class="pk-compare-sec">
    <div class="wrap">
        <div class="pk-compare-head" data-aos="fade-up">
            <h2>Everything Included in <em>Every Plan</em></h2>
            <p>No upsells, no hidden extras. Every subscription comes fully loaded.</p>
        </div>
        <div class="pk-compare-grid" data-aos="fade-up" data-aos-delay="100">
            <div class="pc-item"><div class="pc-ic"><i class="ri-tv-2-fill"></i></div><h4>40,000+ Channels</h4><p>Access live TV from 150+ countries in any language.</p></div>
            <div class="pc-item"><div class="pc-ic"><i class="ri-movie-2-fill"></i></div><h4>100K+ VOD Library</h4><p>Movies, series, documentaries — updated daily.</p></div>
            <div class="pc-item"><div class="pc-ic"><i class="ri-4k-fill"></i></div><h4>4K & HD Quality</h4><p>Crystal clear picture with HDR support on all channels.</p></div>
            <div class="pc-item"><div class="pc-ic"><i class="ri-calendar-todo-fill"></i></div><h4>Full TV Guide</h4><p>7-day EPG for easy programme scheduling.</p></div>
            <div class="pc-item"><div class="pc-ic"><i class="ri-device-fill"></i></div><h4>All Devices</h4><p>Smart TV, phone, tablet, PC, Firestick & more.</p></div>
            <div class="pc-item"><div class="pc-ic"><i class="ri-customer-service-2-fill"></i></div><h4>24/7 Support</h4><p>Live chat, WhatsApp & email — always online.</p></div>
        </div>
    </div>
</section>

{{-- FAQ --}}
<section class="pk-faq-sec">
    <div class="wrap">
        <div class="pk-compare-head" data-aos="fade-up">
            <h2>Common <em>Questions</em></h2>
        </div>
        <div class="pk-faq-grid" data-aos="fade-up">
            <div class="fq on">
                <button class="fq-q"><span>How fast is delivery after payment?</span><i class="ri-arrow-down-s-line"></i></button>
                <div class="fq-a">Your M3U playlist and credentials are delivered to your email within 5 minutes of successful payment, 24/7 including weekends.</div>
            </div>
            <div class="fq">
                <button class="fq-q"><span>Can I use on multiple devices at once?</span><i class="ri-arrow-down-s-line"></i></button>
                <div class="fq-a">Yes! Depending on your plan, you can stream on 1 to 5 devices simultaneously. Check each plan for the number of connections included.</div>
            </div>
            <div class="fq">
                <button class="fq-q"><span>Which apps are compatible?</span><i class="ri-arrow-down-s-line"></i></button>
                <div class="fq-a">We are compatible with IPTV Smarters Pro, TiviMate, Xtream Player, Smart IPTV, VLC, and many more apps on all platforms.</div>
            </div>
            <div class="fq">
                <button class="fq-q"><span>Do you offer a free trial?</span><i class="ri-arrow-down-s-line"></i></button>
                <div class="fq-a">Yes! We offer a 24-hour free trial. You can also rely on our 24-hour money-back guarantee if you are not satisfied after purchase.</div>
            </div>
            <div class="fq">
                <button class="fq-q"><span>What payment methods are accepted?</span><i class="ri-arrow-down-s-line"></i></button>
                <div class="fq-a">We accept Visa, Mastercard, PayPal, and various cryptocurrencies including Bitcoin and Ethereum for fully anonymous payments.</div>
            </div>
            <div class="fq">
                <button class="fq-q"><span>What happens when my plan expires?</span><i class="ri-arrow-down-s-line"></i></button>
                <div class="fq-a">You can renew from your account dashboard at any time. Your watchlist and preferences are saved automatically between renewals.</div>
            </div>
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="pk-cta">
    <div class="wrap">
        <div class="pk-cta-inner" data-aos="fade-up">
            <div>
                <h2>Still Have Questions?</h2>
                <p>Our team is online 24/7 and happy to help you choose the right plan.</p>
            </div>
            <div class="pk-cta-btns">
                <a href="{{ route('contact') }}" class="btn btn-white">
                    <i class="ri-message-3-line"></i> Chat With Us
                </a>
                <a href="{{ route('faq') }}" class="btn btn-lg" style="background:rgba(255,255,255,0.12);color:#fff;border:2px solid rgba(255,255,255,0.25);">
                    View All FAQs
                </a>
            </div>
        </div>
    </div>
</section>

@endsection

@push('styles')
<style>
/* ════════════════════════════
   PRICING PAGE
   ════════════════════════════ */

/* ── Trust Strip ── */
.trust-strip {
    background: var(--dark);
    padding: 16px 0;
}
.trust-strip-inner {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0;
    flex-wrap: wrap;
}
.ts-item {
    display: flex;
    align-items: center;
    gap: 7px;
    font-size: 0.82rem;
    font-weight: 600;
    color: rgba(255,255,255,0.7);
    padding: 6px 20px;
    white-space: nowrap;
}
.ts-item i { color: var(--primary); font-size: 0.95rem; }
.ts-sep { width: 1px; height: 20px; background: rgba(255,255,255,0.1); }

/* ── Main Section ── */
.pk-page-sec {
    padding: 50px 0 80px;
}

/* ── Duration Tabs ── */
.pk-tabs-wrap {
    display: flex;
    justify-content: center;
    margin-bottom: 50px;
}
.pk-tabs {
    display: flex;
    align-items: center;
    gap: 4px;
    background: var(--bg3);
    padding: 5px;
    border-radius: 14px;
    flex-wrap: wrap;
    justify-content: center;
    box-shadow: var(--s2);
    border: var(--bdr);
}
.pk-tab {
    padding: 10px 22px;
    font-size: 0.87rem;
    font-weight: 700;
    color: var(--ink4);
    border-radius: 10px;
    border: none;
    background: transparent;
    cursor: pointer;
    font-family: var(--font);
    transition: var(--t);
    display: flex;
    align-items: center;
    gap: 6px;
    position: relative;
    white-space: nowrap;
}
.pk-tab:hover { color: var(--primary); background: rgba(255,77,28,0.06); }
.pk-tab.active { background: #fff; color: var(--primary); box-shadow: var(--s2); }
.pk-tab-best {
    background: var(--primary);
    color: #fff;
    font-size: 0.7rem;
    font-weight: 900;
    padding: 2px 6px;
    border-radius: 4px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* ── Package Grid ── */
.pk-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 24px;
}

/* ── Package Card ── */
.pk-card {
    background: #fff;
    border: 1.5px solid #e5e7eb;
    border-radius: 20px;
    padding: 32px 28px;
    display: flex;
    flex-direction: column;
    gap: 0;
    position: relative;
    transition: all 0.3s ease;
    box-shadow: var(--s1);
}
.pk-card:hover {
    transform: translateY(-7px);
    box-shadow: var(--s4);
    border-color: rgba(255,77,28,0.2);
}
.pk-card.pk-popular {
    border: 2px solid var(--primary);
    box-shadow: 0 0 0 5px var(--primary-glow), var(--s3);
}
.pk-card.pk-popular:hover {
    transform: translateY(-8px);
    box-shadow: 0 0 0 5px var(--primary-glow), var(--s4);
}

/* Popular badge */
.pk-badge {
    position: absolute;
    top: -14px;
    left: 50%;
    transform: translateX(-50%);
    background: var(--primary);
    color: #fff;
    padding: 5px 18px;
    border-radius: 30px;
    font-size: 0.72rem;
    font-weight: 900;
    display: flex;
    align-items: center;
    gap: 5px;
    white-space: nowrap;
    box-shadow: var(--s-primary);
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Discount ribbon */
.pk-discount {
    position: absolute;
    top: 18px;
    right: 18px;
    background: #ef4444;
    color: #fff;
    padding: 4px 12px;
    border-radius: 30px;
    font-size: 0.72rem;
    font-weight: 900;
}

/* Card header */
.pk-card-head {
    display: flex;
    align-items: center;
    gap: 14px;
    margin-bottom: 24px;
}
.pk-icon {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    background: var(--primary-soft);
    border: 1px solid var(--primary-glow);
    display: grid;
    place-items: center;
    font-size: 1.3rem;
    color: var(--primary);
    flex-shrink: 0;
    transition: var(--t);
}
.pk-card:hover .pk-icon,
.pk-card.pk-popular .pk-icon {
    background: var(--primary);
    color: #fff;
}
.pk-card-head h3 {
    font-size: 1.2rem;
    font-weight: 800;
    color: var(--ink);
    margin-bottom: 3px;
}
.pk-card-head p {
    font-size: 0.78rem;
    color: var(--ink5);
    font-weight: 600;
}

/* Price */
.pk-price-wrap {
    margin-bottom: 24px;
}
.pk-original {
    font-size: 1rem;
    color: var(--ink5);
    text-decoration: line-through;
    margin-bottom: 2px;
}
.pk-price {
    font-size: 3.4rem;
    font-weight: 900;
    color: var(--ink);
    line-height: 1;
    letter-spacing: -2px;
    margin-bottom: 4px;
}
.pk-price sup {
    font-size: 1.4rem;
    font-weight: 700;
    color: var(--primary);
    vertical-align: top;
    margin-top: 8px;
    display: inline-block;
}
.pk-price-suffix {
    font-size: 0.95rem;
    font-weight: 600;
    color: var(--ink5);
    margin-left: 4px;
}
.pk-period {
    font-size: 0.82rem;
    color: var(--ink5);
    font-weight: 600;
}

/* Divider */
.pk-divider {
    border: none;
    border-top: var(--bdr);
    margin-bottom: 22px;
}

/* Features */
.pk-features {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 10px;
    margin-bottom: 26px;
}
.pk-features li {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 0.88rem;
    color: var(--ink3);
    font-weight: 500;
}
.pk-features i {
    color: var(--success);
    font-size: 1rem;
    flex-shrink: 0;
    width: 20px;
    height: 20px;
    background: rgba(16,185,129,0.1);
    border-radius: 50%;
    display: grid;
    place-items: center;
    font-size: 0.85rem;
}

/* CTA Button */
.pk-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 14px 20px;
    border-radius: 10px;
    font-size: 0.92rem;
    font-weight: 800;
    transition: var(--t);
    text-align: center;
    font-family: var(--font);
    border: 2px solid transparent;
}
.pk-btn-primary {
    background: var(--primary);
    color: #fff;
    box-shadow: var(--s-primary);
}
.pk-btn-primary:hover { background: var(--primary-dark); transform: translateY(-2px); }
.pk-btn-outline {
    background: transparent;
    color: var(--ink2);
    border-color: #e5e7eb;
}
.pk-btn-outline:hover { border-color: var(--primary); color: var(--primary); background: var(--primary-soft); }

/* Guarantee text */
.pk-guarantee {
    text-align: center;
    font-size: 0.75rem;
    color: var(--ink5);
    margin-top: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 5px;
}
.pk-guarantee i { color: var(--success); }

/* Empty State */
.pk-empty {
    text-align: center;
    padding: 80px 40px;
    background: var(--bg2);
    border: var(--bdr);
    border-radius: 20px;
    max-width: 420px;
    margin: 0 auto;
}
.pk-empty i { font-size: 3rem; color: var(--ink5); display: block; margin-bottom: 16px; }
.pk-empty h3 { margin-bottom: 8px; }
.pk-empty p { color: var(--ink4); margin-bottom: 20px; }

/* ── Compare Section ── */
.pk-compare-sec {
    background: var(--bg2);
    padding: 80px 0;
    border-top: var(--bdr);
}
.pk-compare-head {
    text-align: center;
    max-width: 560px;
    margin: 0 auto 48px;
}
.pk-compare-head h2 { font-size: clamp(1.8rem, 3.5vw, 2.4rem); margin-bottom: 12px; }
.pk-compare-head em { font-style: normal; color: var(--primary); }
.pk-compare-head p { color: var(--ink4); font-size: 1rem; }

.pk-compare-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
}
.pc-item {
    background: #fff;
    border: var(--bdr);
    border-radius: 16px;
    padding: 28px 24px;
    transition: var(--ts);
}
.pc-item:hover { transform: translateY(-5px); box-shadow: var(--s3); border-color: var(--primary-glow); }
.pc-ic {
    width: 52px; height: 52px;
    border-radius: 12px;
    background: var(--primary-soft);
    border: 1px solid var(--primary-glow);
    display: grid; place-items: center;
    font-size: 1.4rem;
    color: var(--primary);
    margin-bottom: 16px;
    transition: var(--t);
}
.pc-item:hover .pc-ic { background: var(--primary); color: #fff; }
.pc-item h4 { font-size: 1rem; margin-bottom: 7px; color: var(--ink); }
.pc-item p { font-size: 0.85rem; color: var(--ink4); line-height: 1.6; }

/* ── FAQ Section ── */
.pk-faq-sec {
    padding: 80px 0;
}
.pk-faq-grid {
    max-width: 780px;
    margin: 0 auto;
    display: flex;
    flex-direction: column;
    gap: 10px;
}

/* ── CTA ── */
.pk-cta {
    background: var(--primary);
    padding: 60px 0;
}
.pk-cta-inner {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 32px;
    flex-wrap: wrap;
}
.pk-cta-inner h2 { font-size: clamp(1.5rem, 3vw, 2rem); color: #fff; margin-bottom: 6px; }
.pk-cta-inner p { color: rgba(255,255,255,0.78); font-size: 0.97rem; }
.pk-cta-btns { display: flex; gap: 12px; flex-shrink: 0; flex-wrap: wrap; }

/* ── Responsive ── */
@media (max-width: 1024px) {
    .pk-compare-grid { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 768px) {
    .trust-strip-inner { justify-content: flex-start; overflow-x: auto; flex-wrap: nowrap; gap: 0; }
    .ts-sep { flex-shrink: 0; }
    .ts-item { flex-shrink: 0; }
    .pk-tabs { width: 100%; }
    .pk-grid { grid-template-columns: 1fr; max-width: 420px; margin: 0 auto; }
    .pk-compare-grid { grid-template-columns: 1fr; }
    .pk-cta-inner { flex-direction: column; text-align: center; }
    .pk-cta-btns { justify-content: center; width: 100%; }
}
@media (max-width: 480px) {
    .pk-tab { padding: 9px 14px; font-size: 0.8rem; }
    .pk-card { padding: 28px 20px; }
    .pk-price { font-size: 2.8rem; }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const tabs  = document.querySelectorAll('.pk-tab');
    const cards = document.querySelectorAll('.pk-card[data-duration]');

    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            const dur = tab.dataset.tab;

            tabs.forEach(t => t.classList.remove('active'));
            tab.classList.add('active');

            cards.forEach(card => {
                const matches = dur === 'all' || card.dataset.duration === dur;

                if (matches) {
                    card.style.display = 'flex';
                    requestAnimationFrame(() => {
                        card.style.transition = 'opacity 0.35s ease, transform 0.35s ease';
                        card.style.opacity = '1';
                        card.style.transform = 'translateY(0)';
                    });
                } else {
                    card.style.transition = 'opacity 0.25s, transform 0.25s';
                    card.style.opacity = '0';
                    card.style.transform = 'translateY(10px)';
                    setTimeout(() => { card.style.display = 'none'; }, 260);
                }
            });
        });
    });

});
</script>
@endpush
