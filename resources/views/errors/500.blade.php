@extends('layouts.app')
@section('title', 'Server Error — Live IPTV Now | 24/7 Support')

@section('content')
<section class="error-page-sec">
    <div class="wrap">
        {{-- Top Header / Hero --}}
        <div class="error-hero text-center" data-aos="fade-up">
            <div class="error-badge error-badge-500">
                <i class="ri-server-line"></i>
                <span>500 — {{ __('Server Error') }}</span>
            </div>
            <h1 class="error-title">
                {{ __('Something Went Wrong') }} <span class="gradient-text">{{ __('We Are On It!') }}</span>
            </h1>
            <p class="error-sub">
                {{ __("Our server encountered a momentary hiccup. Don't worry — your data is safe and our technical team has been automatically alerted.") }}
            </p>

            <div class="error-actions-hero">
                <button onclick="window.location.reload()" class="btn-primary-action">
                    <i class="ri-refresh-line"></i>
                    <span>{{ __('Refresh Page') }}</span>
                </button>
                <a href="{{ route('home') }}" class="btn-ghost-action">
                    <i class="ri-home-5-line"></i>
                    <span>{{ __('Return to Home') }}</span>
                </a>
            </div>
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

            <a href="{{ route('contact') }}" class="error-nav-card">
                <div class="card-icon bg-purple"><i class="ri-customer-service-2-line"></i></div>
                <div class="card-info">
                    <h4>{{ __('24/7 Live Support') }}</h4>
                    <p>{{ __('Chat directly with our support specialists.') }}</p>
                </div>
                <i class="ri-arrow-right-line card-arrow"></i>
            </a>
        </div>
    </div>
</section>

<style>
.error-page-sec {
    padding: 80px 0 110px;
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

.error-badge-500 {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 6px 16px;
    background: rgba(239, 68, 68, 0.12);
    border: 1px solid rgba(239, 68, 68, 0.3);
    border-radius: 999px;
    font-size: 13px;
    font-weight: 700;
    color: #f87171;
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
    margin-bottom: 30px;
}

.error-actions-hero {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 14px;
    margin-bottom: 10px;
}

.btn-primary-action {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 13px 28px;
    background: linear-gradient(135deg, #ff5722, #e64a19);
    border: none;
    border-radius: 12px;
    color: #ffffff;
    font-size: 14.5px;
    font-weight: 700;
    cursor: pointer;
    text-decoration: none;
    transition: all 0.2s ease;
    box-shadow: 0 4px 14px rgba(255, 77, 28, 0.35);
}

.btn-primary-action:hover {
    background: linear-gradient(135deg, #ff7043, #ff5722);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(255, 77, 28, 0.45);
}

.btn-ghost-action {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 13px 24px;
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid rgba(255, 255, 255, 0.12);
    border-radius: 12px;
    color: #cbd5e1;
    font-size: 14px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.2s ease;
}

.btn-ghost-action:hover {
    background: rgba(255, 255, 255, 0.1);
    color: #ffffff;
}

/* Quick Nav Grid */
.error-nav-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    max-width: 1080px;
    margin: 0 auto;
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

.card-info { flex: 1; }
.card-info h4 { font-size: 16px; font-weight: 700; color: #ffffff; margin-bottom: 4px; }
.card-info p { font-size: 12.5px; color: #94a3b8; line-height: 1.4; margin: 0; }
.card-arrow { font-size: 18px; color: #64748b; transition: transform 0.2s, color 0.2s; }
.error-nav-card:hover .card-arrow { color: #ff5722; transform: translateX(4px); }

@media (max-width: 640px) {
    .error-title { font-size: 30px; }
    .error-actions-hero { flex-direction: column; }
    .btn-primary-action, .btn-ghost-action { width: 100%; justify-content: center; }
}
</style>
@endsection
