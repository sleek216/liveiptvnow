<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard') - Live IPTV Now</title>
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --sidebar-width: 260px;
            --primary-color: #6366f1;
            --primary-dark: #4f46e5;
            --dark-bg: #0f172a;
            --dark-card: #1e293b;
            --dark-border: #334155;
        }
        
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: #f1f5f9;
            min-height: 100vh;
        }
        
        /* ── Sidebar ── */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: var(--dark-bg);
            color: #fff;
            z-index: 1000;
            overflow-y: auto;
            transition: transform 0.3s ease;
        }
        .sidebar-header {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid var(--dark-border);
        }
        .sidebar-brand {
            font-size: 1.25rem;
            font-weight: 700;
            color: #fff;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.6rem;
        }
        .sidebar-brand img {
            height: 32px;
            width: auto;
        }
        .sidebar-nav { padding: 1rem 0; }
        .nav-section {
            padding: 0.5rem 1.5rem;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            color: #64748b;
            letter-spacing: 0.05em;
        }
        .nav-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1.5rem;
            color: #94a3b8;
            text-decoration: none;
            transition: all 0.2s;
            border-left: 3px solid transparent;
        }
        .nav-link:hover { color: #fff; background: rgba(99, 102, 241, 0.1); }
        .nav-link.active { color: #fff; background: rgba(99, 102, 241, 0.15); border-left-color: var(--primary-color); }
        .nav-link i { font-size: 1.1rem; width: 24px; }
        .nav-link .nav-badge {
            margin-left: auto;
            min-width: 22px;
            height: 22px;
            padding: 0 7px;
            border-radius: 999px;
            font-size: 0.7rem;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            line-height: 1;
        }
        .nav-badge-danger { background: #ef4444; color: #fff; }
        .nav-badge-warning { background: #f59e0b; color: #fff; }
        .nav-badge-info { background: #3b82f6; color: #fff; }
        .nav-badge-purple { background: #8b5cf6; color: #fff; }
        
        /* ── Main Content ── */
        .main-content { margin-left: var(--sidebar-width); min-height: 100vh; }
        .top-header {
            background: #fff;
            padding: 1rem 2rem;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 100;
        }
        .content-wrapper { padding: 2rem; }
        .page-title { font-size: 1.5rem; font-weight: 700; color: var(--dark-bg); margin-bottom: 0.25rem; }
        .breadcrumb { margin-bottom: 0; font-size: 0.875rem; }
        
        /* ── Cards ── */
        .card { background: #fff; border: 1px solid #e2e8f0; border-radius: 0.75rem; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
        .card-header { padding: 1rem 1.5rem; border-bottom: 1px solid #e2e8f0; background: transparent; font-weight: 600; }
        .card-body { padding: 1.5rem; }
        
        /* ── Stats ── */
        .stat-card { padding: 1.5rem; border-radius: 0.75rem; background: linear-gradient(135deg, var(--primary-color), var(--primary-dark)); color: #fff; }
        .stat-card.green { background: linear-gradient(135deg, #10b981, #059669); }
        .stat-card.orange { background: linear-gradient(135deg, #f59e0b, #d97706); }
        .stat-card.red { background: linear-gradient(135deg, #ef4444, #dc2626); }
        .stat-value { font-size: 2rem; font-weight: 700; }
        .stat-label { font-size: 0.875rem; opacity: 0.9; }
        
        /* ── Table ── */
        .table { margin-bottom: 0; }
        .table th { font-weight: 600; font-size: 0.75rem; text-transform: uppercase; color: #64748b; border-bottom: 2px solid #e2e8f0; }
        .table td { vertical-align: middle; padding: 1rem; }
        
        /* ── Buttons ── */
        .btn-primary { background: var(--primary-color); border-color: var(--primary-color); }
        .btn-primary:hover { background: var(--primary-dark); border-color: var(--primary-dark); }
        .badge { padding: 0.35em 0.65em; font-weight: 500; }
        
        /* ── Forms ── */
        .form-control, .form-select { border-color: #e2e8f0; padding: 0.625rem 1rem; }
        .form-control:focus, .form-select:focus { border-color: var(--primary-color); box-shadow: 0 0 0 3px rgba(99,102,241,0.1); }
        .form-label { font-weight: 500; color: #475569; margin-bottom: 0.5rem; }
        .alert { border: none; border-radius: 0.5rem; }
        
        /* ── User Dropdown ── */
        .user-dropdown { position: relative; }
        .user-dropdown .dropdown-toggle {
            display: flex; align-items: center; gap: 0.5rem;
            padding: 0.5rem 1rem; background: #f8fafc;
            border: 1px solid #e2e8f0; border-radius: 0.5rem;
            text-decoration: none; color: var(--dark-bg);
        }
        .user-avatar {
            width: 32px; height: 32px; background: var(--primary-color);
            border-radius: 50%; display: flex; align-items: center;
            justify-content: center; color: #fff; font-weight: 600; font-size: 0.875rem;
        }

        /* ── Sidebar close button ── */
        .sidebar-close-btn {
            display: none !important;
            position: absolute; top: 1rem; right: 1rem;
            background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.15);
            color: #fff; width: 32px; height: 32px; border-radius: 8px;
            align-items: center; justify-content: center; cursor: pointer;
            font-size: 1.1rem; z-index: 10;
        }
        .sidebar-close-btn:hover { background: rgba(239,68,68,0.3); }
        .sidebar-overlay {
            display: none; position: fixed; inset: 0;
            background: rgba(0,0,0,0.5); z-index: 999;
        }
        .sidebar-overlay.show { display: block; }

        /* ── Page header (global) ── */
        .page-header-row {
            display: flex; justify-content: space-between; align-items: center;
            flex-wrap: wrap; gap: 0.75rem; margin-bottom: 1.5rem;
        }
        .page-header-actions { display: flex; gap: 0.5rem; flex-wrap: wrap; }

        /* ── Card header badges wrap ── */
        .card-header { display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.5rem; }

        /* ══════════════════════════════════════
           RESPONSIVE: Tablet (<992px)
           ══════════════════════════════════════ */
        @media (max-width: 991.98px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.show { transform: translateX(0); }
            .main-content { margin-left: 0; }
            .content-wrapper { padding: 1.25rem; }
            .top-header { padding: 0.75rem 1.25rem; }
            .page-title { font-size: 1.25rem; }
            .stat-value { font-size: 1.5rem; }
            .card-body { padding: 1rem; }
            .card-header { padding: 0.75rem 1rem; font-size: 0.9rem; }
            .table td, .table th { padding: 0.65rem 0.5rem; font-size: 0.8125rem; }
            .sidebar-close-btn { display: flex !important; }

            .d-flex.justify-content-between.align-items-center.mb-4,
            .page-header-row {
                flex-wrap: wrap;
                gap: 0.5rem;
            }
            .d-flex.gap-2 { flex-wrap: wrap; }

            .input-group { flex-wrap: wrap; }
            .input-group .form-select,
            .input-group .form-control { min-width: 0; }
        }

        /* ══════════════════════════════════════
           RESPONSIVE: Mobile (<576px)
           ══════════════════════════════════════ */
        @media (max-width: 575.98px) {
            .content-wrapper { padding: 0.75rem; }
            .top-header { padding: 0.5rem 0.75rem; }
            .user-dropdown .dropdown-toggle span { display: none; }
            .user-dropdown .dropdown-toggle .bi-chevron-down { display: none; }
            .page-title { font-size: 1.05rem; }

            .stat-card { padding: 0.875rem; }
            .stat-value { font-size: 1.15rem; }
            .stat-label { font-size: 0.7rem; }

            .btn { font-size: 0.8rem; padding: 0.375rem 0.65rem; }
            .btn-sm { font-size: 0.75rem; padding: 0.25rem 0.5rem; }
            .card-body { padding: 0.75rem; }
            .card-header { padding: 0.65rem 0.75rem; font-size: 0.85rem; }

            .form-control, .form-select { font-size: 0.85rem; padding: 0.45rem 0.65rem; }
            .form-label { font-size: 0.85rem; }
            .badge { font-size: 0.68rem; }

            .table td, .table th { padding: 0.5rem 0.35rem; font-size: 0.78rem; }

            .btn-group { flex-wrap: wrap; gap: 2px; }
            .btn-group .btn { border-radius: 0.375rem !important; }

            .d-flex.justify-content-between.align-items-center.mb-4 {
                flex-direction: column;
                align-items: flex-start !important;
            }
            .d-flex.justify-content-between.align-items-center.mb-4 > .btn,
            .d-flex.justify-content-between.align-items-center.mb-4 > a.btn {
                width: 100%;
                text-align: center;
            }

            .d-flex.gap-2 {
                width: 100%;
                flex-direction: column;
            }
            .d-flex.gap-2 .btn { width: 100%; text-align: center; }

            .row.g-3 > [class*="col-"],
            .row.g-4 > [class*="col-md-6"] {
                flex: 0 0 100%;
                max-width: 100%;
            }

            .input-group {
                flex-direction: column;
            }
            .input-group .form-select,
            .input-group .form-control {
                border-radius: 0.375rem !important;
                width: 100%;
            }
            .input-group .btn {
                border-radius: 0.375rem !important;
                width: 100%;
                margin-top: 0.35rem;
            }

            .alert { font-size: 0.85rem; padding: 0.65rem 0.75rem; }
            .alert .btn-close { padding: 0.5rem; }
        }

        /* ══════════════════════════════════════
           RESPONSIVE: Small Mobile (<400px)
           ══════════════════════════════════════ */
        @media (max-width: 399.98px) {
            .content-wrapper { padding: 0.5rem; }
            .page-title { font-size: 0.95rem; }
            .stat-value { font-size: 1rem; }
            .table td, .table th { padding: 0.4rem 0.25rem; font-size: 0.72rem; }
            .card-body { padding: 0.625rem; }
            .sidebar-brand span { font-size: 1rem; }
        }
    </style>
    @stack('styles')
</head>
<body>
    <!-- Sidebar Overlay (mobile) -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <button class="sidebar-close-btn" id="sidebarClose" aria-label="Close sidebar"><i class="bi bi-x-lg"></i></button>
        <div class="sidebar-header">
            <a href="{{ route(auth()->user()->adminHomeRouteName()) }}" class="sidebar-brand">
                <img src="{{ asset('images/favicon.png') }}" alt="Logo">
                <span>Live IPTV Now</span>
            </a>
        </div>
        
        <nav class="sidebar-nav">
            @php $adminUser = auth()->user(); @endphp

            @if($adminUser->canAccessAdminModule('dashboard'))
            <div class="nav-section">Main</div>
            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i>
                <span>Dashboard</span>
            </a>
            @endif
            
            @if(
                $adminUser->canAccessAdminModule('packages') ||
                $adminUser->canAccessAdminModule('orders') ||
                $adminUser->canAccessAdminModule('users') ||
                $adminUser->canAccessAdminModule('countries') ||
                $adminUser->canAccessAdminModule('coupons') ||
                $adminUser->canAccessAdminModule('blogs') ||
                $adminUser->canAccessAdminModule('contacts') ||
                $adminUser->canAccessAdminModule('announcement')
            )
            <div class="nav-section mt-3">Management</div>
            @endif
            @if($adminUser->canAccessAdminModule('packages'))
            <a href="{{ route('admin.packages.index') }}" class="nav-link {{ request()->routeIs('admin.packages.*') ? 'active' : '' }}">
                <i class="bi bi-box-seam"></i>
                <span>Packages</span>
            </a>
            @endif
            @if($adminUser->canAccessAdminModule('orders'))
            <a href="{{ route('admin.orders.index') }}" class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                <i class="bi bi-cart3"></i>
                <span>Orders</span>
                @if(($adminCounts['orders'] ?? 0) > 0)
                    <span class="nav-badge nav-badge-danger">{{ $adminCounts['orders'] }}</span>
                @endif
            </a>
            @endif
            @if($adminUser->canAccessAdminModule('users'))
            <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <i class="bi bi-people"></i>
                <span>Users</span>
                @if(($adminCounts['users'] ?? 0) > 0)
                    <span class="nav-badge nav-badge-info">{{ $adminCounts['users'] }}</span>
                @endif
            </a>
            @endif
            @if($adminUser->canAccessAdminModule('countries'))
            <a href="{{ route('admin.countries.index') }}" class="nav-link {{ request()->routeIs('admin.countries.*') ? 'active' : '' }}">
                <i class="bi bi-globe"></i>
                <span>Countries</span>
            </a>
            @endif
            @if($adminUser->canAccessAdminModule('coupons'))
            <a href="{{ route('admin.coupons.index') }}" class="nav-link {{ request()->routeIs('admin.coupons.*') ? 'active' : '' }}">
                <i class="bi bi-tag"></i>
                <span>Coupons</span>
            </a>
            @endif
            @if($adminUser->canAccessAdminModule('blogs'))
            <a href="{{ route('admin.blogs.index') }}" class="nav-link {{ request()->routeIs('admin.blogs.*') ? 'active' : '' }}">
                <i class="bi bi-journal-text"></i>
                <span>Blog Posts</span>
            </a>
            @endif
            @if($adminUser->canAccessAdminModule('contacts'))
            <a href="{{ route('admin.contacts.index') }}" class="nav-link {{ request()->routeIs('admin.contacts.*') ? 'active' : '' }}">
                <i class="bi bi-envelope-fill"></i>
                <span>Contacts</span>
                @if(($adminCounts['contacts'] ?? 0) > 0)
                    <span class="nav-badge nav-badge-danger">{{ $adminCounts['contacts'] }}</span>
                @endif
            </a>
            @endif
            @if($adminUser->canAccessAdminModule('announcement'))
            <a href="{{ route('admin.announcement.index') }}" class="nav-link {{ request()->routeIs('admin.announcement.*') ? 'active' : '' }}">
                <i class="bi bi-megaphone"></i>
                <span>Announcement Bar</span>
            </a>
            @endif

            @if(
                $adminUser->canAccessAdminModule('affiliate_overview') ||
                $adminUser->canAccessAdminModule('affiliate_affiliates') ||
                $adminUser->canAccessAdminModule('affiliate_referrals') ||
                $adminUser->canAccessAdminModule('affiliate_commissions') ||
                $adminUser->canAccessAdminModule('affiliate_payouts') ||
                $adminUser->canAccessAdminModule('affiliate_settings')
            )
            <div class="nav-section mt-3">Affiliate Program</div>
            @endif
            @if($adminUser->canAccessAdminModule('affiliate_overview'))
            <a href="{{ route('admin.affiliate.index') }}" class="nav-link {{ request()->routeIs('admin.affiliate.index') ? 'active' : '' }}">
                <i class="bi bi-graph-up"></i>
                <span>Overview</span>
                @if(($adminCounts['affiliate_total'] ?? 0) > 0)
                    <span class="nav-badge nav-badge-purple">{{ $adminCounts['affiliate_total'] }}</span>
                @endif
            </a>
            @endif
            @if($adminUser->canAccessAdminModule('affiliate_affiliates'))
            <a href="{{ route('admin.affiliate.affiliates') }}" class="nav-link {{ request()->routeIs('admin.affiliate.affiliates') ? 'active' : '' }}">
                <i class="bi bi-people-fill"></i>
                <span>Affiliates</span>
            </a>
            @endif
            @if($adminUser->canAccessAdminModule('affiliate_referrals'))
            <a href="{{ route('admin.affiliate.referrals') }}" class="nav-link {{ request()->routeIs('admin.affiliate.referrals') ? 'active' : '' }}">
                <i class="bi bi-link-45deg"></i>
                <span>Referrals</span>
                @if(($adminCounts['referrals'] ?? 0) > 0)
                    <span class="nav-badge nav-badge-info">{{ $adminCounts['referrals'] }}</span>
                @endif
            </a>
            @endif
            @if($adminUser->canAccessAdminModule('affiliate_commissions'))
            <a href="{{ route('admin.affiliate.commissions') }}" class="nav-link {{ request()->routeIs('admin.affiliate.commissions') ? 'active' : '' }}">
                <i class="bi bi-cash-coin"></i>
                <span>Commissions</span>
                @if(($adminCounts['commissions'] ?? 0) > 0)
                    <span class="nav-badge nav-badge-warning">{{ $adminCounts['commissions'] }}</span>
                @endif
            </a>
            @endif
            @if($adminUser->canAccessAdminModule('affiliate_payouts'))
            <a href="{{ route('admin.affiliate.payouts') }}" class="nav-link {{ request()->routeIs('admin.affiliate.payouts') ? 'active' : '' }}">
                <i class="bi bi-wallet2"></i>
                <span>Payouts</span>
                @if(($adminCounts['payouts'] ?? 0) > 0)
                    <span class="nav-badge nav-badge-danger">{{ $adminCounts['payouts'] }}</span>
                @endif
            </a>
            @endif
            @if($adminUser->canAccessAdminModule('affiliate_settings'))
            <a href="{{ route('admin.affiliate.settings') }}" class="nav-link {{ request()->routeIs('admin.affiliate.settings') ? 'active' : '' }}">
                <i class="bi bi-sliders"></i>
                <span>Settings</span>
            </a>
            @endif
            
            @if(
                $adminUser->canAccessAdminModule('settings_general') ||
                $adminUser->canAccessAdminModule('settings_stripe') ||
                $adminUser->canAccessAdminModule('settings_nowpayments') ||
                $adminUser->canAccessAdminModule('settings_email') ||
                $adminUser->canAccessAdminModule('settings_backup') ||
                $adminUser->canAccessAdminModule('security')
            )
            <div class="nav-section mt-3">Settings</div>
            @endif
            @if($adminUser->canAccessAdminModule('settings_general'))
            <a href="{{ route('admin.settings.index') }}" class="nav-link {{ request()->routeIs('admin.settings.index') ? 'active' : '' }}">
                <i class="bi bi-gear"></i>
                <span>General Settings</span>
            </a>
            @endif
            @if($adminUser->canAccessAdminModule('settings_stripe'))
            <a href="{{ route('admin.settings.stripe') }}" class="nav-link {{ request()->routeIs('admin.settings.stripe') ? 'active' : '' }}">
                <i class="bi bi-credit-card"></i>
                <span>Stripe Gateway</span>
            </a>
            @endif
            @if($adminUser->canAccessAdminModule('settings_nowpayments'))
            <a href="{{ route('admin.settings.nowpayments') }}" class="nav-link {{ request()->routeIs('admin.settings.nowpayments') ? 'active' : '' }}">
                <i class="bi bi-currency-bitcoin"></i>
                <span>NOWPayments Crypto</span>
            </a>
            @endif
            @if($adminUser->canAccessAdminModule('settings_email'))
            <a href="{{ route('admin.settings.email') }}" class="nav-link {{ request()->routeIs('admin.settings.email') ? 'active' : '' }}">
                <i class="bi bi-envelope"></i>
                <span>Email Settings</span>
            </a>
            @endif
            @if($adminUser->canAccessAdminModule('settings_backup'))
            <a href="{{ route('admin.settings.backup') }}" class="nav-link">
                <i class="bi bi-file-earmark-spreadsheet"></i>
                <span>Data Backup</span>
            </a>
            @endif
            @if($adminUser->canAccessAdminModule('security'))
            <a href="{{ route('admin.security.index') }}" class="nav-link {{ request()->routeIs('admin.security.*') ? 'active' : '' }}">
                <i class="bi bi-shield-lock"></i>
                <span>Security (2FA)</span>
            </a>
            @endif
            
            <div class="nav-section mt-3">Quick Links</div>
            <a href="{{ route('home') }}" class="nav-link" target="_blank">
                <i class="bi bi-box-arrow-up-right"></i>
                <span>View Website</span>
            </a>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Top Header -->
        <header class="top-header">
            <button class="btn btn-link d-lg-none p-0" id="sidebarOpen" aria-label="Open menu">
                <i class="bi bi-list fs-4"></i>
            </button>
            
            <div class="d-none d-lg-block">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route(auth()->user()->adminHomeRouteName()) }}">Admin</a></li>
                        @yield('breadcrumb')
                    </ol>
                </nav>
            </div>
            
            <div class="user-dropdown dropdown">
                <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown">
                    <div class="user-avatar">{{ substr(auth()->user()->name, 0, 1) }}</div>
                    <span>{{ auth()->user()->name }}</span>
                    <i class="bi bi-chevron-down"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="{{ route('profile') }}"><i class="bi bi-person me-2"></i>Profile</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form action="{{ route('admin.logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger">
                                <i class="bi bi-box-arrow-right me-2"></i>Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </header>

        <!-- Content -->
        <div class="content-wrapper">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    (function(){
        var sb = document.getElementById('sidebar');
        var ov = document.getElementById('sidebarOverlay');
        var openBtn = document.getElementById('sidebarOpen');
        var closeBtn = document.getElementById('sidebarClose');
        function open(){ sb.classList.add('show'); ov.classList.add('show'); document.body.style.overflow='hidden'; }
        function close(){ sb.classList.remove('show'); ov.classList.remove('show'); document.body.style.overflow=''; }
        if(openBtn) openBtn.addEventListener('click', open);
        if(closeBtn) closeBtn.addEventListener('click', close);
        if(ov) ov.addEventListener('click', close);
    })();
    </script>
    @stack('scripts')
</body>
</html>
