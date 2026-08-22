<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payout extends Model
{
    protected $fillable = [
        'affiliate_id',
        'commission_id',
        'amount',
        'payment_method',
        'payment_details',
        'status',
        'processed_at',
        'admin_notes',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'payment_details' => 'array',
        'processed_at' => 'datetime',
    ];

    public function affiliate(): BelongsTo
    {
        return $this->belongsTo(Affiliate::class);
    }

    public function commission(): BelongsTo
    {
        return $this->belongsTo(Commission::class);
    }

    public function approve(): void
    {
        if ($this->status === 'pending') {
            $this->update([
                'status' => 'processing',
            ]);
        }
    }

    public function complete(): void
    {
        if ($this->status === 'processing') {
            $this->update([
                'status' => 'completed',
                'processed_at' => now(),
            ]);
        }
    }

    public function reject(string $reason = null): void
    {
        if ($this->status === 'pending') {
            $this->update([
                'status' => 'rejected',
                'admin_notes' => $reason,
                'processed_at' => now(),
            ]);
        }
    }
}
