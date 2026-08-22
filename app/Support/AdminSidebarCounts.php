<?php

namespace App\Support;

use App\Models\Commission;
use App\Models\Contact;
use App\Models\Order;
use App\Models\Payout;
use App\Models\Referral;
use App\Models\User;
use Illuminate\Support\Facades\Schema;

class AdminSidebarCounts
{
    public static function get(): array
    {
        $counts = [
            'orders' => 0,
            'users' => 0,
            'contacts' => 0,
            'commissions' => 0,
            'payouts' => 0,
            'referrals' => 0,
            'affiliate_total' => 0,
        ];

        try {
            if (Schema::hasTable('orders')) {
                $counts['orders'] = Order::where('is_read', false)->count();
            }

            if (Schema::hasTable('users')) {
                $counts['users'] = User::where('is_admin', false)
                    ->where('created_at', '>=', now()->subDays(7))
                    ->count();
            }

            if (Schema::hasTable('contacts')) {
                $counts['contacts'] = Contact::where('status', 'new')->count();
            }

            if (Schema::hasTable('commissions')) {
                $counts['commissions'] = Commission::whereIn('status', ['pending', 'partially_paid'])->count();
            }

            if (Schema::hasTable('payouts')) {
                $counts['payouts'] = Payout::whereIn('status', ['pending', 'processing'])->count();
            }

            if (Schema::hasTable('referrals')) {
                $counts['referrals'] = Referral::where('created_at', '>=', now()->subDays(7))->count();
            }

            $counts['affiliate_total'] = $counts['commissions'] + $counts['payouts'] + $counts['referrals'];
        } catch (\Throwable $e) {
            // Silently fail during migrations/setup
        }

        return $counts;
    }
}
