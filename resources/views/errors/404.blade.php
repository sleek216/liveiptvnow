@extends('layouts.app')
@section('title', 'Page Not Found — How Can We Help You? | Live IPTV Now')

@section('content')
<section class="error-page-sec">
    <div class="wrap">
        {{-- Top Header / Hero --}}
        <div class="error-hero text-center" data-aos="fade-up">
            <div class="error-badge">
                <i class="ri-compass-3-line"></i>
                <span>404 — {{ __('Page Not Found') }}</span>
            </div>
            <h1 class="error-title">
                {{ __('Lost Your Way?') }} <span class="gradient-text">{{ __('How Can We Help You?') }}</span>
            </h1>
            <p class="error-sub">
                {{ __("The page you're looking for doesn't exist or may have been moved. Don't worry — our team is here 24/7 to get you right back on track!") }}
            </p>
        </div>

        {{-- Quick Navigation Cards --}}
        <div class="error-nav-grid" data-aos="fade-up" data-aos-delay="100">
            <a href="{{ route('home') }}" class="error-nav-card">
                <div class="card-icon bg-orange"><i class="ri-home-5-line"></i></div>
                <div class="card-info">
                    <h4>{{ __('Home Page') }}</h4>
                    <p>{{ __('Browse our main features, stream quality & offers.') }}</p>
                </div>
                <i class="ri-arrow-right-line card-arrow"></i>
            </a>

            <a href="{{ route('channels') }}" class="error-nav-card">
                <div class="card-icon bg-blue"><i class="ri-tv-line"></i></div>
                <div class="card-info">
                    <h4>{{ __('40,000+ Channels') }}</h4>
                    <p>{{ __('Search live sports, news, movies & world channels.') }}</p>
                </div>
                <i class="ri-arrow-right-line card-arrow"></i>
            </a>

            <a href="{{ route('packages.index') }}" class="error-nav-card">
                <div class="card-icon bg-green"><i class="ri-vip-diamond-line"></i></div>
                <div class="card-info">
                    <h4>{{ __('Pricing & Plans') }}</h4>
                    <p>{{ __('Choose the perfect subscription package for you.') }}</p>
                </div>
                <i class="ri-arrow-right-line card-arrow"></i>
            </a>

            <a href="{{ route('faq') }}" class="error-nav-card">
                <div class="card-icon bg-purple"><i class="ri-questionnaire-line"></i></div>
                <div class="card-info">
                    <h4>{{ __('Help & FAQ') }}</h4>
                    <p>{{ __('Find instant answers to setup and streaming questions.') }}</p>
                </div>
                <i class="ri-arrow-right-line card-arrow"></i>
            </a>
        </div>

        {{-- Contact / Help Form Section --}}
        <div class="error-form-container" data-aos="fade-up" data-aos-delay="200">
            <div class="error-form-box">
                <div class="form-header">
                    <div class="form-header-icon"><i class="ri-customer-service-2-line"></i></div>
                    <div>
                        <h3>{{ __('Quick Support Request') }}</h3>
                        <p>{{ __('Send us a quick message and our support specialist will reply shortly.') }}</p>
                    </div>
                </div>

                @if(session('success'))
                <div class="alert-box success">
                    <i class="ri-checkbox-circle-fill"></i>
                    <div>{{ session('success') }}</div>
                </div>
                @endif

                @if($errors->any())
                <div class="alert-box error">
                    <i class="ri-error-warning-fill"></i>
                    <div>
                        @foreach($errors->all() as $e)
                            <div>{{ $e }}</div>
                        @endforeach
                    </div>
                </div>
                @endif

                <form action="{{ route('contact.store') }}" method="POST" class="quick-help-form">
                    @csrf
                    <input type="hidden" name="subject" value="404 Page Assistance Request">

                    <div class="form-row-2">
                        <div class="input-field">
                            <label for="help_name">{{ __('Your Name') }}</label>
                            <div class="field-wrap">
                                <i class="ri-user-line"></i>
                                <input type="text" id="help_name" name="name" value="{{ old('name', auth()->user()?->name) }}" placeholder="e.g. John Doe" required>
                            </div>
                        </div>

                        <div class="input-field">
                            <label for="help_email">{{ __('Email Address') }}</label>
                            <div class="field-wrap">
                                <i class="ri-mail-line"></i>
                                <input type="email" id="help_email" name="email" value="{{ old('email', auth()->user()?->email) }}" placeholder="you@example.com" required>
                            </div>
                        </div>
                    </div>

                    <div class="input-field">
                        <label for="help_msg">{{ __('How can we help you?') }}</label>
                        <div class="field-wrap textarea-wrap">
                            <i class="ri-chat-smile-2-line"></i>
                            <textarea id="help_msg" name="message" rows="3" placeholder="{{ __('Describe what you were looking for or ask a question...') }}" required>{{ old('message') }}</textarea>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn-submit-help">
                            <i class="ri-send-plane-fill"></i>
                            <span>{{ __('Send Message') }}</span>
                        </button>

                        <a href="{{ route('contact') }}" class="btn-full-contact">
                            <i class="ri-headphone-line"></i>
                            <span>{{ __('Full Contact Center') }}</span>
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<style>
.error-page-sec {
    padding: 70px 0 100px;
    background: #090d16;
    color: #f1f5f9;
    min-height: 80vh;
    display: flex;
    align-items: center;
}

.error-hero {
    max-width: 720px;
    margin: 0 auto 48px;
    text-align: center;
}

.error-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 6px 16px;
    background: rgba(255, 77, 28, 0.12);
    border: 1px solid rgba(255, 77, 28, 0.3);
    border-radius: 999px;
    font-size: 13px;
    font-weight: 700;
    color: #ff5722;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    margin-bottom: 20px;
}

.error-title {
    font-size: 42px;
    font-weight: 800;
    line-height: 1.2;
    color: #ffffff;
    margin-bottom: 16px;
    letter-spacing: -0.02em;
}

.gradient-text {
    background: linear-gradient(135deg, #ff5722, #ff8a65);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.error-sub {
    font-size: 16px;
    color: #94a3b8;
    line-height: 1.6;
}

/* Quick Nav Grid */
.error-nav-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    max-width: 1080px;
    margin: 0 auto 56px;
}

.error-nav-card {
    display: flex;
    align-items: center;
    gap: 16px;
    padding: 20px;
    background: rgba(255, 255, 255, 0.03);
    border: 1px solid rgba(255, 255, 255, 0.08);
    border-radius: 16px;
    text-decoration: none;
    transition: all 0.25s ease;
}

.error-nav-card:hover {
    background: rgba(255, 255, 255, 0.07);
    border-color: rgba(255, 77, 28, 0.4);
    transform: translateY(-3px);
    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.4);
}

.card-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    color: #ffffff;
    flex-shrink: 0;
}

.bg-orange { background: linear-gradient(135deg, #ff5722, #e64a19); }
.bg-blue { background: linear-gradient(135deg, #0284c7, #0369a1); }
.bg-green { background: linear-gradient(135deg, #10b981, #059669); }
.bg-purple { background: linear-gradient(135deg, #8b5cf6, #6d28d9); }

.card-info {
    flex: 1;
}

.card-info h4 {
    font-size: 16px;
    font-weight: 700;
    color: #ffffff;
    margin-bottom: 4px;
}

.card-info p {
    font-size: 12.5px;
    color: #94a3b8;
    line-height: 1.4;
    margin: 0;
}

.card-arrow {
    font-size: 18px;
    color: #64748b;
    transition: transform 0.2s, color 0.2s;
}

.error-nav-card:hover .card-arrow {
    color: #ff5722;
    transform: translateX(4px);
}

/* Contact Form Section */
.error-form-container {
    max-width: 740px;
    margin: 0 auto;
}

.error-form-box {
    background: rgba(15, 23, 42, 0.85);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 24px;
    padding: 36px 32px;
    box-shadow: 0 20px 40px -10px rgba(0, 0, 0, 0.5);
}

.form-header {
    display: flex;
    align-items: center;
    gap: 16px;
    margin-bottom: 28px;
    padding-bottom: 20px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.08);
}

.form-header-icon {
    width: 48px;
    height: 48px;
    background: rgba(255, 77, 28, 0.12);
    border: 1px solid rgba(255, 77, 28, 0.25);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    color: #ff5722;
}

.form-header h3 {
    font-size: 20px;
    font-weight: 700;
    color: #ffffff;
    margin-bottom: 4px;
}

.form-header p {
    font-size: 13.5px;
    color: #94a3b8;
    margin: 0;
}

.alert-box {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 16px;
    border-radius: 10px;
    font-size: 13.5px;
    margin-bottom: 20px;
}

.alert-box.success {
    background: rgba(16, 185, 129, 0.12);
    border: 1px solid rgba(16, 185, 129, 0.3);
    color: #6ee7b7;
}

.alert-box.error {
    background: rgba(239, 68, 68, 0.12);
    border: 1px solid rgba(239, 68, 68, 0.3);
    color: #fca5a5;
}

.form-row-2 {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
    margin-bottom: 16px;
}

.input-field {
    margin-bottom: 16px;
}

.input-field label {
    display: block;
    font-size: 12.5px;
    font-weight: 600;
    color: #cbd5e1;
    margin-bottom: 8px;
}

.field-wrap {
    position: relative;
    display: flex;
    align-items: center;
}

.field-wrap i {
    position: absolute;
    left: 14px;
    font-size: 17px;
    color: #64748b;
    pointer-events: none;
}

.field-wrap input,
.field-wrap textarea {
    width: 100%;
    padding: 12px 14px 12px 42px;
    background: rgba(255, 255, 255, 0.04);
    border: 1px solid rgba(255, 255, 255, 0.12);
    border-radius: 12px;
    font-size: 14px;
    color: #ffffff;
    font-family: inherit;
    outline: none;
    transition: all 0.2s ease;
}

.field-wrap.textarea-wrap i {
    top: 14px;
}

.field-wrap.textarea-wrap textarea {
    resize: vertical;
    min-height: 85px;
}

.field-wrap input:focus,
.field-wrap textarea:focus {
    background: rgba(255, 255, 255, 0.07);
    border-color: #ff5722;
    box-shadow: 0 0 0 3px rgba(255, 77, 28, 0.2);
}

.form-actions {
    display: flex;
    align-items: center;
    gap: 14px;
    margin-top: 8px;
}

.btn-submit-help {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 13px 24px;
    background: linear-gradient(135deg, #ff5722, #e64a19);
    border: none;
    border-radius: 12px;
    color: #ffffff;
    font-size: 14.5px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.2s ease;
    box-shadow: 0 4px 14px rgba(255, 77, 28, 0.35);
}

.btn-submit-help:hover {
    background: linear-gradient(135deg, #ff7043, #ff5722);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(255, 77, 28, 0.45);
}

.btn-full-contact {
    display: flex;
    align-items: center;
    gap: 6px;
    padding: 13px 20px;
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid rgba(255, 255, 255, 0.12);
    border-radius: 12px;
    color: #cbd5e1;
    font-size: 13.5px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.2s ease;
}

.btn-full-contact:hover {
    background: rgba(255, 255, 255, 0.1);
    color: #ffffff;
}

@media (max-width: 640px) {
    .error-title { font-size: 30px; }
    .form-row-2 { grid-template-columns: 1fr; }
    .form-actions { flex-direction: column; }
    .btn-submit-help, .btn-full-contact { width: 100%; justify-content: center; }
}
</style>
@endsection
