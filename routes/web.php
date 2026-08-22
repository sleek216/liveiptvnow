<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\ChannelController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\NOWPaymentsController;
use App\Http\Controllers\AffiliateController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\PackageController as AdminPackageController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\CountryController as AdminCountryController;
use App\Http\Controllers\Admin\SettingsController as AdminSettingsController;
use App\Http\Controllers\Admin\AffiliateManagementController;
use App\Http\Controllers\ResellerController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\Admin\SecurityController as AdminSecurityController;
use App\Http\Controllers\Admin\CouponController as AdminCouponController;
use App\Http\Controllers\Admin\ContactController as AdminContactController;
use App\Http\Controllers\Admin\BlogController as AdminBlogController;
use App\Http\Controllers\TwoFactorController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LanguageController;

// Language Switcher
Route::get('lang/{locale}', [LanguageController::class, 'switch'])->name('lang.switch');

// Home
Route::get('/', [HomeController::class, 'index'])->name('home');

// Reseller
Route::get('/become-reseller', [ResellerController::class, 'index'])->name('reseller.index');

// Blog
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');

// Packages
Route::get('/packages', [PackageController::class, 'index'])->name('packages.index');
Route::get('/packages/{slug}', [PackageController::class, 'show'])->name('packages.show');

// Checkout (requires authentication)
Route::middleware('auth')->group(function () {
    Route::post('/checkout/apply-coupon', [CheckoutController::class, 'applyCoupon'])->name('checkout.apply-coupon');
    Route::get('/checkout/{slug}', [CheckoutController::class, 'show'])->name('checkout.show');
    Route::post('/checkout/{slug}', [CheckoutController::class, 'process'])->name('checkout.process');
});

// GitHub Auto-Deploy Webhook
Route::match(['GET', 'POST'], '/deploy-webhook', [App\Http\Controllers\DeployWebhookController::class, 'handle'])->name('deploy.webhook');

// Stripe webhook (no auth/CSRF required)
Route::post('/stripe/webhook', [StripeController::class, 'webhook'])->name('stripe.webhook');

// Stripe callbacks (no auth required — user returns from Stripe)
Route::get('/payment/success/{order}', [StripeController::class, 'success'])->name('stripe.success');
Route::get('/payment/cancel/{order}', [StripeController::class, 'cancel'])->name('stripe.cancel');

// Order result pages
Route::get('/order/success/{orderNumber}', [CheckoutController::class, 'success'])->name('checkout.success');
Route::get('/order/pending/{orderNumber}', [CheckoutController::class, 'pending'])->name('checkout.pending');

// Stripe checkout initiation (requires auth — creates Stripe session)
Route::get('/stripe/checkout/{orderNumber}', [StripeController::class, 'checkout'])->name('stripe.checkout')->middleware('auth');

// NOWPayments routes
Route::post('/nowpayments/payment/{order}', [NOWPaymentsController::class, 'createPayment'])->name('nowpayments.payment')->middleware('auth');
Route::get('/nowpayments/invoice/{order}', [NOWPaymentsController::class, 'createInvoice'])->name('nowpayments.invoice')->middleware('auth');
Route::post('/nowpayments/ipn', [NOWPaymentsController::class, 'handleIPN'])->name('nowpayments.ipn');
Route::get('/nowpayments/success/{orderNumber}', [NOWPaymentsController::class, 'success'])->name('nowpayments.success');
Route::get('/nowpayments/cancel/{orderNumber}', [NOWPaymentsController::class, 'cancel'])->name('nowpayments.cancel');
Route::get('/nowpayments/currencies', [NOWPaymentsController::class, 'getCurrencies'])->name('nowpayments.currencies');
Route::post('/nowpayments/estimate', [NOWPaymentsController::class, 'getEstimate'])->name('nowpayments.estimate');


// Contact
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// FAQ
Route::get('/faq', [FaqController::class, 'index'])->name('faq');

// Channels
Route::get('/channels', [ChannelController::class, 'index'])->name('channels');

// Static Pages
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/how-it-works', [PageController::class, 'howItWorks'])->name('how-it-works');
Route::get('/terms', [PageController::class, 'terms'])->name('terms');
Route::get('/privacy', [PageController::class, 'privacy'])->name('privacy');
Route::get('/refund', [PageController::class, 'refund'])->name('refund');
Route::get('/affiliate-program', [PageController::class, 'affiliateInfo'])->name('affiliate.info');
// Note: /affiliate route is now handled by AffiliateController (user dashboard)

// Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');

    Route::post('/register', [AuthController::class, 'register']);

    // Password Reset Routes
    Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
    Route::get('/forgot_password', [AuthController::class, 'showForgotPassword']);
    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
    Route::post('/forgot_password', [AuthController::class, 'sendResetLink']);
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetPassword'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

    // 2FA Routes
    Route::get('/2fa', [TwoFactorController::class, 'showVerification'])->name('2fa.show');
    Route::post('/2fa', [TwoFactorController::class, 'verify'])->name('2fa.verify');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/profile', [AuthController::class, 'showProfile'])->name('profile');
    Route::put('/profile', [AuthController::class, 'updateProfile'])->name('profile.update');
    Route::put('/profile/password', [AuthController::class, 'updatePassword'])->name('profile.password');

    // Affiliate Routes (dashboard is in profile, these are for detailed pages)
    Route::prefix('affiliate')->name('affiliate.')->group(function () {
        Route::get('/referrals', [AffiliateController::class, 'referrals'])->name('referrals');
        Route::get('/commissions', [AffiliateController::class, 'commissions'])->name('commissions');
        Route::get('/payouts', [AffiliateController::class, 'payouts'])->name('payouts');
        Route::get('/payouts/request', [AffiliateController::class, 'requestPayoutForm'])->name('payouts.request');
        Route::post('/payouts/request', [AffiliateController::class, 'requestPayout'])->name('payouts.submit');
    });
});

// Admin Secret Portal Routes
Route::prefix('my-secret-portal-9821')->name('admin.')->group(function () {
    // Admin Guest Routes (Secret Login)
    Route::get('/login', [App\Http\Controllers\Admin\AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [App\Http\Controllers\Admin\AuthController::class, 'login'])->name('login.submit');

    // Authenticated Admin Routes
    Route::middleware(['admin', 'admin.module'])->group(function () {
        Route::post('/logout', [App\Http\Controllers\Admin\AuthController::class, 'logout'])->name('logout');

        // Dashboard
        Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

        // Packages Management
        Route::resource('packages', AdminPackageController::class);
        Route::post('packages/{package}/toggle-active', [AdminPackageController::class, 'toggleActive'])->name('packages.toggle-active');

        // Orders Management
        Route::get('orders', [AdminOrderController::class, 'index'])->name('orders.index');
        Route::get('orders/create', [AdminOrderController::class, 'create'])->name('orders.create');
        Route::get('orders/search-user', [AdminOrderController::class, 'searchUser'])->name('orders.search-user'); // For searching user by email/name
        Route::post('orders/bulk-status', [AdminOrderController::class, 'bulkUpdateStatus'])->name('orders.bulk-status');
        Route::post('orders/mark-all-read', [AdminOrderController::class, 'markAllAsRead'])->name('orders.mark-all-read');
        Route::post('orders', [AdminOrderController::class, 'store'])->name('orders.store');
        Route::get('orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
        Route::get('orders/{order}/edit', [AdminOrderController::class, 'edit'])->name('orders.edit');
        Route::put('orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.update-status');
        Route::put('orders/{order}/payment-status', [AdminOrderController::class, 'updatePaymentStatus'])->name('orders.update-payment-status');
        Route::put('orders/{order}', [AdminOrderController::class, 'update'])->name('orders.update');
        Route::post('orders/{order}/send-email', [AdminOrderController::class, 'sendEmail'])->name('orders.send-email');
        Route::get('orders/{order}/invoice', [AdminOrderController::class, 'invoice'])->name('orders.invoice');
        Route::delete('orders/{order}', [AdminOrderController::class, 'destroy'])->name('orders.destroy');

        // Users Management
        Route::get('users', [AdminUserController::class, 'index'])->name('users.index');
        Route::get('users/create', [AdminUserController::class, 'create'])->name('users.create');
        Route::post('users/mark-all-read', [AdminUserController::class, 'markAllAsRead'])->name('users.mark-all-read');
        Route::post('users', [AdminUserController::class, 'store'])->name('users.store');
        Route::get('users/{user}', [AdminUserController::class, 'show'])->name('users.show');
        Route::get('users/{user}/edit', [AdminUserController::class, 'edit'])->name('users.edit');
        Route::put('users/{user}', [AdminUserController::class, 'update'])->name('users.update');
        Route::post('users/{user}/reset-password', [AdminUserController::class, 'resetPassword'])->name('users.reset-password');
        Route::post('users/{user}/commission-rate', [AdminUserController::class, 'updateCommissionRate'])->name('users.update-commission-rate');
        Route::delete('users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');

        // Global Mark All Read
        Route::post('notifications/mark-all-read', [AdminDashboardController::class, 'markAllNotificationsAsRead'])->name('notifications.mark-all-read');

        // Countries Management
        Route::resource('countries', AdminCountryController::class);
        Route::post('countries/{country}/toggle-active', [AdminCountryController::class, 'toggleActive'])->name('countries.toggle-active');

        // Settings
        Route::get('settings', [AdminSettingsController::class, 'index'])->name('settings.index');
        Route::put('settings', [AdminSettingsController::class, 'update'])->name('settings.update');
        Route::get('settings/stripe', [AdminSettingsController::class, 'stripe'])->name('settings.stripe');
        Route::put('settings/stripe', [AdminSettingsController::class, 'updateStripe'])->name('settings.update-stripe');
        Route::get('settings/email', [AdminSettingsController::class, 'email'])->name('settings.email');
        Route::put('settings/email', [AdminSettingsController::class, 'updateEmail'])->name('settings.update-email');
        Route::post('settings/email/test', [AdminSettingsController::class, 'testEmail'])->name('settings.test-email');
        Route::get('settings/nowpayments', [AdminSettingsController::class, 'nowpayments'])->name('settings.nowpayments');
        Route::put('settings/nowpayments', [AdminSettingsController::class, 'updateNowpayments'])->name('settings.update-nowpayments');
        Route::post('settings/nowpayments/test', [AdminSettingsController::class, 'testNowpayments'])->name('settings.test-nowpayments');
        Route::get('settings/backup', [AdminSettingsController::class, 'exportBackup'])->name('settings.backup');

        // Coupons Management
        Route::resource('coupons', AdminCouponController::class);
        Route::post('coupons/{coupon}/toggle-active', [AdminCouponController::class, 'toggleActive'])->name('coupons.toggle-active');

        // Blogs Management
        Route::resource('blogs', AdminBlogController::class);
        Route::post('blogs/{blog}/toggle-active', [AdminBlogController::class, 'toggleActive'])->name('blogs.toggle-active');
        Route::post('blogs/{blog}/toggle-featured', [AdminBlogController::class, 'toggleFeatured'])->name('blogs.toggle-featured');

        // Announcement Bar
        Route::get('announcement', [App\Http\Controllers\Admin\AnnouncementController::class, 'index'])->name('announcement.index');
        Route::put('announcement', [App\Http\Controllers\Admin\AnnouncementController::class, 'update'])->name('announcement.update');

        // Security & 2FA
        Route::get('security', [AdminSecurityController::class, 'index'])->name('security.index');
        Route::post('security/enable', [AdminSecurityController::class, 'enable'])->name('security.enable');
        Route::post('security/disable', [AdminSecurityController::class, 'disable'])->name('security.disable');

        // Contacts Management
        Route::get('contacts', [AdminContactController::class, 'index'])->name('contacts.index');
        Route::post('contacts/mark-all-read', [AdminContactController::class, 'markAllAsRead'])->name('contacts.mark-all-read');
        Route::get('contacts/{contact}', [AdminContactController::class, 'show'])->name('contacts.show');
        Route::put('contacts/{contact}/status', [AdminContactController::class, 'updateStatus'])->name('contacts.update-status');
        Route::delete('contacts/{contact}', [AdminContactController::class, 'destroy'])->name('contacts.destroy');

        // Affiliate Management
        Route::prefix('affiliate')->name('affiliate.')->group(function () {
            Route::get('/', [AffiliateManagementController::class, 'index'])->name('index');
            Route::get('/referrals', [AffiliateManagementController::class, 'referrals'])->name('referrals');
            Route::post('/referrals/mark-all-read', [AffiliateManagementController::class, 'markReferralsAsRead'])->name('referrals.mark-all-read');
            Route::get('/affiliates', [AffiliateManagementController::class, 'affiliates'])->name('affiliates');
            Route::post('/affiliates/{affiliate}/toggle', [AffiliateManagementController::class, 'toggleStatus'])->name('affiliates.toggle');
            Route::post('/affiliates/{affiliate}/commission-rate', [AffiliateManagementController::class, 'updateCommissionRate'])->name('affiliates.commission-rate');
            Route::post('/affiliates/{affiliate}/pay', [AffiliateManagementController::class, 'payAffiliate'])->name('affiliates.pay');

            Route::get('/commissions', [AffiliateManagementController::class, 'commissions'])->name('commissions');
            Route::post('/commissions/{commission}/approve', [AffiliateManagementController::class, 'approveCommission'])->name('commissions.approve');
            Route::post('/commissions/{commission}/reject', [AffiliateManagementController::class, 'rejectCommission'])->name('commissions.reject');
            Route::post('/commissions/{commission}/pay', [AffiliateManagementController::class, 'payCommission'])->name('commissions.pay');

            Route::get('/payouts', [AffiliateManagementController::class, 'payouts'])->name('payouts');
            Route::post('/payouts/{payout}/approve', [AffiliateManagementController::class, 'approvePayout'])->name('payouts.approve');
            Route::post('/payouts/{payout}/complete', [AffiliateManagementController::class, 'completePayout'])->name('payouts.complete');
            Route::post('/payouts/{payout}/reject', [AffiliateManagementController::class, 'rejectPayout'])->name('payouts.reject');

            Route::get('/settings', [AffiliateManagementController::class, 'settings'])->name('settings');
            Route::put('/settings', [AffiliateManagementController::class, 'updateSettings'])->name('settings.update');
        });
    });
});

// Custom Dashboard Route
Route::get('/my-custom-dashboard-77', function () {
    return view('custom-dashboard');
});
