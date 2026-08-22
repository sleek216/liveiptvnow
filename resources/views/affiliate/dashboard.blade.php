@extends('layouts.app')

@section('title', 'Affiliate Dashboard - Live IPTV Now')

@section('content')
<div style="min-height: 100vh; background: #f8fafc; padding: 80px 20px 40px;">
    <div style="max-width: 1200px; margin: 0 auto;">
        
        <!-- Header -->
        <div style="text-align: center; margin-bottom: 40px;">
            <h1 style="font-size: 2.5rem; font-weight: 700; color: #0f172a; margin-bottom: 10px;">
                💰 Affiliate Dashboard
            </h1>
            <p style="font-size: 1.1rem; color: #64748b;">
                Earn 20% commission on every referral sale!
            </p>
        </div>

        <!-- Stats Grid -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 40px;">
            
            <!-- Total Earnings -->
            <div style="background: #fff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 24px; box-shadow: 0 1px 3px rgba(15,23,42,0.03);">
                <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px;">
                    <i class="ri-money-dollar-circle-fill" style="font-size: 2rem; color: #10b981;"></i>
                    <h3 style="font-size: 0.875rem; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em; margin: 0;">Total Earnings</h3>
                </div>
                <p style="font-size: 2rem; font-weight: 700; color: #0f172a; margin: 0;">${{ number_format($affiliate->total_earnings, 2) }}</p>
            </div>

            <!-- Pending -->
            <div style="background: #fff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 24px; box-shadow: 0 1px 3px rgba(15,23,42,0.03);">
                <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px;">
                    <i class="ri-time-fill" style="font-size: 2rem; color: #f59e0b;"></i>
                    <h3 style="font-size: 0.875rem; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em; margin: 0;">Pending</h3>
                </div>
                <p style="font-size: 2rem; font-weight: 700; color: #0f172a; margin: 0;">${{ number_format($affiliate->pending_earnings, 2) }}</p>
            </div>

            <!-- Available -->
            <div style="background: #fff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 24px; box-shadow: 0 1px 3px rgba(15,23,42,0.03);">
                <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px;">
                    <i class="ri-checkbox-circle-fill" style="font-size: 2rem; color: #0066ff;"></i>
                    <h3 style="font-size: 0.875rem; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em; margin: 0;">Available</h3>
                </div>
                <p style="font-size: 2rem; font-weight: 700; color: #0f172a; margin: 0;">${{ number_format($affiliate->available_balance, 2) }}</p>
            </div>

            <!-- Referrals -->
            <div style="background: #fff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 24px; box-shadow: 0 1px 3px rgba(15,23,42,0.03);">
                <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px;">
                    <i class="ri-group-fill" style="font-size: 2rem; color: #8b5cf6;"></i>
                    <h3 style="font-size: 0.875rem; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em; margin: 0;">Total Referrals</h3>
                </div>
                <p style="font-size: 2rem; font-weight: 700; color: #0f172a; margin: 0;">{{ $affiliate->total_referrals }}</p>
            </div>

        </div>

        <!-- Referral Link Box -->
        <div style="background: linear-gradient(135deg, #0f172a, #1e3a5f); border-radius: 16px; padding: 32px; margin-bottom: 40px; box-shadow: 0 10px 40px rgba(15,23,42,0.15);">
            <h2 style="font-size: 1.5rem; font-weight: 700; color: #fff; margin-bottom: 16px; display: flex; align-items: center; gap: 12px;">
                <i class="ri-link-fill"></i>
                Your Referral Link
            </h2>
            <p style="color: rgba(255,255,255,0.9); margin-bottom: 20px;">
                Share this link with your friends and earn 20% commission on every sale!
            </p>
            <div style="display: flex; gap: 12px; flex-wrap: wrap;">
                <input 
                    type="text" 
                    id="referralLink" 
                    value="{{ auth()->user()->referral_link }}" 
                    readonly
                    style="flex: 1; min-width: 300px; padding: 14px 18px; background: rgba(255,255,255,0.15); border: 1px solid rgba(255,255,255,0.3); border-radius: 8px; color: #fff; font-family: monospace; font-size: 0.95rem;"
                >
                <button 
                    onclick="copyReferralLink()" 
                    style="padding: 14px 28px; background: #fff; color: #0066ff; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.3s; display: flex; align-items: center; gap: 8px;"
                    onmouseover="this.style.transform='scale(1.05)'" 
                    onmouseout="this.style.transform='scale(1)'"
                >
                    <i class="ri-file-copy-line"></i>
                    Copy Link
                </button>
            </div>
        </div>

        <!-- Quick Actions -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; margin-bottom: 40px;">
            
            <a href="{{ route('affiliate.referrals') }}" style="background: #fff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 24px; text-decoration: none; transition: all 0.3s; display: block; box-shadow: 0 1px 3px rgba(15,23,42,0.03);"
               onmouseover="this.style.background='#eff6ff'; this.style.borderColor='#bfdbfe'" 
               onmouseout="this.style.background='#fff'; this.style.borderColor='#e2e8f0'">
                <i class="ri-group-fill" style="font-size: 2.5rem; color: #8b5cf6; margin-bottom: 12px; display: block;"></i>
                <h3 style="font-size: 1.125rem; font-weight: 600; color: #0f172a; margin-bottom: 8px;">View Referrals</h3>
                <p style="color: #64748b; margin: 0; font-size: 0.875rem;">See all users you've referred</p>
            </a>

            <a href="{{ route('affiliate.commissions') }}" style="background: #fff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 24px; text-decoration: none; transition: all 0.3s; display: block; box-shadow: 0 1px 3px rgba(15,23,42,0.03);"
               onmouseover="this.style.background='#eff6ff'; this.style.borderColor='#bfdbfe'" 
               onmouseout="this.style.background='#fff'; this.style.borderColor='#e2e8f0'">
                <i class="ri-money-dollar-circle-fill" style="font-size: 2.5rem; color: #10b981; margin-bottom: 12px; display: block;"></i>
                <h3 style="font-size: 1.125rem; font-weight: 600; color: #0f172a; margin-bottom: 8px;">Commissions</h3>
                <p style="color: #64748b; margin: 0; font-size: 0.875rem;">Track your earnings history</p>
            </a>

            <a href="{{ route('affiliate.payouts') }}" style="background: #fff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 24px; text-decoration: none; transition: all 0.3s; display: block; box-shadow: 0 1px 3px rgba(15,23,42,0.03);"
               onmouseover="this.style.background='#eff6ff'; this.style.borderColor='#bfdbfe'" 
               onmouseout="this.style.background='#fff'; this.style.borderColor='#e2e8f0'">
                <i class="ri-wallet-fill" style="font-size: 2.5rem; color: #0066ff; margin-bottom: 12px; display: block;"></i>
                <h3 style="font-size: 1.125rem; font-weight: 600; color: #0f172a; margin-bottom: 8px;">Payouts</h3>
                <p style="color: #64748b; margin: 0; font-size: 0.875rem;">Request withdrawal</p>
            </a>

        </div>

        <!-- Recent Activity -->
        @if($stats['recent_commissions']->count() > 0)
        <div style="background: #fff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 24px; box-shadow: 0 1px 3px rgba(15,23,42,0.03);">
            <h2 style="font-size: 1.25rem; font-weight: 600; color: #0f172a; margin-bottom: 20px;">Recent Commissions</h2>
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="border-bottom: 1px solid #e2e8f0;">
                            <th style="padding: 12px; text-align: left; color: #64748b; font-size: 0.875rem; font-weight: 500;">Date</th>
                            <th style="padding: 12px; text-align: left; color: #64748b; font-size: 0.875rem; font-weight: 500;">Order</th>
                            <th style="padding: 12px; text-align: left; color: #64748b; font-size: 0.875rem; font-weight: 500;">Amount</th>
                            <th style="padding: 12px; text-align: left; color: #64748b; font-size: 0.875rem; font-weight: 500;">Commission</th>
                            <th style="padding: 12px; text-align: left; color: #64748b; font-size: 0.875rem; font-weight: 500;">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($stats['recent_commissions'] as $commission)
                        <tr style="border-bottom: 1px solid #f1f5f9;">
                            <td style="padding: 12px; color: #334155; font-size: 0.875rem;">{{ $commission->created_at->format('M d, Y') }}</td>
                            <td style="padding: 12px; color: #334155; font-size: 0.875rem;">#{{ $commission->order->order_number }}</td>
                            <td style="padding: 12px; color: #334155; font-size: 0.875rem;">${{ number_format($commission->order_amount, 2) }}</td>
                            <td style="padding: 12px; color: #10b981; font-weight: 600; font-size: 0.875rem;">${{ number_format($commission->commission_amount, 2) }}</td>
                            <td style="padding: 12px;">
                                @if($commission->status === 'pending')
                                    <span style="padding: 4px 12px; background: #fef3c7; color: #92400e; border-radius: 6px; font-size: 0.75rem; font-weight: 500;">Pending</span>
                                @elseif($commission->status === 'approved')
                                    <span style="padding: 4px 12px; background: #d1fae5; color: #065f46; border-radius: 6px; font-size: 0.75rem; font-weight: 500;">Approved</span>
                                @elseif($commission->status === 'paid')
                                    <span style="padding: 4px 12px; background: #dbeafe; color: #1e40af; border-radius: 6px; font-size: 0.75rem; font-weight: 500;">Paid</span>
                                @else
                                    <span style="padding: 4px 12px; background: #fee2e2; color: #991b1b; border-radius: 6px; font-size: 0.75rem; font-weight: 500;">Rejected</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif

    </div>
</div>

<script>
function copyReferralLink() {
    const input = document.getElementById('referralLink');
    input.select();
    document.execCommand('copy');
    
    const button = event.target.closest('button');
    const originalHTML = button.innerHTML;
    button.innerHTML = '<i class="ri-check-fill"></i> Copied!';
    button.style.background = '#10b981';
    button.style.color = '#fff';
    
    setTimeout(() => {
        button.innerHTML = originalHTML;
        button.style.background = '#fff';
        button.style.color = '#0066ff';
    }, 2000);
}
</script>
@endsection
