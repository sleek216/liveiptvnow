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
        $baseUrl = config('app.url', 'https://liveiptvnow.com');
        $baseUrl = rtrim($baseUrl, '/');

        // Static public canonical pages with priorities and frequencies
        $staticPages = [
            ['loc' => $baseUrl . '/', 'priority' => '1.0', 'changefreq' => 'daily', 'lastmod' => now()->toDateString()],
            ['loc' => $baseUrl . '/packages', 'priority' => '0.9', 'changefreq' => 'daily', 'lastmod' => now()->toDateString()],
            ['loc' => $baseUrl . '/channels', 'priority' => '0.8', 'changefreq' => 'weekly', 'lastmod' => now()->toDateString()],
            ['loc' => $baseUrl . '/become-reseller', 'priority' => '0.8', 'changefreq' => 'weekly', 'lastmod' => now()->toDateString()],
            ['loc' => $baseUrl . '/blog', 'priority' => '0.8', 'changefreq' => 'daily', 'lastmod' => now()->toDateString()],
            ['loc' => $baseUrl . '/how-it-works', 'priority' => '0.7', 'changefreq' => 'monthly', 'lastmod' => now()->toDateString()],
            ['loc' => $baseUrl . '/faq', 'priority' => '0.7', 'changefreq' => 'weekly', 'lastmod' => now()->toDateString()],
            ['loc' => $baseUrl . '/about', 'priority' => '0.6', 'changefreq' => 'monthly', 'lastmod' => now()->toDateString()],
            ['loc' => $baseUrl . '/contact', 'priority' => '0.6', 'changefreq' => 'monthly', 'lastmod' => now()->toDateString()],
            ['loc' => $baseUrl . '/affiliate-program', 'priority' => '0.6', 'changefreq' => 'monthly', 'lastmod' => now()->toDateString()],
            ['loc' => $baseUrl . '/terms', 'priority' => '0.3', 'changefreq' => 'yearly', 'lastmod' => now()->toDateString()],
            ['loc' => $baseUrl . '/privacy', 'priority' => '0.3', 'changefreq' => 'yearly', 'lastmod' => now()->toDateString()],
            ['loc' => $baseUrl . '/refund', 'priority' => '0.3', 'changefreq' => 'yearly', 'lastmod' => now()->toDateString()],
        ];

        // Dynamic Packages
        $packages = Package::where('is_active', true)->get();
        $packagePages = [];
        foreach ($packages as $pkg) {
            $packagePages[] = [
                'loc' => $baseUrl . '/packages/' . $pkg->slug,
                'priority' => '0.8',
                'changefreq' => 'weekly',
                'lastmod' => $pkg->updated_at ? $pkg->updated_at->toDateString() : now()->toDateString(),
            ];
        }

        // Dynamic Published Blog Posts
        $blogPosts = [];
        try {
            if (class_exists(BlogPost::class)) {
                $posts = BlogPost::where('is_published', true)->get();
                foreach ($posts as $post) {
                    $blogPosts[] = [
                        'loc' => $baseUrl . '/blog/' . $post->slug,
                        'priority' => '0.7',
                        'changefreq' => 'monthly',
                        'lastmod' => $post->updated_at ? $post->updated_at->toDateString() : now()->toDateString(),
                    ];
                }
            }
        } catch (\Throwable $e) {
            // Ignore if blog table not migrated
        }

        $allUrls = array_merge($staticPages, $packagePages, $blogPosts);

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"' . "\n";
        $xml .= '        xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"' . "\n";
        $xml .= '        xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">' . "\n";

        foreach ($allUrls as $url) {
            $xml .= "  <url>\n";
            $xml .= '    <loc>' . htmlspecialchars($url['loc']) . "</loc>\n";
            $xml .= '    <lastmod>' . $url['lastmod'] . "</lastmod>\n";
            $xml .= '    <changefreq>' . $url['changefreq'] . "</changefreq>\n";
            $xml .= '    <priority>' . $url['priority'] . "</priority>\n";
            $xml .= "  </url>\n";
        }

        $xml .= '</urlset>';

        return response($xml, 200, [
            'Content-Type' => 'application/xml; charset=utf-8',
            'X-Robots-Tag' => 'noindex',
        ]);
    }
}
