@extends('admin.layouts.app')

@section('title', 'Publish New Article')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.blogs.index') }}">Blog Posts</a></li>
    <li class="breadcrumb-item active">Publish Article</li>
@endsection

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="page-title">Publish New Article</h1>
            <p class="text-muted mb-0">Write and publish a new tutorial, news, or tip for your customers</p>
        </div>
        <a href="{{ route('admin.blogs.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Back to List
        </a>
    </div>

    <form action="{{ route('admin.blogs.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header">Article Content</div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="title" class="form-label">Article Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" required placeholder="e.g. How to Setup IPTV on FireStick in 2026">
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="slug" class="form-label">Custom Slug (Optional)</label>
                            <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug" name="slug" value="{{ old('slug') }}" placeholder="how-to-setup-iptv-on-firestick (leave empty to auto-generate)">
                            <small class="text-muted">Will be used in the URL: liveiptvnow.com/blog/your-custom-slug</small>
                            @error('slug')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="excerpt" class="form-label">Short Excerpt / Summary</label>
                            <textarea class="form-control @error('excerpt') is-invalid @enderror" id="excerpt" name="excerpt" rows="3" placeholder="Brief 1-2 sentence summary displayed on blog cards...">{{ old('excerpt') }}</textarea>
                            @error('excerpt')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="content" class="form-label">Full Article Content (HTML / Text) <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" rows="15" required placeholder="Write your full article here. You can use standard HTML tags like <h2>, <p>, <ul>, <li>, <strong> etc...">{{ old('content') }}</textarea>
                            <small class="text-muted">Tip: Use headings (&lt;h2&gt;, &lt;h3&gt;) and bullet points (&lt;ul&gt;&lt;li&gt;) to format your article nicely.</small>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-header">Publish Settings</div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="category" class="form-label">Category <span class="text-danger">*</span></label>
                            <select class="form-select @error('category') is-invalid @enderror" id="category" name="category" required>
                                <option value="tutorials" {{ old('category') === 'tutorials' ? 'selected' : '' }}>Tutorials</option>
                                <option value="updates" {{ old('category') === 'updates' ? 'selected' : '' }}>Updates</option>
                                <option value="tips" {{ old('category') === 'tips' ? 'selected' : '' }}>Tips & Tricks</option>
                                <option value="news" {{ old('category') === 'news' ? 'selected' : '' }}>Industry News</option>
                            </select>
                            @error('category')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Cover Image</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" accept="image/*">
                            <small class="text-muted">Recommended size: 1200x630px (Max 5MB)</small>
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="read_time" class="form-label">Read Time (Optional)</label>
                            <input type="text" class="form-control @error('read_time') is-invalid @enderror" id="read_time" name="read_time" value="{{ old('read_time') }}" placeholder="e.g. 5 min read (leave empty to auto-calculate)">
                            @error('read_time')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr class="my-4">

                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                <strong>Active (Published)</strong>
                                <small class="d-block text-muted">Turn off to save as draft</small>
                            </label>
                        </div>

                        <div class="form-check form-switch mb-4">
                            <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_featured">
                                <strong>Featured Article</strong>
                                <small class="d-block text-muted">Show as main hero article on blog page</small>
                            </label>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-2">
                            <i class="bi bi-send-fill me-2"></i>Publish Article
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
