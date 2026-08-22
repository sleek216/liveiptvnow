@extends('admin.layouts.app')

@section('title', 'Order Details')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.orders.index') }}">Orders</a></li>
    <li class="breadcrumb-item active">{{ $order->order_number }}</li>
@endsection

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="page-title">Order {{ $order->order_number }}</h1>
            <p class="text-muted mb-0">Created {{ $order->created_at->format('M d, Y H:i') }}</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.orders.invoice', $order) }}" target="_blank" class="btn btn-outline-primary">
                <i class="bi bi-printer me-2"></i>Invoice
            </a>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-2"></i>Back to Orders
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <!-- Order Info -->
            <div class="card mb-4">
                <div class="card-header">
                    <span>Order Details</span>
                    <div class="d-flex gap-1 flex-wrap">
                        <span class="badge bg-{{ $order->payment_badge }}">Payment: {{ ucfirst($order->payment_status) }}</span>
                        <span class="badge bg-{{ $order->status_badge }}">Status: {{ ucfirst($order->order_status) }}</span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Customer Name</label>
                            <div class="fw-medium">{{ $order->customer_name }}</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Email</label>
                            <div class="fw-medium">{{ $order->customer_email }}</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Phone</label>
                            <div>{{ $order->customer_phone ?? 'N/A' }}</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Payment Method</label>
                            <div>{{ ucfirst($order->payment_method) }}</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Package</label>
                            <div class="fw-medium">{{ $order->package->name ?? 'N/A' }}</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Amount</label>
                            <div class="fw-bold text-success fs-5">${{ number_format($order->amount, 2) }}</div>
                        </div>
                    </div>

                    @if($order->selected_countries)
                        <hr>
                        <label class="text-muted small">Selected Countries</label>
                        <div class="d-flex flex-wrap gap-2 mt-1">
                            @foreach($order->countries as $country)
                                <span class="badge bg-light text-dark">{{ $country->name }}</span>
                            @endforeach
                        </div>
                    @endif

                    @if($order->notes)
                        <hr>
                        <label class="text-muted small">Customer Notes</label>
                        <div>{{ $order->notes }}</div>
                    @endif

                    @if($order->stripe_payment_id)
                        <hr>
                        <label class="text-muted small">Stripe Payment ID</label>
                        <div><code>{{ $order->stripe_payment_id }}</code></div>
                    @endif

                    @if($order->portal_url)
                        <hr>
                        <label class="text-muted small">Portal URL</label>
                        <div><code>{{ $order->portal_url }}</code></div>
                    @endif
                </div>
            </div>

            <!-- Update Status -->
            <div class="card mb-4">
                <div class="card-header">Update Order</div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12 col-md-6">
                            <form action="{{ route('admin.orders.update-status', $order) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <label class="form-label">Order Status</label>
                                <div class="input-group">
                                    <select name="order_status" class="form-select">
                                        <option value="pending" {{ $order->order_status == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="processing" {{ $order->order_status == 'processing' ? 'selected' : '' }}>Processing</option>
                                        <option value="completed" {{ $order->order_status == 'completed' ? 'selected' : '' }}>Completed</option>
                                        <option value="cancelled" {{ $order->order_status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    </select>
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </form>
                        </div>
                        <div class="col-12 col-md-6">
                            <form action="{{ route('admin.orders.update-payment-status', $order) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <label class="form-label">Payment Status</label>
                                <div class="input-group">
                                    <select name="payment_status" class="form-select">
                                        <option value="pending" {{ $order->payment_status == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="completed" {{ $order->payment_status == 'completed' ? 'selected' : '' }}>Completed</option>
                                        <option value="failed" {{ $order->payment_status == 'failed' ? 'selected' : '' }}>Failed</option>
                                        <option value="refunded" {{ $order->payment_status == 'refunded' ? 'selected' : '' }}>Refunded</option>
                                    </select>
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="mt-3">
                        <form action="{{ route('admin.orders.update-status', $order) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="order_status" value="{{ $order->order_status }}">
                            <label class="form-label">Admin Notes</label>
                            <textarea name="admin_notes" class="form-control" rows="2">{{ $order->admin_notes }}</textarea>
                            <button type="submit" class="btn btn-outline-primary mt-2">Save Notes</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Send Email -->
            <div class="card">
                <div class="card-header">
                    Send Email to Customer
                    @if($order->email_sent_at)
                        <span class="badge bg-success ms-2">Last sent: {{ $order->email_sent_at->format('M d, Y H:i') }}</span>
                    @endif
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.orders.send-email', $order) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Subject *</label>
                            <input type="text" name="subject" class="form-control" value="Your IPTV Subscription Details - {{ $order->order_number }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Message *</label>
                            <textarea name="message" class="form-control" rows="4" required>Thank you for your purchase! Here are your subscription details.</textarea>
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="include_credentials" name="include_credentials" value="1">
                            <label class="form-check-label" for="include_credentials">Include IPTV Credentials</label>
                        </div>
                        <div id="credentials-fields" style="display: none;">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Username</label>
                                    <input type="text" name="username" class="form-control">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Password</label>
                                    <input type="text" name="password" class="form-control">
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="form-label">M3U URL</label>
                                    <input type="text" name="m3u_url" class="form-control">
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="form-label">Portal URL</label>
                                    <input type="text" name="portal_url" class="form-control" value="{{ $order->portal_url }}">
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-envelope me-2"></i>Send Email
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- User Info -->
            @if($order->user)
                <div class="card mb-4">
                    <div class="card-header">Customer Account</div>
                    <div class="card-body">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="user-avatar" style="width: 48px; height: 48px; font-size: 1.25rem;">
                                {{ substr($order->user->name, 0, 1) }}
                            </div>
                            <div>
                                <div class="fw-medium">{{ $order->user->name }}</div>
                                <small class="text-muted">{{ $order->user->email }}</small>
                            </div>
                        </div>
                        <a href="{{ route('admin.users.show', $order->user) }}" class="btn btn-outline-primary btn-sm w-100">
                            View Profile
                        </a>
                    </div>
                </div>
            @endif

            <!-- Subscription Info -->
            <div class="card mb-4">
                <div class="card-header">Subscription</div>
                <div class="card-body">
                    @if($order->activated_at)
                        <div class="mb-2">
                            <small class="text-muted">Activated</small>
                            <div>{{ $order->activated_at->format('M d, Y H:i') }}</div>
                        </div>
                    @endif
                    @if($order->expires_at)
                        <div class="mb-2">
                            <small class="text-muted">Expires</small>
                            <div>{{ $order->expires_at->format('M d, Y H:i') }}</div>
                        </div>
                        <div>
                            @if($order->is_active)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-danger">Expired</span>
                            @endif
                        </div>
                    @else
                        <p class="text-muted mb-0">Not activated yet</p>
                    @endif
                </div>
            </div>

            <!-- Danger Zone -->
            <div class="card border-danger">
                <div class="card-header text-danger">Danger Zone</div>
                <div class="card-body">
                    <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this order? This action cannot be undone.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger w-100">
                            <i class="bi bi-trash me-2"></i>Delete Order
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
document.getElementById('include_credentials').addEventListener('change', function() {
    document.getElementById('credentials-fields').style.display = this.checked ? 'block' : 'none';
});
</script>
@endpush
