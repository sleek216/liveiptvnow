<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    public function run(): void
    {
        $countries = [
            ['name' => 'United States', 'code' => 'US', 'flag' => '🇺🇸', 'sort_order' => 1],
            ['name' => 'United Kingdom', 'code' => 'UK', 'flag' => '🇬🇧', 'sort_order' => 2],
            ['name' => 'Canada', 'code' => 'CA', 'flag' => '🇨🇦', 'sort_order' => 3],
            ['name' => 'Germany', 'code' => 'DE', 'flag' => '🇩🇪', 'sort_order' => 4],
            ['name' => 'France', 'code' => 'FR', 'flag' => '🇫🇷', 'sort_order' => 5],
            ['name' => 'Spain', 'code' => 'ES', 'flag' => '🇪🇸', 'sort_order' => 6],
            ['name' => 'Italy', 'code' => 'IT', 'flag' => '🇮🇹', 'sort_order' => 7],
            ['name' => 'Netherlands', 'code' => 'NL', 'flag' => '🇳🇱', 'sort_order' => 8],
            ['name' => 'Belgium', 'code' => 'BE', 'flag' => '🇧🇪', 'sort_order' => 9],
            ['name' => 'Switzerland', 'code' => 'CH', 'flag' => '🇨🇭', 'sort_order' => 10],
            ['name' => 'Austria', 'code' => 'AT', 'flag' => '🇦🇹', 'sort_order' => 11],
            ['name' => 'Portugal', 'code' => 'PT', 'flag' => '🇵🇹', 'sort_order' => 12],
            ['name' => 'Poland', 'code' => 'PL', 'flag' => '🇵🇱', 'sort_order' => 13],
            ['name' => 'Sweden', 'code' => 'SE', 'flag' => '🇸🇪', 'sort_order' => 14],
            ['name' => 'Norway', 'code' => 'NO', 'flag' => '🇳🇴', 'sort_order' => 15],
            ['name' => 'Denmark', 'code' => 'DK', 'flag' => '🇩🇰', 'sort_order' => 16],
            ['name' => 'Finland', 'code' => 'FI', 'flag' => '🇫🇮', 'sort_order' => 17],
            ['name' => 'Ireland', 'code' => 'IE', 'flag' => '🇮🇪', 'sort_order' => 18],
            ['name' => 'Australia', 'code' => 'AU', 'flag' => '🇦🇺', 'sort_order' => 19],
            ['name' => 'New Zealand', 'code' => 'NZ', 'flag' => '🇳🇿', 'sort_order' => 20],
            ['name' => 'India', 'code' => 'IN', 'flag' => '🇮🇳', 'sort_order' => 21],
            ['name' => 'Pakistan', 'code' => 'PK', 'flag' => '🇵🇰', 'sort_order' => 22],
            ['name' => 'Brazil', 'code' => 'BR', 'flag' => '🇧🇷', 'sort_order' => 23],
            ['name' => 'Mexico', 'code' => 'MX', 'flag' => '🇲🇽', 'sort_order' => 24],
            ['name' => 'Argentina', 'code' => 'AR', 'flag' => '🇦🇷', 'sort_order' => 25],
            ['name' => 'Turkey', 'code' => 'TR', 'flag' => '🇹🇷', 'sort_order' => 26],
            ['name' => 'Saudi Arabia', 'code' => 'SA', 'flag' => '🇸🇦', 'sort_order' => 27],
            ['name' => 'UAE', 'code' => 'AE', 'flag' => '🇦🇪', 'sort_order' => 28],
            ['name' => 'Egypt', 'code' => 'EG', 'flag' => '🇪🇬', 'sort_order' => 29],
            ['name' => 'South Africa', 'code' => 'ZA', 'flag' => '🇿🇦', 'sort_order' => 30],
        ];

        foreach ($countries as $country) {
            Country::updateOrCreate(
                ['code' => $country['code']],
                $country
            );
        }
    }
}
