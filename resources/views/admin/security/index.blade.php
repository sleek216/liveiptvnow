@extends('admin.layouts.app')

@section('title', 'Security Settings')

@section('breadcrumb')
    <li class="breadcrumb-item active">Security</li>
@endsection

@section('content')
<div class="mb-4">
    <h1 class="page-title">Security & Authenticator</h1>
    <p class="text-muted">Enhance your account security with Two-Factor Authentication (2FA).</p>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">Google Authenticator (2FA)</div>
            <div class="card-body">
                @if(!$user->google2fa_enabled)
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i>
                        Two-factor authentication is currently <strong>disabled</strong>. Follow the steps below to enable it.
                    </div>

                    <div class="row align-items-center">
                        <div class="col-md-4 text-center">
                            <div class="qr-code-wrapper p-3 bg-white rounded shadow-sm">
                                {!! $qrCode !!}
                            </div>
                        </div>
                        <div class="col-md-8">
                            <h5>Step 1: Scan QR Code</h5>
                            <p>Download "Google Authenticator" or "Authy" on your mobile device and scan the QR code on the left.</p>
                            
                            <h5 class="mt-4">Step 2: Enter Verification Code</h5>
                            <p>Once scanned, your app will generate a 6-digit code. Enter it below to confirm.</p>
                            
                            <form action="{{ route('admin.security.enable') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">6-Digit Code</label>
                                    <input type="text" name="secret" class="form-control" placeholder="123456" maxlength="6" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Enable 2FA</button>
                            </form>
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <small class="text-muted">Or manually enter this secret key: <code>{{ $secret }}</code></small>
                    </div>
                @else
                    <div class="alert alert-success">
                        <i class="bi bi-shield-check me-2"></i>
                        Two-factor authentication is <strong>enabled</strong>. Your account is protected.
                    </div>
                    
                    <p>If you wish to disable 2FA, please click the button below. You will need to re-setup if you enable it again.</p>
                    
                    <form action="{{ route('admin.security.disable') }}" method="POST" onsubmit="return confirm('Are you sure you want to disable 2FA? This will reduce your account security.')">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger">Disable 2FA</button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
    .qr-code-wrapper svg {
        width: 100%;
        height: auto;
    }
</style>
@endsection
