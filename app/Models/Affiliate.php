<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Affiliate extends Model
{
    protected $fillable = [
        'user_id',
        'referral_code',
        'total_earnings',
        'pending_earnings',
        'paid_earnings',
        'total_referrals',
        'total_sales',
        'is_active',
        'custom_commission_rate',
    ];

    protected $casts = [
        'total_earnings' => 'decimal:2',
        'pending_earnings' => 'decimal:2',
        'paid_earnings' => 'decimal:2',
        'custom_commission_rate' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function referrals(): HasMany
    {
        return $this->hasMany(Referral::class);
    }

    public function commissions(): HasMany
    {
        return $this->hasMany(Commission::class);
    }

    public function payouts(): HasMany
    {
        return $this->hasMany(Payout::class);
    }

    public function getAvailableBalanceAttribute(): float
    {
        $totalPayouts = $this->payouts()
            ->whereIn('status', ['pending', 'processing', 'completed'])
            ->sum('amount');
        
        return (float) ($this->paid_earnings - $totalPayouts);
    }

    public function getTotalPaidAttribute(): float
    {
        return (float) $this->payouts()->where('status', 'completed')->sum('amount');
    }

    public function getPendingBalanceAttribute(): float
    {
        return (float) $this->pending_earnings;
    }

    public function canRequestPayout(): bool
    {
        $minimumPayout = Setting::get('affiliate_minimum_payout', 50);
        return $this->available_balance >= $minimumPayout;
    }

    public static function generateReferralCode(): string
    {
        do {
            $code = strtoupper(substr(md5(uniqid()), 0, 8));
        } while (self::where('referral_code', $code)->exists());

        return $code;
    }

    /**
     * Get the commission rate for this affiliate
     * Returns custom rate if set, otherwise returns global default
     */
    public function getCommissionRate(): float
    {
        if ($this->custom_commission_rate !== null) {
            return (float) $this->custom_commission_rate;
        }

        return (float) Setting::get('affiliate_commission_rate', 20);
    }
}
