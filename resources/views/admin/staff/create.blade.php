@extends('admin.layouts.app')

@section('title', 'Add New Staff Member')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.staff.index') }}">Staff</a></li>
    <li class="breadcrumb-item active">Add New</li>
@endsection

@push('styles')
<style>
    .section-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02);
    }
    .permission-group-card {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 1.25rem;
        height: 100%;
        transition: all 0.2s ease;
    }
    .permission-group-card:hover {
        border-color: #cbd5e1;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.04);
    }
    .module-item {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 0.75rem 1rem;
        margin-bottom: 0.6rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        cursor: pointer;
        transition: all 0.2s ease;
        user-select: none;
    }
    .module-item:hover {
        border-color: #c7d2fe;
        background: #fafbff;
    }
    .module-item.active {
        border-color: #6366f1;
        background: rgba(99, 102, 241, 0.05);
    }
    .module-icon-box {
        width: 34px;
        height: 34px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        background: #eef2ff;
        color: #4f46e5;
        flex-shrink: 0;
    }
    .module-item.active .module-icon-box {
        background: #6366f1;
        color: #fff;
    }
    .toggle-card {
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 1rem 1.25rem;
        background: #fff;
        transition: all 0.2s;
    }
    .toggle-card:hover {
        border-color: #cbd5e1;
    }
    .super-admin-banner {
        background: #fef2f2;
        border: 1px solid #fecaca;
        border-radius: 12px;
        padding: 1rem 1.25rem;
        color: #991b1b;
        display: none;
    }
    .super-admin-banner.active {
        display: flex;
    }
</style>
@endpush

@section('content')
    <!-- Top Action Bar -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="page-title mb-1">Add New Staff Member</h1>
            <p class="text-muted small mb-0">Create an employee account, assign job designation, and grant specific module permissions.</p>
        </div>
        <a href="{{ route('admin.staff.index') }}" class="btn btn-outline-secondary btn-sm px-3 py-1.5 fw-semibold" style="border-radius: 8px;">
            <i class="bi bi-arrow-left me-1"></i>Back to Staff List
        </a>
    </div>

    <form action="{{ route('admin.staff.store') }}" method="POST" id="createStaffForm">
        @csrf

        <!-- SECTION 1: Account Information -->
        <div class="section-card">
            <div class="d-flex align-items-center gap-2 mb-3">
                <i class="bi bi-person-plus-fill text-primary fs-5"></i>
                <h5 class="fw-bold mb-0">Personal & Login Information</h5>
            </div>

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold small text-muted">FULL NAME <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="bi bi-person"></i></span>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required placeholder="e.g. Sarah Connor">
                    </div>
                    @error('name') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold small text-muted">EMAIL ADDRESS <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="bi bi-envelope"></i></span>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required placeholder="e.g. sarah@liveiptvnow.com">
                    </div>
                    @error('email') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold small text-muted">LOGIN PASSWORD <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="bi bi-lock"></i></span>
                        <input type="password" name="password" id="staffPassword" class="form-control @error('password') is-invalid @enderror" required minlength="8" placeholder="Enter secure password">
                        <button class="btn btn-outline-secondary" type="button" onclick="togglePasswordVisibility()"><i class="bi bi-eye" id="pwdEye"></i></button>
                    </div>
                    @error('password') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    <div class="form-text small">Must be at least 8 characters.</div>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold small text-muted">DESIGNATION / JOB TITLE</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="bi bi-briefcase"></i></span>
                        <input type="text" name="designation" class="form-control @error('designation') is-invalid @enderror" value="{{ old('designation') }}" placeholder="e.g. Senior Support Agent, Content Manager">
                    </div>
                    @error('designation') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    <div class="form-text small">Job title visible across admin tables and activity logs.</div>
                </div>
            </div>
        </div>

        <!-- SECTION 2: Role & Status -->
        <div class="section-card">
            <div class="d-flex align-items-center gap-2 mb-3">
                <i class="bi bi-sliders text-primary fs-5"></i>
                <h5 class="fw-bold mb-0">Role & Access Settings</h5>
            </div>

            <div class="row g-3">
                <!-- Account Status Toggle -->
                <div class="col-md-6">
                    <div class="toggle-card">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="fw-bold mb-1 text-dark">Active Account</h6>
                                <p class="text-muted small mb-0">Allows the employee to log in via the Staff Portal immediately upon creation.</p>
                            </div>
                            <div class="form-check form-switch ms-3">
                                <input class="form-check-input" type="checkbox" role="switch" name="is_active" id="isActive" value="1" {{ old('is_active', true) ? 'checked' : '' }} style="width: 2.75rem; height: 1.4rem;">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Super Admin Switch -->
                <div class="col-md-6">
                    <div class="toggle-card border-danger border-opacity-25" style="background: #fffbfa;">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="fw-bold mb-1 text-danger d-flex align-items-center gap-1.5">
                                    <i class="bi bi-star-fill"></i> Super Admin Privileges
                                </h6>
                                <p class="text-muted small mb-0">Grants full unrestricted access to all modules, settings, and billing.</p>
                            </div>
                            <div class="form-check form-switch ms-3">
                                <input class="form-check-input bg-danger border-danger" type="checkbox" role="switch" name="is_super_admin" id="isSuperAdmin" value="1" {{ old('is_super_admin') ? 'checked' : '' }} onchange="onSuperAdminToggle(this.checked)" style="width: 2.75rem; height: 1.4rem;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Super Admin Warning Banner -->
        <div class="super-admin-banner align-items-center gap-3 mb-4 {{ old('is_super_admin') ? 'active' : '' }}" id="superAdminAlert">
            <i class="bi bi-shield-fill-check fs-2 text-danger flex-shrink-0"></i>
            <div>
                <h6 class="fw-bold mb-0 text-danger">Super Administrator Access Selected</h6>
                <div class="small">This user will have full master authority over all current and future modules. Module checkboxes below are overridden and not required.</div>
            </div>
        </div>

        <!-- SECTION 3: Granular Permissions Matrix -->
        <div class="section-card" id="permissionsContainer" style="{{ old('is_super_admin') ? 'opacity: 0.45; pointer-events: none;' : '' }}">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
                <div>
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-grid-3x3-gap-fill text-primary fs-5"></i>
                        <h5 class="fw-bold mb-0">Assign Module Permissions</h5>
                    </div>
                    <p class="text-muted small mb-0 mt-0.5">Select the exact administrative sections this staff member can access.</p>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <span id="moduleCountBadge" class="badge bg-primary rounded-pill px-3 py-2 fw-semibold">0 Selected</span>
                    <button type="button" class="btn btn-sm btn-outline-primary fw-medium" onclick="selectAllModules(true)">
                        <i class="bi bi-check-all me-1"></i>Select All
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-secondary fw-medium" onclick="selectAllModules(false)">
                        <i class="bi bi-x-lg me-1"></i>Clear All
                    </button>
                </div>
            </div>

            @php
                $grouped = \App\Support\AdminModules::grouped();
                $categoryIcons = [
                    'Main' => 'bi-speedometer2',
                    'Management' => 'bi-kanban-fill',
                    'Affiliate Program' => 'bi-diagram-3-fill',
                    'Settings' => 'bi-gear-wide-connected'
                ];
                $oldModules = old('admin_modules', ['dashboard', 'orders']);
            @endphp

            <div class="row g-4">
                @foreach($grouped as $section => $sectionModules)
                    <div class="col-lg-6">
                        <div class="permission-group-card">
                            <div class="d-flex justify-content-between align-items-center pb-2 mb-3 border-bottom">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="bi {{ $categoryIcons[$section] ?? 'bi-folder' }} text-primary"></i>
                                    <h6 class="fw-bold mb-0 text-dark">{{ $section }}</h6>
                                </div>
                                <button type="button" class="btn btn-link btn-sm text-decoration-none p-0 fw-semibold text-primary" style="font-size: 0.8rem;" onclick="toggleCategory('{{ Str::slug($section) }}')">
                                    Toggle All
                                </button>
                            </div>

                            <div class="category-modules" id="cat-{{ Str::slug($section) }}">
                                @foreach($sectionModules as $key => $module)
                                    @php
                                        $isChecked = in_array($key, $oldModules);
                                    @endphp
                                    <div class="module-item {{ $isChecked ? 'active' : '' }}" onclick="toggleModuleCard('{{ $key }}', event)">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="module-icon-box">
                                                <i class="bi {{ $module['icon'] ?? 'bi-app' }}"></i>
                                            </div>
                                            <div>
                                                <div class="fw-bold text-dark small">{{ $module['label'] }}</div>
                                                <div class="text-muted" style="font-size: 0.75rem;">{{ $module['description'] ?? 'Manage ' . $module['label'] }}</div>
                                            </div>
                                        </div>
                                        <div class="form-check form-switch m-0 p-0">
                                            <input class="form-check-input module-checkbox ms-0" type="checkbox" name="admin_modules[]" value="{{ $key }}" id="mod_{{ $key }}" {{ $isChecked ? 'checked' : '' }} onchange="onCheckboxChange('{{ $key }}')" style="width: 2.2rem; height: 1.15rem; cursor: pointer;">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Submit & Save Actions -->
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 pt-2 mb-5">
            <a href="{{ route('admin.staff.index') }}" class="btn btn-light px-4 py-2 fw-medium border">
                Cancel
            </a>
            <button type="submit" class="btn btn-primary px-5 py-2.5 fw-bold" style="border-radius: 10px; font-size: 1rem; box-shadow: 0 4px 14px rgba(99, 102, 241, 0.35);">
                <i class="bi bi-person-check-fill me-2"></i>Create Staff Member
            </button>
        </div>
    </form>
@endsection

@push('scripts')
<script>
    function togglePasswordVisibility() {
        const input = document.getElementById('staffPassword');
        const eye = document.getElementById('pwdEye');
        if (input.type === 'password') {
            input.type = 'text';
            eye.className = 'bi bi-eye-slash';
        } else {
            input.type = 'password';
            eye.className = 'bi bi-eye';
        }
    }

    function onSuperAdminToggle(isSuper) {
        const container = document.getElementById('permissionsContainer');
        const alertBanner = document.getElementById('superAdminAlert');

        if (isSuper) {
            container.style.opacity = '0.45';
            container.style.pointerEvents = 'none';
            alertBanner.classList.add('active');
        } else {
            container.style.opacity = '1';
            container.style.pointerEvents = 'auto';
            alertBanner.classList.remove('active');
        }
    }

    function toggleModuleCard(key, event) {
        if (event && event.target && event.target.tagName === 'INPUT') {
            return;
        }
        const cb = document.getElementById('mod_' + key);
        if (cb) {
            cb.checked = !cb.checked;
            onCheckboxChange(key);
        }
    }

    function onCheckboxChange(key) {
        const cb = document.getElementById('mod_' + key);
        const card = cb ? cb.closest('.module-item') : null;
        if (card && cb) {
            if (cb.checked) {
                card.classList.add('active');
            } else {
                card.classList.remove('active');
            }
        }
        updateSelectedCounter();
    }

    function selectAllModules(select) {
        const checkboxes = document.querySelectorAll('.module-checkbox');
        checkboxes.forEach(cb => {
            cb.checked = select;
            const card = cb.closest('.module-item');
            if (card) {
                if (select) card.classList.add('active');
                else card.classList.remove('active');
            }
        });
        updateSelectedCounter();
    }

    function toggleCategory(catSlug) {
        const container = document.getElementById('cat-' + catSlug);
        if (!container) return;
        const checkboxes = container.querySelectorAll('.module-checkbox');
        const anyUnchecked = Array.from(checkboxes).some(cb => !cb.checked);
        const targetState = anyUnchecked;

        checkboxes.forEach(cb => {
            cb.checked = targetState;
            const card = cb.closest('.module-item');
            if (card) {
                if (targetState) card.classList.add('active');
                else card.classList.remove('active');
            }
        });
        updateSelectedCounter();
    }

    function updateSelectedCounter() {
        const total = document.querySelectorAll('.module-checkbox').length;
        const checked = document.querySelectorAll('.module-checkbox:checked').length;
        const badge = document.getElementById('moduleCountBadge');
        if (badge) {
            badge.innerText = checked + ' of ' + total + ' Selected';
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        updateSelectedCounter();
        const superCb = document.getElementById('isSuperAdmin');
        if (superCb) {
            onSuperAdminToggle(superCb.checked);
        }
    });
</script>
@endpush
