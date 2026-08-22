@extends('admin.layouts.app')

@section('title', 'Manage Affiliates')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1 text-gray-800">Affiliates</h1>
            <p class="text-muted mb-0">Manage affiliates, commission rates, and send custom payments</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 py-3 text-uppercase text-muted small fw-bold">Affiliate</th>
                        <th class="py-3 text-uppercase text-muted small fw-bold">Referral Code</th>
                        <th class="py-3 text-uppercase text-muted small fw-bold">Rate</th>
                        <th class="py-3 text-uppercase text-muted small fw-bold">Signups</th>
                        <th class="py-3 text-uppercase text-muted small fw-bold">Purchases</th>
                        <th class="py-3 text-uppercase text-muted small fw-bold">Balance</th>
                        <th class="py-3 text-uppercase text-muted small fw-bold">Status</th>
                        <th class="pe-4 py-3 text-uppercase text-muted small fw-bold text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($affiliates as $affiliate)
                    @php
                        $available = $affiliate->available_balance;
                        $withdrawn = $affiliate->total_paid;
                    @endphp
                    <tr>
                        <td class="ps-4">
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center fw-bold me-3" style="width: 40px; height: 40px;">
                                    {{ substr($affiliate->user->name ?? 'A', 0, 1) }}
                                </div>
                                <div>
                                    <div class="fw-bold text-dark">{{ $affiliate->user->name ?? 'Unknown' }}</div>
                                    <div class="small text-muted">{{ $affiliate->user->email ?? '' }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-light text-dark border font-monospace px-2 py-2">
                                {{ $affiliate->referral_code }}
                            </span>
                        </td>
                        <td>
                            @if($affiliate->custom_commission_rate)
                                <span class="badge bg-primary bg-opacity-10 text-primary px-2 py-2">
                                    {{ $affiliate->custom_commission_rate }}% <small>(Custom)</small>
                                </span>
                            @else
                                <span class="badge bg-secondary bg-opacity-10 text-secondary px-2 py-2">
                                    {{ \App\Models\Setting::get('affiliate_commission_rate', 20) }}% <small>(Default)</small>
                                </span>
                            @endif
                        </td>
                        <td>{{ $affiliate->total_referrals }}</td>
                        <td>{{ $affiliate->total_sales }}</td>
                        <td>
                            <div class="d-flex flex-column gap-1" style="min-width: 140px;">
                                <span class="small"><span class="text-muted">Total:</span> <strong class="text-success">${{ number_format($affiliate->total_earnings, 2) }}</strong></span>
                                <span class="small"><span class="text-muted">Pending:</span> <strong class="text-warning">${{ number_format($affiliate->pending_earnings, 2) }}</strong></span>
                                <span class="small"><span class="text-muted">Available:</span> <strong class="text-primary">${{ number_format($available, 2) }}</strong></span>
                                <span class="small"><span class="text-muted">Paid Out:</span> <strong>${{ number_format($withdrawn, 2) }}</strong></span>
                            </div>
                        </td>
                        <td>
                            @if($affiliate->is_active)
                                <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-2">Active</span>
                            @else
                                <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-3 py-2">Inactive</span>
                            @endif
                        </td>
                        <td class="pe-4 text-end">
                            <div class="d-flex flex-column align-items-end gap-2">
                                @if($available > 0)
                                <button type="button" class="btn btn-sm btn-success text-white"
                                    data-bs-toggle="modal"
                                    data-bs-target="#payModal{{ $affiliate->id }}">
                                    <i class="bi bi-cash-coin me-1"></i> Pay Affiliate
                                </button>
                                @else
                                <button type="button" class="btn btn-sm btn-outline-secondary" disabled title="No available balance">
                                    <i class="bi bi-cash-coin me-1"></i> Pay Affiliate
                                </button>
                                @endif

                                <form action="{{ route('admin.affiliate.affiliates.commission-rate', $affiliate) }}" method="POST" class="d-flex align-items-center gap-2">
                                    @csrf
                                    <input type="number" name="custom_commission_rate" class="form-control form-control-sm" style="width: 72px;"
                                        value="{{ $affiliate->custom_commission_rate }}"
                                        placeholder="{{ \App\Models\Setting::get('affiliate_commission_rate', 20) }}"
                                        min="0" max="100" step="0.01" title="Custom commission %">
                                    <button type="submit" class="btn btn-sm btn-outline-primary" title="Save rate">Rate</button>
                                </form>

                                <form action="{{ route('admin.affiliate.affiliates.toggle', $affiliate) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm {{ $affiliate->is_active ? 'btn-outline-danger' : 'btn-outline-success' }}">
                                        {{ $affiliate->is_active ? 'Deactivate' : 'Activate' }}
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>

                    {{-- Pay Modal --}}
                    <div class="modal fade" id="payModal{{ $affiliate->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content border-0 shadow">
                                <form action="{{ route('admin.affiliate.affiliates.pay', $affiliate) }}" method="POST">
                                    @csrf
                                    <div class="modal-header border-0 pb-0">
                                        <div>
                                            <h5 class="modal-title fw-bold">Pay Affiliate</h5>
                                            <p class="text-muted small mb-0">{{ $affiliate->user->name ?? 'Unknown' }}</p>
                                        </div>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="alert alert-light border mb-3">
                                            <div class="d-flex justify-content-between small mb-1">
                                                <span>Available to pay:</span>
                                                <strong class="text-primary">${{ number_format($available, 2) }}</strong>
                                            </div>
                                            <div class="d-flex justify-content-between small mb-1">
                                                <span>Pending approval:</span>
                                                <strong class="text-warning">${{ number_format($affiliate->pending_earnings, 2) }}</strong>
                                            </div>
                                            <div class="d-flex justify-content-between small">
                                                <span>Already paid out:</span>
                                                <strong>${{ number_format($withdrawn, 2) }}</strong>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Payment Amount ($) <span class="text-danger">*</span></label>
                                            <input type="number" name="amount" class="form-control" required
                                                min="0.01" max="{{ $available }}" step="0.01"
                                                placeholder="e.g. 10.00" value="{{ $available >= 50 ? 50 : $available }}">
                                            <div class="form-text">Partial payments allowed. Max: ${{ number_format($available, 2) }}</div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Payment Method <span class="text-danger">*</span></label>
                                            <select name="payment_method" class="form-select" required>
                                                <option value="paypal">PayPal</option>
                                                <option value="bank_transfer">Bank Transfer</option>
                                                <option value="crypto">Crypto</option>
                                                <option value="other">Other / Cash</option>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Reference / Transaction ID</label>
                                            <input type="text" name="payment_reference" class="form-control"
                                                placeholder="PayPal txn ID, bank ref, etc.">
                                        </div>

                                        <div class="mb-0">
                                            <label class="form-label fw-semibold">Note to Affiliate</label>
                                            <textarea name="admin_notes" class="form-control" rows="2"
                                                placeholder="Optional note (visible to affiliate)"></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer border-0 pt-0">
                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-success">
                                            <i class="bi bi-check-circle me-1"></i> Confirm Payment
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-5 text-muted">
                            <i class="bi bi-people display-4 d-block mb-3 opacity-25"></i>
                            <p class="mb-0">No affiliates found</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($affiliates->hasPages())
        <div class="card-footer bg-white border-top-0 py-3">
            {{ $affiliates->links() }}
        </div>
        @endif
    </div>

    <div class="card border-0 shadow-sm mt-4">
        <div class="card-body">
            <h6 class="fw-bold mb-2"><i class="bi bi-info-circle me-1"></i> How payments work</h6>
            <ul class="small text-muted mb-0 ps-3">
                <li><strong>Pending</strong> — commissions waiting for admin approval (Commissions page).</li>
                <li><strong>Available</strong> — approved earnings ready to pay out.</li>
                <li><strong>Pay Affiliate</strong> — send any custom amount (e.g. $10 of $50). Partial payments supported.</li>
                <li>Affiliate receives an email when payment is recorded.</li>
            </ul>
        </div>
    </div>
</div>
@endsection
