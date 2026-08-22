<?php

namespace App\Http\Middleware;

use App\Support\SupportedLocales;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        $locale = SupportedLocales::resolve(
            session('locale', $request->cookie('locale'))
        );

        session(['locale' => $locale]);
        App::setLocale($locale);

        return $next($request);
    }
}
