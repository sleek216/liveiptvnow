@include('layouts.partials.auth-head', ['title' => __('Staff & Employee Portal') . ' — Live IPTV Now'])
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
                <div style="display: inline-flex; align-items: center; gap: 0.5rem; background: rgba(99, 102, 241, 0.12); color: #6366f1; padding: 0.35rem 0.85rem; border-radius: 9999px; font-size: 0.8rem; font-weight: 700; letter-spacing: 0.05em; text-transform: uppercase; margin-bottom: 0.85rem;">
                    <i class="ri-shield-user-fill"></i> {{ __('Staff & Employee Portal') }}
                </div>
                <h1>{{ __('Staff Workspace Login') }}</h1>
                <p>{{ __('Enter your employee credentials to access your assigned management dashboard.') }}</p>
            </div>

            @if($errors->any())
            <div class="auth-alert auth-alert-error">
                <i class="ri-error-warning-fill"></i>
                <div>@foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>
            </div>
            @endif

            @if(session('error'))
            <div class="auth-alert auth-alert-error">
                <i class="ri-error-warning-fill"></i>
                <div>{{ session('error') }}</div>
            </div>
            @endif

            @if(session('success'))
            <div class="auth-alert auth-alert-success">
                <i class="ri-checkbox-circle-fill"></i>
                <div>{{ session('success') }}</div>
            </div>
            @endif

            <form action="{{ route('staff.portal.login.submit') }}" method="POST" class="auth-form">
                @csrf

                <div class="auth-field">
                    <label for="email">{{ __('Staff Email Address') }}</label>
                    <div class="auth-input-wrap">
                        <i class="ri-mail-line"></i>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="employee@liveiptvnow.com" required autofocus autocomplete="username">
                    </div>
                </div>

                <div class="auth-field">
                    <div class="auth-field-header">
                        <label for="password">{{ __('Password') }}</label>
                    </div>
                    <div class="auth-input-wrap">
                        <i class="ri-lock-line"></i>
                        <input type="password" id="password" name="password" placeholder="{{ __('Enter your password') }}" required autocomplete="current-password">
                        <button type="button" class="auth-eye" onclick="togglePwd('password',this)" aria-label="Toggle password visibility">
                            <i class="ri-eye-off-line"></i>
                        </button>
                    </div>
                </div>

                <div class="auth-check">
                    <label>
                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                        <span>{{ __('Keep me signed in on this device') }}</span>
                    </label>
                </div>

                <button type="submit" class="auth-submit" style="background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%);">
                    <i class="ri-login-box-line"></i> {{ __('Sign In to Staff Portal') }}
                </button>

                <div style="margin-top: 1.5rem; text-align: center; color: #94a3b8; font-size: 0.8rem; display: flex; align-items: center; justify-content: center; gap: 0.4rem;">
                    <i class="ri-lock-2-line"></i>
                    <span>{{ __('Authorized Personnel Only. All access and activity is securely logged.') }}</span>
                </div>
            </form>
        </div>
    </div>

</div>
@include('layouts.partials.auth-scripts')
