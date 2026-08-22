<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Affiliates table - stores affiliate program data for each user
        Schema::create('affiliates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('referral_code')->unique();
            $table->decimal('total_earnings', 10, 2)->default(0);
            $table->decimal('pending_earnings', 10, 2)->default(0);
            $table->decimal('paid_earnings', 10, 2)->default(0);
            $table->integer('total_referrals')->default(0);
            $table->integer('total_sales')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Referrals table - tracks who referred whom
        Schema::create('referrals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('affiliate_id')->constrained()->onDelete('cascade');
            $table->foreignId('referred_user_id')->constrained('users')->onDelete('cascade');
            $table->string('referral_code');
            $table->ipAddress('ip_address')->nullable();
            $table->timestamp('converted_at')->nullable(); // When they made first purchase
            $table->timestamps();
        });

        // Commissions table - tracks earnings from each sale
        Schema::create('commissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('affiliate_id')->constrained()->onDelete('cascade');
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('referral_id')->constrained()->onDelete('cascade');
            $table->decimal('order_amount', 10, 2);
            $table->decimal('commission_rate', 5, 2); // Percentage
            $table->decimal('commission_amount', 10, 2);
            $table->enum('status', ['pending', 'approved', 'paid', 'rejected'])->default('pending');
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->text('admin_notes')->nullable();
            $table->timestamps();
        });

        // Payouts table - withdrawal requests
        Schema::create('payouts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('affiliate_id')->constrained()->onDelete('cascade');
            $table->decimal('amount', 10, 2);
            $table->enum('payment_method', ['paypal', 'bank_transfer', 'crypto', 'other']);
            $table->text('payment_details'); // JSON with payment info
            $table->enum('status', ['pending', 'processing', 'completed', 'rejected'])->default('pending');
            $table->timestamp('processed_at')->nullable();
            $table->text('admin_notes')->nullable();
            $table->timestamps();
        });

        // Add referral tracking to users table
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('referred_by')->nullable()->constrained('users')->onDelete('set null');
            $table->string('referral_code')->nullable()->unique();
        });

        // Add affiliate settings
        DB::table('settings')->insert([
            [
                'key' => 'affiliate_enabled',
                'value' => '1',
                'type' => 'boolean',
                'group' => 'affiliate',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'affiliate_commission_rate',
                'value' => '20',
                'type' => 'number',
                'group' => 'affiliate',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'affiliate_minimum_payout',
                'value' => '50',
                'type' => 'number',
                'group' => 'affiliate',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'affiliate_cookie_duration',
                'value' => '30',
                'type' => 'number',
                'group' => 'affiliate',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['referred_by']);
            $table->dropColumn(['referred_by', 'referral_code']);
        });
        
        Schema::dropIfExists('payouts');
        Schema::dropIfExists('commissions');
        Schema::dropIfExists('referrals');
        Schema::dropIfExists('affiliates');
        
        DB::table('settings')->where('group', 'affiliate')->delete();
    }
};
