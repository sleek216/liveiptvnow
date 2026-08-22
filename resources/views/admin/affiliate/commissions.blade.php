@extends('admin.layouts.app')

@section('title', 'Manage Commissions')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1 text-gray-800">Commissions</h1>
            <p class="text-muted mb-0">Set amount and pay directly from each row</p>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 py-3 text-uppercase text-muted small fw-bold">Date</th>
                        <th class="py-3 text-uppercase text-muted small fw-bold">Affiliate (Referrer)</th>
                        <th class="py-3 text-uppercase text-muted small fw-bold">Buyer (Referred User)</th>
                        <th class="py-3 text-uppercase text-muted small fw-bold">Order Details</th>
                        <th class="py-3 text-uppercase text-muted small fw-bold">Commission</th>
                        <th class="py-3 text-uppercase text-muted small fw-bold">Status</th>
                        <th class="pe-4 py-3 text-uppercase text-muted small fw-bold text-end" style="min-width: 200px;">Pay Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($commissions as $commission)
                    @php
                        $paid = (float) ($commission->paid_amount ?? 0);
                        $remaining = max(0, (float) $commission->commission_amount - $paid);
                    @endphp
                    <tr>
                        <td class="ps-4">
                            <div class="fw-bold text-dark">{{ $commission->created_at->format('M d, Y') }}</div>
                            <div class="small text-muted">{{ $commission->created_at->format('h:i A') }}</div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center fw-bold me-2" style="width: 32px; height: 32px;">
                                    {{ substr($commission->affiliate->user->name ?? 'A', 0, 1) }}
                                </div>
                                <div>
                                    <div class="fw-bold text-dark">{{ $commission->affiliate->user->name ?? 'Unknown' }}</div>
                                    <div class="small text-muted">{{ $commission->affiliate->user->email ?? '' }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            @if($commission->referral?->referredUser)
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm bg-info bg-opacity-10 text-info rounded-circle d-flex align-items-center justify-content-center fw-bold me-2" style="width: 32px; height: 32px;">
                                    {{ substr($commission->referral->referredUser->name, 0, 1) }}
                                </div>
                                <div>
                                    <div class="fw-bold text-dark">{{ $commission->referral->referredUser->name }}</div>
                                    <div class="small text-muted">{{ $commission->referral->referredUser->email }}</div>
                                </div>
                            </div>
                            @else
                            <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td>
                            <div class="mb-1">
                                <span class="badge bg-light text-dark border font-monospace">#{{ $commission->order_id }}</span>
                            </div>
                            <div class="small text-muted">Sale: ${{ number_format($commission->order_amount, 2) }}</div>
                            @if($commission->order?->package)
                            <div class="small text-muted">Package: {{ $commission->order->package->name }}</div>
                            @endif
                        </td>
                        <td>
                            <div class="fw-bold text-success">${{ number_format($commission->commission_amount, 2) }}</div>
                            <div class="small text-muted">{{ $commission->commission_rate }}% Rate</div>
                            @if($paid > 0)
                            <div class="small text-primary">Paid: ${{ number_format($paid, 2) }}</div>
                            @endif
                            @if($remaining > 0 && $commission->status !== 'rejected')
                            <div class="small text-warning fw-semibold">Left: ${{ number_format($remaining, 2) }}</div>
                            @endif
                        </td>
                        <td>
                            @if($commission->status === 'paid')
                                <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-2">Paid</span>
                            @elseif($commission->status === 'partially_paid')
                                <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-2">Partial</span>
                            @elseif($commission->status === 'approved')
                                <span class="badge bg-info bg-opacity-10 text-info rounded-pill px-3 py-2">Approved</span>
                            @elseif($commission->status === 'pending')
                                <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-3 py-2">Pending</span>
                            @else
                                <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-3 py-2">Rejected</span>
                            @endif
                        </td>
                        <td class="pe-4 text-end">
                            @if($remaining > 0 && in_array($commission->status, ['pending', 'partially_paid', 'approved']))
                            <form action="{{ route('admin.affiliate.commissions.pay', $commission) }}" method="POST"
                                class="d-flex align-items-center justify-content-end gap-2 flex-wrap">
                                @csrf
                                <div class="input-group input-group-sm" style="width: 150px;">
                                    <span class="input-group-text">$</span>
                                    <input type="number" name="amount" class="form-control"
                                        min="0.01" max="{{ $remaining }}" step="0.01"
                                        value="{{ number_format($remaining, 2, '.', '') }}"
                                        title="Max: ${{ number_format($remaining, 2) }}" required>
                                </div>
                                <button type="submit" class="btn btn-sm btn-success text-white px-3">
                                    Pay
                                </button>
                                @if(in_array($commission->status, ['pending', 'partially_paid']))
                                <button type="submit" formaction="{{ route('admin.affiliate.commissions.reject', $commission) }}"
                                    formmethod="POST" class="btn btn-sm btn-outline-danger" title="Reject"
                                    onclick="return confirm('Reject remaining commission?')">
                                    <i class="bi bi-x-lg"></i>
                                </button>
                                @endif
                            </form>
                            @else
                            <span class="text-muted small">—</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <i class="bi bi-cash-stack display-4 d-block mb-3 opacity-25"></i>
                            <p class="mb-0">No commissions found</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($commissions->hasPages())
        <div class="card-footer bg-white border-top-0 py-3">
            {{ $commissions->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
