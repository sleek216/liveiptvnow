@include('layouts.partials.auth-head', ['title' => __('Sign In') . ' — Live IPTV Now'])
<div class="auth-page">

    @include('layouts.partials.auth-left-panel')

    {{-- Right Panel --}}
    <div class="auth-right">
        <div class="auth-lang-bar">
            @include('layouts.partials.language-switcher')
        </div>
        <div class="auth-form-wrap">
            <a href="{{ route('home') }}" class="auth-back"><i class="ri-arrow-left-line"></i> {{ __('Back to Home') }}</a>

            <div class="auth-form-header">
                <h1>{{ __('Welcome Back') }}</h1>
                <p>{{ __('Sign in to your account to continue') }}</p>
            </div>

            @if($errors->any())
            <div class="auth-alert auth-alert-error">
                <i class="ri-error-warning-fill"></i>
                <div>@foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>
            </div>
            @endif

            @if(session('success'))
            <div class="auth-alert auth-alert-success">
                <i class="ri-checkbox-circle-fill"></i>
                <div>{{ session('success') }}</div>
            </div>
            @endif

            <form action="{{ route('login') }}" method="POST" class="auth-form">
                @csrf

                <div class="auth-field">
                    <label for="email">{{ __('Email Address') }}</label>
                    <div class="auth-input-wrap">
                        <i class="ri-mail-line"></i>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="you@example.com" required autofocus>
                    </div>
                </div>

                <div class="auth-field">
                    <div class="auth-field-header">
                        <label for="password">{{ __('Password') }}</label>
                        <a href="{{ route('password.request') }}" class="auth-link">{{ __('Forgot Password?') }}</a>
                    </div>
                    <div class="auth-input-wrap">
                        <i class="ri-lock-line"></i>
                        <input type="password" id="password" name="password" placeholder="{{ __('Enter your password') }}" required>
                        <button type="button" class="auth-eye" onclick="togglePwd('password',this)"><i class="ri-eye-off-line"></i></button>
                    </div>
                </div>

                <div class="auth-check">
                    <label>
                        <input type="checkbox" name="remember">
                        <span>{{ __('Remember me for 30 days') }}</span>
                    </label>
                </div>

                <button type="submit" class="auth-submit">
                    <i class="ri-login-box-line"></i> {{ __('Sign In') }}
                </button>
            </form>

            <p class="auth-switch">{{ __("Don't have an account?") }} <a href="{{ route('register') }}" class="auth-link">{{ __('Create Account') }}</a></p>
        </div>
    </div>

</div>
@include('layouts.partials.auth-scripts')
