@extends('admin.layouts.app')

@section('title', 'Contact Message #' . $contact->id)

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.contacts.index') }}">Contacts</a></li>
<li class="breadcrumb-item active">Message #{{ $contact->id }}</li>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-8">
        <!-- Message Card -->
        <div class="card mb-4">
            <div class="card-header bg-white">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Message Details</h5>
                    <div>
                        @if($contact->status === 'new')
                            <span class="badge bg-warning">New</span>
                        @elseif($contact->status === 'read')
                            <span class="badge bg-info">Read</span>
                        @elseif($contact->status === 'replied')
                            <span class="badge bg-success">Replied</span>
                        @else
                            <span class="badge bg-secondary">Closed</span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="message-header mb-4 pb-4 border-bottom">
                    <div class="d-flex align-items-start">
                        <div class="avatar-lg bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-3">
                            <span class="fs-4 fw-bold">{{ substr($contact->name, 0, 1) }}</span>
                        </div>
                        <div class="flex-grow-1">
                            <h4 class="mb-1">{{ $contact->name }}</h4>
                            <div class="text-muted">
                                <i class="bi bi-envelope me-1"></i>
                                <a href="mailto:{{ $contact->email }}" class="text-decoration-none">{{ $contact->email }}</a>
                            </div>
                            @if($contact->phone)
                            <div class="text-muted mt-1">
                                <i class="bi bi-telephone me-1"></i>
                                <a href="tel:{{ $contact->phone }}" class="text-decoration-none">{{ $contact->phone }}</a>
                            </div>
                            @endif
                            <div class="text-muted mt-2">
                                <small>
                                    <i class="bi bi-clock me-1"></i>
                                    {{ $contact->created_at->format('F j, Y \a\t g:i A') }}
                                    ({{ $contact->created_at->diffForHumans() }})
                                </small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="message-subject mb-3">
                    <label class="text-muted small mb-1">Subject</label>
                    <div class="d-flex align-items-center">
                        <span class="badge bg-light text-dark fs-6 px-3 py-2">{{ $contact->subject }}</span>
                    </div>
                </div>

                <div class="message-body">
                    <label class="text-muted small mb-2">Message</label>
                    <div class="message-content p-4 bg-light rounded">
                        {!! nl2br(e($contact->message)) !!}
                    </div>
                </div>
            </div>
        </div>

        <!-- Admin Notes -->
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">Admin Notes</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.contacts.update-status', $contact) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label class="form-label">Internal Notes</label>
                        <textarea name="admin_notes" class="form-control" rows="4" placeholder="Add internal notes about this contact...">{{ $contact->admin_notes }}</textarea>
                        <small class="text-muted">These notes are only visible to admins</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="new" {{ $contact->status === 'new' ? 'selected' : '' }}>New</option>
                            <option value="read" {{ $contact->status === 'read' ? 'selected' : '' }}>Read</option>
                            <option value="replied" {{ $contact->status === 'replied' ? 'selected' : '' }}>Replied</option>
                            <option value="closed" {{ $contact->status === 'closed' ? 'selected' : '' }}>Closed</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i> Save Changes
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <!-- Quick Actions -->
        <div class="card mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0">Quick Actions</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="mailto:{{ $contact->email }}" class="btn btn-primary">
                        <i class="bi bi-envelope me-2"></i> Reply via Email
                    </a>
                    @if($contact->phone)
                    <a href="tel:{{ $contact->phone }}" class="btn btn-outline-primary">
                        <i class="bi bi-telephone me-2"></i> Call Customer
                    </a>
                    @endif
                    <a href="{{ route('admin.contacts.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-2"></i> Back to List
                    </a>
                </div>
            </div>
        </div>

        <!-- Contact Info -->
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">Contact Information</h5>
            </div>
            <div class="card-body">
                <div class="info-item mb-3">
                    <label class="text-muted small mb-1">Contact ID</label>
                    <div class="fw-semibold">#{{ $contact->id }}</div>
                </div>

                <div class="info-item mb-3">
                    <label class="text-muted small mb-1">Full Name</label>
                    <div class="fw-semibold">{{ $contact->name }}</div>
                </div>

                <div class="info-item mb-3">
                    <label class="text-muted small mb-1">Email Address</label>
                    <div>
                        <a href="mailto:{{ $contact->email }}" class="text-decoration-none">
                            {{ $contact->email }}
                        </a>
                    </div>
                </div>

                @if($contact->phone)
                <div class="info-item mb-3">
                    <label class="text-muted small mb-1">Phone Number</label>
                    <div>
                        <a href="tel:{{ $contact->phone }}" class="text-decoration-none">
                            {{ $contact->phone }}
                        </a>
                    </div>
                </div>
                @endif

                <div class="info-item mb-3">
                    <label class="text-muted small mb-1">Submitted</label>
                    <div>{{ $contact->created_at->format('M d, Y h:i A') }}</div>
                    <small class="text-muted">{{ $contact->created_at->diffForHumans() }}</small>
                </div>

                <div class="info-item">
                    <label class="text-muted small mb-1">Last Updated</label>
                    <div>{{ $contact->updated_at->format('M d, Y h:i A') }}</div>
                </div>
            </div>
        </div>

        <!-- Delete Contact -->
        <div class="card border-danger mt-4">
            <div class="card-header bg-danger bg-opacity-10 text-danger">
                <h6 class="mb-0">Danger Zone</h6>
            </div>
            <div class="card-body">
                <p class="text-muted small mb-3">Once you delete this contact, there is no going back. Please be certain.</p>
                <form action="{{ route('admin.contacts.destroy', $contact) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this contact message? This action cannot be undone.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger w-100">
                        <i class="bi bi-trash me-2"></i> Delete Contact
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .avatar-lg {
        width: 64px;
        height: 64px;
    }
    .message-content {
        line-height: 1.7;
        font-size: 0.95rem;
    }
    .info-item label {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
</style>
@endpush
