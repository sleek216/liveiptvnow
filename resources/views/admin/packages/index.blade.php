@extends('admin.layouts.app')

@section('title', 'Packages')

@section('breadcrumb')
    <li class="breadcrumb-item active">Packages</li>
@endsection

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="page-title">Packages</h1>
            <p class="text-muted mb-0">Manage your subscription packages</p>
        </div>
        <a href="{{ route('admin.packages.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-2"></i>Add Package
        </a>
    </div>

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Package</th>
                            <th>Price</th>
                            <th>Duration</th>
                            <th>Connections</th>
                            <th>Orders</th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($packages as $package)
                            <tr>
                                <td>
                                    <div class="fw-medium">{{ $package->name }}</div>
                                    @if($package->is_featured)
                                        <span class="badge bg-warning text-dark">Featured</span>
                                    @endif
                                    @if($package->is_trial)
                                        <span class="badge bg-info">Trial</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="fw-bold text-success">${{ number_format($package->price, 2) }}</span>
                                    @if($package->original_price)
                                        <br><small class="text-muted text-decoration-line-through">${{ number_format($package->original_price, 2) }}</small>
                                    @endif
                                </td>
                                <td>{{ $package->duration_label ?? ($package->duration_months ? $package->duration_months . ' months' : ($package->duration_days . ' days')) }}</td>
                                <td>{{ $package->connections }}</td>
                                <td>{{ $package->orders_count }}</td>
                                <td>
                                    @if($package->is_active)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-secondary">Inactive</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <div class="btn-group">
                                        <a href="{{ route('admin.packages.edit', $package) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('admin.packages.toggle-active', $package) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-{{ $package->is_active ? 'warning' : 'success' }}" title="{{ $package->is_active ? 'Deactivate' : 'Activate' }}">
                                                <i class="bi bi-{{ $package->is_active ? 'pause' : 'play' }}"></i>
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.packages.destroy', $package) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this package?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">
                                    <i class="bi bi-box-seam fs-1 d-block mb-2"></i>
                                    No packages found. <a href="{{ route('admin.packages.create') }}">Create one</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="mt-4">
        {{ $packages->links() }}
    </div>
@endsection
