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

        // Settings, packages, and package mapping
        $settings = $this->xuiService->getSettings();
        $packages = Package::where('is_active', true)->orderBy('price', 'asc')->get();
        $packageMap = $settings['package_map'] ?? [];

        return view('secret-dashboard.index', compact(
            'orders',
            'totalOrders',
            'pendingOrders',
            'completedOrders',
            'totalRevenue',
            'settings',
            'packages',
            'packageMap',
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
            $sendEmail = $request->boolean('send_email', false);
            $customParams = array_filter([
                'package_id' => $request->input('package_id'),
                'username' => $request->input('custom_username'),
                'password' => $request->input('custom_password'),
                'duration_days' => $request->input('duration_days'),
            ]);

            $result = $this->xuiService->fulfillOrder($order, null, $sendEmail, $customParams);

            if (!$result['success']) {
                if ($request->wantsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => $result['message'],
                    ], 422);
                }

                return redirect()->back()->with('error', '❌ ' . $result['message']);
            }

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => $result['message'],
                    'credentials' => $result['credentials'] ?? [],
                ]);
            }

            return redirect()->back()->with('success', '🎉 Order #' . $order->order_number . ': ' . $result['message'] . ($sendEmail ? ' Credentials emailed to customer!' : ''));
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
     * Send or Resend Delivery Email with IPTV credentials to customer
     */
    public function sendEmail(Request $request, Order $order)
    {
        if (empty($order->subscription_details)) {
            return redirect()->back()->with('error', 'Cannot send email: Please generate IPTV credentials for this order first!');
        }

        try {
            $this->xuiService->sendDeliveryEmail($order);

            return redirect()->back()->with('success', '✉️ Delivery email with IPTV credentials sent successfully to ' . $order->customer_email . '!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to send customer email: ' . $e->getMessage());
        }
    }

    /**
     * Save Package Mapping (Website Package -> XUI Package ID)
     */
    public function updatePackageMapping(Request $request)
    {
        $packageMap = $request->input('package_map', []);
        if (is_array($packageMap)) {
            Setting::set('xui_package_map', json_encode($packageMap), 'json', 'iptv_xui');
        }

        return redirect()->back()->with('success', '🎉 Package mappings saved successfully! Each website plan will now auto-create with its mapped XUI package.');
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
            $sendEmail = $request->boolean('send_email', false);
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
        return $this->sendEmail(request(), $order);
    }

    /**
     * Update XUI / Xtream Panel Settings
     */
    public function updateSettings(Request $request)
    {
        $request->validate([
            'panel_url' => 'nullable|string|max:255',
            'api_url' => 'nullable|string|max:255',
            'api_key' => 'nullable|string|max:255',
            'username' => 'nullable|string|max:255',
            'password' => 'nullable|string|max:255',
            'portal_dns' => 'nullable|string|max:255',
            'output_format' => 'nullable|string|max:20',
            'default_bouquets' => 'nullable|string|max:255',
            'default_package_id' => 'nullable|string|max:50',
        ]);

        Setting::set('xui_panel_url', trim($request->input('panel_url', '')), 'text', 'iptv_xui');
        Setting::set('xui_api_url', trim($request->input('api_url', '')), 'text', 'iptv_xui');
        Setting::set('xui_api_key', trim($request->input('api_key', '')), 'text', 'iptv_xui');
        Setting::set('xui_username', trim($request->input('username', '')), 'text', 'iptv_xui');
        
        if ($request->filled('password')) {
            Setting::set('xui_password', trim($request->input('password')), 'password', 'iptv_xui');
        }

        Setting::set('xui_portal_dns', trim($request->input('portal_dns', '')), 'text', 'iptv_xui');
        Setting::set('xui_user_prefix', trim($request->input('user_prefix', 'user')), 'text', 'iptv_xui');
        Setting::set('xui_default_package_id', trim($request->input('default_package_id', '1')), 'text', 'iptv_xui');
        Setting::set('xui_auto_fulfill', $request->has('auto_fulfill') ? '1' : '0', 'boolean', 'iptv_xui');
        Setting::set('xui_output_format', trim($request->input('output_format', 'ts')), 'text', 'iptv_xui');
        Setting::set('xui_default_bouquets', trim($request->input('default_bouquets', '')), 'text', 'iptv_xui');

        return redirect()->back()->with('success', 'XUI.ONE Panel & API settings saved successfully!');
    }

    /**
     * Test connection to XUI Panel via AJAX
     */
    public function testConnection(Request $request)
    {
        $panelUrl = $request->input('panel_url');
        $apiUrl = $request->input('api_url');
        $apiKey = $request->input('api_key');
        $username = $request->input('username');
        $password = $request->input('password');

        $result = $this->xuiService->testConnection($panelUrl, $username, $password, $apiKey, $apiUrl);

        return response()->json($result);
    }
}
