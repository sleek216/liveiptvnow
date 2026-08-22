<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class PageController extends Controller
{
    public function about(): View
    {
        return view('pages.about');
    }

    public function howItWorks(): View
    {
        return view('pages.how-it-works');
    }

    public function terms(): View
    {
        return view('pages.terms');
    }

    public function privacy(): View
    {
        return view('pages.privacy');
    }

    public function refund(): View
    {
        return view('pages.refund');
    }

    public function affiliateInfo(): View
    {
        return view('pages.affiliate');
    }
}
