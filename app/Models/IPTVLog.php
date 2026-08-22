<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IPTVLog extends Model
{
    protected $table = 'iptv_logs';

    protected $fillable = [
        'iptv_website_id', 'iptv_order_id', 'action', 'status', 'description', 'payload'
    ];

    protected $casts = [
        'payload' => 'json',
    ];

    public function website(): BelongsTo
    {
        return $this->belongsTo(IPTVWebsite::class, 'iptv_website_id');
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(IPTVOrder::class, 'iptv_order_id');
    }
}
