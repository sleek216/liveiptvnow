<?php

namespace App\Support;

class SupportedLocales
{
    /**
     * @return array<string, array{label: string, native: string, flag: string}>
     */
    public static function all(): array
    {
        return [
            'en' => ['label' => 'English', 'native' => 'English', 'flag' => 'gb'],
            'es' => ['label' => 'Spanish', 'native' => 'Español', 'flag' => 'es'],
            'fr' => ['label' => 'French', 'native' => 'Français', 'flag' => 'fr'],
            'de' => ['label' => 'German', 'native' => 'Deutsch', 'flag' => 'de'],
            'pt' => ['label' => 'Portuguese', 'native' => 'Português', 'flag' => 'pt'],
            'it' => ['label' => 'Italian', 'native' => 'Italiano', 'flag' => 'it'],
            'ar' => ['label' => 'Arabic', 'native' => 'العربية', 'flag' => 'sa'],
            'nl' => ['label' => 'Dutch', 'native' => 'Nederlands', 'flag' => 'nl'],
        ];
    }

    public static function codes(): array
    {
        return array_keys(self::all());
    }

    public static function isSupported(string $locale): bool
    {
        return in_array($locale, self::codes(), true);
    }

    public static function resolve(?string $locale): string
    {
        if ($locale && self::isSupported($locale)) {
            return $locale;
        }

        return config('app.locale', 'en');
    }

    public static function isRtl(string $locale): bool
    {
        return $locale === 'ar';
    }
}
