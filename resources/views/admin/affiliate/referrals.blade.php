@extends('admin.layouts.app')

@section('title', 'Referrals Management')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1 text-gray-800">Referrals Management</h1>
            <p class="text-muted mb-0">Monitor all user referrals and their status</p>
        </div>
    </div>

    <!-- Stats -->
    <div class="row g-4 mb-4">
        <div class="col-12 col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="icon-box bg-primary bg-opacity-10 text-primary rounded-3 p-3 me-3">
                        <i class="bi bi-people fs-4"></i>
                    </div>
                    <div>
                        <h3 class="h4 mb-0 fw-bold">{{ $referrals->total() }}</h3>
                        <p class="text-muted small mb-0">Total Referrals</p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-12 col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="icon-box bg-success bg-opacity-10 text-success rounded-3 p-3 me-3">
                        <i class="bi bi-check-circle fs-4"></i>
                    </div>
                    <div>
                        <h3 class="h4 mb-0 fw-bold">{{ \App\Models\Referral::whereNotNull('converted_at')->count() }}</h3>
                        <p class="text-muted small mb-0">Converted</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="icon-box bg-info bg-opacity-10 text-info rounded-3 p-3 me-3">
                        <i class="bi bi-graph-up fs-4"></i>
                    </div>
                    <div>
                        <h3 class="h4 mb-0 fw-bold">
                            {{ number_format(\App\Models\Referral::whereNotNull('converted_at')->count() > 0 ? (\App\Models\Referral::whereNotNull('converted_at')->count() / \App\Models\Referral::count()) * 100 : 0, 1) }}%
                        </h3>
                        <p class="text-muted small mb-0">Conversion Rate</p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-12 col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="icon-box bg-warning bg-opacity-10 text-warning rounded-3 p-3 me-3">
                        <i class="bi bi-currency-dollar fs-4"></i>
                    </div>
                    <div>
                        <h3 class="h4 mb-0 fw-bold">
                            ${{ number_format(\App\Models\Commission::sum('commission_amount'), 2) }}
                        </h3>
                        <p class="text-muted small mb-0">Total Commissions</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Referrals Table -->
    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 py-3 text-uppercase text-muted small fw-bold">Date</th>
                        <th class="py-3 text-uppercase text-muted small fw-bold">Referred By (Affiliate)</th>
                        <th class="py-3 text-uppercase text-muted small fw-bold">Referred User (New User)</th>
                        <th class="py-3 text-uppercase text-muted small fw-bold">Status</th>
                        <th class="pe-4 py-3 text-uppercase text-muted small fw-bold">Commission</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($referrals as $referral)
                    <tr>
                        <td class="ps-4">
                            <div class="fw-bold text-dark">{{ $referral->created_at->format('M d, Y') }}</div>
                            <div class="small text-muted">{{ $referral->created_at->format('h:i A') }}</div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center fw-bold me-2" style="width: 32px; height: 32px;">
                                    {{ substr($referral->affiliate->user->name ?? 'A', 0, 1) }}
                                </div>
                                <div>
                                    <div class="fw-bold text-dark">{{ $referral->affiliate->user->name ?? 'Unknown' }}</div>
                                    <div class="small text-muted mb-1">{{ $referral->affiliate->user->email ?? '' }}</div>
                                    <span class="badge bg-light text-dark border font-monospace">{{ $referral->referral_code }}</span>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm bg-info bg-opacity-10 text-info rounded-circle d-flex align-items-center justify-content-center fw-bold me-2" style="width: 32px; height: 32px;">
                                    {{ substr($referral->referredUser->name ?? 'U', 0, 1) }}
                                </div>
                                <div>
                                    <div class="fw-bold text-dark">{{ $referral->referredUser->name ?? 'Unknown' }}</div>
                                    <div class="small text-muted">{{ $referral->referredUser->email ?? '' }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            @if($referral->converted_at)
                                <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-2">
                                    <i class="bi bi-check-circle me-1"></i> Converted
                                </span>
                                <div class="small text-muted mt-1">
                                    {{ $referral->converted_at->diffForHumans() }}
                                </div>
                            @else
                                <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-3 py-2">
                                    <i class="bi bi-clock me-1"></i> Pending
                                </span>
                            @endif
                        </td>
                        <td class="pe-4">
                            @if($referral->commissions->count() > 0)
                                <div class="fw-bold text-success">
                                    ${{ number_format($referral->commissions->sum('commission_amount'), 2) }}
                                </div>
                                <div class="small text-muted">
                                    {{ $referral->commissions->count() }} Order(s)
                                </div>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">
                            <i class="bi bi-people display-4 d-block mb-3 opacity-25"></i>
                            <p class="mb-0">No referrals found</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($referrals->hasPages())
        <div class="card-footer bg-white border-top-0 py-3">
            {{ $referrals->links() }}
        </div>
        @endif
    </div>
</div>

<style>
.icon-box {
    width: 48px;
    height: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
}
.card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.card:hover {
    box-shadow: 0 .5rem 1rem rgba(0,0,0,.05)!important;
}
</style>
@endsection
