<?php

namespace App\Http\Controllers\IPTVAdmin;

use App\Http\Controllers\Controller;
use App\Models\IPTVOrder;
use App\Models\IPTVWebsite;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $websiteId = $request->session()->get('iptv_website_id');
        $query = IPTVOrder::query();
        
        if ($websiteId) {
            $query->where('iptv_website_id', $websiteId);
        }

        $totalOrders = (clone $query)->count();
        $pendingIPTV = (clone $query)->where('iptv_status', 'pending')->count();
        $totalRevenue = (clone $query)->where('payment_status', 'completed')->sum('amount');
        
        $websites = IPTVWebsite::all();

        return view('iptv-admin.dashboard', compact('totalOrders', 'pendingIPTV', 'totalRevenue', 'websites', 'websiteId'));
    }

    public function setWebsite(Request $request)
    {
        $request->session()->put('iptv_website_id', $request->website_id);
        return back();
    }
}
