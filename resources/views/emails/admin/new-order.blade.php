<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Order Notification</title>
</head>
<body style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; background-color: #f5f5f5; margin: 0; padding: 20px;">
    <table width="100%" cellpadding="0" cellspacing="0" style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
        <!-- Header -->
        <tr>
            <td style="background: linear-gradient(135deg, #6366f1, #4f46e5); padding: 30px; text-align: center;">
                <h1 style="color: #ffffff; margin: 0; font-size: 24px;">🎉 New Order Received!</h1>
            </td>
        </tr>
        
        <!-- Content -->
        <tr>
            <td style="padding: 30px;">
                <p style="color: #374151; font-size: 16px; line-height: 1.6; margin: 0 0 20px;">
                    A new order has been placed on Best Live IPTV.
                </p>
                
                <!-- Order Details -->
                <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f9fafb; border-radius: 8px; padding: 20px; margin-bottom: 20px;">
                    <tr>
                        <td style="padding: 15px;">
                            <h3 style="color: #111827; margin: 0 0 15px; font-size: 18px;">Order Details</h3>
                            
                            <table width="100%" cellpadding="5" cellspacing="0">
                                <tr>
                                    <td style="color: #6b7280; font-size: 14px;">Order Number:</td>
                                    <td style="color: #111827; font-weight: 600; font-size: 14px;">{{ $order->order_number }}</td>
                                </tr>
                                <tr>
                                    <td style="color: #6b7280; font-size: 14px;">Package:</td>
                                    <td style="color: #111827; font-weight: 600; font-size: 14px;">{{ $order->package->name ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td style="color: #6b7280; font-size: 14px;">Amount:</td>
                                    <td style="color: #10b981; font-weight: 700; font-size: 16px;">${{ number_format($order->amount, 2) }}</td>
                                </tr>
                                <tr>
                                    <td style="color: #6b7280; font-size: 14px;">Payment Method:</td>
                                    <td style="color: #111827; font-size: 14px;">{{ ucfirst($order->payment_method) }}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                
                <!-- Customer Info -->
                <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f9fafb; border-radius: 8px; padding: 20px; margin-bottom: 20px;">
                    <tr>
                        <td style="padding: 15px;">
                            <h3 style="color: #111827; margin: 0 0 15px; font-size: 18px;">Customer Information</h3>
                            
                            <table width="100%" cellpadding="5" cellspacing="0">
                                <tr>
                                    <td style="color: #6b7280; font-size: 14px;">Name:</td>
                                    <td style="color: #111827; font-size: 14px;">{{ $order->customer_name }}</td>
                                </tr>
                                <tr>
                                    <td style="color: #6b7280; font-size: 14px;">Email:</td>
                                    <td style="color: #111827; font-size: 14px;">{{ $order->customer_email }}</td>
                                </tr>
                                @if($order->customer_phone)
                                <tr>
                                    <td style="color: #6b7280; font-size: 14px;">Phone:</td>
                                    <td style="color: #111827; font-size: 14px;">{{ $order->customer_phone }}</td>
                                </tr>
                                @endif
                            </table>
                        </td>
                    </tr>
                </table>
                
                @if($order->notes)
                <div style="background-color: #fef3c7; border-radius: 8px; padding: 15px; margin-bottom: 20px;">
                    <h4 style="color: #92400e; margin: 0 0 5px; font-size: 14px;">Customer Notes:</h4>
                    <p style="color: #78350f; margin: 0; font-size: 14px;">{{ $order->notes }}</p>
                </div>
                @endif
                
                <!-- Action Button -->
                <table width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                        <td style="text-align: center; padding-top: 10px;">
                            <a href="{{ route('admin.orders.show', $order) }}" style="display: inline-block; background: linear-gradient(135deg, #6366f1, #4f46e5); color: #ffffff; text-decoration: none; padding: 12px 30px; border-radius: 6px; font-weight: 600; font-size: 14px;">
                                View Order in Admin
                            </a>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        
        <!-- Footer -->
        <tr>
            <td style="background-color: #f9fafb; padding: 20px; text-align: center; border-top: 1px solid #e5e7eb;">
                <p style="color: #6b7280; font-size: 12px; margin: 0;">
                    Best Live IPTV - Admin Notification<br>
                    {{ now()->format('M d, Y H:i') }}
                </p>
            </td>
        </tr>
    </table>
</body>
</html>
