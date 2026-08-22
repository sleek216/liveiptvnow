@include('layouts.partials.auth-head', ['title' => __('Forgot Password?') . ' — Live IPTV Now'])
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
            <div class="auth-card-icon"><i class="ri-shield-keyhole-fill"></i></div>
            <h1>{{ __('Forgot Password?') }}</h1>
            <p>{{ __("No worries! Enter your email and we'll send a secure reset link within a few minutes.") }}</p>
        </div>

        @if(session('status'))
        <div class="auth-alert auth-alert-success" style="margin-bottom:20px;">
            <i class="ri-checkbox-circle-fill"></i>
            <div>{{ session('status') }}</div>
        </div>
        @endif

        @if($errors->any())
        <div class="auth-alert auth-alert-error" style="margin-bottom:20px;">
            <i class="ri-error-warning-fill"></i>
            <div>@foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>
        </div>
        @endif

        <form action="{{ route('password.email') }}" method="POST" class="auth-form">
            @csrf

            <div class="auth-field">
                <label for="email">{{ __('Email Address') }}</label>
                <div class="auth-input-wrap">
                    <i class="ri-mail-line"></i>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="you@example.com" required autofocus>
                </div>
            </div>

            <div class="auth-info-box">
                <i class="ri-information-line"></i>
                <span>{{ __("We'll send a reset link to your email. Check your spam folder if you don't see it.") }}</span>
            </div>

            <button type="submit" class="auth-submit">
                <i class="ri-mail-send-line"></i> {{ __('Send Reset Link') }}
            </button>
        </form>

        <p class="auth-switch"><a href="{{ route('login') }}" class="auth-link"><i class="ri-arrow-left-line"></i> {{ __('Back to Sign In') }}</a></p>
    </div>
</div>
@include('layouts.partials.auth-scripts')
