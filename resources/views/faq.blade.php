@extends('layouts.app')
@section('title', 'FAQ — Frequently Asked Questions | Live IPTV Now')

@section('content')

@include('layouts.page-hero', [
    'heroImage'      => '/hero_faq.png',
    'breadcrumb'     => 'FAQ',
    'badge'          => 'Help Center — Instant Answers',
    'badgeIcon'      => 'ri-question-answer-fill',
    'title'          => 'Got Questions?',
    'accent'         => 'We Have Answers',
    'subtitle'       => 'Find instant answers to common questions about setup, billing, channels, devices, and technical support — all in one place.',
    'desc'           => 'Our comprehensive FAQ covers everything from getting started to advanced troubleshooting. Still not finding what you need? Our 24/7 support team is always ready to help.',
    'highlights' => [
        ['icon' => 'ri-settings-4-fill',   'text' => 'Setup & Installation guides for every device', 'sub' => 'FireStick, Smart TV, Android, iOS, MAG & more'],
        ['icon' => 'ri-bank-card-fill',    'text' => 'Billing, payments & refund questions answered', 'sub' => 'Stripe, crypto, subscriptions & cancellation'],
        ['icon' => 'ri-tools-fill',        'text' => 'Technical troubleshooting & buffering fixes',   'sub' => 'Buffering, channel errors & EPG issues'],
    ],
    'ctaPrimary'     => 'Browse FAQs',
    'ctaPrimaryUrl'  => '#faq-body',
    'ctaPrimaryIcon' => 'ri-question-answer-line',
    'ctaGhost'       => 'Contact Support',
    'ctaGhostUrl'    => route('contact'),
    'ctaGhostIcon'   => 'ri-headphone-line',
    'stats' => [
        ['icon' => 'ri-question-fill',    'text' => '16+ FAQ Topics'],
        ['icon' => 'ri-time-fill',        'text' => 'Avg Response < 1hr'],
        ['icon' => 'ri-star-fill',        'text' => '4.9★ Support Rating'],
        ['icon' => 'ri-headphone-fill',   'text' => '24/7 Live Support'],
    ],
])

{{-- ═══ SEARCH + CATEGORY TAB BAR ═══ --}}
<div class="faq-topbar" id="faq-body">
    <div class="wrap">
        {{-- Live Search --}}
        <div class="faq-search-wrap" data-aos="fade-up">
            <i class="ri-search-line faq-si"></i>
            <input type="text" id="faqSearch" placeholder="Search any question... e.g. 'buffering', 'refund', 'setup'" autocomplete="off">
            <span class="faq-sc" id="faqCount"></span>
        </div>

        {{-- Category Pills --}}
        <div class="faq-cats" data-aos="fade-up" data-aos-delay="60">
            <button class="faq-cat-pill on" data-cat="all">
                <i class="ri-apps-fill"></i> All Topics
            </button>
            <button class="faq-cat-pill" data-cat="general">
                <i class="ri-information-fill"></i> General
            </button>
            <button class="faq-cat-pill" data-cat="setup">
                <i class="ri-settings-3-fill"></i> Setup
            </button>
            <button class="faq-cat-pill" data-cat="payment">
                <i class="ri-bank-card-fill"></i> Payment
            </button>
            <button class="faq-cat-pill" data-cat="technical">
                <i class="ri-tools-fill"></i> Technical
            </button>
        </div>
    </div>
</div>

{{-- ═══ MAIN FAQ BODY ═══ --}}
<section class="faq-body-sec">
    <div class="wrap">

        {{-- ── Top Quick Stats Strip ── --}}
        <div class="faq-stats-strip" data-aos="fade-up">
            <div class="fqs-card">
                <i class="ri-question-answer-fill"></i>
                <div><strong>16</strong><span>Questions Covered</span></div>
            </div>
            <div class="fqs-sep"></div>
            <div class="fqs-card">
                <i class="ri-time-fill"></i>
                <div><strong>&lt;1 hr</strong><span>Avg Response Time</span></div>
            </div>
            <div class="fqs-sep"></div>
            <div class="fqs-card">
                <i class="ri-star-fill"></i>
                <div><strong>4.9★</strong><span>Support Rating</span></div>
            </div>
            <div class="fqs-sep"></div>
            <div class="fqs-card">
                <i class="ri-headphone-fill"></i>
                <div><strong>24/7</strong><span>Always Available</span></div>
            </div>
            <div class="fqs-sep"></div>
            <div class="fqs-card">
                <i class="ri-translate-2"></i>
                <div><strong>10+</strong><span>Languages Supported</span></div>
            </div>
        </div>

        {{-- ── FAQ Categories ── --}}
        @foreach([
            ['general',  'ri-information-fill', '#6366f1', 'General Questions',   'Everything you need to know about our IPTV service.', [
                ['What is IPTV and how does it work?',           'IPTV (Internet Protocol Television) delivers TV content over the internet rather than through traditional cable or satellite. You stream content directly through your internet connection on any compatible device — Smart TV, phone, tablet, or PC.'],
                ['What channels and content do you offer?',      'We offer over 40,000 live channels from 150+ countries including sports, movies, news, entertainment, and kids content — plus a library of 100,000+ on-demand movies and TV series.'],
                ['Is there a free trial available?',             'Yes! We offer a 24-hour free trial with full access to all channels, VOD content, and features. No credit card required. Contact our support team to get started.'],
                ['How many devices can I use simultaneously?',   'Depending on your plan you can stream on 1 to 5 devices simultaneously. This is perfect for family households who want to watch on multiple screens at the same time.'],
            ]],
            ['setup',    'ri-settings-3-fill', '#10b981', 'Setup & Installation',  'Get up and running in minutes on any device.', [
                ['What devices are compatible?',                 'We support Smart TVs (Samsung, LG, Sony), Android phones/tablets, iOS (iPhone/iPad), Amazon FireStick, Nvidia Shield, MAG boxes, Windows PC, Mac, and most IPTV player apps.'],
                ['What internet speed do I need?',               'For SD quality: 5 Mbps. For HD: 10 Mbps. For FHD: 15 Mbps. For 4K Ultra HD: 25 Mbps. We recommend a wired ethernet connection for the most stable experience.'],
                ['How quickly will I receive my subscription?',  'Your credentials (M3U URL and Xtream codes) are delivered to your email inbox within 5 minutes of successful payment — available 24/7 including weekends and holidays.'],
                ['Do you provide setup assistance?',             'Absolutely! We provide comprehensive written guides and video tutorials for all supported devices. Our support team is also available 24/7 for live remote assistance if needed.'],
            ]],
            ['payment',  'ri-bank-card-fill',   '#f59e0b', 'Payment & Billing',    'Flexible payment options with full transparency.', [
                ['What payment methods do you accept?',          'We accept all major credit/debit cards via Stripe, PayPal, and a wide range of cryptocurrencies including Bitcoin, Ethereum, and USDT. All payments are secured with 256-bit SSL encryption.'],
                ['Do subscriptions auto-renew?',                 'No, we do not auto-renew. You have full control over your subscription. We send reminder notifications before your subscription expires so you can choose to renew manually.'],
                ['What is your refund policy?',                  'We offer a 24-hour money-back guarantee for new subscribers. If you are not satisfied with the service within the first 24 hours of purchase, contact support for a full refund.'],
                ['Can I upgrade my plan?',                       'Yes! You can upgrade your plan at any time by contacting our support team. We will calculate a prorated amount for the remaining time on your current plan.'],
            ]],
            ['technical','ri-tools-fill',       '#ef4444', 'Technical Support',    'Troubleshoot and resolve any technical issues fast.', [
                ['Why is my stream buffering?',                  'Common causes: slow internet connection, Wi-Fi interference, ISP throttling, or too many background apps running. Try switching to a wired connection, restarting your router, or lowering stream quality.'],
                ['A specific channel is not working?',           'First try refreshing your playlist. If the channel is still down, please report it to our support team with the channel name. We usually fix channel issues within 30 minutes.'],
                ['Do I need a VPN to use the service?',          'A VPN is not required but is highly recommended for enhanced privacy and to prevent potential ISP throttling. We recommend using a fast VPN provider with a server close to your location.'],
                ['How do I contact support?',                    'You can reach us via live chat on the website, WhatsApp, Telegram, or our contact form. We typically respond within minutes for urgent technical issues, 24 hours a day.'],
            ]],
        ] as $cat)

        <div class="faq-group" id="{{ $cat[0] }}" data-cat="{{ $cat[0] }}" data-aos="fade-up">

            {{-- Group Header --}}
            <div class="faq-group-hd">
                <div class="faq-group-ic" style="background:{{ $cat[2] }}18; border-color:{{ $cat[2] }}35; color:{{ $cat[2] }};">
                    <i class="{{ $cat[1] }}"></i>
                </div>
                <div class="faq-group-meta">
                    <h2>{{ $cat[3] }}</h2>
                    <p>{{ $cat[4] }}</p>
                </div>
                <div class="faq-group-cnt" style="background:{{ $cat[2] }}12; color:{{ $cat[2] }}; border-color:{{ $cat[2] }}30;">
                    {{ count($cat[5]) }} Q&amp;A
                </div>
            </div>

            {{-- 2-col Accordion Grid --}}
            <div class="faq-grid-2">
                @foreach($cat[5] as $i => $q)
                <div class="fq2 {{ $loop->first && $loop->parent->first ? 'on' : '' }}" data-question="{{ strtolower($q[0]) }} {{ strtolower($q[1]) }}">
                    <button class="fq2-q" aria-expanded="{{ $loop->first && $loop->parent->first ? 'true' : 'false' }}">
                        <div class="fq2-num">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</div>
                        <span>{{ $q[0] }}</span>
                        <div class="fq2-icon"><i class="ri-add-line"></i></div>
                    </button>
                    <div class="fq2-a">
                        <div class="fq2-a-inner">
                            <i class="ri-checkbox-circle-fill fq2-check"></i>
                            <p>{{ $q[1] }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

        </div>
        @endforeach

        {{-- No results message --}}
        <div class="faq-no-results" id="faqNoResults" style="display:none;">
            <i class="ri-search-eye-line"></i>
            <h3>No results found</h3>
            <p>Try different keywords or <a href="{{ route('contact') }}">contact our support team</a> for help.</p>
        </div>

    </div>
</section>

{{-- ═══ SUPPORT CTA SECTION ═══ --}}
<section class="faq-support-sec">
    <div class="wrap">
        <div class="faq-support-grid" data-aos="fade-up">

            {{-- Left: Didn't find answer --}}
            <div class="faq-sup-main">
                <div class="faq-sup-icon">
                    <i class="ri-customer-service-2-fill"></i>
                </div>
                <h2>Still Didn't Find <em>Your Answer?</em></h2>
                <p>Our expert support team is available around the clock. We respond to all queries within minutes — not hours.</p>
                <div class="faq-sup-btns">
                    <a href="{{ route('contact') }}" class="faq-sup-btn-primary">
                        <i class="ri-message-3-fill"></i> Send a Message
                    </a>
                    <a href="#" class="faq-sup-btn-ghost" onclick="if(window.$crisp)$crisp.push(['do','chat:open']);return false;">
                        <i class="ri-chat-1-fill"></i> Live Chat Now
                    </a>
                </div>
            </div>

            {{-- Right: Contact channels --}}
            <div class="faq-sup-channels">
                <a href="mailto:support@liveiptvnow.com" class="faq-ch-card">
                    <div class="faq-ch-ic" style="background:rgba(59,130,246,0.12);color:#3b82f6;">
                        <i class="ri-mail-fill"></i>
                    </div>
                    <div class="faq-ch-body">
                        <strong>Email Support</strong>
                        <span>support@liveiptvnow.com</span>
                        <em>Reply within 2 hours</em>
                    </div>
                    <i class="ri-arrow-right-line faq-ch-arr"></i>
                </a>
                <a href="#" class="faq-ch-card">
                    <div class="faq-ch-ic" style="background:rgba(16,185,129,0.12);color:#10b981;">
                        <i class="ri-whatsapp-fill"></i>
                    </div>
                    <div class="faq-ch-body">
                        <strong>WhatsApp</strong>
                        <span>+1 (800) 123-4567</span>
                        <em>Instant response 24/7</em>
                    </div>
                    <i class="ri-arrow-right-line faq-ch-arr"></i>
                </a>
                <a href="#" class="faq-ch-card">
                    <div class="faq-ch-ic" style="background:rgba(14,165,233,0.12);color:#0ea5e9;">
                        <i class="ri-telegram-fill"></i>
                    </div>
                    <div class="faq-ch-body">
                        <strong>Telegram</strong>
                        <span>@LiveIPTVNow</span>
                        <em>Fastest response channel</em>
                    </div>
                    <i class="ri-arrow-right-line faq-ch-arr"></i>
                </a>
                <div class="faq-ch-card no-link">
                    <div class="faq-ch-ic" style="background:rgba(255,77,28,0.12);color:var(--primary);">
                        <i class="ri-time-fill"></i>
                    </div>
                    <div class="faq-ch-body">
                        <strong>Support Hours</strong>
                        <span>24/7 — Every single day</span>
                        <em><span class="live-dot"></span> Team is online now</em>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

@endsection

@push('styles')
<style>
/* ════════════════════════════════════════
   FAQ PAGE — Premium Redesign
   ════════════════════════════════════════ */

/* ── Search + Tab bar ── */
.faq-topbar {
    background: #fff;
    border-bottom: 1px solid #e5e7eb;
    padding: 24px 0 0;
    position: sticky;
    top: 75px;
    z-index: 90;
    box-shadow: 0 4px 20px rgba(0,0,0,0.06);
}

.faq-search-wrap {
    position: relative;
    max-width: 640px;
    margin: 0 auto 18px;
}

.faq-si {
    position: absolute;
    left: 18px; top: 50%;
    transform: translateY(-50%);
    color: var(--ink5);
    font-size: 1.1rem;
    pointer-events: none;
}

#faqSearch {
    width: 100%;
    padding: 14px 120px 14px 48px;
    border: 1.5px solid #e5e7eb;
    border-radius: 14px;
    font-family: var(--font);
    font-size: 0.95rem;
    color: var(--ink);
    background: var(--bg2);
    outline: none;
    transition: all 0.25s ease;
}

#faqSearch:focus {
    border-color: var(--primary);
    background: #fff;
    box-shadow: 0 0 0 4px rgba(255,77,28,0.08);
}

#faqSearch::placeholder { color: var(--ink5); }

.faq-sc {
    position: absolute;
    right: 16px; top: 50%;
    transform: translateY(-50%);
    font-size: 0.75rem;
    font-weight: 700;
    color: var(--ink5);
    white-space: nowrap;
}

.faq-cats {
    display: flex;
    justify-content: center;
    gap: 4px;
    overflow-x: auto;
    padding-bottom: 0;
    scrollbar-width: none;
}

.faq-cats::-webkit-scrollbar { display: none; }

.faq-cat-pill {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 10px 20px;
    font-size: 0.84rem;
    font-weight: 700;
    color: var(--ink4);
    border: none;
    background: transparent;
    border-bottom: 3px solid transparent;
    border-radius: 0;
    cursor: pointer;
    transition: all 0.22s ease;
    font-family: var(--font);
    white-space: nowrap;
    flex-shrink: 0;
}

.faq-cat-pill:hover { color: var(--primary); }
.faq-cat-pill.on { color: var(--primary); border-bottom-color: var(--primary); }
.faq-cat-pill i { font-size: 0.9rem; }

/* ── Stats strip ── */
.faq-body-sec { padding: 56px 0; background: var(--bg2); }

.faq-stats-strip {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0;
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 20px;
    padding: 22px 32px;
    margin-bottom: 52px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.05);
    flex-wrap: wrap;
}

.fqs-card {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 0 28px;
    flex: 1;
    min-width: 130px;
}

.fqs-card i {
    font-size: 1.6rem;
    color: var(--primary);
    flex-shrink: 0;
}

.fqs-card strong {
    display: block;
    font-size: 1.4rem;
    font-weight: 900;
    color: var(--ink);
    line-height: 1;
    letter-spacing: -0.5px;
}

.fqs-card span {
    font-size: 0.72rem;
    color: var(--ink5);
    text-transform: uppercase;
    letter-spacing: 1px;
    font-weight: 700;
}

.fqs-sep {
    width: 1px;
    height: 40px;
    background: #e5e7eb;
    flex-shrink: 0;
}

/* ── FAQ Group ── */
.faq-group {
    margin-bottom: 52px;
}

.faq-group:last-of-type { margin-bottom: 0; }

.faq-group-hd {
    display: flex;
    align-items: center;
    gap: 18px;
    margin-bottom: 24px;
    padding: 20px 28px;
    background: #fff;
    border-radius: 16px;
    border: 1px solid #e5e7eb;
    box-shadow: 0 2px 8px rgba(0,0,0,0.04);
}

.faq-group-ic {
    width: 52px; height: 52px;
    border-radius: 14px;
    border: 1.5px solid;
    display: grid; place-items: center;
    font-size: 1.4rem;
    flex-shrink: 0;
}

.faq-group-meta { flex: 1; }
.faq-group-meta h2 { font-size: 1.25rem; color: var(--ink); margin-bottom: 2px; }
.faq-group-meta p  { font-size: 0.82rem; color: var(--ink5); }

.faq-group-cnt {
    padding: 5px 14px;
    border-radius: 999px;
    font-size: 0.78rem;
    font-weight: 800;
    border: 1px solid;
    flex-shrink: 0;
    letter-spacing: 0.3px;
}

/* ── 2-col Accordion Grid ── */
.faq-grid-2 {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px;
}

.fq2 {
    background: #fff;
    border: 1.5px solid #e5e7eb;
    border-radius: 14px;
    overflow: hidden;
    transition: all 0.25s ease;
}

.fq2:hover { border-color: rgba(255,77,28,0.25); box-shadow: 0 4px 16px rgba(0,0,0,0.07); }
.fq2.on { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(255,77,28,0.08); }

.fq2-q {
    width: 100%;
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 18px 20px;
    background: none;
    border: none;
    cursor: pointer;
    font-family: var(--font);
    text-align: left;
}

.fq2-num {
    width: 28px; height: 28px;
    border-radius: 8px;
    background: var(--bg3);
    display: flex; align-items: center; justify-content: center;
    font-size: 0.72rem;
    font-weight: 900;
    color: var(--ink5);
    flex-shrink: 0;
    transition: all 0.22s ease;
}

.fq2.on .fq2-num {
    background: var(--primary);
    color: #fff;
}

.fq2-q span {
    flex: 1;
    font-size: 0.9rem;
    font-weight: 700;
    color: var(--ink);
    line-height: 1.4;
}

.fq2.on .fq2-q span { color: var(--primary); }

.fq2-icon {
    width: 28px; height: 28px;
    border-radius: 8px;
    background: var(--bg3);
    display: flex; align-items: center; justify-content: center;
    font-size: 1rem;
    color: var(--ink5);
    flex-shrink: 0;
    transition: all 0.3s ease;
}

.fq2.on .fq2-icon {
    background: var(--primary);
    color: #fff;
    transform: rotate(45deg);
}

/* Answer area */
.fq2-a {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

.fq2.on .fq2-a { max-height: 300px; }

.fq2-a-inner {
    display: flex;
    gap: 12px;
    padding: 0 20px 20px;
    border-top: 1px solid #f1f5f9;
    padding-top: 14px;
}

.fq2-check {
    color: var(--success);
    font-size: 1rem;
    flex-shrink: 0;
    margin-top: 2px;
}

.fq2-a-inner p {
    font-size: 0.875rem;
    color: var(--ink4);
    line-height: 1.75;
    margin: 0;
}

/* No results */
.faq-no-results {
    text-align: center;
    padding: 80px 24px;
    color: var(--ink4);
}

.faq-no-results i { font-size: 3.5rem; color: var(--ink5); display: block; margin-bottom: 16px; }
.faq-no-results h3 { font-size: 1.4rem; color: var(--ink); margin-bottom: 8px; }
.faq-no-results p { font-size: 0.95rem; }
.faq-no-results a { color: var(--primary); font-weight: 700; }

/* ── Support Section ── */
.faq-support-sec {
    background: var(--dark);
    padding: 72px 0;
    position: relative;
    overflow: hidden;
}

.faq-support-sec::before {
    content: '';
    position: absolute;
    top: -100px; left: -100px;
    width: 500px; height: 500px;
    background: radial-gradient(circle, rgba(255,77,28,0.12) 0%, transparent 65%);
    pointer-events: none;
}

.faq-support-grid {
    display: grid;
    grid-template-columns: 1fr 1.1fr;
    gap: 60px;
    align-items: center;
    position: relative;
    z-index: 1;
}

/* Left */
.faq-sup-icon {
    width: 72px; height: 72px;
    border-radius: 20px;
    background: rgba(255,77,28,0.15);
    border: 1.5px solid rgba(255,77,28,0.3);
    display: grid; place-items: center;
    font-size: 2rem;
    color: var(--primary);
    margin-bottom: 24px;
}

.faq-sup-main h2 {
    font-size: clamp(1.7rem, 3.5vw, 2.4rem);
    color: #fff;
    line-height: 1.15;
    margin-bottom: 16px;
    letter-spacing: -0.5px;
}

.faq-sup-main h2 em {
    font-style: normal;
    color: var(--primary);
}

.faq-sup-main p {
    font-size: 1rem;
    color: rgba(255,255,255,0.55);
    line-height: 1.75;
    margin-bottom: 32px;
    max-width: 400px;
}

.faq-sup-btns { display: flex; gap: 12px; flex-wrap: wrap; }

.faq-sup-btn-primary {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 14px 28px;
    background: var(--primary);
    color: #fff;
    border-radius: 12px;
    font-weight: 800;
    font-size: 0.9375rem;
    font-family: var(--font);
    transition: all 0.25s ease;
    box-shadow: 0 6px 24px rgba(255,77,28,0.3);
}

.faq-sup-btn-primary:hover {
    background: var(--primary-dark);
    transform: translateY(-2px);
    color: #fff;
}

.faq-sup-btn-ghost {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 13px 24px;
    background: rgba(255,255,255,0.08);
    color: rgba(255,255,255,0.85);
    border-radius: 12px;
    font-weight: 700;
    font-size: 0.9375rem;
    font-family: var(--font);
    border: 1.5px solid rgba(255,255,255,0.15);
    transition: all 0.25s ease;
}

.faq-sup-btn-ghost:hover {
    background: rgba(255,255,255,0.14);
    color: #fff;
    transform: translateY(-2px);
}

/* Right: Channel cards */
.faq-sup-channels {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.faq-ch-card {
    display: flex;
    align-items: center;
    gap: 16px;
    padding: 18px 22px;
    background: rgba(255,255,255,0.05);
    border: 1px solid rgba(255,255,255,0.08);
    border-radius: 16px;
    transition: all 0.25s ease;
    text-decoration: none;
}

.faq-ch-card:not(.no-link):hover {
    background: rgba(255,255,255,0.09);
    border-color: rgba(255,255,255,0.15);
    transform: translateX(6px);
}

.faq-ch-ic {
    width: 46px; height: 46px;
    border-radius: 12px;
    display: grid; place-items: center;
    font-size: 1.3rem;
    flex-shrink: 0;
}

.faq-ch-body { flex: 1; }
.faq-ch-body strong { display: block; font-size: 0.9rem; font-weight: 800; color: #fff; margin-bottom: 2px; }
.faq-ch-body span { display: block; font-size: 0.78rem; color: rgba(255,255,255,0.45); margin-bottom: 2px; }
.faq-ch-body em { font-style: normal; font-size: 0.72rem; color: rgba(255,255,255,0.3); }

.faq-ch-arr { color: rgba(255,255,255,0.2); font-size: 1.2rem; flex-shrink: 0; transition: all 0.22s; }
.faq-ch-card:hover .faq-ch-arr { color: rgba(255,255,255,0.5); transform: translateX(4px); }

/* Live dot */
.live-dot {
    display: inline-block;
    width: 6px; height: 6px;
    background: #10b981;
    border-radius: 50%;
    margin-right: 4px;
    animation: pulse-dot 1.8s ease-in-out infinite;
    vertical-align: middle;
}

/* ── Responsive ── */
@media (max-width: 1024px) {
    .faq-grid-2 { grid-template-columns: 1fr; }
    .faq-support-grid { grid-template-columns: 1fr; gap: 40px; }
    .fqs-card { padding: 0 18px; min-width: 110px; }
}

@media (max-width: 768px) {
    .faq-body-sec { padding: 40px 0; }
    .faq-stats-strip { padding: 18px 16px; gap: 8px; }
    .fqs-sep { display: none; }
    .fqs-card { padding: 8px 12px; flex: 1; min-width: 80px; flex-direction: column; text-align: center; gap: 6px; }
    .faq-group-hd { padding: 16px 18px; flex-wrap: wrap; }
    .faq-support-sec { padding: 52px 0; }
    .faq-sup-channels { gap: 8px; }
    .faq-ch-card { padding: 14px 16px; }
}

@media (max-width: 480px) {
    .faq-topbar { top: 75px; }
    .faq-cats { justify-content: flex-start; }
    .faq-cat-pill { padding: 10px 14px; font-size: 0.8rem; }
    .faq-group-cnt { display: none; }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {

    /* ── Category Filter ── */
    const pills  = document.querySelectorAll('.faq-cat-pill');
    const groups = document.querySelectorAll('.faq-group');

    pills.forEach(pill => {
        pill.addEventListener('click', () => {
            pills.forEach(p => p.classList.remove('on'));
            pill.classList.add('on');
            const cat = pill.dataset.cat;
            groups.forEach(g => {
                g.style.display = (cat === 'all' || g.dataset.cat === cat) ? 'block' : 'none';
            });
            updateCount();
        });
    });

    /* ── Live Search ── */
    const searchInput = document.getElementById('faqSearch');
    const countEl     = document.getElementById('faqCount');
    const noResults   = document.getElementById('faqNoResults');

    function updateCount() {
        const visible = document.querySelectorAll('.fq2:not([style*="display: none"])').length;
        const total   = document.querySelectorAll('.fq2').length;
        countEl.textContent = visible < total ? `${visible} of ${total} results` : '';
    }

    searchInput.addEventListener('input', function() {
        const q = this.value.toLowerCase().trim();
        let anyVisible = false;

        // Reset category pills
        if (q) {
            pills.forEach(p => p.classList.remove('on'));
            document.querySelector('[data-cat="all"]').classList.add('on');
        }

        groups.forEach(group => {
            group.style.display = 'block';
            let groupHasVisible = false;
            group.querySelectorAll('.fq2').forEach(item => {
                const text = item.dataset.question || '';
                const match = !q || text.includes(q);
                item.style.display = match ? '' : 'none';
                if (match) { groupHasVisible = true; anyVisible = true; }
            });
            group.style.display = groupHasVisible ? 'block' : 'none';
        });

        noResults.style.display = anyVisible || !q ? 'none' : 'block';
        updateCount();
    });

});
</script>
@endpush
