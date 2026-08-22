@include('layouts.partials.auth-head', ['title' => __('Reset Password') . ' — Live IPTV Now'])
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
                <h1>{{ __('Reset Password') }}</h1>
                <p>{{ __("Create a new strong password for your account (minimum 8 characters).") }}</p>
            </div>

            @if($errors->any())
            <div class="auth-alert auth-alert-error">
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

            <p class="auth-switch"><a href="{{ route('login') }}" class="auth-link">{{ __('Back to Sign In') }}</a></p>
        </div>
    </div>

</div>
@include('layouts.partials.auth-scripts')
