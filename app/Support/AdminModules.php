<?php

namespace App\Support;

use Illuminate\Support\Str;

class AdminModules
{
    /**
     * @return array<string, array{label: string, section: string, routes: array<int, string>}>
     */
    public static function all(): array
    {
        return [
            'dashboard' => [
                'label' => 'Dashboard',
                'section' => 'Main',
                'routes' => ['admin.dashboard'],
            ],
            'packages' => [
                'label' => 'Packages',
                'section' => 'Management',
                'routes' => ['admin.packages.*'],
            ],
            'orders' => [
                'label' => 'Orders',
                'section' => 'Management',
                'routes' => ['admin.orders.*'],
            ],
            'users' => [
                'label' => 'Users',
                'section' => 'Management',
                'routes' => ['admin.users.*'],
            ],
            'countries' => [
                'label' => 'Countries',
                'section' => 'Management',
                'routes' => ['admin.countries.*'],
            ],
            'coupons' => [
                'label' => 'Coupons',
                'section' => 'Management',
                'routes' => ['admin.coupons.*'],
            ],
            'blogs' => [
                'label' => 'Blog Posts',
                'section' => 'Management',
                'routes' => ['admin.blogs.*'],
            ],
            'contacts' => [
                'label' => 'Contacts',
                'section' => 'Management',
                'routes' => ['admin.contacts.*'],
            ],
            'announcement' => [
                'label' => 'Announcement Bar',
                'section' => 'Management',
                'routes' => ['admin.announcement.*'],
            ],
            'affiliate_overview' => [
                'label' => 'Affiliate Overview',
                'section' => 'Affiliate Program',
                'routes' => ['admin.affiliate.index'],
            ],
            'affiliate_affiliates' => [
                'label' => 'Affiliates',
                'section' => 'Affiliate Program',
                'routes' => ['admin.affiliate.affiliates', 'admin.affiliate.affiliates.*'],
            ],
            'affiliate_referrals' => [
                'label' => 'Referrals',
                'section' => 'Affiliate Program',
                'routes' => ['admin.affiliate.referrals'],
            ],
            'affiliate_commissions' => [
                'label' => 'Commissions',
                'section' => 'Affiliate Program',
                'routes' => ['admin.affiliate.commissions', 'admin.affiliate.commissions.*'],
            ],
            'affiliate_payouts' => [
                'label' => 'Payouts',
                'section' => 'Affiliate Program',
                'routes' => ['admin.affiliate.payouts', 'admin.affiliate.payouts.*'],
            ],
            'affiliate_settings' => [
                'label' => 'Affiliate Settings',
                'section' => 'Affiliate Program',
                'routes' => ['admin.affiliate.settings', 'admin.affiliate.settings.*'],
            ],
            'settings_general' => [
                'label' => 'General Settings',
                'section' => 'Settings',
                'routes' => ['admin.settings.index', 'admin.settings.update'],
            ],
            'settings_stripe' => [
                'label' => 'Stripe Gateway',
                'section' => 'Settings',
                'routes' => ['admin.settings.stripe', 'admin.settings.update-stripe'],
            ],
            'settings_nowpayments' => [
                'label' => 'NOWPayments Crypto',
                'section' => 'Settings',
                'routes' => ['admin.settings.nowpayments', 'admin.settings.update-nowpayments', 'admin.settings.test-nowpayments'],
            ],
            'settings_email' => [
                'label' => 'Email Settings',
                'section' => 'Settings',
                'routes' => ['admin.settings.email', 'admin.settings.update-email', 'admin.settings.test-email'],
            ],
            'settings_backup' => [
                'label' => 'Data Backup',
                'section' => 'Settings',
                'routes' => ['admin.settings.backup'],
            ],
            'security' => [
                'label' => 'Security (2FA)',
                'section' => 'Settings',
                'routes' => ['admin.security.*'],
            ],
        ];
    }

    /**
     * @return array<string, array<string, array{label: string, section: string, routes: array<int, string>}>>
     */
    public static function grouped(): array
    {
        $grouped = [];

        foreach (self::all() as $key => $module) {
            $grouped[$module['section']][$key] = $module;
        }

        return $grouped;
    }

    public static function keys(): array
    {
        return array_keys(self::all());
    }

    public static function moduleForRoute(?string $routeName): ?string
    {
        if (!$routeName) {
            return null;
        }

        foreach (self::all() as $key => $module) {
            foreach ($module['routes'] as $pattern) {
                if (Str::is($pattern, $routeName)) {
                    return $key;
                }
            }
        }

        return null;
    }

    public static function defaultRouteForModules(array $modules): ?string
    {
        foreach (self::keys() as $key) {
            if (in_array($key, $modules, true)) {
                return self::routeNameForModule($key);
            }
        }

        return null;
    }

    public static function routeNameForModule(string $module): ?string
    {
        $routes = self::all()[$module]['routes'] ?? [];

        foreach ($routes as $pattern) {
            if (!str_contains($pattern, '*')) {
                return $pattern;
            }
        }

        return match ($module) {
            'packages' => 'admin.packages.index',
            'orders' => 'admin.orders.index',
            'users' => 'admin.users.index',
            'countries' => 'admin.countries.index',
            'coupons' => 'admin.coupons.index',
            'blogs' => 'admin.blogs.index',
            'contacts' => 'admin.contacts.index',
            'announcement' => 'admin.announcement.index',
            'affiliate_affiliates' => 'admin.affiliate.affiliates',
            'affiliate_commissions' => 'admin.affiliate.commissions',
            'affiliate_payouts' => 'admin.affiliate.payouts',
            'affiliate_settings' => 'admin.affiliate.settings',
            'security' => 'admin.security.index',
            default => null,
        };
    }
}
