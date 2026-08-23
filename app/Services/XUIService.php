<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Setting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderConfirmationMail;

class XUIService
{
    /**
     * Get XUI / Xtream settings from database
     */
    public function getSettings(): array
    {
        return [
            'panel_url' => Setting::get('xui_panel_url', ''),
            'username' => Setting::get('xui_username', ''),
            'password' => Setting::get('xui_password', ''),
            'portal_dns' => Setting::get('xui_portal_dns', 'http://Live IPTV Now.com:8080'),
            'auto_fulfill' => Setting::get('xui_auto_fulfill', '0') === '1',
            'output_format' => Setting::get('xui_output_format', 'ts'),
            'default_bouquets' => Setting::get('xui_default_bouquets', ''),
            'panel_type' => Setting::get('xui_panel_type', 'xui'), // xui, xtream, xui_one
        ];
    }

    /**
     * Test connection to the XUI / Xtream panel
     */
    public function testConnection(string $url, string $username, string $password): array
    {
        $baseUrl = rtrim(trim($url), '/');
        if (empty($baseUrl)) {
            return [
                'success' => false,
                'message' => 'Panel URL cannot be empty.',
            ];
        }

        try {
            // Attempt 1: Standard player/reseller api test
            $response = Http::timeout(8)->get($baseUrl . '/player_api.php', [
                'username' => $username,
                'password' => $password,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                if (isset($data['user_info']['auth']) && $data['user_info']['auth'] == 1) {
                    $exp = isset($data['user_info']['exp_date']) ? date('Y-m-d', (int)$data['user_info']['exp_date']) : 'Active';
                    return [
                        'success' => true,
                        'message' => 'Successfully connected to Xtream / XUI API! Reseller account is active.',
                        'data' => [
                            'status' => $data['user_info']['status'] ?? 'Active',
                            'expires' => $exp,
                            'max_connections' => $data['user_info']['max_connections'] ?? 1,
                        ]
                    ];
                }
            }

            // Attempt 2: XUI Panel Login / Status Endpoint
            $loginResponse = Http::timeout(8)->post($baseUrl . '/login', [
                'username' => $username,
                'password' => $password,
            ]);

            if ($loginResponse->successful()) {
                return [
                    'success' => true,
                    'message' => 'Successfully connected to XUI Panel!',
                    'data' => ['status' => 'Online']
                ];
            }

            // Attempt 3: API ping endpoint
            $apiPing = Http::timeout(8)->get($baseUrl . '/api.php', [
                'action' => 'user_info',
                'user' => $username,
                'password' => $password,
            ]);

            if ($apiPing->successful()) {
                return [
                    'success' => true,
                    'message' => 'Panel responded successfully via api.php!',
                    'data' => $apiPing->json() ?? ['status' => 'Online']
                ];
            }

            return [
                'success' => false,
                'message' => 'Connected to server but authentication failed. Please check your username and password. (HTTP ' . ($response->status() ?: $loginResponse->status()) . ')',
            ];
        } catch (\Exception $e) {
            Log::error('XUI test connection failed: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Could not connect to panel: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Create line on XUI Panel or generate Xtream credentials
     */
    public function createLine(Order $order, array $customParams = []): array
    {
        $settings = $this->getSettings();
        $package = $order->package;

        // Determine duration in days
        $durationDays = 30; // default 1 month
        if ($package) {
            if (!empty($package->duration_days)) {
                $durationDays = (int)$package->duration_days;
            } elseif (!empty($package->duration_months)) {
                $durationDays = (int)$package->duration_months * 30;
            }
        }

        $devices = $package && $package->devices ? (int)$package->devices : 1;

        // Generate clean username & password
        $cleanName = preg_replace('/[^a-zA-Z0-9]/', '', strtolower($order->customer_name ?: 'user'));
        $username = $customParams['username'] ?? ($cleanName . '_' . rand(1000, 9999));
        $password = $customParams['password'] ?? substr(md5(uniqid(rand(), true)), 0, 8);
        $portalDns = rtrim($customParams['portal_dns'] ?? ($settings['portal_dns'] ?: 'http://Live IPTV Now.com:8080'), '/');
        $outputFormat = $settings['output_format'] ?: 'ts';

        $expireTimestamp = now()->addDays($durationDays)->timestamp;
        $expireDate = now()->addDays($durationDays);

        $lineCreatedOnPanel = false;
        $panelMessage = '';

        // If Panel URL is configured, attempt API call to create line
        if (!empty($settings['panel_url']) && !empty($settings['username']) && !empty($settings['password'])) {
            try {
                $apiUrl = rtrim($settings['panel_url'], '/');

                // Try XUI API line creation
                $createPayload = [
                    'username' => $username,
                    'password' => $password,
                    'expire_date' => $expireTimestamp,
                    'max_connections' => $devices,
                    'package' => $customParams['package_id'] ?? 1,
                    'bouquet' => !empty($settings['default_bouquets']) ? explode(',', $settings['default_bouquets']) : [],
                ];

                $response = Http::timeout(10)->post($apiUrl . '/api/line/create', $createPayload);

                if ($response->successful() && ($response->json('success') || $response->json('status') == 'success')) {
                    $lineCreatedOnPanel = true;
                    $panelMessage = 'Created on XUI Panel successfully.';
                } else {
                    // Try alternative standard Xtream codes create endpoint
                    $altResponse = Http::timeout(10)->get($apiUrl . '/api.php', [
                        'action' => 'user_create',
                        'sub_user' => $settings['username'],
                        'sub_password' => $settings['password'],
                        'username' => $username,
                        'password' => $password,
                        'exp_date' => date('Y-m-d', $expireTimestamp),
                        'max_connections' => $devices,
                    ]);

                    if ($altResponse->successful()) {
                        $lineCreatedOnPanel = true;
                        $panelMessage = 'Created via Xtream Reseller API.';
                    } else {
                        $panelMessage = 'Panel response: ' . ($response->body() ?: 'No response');
                    }
                }
            } catch (\Exception $e) {
                Log::warning('XUI line creation API request failed, proceeding with generated credentials: ' . $e->getMessage());
                $panelMessage = 'API Connection Error: ' . $e->getMessage();
            }
        } else {
            $panelMessage = 'Generated with default Xtream format (No external panel URL configured).';
        }

        $m3uUrl = $this->buildM3uUrl($portalDns, $username, $password, $outputFormat);

        $credentials = [
            'username' => $username,
            'password' => $password,
            'portal_url' => $portalDns,
            'm3u_url' => $m3uUrl,
            'duration_days' => $durationDays,
            'devices' => $devices,
            'expires_at' => $expireDate->toDateTimeString(),
            'panel_synced' => $lineCreatedOnPanel,
            'panel_message' => $panelMessage,
            'generated_at' => now()->toDateTimeString(),
        ];

        return [
            'success' => true,
            'credentials' => $credentials,
            'panel_synced' => $lineCreatedOnPanel,
            'message' => $lineCreatedOnPanel ? 'Line created on XUI Panel & delivered!' : 'Line generated successfully! ' . $panelMessage,
        ];
    }

    /**
     * Build M3U URL for Xtream codes
     */
    public function buildM3uUrl(string $portalDns, string $username, string $password, string $format = 'ts'): string
    {
        $dns = rtrim($portalDns, '/');
        return "{$dns}/get.php?username={$username}&password={$password}&type=m3u_plus&output={$format}";
    }

    /**
     * Fulfill an order: generate credentials, update database, and send delivery email
     */
    public function fulfillOrder(Order $order, ?array $manualCredentials = null, bool $sendEmail = true): array
    {
        if ($manualCredentials) {
            $settings = $this->getSettings();
            $portalDns = rtrim($manualCredentials['portal_url'] ?? ($settings['portal_dns'] ?: 'http://Live IPTV Now.com:8080'), '/');
            $username = $manualCredentials['username'] ?? '';
            $password = $manualCredentials['password'] ?? '';
            $m3uUrl = $manualCredentials['m3u_url'] ?? $this->buildM3uUrl($portalDns, $username, $password);

            $durationDays = !empty($manualCredentials['duration_days']) ? (int)$manualCredentials['duration_days'] : 30;
            $expireDate = now()->addDays($durationDays);

            $credentials = [
                'username' => $username,
                'password' => $password,
                'portal_url' => $portalDns,
                'm3u_url' => $m3uUrl,
                'duration_days' => $durationDays,
                'devices' => $manualCredentials['devices'] ?? ($order->package ? $order->package->devices : 1),
                'expires_at' => $expireDate->toDateTimeString(),
                'panel_synced' => false,
                'panel_message' => 'Manually created & assigned.',
                'generated_at' => now()->toDateTimeString(),
            ];
            $result = [
                'success' => true,
                'credentials' => $credentials,
                'panel_synced' => false,
                'message' => 'Custom credentials assigned successfully!',
            ];
        } else {
            $result = $this->createLine($order);
            $credentials = $result['credentials'];
        }

        // Update the order in database
        $order->update([
            'order_status' => 'completed',
            'payment_status' => 'completed',
            'activated_at' => now(),
            'expires_at' => isset($credentials['expires_at']) ? $credentials['expires_at'] : null,
            'portal_url' => $credentials['portal_url'] ?? null,
            'subscription_details' => $credentials,
        ]);

        // Send confirmation delivery email to customer
        if ($sendEmail && !empty($order->customer_email)) {
            try {
                Mail::to($order->customer_email)->send(
                    new OrderConfirmationMail($order, $credentials)
                );
                $order->update(['email_sent_at' => now()]);
            } catch (\Exception $e) {
                Log::error('Failed to send IPTV delivery email for order #' . $order->order_number . ': ' . $e->getMessage());
            }
        }

        return $result;
    }
}
