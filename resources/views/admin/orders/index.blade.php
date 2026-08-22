@extends('admin.layouts.app')

@section('title', 'Orders')

@section('breadcrumb')
    <li class="breadcrumb-item active">Orders</li>
@endsection

@push('styles')
<style>
    .bulk-bar {
        display: none;
        background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
        border: none;
        border-radius: 0.75rem;
        color: #fff;
        padding: 0.75rem 1.25rem;
        margin-bottom: 1rem;
        animation: slideDown 0.25s ease;
    }
    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-8px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .bulk-bar .bulk-count {
        font-weight: 600;
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        white-space: nowrap;
    }
    .bulk-bar .bulk-count i {
        font-size: 1.1rem;
    }
    .bulk-bar .bulk-field {
        display: flex;
        align-items: center;
        gap: 0.35rem;
    }
    .bulk-bar .bulk-label {
        font-size: 0.78rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: rgba(255,255,255,0.85);
        white-space: nowrap;
        margin: 0;
    }
    .bulk-bar select {
        background: rgba(255,255,255,0.15);
        border: 1px solid rgba(255,255,255,0.3);
        color: #fff;
        border-radius: 0.5rem;
        padding: 0.4rem 2rem 0.4rem 0.75rem;
        font-size: 0.85rem;
        font-weight: 500;
        cursor: pointer;
        -webkit-appearance: none;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='white' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14L2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 0.65rem center;
    }
    .bulk-bar select:focus {
        outline: none;
        border-color: rgba(255,255,255,0.6);
        box-shadow: 0 0 0 2px rgba(255,255,255,0.2);
    }
    .bulk-bar select option {
        color: #1e293b;
        background: #fff;
    }
    .bulk-bar .btn-bulk-apply {
        background: #fff;
        color: #4f46e5;
        border: none;
        border-radius: 0.5rem;
        padding: 0.4rem 1rem;
        font-size: 0.85rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.15s;
    }
    .bulk-bar .btn-bulk-apply:hover {
        background: #e0e7ff;
    }
    .bulk-bar .btn-bulk-deselect {
        background: rgba(255,255,255,0.15);
        color: #fff;
        border: 1px solid rgba(255,255,255,0.3);
        border-radius: 0.5rem;
        padding: 0.4rem 0.85rem;
        font-size: 0.85rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.15s;
    }
    .bulk-bar .btn-bulk-deselect:hover {
        background: rgba(255,255,255,0.25);
    }

    .orders-table .form-check-input {
        width: 1.1em;
        height: 1.1em;
        margin: 0;
        cursor: pointer;
        border-color: #cbd5e1;
    }
    .orders-table .form-check-input:checked {
        background-color: #6366f1;
        border-color: #6366f1;
    }
    .orders-table thead th {
        background: #f8fafc;
        font-weight: 600;
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        color: #64748b;
        padding: 0.85rem 0.75rem;
        border-bottom: 2px solid #e2e8f0;
        white-space: nowrap;
    }
    .orders-table thead th:first-child {
        padding-left: 1.25rem;
        width: 44px;
    }
    .orders-table tbody td {
        padding: 0.85rem 0.75rem;
        vertical-align: middle;
        font-size: 0.875rem;
        border-bottom: 1px solid #f1f5f9;
    }
    .orders-table tbody td:first-child {
        padding-left: 1.25rem;
    }
    .orders-table tbody tr {
        transition: background 0.15s;
    }
    .orders-table tbody tr:hover {
        background: #f8fafc;
    }
    .orders-table tbody tr.row-selected {
        background: #eef2ff !important;
    }
    .orders-table .order-link {
        color: #6366f1;
        font-weight: 600;
        text-decoration: none;
        font-size: 0.85rem;
    }
    .orders-table .order-link:hover {
        color: #4f46e5;
        text-decoration: underline;
    }
    .orders-table .customer-name {
        font-weight: 600;
        color: #1e293b;
        font-size: 0.85rem;
        margin-bottom: 1px;
    }
    .orders-table .customer-email {
        color: #94a3b8;
        font-size: 0.78rem;
    }
    .orders-table .amount {
        font-weight: 700;
        color: #0f172a;
    }
    .action-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        border-radius: 0.5rem;
        border: 1px solid #e2e8f0;
        background: #fff;
        color: #64748b;
        font-size: 0.85rem;
        transition: all 0.15s;
        text-decoration: none;
    }
    .action-btn:hover {
        background: #f1f5f9;
        color: #4f46e5;
        border-color: #c7d2fe;
    }
    .empty-state {
        padding: 3rem 1rem;
        text-align: center;
        color: #94a3b8;
    }
    .empty-state i {
        font-size: 2.5rem;
        margin-bottom: 0.75rem;
        display: block;
        color: #cbd5e1;
    }

    @media (max-width: 767.98px) {
        .bulk-bar .bulk-inner {
            flex-direction: column;
            align-items: stretch !important;
            gap: 0.5rem !important;
        }
        .bulk-bar .bulk-actions {
            flex-wrap: wrap;
        }
        .orders-table thead th,
        .orders-table tbody td {
            padding: 0.65rem 0.5rem;
            font-size: 0.8rem;
        }
        .filter-row .col-md-4,
        .filter-row .col-md-3,
        .filter-row .col-md-2 {
            flex: 0 0 100%;
            max-width: 100%;
        }
    }
</style>
@endpush

@section('content')
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
        <div>
            <h1 class="page-title">Orders</h1>
            <p class="text-muted mb-0">Manage customer orders</p>
        </div>
        <a href="{{ route('admin.orders.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i>Create Order
        </a>
    </div>

    <!-- Filters -->
    <div class="card mb-4">
        <div class="card-body py-3">
            <form action="{{ route('admin.orders.index') }}" method="GET" class="row g-2 filter-row align-items-end">
                <div class="col-12 col-md-4">
                    <input type="text" name="search" class="form-control" placeholder="Search by order #, name, email..." value="{{ request('search') }}">
                </div>
                <div class="col-6 col-md-3">
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
                <div class="col-6 col-md-3">
                    <select name="payment_status" class="form-select">
                        <option value="">All Payment</option>
                        <option value="pending" {{ request('payment_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="completed" {{ request('payment_status') == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="failed" {{ request('payment_status') == 'failed' ? 'selected' : '' }}>Failed</option>
                        <option value="refunded" {{ request('payment_status') == 'refunded' ? 'selected' : '' }}>Refunded</option>
                    </select>
                </div>
                <div class="col-12 col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-search me-1"></i>Filter
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Bulk Action Bar -->
    <div id="bulkActionBar" class="bulk-bar">
        <form id="bulkActionForm" action="{{ route('admin.orders.bulk-status') }}" method="POST">
            @csrf
            <div id="bulkOrderInputs"></div>
            <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap bulk-inner">
                <div class="bulk-count">
                    <i class="bi bi-check2-square"></i>
                    <span id="selectedCount">0</span> order(s) selected
                </div>
                <div class="d-flex align-items-center gap-2 flex-wrap bulk-actions">
                    <div class="bulk-field">
                        <label class="bulk-label"><i class="bi bi-box-seam me-1"></i>Order:</label>
                        <select name="bulk_order_status" id="bulkOrderStatus">
                            <option value="">Order Status (No change)</option>
                            <option value="pending">Pending</option>
                            <option value="processing">Processing</option>
                            <option value="completed">Completed</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>

                    <div class="bulk-field">
                        <label class="bulk-label"><i class="bi bi-credit-card me-1"></i>Payment:</label>
                        <select name="bulk_payment_status" id="bulkPaymentStatus">
                            <option value="">Payment Status (No change)</option>
                            <option value="pending">Pending</option>
                            <option value="completed">Completed</option>
                            <option value="failed">Failed</option>
                            <option value="refunded">Refunded</option>
                        </select>
                    </div>

                    <button type="submit" class="btn-bulk-apply">
                        <i class="bi bi-check-lg me-1"></i>Apply
                    </button>
                    <button type="button" class="btn-bulk-deselect" id="bulkDeselectAll">
                        <i class="bi bi-x-lg me-1"></i>Clear
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Orders Table -->
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table orders-table mb-0">
                    <thead>
                        <tr>
                            <th>
                                <input type="checkbox" class="form-check-input" id="selectAllOrders" title="Select all">
                            </th>
                            <th>Order #</th>
                            <th>Customer</th>
                            <th>Package</th>
                            <th>Amount</th>
                            <th>Payment</th>
                            <th>Status</th>
                            <th>Email</th>
                            <th>Date</th>
                            <th class="text-end pe-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                            <tr data-order-id="{{ $order->id }}">
                                <td>
                                    <input type="checkbox" class="form-check-input order-checkbox" value="{{ $order->id }}">
                                </td>
                                <td>
                                    <a href="{{ route('admin.orders.show', $order) }}" class="order-link">
                                        {{ $order->order_number }}
                                    </a>
                                </td>
                                <td>
                                    <div class="customer-name">{{ $order->customer_name }}</div>
                                    <div class="customer-email">{{ $order->customer_email }}</div>
                                </td>
                                <td>{{ $order->package->name ?? 'N/A' }}</td>
                                <td><span class="amount">${{ number_format($order->amount, 2) }}</span></td>
                                <td>
                                    <span class="badge bg-{{ $order->payment_badge }}">
                                        {{ ucfirst($order->payment_status) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $order->status_badge }}">
                                        {{ ucfirst($order->order_status) }}
                                    </span>
                                </td>
                                <td>
                                    @if($order->email_sent_at)
                                        <span class="text-success" title="Sent {{ $order->email_sent_at->format('M d, Y') }}"><i class="bi bi-check-circle-fill"></i></span>
                                     @else
                                        <span class="text-muted"><i class="bi bi-dash-circle"></i></span>
                                    @endif
                                </td>
                                <td class="text-muted" style="white-space:nowrap;">{{ $order->created_at->format('M d, Y') }}</td>
                                <td class="text-end pe-3">
                                    <div class="d-flex gap-1 justify-content-end">
                                        <a href="{{ route('admin.orders.invoice', $order) }}" target="_blank" class="action-btn" title="Invoice">
                                            <i class="bi bi-printer"></i>
                                        </a>
                                        <a href="{{ route('admin.orders.show', $order) }}" class="action-btn" title="View details">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10">
                                    <div class="empty-state">
                                        <i class="bi bi-cart"></i>
                                        <div>No orders found.</div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @if($orders->hasPages())
    <div class="mt-4">
        {{ $orders->withQueryString()->links() }}
    </div>
    @endif
@endsection

@push('scripts')
<script>
(function(){
    var selectAll   = document.getElementById('selectAllOrders');
    var checkboxes  = document.querySelectorAll('.order-checkbox');
    var bar         = document.getElementById('bulkActionBar');
    var countEl     = document.getElementById('selectedCount');
    var inputsEl    = document.getElementById('bulkOrderInputs');
    var deselectBtn = document.getElementById('bulkDeselectAll');
    var form        = document.getElementById('bulkActionForm');

    if (!selectAll || checkboxes.length === 0) return;

    function getSelected(){
        return document.querySelectorAll('.order-checkbox:checked');
    }

    function updateBar(){
        var selected = getSelected();
        var count = selected.length;
        countEl.textContent = count;
        bar.style.display = count > 0 ? 'block' : 'none';

        inputsEl.innerHTML = '';
        selected.forEach(function(cb){
            var inp = document.createElement('input');
            inp.type = 'hidden';
            inp.name = 'order_ids[]';
            inp.value = cb.value;
            inputsEl.appendChild(inp);
        });

        selectAll.checked = checkboxes.length > 0 && count === checkboxes.length;
        selectAll.indeterminate = count > 0 && count < checkboxes.length;
    }

    selectAll.addEventListener('change', function(){
        checkboxes.forEach(function(cb){
            cb.checked = selectAll.checked;
            cb.closest('tr').classList.toggle('row-selected', selectAll.checked);
        });
        updateBar();
    });

    checkboxes.forEach(function(cb){
        cb.addEventListener('change', function(){
            this.closest('tr').classList.toggle('row-selected', this.checked);
            updateBar();
        });
    });

    deselectBtn.addEventListener('click', function(){
        checkboxes.forEach(function(cb){
            cb.checked = false;
            cb.closest('tr').classList.remove('row-selected');
        });
        selectAll.checked = false;
        selectAll.indeterminate = false;
        updateBar();
    });

    form.addEventListener('submit', function(e){
        var selected = getSelected();
        if(selected.length === 0){
            e.preventDefault();
            alert('Please select at least one order.');
            return;
        }

        var orderSelect = form.querySelector('[name="bulk_order_status"]');
        var paymentSelect = form.querySelector('[name="bulk_payment_status"]');

        var orderVal = orderSelect.value;
        var paymentVal = paymentSelect.value;

        if(!orderVal && !paymentVal){
            e.preventDefault();
            alert('Please select at least one status (Order Status or Payment Status) to apply.');
            return;
        }

        var labels = [];
        if(orderVal){
            labels.push('Order Status to "' + orderSelect.options[orderSelect.selectedIndex].text + '"');
        }
        if(paymentVal){
            labels.push('Payment Status to "' + paymentSelect.options[paymentSelect.selectedIndex].text + '"');
        }

        if(!confirm('Update ' + labels.join(' and ') + ' for ' + selected.length + ' order(s)?')){
            e.preventDefault();
        }
    });
})();
</script>
@endpush

