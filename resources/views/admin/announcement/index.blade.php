@extends('admin.layouts.app')

@section('title', 'Announcement Bar')

@section('breadcrumb')
    <li class="breadcrumb-item active">Announcement Bar</li>
@endsection

@section('content')
    <div class="mb-4">
        <h1 class="page-title">Announcement Bar</h1>
        <p class="text-muted mb-0">Manage the notification bar at the top of the website</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form action="{{ route('admin.announcement.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="bi bi-megaphone me-2"></i>Content Settings
                    </div>
                    <div class="card-body">
                         <div class="form-check form-switch mb-4 p-3 bg-light rounded border">
                            <input class="form-check-input" type="checkbox" id="announcement_enabled" name="announcement_enabled" value="1" {{ $settings['announcement_enabled'] == '1' ? 'checked' : '' }} style="width: 3em; height: 1.5em; margin-right: 1em;">
                            <label class="form-check-label fw-bold pt-1" for="announcement_enabled">Enable Announcement Bar</label>
                        </div>

                        <div class="mb-3">
                            <label for="announcement_text" class="form-label">Announcement Text</label>
                            <textarea class="form-control @error('announcement_text') is-invalid @enderror" id="announcement_text" name="announcement_text" rows="2" placeholder="Get <strong>50% OFF</strong> on annual plans">{{ old('announcement_text', $settings['announcement_text']) }}</textarea>
                            <small class="text-muted">Supports HTML tags like &lt;strong&gt;, &lt;b&gt;, &lt;i&gt;, &lt;span&gt;</small>
                            @error('announcement_text')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="announcement_link" class="form-label">Button Link URL</label>
                                <input type="text" class="form-control @error('announcement_link') is-invalid @enderror" id="announcement_link" name="announcement_link" value="{{ old('announcement_link', $settings['announcement_link']) }}" placeholder="/packages">
                                @error('announcement_link')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="announcement_link_text" class="form-label">Button Text</label>
                                <input type="text" class="form-control @error('announcement_link_text') is-invalid @enderror" id="announcement_link_text" name="announcement_link_text" value="{{ old('announcement_link_text', $settings['announcement_link_text']) }}" placeholder="Shop Now">
                                @error('announcement_link_text')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card mb-3">
                    <div class="card-body">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-save me-2"></i>Save Changes
                        </button>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">Live Preview</div>
                    <div class="card-body p-0">
                        <div class="alert alert-info rounded-0 mb-0 border-0" style="background: linear-gradient(90deg, #6366f1, #8b5cf6); color: white;">
                            <div class="d-flex justify-content-between align-items-center">
                                <div id="preview" style="font-size: 0.9rem;">
                                    {!! $settings['announcement_text'] ? $settings['announcement_text'] : 'Announcement text...' !!}
                                </div>
                                <span class="badge bg-white text-primary rounded-pill ms-2" id="btn-preview">
                                    {{ $settings['announcement_link_text'] ? $settings['announcement_link_text'] : 'Button' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('scripts')
<script>
    const textInput = document.getElementById('announcement_text');
    const btnInput = document.getElementById('announcement_link_text');
    const previewText = document.getElementById('preview');
    const previewBtn = document.getElementById('btn-preview');

    textInput.addEventListener('input', function() {
        previewText.innerHTML = this.value || 'Announcement text...';
    });

    btnInput.addEventListener('input', function() {
        previewBtn.innerText = this.value || 'Button';
    });
</script>
@endpush
