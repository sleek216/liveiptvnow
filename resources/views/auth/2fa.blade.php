@include('layouts.partials.auth-head', ['title' => __('Two-Factor Auth') . ' — Live IPTV Now'])
<style>
    .otp-input {
        text-align: center;
        letter-spacing: 0.5em;
        font-size: 1.5rem;
        font-weight: 900;
        padding-left: 18px !important;
    }
    .tfa-timer {
        text-align: center;
        font-size: 0.85rem;
        color: var(--ink5);
        margin-top: -4px;
    }
    .tfa-timer strong { color: var(--primary); }
</style>
<div class="auth-lang-bar-simple">
    @include('layouts.partials.language-switcher')
</div>
<div class="auth-page-simple">
    <div class="auth-card">

        {{-- Logo --}}
        <div class="auth-card-logo">
            <a href="{{ route('home') }}" style="display:inline-flex;align-items:center;gap:8px;text-decoration:none;">
                <div class="auth-card-logo-ic"><i class="ri-play-fill"></i></div>
                <span>Live<strong>IPTV</strong>Now</span>
            </a>
        </div>

        {{-- Icon Header --}}
        <div class="auth-card-header">
            <div class="auth-card-icon"><i class="ri-shield-check-fill"></i></div>
            <h1>{{ __('Two-Factor Auth') }}</h1>
            <p>{{ __('Open your authenticator app and enter the 6-digit verification code to continue.') }}</p>
        </div>

        @if($errors->any())
        <div class="auth-alert auth-alert-error" style="margin-bottom:20px;">
            <i class="ri-error-warning-fill"></i>
            <div>@foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>
        </div>
        @endif

        <form action="{{ route('2fa.verify') }}" method="POST" class="auth-form">
            @csrf

            <div class="auth-field">
                <label for="one_time_password">{{ __('6-Digit Code') }}</label>
                <div class="auth-input-wrap no-icon">
                    <input
                        type="text"
                        id="one_time_password"
                        name="one_time_password"
                        class="otp-input"
                        placeholder="000 000"
                        maxlength="6"
                        autocomplete="one-time-code"
                        inputmode="numeric"
                        autofocus
                        required>
                </div>
            </div>

            <div class="auth-info-box">
                <i class="ri-time-line"></i>
                <span>{{ __('Codes expire every 30 seconds. Make sure your device clock is synced correctly.') }}</span>
            </div>

            <button type="submit" class="auth-submit">
                <i class="ri-shield-check-fill"></i> {{ __('Verify & Sign In') }}
            </button>
        </form>

        <p class="auth-switch"><a href="{{ route('login') }}" class="auth-link"><i class="ri-arrow-left-line"></i> {{ __('Back to Sign In') }}</a></p>
    </div>
</div>
<script>
document.getElementById('one_time_password').addEventListener('input', function(e) {
    let v = e.target.value.replace(/\D/g, '').slice(0, 6);
    e.target.value = v;
    if (v.length === 6) e.target.closest('form').querySelector('.auth-submit').focus();
});
</script>
@include('layouts.partials.auth-scripts')
