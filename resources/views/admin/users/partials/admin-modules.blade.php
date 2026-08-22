@php
    $selectedModules = old(
        'admin_modules',
        ($user->exists && $user->hasFullAdminAccess())
            ? \App\Support\AdminModules::keys()
            : ($user->admin_modules ?? [])
    );
    $showModules = old('is_admin', $user->is_admin ?? false);
@endphp

@if(auth()->user()->isSuperAdmin())
    <div id="admin-modules-panel" class="mb-4 {{ $showModules ? '' : 'd-none' }}">
        <div class="card border">
            <div class="card-header bg-light py-2">
                <strong>Admin Module Access</strong>
                <small class="text-muted d-block">Select which sections this admin can access</small>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <button type="button" class="btn btn-sm btn-outline-primary me-2" id="select-all-modules">Select All</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" id="clear-all-modules">Clear All</button>
                </div>

                @foreach(\App\Support\AdminModules::grouped() as $section => $modules)
                    <div class="mb-3">
                        <div class="text-uppercase text-muted small fw-semibold mb-2">{{ $section }}</div>
                        <div class="row g-2">
                            @foreach($modules as $key => $module)
                                <div class="col-md-6 col-lg-4">
                                    <div class="form-check">
                                        <input
                                            class="form-check-input admin-module-checkbox"
                                            type="checkbox"
                                            name="admin_modules[]"
                                            id="module_{{ $key }}"
                                            value="{{ $key }}"
                                            {{ in_array($key, $selectedModules, true) ? 'checked' : '' }}
                                        >
                                        <label class="form-check-label" for="module_{{ $key }}">{{ $module['label'] }}</label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach

                @error('admin_modules')
                    <div class="text-danger small mt-2">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
@endif

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const adminToggle = document.getElementById('is_admin');
    const panel = document.getElementById('admin-modules-panel');
    const selectAll = document.getElementById('select-all-modules');
    const clearAll = document.getElementById('clear-all-modules');

    if (!adminToggle || !panel) return;

    adminToggle.addEventListener('change', function () {
        panel.classList.toggle('d-none', !this.checked);
    });

    if (selectAll) {
        selectAll.addEventListener('click', function () {
            document.querySelectorAll('.admin-module-checkbox').forEach(cb => cb.checked = true);
        });
    }

    if (clearAll) {
        clearAll.addEventListener('click', function () {
            document.querySelectorAll('.admin-module-checkbox').forEach(cb => cb.checked = false);
        });
    }
});
</script>
@endpush
