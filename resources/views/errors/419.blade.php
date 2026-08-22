@extends('layouts.app')
@section('title', 'Session Expired — Live IPTV Now')

@section('content')
<section class="error-page-sec">
    <div class="wrap text-center">
        <div class="error-hero text-center" data-aos="fade-up">
            <div class="error-badge error-badge-419">
                <i class="ri-timer-line"></i>
                <span>419 — {{ __('Session Expired') }}</span>
            </div>
            <h1 class="error-title">
                {{ __('Page Expired') }} <span class="gradient-text">{{ __("Let's Refresh") }}</span>
            </h1>
            <p class="error-sub">
                {{ __('Your security token or session has expired due to inactivity. Please refresh the page to securely continue.') }}
            </p>

            <div class="error-actions-hero">
                <button onclick="window.location.reload()" class="btn-primary-action">
                    <i class="ri-refresh-line"></i>
                    <span>{{ __('Refresh & Continue') }}</span>
                </button>
                <a href="{{ route('home') }}" class="btn-ghost-action">
                    <i class="ri-home-5-line"></i>
                    <span>{{ __('Return to Home') }}</span>
                </a>
            </div>
        </div>
    </div>
</section>

<style>
.error-page-sec {
    padding: 90px 0 120px;
    background: #090d16;
    color: #f1f5f9;
    min-height: 75vh;
    display: flex;
    align-items: center;
    justify-content: center;
}
.error-hero { max-width: 680px; margin: 0 auto; }
.error-badge-419 {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 6px 16px;
    background: rgba(245, 158, 11, 0.12);
    border: 1px solid rgba(245, 158, 11, 0.3);
    border-radius: 999px;
    font-size: 13px;
    font-weight: 700;
    color: #fbbf24;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    margin-bottom: 20px;
}
.error-title { font-size: 42px; font-weight: 800; line-height: 1.2; color: #ffffff; margin-bottom: 16px; letter-spacing: -0.02em; }
.gradient-text { background: linear-gradient(135deg, #ff5722, #ff8a65); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
.error-sub { font-size: 16px; color: #94a3b8; line-height: 1.6; margin-bottom: 32px; }
.error-actions-hero { display: flex; align-items: center; justify-content: center; gap: 14px; }
.btn-primary-action {
    display: inline-flex; align-items: center; gap: 8px; padding: 13px 28px;
    background: linear-gradient(135deg, #ff5722, #e64a19); border: none; border-radius: 12px;
    color: #ffffff; font-size: 14.5px; font-weight: 700; cursor: pointer; text-decoration: none;
    transition: all 0.2s ease; box-shadow: 0 4px 14px rgba(255, 77, 28, 0.35);
}
.btn-primary-action:hover { background: linear-gradient(135deg, #ff7043, #ff5722); transform: translateY(-2px); box-shadow: 0 6px 20px rgba(255, 77, 28, 0.45); }
.btn-ghost-action {
    display: inline-flex; align-items: center; gap: 8px; padding: 13px 24px;
    background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.12);
    border-radius: 12px; color: #cbd5e1; font-size: 14px; font-weight: 600; text-decoration: none; transition: all 0.2s ease;
}
.btn-ghost-action:hover { background: rgba(255, 255, 255, 0.1); color: #ffffff; }
@media (max-width: 640px) {
    .error-title { font-size: 30px; }
    .error-actions-hero { flex-direction: column; }
    .btn-primary-action, .btn-ghost-action { width: 100%; justify-content: center; }
}
</style>
@endsection
