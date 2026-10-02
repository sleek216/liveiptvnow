<?php
$pages = [
    'iptv-service', 'iptv-subscription', 'iptv-pricing', 'iptv-free-trial', 'iptv-devices', 'iptv-channels',
    'iptv-usa', 'iptv-uk', 'iptv-canada', 'iptv-australia', 'iptv-europe',
    'what-is-iptv', 'how-does-iptv-work', 'iptv-vs-cable', 'iptv-vs-satellite', 'iptv-internet-speed-requirements', 'what-is-epg', 'iptv-troubleshooting-guide', 'iptv-buffering-causes', 'hd-vs-4k-iptv',
    'iptv-for-smart-tv', 'iptv-for-firestick', 'iptv-for-android', 'iptv-for-ios', 'iptv-for-windows', 'iptv-for-mac', 'iptv-for-mag-box', 'iptv-for-xbox', 'iptv-for-samsung-tv', 'iptv-for-lg-tv', 'iptv-for-roku'
];

foreach ($pages as $page) {
    $title = ucwords(str_replace('-', ' ', $page));
    $content = "@extends('layouts.app')\n\n";
    $content .= "@section('title', '$title - Premium IPTV')\n";
    $content .= "@section('meta_description', 'Learn more about $title with our comprehensive premium IPTV service guide.')\n\n";
    $content .= "@section('content')\n";
    $content .= "<section class=\"hero\" style=\"padding-top:120px; padding-bottom:60px; background:#0f172a;\">\n";
    $content .= "    <div class=\"wrap text-center\">\n";
    $content .= "        <h1 style=\"color:#fff; font-size:3rem;\">$title</h1>\n";
    $content .= "        <p style=\"color:#94a3b8; font-size:1.25rem; max-width:800px; margin:20px auto;\">Find the best information and options for $title right here.</p>\n";
    $content .= "    </div>\n";
    $content .= "</section>\n\n";
    $content .= "<section class=\"page-content\" style=\"padding:60px 0;\">\n";
    $content .= "    <div class=\"wrap\">\n";
    $content .= "        <div style=\"background:#fff; padding:40px; border-radius:12px; box-shadow:0 4px 12px rgba(0,0,0,0.05);\">\n";
    $content .= "            <h2>Overview of $title</h2>\n";
    $content .= "            <p>This is a dedicated page for <strong>$title</strong>. Please update this section with unique, SEO-optimized content that specifically addresses this topic.</p>\n";
    $content .= "            <ul>\n";
    $content .= "                <li>Key benefits and features</li>\n";
    $content .= "                <li>Common questions and detailed answers</li>\n";
    $content .= "                <li>Step-by-step setup or usage guides where applicable</li>\n";
    $content .= "            </ul>\n";
    $content .= "            <p>Ensure this content is not just a copy-paste of other pages to maintain strong SEO performance.</p>\n";
    $content .= "        </div>\n";
    $content .= "    </div>\n";
    $content .= "</section>\n";
    $content .= "@endsection\n";

    file_put_contents("resources/views/seo/$page.blade.php", $content);
}
echo "Done.\n";
