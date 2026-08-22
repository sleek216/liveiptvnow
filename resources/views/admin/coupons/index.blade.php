@extends('admin.layouts.app')

@section('title', 'Coupons')

@section('breadcrumb')
    <li class="breadcrumb-item active">Coupons</li>
@endsection

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="page-title">Coupons</h1>
            <p class="text-muted mb-0">Manage discount coupons</p>
        </div>
        <a href="{{ route('admin.coupons.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-2"></i>Create Coupon
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            @if($coupons->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>Code</th>
                                <th>Type</th>
                                <th>Value</th>
                                <th>Usage</th>
                                <th>Expires</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($coupons as $coupon)
                                <tr>
                                    <td>
                                        <strong class="text-primary">{{ $coupon->code }}</strong>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">
                                            {{ ucfirst($coupon->type) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($coupon->type === 'percentage')
                                            {{ $coupon->value }}%
                                        @else
                                            ${{ number_format($coupon->value, 2) }}
                                        @endif
                                    </td>
                                    <td>
                                        {{ $coupon->usage_count }}
                                        @if($coupon->usage_limit)
                                            / {{ $coupon->usage_limit }}
                                        @else
                                            / ∞
                                        @endif
                                    </td>
                                    <td>
                                        @if($coupon->expires_at)
                                            {{ $coupon->expires_at->format('M d, Y') }}
                                        @else
                                            <span class="text-muted">Never</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($coupon->is_active)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-danger">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('admin.coupons.edit', $coupon) }}" class="btn btn-outline-primary">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('admin.coupons.toggle-active', $coupon) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-outline-secondary">
                                                    <i class="bi bi-toggle-{{ $coupon->is_active ? 'on' : 'off' }}"></i>
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.coupons.destroy', $coupon) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $coupons->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-tag" style="font-size: 3rem; color: #cbd5e1;"></i>
                    <h5 class="mt-3">No coupons found</h5>
                    <p class="text-muted">Create your first coupon to get started.</p>
                    <a href="{{ route('admin.coupons.create') }}" class="btn btn-primary mt-2">
                        <i class="bi bi-plus-lg me-2"></i>Create Coupon
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection
