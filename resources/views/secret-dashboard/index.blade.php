<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>⚡ Secret Reseller & XUI Automation Hub</title>
    
    <!-- Google Fonts & Phosphor Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    
    <style>
        :root {
            --bg-page: #f8fafc;
            --bg-card: #ffffff;
            --bg-subtle: #f1f5f9;
            --border-card: 2px solid #e2e8f0;
            --border-subtle: 1px solid #e2e8f0;
            --border-hover: #cbd5e1;
            
            /* Google Material Palette */
            --g-blue: #1a73e8;
            --g-blue-hover: #1557b0;
            --g-blue-bg: #e8f0fe;
            --g-green: #1e8e3e;
            --g-green-bg: #e6f4ea;
            --g-yellow: #f29900;
            --g-yellow-bg: #fef7e0;
            --g-red: #d93025;
            --g-red-bg: #fce8e6;
            --g-purple: #9334e6;
            --g-purple-bg: #f3e8fd;

            --text-main: #1f2937;
            --text-title: #0f172a;
            --text-muted: #5f6368;
            --text-subtle: #94a3b8;
            
            --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 12px rgba(0, 0, 0, 0.05);
            --shadow-lg: 0 10px 25px rgba(0, 0, 0, 0.08);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: var(--bg-page);
            color: var(--text-main);
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Roboto', sans-serif;
            min-height: 100vh;
            line-height: 1.5;
            -webkit-font-smoothing: antialiased;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 28px 20px;
        }

        /* Top Bar */
        .topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 24px;
            background: var(--bg-card);
            border: var(--border-card);
            border-radius: 16px;
            margin-bottom: 24px;
            box-shadow: var(--shadow-sm);
        }

        .brand-box {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .brand-icon {
            width: 44px;
            height: 44px;
            background: var(--g-blue);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: #ffffff;
            box-shadow: 0 4px 10px rgba(26, 115, 232, 0.25);
        }

        .brand-title {
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--text-title);
            letter-spacing: -0.02em;
        }

        .secret-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: var(--g-purple-bg);
            border: 1px solid rgba(147, 52, 230, 0.25);
            color: var(--g-purple);
            padding: 4px 10px;
            border-radius: 100px;
            font-size: 0.725rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .topbar-actions {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 9px 16px;
            border-radius: 10px;
            font-size: 0.875rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
            border: none;
            font-family: inherit;
        }

        .btn-primary {
            background: var(--g-blue);
            color: #ffffff;
            border: 1px solid var(--g-blue);
            box-shadow: 0 2px 6px rgba(26, 115, 232, 0.25);
        }

        .btn-primary:hover {
            background: var(--g-blue-hover);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(26, 115, 232, 0.35);
        }

        .btn-success {
            background: var(--g-green);
            color: #ffffff;
            border: 1px solid var(--g-green);
        }

        .btn-success:hover {
            background: #177231;
            transform: translateY(-1px);
        }

        .btn-secondary {
            background: #ffffff;
            border: 2px solid #e2e8f0;
            color: var(--text-main);
        }

        .btn-secondary:hover {
            background: #f8fafc;
            border-color: #cbd5e1;
            color: #0f172a;
        }

        .btn-sm {
            padding: 6px 12px;
            font-size: 0.8rem;
            border-radius: 8px;
        }

        /* Alerts */
        .alert {
            padding: 14px 18px;
            border-radius: 12px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .alert-success {
            background: var(--g-green-bg);
            border: 2px solid rgba(30, 142, 62, 0.3);
            color: #137333;
        }

        .alert-error {
            background: var(--g-red-bg);
            border: 2px solid rgba(217, 48, 37, 0.3);
            color: #c5221f;
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 18px;
            margin-bottom: 26px;
        }

        .stat-card {
            background: var(--bg-card);
            border: var(--border-card);
            border-radius: 16px;
            padding: 20px;
            display: flex;
            align-items: center;
            gap: 16px;
            box-shadow: var(--shadow-sm);
            transition: all 0.2s ease;
        }

        .stat-card:hover {
            border-color: #cbd5e1;
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .stat-icon-wrap {
            width: 50px;
            height: 50px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            flex-shrink: 0;
        }

        .stat-icon-blue { background: var(--g-blue-bg); color: var(--g-blue); }
        .stat-icon-amber { background: var(--g-yellow-bg); color: #b06000; }
        .stat-icon-green { background: var(--g-green-bg); color: var(--g-green); }
        .stat-icon-purple { background: var(--g-purple-bg); color: var(--g-purple); }

        .stat-content h4 {
            font-size: 0.8rem;
            color: var(--text-muted);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            margin-bottom: 4px;
        }

        .stat-value {
            font-size: 1.75rem;
            font-weight: 800;
            color: var(--text-title);
            letter-spacing: -0.02em;
        }

        .pulse-badge {
            display: inline-block;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--g-yellow);
            box-shadow: 0 0 0 rgba(242, 153, 0, 0.4);
            animation: pulse 1.5s infinite;
        }

        @keyframes pulse {
            0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(242, 153, 0, 0.7); }
            70% { transform: scale(1); box-shadow: 0 0 0 6px rgba(242, 153, 0, 0); }
            100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(242, 153, 0, 0); }
        }

        /* Tabs Container */
        .tabs-header {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 20px;
            border-bottom: 2px solid #e2e8f0;
            padding-bottom: 12px;
        }

        .tab-btn {
            background: transparent;
            border: none;
            color: var(--text-muted);
            font-size: 0.95rem;
            font-weight: 600;
            padding: 9px 18px;
            border-radius: 10px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s;
            font-family: inherit;
        }

        .tab-btn:hover {
            color: var(--text-title);
            background: #edf2f7;
        }

        .tab-btn.active {
            color: var(--g-blue);
            background: var(--g-blue-bg);
            font-weight: 700;
        }

        .tab-badge {
            background: #e2e8f0;
            color: var(--text-main);
            padding: 2px 8px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 700;
        }

        .tab-btn.active .tab-badge {
            background: var(--g-blue);
            color: #ffffff;
        }

        .tab-pane {
            display: none;
        }

        .tab-pane.active {
            display: block;
            animation: fadeIn 0.2s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(4px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Filter and Search Bar */
        .filter-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .status-pills {
            display: flex;
            align-items: center;
            gap: 6px;
            background: var(--bg-card);
            padding: 5px;
            border-radius: 12px;
            border: var(--border-card);
            box-shadow: var(--shadow-sm);
        }

        .status-pill {
            padding: 6px 14px;
            border-radius: 8px;
            font-size: 0.825rem;
            font-weight: 600;
            color: var(--text-muted);
            text-decoration: none;
            transition: all 0.2s;
        }

        .status-pill:hover {
            color: var(--text-title);
            background: #f1f5f9;
        }

        .status-pill.active {
            background: var(--g-blue-bg);
            color: var(--g-blue);
        }

        .search-box {
            position: relative;
            min-width: 320px;
        }

        .search-box input {
            width: 100%;
            background: var(--bg-card);
            border: var(--border-card);
            border-radius: 12px;
            padding: 10px 16px 10px 38px;
            color: var(--text-title);
            font-size: 0.875rem;
            outline: none;
            font-family: inherit;
            box-shadow: var(--shadow-sm);
            transition: all 0.2s;
        }

        .search-box input:focus {
            border-color: var(--g-blue);
            box-shadow: 0 0 0 3px rgba(26, 115, 232, 0.15);
        }

        .search-box i {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 16px;
        }

        /* Orders Table */
        .table-card {
            background: var(--bg-card);
            border: var(--border-card);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: var(--shadow-sm);
        }

        .table-responsive {
            width: 100%;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        thead {
            background: #f8fafc;
            border-bottom: 2px solid #e2e8f0;
        }

        th {
            padding: 14px 18px;
            font-size: 0.75rem;
            font-weight: 700;
            color: #475569;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        tbody tr {
            border-bottom: 1px solid #edf2f7;
            transition: background 0.15s ease;
        }

        tbody tr:hover {
            background: #f8fafc;
        }

        tbody tr:last-child {
            border-bottom: none;
        }

        td {
            padding: 16px 18px;
            font-size: 0.875rem;
            vertical-align: middle;
        }

        .customer-cell {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .customer-name {
            font-weight: 700;
            color: var(--text-title);
        }

        .customer-email {
            font-size: 0.775rem;
            color: var(--text-muted);
            font-family: 'JetBrains Mono', monospace;
        }

        .order-tag {
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.8rem;
            color: var(--g-blue);
            font-weight: 700;
            background: var(--g-blue-bg);
            padding: 2px 8px;
            border-radius: 6px;
            display: inline-block;
        }

        .order-time {
            font-size: 0.75rem;
            color: var(--text-subtle);
            display: block;
            margin-top: 4px;
        }

        .pkg-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #f1f5f9;
            border: 1px solid #e2e8f0;
            padding: 4px 10px;
            border-radius: 8px;
            font-size: 0.8rem;
            font-weight: 600;
            color: #334155;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 10px;
            border-radius: 100px;
            font-size: 0.75rem;
            font-weight: 700;
        }

        .badge-success { background: var(--g-green-bg); color: var(--g-green); border: 1px solid rgba(30, 142, 62, 0.25); }
        .badge-warning { background: var(--g-yellow-bg); color: #b06000; border: 1px solid rgba(242, 153, 0, 0.25); }
        .badge-danger { background: var(--g-red-bg); color: var(--g-red); border: 1px solid rgba(217, 48, 37, 0.25); }
        .badge-info { background: var(--g-blue-bg); color: var(--g-blue); border: 1px solid rgba(26, 115, 232, 0.25); }

        .action-group {
            display: flex;
            align-items: center;
            gap: 6px;
            flex-wrap: wrap;
        }

        /* Settings Card */
        .settings-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 24px;
        }

        .card {
            background: var(--bg-card);
            border: var(--border-card);
            border-radius: 16px;
            padding: 24px;
            box-shadow: var(--shadow-sm);
        }

        .card-title {
            font-size: 1.15rem;
            font-weight: 700;
            color: var(--text-title);
            margin-bottom: 6px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .card-desc {
            font-size: 0.85rem;
            color: var(--text-muted);
            margin-bottom: 22px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-label {
            display: block;
            font-size: 0.8rem;
            font-weight: 700;
            color: #334155;
            margin-bottom: 6px;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        .form-control {
            width: 100%;
            background: #ffffff;
            border: var(--border-card);
            border-radius: 10px;
            padding: 11px 16px;
            color: var(--text-title);
            font-size: 0.9rem;
            font-family: inherit;
            outline: none;
            transition: all 0.2s;
        }

        .form-control:focus {
            border-color: var(--g-blue);
            box-shadow: 0 0 0 3px rgba(26, 115, 232, 0.15);
        }

        .form-switch {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 18px;
            background: #f8fafc;
            border: var(--border-card);
            border-radius: 12px;
            margin-bottom: 18px;
        }

        .switch-label {
            font-weight: 700;
            font-size: 0.9rem;
            color: var(--text-title);
        }

        .switch-desc {
            font-size: 0.775rem;
            color: var(--text-muted);
        }

        /* Toggle switch checkbox */
        .switch {
            position: relative;
            display: inline-block;
            width: 48px;
            height: 26px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #cbd5e1;
            transition: .3s;
            border-radius: 34px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 18px;
            width: 18px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: .3s;
            border-radius: 50%;
            box-shadow: 0 1px 3px rgba(0,0,0,0.2);
        }

        input:checked + .slider {
            background-color: var(--g-blue);
        }

        input:checked + .slider:before {
            transform: translateX(22px);
        }

        /* Live test response box */
        .test-box {
            background: #f8fafc;
            border: var(--border-card);
            border-radius: 12px;
            padding: 16px;
            margin-top: 16px;
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.825rem;
            display: none;
        }

        /* Modals */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(4px);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 999;
            padding: 20px;
        }

        .modal-overlay.active {
            display: flex;
            animation: fadeIn 0.2s ease;
        }

        .modal-card {
            background: #ffffff;
            border: var(--border-card);
            border-radius: 20px;
            width: 100%;
            max-width: 580px;
            padding: 26px;
            box-shadow: var(--shadow-lg);
            position: relative;
        }

        .modal-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
            padding-bottom: 14px;
            border-bottom: 2px solid #f1f5f9;
        }

        .modal-close {
            background: transparent;
            border: none;
            color: var(--text-muted);
            font-size: 20px;
            cursor: pointer;
            border-radius: 8px;
            padding: 4px;
        }

        .modal-close:hover {
            background: #f1f5f9;
            color: var(--text-title);
        }

        .cred-copy-box {
            background: #f8fafc;
            border: var(--border-card);
            border-radius: 12px;
            padding: 14px;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .cred-info {
            display: flex;
            flex-direction: column;
            gap: 3px;
        }

        .cred-lbl {
            font-size: 0.7rem;
            text-transform: uppercase;
            color: var(--text-muted);
            font-weight: 700;
            letter-spacing: 0.05em;
        }

        .cred-val {
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.9rem;
            color: var(--g-blue);
            font-weight: 600;
            word-break: break-all;
        }

        /* Toast notification */
        .toast {
            position: fixed;
            bottom: 24px;
            right: 24px;
            background: #1e293b;
            color: #ffffff;
            padding: 12px 20px;
            border-radius: 12px;
            box-shadow: var(--shadow-lg);
            font-size: 0.875rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 10px;
            z-index: 1000;
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
            pointer-events: none;
        }

        .toast.show {
            opacity: 1;
            transform: translateY(0);
            pointer-events: auto;
        }

        /* Pagination */
        .pagination-wrap {
            padding: 16px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-top: 2px solid #e2e8f0;
            background: #f8fafc;
        }

        @media (max-width: 992px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            .settings-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 640px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }
            .topbar {
                flex-direction: column;
                align-items: flex-start;
                gap: 16px;
            }
            .filter-bar {
                flex-direction: column;
                align-items: stretch;
            }
            .search-box {
                min-width: 100%;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <!-- Top Bar -->
    <div class="topbar">
        <div class="brand-box">
            <div class="brand-icon">
                <i class="ph-bold ph-lightning"></i>
            </div>
            <div>
                <div style="display: flex; align-items: center; gap: 10px;">
                    <h1 class="brand-title">XUI Reseller Automation Hub</h1>
                    <span class="secret-badge"><i class="ph-fill ph-lock-key"></i> Secret Portal</span>
                </div>
                <p style="font-size: 0.8rem; color: var(--text-muted); margin-top: 2px;">
                    Automated IPTV line generation & order delivery management
                </p>
            </div>
        </div>

        <div class="topbar-actions">
            <button type="button" class="btn btn-secondary btn-sm" onclick="switchTab('settings')">
                <i class="ph-bold ph-gear-six"></i>
                <span>Panel Settings</span>
            </button>
            <a href="{{ route('home') }}" target="_blank" class="btn btn-secondary btn-sm">
                <i class="ph-bold ph-arrow-square-out"></i>
                <span>Open Website</span>
            </a>
        </div>
    </div>

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="alert alert-success">
            <i class="ph-fill ph-check-circle" style="font-size: 20px;"></i>
            <div>{{ session('success') }}</div>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-error">
            <i class="ph-fill ph-warning-circle" style="font-size: 20px;"></i>
            <div>{{ session('error') }}</div>
        </div>
    @endif

    <!-- Quick Stats Grid -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon-wrap stat-icon-purple">
                <i class="ph-fill ph-shopping-bag"></i>
            </div>
            <div class="stat-content">
                <h4>Total Orders</h4>
                <div class="stat-value">{{ number_format($totalOrders) }}</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon-wrap stat-icon-amber">
                <i class="ph-fill ph-clock-countdown"></i>
            </div>
            <div class="stat-content">
                <h4>Pending Delivery</h4>
                <div class="stat-value" style="display: flex; align-items: center; gap: 8px;">
                    {{ number_format($pendingOrders) }}
                    @if($pendingOrders > 0)
                        <span class="pulse-badge" title="Orders waiting for credentials"></span>
                    @endif
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon-wrap stat-icon-green">
                <i class="ph-fill ph-check-fat"></i>
            </div>
            <div class="stat-content">
                <h4>Fulfilled & Active</h4>
                <div class="stat-value">{{ number_format($completedOrders) }}</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon-wrap stat-icon-blue">
                <i class="ph-fill ph-currency-dollar"></i>
            </div>
            <div class="stat-content">
                <h4>Completed Revenue</h4>
                <div class="stat-value">${{ number_format($totalRevenue, 2) }}</div>
            </div>
        </div>
    </div>

    <!-- Navigation Tabs -->
    <div class="tabs-header">
        <button class="tab-btn active" id="tab-btn-orders" onclick="switchTab('orders')">
            <i class="ph-bold ph-receipt"></i>
            <span>Live Orders Feed</span>
            <span class="tab-badge">{{ $totalOrders }}</span>
        </button>
        <button class="tab-btn" id="tab-btn-settings" onclick="switchTab('settings')">
            <i class="ph-bold ph-sliders-horizontal"></i>
            <span>XUI / Xtream Settings</span>
        </button>
        <button class="tab-btn" id="tab-btn-generator" onclick="switchTab('generator')">
            <i class="ph-bold ph-magic-wand"></i>
            <span>Quick Line Generator</span>
        </button>
    </div>

    <!-- TAB 1: LIVE ORDERS FEED -->
    <div class="tab-pane active" id="pane-orders">
        <!-- Filter & Search Bar -->
        <div class="filter-bar">
            <div class="status-pills">
                <a href="{{ route('secret.reseller.index', ['status' => 'all', 'search' => $searchQuery]) }}" 
                   class="status-pill {{ $statusFilter === 'all' ? 'active' : '' }}">
                   All Orders
                </a>
                <a href="{{ route('secret.reseller.index', ['status' => 'pending', 'search' => $searchQuery]) }}" 
                   class="status-pill {{ $statusFilter === 'pending' ? 'active' : '' }}">
                   ⏳ Pending Delivery
                </a>
                <a href="{{ route('secret.reseller.index', ['status' => 'completed', 'search' => $searchQuery]) }}" 
                   class="status-pill {{ $statusFilter === 'completed' ? 'active' : '' }}">
                   ✅ Delivered
                </a>
                <a href="{{ route('secret.reseller.index', ['status' => 'unpaid', 'search' => $searchQuery]) }}" 
                   class="status-pill {{ $statusFilter === 'unpaid' ? 'active' : '' }}">
                   💳 Unpaid
                </a>
            </div>

            <form method="GET" action="{{ route('secret.reseller.index') }}" class="search-box">
                <input type="hidden" name="status" value="{{ $statusFilter }}">
                <i class="ph ph-magnifying-glass"></i>
                <input type="text" name="search" value="{{ $searchQuery }}" placeholder="Search customer, email, order #...">
            </form>
        </div>

        <!-- Orders Table -->
        <div class="table-card">
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>Order # / Date</th>
                            <th>Customer Info</th>
                            <th>Package & Duration</th>
                            <th>Amount & Payment</th>
                            <th>Delivery Status</th>
                            <th style="text-align: right;">Automation Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                            @php
                                $creds = $order->subscription_details;
                                $isDelivered = !empty($creds) && !empty($creds['username']);
                            @endphp
                            <tr>
                                <td>
                                    <span class="order-tag">{{ $order->order_number }}</span>
                                    <span class="order-time">{{ $order->created_at->format('M d, Y • h:i A') }}</span>
                                </td>
                                <td>
                                    <div class="customer-cell">
                                        <span class="customer-name">{{ $order->customer_name ?: 'Customer' }}</span>
                                        <span class="customer-email">{{ $order->customer_email }}</span>
                                        @if($order->customer_phone)
                                            <span style="font-size: 0.75rem; color: var(--text-muted);">{{ $order->customer_phone }}</span>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div class="pkg-badge">
                                        <i class="ph-fill ph-television" style="color: var(--g-blue);"></i>
                                        <span>{{ $order->package ? $order->package->name : 'Custom Plan' }}</span>
                                    </div>
                                    <div style="font-size: 0.75rem; color: var(--text-muted); margin-top: 4px; font-weight: 500;">
                                        {{ $order->package ? $order->package->duration_label : '1 Month' }} • {{ $order->package ? $order->package->devices : 1 }} Dev
                                    </div>
                                </td>
                                <td>
                                    <div style="font-weight: 800; font-size: 0.95rem; color: var(--text-title);">${{ number_format($order->amount, 2) }}</div>
                                    <span class="status-badge {{ $order->payment_status === 'completed' ? 'badge-success' : 'badge-warning' }}">
                                        {{ ucfirst($order->payment_status) }}
                                    </span>
                                </td>
                                <td>
                                    @if($isDelivered)
                                        <span class="status-badge badge-success">
                                            <i class="ph-bold ph-check"></i> Delivered
                                        </span>
                                        @if($order->email_sent_at)
                                            <span style="display: block; font-size: 0.72rem; color: var(--text-muted); margin-top: 3px;">
                                                Emailed: {{ $order->email_sent_at->diffForHumans() }}
                                            </span>
                                        @endif
                                    @else
                                        <span class="status-badge badge-warning">
                                            <i class="ph-bold ph-hourglass"></i> Pending Line
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <div class="action-group" style="justify-content: flex-end;">
                                        @if(!$isDelivered)
                                            <!-- 1-Click Generate Button -->
                                            <form method="POST" action="{{ route('secret.reseller.generate', $order) }}" style="display: inline;" onsubmit="showButtonLoading(this)">
                                                @csrf
                                                <button type="submit" class="btn btn-primary btn-sm">
                                                    <i class="ph-bold ph-lightning"></i>
                                                    <span>Generate & Deliver</span>
                                                </button>
                                            </form>
                                        @else
                                            <!-- Copy & View Credentials -->
                                            <button type="button" class="btn btn-secondary btn-sm" onclick="openViewModal({{ json_encode($order) }}, {{ json_encode($creds) }})">
                                                <i class="ph-bold ph-key"></i>
                                                <span>Credentials</span>
                                            </button>

                                            <!-- Resend Email -->
                                            <form method="POST" action="{{ route('secret.reseller.resend-email', $order) }}" style="display: inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-secondary btn-sm" title="Resend delivery email">
                                                    <i class="ph-bold ph-paper-plane-tilt"></i>
                                                </button>
                                            </form>
                                        @endif

                                        <!-- Manual Edit / Override -->
                                        <button type="button" class="btn btn-secondary btn-sm" title="Manual Line Delivery" onclick="openManualModal({{ json_encode($order) }}, {{ json_encode($creds) }})">
                                            <i class="ph-bold ph-pencil-simple"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="text-align: center; padding: 48px 20px; color: var(--text-muted);">
                                    <i class="ph-duotone ph-magnifying-glass" style="font-size: 36px; display: block; margin-bottom: 8px; color: var(--text-subtle);"></i>
                                    No orders found matching your search criteria.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($orders->hasPages())
                <div class="pagination-wrap">
                    <div style="font-size: 0.825rem; color: var(--text-muted); font-weight: 500;">
                        Showing {{ $orders->firstItem() }} to {{ $orders->lastItem() }} of {{ $orders->total() }} orders
                    </div>
                    <div>
                        {{ $orders->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- TAB 2: XUI / XTREAM SETTINGS -->
    <div class="tab-pane" id="pane-settings">
        <div class="settings-grid">
            <div class="card">
                <h2 class="card-title">
                    <i class="ph-bold ph-plugs-connected" style="color: var(--g-blue);"></i>
                    XUI / Xtream Codes Panel Connection
                </h2>
                <p class="card-desc">
                    Configure your XUI.ONE Panel connection (e.g. <strong>http://kytv.xyz/HckqYJZU</strong>) to automate account creation and delivery.
                </p>

                <form method="POST" action="{{ route('secret.reseller.settings.update') }}">
                    @csrf
                    
                    <div class="form-group">
                        <label class="form-label">XUI Panel URL</label>
                        <input type="text" name="panel_url" class="form-control" id="cfg_panel_url" value="{{ $settings['panel_url'] }}" placeholder="http://kytv.xyz/HckqYJZU">
                        <small style="color: var(--text-muted); font-size: 0.775rem; margin-top: 4px; display: block;">
                            Your XUI panel reseller login URL with secret key (e.g. <code>http://kytv.xyz/HckqYJZU</code>).
                        </small>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                        <div class="form-group">
                            <label class="form-label">Reseller Username / Owner</label>
                            <input type="text" name="username" class="form-control" id="cfg_username" value="{{ $settings['username'] }}" placeholder="e.g. Hasil47228">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Reseller Password</label>
                            <input type="password" name="password" class="form-control" id="cfg_password" placeholder="{{ !empty($settings['password']) ? '•••••••••••• (Saved)' : 'Enter your XUI password' }}">
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                        <div class="form-group">
                            <label class="form-label">Default Client Portal DNS</label>
                            <input type="text" name="portal_dns" class="form-control" value="{{ $settings['portal_dns'] }}" placeholder="http://kytv.xyz:8080">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Username Prefix for Created Lines</label>
                            <input type="text" name="user_prefix" class="form-control" value="{{ $settings['user_prefix'] ?? 'bestuser' }}" placeholder="e.g. bestuser">
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                        <div class="form-group">
                            <label class="form-label">Default Output Stream Format</label>
                            <select name="output_format" class="form-control">
                                <option value="ts" {{ $settings['output_format'] === 'ts' ? 'selected' : '' }}>MPEG-TS (.ts)</option>
                                <option value="m3u8" {{ $settings['output_format'] === 'm3u8' ? 'selected' : '' }}>HLS (.m3u8)</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Default Bouquet IDs (Optional)</label>
                            <input type="text" name="default_bouquets" class="form-control" value="{{ $settings['default_bouquets'] }}" placeholder="e.g. 1,2,3,4 (comma separated)">
                        </div>
                    </div>

                    <div class="form-switch">
                        <div>
                            <div class="switch-label">Instant Auto-Fulfill upon Payment</div>
                            <div class="switch-desc">Automatically create line on XUI & email credentials immediately when customer checkout is paid.</div>
                        </div>
                        <label class="switch">
                            <input type="checkbox" name="auto_fulfill" value="1" {{ $settings['auto_fulfill'] ? 'checked' : '' }}>
                            <span class="slider"></span>
                        </label>
                    </div>

                    <div style="display: flex; gap: 12px; margin-top: 24px;">
                        <button type="submit" class="btn btn-primary">
                            <i class="ph-bold ph-floppy-disk"></i>
                            <span>Save Settings</span>
                        </button>

                        <button type="button" class="btn btn-secondary" onclick="testPanelConnection()">
                            <i class="ph-bold ph-broadcast"></i>
                            <span>Test Live Connection</span>
                        </button>
                    </div>

                    <!-- Test Output Box -->
                    <div id="testConnectionBox" class="test-box"></div>
                </form>
            </div>

            <!-- Side Card: Information & Quick Help -->
            <div>
                <div class="card" style="margin-bottom: 20px;">
                    <h3 class="card-title" style="font-size: 1rem;">
                        <i class="ph-bold ph-shield-check" style="color: var(--g-green);"></i>
                        XUI.ONE Automation Guide
                    </h3>
                    <ul style="padding-left: 18px; color: var(--text-muted); font-size: 0.825rem; line-height: 1.7; margin-top: 10px;">
                        <li>Connected directly to your XUI Panel: <strong>kytv.xyz</strong></li>
                        <li>Creates user accounts with username prefix (e.g. <code>bestuserXXXX</code>) and random 8-char secure passwords.</li>
                        <li>Uses your reseller account <strong>{{ $settings['username'] ?: 'Hasil47228' }}</strong> to deduct credits automatically.</li>
                    </ul>
                </div>

                <div class="card">
                    <h3 class="card-title" style="font-size: 1rem;">
                        <i class="ph-bold ph-link-simple" style="color: var(--g-blue);"></i>
                        Generated M3U Structure
                    </h3>
                    <p style="font-size: 0.775rem; color: var(--text-muted); margin-top: 6px;">
                        The system generates standard Xtream Codes and M3U Plus format compatible with TiviMate, IPTV Smarters, IPTV Smart Player, XCIPTV, and VLC.
                    </p>
                    <div style="background: #f1f5f9; border: 1px solid #e2e8f0; padding: 12px; border-radius: 10px; font-family: 'JetBrains Mono', monospace; font-size: 0.75rem; color: var(--g-blue); margin-top: 10px; word-break: break-all; font-weight: 600;">
                        {portal_dns}/get.php?username={user}&password={pass}&type=m3u_plus&output=ts
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- TAB 3: QUICK SCRATCHPAD GENERATOR -->
    <div class="tab-pane" id="pane-generator">
        <div class="card" style="max-width: 700px; margin: 0 auto;">
            <h2 class="card-title">
                <i class="ph-bold ph-magic-wand" style="color: var(--g-purple);"></i>
                Instant Line Scratchpad
            </h2>
            <p class="card-desc">
                Need to quickly generate a test line or deliver an off-site customer subscription? Use this instant builder.
            </p>

            <div class="form-group">
                <label class="form-label">Customer Name</label>
                <input type="text" id="quick_name" class="form-control" placeholder="e.g. John Doe" oninput="updateQuickPreview()">
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                <div class="form-group">
                    <label class="form-label">Username</label>
                    <input type="text" id="quick_user" class="form-control" placeholder="e.g. bestuser9821" oninput="updateQuickPreview()">
                </div>
                <div class="form-group">
                    <label class="form-label">Password</label>
                    <input type="text" id="quick_pass" class="form-control" placeholder="Auto-generated if blank" oninput="updateQuickPreview()">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Portal DNS</label>
                <input type="text" id="quick_dns" class="form-control" value="{{ $settings['portal_dns'] }}" oninput="updateQuickPreview()">
            </div>

            <div style="margin-top: 20px;">
                <button type="button" class="btn btn-primary" onclick="generateQuickLine()">
                    <i class="ph-bold ph-lightning"></i>
                    <span>Generate Instant Credentials</span>
                </button>
            </div>

            <div id="quickResultBox" style="display: none; margin-top: 24px; border-top: 2px solid #e2e8f0; padding-top: 20px;">
                <h4 style="color: var(--text-title); margin-bottom: 12px; font-size: 1rem;">Generated Credentials:</h4>
                <div class="cred-copy-box">
                    <div class="cred-info">
                        <span class="cred-lbl">Portal URL</span>
                        <span class="cred-val" id="res_portal"></span>
                    </div>
                    <button class="btn btn-secondary btn-sm" onclick="copyText(document.getElementById('res_portal').innerText)">Copy</button>
                </div>
                <div class="cred-copy-box">
                    <div class="cred-info">
                        <span class="cred-lbl">Username</span>
                        <span class="cred-val" id="res_user"></span>
                    </div>
                    <button class="btn btn-secondary btn-sm" onclick="copyText(document.getElementById('res_user').innerText)">Copy</button>
                </div>
                <div class="cred-copy-box">
                    <div class="cred-info">
                        <span class="cred-lbl">Password</span>
                        <span class="cred-val" id="res_pass"></span>
                    </div>
                    <button class="btn btn-secondary btn-sm" onclick="copyText(document.getElementById('res_pass').innerText)">Copy</button>
                </div>
                <div class="cred-copy-box">
                    <div class="cred-info">
                        <span class="cred-lbl">M3U Playlist URL</span>
                        <span class="cred-val" id="res_m3u"></span>
                    </div>
                    <button class="btn btn-secondary btn-sm" onclick="copyText(document.getElementById('res_m3u').innerText)">Copy</button>
                </div>
                <button type="button" class="btn btn-success" style="width: 100%; margin-top: 10px;" onclick="copyAllQuick()">
                    <i class="ph-bold ph-copy"></i>
                    <span>Copy Full Customer Access Message</span>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL 1: VIEW & COPY CREDENTIALS -->
<div class="modal-overlay" id="viewModal">
    <div class="modal-card">
        <div class="modal-header">
            <h3 style="font-size: 1.15rem; font-weight: 700; color: var(--text-title); display: flex; align-items: center; gap: 8px;">
                <i class="ph-bold ph-key" style="color: var(--g-blue);"></i>
                <span>Customer IPTV Credentials</span>
            </h3>
            <button class="modal-close" onclick="closeModal('viewModal')"><i class="ph ph-x"></i></button>
        </div>

        <div style="margin-bottom: 18px;">
            <div style="font-size: 0.85rem; color: var(--text-muted);" id="vm_order_info"></div>
        </div>

        <div class="cred-copy-box">
            <div class="cred-info">
                <span class="cred-lbl">Portal URL / Server DNS</span>
                <span class="cred-val" id="vm_portal"></span>
            </div>
            <button class="btn btn-secondary btn-sm" onclick="copyText(document.getElementById('vm_portal').innerText)">Copy</button>
        </div>

        <div class="cred-copy-box">
            <div class="cred-info">
                <span class="cred-lbl">Username</span>
                <span class="cred-val" id="vm_user"></span>
            </div>
            <button class="btn btn-secondary btn-sm" onclick="copyText(document.getElementById('vm_user').innerText)">Copy</button>
        </div>

        <div class="cred-copy-box">
            <div class="cred-info">
                <span class="cred-lbl">Password</span>
                <span class="cred-val" id="vm_pass"></span>
            </div>
            <button class="btn btn-secondary btn-sm" onclick="copyText(document.getElementById('vm_pass').innerText)">Copy</button>
        </div>

        <div class="cred-copy-box">
            <div class="cred-info">
                <span class="cred-lbl">M3U Playlist URL</span>
                <span class="cred-val" id="vm_m3u"></span>
            </div>
            <button class="btn btn-secondary btn-sm" onclick="copyText(document.getElementById('vm_m3u').innerText)">Copy</button>
        </div>

        <div style="display: flex; gap: 12px; margin-top: 20px;">
            <button type="button" class="btn btn-primary" style="flex: 1;" onclick="copyAllModal()">
                <i class="ph-bold ph-copy"></i>
                <span>Copy Full Details</span>
            </button>
            <button type="button" class="btn btn-secondary" onclick="closeModal('viewModal')">Close</button>
        </div>
    </div>
</div>

<!-- MODAL 2: MANUAL OVERRIDE / ASSIGN CREDENTIALS -->
<div class="modal-overlay" id="manualModal">
    <div class="modal-card">
        <div class="modal-header">
            <h3 style="font-size: 1.15rem; font-weight: 700; color: var(--text-title); display: flex; align-items: center; gap: 8px;">
                <i class="ph-bold ph-pencil-simple" style="color: var(--g-yellow);"></i>
                <span>Manual Line Assignment</span>
            </h3>
            <button class="modal-close" onclick="closeModal('manualModal')"><i class="ph ph-x"></i></button>
        </div>

        <form id="manualForm" method="POST" action="">
            @csrf
            <div style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 16px;" id="mm_order_info"></div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px;">
                <div class="form-group">
                    <label class="form-label">Username *</label>
                    <input type="text" name="username" id="mm_user" class="form-control" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Password *</label>
                    <input type="text" name="password" id="mm_pass" class="form-control" required>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Portal DNS</label>
                <input type="text" name="portal_url" id="mm_portal" class="form-control" value="{{ $settings['portal_dns'] }}">
            </div>

            <div class="form-group">
                <label class="form-label">M3U Playlist URL (Optional)</label>
                <input type="text" name="m3u_url" id="mm_m3u" class="form-control" placeholder="Leave empty to auto-build from DNS + user + pass">
            </div>

            <div class="form-group">
                <label class="form-label">Duration (Days)</label>
                <input type="number" name="duration_days" id="mm_days" class="form-control" value="30">
            </div>

            <div class="form-switch" style="margin-top: 10px;">
                <div>
                    <div class="switch-label">Send Delivery Email to Customer</div>
                    <div class="switch-desc">Sends the credentials to the customer's email address upon saving.</div>
                </div>
                <label class="switch">
                    <input type="checkbox" name="send_email" value="1" checked>
                    <span class="slider"></span>
                </label>
            </div>

            <div style="display: flex; gap: 12px; margin-top: 20px;">
                <button type="submit" class="btn btn-primary" style="flex: 1;">
                    <i class="ph-bold ph-check"></i>
                    <span>Save & Deliver Line</span>
                </button>
                <button type="button" class="btn btn-secondary" onclick="closeModal('manualModal')">Cancel</button>
            </div>
        </form>
    </div>
</div>

<!-- Toast Box -->
<div class="toast" id="toastBox">
    <i class="ph-bold ph-check-circle" style="font-size: 18px; color: #4ade80;"></i>
    <span id="toastText">Copied to clipboard!</span>
</div>

<script>
    // Tab switching
    function switchTab(tabId) {
        document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
        document.querySelectorAll('.tab-pane').forEach(p => p.classList.remove('active'));

        const btn = document.getElementById('tab-btn-' + tabId);
        const pane = document.getElementById('pane-' + tabId);
        if (btn && pane) {
            btn.classList.add('active');
            pane.classList.add('active');
        }
    }

    // Modal helpers
    function openModal(id) {
        document.getElementById(id).classList.add('active');
    }

    function closeModal(id) {
        document.getElementById(id).classList.remove('active');
    }

    // View Credentials modal
    let currentModalCreds = null;
    let currentModalOrder = null;

    function openViewModal(order, creds) {
        currentModalOrder = order;
        currentModalCreds = creds || {};

        document.getElementById('vm_order_info').innerHTML = `Order <strong>#${order.order_number}</strong> — ${order.customer_name} (${order.customer_email})`;
        document.getElementById('vm_portal').innerText = creds.portal_url || 'N/A';
        document.getElementById('vm_user').innerText = creds.username || 'N/A';
        document.getElementById('vm_pass').innerText = creds.password || 'N/A';
        document.getElementById('vm_m3u').innerText = creds.m3u_url || 'N/A';

        openModal('viewModal');
    }

    function copyAllModal() {
        if (!currentModalCreds) return;
        const text = `🎉 Your IPTV Subscription Details\n--------------------------------\nOrder: #${currentModalOrder.order_number}\nPortal URL: ${currentModalCreds.portal_url}\nUsername: ${currentModalCreds.username}\nPassword: ${currentModalCreds.password}\nM3U Playlist: ${currentModalCreds.m3u_url}\n--------------------------------\nThank you for choosing Live IPTV Now!`;
        copyText(text, 'Full IPTV details copied to clipboard!');
    }

    // Manual Edit modal
    function openManualModal(order, creds) {
        const form = document.getElementById('manualForm');
        form.action = `/secret-reseller-hub-8829/manual-deliver/${order.id}`;

        document.getElementById('mm_order_info').innerHTML = `Order <strong>#${order.order_number}</strong> for <strong>${order.customer_name}</strong> (${order.customer_email})`;
        const userPrefix = '{{ $settings['user_prefix'] ?? 'bestuser' }}';
        document.getElementById('mm_user').value = creds && creds.username ? creds.username : (userPrefix + Math.floor(1000 + Math.random() * 9000));
        document.getElementById('mm_pass').value = creds && creds.password ? creds.password : Math.random().toString(36).slice(-8);
        document.getElementById('mm_portal').value = creds && creds.portal_url ? creds.portal_url : '{{ $settings['portal_dns'] }}';
        document.getElementById('mm_m3u').value = creds && creds.m3u_url ? creds.m3u_url : '';
        document.getElementById('mm_days').value = creds && creds.duration_days ? creds.duration_days : (order.package && order.package.duration_days ? order.package.duration_days : 30);

        openModal('manualModal');
    }

    // Copy to clipboard with toast
    function copyText(text, msg = 'Copied to clipboard!') {
        navigator.clipboard.writeText(text).then(() => {
            showToast(msg);
        });
    }

    function showToast(msg) {
        const toast = document.getElementById('toastBox');
        document.getElementById('toastText').innerText = msg;
        toast.classList.add('show');
        setTimeout(() => toast.classList.remove('show'), 2500);
    }

    // Test XUI Panel connection
    function testPanelConnection() {
        const url = document.getElementById('cfg_panel_url').value;
        const user = document.getElementById('cfg_username').value;
        const pass = document.getElementById('cfg_password').value;
        const box = document.getElementById('testConnectionBox');

        box.style.display = 'block';
        box.innerHTML = `<span style="color: var(--g-blue);"><i class="ph-bold ph-spinner ph-spin"></i> Connecting to ${url || 'server'}...</span>`;

        fetch('{{ route('secret.reseller.test-connection') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                panel_url: url,
                username: user,
                password: pass
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                box.innerHTML = `<span style="color: var(--g-green); font-weight: 700;"><i class="ph-bold ph-check-circle"></i> ${data.message}</span>`;
                if (data.data) {
                    box.innerHTML += `<div style="margin-top: 8px; color: var(--text-muted); font-size: 0.75rem;">Status: ${JSON.stringify(data.data)}</div>`;
                }
            } else {
                box.innerHTML = `<span style="color: var(--g-red); font-weight: 700;"><i class="ph-bold ph-x-circle"></i> ${data.message}</span>`;
            }
        })
        .catch(err => {
            box.innerHTML = `<span style="color: var(--g-red); font-weight: 700;"><i class="ph-bold ph-x-circle"></i> Request error: ${err.message}</span>`;
        });
    }

    // Button loading state
    function showButtonLoading(form) {
        const btn = form.querySelector('button[type="submit"]');
        if (btn) {
            btn.disabled = true;
            btn.innerHTML = `<i class="ph-bold ph-spinner ph-spin"></i> Generating...`;
        }
    }

    // Instant Scratchpad Generator
    function generateQuickLine() {
        const userPrefix = '{{ $settings['user_prefix'] ?? 'bestuser' }}';
        const user = document.getElementById('quick_user').value || (userPrefix + Math.floor(1000 + Math.random() * 9000));
        const pass = document.getElementById('quick_pass').value || Math.random().toString(36).slice(-8);
        const dns = (document.getElementById('quick_dns').value || '{{ $settings['portal_dns'] }}').replace(/\/$/, '');
        const m3u = `${dns}/get.php?username=${user}&password=${pass}&type=m3u_plus&output=ts`;

        document.getElementById('res_portal').innerText = dns;
        document.getElementById('res_user').innerText = user;
        document.getElementById('res_pass').innerText = pass;
        document.getElementById('res_m3u').innerText = m3u;
        document.getElementById('quickResultBox').style.display = 'block';
    }

    function copyAllQuick() {
        const portal = document.getElementById('res_portal').innerText;
        const user = document.getElementById('res_user').innerText;
        const pass = document.getElementById('res_pass').innerText;
        const m3u = document.getElementById('res_m3u').innerText;

        const text = `🎉 Your IPTV Subscription Details\n--------------------------------\nPortal URL: ${portal}\nUsername: ${user}\nPassword: ${pass}\nM3U Playlist: ${m3u}\n--------------------------------\nThank you for choosing Live IPTV Now!`;
        copyText(text, 'Access message copied to clipboard!');
    }
</script>

</body>
</html>
