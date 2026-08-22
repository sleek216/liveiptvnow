@extends('layouts.app')
@section('title', 'Refund Policy — Live IPTV Now | 24-Hour Guarantee')

@section('content')
@include('layouts.page-hero', [
    'heroImage'      => '/page_hero_bg.png',
    'breadcrumb'     => 'Refund Policy',
    'badge'          => 'Guarantee — 24-Hour Money Back',
    'badgeIcon'      => 'ri-refund-2-fill',
    'title'          => 'Refund',
    'accent'         => 'Policy',
    'subtitle'       => 'Your satisfaction is our priority. We offer a transparent, hassle-free 24-hour money-back guarantee on all new subscriptions — no questions asked.',
    'desc'           => 'Not happy within 24 hours? Get a full refund. We stand behind the quality of our service. Contact our support team and we will process your refund promptly.',
    'highlights' => [
        ['icon' => 'ri-verified-badge-fill','text' => '24-hour money-back guarantee on all plans',   'sub' => 'Full refund — no questions, no conditions'],
        ['icon' => 'ri-timer-fill',         'text' => 'Refunds processed within 3–5 business days',  'sub' => 'Returned to your original payment method'],
        ['icon' => 'ri-customer-service-2-fill','text' => 'Support team resolves most issues instantly','sub' => 'We try to fix problems before refunds are needed'],
    ],
    'ctaPrimary'     => 'Request Refund',
    'ctaPrimaryUrl'  => route('contact'),
    'ctaPrimaryIcon' => 'ri-refund-2-line',
    'ctaGhost'       => 'Contact Support',
    'ctaGhostUrl'    => route('contact'),
    'ctaGhostIcon'   => 'ri-headphone-line',
    'stats' => [
        ['icon' => 'ri-verified-badge-fill','text' => '24h Guarantee'],
        ['icon' => 'ri-timer-fill',         'text' => '3–5 Day Refund'],
        ['icon' => 'ri-headphone-fill',     'text' => '24/7 Support'],
        ['icon' => 'ri-shield-check-fill',  'text' => '100% Safe'],
    ],
])

<section class="rf-sec">
    <div class="wrap">
        <div class="rf-content">

            {{-- Guarantee Banner --}}
            <div class="rf-banner" data-aos="fade-up">
                <div class="rf-banner-ic"><i class="ri-verified-badge-fill"></i></div>
                <div class="rf-banner-txt">
                    <h2>24-Hour Money-Back Guarantee</h2>
                    <p>Not satisfied within 24 hours of purchase? Contact us for a full refund — no questions asked. We stand behind the quality of our service.</p>
                </div>
                <a href="{{ route('contact') }}" class="btn btn-white" style="flex-shrink:0;">Request Refund</a>
            </div>

            {{-- Eligible / Not Eligible --}}
            <div class="rf-compare" data-aos="fade-up">
                <div class="rf-col rf-yes">
                    <div class="rf-col-head"><div class="rf-col-ic"><i class="ri-checkbox-circle-fill"></i></div><h3>Eligible for Refund</h3></div>
                    <ul>
                        <li><i class="ri-check-fill"></i> New subscribers within 24 hours of purchase</li>
                        <li><i class="ri-check-fill"></i> Unresolvable technical faults on our end</li>
                        <li><i class="ri-check-fill"></i> Accidental duplicate orders</li>
                        <li><i class="ri-check-fill"></i> Significant service downtime (&gt;24 hours)</li>
                    </ul>
                </div>
                <div class="rf-col rf-no">
                    <div class="rf-col-head"><div class="rf-col-ic"><i class="ri-forbid-fill"></i></div><h3>Not Eligible</h3></div>
                    <ul>
                        <li><i class="ri-close-fill"></i> Requests after the 24-hour window</li>
                        <li><i class="ri-close-fill"></i> Subscription renewals and upgrades</li>
                        <li><i class="ri-close-fill"></i> Policy violations or abuse of service</li>
                        <li><i class="ri-close-fill"></i> Change of mind after significant use</li>
                    </ul>
                </div>
            </div>

            {{-- Process Steps --}}
            <div class="rf-process" data-aos="fade-up">
                <h2>How the Refund <em>Process Works</em></h2>
                <div class="rf-steps">
                    <div class="rfs"><div class="rfs-num">01</div><i class="ri-message-3-fill"></i><h4>Contact Support</h4><p>Reach us via email, WhatsApp, or live chat within 24 hours of purchase.</p></div>
                    <div class="rfs-arrow"><i class="ri-arrow-right-line"></i></div>
                    <div class="rfs"><div class="rfs-num">02</div><i class="ri-file-list-3-fill"></i><h4>Provide Details</h4><p>Share your order ID and a brief reason for the refund request.</p></div>
                    <div class="rfs-arrow"><i class="ri-arrow-right-line"></i></div>
                    <div class="rfs"><div class="rfs-num">03</div><i class="ri-search-fill"></i><h4>Quick Review</h4><p>Our team reviews your request instantly and confirms eligibility.</p></div>
                    <div class="rfs-arrow"><i class="ri-arrow-right-line"></i></div>
                    <div class="rfs"><div class="rfs-num">04</div><i class="ri-bank-card-fill"></i><h4>Funds Returned</h4><p>Refund is processed within 3–5 business days to your original payment method.</p></div>
                </div>
            </div>

            {{-- CTA --}}
            <div class="rf-cta" data-aos="fade-up">
                <div class="rf-cta-ic"><i class="ri-customer-service-2-fill"></i></div>
                <div class="rf-cta-txt">
                    <h3>Need Immediate Assistance?</h3>
                    <p>Our support team is online 24/7. We resolve most issues before a refund is even needed.</p>
                </div>
                <div class="rf-cta-btns">
                    <a href="{{ route('contact') }}" class="btn btn-primary"><i class="ri-chat-1-fill"></i> Chat with Us</a>
                    <a href="{{ route('faq') }}" class="btn btn-outline">View FAQ</a>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
.rf-sec { padding: 72px 0 100px; }
.rf-content { max-width: 940px; margin: 0 auto; display: flex; flex-direction: column; gap: 28px; }

/* Banner */
.rf-banner {
    display: flex; align-items: center; gap: 24px;
    background: linear-gradient(135deg, rgba(16,185,129,0.08), rgba(16,185,129,0.04));
    border: 1px solid rgba(16,185,129,0.2);
    border-radius: 20px; padding: 36px 40px;
    flex-wrap: wrap;
}
.rf-banner-ic {
    width: 72px; height: 72px; border-radius: 50%;
    background: rgba(16,185,129,0.12);
    display: grid; place-items: center;
    font-size: 2.4rem; color: #10b981; flex-shrink: 0;
}
.rf-banner-txt { flex: 1; min-width: 200px; }
.rf-banner-txt h2 { font-size: 1.5rem; color: var(--ink); margin-bottom: 8px; }
.rf-banner-txt p { color: var(--ink4); line-height: 1.65; font-size: 0.95rem; }

/* Compare */
.rf-compare { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
.rf-col {
    background: #fff; border-radius: 18px; padding: 32px 28px;
    box-shadow: var(--s1); border: 1.5px solid #e5e7eb;
}
.rf-col-head { display: flex; align-items: center; gap: 14px; margin-bottom: 22px; }
.rf-col-ic {
    width: 46px; height: 46px; border-radius: 12px;
    display: grid; place-items: center; font-size: 1.3rem;
}
.rf-yes .rf-col-ic { background: rgba(16,185,129,0.1); color: #10b981; border: 1px solid rgba(16,185,129,0.2); }
.rf-no .rf-col-ic { background: rgba(239,68,68,0.1); color: #ef4444; border: 1px solid rgba(239,68,68,0.2); }
.rf-col h3 { font-size: 1.1rem; color: var(--ink); }
.rf-yes { border-color: rgba(16,185,129,0.2); }
.rf-no { border-color: rgba(239,68,68,0.15); }
.rf-col ul { display: flex; flex-direction: column; gap: 12px; }
.rf-col li { display: flex; align-items: center; gap: 10px; font-size: 0.9rem; color: var(--ink3); font-weight: 600; }
.rf-yes li i { color: #10b981; font-size: 0.9rem; width: 20px; height: 20px; background: rgba(16,185,129,0.1); border-radius: 50%; display: grid; place-items: center; font-size: 0.75rem; flex-shrink: 0; }
.rf-no li i { color: #ef4444; font-size: 0.9rem; width: 20px; height: 20px; background: rgba(239,68,68,0.1); border-radius: 50%; display: grid; place-items: center; font-size: 0.75rem; flex-shrink: 0; }

/* Process */
.rf-process {
    background: #fff; border: var(--bdr);
    border-radius: 20px; padding: 48px;
    box-shadow: var(--s2); text-align: center;
}
.rf-process h2 { font-size: 1.6rem; color: var(--ink); margin-bottom: 36px; }
.rf-process h2 em { font-style: normal; color: var(--primary); }
.rf-steps { display: flex; align-items: flex-start; justify-content: center; gap: 0; flex-wrap: wrap; }
.rfs { flex: 1; min-width: 140px; max-width: 180px; text-align: center; }
.rfs-num {
    width: 40px; height: 40px; border-radius: 50%;
    background: var(--primary); color: #fff;
    display: grid; place-items: center;
    font-size: 0.8rem; font-weight: 900;
    margin: 0 auto 12px;
}
.rfs > i { font-size: 1.8rem; color: var(--primary); display: block; margin-bottom: 12px; }
.rfs h4 { font-size: 0.95rem; color: var(--ink); margin-bottom: 6px; }
.rfs p { font-size: 0.8rem; color: var(--ink4); line-height: 1.55; }
.rfs-arrow { color: var(--ink5); font-size: 1.2rem; padding-top: 55px; flex-shrink: 0; padding-left: 8px; padding-right: 8px; }

/* CTA */
.rf-cta {
    display: flex; align-items: center; gap: 20px;
    background: var(--dark); border-radius: 18px;
    padding: 36px 40px; flex-wrap: wrap;
    position: relative; overflow: hidden;
}
.rf-cta::before { content:''; position:absolute; inset:0; background: radial-gradient(ellipse at 20% 50%,rgba(255,77,28,0.1),transparent 50%); pointer-events:none; }
.rf-cta-ic {
    width: 56px; height: 56px; border-radius: 14px;
    background: var(--primary); display: grid; place-items: center;
    font-size: 1.5rem; color: #fff; flex-shrink: 0;
}
.rf-cta-txt { flex: 1; min-width: 200px; }
.rf-cta-txt h3 { font-size: 1.2rem; color: #fff; margin-bottom: 5px; }
.rf-cta-txt p { font-size: 0.88rem; color: rgba(255,255,255,0.55); }
.rf-cta-btns { display: flex; gap: 10px; flex-shrink: 0; flex-wrap: wrap; }

@media(max-width:768px) {
    .rf-compare { grid-template-columns: 1fr; }
    .rf-process { padding: 32px 24px; }
    .rfs-arrow { display: none; }
    .rf-steps { gap: 24px; }
    .rf-banner { flex-direction: column; text-align: center; padding: 28px 24px; }
    .rf-banner-ic { margin: 0 auto; }
    .rf-cta { flex-direction: column; text-align: center; padding: 28px; }
    .rf-cta-btns { justify-content: center; width: 100%; }
}
</style>
@endpush
