<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Package;
use App\Models\Setting;
use App\Services\XUIService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderConfirmationMail;

class SecretResellerDashboardController extends Controller
{
    protected XUIService $xuiService;

    public function __construct(XUIService $xuiService)
    {
        $this->xuiService = $xuiService;
    }

    /**
     * Display the Secret Reseller & Order Automation Dashboard
     */
    public function index(Request $request)
    {
        $statusFilter = $request->get('status', 'all');
        $searchQuery = $request->get('search', '');

        $query = Order::with('package')->latest();

        // Search filter
        if (!empty($searchQuery)) {
            $query->where(function ($q) use ($searchQuery) {
                $q->where('order_number', 'like', "%{$searchQuery}%")
                  ->orWhere('customer_name', 'like', "%{$searchQuery}%")
                  ->orWhere('customer_email', 'like', "%{$searchQuery}%");
            });
        }

        // Status tab filter
        if ($statusFilter === 'pending') {
            $query->where(function ($q) {
                $q->where('order_status', '!=', 'completed')
                  ->orWhereNull('subscription_details');
            });
        } elseif ($statusFilter === 'completed') {
            $query->where('order_status', 'completed')
                  ->whereNotNull('subscription_details');
        } elseif ($statusFilter === 'unpaid') {
            $query->where('payment_status', '!=', 'completed');
        }

        $orders = $query->paginate(20)->withQueryString();

        // Stats summary
        $totalOrders = Order::count();
        $pendingOrders = Order::where(function ($q) {
            $q->where('order_status', '!=', 'completed')
              ->orWhereNull('subscription_details');
        })->count();
        $completedOrders = Order::where('order_status', 'completed')->whereNotNull('subscription_details')->count();
        $totalRevenue = Order::where('payment_status', 'completed')->sum('amount');

        // Settings and packages
        $settings = $this->xuiService->getSettings();
        $packages = Package::where('is_active', true)->get();

        return view('secret-dashboard.index', compact(
            'orders',
            'totalOrders',
            'pendingOrders',
            'completedOrders',
            'totalRevenue',
            'settings',
            'packages',
            'statusFilter',
            'searchQuery'
        ));
    }

    /**
     * 1-Click Generate & Deliver Order via XUI / Xtream API
     */
    public function generateOrder(Request $request, Order $order)
    {
        try {
            $result = $this->xuiService->fulfillOrder($order, null, true);

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => $result['message'],
                    'credentials' => $result['credentials'],
                ]);
            }

            return redirect()->back()->with('success', 'Order #' . $order->order_number . ': ' . $result['message']);
        } catch (\Exception $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()->with('error', 'Failed to generate order: ' . $e->getMessage());
        }
    }

    /**
     * Manually assign custom credentials and deliver to customer
     */
    public function manualDeliver(Request $request, Order $order)
    {
        $request->validate([
            'username' => 'required|string|max:100',
            'password' => 'required|string|max:100',
            'portal_url' => 'nullable|string|max:255',
            'm3u_url' => 'nullable|string|max:500',
            'duration_days' => 'nullable|integer|min:1',
            'send_email' => 'nullable|boolean',
        ]);

        try {
            $sendEmail = $request->boolean('send_email', true);
            $manualData = [
                'username' => trim($request->username),
                'password' => trim($request->password),
                'portal_url' => trim($request->portal_url),
                'm3u_url' => trim($request->m3u_url),
                'duration_days' => (int)$request->duration_days ?: 30,
            ];

            $result = $this->xuiService->fulfillOrder($order, $manualData, $sendEmail);

            return redirect()->back()->with('success', 'Order #' . $order->order_number . ' updated with custom credentials' . ($sendEmail ? ' and delivery email sent!' : '!'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Manual delivery failed: ' . $e->getMessage());
        }
    }

    /**
     * Resend delivery confirmation email with credentials
     */
    public function resendEmail(Order $order)
    {
        if (empty($order->subscription_details)) {
            return redirect()->back()->with('error', 'Cannot resend email: No IPTV credentials generated for this order yet.');
        }

        if (empty($order->customer_email)) {
            return redirect()->back()->with('error', 'Order has no customer email address.');
        }

        try {
            Mail::to($order->customer_email)->send(
                new OrderConfirmationMail($order, $order->subscription_details)
            );
            $order->update(['email_sent_at' => now()]);

            return redirect()->back()->with('success', 'Delivery email resent successfully to ' . $order->customer_email);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to send email: ' . $e->getMessage());
        }
    }

    /**
     * Update XUI / Xtream Panel Settings
     */
    public function updateSettings(Request $request)
    {
        $request->validate([
            'panel_url' => 'nullable|string|max:255',
            'username' => 'nullable|string|max:255',
            'password' => 'nullable|string|max:255',
            'portal_dns' => 'nullable|string|max:255',
            'output_format' => 'nullable|string|max:20',
            'default_bouquets' => 'nullable|string|max:255',
        ]);

        Setting::set('xui_panel_url', trim($request->input('panel_url', '')), 'text', 'iptv_xui');
        Setting::set('xui_username', trim($request->input('username', '')), 'text', 'iptv_xui');
        
        if ($request->filled('password')) {
            Setting::set('xui_password', trim($request->input('password')), 'password', 'iptv_xui');
        }

        Setting::set('xui_portal_dns', trim($request->input('portal_dns', 'http://kytv.xyz:8080')), 'text', 'iptv_xui');
        Setting::set('xui_user_prefix', trim($request->input('user_prefix', 'bestuser')), 'text', 'iptv_xui');
        Setting::set('xui_auto_fulfill', $request->has('auto_fulfill') ? '1' : '0', 'boolean', 'iptv_xui');
        Setting::set('xui_output_format', trim($request->input('output_format', 'ts')), 'text', 'iptv_xui');
        Setting::set('xui_default_bouquets', trim($request->input('default_bouquets', '')), 'text', 'iptv_xui');

        return redirect()->back()->with('success', 'XUI / Xtream Panel settings saved successfully!');
    }

    /**
     * Test connection to XUI Panel via AJAX
     */
    public function testConnection(Request $request)
    {
        $url = $request->input('panel_url') ?: Setting::get('xui_panel_url', '');
        $username = $request->input('username') ?: Setting::get('xui_username', '');
        $password = $request->input('password') ?: Setting::get('xui_password', '');

        $result = $this->xuiService->testConnection($url, $username, $password);

        return response()->json($result);
    }
}
