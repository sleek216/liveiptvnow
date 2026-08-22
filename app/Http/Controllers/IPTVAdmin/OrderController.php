<?php

namespace App\Http\Controllers\IPTVAdmin;

use App\Http\Controllers\Controller;
use App\Models\IPTVOrder;
use App\Models\IPTVPackageMapping;
use App\Models\IPTVProvider;
use App\Services\IPTV\Providers\XUIProvider;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $websiteId = $request->session()->get('iptv_website_id');
        $query = IPTVOrder::with('website');
        
        if ($websiteId) {
            $query->where('iptv_website_id', $websiteId);
        }

        $orders = $query->orderBy('created_at', 'desc')->get();
        return view('iptv-admin.orders.index', compact('orders'));
    }

    public function createIPTV(Request $request, IPTVOrder $order)
    {
        // 1. Find mapping
        $mapping = IPTVPackageMapping::where('iptv_website_id', $order->iptv_website_id)
            ->where('external_package_id', $order->external_package_id)
            ->first();

        if (!$mapping) {
            return back()->with('error', 'No package mapping found for this order.');
        }

        // 2. Initialize Provider Service
        $providerModel = $mapping->provider;
        $providerService = new XUIProvider($providerModel); // Standardized to XUI for now

        // 3. Create Line
        $username = 'u_' . uniqid();
        $password = 'p_' . substr(md5(uniqid()), 0, 8);

        $result = $providerService->createLine([
            'username' => $username,
            'password' => $password,
            'duration_days' => $mapping->duration_days,
            'max_connections' => $mapping->max_connections,
            'provider_package_id' => $mapping->provider_package_id,
            'bouquet_ids' => $mapping->bouquet_ids,
        ]);

        if ($result['success']) {
            $order->update(['iptv_status' => 'created']);
            $order->iptvAccount()->create([
                'iptv_provider_id' => $providerModel->id,
                'username' => $username,
                'password' => $password,
                'provider_client_id' => $result['client_id'],
                'expires_at' => now()->addDays($mapping->duration_days)
            ]);
            return back()->with('success', 'IPTV Account created successfully!');
        }

        return back()->with('error', 'Provider Error: ' . $result['message']);
    }
}
