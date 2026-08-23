<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Setting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
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
            'panel_url' => Setting::get('xui_panel_url', 'http://kytv.xyz/HckqYJZU'),
            'username' => Setting::get('xui_username', 'Hasil47228'),
            'password' => Setting::get('xui_password', ''),
            'portal_dns' => Setting::get('xui_portal_dns', 'http://kytv.xyz:8080'),
            'user_prefix' => Setting::get('xui_user_prefix', 'bestuser'),
            'auto_fulfill' => Setting::get('xui_auto_fulfill', '0') === '1',
            'output_format' => Setting::get('xui_output_format', 'ts'),
            'default_bouquets' => Setting::get('xui_default_bouquets', ''),
            'panel_type' => Setting::get('xui_panel_type', 'xui_one'),
        ];
    }

    /**
     * Normalize base URL (strip /lines or /dashboard from the end)
     */
    public function cleanPanelUrl(string $url): string
    {
        $url = trim($url);
        $url = preg_replace('/(\/lines|\/dashboard|\/index\.php|\/lines\?.*)$/i', '', $url);
        return rtrim($url, '/');
    }

    /**
     * Test connection to the XUI / XUI.ONE panel
     */
    public function testConnection(string $url, string $username, string $password): array
    {
        $baseUrl = $this->cleanPanelUrl($url);
        if (empty($baseUrl)) {
            return [
                'success' => false,
                'message' => 'Panel URL cannot be empty.',
            ];
        }

        try {
            // Attempt 1: XUI.ONE / XUI Session Login
            $loginResponse = Http::timeout(8)->asForm()->post($baseUrl . '/login', [
                'username' => $username,
                'password' => $password,
            ]);

            if ($loginResponse->successful() || $loginResponse->status() === 302) {
                // If cookies returned, cache session
                $cookies = $loginResponse->cookies();
                if ($cookies && count($cookies) > 0) {
                    Cache::put('xui_session_cookies', $cookies->toArray(), now()->addHours(12));
                    return [
                        'success' => true,
                        'message' => 'Successfully connected and authenticated to XUI.ONE Panel!',
                        'data' => [
                            'status' => 'Online',
                            'auth' => 'Session Cookies Acquired',
                            'panel_url' => $baseUrl
                        ]
                    ];
                }
            }

            // Attempt 2: Standard Xtream player_api.php
            $hostOnly = parse_url($baseUrl, PHP_URL_SCHEME) . '://' . parse_url($baseUrl, PHP_URL_HOST);
            $port = parse_url($baseUrl, PHP_URL_PORT) ? ':' . parse_url($baseUrl, PHP_URL_PORT) : '';
            $domainUrl = $hostOnly . $port;

            $response = Http::timeout(8)->get($domainUrl . '/player_api.php', [
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

            // Attempt 3: API endpoint ping
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
                'message' => 'Could not authenticate. Please verify your Panel URL, Username (' . $username . '), and Password.',
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

        // Generate username (e.g. bestuser3252 like in XUI panel)
        $prefix = !empty($settings['user_prefix']) ? $settings['user_prefix'] : 'bestuser';
        $username = $customParams['username'] ?? ($prefix . rand(1000, 9999));
        $password = $customParams['password'] ?? (substr(str_shuffle('abcdefghjkmnpqrstuvwxyz23456789'), 0, 8));
        $portalDns = rtrim($customParams['portal_dns'] ?? ($settings['portal_dns'] ?: 'http://kytv.xyz:8080'), '/');
        $outputFormat = $settings['output_format'] ?: 'ts';

        $expireTimestamp = now()->addDays($durationDays)->timestamp;
        $expireDate = now()->addDays($durationDays);

        $lineCreatedOnPanel = false;
        $panelMessage = '';

        $baseUrl = $this->cleanPanelUrl($settings['panel_url']);

        // If Panel URL is configured, attempt API call to create line
        if (!empty($baseUrl) && !empty($settings['username']) && !empty($settings['password'])) {
            try {
                // Attempt XUI.ONE line creation via API / form
                $linePayload = [
                    'username' => $username,
                    'password' => $password,
                    'member_id' => 1,
                    'expire_date' => $expireTimestamp,
                    'max_connections' => $devices,
                    'package' => $customParams['package_id'] ?? 1,
                    'bouquet' => !empty($settings['default_bouquets']) ? explode(',', $settings['default_bouquets']) : [],
                ];

                // Check for cached cookies or authenticate
                $cookies = Cache::get('xui_session_cookies', []);
                $http = Http::timeout(10);
                if (!empty($cookies)) {
                    $http = $http->withCookies($cookies, parse_url($baseUrl, PHP_URL_HOST));
                }

                $response = $http->post($baseUrl . '/api/line/create', $linePayload);

                if (!$response->successful() || !$response->json('success')) {
                    // Try XUI direct line endpoint
                    $response = $http->post($baseUrl . '/line', [
                        'username' => $username,
                        'password' => $password,
                        'expire_date' => date('Y-m-d H:i:s', $expireTimestamp),
                        'max_connections' => $devices,
                    ]);
                }

                if ($response->successful() && ($response->json('success') || $response->status() === 200)) {
                    $lineCreatedOnPanel = true;
                    $panelMessage = 'Created on XUI.ONE Panel successfully.';
                } else {
                    // Try alternative standard Xtream codes create endpoint
                    $altResponse = Http::timeout(10)->get($baseUrl . '/api.php', [
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
                        $panelMessage = 'Panel response code: ' . $response->status();
                    }
                }
            } catch (\Exception $e) {
                Log::warning('XUI line creation API request failed, proceeding with generated credentials: ' . $e->getMessage());
                $panelMessage = 'API Connection Note: ' . $e->getMessage();
            }
        } else {
            $panelMessage = 'Generated with standard Xtream format.';
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
            $portalDns = rtrim($manualCredentials['portal_url'] ?? ($settings['portal_dns'] ?: 'http://kytv.xyz:8080'), '/');
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
