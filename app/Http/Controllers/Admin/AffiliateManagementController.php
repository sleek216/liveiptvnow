<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Affiliate;
use App\Models\Commission;
use App\Models\Payout;
use App\Models\Setting;
use App\Mail\CommissionApprovedMail;
use App\Mail\AffiliatePaymentMail;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;
use App\Services\AffiliateService;

class AffiliateManagementController extends Controller
{
    // Routes already have 'admin' middleware, no need to add here

    /**
     * Show affiliate overview
     */
    public function index(): View
    {
        $stats = [
            'total_affiliates' => Affiliate::count(),
            'active_affiliates' => Affiliate::where('is_active', true)->count(),
            'total_referrals' => Affiliate::sum('total_referrals'),
            'total_sales' => Affiliate::sum('total_sales'),
            'total_earnings' => Affiliate::sum('total_earnings'),
            'pending_earnings' => Affiliate::sum('pending_earnings'),
            'paid_earnings' => Affiliate::sum('paid_earnings'),
            'pending_commissions' => Commission::where('status', 'pending')->count(),
            'pending_payouts' => Payout::where('status', 'pending')->count(),
        ];

        $topAffiliates = Affiliate::with('user')
            ->orderBy('total_earnings', 'desc')
            ->take(10)
            ->get();

        return view('admin.affiliate.index', compact('stats', 'topAffiliates'));
    }

    /**
     * Show overview of all referrals
     */
    public function referrals(): View
    {
        $referrals = \App\Models\Referral::with(['affiliate.user', 'referredUser', 'commissions'])
            ->latest()
            ->paginate(20);

        return view('admin.affiliate.referrals', compact('referrals'));
    }

    /**
     * Show all affiliates
     */
    public function affiliates(): View
    {
        $affiliates = Affiliate::with('user')
            ->latest()
            ->paginate(20);

        return view('admin.affiliate.affiliates', compact('affiliates'));
    }



    /**
     * Show pending commissions
     */
    public function commissions(): View
    {
        $commissions = Commission::with(['affiliate.user', 'order.package', 'referral.referredUser'])
            ->latest()
            ->paginate(20);

        return view('admin.affiliate.commissions', compact('commissions'));
    }

    /**
     * Approve commission
     */
    public function approveCommission(Commission $commission): RedirectResponse
    {
        if ($commission->status !== 'pending') {
            return back()->with('error', 'This commission has already been processed.');
        }

        $commission->approve();
        $commission->load(['affiliate.user']);

        if ($commission->affiliate?->user?->email) {
            try {
                Mail::to($commission->affiliate->user->email)->send(new CommissionApprovedMail($commission));
            } catch (\Exception $e) {
                \Log::error('Failed to send commission approval email: ' . $e->getMessage());
            }
        }

        return back()->with('success', 'Commission approved! The affiliate has been notified by email.');
    }

    /**
     * Reject commission
     */
    public function rejectCommission(Request $request, Commission $commission): RedirectResponse
    {
        $validated = $request->validate([
            'reason' => 'nullable|string|max:500',
        ]);

        $commission->reject($validated['reason'] ?? null);

        return back()->with('success', 'Commission rejected.');
    }

    /**
     * Pay a custom partial or full amount for a commission.
     */
    public function payCommission(Request $request, Commission $commission): RedirectResponse
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'payment_method' => 'nullable|in:paypal,bank_transfer,crypto,other',
            'payment_reference' => 'nullable|string|max:255',
            'admin_notes' => 'nullable|string|max:500',
        ]);

        $validated['payment_method'] = $validated['payment_method'] ?? 'other';

        $commission->load(['affiliate.user']);

        try {
            $payout = $commission->recordPayment((float) $validated['amount'], [
                'payment_method' => $validated['payment_method'],
                'payment_reference' => $validated['payment_reference'] ?? null,
                'admin_notes' => $validated['admin_notes'] ?? null,
                'paid_by' => auth()->user()->name ?? 'Admin',
            ]);
        } catch (\InvalidArgumentException $e) {
            return back()->with('error', $e->getMessage());
        }

        if ($commission->affiliate?->user?->email) {
            try {
                Mail::to($commission->affiliate->user->email)->send(new AffiliatePaymentMail($payout));
            } catch (\Exception $e) {
                \Log::error('Failed to send commission payment email: ' . $e->getMessage());
            }
        }

        $remaining = $commission->fresh()->remaining_amount;
        $message = 'Paid $' . number_format($validated['amount'], 2) . ' for this commission.';

        if ($remaining > 0) {
            $message .= ' Remaining: $' . number_format($remaining, 2);
        } else {
            $message .= ' Commission fully paid.';
        }

        return back()->with('success', $message);
    }

    /**
     * Show payouts
     */
    public function payouts(): View
    {
        $payouts = Payout::with('affiliate.user')
            ->latest()
            ->paginate(20);

        return view('admin.affiliate.payouts', compact('payouts'));
    }

    /**
     * Approve payout
     */
    public function approvePayout(Payout $payout): RedirectResponse
    {
        $payout->approve();

        return back()->with('success', 'Payout approved and set to processing.');
    }

    /**
     * Complete payout
     */
    public function completePayout(Payout $payout): RedirectResponse
    {
        $payout->complete();

        return back()->with('success', 'Payout marked as completed!');
    }

    /**
     * Reject payout
     */
    public function rejectPayout(Request $request, Payout $payout): RedirectResponse
    {
        $validated = $request->validate([
            'reason' => 'nullable|string|max:500',
        ]);

        $payout->reject($validated['reason'] ?? null);

        return back()->with('success', 'Payout rejected.');
    }

    /**
     * Show affiliate settings
     */
    public function settings(): View
    {
        return view('admin.affiliate.settings');
    }

    /**
     * Update affiliate settings
     */
    public function updateSettings(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'affiliate_enabled' => 'required|boolean',
            'affiliate_commission_rate' => 'required|numeric|min:0|max:100',
            'affiliate_minimum_payout' => 'required|numeric|min:0',
            'affiliate_cookie_duration' => 'required|integer|min:1|max:365',
        ]);

        foreach ($validated as $key => $value) {
            Setting::set($key, $value, 'text', 'affiliate');
        }

        \Cache::flush();

        return back()->with('success', 'Affiliate settings updated successfully!');
    }

    /**
     * Toggle affiliate status
     */
    public function toggleStatus(Affiliate $affiliate): RedirectResponse
    {
        $affiliate->update(['is_active' => !$affiliate->is_active]);

        $status = $affiliate->is_active ? 'activated' : 'deactivated';
        
        return back()->with('success', "Affiliate {$status} successfully!");
    }

    /**
     * Update custom commission rate for an affiliate
     */
    public function updateCommissionRate(Request $request, Affiliate $affiliate): RedirectResponse
    {
        $validated = $request->validate([
            'custom_commission_rate' => 'nullable|numeric|min:0|max:100',
        ]);

        $affiliate->update([
            'custom_commission_rate' => $validated['custom_commission_rate'] ?: null,
        ]);

        $rate = $affiliate->getCommissionRate();
        $userName = $affiliate->user->name ?? 'Affiliate';

        return back()->with('success', "Commission rate for {$userName} set to {$rate}%.");
    }

    /**
     * Send a custom partial or full payment to an affiliate.
     */
    public function payAffiliate(Request $request, Affiliate $affiliate, AffiliateService $affiliateService): RedirectResponse
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'payment_method' => 'required|in:paypal,bank_transfer,crypto,other',
            'payment_reference' => 'nullable|string|max:255',
            'admin_notes' => 'nullable|string|max:500',
        ]);

        $affiliate->load('user');

        try {
            $payout = $affiliateService->recordAdminPayment($affiliate, [
                'amount' => $validated['amount'],
                'payment_method' => $validated['payment_method'],
                'payment_reference' => $validated['payment_reference'] ?? null,
                'admin_notes' => $validated['admin_notes'] ?? null,
                'paid_by' => auth()->user()->name ?? 'Admin',
            ]);
        } catch (\InvalidArgumentException $e) {
            return back()->with('error', $e->getMessage());
        }

        if ($affiliate->user?->email) {
            try {
                Mail::to($affiliate->user->email)->send(new AffiliatePaymentMail($payout));
            } catch (\Exception $e) {
                \Log::error('Failed to send affiliate payment email: ' . $e->getMessage());
            }
        }

        $userName = $affiliate->user->name ?? 'Affiliate';
        $remaining = $affiliate->fresh()->available_balance;

        return back()->with(
            'success',
            "Paid \${$validated['amount']} to {$userName}. Remaining balance: \$" . number_format($remaining, 2)
        );
    }
}
