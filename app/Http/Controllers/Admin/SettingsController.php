<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class SettingsController extends Controller
{
    public function index(): View
    {
        $settings = [
            'whatsapp_number' => Setting::get('whatsapp_number', ''),
            'crisp_website_id' => Setting::get('crisp_website_id', ''),
        ];

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'whatsapp_number' => 'nullable|string|max:20',
            'crisp_website_id' => 'nullable|string|max:255',
        ]);

        foreach ($validated as $key => $value) {
            Setting::set($key, $value ?? '');
        }

        return redirect()
            ->route('admin.settings.index')
            ->with('success', 'Settings updated successfully!');
    }
    public function stripe(): View
    {
        $settings = [
            'stripe_enabled' => Setting::get('stripe_enabled', '0'),
            'stripe_mode' => Setting::get('stripe_mode', 'test'),
            'stripe_publishable_key' => Setting::get('stripe_publishable_key', ''),
            'stripe_secret_key' => Setting::get('stripe_secret_key', ''),
            'stripe_webhook_secret' => Setting::get('stripe_webhook_secret', ''),
        ];


        return view('admin.settings.stripe', ['stripeSettings' => $settings]);
    }

    public function updateStripe(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'stripe_enabled' => 'boolean',
            'stripe_mode' => 'required|in:test,live',
            'stripe_publishable_key' => 'nullable|string|max:255',
            'stripe_secret_key' => 'nullable|string|max:255',
            'stripe_webhook_secret' => 'nullable|string|max:255',
        ]);

        Setting::set('stripe_enabled', $request->boolean('stripe_enabled') ? '1' : '0');
        Setting::set('stripe_mode', $validated['stripe_mode']);
        Setting::set('stripe_publishable_key', $validated['stripe_publishable_key'] ?? '');
        Setting::set('stripe_secret_key', $validated['stripe_secret_key'] ?? '');
        Setting::set('stripe_webhook_secret', $validated['stripe_webhook_secret'] ?? '');

        return redirect()
            ->route('admin.settings.stripe')
            ->with('success', 'Stripe settings updated successfully!');
    }

    public function email(): View
    {
        $settings = [
            'mail_driver' => Setting::get('mail_driver', 'smtp'),
            'mail_host' => Setting::get('mail_host', ''),
            'mail_port' => Setting::get('mail_port', '587'),
            'mail_username' => Setting::get('mail_username', ''),
            'mail_password' => Setting::get('mail_password', ''),
            'mail_encryption' => Setting::get('mail_encryption', 'tls'),
            'mail_from_address' => Setting::get('mail_from_address', ''),
            'mail_from_name' => Setting::get('mail_from_name', config('app.name')),
            'admin_notification_email' => Setting::get('admin_notification_email', ''),
        ];

        return view('admin.settings.email', ['emailSettings' => $settings]);
    }

    public function updateEmail(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'mail_host' => 'nullable|string|max:255',
            'mail_port' => 'nullable|numeric',
            'mail_username' => 'nullable|string|max:255',
            'mail_password' => 'nullable|string|max:255',
            'mail_encryption' => 'nullable|string|max:10',
            'mail_from_address' => 'nullable|email|max:255',
            'mail_from_name' => 'nullable|string|max:255',
            'admin_notification_email' => 'nullable|email|max:255',
        ]);

        foreach ($validated as $key => $value) {
            $finalValue = $value ?? '';
            if (in_array($key, ['mail_host', 'mail_port', 'mail_username', 'mail_encryption', 'mail_from_address', 'admin_notification_email'])) {
                $finalValue = trim($finalValue);
            }
            Setting::set($key, $finalValue);
        }

        Setting::set('mail_driver', 'smtp');

        return redirect()
            ->route('admin.settings.email')
            ->with('success', 'Email settings updated successfully!');
    }

    public function testEmail(Request $request): RedirectResponse
    {
        $request->validate(['test_email' => 'required|email']);

        try {
            \Illuminate\Support\Facades\Mail::raw(
                "This is a test email from your Live IPTV Now admin panel.\n\nIf you received this, your SMTP settings are configured correctly!\n\nSent at: " . now()->format('Y-m-d H:i:s'),
                function ($message) use ($request) {
                    $message->to($request->test_email)
                        ->subject('Test Email - Live IPTV Now');
                }
            );

            return redirect()
                ->route('admin.settings.email')
                ->with('success', 'Test email sent successfully to ' . $request->test_email . '! Check your inbox.');
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.settings.email')
                ->with('error', 'Failed to send test email: ' . $e->getMessage());
        }
    }

    public function nowpayments(): View
    {
        $settings = [
            'nowpayments_enabled' => Setting::get('nowpayments_enabled', '0'),
            'nowpayments_api_key' => Setting::get('nowpayments_api_key', ''),
            'nowpayments_ipn_secret' => Setting::get('nowpayments_ipn_secret', ''),
            'nowpayments_email' => Setting::get('nowpayments_email', ''),
            'nowpayments_password' => Setting::get('nowpayments_password', ''),
            'nowpayments_sandbox' => Setting::get('nowpayments_sandbox', '1'),
        ];


        return view('admin.settings.nowpayments', ['nowpaymentsSettings' => $settings]);
    }

    public function updateNowpayments(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nowpayments_sandbox' => 'boolean',
            'nowpayments_api_key' => 'nullable|string|max:255',
            'nowpayments_ipn_secret' => 'nullable|string|max:255',
            'nowpayments_email' => 'nullable|string|max:255',
            'nowpayments_password' => 'nullable|string|max:255',
        ]);

        Setting::set('nowpayments_enabled', $request->boolean('nowpayments_enabled') ? '1' : '0');
        Setting::set('nowpayments_sandbox', $request->boolean('nowpayments_sandbox') ? '1' : '0');
        Setting::set('nowpayments_api_key', trim($validated['nowpayments_api_key'] ?? ''));
        Setting::set('nowpayments_ipn_secret', trim($validated['nowpayments_ipn_secret'] ?? ''));
        Setting::set('nowpayments_email', trim($validated['nowpayments_email'] ?? ''));
        Setting::set('nowpayments_password', $validated['nowpayments_password'] ?? '');

        return redirect()
            ->route('admin.settings.nowpayments')
            ->with('success', 'NOWPayments settings updated successfully!');
    }

    public function testNowpayments(Request $request)
    {
        try {
            $service = new \App\Services\NOWPaymentsService();
            $result = $service->getStatus();
            return response()->json($result);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ]);
        }
    }

    public function exportBackup()
    {
        $users = \App\Models\User::all();
        $orders = \App\Models\Order::with(['user', 'package'])->get();

        $stats = [
            'total_orders' => \App\Models\Order::count(),
            'total_revenue' => \App\Models\Order::where('payment_status', 'completed')->sum('amount'),
            'pending_orders' => \App\Models\Order::where('order_status', 'pending')->count(),
            'total_users' => \App\Models\User::where('is_admin', false)->count(),
            'active_packages' => \App\Models\Package::where('is_active', true)->count(),
            'completed_orders' => \App\Models\Order::where('order_status', 'completed')->count(),
        ];

        $filename = "IPTV_FULL_BACKUP_" . date('Y-m-d') . ".xls";

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename=' . $filename);
        header('Cache-Control: max-age=0');

        echo '
        <html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
            <style>
                .title { font-weight: bold; font-size: 14pt; background-color: #4F81BD; color: #FFFFFF; text-align: center; }
                .heading { font-weight: bold; background-color: #f2f2f2; text-align: left; }
                .data-header { font-weight: bold; background-color: #D9E1F2; text-align: center; }
                td { border: 1px solid #7F7F7F; padding: 4px; vertical-align: middle; }
                .text-center { text-align: center; }
                .price { color: #008000; font-weight: bold; }
            </style>
        </head>
        <body>
            <!-- SYSTEM SUMMARY -->
            <table border="1">
                <tr><td colspan="2" class="title">SYSTEM STATS & SUMMARY OVERVIEW</td></tr>
                <tr><td width="200" class="heading">METRIC NAME</td><td width="200" class="heading">CURRENT VALUE</td></tr>
                <tr><td>TOTAL REVENUE</td><td class="price">$' . number_format($stats['total_revenue'], 2) . '</td></tr>
                <tr><td>TOTAL ORDERS</td><td>' . $stats['total_orders'] . '</td></tr>
                <tr><td>COMPLETED ORDERS</td><td>' . $stats['completed_orders'] . '</td></tr>
                <tr><td>PENDING ORDERS</td><td>' . $stats['pending_orders'] . '</td></tr>
                <tr><td>TOTAL REGISTERED USERS</td><td>' . $stats['total_users'] . '</td></tr>
                <tr><td>TOTAL ACTIVE PACKAGES</td><td>' . $stats['active_packages'] . '</td></tr>
                <tr><td>REPORT GENERATED ON</td><td>' . date('Y-m-d H:i:s') . '</td></tr>
            </table>
            
            <br>

            <!-- CUSTOMERS -->
            <table border="1">
                <tr><td colspan="8" class="title">USER DATABASE (CUSTOMER DETAILS)</td></tr>
                <tr class="data-header">
                    <td>S.NO</td><td>ID</td><td>FULL NAME</td><td>EMAIL ADDRESS</td><td>PHONE</td><td>COUNTRY</td><td>TYPE</td><td>JOIN DATE</td>
                </tr>';

        $userCount = 1;
        foreach ($users as $user) {
            echo '<tr>
                        <td class="text-center">' . $userCount++ . '</td>
                        <td class="text-center">' . $user->id . '</td>
                        <td>' . $user->name . '</td>
                        <td>' . $user->email . '</td>
                        <td>' . ($user->phone ?? 'N/A') . '</td>
                        <td>' . ($user->country ?? 'N/A') . '</td>
                        <td class="text-center">' . ($user->isAdmin() ? 'ADMIN' : 'USER') . '</td>
                        <td>' . $user->created_at->format('d M Y, h:i A') . '</td>
                    </tr>';
        }
        echo '</table>
            
            <br>

            <!-- SALES -->
            <table border="1">
                <tr><td colspan="10" class="title">SALES RECORD & SUBSCRIPTION DETAILS</td></tr>
                <tr class="data-header">
                    <td>S.NO</td><td>ORDER NO.</td><td>CUSTOMER NAME</td><td>PACKAGE NAME</td><td>AMOUNT</td><td>PAYMENT</td><td>STATUS</td><td>PORTAL URL</td><td>EXPIRY</td><td>DATE</td>
                </tr>';

        $orderCount = 1;
        foreach ($orders as $order) {
            echo '<tr>
                        <td class="text-center">' . $orderCount++ . '</td>
                        <td>' . $order->order_number . '</td>
                        <td>' . $order->customer_name . '</td>
                        <td>' . ($order->package->name ?? 'N/A') . '</td>
                        <td class="price">$' . number_format($order->amount, 2) . '</td>
                        <td class="text-center">' . strtoupper($order->payment_status) . '</td>
                        <td class="text-center">' . strtoupper($order->order_status) . '</td>
                        <td>' . ($order->portal_url ?? 'N/A') . '</td>
                        <td>' . ($order->expires_at ? $order->expires_at->format('d M Y') : 'LIFETIME') . '</td>
                        <td>' . $order->created_at->format('d M Y') . '</td>
                    </tr>';
        }
        echo '</table>
        </body>
        </html>';
        exit;
    }
}
