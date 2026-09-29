<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\BlogPost;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    /**
     * Generate dynamic XML sitemap
     */
    public function index(): Response
    {
        $sitemapPath = public_path('sitemap.xml');
        if (file_exists($sitemapPath)) {
            return response(file_get_contents($sitemapPath), 200, [
                'Content-Type' => 'application/xml; charset=utf-8',
            ]);
        }

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
        $urls = [
            'https://liveiptvnow.com/',
            'https://liveiptvnow.com/packages',
            'https://liveiptvnow.com/channels',
            'https://liveiptvnow.com/how-it-works',
            'https://liveiptvnow.com/faq',
            'https://liveiptvnow.com/about',
            'https://liveiptvnow.com/contact',
            'https://liveiptvnow.com/blog',
            'https://liveiptvnow.com/affiliate-program',
            'https://liveiptvnow.com/become-reseller',
            'https://liveiptvnow.com/refund',
            'https://liveiptvnow.com/privacy',
            'https://liveiptvnow.com/terms',
        ];
        foreach ($urls as $url) {
            $xml .= "<url>\n<loc>{$url}</loc>\n</url>\n";
        }
        $xml .= '</urlset>';

        return response($xml, 200, [
            'Content-Type' => 'application/xml; charset=utf-8',
        ]);
    }
}
