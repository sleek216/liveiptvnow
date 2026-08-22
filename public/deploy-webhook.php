<?php
/**
 * Live IPTV Now - GitHub Auto-Deployment Webhook
 */

$expectedSecret = 'LiveIPTVDeploy9821';
$providedSecret = $_GET['secret'] ?? $_SERVER['HTTP_X_DEPLOY_SECRET'] ?? '';

if ($providedSecret !== $expectedSecret) {
    http_response_code(403);
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Forbidden: Invalid secret key']);
    exit;
}

$repoDir = '/home/liveiptvnow/repositories/liveiptvnow';
$targetDir = '/home/liveiptvnow';
$output = [];

if (is_dir($repoDir)) {
    @exec("cd {$repoDir} && git pull origin main 2>&1", $output);

    $folders = ['app', 'bootstrap', 'config', 'database', 'lang', 'public', 'public_html', 'resources', 'routes', 'scripts', 'storage'];
    foreach ($folders as $folder) {
        if (is_dir("{$repoDir}/{$folder}")) {
            @exec("cp -R {$repoDir}/{$folder} {$targetDir}/ 2>&1", $output);
        }
    }

    $files = ['artisan', 'composer.json', 'composer.lock', 'vite.config.js', 'package.json'];
    foreach ($files as $file) {
        if (file_exists("{$repoDir}/{$file}")) {
            @exec("cp {$repoDir}/{$file} {$targetDir}/ 2>&1", $output);
        }
    }

    if (file_exists("{$targetDir}/artisan")) {
        @exec("php {$targetDir}/artisan config:clear 2>&1", $output);
        @exec("php {$targetDir}/artisan view:clear 2>&1", $output);
        @exec("php {$targetDir}/artisan route:clear 2>&1", $output);
    }
} else {
    $output[] = "Repository directory {$repoDir} not found.";
}

header('Content-Type: application/json');
echo json_encode([
    'status' => 'success',
    'timestamp' => date('Y-m-d H:i:s'),
    'output' => $output
]);
