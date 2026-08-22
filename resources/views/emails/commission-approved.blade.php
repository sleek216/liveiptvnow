<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Commission Approved</title>
    <style>
        body { margin: 0; padding: 0; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Arial, sans-serif; background: #f3f4f6; }
        .email-container { max-width: 600px; margin: 40px auto; background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .header { background: linear-gradient(135deg, #ff4d1c 0%, #e63e10 100%); padding: 36px 30px; text-align: center; color: #fff; }
        .header h1 { margin: 0; font-size: 26px; }
        .content { padding: 36px 30px; color: #374151; line-height: 1.6; }
        .box { background: #f9fafb; border-radius: 10px; padding: 20px; margin: 24px 0; }
        .row { display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #e5e7eb; }
        .row:last-child { border-bottom: none; font-weight: 700; color: #111827; }
        .amount { font-size: 32px; font-weight: 800; color: #10b981; margin: 16px 0; }
        .btn { display: inline-block; background: #ff4d1c; color: #fff !important; text-decoration: none; padding: 14px 28px; border-radius: 8px; font-weight: 700; margin-top: 16px; }
        .footer { padding: 20px 30px; background: #f9fafb; text-align: center; font-size: 13px; color: #6b7280; }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1>Commission Approved!</h1>
            <p>Your referral earnings are now available</p>
        </div>
        <div class="content">
            <p>Hi {{ $affiliate->user->name ?? 'Partner' }},</p>
            <p>Great news! An admin has approved your referral commission. Here are the details:</p>

            <div class="amount">${{ number_format($commission->commission_amount, 2) }}</div>

            <div class="box">
                <div class="row"><span>Order Amount</span><span>${{ number_format($commission->order_amount, 2) }}</span></div>
                <div class="row"><span>Commission Rate</span><span>{{ $commission->commission_rate }}%</span></div>
                @if($buyer)
                <div class="row"><span>Referred Customer</span><span>{{ $buyer->name }}</span></div>
                @endif
                @if($commission->order?->package)
                <div class="row"><span>Package</span><span>{{ $commission->order->package->name }}</span></div>
                @endif
                <div class="row"><span>Status</span><span style="color:#10b981;">Approved</span></div>
            </div>

            <p>This amount has been moved to your approved balance. You can request a payout once you reach the minimum threshold.</p>

            <a href="{{ route('affiliate.commissions') }}" class="btn">View My Commissions</a>
        </div>
        <div class="footer">
            Live IPTV Now Affiliate Program
        </div>
    </div>
</body>
</html>
