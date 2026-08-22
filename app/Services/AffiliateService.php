<?php

namespace App\Services;

use App\Models\User;
use App\Models\Affiliate;
use App\Models\Referral;
use App\Models\Commission;
use App\Models\Order;
use App\Models\Setting;
use Illuminate\Support\Facades\Cookie;

class AffiliateService
{
    /**
     * Track referral from cookie or URL parameter
     */
    public function trackReferral(?string $referralCode, User $user): ?Referral
    {
        if (!$referralCode) {
            return null;
        }

        $affiliate = Affiliate::where('referral_code', $referralCode)
            ->where('is_active', true)
            ->first();

        if (!$affiliate || $affiliate->user_id === $user->id) {
            return null;
        }

        // Check if already referred
        if ($user->referred_by) {
            return null;
        }

        // Create referral record
        $referral = Referral::create([
            'affiliate_id' => $affiliate->id,
            'referred_user_id' => $user->id,
            'referral_code' => $referralCode,
            'ip_address' => request()->ip(),
        ]);

        // Update user
        $user->update(['referred_by' => $affiliate->user_id]);

        // Update affiliate stats
        $affiliate->increment('total_referrals');

        return $referral;
    }

    /**
     * Create commission for an order
     */
    public function createCommission(Order $order): ?Commission
    {
        // Check if affiliate system is enabled
        if (!Setting::get('affiliate_enabled', true)) {
            return null;
        }

        if ($order->amount <= 0) {
            return null;
        }

        if (Commission::where('order_id', $order->id)->exists()) {
            return null;
        }

        $order->loadMissing('user');

        // Check if user was referred
        if (!$order->user->referred_by) {
            return null;
        }

        $affiliate = Affiliate::where('user_id', $order->user->referred_by)
            ->where('is_active', true)
            ->first();

        if (!$affiliate) {
            return null;
        }

        $referral = Referral::where('affiliate_id', $affiliate->id)
            ->where('referred_user_id', $order->user_id)
            ->first();

        if (!$referral) {
            return null;
        }

        // Mark referral as converted
        $referral->markAsConverted();

        // Get commission rate (custom or default)
        $commissionRate = $affiliate->getCommissionRate();
        $commissionAmount = ($order->amount * $commissionRate) / 100;

        // Create commission
        $commission = Commission::create([
            'affiliate_id' => $affiliate->id,
            'order_id' => $order->id,
            'referral_id' => $referral->id,
            'order_amount' => $order->amount,
            'commission_rate' => $commissionRate,
            'commission_amount' => $commissionAmount,
            'status' => 'pending',
        ]);

        // Update affiliate stats
        $affiliate->increment('total_sales');
        $affiliate->increment('pending_earnings', $commissionAmount);
        $affiliate->increment('total_earnings', $commissionAmount);

        return $commission;
    }

    /**
     * Set referral cookie
     */
    public function setReferralCookie(string $referralCode): void
    {
        $duration = Setting::get('affiliate_cookie_duration', 30);
        Cookie::queue('referral_code', $referralCode, $duration * 24 * 60);
    }

    /**
     * Get referral code from cookie or request
     */
    public function getReferralCode(): ?string
    {
        return request()->query('ref') ?? Cookie::get('referral_code');
    }

    /**
     * Ensure user has an affiliate account and apply referral cookie if eligible.
     */
    public function ensureAffiliateSetup(User $user): Affiliate
    {
        $affiliate = $user->createAffiliateAccount();

        $referralCode = $this->getReferralCode();
        if ($referralCode && !$user->referred_by) {
            $this->trackReferral($referralCode, $user->fresh());
        }

        return $affiliate->fresh();
    }

    /**
     * Apply referral from checkout form or stored cookie.
     */
    public function applyReferralForUser(User $user, ?string $referralCode = null): ?Referral
    {
        $code = $referralCode ?: $this->getReferralCode();

        if (!$code || $user->referred_by) {
            return null;
        }

        return $this->trackReferral($code, $user);
    }

    /**
     * Get affiliate statistics
     */
    public function getAffiliateStats(Affiliate $affiliate): array
    {
        return [
            'total_referrals' => $affiliate->total_referrals,
            'total_sales' => $affiliate->total_sales,
            'total_earnings' => $affiliate->total_earnings,
            'pending_earnings' => $affiliate->pending_earnings,
            'paid_earnings' => $affiliate->paid_earnings,
            'available_balance' => $affiliate->available_balance,
            'conversion_rate' => $affiliate->total_referrals > 0 
                ? round(($affiliate->total_sales / $affiliate->total_referrals) * 100, 2) 
                : 0,
            'recent_referrals' => $affiliate->referrals()
                ->with('referredUser')
                ->latest()
                ->take(10)
                ->get(),
            'recent_commissions' => $affiliate->commissions()
                ->with('order')
                ->latest()
                ->take(10)
                ->get(),
        ];
    }

    /**
     * Request payout
     */
    public function requestPayout(Affiliate $affiliate, array $data): ?\App\Models\Payout
    {
        if (!$affiliate->canRequestPayout()) {
            return null;
        }

        return \App\Models\Payout::create([
            'affiliate_id' => $affiliate->id,
            'amount' => $data['amount'],
            'payment_method' => $data['payment_method'],
            'payment_details' => $data['payment_details'],
            'status' => 'pending',
        ]);
    }

    /**
     * Record a custom admin payment to an affiliate (full or partial).
     */
    public function recordAdminPayment(Affiliate $affiliate, array $data): \App\Models\Payout
    {
        $affiliate->refresh();
        $available = $affiliate->available_balance;

        if ($data['amount'] > $available) {
            throw new \InvalidArgumentException(
                'Payment amount exceeds available balance ($' . number_format($available, 2) . ').'
            );
        }

        return \App\Models\Payout::create([
            'affiliate_id' => $affiliate->id,
            'amount' => $data['amount'],
            'payment_method' => $data['payment_method'],
            'payment_details' => [
                'admin_payment' => true,
                'reference' => $data['payment_reference'] ?? null,
                'paid_by' => $data['paid_by'] ?? 'Admin',
            ],
            'status' => 'completed',
            'processed_at' => now(),
            'admin_notes' => $data['admin_notes'] ?? 'Manual payment by admin',
        ]);
    }
}
