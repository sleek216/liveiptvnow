@extends('admin.layouts.app')

@section('title', 'Staff Management')

@section('breadcrumb')
    <li class="breadcrumb-item active">Staff</li>
@endsection

@push('styles')
<style>
    .portal-banner {
        background: linear-gradient(135deg, #1e1b4b 0%, #312e81 50%, #4338ca 100%);
        border: 1px solid rgba(99, 102, 241, 0.3);
        border-radius: 16px;
        padding: 1.5rem;
        color: #fff;
        box-shadow: 0 10px 25px -5px rgba(49, 46, 129, 0.25);
        position: relative;
        overflow: hidden;
    }
    .portal-banner::after {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 300px;
        height: 300px;
        background: radial-gradient(circle, rgba(99, 102, 241, 0.25) 0%, transparent 70%);
        pointer-events: none;
    }
    .portal-url-box {
        background: rgba(15, 23, 42, 0.65);
        border: 1px solid rgba(255, 255, 255, 0.15);
        border-radius: 12px;
        padding: 0.5rem 0.75rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    .portal-url-text {
        font-family: 'SFMono-Regular', Consolas, 'Liberation Mono', Menlo, monospace;
        color: #a5b4fc;
        font-size: 0.95rem;
        background: transparent;
        border: none;
        outline: none;
        width: 100%;
        text-overflow: ellipsis;
    }
    .portal-copy-btn {
        background: #6366f1;
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 0.5rem 1.1rem;
        font-weight: 600;
        font-size: 0.875rem;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        white-space: nowrap;
    }
    .portal-copy-btn:hover {
        background: #4f46e5;
        color: #fff;
        transform: translateY(-1px);
    }
    .portal-copy-btn.copied {
        background: #10b981 !important;
    }
    .portal-open-btn {
        background: rgba(255, 255, 255, 0.12);
        color: #e0e7ff;
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 8px;
        padding: 0.5rem 0.9rem;
        font-weight: 600;
        font-size: 0.875rem;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        text-decoration: none;
        white-space: nowrap;
    }
    .portal-open-btn:hover {
        background: rgba(255, 255, 255, 0.22);
        color: #fff;
    }
    .stat-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 44px;
        height: 44px;
        border-radius: 12px;
        font-size: 1.25rem;
    }
    .staff-card {
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.04), 0 2px 4px -2px rgba(0, 0, 0, 0.04);
        background: #fff;
    }
    .user-avatar-circle {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 0.9rem;
        color: #fff;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    .pulse-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background-color: #10b981;
        display: inline-block;
        box-shadow: 0 0 0 2px rgba(16, 185, 129, 0.3);
        animation: pulse 2s infinite;
    }
    @keyframes pulse {
        0% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.5); }
        70% { box-shadow: 0 0 0 6px rgba(16, 185, 129, 0); }
        100% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
    }
    .toast-copy {
        position: fixed;
        bottom: 2rem;
        right: 2rem;
        z-index: 9999;
        background: #0f172a;
        color: #fff;
        padding: 0.75rem 1.25rem;
        border-radius: 10px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.25);
        display: flex;
        align-items: center;
        gap: 0.6rem;
        font-size: 0.9rem;
        transform: translateY(100px);
        opacity: 0;
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .toast-copy.show {
        transform: translateY(0);
        opacity: 1;
    }
</style>
@endpush

@section('content')
    <!-- Toast Notification -->
    <div id="copyToast" class="toast-copy">
        <i class="bi bi-check-circle-fill text-success fs-5"></i>
        <span id="toastMsg">Staff Portal Link copied to clipboard!</span>
    </div>

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h1 class="page-title mb-1">Staff & Employee Management</h1>
            <p class="text-muted mb-0">Manage roles, designations, and granular module permissions for all employees.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.staff.create') }}" class="btn btn-primary px-3 py-2 fw-semibold" style="border-radius: 10px;">
                <i class="bi bi-person-plus-fill me-2"></i>Add New Staff
            </a>
        </div>
    </div>

    <!-- UNIQUE STAFF PORTAL URL BANNER (WITH 1-CLICK COPY) -->
    <div class="portal-banner mb-4">
        <div class="row align-items-center g-3">
            <div class="col-lg-7">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <span class="badge" style="background: rgba(255, 255, 255, 0.2); font-weight: 700; letter-spacing: 0.05em; font-size: 0.75rem;">
                        <i class="bi bi-shield-check me-1"></i> EXCLUSIVE STAFF URL
                    </span>
                    <span class="text-white-50 small">• Private Employee Access</span>
                </div>
                <h4 class="fw-bold mb-1 text-white">Unique Staff Portal Login Link</h4>
                <p class="mb-0 text-white-50 small" style="max-width: 620px;">
                    Share this dedicated URL with your staff members and employees. They can sign in directly to their assigned modules without having access to your Super Admin secret URL.
                </p>
            </div>
            <div class="col-lg-5">
                <div class="portal-url-box">
                    <i class="bi bi-link-45deg text-white-50 fs-5"></i>
                    <input type="text" id="staffPortalUrlInput" class="portal-url-text" value="{{ $staffPortalUrl }}" readonly>
                    <button type="button" id="copyUrlBtn" class="portal-copy-btn" onclick="copyStaffPortalUrl()">
                        <i class="bi bi-clipboard" id="copyIcon"></i>
                        <span id="copyText">Copy Link</span>
                    </button>
                    <a href="{{ $staffPortalUrl }}" target="_blank" class="portal-open-btn" title="Open in new tab">
                        <i class="bi bi-box-arrow-up-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Stats Cards -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-lg-3">
            <div class="staff-card p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-muted small fw-semibold">Total Staff</div>
                        <div class="fs-3 fw-bold text-dark mt-1">{{ $stats['total'] }}</div>
                    </div>
                    <div class="stat-badge bg-primary-subtle text-primary">
                        <i class="bi bi-people-fill"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="staff-card p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-muted small fw-semibold">Active Members</div>
                        <div class="fs-3 fw-bold text-success mt-1">{{ $stats['active'] }}</div>
                    </div>
                    <div class="stat-badge bg-success-subtle text-success">
                        <i class="bi bi-person-check-fill"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="staff-card p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-muted small fw-semibold">Super Admins</div>
                        <div class="fs-3 fw-bold text-danger mt-1">{{ $stats['super'] }}</div>
                    </div>
                    <div class="stat-badge bg-danger-subtle text-danger">
                        <i class="bi bi-star-fill"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="staff-card p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-muted small fw-semibold">Staff (RBAC)</div>
                        <div class="fs-3 fw-bold text-info mt-1">{{ $stats['staff_only'] }}</div>
                    </div>
                    <div class="stat-badge bg-info-subtle text-info">
                        <i class="bi bi-person-badge-fill"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Staff Table Card -->
    <div class="staff-card overflow-hidden">
        <!-- Table Toolbar -->
        <div class="p-3 border-bottom bg-light bg-opacity-50">
            <form action="{{ route('admin.staff.index') }}" method="GET" class="row g-2 align-items-center">
                <div class="col-md-5">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
                        <input type="text" name="search" class="form-control border-start-0" placeholder="Search by name, email or designation..." value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <select name="role" class="form-select" onchange="this.form.submit()">
                        <option value="">All Roles</option>
                        <option value="super" {{ request('role') == 'super' ? 'selected' : '' }}>Super Admin Only</option>
                        <option value="staff" {{ request('role') == 'staff' ? 'selected' : '' }}>Staff Only</option>
                    </select>
                </div>
                <div class="col-6 col-md-2">
                    <select name="status" class="form-select" onchange="this.form.submit()">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
                <div class="col-md-2 d-flex gap-1">
                    <button type="submit" class="btn btn-secondary w-100 fw-medium">Filter</button>
                    @if(request()->hasAny(['search', 'role', 'status']))
                        <a href="{{ route('admin.staff.index') }}" class="btn btn-outline-secondary" title="Clear Filters">
                            <i class="bi bi-x-lg"></i>
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Table -->
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Staff Member</th>
                        <th>Designation</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Module Access</th>
                        <th>Status</th>
                        <th>Last Login</th>
                        <th class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($staff as $user)
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="user-avatar-circle" style="background: {{ $user->isSuperAdmin() ? 'linear-gradient(135deg, #ef4444, #f43f5e)' : 'linear-gradient(135deg, #6366f1, #8b5cf6)' }};">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark">{{ $user->name }}</div>
                                        @if($user->id === auth()->id())
                                            <span class="badge bg-secondary-subtle text-secondary" style="font-size: 0.65rem;">You (Current)</span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if(!empty($user->designation))
                                    <span class="badge bg-light text-dark border fw-medium px-2 py-1">
                                        {{ $user->designation }}
                                    </span>
                                @else
                                    <span class="text-muted small">—</span>
                                @endif
                            </td>
                            <td>
                                <span class="text-secondary small">{{ $user->email }}</span>
                            </td>
                            <td>
                                @if($user->isSuperAdmin())
                                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill px-2.5 py-1">
                                        <i class="bi bi-star-fill me-1"></i> Super Admin
                                    </span>
                                @else
                                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill px-2.5 py-1">
                                        <i class="bi bi-person-badge-fill me-1"></i> Staff Member
                                    </span>
                                @endif
                            </td>
                            <td>
                                @if($user->isSuperAdmin())
                                    <span class="text-success small fw-semibold">
                                        <i class="bi bi-shield-fill-check me-1"></i> Full Access (All)
                                    </span>
                                @else
                                    @php
                                        $modCount = count($user->admin_modules ?? []);
                                    @endphp
                                    <span class="badge bg-indigo-subtle text-indigo border border-indigo-subtle rounded-pill px-2 py-1" style="background: #eef2ff; color: #4f46e5; border-color: #c7d2fe;">
                                        <i class="bi bi-grid-fill me-1"></i> {{ $modCount }} {{ Str::plural('Module', $modCount) }}
                                    </span>
                                @endif
                            </td>
                            <td>
                                @if($user->isActive())
                                    <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-2.5 py-1 d-inline-flex align-items-center gap-1.5">
                                        <span class="pulse-dot"></span> Active
                                    </span>
                                @else
                                    <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle rounded-pill px-2.5 py-1">
                                        <i class="bi bi-slash-circle me-1"></i> Deactivated
                                    </span>
                                @endif
                            </td>
                            <td>
                                <span class="text-muted small">
                                    {{ $user->last_login_at ? $user->last_login_at->diffForHumans() : 'Never' }}
                                </span>
                            </td>
                            <td class="text-end pe-4">
                                <div class="btn-group">
                                    <a href="{{ route('admin.staff.edit', $user) }}" class="btn btn-sm btn-outline-primary" title="Edit Permissions & Details" style="border-radius: 6px 0 0 6px;">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    @if($user->id !== auth()->id())
                                        <form action="{{ route('admin.staff.destroy', $user) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to permanently remove this staff member?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete Staff" style="border-radius: 0 6px 6px 0;">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">
                                <div class="py-4">
                                    <i class="bi bi-person-x fs-1 text-muted d-block mb-3"></i>
                                    <h5 class="fw-bold text-dark">No Staff Members Found</h5>
                                    <p class="text-muted small">No staff members match the selected criteria.</p>
                                    <a href="{{ route('admin.staff.create') }}" class="btn btn-sm btn-primary">
                                        <i class="bi bi-plus-lg me-1"></i>Add Staff Member
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($staff->hasPages())
            <div class="p-3 border-top bg-light bg-opacity-25 d-flex justify-content-end">
                {{ $staff->links() }}
            </div>
        @endif
    </div>
@endsection

@push('scripts')
<script>
    function copyStaffPortalUrl() {
        const urlInput = document.getElementById('staffPortalUrlInput');
        const copyBtn = document.getElementById('copyUrlBtn');
        const copyIcon = document.getElementById('copyIcon');
        const copyText = document.getElementById('copyText');
        const toast = document.getElementById('copyToast');

        urlInput.select();
        urlInput.setSelectionRange(0, 99999);

        navigator.clipboard.writeText(urlInput.value).then(() => {
            // Visual button feedback
            copyBtn.classList.add('copied');
            copyIcon.className = 'bi bi-check2-circle';
            copyText.innerText = 'Copied!';

            // Show Toast
            toast.classList.add('show');

            setTimeout(() => {
                copyBtn.classList.remove('copied');
                copyIcon.className = 'bi bi-clipboard';
                copyText.innerText = 'Copy Link';
                toast.classList.remove('show');
            }, 2500);
        }).catch(err => {
            // Fallback for older browsers
            document.execCommand('copy');
            copyBtn.classList.add('copied');
            copyText.innerText = 'Copied!';
            setTimeout(() => {
                copyBtn.classList.remove('copied');
                copyText.innerText = 'Copy Link';
            }, 2000);
        });
    }
</script>
@endpush
