@extends('admin.layouts.app')

@section('title', 'Blog Posts')

@section('breadcrumb')
    <li class="breadcrumb-item active">Blog Posts</li>
@endsection

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="page-title">Blog Posts</h1>
            <p class="text-muted mb-0">Manage website articles, tutorials, and news</p>
        </div>
        <a href="{{ route('admin.blogs.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-2"></i>Publish New Article
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('admin.blogs.index') }}" method="GET" class="row g-3 align-items-center">
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="bi bi-search"></i></span>
                        <input type="text" name="search" class="form-control" placeholder="Search articles..." value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <select name="category" class="form-select" onchange="this.form.submit()">
                        <option value="all">All Categories</option>
                        <option value="tutorials" {{ request('category') === 'tutorials' ? 'selected' : '' }}>Tutorials</option>
                        <option value="updates" {{ request('category') === 'updates' ? 'selected' : '' }}>Updates</option>
                        <option value="tips" {{ request('category') === 'tips' ? 'selected' : '' }}>Tips & Tricks</option>
                        <option value="news" {{ request('category') === 'news' ? 'selected' : '' }}>Industry News</option>
                    </select>
                </div>
                <div class="col-md-2">
                    @if(request('search') || (request('category') && request('category') !== 'all'))
                        <a href="{{ route('admin.blogs.index') }}" class="btn btn-outline-secondary w-100">Reset</a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            @if($blogs->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th style="width: 50px;">Image</th>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Views</th>
                                <th>Featured</th>
                                <th>Status</th>
                                <th>Published</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($blogs as $blog)
                                <tr>
                                    <td>
                                        @if($blog->image)
                                            <img src="{{ $blog->image }}" alt="" class="rounded" style="width: 45px; height: 45px; object-fit: cover;">
                                        @else
                                            <div class="rounded bg-light d-flex align-items-center justify-content-center text-muted" style="width: 45px; height: 45px;">
                                                <i class="bi bi-image"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <strong class="text-dark d-block mb-1">{{ Str::limit($blog->title, 50) }}</strong>
                                        <small class="text-muted"><i class="bi bi-clock me-1"></i>{{ $blog->read_time }}</small>
                                    </td>
                                    <td>
                                        <span class="badge" style="background-color: {{ $blog->category_color }} !important; color: #fff;">
                                            {{ $blog->category_label }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark border">
                                            <i class="bi bi-eye me-1"></i>{{ number_format($blog->views) }}
                                        </span>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-link p-0 toggle-featured" data-id="{{ $blog->id }}" title="Toggle Featured">
                                            <i class="bi bi-star{{ $blog->is_featured ? '-fill text-warning' : ' text-muted' }} fs-5"></i>
                                        </button>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-outline-{{ $blog->is_active ? 'success' : 'danger' }} toggle-status" data-id="{{ $blog->id }}">
                                            {{ $blog->is_active ? 'Active' : 'Inactive' }}
                                        </button>
                                    </td>
                                    <td>
                                        <small class="text-muted">{{ $blog->created_at->format('M d, Y') }}</small>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('blog.show', $blog->slug) }}" target="_blank" class="btn btn-outline-secondary" title="View Live">
                                                <i class="bi bi-box-arrow-up-right"></i>
                                            </a>
                                            <a href="{{ route('admin.blogs.edit', $blog) }}" class="btn btn-outline-primary" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('admin.blogs.destroy', $blog) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this post?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger" title="Delete">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $blogs->withQueryString()->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-journal-x text-muted fs-1 mb-3 d-block"></i>
                    <h5 class="text-muted">No blog posts found</h5>
                    <p class="text-muted mb-3">Get started by publishing your first article!</p>
                    <a href="{{ route('admin.blogs.create') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-lg me-2"></i>Publish Article
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const csrfToken = '{{ csrf_token() }}';

    // Toggle Status
    document.querySelectorAll('.toggle-status').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            fetch(`{{ url('my-secret-portal-9821/blogs') }}/${id}/toggle-active`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    this.className = `btn btn-sm btn-outline-${data.is_active ? 'success' : 'danger'} toggle-status`;
                    this.textContent = data.is_active ? 'Active' : 'Inactive';
                }
            });
        });
    });

    // Toggle Featured
    document.querySelectorAll('.toggle-featured').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            fetch(`{{ url('my-secret-portal-9821/blogs') }}/${id}/toggle-featured`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                }
            });
        });
    });
});
</script>
@endpush
