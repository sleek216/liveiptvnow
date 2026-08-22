@extends('admin.layouts.app')

@section('title', 'Contact Messages')

@section('breadcrumb')
<li class="breadcrumb-item active">Contacts</li>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="page-title">Contact Messages</h1>
        <p class="text-muted mb-0">Manage customer inquiries and support requests</p>
    </div>
</div>

<!-- Stats Cards -->
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="stat-icon bg-primary bg-opacity-10 text-primary">
                            <i class="bi bi-envelope-fill"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <div class="stat-value">{{ $stats['total'] }}</div>
                        <div class="stat-label text-muted">Total</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="stat-icon bg-warning bg-opacity-10 text-warning">
                            <i class="bi bi-envelope-exclamation"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <div class="stat-value">{{ $stats['new'] }}</div>
                        <div class="stat-label text-muted">New</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="stat-icon bg-info bg-opacity-10 text-info">
                            <i class="bi bi-envelope-open"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <div class="stat-value">{{ $stats['read'] }}</div>
                        <div class="stat-label text-muted">Read</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="stat-icon bg-success bg-opacity-10 text-success">
                            <i class="bi bi-envelope-check"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <div class="stat-value">{{ $stats['replied'] }}</div>
                        <div class="stat-label text-muted">Replied</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filters -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.contacts.index') }}" class="row g-2">
            <div class="col-12 col-md-4">
                <input type="text" name="search" class="form-control" placeholder="Search by name, email, subject..." value="{{ request('search') }}">
            </div>
            <div class="col-6 col-md-3">
                <select name="status" class="form-select">
                    <option value="">All Status</option>
                    <option value="new" {{ request('status') == 'new' ? 'selected' : '' }}>New</option>
                    <option value="read" {{ request('status') == 'read' ? 'selected' : '' }}>Read</option>
                    <option value="replied" {{ request('status') == 'replied' ? 'selected' : '' }}>Replied</option>
                    <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Closed</option>
                </select>
            </div>
            <div class="col-3 col-md-2">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-search me-1"></i>Filter
                </button>
            </div>
            <div class="col-3 col-md-3">
                <a href="{{ route('admin.contacts.index') }}" class="btn btn-outline-secondary w-100">
                    <i class="bi bi-arrow-clockwise me-1"></i>Reset
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Contacts Table -->
<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Subject</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($contacts as $contact)
                    <tr>
                        <td><strong>#{{ $contact->id }}</strong></td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-2">
                                    {{ substr($contact->name, 0, 1) }}
                                </div>
                                <div>
                                    <div class="fw-semibold">{{ $contact->name }}</div>
                                    @if($contact->phone)
                                    <small class="text-muted">{{ $contact->phone }}</small>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td>
                            <a href="mailto:{{ $contact->email }}" class="text-decoration-none">
                                {{ $contact->email }}
                            </a>
                        </td>
                        <td>
                            <span class="badge bg-light text-dark">{{ $contact->subject }}</span>
                        </td>
                        <td>
                            @if($contact->status === 'new')
                                <span class="badge bg-warning">New</span>
                            @elseif($contact->status === 'read')
                                <span class="badge bg-info">Read</span>
                            @elseif($contact->status === 'replied')
                                <span class="badge bg-success">Replied</span>
                            @else
                                <span class="badge bg-secondary">Closed</span>
                            @endif
                        </td>
                        <td>
                            <div>{{ $contact->created_at->format('M d, Y') }}</div>
                            <small class="text-muted">{{ $contact->created_at->format('h:i A') }}</small>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.contacts.show', $contact) }}" class="btn btn-outline-primary" title="View">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <form action="{{ route('admin.contacts.destroy', $contact) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this contact?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger" title="Delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <div class="text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                <p class="mb-0">No contact messages found</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($contacts->hasPages())
    <div class="card-footer">
        {{ $contacts->links() }}
    </div>
    @endif
</div>
@endsection

@push('styles')
<style>
    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
    }
    .stat-value {
        font-size: 1.5rem;
        font-weight: 700;
        color: #0f172a;
    }
    .stat-label {
        font-size: 0.875rem;
    }
    .avatar-sm {
        width: 36px;
        height: 36px;
        font-size: 0.875rem;
        font-weight: 600;
    }
</style>
@endpush
