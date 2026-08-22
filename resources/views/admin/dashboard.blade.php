@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('breadcrumb')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')
    <div class="mb-4 d-flex justify-content-between align-items-center">
        <div>
            <h1 class="page-title">Dashboard</h1>
            <p class="text-muted">Welcome back, {{ auth()->user()->name }}!</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <label for="revenue_period" class="text-muted small fw-medium text-nowrap">Filter Revenue:</label>
            <form action="{{ route('admin.dashboard') }}" method="GET" id="filterForm">
                <select name="revenue_period" id="revenue_period" class="form-select form-select-sm" onchange="this.form.submit()" style="min-width: 140px;">
                    <option value="all" {{ $period == 'all' ? 'selected' : '' }}>All Time</option>
                    <option value="1_week" {{ $period == '1_week' ? 'selected' : '' }}>Last 7 Days</option>
                    <option value="1_month" {{ $period == '1_month' ? 'selected' : '' }}>Last 30 Days</option>
                    <option value="3_months" {{ $period == '3_months' ? 'selected' : '' }}>Last 3 Months</option>
                    <option value="6_months" {{ $period == '6_months' ? 'selected' : '' }}>Last 6 Months</option>
                </select>
            </form>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-xl-3">
            <div class="stat-card">
                <div class="stat-value">${{ number_format($stats['filtered_revenue'], 2) }}</div>
                <div class="stat-label">
                    @if($period == 'all')
                        Total Revenue
                    @else
                        Revenue ({{ str_replace('_', ' ', $period) }})
                    @endif
                </div>
            </div>
        </div>
        <div class="col-6 col-xl-3">
            <div class="stat-card green">
                <div class="stat-value">{{ $stats['total_orders'] }}</div>
                <div class="stat-label">Total Orders</div>
            </div>
        </div>
        <div class="col-6 col-xl-3">
            <div class="stat-card orange">
                <div class="stat-value">{{ $stats['pending_orders'] }}</div>
                <div class="stat-label">Pending Orders</div>
            </div>
        </div>
        <div class="col-6 col-xl-3">
            <div class="stat-card red">
                <div class="stat-value">{{ $stats['total_users'] }}</div>
                <div class="stat-label">Total Users</div>
            </div>
        </div>
    </div>

    <!-- Monthly Revenue -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-xl-4">
            <div class="card h-100">
                <div class="card-body">
                    <h6 class="text-muted mb-2" style="font-size:0.8rem;">This Month Revenue</h6>
                    <h2 class="mb-0">${{ number_format($monthlyRevenue, 2) }}</h2>
                </div>
            </div>
        </div>
        <div class="col-6 col-xl-4">
            <div class="card h-100">
                <div class="card-body">
                    <h6 class="text-muted mb-2" style="font-size:0.8rem;">Active Packages</h6>
                    <h2 class="mb-0">{{ $stats['active_packages'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-12 col-xl-4">
            <div class="card h-100">
                <div class="card-body">
                    <h6 class="text-muted mb-2" style="font-size:0.8rem;">Completed Orders</h6>
                    <h2 class="mb-0">{{ $stats['completed_orders'] }}</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Recent Orders -->
        <div class="col-xl-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Recent Orders</span>
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Order #</th>
                                    <th>Customer</th>
                                    <th>Package</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentOrders as $order)
                                    <tr>
                                        <td>
                                            <a href="{{ route('admin.orders.show', $order) }}" class="text-decoration-none fw-medium">
                                                {{ $order->order_number }}
                                            </a>
                                        </td>
                                        <td>
                                            <div>{{ $order->customer_name }}</div>
                                            <small class="text-muted">{{ $order->customer_email }}</small>
                                        </td>
                                        <td>{{ $order->package->name ?? 'N/A' }}</td>
                                        <td>${{ number_format($order->amount, 2) }}</td>
                                        <td>
                                            <span class="badge bg-{{ $order->status_badge }}">
                                                {{ ucfirst($order->order_status) }}
                                            </span>
                                        </td>
                                        <td>{{ $order->created_at->format('M d, Y') }}</td>
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

        <!-- Recent Users -->
        <div class="col-xl-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Recent Users</span>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        @forelse($recentUsers as $user)
                            <li class="list-group-item d-flex align-items-center gap-3">
                                <div class="user-avatar">{{ substr($user->name, 0, 1) }}</div>
                                <div class="flex-grow-1">
                                    <div class="fw-medium">{{ $user->name }}</div>
                                    <small class="text-muted">{{ $user->email }}</small>
                                </div>
                                <small class="text-muted">{{ $user->created_at->diffForHumans() }}</small>
                            </li>
                        @empty
                            <li class="list-group-item text-center py-4 text-muted">No users yet</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
