<?php

namespace App\Http\Controllers;

use App\Models\Affiliate;
use App\Models\Payout;
use App\Services\AffiliateService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class AffiliateController extends Controller
{
    protected AffiliateService $affiliateService;

    public function __construct(AffiliateService $affiliateService)
    {
        $this->affiliateService = $affiliateService;
    }

    /**
     * Show affiliate dashboard
     */
    public function index(): View
    {
        $user = auth()->user();
        
        // Create affiliate account if doesn't exist
        if (!$user->affiliate) {
            $user->createAffiliateAccount();
        }

        $affiliate = $user->affiliate;
        $stats = $this->affiliateService->getAffiliateStats($affiliate);

        return view('affiliate.dashboard', compact('affiliate', 'stats'));
    }

    /**
     * Show referrals page
     */
    public function referrals(): View
    {
        $affiliate = auth()->user()->affiliate;
        
        $referrals = $affiliate->referrals()
            ->with(['referredUser', 'commissions'])
            ->latest()
            ->paginate(20);

        return view('affiliate.referrals', compact('affiliate', 'referrals'));
    }

    /**
     * Show commissions page
     */
    public function commissions(): View
    {
        $affiliate = auth()->user()->affiliate;
        
        $commissions = $affiliate->commissions()
            ->with(['order', 'referral.referredUser'])
            ->latest()
            ->paginate(20);

        return view('affiliate.commissions', compact('affiliate', 'commissions'));
    }

    /**
     * Show payouts page
     */
    public function payouts(): View
    {
        $affiliate = auth()->user()->affiliate;
        
        $payouts = $affiliate->payouts()
            ->latest()
            ->paginate(20);

        return view('affiliate.payouts', compact('affiliate', 'payouts'));
    }

    /**
     * Show payout request form
     */
    public function requestPayoutForm(): View
    {
        $affiliate = auth()->user()->affiliate;

        return view('affiliate.request-payout', compact('affiliate'));
    }

    /**
     * Submit payout request
     */
    public function requestPayout(Request $request): RedirectResponse
    {
        $affiliate = auth()->user()->affiliate;

        $validated = $request->validate([
            'amount' => 'required|numeric|min:1',
            'payment_method' => 'required|in:paypal,bank_transfer,crypto',
            'paypal_email' => 'required_if:payment_method,paypal|email',
            'bank_name' => 'required_if:payment_method,bank_transfer',
            'account_number' => 'required_if:payment_method,bank_transfer',
            'account_holder' => 'required_if:payment_method,bank_transfer',
            'crypto_address' => 'required_if:payment_method,crypto',
            'crypto_network' => 'required_if:payment_method,crypto',
        ]);

        // Check if amount is available
        if ($validated['amount'] > $affiliate->available_balance) {
            return back()->with('error', 'Insufficient balance.');
        }

        // Check minimum payout
        $minimumPayout = \App\Models\Setting::get('affiliate_minimum_payout', 50);
        if ($validated['amount'] < $minimumPayout) {
            return back()->with('error', "Minimum payout amount is ${minimumPayout}.");
        }

        // Prepare payment details
        $paymentDetails = [];
        switch ($validated['payment_method']) {
            case 'paypal':
                $paymentDetails = ['email' => $validated['paypal_email']];
                break;
            case 'bank_transfer':
                $paymentDetails = [
                    'bank_name' => $validated['bank_name'],
                    'account_number' => $validated['account_number'],
                    'account_holder' => $validated['account_holder'],
                ];
                break;
            case 'crypto':
                $paymentDetails = [
                    'address' => $validated['crypto_address'],
                    'network' => $validated['crypto_network'],
                ];
                break;
        }

        // Create payout request
        $payout = $this->affiliateService->requestPayout($affiliate, [
            'amount' => $validated['amount'],
            'payment_method' => $validated['payment_method'],
            'payment_details' => $paymentDetails,
        ]);

        if ($payout) {
            return redirect()->route('affiliate.payouts')
                ->with('success', 'Payout request submitted successfully!');
        }

        return back()->with('error', 'Failed to submit payout request.');
    }
}
