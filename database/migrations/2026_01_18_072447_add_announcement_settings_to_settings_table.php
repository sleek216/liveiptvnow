<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Add announcement bar settings
        DB::table('settings')->insert([
            [
                'key' => 'announcement_enabled',
                'value' => '1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'announcement_text',
                'value' => 'Get <strong>50% OFF</strong> on annual plans — Use code: <code>LIVE50</code>',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'announcement_link',
                'value' => '/packages',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'announcement_link_text',
                'value' => 'Shop Now',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    public function down(): void
    {
        DB::table('settings')->whereIn('key', [
            'announcement_enabled',
            'announcement_text',
            'announcement_link',
            'announcement_link_text',
        ])->delete();
    }
};
