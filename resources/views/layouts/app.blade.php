<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ \App\Support\SupportedLocales::isRtl(app()->getLocale()) ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="theme-color" content="#ff4d1c">
    <meta name="description" content="Live IPTV Now - #1 Premium IPTV Service with 40,000+ Channels, HD &amp; 4K Quality. Zero Buffering. Instant Delivery.">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Live IPTV Now - Premium Streaming Service')</title>

    {{-- Favicon --}}
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">

    {{-- DNS Prefetch for external domains --}}
    <link rel="dns-prefetch" href="//fonts.googleapis.com">
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link rel="dns-prefetch" href="//cdn.jsdelivr.net">

    {{-- Preconnect only what we use immediately --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    {{-- Google Fonts — only weights actually used (400,700,800,900), display=swap prevents FOIT --}}
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;700;800;900&display=swap" rel="stylesheet">

    {{-- RemixIcon — load async to prevent render blocking --}}
    <link rel="preload" href="https://cdn.jsdelivr.net/npm/remixicon@4.6.0/fonts/remixicon.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link href="https://cdn.jsdelivr.net/npm/remixicon@4.6.0/fonts/remixicon.css" rel="stylesheet"></noscript>

    {{-- Flag icons for language switcher --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lipis/flag-icons@7.2.3/css/flag-icons.min.css">

    {{-- AOS CSS — load async --}}
    <link rel="preload" href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet"></noscript>

    {{-- Local CSS — critical, loaded synchronously --}}
    @php
        $appCss = 'css/app.css';
        $resCss = 'css/responsive.css';
        $appVer = file_exists(public_path($appCss)) ? filemtime(public_path($appCss)) : time();
        $resVer = file_exists(public_path($resCss)) ? filemtime(public_path($resCss)) : time();
    @endphp
    <link rel="stylesheet" href="{{ asset($appCss) }}?v={{ $appVer }}">
    <link rel="stylesheet" href="{{ asset($resCss) }}?v={{ $resVer }}">

    @stack('styles')

    @include('layouts.partials.i18n-config')

    {{-- Crisp Chat — loaded async via JS, non-blocking --}}
    @php $crispId = \App\Models\Setting::get('crisp_website_id'); @endphp
    @if($crispId)
    <script>window.$crisp=[];window.CRISP_WEBSITE_ID="{{ $crispId }}";</script>
    @endif

    {{-- Critical inline CSS for above-the-fold to prevent CLS --}}
    <style>
        /* Critical: prevent layout shift before fonts load */
        body { font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif; }
        /* Ensure icons don't cause layout shift while loading */
        [class^="ri-"], [class*=" ri-"] { font-size: 1em; line-height: 1; display: inline-flex; }
    </style>
</head>
<body>

    {{-- ═══ ANNOUNCEMENT BAR ═══ --}}
    @php
        $ao = \App\Models\Setting::get('announcement_enabled', '1');
        $at = \App\Models\Setting::get('announcement_text', 'Get <strong>50% OFF</strong> on all annual plans — Use Code: <code>LIVE50</code>');
        $al = \App\Models\Setting::get('announcement_link', '/packages');
        $ab = \App\Models\Setting::get('announcement_link_text', 'Shop Now');
    @endphp
    @if($ao === '1' && !empty($at))
    <div class="ann" id="ann-bar">
        <span class="ann-tag">🔥 Sale</span>
        {!! $at !!}
        @if($al)
            <a href="{{ $al }}">{{ $ab }} &rarr;</a>
        @endif
    </div>
    @endif

    {{-- ═══ TOP INFO BAR ═══ --}}
    <div class="top-bar">
        <div class="wrap">
            <div class="top-bar-inner">
                <div class="top-info">
                    <span><i class="ri-phone-fill"></i> +1 (800) 123-4567</span>
                    <span><i class="ri-mail-fill"></i> support@liveiptvnow.com</span>
                    <span><i class="ri-time-fill"></i> {{ __('24/7 Support Available') }}</span>
                </div>
                <div class="top-right">
                    @include('layouts.partials.language-switcher')
                    <div class="top-right-sep"></div>
                    @guest
                        <a href="{{ route('login') }}"><i class="ri-user-line"></i> {{ __('Sign In') }}</a>
                        <div class="top-right-sep"></div>
                        <a href="{{ route('register') }}"><i class="ri-user-add-line"></i> {{ __('Register') }}</a>
                    @else
                        <a href="{{ route('profile') }}"><i class="ri-user-3-line"></i> {{ Auth::user()->name }}</a>
                        @if(Auth::user()->isAdmin())
                            <div class="top-right-sep"></div>
                            <a href="{{ route(auth()->user()->adminHomeRouteName()) }}"><i class="ri-settings-4-line"></i> {{ __('Admin Panel') }}</a>
                        @endif
                        <div class="top-right-sep"></div>
                        <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" style="background:none;border:none;color:rgba(255,255,255,0.7);cursor:pointer;font:inherit;font-size:0.8rem;display:flex;align-items:center;gap:5px;padding:0;transition:all 0.22s ease;" onmouseover="this.style.color='#ff4d1c'" onmouseout="this.style.color='rgba(255,255,255,0.7)'">
                                <i class="ri-logout-box-r-line"></i> {{ __('Logout') }}
                            </button>
                        </form>
                    @endguest
                </div>
            </div>
        </div>
    </div>

    {{-- ═══ MAIN HEADER ═══ --}}
    <header class="hdr" id="hdr">
        <div class="hdr-bar">
            {{-- Logo --}}
            <a href="{{ route('home') }}" class="brand" aria-label="Live IPTV Now - Home">
                <img src="{{ asset('images/logo.png') }}" alt="Live IPTV Now" class="brand-logo">
            </a>

            {{-- Desktop Navigation --}}
            <nav class="mnav" aria-label="Main navigation">
                <a href="{{ route('home') }}"          class="{{ request()->routeIs('home')       ? 'on' : '' }}">{{ __('Home') }}</a>
                <a href="{{ route('packages.index') }}" class="{{ request()->routeIs('packages.*') ? 'on' : '' }}">{{ __('Pricing') }}</a>
                <a href="{{ route('channels') }}"       class="{{ request()->routeIs('channels')   ? 'on' : '' }}">{{ __('Channels') }}</a>
                <a href="{{ route('blog.index') }}"     class="{{ request()->routeIs('blog.*')     ? 'on' : '' }}">{{ __('Blog') }}</a>
                <a href="{{ route('faq') }}"            class="{{ request()->routeIs('faq')        ? 'on' : '' }}">{{ __('FAQ') }}</a>
                <a href="{{ route('contact') }}"        class="{{ request()->routeIs('contact')    ? 'on' : '' }}">{{ __('Contact') }}</a>
                <a href="{{ route('affiliate.info') }}" class="{{ request()->routeIs('affiliate.info') ? 'on' : '' }}">{{ __('Affiliate') }}</a>
            </nav>

            {{-- Desktop CTA --}}
            <div class="hdr-end">
                <button class="hdr-search" aria-label="{{ __('Search') }}"><i class="ri-search-line"></i></button>
                @guest
                    <a href="{{ route('login') }}" class="hb hb-ghost">{{ __('Log In') }}</a>
                @endguest
                <a href="{{ route('packages.index') }}" class="hb hb-b"><i class="ri-play-circle-line"></i> {{ __('Get Started') }}</a>
            </div>

            {{-- Mobile Toggle --}}
            <button class="m-toggle" id="mt" aria-label="{{ __('Open menu') }}" aria-expanded="false">
                <i class="ri-menu-3-line"></i>
            </button>
        </div>
    </header>

    {{-- ═══ MOBILE DRAWER ═══ --}}
    <div class="m-drawer" id="md" role="dialog" aria-modal="true" aria-label="{{ __('Navigation menu') }}">
        <div class="m-drawer-logo">
            <img src="{{ asset('images/logo.png') }}" alt="Live IPTV Now" class="brand-logo">
        </div>
        <button class="m-close" id="mc" aria-label="{{ __('Close menu') }}"><i class="ri-close-line"></i></button>

        <a href="{{ route('home') }}">        <i class="ri-home-4-line"></i>  {{ __('Home') }}</a>
        <a href="{{ route('packages.index') }}"><i class="ri-price-tag-3-line"></i> {{ __('Pricing') }}</a>
        <a href="{{ route('channels') }}">     <i class="ri-tv-2-line"></i>   {{ __('Channels') }}</a>
        <a href="{{ route('blog.index') }}">   <i class="ri-article-line"></i> {{ __('Blog') }}</a>
        <a href="{{ route('faq') }}">          <i class="ri-question-line"></i> {{ __('FAQ') }}</a>
        <a href="{{ route('contact') }}">      <i class="ri-customer-service-2-line"></i> {{ __('Contact') }}</a>
        <a href="{{ route('affiliate.info') }}"><i class="ri-hand-coin-line"></i> {{ __('Affiliate') }}</a>

        <div class="m-drawer-lang">
            @include('layouts.partials.language-switcher')
        </div>

        <div class="m-drawer-cta">
            @guest
                <a href="{{ route('login') }}"    class="btn btn-outline btn-full">{{ __('Log In') }}</a>
                <a href="{{ route('register') }}" class="btn btn-primary btn-full">{{ __('Create Account') }}</a>
            @else
                <a href="{{ route('profile') }}"  class="btn btn-outline btn-full"><i class="ri-user-line"></i> {{ __('My Profile') }}</a>
                @if(Auth::user()->isAdmin())
                    <a href="{{ route(auth()->user()->adminHomeRouteName()) }}" class="btn btn-dark btn-full"><i class="ri-settings-4-line"></i> {{ __('Admin Panel') }}</a>
                @endif
            @endguest
        </div>
    </div>

    {{-- ═══ MAIN CONTENT ═══ --}}
    <main id="main-content">
        @yield('content')
    </main>

    {{-- ═══ FOOTER ═══ --}}
    <footer class="ft" role="contentinfo">
        <div class="wrap">
            <div class="ft-grid">
                {{-- Brand Column --}}
                <div class="ft-about">
                    <div class="ft-logo">
                        <div class="ft-logo-icon"><i class="ri-play-fill"></i></div>
                        <span class="ft-logo-text">Live<b>IPTV</b>Now</span>
                    </div>
                    <p>{{ __('Premium IPTV streaming with 40,000+ live channels in stunning 4K & HD. Zero buffering, instant activation, and 24/7 expert support.') }}</p>
                    <div class="ft-socials">
                        <a href="#" aria-label="Facebook"><i class="ri-facebook-fill"></i></a>
                        <a href="#" aria-label="Twitter/X"><i class="ri-twitter-x-line"></i></a>
                        <a href="#" aria-label="Instagram"><i class="ri-instagram-fill"></i></a>
                        <a href="#" aria-label="YouTube"><i class="ri-youtube-fill"></i></a>
                        <a href="#" aria-label="Telegram"><i class="ri-telegram-fill"></i></a>
                    </div>
                </div>

                {{-- Services Column --}}
                <div class="ft-links">
                    <h6>{{ __('Services') }}</h6>
                    <a href="{{ route('packages.index') }}">{{ __('Subscription Plans') }}</a>
                    <a href="{{ route('channels') }}">{{ __('Channel Guide') }}</a>
                    <a href="{{ route('reseller.index') }}">{{ __('Reseller Program') }}</a>
                    <a href="{{ route('affiliate.info') }}">{{ __('Affiliate Program') }}</a>
                    <a href="{{ route('how-it-works') }}">{{ __('How It Works') }}</a>
                </div>

                {{-- Company Column --}}
                <div class="ft-links">
                    <h6>{{ __('Company') }}</h6>
                    <a href="{{ route('about') }}">{{ __('About Us') }}</a>
                    <a href="{{ route('blog.index') }}">{{ __('Our Blog') }}</a>
                    <a href="{{ route('contact') }}">{{ __('Contact Us') }}</a>
                    <a href="{{ route('terms') }}">{{ __('Terms of Service') }}</a>
                    <a href="{{ route('privacy') }}">{{ __('Privacy Policy') }}</a>
                    <a href="{{ route('refund') }}">{{ __('Refund Policy') }}</a>
                </div>

                {{-- Contact Column --}}
                <div class="ft-contact-col">
                    <h6>{{ __('Get Support') }}</h6>
                    <p>{{ __('Our team is available around the clock to help you.') }}</p>
                    <div class="ft-ct-row">
                        <div class="ft-ct-ic"><i class="ri-mail-send-fill"></i></div>
                        <div><span>{{ __('Email Us') }}</span><strong>support@liveiptvnow.com</strong></div>
                    </div>
                    <div class="ft-ct-row">
                        <div class="ft-ct-ic"><i class="ri-whatsapp-fill"></i></div>
                        <div><span>{{ __('WhatsApp') }}</span><strong>+1 (800) 123-4567</strong></div>
                    </div>
                    <div class="ft-ct-row">
                        <div class="ft-ct-ic"><i class="ri-time-fill"></i></div>
                        <div><span>{{ __('Support Hours') }}</span><strong>{{ __('24/7 — Always Available') }}</strong></div>
                    </div>
                </div>
            </div>

            {{-- Footer Bottom --}}
            <div class="ft-bottom">
                <p>&copy; {{ date('Y') }} Live IPTV Now. {{ __('All rights reserved') }}.</p>
                <div class="ft-pay">
                    <span>{{ __('We Accept') }}</span>
                    <div class="ft-pay-icons">
                        <div class="ft-pay-icon" title="Visa"><i class="ri-visa-fill"></i></div>
                        <div class="ft-pay-icon" title="Mastercard"><i class="ri-mastercard-fill"></i></div>
                        <div class="ft-pay-icon" title="PayPal"><i class="ri-paypal-fill"></i></div>
                        <div class="ft-pay-icon" title="Bitcoin"><i class="ri-bitcoin-fill"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    {{-- ═══ WHATSAPP FLOATING BUTTON ═══ --}}
    @php $waNum = \App\Models\Setting::get('whatsapp_number'); @endphp
    @if($waNum)
    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $waNum) }}?text={{ urlencode('Hi! I need help with Live IPTV Now.') }}"
       target="_blank"
       rel="noopener"
       class="wa-float"
       aria-label="{{ __('Chat on WhatsApp') }}"
       title="{{ __('Chat with us on WhatsApp') }}">
        <svg viewBox="0 0 32 32" width="28" height="28" fill="#fff"><path d="M16.004 0h-.008C7.174 0 0 7.176 0 16.004c0 3.5 1.129 6.742 3.047 9.379L1.054 31.25l6.1-1.953A15.9 15.9 0 0016.004 32C24.826 32 32 24.826 32 16.004S24.826 0 16.004 0zm9.32 22.617c-.39 1.1-1.932 2.012-3.172 2.278-.848.18-1.957.324-5.688-1.222-4.773-1.977-7.84-6.82-8.078-7.136-.23-.316-1.906-2.54-1.906-4.844s1.207-3.433 1.637-3.902c.43-.469.937-.586 1.25-.586.312 0 .625.003.898.016.289.014.676-.11 1.058.808.39.937 1.328 3.242 1.445 3.477.117.234.195.508.039.82-.156.313-.234.508-.469.781-.234.273-.492.61-.703.82-.234.234-.477.488-.207.957.274.469 1.211 2 2.602 3.238 1.785 1.59 3.289 2.082 3.758 2.316.468.234.742.196 1.015-.117.274-.313 1.172-1.367 1.484-1.836.313-.469.625-.39 1.055-.234.43.156 2.734 1.289 3.203 1.523.469.234.781.352.898.547.117.195.117 1.133-.273 2.227z"/></svg>
    </a>
    <style>
    .wa-float {
        position: fixed;
        bottom: 92px;
        right: 24px;
        z-index: 9999;
        width: 56px;
        height: 56px;
        border-radius: 50%;
        background: #25d366;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 14px rgba(37,211,102,0.4), 0 2px 6px rgba(0,0,0,0.15);
        transition: all 0.3s ease;
        text-decoration: none;
    }
    .wa-float:hover {
        transform: scale(1.1) translateY(-2px);
        box-shadow: 0 8px 24px rgba(37,211,102,0.5), 0 4px 10px rgba(0,0,0,0.2);
    }
    .wa-float::after {
        content: @json(__('Chat with us'));
        position: absolute;
        right: 68px;
        background: #fff;
        color: #1a1a1a;
        padding: 8px 16px;
        border-radius: 10px;
        font-size: 0.82rem;
        font-weight: 700;
        white-space: nowrap;
        box-shadow: 0 4px 14px rgba(0,0,0,0.1);
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.25s;
        font-family: var(--font, sans-serif);
    }
    .wa-float:hover::after { opacity: 1; }
    @media (max-width: 480px) {
        .wa-float { width: 50px; height: 50px; bottom: 80px; right: 18px; }
        .wa-float svg { width: 24px; height: 24px; }
        .wa-float::after { display: none; }
    }
    </style>
    @endif

    {{-- ═══ SCRIPTS — deferred, non-blocking ═══ --}}

    {{-- AOS — loaded after page content --}}
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js" defer></script>

    {{-- Main app JS --}}
    @php
        $appJs = 'js/app.js';
        $jsVer = file_exists(public_path($appJs)) ? filemtime(public_path($appJs)) : time();
    @endphp
    <script src="{{ asset($appJs) }}?v={{ $jsVer }}" defer></script>

    @php
        $translationsJs = 'js/translations.js';
        $translationsVer = file_exists(public_path($translationsJs)) ? filemtime(public_path($translationsJs)) : time();
    @endphp
    <script src="{{ asset($translationsJs) }}?v={{ $translationsVer }}" defer></script>

    {{-- Crisp Chat — async, completely non-blocking --}}
    @if($crispId)
    <script>
    window.addEventListener('load', function() {
        var s = document.createElement('script');
        s.src = 'https://client.crisp.chat/l.js';
        s.async = true;
        document.head.appendChild(s);
    });
    </script>
    @endif

    {{-- Inline init — runs after defer scripts load --}}
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Init AOS with reduced motion support
        if (typeof AOS !== 'undefined') {
            var prefersReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
            AOS.init({
                duration: prefersReduced ? 0 : 550,
                once: true,
                offset: 50,
                easing: 'ease-out-cubic',
                disable: prefersReduced
            });
        }

        // Mobile drawer
        var mt = document.getElementById('mt');
        var md = document.getElementById('md');
        var mc = document.getElementById('mc');
        function openDrawer() { md.classList.add('open'); document.body.style.overflow = 'hidden'; mt.setAttribute('aria-expanded','true'); }
        function closeDrawer() { md.classList.remove('open'); document.body.style.overflow = ''; mt.setAttribute('aria-expanded','false'); }
        if (mt) mt.addEventListener('click', openDrawer);
        if (mc) mc.addEventListener('click', closeDrawer);
        if (md) {
            md.querySelectorAll('a').forEach(function(a) { a.addEventListener('click', closeDrawer); });
            md.addEventListener('click', function(e) { if (e.target === md) closeDrawer(); });
        }

        // Header scroll shadow — throttled via rAF
        var hdr = document.getElementById('hdr');
        var ticking = false;
        if (hdr) {
            window.addEventListener('scroll', function() {
                if (!ticking) {
                    requestAnimationFrame(function() {
                        hdr.classList.toggle('scrolled', window.scrollY > 40);
                        ticking = false;
                    });
                    ticking = true;
                }
            }, { passive: true });
        }
    });
    </script>

    @stack('scripts')
</body>
</html>
