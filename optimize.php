<?php
$files = glob('public/*.png');
foreach($files as $file) {
    if (strpos($file, 'hero_') !== false || strpos($file, 'speed_test') !== false || strpos($file, 'iptv_hero') !== false) {
        $img = imagecreatefrompng($file);
        imagepalettetotruecolor($img);
        $webp_file = str_replace('.png', '.webp', $file);
        imagewebp($img, $webp_file, 50); // High compression
        imagedestroy($img);
        echo "Converted $file to $webp_file\n";
    }
}
$files = glob('public_html/*.png');
foreach($files as $file) {
    if (strpos($file, 'hero_') !== false || strpos($file, 'speed_test') !== false || strpos($file, 'iptv_hero') !== false) {
        $img = imagecreatefrompng($file);
        imagepalettetotruecolor($img);
        $webp_file = str_replace('.png', '.webp', $file);
        imagewebp($img, $webp_file, 50); // High compression
        imagedestroy($img);
        echo "Converted $file to $webp_file\n";
    }
}
echo "Done.\n";
