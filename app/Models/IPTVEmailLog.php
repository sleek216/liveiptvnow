<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IPTVEmailLog extends Model
{
    protected $table = 'iptv_email_logs';

    protected $fillable = [
        'iptv_order_id', 'customer_email', 'status', 'error_message', 'sent_at'
    ];

    protected $casts = [
        'sent_at' => 'datetime',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(IPTVOrder::class, 'iptv_order_id');
    }
}
