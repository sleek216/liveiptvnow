<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Free Trial Request Received!</title>
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
        }
        .info-box {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            border: 1px solid #f59e0b;
            border-radius: 8px;
            padding: 25px;
            margin: 30px 0;
            text-align: center;
        }
        .info-box h2 {
            margin: 0 0 15px;
            font-size: 20px;
            color: #92400e;
        }
        .info-box p {
            margin: 0;
            color: #78350f;
            font-size: 15px;
            line-height: 1.6;
        }
        .steps-box {
            background: #f0f9ff;
            border: 1px solid #0284c7;
            border-radius: 8px;
            padding: 25px;
            margin: 30px 0;
        }
        .steps-box h2 {
            margin: 0 0 15px;
            font-size: 18px;
            color: #0c4a6e;
        }
        .steps-box ol {
            margin: 0;
            padding-left: 20px;
            color: #0369a1;
        }
        .steps-box li {
            margin-bottom: 10px;
            line-height: 1.5;
        }
        .support-box {
            background: #f3e8ff;
            border: 1px solid #9333ea;
            border-radius: 8px;
            padding: 20px;
            margin: 30px 0;
            text-align: center;
        }
        .support-box p {
            margin: 0 0 10px;
            color: #6b21a8;
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
            <h1>🎉 Free Trial Request Received!</h1>
            <p>Thank you for trying Live IPTV Now</p>
        </div>

        <!-- Content -->
        <div class="content">
            <p style="font-size: 16px; color: #374151; margin: 0 0 20px;">
                Hi <strong>{{ $order->customer_name }}</strong>,
            </p>
            <p style="font-size: 16px; color: #374151; line-height: 1.6; margin: 0 0 30px;">
                Thank you for choosing Live IPTV Now! We have received your free trial request and our team is processing it.
            </p>

            <!-- Order Information -->
            <div class="order-info">
                <h2>📋 Request Details</h2>
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
                    <span>Status:</span>
                    <strong style="color: #f59e0b;">Processing</strong>
                </div>
            </div>

            <!-- Info Box -->
            <div class="info-box">
                <h2>⏳ What Happens Next?</h2>
                <p>
                    Our team will review your free trial request and set up your account. 
                    <strong>You will receive your IPTV credentials shortly via a separate email from our team.</strong>
                </p>
            </div>

            <!-- Steps Box -->
            <div class="steps-box">
                <h2>📱 Get Ready!</h2>
                <ol>
                    <li>Download an IPTV app on your device (IPTV Smarters Pro, TiviMate, or Perfect Player recommended)</li>
                    <li>Wait for your credentials email from our support team</li>
                    <li>Enter the provided credentials in your IPTV app</li>
                    <li>Enjoy thousands of live channels and VOD content!</li>
                </ol>
            </div>

            <!-- Support Box -->
            <div class="support-box">
                <p><strong>Need Help?</strong></p>
                <p>Our 24/7 support team is here to assist you with any questions.</p>
                <a href="{{ route('contact') }}">Contact Support →</a>
            </div>

            <p style="font-size: 14px; color: #6b7280; margin: 30px 0 0;">
                <strong>Note:</strong> Free trial credentials are typically sent within 1-2 hours during business hours. Please check your inbox and spam folder.
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
