@php
    $currentLocale = app()->getLocale();
    $locales = \App\Support\SupportedLocales::all();
    $current = $locales[$currentLocale] ?? $locales['en'];
@endphp

<div class="lang-switcher" data-lang-switcher>
    <button type="button" class="lang-switcher-btn" data-lang-toggle aria-haspopup="true" aria-expanded="false" aria-label="{{ __('Change language') }}">
        <span class="lang-switcher-flag">@include('layouts.partials.flag-icon', ['code' => $current['flag']])</span>
        <span class="lang-switcher-label">{{ $current['native'] }}</span>
        <i class="ri-arrow-down-s-line lang-switcher-caret" aria-hidden="true"></i>
    </button>
    <div class="lang-switcher-menu" data-lang-menu role="menu">
        @foreach($locales as $code => $locale)
            <a
                href="{{ route('lang.switch', $code) }}"
                class="lang-switcher-option {{ $currentLocale === $code ? 'is-active' : '' }}"
                role="menuitem"
                lang="{{ $code }}"
            >
                <span class="lang-switcher-flag lang-switcher-option-flag">@include('layouts.partials.flag-icon', ['code' => $locale['flag']])</span>
                <span class="lang-switcher-option-text">{{ $locale['native'] }}</span>
                @if($currentLocale === $code)
                    <i class="ri-check-line lang-switcher-check" aria-hidden="true"></i>
                @endif
            </a>
        @endforeach
    </div>
</div>
