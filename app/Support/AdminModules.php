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
                'icon' => 'bi-speedometer2',
                'description' => 'Overview analytics and revenue stats',
                'routes' => ['admin.dashboard'],
            ],
            'packages' => [
                'label' => 'Packages',
                'section' => 'Management',
                'icon' => 'bi-box-seam',
                'description' => 'Manage IPTV plans, channels and pricing',
                'routes' => ['admin.packages.*'],
            ],
            'orders' => [
                'label' => 'Orders',
                'section' => 'Management',
                'icon' => 'bi-cart-check',
                'description' => 'Customer orders and invoice management',
                'routes' => ['admin.orders.*'],
            ],
            'users' => [
                'label' => 'Users',
                'section' => 'Management',
                'icon' => 'bi-people',
                'description' => 'Registered customers and user accounts',
                'routes' => ['admin.users.*'],
            ],
            'staff' => [
                'label' => 'Staff & Admins',
                'section' => 'Management',
                'icon' => 'bi-person-badge',
                'description' => 'Staff employees and granular permissions',
                'routes' => ['admin.staff.*'],
            ],
            'countries' => [
                'label' => 'Countries',
                'section' => 'Management',
                'icon' => 'bi-globe2',
                'description' => 'Server regions and country listings',
                'routes' => ['admin.countries.*'],
            ],
            'coupons' => [
                'label' => 'Coupons',
                'section' => 'Management',
                'icon' => 'bi-ticket-perforated',
                'description' => 'Promotional discount codes',
                'routes' => ['admin.coupons.*'],
            ],
            'blogs' => [
                'label' => 'Blog Posts',
                'section' => 'Management',
                'icon' => 'bi-newspaper',
                'description' => 'Articles and educational guides',
                'routes' => ['admin.blogs.*'],
            ],
            'contacts' => [
                'label' => 'Contacts',
                'section' => 'Management',
                'icon' => 'bi-chat-left-dots',
                'description' => 'Inquiries and customer messages',
                'routes' => ['admin.contacts.*'],
            ],
            'announcement' => [
                'label' => 'Announcement Bar',
                'section' => 'Management',
                'icon' => 'bi-megaphone',
                'description' => 'Global notification banner on store',
                'routes' => ['admin.announcement.*'],
            ],
            'affiliate_overview' => [
                'label' => 'Affiliate Overview',
                'section' => 'Affiliate Program',
                'icon' => 'bi-graph-up-arrow',
                'description' => 'Affiliate program summary statistics',
                'routes' => ['admin.affiliate.index'],
            ],
            'affiliate_affiliates' => [
                'label' => 'Affiliates',
                'section' => 'Affiliate Program',
                'icon' => 'bi-person-lines-fill',
                'description' => 'Enrolled affiliate partners',
                'routes' => ['admin.affiliate.affiliates', 'admin.affiliate.affiliates.*'],
            ],
            'affiliate_referrals' => [
                'label' => 'Referrals',
                'section' => 'Affiliate Program',
                'icon' => 'bi-share',
                'description' => 'Customer referrals and tracking',
                'routes' => ['admin.affiliate.referrals'],
            ],
            'affiliate_commissions' => [
                'label' => 'Commissions',
                'section' => 'Affiliate Program',
                'icon' => 'bi-cash-coin',
                'description' => 'Partner commissions and earnings',
                'routes' => ['admin.affiliate.commissions', 'admin.affiliate.commissions.*'],
            ],
            'affiliate_payouts' => [
                'label' => 'Payouts',
                'section' => 'Affiliate Program',
                'icon' => 'bi-wallet2',
                'description' => 'Affiliate payment requests',
                'routes' => ['admin.affiliate.payouts', 'admin.affiliate.payouts.*'],
            ],
            'affiliate_settings' => [
                'label' => 'Affiliate Settings',
                'section' => 'Affiliate Program',
                'icon' => 'bi-sliders2',
                'description' => 'Commission rates and cookie duration',
                'routes' => ['admin.affiliate.settings', 'admin.affiliate.settings.*'],
            ],
            'settings_general' => [
                'label' => 'General Settings',
                'section' => 'Settings',
                'icon' => 'bi-gear',
                'description' => 'Website configuration and branding',
                'routes' => ['admin.settings.index', 'admin.settings.update'],
            ],
            'settings_stripe' => [
                'label' => 'Stripe Gateway',
                'section' => 'Settings',
                'icon' => 'bi-credit-card',
                'description' => 'Credit card payment credentials',
                'routes' => ['admin.settings.stripe', 'admin.settings.update-stripe'],
            ],
            'settings_nowpayments' => [
                'label' => 'NOWPayments Crypto',
                'section' => 'Settings',
                'icon' => 'bi-currency-bitcoin',
                'description' => 'Crypto payment gateway configuration',
                'routes' => ['admin.settings.nowpayments', 'admin.settings.update-nowpayments', 'admin.settings.test-nowpayments'],
            ],
            'settings_email' => [
                'label' => 'Email Settings',
                'section' => 'Settings',
                'icon' => 'bi-envelope-at',
                'description' => 'SMTP mail server configuration',
                'routes' => ['admin.settings.email', 'admin.settings.update-email', 'admin.settings.test-email'],
            ],
            'settings_backup' => [
                'label' => 'Data Backup',
                'section' => 'Settings',
                'icon' => 'bi-database-down',
                'description' => 'System and database backups',
                'routes' => ['admin.settings.backup'],
            ],
            'security' => [
                'label' => 'Security (2FA)',
                'section' => 'Settings',
                'icon' => 'bi-shield-lock',
                'description' => 'Two-Factor Authentication controls',
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
            'staff' => 'admin.staff.index',
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
