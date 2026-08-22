@extends('admin.layouts.app')

@section('title', 'Edit Order ' . $order->order_number)

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.orders.index') }}">Orders</a></li>
    <li class="breadcrumb-item active">Edit Order</li>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">Edit Order: {{ $order->order_number }}</div>
            <div class="card-body">
                <form action="{{ route('admin.orders.update', $order) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label class="form-label">Customer</label>
                        <input type="text" class="form-control" value="{{ $order->customer_name }} ({{ $order->customer_email }})" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Package</label>
                        <input type="text" class="form-control" value="{{ $order->package->name ?? 'Custom Order' }}" readonly>
                    </div>

                    <!-- Adjustment -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Base Price (Package)</label>
                            <input type="text" class="form-control" value="{{ $order->package ? $order->package->price : $order->amount }}" readonly id="base_price">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Adjustment Amount ($)</label>
                            <input type="number" name="adjustment_amount" id="adjustment_amount" class="form-control" step="0.01" value="{{ $order->adjustment_amount }}">
                            <small class="text-muted">Enter positive (e.g. 2 for +$2) or negative (e.g. -2 for -$2 discount)</small>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Current Total: <span id="total_price_display" class="text-success">${{ number_format($order->amount, 2) }}</span></label>
                        @if($order->package)
                        <small class="d-block text-muted">Calculated as: Package (${{ $order->package->price }}) + Adjustment</small>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Coupon Code</label>
                        <input type="text" name="coupon_code" class="form-control" value="{{ $order->coupon_code }}">
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Order Status</label>
                            <select name="order_status" class="form-select">
                                <option value="pending" {{ $order->order_status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="processing" {{ $order->order_status == 'processing' ? 'selected' : '' }}>Processing</option>
                                <option value="completed" {{ $order->order_status == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled" {{ $order->order_status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Payment Status</label>
                            <select name="payment_status" class="form-select">
                                <option value="pending" {{ $order->payment_status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="completed" {{ $order->payment_status == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="failed" {{ $order->payment_status == 'failed' ? 'selected' : '' }}>Failed</option>
                                <option value="refunded" {{ $order->payment_status == 'refunded' ? 'selected' : '' }}>Refunded</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Admin Notes</label>
                        <textarea name="admin_notes" class="form-control" rows="3">{{ $order->admin_notes }}</textarea>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-outline-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">Update Order Details</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const basePrice = parseFloat(document.getElementById('base_price').value);
    const adjustmentInput = document.getElementById('adjustment_amount');
    const totalPriceDisplay = document.getElementById('total_price_display');

    adjustmentInput.addEventListener('input', function() {
        const adj = parseFloat(this.value || 0);
        const total = basePrice + adj;
        totalPriceDisplay.textContent = '$' + total.toFixed(2);
    });
</script>
@endpush
