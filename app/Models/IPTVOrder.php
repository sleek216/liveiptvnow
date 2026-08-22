<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class IPTVOrder extends Model
{
    protected $table = 'iptv_orders';

    protected $fillable = [
        'iptv_website_id', 'external_order_id', 'external_package_id',
        'customer_name', 'customer_email', 'customer_phone',
        'amount', 'payment_status', 'order_status',
        'iptv_status', 'email_status'
    ];

    public function website(): BelongsTo
    {
        return $this->belongsTo(IPTVWebsite::class, 'iptv_website_id');
    }

    public function iptvAccount(): HasOne
    {
        return $this->hasOne(IPTVAccount::class, 'iptv_order_id');
    }
}
