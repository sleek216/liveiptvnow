<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Received</title>
    <style>
        body { margin: 0; padding: 0; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Arial, sans-serif; background: #f3f4f6; }
        .email-container { max-width: 600px; margin: 40px auto; background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .header { background: linear-gradient(135deg, #10b981 0%, #059669 100%); padding: 36px 30px; text-align: center; color: #fff; }
        .header h1 { margin: 0; font-size: 26px; }
        .content { padding: 36px 30px; color: #374151; line-height: 1.6; }
        .amount { font-size: 32px; font-weight: 800; color: #10b981; margin: 16px 0; }
        .box { background: #f9fafb; border-radius: 10px; padding: 20px; margin: 24px 0; }
        .row { display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #e5e7eb; }
        .row:last-child { border-bottom: none; }
        .btn { display: inline-block; background: #ff4d1c; color: #fff !important; text-decoration: none; padding: 14px 28px; border-radius: 8px; font-weight: 700; margin-top: 16px; }
        .footer { padding: 20px 30px; background: #f9fafb; text-align: center; font-size: 13px; color: #6b7280; }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1>Payment Sent!</h1>
            <p>Your affiliate payout has been processed</p>
        </div>
        <div class="content">
            <p>Hi {{ $affiliate->user->name ?? 'Partner' }},</p>
            <p>We have sent you a payment for your affiliate earnings:</p>

            <div class="amount">${{ number_format($payout->amount, 2) }}</div>

            <div class="box">
                <div class="row"><span>Payment Method</span><span>{{ ucfirst(str_replace('_', ' ', $payout->payment_method)) }}</span></div>
                <div class="row"><span>Date</span><span>{{ $payout->processed_at?->format('M d, Y h:i A') ?? now()->format('M d, Y') }}</span></div>
                @if($payout->admin_notes)
                <div class="row"><span>Note</span><span>{{ $payout->admin_notes }}</span></div>
                @endif
                <div class="row"><span>Remaining Balance</span><span>${{ number_format($affiliate->fresh()->available_balance, 2) }}</span></div>
            </div>

            <a href="{{ route('affiliate.payouts') }}" class="btn">View Payout History</a>
        </div>
        <div class="footer">Live IPTV Now Affiliate Program</div>
    </div>
</body>
</html>
