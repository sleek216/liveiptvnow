<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Live IPTV Now &lsaquo; XUI Order Automation &#8212; WordPress</title>
    
    <!-- Fonts & Phosphor Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,400;0,600;0,700;1,400&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    
    <style>
        /* ==========================================================================
           WordPress Admin Theme Stylesheet (Classic WP Admin / WooCommerce Look)
           ========================================================================== */
        :root {
            --wp-admin-bar: #1d2327;
            --wp-menu-bg: #1d2327;
            --wp-menu-active: #2271b1;
            --wp-menu-text: #f0f0f1;
            --wp-menu-hover: #135e96;
            --wp-body-bg: #f0f0f1;
            --wp-card-bg: #ffffff;
            --wp-border: #c3c4c7;
            --wp-border-subtle: #dcdcde;
            --wp-text-main: #2c3338;
            --wp-text-muted: #646970;
            --wp-text-link: #2271b1;
            --wp-btn-primary: #2271b1;
            --wp-btn-primary-hover: #135e96;
            --wp-btn-success: #008a20;
            --wp-btn-success-hover: #007017;
            --wp-badge-green: #d1e7dd;
            --wp-badge-green-text: #0f5132;
            --wp-badge-orange: #fff3cd;
            --wp-badge-orange-text: #664d03;
            --wp-badge-red: #f8d7da;
            --wp-badge-red-text: #842029;
            --wp-badge-blue: #cff4fc;
            --wp-badge-blue-text: #055160;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: var(--wp-body-bg);
            color: var(--wp-text-main);
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif;
            font-size: 13px;
            line-height: 1.4em;
            min-height: 100vh;
        }

        /* WordPress Admin Bar (Top Bar) */
        #wpadminbar {
            background: var(--wp-admin-bar);
            height: 32px;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 99999;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 16px;
            color: #c3c4c7;
            font-size: 12px;
        }

        .wp-bar-left, .wp-bar-right {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .wp-logo {
            display: flex;
            align-items: center;
            gap: 6px;
            color: #ffffff;
            font-weight: 700;
            text-decoration: none;
            font-size: 13px;
        }

        .wp-logo i {
            font-size: 18px;
            color: #72aee6;
        }

        .wp-bar-link {
            color: #c3c4c7;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 4px;
            transition: color 0.15s;
        }

        .wp-bar-link:hover {
            color: #72aee6;
        }

        .wp-secret-tag {
            background: #d63638;
            color: #ffffff;
            font-size: 10px;
            font-weight: 700;
            padding: 2px 6px;
            border-radius: 3px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Layout Container */
        .wp-wrap {
            display: flex;
            margin-top: 32px;
            min-height: calc(100vh - 32px);
        }

        /* WordPress Sidebar Menu */
        #adminmenu {
            width: 160px;
            background: var(--wp-menu-bg);
            flex-shrink: 0;
            padding-top: 12px;
        }

        .menu-item {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 10px 14px;
            color: #c3c4c7;
            text-decoration: none;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            border-left: 4px solid transparent;
            transition: all 0.15s ease;
        }

        .menu-item i {
            font-size: 16px;
        }

        .menu-item:hover {
            background: #135e96;
            color: #ffffff;
        }

        .menu-item.active {
            background: var(--wp-menu-active);
            color: #ffffff;
            font-weight: 600;
            border-left-color: #72aee6;
        }

        .menu-badge {
            margin-left: auto;
            background: #d63638;
            color: #ffffff;
            border-radius: 10px;
            padding: 1px 6px;
            font-size: 10px;
            font-weight: 700;
        }

        /* WordPress Body Content */
        #wpbody {
            flex-grow: 1;
            padding: 20px 24px;
            max-width: calc(100vw - 160px);
        }

        /* WordPress Page Header */
        .wp-page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 18px;
        }

        .wp-heading-inline {
            font-size: 23px;
            font-weight: 400;
            color: #1d2327;
            display: inline-block;
            margin-right: 12px;
        }

        .page-title-action {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 4px 10px;
            font-size: 13px;
            font-weight: 600;
            color: var(--wp-btn-primary);
            border: 1px solid var(--wp-btn-primary);
            border-radius: 3px;
            background: #f6f7f7;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.15s;
        }

        .page-title-action:hover {
            background: #f0f0f1;
            border-color: #135e96;
            color: #135e96;
        }

        /* WordPress Notices */
        .notice {
            background: #fff;
            border: 1px solid var(--wp-border);
            border-left-width: 4px;
            box-shadow: 0 1px 1px rgba(0,0,0,.04);
            padding: 12px 14px;
            margin-bottom: 16px;
            font-size: 13px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .notice-success {
            border-left-color: #00a32a;
        }

        .notice-error {
            border-left-color: #d63638;
        }

        .notice-warning {
            border-left-color: #dba617;
        }

        /* WordPress Postbox / Card */
        .postbox {
            background: #ffffff;
            border: 1px solid var(--wp-border);
            box-shadow: 0 1px 1px rgba(0,0,0,.04);
            margin-bottom: 20px;
        }

        .postbox-header {
            padding: 12px 16px;
            border-bottom: 1px solid var(--wp-border-subtle);
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #fafafa;
        }

        .postbox-title {
            font-size: 14px;
            font-weight: 600;
            color: #1d2327;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .inside {
            padding: 16px;
        }

        /* WooCommerce Summary Stats Bar */
        .wp-stats-row {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-bottom: 20px;
        }

        .wp-stat-box {
            background: #ffffff;
            border: 1px solid var(--wp-border);
            padding: 14px 18px;
            box-shadow: 0 1px 1px rgba(0,0,0,.04);
        }

        .wp-stat-title {
            font-size: 12px;
            font-weight: 600;
            color: var(--wp-text-muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }

        .wp-stat-number {
            font-size: 22px;
            font-weight: 700;
            color: #1d2327;
        }

        /* Filter Subsubsub Navigation (WordPress Standard) */
        .subsubsub {
            list-style: none;
            margin: 0 0 14px 0;
            padding: 0;
            font-size: 13px;
            color: #646970;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .subsubsub a {
            color: var(--wp-btn-primary);
            text-decoration: none;
            padding: 2px 6px;
            border-radius: 3px;
        }

        .subsubsub a:hover {
            color: #135e96;
        }

        .subsubsub a.current {
            font-weight: 600;
            color: #000;
            background: #e2e4e7;
        }

        .subsubsub .count {
            color: #50575e;
            font-weight: 400;
        }

        /* WordPress List Table */
        .wp-list-table {
            width: 100%;
            border-collapse: collapse;
            background: #ffffff;
            border: 1px solid var(--wp-border);
            box-shadow: 0 1px 1px rgba(0,0,0,.04);
        }

        .wp-list-table thead th {
            background: #f6f7f7;
            border-bottom: 1px solid var(--wp-border);
            padding: 10px 12px;
            font-size: 12px;
            font-weight: 700;
            color: #2c3338;
            text-align: left;
        }

        .wp-list-table tbody tr {
            border-bottom: 1px solid #f0f0f1;
            transition: background 0.1s;
        }

        .wp-list-table tbody tr:hover {
            background: #f9f9f9;
        }

        .wp-list-table tbody td {
            padding: 12px;
            font-size: 13px;
            vertical-align: middle;
        }

        /* Order Status Pills (WooCommerce style) */
        .order-status {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: 700;
            line-height: 1.2;
            text-transform: uppercase;
        }

        .status-completed { background: var(--wp-badge-green); color: var(--wp-badge-green-text); }
        .status-processing { background: var(--wp-badge-blue); color: var(--wp-badge-blue-text); }
        .status-pending { background: var(--wp-badge-orange); color: var(--wp-badge-orange-text); }
        .status-failed { background: var(--wp-badge-red); color: var(--wp-badge-red-text); }

        /* WordPress Buttons */
        .button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
            font-size: 12px;
            font-weight: 600;
            line-height: 2;
            padding: 0 10px;
            min-height: 28px;
            border-radius: 3px;
            cursor: pointer;
            border: 1px solid var(--wp-border);
            background: #f6f7f7;
            color: #2c3338;
            text-decoration: none;
            white-space: nowrap;
            transition: all 0.15s;
            font-family: inherit;
        }

        .button:hover {
            background: #f0f0f1;
            border-color: #8c8f94;
            color: #1d2327;
        }

        .button-primary {
            background: var(--wp-btn-primary);
            border-color: var(--wp-btn-primary);
            color: #ffffff;
        }

        .button-primary:hover {
            background: var(--wp-btn-primary-hover);
            border-color: var(--wp-btn-primary-hover);
            color: #ffffff;
        }

        .button-success {
            background: var(--wp-btn-success);
            border-color: var(--wp-btn-success);
            color: #ffffff;
        }

        .button-success:hover {
            background: var(--wp-btn-success-hover);
            border-color: var(--wp-btn-success-hover);
            color: #ffffff;
        }

        .button-small {
            min-height: 26px;
            line-height: 1.8;
            padding: 0 8px;
            font-size: 11px;
        }

        /* Form Table (Classic WordPress Setting Table) */
        .form-table {
            width: 100%;
            border-collapse: collapse;
        }

        .form-table th {
            width: 220px;
            padding: 16px 10px 16px 0;
            vertical-align: top;
            text-align: left;
            font-size: 13px;
            font-weight: 600;
            color: #1d2327;
        }

        .form-table td {
            padding: 12px 10px;
            vertical-align: middle;
        }

        .regular-text {
            width: 100%;
            max-width: 450px;
            padding: 6px 8px;
            border: 1px solid var(--wp-border);
            border-radius: 3px;
            font-size: 13px;
            color: #2c3338;
            outline: none;
        }

        .regular-text:focus {
            border-color: var(--wp-btn-primary);
            box-shadow: 0 0 0 1px var(--wp-btn-primary);
        }

        .description {
            color: #646970;
            font-size: 12px;
            font-style: italic;
            margin-top: 4px;
            display: block;
        }

        /* Tab Panes */
        .tab-pane {
            display: none;
        }

        .tab-pane.active {
            display: block;
        }

        /* Modal Overlay */
        .wp-modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.7);
            z-index: 999999;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .wp-modal-overlay.active {
            display: flex;
        }

        .wp-modal-box {
            background: #ffffff;
            border: 1px solid var(--wp-border);
            border-radius: 4px;
            width: 100%;
            max-width: 580px;
            box-shadow: 0 5px 15px rgba(0,0,0,.5);
        }

        .wp-modal-header {
            padding: 14px 18px;
            border-bottom: 1px solid var(--wp-border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #f6f7f7;
        }

        .wp-modal-title {
            font-size: 14px;
            font-weight: 700;
            color: #1d2327;
        }

        .wp-modal-body {
            padding: 18px;
        }

        .wp-modal-footer {
            padding: 12px 18px;
            border-top: 1px solid var(--wp-border);
            background: #f6f7f7;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 10px;
        }

        .cred-item {
            background: #f0f0f1;
            border: 1px solid var(--wp-border-subtle);
            padding: 10px 14px;
            border-radius: 3px;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .cred-item-info span {
            display: block;
        }

        .cred-label {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            color: #646970;
        }

        .cred-value {
            font-family: 'JetBrains Mono', monospace;
            font-size: 12px;
            color: #2271b1;
            font-weight: 600;
            word-break: break-all;
        }

        /* Toast notification */
        .wp-toast {
            position: fixed;
            bottom: 24px;
            right: 24px;
            background: #1d2327;
            color: #ffffff;
            padding: 10px 18px;
            border-radius: 3px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            font-size: 13px;
            display: flex;
            align-items: center;
            gap: 8px;
            z-index: 1000000;
            opacity: 0;
            transform: translateY(10px);
            transition: all 0.2s ease;
            pointer-events: none;
        }

        .wp-toast.show {
            opacity: 1;
            transform: translateY(0);
            pointer-events: auto;
        }

        /* Package Mapping Table */
        .mapping-table th, .mapping-table td {
            padding: 10px 14px;
        }
    </style>
</head>
<body>

<!-- WordPress Top Admin Bar -->
<div id="wpadminbar">
    <div class="wp-bar-left">
        <a href="{{ route('secret.reseller.index') }}" class="wp-logo">
            <i class="ph-fill ph-television-simple"></i>
            <span>Live IPTV Admin</span>
        </a>
        <a href="{{ route('home') }}" target="_blank" class="wp-bar-link">
            <i class="ph-bold ph-house"></i>
            <span>Visit Site</span>
        </a>
        <span class="wp-secret-tag"><i class="ph-fill ph-lock-key"></i> Reseller Secret Hub</span>
    </div>

    <div class="wp-bar-right">
        <span style="color: #a7aaad;">Howdy, <strong>{{ $settings['username'] ?: 'Reseller' }}</strong></span>
        <button class="button button-small" onclick="switchTab('settings')" style="background: transparent; color: #c3c4c7; border-color: #50575e;">
            <i class="ph-bold ph-gear"></i> XUI API Config
        </button>
    </div>
</div>

<!-- Main Wrapper -->
<div class="wp-wrap">
    <!-- WordPress Left Sidebar Menu -->
    <div id="adminmenu">
        <div class="menu-item active" id="menu-orders" onclick="switchTab('orders')">
            <i class="ph-bold ph-shopping-cart"></i>
            <span>Orders Feed</span>
            <span class="menu-badge">{{ $totalOrders }}</span>
        </div>
        <div class="menu-item" id="menu-mapping" onclick="switchTab('mapping')">
            <i class="ph-bold ph-plugs"></i>
            <span>Package Mapping</span>
        </div>
        <div class="menu-item" id="menu-settings" onclick="switchTab('settings')">
            <i class="ph-bold ph-sliders"></i>
            <span>XUI API Settings</span>
        </div>
        <div class="menu-item" id="menu-generator" onclick="switchTab('generator')">
            <i class="ph-bold ph-magic-wand"></i>
            <span>Instant Line</span>
        </div>
    </div>

    <!-- WordPress Body Content Area -->
    <div id="wpbody">
        <!-- Top Flash Notices -->
        @if(session('success'))
            <div class="notice notice-success">
                <i class="ph-fill ph-check-circle" style="color: #00a32a; font-size: 18px;"></i>
                <div><strong>Success:</strong> {{ session('success') }}</div>
            </div>
        @endif

        @if(session('error'))
            <div class="notice notice-error">
                <i class="ph-fill ph-warning-circle" style="color: #d63638; font-size: 18px;"></i>
                <div><strong>Notice:</strong> {{ session('error') }}</div>
            </div>
        @endif

        <!-- TAB 1: ORDERS FEED -->
        <div class="tab-pane active" id="pane-orders">
            <div class="wp-page-header">
                <div>
                    <h1 class="wp-heading-inline">IPTV Orders & Line Fulfillment</h1>
                    <a href="{{ route('secret.reseller.index') }}" class="page-title-action">
                        <i class="ph-bold ph-arrows-clockwise"></i> Refresh Feed
                    </a>
                </div>

                <div>
                    <form method="GET" action="{{ route('secret.reseller.index') }}" style="display: flex; gap: 6px;">
                        <input type="hidden" name="status" value="{{ $statusFilter }}">
                        <input type="text" name="search" value="{{ $searchQuery }}" placeholder="Search customer, email, order..." class="regular-text" style="width: 260px;">
                        <button type="submit" class="button"><i class="ph-bold ph-magnifying-glass"></i> Search</button>
                    </form>
                </div>
            </div>

            <!-- Stats Bar -->
            <div class="wp-stats-row">
                <div class="wp-stat-box">
                    <div class="wp-stat-title">Total Orders</div>
                    <div class="wp-stat-number">{{ number_format($totalOrders) }}</div>
                </div>
                <div class="wp-stat-box">
                    <div class="wp-stat-title">Pending Lines</div>
                    <div class="wp-stat-number" style="color: #d63638;">{{ number_format($pendingOrders) }}</div>
                </div>
                <div class="wp-stat-box">
                    <div class="wp-stat-title">Delivered & Active</div>
                    <div class="wp-stat-number" style="color: #00a32a;">{{ number_format($completedOrders) }}</div>
                </div>
                <div class="wp-stat-box">
                    <div class="wp-stat-title">Total Revenue</div>
                    <div class="wp-stat-number">${{ number_format($totalRevenue, 2) }}</div>
                </div>
            </div>

            <!-- Subsubsub Filter Tabs -->
            <ul class="subsubsub">
                <li>
                    <a href="{{ route('secret.reseller.index', ['status' => 'all', 'search' => $searchQuery]) }}" class="{{ $statusFilter === 'all' ? 'current' : '' }}">
                        All <span class="count">({{ $totalOrders }})</span>
                    </a> |
                </li>
                <li>
                    <a href="{{ route('secret.reseller.index', ['status' => 'pending', 'search' => $searchQuery]) }}" class="{{ $statusFilter === 'pending' ? 'current' : '' }}">
                        Pending Fulfillment <span class="count">({{ $pendingOrders }})</span>
                    </a> |
                </li>
                <li>
                    <a href="{{ route('secret.reseller.index', ['status' => 'completed', 'search' => $searchQuery]) }}" class="{{ $statusFilter === 'completed' ? 'current' : '' }}">
                        Delivered <span class="count">({{ $completedOrders }})</span>
                    </a> |
                </li>
                <li>
                    <a href="{{ route('secret.reseller.index', ['status' => 'unpaid', 'search' => $searchQuery]) }}" class="{{ $statusFilter === 'unpaid' ? 'current' : '' }}">
                        Unpaid
                    </a>
                </li>
            </ul>

            <!-- Orders Table -->
            <table class="wp-list-table widefat fixed striped">
                <thead>
                    <tr>
                        <th style="width: 140px;">Order # & Date</th>
                        <th style="width: 200px;">Customer Info</th>
                        <th style="width: 170px;">Website Package</th>
                        <th style="width: 130px;">Payment Status</th>
                        <th style="width: 180px;">XUI Line Status</th>
                        <th style="width: 150px;">Customer Email</th>
                        <th style="text-align: right;">Fulfillment Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                        @php
                            $creds = $order->subscription_details;
                            $hasLine = !empty($creds) && !empty($creds['username']);
                            $isEmailed = !empty($order->email_sent_at);
                            $pkg = $order->package;
                            $mappedXuiPkg = $pkg && isset($packageMap[$pkg->id]) ? $packageMap[$pkg->id] : ($settings['default_package_id'] ?? 1);
                        @endphp
                        <tr>
                            <td>
                                <strong>#{{ $order->order_number }}</strong>
                                <div style="color: var(--wp-text-muted); font-size: 11px;">
                                    {{ $order->created_at->format('Y/m/d \a\t g:i A') }}
                                </div>
                            </td>
                            <td>
                                <strong>{{ $order->customer_name ?: 'Customer' }}</strong>
                                <div style="color: var(--wp-text-muted); font-size: 11px; font-family: monospace;">
                                    {{ $order->customer_email }}
                                </div>
                                @if($order->customer_phone)
                                    <div style="color: #646970; font-size: 11px;">{{ $order->customer_phone }}</div>
                                @endif
                            </td>
                            <td>
                                <strong style="color: #1d2327;">{{ $pkg ? $pkg->name : 'Custom Plan' }}</strong>
                                <div style="color: var(--wp-text-muted); font-size: 11px;">
                                    {{ $pkg ? $pkg->duration_label : '1 Month' }} &bull; {{ $pkg ? $pkg->devices : 1 }} Device(s)
                                </div>
                                <div style="font-size: 10px; color: #2271b1; margin-top: 2px;">
                                    XUI Package ID: <strong>#{{ $mappedXuiPkg }}</strong>
                                </div>
                            </td>
                            <td>
                                <strong>${{ number_format($order->amount, 2) }}</strong>
                                <div>
                                    <span class="order-status {{ $order->payment_status === 'completed' ? 'status-completed' : 'status-pending' }}">
                                        {{ $order->payment_status }}
                                    </span>
                                </div>
                            </td>
                            <td>
                                @if($hasLine)
                                    <span class="order-status status-completed">
                                        <i class="ph-bold ph-check"></i> Line Created
                                    </span>
                                    <div style="font-family: monospace; font-size: 11px; color: #2271b1; margin-top: 3px;">
                                        User: <strong>{{ $creds['username'] }}</strong>
                                    </div>
                                @else
                                    <span class="order-status status-pending">
                                        <i class="ph-bold ph-hourglass"></i> Needs Generation
                                    </span>
                                @endif
                            </td>
                            <td>
                                @if($isEmailed)
                                    <span style="color: #00a32a; font-weight: 600; font-size: 11px; display: flex; align-items: center; gap: 4px;">
                                        <i class="ph-fill ph-check-circle"></i> Emailed
                                    </span>
                                    <div style="font-size: 10px; color: #646970;">
                                        {{ $order->email_sent_at->diffForHumans() }}
                                    </div>
                                @else
                                    <span style="color: #d63638; font-weight: 600; font-size: 11px; display: flex; align-items: center; gap: 4px;">
                                        <i class="ph-fill ph-warning-circle"></i> Not Sent
                                    </span>
                                @endif
                            </td>
                            <td style="text-align: right;">
                                <div style="display: flex; gap: 6px; justify-content: flex-end; align-items: center; flex-wrap: wrap;">
                                    @if(!$hasLine)
                                        <!-- 1-Click Generate Line on XUI button -->
                                        <form method="POST" action="{{ route('secret.reseller.generate', $order) }}" style="display: inline;" onsubmit="this.querySelector('button').innerText = 'Generating on XUI...';">
                                            @csrf
                                            <input type="hidden" name="package_id" value="{{ $mappedXuiPkg }}">
                                            <button type="submit" class="button button-primary button-small" title="Generate this exact package on XUI panel">
                                                <i class="ph-bold ph-lightning"></i>
                                                <span>Generate on XUI</span>
                                            </button>
                                        </form>
                                    @else
                                        <!-- Send / Resend to Customer Email Button -->
                                        <form method="POST" action="{{ route('secret.reseller.send-email', $order) }}" style="display: inline;">
                                            @csrf
                                            <button type="submit" class="button button-success button-small" title="Send credentials email directly to customer">
                                                <i class="ph-bold ph-paper-plane-tilt"></i>
                                                <span>{{ $isEmailed ? 'Resend Email' : 'Send to Customer' }}</span>
                                            </button>
                                        </form>

                                        <!-- View Credentials Modal Button -->
                                        <button type="button" class="button button-small" onclick="openViewModal({{ json_encode($order) }}, {{ json_encode($creds) }})">
                                            <i class="ph-bold ph-key"></i>
                                            <span>View Details</span>
                                        </button>
                                    @endif

                                    <!-- Manual Line Assignment -->
                                    <button type="button" class="button button-small" title="Manual Line Override" onclick="openManualModal({{ json_encode($order) }}, {{ json_encode($creds) }})">
                                        <i class="ph-bold ph-pencil"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align: center; padding: 30px; color: #646970;">
                                No orders found in this view.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            @if($orders->hasPages())
                <div style="margin-top: 14px; display: flex; justify-content: space-between; align-items: center;">
                    <span style="color: #646970; font-size: 12px;">
                        Showing {{ $orders->firstItem() }} to {{ $orders->lastItem() }} of {{ $orders->total() }} items
                    </span>
                    <div>{{ $orders->links() }}</div>
                </div>
            @endif
        </div>

        <!-- TAB 2: WEBSITE PACKAGE -> XUI PACKAGE MAPPING -->
        <div class="tab-pane" id="pane-mapping">
            <div class="wp-page-header">
                <div>
                    <h1 class="wp-heading-inline">Website Package &rarr; XUI Package ID Mapping</h1>
                </div>
            </div>

            <div class="postbox">
                <div class="postbox-header">
                    <h2 class="postbox-title"><i class="ph-bold ph-plugs"></i> Auto-Generate Package Matcher</h2>
                </div>
                <div class="inside">
                    <p style="color: #646970; margin-bottom: 16px;">
                        When a customer purchases a package on your website, the system automatically uses the mapped <strong>XUI Package ID</strong> below to create the exact plan on your XUI server.
                    </p>

                    <form method="POST" action="{{ route('secret.reseller.package-mapping') }}">
                        @csrf
                        <table class="wp-list-table widefat striped mapping-table">
                            <thead>
                                <tr>
                                    <th style="width: 250px;">Website Package Name</th>
                                    <th style="width: 140px;">Duration</th>
                                    <th style="width: 120px;">Devices</th>
                                    <th style="width: 100px;">Price</th>
                                    <th>Corresponding XUI.ONE Package ID</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($packages as $pkg)
                                    @php
                                        $currentXuiId = $packageMap[$pkg->id] ?? ($settings['default_package_id'] ?? 1);
                                    @endphp
                                    <tr>
                                        <td>
                                            <strong>{{ $pkg->name }}</strong>
                                            <div style="font-size: 11px; color: #646970;">Slug: {{ $pkg->slug }}</div>
                                        </td>
                                        <td>{{ $pkg->duration_label }}</td>
                                        <td>{{ $pkg->devices }} Connection(s)</td>
                                        <td><strong>${{ number_format($pkg->price, 2) }}</strong></td>
                                        <td>
                                            <input type="number" 
                                                   name="package_map[{{ $pkg->id }}]" 
                                                   value="{{ $currentXuiId }}" 
                                                   class="regular-text" 
                                                   style="width: 120px;" 
                                                   min="1" 
                                                   placeholder="e.g. 1">
                                            <span style="font-size: 11px; color: #646970; margin-left: 6px;">
                                                (XUI Package ID in your panel)
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div style="margin-top: 18px;">
                            <button type="submit" class="button button-primary">
                                <i class="ph-bold ph-floppy-disk"></i>
                                <span>Save Package Mappings</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- TAB 3: XUI API SETTINGS -->
        <div class="tab-pane" id="pane-settings">
            <div class="wp-page-header">
                <div>
                    <h1 class="wp-heading-inline">XUI.ONE Server & API Configuration</h1>
                </div>
            </div>

            <div class="postbox">
                <div class="postbox-header">
                    <h2 class="postbox-title"><i class="ph-bold ph-sliders"></i> XUI API Credentials & Connection</h2>
                </div>
                <div class="inside">
                    <form method="POST" action="{{ route('secret.reseller.settings.update') }}">
                        @csrf
                        
                        <table class="form-table">
                            <tbody>
                                <tr>
                                    <th><label for="cfg_api_key">XUI.ONE API Key</label></th>
                                    <td>
                                        <input type="text" name="api_key" id="cfg_api_key" value="{{ $settings['api_key'] }}" class="regular-text" placeholder="Paste your API key from XUI Edit Profile">
                                        <p class="description">Your reseller API key from your XUI.ONE profile (keeps everything automated without manual logins).</p>
                                    </td>
                                </tr>

                                <tr>
                                    <th><label for="cfg_api_url">XUI.ONE API URL</label></th>
                                    <td>
                                        <input type="text" name="api_url" id="cfg_api_url" value="{{ $settings['api_url'] }}" class="regular-text" placeholder="http://your-server:80/path/">
                                        <p class="description">The dedicated API URL displayed in your XUI.ONE Edit Profile tooltip.</p>
                                    </td>
                                </tr>

                                <tr>
                                    <th><label for="cfg_panel_url">Panel URL (Web Fallback)</label></th>
                                    <td>
                                        <input type="text" name="panel_url" id="cfg_panel_url" value="{{ $settings['panel_url'] }}" class="regular-text" placeholder="http://your-server/secret-path">
                                        <p class="description">Your primary reseller panel web address.</p>
                                    </td>
                                </tr>

                                <tr>
                                    <th><label for="cfg_username">Reseller Username</label></th>
                                    <td>
                                        <input type="text" name="username" id="cfg_username" value="{{ $settings['username'] }}" class="regular-text" placeholder="Your reseller account username">
                                    </td>
                                </tr>

                                <tr>
                                    <th><label for="cfg_password">Reseller Password</label></th>
                                    <td>
                                        <input type="password" name="password" id="cfg_password" class="regular-text" placeholder="{{ !empty($settings['password']) ? '•••••••••••• (Saved)' : 'Optional if API Key is set' }}">
                                        <p class="description">Only required if using session web login instead of API Key.</p>
                                    </td>
                                </tr>

                                <tr>
                                    <th><label for="cfg_dns">Default Client Portal DNS</label></th>
                                    <td>
                                        <input type="text" name="portal_dns" id="cfg_dns" value="{{ $settings['portal_dns'] }}" class="regular-text" placeholder="http://your-iptv-portal.com:8080">
                                        <p class="description">The streaming server address sent to the customer for Xtream Codes and M3U playlists.</p>
                                    </td>
                                </tr>

                                <tr>
                                    <th><label for="cfg_prefix">Username Prefix</label></th>
                                    <td>
                                        <input type="text" name="user_prefix" id="cfg_prefix" value="{{ $settings['user_prefix'] ?? 'user' }}" class="regular-text" style="width: 160px;">
                                        <p class="description">Prefix for generated IPTV accounts (e.g. <code>bestuser</code> &rarr; <code>bestuser3254</code>).</p>
                                    </td>
                                </tr>

                                <tr>
                                    <th><label for="cfg_default_pkg">Fallback Package ID</label></th>
                                    <td>
                                        <input type="text" name="default_package_id" id="cfg_default_pkg" value="{{ $settings['default_package_id'] ?? '1' }}" class="regular-text" style="width: 100px;">
                                        <p class="description">Default XUI package ID if no package mapping matches.</p>
                                    </td>
                                </tr>

                                <tr>
                                    <th>Automatic Delivery</th>
                                    <td>
                                        <label>
                                            <input type="checkbox" name="auto_fulfill" value="1" {{ $settings['auto_fulfill'] ? 'checked' : '' }}>
                                            <span>Instantly create line on XUI & email customer as soon as payment is confirmed on website.</span>
                                        </label>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <div style="margin-top: 20px; display: flex; gap: 10px; align-items: center;">
                            <button type="submit" class="button button-primary">
                                <i class="ph-bold ph-floppy-disk"></i>
                                <span>Save XUI Settings</span>
                            </button>

                            <button type="button" class="button" onclick="testPanelConnection()">
                                <i class="ph-bold ph-broadcast"></i>
                                <span>Test Live API Connection</span>
                            </button>
                        </div>

                        <div id="testConnectionBox" style="display: none; margin-top: 16px; padding: 12px; background: #fafafa; border: 1px solid var(--wp-border); font-family: monospace; font-size: 12px;"></div>
                    </form>
                </div>
            </div>
        </div>

        <!-- TAB 4: INSTANT SCRATCHPAD GENERATOR -->
        <div class="tab-pane" id="pane-generator">
            <div class="wp-page-header">
                <div>
                    <h1 class="wp-heading-inline">Instant IPTV Line Builder</h1>
                </div>
            </div>

            <div class="postbox" style="max-width: 700px;">
                <div class="postbox-header">
                    <h2 class="postbox-title"><i class="ph-bold ph-magic-wand"></i> Quick Line Scratchpad</h2>
                </div>
                <div class="inside">
                    <table class="form-table">
                        <tbody>
                            <tr>
                                <th>Username</th>
                                <td><input type="text" id="quick_user" class="regular-text" placeholder="Auto-generated if blank"></td>
                            </tr>
                            <tr>
                                <th>Password</th>
                                <td><input type="text" id="quick_pass" class="regular-text" placeholder="Auto-generated if blank"></td>
                            </tr>
                            <tr>
                                <th>Portal DNS</th>
                                <td><input type="text" id="quick_dns" class="regular-text" value="{{ $settings['portal_dns'] }}"></td>
                            </tr>
                        </tbody>
                    </table>

                    <div style="margin-top: 14px;">
                        <button type="button" class="button button-primary" onclick="generateQuickLine()">
                            <i class="ph-bold ph-lightning"></i>
                            <span>Generate Instant Credentials</span>
                        </button>
                    </div>

                    <div id="quickResultBox" style="display: none; margin-top: 18px; padding-top: 14px; border-top: 1px solid var(--wp-border);">
                        <h4 style="margin-bottom: 10px;">Generated Details:</h4>
                        <div class="cred-item">
                            <div class="cred-item-info">
                                <span class="cred-label">Portal URL</span>
                                <span class="cred-value" id="res_portal"></span>
                            </div>
                            <button class="button button-small" onclick="copyText(document.getElementById('res_portal').innerText)">Copy</button>
                        </div>
                        <div class="cred-item">
                            <div class="cred-item-info">
                                <span class="cred-label">Username</span>
                                <span class="cred-value" id="res_user"></span>
                            </div>
                            <button class="button button-small" onclick="copyText(document.getElementById('res_user').innerText)">Copy</button>
                        </div>
                        <div class="cred-item">
                            <div class="cred-item-info">
                                <span class="cred-label">Password</span>
                                <span class="cred-value" id="res_pass"></span>
                            </div>
                            <button class="button button-small" onclick="copyText(document.getElementById('res_pass').innerText)">Copy</button>
                        </div>
                        <div class="cred-item">
                            <div class="cred-item-info">
                                <span class="cred-label">M3U Playlist Link</span>
                                <span class="cred-value" id="res_m3u"></span>
                            </div>
                            <button class="button button-small" onclick="copyText(document.getElementById('res_m3u').innerText)">Copy</button>
                        </div>
                        <button type="button" class="button button-success" style="width: 100%; margin-top: 8px;" onclick="copyAllQuick()">
                            <i class="ph-bold ph-copy"></i>
                            <span>Copy Complete Customer Message</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODAL: VIEW & COPY CREDENTIALS -->
<div class="wp-modal-overlay" id="viewModal">
    <div class="wp-modal-box">
        <div class="wp-modal-header">
            <h3 class="wp-modal-title"><i class="ph-bold ph-key"></i> Customer IPTV Credentials</h3>
            <button type="button" class="button button-small" onclick="closeModal('viewModal')">&times;</button>
        </div>
        <div class="wp-modal-body">
            <div style="color: #646970; font-size: 12px; margin-bottom: 14px;" id="vm_order_info"></div>

            <div class="cred-item">
                <div class="cred-item-info">
                    <span class="cred-label">Portal URL / Server DNS</span>
                    <span class="cred-value" id="vm_portal"></span>
                </div>
                <button class="button button-small" onclick="copyText(document.getElementById('vm_portal').innerText)">Copy</button>
            </div>

            <div class="cred-item">
                <div class="cred-item-info">
                    <span class="cred-label">Username</span>
                    <span class="cred-value" id="vm_user"></span>
                </div>
                <button class="button button-small" onclick="copyText(document.getElementById('vm_user').innerText)">Copy</button>
            </div>

            <div class="cred-item">
                <div class="cred-item-info">
                    <span class="cred-label">Password</span>
                    <span class="cred-value" id="vm_pass"></span>
                </div>
                <button class="button button-small" onclick="copyText(document.getElementById('vm_pass').innerText)">Copy</button>
            </div>

            <div class="cred-item">
                <div class="cred-item-info">
                    <span class="cred-label">M3U Playlist Link</span>
                    <span class="cred-value" id="vm_m3u"></span>
                </div>
                <button class="button button-small" onclick="copyText(document.getElementById('vm_m3u').innerText)">Copy</button>
            </div>
        </div>
        <div class="wp-modal-footer">
            <button type="button" class="button button-primary" onclick="copyAllModal()">
                <i class="ph-bold ph-copy"></i> Copy Full Access Text
            </button>
            <button type="button" class="button" onclick="closeModal('viewModal')">Close</button>
        </div>
    </div>
</div>

<!-- MODAL: MANUAL EDIT -->
<div class="wp-modal-overlay" id="manualModal">
    <div class="wp-modal-box">
        <div class="wp-modal-header">
            <h3 class="wp-modal-title"><i class="ph-bold ph-pencil"></i> Manual Line Override</h3>
            <button type="button" class="button button-small" onclick="closeModal('manualModal')">&times;</button>
        </div>
        <form id="manualForm" method="POST" action="">
            @csrf
            <div class="wp-modal-body">
                <div style="font-size: 12px; color: #646970; margin-bottom: 12px;" id="mm_order_info"></div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 10px;">
                    <div>
                        <label style="display: block; font-weight: 600; font-size: 12px; margin-bottom: 4px;">Username *</label>
                        <input type="text" name="username" id="mm_user" class="regular-text" required>
                    </div>
                    <div>
                        <label style="display: block; font-weight: 600; font-size: 12px; margin-bottom: 4px;">Password *</label>
                        <input type="text" name="password" id="mm_pass" class="regular-text" required>
                    </div>
                </div>

                <div style="margin-bottom: 10px;">
                    <label style="display: block; font-weight: 600; font-size: 12px; margin-bottom: 4px;">Portal DNS</label>
                    <input type="text" name="portal_url" id="mm_portal" class="regular-text" value="{{ $settings['portal_dns'] }}">
                </div>

                <div style="margin-bottom: 10px;">
                    <label style="display: block; font-weight: 600; font-size: 12px; margin-bottom: 4px;">Duration (Days)</label>
                    <input type="number" name="duration_days" id="mm_days" class="regular-text" value="30">
                </div>

                <div style="margin-top: 10px;">
                    <label>
                        <input type="checkbox" name="send_email" value="1">
                        <span>Send delivery email to customer immediately</span>
                    </label>
                </div>
            </div>
            <div class="wp-modal-footer">
                <button type="submit" class="button button-primary">Save Line</button>
                <button type="button" class="button" onclick="closeModal('manualModal')">Cancel</button>
            </div>
        </form>
    </div>
</div>

<!-- Toast Notification Box -->
<div class="wp-toast" id="toastBox">
    <i class="ph-bold ph-check-circle" style="color: #00a32a;"></i>
    <span id="toastText">Copied to clipboard!</span>
</div>

<script>
    // Tab switching
    function switchTab(tabId) {
        document.querySelectorAll('.menu-item').forEach(b => b.classList.remove('active'));
        document.querySelectorAll('.tab-pane').forEach(p => p.classList.remove('active'));

        const menu = document.getElementById('menu-' + tabId);
        const pane = document.getElementById('pane-' + tabId);
        if (menu && pane) {
            menu.classList.add('active');
            pane.classList.add('active');
        }
    }

    // Modals
    function openModal(id) {
        document.getElementById(id).classList.add('active');
    }

    function closeModal(id) {
        document.getElementById(id).classList.remove('active');
    }

    let currentModalCreds = null;
    let currentModalOrder = null;

    function openViewModal(order, creds) {
        currentModalOrder = order;
        currentModalCreds = creds || {};

        document.getElementById('vm_order_info').innerHTML = `Order <strong>#${order.order_number}</strong> &#8212; ${order.customer_name} (${order.customer_email})`;
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

    function openManualModal(order, creds) {
        const form = document.getElementById('manualForm');
        form.action = `/secret-reseller-hub-8829/manual-deliver/${order.id}`;

        document.getElementById('mm_order_info').innerHTML = `Order <strong>#${order.order_number}</strong> for <strong>${order.customer_name}</strong> (${order.customer_email})`;
        const userPrefix = '{{ $settings['user_prefix'] ?? 'user' }}';
        document.getElementById('mm_user').value = creds && creds.username ? creds.username : (userPrefix + Math.floor(1000 + Math.random() * 9000));
        document.getElementById('mm_pass').value = creds && creds.password ? creds.password : Math.random().toString(36).slice(-8);
        document.getElementById('mm_portal').value = creds && creds.portal_url ? creds.portal_url : '{{ $settings['portal_dns'] }}';
        document.getElementById('mm_days').value = creds && creds.duration_days ? creds.duration_days : (order.package && order.package.duration_days ? order.package.duration_days : 30);

        openModal('manualModal');
    }

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

    function testPanelConnection() {
        const apiKey = document.getElementById('cfg_api_key') ? document.getElementById('cfg_api_key').value : '';
        const apiUrl = document.getElementById('cfg_api_url') ? document.getElementById('cfg_api_url').value : '';
        const url = document.getElementById('cfg_panel_url').value;
        const user = document.getElementById('cfg_username').value;
        const pass = document.getElementById('cfg_password').value;
        const box = document.getElementById('testConnectionBox');

        box.style.display = 'block';
        box.innerHTML = `<span style="color: #2271b1;"><i class="ph-bold ph-spinner ph-spin"></i> Connecting to XUI API server...</span>`;

        fetch('{{ route('secret.reseller.test-connection') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                api_key: apiKey,
                api_url: apiUrl,
                panel_url: url,
                username: user,
                password: pass
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                box.innerHTML = `<span style="color: #00a32a; font-weight: 700;"><i class="ph-bold ph-check-circle"></i> ${data.message}</span>`;
                if (data.data) {
                    box.innerHTML += `<div style="margin-top: 6px; color: #646970; font-size: 11px;">Details: ${JSON.stringify(data.data)}</div>`;
                }
            } else {
                box.innerHTML = `<span style="color: #d63638; font-weight: 700;"><i class="ph-bold ph-x-circle"></i> ${data.message}</span>`;
            }
        })
        .catch(err => {
            box.innerHTML = `<span style="color: #d63638; font-weight: 700;"><i class="ph-bold ph-x-circle"></i> Request error: ${err.message}</span>`;
        });
    }

    function generateQuickLine() {
        const userPrefix = '{{ $settings['user_prefix'] ?? 'user' }}';
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
