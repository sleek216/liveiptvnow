<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class NOWPaymentsService
{
    private string $apiKey;
    private string $baseUrl;
    private bool $sandbox;

    public function __construct()
    {
        $this->apiKey = Setting::get('nowpayments_api_key', '');
        $this->sandbox = (bool) Setting::get('nowpayments_sandbox', true);
        $this->baseUrl = $this->sandbox 
            ? 'https://api-sandbox.nowpayments.io/v1' 
            : 'https://api.nowpayments.io/v1';
    }

    /**
     * Get API status
     */
    public function getStatus(): array
    {
        try {
            $response = Http::withoutVerifying()->withHeaders([
                'x-api-key' => $this->apiKey,
            ])->get("{$this->baseUrl}/status");

            return [
                'success' => $response->successful(),
                'data' => $response->json(),
            ];
        } catch (\Exception $e) {
            Log::error('NOWPayments Status Error: ' . $e->getMessage());
            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Get available currencies
     */
    public function getAvailableCurrencies(): array
    {
        try {
            $response = Http::withoutVerifying()->withHeaders([
                'x-api-key' => $this->apiKey,
            ])->get("{$this->baseUrl}/currencies");

            if ($response->successful()) {
                return [
                    'success' => true,
                    'currencies' => $response->json()['currencies'] ?? [],
                ];
            }

            return [
                'success' => false,
                'error' => 'Failed to fetch currencies',
            ];
        } catch (\Exception $e) {
            Log::error('NOWPayments Currencies Error: ' . $e->getMessage());
            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Get minimum payment amount for a currency
     */
    public function getMinimumAmount(string $currency): array
    {
        try {
            $response = Http::withoutVerifying()->withHeaders([
                'x-api-key' => $this->apiKey,
            ])->get("{$this->baseUrl}/min-amount", [
                'currency_from' => 'usd',
                'currency_to' => $currency,
            ]);

            return [
                'success' => $response->successful(),
                'data' => $response->json(),
            ];
        } catch (\Exception $e) {
            Log::error('NOWPayments Minimum Amount Error: ' . $e->getMessage());
            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Create a payment
     */
    public function createPayment(array $data): array
    {
        try {
            $response = Http::withoutVerifying()->withHeaders([
                'x-api-key' => $this->apiKey,
                'Content-Type' => 'application/json',
            ])->post("{$this->baseUrl}/payment", $data);

            if ($response->successful()) {
                return [
                    'success' => true,
                    'payment' => $response->json(),
                ];
            }

            Log::error('NOWPayments Create Payment Error: ' . $response->body());
            return [
                'success' => false,
                'error' => $response->json()['message'] ?? 'Failed to create payment',
            ];
        } catch (\Exception $e) {
            Log::error('NOWPayments Create Payment Exception: ' . $e->getMessage());
            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Get payment status
     */
    public function getPaymentStatus(string $paymentId): array
    {
        try {
            $response = Http::withoutVerifying()->withHeaders([
                'x-api-key' => $this->apiKey,
            ])->get("{$this->baseUrl}/payment/{$paymentId}");

            return [
                'success' => $response->successful(),
                'payment' => $response->json(),
            ];
        } catch (\Exception $e) {
            Log::error('NOWPayments Payment Status Error: ' . $e->getMessage());
            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Verify IPN callback
     */
    public function verifyIPN(array $data, string $signature): bool
    {
        $ipnSecret = Setting::get('nowpayments_ipn_secret', '');
        
        if (empty($ipnSecret)) {
            Log::warning('NOWPayments IPN Secret not configured');
            return false;
        }

        ksort($data);
        $json = json_encode($data, JSON_UNESCAPED_SLASHES);
        $hash = hash_hmac('sha512', $json, $ipnSecret);

        return hash_equals($hash, $signature);
    }

    /**
     * Get estimated price
     */
    public function getEstimatedPrice(float $amount, string $currencyFrom = 'usd', string $currencyTo = 'btc'): array
    {
        try {
            $response = Http::withoutVerifying()->withHeaders([
                'x-api-key' => $this->apiKey,
            ])->get("{$this->baseUrl}/estimate", [
                'amount' => $amount,
                'currency_from' => $currencyFrom,
                'currency_to' => $currencyTo,
            ]);

            return [
                'success' => $response->successful(),
                'data' => $response->json(),
            ];
        } catch (\Exception $e) {
            Log::error('NOWPayments Estimate Error: ' . $e->getMessage());
            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Create invoice
     */
    public function createInvoice(array $data): array
    {
        try {
            $response = Http::withoutVerifying()->withHeaders([
                'x-api-key' => $this->apiKey,
                'Content-Type' => 'application/json',
            ])->post("{$this->baseUrl}/invoice", $data);

            if ($response->successful()) {
                return [
                    'success' => true,
                    'invoice' => $response->json(),
                ];
            }

            Log::error('NOWPayments Create Invoice Error: ' . $response->body());
            return [
                'success' => false,
                'error' => $response->json()['message'] ?? 'Failed to create invoice',
            ];
        } catch (\Exception $e) {
            Log::error('NOWPayments Create Invoice Exception: ' . $e->getMessage());
            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Check if NOWPayments is enabled
     */
    public function isEnabled(): bool
    {
        return (bool) Setting::get('nowpayments_enabled', false) && !empty($this->apiKey);
    }
}
