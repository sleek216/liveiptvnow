<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('stripe_payment_id')->nullable()->after('payment_method');
            $table->string('stripe_session_id')->nullable()->after('stripe_payment_id');
            $table->json('selected_countries')->nullable()->after('subscription_details');
            $table->timestamp('email_sent_at')->nullable()->after('expires_at');
            $table->text('admin_notes')->nullable()->after('notes');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['stripe_payment_id', 'stripe_session_id', 'selected_countries', 'email_sent_at', 'admin_notes']);
        });
    }
};
