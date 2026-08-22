@extends('layouts.app')

@section('title', 'My Payouts - Live IPTV Now')

@section('content')
@include('affiliate.partials.dashboard-ui')

<div class="aff-dash">
    <div class="aff-dash-wrap">
        <div class="aff-dash-header" data-aos="fade-up">
            <a href="{{ route('profile') }}#affiliate" class="aff-back-link">
                <i class="ri-arrow-left-line"></i>
                Back to Dashboard
            </a>
            <h1 class="aff-dash-title">My <em>Payouts</em></h1>
            <p class="aff-dash-subtitle">
                View and manage your payout requests. Track withdrawal history and current balance.
            </p>
            <div class="aff-dash-actions">
                @if($affiliate->paid_earnings >= 50)
                    <a href="{{ route('affiliate.payout.request') }}" class="aff-btn aff-btn-primary">
                        <i class="ri-money-dollar-circle-fill"></i>
                        Request Payout
                    </a>
                @endif
            </div>
        </div>

        <div class="aff-stats-grid">
            <div class="aff-stat-card" data-aos="fade-up" data-aos-delay="0">
                <div class="aff-stat-top">
                    <div class="aff-stat-icon aff-stat-icon--green">
                        <i class="ri-wallet-fill"></i>
                    </div>
                    <span class="aff-stat-label">Paid Earnings</span>
                </div>
                <div class="aff-stat-value">${{ number_format($affiliate->paid_earnings, 2) }}</div>
            </div>

            <div class="aff-stat-card" data-aos="fade-up" data-aos-delay="100">
                <div class="aff-stat-top">
                    <div class="aff-stat-icon aff-stat-icon--amber">
                        <i class="ri-time-fill"></i>
                    </div>
                    <span class="aff-stat-label">Pending Earnings</span>
                </div>
                <div class="aff-stat-value">${{ number_format($affiliate->pending_earnings, 2) }}</div>
            </div>

            <div class="aff-stat-card" data-aos="fade-up" data-aos-delay="200">
                <div class="aff-stat-top">
                    <div class="aff-stat-icon aff-stat-icon--blue">
                        <i class="ri-checkbox-circle-fill"></i>
                    </div>
                    <span class="aff-stat-label">Total Withdrawn</span>
                </div>
                <div class="aff-stat-value">${{ number_format($affiliate->payouts()->where('status', 'completed')->sum('amount'), 2) }}</div>
            </div>

            <div class="aff-stat-card" data-aos="fade-up" data-aos-delay="300">
                <div class="aff-stat-top">
                    <div class="aff-stat-icon aff-stat-icon--purple">
                        <i class="ri-exchange-dollar-fill"></i>
                    </div>
                    <span class="aff-stat-label">Total Requests</span>
                </div>
                <div class="aff-stat-value">{{ $payouts->total() }}</div>
            </div>
        </div>

        @if($affiliate->paid_earnings < 50)
            <div class="aff-alert" data-aos="fade-up">
                <div class="aff-alert-icon">
                    <i class="ri-information-fill"></i>
                </div>
                <div>
                    <h4 class="aff-alert-title">Minimum Payout: $50</h4>
                    <p class="aff-alert-text">
                        You need <strong>${{ number_format(50 - $affiliate->paid_earnings, 2) }}</strong> more in paid earnings to request a payout.
                    </p>
                </div>
            </div>
        @endif

        <div class="aff-panel" data-aos="fade-up" data-aos-delay="150">
            <div class="aff-panel-head">
                <h2 class="aff-panel-title">Payout <em>History</em></h2>
                <p class="aff-panel-desc">Track all your withdrawal requests and their current status</p>
            </div>

            @if($payouts->count() > 0)
                <div class="aff-table-wrap">
                    <table class="aff-table">
                        <thead>
                            <tr>
                                <th>Request Date</th>
                                <th>Amount</th>
                                <th>Payment Method</th>
                                <th>Status</th>
                                <th>Processed Date</th>
                                <th>Notes</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($payouts as $payout)
                            <tr>
                                <td>
                                    <span class="aff-date-main">{{ $payout->created_at->format('M d, Y') }}</span>
                                    <span class="aff-date-sub">{{ $payout->created_at->format('h:i A') }}</span>
                                </td>
                                <td><span class="aff-amount">${{ number_format($payout->amount, 2) }}</span></td>
                                <td>
                                    <span class="aff-user-name">{{ str_replace('_', ' ', ucfirst($payout->payment_method)) }}</span>
                                    @php
                                        $details = is_string($payout->payment_details) ? json_decode($payout->payment_details, true) : $payout->payment_details;
                                    @endphp
                                    @if($details)
                                        <span class="aff-user-email">
                                            @if($payout->payment_method === 'paypal')
                                                {{ $details['email'] ?? '' }}
                                            @elseif($payout->payment_method === 'crypto')
                                                {{ isset($details['address']) ? substr($details['address'], 0, 12) . '...' : '' }}
                                            @elseif($payout->payment_method === 'bank_transfer')
                                                {{ $details['bank_name'] ?? '' }}
                                            @endif
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    @if($payout->status === 'completed')
                                        <span class="aff-badge aff-badge--success">
                                            <i class="ri-checkbox-circle-fill"></i>
                                            Completed
                                        </span>
                                    @elseif($payout->status === 'pending')
                                        <span class="aff-badge aff-badge--pending">
                                            <i class="ri-time-fill"></i>
                                            Pending
                                        </span>
                                    @elseif($payout->status === 'processing')
                                        <span class="aff-badge aff-badge--info">
                                            <i class="ri-loader-4-fill"></i>
                                            Processing
                                        </span>
                                    @elseif($payout->status === 'rejected')
                                        <span class="aff-badge aff-badge--danger">
                                            <i class="ri-close-circle-fill"></i>
                                            Rejected
                                        </span>
                                    @else
                                        <span class="aff-badge aff-badge--muted">{{ ucfirst($payout->status) }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if($payout->processed_at)
                                        <span class="aff-date-main">{{ $payout->processed_at->format('M d, Y') }}</span>
                                    @else
                                        <span class="aff-muted">—</span>
                                    @endif
                                </td>
                                <td>
                                    @if($payout->admin_notes)
                                        <span>{{ Str::limit($payout->admin_notes, 30) }}</span>
                                    @else
                                        <span class="aff-muted">—</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if($payouts->hasPages())
                    <div class="aff-pagination">
                        {{ $payouts->links() }}
                    </div>
                @endif
            @else
                <div class="aff-empty">
                    <div class="aff-empty-icon">
                        <i class="ri-wallet-line"></i>
                    </div>
                    <h3 class="aff-empty-title">No Payouts Yet</h3>
                    <p class="aff-empty-text">
                        Once you reach the minimum threshold of $50, you can request a payout.
                    </p>
                    @if($affiliate->paid_earnings >= 50)
                        <a href="{{ route('affiliate.payout.request') }}" class="aff-btn aff-btn-primary">
                            <i class="ri-money-dollar-circle-fill"></i>
                            Request Your First Payout
                        </a>
                    @else
                        <a href="{{ route('profile') }}#affiliate" class="aff-btn aff-btn-primary">
                            <i class="ri-arrow-left-fill"></i>
                            Continue Earning
                        </a>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
