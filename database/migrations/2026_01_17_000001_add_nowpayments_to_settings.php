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
        // Add NOWPayments settings to settings table
        DB::table('settings')->insert([
            [
                'key' => 'nowpayments_api_key',
                'value' => '',
                'type' => 'text',
                'group' => 'nowpayments',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'nowpayments_ipn_secret',
                'value' => '',
                'type' => 'text',
                'group' => 'nowpayments',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'nowpayments_enabled',
                'value' => '0',
                'type' => 'boolean',
                'group' => 'nowpayments',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'nowpayments_sandbox',
                'value' => '1',
                'type' => 'boolean',
                'group' => 'nowpayments',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'nowpayments_default_currency',
                'value' => 'usdttrc20',
                'type' => 'text',
                'group' => 'nowpayments',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('settings')->where('group', 'nowpayments')->delete();
    }
};
