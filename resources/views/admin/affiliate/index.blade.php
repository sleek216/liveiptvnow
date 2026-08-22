@extends('admin.layouts.app')

@section('title', 'Affiliate Overview')

@section('content')
<div class="container-fluid p-0">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1 text-gray-800">Affiliate Program Overview</h1>
            <p class="text-muted mb-0">Key metrics and top performing partners</p>
        </div>
        <a href="{{ route('admin.affiliate.settings') }}" class="btn btn-outline-primary">
            <i class="bi bi-gear-fill me-2"></i> Settings
        </a>
    </div>

    <!-- Stats Grid -->
    <div class="row g-4 mb-4">
        <!-- Total Affiliates -->
        <div class="col-6 col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-box bg-primary bg-opacity-10 text-primary rounded-3 p-3 me-3">
                            <i class="bi bi-people-fill fs-4"></i>
                        </div>
                        <div>
                            <h2 class="h4 mb-0 fw-bold">{{ $stats['total_affiliates'] }}</h2>
                            <p class="text-muted small mb-0">Total Affiliates</p>
                        </div>
                    </div>
                    <div class="border-top pt-3 d-flex justify-content-between align-items-center small">
                        <span class="text-muted">Active</span>
                        <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3">{{ $stats['active_affiliates'] }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Revenue -->
        <div class="col-6 col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-box bg-success bg-opacity-10 text-success rounded-3 p-3 me-3">
                            <i class="bi bi-currency-dollar fs-4"></i>
                        </div>
                        <div>
                            <h2 class="h4 mb-0 fw-bold">${{ number_format($stats['total_sales'], 2) }}</h2>
                            <p class="text-muted small mb-0">Total Revenue</p>
                        </div>
                    </div>
                    <div class="border-top pt-3 d-flex justify-content-between align-items-center small">
                        <span class="text-muted">Referrals</span>
                        <span class="fw-bold text-dark">{{ $stats['total_referrals'] }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Paid Out -->
        <div class="col-6 col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-box bg-info bg-opacity-10 text-info rounded-3 p-3 me-3">
                            <i class="bi bi-wallet2 fs-4"></i>
                        </div>
                        <div>
                            <h2 class="h4 mb-0 fw-bold">${{ number_format($stats['paid_earnings'], 2) }}</h2>
                            <p class="text-muted small mb-0">Total Paid Out</p>
                        </div>
                    </div>
                    <div class="border-top pt-3 d-flex justify-content-between align-items-center small">
                        <span class="text-muted">Pending Payouts</span>
                        <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-3">{{ $stats['pending_payouts'] }} Requests</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Commissions -->
        <div class="col-6 col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-box bg-warning bg-opacity-10 text-warning rounded-3 p-3 me-3">
                            <i class="bi bi-clock-history fs-4"></i>
                        </div>
                        <div>
                            <h2 class="h4 mb-0 fw-bold">${{ number_format($stats['pending_earnings'], 2) }}</h2>
                            <p class="text-muted small mb-0">Pending Commissions</p>
                        </div>
                    </div>
                    <div class="border-top pt-3 d-flex justify-content-between align-items-center small">
                        <span class="text-muted">To Approve</span>
                        <span class="fw-bold text-warning">{{ $stats['pending_commissions'] }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Top Affiliates Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 fw-bold text-gray-800" style="font-size:1rem;">Top Performing Affiliates</h5>
            <a href="{{ route('admin.affiliate.affiliates') }}" class="btn btn-sm btn-light text-primary fw-medium">View All</a>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 text-uppercase text-muted small fw-bold">Affiliate</th>
                        <th class="text-uppercase text-muted small fw-bold">Referrals</th>
                        <th class="text-uppercase text-muted small fw-bold">Total Sales</th>
                        <th class="text-uppercase text-muted small fw-bold">Earnings</th>
                        <th class="text-uppercase text-muted small fw-bold">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($topAffiliates as $affiliate)
                    <tr>
                        <td class="ps-4">
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center fw-bold me-3" style="width: 36px; height: 36px;">
                                    {{ substr($affiliate->user->name ?? 'A', 0, 1) }}
                                </div>
                                <div>
                                    <div class="fw-bold text-dark">{{ $affiliate->user->name ?? 'Unknown' }}</div>
                                    <div class="small text-muted">{{ $affiliate->user->email ?? '' }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="fw-medium">{{ $affiliate->total_referrals }}</td>
                        <td class="fw-medium text-dark">${{ number_format($affiliate->total_sales, 2) }}</td>
                        <td class="fw-bold text-success">${{ number_format($affiliate->total_earnings, 2) }}</td>
                        <td>
                            @if($affiliate->is_active)
                                <span class="badge bg-success bg-opacity-10 text-success rounded-pill">Active</span>
                            @else
                                <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill">Inactive</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">
                            <i class="bi bi-people display-4 d-block mb-3 opacity-25"></i>
                            <p class="mb-0">No affiliates found</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
.icon-box {
    width: 48px;
    height: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
@media (max-width: 575.98px) {
    .icon-box { width: 36px; height: 36px; }
    .icon-box .fs-4 { font-size: 1rem !important; }
    .h4 { font-size: 1.1rem; }
}
</style>
@endsection
