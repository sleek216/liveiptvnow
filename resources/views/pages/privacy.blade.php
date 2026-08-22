@extends('layouts.app')
@section('title', 'Privacy Policy — Live IPTV Now')

@section('content')
@include('layouts.page-hero', [
    'heroImage'      => '/page_hero_bg.png',
    'breadcrumb'     => 'Privacy Policy',
    'badge'          => 'Privacy — Your Data is Safe With Us',
    'badgeIcon'      => 'ri-shield-check-fill',
    'title'          => 'Privacy',
    'accent'         => 'Policy',
    'subtitle'       => 'Your privacy is our top priority. This policy explains exactly how we collect, use, and protect your personal information — with full transparency.',
    'desc'           => 'We never sell your personal data to third parties. All information is encrypted with 256-bit SSL and stored securely. You are always in full control of your data.',
    'highlights' => [
        ['icon' => 'ri-eye-off-fill',      'text' => 'We never sell your personal data to anyone',   'sub' => 'Your information stays private — always'],
        ['icon' => 'ri-shield-check-fill', 'text' => '256-bit SSL encryption on all data transfers', 'sub' => 'Bank-grade security for your information'],
        ['icon' => 'ri-user-settings-fill','text' => 'Full control over your personal data & rights', 'sub' => 'Request deletion or export anytime'],
    ],
    'ctaPrimary'     => 'Read Policy',
    'ctaPrimaryUrl'  => '#s1',
    'ctaPrimaryIcon' => 'ri-shield-check-line',
    'ctaGhost'       => 'Contact Us',
    'ctaGhostUrl'    => route('contact'),
    'ctaGhostIcon'   => 'ri-mail-line',
    'stats' => [
        ['icon' => 'ri-eye-off-fill',       'text' => 'Never Sold'],
        ['icon' => 'ri-shield-check-fill',  'text' => '256-bit SSL'],
        ['icon' => 'ri-user-settings-fill', 'text' => 'Your Rights'],
        ['icon' => 'ri-lock-fill',          'text' => 'Fully Secure'],
    ],
])

<section class="legal-sec">
    <div class="wrap">
        <div class="legal-layout">
            <aside class="legal-side" data-aos="fade-right">
                <div class="legal-nav-box">
                    <h4><i class="ri-list-check"></i> Contents</h4>
                    <nav>
                        <a href="#s1" class="legal-nav-link on"><span>01</span> Introduction</a>
                        <a href="#s2" class="legal-nav-link"><span>02</span> Data We Collect</a>
                        <a href="#s3" class="legal-nav-link"><span>03</span> How We Use It</a>
                        <a href="#s4" class="legal-nav-link"><span>04</span> Data Security</a>
                        <a href="#s5" class="legal-nav-link"><span>05</span> Your Rights</a>
                        <a href="#s6" class="legal-nav-link"><span>06</span> Contact</a>
                    </nav>
                </div>
                <div class="legal-side-note">
                    <i class="ri-shield-check-line"></i>
                    <p>Your data is protected with 256-bit SSL encryption. We never sell your information.</p>
                </div>
            </aside>

            <div class="legal-body" data-aos="fade-up">
                <section id="s1" class="legal-section">
                    <div class="legal-sec-head"><span class="legal-num">01</span><h2>Introduction</h2></div>
                    <p>Live IPTV Now ("we", "our", "us") is committed to protecting your privacy. This Privacy Policy describes how we collect, use, and share information about you when you use our services.</p>
                    <p>By using our services, you agree to the collection and use of information in accordance with this policy. If you have any questions, please contact us at <a href="mailto:privacy@liveiptvnow.com" style="color:var(--primary);font-weight:700;">privacy@liveiptvnow.com</a>.</p>
                </section>

                <section id="s2" class="legal-section">
                    <div class="legal-sec-head"><span class="legal-num">02</span><h2>Information We Collect</h2></div>
                    <p>We collect information you provide directly to us and information collected automatically when you use our services.</p>
                    <div class="legal-two-col">
                        <div class="legal-info-box">
                            <div class="lib-head"><i class="ri-user-fill"></i><strong>Personal Data</strong></div>
                            <ul>
                                <li>Name and email address</li>
                                <li>Billing and payment details</li>
                                <li>Account credentials</li>
                                <li>Communication preferences</li>
                            </ul>
                        </div>
                        <div class="legal-info-box">
                            <div class="lib-head"><i class="ri-computer-fill"></i><strong>Technical Data</strong></div>
                            <ul>
                                <li>IP address and device IDs</li>
                                <li>Browser type and version</li>
                                <li>Viewing history and habits</li>
                                <li>Connection timestamps</li>
                            </ul>
                        </div>
                    </div>
                </section>

                <section id="s3" class="legal-section">
                    <div class="legal-sec-head"><span class="legal-num">03</span><h2>How We Use Your Data</h2></div>
                    <p>We use the information we collect for the following purposes only:</p>
                    <ul class="legal-checks">
                        <li><i class="ri-check-fill"></i> Provide, operate, and maintain our streaming services</li>
                        <li><i class="ri-check-fill"></i> Process transactions and send billing receipts</li>
                        <li><i class="ri-check-fill"></i> Send important service updates and notifications</li>
                        <li><i class="ri-check-fill"></i> Detect, prevent, and address fraud or technical issues</li>
                        <li><i class="ri-check-fill"></i> Improve and personalize your experience</li>
                    </ul>
                    <div class="legal-highlight" style="margin-top:20px;">
                        <i class="ri-eye-off-fill"></i>
                        <div>
                            <strong>We Do NOT Sell Your Data</strong>
                            <p>We never sell, trade, or rent your personal information to third parties. Your data is used exclusively to provide and improve your service.</p>
                        </div>
                    </div>
                </section>

                <section id="s4" class="legal-section">
                    <div class="legal-sec-head"><span class="legal-num">04</span><h2>Data Security</h2></div>
                    <div class="legal-highlight">
                        <i class="ri-shield-check-fill"></i>
                        <div>
                            <strong>256-bit SSL Encryption</strong>
                            <p>We use industry-standard SSL encryption to protect your data in transit and at rest. Regular security audits are conducted to ensure ongoing protection.</p>
                        </div>
                    </div>
                    <p style="margin-top:16px;">While we implement safeguards, no method of transmission over the Internet or electronic storage is 100% secure. We strive to use commercially acceptable means to protect your personal information.</p>
                </section>

                <section id="s5" class="legal-section">
                    <div class="legal-sec-head"><span class="legal-num">05</span><h2>Your Rights</h2></div>
                    <p>Under applicable data protection laws, you have the following rights regarding your personal information:</p>
                    <ul class="legal-checks">
                        <li><i class="ri-check-fill"></i> Right to access your personal data</li>
                        <li><i class="ri-check-fill"></i> Right to correct inaccurate data</li>
                        <li><i class="ri-check-fill"></i> Right to request deletion of your data</li>
                        <li><i class="ri-check-fill"></i> Right to data portability</li>
                        <li><i class="ri-check-fill"></i> Right to withdraw consent at any time</li>
                    </ul>
                </section>

                <section id="s6" class="legal-section" style="margin-bottom:0;">
                    <div class="legal-sec-head"><span class="legal-num">06</span><h2>Contact Us</h2></div>
                    <p>For any privacy-related questions or requests, please contact our Privacy team:</p>
                    <div class="legal-contact-row">
                        <a href="mailto:privacy@liveiptvnow.com" class="legal-contact-btn"><i class="ri-mail-fill"></i> privacy@liveiptvnow.com</a>
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
.legal-two-col { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-top: 20px; }
.legal-info-box { background: var(--bg2); border: var(--bdr); border-radius: 14px; padding: 22px; }
.lib-head { display: flex; align-items: center; gap: 10px; margin-bottom: 14px; }
.lib-head i { font-size: 1.1rem; color: var(--primary); }
.lib-head strong { font-size: 0.95rem; color: var(--ink); }
.legal-info-box ul { display: flex; flex-direction: column; gap: 8px; }
.legal-info-box li { font-size: 0.86rem; color: var(--ink4); padding-left: 14px; position: relative; }
.legal-info-box li::before { content:'•'; position:absolute; left:0; color:var(--primary); }
@media(max-width:640px) { .legal-two-col { grid-template-columns: 1fr; } }
</style>
@endpush
