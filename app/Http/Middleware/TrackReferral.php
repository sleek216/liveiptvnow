<?php

namespace App\Http\Middleware;

use App\Services\AffiliateService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackReferral
{
    protected AffiliateService $affiliateService;

    public function __construct(AffiliateService $affiliateService)
    {
        $this->affiliateService = $affiliateService;
    }

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if there's a referral code in the URL
        $referralCode = $request->query('ref');
        
        if ($referralCode) {
            // Set referral cookie
            $this->affiliateService->setReferralCookie($referralCode);
        }

        return $next($request);
    }
}
