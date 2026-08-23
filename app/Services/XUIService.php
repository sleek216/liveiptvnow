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
     * Clean base URL (strip trailing slashes, /lines, /dashboard, /login)
     */
    public function cleanUrl(?string $url): string
    {
        if (empty($url)) {
            return '';
        }
        $url = trim($url);
        $url = preg_replace('/(\/lines|\/dashboard|\/index\.php|\/lines\?.*|\/login|\/edit_profile|\/line)$/i', '', $url);
        return rtrim($url, '/');
    }

    /**
     * Build standard HTTP client
     */
    protected function getHttpClient(?string $apiKey = null)
    {
        $headers = [
            'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
            'Accept' => 'application/json, text/javascript, */*; q=0.01',
        ];

        if (!empty($apiKey)) {
            $headers['X-Api-Key'] = $apiKey;
            $headers['Authorization'] = 'Bearer ' . $apiKey;
        }

        return Http::timeout(15)->withHeaders($headers);
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
        $serverData = [];

        // Method 1: Official XUI.ONE API Key
        if (!empty($apiKey)) {
            foreach ($targets as $base) {
                // XUI.ONE REST API test endpoints
                $testEndpoints = [
                    $base . '/api?action=user_info&api_key=' . urlencode($apiKey),
                    $base . '/api/user/info',
                    $base . '/api.php?action=user_info&api_key=' . urlencode($apiKey),
                    $base . '/api?action=package_list&api_key=' . urlencode($apiKey),
                    $base . '/api',
                ];

                foreach ($testEndpoints as $ep) {
                    try {
                        $res = $this->getHttpClient($apiKey)->get($ep, [
                            'api_key' => $apiKey,
                            'token' => $apiKey,
                            'action' => 'user_info',
                        ]);

                        $json = $res->json();
                        $body = $res->body();

                        // Check for valid JSON response from XUI.ONE
                        if (is_array($json)) {
                            if ((isset($json['result']) && $json['result'] === true) || 
                                (isset($json['status']) && ($json['status'] === 'success' || $json['status'] == 1)) || 
                                isset($json['credits']) || 
                                isset($json['member_id']) || 
                                isset($json['data'])) {
                                
                                $connected = true;
                                $serverData = [
                                    'status' => 'Authorized (API Key)',
                                    'endpoint' => $ep,
                                    'response' => $json,
                                ];
                                $diagnostics[] = "API Key validated successfully on {$ep}";
                                break 2;
                            } else {
                                $diagnostics[] = "{$ep}: " . ($json['message'] ?? $json['error'] ?? json_encode($json));
                            }
                        } else {
                            $diagnostics[] = "{$ep} returned non-JSON (HTTP {$res->status()})";
                        }
                    } catch (\Exception $e) {
                        $diagnostics[] = "{$ep} connection error: " . $e->getMessage();
                    }
                }
            }
        }

        // Method 2: Web Session Login to XUI.ONE
        if (!$connected && !empty($username) && !empty($password)) {
            foreach ($targets as $base) {
                try {
                    $loginRes = Http::timeout(10)->asForm()->post($base . '/login', [
                        'username' => $username,
                        'password' => $password,
                        'login' => '1',
                    ]);

                    $cookies = $loginRes->cookies();
                    $cookieArray = $cookies ? $cookies->toArray() : [];

                    // Check if session cookies received and not redirected to error
                    if (!empty($cookieArray)) {
                        // Verify by visiting /lines
                        $checkLines = Http::timeout(10)
                            ->withCookies($cookieArray, parse_url($base, PHP_URL_HOST))
                            ->get($base . '/lines');

                        if ($checkLines->successful() && !str_contains($checkLines->body(), 'login-box') && !str_contains($checkLines->body(), 'Please login')) {
                            Cache::put('xui_session_cookies', $cookieArray, now()->addHours(6));
                            $connected = true;
                            $serverData = [
                                'status' => 'Web Session Active & Authenticated',
                                'panel_url' => $base,
                                'user' => $username,
                            ];
                            $diagnostics[] = "Web login succeeded on {$base}";
                            break;
                        } else {
                            $diagnostics[] = "Login cookie received on {$base} but /lines access was rejected.";
                        }
                    } else {
                        $diagnostics[] = "Login on {$base} returned HTTP {$loginRes->status()} with no session cookie.";
                    }
                } catch (\Exception $e) {
                    $diagnostics[] = "Login error on {$base}: " . $e->getMessage();
                }
            }
        }

        if ($connected) {
            return [
                'success' => true,
                'message' => "🎉 Successfully connected to XUI.ONE Panel!",
                'data' => $serverData,
            ];
        }

        return [
            'success' => false,
            'message' => "❌ Connection to XUI Panel failed. (Diagnostics: " . implode(' | ', array_slice($diagnostics, 0, 3)) . ")",
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

        // Generate username & password
        $prefix = !empty($settings['user_prefix']) ? $settings['user_prefix'] : 'user';
        $username = $customParams['username'] ?? ($prefix . rand(1000, 9999));
        $password = $customParams['password'] ?? substr(str_shuffle('abcdefghjkmnpqrstuvwxyz23456789'), 0, 8);
        $portalDns = rtrim($customParams['portal_dns'] ?? ($settings['portal_dns'] ?: 'http://iptv.server:8080'), '/');
        $outputFormat = $settings['output_format'] ?: 'ts';

        $expireTimestamp = now()->addDays($durationDays)->timestamp;
        $expireDateStr = date('Y-m-d H:i:s', $expireTimestamp);
        $expireDateShort = date('Y-m-d', $expireTimestamp);

        $apiUrl = $this->cleanUrl($settings['api_url']);
        $panelUrl = $this->cleanUrl($settings['panel_url']);
        $apiKey = trim($settings['api_key']);
        $panelUser = trim($settings['username']);
        $panelPass = trim($settings['password']);

        $targets = array_unique(array_filter([$apiUrl, $panelUrl]));

        if (empty($targets)) {
            return [
                'success' => false,
                'message' => 'XUI Panel URL or API URL is not configured. Please enter them in Settings tab.',
            ];
        }

        $lineCreated = false;
        $debugDetails = [];
        $createdVia = '';

        // =========================================================================
        // STRATEGY 1: Official XUI.ONE REST API using API Key
        // =========================================================================
        if (!empty($apiKey)) {
            foreach ($targets as $base) {
                $apiEndpoints = [
                    $base . '/api?action=user_create&api_key=' . urlencode($apiKey),
                    $base . '/api/line/create',
                    $base . '/api/line/add',
                    $base . '/api.php?action=user_create&api_key=' . urlencode($apiKey),
                    $base . '/api',
                ];

                $apiPayload = [
                    'action' => 'user_create',
                    'api_key' => $apiKey,
                    'username' => $username,
                    'password' => $password,
                    'user_name' => $username,
                    'user_password' => $password,
                    'package' => (int)$packageId,
                    'package_id' => (int)$packageId,
                    'max_connections' => (int)$devices,
                    'expire_date' => $expireDateStr,
                    'exp_date' => $expireDateShort,
                    'member_id' => 1,
                    'notes' => 'Order #' . $order->order_number . ' (' . ($package ? $package->name : 'Custom') . ')',
                ];

                foreach ($apiEndpoints as $endpoint) {
                    try {
                        // Try POST as JSON first, then Form
                        $res = $this->getHttpClient($apiKey)->asForm()->post($endpoint, $apiPayload);
                        $json = $res->json();
                        $body = $res->body();

                        // Strict verification: response MUST be valid JSON indicating success
                        if (is_array($json)) {
                            if ((isset($json['result']) && $json['result'] === true) || 
                                (isset($json['status']) && ($json['status'] === 'success' || $json['status'] == 1)) || 
                                (isset($json['success']) && $json['success'] === true) ||
                                isset($json['user_id']) ||
                                isset($json['data']['id'])) {
                                
                                $lineCreated = true;
                                $createdVia = "XUI.ONE API ({$endpoint})";
                                break 2;
                            } else {
                                $err = $json['message'] ?? $json['error'] ?? $json['result'] ?? json_encode($json);
                                $debugDetails[] = "API {$endpoint}: {$err}";
                            }
                        } else {
                            // If response is not JSON, check if it's an error HTML
                            if ($res->status() === 401 || $res->status() === 403) {
                                $debugDetails[] = "API {$endpoint}: 401/403 Unauthorized (Invalid API Key)";
                            } else {
                                $debugDetails[] = "API {$endpoint} returned HTTP {$res->status()} (non-JSON)";
                            }
                        }
                    } catch (\Exception $e) {
                        $debugDetails[] = "API {$endpoint} exception: " . $e->getMessage();
                    }
                }
            }
        }

        // =========================================================================
        // STRATEGY 2: Web Session Form Line Creation (POST to /line)
        // =========================================================================
        if (!$lineCreated && !empty($panelUser) && !empty($panelPass)) {
            foreach ($targets as $base) {
                try {
                    // Step A: Login to get fresh session cookie
                    $loginRes = Http::timeout(10)->asForm()->post($base . '/login', [
                        'username' => $panelUser,
                        'password' => $panelPass,
                        'login' => '1',
                    ]);

                    $cookies = $loginRes->cookies();
                    $cookieArray = $cookies ? $cookies->toArray() : [];

                    if (!empty($cookieArray)) {
                        // Step B: Submit Line Creation Form to /line
                        $linePayload = [
                            'username' => $username,
                            'password' => $password,
                            'package' => (int)$packageId,
                            'max_connections' => (int)$devices,
                            'member_id' => 1,
                            'exp_date' => $expireDateShort,
                            'notes' => 'LiveIPTVNow Order #' . $order->order_number,
                            'submit' => 'Add Line',
                        ];

                        $lineRes = Http::timeout(12)
                            ->withCookies($cookieArray, parse_url($base, PHP_URL_HOST))
                            ->withHeaders([
                                'Referer' => $base . '/line',
                                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)',
                            ])
                            ->asForm()
                            ->post($base . '/line', $linePayload);

                        // Strict Check: XUI.ONE redirects (302) to /lines on successful creation
                        $location = $lineRes->header('Location');
                        if (($lineRes->status() === 302 && $location && (str_contains($location, 'lines') || str_contains($location, 'manage_lines'))) ||
                            ($lineRes->json('result') === true)) {
                            
                            $lineCreated = true;
                            $createdVia = "XUI Web Form ({$base}/line)";
                            break;
                        } else {
                            $debugDetails[] = "Web Form {$base}/line returned HTTP " . $lineRes->status() . " (Location: {$location})";
                        }
                    } else {
                        $debugDetails[] = "Web login on {$base} failed: invalid username/password.";
                    }
                } catch (\Exception $e) {
                    $debugDetails[] = "Web Form line error on {$base}: " . $e->getMessage();
                }
            }
        }

        // =========================================================================
        // STRATEGY 3: Standard Xtream Reseller api.php GET query
        // =========================================================================
        if (!$lineCreated && !empty($panelUser) && !empty($panelPass)) {
            foreach ($targets as $base) {
                try {
                    $apiRes = Http::timeout(10)->get($base . '/api.php', [
                        'action' => 'user_create',
                        'sub_user' => $panelUser,
                        'sub_password' => $panelPass,
                        'user_name' => $username,
                        'user_password' => $password,
                        'package_id' => $packageId,
                        'exp_date' => $expireDateShort,
                        'max_connections' => $devices,
                    ]);

                    $json = $apiRes->json();
                    if (is_array($json) && (($json['result'] ?? '') === 'success' || ($json['status'] ?? 0) == 1)) {
                        $lineCreated = true;
                        $createdVia = "Xtream api.php ({$base})";
                        break;
                    } else {
                        $debugDetails[] = "api.php: " . (is_array($json) ? json_encode($json) : "HTTP " . $apiRes->status());
                    }
                } catch (\Exception $e) {
                    $debugDetails[] = "api.php exception: " . $e->getMessage();
                }
            }
        }

        // Strict Fail: If XUI did not confirm account creation, abort and show real error!
        if (!$lineCreated) {
            $reason = !empty($debugDetails) ? implode(' | ', array_slice($debugDetails, 0, 2)) : 'Panel did not respond.';
            return [
                'success' => false,
                'message' => "❌ XUI Panel line creation failed: {$reason}. Please check your API settings or Package ID.",
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
            'expires_at' => now()->addDays($durationDays)->toDateTimeString(),
            'panel_synced' => true,
            'panel_message' => "Created on XUI Panel via {$createdVia}",
            'generated_at' => now()->toDateTimeString(),
        ];

        return [
            'success' => true,
            'credentials' => $credentials,
            'panel_synced' => true,
            'message' => "Line created successfully on XUI Panel ({$username}) for {$durationDays} days (Package: #{$packageId}) via {$createdVia}!",
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

        // Update the order in database only on real success
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
