<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'country',
        'is_admin',
        'admin_modules',
        'last_login_at',
        'referred_by',
        'referral_code',
        'google2fa_secret',
        'google2fa_enabled',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean',
            'admin_modules' => 'array',
            'last_login_at' => 'datetime',
            'google2fa_enabled' => 'boolean',
            'google2fa_secret' => 'encrypted',
        ];
    }

    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return $this->is_admin === true;
    }

    /**
     * Full admin access (all modules). Null admin_modules = super admin.
     */
    public function hasFullAdminAccess(): bool
    {
        return $this->isAdmin() && $this->admin_modules === null;
    }

    public function isSuperAdmin(): bool
    {
        return $this->hasFullAdminAccess();
    }

    public function canAccessAdminModule(string $module): bool
    {
        if (!$this->isAdmin()) {
            return false;
        }

        if ($this->hasFullAdminAccess()) {
            return true;
        }

        return in_array($module, $this->admin_modules ?? [], true);
    }

    /**
     * @return array<int, string>
     */
    public function getAdminModules(): array
    {
        if ($this->hasFullAdminAccess()) {
            return \App\Support\AdminModules::keys();
        }

        return $this->admin_modules ?? [];
    }

    public function defaultAdminRouteName(): ?string
    {
        if ($this->hasFullAdminAccess()) {
            return 'admin.dashboard';
        }

        return \App\Support\AdminModules::defaultRouteForModules($this->getAdminModules());
    }

    public function adminHomeRouteName(): string
    {
        return $this->defaultAdminRouteName() ?? 'admin.dashboard';
    }

    /**
     * Get user's orders
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Get user's active subscription
     */
    public function activeSubscription()
    {
        return $this->orders()
            ->where('order_status', 'completed')
            ->where('payment_status', 'completed')
            ->where(function($query) {
                $query->whereNull('expires_at')
                      ->orWhere('expires_at', '>', now());
            })
            ->latest()
            ->first();
    }

    /**
     * Check if user has active subscription
     */
    public function hasActiveSubscription(): bool
    {
        return $this->activeSubscription() !== null;
    }

    /**
     * Get user's affiliate account
     */
    public function affiliate()
    {
        return $this->hasOne(Affiliate::class);
    }

    /**
     * Get user who referred this user
     */
    public function referrer()
    {
        return $this->belongsTo(User::class, 'referred_by');
    }

    /**
     * Get users referred by this user
     */
    public function referredUsers()
    {
        return $this->hasMany(User::class, 'referred_by');
    }

    /**
     * Create affiliate account for user
     */
    public function createAffiliateAccount(): Affiliate
    {
        if ($this->affiliate) {
            return $this->affiliate;
        }

        return Affiliate::create([
            'user_id' => $this->id,
            'referral_code' => Affiliate::generateReferralCode(),
        ]);
    }

    /**
     * Get referral link
     */
    public function getReferralLinkAttribute(): string
    {
        if (!$this->affiliate) {
            return '';
        }

        return url('/') . '?ref=' . $this->affiliate->referral_code;
    }
}

