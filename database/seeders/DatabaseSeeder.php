<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Package;
use App\Models\Feature;
use App\Models\Testimonial;
use App\Models\Faq;
use App\Models\Setting;
use App\Models\ChannelCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Run additional seeders first (creates admin and settings)
        $this->call([
            CountrySeeder::class,
            AdminSeeder::class,
        ]);

        // Create Features
        $features = [
            ['name' => '20,000+ Live Channels', 'icon' => 'ph-television', 'description' => 'Access to premium channels worldwide'],
            ['name' => '50,000+ VOD', 'icon' => 'ph-film-slate', 'description' => 'Movies and TV series on demand'],
            ['name' => 'HD & 4K Quality', 'icon' => 'ph-high-definition', 'description' => 'Crystal clear streaming quality'],
            ['name' => 'EPG TV Guide', 'icon' => 'ph-list-bullets', 'description' => 'Electronic program guide included'],
            ['name' => '24/7 Support', 'icon' => 'ph-headset', 'description' => 'Round-the-clock customer support'],
            ['name' => 'Anti-Freeze Technology', 'icon' => 'ph-shield-check', 'description' => 'Buffer-free streaming experience'],
            ['name' => 'All Devices', 'icon' => 'ph-devices', 'description' => 'Works on any device'],
            ['name' => 'Catch Up & Recording', 'icon' => 'ph-record', 'description' => 'Never miss your favorite shows'],
        ];

        foreach ($features as $feature) {
            Feature::create([
                'name' => $feature['name'],
                'icon' => $feature['icon'],
                'description' => $feature['description'],
                'is_active' => true,
            ]);
        }

        // Create Packages
        $packages = [
            // Trial
            [
                'name' => 'Free Trial',
                'slug' => 'free-trial',
                'description' => 'Test our service before purchasing',
                'price' => 0.00,
                'duration_months' => 0,
                'duration_days' => 1,
                'duration_label' => '36 Hours',
                'connections' => 1,
                'features_list' => json_encode(['20,000+ Live Channels', '50,000+ VOD Content', 'HD & 4K Streaming', 'EPG TV Guide', '24/7 Support']),
                'is_featured' => false,
                'is_trial' => true,
                'is_active' => true,
                'sort_order' => 0,
            ],
            // 1 Month Plans
            [
                'name' => 'Starter',
                'slug' => 'starter-1-month',
                'description' => 'Perfect for single users',
                'price' => 12.99,
                'duration_months' => 1,
                'duration_days' => 30,
                'duration_label' => '1 Month',
                'connections' => 1,
                'features_list' => json_encode(['20,000+ Live Channels', '50,000+ VOD Content', 'HD & 4K Streaming', 'EPG TV Guide', '24/7 Support', 'Anti-Freeze Technology']),
                'is_featured' => false,
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Family',
                'slug' => 'family-1-month',
                'description' => 'Ideal for families',
                'price' => 19.99,
                'duration_months' => 1,
                'duration_days' => 30,
                'duration_label' => '1 Month',
                'connections' => 2,
                'features_list' => json_encode(['20,000+ Live Channels', '50,000+ VOD Content', 'HD & 4K Streaming', 'EPG TV Guide', '24/7 Support', 'Anti-Freeze Technology', '2 Simultaneous Connections']),
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Premium',
                'slug' => 'premium-1-month',
                'description' => 'For the ultimate experience',
                'price' => 29.99,
                'duration_months' => 1,
                'duration_days' => 30,
                'duration_label' => '1 Month',
                'connections' => 4,
                'features_list' => json_encode(['20,000+ Live Channels', '50,000+ VOD Content', 'HD & 4K Streaming', 'EPG TV Guide', '24/7 Priority Support', 'Anti-Freeze Technology', '4 Simultaneous Connections', 'PPV Events Included']),
                'is_featured' => false,
                'is_active' => true,
                'sort_order' => 3,
            ],
            // 3 Month Plans
            [
                'name' => 'Starter',
                'slug' => 'starter-3-month',
                'description' => 'Perfect for single users',
                'price' => 29.99,
                'original_price' => 38.97,
                'duration_months' => 3,
                'duration_days' => 90,
                'duration_label' => '3 Months',
                'connections' => 1,
                'features_list' => json_encode(['20,000+ Live Channels', '50,000+ VOD Content', 'HD & 4K Streaming', 'EPG TV Guide', '24/7 Support', 'Anti-Freeze Technology']),
                'is_featured' => false,
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'name' => 'Family',
                'slug' => 'family-3-month',
                'description' => 'Ideal for families',
                'price' => 49.99,
                'original_price' => 59.97,
                'duration_months' => 3,
                'duration_days' => 90,
                'duration_label' => '3 Months',
                'connections' => 2,
                'features_list' => json_encode(['20,000+ Live Channels', '50,000+ VOD Content', 'HD & 4K Streaming', 'EPG TV Guide', '24/7 Support', 'Anti-Freeze Technology', '2 Simultaneous Connections']),
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 5,
            ],
            [
                'name' => 'Premium',
                'slug' => 'premium-3-month',
                'description' => 'For the ultimate experience',
                'price' => 69.99,
                'original_price' => 89.97,
                'duration_months' => 3,
                'duration_days' => 90,
                'duration_label' => '3 Months',
                'connections' => 4,
                'features_list' => json_encode(['20,000+ Live Channels', '50,000+ VOD Content', 'HD & 4K Streaming', 'EPG TV Guide', '24/7 Priority Support', 'Anti-Freeze Technology', '4 Simultaneous Connections', 'PPV Events Included']),
                'is_featured' => false,
                'is_active' => true,
                'sort_order' => 6,
            ],
            // 6 Month Plans
            [
                'name' => 'Starter',
                'slug' => 'starter-6-month',
                'description' => 'Perfect for single users',
                'price' => 49.99,
                'original_price' => 77.94,
                'duration_months' => 6,
                'duration_days' => 180,
                'duration_label' => '6 Months',
                'connections' => 1,
                'features_list' => json_encode(['20,000+ Live Channels', '50,000+ VOD Content', 'HD & 4K Streaming', 'EPG TV Guide', '24/7 Support', 'Anti-Freeze Technology']),
                'is_featured' => false,
                'is_active' => true,
                'sort_order' => 7,
            ],
            [
                'name' => 'Family',
                'slug' => 'family-6-month',
                'description' => 'Ideal for families',
                'price' => 79.99,
                'original_price' => 119.94,
                'duration_months' => 6,
                'duration_days' => 180,
                'duration_label' => '6 Months',
                'connections' => 2,
                'features_list' => json_encode(['20,000+ Live Channels', '50,000+ VOD Content', 'HD & 4K Streaming', 'EPG TV Guide', '24/7 Support', 'Anti-Freeze Technology', '2 Simultaneous Connections']),
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 8,
            ],
            [
                'name' => 'Premium',
                'slug' => 'premium-6-month',
                'description' => 'For the ultimate experience',
                'price' => 119.99,
                'original_price' => 179.94,
                'duration_months' => 6,
                'duration_days' => 180,
                'duration_label' => '6 Months',
                'connections' => 4,
                'features_list' => json_encode(['20,000+ Live Channels', '50,000+ VOD Content', 'HD & 4K Streaming', 'EPG TV Guide', '24/7 Priority Support', 'Anti-Freeze Technology', '4 Simultaneous Connections', 'PPV Events Included']),
                'is_featured' => false,
                'is_active' => true,
                'sort_order' => 9,
            ],
            // 12 Month Plans
            [
                'name' => 'Starter',
                'slug' => 'starter-12-month',
                'description' => 'Perfect for single users',
                'price' => 79.99,
                'original_price' => 155.88,
                'duration_months' => 12,
                'duration_days' => 365,
                'duration_label' => '12 Months',
                'connections' => 1,
                'features_list' => json_encode(['20,000+ Live Channels', '50,000+ VOD Content', 'HD & 4K Streaming', 'EPG TV Guide', '24/7 Support', 'Anti-Freeze Technology']),
                'is_featured' => false,
                'is_active' => true,
                'sort_order' => 10,
            ],
            [
                'name' => 'Family',
                'slug' => 'family-12-month',
                'description' => 'Best value for families',
                'price' => 129.99,
                'original_price' => 239.88,
                'duration_months' => 12,
                'duration_days' => 365,
                'duration_label' => '12 Months',
                'connections' => 2,
                'features_list' => json_encode(['20,000+ Live Channels', '50,000+ VOD Content', 'HD & 4K Streaming', 'EPG TV Guide', '24/7 Support', 'Anti-Freeze Technology', '2 Simultaneous Connections']),
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 11,
            ],
            [
                'name' => 'Premium',
                'slug' => 'premium-12-month',
                'description' => 'Ultimate entertainment package',
                'price' => 199.99,
                'original_price' => 359.88,
                'duration_months' => 12,
                'duration_days' => 365,
                'duration_label' => '12 Months',
                'connections' => 4,
                'features_list' => json_encode(['20,000+ Live Channels', '50,000+ VOD Content', 'HD & 4K Streaming', 'EPG TV Guide', '24/7 Priority Support', 'Anti-Freeze Technology', '4 Simultaneous Connections', 'PPV Events Included', 'Catch Up & Recording']),
                'is_featured' => false,
                'is_active' => true,
                'sort_order' => 12,
            ],
        ];

        foreach ($packages as $package) {
            Package::create($package);
        }
        // Create Package-Feature relationships
        $allPackages = Package::all();
        $allFeatures = Feature::all();
        
        foreach ($allPackages as $package) {
            // All packages get basic features
            $basicFeatures = $allFeatures->whereIn('slug', [
                'live-tv-channels', 
                'video-on-demand',
                'multi-device-support',
                'epg-tv-guide'
            ])->pluck('id');
            
            // Premium packages get all features
            if (str_contains($package->name, 'Premium') || str_contains($package->name, 'Ultimate')) {
                $package->features()->attach($allFeatures->pluck('id'));
            } else {
                $package->features()->attach($basicFeatures);
                
                // Add HD/4K for non-basic plans
                if (!str_contains($package->name, 'Trial')) {
                    $hdFeature = $allFeatures->where('slug', 'hd-4k-quality')->first();
                    if ($hdFeature) {
                        $package->features()->attach($hdFeature->id);
                    }
                }
            }
        }
        // Create Testimonials
        $testimonials = [
            [
                'name' => 'Michael Thompson',
                'location' => 'New York, USA',
                'rating' => 5,
                'title' => 'Best IPTV service I\'ve ever used!',
                'content' => 'I\'ve tried many IPTV services over the years, but BestLiveIPTV is by far the best. The channel quality is amazing, zero buffering, and the customer support is incredibly responsive.',
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'name' => 'Sarah Williams',
                'location' => 'London, UK',
                'rating' => 5,
                'title' => 'Perfect for the whole family',
                'content' => 'We cut the cord last year and switched to BestLiveIPTV. My kids love the cartoon channels, my husband enjoys the sports, and I watch my drama series. The 4 connections plan is perfect!',
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'name' => 'Ahmed Hassan',
                'location' => 'Dubai, UAE',
                'rating' => 5,
                'title' => 'Excellent Arabic channels',
                'content' => 'Finally found a service with great Arabic channel coverage. All the channels I need in HD quality. The EPG works perfectly and the setup was very easy. Great value for money!',
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'name' => 'James Rodriguez',
                'location' => 'Toronto, Canada',
                'rating' => 5,
                'title' => 'Sports fan\'s dream come true',
                'content' => 'As a huge sports fan, I need reliable streaming for live games. BestLiveIPTV delivers every single time. NBA, NFL, Premier League - all in crystal clear quality!',
                'is_featured' => true,
                'is_active' => true,
            ],
        ];

        foreach ($testimonials as $testimonial) {
            Testimonial::create($testimonial);
        }

        // Create FAQs
        $faqs = [
            ['category' => 'general', 'question' => 'What is IPTV and how does it work?', 'answer' => 'IPTV (Internet Protocol Television) is a service that delivers television content over the internet rather than through traditional satellite or cable formats.', 'sort_order' => 1, 'is_active' => true],
            ['category' => 'general', 'question' => 'What channels and content do you offer?', 'answer' => 'We offer over 20,000 live TV channels from around the world including sports, movies, news, entertainment, kids, and more. Plus 50,000+ VOD content.', 'sort_order' => 2, 'is_active' => true],
            ['category' => 'general', 'question' => 'Is there a free trial available?', 'answer' => 'Yes! We offer a 36-hour free trial so you can test our service before committing to a subscription with full access to all features.', 'sort_order' => 3, 'is_active' => true],
            ['category' => 'setup', 'question' => 'What devices are compatible with your service?', 'answer' => 'Our service is compatible with Smart TVs, Android devices, iOS devices, Amazon Fire Stick, Nvidia Shield, MAG boxes, Windows and Mac computers, and Xbox.', 'sort_order' => 4, 'is_active' => true],
            ['category' => 'setup', 'question' => 'What internet speed do I need?', 'answer' => 'SD quality: 5 Mbps, HD quality: 10 Mbps, Full HD (1080p): 15 Mbps, 4K Ultra HD: 25 Mbps minimum recommended.', 'sort_order' => 5, 'is_active' => true],
            ['category' => 'payment', 'question' => 'What payment methods do you accept?', 'answer' => 'We accept PayPal, Credit/Debit cards via Stripe (Visa, Mastercard, American Express), and Cryptocurrencies (Bitcoin, Ethereum).', 'sort_order' => 6, 'is_active' => true],
            ['category' => 'payment', 'question' => 'Do subscriptions auto-renew?', 'answer' => 'No, our subscriptions do not auto-renew. You have full control and can renew manually when ready. We send reminders before expiration.', 'sort_order' => 7, 'is_active' => true],
            ['category' => 'payment', 'question' => 'What is your refund policy?', 'answer' => 'We offer a 24-hour money-back guarantee for new subscribers. Contact our support team within the first 24 hours for a full refund.', 'sort_order' => 8, 'is_active' => true],
        ];

        foreach ($faqs as $faq) {
            Faq::create($faq);
        }

        // Create Settings
        $settings = [
            ['key' => 'site_name', 'value' => 'BestLiveIPTV', 'group' => 'general'],
            ['key' => 'site_tagline', 'value' => 'Premium IPTV Service', 'group' => 'general'],
            ['key' => 'contact_email', 'value' => 'support@bestliveiptv.com', 'group' => 'contact'],
            ['key' => 'contact_phone', 'value' => '+1 (555) 123-4567', 'group' => 'contact'],
            ['key' => 'whatsapp', 'value' => '+15551234567', 'group' => 'contact'],
            ['key' => 'telegram', 'value' => '@BestLiveIPTV', 'group' => 'contact'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }

        // Create Channel Categories
        $categories = [
            ['name' => 'Sports', 'slug' => 'sports', 'icon' => 'ph-soccer-ball', 'description' => 'Live sports from around the world', 'channel_count' => 2500],
            ['name' => 'Movies', 'slug' => 'movies', 'icon' => 'ph-film-slate', 'description' => 'Premium movie channels', 'channel_count' => 3000],
            ['name' => 'News', 'slug' => 'news', 'icon' => 'ph-newspaper', 'description' => '24/7 news coverage', 'channel_count' => 800],
            ['name' => 'Entertainment', 'slug' => 'entertainment', 'icon' => 'ph-star', 'description' => 'Entertainment channels', 'channel_count' => 5000],
            ['name' => 'Kids', 'slug' => 'kids', 'icon' => 'ph-baby', 'description' => 'Family-friendly content', 'channel_count' => 1000],
            ['name' => 'Documentary', 'slug' => 'documentary', 'icon' => 'ph-globe-hemisphere-west', 'description' => 'Educational content', 'channel_count' => 600],
        ];

        foreach ($categories as $category) {
            ChannelCategory::create($category);
        }

        $this->command->info('Database seeded successfully!');
    }
}
