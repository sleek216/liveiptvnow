<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\Testimonial;
use App\Models\Faq;
use App\Models\ChannelCategory;
use App\Models\Setting;
use App\Support\PackageDurations;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $allPackages = Package::active()
            ->with('features')
            ->orderBy('sort_order')
            ->get();

        $packagesByDuration = PackageDurations::group($allPackages);

        $featuredPackages = $packagesByDuration['1_month'];

        $testimonials = Testimonial::active()
            ->featured()
            ->orderBy('sort_order')
            ->take(6)
            ->get();

        $faqs = Faq::active()
            ->orderBy('sort_order')
            ->take(8)
            ->get();

        $channelCategories = ChannelCategory::active()
            ->orderBy('sort_order')
            ->take(12)
            ->get();

        $stats = [
            'channels' => Setting::get('total_channels', '20,000+'),
            'countries' => Setting::get('total_countries', '150+'),
            'uptime' => Setting::get('uptime_percentage', '99.9%'),
            'support' => Setting::get('support_type', '24/7'),
        ];
        
        // Get free trial package for direct checkout link
        $freeTrialPackage = Package::active()
            ->where(function($query) {
                $query->where('duration_label', 'LIKE', '%trial%')
                      ->orWhere('name', 'LIKE', '%trial%')
                      ->orWhere('price', 0);
            })
            ->first();

        return view('home', compact(
            'featuredPackages',
            'packagesByDuration',
            'testimonials',
            'faqs',
            'channelCategories',
            'stats',
            'freeTrialPackage'
        ));
    }
}
