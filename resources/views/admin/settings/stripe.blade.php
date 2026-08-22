@extends('admin.layouts.app')

@section('title', 'Stripe Settings')

@section('breadcrumb')
    <li class="breadcrumb-item">Settings</li>
    <li class="breadcrumb-item active">Stripe</li>
@endsection

@section('content')
    <div class="mb-4">
        <h1 class="page-title">Stripe Payment Gateway</h1>
        <p class="text-muted mb-0">Configure your Stripe API keys for payment processing</p>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.settings.update-stripe') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="alert alert-info mb-4">
                            <i class="bi bi-info-circle me-2"></i>
                            Get your API keys from <a href="https://dashboard.stripe.com/apikeys" target="_blank">Stripe Dashboard</a>
                        </div>

                        <div class="mb-4 form-check form-switch p-3 border rounded bg-light">
                            <input class="form-check-input ms-0 me-2" type="checkbox" id="stripe_enabled" name="stripe_enabled" value="1" {{ ($stripeSettings['stripe_enabled'] ?? '1') == '1' ? 'checked' : '' }} style="margin-left: 0;">
                            <label class="form-check-label fw-bold" for="stripe_enabled">Enable Stripe Payment Gateway</label>
                            <div class="text-muted small mt-1">Toggle this to show/hide Stripe during checkout</div>
                        </div>

                        <div class="mb-3">
                            <label for="stripe_mode" class="form-label">Mode *</label>
                            <select class="form-select @error('stripe_mode') is-invalid @enderror" id="stripe_mode" name="stripe_mode" required>
                                <option value="test" {{ ($stripeSettings['stripe_mode'] ?? 'test') == 'test' ? 'selected' : '' }}>Test Mode</option>
                                <option value="live" {{ ($stripeSettings['stripe_mode'] ?? '') == 'live' ? 'selected' : '' }}>Live Mode</option>
                            </select>
                            @error('stripe_mode')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Use Test mode for development, Live for production</small>
                        </div>

                        <div class="mb-3">
                            <label for="stripe_publishable_key" class="form-label">Publishable Key</label>
                            <input type="text" class="form-control @error('stripe_publishable_key') is-invalid @enderror" id="stripe_publishable_key" name="stripe_publishable_key" value="{{ $stripeSettings['stripe_publishable_key'] ?? '' }}" placeholder="pk_test_...">
                            @error('stripe_publishable_key')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="stripe_secret_key" class="form-label">Secret Key</label>
                            <input type="password" class="form-control @error('stripe_secret_key') is-invalid @enderror" id="stripe_secret_key" name="stripe_secret_key" value="{{ $stripeSettings['stripe_secret_key'] ?? '' }}" placeholder="sk_test_...">
                            @error('stripe_secret_key')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Keep this key secret! Never share it publicly.</small>
                        </div>

                        <div class="mb-4">
                            <label for="stripe_webhook_secret" class="form-label">Webhook Secret</label>
                            <input type="password" class="form-control @error('stripe_webhook_secret') is-invalid @enderror" id="stripe_webhook_secret" name="stripe_webhook_secret" value="{{ $stripeSettings['stripe_webhook_secret'] ?? '' }}" placeholder="whsec_...">
                            @error('stripe_webhook_secret')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Required for handling webhook events</small>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg me-2"></i>Save Settings
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">Webhook URL</div>
                <div class="card-body">
                    <p class="text-muted small mb-2">Configure this URL in your Stripe Dashboard:</p>
                    <div class="bg-light p-2 rounded">
                        <code class="small">{{ route('stripe.webhook') }}</code>
                    </div>
                    <button onclick="navigator.clipboard.writeText('{{ route('stripe.webhook') }}')" class="btn btn-outline-secondary btn-sm mt-2">
                        <i class="bi bi-clipboard me-1"></i>Copy
                    </button>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header">Setup Instructions</div>
                <div class="card-body">
                    <ol class="small mb-0">
                        <li class="mb-2">Go to Stripe Dashboard → Developers → API keys</li>
                        <li class="mb-2">Copy your Publishable and Secret keys</li>
                        <li class="mb-2">Go to Webhooks → Add endpoint</li>
                        <li class="mb-2">Paste the webhook URL above</li>
                        <li class="mb-2">Select events: <code>checkout.session.completed</code>, <code>payment_intent.payment_failed</code></li>
                        <li>Copy the Signing secret to Webhook Secret field</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection
