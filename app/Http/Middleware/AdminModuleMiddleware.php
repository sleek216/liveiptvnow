<?php

namespace App\Http\Middleware;

use App\Support\AdminModules;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminModuleMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        if (!$user || !$user->isAdmin()) {
            abort(403, 'Access denied.');
        }

        if ($user->hasFullAdminAccess()) {
            return $next($request);
        }

        $requiredModule = AdminModules::moduleForRoute($request->route()?->getName());

        if ($requiredModule && !$user->canAccessAdminModule($requiredModule)) {
            if ($request->isMethod('GET')) {
                $fallbackRoute = $user->defaultAdminRouteName();

                if ($fallbackRoute && $fallbackRoute !== $request->route()?->getName()) {
                    return redirect()->route($fallbackRoute);
                }
            }

            abort(403, 'You do not have access to this admin section.');
        }

        return $next($request);
    }
}
