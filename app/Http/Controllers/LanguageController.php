<?php

namespace App\Http\Controllers;

use App\Support\SupportedLocales;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    public function switch(string $locale): RedirectResponse
    {
        if (!SupportedLocales::isSupported($locale)) {
            return redirect()->back();
        }

        Session::put('locale', $locale);

        return redirect()
            ->back()
            ->withCookie(Cookie::make('locale', $locale, 60 * 24 * 365));
    }
}
