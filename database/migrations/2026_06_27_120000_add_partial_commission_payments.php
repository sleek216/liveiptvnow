<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('commissions', function (Blueprint $table) {
            $table->decimal('paid_amount', 10, 2)->default(0)->after('commission_amount');
        });

        DB::statement("ALTER TABLE commissions MODIFY status ENUM('pending', 'partially_paid', 'approved', 'paid', 'rejected') DEFAULT 'pending'");

        Schema::table('payouts', function (Blueprint $table) {
            $table->foreignId('commission_id')->nullable()->after('affiliate_id')->constrained()->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('payouts', function (Blueprint $table) {
            $table->dropConstrainedForeignId('commission_id');
        });

        DB::statement("ALTER TABLE commissions MODIFY status ENUM('pending', 'approved', 'paid', 'rejected') DEFAULT 'pending'");

        Schema::table('commissions', function (Blueprint $table) {
            $table->dropColumn('paid_amount');
        });
    }
};
