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
        $packageMapJson = Setting::get('xui_package_map', '{}');
        $packageMap = json_decode($packageMapJson, true);
        if (!is_array($packageMap)) {
            $packageMap = [];
        }

        return [
            'panel_url' => Setting::get('xui_panel_url', ''),
            'api_url' => Setting::get('xui_api_url', ''),
            'api_key' => Setting::get('xui_api_key', ''),
            'username' => Setting::get('xui_username', ''),
            'password' => Setting::get('xui_password', ''),
            'portal_dns' => Setting::get('xui_portal_dns', ''),
            'user_prefix' => Setting::get('xui_user_prefix', 'user'),
            'auto_fulfill' => Setting::get('xui_auto_fulfill', '0') === '1',
            'output_format' => Setting::get('xui_output_format', 'ts'),
            'default_bouquets' => Setting::get('xui_default_bouquets', ''),
            'default_package_id' => Setting::get('xui_default_package_id', '1'),
            'package_map' => $packageMap,
            'panel_type' => Setting::get('xui_panel_type', 'xui_one'),
        ];
    }

    /**
     * Clean base URL (strip trailing slashes, /lines, /dashboard)
     */
    public function cleanUrl(?string $url): string
    {
        if (empty($url)) {
            return '';
        }
        $url = trim($url);
        $url = preg_replace('/(\/lines|\/dashboard|\/index\.php|\/lines\?.*|\/login|\/edit_profile)$/i', '', $url);
        return rtrim($url, '/');
    }

    /**
     * Build standard HTTP client with API Key headers & timeouts
     */
    protected function getHttpClient(?string $apiKey = null)
    {
        $http = Http::timeout(12)->withHeaders([
            'User-Agent' => 'LiveIPTVNow-XUI/2.0',
            'Accept' => 'application/json, text/plain, */*',
        ]);

        if (!empty($apiKey)) {
            $http = $http->withHeaders([
                'X-Api-Key' => $apiKey,
                'Authorization' => 'Bearer ' . $apiKey,
            ]);
        }

        return $http;
    }

    /**
     * Test connection to the XUI / XUI.ONE panel via API Key or Session Login
     */
    public function testConnection(?string $panelUrl = null, ?string $username = null, ?string $password = null, ?string $apiKey = null, ?string $apiUrl = null): array
    {
        $settings = $this->getSettings();
        
        $panelUrl = $this->cleanUrl($panelUrl ?: $settings['panel_url']);
        $apiUrl = $this->cleanUrl($apiUrl ?: $settings['api_url']);
        $apiKey = trim($apiKey !== null ? $apiKey : $settings['api_key']);
        $username = trim($username ?: $settings['username']);
        $password = trim($password !== null ? $password : $settings['password']);

        $targets = array_unique(array_filter([$apiUrl, $panelUrl]));
        
        if (empty($targets) && empty($apiKey) && empty($username)) {
            return [
                'success' => false,
                'message' => 'Please enter your API Key or Panel URL and Username/Password in settings first.',
            ];
        }

        $diagnostics = [];
        $connected = false;
        $connectionType = '';
        $serverData = [];

        // Method 1: Official XUI.ONE API Key Authentication
        if (!empty($apiKey)) {
            foreach ($targets as $base) {
                try {
                    $endpoints = [
                        $base . '/api/line/list',
                        $base . '/api/user/info',
                        $base . '/api.php?action=user_info&api_key=' . urlencode($apiKey),
                        $base . '/api/profile',
                        $base . '/api/packages',
                        $base . '/lines',
                    ];

                    foreach ($endpoints as $ep) {
                        $res = $this->getHttpClient($apiKey)->get($ep, [
                            'api_key' => $apiKey,
                            'token' => $apiKey,
                            'user' => $username,
                        ]);

                        if ($res->successful() || $res->json('success') === true || $res->status() === 200) {
                            $connected = true;
                            $connectionType = 'XUI.ONE Official API Key';
                            $serverData = [
                                'method' => 'API Key Verified',
                                'api_endpoint' => $ep,
                                'api_status' => 'Authorized & Ready',
                                'status' => 'Online',
                            ];
                            $diagnostics[] = "API Key auth passed on {$ep} (HTTP {$res->status()})";
                            break 2;
                        } else {
                            $diagnostics[] = "API check on {$ep} returned HTTP " . $res->status();
                        }
                    }
                } catch (\Exception $e) {
                    $diagnostics[] = "API error on {$base}: " . $e->getMessage();
                }
            }
        }

        // Method 2: Web Session Login Authentication
        if (!$connected && !empty($username) && !empty($password)) {
            foreach ($targets as $base) {
                try {
                    $loginRes = Http::timeout(8)->asForm()->post($base . '/login', [
                        'username' => $username,
                        'password' => $password,
                        'login' => '1',
                        'submit' => 'Login',
                    ]);

                    $cookies = $loginRes->cookies();
                    if ($loginRes->status() === 302 || $loginRes->successful()) {
                        if ($cookies && count($cookies) > 0) {
                            Cache::put('xui_session_cookies', $cookies->toArray(), now()->addHours(6));
                            $connected = true;
                            $connectionType = 'XUI.ONE Web Session';
                            $serverData = [
                                'method' => 'Web Session Active',
                                'panel_url' => $base,
                                'username' => $username,
                                'status' => 'Online',
                            ];
                            $diagnostics[] = "Web login passed on {$base}";
                            break;
                        }
                    }
                } catch (\Exception $e) {
                    $diagnostics[] = "Login error on {$base}: " . $e->getMessage();
                }
            }
        }

        // Method 3: Standard Xtream Codes player_api.php
        if (!$connected && !empty($panelUrl) && !empty($username) && !empty($password)) {
            try {
                $hostOnly = parse_url($panelUrl, PHP_URL_SCHEME) . '://' . parse_url($panelUrl, PHP_URL_HOST);
                $playerRes = Http::timeout(8)->get($hostOnly . '/player_api.php', [
                    'username' => $username,
                    'password' => $password,
                ]);

                if ($playerRes->successful()) {
                    $data = $playerRes->json();
                    if (isset($data['user_info']['auth']) && $data['user_info']['auth'] == 1) {
                        $connected = true;
                        $connectionType = 'Xtream Player API';
                        $serverData = [
                            'method' => 'Player API Auth',
                            'status' => $data['user_info']['status'] ?? 'Active',
                            'expires' => isset($data['user_info']['exp_date']) ? date('Y-m-d', (int)$data['user_info']['exp_date']) : 'Active',
                        ];
                    }
                }
            } catch (\Exception $e) {
                $diagnostics[] = "Player API check error: " . $e->getMessage();
            }
        }

        if ($connected) {
            return [
                'success' => true,
                'message' => "🎉 Successfully connected to XUI Panel via {$connectionType}!",
                'data' => $serverData,
            ];
        }

        return [
            'success' => false,
            'message' => "Could not connect to XUI Panel. Please verify your API URL, API Key, or Username/Password. (Diagnostics: " . implode('; ', array_slice($diagnostics, 0, 3)) . ")",
        ];
    }

    /**
     * Create user line on XUI.ONE / XUI Panel
     */
    public function createLine(Order $order, array $customParams = []): array
    {
        $settings = $this->getSettings();
        $package = $order->package;

        // Calculate accurate duration based on website package
        $durationDays = 30;
        if (!empty($customParams['duration_days'])) {
            $durationDays = (int)$customParams['duration_days'];
        } elseif ($package) {
            if (!empty($package->duration_days) && (int)$package->duration_days > 0) {
                $durationDays = (int)$package->duration_days;
            } elseif (!empty($package->duration_months) && (int)$package->duration_months > 0) {
                $months = (int)$package->duration_months;
                $durationDays = ($months === 12) ? 365 : ($months * 30);
            }
        }

        $devices = $customParams['devices'] ?? ($package && $package->devices ? (int)$package->devices : 1);

        // Determine XUI Package ID from mapping or parameter
        $packageMap = $settings['package_map'] ?? [];
        $packageId = $customParams['package_id'] 
            ?? ($order->package_id && isset($packageMap[$order->package_id]) && !empty($packageMap[$order->package_id]) 
                ? $packageMap[$order->package_id] 
                : ($settings['default_package_id'] ?: 1));

        // Generate username
        $prefix = !empty($settings['user_prefix']) ? $settings['user_prefix'] : 'user';
        $username = $customParams['username'] ?? ($prefix . rand(1000, 9999));
        $password = $customParams['password'] ?? substr(str_shuffle('abcdefghjkmnpqrstuvwxyz23456789'), 0, 8);
        $portalDns = rtrim($customParams['portal_dns'] ?? ($settings['portal_dns'] ?: 'http://iptv.server:8080'), '/');
        $outputFormat = $settings['output_format'] ?: 'ts';

        $expireTimestamp = now()->addDays($durationDays)->timestamp;
        $expireDate = now()->addDays($durationDays);

        $apiUrl = $this->cleanUrl($settings['api_url']);
        $panelUrl = $this->cleanUrl($settings['panel_url']);
        $apiKey = trim($settings['api_key']);
        $panelUser = trim($settings['username']);
        $panelPass = trim($settings['password']);

        $targets = array_unique(array_filter([$apiUrl, $panelUrl]));

        $lineCreated = false;
        $debugDetails = [];
        $createdVia = '';

        $payload = [
            'username' => $username,
            'password' => $password,
            'member_id' => 1,
            'package' => $packageId,
            'package_id' => $packageId,
            'expire_date' => date('Y-m-d H:i:s', $expireTimestamp),
            'exp_date' => date('Y-m-d', $expireTimestamp),
            'max_connections' => $devices,
            'notes' => 'LiveIPTVNow Order #' . $order->order_number . ' (' . ($package ? $package->name : 'Custom') . ')',
            'api_key' => $apiKey,
            'trial' => 0,
        ];

        // Strategy 1: Official XUI.ONE REST API using API Key
        if (!empty($apiKey) && !empty($targets)) {
            foreach ($targets as $base) {
                $apiCreateEndpoints = [
                    $base . '/api/line/create',
                    $base . '/api/line/add',
                    $base . '/line/create',
                    $base . '/api.php',
                ];

                foreach ($apiCreateEndpoints as $endpoint) {
                    try {
                        $res = $this->getHttpClient($apiKey)->asForm()->post($endpoint, array_merge($payload, [
                            'action' => 'user_create',
                            'sub_user' => $panelUser,
                            'sub_password' => $panelPass,
                            'user_name' => $username,
                            'user_password' => $password,
                        ]));

                        $statusCode = $res->status();
                        $body = $res->body();

                        if ($statusCode === 200 || $statusCode === 201 || $res->json('success') === true || str_contains($body, 'success') || str_contains($body, 'created')) {
                            $lineCreated = true;
                            $createdVia = "XUI API ({$endpoint})";
                            break 2;
                        } else {
                            $debugDetails[] = "API {$endpoint} returned HTTP {$statusCode}";
                        }
                    } catch (\Exception $e) {
                        $debugDetails[] = "API {$endpoint} error: " . $e->getMessage();
                    }
                }
            }
        }

        // Strategy 2: Web Session Form Line Creation
        if (!$lineCreated && !empty($panelUser) && !empty($panelPass) && !empty($targets)) {
            foreach ($targets as $base) {
                try {
                    $loginRes = Http::timeout(8)->asForm()->post($base . '/login', [
                        'username' => $panelUser,
                        'password' => $panelPass,
                        'login' => '1',
                        'submit' => 'Login',
                    ]);

                    $cookies = $loginRes->cookies();
                    $cookieArray = $cookies ? $cookies->toArray() : Cache::get('xui_session_cookies', []);

                    if (!empty($cookieArray)) {
                        $lineEndpoints = [
                            $base . '/line',
                            $base . '/api/line/create',
                            $base . '/lines/add',
                        ];

                        foreach ($lineEndpoints as $lineEp) {
                            $lineRes = Http::timeout(10)
                                ->withCookies($cookieArray, parse_url($base, PHP_URL_HOST))
                                ->asForm()
                                ->post($lineEp, $payload);

                            $statusCode = $lineRes->status();
                            $body = $lineRes->body();

                            if ($statusCode === 302 || $lineRes->json('success') === true || str_contains($body, 'Line created') || str_contains($body, 'success')) {
                                $lineCreated = true;
                                $createdVia = "Web Session ({$lineEp})";
                                break 2;
                            } else {
                                $debugDetails[] = "Session {$lineEp} returned HTTP {$statusCode}";
                            }
                        }
                    }
                } catch (\Exception $e) {
                    $debugDetails[] = "Session line error on {$base}: " . $e->getMessage();
                }
            }
        }

        // Strategy 3: Standard Xtream Reseller api.php
        if (!$lineCreated && !empty($panelUser) && !empty($panelPass) && !empty($targets)) {
            foreach ($targets as $base) {
                try {
                    $apiRes = Http::timeout(8)->get($base . '/api.php', [
                        'action' => 'user_create',
                        'sub_user' => $panelUser,
                        'sub_password' => $panelPass,
                        'user_name' => $username,
                        'user_password' => $password,
                        'package_id' => $packageId,
                        'exp_date' => date('Y-m-d', $expireTimestamp),
                        'max_connections' => $devices,
                    ]);

                    if ($apiRes->successful() && ($apiRes->json('result') === 'success' || str_contains($apiRes->body(), 'success') || $apiRes->json('status') == 1)) {
                        $lineCreated = true;
                        $createdVia = "Xtream api.php";
                        break;
                    }
                } catch (\Exception $e) {
                    $debugDetails[] = "api.php error: " . $e->getMessage();
                }
            }
        }

        // If line was NOT created, fail strictly with clear error
        if (!$lineCreated) {
            return [
                'success' => false,
                'message' => 'Could not create line on XUI Panel. Panel did not confirm account creation. (Diagnostics: ' . implode(' | ', array_slice($debugDetails, 0, 3)) . '). Please test your API Key and Connection in Settings.',
            ];
        }

        // Build credentials
        $m3uUrl = $this->buildM3uUrl($portalDns, $username, $password, $outputFormat);

        $credentials = [
            'username' => $username,
            'password' => $password,
            'portal_url' => $portalDns,
            'm3u_url' => $m3uUrl,
            'duration_days' => $durationDays,
            'package_name' => $package ? $package->name : 'Custom Plan',
            'package_id' => $packageId,
            'devices' => $devices,
            'expires_at' => $expireDate->toDateTimeString(),
            'panel_synced' => true,
            'panel_message' => "Created successfully on XUI Panel via {$createdVia}",
            'generated_at' => now()->toDateTimeString(),
        ];

        return [
            'success' => true,
            'credentials' => $credentials,
            'panel_synced' => true,
            'message' => "Line created successfully on XUI Panel ({$username}) for {$durationDays} days (Package: {$packageId}) via {$createdVia}!",
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
     * Fulfill an order: generate credentials, update database, and optionally send delivery email
     */
    public function fulfillOrder(Order $order, ?array $manualCredentials = null, bool $sendEmail = true, array $customParams = []): array
    {
        if ($manualCredentials) {
            $settings = $this->getSettings();
            $portalDns = rtrim($manualCredentials['portal_url'] ?? ($settings['portal_dns'] ?: 'http://iptv.server:8080'), '/');
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
                'package_name' => $order->package ? $order->package->name : 'Custom Plan',
                'devices' => $manualCredentials['devices'] ?? ($order->package ? $order->package->devices : 1),
                'expires_at' => $expireDate->toDateTimeString(),
                'panel_synced' => false,
                'panel_message' => 'Manually assigned credentials.',
                'generated_at' => now()->toDateTimeString(),
            ];
            $result = [
                'success' => true,
                'credentials' => $credentials,
                'panel_synced' => false,
                'message' => 'Custom credentials assigned successfully!',
            ];
        } else {
            $result = $this->createLine($order, $customParams);
            if (!$result['success']) {
                // DO NOT complete order or send fake email if XUI failed!
                return $result;
            }
            $credentials = $result['credentials'];
        }

        // Update the order in database only on success
        $order->update([
            'order_status' => 'completed',
            'payment_status' => 'completed',
            'activated_at' => now(),
            'expires_at' => isset($credentials['expires_at']) ? $credentials['expires_at'] : null,
            'portal_url' => $credentials['portal_url'] ?? null,
            'subscription_details' => $credentials,
        ]);

        // Send confirmation delivery email to customer if requested
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

    /**
     * Send credentials email to customer
     */
    public function sendDeliveryEmail(Order $order): bool
    {
        if (empty($order->subscription_details) || empty($order->customer_email)) {
            return false;
        }

        Mail::to($order->customer_email)->send(
            new OrderConfirmationMail($order, $order->subscription_details)
        );
        $order->update(['email_sent_at' => now()]);

        return true;
    }
}
