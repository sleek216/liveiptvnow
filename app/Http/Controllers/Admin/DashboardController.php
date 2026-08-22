<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Package;
use App\Models\User;
use App\Models\Contact;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(\Illuminate\Http\Request $request): View
    {
        $period = $request->get('revenue_period', 'all');
        $startDate = null;

        switch ($period) {
            case '1_week':
                $startDate = now()->subWeek();
                break;
            case '1_month':
                $startDate = now()->subMonth();
                break;
            case '3_months':
                $startDate = now()->subMonths(3);
                break;
            case '6_months':
                $startDate = now()->subMonths(6);
                break;
        }

        $revenueQuery = Order::paymentCompleted();
        if ($startDate) {
            $revenueQuery->where('created_at', '>=', $startDate);
        }
        $filteredRevenue = $revenueQuery->sum('amount');

        $stats = [
            'total_orders' => Order::count(),
            'pending_orders' => Order::pending()->count(),
            'completed_orders' => Order::completed()->count(),
            'total_revenue' => Order::paymentCompleted()->sum('amount'), // This remains total for the top card if desired, or we can use $filteredRevenue
            'filtered_revenue' => $filteredRevenue,
            'total_users' => User::where('is_admin', false)->count(),
            'active_packages' => Package::active()->count(),
            'pending_contacts' => Contact::where('status', 'new')->count(),
        ];

        $recentOrders = Order::with(['user', 'package'])
            ->latest()
            ->take(10)
            ->get();

        $recentUsers = User::where('is_admin', false)
            ->latest()
            ->take(5)
            ->get();

        $monthlyRevenue = Order::paymentCompleted()
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('amount');

        return view('admin.dashboard', compact('stats', 'recentOrders', 'recentUsers', 'monthlyRevenue', 'period'));
    }

    public function markAllNotificationsAsRead(): \Illuminate\Http\RedirectResponse
    {
        $ordersCount = Order::where('is_read', false)->update(['is_read' => true]);
        $contactsCount = Contact::where('status', 'new')->update(['status' => 'read']);
        \App\Models\Setting::set('admin_last_read_users_at', now()->toDateTimeString());
        \App\Models\Setting::set('admin_last_read_referrals_at', now()->toDateTimeString());

        return redirect()
            ->back()
            ->with('success', "All notifications marked as read ({$ordersCount} orders, {$contactsCount} contacts). Badges reset to 0.");
    }
}
