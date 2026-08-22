@extends('layouts.app')

@section('title', 'Request Payout - Live IPTV Now')

@section('content')
<!-- Page Hero Section -->
<section class="page-hero">
    <div class="page-hero-bg">
        <div class="page-hero-pattern"></div>
        <div class="page-hero-glow page-hero-glow-1"></div>
        <div class="page-hero-glow page-hero-glow-2"></div>
    </div>
    
    <div class="container">
        <div class="page-hero-content">
            <div class="page-hero-text" data-aos="fade-right" data-aos-duration="800">
                <h1 class="page-hero-title">
                    Request <span class="text-gradient">Payout</span>
                </h1>
                <p class="page-hero-subtitle">
                    Withdraw your earned commissions securely. Choose your preferred payment method.
                </p>
                <div class="hero-cta" style="margin-top: 1.5rem;">
                    <a href="{{ route('affiliate.payouts') }}" class="btn btn-glass btn-lg">
                        <i class="ri-arrow-left-line"></i>
                        Back to Payouts
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Form Section -->
<section class="features-section" style="background: var(--gray-50);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <!-- Balance Card -->
                <div class="balance-card" data-aos="fade-up">
                    <div class="balance-content">
                        <div class="balance-info">
                            <span class="balance-label">Paid Earnings</span>
                            <span class="balance-amount">${{ number_format($affiliate->paid_earnings, 2) }}</span>
                        </div>
                        <div class="balance-icon">
                            <i class="ri-wallet-fill"></i>
                        </div>
                    </div>
                </div>

                @if(session('success'))
                    <div class="alert alert-success" data-aos="fade-up">
                        <i class="ri-checkbox-circle-fill"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger" data-aos="fade-up">
                        <i class="ri-close-circle-fill"></i>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                @if($affiliate->paid_earnings < 50)
                    <!-- Minimum Payout Warning -->
                    <div class="feature-card" style="background: rgba(239, 68, 68, 0.05); border: 2px solid rgba(239, 68, 68, 0.2);" data-aos="fade-up">
                        <div class="feature-icon" style="background: rgba(239, 68, 68, 0.1);">
                            <i class="ri-error-warning-fill" style="color: #DC2626;"></i>
                        </div>
                        <h3 class="feature-title" style="color: #DC2626;">Minimum Payout Not Reached</h3>
                        <p class="feature-desc">
                            You need <strong>${{ number_format(50 - $affiliate->paid_earnings, 2) }}</strong> more to request a payout.
                            The minimum payout amount is <strong>$50.00</strong>.
                        </p>
                        <a href="{{ route('profile') }}#affiliate" class="btn btn-outline" style="margin-top: 1rem;">
                            <i class="ri-arrow-left-fill"></i>
                            Continue Earning
                        </a>
                    </div>
                @else
                    <!-- Payout Request Form -->
                    <div class="feature-card" data-aos="fade-up" data-aos-delay="100">
                        <form action="{{ route('affiliate.payout.submit') }}" method="POST">
                            @csrf

                            <!-- Amount -->
                            <div class="form-group">
                                <label for="amount" class="form-label">
                                    Payout Amount <span style="color: var(--danger);">*</span>
                                </label>
                                <div class="input-group-custom">
                                    <span class="input-prefix">$</span>
                                    <input type="number" 
                                           class="form-control-custom @error('amount') is-invalid @enderror" 
                                           id="amount" 
                                           name="amount" 
                                           step="0.01" 
                                           min="50" 
                                           max="{{ $affiliate->paid_earnings }}"
                                           value="{{ old('amount', $affiliate->paid_earnings) }}"
                                           required
                                           placeholder="Enter amount">
                                </div>
                                @error('amount')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                                <small class="form-hint">Maximum: ${{ number_format($affiliate->paid_earnings, 2) }}</small>
                            </div>

                            <!-- Payment Method -->
                            <div class="form-group">
                                <label class="form-label">
                                    Payment Method <span style="color: var(--danger);">*</span>
                                </label>
                                <div class="payment-methods">
                                    <div class="payment-option">
                                        <input type="radio" name="payment_method" id="paypal" value="paypal" {{ old('payment_method') === 'paypal' ? 'checked' : '' }}>
                                        <label for="paypal">
                                            <div class="payment-icon" style="color: #0070BA;">
                                                <i class="ri-paypal-fill"></i>
                                            </div>
                                            <div class="payment-info">
                                                <strong>PayPal</strong>
                                                <span>Fast and secure payment</span>
                                            </div>
                                        </label>
                                    </div>

                                    <div class="payment-option">
                                        <input type="radio" name="payment_method" id="bank_transfer" value="bank_transfer" {{ old('payment_method') === 'bank_transfer' ? 'checked' : '' }}>
                                        <label for="bank_transfer">
                                            <div class="payment-icon" style="color: var(--primary-500);">
                                                <i class="ri-bank-fill"></i>
                                            </div>
                                            <div class="payment-info">
                                                <strong>Bank Transfer</strong>
                                                <span>Direct to your bank account</span>
                                            </div>
                                        </label>
                                    </div>

                                    <div class="payment-option">
                                        <input type="radio" name="payment_method" id="crypto" value="crypto" {{ old('payment_method') === 'crypto' ? 'checked' : '' }}>
                                        <label for="crypto">
                                            <div class="payment-icon" style="color: #F7931A;">
                                                <i class="ri-bitcoin-fill"></i>
                                            </div>
                                            <div class="payment-info">
                                                <strong>Cryptocurrency</strong>
                                                <span>Bitcoin, USDT, etc.</span>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                                @error('payment_method')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- PayPal Fields -->
                            <div id="paypal-fields" class="payment-fields" style="display: none;">
                                <div class="form-group">
                                    <label for="paypal_email" class="form-label">
                                        PayPal Email <span style="color: var(--danger);">*</span>
                                    </label>
                                    <input type="email" 
                                           class="form-control-custom @error('paypal_email') is-invalid @enderror" 
                                           id="paypal_email" 
                                           name="paypal_email" 
                                           value="{{ old('paypal_email') }}"
                                           placeholder="your@email.com">
                                    @error('paypal_email')
                                        <span class="error-message">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Bank Transfer Fields -->
                            <div id="bank-fields" class="payment-fields" style="display: none;">
                                <div class="form-group">
                                    <label for="bank_name" class="form-label">
                                        Bank Name <span style="color: var(--danger);">*</span>
                                    </label>
                                    <input type="text" 
                                           class="form-control-custom @error('bank_name') is-invalid @enderror" 
                                           id="bank_name" 
                                           name="bank_name" 
                                           value="{{ old('bank_name') }}"
                                           placeholder="Your Bank Name">
                                    @error('bank_name')
                                        <span class="error-message">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="account_holder" class="form-label">
                                        Account Holder Name <span style="color: var(--danger);">*</span>
                                    </label>
                                    <input type="text" 
                                           class="form-control-custom @error('account_holder') is-invalid @enderror" 
                                           id="account_holder" 
                                           name="account_holder" 
                                           value="{{ old('account_holder') }}"
                                           placeholder="John Doe">
                                    @error('account_holder')
                                        <span class="error-message">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="account_number" class="form-label">
                                        Account Number <span style="color: var(--danger);">*</span>
                                    </label>
                                    <input type="text" 
                                           class="form-control-custom @error('account_number') is-invalid @enderror" 
                                           id="account_number" 
                                           name="account_number" 
                                           value="{{ old('account_number') }}"
                                           placeholder="1234567890">
                                    @error('account_number')
                                        <span class="error-message">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Crypto Fields -->
                            <div id="crypto-fields" class="payment-fields" style="display: none;">
                                <div class="form-group">
                                    <label for="crypto_network" class="form-label">
                                        Cryptocurrency Network <span style="color: var(--danger);">*</span>
                                    </label>
                                    <select class="form-control-custom @error('crypto_network') is-invalid @enderror" 
                                            id="crypto_network" 
                                            name="crypto_network">
                                        <option value="">Select Network</option>
                                        <option value="bitcoin" {{ old('crypto_network') === 'bitcoin' ? 'selected' : '' }}>Bitcoin (BTC)</option>
                                        <option value="ethereum" {{ old('crypto_network') === 'ethereum' ? 'selected' : '' }}>Ethereum (ETH)</option>
                                        <option value="usdt-trc20" {{ old('crypto_network') === 'usdt-trc20' ? 'selected' : '' }}>USDT (TRC20)</option>
                                        <option value="usdt-erc20" {{ old('crypto_network') === 'usdt-erc20' ? 'selected' : '' }}>USDT (ERC20)</option>
                                    </select>
                                    @error('crypto_network')
                                        <span class="error-message">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="crypto_address" class="form-label">
                                        Wallet Address <span style="color: var(--danger);">*</span>
                                    </label>
                                    <input type="text" 
                                           class="form-control-custom @error('crypto_address') is-invalid @enderror" 
                                           id="crypto_address" 
                                           name="crypto_address" 
                                           value="{{ old('crypto_address') }}"
                                           placeholder="Enter your wallet address"
                                           style="font-family: monospace;">
                                    @error('crypto_address')
                                        <span class="error-message">{{ $message }}</span>
                                    @enderror
                                    <small class="form-hint">Please double-check your wallet address before submitting</small>
                                </div>
                            </div>

                            <!-- Submit Buttons -->
                            <div class="form-actions">
                                <button type="submit" class="btn btn-primary btn-lg btn-block">
                                    <i class="ri-check-fill"></i>
                                    Submit Payout Request
                                </button>
                                <a href="{{ route('affiliate.payouts') }}" class="btn btn-glass btn-lg btn-block">
                                    <i class="ri-close-line"></i>
                                    Cancel
                                </a>
                            </div>
                        </form>
                    </div>

                    <!-- Info Box -->
                    <div class="feature-card" style="background: var(--primary-50, rgba(0, 102, 255, 0.05)); border: 2px solid var(--primary-100);" data-aos="fade-up" data-aos-delay="200">
                        <div class="feature-icon">
                            <i class="ri-information-fill"></i>
                        </div>
                        <h3 class="feature-title">Payout Information</h3>
                        <ul class="info-list">
                            <li>Payouts are processed within 24-48 hours</li>
                            <li>Minimum payout amount is $50</li>
                            <li>Please ensure your payment details are correct</li>
                            <li>Once processed, you'll receive a confirmation email</li>
                        </ul>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

<style>
/* Balance Card */
.balance-card {
    background: linear-gradient(135deg, var(--primary-500), var(--primary-600));
    border-radius: var(--radius-2xl);
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: var(--shadow-lg);
}

.balance-content {
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.balance-info {
    display: flex;
    flex-direction: column;
}

.balance-label {
    font-size: 0.938rem;
    color: rgba(255, 255, 255, 0.9);
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.balance-amount {
    font-size: 2.5rem;
    font-weight: 800;
    color: white;
}

.balance-icon {
    width: 80px;
    height: 80px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: var(--radius-xl);
    display: flex;
    align-items: center;
    justify-content: center;
}

.balance-icon i {
    font-size: 2.5rem;
    color: white;
}

/* Alerts */
.alert {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem 1.5rem;
    border-radius: var(--radius-xl);
    margin-bottom: 2rem;
    font-weight: 600;
}

.alert-success {
    background: var(--success-light, #D1FAE5);
    color: var(--success-dark, #065F46);
    border: 1px solid var(--success, #10B981);
}

.alert-danger {
    background: rgba(239, 68, 68, 0.1);
    color: #991B1B;
    border: 1px solid rgba(239, 68, 68, 0.3);
}

.alert i {
    font-size: 1.5rem;
}

/* Form Groups */
.form-group {
    margin-bottom: 2rem;
}

.form-label {
    display: block;
    font-weight: 700;
    font-size: 0.938rem;
    color: var(--gray-900);
    margin-bottom: 0.75rem;
}

/* Form Controls */
.form-control-custom {
    width: 100%;
    padding: 0.875rem 1.25rem;
    font-size: 1rem;
    color: var(--gray-900);
    background: var(--white);
    border: 2px solid var(--gray-200);
    border-radius: var(--radius-lg);
    transition: all var(--transition);
}

.form-control-custom:focus {
    outline: none;
    border-color: var(--primary-500);
    box-shadow: 0 0 0 4px var(--primary-50, rgba(0, 102, 255, 0.1));
}

.form-control-custom.is-invalid {
    border-color: #EF4444;
}

/* Input Group */
.input-group-custom {
    position: relative;
    display: flex;
    align-items: center;
}

.input-prefix {
    position: absolute;
    left: 1.25rem;
    font-weight: 700;
    font-size: 1.125rem;
    color: var(--gray-600);
    z-index: 1;
}

.input-group-custom .form-control-custom {
    padding-left: 2.5rem;
}

/* Payment Methods */
.payment-methods {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.payment-option {
    position: relative;
}

.payment-option input[type="radio"] {
    position: absolute;
    opacity: 0;
}

.payment-option label {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1.25rem 1.5rem;
    background: var(--white);
    border: 2px solid var(--gray-200);
    border-radius: var(--radius-lg);
    cursor: pointer;
    transition: all var(--transition);
}

.payment-option input[type="radio"]:checked + label {
    border-color: var(--primary-500);
    background: var(--primary-50, rgba(0, 102, 255, 0.05));
}

.payment-option label:hover {
    border-color: var(--primary-300);
}

.payment-icon {
    width: 48px;
    height: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.payment-icon i {
    font-size: 1.75rem;
}

.payment-info {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.payment-info strong {
    font-size: 1rem;
    color: var(--gray-900);
}

.payment-info span {
    font-size: 0.875rem;
    color: var(--gray-500);
}

/* Payment Fields */
.payment-fields {
    padding-top: 1rem;
}

/* Error Message */
.error-message {
    display: block;
    color: #DC2626;
    font-size: 0.875rem;
    margin-top: 0.5rem;
}

/* Form Hint */
.form-hint {
    display: block;
    color: var(--gray-500);
    font-size: 0.875rem;
    margin-top: 0.5rem;
}

/* Form Actions */
.form-actions {
    display: flex;
    gap: 1rem;
    margin-top: 2rem;
}

.btn-block {
    flex: 1;
}

/* Info List */
.info-list {
    margin: 1rem 0 0;
    padding-left: 1.5rem;
    color: var(--gray-700);
}

.info-list li {
    margin-bottom: 0.5rem;
    font-size: 0.938rem;
}

@media (max-width: 768px) {
    .balance-content {
        flex-direction: column;
        text-align: center;
        gap: 1.5rem;
    }
    
    .balance-card { padding: 20px 16px; }
    
    .form-actions {
        flex-direction: column;
    }
}
@media (max-width: 480px) {
    .balance-amount { font-size: 1.5rem; }
    .payment-option label { padding: 1rem; }
    .form-control-custom { padding: 0.75rem 1rem; font-size: 0.9rem; }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const paymentMethods = document.querySelectorAll('input[name="payment_method"]');
    const paypalFields = document.getElementById('paypal-fields');
    const bankFields = document.getElementById('bank-fields');
    const cryptoFields = document.getElementById('crypto-fields');

    paymentMethods.forEach(method => {
        method.addEventListener('change', function() {
            // Hide all payment fields
            if(paypalFields) paypalFields.style.display = 'none';
            if(bankFields) bankFields.style.display = 'none';
            if(cryptoFields) cryptoFields.style.display = 'none';

            // Show selected payment method fields
            if (this.value === 'paypal' && paypalFields) {
                paypalFields.style.display = 'block';
            } else if (this.value === 'bank_transfer' && bankFields) {
                bankFields.style.display = 'block';
            } else if (this.value === 'crypto' && cryptoFields) {
                cryptoFields.style.display = 'block';
            }
        });
    });

    // Trigger change event on page load if a method is selected
    const selectedMethod = document.querySelector('input[name="payment_method"]:checked');
    if (selectedMethod) {
        selectedMethod.dispatchEvent(new Event('change'));
    }
});
</script>
@endsection
