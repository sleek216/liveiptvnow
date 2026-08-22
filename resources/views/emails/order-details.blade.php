<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $emailData['subject'] }}</title>
</head>
<body style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; background-color: #f5f5f5; margin: 0; padding: 20px;">
    <table width="100%" cellpadding="0" cellspacing="0" style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
        <!-- Header -->
        <tr>
            <td style="background: linear-gradient(135deg, #6366f1, #4f46e5); padding: 30px; text-align: center;">
                <h1 style="color: #ffffff; margin: 0; font-size: 24px;">📺 Best Live IPTV</h1>
            </td>
        </tr>
        
        <!-- Content -->
        <tr>
            <td style="padding: 30px;">
                <p style="color: #374151; font-size: 16px; line-height: 1.6; margin: 0 0 20px;">
                    Dear {{ $order->customer_name }},
                </p>
                
                <div style="color: #374151; font-size: 16px; line-height: 1.8; margin-bottom: 25px;">
                    {!! nl2br(e($emailMessage)) !!}
                </div>
                
                <!-- Order Summary -->
                <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f9fafb; border-radius: 8px; margin-bottom: 25px;">
                    <tr>
                        <td style="padding: 20px;">
                            <h3 style="color: #111827; margin: 0 0 15px; font-size: 18px;">Order Summary</h3>
                            
                            <table width="100%" cellpadding="8" cellspacing="0">
                                <tr>
                                    <td style="color: #6b7280; font-size: 14px; border-bottom: 1px solid #e5e7eb;">Order Number:</td>
                                    <td style="color: #111827; font-weight: 600; font-size: 14px; border-bottom: 1px solid #e5e7eb;">{{ $order->order_number }}</td>
                                </tr>
                                <tr>
                                    <td style="color: #6b7280; font-size: 14px; border-bottom: 1px solid #e5e7eb;">Package:</td>
                                    <td style="color: #111827; font-weight: 600; font-size: 14px; border-bottom: 1px solid #e5e7eb;">{{ $order->package->name }}</td>
                                </tr>
                                <tr>
                                    <td style="color: #6b7280; font-size: 14px; border-bottom: 1px solid #e5e7eb;">Duration:</td>
                                    <td style="color: #111827; font-size: 14px; border-bottom: 1px solid #e5e7eb;">{{ $order->package->duration_label }}</td>
                                </tr>
                                <tr>
                                    <td style="color: #6b7280; font-size: 14px;">Amount Paid:</td>
                                    <td style="color: #10b981; font-weight: 700; font-size: 18px;">${{ number_format($order->amount, 2) }}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                
                @if($includeCredentials && ($username || $password || $m3uUrl))
                <!-- IPTV Credentials -->
                <table width="100%" cellpadding="0" cellspacing="0" style="background: linear-gradient(135deg, #10b981, #059669); border-radius: 8px; margin-bottom: 25px;">
                    <tr>
                        <td style="padding: 25px;">
                            <h3 style="color: #ffffff; margin: 0 0 15px; font-size: 18px;">🔐 Your IPTV Credentials</h3>
                            
                            <table width="100%" cellpadding="8" cellspacing="0">
                                @if($username)
                                <tr>
                                    <td style="color: rgba(255,255,255,0.8); font-size: 14px;">Username:</td>
                                    <td style="color: #ffffff; font-weight: 700; font-size: 16px; font-family: monospace;">{{ $username }}</td>
                                </tr>
                                @endif
                                @if($password)
                                <tr>
                                    <td style="color: rgba(255,255,255,0.8); font-size: 14px;">Password:</td>
                                    <td style="color: #ffffff; font-weight: 700; font-size: 16px; font-family: monospace;">{{ $password }}</td>
                                </tr>
                                @endif
                                @if($m3uUrl)
                                <tr>
                                    <td colspan="2" style="padding-top: 10px;">
                                        <div style="color: rgba(255,255,255,0.8); font-size: 14px; margin-bottom: 5px;">M3U URL:</div>
                                        <div style="background: rgba(0,0,0,0.2); padding: 10px; border-radius: 4px; word-break: break-all;">
                                            <code style="color: #ffffff; font-size: 12px;">{{ $m3uUrl }}</code>
                                        </div>
                                    </td>
                                </tr>
                                @endif
                                @if($portalUrl)
                                <tr>
                                    <td colspan="2" style="padding-top: 10px;">
                                        <div style="color: rgba(255,255,255,0.8); font-size: 14px; margin-bottom: 5px;">Portal URL:</div>
                                        <div style="background: rgba(0,0,0,0.2); padding: 10px; border-radius: 4px; word-break: break-all;">
                                            <code style="color: #ffffff; font-size: 12px;">{{ $portalUrl }}</code>
                                        </div>
                                    </td>
                                </tr>
                                @endif
                            </table>
                        </td>
                    </tr>
                </table>
                
                <div style="background-color: #fef3c7; border-radius: 8px; padding: 15px; margin-bottom: 25px;">
                    <p style="color: #92400e; margin: 0; font-size: 14px;">
                        <strong>⚠️ Important:</strong> Keep your credentials safe and do not share them with others. Your subscription is for personal use only.
                    </p>
                </div>
                @endif
                
                <p style="color: #374151; font-size: 16px; line-height: 1.6; margin-bottom: 20px;">
                    If you have any questions or need assistance, please don't hesitate to contact our support team.
                </p>
                
                <p style="color: #374151; font-size: 16px; line-height: 1.6; margin: 0;">
                    Thank you for choosing Best Live IPTV!<br>
                    <strong>The Best Live IPTV Team</strong>
                </p>
            </td>
        </tr>
        
        <!-- Footer -->
        <tr>
            <td style="background-color: #f9fafb; padding: 20px; text-align: center; border-top: 1px solid #e5e7eb;">
                <p style="color: #6b7280; font-size: 12px; margin: 0;">
                    © {{ date('Y') }} Best Live IPTV. All rights reserved.<br>
                    <a href="{{ route('terms') }}" style="color: #6366f1;">Terms of Service</a> | 
                    <a href="{{ route('privacy') }}" style="color: #6366f1;">Privacy Policy</a> |
                    <a href="{{ route('contact') }}" style="color: #6366f1;">Contact Support</a>
                </p>
            </td>
        </tr>
    </table>
</body>
</html>
