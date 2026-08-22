@extends('admin.layouts.app')

@section('title', 'Edit Article: ' . Str::limit($blog->title, 30))

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.blogs.index') }}">Blog Posts</a></li>
    <li class="breadcrumb-item active">Edit Article</li>
@endsection

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="page-title">Edit Article</h1>
            <p class="text-muted mb-0">Update blog post content, image, or publishing status</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('blog.show', $blog->slug) }}" target="_blank" class="btn btn-outline-info">
                <i class="bi bi-box-arrow-up-right me-2"></i>View Live
            </a>
            <a href="{{ route('admin.blogs.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-2"></i>Back to List
            </a>
        </div>
    </div>

    <form action="{{ route('admin.blogs.update', $blog) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header">Article Content</div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="title" class="form-label">Article Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $blog->title) }}" required placeholder="e.g. How to Setup IPTV on FireStick in 2026">
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="slug" class="form-label">Custom Slug</label>
                            <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug" name="slug" value="{{ old('slug', $blog->slug) }}">
                            <small class="text-muted">URL: liveiptvnow.com/blog/{{ $blog->slug }}</small>
                            @error('slug')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="excerpt" class="form-label">Short Excerpt / Summary</label>
                            <textarea class="form-control @error('excerpt') is-invalid @enderror" id="excerpt" name="excerpt" rows="3" placeholder="Brief 1-2 sentence summary...">{{ old('excerpt', $blog->excerpt) }}</textarea>
                            @error('excerpt')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="content" class="form-label">Full Article Content (HTML / Text) <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" rows="15" required>{{ old('content', $blog->content) }}</textarea>
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
                                <option value="tutorials" {{ old('category', $blog->category) === 'tutorials' ? 'selected' : '' }}>Tutorials</option>
                                <option value="updates" {{ old('category', $blog->category) === 'updates' ? 'selected' : '' }}>Updates</option>
                                <option value="tips" {{ old('category', $blog->category) === 'tips' ? 'selected' : '' }}>Tips & Tricks</option>
                                <option value="news" {{ old('category', $blog->category) === 'news' ? 'selected' : '' }}>Industry News</option>
                            </select>
                            @error('category')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Cover Image</label>
                            @if($blog->image)
                                <div class="mb-2">
                                    <img src="{{ $blog->image }}" alt="" class="img-fluid rounded border mb-1" style="max-height: 150px; width: 100%; object-fit: cover;">
                                    <small class="d-block text-muted">Current Cover Image</small>
                                </div>
                            @endif
                            <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" accept="image/*">
                            <small class="text-muted">Leave blank to keep current image</small>
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="read_time" class="form-label">Read Time</label>
                            <input type="text" class="form-control @error('read_time') is-invalid @enderror" id="read_time" name="read_time" value="{{ old('read_time', $blog->read_time) }}">
                            @error('read_time')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr class="my-4">

                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $blog->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                <strong>Active (Published)</strong>
                            </label>
                        </div>

                        <div class="form-check form-switch mb-4">
                            <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" value="1" {{ old('is_featured', $blog->is_featured) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_featured">
                                <strong>Featured Article</strong>
                            </label>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-2">
                            <i class="bi bi-save-fill me-2"></i>Update Article
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
