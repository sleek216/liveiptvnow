<?php

namespace App\Services\IPTV\Providers;

use App\Models\IPTVProvider;
use App\Services\IPTV\Contracts\ProviderInterface;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class XUIProvider implements ProviderInterface
{
    protected $provider;
    protected $baseUrl;
    
    public function __construct(IPTVProvider $provider)
    {
        $this->provider = $provider;
        $this->baseUrl = rtrim($provider->api_url, '/');
    }

    public function authenticate(): bool
    {
        $response = Http::post($this->baseUrl . '/login', [
            'username' => $this->provider->username,
            'password' => $this->provider->password,
        ]);

        if ($response->successful()) {
            $cookies = $response->cookies();
            if ($cookies) {
                Cache::put('xui_cookie_' . $this->provider->id, $cookies->toArray(), now()->addHours(12));
                return true;
            }
        }
        return false;
    }

    protected function request(string $method, string $endpoint, array $data = [])
    {
        if (!Cache::has('xui_cookie_' . $this->provider->id)) {
            $this->authenticate();
        }

        $cookies = Cache::get('xui_cookie_' . $this->provider->id, []);
        $http = Http::withCookies($cookies, parse_url($this->baseUrl, PHP_URL_HOST));

        return $method === 'GET' 
            ? $http->get($this->baseUrl . $endpoint, $data)
            : $http->post($this->baseUrl . $endpoint, $data);
    }

    public function createLine(array $data): array
    {
        // Add typical XUI create line payload
        $payload = [
            'username' => $data['username'],
            'password' => $data['password'],
            'member_id' => 1,
            'expire_date' => now()->addDays($data['duration_days'])->timestamp,
            'max_connections' => $data['max_connections'] ?? 1,
            'package' => $data['provider_package_id'],
            'bouquet' => json_encode($data['bouquet_ids'] ?? []),
        ];

        $response = $this->request('POST', '/api/line/create', $payload);

        if ($response->successful() && $response->json('success')) {
            return [
                'success' => true,
                'client_id' => $response->json('data.id') ?? $data['username'],
                'message' => 'Line created successfully'
            ];
        }

        return [
            'success' => false,
            'message' => $response->json('message') ?? 'Failed to create line'
        ];
    }

    public function renewLine(string $clientId, array $data): array
    {
        // Renewal logic
        return ['success' => true, 'message' => 'Renewed (Mocked)'];
    }

    public function toggleLine(string $clientId, bool $status): array
    {
        // Toggle logic
        return ['success' => true, 'message' => 'Toggled (Mocked)'];
    }
}
