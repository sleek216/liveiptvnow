@extends('layouts.app')
@section('title', 'Contact Us — Live IPTV Now | 24/7 Support')

@section('content')

@include('layouts.page-hero', [
    'heroImage'      => '/hero_contact.png',
    'breadcrumb'     => 'Contact',
    'badge'          => 'Support Center — 24/7 Available',
    'badgeIcon'      => 'ri-headphone-fill',
    'title'          => 'We Are Always',
    'accent'         => 'Here For You',
    'subtitle'       => 'Got a question, need help, or want to share feedback? Our expert support team is available 24/7 and responds within minutes.',
    'desc'           => 'Reach us via live chat, WhatsApp, Telegram, or email. We speak English, Arabic, French, Spanish and more. No issue is too big or too small.',
    'highlights' => [
        ['icon' => 'ri-flashlight-fill',  'text' => 'Lightning-fast response — under 1 hour average',  'sub' => 'Live chat & WhatsApp replied within minutes'],
        ['icon' => 'ri-global-fill',      'text' => 'Multi-language support team available 24/7',      'sub' => 'English, Arabic, French, Spanish & more'],
        ['icon' => 'ri-shield-check-fill','text' => '100% secure & confidential communication',        'sub' => 'Your data is never shared with third parties'],
    ],
    'ctaPrimary'     => 'Start Live Chat',
    'ctaPrimaryUrl'  => route('contact'),
    'ctaPrimaryIcon' => 'ri-chat-1-line',
    'ctaGhost'       => 'View FAQ First',
    'ctaGhostUrl'    => route('faq'),
    'ctaGhostIcon'   => 'ri-question-line',
    'stats' => [
        ['icon' => 'ri-time-fill',        'text' => '24/7 Available'],
        ['icon' => 'ri-flashlight-fill',  'text' => '< 1hr Response Time'],
        ['icon' => 'ri-global-fill',      'text' => 'Multi-Language'],
        ['icon' => 'ri-star-fill',        'text' => '4.9★ Rating'],
    ],
])

{{-- Help Hub Grid --}}
<section class="ch-hub-sec">
    <div class="wrap">
        <div class="ch-hub-grid">
            {{-- Method Cards --}}
            <div class="ch-cards" data-aos="fade-up">
                <a href="#" class="ch-card whatsapp">
                    <div class="ch-c-bg"></div>
                    <div class="ch-c-icon"><i class="ri-whatsapp-fill"></i></div>
                    <div class="ch-c-txt">
                        <h4>WhatsApp</h4>
                        <p>Available 24/7 for instant chat and setup help.</p>
                        <span>+1 (800) 123-4567</span>
                    </div>
                    <div class="ch-c-badge">Fastest</div>
                </a>
                
                <a href="#" class="ch-card telegram">
                    <div class="ch-c-bg"></div>
                    <div class="ch-c-icon"><i class="ri-telegram-fill"></i></div>
                    <div class="ch-c-txt">
                        <h4>Telegram</h4>
                        <p>Join our support channel or chat with an agent.</p>
                        <span>@LiveIPTVNow_Help</span>
                    </div>
                </a>

                <a href="mailto:support@liveiptvnow.com" class="ch-card email">
                    <div class="ch-c-bg"></div>
                    <div class="ch-c-icon"><i class="ri-mail-send-fill"></i></div>
                    <div class="ch-c-txt">
                        <h4>Email Support</h4>
                        <p>For detailed inquiries and partnership requests.</p>
                        <span>support@liveiptvnow.com</span>
                    </div>
                </a>

                <div class="ch-card status">
                    <div class="ch-c-bg"></div>
                    <div class="ch-c-icon live"><i class="ri-pulse-fill"></i></div>
                    <div class="ch-c-txt">
                        <h4>Global Status</h4>
                        <p>Daily server health and uptime monitoring.</p>
                        <div class="ch-status-bar">
                            <div class="ch-sb-track"></div>
                            <span class="ch-sb-label">99.9% Uptime</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Main Form Content --}}
            <div class="ch-main">
                <div class="ch-form-wrap" data-aos="fade-left">
                    <div class="ch-form-inner">
                        <div class="ch-form-head">
                            <span class="ch-form-tag">Get in Touch</span>
                            <h2>Direct <em>Message</em></h2>
                            <p>Prefer email? Send us a message and our team will get back to you within 24 hours.</p>
                        </div>

                        @if(session('success'))
                        <div class="ch-alert success">
                            <i class="ri-checkbox-circle-fill"></i>
                            <div><strong>Sent Successfully!</strong><p>{{ session('success') }}</p></div>
                        </div>
                        @endif

                        <form action="{{ route('contact.store') }}" method="POST" class="ch-form">
                            @csrf
                            <div class="ch-form-grid">
                                <div class="ch-field">
                                    <label>Full Name</label>
                                    <div class="ch-input">
                                        <i class="ri-user-smile-line"></i>
                                        <input type="text" name="name" value="{{ old('name') }}" placeholder="What's your name?" required>
                                    </div>
                                    @error('name')<span class="ch-error">{{ $message }}</span>@enderror
                                </div>

                                <div class="ch-field">
                                    <label>Email Address</label>
                                    <div class="ch-input">
                                        <i class="ri-mail-line"></i>
                                        <input type="email" name="email" value="{{ old('email') }}" placeholder="you@example.com" required>
                                    </div>
                                    @error('email')<span class="ch-error">{{ $message }}</span>@enderror
                                </div>

                                <div class="ch-field">
                                    <label>Phone Number (Optional)</label>
                                    <div class="ch-input">
                                        <i class="ri-smartphone-line"></i>
                                        <input type="tel" name="phone" value="{{ old('phone') }}" placeholder="+1 (555) 000-0000">
                                    </div>
                                </div>

                                <div class="ch-field">
                                    <label>Inquiry Topic</label>
                                    <div class="ch-input">
                                        <i class="ri-chat-voice-line"></i>
                                        <select name="subject" required>
                                            <option value="">Select a topic</option>
                                            <option value="General Support">General Support</option>
                                            <option value="Billing & Refund">Billing & Refund</option>
                                            <option value="Installation Help">Installation Help</option>
                                            <option value="Reseller Inquiry">Reseller Inquiry</option>
                                            <option value="Other">Other</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="ch-field full">
                                <label>Your Message</label>
                                <div class="ch-input">
                                    <i class="ri-pencil-line"></i>
                                    <textarea name="message" rows="5" placeholder="Tell us how we can help you..." required>{{ old('message') }}</textarea>
                                </div>
                                @error('message')<span class="ch-error">{{ $message }}</span>@enderror
                            </div>

                            <button type="submit" class="ch-submit">
                                <span>Send My Message</span>
                                <i class="ri-send-plane-fill"></i>
                            </button>
                        </form>
                    </div>
                </div>

                {{-- Side Info / Socials --}}
                <div class="ch-side" data-aos="fade-right">
                    <div class="ch-side-card trust">
                        <div class="ch-st-avatars">
                            <img src="https://i.pravatar.cc/150?u=1" alt="Support Agent">
                            <img src="https://i.pravatar.cc/150?u=2" alt="Support Agent">
                            <img src="https://i.pravatar.cc/150?u=3" alt="Support Agent">
                            <div class="ch-st-count">+12</div>
                        </div>
                        <h4>Expert Support Agent</h4>
                        <p>Our team is online right now. You won't be talking to a bot.</p>
                        <div class="ch-st-badge"><i class="ri-shield-user-fill"></i> Verified Team</div>
                    </div>

                    <div class="ch-side-card socials">
                        <h4>Follow Our <em>Community</em></h4>
                        <p>Get the latest updates, channel list changes, and exclusive deals.</p>
                        <div class="ch-soc-grid">
                            <a href="#" class="ch-soc"><i class="ri-facebook-fill"></i></a>
                            <a href="#" class="ch-soc"><i class="ri-twitter-x-line"></i></a>
                            <a href="#" class="ch-soc"><i class="ri-instagram-fill"></i></a>
                            <a href="#" class="ch-soc"><i class="ri-youtube-fill"></i></a>
                            <a href="#" class="ch-soc"><i class="ri-telegram-fill"></i></a>
                        </div>
                    </div>

                    <a href="{{ route('faq') }}" class="ch-faq-link">
                        <div class="ch-fl-ic"><i class="ri-questionnaire-line"></i></div>
                        <div>
                            <strong>Need instant answers?</strong>
                            <span>Search our detailed FAQ database</span>
                        </div>
                        <i class="ri-arrow-right-line"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
/* ══════════════════════════════════════════════════════════
   CONTACT HELP HUB — Premium Design System
   ══════════════════════════════════════════════════════════ */

.ch-hub-sec {
    padding: 80px 0;
    background: #f8fafc; /* Subtle light background to pop the white cards */
}

.ch-hub-grid {
    display: flex;
    flex-direction: column;
    gap: 40px;
}

/* ── Status Bar Pulse ── */
@keyframes pulse-live {
    0% { transform: scale(0.95); opacity: 0.5; }
    50% { transform: scale(1.05); opacity: 1; }
    100% { transform: scale(0.95); opacity: 0.5; }
}

/* ── Contact Method Cards ── */
.ch-cards {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
}

.ch-card {
    position: relative;
    background: #fff;
    border: 1px solid rgba(226, 232, 240, 0.8);
    border-radius: 20px;
    padding: 28px;
    display: flex;
    flex-direction: column;
    gap: 16px;
    text-decoration: none;
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
}

.ch-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
    border-color: var(--primary);
}

.ch-c-bg {
    position: absolute;
    top: -50px; right: -50px;
    width: 150px; height: 150px;
    background: radial-gradient(circle, var(--primary-soft) 0%, transparent 70%);
    opacity: 0;
    transition: 0.4s;
    z-index: 0;
}
.ch-card:hover .ch-c-bg { opacity: 0.5; top: -20px; right: -20px; }

.ch-c-icon {
    width: 52px; height: 52px;
    border-radius: 14px;
    display: grid; place-items: center;
    font-size: 1.6rem;
    position: relative; z-index: 1;
    transition: 0.4s;
}

.ch-card.whatsapp .ch-c-icon { background: rgba(37, 211, 102, 0.1); color: #25D366; }
.ch-card.telegram .ch-c-icon { background: rgba(0, 136, 204, 0.1); color: #0088cc; }
.ch-card.email .ch-c-icon { background: rgba(59, 130, 246, 0.1); color: #3b82f6; }
.ch-card.status .ch-c-icon { background: rgba(255, 77, 28, 0.1); color: var(--primary); }

.ch-card:hover .ch-c-icon { transform: scale(1.1) rotate(5deg); }

.ch-c-txt { position: relative; z-index: 1; }
.ch-c-txt h4 { font-size: 1.15rem; color: var(--ink); margin-bottom: 6px; }
.ch-c-txt p { font-size: 0.85rem; color: var(--ink4); line-height: 1.5; margin-bottom: 12px; }
.ch-c-txt span { font-size: 0.88rem; font-weight: 800; color: var(--primary); letter-spacing: 0.5px; }

.ch-c-badge {
    position: absolute; top: 20px; right: 20px;
    background: #25D366; color: #fff;
    padding: 4px 10px; border-radius: 30px;
    font-size: 0.65rem; font-weight: 900;
    text-transform: uppercase; letter-spacing: 1px;
}

/* Status Bar in card */
.ch-status-bar { margin-top: 10px; }
.ch-sb-track { width: 100%; height: 6px; background: #eef2f6; border-radius: 10px; position: relative; overflow: hidden; }
.ch-sb-track::after { content:''; position:absolute; left:0; top:0; height:100%; width:99.9%; background:#25D366; border-radius:10px; }
.ch-sb-label { font-size: 0.75rem; color: #25D366; font-weight: 800; margin-top: 5px; display: block; }

/* ── Main Layout 2-col ── */
.ch-main {
    display: grid;
    grid-template-columns: 1.6fr 1fr;
    gap: 40px;
    align-items: start;
}

/* ── Form Wrap ── */
.ch-form-wrap {
    background: #fff;
    border-radius: 24px;
    padding: 48px;
    border: 1px solid rgba(226, 232, 240, 0.8);
    box-shadow: 0 10px 40px rgba(0,0,0,0.04);
}

.ch-form-head { margin-bottom: 40px; }
.ch-form-tag { 
    display: inline-block; padding: 5px 14px; 
    background: var(--primary-soft); color: var(--primary); 
    font-size: 0.75rem; font-weight: 900; 
    text-transform: uppercase; letter-spacing: 1.5px;
    border-radius: 30px; margin-bottom: 12px;
}
.ch-form-head h2 { font-size: 2.2rem; color: var(--ink); margin-bottom: 10px; }
.ch-form-head h2 em { font-style: normal; color: var(--primary); }
.ch-form-head p { color: var(--ink4); line-height: 1.6; }

.ch-form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    margin-bottom: 20px;
}

.ch-field { display: flex; flex-direction: column; gap: 8px; }
.ch-field.full { grid-column: 1 / -1; }
.ch-field label { font-size: 0.88rem; font-weight: 700; color: var(--ink2); margin-left: 4px; }

.ch-input { position: relative; }
.ch-input i { 
    position: absolute; left: 16px; top: 18px; 
    font-size: 1.2rem; color: #94a3b8; 
    transition: 0.3s; pointer-events: none;
}
.ch-input textarea ~ i { top: 16px; }

.ch-input input, 
.ch-input select, 
.ch-input textarea {
    width: 100%;
    padding: 16px 16px 16px 48px;
    background: #f8fafc;
    border: 1.5px solid #f1f5f9;
    border-radius: 14px;
    font-family: var(--font);
    font-size: 1rem;
    color: var(--ink);
    transition: all 0.3s;
}

.ch-input input:focus, 
.ch-input select:focus, 
.ch-input textarea:focus {
    background: #fff;
    border-color: var(--primary);
    box-shadow: 0 0 0 4px var(--primary-glow);
    outline: none;
}

.ch-input:focus-within i { color: var(--primary); transform: scale(1.1); }

.ch-submit {
    margin-top: 24px;
    width: 100%;
    padding: 18px;
    background: var(--primary);
    color: #fff;
    border: none;
    border-radius: 14px;
    font-size: 1.05rem;
    font-weight: 800;
    display: flex; align-items: center; justify-content: center; gap: 12px;
    cursor: pointer;
    transition: 0.3s;
    box-shadow: var(--s-primary);
}

.ch-submit:hover {
    background: var(--primary-dark);
    transform: translateY(-2px);
    box-shadow: 0 15px 30px rgba(255, 77, 28, 0.4);
}

.ch-error { font-size: 0.78rem; color: #ef4444; font-weight: 700; margin-left: 4px; margin-top: 4px; }

/* ── Side Content ── */
.ch-side {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.ch-side-card {
    background: #fff;
    border-radius: 20px;
    padding: 32px;
    border: 1px solid rgba(226, 232, 240, 0.8);
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
}

.ch-side-card.trust { text-align: center; }
.ch-st-avatars { display: flex; justify-content: center; margin-bottom: 16px; }
.ch-st-avatars img { 
    width: 44px; height: 44px; border-radius: 50%; border: 3px solid #fff; 
    margin-left: -12px; box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}
.ch-st-avatars img:first-child { margin-left: 0; }
.ch-st-count {
    width: 44px; height: 44px; border-radius: 50%; border: 3px solid #fff;
    background: var(--bg3); color: var(--ink3);
    display: grid; place-items: center; font-size: 0.75rem; font-weight: 800;
    margin-left: -12px;
}

.ch-side-card.trust h4 { font-size: 1.1rem; color: var(--ink); margin-bottom: 8px; }
.ch-side-card.trust p { font-size: 0.88rem; color: var(--ink4); line-height: 1.5; margin-bottom: 16px; }
.ch-st-badge { 
    display: inline-flex; align-items: center; gap: 6px; 
    font-size: 0.78rem; font-weight: 800; color: #25D366;
    background: rgba(37, 211, 102, 0.1); padding: 6px 14px; border-radius: 30px;
}

.ch-side-card.socials h4 { font-size: 1.1rem; color: var(--ink); margin-bottom: 8px; }
.ch-side-card.socials h4 em { font-style: normal; color: var(--primary); }
.ch-side-card.socials p { font-size: 0.88rem; color: var(--ink4); line-height: 1.5; margin-bottom: 20px; }

.ch-soc-grid { display: flex; gap: 10px; }
.ch-soc {
    width: 42px; height: 42px; border-radius: 12px;
    background: #f8fafc; border: 1px solid #f1f5f9;
    display: grid; place-items: center; font-size: 1.2rem; color: var(--ink3);
    transition: 0.3s;
}
.ch-soc:hover { background: var(--primary); color: #fff; border-color: var(--primary); transform: translateY(-4px); }

.ch-faq-link {
    background: var(--dark);
    padding: 24px;
    border-radius: 20px;
    display: flex; align-items: center; gap: 16px;
    text-decoration: none;
    transition: 0.3s;
}
.ch-faq-link:hover { transform: translateY(-4px); box-shadow: 0 10px 30px rgba(0,0,0,0.2); }
.ch-fl-ic { 
    width: 48px; height: 48px; border-radius: 12px;
    background: rgba(255,255,255,0.1); color: #fff;
    display: grid; place-items: center; font-size: 1.4rem;
}
.ch-faq-link strong { display: block; color: #fff; font-size: 0.95rem; }
.ch-faq-link span { color: rgba(255,255,255,0.5); font-size: 0.8rem; }
.ch-faq-link > i { margin-left: auto; color: #fff; opacity: 0.3; }

/* ── Alert ── */
.ch-alert {
    padding: 20px; border-radius: 14px; margin-bottom: 30px;
    display: flex; gap: 16px; align-items: start;
}
.ch-alert.success { background: rgba(37, 211, 102, 0.1); border: 1px solid rgba(37, 211, 102, 0.2); color: #15803d; }
.ch-alert i { font-size: 1.4rem; }
.ch-alert strong { display: block; margin-bottom: 2px; }
.ch-alert p { font-size: 0.9rem; margin: 0; opacity: 0.8; }

/* ── Responsive ── */
@media (max-width: 1200px) {
    .ch-cards { grid-template-columns: repeat(2, 1fr); }
}

@media (max-width: 992px) {
    .ch-main { grid-template-columns: 1fr; }
    .ch-side { order: 2; flex-direction: row; flex-wrap: wrap; }
    .ch-side > * { flex: 1; min-width: 280px; }
    .ch-faq-link { width: 100%; }
}

@media (max-width: 640px) {
    .ch-cards { grid-template-columns: 1fr; }
    .ch-form-wrap { padding: 32px 24px; }
    .ch-form-grid { grid-template-columns: 1fr; }
    .ch-form-head h2 { font-size: 1.8rem; }
}
</style>
@endpush
