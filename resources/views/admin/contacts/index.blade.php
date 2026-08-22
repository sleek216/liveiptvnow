@extends('admin.layouts.app')

@section('title', 'Contact Messages')

@section('breadcrumb')
    <li class="breadcrumb-item active">Contacts</li>
@endsection

@push('styles')
<style>
    .stat-card-mini {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 0.75rem;
        padding: 1.25rem;
        transition: all 0.2s ease;
        box-shadow: 0 1px 3px rgba(0,0,0,0.03);
    }
    .stat-card-mini:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.06);
    }
    .stat-card-mini .stat-icon {
        width: 46px;
        height: 46px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.35rem;
        flex-shrink: 0;
    }
    .stat-card-mini .stat-val {
        font-size: 1.6rem;
        font-weight: 800;
        color: #0f172a;
        line-height: 1;
        margin-bottom: 0.25rem;
    }
    .stat-card-mini .stat-lbl {
        font-size: 0.8rem;
        font-weight: 600;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .contacts-table thead th {
        background: #f8fafc;
        font-weight: 600;
        font-size: 0.72rem;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        color: #64748b;
        padding: 0.85rem 1rem;
        border-bottom: 2px solid #e2e8f0;
        white-space: nowrap;
    }
    .contacts-table tbody td {
        padding: 0.95rem 1rem;
        vertical-align: middle;
        font-size: 0.875rem;
        border-bottom: 1px solid #f1f5f9;
    }
    .contacts-table tbody tr {
        transition: background 0.15s ease;
    }
    .contacts-table tbody tr:hover {
        background: #f8fafc;
    }
    .contacts-table tbody tr.row-unread {
        background: #fffbeb;
    }
    .contacts-table tbody tr.row-unread:hover {
        background: #fef3c7;
    }

    .contact-avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: rgba(99, 102, 241, 0.1);
        color: #6366f1;
        font-weight: 700;
        font-size: 0.85rem;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .contact-name {
        font-weight: 600;
        color: #1e293b;
        font-size: 0.875rem;
        margin-bottom: 1px;
    }
    .contact-phone {
        color: #94a3b8;
        font-size: 0.78rem;
    }
    .contact-email {
        color: #4f46e5;
        font-size: 0.85rem;
        text-decoration: none;
        word-break: break-all;
    }
    .contact-email:hover {
        text-decoration: underline;
    }

    .subject-pill {
        display: inline-block;
        max-width: 220px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        font-size: 0.82rem;
        font-weight: 600;
        background: #f1f5f9;
        color: #334155;
        padding: 4px 10px;
        border-radius: 6px;
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
    .action-btn.text-danger:hover {
        background: #fee2e2;
        color: #dc2626;
        border-color: #fca5a5;
    }

    .pagination-wrap {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem 1.25rem;
        border-top: 1px solid #e2e8f0;
        background: #fff;
        border-bottom-left-radius: 0.75rem;
        border-bottom-right-radius: 0.75rem;
        flex-wrap: wrap;
        gap: 1rem;
    }
    .pagination-wrap .pagination {
        margin: 0;
    }

    @media (max-width: 767.98px) {
        .contacts-table thead th,
        .contacts-table tbody td {
            padding: 0.65rem 0.5rem;
            font-size: 0.8rem;
        }
        .pagination-wrap {
            flex-direction: column;
            align-items: center;
            text-align: center;
        }
    }
</style>
@endpush

@section('content')
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
        <div>
            <h1 class="page-title">Contact Messages</h1>
            <p class="text-muted mb-0">Manage customer inquiries and support requests</p>
        </div>
        <div class="d-flex gap-2 align-items-center">
            @if(($stats['new'] ?? 0) > 0)
            <form action="{{ route('admin.contacts.mark-all-read') }}" method="POST" class="m-0">
                @csrf
                <button type="submit" class="btn btn-outline-secondary" title="Mark all new contact messages as read">
                    <i class="bi bi-check2-all me-1"></i>Mark All Read
                </button>
            </form>
            @endif
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="stat-card-mini">
                <div class="d-flex align-items-center gap-3">
                    <div class="stat-icon bg-primary bg-opacity-10 text-primary">
                        <i class="bi bi-envelope-fill"></i>
                    </div>
                    <div>
                        <div class="stat-val">{{ $stats['total'] }}</div>
                        <div class="stat-lbl">Total Messages</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="stat-card-mini">
                <div class="d-flex align-items-center gap-3">
                    <div class="stat-icon bg-warning bg-opacity-10 text-warning">
                        <i class="bi bi-envelope-exclamation-fill"></i>
                    </div>
                    <div>
                        <div class="stat-val text-warning">{{ $stats['new'] }}</div>
                        <div class="stat-lbl">New Messages</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="stat-card-mini">
                <div class="d-flex align-items-center gap-3">
                    <div class="stat-icon bg-info bg-opacity-10 text-info">
                        <i class="bi bi-envelope-open-fill"></i>
                    </div>
                    <div>
                        <div class="stat-val">{{ $stats['read'] }}</div>
                        <div class="stat-lbl">Read</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="stat-card-mini">
                <div class="d-flex align-items-center gap-3">
                    <div class="stat-icon bg-success bg-opacity-10 text-success">
                        <i class="bi bi-envelope-check-fill"></i>
                    </div>
                    <div>
                        <div class="stat-val text-success">{{ $stats['replied'] }}</div>
                        <div class="stat-lbl">Replied</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Search & Filter Card -->
    <div class="card mb-4">
        <div class="card-body py-3">
            <form method="GET" action="{{ route('admin.contacts.index') }}" class="row g-2 align-items-end">
                <div class="col-12 col-md-5">
                    <input type="text" name="search" class="form-control" placeholder="Search by name, email, subject, message..." value="{{ request('search') }}">
                </div>
                <div class="col-6 col-md-3">
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="new" {{ request('status') == 'new' ? 'selected' : '' }}>New (Unread)</option>
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
                <div class="col-3 col-md-2">
                    <a href="{{ route('admin.contacts.index') }}" class="btn btn-outline-secondary w-100">
                        <i class="bi bi-arrow-clockwise me-1"></i>Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Contacts Table Card -->
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table contacts-table mb-0">
                    <thead>
                        <tr>
                            <th style="width: 60px;">ID</th>
                            <th>Customer</th>
                            <th>Email</th>
                            <th>Subject</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th class="text-end pe-3" style="width: 100px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($contacts as $contact)
                        <tr class="{{ $contact->status === 'new' ? 'row-unread' : '' }}">
                            <td><strong class="text-secondary">#{{ $contact->id }}</strong></td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="contact-avatar">
                                        {{ strtoupper(substr($contact->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="contact-name">{{ $contact->name }}</div>
                                        @if($contact->phone)
                                        <div class="contact-phone"><i class="bi bi-telephone me-1"></i>{{ $contact->phone }}</div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td>
                                <a href="mailto:{{ $contact->email }}" class="contact-email">
                                    {{ $contact->email }}
                                </a>
                            </td>
                            <td>
                                <span class="subject-pill" title="{{ $contact->subject }}">
                                    {{ $contact->subject }}
                                </span>
                            </td>
                            <td>
                                @if($contact->status === 'new')
                                    <span class="badge bg-warning text-dark"><i class="bi bi-record-fill me-1"></i>New</span>
                                @elseif($contact->status === 'read')
                                    <span class="badge bg-info bg-opacity-10 text-info">Read</span>
                                @elseif($contact->status === 'replied')
                                    <span class="badge bg-success bg-opacity-10 text-success"><i class="bi bi-check-all me-1"></i>Replied</span>
                                @else
                                    <span class="badge bg-secondary bg-opacity-10 text-secondary">Closed</span>
                                @endif
                            </td>
                            <td>
                                <div class="text-dark fw-medium">{{ $contact->created_at->format('M d, Y') }}</div>
                                <small class="text-muted">{{ $contact->created_at->format('h:i A') }}</small>
                            </td>
                            <td class="text-end pe-3">
                                <div class="d-flex gap-1 justify-content-end">
                                    <a href="{{ route('admin.contacts.show', $contact) }}" class="action-btn" title="View details">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <form action="{{ route('admin.contacts.destroy', $contact) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this contact message?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="action-btn text-danger" title="Delete">
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
                                    <i class="bi bi-inbox fs-1 d-block mb-2 text-secondary opacity-50"></i>
                                    <p class="mb-0 fw-medium">No contact messages found</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Clean Bottom Pagination Bar -->
            @if($contacts->hasPages())
            <div class="pagination-wrap">
                <div class="text-muted small">
                    Showing <strong>{{ $contacts->firstItem() }}</strong> to <strong>{{ $contacts->lastItem() }}</strong> of <strong>{{ $contacts->total() }}</strong> messages
                </div>
                <div>
                    {{ $contacts->withQueryString()->links() }}
                </div>
            </div>
            @endif
        </div>
    </div>
@endsection
