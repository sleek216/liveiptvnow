<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow, noarchive, nosnippet">
    <title>Secure Portal Authentication — Live IPTV Now</title>
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css">

    <style>
        *, *::before, *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
            background: #090d16;
            color: #f1f5f9;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            position: relative;
            overflow-x: hidden;
        }

        /* Ambient Glow Background */
        .ambient-bg {
            position: fixed;
            inset: 0;
            pointer-events: none;
            overflow: hidden;
            z-index: 0;
        }

        .glow-1 {
            position: absolute;
            top: 15%;
            left: 20%;
            width: 450px;
            height: 450px;
            background: radial-gradient(circle, rgba(99, 102, 241, 0.15) 0%, rgba(99, 102, 241, 0) 70%);
            border-radius: 50%;
            filter: blur(40px);
        }

        .glow-2 {
            position: absolute;
            bottom: 15%;
            right: 20%;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(14, 165, 233, 0.12) 0%, rgba(14, 165, 233, 0) 70%);
            border-radius: 50%;
            filter: blur(40px);
        }

        .grid-pattern {
            position: absolute;
            inset: 0;
            background-image: 
                linear-gradient(rgba(255, 255, 255, 0.02) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, 0.02) 1px, transparent 1px);
            background-size: 40px 40px;
            mask-image: radial-gradient(ellipse at center, rgba(0, 0, 0, 0.8) 0%, rgba(0, 0, 0, 0) 75%);
        }

        /* Login Card */
        .portal-card {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 440px;
            background: rgba(15, 23, 42, 0.75);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 24px;
            padding: 40px 36px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5), 0 0 0 1px rgba(255, 255, 255, 0.04);
            animation: fadeIn 0.4s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(12px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Header Badge */
        .badge-secure {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            background: rgba(99, 102, 241, 0.1);
            border: 1px solid rgba(99, 102, 241, 0.25);
            border-radius: 9999px;
            font-size: 11.5px;
            font-weight: 700;
            color: #818cf8;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            margin-bottom: 20px;
        }

        .badge-secure .status-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #22c55e;
            box-shadow: 0 0 8px #22c55e;
        }

        .portal-header {
            text-align: center;
            margin-bottom: 28px;
        }

        .portal-logo {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 56px;
            height: 56px;
            background: linear-gradient(135deg, #4f46e5, #06b6d4);
            border-radius: 16px;
            color: #ffffff;
            font-size: 26px;
            margin-bottom: 16px;
            box-shadow: 0 10px 20px -5px rgba(79, 70, 229, 0.4);
        }

        .portal-header h1 {
            font-size: 22px;
            font-weight: 700;
            color: #ffffff;
            letter-spacing: -0.02em;
            margin-bottom: 6px;
        }

        .portal-header p {
            font-size: 13.5px;
            color: #94a3b8;
            font-weight: 400;
        }

        /* Alerts */
        .portal-alert {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 12px 16px;
            border-radius: 12px;
            font-size: 13px;
            margin-bottom: 20px;
            line-height: 1.45;
        }

        .portal-alert-error {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.25);
            color: #fca5a5;
        }

        .portal-alert-success {
            background: rgba(34, 197, 94, 0.1);
            border: 1px solid rgba(34, 197, 94, 0.25);
            color: #86efac;
        }

        .portal-alert i {
            font-size: 17px;
            flex-shrink: 0;
            margin-top: 1px;
        }

        /* Form */
        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-size: 12.5px;
            font-weight: 600;
            color: #cbd5e1;
            margin-bottom: 8px;
            letter-spacing: 0.02em;
        }

        .input-wrap {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-wrap i.input-icon {
            position: absolute;
            left: 14px;
            font-size: 17px;
            color: #64748b;
            pointer-events: none;
            transition: color 0.2s;
        }

        .input-control {
            width: 100%;
            padding: 12px 14px 12px 42px;
            background: rgba(15, 23, 42, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            font-size: 14px;
            color: #ffffff;
            font-family: inherit;
            outline: none;
            transition: all 0.2s ease;
        }

        .input-control:focus {
            background: rgba(15, 23, 42, 0.9);
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2);
        }

        .input-control:focus + i.input-icon,
        .input-wrap:focus-within i.input-icon {
            color: #818cf8;
        }

        .btn-toggle-pwd {
            position: absolute;
            right: 12px;
            background: none;
            border: none;
            color: #64748b;
            cursor: pointer;
            padding: 4px;
            font-size: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: color 0.2s;
        }

        .btn-toggle-pwd:hover {
            color: #cbd5e1;
        }

        .form-extras {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
        }

        .remember-label {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            color: #94a3b8;
            cursor: pointer;
            user-select: none;
        }

        .remember-label input[type="checkbox"] {
            accent-color: #6366f1;
            width: 15px;
            height: 15px;
            border-radius: 4px;
            cursor: pointer;
        }

        /* Submit Button */
        .btn-submit {
            width: 100%;
            padding: 13px 20px;
            background: linear-gradient(135deg, #4f46e5, #4338ca);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 12px;
            color: #ffffff;
            font-size: 14.5px;
            font-weight: 600;
            font-family: inherit;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.2s ease;
            box-shadow: 0 4px 14px rgba(79, 70, 229, 0.35);
        }

        .btn-submit:hover {
            background: linear-gradient(135deg, #5b52f3, #4f46e5);
            box-shadow: 0 6px 20px rgba(79, 70, 229, 0.45);
            transform: translateY(-1px);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        /* Footer Info */
        .portal-footer {
            margin-top: 28px;
            padding-top: 18px;
            border-top: 1px solid rgba(255, 255, 255, 0.06);
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 11.5px;
            color: #64748b;
        }

        .portal-footer .security-tag {
            display: flex;
            align-items: center;
            gap: 5px;
        }
    </style>
</head>
<body>

    <div class="ambient-bg">
        <div class="grid-pattern"></div>
        <div class="glow-1"></div>
        <div class="glow-2"></div>
    </div>

    <div class="portal-card">
        <div class="portal-header">
            <div class="badge-secure">
                <span class="status-dot"></span>
                <span>Restricted Access</span>
            </div>
            <div>
                <div class="portal-logo">
                    <i class="ri-shield-keyhole-line"></i>
                </div>
            </div>
            <h1>Management Portal</h1>
            <p>Authorized Administrator Authentication Only</p>
        </div>

        @if($errors->any())
        <div class="portal-alert portal-alert-error">
            <i class="ri-error-warning-fill"></i>
            <div>
                @foreach($errors->all() as $e)
                    <div>{{ $e }}</div>
                @endforeach
            </div>
        </div>
        @endif

        @if(session('error'))
        <div class="portal-alert portal-alert-error">
            <i class="ri-error-warning-fill"></i>
            <div>{{ session('error') }}</div>
        </div>
        @endif

        @if(session('success'))
        <div class="portal-alert portal-alert-success">
            <i class="ri-checkbox-circle-fill"></i>
            <div>{{ session('success') }}</div>
        </div>
        @endif

        <form action="{{ route('admin.login.submit') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="email" class="form-label">Administrator Email</label>
                <div class="input-wrap">
                    <input type="email" id="email" name="email" class="input-control" value="{{ old('email') }}" placeholder="admin@example.com" required autofocus autocomplete="username">
                    <i class="ri-user-settings-line input-icon"></i>
                </div>
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Security Key / Password</label>
                <div class="input-wrap">
                    <input type="password" id="password" name="password" class="input-control" placeholder="••••••••••••" required autocomplete="current-password">
                    <i class="ri-lock-2-line input-icon"></i>
                    <button type="button" class="btn-toggle-pwd" onclick="togglePassword()">
                        <i class="ri-eye-off-line" id="toggleEyeIcon"></i>
                    </button>
                </div>
            </div>

            <div class="form-extras">
                <label class="remember-label">
                    <input type="checkbox" name="remember">
                    <span>Keep session active</span>
                </label>
            </div>

            <button type="submit" class="btn-submit">
                <i class="ri-login-circle-line"></i>
                <span>Authenticate & Enter</span>
            </button>
        </form>

        <div class="portal-footer">
            <div class="security-tag">
                <i class="ri-shield-check-line"></i>
                <span>SSL Encrypted</span>
            </div>
            <div>
                <span>IP Logged & Monitored</span>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const pwd = document.getElementById('password');
            const icon = document.getElementById('toggleEyeIcon');
            if (pwd.type === 'password') {
                pwd.type = 'text';
                icon.className = 'ri-eye-line';
            } else {
                pwd.type = 'password';
                icon.className = 'ri-eye-off-line';
            }
        }
    </script>
</body>
</html>
