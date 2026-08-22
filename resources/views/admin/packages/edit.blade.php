@extends('admin.layouts.app')

@section('title', 'Edit Package')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.packages.index') }}">Packages</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
    <div class="mb-4">
        <h1 class="page-title">Edit Package</h1>
        <p class="text-muted mb-0">Update package details</p>
    </div>

    <form action="{{ route('admin.packages.update', $package) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="row">
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header">Package Details</div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Package Name *</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $package->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description', $package->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="price" class="form-label">Price ($) *</label>
                                <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price', $package->price) }}" required>
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="original_price" class="form-label">Original Price ($)</label>
                                <input type="number" step="0.01" class="form-control @error('original_price') is-invalid @enderror" id="original_price" name="original_price" value="{{ old('original_price', $package->original_price) }}">
                                <small class="text-muted">Leave empty if no discount</small>
                                @error('original_price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="duration_months" class="form-label">Duration (Months)</label>
                                <input type="number" class="form-control @error('duration_months') is-invalid @enderror" id="duration_months" name="duration_months" value="{{ old('duration_months', $package->duration_months) }}">
                                @error('duration_months')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="duration_days" class="form-label">Duration (Days)</label>
                                <input type="number" class="form-control @error('duration_days') is-invalid @enderror" id="duration_days" name="duration_days" value="{{ old('duration_days', $package->duration_days) }}">
                                @error('duration_days')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="duration_label" class="form-label">Duration Label</label>
                                <input type="text" class="form-control @error('duration_label') is-invalid @enderror" id="duration_label" name="duration_label" value="{{ old('duration_label', $package->duration_label) }}" placeholder="e.g., 1 Month">
                                @error('duration_label')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="connections" class="form-label">Connections *</label>
                                <input type="number" class="form-control @error('connections') is-invalid @enderror" id="connections" name="connections" value="{{ old('connections', $package->connections) }}" required min="1">
                                @error('connections')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="sort_order" class="form-label">Sort Order</label>
                                <input type="number" class="form-control @error('sort_order') is-invalid @enderror" id="sort_order" name="sort_order" value="{{ old('sort_order', $package->sort_order) }}">
                                @error('sort_order')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header">Features List</div>
                    <div class="card-body">
                        <div id="features-container">
                            @if($package->features_list)
                                @foreach($package->features_list as $feature)
                                    <div class="input-group mb-2">
                                        <input type="text" class="form-control" name="features_list[]" value="{{ $feature }}" placeholder="Enter a feature">
                                        <button type="button" class="btn btn-outline-danger" onclick="this.parentElement.remove()">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                @endforeach
                            @else
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control" name="features_list[]" placeholder="Enter a feature">
                                    <button type="button" class="btn btn-outline-danger" onclick="this.parentElement.remove()">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            @endif
                        </div>
                        <button type="button" class="btn btn-outline-primary btn-sm" onclick="addFeature()">
                            <i class="bi bi-plus-lg me-1"></i>Add Feature
                        </button>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-header">Status & Options</div>
                    <div class="card-body">
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $package->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">Active</label>
                        </div>
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" value="1" {{ old('is_featured', $package->is_featured) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_featured">Featured Package</label>
                        </div>
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" id="is_trial" name="is_trial" value="1" {{ old('is_trial', $package->is_trial) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_trial">Trial Package</label>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="is_reseller" name="is_reseller" value="1" {{ old('is_reseller', $package->is_reseller) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_reseller">Reseller Package</label>
                            <small class="d-block text-muted mt-1">Show on reseller page instead of pricing page</small>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-check-lg me-2"></i>Update Package
                        </button>
                        <a href="{{ route('admin.packages.index') }}" class="btn btn-outline-secondary w-100 mt-2">Cancel</a>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('scripts')
<script>
function addFeature() {
    const container = document.getElementById('features-container');
    const div = document.createElement('div');
    div.className = 'input-group mb-2';
    div.innerHTML = `
        <input type="text" class="form-control" name="features_list[]" placeholder="Enter a feature">
        <button type="button" class="btn btn-outline-danger" onclick="this.parentElement.remove()">
            <i class="bi bi-trash"></i>
        </button>
    `;
    container.appendChild(div);
}
</script>
@endpush
