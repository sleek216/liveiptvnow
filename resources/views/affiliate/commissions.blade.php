@extends('layouts.app')

@section('title', 'My Commissions - Live IPTV Now')

@section('content')
@include('affiliate.partials.dashboard-ui')

<div class="aff-dash">
    <div class="aff-dash-wrap">
        <div class="aff-dash-header" data-aos="fade-up">
            <a href="{{ route('profile') }}#affiliate" class="aff-back-link">
                <i class="ri-arrow-left-line"></i>
                Back to Dashboard
            </a>
            <h1 class="aff-dash-title">My <em>Commissions</em></h1>
            <p class="aff-dash-subtitle">
                Track all your earned commissions from successful referrals. Monitor your earnings in real-time.
            </p>
        </div>

        <div class="aff-stats-grid">
            <div class="aff-stat-card" data-aos="fade-up" data-aos-delay="0">
                <div class="aff-stat-top">
                    <div class="aff-stat-icon aff-stat-icon--orange">
                        <i class="ri-money-dollar-circle-fill"></i>
                    </div>
                    <span class="aff-stat-label">Total Earned</span>
                </div>
                <div class="aff-stat-value">${{ number_format($affiliate->total_earnings, 2) }}</div>
            </div>

            <div class="aff-stat-card" data-aos="fade-up" data-aos-delay="100">
                <div class="aff-stat-top">
                    <div class="aff-stat-icon aff-stat-icon--green">
                        <i class="ri-wallet-fill"></i>
                    </div>
                    <span class="aff-stat-label">Paid Earnings</span>
                </div>
                <div class="aff-stat-value">${{ number_format($affiliate->paid_earnings, 2) }}</div>
            </div>

            <div class="aff-stat-card" data-aos="fade-up" data-aos-delay="200">
                <div class="aff-stat-top">
                    <div class="aff-stat-icon aff-stat-icon--amber">
                        <i class="ri-time-fill"></i>
                    </div>
                    <span class="aff-stat-label">Pending Earnings</span>
                </div>
                <div class="aff-stat-value">${{ number_format($affiliate->pending_earnings, 2) }}</div>
            </div>

            <div class="aff-stat-card" data-aos="fade-up" data-aos-delay="300">
                <div class="aff-stat-top">
                    <div class="aff-stat-icon aff-stat-icon--blue">
                        <i class="ri-arrow-up-circle-fill"></i>
                    </div>
                    <span class="aff-stat-label">Total Commissions</span>
                </div>
                <div class="aff-stat-value">{{ $commissions->total() }}</div>
            </div>
        </div>

        <div class="aff-panel" data-aos="fade-up" data-aos-delay="150">
            <div class="aff-panel-head">
                <h2 class="aff-panel-title">Commission <em>History</em></h2>
                <p class="aff-panel-desc">Detailed breakdown of all commissions earned from your referrals</p>
            </div>

            @if($commissions->count() > 0)
                <div class="aff-table-wrap">
                    <table class="aff-table">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Customer</th>
                                <th>Order ID</th>
                                <th>Sale Amount</th>
                                <th>Rate</th>
                                <th>Commission</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($commissions as $commission)
                            <tr>
                                <td>
                                    <span class="aff-date-main">{{ $commission->created_at->format('M d, Y') }}</span>
                                    <span class="aff-date-sub">{{ $commission->created_at->format('h:i A') }}</span>
                                </td>
                                <td>
                                    <div class="aff-user">
                                        <div class="aff-user-avatar">
                                            <i class="ri-user-fill"></i>
                                        </div>
                                        <div>
                                            <span class="aff-user-name">{{ $commission->referral->referredUser->name ?? 'N/A' }}</span>
                                            @if($commission->referral->referredUser->email ?? null)
                                                <span class="aff-user-email">{{ $commission->referral->referredUser->email }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td><span class="aff-code">#{{ $commission->order_id }}</span></td>
                                <td>${{ number_format($commission->order_amount, 2) }}</td>
                                <td><strong>{{ $commission->commission_rate }}%</strong></td>
                                <td><span class="aff-amount">${{ number_format($commission->commission_amount, 2) }}</span>
                                    @if(($commission->paid_amount ?? 0) > 0)
                                    <br><span class="aff-user-email">Paid: ${{ number_format($commission->paid_amount, 2) }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if($commission->status === 'paid')
                                        <span class="aff-badge aff-badge--success">
                                            <i class="ri-checkbox-circle-fill"></i>
                                            Paid
                                        </span>
                                    @elseif($commission->status === 'partially_paid')
                                        <span class="aff-badge aff-badge--info">
                                            <i class="ri-cash-fill"></i>
                                            Partially Paid
                                        </span>
                                    @elseif($commission->status === 'approved')
                                        <span class="aff-badge aff-badge--info">
                                            <i class="ri-check-fill"></i>
                                            Approved
                                        </span>
                                    @elseif($commission->status === 'pending')
                                        <span class="aff-badge aff-badge--pending">
                                            <i class="ri-time-fill"></i>
                                            Pending
                                        </span>
                                    @elseif($commission->status === 'rejected')
                                        <span class="aff-badge aff-badge--muted">Rejected</span>
                                    @else
                                        <span class="aff-badge aff-badge--muted">{{ ucfirst(str_replace('_', ' ', $commission->status)) }}</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if($commissions->hasPages())
                    <div class="aff-pagination">
                        {{ $commissions->links() }}
                    </div>
                @endif
            @else
                <div class="aff-empty">
                    <div class="aff-empty-icon">
                        <i class="ri-money-dollar-circle-line"></i>
                    </div>
                    <h3 class="aff-empty-title">No Commissions Yet</h3>
                    <p class="aff-empty-text">
                        Start sharing your referral link to earn commissions on every successful sale!
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
