@extends('admin.layouts.app')

@section('title', 'Edit Staff Member')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.staff.index') }}">Staff</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="page-title">Edit Staff Member</h1>
            <p class="text-muted mb-0">Update account details and permissions for {{ $staff->name }}.</p>
        </div>
        <a href="{{ route('admin.staff.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i>Back
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.staff.update', $staff) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Full Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $staff->name) }}" required>
                                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Email Address <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $staff->email) }}" required>
                                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Password</label>
                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" minlength="8" placeholder="Leave blank to keep current">
                                @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Designation / Role Title</label>
                                <input type="text" name="designation" class="form-control @error('designation') is-invalid @enderror" value="{{ old('designation', $staff->designation) }}" placeholder="e.g. Support Agent">
                                @error('designation') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <hr class="my-4">
                        
                        <h5 class="mb-3">Access Permissions</h5>
                        
                        <div class="mb-4">
                            <div class="form-check form-switch mb-2">
                                <input class="form-check-input" type="checkbox" role="switch" name="is_active" id="isActive" value="1" {{ old('is_active', $staff->isActive()) ? 'checked' : '' }}>
                                <label class="form-check-label fw-medium" for="isActive">Account is Active</label>
                            </div>
                            <div class="form-text">Inactive accounts cannot log into the admin portal.</div>
                        </div>

                        <div class="mb-4">
                            <div class="form-check form-switch mb-2">
                                <input class="form-check-input" type="checkbox" role="switch" name="is_super_admin" id="isSuperAdmin" value="1" {{ old('is_super_admin', $staff->isSuperAdmin()) ? 'checked' : '' }} onchange="togglePermissions(this.checked)" {{ $staff->id === auth()->id() ? 'disabled' : '' }}>
                                <label class="form-check-label fw-medium text-danger" for="isSuperAdmin">Super Admin Access</label>
                            </div>
                            @if($staff->id === auth()->id())
                                <input type="hidden" name="is_super_admin" value="{{ $staff->isSuperAdmin() ? '1' : '0' }}">
                                <div class="form-text text-warning">You cannot change your own super admin status.</div>
                            @else
                                <div class="form-text">Super Admins have full access to all current and future modules.</div>
                            @endif
                        </div>

                        <div class="permissions-container" id="permissionsContainer">
                            <label class="form-label fw-medium">Specific Module Permissions</label>
                            <div class="row g-3">
                                @php
                                    $userModules = $staff->admin_modules ?? [];
                                @endphp
                                @foreach(\App\Support\AdminModules::grouped() as $section => $sectionModules)
                                    <div class="col-md-6">
                                        <div class="card bg-light h-100 shadow-none border">
                                            <div class="card-body p-3">
                                                <h6 class="mb-2">{{ $section }}</h6>
                                                @foreach($sectionModules as $key => $module)
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="admin_modules[]" value="{{ $key }}" id="mod_{{ $key }}" {{ in_array($key, old('admin_modules', $userModules)) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="mod_{{ $key }}">
                                                            {{ $module['label'] }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-1"></i>Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    function togglePermissions(isSuperAdmin) {
        const container = document.getElementById('permissionsContainer');
        const checkboxes = container.querySelectorAll('input[type="checkbox"]');
        
        if (isSuperAdmin) {
            container.style.opacity = '0.5';
            checkboxes.forEach(cb => cb.disabled = true);
        } else {
            container.style.opacity = '1';
            checkboxes.forEach(cb => cb.disabled = false);
        }
    }

    // Run on load to set correct state
    document.addEventListener('DOMContentLoaded', function() {
        togglePermissions(document.getElementById('isSuperAdmin').checked);
    });
</script>
@endpush
