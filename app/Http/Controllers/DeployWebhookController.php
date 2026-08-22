<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DeployWebhookController extends Controller
{
    public function handle(Request $request): JsonResponse
    {
        $expectedSecret = config('app.deploy_secret', 'LiveIPTVDeploy9821');
        $secret = $request->query('secret') ?: $request->header('X-Deploy-Secret');

        if ($secret !== $expectedSecret) {
            return response()->json(['error' => 'Forbidden: Invalid secret key'], 403);
        }

        $repoDir = '/home/liveiptvnow/repositories/liveiptvnow';
        $targetDir = '/home/liveiptvnow';
        $logs = [];

        if (is_dir($repoDir)) {
            // 1. Pull latest code from GitHub main branch
            @exec("cd {$repoDir} && git pull origin main 2>&1", $logs);

            // 2. Copy directories to /home/liveiptvnow
            $folders = ['app', 'bootstrap', 'config', 'database', 'lang', 'public', 'public_html', 'resources', 'routes', 'scripts', 'storage'];
            foreach ($folders as $folder) {
                if (is_dir("{$repoDir}/{$folder}")) {
                    @exec("cp -R {$repoDir}/{$folder} {$targetDir}/ 2>&1", $logs);
                }
            }

            // 3. Copy root files
            $files = ['artisan', 'composer.json', 'composer.lock', 'vite.config.js', 'package.json'];
            foreach ($files as $file) {
                if (file_exists("{$repoDir}/{$file}")) {
                    @exec("cp {$repoDir}/{$file} {$targetDir}/ 2>&1", $logs);
                }
            }

            // 4. Clear cache
            if (file_exists("{$targetDir}/artisan")) {
                @exec("php {$targetDir}/artisan config:clear 2>&1", $logs);
                @exec("php {$targetDir}/artisan view:clear 2>&1", $logs);
                @exec("php {$targetDir}/artisan route:clear 2>&1", $logs);
            }
        } else {
            $logs[] = "Repository directory {$repoDir} not found.";
        }

        return response()->json([
            'status' => 'success',
            'timestamp' => now()->toIso8601String(),
            'output' => $logs,
        ]);
    }
}
