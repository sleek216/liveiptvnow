<?php

namespace App\Services\IPTV;

use App\Models\IPTVOrder;
use App\Models\IPTVWebsite;

class OrderSyncService
{
    public function processWebhook(IPTVWebsite $website, array $payload): IPTVOrder
    {
        // Update or Create Order based on Webhook Payload
        $order = IPTVOrder::updateOrCreate(
            [
                'iptv_website_id' => $website->id,
                'external_order_id' => $payload['order_id'],
            ],
            [
                'external_package_id' => $payload['package_id'],
                'customer_name' => $payload['customer_name'] ?? null,
                'customer_email' => $payload['customer_email'],
                'amount' => $payload['amount'] ?? 0,
                'payment_status' => $payload['payment_status'] ?? 'pending',
                'order_status' => $payload['order_status'] ?? 'pending',
            ]
        );

        return $order;
    }
}
