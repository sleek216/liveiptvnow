<?php

namespace App\Support;

class SiteTranslations
{
    public static function forLocale(?string $locale = null): array
    {
        $locale = SupportedLocales::resolve($locale ?? app()->getLocale());
        $translations = self::loadFile($locale);

        if ($locale === 'en') {
            return $translations;
        }

        return array_merge(self::loadFile('en'), $translations);
    }

    private static function loadFile(string $locale): array
    {
        $path = lang_path("{$locale}.json");

        if (!is_file($path)) {
            return [];
        }

        $data = json_decode((string) file_get_contents($path), true);

        return is_array($data) ? $data : [];
    }
}
