@include('layouts.partials.auth-head', ['title' => __('Forgot Password?') . ' — Live IPTV Now'])
<div class="auth-page">

    @include('layouts.partials.auth-left-panel')

    {{-- Right Panel --}}
    <div class="auth-right">
        <div class="auth-lang-bar">
            @include('layouts.partials.language-switcher')
        </div>
        <div class="auth-form-wrap">
            <a href="{{ route('login') }}" class="auth-back"><i class="ri-arrow-left-line"></i> {{ __('Back to Sign In') }}</a>

            <div class="auth-form-header">
                <h1>{{ __('Forgot Password?') }}</h1>
                <p>{{ __("No worries! Enter your email address and we'll send a secure password reset link.") }}</p>
            </div>

            @if(session('status'))
            <div class="auth-alert auth-alert-success">
                <i class="ri-checkbox-circle-fill"></i>
                <div>{{ session('status') }}</div>
            </div>
            @endif

            @if($errors->any())
            <div class="auth-alert auth-alert-error">
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

                <button type="submit" class="auth-submit">
                    <i class="ri-mail-send-line"></i> {{ __('Send Reset Link') }}
                </button>
            </form>

            <p class="auth-switch">{{ __('Remembered your password?') }} <a href="{{ route('login') }}" class="auth-link">{{ __('Sign In') }}</a></p>
        </div>
    </div>

</div>
@include('layouts.partials.auth-scripts')
