@extends('admin.layouts.app')

@section('title', 'General Settings')

@section('breadcrumb')
    <li class="breadcrumb-item active">General Settings</li>
@endsection

@section('content')
    <div class="mb-4">
        <h1 class="page-title">General Settings</h1>
        <p class="text-muted mb-0">Manage site-wide settings</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form action="{{ route('admin.settings.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-lg-8">
                <!-- Chat & Support Settings -->
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="bi bi-chat-dots me-2"></i>Chat & Support
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="whatsapp_number" class="form-label">WhatsApp Number</label>
                            <input type="text" class="form-control @error('whatsapp_number') is-invalid @enderror"
                                id="whatsapp_number" name="whatsapp_number"
                                value="{{ old('whatsapp_number', $settings['whatsapp_number']) }}"
                                placeholder="+1234567890">
                            <small class="text-muted">Include country code without spaces</small>
                            @error('whatsapp_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="crisp_website_id" class="form-label">Crisp Website ID</label>
                            <input type="text" class="form-control @error('crisp_website_id') is-invalid @enderror"
                                id="crisp_website_id" name="crisp_website_id"
                                value="{{ old('crisp_website_id', $settings['crisp_website_id']) }}"
                                placeholder="xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx">
                            <small class="text-muted">Get your Crisp ID from <a href="https://crisp.chat"
                                    target="_blank">crisp.chat</a></small>
                            @error('crisp_website_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-check-lg me-2"></i>Save Settings
                        </button>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-body">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-check-lg me-2"></i>Save Settings
                        </button>
                    </div>
                </div>

                <!-- Database Backup -->
                <div class="card border-primary">
                    <div class="card-header bg-primary text-white">
                        <i class="bi bi-download me-2"></i>Database Backup
                    </div>
                    <div class="card-body">
                        <p class="small text-muted">Download all user data, orders, and subscription details in an
                            Excel-compatible format (CSV).</p>
                        <a href="{{ route('admin.settings.backup') }}" class="btn btn-outline-primary w-100">
                            <i class="bi bi-file-earmark-spreadsheet me-2"></i>Download Backup
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection