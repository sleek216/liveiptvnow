<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->decimal('adjustment_amount', 10, 2)->default(0)->after('amount');
            $table->string('coupon_code')->nullable()->after('adjustment_amount');
            $table->decimal('discount_amount', 10, 2)->default(0)->after('coupon_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['adjustment_amount', 'coupon_code', 'discount_amount']);
        });
    }
};
