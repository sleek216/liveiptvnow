@extends('layouts.app')
@section('title', 'Terms of Service — Live IPTV Now')

@section('content')
@include('layouts.page-hero', [
    'heroImage'      => '/page_hero_bg.png',
    'breadcrumb'     => 'Terms of Service',
    'badge'          => 'Legal — Last Updated January 2026',
    'badgeIcon'      => 'ri-file-text-fill',
    'title'          => 'Terms of',
    'accent'         => 'Service',
    'subtitle'       => 'Please read these terms carefully before using our services. By using Live IPTV Now, you agree to these terms. Last updated: January 2026.',
    'desc'           => 'These terms govern your use of our IPTV service. We keep them clear and fair. If you have questions, our support team is always happy to explain anything.',
    'highlights' => [
        ['icon' => 'ri-shield-check-fill', 'text' => 'Transparent, fair terms with no hidden clauses',  'sub' => 'Simple language — no legal jargon'],
        ['icon' => 'ri-bank-card-fill',    'text' => 'No auto-renewal without your explicit consent',    'sub' => 'You are always in full control of your subscription'],
        ['icon' => 'ri-headphone-fill',    'text' => 'Questions? Our team explains any clause 24/7',     'sub' => 'Contact us anytime via chat or email'],
    ],
    'ctaPrimary'     => 'Read Full Terms',
    'ctaPrimaryUrl'  => '#t1',
    'ctaPrimaryIcon' => 'ri-file-text-line',
    'ctaGhost'       => 'Contact Us',
    'ctaGhostUrl'    => route('contact'),
    'ctaGhostIcon'   => 'ri-chat-1-line',
    'stats' => [
        ['icon' => 'ri-file-text-fill',    'text' => 'Clear Terms'],
        ['icon' => 'ri-shield-check-fill', 'text' => 'SSL Secured'],
        ['icon' => 'ri-bank-card-fill',    'text' => 'No Auto-Renew'],
        ['icon' => 'ri-headphone-fill',    'text' => '24/7 Support'],
    ],
])

<section class="legal-sec">
    <div class="wrap">
        <div class="legal-layout">
            {{-- Sidebar --}}
            <aside class="legal-side" data-aos="fade-right">
                <div class="legal-nav-box">
                    <h4><i class="ri-list-check"></i> Contents</h4>
                    <nav>
                        <a href="#t1" class="legal-nav-link on"><span>01</span> Acceptance</a>
                        <a href="#t2" class="legal-nav-link"><span>02</span> Services</a>
                        <a href="#t3" class="legal-nav-link"><span>03</span> Payments</a>
                        <a href="#t4" class="legal-nav-link"><span>04</span> Acceptable Use</a>
                        <a href="#t5" class="legal-nav-link"><span>05</span> Contact</a>
                    </nav>
                </div>
                <div class="legal-side-note">
                    <i class="ri-information-line"></i>
                    <p>Questions about our terms? <a href="{{ route('contact') }}">Contact our team</a> — we're happy to clarify anything.</p>
                </div>
            </aside>

            {{-- Body --}}
            <div class="legal-body" data-aos="fade-up">
                <section id="t1" class="legal-section">
                    <div class="legal-sec-head"><span class="legal-num">01</span><h2>Acceptance of Terms</h2></div>
                    <p>By accessing or using Live IPTV Now services, you agree to be bound by these Terms of Service and all applicable laws and regulations. If you do not agree with any part of these terms, you may not use our services.</p>
                    <p>We reserve the right to update these terms at any time. Continued use of our services following any changes constitutes your acceptance of the new terms.</p>
                </section>

                <section id="t2" class="legal-section">
                    <div class="legal-sec-head"><span class="legal-num">02</span><h2>Services Provided</h2></div>
                    <p>Live IPTV Now provides internet-based television streaming services including the following features:</p>
                    <ul class="legal-checks">
                        <li><i class="ri-check-fill"></i> Live TV streaming in SD, HD, FHD, and 4K quality</li>
                        <li><i class="ri-check-fill"></i> Video On Demand (VOD) library of 100,000+ titles</li>
                        <li><i class="ri-check-fill"></i> Electronic Program Guide (EPG) support</li>
                        <li><i class="ri-check-fill"></i> Multi-device simultaneous streaming</li>
                        <li><i class="ri-check-fill"></i> 24/7 technical support</li>
                    </ul>
                </section>

                <section id="t3" class="legal-section">
                    <div class="legal-sec-head"><span class="legal-num">03</span><h2>Payments & Billing</h2></div>
                    <div class="legal-highlight">
                        <i class="ri-shield-check-fill"></i>
                        <div>
                            <strong>Secure Payments</strong>
                            <p>We accept Credit Cards, PayPal, and major cryptocurrencies. All transactions are secured with 256-bit SSL encryption.</p>
                        </div>
                    </div>
                    <p style="margin-top:18px;">Subscription fees are charged upfront for the selected duration. We do not auto-renew subscriptions without explicit consent. All prices are displayed in USD.</p>
                </section>

                <section id="t4" class="legal-section">
                    <div class="legal-sec-head"><span class="legal-num">04</span><h2>Acceptable Use</h2></div>
                    <p>You agree to use our services only for lawful, personal, non-commercial purposes. The following actions are strictly prohibited:</p>
                    <div class="legal-prohibited">
                        <ul>
                            <li><i class="ri-close-fill"></i> Sharing login credentials beyond your plan's device limit</li>
                            <li><i class="ri-close-fill"></i> Reselling or sub-licensing access without written permission</li>
                            <li><i class="ri-close-fill"></i> Recording and redistributing streamed content</li>
                            <li><i class="ri-close-fill"></i> Using automated tools to access or scrape the service</li>
                        </ul>
                    </div>
                </section>

                <section id="t5" class="legal-section" style="margin-bottom:0;">
                    <div class="legal-sec-head"><span class="legal-num">05</span><h2>Contact Us</h2></div>
                    <p>If you have questions about these Terms, please do not hesitate to reach out:</p>
                    <div class="legal-contact-row">
                        <a href="mailto:support@liveiptvnow.com" class="legal-contact-btn"><i class="ri-mail-fill"></i> support@liveiptvnow.com</a>
                        <a href="{{ route('contact') }}" class="legal-contact-btn"><i class="ri-chat-1-fill"></i> Contact Form</a>
                    </div>
                </section>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
.legal-sec { padding: 72px 0 100px; }
.legal-layout { display: grid; grid-template-columns: 260px 1fr; gap: 40px; align-items: start; }

/* Sidebar */
.legal-side { position: sticky; top: 90px; display: flex; flex-direction: column; gap: 16px; }
.legal-nav-box { background: #fff; border: var(--bdr); border-radius: 16px; padding: 24px; box-shadow: var(--s1); }
.legal-nav-box h4 { font-size: 0.8rem; text-transform: uppercase; letter-spacing: 2px; color: var(--ink5); margin-bottom: 16px; display: flex; align-items: center; gap: 6px; }
.legal-nav-box nav { display: flex; flex-direction: column; gap: 6px; }
.legal-nav-link {
    display: flex; align-items: center; gap: 10px;
    padding: 10px 12px; border-radius: 10px;
    font-size: 0.88rem; font-weight: 700; color: var(--ink4);
    transition: var(--t); border: 1.5px solid transparent;
}
.legal-nav-link:hover { color: var(--primary); background: var(--primary-soft); }
.legal-nav-link.on { color: var(--primary); background: var(--primary-soft); border-color: var(--primary-glow); }
.legal-nav-link span { font-size: 0.7rem; color: var(--ink5); font-weight: 800; width: 22px; flex-shrink: 0; }
.legal-nav-link.on span { color: var(--primary); }

.legal-side-note {
    background: var(--bg2); border: var(--bdr);
    border-radius: 12px; padding: 16px;
    display: flex; gap: 10px; align-items: flex-start;
    font-size: 0.82rem; color: var(--ink4); line-height: 1.55;
}
.legal-side-note i { color: var(--primary); margin-top: 2px; flex-shrink: 0; }
.legal-side-note a { color: var(--primary); font-weight: 700; }

/* Body */
.legal-body {
    background: #fff; border: var(--bdr);
    border-radius: 20px; padding: 52px;
    box-shadow: var(--s2);
}
.legal-section { margin-bottom: 52px; padding-bottom: 52px; border-bottom: var(--bdr); }
.legal-section:last-child { margin-bottom: 0; padding-bottom: 0; border-bottom: none; }
.legal-sec-head { display: flex; align-items: center; gap: 14px; margin-bottom: 20px; }
.legal-num { font-size: 2rem; font-weight: 900; color: var(--primary); opacity: 0.15; line-height: 1; }
.legal-sec-head h2 { font-size: 1.5rem; color: var(--ink); }
.legal-body p { font-size: 0.95rem; color: var(--ink4); line-height: 1.75; margin-bottom: 14px; }

.legal-checks { display: flex; flex-direction: column; gap: 10px; margin-top: 16px; }
.legal-checks li { display: flex; align-items: center; gap: 10px; font-size: 0.92rem; color: var(--ink3); font-weight: 600; }
.legal-checks i { color: var(--success); font-size: 1rem; width: 22px; height: 22px; background: rgba(16,185,129,0.1); border-radius: 50%; display: grid; place-items: center; font-size: 0.8rem; flex-shrink: 0; }

.legal-highlight {
    display: flex; gap: 18px; align-items: flex-start;
    background: var(--primary-soft); border: 1px solid var(--primary-glow);
    border-radius: 14px; padding: 22px 24px;
}
.legal-highlight > i { font-size: 1.8rem; color: var(--primary); flex-shrink: 0; margin-top: 2px; }
.legal-highlight strong { display: block; font-size: 1rem; color: var(--ink); margin-bottom: 5px; }
.legal-highlight p { font-size: 0.88rem; color: var(--ink4); margin: 0; }

.legal-prohibited {
    background: rgba(239,68,68,0.04);
    border: 1px solid rgba(239,68,68,0.15);
    border-radius: 14px; padding: 22px 24px;
    margin-top: 16px;
}
.legal-prohibited ul { display: flex; flex-direction: column; gap: 10px; }
.legal-prohibited li { display: flex; align-items: center; gap: 10px; font-size: 0.9rem; color: var(--ink3); }
.legal-prohibited i { color: #ef4444; font-size: 0.9rem; width: 22px; height: 22px; background: rgba(239,68,68,0.1); border-radius: 50%; display: grid; place-items: center; flex-shrink: 0; }

.legal-contact-row { display: flex; gap: 12px; flex-wrap: wrap; margin-top: 16px; }
.legal-contact-btn {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 12px 22px; border-radius: 10px;
    background: var(--bg2); border: var(--bdr);
    font-size: 0.88rem; font-weight: 700; color: var(--ink3);
    transition: var(--t);
}
.legal-contact-btn:hover { border-color: var(--primary); color: var(--primary); background: var(--primary-soft); }

@media(max-width:1024px) { .legal-layout { grid-template-columns: 1fr; } .legal-side { position: static; } .legal-nav-box nav { flex-direction: row; flex-wrap: wrap; } .legal-nav-link { flex: 1; min-width: 110px; } }
@media(max-width:640px) { .legal-body { padding: 28px 20px; } }
</style>
@endpush
