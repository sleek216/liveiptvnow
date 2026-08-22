@extends('admin.layouts.app')

@section('title', 'NOWPayments Settings')

@section('breadcrumb')
    <li class="breadcrumb-item">Settings</li>
    <li class="breadcrumb-item active">NOWPayments</li>
@endsection

@section('content')
    <div class="mb-4">
        <h1 class="page-title">NOWPayments Crypto Gateway</h1>
        <p class="text-muted mb-0">Configure your NOWPayments API for cryptocurrency payments</p>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.settings.update-nowpayments') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="alert alert-info mb-4">
                            <i class="bi bi-info-circle me-2"></i>
                            Get your API keys from <a href="https://account.nowpayments.io/" target="_blank" class="alert-link">NOWPayments Dashboard</a>
                        </div>

                        <!-- Enable/Disable -->
                        <div class="mb-4">
                            <div class="form-check form-switch">
                                <input type="hidden" name="nowpayments_enabled" value="0">
                                <input class="form-check-input" type="checkbox" id="nowpayments_enabled" name="nowpayments_enabled" value="1" {{ ($nowpaymentsSettings['nowpayments_enabled'] ?? '0') == '1' ? 'checked' : '' }}>
                                <label class="form-check-label" for="nowpayments_enabled">
                                    <strong>Enable NOWPayments</strong>
                                </label>
                            </div>
                            <small class="text-muted">Allow customers to pay with cryptocurrency</small>
                        </div>

                        <!-- Sandbox Mode -->
                        <div class="mb-4">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="nowpayments_sandbox" name="nowpayments_sandbox" value="1" {{ ($nowpaymentsSettings['nowpayments_sandbox'] ?? '1') == '1' ? 'checked' : '' }}>
                                <label class="form-check-label" for="nowpayments_sandbox">
                                    <strong>Sandbox Mode</strong>
                                </label>
                            </div>
                            <small class="text-muted">Use sandbox for testing, disable for production</small>
                        </div>

                        <!-- API Key -->
                        <div class="mb-3">
                            <label for="nowpayments_api_key" class="form-label">API Key *</label>
                            <input type="password" class="form-control @error('nowpayments_api_key') is-invalid @enderror" id="nowpayments_api_key" name="nowpayments_api_key" value="{{ $nowpaymentsSettings['nowpayments_api_key'] ?? '' }}" placeholder="Enter your NOWPayments API key">
                            @error('nowpayments_api_key')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Your NOWPayments API key from the dashboard</small>
                        </div>

                        <!-- IPN Secret -->
                        <div class="mb-3">
                            <label for="nowpayments_ipn_secret" class="form-label">IPN Secret Key</label>
                            <input type="password" class="form-control @error('nowpayments_ipn_secret') is-invalid @enderror" id="nowpayments_ipn_secret" name="nowpayments_ipn_secret" value="{{ $nowpaymentsSettings['nowpayments_ipn_secret'] ?? '' }}" placeholder="Enter your IPN secret key">
                            @error('nowpayments_ipn_secret')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Required for secure webhook verification</small>
                        </div>

                        <!-- Default Currency -->
                        <div class="mb-4">
                            <label for="nowpayments_default_currency" class="form-label">Default Cryptocurrency</label>
                            <select class="form-select @error('nowpayments_default_currency') is-invalid @enderror" id="nowpayments_default_currency" name="nowpayments_default_currency">
                                <option value="btc" {{ ($nowpaymentsSettings['nowpayments_default_currency'] ?? '') == 'btc' ? 'selected' : '' }}>Bitcoin (BTC)</option>
                                <option value="eth" {{ ($nowpaymentsSettings['nowpayments_default_currency'] ?? '') == 'eth' ? 'selected' : '' }}>Ethereum (ETH)</option>
                                <option value="usdttrc20" {{ ($nowpaymentsSettings['nowpayments_default_currency'] ?? 'usdttrc20') == 'usdttrc20' ? 'selected' : '' }}>USDT (TRC20)</option>
                                <option value="usdterc20" {{ ($nowpaymentsSettings['nowpayments_default_currency'] ?? '') == 'usdterc20' ? 'selected' : '' }}>USDT (ERC20)</option>
                                <option value="ltc" {{ ($nowpaymentsSettings['nowpayments_default_currency'] ?? '') == 'ltc' ? 'selected' : '' }}>Litecoin (LTC)</option>
                                <option value="trx" {{ ($nowpaymentsSettings['nowpayments_default_currency'] ?? '') == 'trx' ? 'selected' : '' }}>Tron (TRX)</option>
                                <option value="bnbbsc" {{ ($nowpaymentsSettings['nowpayments_default_currency'] ?? '') == 'bnbbsc' ? 'selected' : '' }}>BNB (BSC)</option>
                                <option value="xrp" {{ ($nowpaymentsSettings['nowpayments_default_currency'] ?? '') == 'xrp' ? 'selected' : '' }}>Ripple (XRP)</option>
                            </select>
                            @error('nowpayments_default_currency')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Default cryptocurrency for payments (customers can choose others)</small>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-lg me-2"></i>Save Settings
                            </button>
                            <button type="button" class="btn btn-outline-primary" onclick="testConnection()">
                                <i class="bi bi-wifi me-2"></i>Test Connection
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- IPN Callback URL -->
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-webhook me-2"></i>IPN Callback URL
                </div>
                <div class="card-body">
                    <p class="text-muted small mb-2">Configure this URL in your NOWPayments Dashboard:</p>
                    <div class="bg-light p-2 rounded">
                        <code class="small">{{ route('nowpayments.ipn') }}</code>
                    </div>
                    <button onclick="navigator.clipboard.writeText('{{ route('nowpayments.ipn') }}')" class="btn btn-outline-secondary btn-sm mt-2">
                        <i class="bi bi-clipboard me-1"></i>Copy
                    </button>
                </div>
            </div>

            <!-- Supported Cryptocurrencies -->
            <div class="card mt-4">
                <div class="card-header">
                    <i class="bi bi-currency-bitcoin me-2"></i>Supported Cryptocurrencies
                </div>
                <div class="card-body">
                    <div class="d-flex flex-wrap gap-2">
                        <span class="badge bg-primary">Bitcoin</span>
                        <span class="badge bg-primary">Ethereum</span>
                        <span class="badge bg-primary">USDT</span>
                        <span class="badge bg-primary">Litecoin</span>
                        <span class="badge bg-primary">Tron</span>
                        <span class="badge bg-primary">BNB</span>
                        <span class="badge bg-primary">XRP</span>
                        <span class="badge bg-primary">+300 more</span>
                    </div>
                    <p class="text-muted small mt-3 mb-0">NOWPayments supports 300+ cryptocurrencies for payments</p>
                </div>
            </div>

            <!-- Setup Instructions -->
            <div class="card mt-4">
                <div class="card-header">
                    <i class="bi bi-book me-2"></i>Setup Instructions
                </div>
                <div class="card-body">
                    <ol class="small mb-0">
                        <li class="mb-2">Create account at <a href="https://nowpayments.io/" target="_blank">NOWPayments.io</a></li>
                        <li class="mb-2">Go to Settings → API Keys</li>
                        <li class="mb-2">Generate or copy your API key</li>
                        <li class="mb-2">Generate IPN Secret Key</li>
                        <li class="mb-2">Paste both keys in the form</li>
                        <li class="mb-2">Add the IPN Callback URL to your NOWPayments settings</li>
                        <li>Test the connection and enable the gateway</li>
                    </ol>
                </div>
            </div>

            <!-- Benefits -->
            <div class="card mt-4">
                <div class="card-header">
                    <i class="bi bi-star me-2"></i>Why NOWPayments?
                </div>
                <div class="card-body">
                    <ul class="small mb-0">
                        <li class="mb-2">✓ Low fees (0.5%)</li>
                        <li class="mb-2">✓ 300+ cryptocurrencies</li>
                        <li class="mb-2">✓ Instant settlements</li>
                        <li class="mb-2">✓ No chargebacks</li>
                        <li class="mb-2">✓ Global reach</li>
                        <li>✓ 24/7 support</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <script>
        function testConnection() {
            const btn = event.target;
            const originalText = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Testing...';

            fetch('{{ route('admin.settings.test-nowpayments') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                btn.disabled = false;
                btn.innerHTML = originalText;
                
                if (data.success) {
                    alert('✓ Connection successful! NOWPayments API is working correctly.');
                } else {
                    alert('✗ Connection failed: ' + (data.error || 'Unknown error'));
                }
            })
            .catch(error => {
                btn.disabled = false;
                btn.innerHTML = originalText;
                alert('✗ Connection test failed. Please check your API key.');
            });
        }
    </script>
@endsection
