@extends('admin.layouts.app')

@section('title', 'Manage Payouts')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1 text-gray-800">Payout Requests</h1>
            <p class="text-muted mb-0">Process withdrawal requests from affiliates</p>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 py-3 text-uppercase text-muted small fw-bold">Date</th>
                        <th class="py-3 text-uppercase text-muted small fw-bold">Affiliate</th>
                        <th class="py-3 text-uppercase text-muted small fw-bold">Amount</th>
                        <th class="py-3 text-uppercase text-muted small fw-bold">Method</th>
                        <th class="py-3 text-uppercase text-muted small fw-bold">Status</th>
                        <th class="pe-4 py-3 text-uppercase text-muted small fw-bold text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payouts as $payout)
                    <tr>
                        <td class="ps-4">
                            <div class="fw-bold text-dark">{{ $payout->created_at->format('M d, Y') }}</div>
                            <div class="small text-muted">{{ $payout->created_at->format('h:i A') }}</div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center fw-bold me-2" style="width: 32px; height: 32px;">
                                    {{ substr($payout->affiliate->user->name ?? 'A', 0, 1) }}
                                </div>
                                <div>
                                    <div class="fw-bold text-dark">{{ $payout->affiliate->user->name ?? 'Unknown' }}</div>
                                    <div class="small text-muted">{{ $payout->affiliate->user->email ?? '' }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="fw-bold text-dark">${{ number_format($payout->amount, 2) }}</span>
                        </td>
                        <td>
                            <div class="d-flex flex-column">
                                <span class="text-capitalize fw-bold mb-1">
                                    {{ str_replace('_', ' ', $payout->payment_method) }}
                                </span>
                                @php
                                    $details = is_string($payout->payment_details) ? json_decode($payout->payment_details, true) : $payout->payment_details;
                                @endphp
                                <small class="text-muted" style="max-width: 250px; font-size: 0.75rem;">
                                    @if($payout->payment_method === 'paypal')
                                        <strong>Email:</strong> {{ $details['email'] ?? 'N/A' }}
                                    @elseif($payout->payment_method === 'crypto')
                                        <strong>{{ ucfirst($details['network'] ?? 'crypto') }}:</strong> 
                                        <span class="font-monospace">{{ Str::limit($details['address'] ?? 'N/A', 15) }}</span>
                                    @elseif($payout->payment_method === 'bank_transfer')
                                        <div>{{ $details['bank_name'] ?? 'Bank' }}</div>
                                        <div class="font-monospace">{{ $details['account_number'] ?? 'N/A' }}</div>
                                    @endif
                                </small>
                            </div>
                        </td>
                        <td>
                            @if($payout->status === 'completed')
                                <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-2">
                                    <i class="bi bi-check-circle me-1"></i> Completed
                                </span>
                            @elseif($payout->status === 'processing')
                                <span class="badge bg-info bg-opacity-10 text-info rounded-pill px-3 py-2">
                                    <i class="bi bi-gear me-1"></i> Processing
                                </span>
                            @elseif($payout->status === 'pending')
                                <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-3 py-2">
                                    <i class="bi bi-clock me-1"></i> Pending
                                </span>
                            @else
                                <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-3 py-2">
                                    <i class="bi bi-x-circle me-1"></i> Rejected
                                </span>
                            @endif
                        </td>
                        <td class="pe-4 text-end">
                            @if($payout->status === 'pending')
                                <div class="btn-group">
                                    <form action="{{ route('admin.affiliate.payouts.approve', $payout) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-primary text-white me-1">
                                            Allow & Process
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.affiliate.payouts.reject', $payout) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            Reject
                                        </button>
                                    </form>
                                </div>
                            @elseif($payout->status === 'processing')
                                <form action="{{ route('admin.affiliate.payouts.complete', $payout) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success text-white">
                                        Mark Completed
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="bi bi-wallet2 display-4 d-block mb-3 opacity-25"></i>
                            <p class="mb-0">No payout requests found</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($payouts->hasPages())
        <div class="card-footer bg-white border-top-0 py-3">
            {{ $payouts->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
