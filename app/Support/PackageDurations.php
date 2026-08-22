<?php

namespace App\Support;

use App\Models\Package;
use Illuminate\Support\Collection;

class PackageDurations
{
    public const FILTERS = [
        '1_month',
        '3_months',
        '6_months',
        '12_months',
        'recharge',
        'lifetime',
    ];

    /**
     * @return array<string, Collection<int, Package>>
     */
    public static function group(Collection $packages, bool $includeAll = false): array
    {
        $grouped = [];

        if ($includeAll) {
            $grouped['all'] = $packages->values();
        }

        foreach (self::FILTERS as $filter) {
            $grouped[$filter] = $packages
                ->filter(fn (Package $package) => self::matches($package, $filter))
                ->values();
        }

        return $grouped;
    }

    public static function matches(Package $package, string $filter): bool
    {
        return self::filterKeyFor($package) === $filter;
    }

    public static function filterKeyFor(Package $package): string
    {
        $label = strtolower((string) $package->getRawOriginal('duration_label') ?: $package->duration_label);
        $name = strtolower((string) $package->name);

        if (
            str_contains($label, 'lifetime') ||
            str_contains($name, 'lifetime') ||
            (int) $package->duration_months >= 999
        ) {
            return 'lifetime';
        }

        if (
            str_contains($name, 'recharge') ||
            str_contains($name, 'renewal') ||
            str_contains($name, 'renew') ||
            str_contains($label, 'recharge')
        ) {
            return 'recharge';
        }

        return match ((int) $package->duration_months) {
            1 => '1_month',
            3 => '3_months',
            6 => '6_months',
            12 => '12_months',
            default => match (true) {
                str_contains($label, '1 month') => '1_month',
                str_contains($label, '3 month') => '3_months',
                str_contains($label, '6 month') => '6_months',
                str_contains($label, '12 month') || str_contains($label, '1 year') => '12_months',
                default => 'other',
            },
        };
    }

    public static function tabLabel(string $filter): string
    {
        return match ($filter) {
            'all' => 'All Plans',
            '1_month' => '1 Month',
            '3_months' => '3 Months',
            '6_months' => '6 Months',
            '12_months' => '1 Year',
            'recharge' => 'Recharge',
            'lifetime' => 'Lifetime',
            default => ucwords(str_replace('_', ' ', $filter)),
        };
    }

    public static function cardLabel(Package $package): string
    {
        $label = $package->getRawOriginal('duration_label');

        if (!empty($label)) {
            $label = preg_replace('/[\s\-\/\(\),]*\d+\s*connections?[\)\.]*/i', '', $label);
            return trim($label);
        }

        return match (self::filterKeyFor($package)) {
            '1_month' => '1 Month',
            '3_months' => '3 Months',
            '6_months' => '6 Months',
            '12_months' => '12 Months',
            'lifetime' => 'Lifetime',
            'recharge' => 'Recharge',
            default => 'Plan',
        };
    }

    public static function priceSuffix(Package $package): ?string
    {
        return match (self::filterKeyFor($package)) {
            '1_month' => '/month',
            '3_months' => 'Quarterly',
            '6_months' => 'Semi-Annually',
            '12_months' => 'Annually',
            'lifetime' => '/once',
            default => null,
        };
    }
}
