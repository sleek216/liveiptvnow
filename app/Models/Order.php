<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Setting;

class Order extends Model
{
    protected $fillable = [
        'order_number',
        'user_id',
        'package_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'amount',
        'payment_method',
        'payment_status',
        'order_status',
        'notes',
        'admin_notes',
        'subscription_details',
        'selected_countries',
        'stripe_payment_id',
        'stripe_session_id',
        'portal_url',
        'activated_at',
        'expires_at',
        'email_sent_at',
        'adjustment_amount',
        'coupon_code',
        'discount_amount',
        'is_read',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'subscription_details' => 'json',
        'selected_countries' => 'json',
        'activated_at' => 'datetime',
        'expires_at' => 'datetime',
        'email_sent_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }

    public function countries(): BelongsToMany
    {
        return $this->belongsToMany(Country::class);
    }

    public static function generateOrderNumber(): string
    {
        return 'BLI-' . strtoupper(uniqid()) . '-' . date('Ymd');
    }

    public function scopePending($query)
    {
        return $query->where('order_status', 'pending');
    }

    public function scopeCompleted($query)
    {
        return $query->where('order_status', 'completed');
    }

    public function scopePaymentCompleted($query)
    {
        return $query->where('payment_status', 'completed');
    }

    public function getIsActiveAttribute(): bool
    {
        return $this->order_status === 'completed' && 
               $this->payment_status === 'completed' &&
               ($this->expires_at === null || $this->expires_at->isFuture());
    }

    public function getStatusBadgeAttribute(): string
    {
        return match($this->order_status) {
            'pending' => 'warning',
            'processing' => 'info',
            'completed' => 'success',
            'cancelled' => 'danger',
            default => 'secondary',
        };
    }

    public function getPaymentBadgeAttribute(): string
    {
        return match($this->payment_status) {
            'pending' => 'warning',
            'completed' => 'success',
            'failed' => 'danger',
            'refunded' => 'info',
            default => 'secondary',
        };
    }

    /**
     * Mark order as completed after successful payment
     */
    public function markAsCompleted(): void
    {
        $this->update([
            'payment_status' => 'completed',
            'order_status' => 'completed',
            'activated_at' => now(),
            'expires_at' => $this->calculateExpiryDate(),
        ]);

        $this->processAffiliateCommissionIfPaid();
    }

    /**
     * Create affiliate commission when payment is completed.
     */
    public function processAffiliateCommissionIfPaid(): void
    {
        if ($this->payment_status !== 'completed') {
            return;
        }

        try {
            $this->loadMissing('user');
            app(\App\Services\AffiliateService::class)->createCommission($this);
        } catch (\Exception $e) {
            \Log::error('Failed to create affiliate commission for order ' . $this->id . ': ' . $e->getMessage());
        }
    }

    /**
     * Calculate expiry date based on package duration
     */
    protected function calculateExpiryDate()
    {
        if (!$this->package) {
            return null;
        }

        $date = now();
        $hasDuration = false;

        if (!empty($this->package->duration_months)) {
            $date->addMonths($this->package->duration_months);
            $hasDuration = true;
        }

        if (!empty($this->package->duration_days)) {
            $date->addDays($this->package->duration_days);
            $hasDuration = true;
        }

        return $hasDuration ? $date : null;
    }

    /**
     * Send order confirmation email with credentials
     * 
     * For FREE packages (price = 0):
     * - Customer receives confirmation WITHOUT credentials
     * - Admin receives credentials for manual review/sending
     * 
     * For PAID packages:
     * - Customer receives confirmation WITH credentials
     * - Admin receives standard order notification
     */
    public function sendConfirmationEmail(): void
    {
        // Generate credentials
        $username = 'user_' . strtoupper(substr(uniqid(), -8));
        $password = 'pass_' . strtoupper(substr(md5(uniqid()), 0, 10));
        
        $credentials = [
            'username' => $username,
            'password' => $password,
            'm3u_url' => 'http://bestliveiptv.com:8080/get.php?username=' . $username . 
                        '&password=' . $password . '&type=m3u_plus',
        ];

        // Check if this is a free package (price = 0)
        $isFreePackage = $this->amount == 0 || ($this->package && $this->package->price == 0);
        
        if ($isFreePackage) {
            // FREE PACKAGE: Send confirmation WITHOUT credentials to customer
            \Mail::to($this->customer_email)->send(
                new \App\Mail\FreeTrialConfirmationMail($this)
            );
            
            // Send credentials to ADMIN only for review
            $adminEmail = Setting::get('admin_notification_email')
                ?: Setting::get('mail_from_address')
                ?: config('mail.from.address');
            if ($adminEmail) {
                \Mail::to($adminEmail)->send(
                    new \App\Mail\AdminCredentialsNotification($this, $credentials)
                );
            }
        } else {
            // PAID PACKAGE: Send confirmation WITH credentials to customer
            \Mail::to($this->customer_email)->send(
                new \App\Mail\OrderConfirmationMail($this, $credentials)
            );
        }

        // Update email sent timestamp
        $this->update(['email_sent_at' => now()]);
    }
}

