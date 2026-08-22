<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IPTVAccount extends Model
{
    protected $table = 'iptv_accounts';

    protected $fillable = [
        'iptv_order_id', 'iptv_provider_id', 'username', 'password',
        'provider_client_id', 'status', 'expires_at'
    ];

    protected $casts = [
        'expires_at' => 'datetime',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(IPTVOrder::class, 'iptv_order_id');
    }

    public function provider(): BelongsTo
    {
        return $this->belongsTo(IPTVProvider::class, 'iptv_provider_id');
    }
}
