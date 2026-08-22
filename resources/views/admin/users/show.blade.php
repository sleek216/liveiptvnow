@extends('admin.layouts.app')

@section('title', 'User Details')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Users</a></li>
    <li class="breadcrumb-item active">{{ $user->name }}</li>
@endsection

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="page-title">{{ $user->name }}</h1>
            <p class="text-muted mb-0">{{ $user->email }}</p>
        </div>
        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Back to Users
        </a>
    </div>

    <div class="row">
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-body text-center">
                    <div class="user-avatar mx-auto mb-3" style="width: 80px; height: 80px; font-size: 2rem;">
                        {{ substr($user->name, 0, 1) }}
                    </div>
                    <h5>{{ $user->name }}</h5>
                    <p class="text-muted mb-2">{{ $user->email }}</p>
                    @if($user->is_admin)
                        <span class="badge bg-danger">Admin</span>
                    @else
                        <span class="badge bg-secondary">User</span>
                    @endif
                </div>
                <div class="card-footer bg-transparent">
                    <div class="row text-center">
                        <div class="col">
                            <div class="fw-bold">{{ $user->orders->count() }}</div>
                            <small class="text-muted">Orders</small>
                        </div>
                        <div class="col">
                            <div class="fw-bold">${{ number_format($user->orders->sum('amount'), 2) }}</div>
                            <small class="text-muted">Spent</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">Details</div>
                <div class="card-body">
                    <div class="mb-2">
                        <small class="text-muted">Phone</small>
                        <div>{{ $user->phone ?? 'Not provided' }}</div>
                    </div>
                    <div class="mb-2">
                        <small class="text-muted">Country</small>
                        <div>{{ $user->country ?? 'Not provided' }}</div>
                    </div>
                    <div class="mb-2">
                        <small class="text-muted">Last Login</small>
                        <div>{{ $user->last_login_at ? $user->last_login_at->format('M d, Y H:i') : 'Never' }}</div>
                    </div>
                    <div>
                        <small class="text-muted">Joined</small>
                        <div>{{ $user->created_at->format('M d, Y') }}</div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">Affiliate Commission Rate</div>
                <div class="card-body">
                    <form action="{{ route('admin.users.update-commission-rate', $user) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Custom Commission Rate (%)</label>
                            <input 
                                type="number" 
                                name="custom_commission_rate" 
                                class="form-control @error('custom_commission_rate') is-invalid @enderror" 
                                value="{{ $user->affiliate->custom_commission_rate ?? '' }}"
                                placeholder="Leave empty for default rate"
                                step="0.01"
                                min="0"
                                max="100"
                            >
                            @error('custom_commission_rate')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">
                                @if($user->affiliate && $user->affiliate->custom_commission_rate)
                                    Current: {{ $user->affiliate->custom_commission_rate }}% (Custom)
                                @else
                                    Current: {{ \App\Models\Setting::get('affiliate_commission_rate', 20) }}% (Default)
                                @endif
                            </small>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-percent me-2"></i>Update Commission Rate
                        </button>
                    </form>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">Reset Password</div>
                <div class="card-body">
                    <form action="{{ route('admin.users.reset-password', $user) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">New Password</label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-warning w-100">
                            <i class="bi bi-key me-2"></i>Reset Password
                        </button>
                    </form>
                </div>
            </div>

            @if($user->id !== auth()->id())
                <div class="card border-danger">
                    <div class="card-header text-danger">Danger Zone</div>
                    <div class="card-body">
                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger w-100">
                                <i class="bi bi-trash me-2"></i>Delete User
                            </button>
                        </form>
                    </div>
                </div>
            @endif
        </div>

        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">Order History</div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Order #</th>
                                    <th>Package</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($user->orders as $order)
                                    <tr>
                                        <td>
                                            <a href="{{ route('admin.orders.show', $order) }}" class="text-decoration-none fw-medium">
                                                {{ $order->order_number }}
                                            </a>
                                        </td>
                                        <td>{{ $order->package->name ?? 'N/A' }}</td>
                                        <td>${{ number_format($order->amount, 2) }}</td>
                                        <td>
                                            <span class="badge bg-{{ $order->status_badge }}">
                                                {{ ucfirst($order->order_status) }}
                                            </span>
                                        </td>
                                        <td>{{ $order->created_at->format('M d, Y') }}</td>
                                        <td>
                                            <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4 text-muted">No orders yet</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
