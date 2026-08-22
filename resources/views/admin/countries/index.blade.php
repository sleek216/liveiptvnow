@extends('admin.layouts.app')

@section('title', 'Countries')

@section('breadcrumb')
    <li class="breadcrumb-item active">Countries</li>
@endsection

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="page-title">Countries</h1>
            <p class="text-muted mb-0">Manage available countries for packages</p>
        </div>
        <a href="{{ route('admin.countries.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-2"></i>Add Country
        </a>
    </div>

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Country</th>
                            <th>Code</th>
                            <th>Flag</th>
                            <th>Status</th>
                            <th>Sort Order</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($countries as $country)
                            <tr>
                                <td class="fw-medium">{{ $country->name }}</td>
                                <td><code>{{ $country->code }}</code></td>
                                <td>
                                    @if($country->flag)
                                        {{ $country->flag }}
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($country->is_active)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-secondary">Inactive</span>
                                    @endif
                                </td>
                                <td>{{ $country->sort_order }}</td>
                                <td class="text-end">
                                    <div class="btn-group">
                                        <a href="{{ route('admin.countries.edit', $country) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('admin.countries.toggle-active', $country) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-{{ $country->is_active ? 'warning' : 'success' }}">
                                                <i class="bi bi-{{ $country->is_active ? 'pause' : 'play' }}"></i>
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.countries.destroy', $country) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this country?')">
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
                                <td colspan="6" class="text-center py-4 text-muted">
                                    <i class="bi bi-globe fs-1 d-block mb-2"></i>
                                    No countries found. <a href="{{ route('admin.countries.create') }}">Add one</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="mt-4">
        {{ $countries->links() }}
    </div>
@endsection
