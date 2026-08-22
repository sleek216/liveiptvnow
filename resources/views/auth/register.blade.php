@include('layouts.partials.auth-head', ['title' => __('Create Account') . ' — Live IPTV Now'])
<div class="auth-page">

    {{-- Left Panel --}}
    <div class="auth-left">
        <a href="{{ route('home') }}" class="auth-logo">
            <div class="auth-logo-ic"><i class="ri-play-fill"></i></div>
            <span>Live<strong>IPTV</strong>Now</span>
        </a>
        <div class="auth-left-body">
            <h2>{{ __('Start Watching') }}<br><em>{{ __('in 3 Minutes') }}</em></h2>
            <p>{{ __('Create your free account today and get instant access to 40,000+ live channels and 100,000+ VOD titles.') }}</p>
            <ul class="auth-feats">
                <li><i class="ri-gift-fill"></i><span><strong>{{ __('24-Hour Free Trial') }}</strong> · {{ __('No credit card needed') }}</span></li>
                <li><i class="ri-flashlight-fill"></i><span><strong>{{ __('Instant Activation') }}</strong> · {{ __('Within 5 minutes') }}</span></li>
                <li><i class="ri-device-fill"></i><span><strong>{{ __('All Devices') }}</strong> · {{ __('TV, mobile, tablet, PC') }}</span></li>
                <li><i class="ri-headphone-fill"></i><span><strong>{{ __('24/7 Support') }}</strong> · {{ __('Expert team always online') }}</span></li>
            </ul>
        </div>
        <div class="auth-left-footer">
            <div class="auth-trust">
                <div class="auth-trust-item"><i class="ri-shield-check-fill"></i> {{ __('SSL Secured') }}</div>
                <div class="auth-trust-item"><i class="ri-star-fill"></i> {{ __('4.9/5 Rating') }}</div>
                <div class="auth-trust-item"><i class="ri-group-fill"></i> {{ __('100K+ Customers') }}</div>
            </div>
        </div>
    </div>

    {{-- Right Panel --}}
    <div class="auth-right">
        <div class="auth-lang-bar">
            @include('layouts.partials.language-switcher')
        </div>
        <div class="auth-form-wrap">
            <a href="{{ route('home') }}" class="auth-back"><i class="ri-arrow-left-line"></i> {{ __('Back to Home') }}</a>

            <div class="auth-form-header">
                <h1>{{ __('Create Account') }}</h1>
                <p>{{ __('Join 100,000+ streamers worldwide. Free trial included.') }}</p>
            </div>

            @if($errors->any())
            <div class="auth-alert auth-alert-error">
                <i class="ri-error-warning-fill"></i>
                <div>@foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>
            </div>
            @endif

            <form action="{{ route('register') }}" method="POST" class="auth-form">
                @csrf

                <div class="auth-field">
                    <label for="name">{{ __('Full Name') }}</label>
                    <div class="auth-input-wrap">
                        <i class="ri-user-line"></i>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="John Doe" required autofocus>
                    </div>
                </div>

                <div class="auth-field">
                    <label for="email">{{ __('Email Address') }}</label>
                    <div class="auth-input-wrap">
                        <i class="ri-mail-line"></i>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="you@example.com" required>
                    </div>
                </div>

                <div class="auth-row-2">
                    <div class="auth-field">
                        <label for="phone">{{ __('Phone') }} <span style="color:var(--ink5);font-weight:400;">{{ __('(optional)') }}</span></label>
                        <div class="auth-input-wrap">
                            <i class="ri-phone-line"></i>
                            <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" placeholder="+1 555 123 4567">
                        </div>
                    </div>
                    <div class="auth-field">
                        <label for="country">{{ __('Country') }} <span style="color:var(--ink5);font-weight:400;">{{ __('(optional)') }}</span></label>
                        <div class="auth-input-wrap">
                            <i class="ri-global-line"></i>
                            <input type="text" id="country" name="country" value="{{ old('country') }}" placeholder="United States">
                        </div>
                    </div>
                </div>

                <div class="auth-row-2">
                    <div class="auth-field">
                        <label for="password">{{ __('Password') }}</label>
                        <div class="auth-input-wrap">
                            <i class="ri-lock-line"></i>
                            <input type="password" id="password" name="password" placeholder="{{ __('Min 8 characters') }}" required>
                            <button type="button" class="auth-eye" onclick="togglePwd('password',this)"><i class="ri-eye-off-line"></i></button>
                        </div>
                    </div>
                    <div class="auth-field">
                        <label for="password_confirmation">{{ __('Confirm Password') }}</label>
                        <div class="auth-input-wrap">
                            <i class="ri-lock-check-line"></i>
                            <input type="password" id="password_confirmation" name="password_confirmation" placeholder="{{ __('Re-enter password') }}" required>
                            <button type="button" class="auth-eye" onclick="togglePwd('password_confirmation',this)"><i class="ri-eye-off-line"></i></button>
                        </div>
                    </div>
                </div>

                <div class="auth-features-bar">
                    <span><i class="ri-checkbox-circle-fill"></i> {{ __('Free 24h Trial') }}</span>
                    <span><i class="ri-checkbox-circle-fill"></i> {{ __('No Credit Card') }}</span>
                    <span><i class="ri-checkbox-circle-fill"></i> {{ __('Cancel Anytime') }}</span>
                </div>

                <button type="submit" class="auth-submit">
                    <i class="ri-user-add-line"></i> {{ __('Create Account') }}
                </button>
            </form>

            <p class="auth-switch">{{ __('Already have an account?') }} <a href="{{ route('login') }}" class="auth-link">{{ __('Sign In') }}</a></p>
        </div>
    </div>

</div>
@include('layouts.partials.auth-scripts')
