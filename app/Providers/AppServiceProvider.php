<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Local dev uses /public (artisan serve). Production/cPanel uses /public_html.
        if (app()->environment('local') && file_exists(base_path('public/index.php'))) {
            $this->app->usePublicPath(base_path('public'));
            $this->app->bind('path.public', fn () => base_path('public'));
        } elseif (is_dir(base_path('public_html'))) {
            $this->app->usePublicPath(base_path('public_html'));
            $this->app->bind('path.public', fn () => base_path('public_html'));
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \Illuminate\Pagination\Paginator::useBootstrapFive();

        if (app()->environment('production') || request()->isSecure() || request()->header('X-Forwarded-Proto') === 'https' || str_starts_with(config('app.url', ''), 'https://')) {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }

        // Sync uploads from public to public_html on cPanel if needed
        if (is_dir(base_path('public/uploads')) && is_dir(base_path('public_html'))) {
            if (!is_dir(base_path('public_html/uploads'))) {
                @mkdir(base_path('public_html/uploads'), 0755, true);
            }
            if (is_dir(base_path('public/uploads/blogs')) && !is_dir(base_path('public_html/uploads/blogs'))) {
                @mkdir(base_path('public_html/uploads/blogs'), 0755, true);
            }
            foreach (glob(base_path('public/uploads/blogs/*.*')) as $file) {
                $dest = base_path('public_html/uploads/blogs/' . basename($file));
                if (!file_exists($dest)) {
                    @copy($file, $dest);
                }
            }
        }

        try {
            if (!\Illuminate\Support\Facades\Schema::hasTable('settings')) {
                return;
            }

            // Mail settings
            if ($mailDriver = \App\Models\Setting::get('mail_driver')) {
                config(['mail.default' => $mailDriver]);
            }
            if ($mailHost = \App\Models\Setting::get('mail_host')) {
                config(['mail.mailers.smtp.host' => $mailHost]);
            }
            if ($mailPort = \App\Models\Setting::get('mail_port')) {
                config(['mail.mailers.smtp.port' => (int) $mailPort]);
            }
            if ($mailUsername = \App\Models\Setting::get('mail_username')) {
                config(['mail.mailers.smtp.username' => $mailUsername]);
            }
            if ($mailPassword = \App\Models\Setting::get('mail_password')) {
                config(['mail.mailers.smtp.password' => $mailPassword]);
            }
            if ($mailEncryption = \App\Models\Setting::get('mail_encryption')) {
                $scheme = match ($mailEncryption) {
                    'ssl' => 'smtps',
                    'tls' => 'smtp',
                    default => null,
                };
                config(['mail.mailers.smtp.scheme' => $scheme]);
                config(['mail.mailers.smtp.encryption' => $mailEncryption]);
            }
            if ($mailFromAddress = \App\Models\Setting::get('mail_from_address')) {
                config(['mail.from.address' => $mailFromAddress]);
            }
            if ($mailFromName = \App\Models\Setting::get('mail_from_name')) {
                config(['mail.from.name' => $mailFromName]);
            }

            // Stripe settings
            if ($stripeKey = \App\Models\Setting::get('stripe_publishable_key')) {
                config(['services.stripe.key' => $stripeKey]);
            }
            if ($stripeSecret = \App\Models\Setting::get('stripe_secret_key')) {
                config(['services.stripe.secret' => $stripeSecret]);
            }
            if ($stripeWebhook = \App\Models\Setting::get('stripe_webhook_secret')) {
                config(['services.stripe.webhook.secret' => $stripeWebhook]);
            }

            // NOWPayments settings
            if ($nowPaymentKey = \App\Models\Setting::get('nowpayments_api_key')) {
                config(['services.nowpayments.api_key' => $nowPaymentKey]);
            }
            if ($nowPaymentSecret = \App\Models\Setting::get('nowpayments_ipn_secret')) {
                config(['services.nowpayments.ipn_secret' => $nowPaymentSecret]);
            }
            if ($nowPaymentEnv = \App\Models\Setting::get('nowpayments_sandbox')) {
                config(['services.nowpayments.sandbox' => $nowPaymentEnv]);
            }

            // Share admin sidebar notification counts
            \Illuminate\Support\Facades\View::composer('admin.layouts.app', function ($view) {
                $counts = \App\Support\AdminSidebarCounts::get();

                $view->with([
                    'adminCounts' => $counts,
                    'unreadOrdersCount' => $counts['orders'],
                    'unreadContactsCount' => $counts['contacts'],
                ]);
            });
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::warning('Could not load settings from database: ' . $e->getMessage());
        }
    }
}
