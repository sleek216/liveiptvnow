<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        User::updateOrCreate(
            ['email' => 'admin@bestliveiptv.com'],
            [
                'name' => 'Admin',
                'email' => 'admin@bestliveiptv.com',
                'password' => Hash::make('admin123'),
                'is_admin' => true,
            ]
        );

        // Create default settings
        $settings = [
            // Site settings
            ['key' => 'site_name', 'value' => 'Best Live IPTV', 'type' => 'text', 'group' => 'site'],
            ['key' => 'site_tagline', 'value' => 'Premium IPTV Service', 'type' => 'text', 'group' => 'site'],
            
            // Stripe settings (empty by default)
            ['key' => 'stripe_mode', 'value' => 'test', 'type' => 'text', 'group' => 'stripe'],
            ['key' => 'stripe_publishable_key', 'value' => '', 'type' => 'text', 'group' => 'stripe'],
            ['key' => 'stripe_secret_key', 'value' => '', 'type' => 'text', 'group' => 'stripe'],
            ['key' => 'stripe_webhook_secret', 'value' => '', 'type' => 'text', 'group' => 'stripe'],
            
            // Email settings
            ['key' => 'admin_notification_email', 'value' => 'admin@bestliveiptv.com', 'type' => 'text', 'group' => 'email'],
            ['key' => 'mail_from_name', 'value' => 'Best Live IPTV', 'type' => 'text', 'group' => 'email'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
