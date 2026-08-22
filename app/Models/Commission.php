<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Commission extends Model
{
    protected $fillable = [
        'affiliate_id',
        'order_id',
        'referral_id',
        'order_amount',
        'commission_rate',
        'commission_amount',
        'paid_amount',
        'status',
        'approved_at',
        'paid_at',
        'admin_notes',
    ];

    protected $casts = [
        'order_amount' => 'decimal:2',
        'commission_rate' => 'decimal:2',
        'commission_amount' => 'decimal:2',
        'paid_amount' => 'decimal:2',
        'approved_at' => 'datetime',
        'paid_at' => 'datetime',
    ];

    public function affiliate(): BelongsTo
    {
        return $this->belongsTo(Affiliate::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function referral(): BelongsTo
    {
        return $this->belongsTo(Referral::class);
    }

    public function getRemainingAmountAttribute(): float
    {
        return max(0, (float) $this->commission_amount - (float) $this->paid_amount);
    }

    public function canReceivePayment(): bool
    {
        return in_array($this->status, ['pending', 'partially_paid', 'approved'])
            && $this->remaining_amount > 0;
    }

    public function approve(): void
    {
        $remaining = $this->remaining_amount;

        if ($remaining <= 0 || !in_array($this->status, ['pending', 'partially_paid'])) {
            return;
        }

        $this->update([
            'status' => 'approved',
            'approved_at' => $this->approved_at ?? now(),
        ]);

        $this->affiliate->increment('paid_earnings', $remaining);
        $this->affiliate->decrement('pending_earnings', $remaining);
    }

    public function reject(string $reason = null): void
    {
        if (!in_array($this->status, ['pending', 'partially_paid'])) {
            return;
        }

        $remaining = $this->remaining_amount;

        $this->update([
            'status' => 'rejected',
            'admin_notes' => $reason,
        ]);

        if ($remaining > 0) {
            $this->affiliate->decrement('pending_earnings', $remaining);
        }
    }

    public function recordPayment(float $amount, array $data): Payout
    {
        if (!$this->canReceivePayment()) {
            throw new \InvalidArgumentException('This commission cannot receive payments.');
        }

        if ($amount <= 0 || $amount > $this->remaining_amount + 0.001) {
            throw new \InvalidArgumentException(
                'Invalid amount. Maximum payable now: $' . number_format($this->remaining_amount, 2)
            );
        }

        $affiliate = $this->affiliate()->first();

        if ($this->status === 'approved' && $amount > $affiliate->available_balance + 0.001) {
            throw new \InvalidArgumentException(
                'Insufficient affiliate balance. Available: $' . number_format($affiliate->available_balance, 2)
            );
        }

        $payout = Payout::create([
            'affiliate_id' => $affiliate->id,
            'commission_id' => $this->id,
            'amount' => $amount,
            'payment_method' => $data['payment_method'],
            'payment_details' => [
                'admin_payment' => true,
                'commission_payment' => true,
                'reference' => $data['payment_reference'] ?? null,
                'paid_by' => $data['paid_by'] ?? 'Admin',
            ],
            'status' => 'completed',
            'processed_at' => now(),
            'admin_notes' => $data['admin_notes'] ?? 'Commission payment',
        ]);

        if (in_array($this->status, ['pending', 'partially_paid'])) {
            $affiliate->decrement('pending_earnings', $amount);
        }

        $newPaidAmount = round((float) $this->paid_amount + $amount, 2);
        $updates = ['paid_amount' => $newPaidAmount];

        if ($newPaidAmount >= (float) $this->commission_amount) {
            $updates['status'] = 'paid';
            $updates['paid_at'] = now();
            if (!$this->approved_at) {
                $updates['approved_at'] = now();
            }
        } elseif ($this->status === 'pending') {
            $updates['status'] = 'partially_paid';
        }

        $this->update($updates);

        return $payout;
    }

    public function markAsPaid(): void
    {
        if ($this->status === 'approved' && $this->remaining_amount <= 0) {
            $this->update([
                'status' => 'paid',
                'paid_at' => now(),
            ]);
        }
    }
}
