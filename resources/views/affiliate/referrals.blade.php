@extends('layouts.app')

@section('title', 'My Referrals - Live IPTV Now')

@section('content')
@include('affiliate.partials.dashboard-ui')

<div class="aff-dash">
    <div class="aff-dash-wrap">
        <div class="aff-dash-header" data-aos="fade-up">
            <a href="{{ route('profile') }}#affiliate" class="aff-back-link">
                <i class="ri-arrow-left-line"></i>
                Back to Dashboard
            </a>
            <h1 class="aff-dash-title">My <em>Referrals</em></h1>
            <p class="aff-dash-subtitle">
                Track and manage all your referred users. Monitor your network growth and earnings in real-time.
            </p>
        </div>

        <div class="aff-stats-grid">
            <div class="aff-stat-card" data-aos="fade-up" data-aos-delay="0">
                <div class="aff-stat-top">
                    <div class="aff-stat-icon aff-stat-icon--purple">
                        <i class="ri-team-fill"></i>
                    </div>
                    <span class="aff-stat-label">Total Referrals</span>
                </div>
                <div class="aff-stat-value">{{ $referrals->total() }}</div>
            </div>

            <div class="aff-stat-card" data-aos="fade-up" data-aos-delay="100">
                <div class="aff-stat-top">
                    <div class="aff-stat-icon aff-stat-icon--green">
                        <i class="ri-checkbox-circle-fill"></i>
                    </div>
                    <span class="aff-stat-label">Converted</span>
                </div>
                <div class="aff-stat-value">{{ $affiliate->referrals()->whereNotNull('converted_at')->count() }}</div>
            </div>

            <div class="aff-stat-card" data-aos="fade-up" data-aos-delay="200">
                <div class="aff-stat-top">
                    <div class="aff-stat-icon aff-stat-icon--blue">
                        <i class="ri-percent-fill"></i>
                    </div>
                    <span class="aff-stat-label">Conversion Rate</span>
                </div>
                <div class="aff-stat-value">
                    {{ $referrals->total() > 0 ? number_format(($affiliate->referrals()->whereNotNull('converted_at')->count() / $referrals->total()) * 100, 1) : 0 }}%
                </div>
            </div>

            <div class="aff-stat-card" data-aos="fade-up" data-aos-delay="300">
                <div class="aff-stat-top">
                    <div class="aff-stat-icon aff-stat-icon--orange">
                        <i class="ri-money-dollar-circle-fill"></i>
                    </div>
                    <span class="aff-stat-label">Total Earned</span>
                </div>
                <div class="aff-stat-value">${{ number_format($affiliate->referrals->sum(function ($ref) { return $ref->commissions->sum('commission_amount'); }), 2) }}</div>
            </div>
        </div>

        <div class="aff-panel" data-aos="fade-up" data-aos-delay="150">
            <div class="aff-panel-head">
                <h2 class="aff-panel-title">Referral <em>Details</em></h2>
                <p class="aff-panel-desc">Complete list of all users you've referred to the platform</p>
            </div>

            @if($referrals->count() > 0)
                <div class="aff-table-wrap">
                    <table class="aff-table">
                        <thead>
                            <tr>
                                <th>Date Referred</th>
                                <th>User Information</th>
                                <th>Status</th>
                                <th>Commission Earned</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($referrals as $referral)
                            <tr>
                                <td>
                                    <span class="aff-date-main">{{ $referral->created_at->format('M d, Y') }}</span>
                                    <span class="aff-date-sub">{{ $referral->created_at->format('h:i A') }}</span>
                                </td>
                                <td>
                                    <div class="aff-user">
                                        <div class="aff-user-avatar">
                                            <i class="ri-user-fill"></i>
                                        </div>
                                        <div>
                                            <span class="aff-user-name">{{ $referral->referredUser->name ?? 'N/A' }}</span>
                                            <span class="aff-user-email">{{ $referral->referredUser->email ?? 'N/A' }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if($referral->converted_at)
                                        <span class="aff-badge aff-badge--success">
                                            <i class="ri-checkbox-circle-fill"></i>
                                            Converted
                                        </span>
                                    @else
                                        <span class="aff-badge aff-badge--pending">
                                            <i class="ri-time-fill"></i>
                                            Pending
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <span class="aff-amount">${{ number_format($referral->commissions->sum('commission_amount'), 2) }}</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if($referrals->hasPages())
                    <div class="aff-pagination">
                        {{ $referrals->links() }}
                    </div>
                @endif
            @else
                <div class="aff-empty">
                    <div class="aff-empty-icon">
                        <i class="ri-team-line"></i>
                    </div>
                    <h3 class="aff-empty-title">No Referrals Yet</h3>
                    <p class="aff-empty-text">
                        Share your unique referral link to start building your network and earning commissions!
                    </p>
                    <a href="{{ route('profile') }}#affiliate" class="aff-btn aff-btn-primary">
                        <i class="ri-link-fill"></i>
                        Get Your Referral Link
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
