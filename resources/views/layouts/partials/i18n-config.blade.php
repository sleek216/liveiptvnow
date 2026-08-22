@php
    $siteLocale = app()->getLocale();
    $siteTranslations = \App\Support\SiteTranslations::forLocale($siteLocale);
@endphp
<script>
window.SITE_LOCALE = @json($siteLocale);
window.SITE_TRANSLATIONS = @json($siteTranslations);
window.SITE_RTL = @json(\App\Support\SupportedLocales::isRtl($siteLocale));
</script>
