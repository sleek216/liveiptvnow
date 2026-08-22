<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your IPTV Subscription is Active!</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background-color: #f3f4f6;
        }
        .email-container {
            max-width: 600px;
            margin: 40px auto;
            background: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .header {
            background: linear-gradient(135deg, #0066ff 0%, #0052cc 100%);
            padding: 40px 30px;
            text-align: center;
            color: #ffffff;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 700;
        }
        .header p {
            margin: 10px 0 0;
            font-size: 16px;
            opacity: 0.9;
        }
        .content {
            padding: 40px 30px;
        }
        .order-info {
            background: #f9fafb;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 30px;
        }
        .order-info h2 {
            margin: 0 0 15px;
            font-size: 18px;
            color: #111827;
        }
        .order-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #e5e7eb;
        }
        .order-row:last-child {
            border-bottom: none;
            font-weight: 600;
            font-size: 18px;
            padding-top: 15px;
            margin-top: 10px;
            border-top: 2px solid #e5e7eb;
        }
        .credentials-box {
            background: linear-gradient(135deg, #0a0f1a 0%, #1a2332 100%);
            border-radius: 8px;
            padding: 25px;
            margin: 30px 0;
            color: #ffffff;
        }
        .credentials-box h2 {
            margin: 0 0 20px;
            font-size: 20px;
            color: #ffffff;
        }
        .credential-item {
            margin-bottom: 20px;
        }
        .credential-item:last-child {
            margin-bottom: 0;
        }
        .credential-label {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: rgba(255, 255, 255, 0.6);
            margin-bottom: 8px;
        }
        .credential-value {
            background: rgba(255, 255, 255, 0.1);
            padding: 12px 15px;
            border-radius: 6px;
            font-family: 'Courier New', monospace;
            font-size: 15px;
            word-break: break-all;
        }
        .setup-steps {
            margin: 30px 0;
        }
        .setup-steps h2 {
            font-size: 20px;
            color: #111827;
            margin: 0 0 20px;
        }
        .step {
            display: flex;
            margin-bottom: 20px;
        }
        .step-number {
            width: 32px;
            height: 32px;
            background: linear-gradient(135deg, #0066ff 0%, #0052cc 100%);
            color: #ffffff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 14px;
            flex-shrink: 0;
            margin-right: 15px;
        }
        .step-content h3 {
            margin: 0 0 5px;
            font-size: 16px;
            color: #111827;
        }
        .step-content p {
            margin: 0;
            font-size: 14px;
            color: #6b7280;
            line-height: 1.5;
        }
        .support-box {
            background: #fef3c7;
            border: 1px solid #fbbf24;
            border-radius: 8px;
            padding: 20px;
            margin: 30px 0;
            text-align: center;
        }
        .support-box p {
            margin: 0 0 10px;
            color: #92400e;
            font-size: 14px;
        }
        .support-box a {
            color: #0066ff;
            text-decoration: none;
            font-weight: 600;
        }
        .footer {
            background: #f9fafb;
            padding: 30px;
            text-align: center;
            color: #6b7280;
            font-size: 14px;
        }
        .footer p {
            margin: 5px 0;
        }
        .footer a {
            color: #0066ff;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="header">
            <h1>🎉 Welcome to Live IPTV Now!</h1>
            <p>Your subscription is now active</p>
        </div>

        <!-- Content -->
        <div class="content">
            <p style="font-size: 16px; color: #374151; margin: 0 0 20px;">
                Hi <strong>{{ $order->customer_name }}</strong>,
            </p>
            <p style="font-size: 16px; color: #374151; line-height: 1.6; margin: 0 0 30px;">
                Thank you for choosing Live IPTV Now! Your payment has been successfully processed, and your IPTV subscription is now active. Below you'll find everything you need to get started.
            </p>

            <!-- Order Information -->
            <div class="order-info">
                <h2>📋 Order Details</h2>
                <div class="order-row">
                    <span>Order Number:</span>
                    <strong>{{ $order->order_number }}</strong>
                </div>
                <div class="order-row">
                    <span>Package:</span>
                    <strong>{{ $order->package->name }}</strong>
                </div>
                <div class="order-row">
                    <span>Duration:</span>
                    <strong>{{ $order->package->duration_label }}</strong>
                </div>
                <div class="order-row">
                    <span>Connections:</span>
                    <strong>{{ $order->package->devices }} Device(s)</strong>
                </div>
                <div class="order-row">
                    <span>Total Paid:</span>
                    <strong>${{ number_format($order->amount, 2) }}</strong>
                </div>
            </div>

            <!-- Credentials -->
            <div class="credentials-box">
                <h2>🔑 Your IPTV Credentials</h2>
                
                <div class="credential-item">
                    <div class="credential-label">Portal URL</div>
                    <div class="credential-value">http://Live IPTV Now.com:8080</div>
                </div>

                <div class="credential-item">
                    <div class="credential-label">Username</div>
                    <div class="credential-value">{{ $credentials['username'] }}</div>
                </div>

                <div class="credential-item">
                    <div class="credential-label">Password</div>
                    <div class="credential-value">{{ $credentials['password'] }}</div>
                </div>

                <div class="credential-item">
                    <div class="credential-label">M3U Playlist URL</div>
                    <div class="credential-value">{{ $credentials['m3u_url'] }}</div>
                </div>
            </div>

            <!-- Setup Steps -->
            <div class="setup-steps">
                <h2>🚀 Quick Setup Guide</h2>
                
                <div class="step">
                    <div class="step-number">1</div>
                    <div class="step-content">
                        <h3>Download an IPTV App</h3>
                        <p>Install an IPTV player on your device. We recommend: IPTV Smarters Pro, TiviMate, or Perfect Player.</p>
                    </div>
                </div>

                <div class="step">
                    <div class="step-number">2</div>
                    <div class="step-content">
                        <h3>Enter Your Credentials</h3>
                        <p>Open the app and enter the Portal URL, Username, and Password provided above.</p>
                    </div>
                </div>

                <div class="step">
                    <div class="step-number">3</div>
                    <div class="step-content">
                        <h3>Start Watching</h3>
                        <p>That's it! Enjoy thousands of live channels and VOD content in HD and 4K quality.</p>
                    </div>
                </div>
            </div>

            <!-- Support Box -->
            <div class="support-box">
                <p><strong>Need Help?</strong></p>
                <p>Our 24/7 support team is here to assist you with setup or any questions.</p>
                <a href="{{ route('contact') }}">Contact Support →</a>
            </div>

            <p style="font-size: 14px; color: #6b7280; margin: 30px 0 0;">
                <strong>Important:</strong> Please save this email for future reference. Keep your credentials secure and do not share them with others.
            </p>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p><strong>Live IPTV Now</strong></p>
            <p>Premium IPTV Service</p>
            <p style="margin-top: 15px;">
                <a href="{{ route('home') }}">Visit Website</a> | 
                <a href="{{ route('contact') }}">Contact Support</a> | 
                <a href="{{ route('faq') }}">FAQ</a>
            </p>
            <p style="margin-top: 15px; font-size: 12px;">
                © {{ date('Y') }} Live IPTV Now. All rights reserved.
            </p>
        </div>
    </div>
</body>
</html>
