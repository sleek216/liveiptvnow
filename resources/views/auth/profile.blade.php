@extends('layouts.app')

@section('title', 'My Profile - Live IPTV Now')

@section('content')
<div class="profile-page-wrapper">
    <!-- Background Elements -->
    <div class="profile-bg">
        <div class="profile-bg-gradient"></div>
        <div class="profile-bg-pattern"></div>
        <div class="profile-glow profile-glow-1"></div>
        <div class="profile-glow profile-glow-2"></div>
    </div>

    <div class="container">
        <!-- Profile Header -->
        <div class="profile-header" data-aos="fade-down">
            <div class="profile-header-content">
                <div class="header-avatar-section">
                    <div class="profile-avatar-wrapper">
                        <div class="profile-avatar">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <div class="profile-status-badge">
                            <span class="status-indicator"></span>
                            <span>Active Member</span>
                        </div>
                    </div>
                </div>
                
                <div class="header-info-section">
                    <div class="header-top">
                        <h1 class="profile-welcome">Welcome back, <span class="text-gradient">{{ $user->name }}</span></h1>
                        <div class="profile-badges">
                            <span class="badge badge-glass">
                                <i class="ri-user-fill"></i> {{ $user->email }}
                            </span>
                            @if($user->isAdmin())
                            <span class="badge badge-admin">
                                <i class="ri-vip-crown-fill"></i> Administrator
                            </span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="header-stats">
                        <div class="header-stat-item">
                            <div class="stat-icon">
                                <i class="ri-shopping-cart-fill"></i>
                            </div>
                            <div class="stat-text">
                                <span class="stat-value">{{ $orders->count() }}</span>
                                <span class="stat-label">Total Orders</span>
                            </div>
                        </div>
                        <div class="header-stat-item">
                            <div class="stat-icon icon-success">
                                <i class="ri-checkbox-circle-fill"></i>
                            </div>
                            <div class="stat-text">
                                <span class="stat-value">{{ $orders->where('is_active', true)->count() }}</span>
                                <span class="stat-label">Active Plans</span>
                            </div>
                        </div>
                        <div class="header-stat-item">
                            <div class="stat-icon icon-purple">
                                <i class="ri-money-dollar-circle-fill"></i>
                            </div>
                            <div class="stat-text">
                                <span class="stat-value">${{ number_format($orders->sum('amount'), 0) }}</span>
                                <span class="stat-label">Total Spent</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="profile-layout-grid">
            <!-- Sidebar Navigation -->
            <aside class="profile-sidebar" data-aos="fade-right" data-aos-delay="100">
                <div class="sidebar-menu">
                    <a href="#overview" class="sidebar-link active" onclick="switchTab(event, 'overview')">
                        <i class="ri-grid-fill"></i>
                        <span>Overview</span>
                    </a>
                    <a href="#settings" class="sidebar-link" onclick="switchTab(event, 'settings')">
                        <i class="ri-settings-4-fill"></i>
                        <span>Account Settings</span>
                    </a>
                    <a href="#security" class="sidebar-link" onclick="switchTab(event, 'security')">
                        <i class="ri-lock-password-fill"></i>
                        <span>Security</span>
                    </a>

                    <a href="#affiliate" class="sidebar-link" onclick="switchTab(event, 'affiliate')">
                        <i class="ri-gift-fill"></i>
                        <span>Affiliate Program</span>
                    </a>
                    
                    <div class="sidebar-divider"></div>
                    
                    @if($user->isAdmin())
                    <a href="{{ route(auth()->user()->adminHomeRouteName()) }}" class="sidebar-link link-admin">
                        <i class="ri-computer-fill"></i>
                        <span>Admin Dashboard</span>
                    </a>
                    @endif
                    
                    <a href="{{ route('packages.index') }}" class="sidebar-link link-primary">
                        <i class="ri-add-circle-fill"></i>
                        <span>Buy New Package</span>
                    </a>
                    
                    <form action="{{ route('logout') }}" method="POST" class="logout-form">
                        @csrf
                        <button type="submit" class="sidebar-link link-danger">
                            <i class="ri-logout-box-fill"></i>
                            <span>Logout</span>
                        </button>
                    </form>
                </div>
            </aside>

            <!-- Main Content Area -->
            <main class="profile-main-content">
                <!-- Alerts -->
                @if(session('success'))
                <div class="alert-glass alert-success" data-aos="fade-in">
                    <div class="alert-icon"><i class="ri-checkbox-circle-fill"></i></div>
                    <div class="alert-message">{{ session('success') }}</div>
                    <button class="alert-close" onclick="this.parentElement.remove()"><i class="ri-close-line"></i></button>
                </div>
                @endif

                @if($errors->any())
                <div class="alert-glass alert-error" data-aos="fade-in">
                    <div class="alert-icon"><i class="ri-error-warning-fill"></i></div>
                    <div class="alert-message">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                @endif

                <!-- Overview Tab -->
                <div id="overview" class="tab-content active" data-aos="fade-up" data-aos-delay="200">
                    <div class="content-header">
                        <h2>Order History</h2>
                        <p>Manage your subscriptions and view past orders</p>
                    </div>

                    <div class="orders-container">
                        @forelse($orders as $order)
                        <div class="order-card-glass">
                            <div class="order-status-line {{ $order->is_active ? 'active' : 'expired' }}"></div>
                            <div class="order-main-info">
                                <div class="order-package-icon">
                                    <i class="ri-tv-fill"></i>
                                </div>
                                <div class="order-details">
                                    <h3>{{ $order->package->name ?? 'Premium Package' }}</h3>
                                    <span class="order-id">#{{ $order->order_number }}</span>
                                </div>
                            </div>
                            
                            <div class="order-meta-info">
                                <div class="meta-item">
                                    <span class="meta-label">Duration</span>
                                    <span class="meta-value">{{ $order->package->duration_label ?? '1 Month' }}</span>
                                </div>
                                <div class="meta-item">
                                    <span class="meta-label">Amount</span>
                                    <span class="meta-value price">${{ number_format($order->amount, 0) }}</span>
                                </div>
                                <div class="meta-item">
                                    <span class="meta-label">Status</span>
                                    <span class="status-badge {{ $order->is_active ? 'status-active' : 'status-expired' }}">
                                        {{ $order->is_active ? 'Active' : ucfirst($order->order_status) }}
                                    </span>
                                </div>
                            </div>
                            
                            <div class="order-actions">
                                @if($order->expires_at)
                                <div class="expiry-date">
                                    <i class="ri-calendar-line"></i>
                                    <span>{{ $order->is_active ? 'Expires' : 'Expired' }} {{ $order->expires_at->format('M d, Y') }}</span>
                                </div>
                                @endif
                                @if(!$order->is_active)
                                <a href="{{ $order->package ? route('checkout.show', $order->package->slug) : route('packages.index') }}" class="btn-renew">
                                    Renew Now
                                </a>
                                @endif
                            </div>
                        </div>
                        @empty
                        <div class="empty-state-glass">
                            <div class="empty-icon">
                                <i class="ri-shopping-cart-line"></i>
                            </div>
                            <h3>No active subscriptions</h3>
                            <p>You haven't purchased any packages yet. Start streaming today!</p>
                            <a href="{{ route('packages.index') }}" class="btn-primary-glow">
                                Browse Packages <i class="ri-arrow-right-line"></i>
                            </a>
                        </div>
                        @endforelse
                    </div>
                </div>

                <!-- Settings Tab -->
                <div id="settings" class="tab-content" style="display: none;">
                    <div class="content-header">
                        <h2>Account Settings</h2>
                        <p>Update your personal information</p>
                    </div>

                    <div class="glass-form-card">
                        <form action="{{ route('profile.update') }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div class="form-grid">
                                <div class="form-group">
                                    <label>Full Name</label>
                                    <div class="input-wrapper">
                                        <i class="ri-user-line"></i>
                                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required placeholder="Your Name">
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label>Email Address</label>
                                    <div class="input-wrapper">
                                        <i class="ri-mail-line"></i>
                                        <input type="email" name="email" value="{{ old('email', $user->email) }}" required placeholder="email@example.com">
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label>Phone Number relative</label>
                                    <div class="input-wrapper">
                                        <i class="ri-phone-line"></i>
                                        <input type="tel" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="+1 (555) 000-0000">
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label>Country</label>
                                    <div class="input-wrapper">
                                        <i class="ri-globe-line"></i>
                                        <input type="text" name="country" value="{{ old('country', $user->country) }}" placeholder="Your Country">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-actions">
                                <button type="submit" class="btn-primary-glow">
                                    Save Changes
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Security Tab -->
                <div id="security" class="tab-content" style="display: none;">
                    <div class="content-header">
                        <h2>Security</h2>
                        <p>Protect your account with a strong password</p>
                    </div>

                    <div class="glass-form-card">
                        <form action="{{ route('profile.password') }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div class="form-group">
                                <label>Current Password</label>
                                <div class="input-wrapper">
                                    <i class="ri-lock-unlock-line"></i>
                                    <input type="password" name="current_password" required placeholder="Enter current password">
                                </div>
                            </div>
                            
                            <div class="form-grid">
                                <div class="form-group">
                                    <label>New Password</label>
                                    <div class="input-wrapper">
                                        <i class="ri-lock-password-line"></i>
                                        <input type="password" name="password" required placeholder="Min 8 characters">
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label>Confirm Password</label>
                                    <div class="input-wrapper">
                                        <i class="ri-checkbox-line"></i>
                                        <input type="password" name="password_confirmation" required placeholder="Confirm new password">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-actions">
                                <button type="submit" class="btn-primary-glow">
                                    Update Password
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Affiliate Tab -->
                <div id="affiliate" class="tab-content" style="display: none;">
                    <div class="content-header">
                        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px;">
                            <div>
                                <h2>Affiliate Program</h2>
                                <p>Share your link, earn {{ number_format($affiliate->getCommissionRate(), 0) }}% on every package purchase</p>
                            </div>
                            <span class="badge badge-success" style="background: rgba(16, 185, 129, 0.1); color: #10b981; border: 1px solid rgba(16, 185, 129, 0.2);">
                                <i class="ri-checkbox-circle-fill"></i> Active
                            </span>
                        </div>
                    </div>

                    <!-- Stats Grid -->
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 16px; margin-bottom: 30px;">

                        <div class="order-card-glass" style="display: block; padding: 20px;">
                            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px;">
                                <div class="stat-icon" style="width: 40px; height: 40px; background: rgba(139, 92, 246, 0.1); color: #8b5cf6; font-size: 1.25rem;"><i class="ri-user-add-fill"></i></div>
                                <h3 style="font-size: 0.875rem; color: var(--text-secondary); text-transform: uppercase;">Signups</h3>
                            </div>
                            <p style="font-size: 1.75rem; font-weight: 700; color: #0f172a; margin: 0;">{{ $stats['total_referrals'] ?? 0 }}</p>
                            <p style="font-size: 0.8rem; color: #64748b; margin: 6px 0 0;">Users joined via your link</p>
                        </div>

                        <div class="order-card-glass" style="display: block; padding: 20px;">
                            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px;">
                                <div class="stat-icon" style="width: 40px; height: 40px; background: rgba(59, 130, 246, 0.1); color: #3b82f6; font-size: 1.25rem;"><i class="ri-shopping-bag-fill"></i></div>
                                <h3 style="font-size: 0.875rem; color: var(--text-secondary); text-transform: uppercase;">Purchases</h3>
                            </div>
                            <p style="font-size: 1.75rem; font-weight: 700; color: #0f172a; margin: 0;">{{ $stats['total_sales'] ?? 0 }}</p>
                            <p style="font-size: 0.8rem; color: #64748b; margin: 6px 0 0;">Packages bought by referrals</p>
                        </div>

                        <div class="order-card-glass" style="display: block; padding: 20px;">
                            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px;">
                                <div class="stat-icon" style="width: 40px; height: 40px; font-size: 1.25rem;"><i class="ri-money-dollar-circle-fill"></i></div>
                                <h3 style="font-size: 0.875rem; color: var(--text-secondary); text-transform: uppercase;">Total Earned</h3>
                            </div>
                            <p style="font-size: 1.75rem; font-weight: 700; color: #0f172a; margin: 0;">${{ number_format($stats['total_earnings'] ?? 0, 2) }}</p>
                        </div>

                        <div class="order-card-glass" style="display: block; padding: 20px;">
                            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px;">
                                <div class="stat-icon" style="width: 40px; height: 40px; background: rgba(245, 158, 11, 0.1); color: #f59e0b; font-size: 1.25rem;"><i class="ri-time-fill"></i></div>
                                <h3 style="font-size: 0.875rem; color: var(--text-secondary); text-transform: uppercase;">Pending</h3>
                            </div>
                            <p style="font-size: 1.75rem; font-weight: 700; color: #0f172a; margin: 0;">${{ number_format($stats['pending_earnings'] ?? 0, 2) }}</p>
                            <p style="font-size: 0.8rem; color: #64748b; margin: 6px 0 0;">Awaiting admin approval</p>
                        </div>

                        <div class="order-card-glass" style="display: block; padding: 20px;">
                            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px;">
                                <div class="stat-icon" style="width: 40px; height: 40px; background: rgba(16, 185, 129, 0.1); color: #10b981; font-size: 1.25rem;"><i class="ri-checkbox-circle-fill"></i></div>
                                <h3 style="font-size: 0.875rem; color: var(--text-secondary); text-transform: uppercase;">Approved</h3>
                            </div>
                            <p style="font-size: 1.75rem; font-weight: 700; color: #0f172a; margin: 0;">${{ number_format($stats['paid_earnings'] ?? 0, 2) }}</p>
                            <p style="font-size: 0.8rem; color: #64748b; margin: 6px 0 0;">Ready for payout</p>
                        </div>

                        <div class="order-card-glass" style="display: block; padding: 20px;">
                            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px;">
                                <div class="stat-icon" style="width: 40px; height: 40px; background: rgba(255, 77, 28, 0.1); color: #ff4d1c; font-size: 1.25rem;"><i class="ri-percent-fill"></i></div>
                                <h3 style="font-size: 0.875rem; color: var(--text-secondary); text-transform: uppercase;">Your Rate</h3>
                            </div>
                            <p style="font-size: 1.75rem; font-weight: 700; color: #0f172a; margin: 0;">{{ number_format($affiliate->getCommissionRate(), 0) }}%</p>
                            <p style="font-size: 0.8rem; color: #64748b; margin: 6px 0 0;">
                                @if($affiliate->custom_commission_rate)
                                    Custom rate set by admin
                                @else
                                    Default program rate
                                @endif
                            </p>
                        </div>

                    </div>

                    <!-- Referral Link & Code -->
                    <div class="glass-form-card" style="background: rgba(37, 99, 235, 0.04); border: 1px solid rgba(37, 99, 235, 0.15);">
                        <h3 style="font-size: 1.25rem; font-weight: 600; color: #0f172a; margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
                            <i class="ri-link-fill"></i> Your Referral Tools
                        </h3>
                        
                        <div class="form-grid">
                            <div class="form-group">
                                <label style="color: #64748b;">Referral Link</label>
                                <div class="input-wrapper" style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px;">
                                    <i class="ri-link-line"></i>
                                    <input type="text" id="referralLink" value="{{ auth()->user()->referral_link }}" readonly style="background: transparent; border: none; font-family: monospace;">
                                    <button type="button" onclick="copyToClipboard('referralLink', this)" style="background: #f1f5f9; border: 1px solid #e2e8f0; color: #475569; padding: 4px 12px; border-radius: 6px; cursor: pointer;">
                                        <i class="ri-file-copy-line"></i>
                                    </button>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label style="color: #64748b;">Referral Code</label>
                                <div class="input-wrapper" style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px;">
                                    <i class="ri-price-tag-3-line"></i>
                                    <input type="text" id="referralCode" value="{{ $affiliate->referral_code }}" readonly style="background: transparent; border: none; font-family: monospace; font-weight: bold; letter-spacing: 1px;">
                                    <button type="button" onclick="copyToClipboard('referralCode', this)" style="background: #f1f5f9; border: 1px solid #e2e8f0; color: #475569; padding: 4px 12px; border-radius: 6px; cursor: pointer;">
                                        <i class="ri-file-copy-line"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="form-grid" style="grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-bottom: 30px;">
                        <a href="{{ route('affiliate.referrals') }}" class="btn-primary-glow" style="text-align: center; background: #f8fafc; border: 1px solid #e2e8f0; color: #0f172a; box-shadow: none;">
                            <i class="ri-group-line"></i> View Referrals
                        </a>
                        <a href="{{ route('affiliate.commissions') }}" class="btn-primary-glow" style="text-align: center; background: #f8fafc; border: 1px solid #e2e8f0; color: #0f172a; box-shadow: none;">
                            <i class="ri-receipt-line"></i> Commissions
                        </a>
                        <a href="{{ route('affiliate.payouts') }}" class="btn-primary-glow" style="text-align: center; background: #f8fafc; border: 1px solid #e2e8f0; color: #0f172a; box-shadow: none;">
                            <i class="ri-wallet-3-line"></i> Payouts
                        </a>
                    </div>

                    @if(($stats['recent_commissions'] ?? collect())->count() > 0)
                    <div class="glass-form-card" style="margin-top: 0;">
                        <h3 style="font-size: 1.15rem; font-weight: 600; color: #0f172a; margin-bottom: 16px;">
                            <i class="ri-history-line"></i> Recent Commissions
                        </h3>
                        <div style="overflow-x: auto;">
                            <table style="width: 100%; border-collapse: collapse; min-width: 520px;">
                                <thead>
                                    <tr style="border-bottom: 1px solid #e2e8f0;">
                                        <th style="padding: 10px 12px; text-align: left; color: #64748b; font-size: 0.8rem;">Date</th>
                                        <th style="padding: 10px 12px; text-align: left; color: #64748b; font-size: 0.8rem;">Sale</th>
                                        <th style="padding: 10px 12px; text-align: left; color: #64748b; font-size: 0.8rem;">Rate</th>
                                        <th style="padding: 10px 12px; text-align: left; color: #64748b; font-size: 0.8rem;">Commission</th>
                                        <th style="padding: 10px 12px; text-align: left; color: #64748b; font-size: 0.8rem;">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($stats['recent_commissions'] as $commission)
                                    <tr style="border-bottom: 1px solid #f1f5f9;">
                                        <td style="padding: 12px; font-size: 0.875rem;">{{ $commission->created_at->format('M d, Y') }}</td>
                                        <td style="padding: 12px; font-size: 0.875rem;">${{ number_format($commission->order_amount, 2) }}</td>
                                        <td style="padding: 12px; font-size: 0.875rem;">{{ $commission->commission_rate }}%</td>
                                        <td style="padding: 12px; font-size: 0.875rem; font-weight: 700; color: #ff4d1c;">${{ number_format($commission->commission_amount, 2) }}</td>
                                        <td style="padding: 12px;">
                                            @if($commission->status === 'approved')
                                                <span style="padding: 4px 10px; background: #d1fae5; color: #065f46; border-radius: 6px; font-size: 0.75rem; font-weight: 600;">Approved</span>
                                            @elseif($commission->status === 'pending')
                                                <span style="padding: 4px 10px; background: #fef3c7; color: #92400e; border-radius: 6px; font-size: 0.75rem; font-weight: 600;">Pending</span>
                                            @elseif($commission->status === 'paid')
                                                <span style="padding: 4px 10px; background: #dbeafe; color: #1e40af; border-radius: 6px; font-size: 0.75rem; font-weight: 600;">Paid</span>
                                            @else
                                                <span style="padding: 4px 10px; background: #fee2e2; color: #991b1b; border-radius: 6px; font-size: 0.75rem; font-weight: 600;">{{ ucfirst($commission->status) }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endif

                </div>
            </main>
        </div>
    </div>
</div>

@endsection

@push('scripts')

<script>
document.addEventListener('DOMContentLoaded', function() {
    if (window.location.hash) {
        const tabId = window.location.hash.substring(1);
        const tabLink = document.querySelector(`.sidebar-link[href="#${tabId}"]`);
        if (tabLink) {
            tabLink.click();
        }
    }
});

function switchTab(event, tabId) {
    if (event) event.preventDefault();
    
    history.pushState(null, null, `#${tabId}`);
    
    document.querySelectorAll('.tab-content').forEach(tab => {
        tab.style.display = 'none';
        tab.classList.remove('active');
    });
    
    const selectedTab = document.getElementById(tabId);
    if (selectedTab) {
        selectedTab.style.display = 'block';
        setTimeout(() => selectedTab.classList.add('active'), 10);
    }
    
    document.querySelectorAll('.sidebar-link').forEach(link => {
        link.classList.remove('active');
    });
    
    const activeLink = document.querySelector(`.sidebar-link[href="#${tabId}"]`);
    if (activeLink) {
        activeLink.classList.add('active');
    }
    
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

function copyToClipboard(elementId, btn) {
    const input = document.getElementById(elementId);
    input.select();
    input.setSelectionRange(0, 99999);
    
    navigator.clipboard.writeText(input.value).then(() => {
        const originalInfo = btn.innerHTML;
        btn.innerHTML = '<i class="ri-check-fill"></i>';
        btn.style.color = '#10b981';
        
        setTimeout(() => {
            btn.innerHTML = originalInfo;
            btn.style.color = '';
        }, 2000);
    });
}
</script>
@endpush

@push('styles')
<style>
/* =========================================
   WHITE + BLUE CLEAN THEME
   Professional Dashboard Design
   ========================================= */

:root {
    --glass-bg: #ffffff;
    --glass-border: #e2e8f0;
    --text-primary: #0f172a;
    --text-secondary: #94a3b8;
    --accent-blue: #2563eb;
    --accent-glow: rgba(37, 99, 235, 0.15);
    --page-bg: #f8fafc;
}

/* Page Wrapper */
.profile-page-wrapper {
    position: relative;
    min-height: 100vh;
    padding-top: 100px;
    padding-bottom: 80px;
    background-color: var(--page-bg);
    overflow-x: hidden;
    color: var(--text-primary);
}

/* Background Effects */
.profile-bg {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 0;
    overflow: hidden;
    pointer-events: none;
}

.profile-bg-gradient {
    position: absolute;
    inset: 0;
    background: linear-gradient(180deg, #eff6ff 0%, #f8fafc 100%);
}

.profile-bg-pattern {
    position: absolute;
    inset: 0;
    background-image: 
        linear-gradient(rgba(37, 99, 235, 0.03) 1px, transparent 1px),
        linear-gradient(90deg, rgba(37, 99, 235, 0.03) 1px, transparent 1px);
    background-size: 50px 50px;
    mask-image: linear-gradient(to bottom, black 0%, transparent 80%);
}

.profile-glow {
    position: absolute;
    border-radius: 50%;
    filter: blur(120px);
    opacity: 0.15;
    animation: glowFloat 10s infinite alternate;
}

.profile-glow-1 {
    width: 600px;
    height: 600px;
    background: rgba(37, 99, 235, 0.2);
    top: -20%;
    right: -10%;
}

.profile-glow-2 {
    width: 500px;
    height: 500px;
    background: rgba(56, 189, 248, 0.15);
    bottom: -10%;
    left: -10%;
    animation-delay: -5s;
}

@keyframes glowFloat {
    0% { transform: translate(0, 0); }
    100% { transform: translate(30px, 30px); }
}

/* Layout Grid */
.profile-layout-grid {
    display: grid;
    grid-template-columns: 280px 1fr;
    gap: 2rem;
    align-items: start;
    position: relative;
    z-index: 10;
}

@media (max-width: 992px) {
    .profile-layout-grid {
        grid-template-columns: 1fr;
    }
}

/* Profile Header */
.profile-header {
    position: relative;
    z-index: 10;
    margin-bottom: 2.5rem;
    background: #fff;
    border: 1px solid var(--glass-border);
    border-radius: 24px;
    padding: 2.5rem;
    box-shadow: 0 1px 3px rgba(15, 23, 42, 0.03);
}

.profile-header-content {
    display: flex;
    gap: 2.5rem;
    align-items: center;
}

@media (max-width: 768px) {
    .profile-header-content {
        flex-direction: column;
        text-align: center;
    }
}

.profile-avatar-wrapper {
    position: relative;
}

.profile-avatar {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    background: linear-gradient(135deg, #2563eb, #38bdf8);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2.5rem;
    font-weight: 800;
    color: white;
    box-shadow: 0 4px 15px rgba(37, 99, 235, 0.2);
    border: 4px solid #fff;
}

.profile-status-badge {
    position: absolute;
    bottom: -10px;
    left: 50%;
    transform: translateX(-50%);
    background: #fff;
    border: 1px solid var(--glass-border);
    padding: 0.3rem 0.8rem;
    border-radius: 20px;
    display: flex;
    align-items: center;
    gap: 0.4rem;
    font-size: 0.75rem;
    font-weight: 600;
    white-space: nowrap;
    color: #0f172a;
    box-shadow: 0 1px 3px rgba(15, 23, 42, 0.05);
}

.status-indicator {
    width: 8px;
    height: 8px;
    background: #10B981;
    border-radius: 50%;
    box-shadow: 0 0 10px #10B981;
}

.header-info-section {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.profile-welcome {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
    color: #0f172a;
}

.text-gradient {
    background: linear-gradient(to right, #2563eb, #38bdf8);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.profile-badges {
    display: flex;
    gap: 0.8rem;
    flex-wrap: wrap;
}

@media (max-width: 768px) {
    .profile-badges {
        justify-content: center;
    }
}

.badge {
    padding: 0.4rem 1rem;
    border-radius: 50px;
    font-size: 0.875rem;
    font-weight: 500;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.badge-glass {
    background: rgba(37, 99, 235, 0.05);
    border: 1px solid #e2e8f0;
    color: var(--text-secondary);
}

.badge-admin {
    background: rgba(245, 158, 11, 0.1);
    border: 1px solid rgba(245, 158, 11, 0.3);
    color: #d97706;
}

.header-stats {
    display: flex;
    gap: 2rem;
    padding-top: 1rem;
    border-top: 1px solid var(--glass-border);
}

@media (max-width: 768px) {
    .header-stats {
        flex-wrap: wrap;
        justify-content: center;
    }
}

.header-stat-item {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.stat-icon {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    background: rgba(37, 99, 235, 0.08);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    color: #2563eb;
}

.stat-icon.icon-success { background: rgba(16, 185, 129, 0.1); color: #10b981; }
.stat-icon.icon-purple { background: rgba(139, 92, 246, 0.1); color: #8b5cf6; }

.stat-text {
    display: flex;
    flex-direction: column;
}

.stat-value {
    font-size: 1.25rem;
    font-weight: 700;
    color: #0f172a;
}

.stat-label {
    font-size: 0.8rem;
    color: var(--text-secondary);
}

/* Sidebar */
.profile-sidebar {
    position: sticky;
    top: 100px;
}

.sidebar-menu {
    background: #fff;
    border: 1px solid var(--glass-border);
    border-radius: 20px;
    padding: 1rem;
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    box-shadow: 0 1px 3px rgba(15, 23, 42, 0.03);
}

.sidebar-link {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem 1.25rem;
    border-radius: 12px;
    color: var(--text-secondary);
    transition: all 0.3s ease;
    text-decoration: none;
    font-weight: 500;
    border: 1px solid transparent;
}

.sidebar-link:hover {
    background: rgba(37, 99, 235, 0.05);
    color: #0f172a;
    transform: translateX(5px);
}

.sidebar-link.active {
    background: rgba(37, 99, 235, 0.08);
    border-color: rgba(37, 99, 235, 0.2);
    color: #0f172a;
    font-weight: 600;
}

.sidebar-link i {
    font-size: 1.25rem;
}

.sidebar-link.active i {
    color: #2563eb;
}

.sidebar-divider {
    height: 1px;
    background: var(--glass-border);
    margin: 0.5rem 0;
}

.logout-form { margin: 0; }
.logout-form button { 
    width: 100%; 
    background: none; 
    border: none; 
    cursor: pointer; 
    text-align: left;
    font-family: inherit;
    font-size: inherit;
}

.link-danger:hover {
    background: rgba(239, 68, 68, 0.08);
    color: #ef4444;
}

.link-primary { color: #2563eb; }

/* Main Content */
.content-header {
    margin-bottom: 2rem;
}

.content-header h2 {
    font-size: 1.75rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
    color: #0f172a;
}

.content-header p {
    color: var(--text-secondary);
}

.tab-content {
    opacity: 0;
    animation: fadeIn 0.4s forwards;
}

@keyframes fadeIn {
    to { opacity: 1; }
}

/* Cards */
.glass-form-card, .order-card-glass, .empty-state-glass {
    background: #fff;
    border: 1px solid var(--glass-border);
    border-radius: 20px;
    padding: 2rem;
    margin-bottom: 1.5rem;
    box-shadow: 0 1px 3px rgba(15, 23, 42, 0.03);
}

/* Orders Styles */
.order-card-glass {
    position: relative;
    overflow: hidden;
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    justify-content: space-between;
    gap: 2rem;
    transition: transform 0.3s ease, border-color 0.3s ease;
}

.order-card-glass:hover {
    transform: translateY(-2px);
    border-color: rgba(37, 99, 235, 0.3);
    background: #fafbff;
}

.order-status-line {
    position: absolute;
    left: 0;
    top: 0;
    bottom: 0;
    width: 4px;
}

.order-status-line.active { background: #10B981; box-shadow: 0 0 10px #10B981; }
.order-status-line.expired { background: #cbd5e1; }

.order-main-info {
    display: flex;
    align-items: center;
    gap: 1.25rem;
}

.order-package-icon {
    width: 54px;
    height: 54px;
    border-radius: 12px;
    background: rgba(37, 99, 235, 0.08);
    color: #2563eb;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.75rem;
    border: 1px solid rgba(37, 99, 235, 0.15);
}

.order-details h3 {
    font-size: 1.25rem;
    font-weight: 700;
    margin-bottom: 0.25rem;
    color: #0f172a;
}

.order-id {
    font-size: 0.85rem;
    color: var(--text-secondary);
    font-family: monospace;
}

.order-meta-info {
    flex: 1;
    display: flex;
    justify-content: space-around;
    gap: 1rem;
}

@media (max-width: 768px) {
    .order-meta-info {
        flex-basis: 100%;
        justify-content: space-between;
        background: rgba(37, 99, 235, 0.02);
        padding: 1rem;
        border-radius: 12px;
    }
}

.meta-item {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.meta-label {
    font-size: 0.75rem;
    color: var(--text-secondary);
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.meta-value {
    font-weight: 600;
    font-size: 1rem;
    color: #0f172a;
}

.meta-value.price {
    color: #2563eb;
    font-family: var(--font-display, sans-serif);
}

.status-badge {
    display: inline-flex;
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
}

.status-active { background: rgba(16, 185, 129, 0.1); color: #10b981; }
.status-expired { background: rgba(100, 116, 139, 0.1); color: #94A3B8; }

.order-actions {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    gap: 0.5rem;
}

.expiry-date {
    font-size: 0.85rem;
    color: var(--text-secondary);
    display: flex;
    align-items: center;
    gap: 0.4rem;
}

.btn-renew {
    padding: 0.5rem 1.25rem;
    background: transparent;
    border: 1px solid #2563eb;
    color: #2563eb;
    border-radius: 8px;
    font-size: 0.875rem;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
}

.btn-renew:hover {
    background: #2563eb;
    color: white;
    box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
}

.empty-state-glass {
    text-align: center;
    padding: 4rem 2rem;
}

.empty-icon {
    font-size: 4rem;
    color: rgba(37, 99, 235, 0.15);
    margin-bottom: 1.5rem;
}

/* Forms */
.form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
    margin-bottom: 2rem;
}

@media (max-width: 640px) {
    .form-grid { grid-template-columns: 1fr; }
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-group label {
    display: block;
    margin-bottom: 0.75rem;
    font-size: 0.9rem;
    font-weight: 500;
    color: var(--text-secondary);
}

.input-wrapper {
    position: relative;
    display: flex;
    align-items: center;
}

.input-wrapper i {
    position: absolute;
    left: 1.25rem;
    color: var(--text-secondary);
    font-size: 1.2rem;
    transition: color 0.3s ease;
}

.input-wrapper input {
    width: 100%;
    padding: 1rem 1rem 1rem 3.5rem;
    background: #f8fafc;
    border: 1px solid var(--glass-border);
    border-radius: 12px;
    color: #0f172a;
    font-size: 1rem;
    transition: all 0.3s ease;
}

.input-wrapper input:focus {
    outline: none;
    border-color: #2563eb;
    background: #fff;
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
}

.input-wrapper input:focus + i, 
.input-wrapper input:not(:placeholder-shown) + i {
    color: #2563eb;
}

.btn-primary-glow {
    background: #2563eb;
    color: white;
    padding: 1rem 2.5rem;
    border-radius: 12px;
    border: none;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 1px 3px rgba(37, 99, 235, 0.2);
    display: inline-flex;
    align-items: center;
    gap: 0.75rem;
    text-decoration: none;
}

.btn-primary-glow:hover {
    background: #1d4ed8;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
    color: white;
}

/* Alerts */
.alert-glass {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    padding: 1.25rem;
    border-radius: 16px;
    margin-bottom: 2rem;
}

.alert-success {
    background: rgba(16, 185, 129, 0.08);
    border: 1px solid rgba(16, 185, 129, 0.2);
    color: #10b981;
}

.alert-error {
    background: rgba(239, 68, 68, 0.08);
    border: 1px solid rgba(239, 68, 68, 0.2);
    color: #ef4444;
}

.alert-close {
    margin-left: auto;
    background: none;
    border: none;
    color: currentColor;
    opacity: 0.7;
    cursor: pointer;
    font-size: 1.2rem;
}
</style>
@endpush
