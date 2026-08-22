@include('layouts.partials.auth-head', ['title' => __('Reset Password') . ' — Live IPTV Now'])
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
            <div class="auth-card-icon"><i class="ri-key-2-fill"></i></div>
            <h1>{{ __('Reset Password') }}</h1>
            <p>{{ __("Create a new strong password for your account. Make sure it's at least 8 characters.") }}</p>
        </div>

        @if($errors->any())
        <div class="auth-alert auth-alert-error" style="margin-bottom:20px;">
            <i class="ri-error-warning-fill"></i>
            <div>@foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>
        </div>
        @endif

        <form action="{{ route('password.update') }}" method="POST" class="auth-form">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <div class="auth-field">
                <label for="email">{{ __('Email Address') }}</label>
                <div class="auth-input-wrap">
                    <i class="ri-mail-line"></i>
                    <input type="email" id="email" name="email" value="{{ $email ?? old('email') }}" required autofocus>
                </div>
            </div>

            <div class="auth-field">
                <label for="password">{{ __('New Password') }}</label>
                <div class="auth-input-wrap">
                    <i class="ri-lock-line"></i>
                    <input type="password" id="password" name="password" placeholder="{{ __('Min 8 characters') }}" required>
                    <button type="button" class="auth-eye" onclick="togglePwd('password',this)"><i class="ri-eye-off-line"></i></button>
                </div>
            </div>

            <div class="auth-field">
                <label for="password_confirmation">{{ __('Confirm New Password') }}</label>
                <div class="auth-input-wrap">
                    <i class="ri-lock-check-line"></i>
                    <input type="password" id="password_confirmation" name="password_confirmation" placeholder="{{ __('Re-enter password') }}" required>
                    <button type="button" class="auth-eye" onclick="togglePwd('password_confirmation',this)"><i class="ri-eye-off-line"></i></button>
                </div>
            </div>

            <button type="submit" class="auth-submit">
                <i class="ri-check-double-line"></i> {{ __('Set New Password') }}
            </button>
        </form>

        <p class="auth-switch"><a href="{{ route('login') }}" class="auth-link"><i class="ri-arrow-left-line"></i> {{ __('Back to Sign In') }}</a></p>
    </div>
</div>
@include('layouts.partials.auth-scripts')
