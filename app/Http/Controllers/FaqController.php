<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\View\View;

class FaqController extends Controller
{
    public function index(): View
    {
        $faqs = Faq::active()->orderBy('sort_order')->get();
        
        $categories = $faqs->pluck('category')->unique()->filter()->values();

        return view('faq', compact('faqs', 'categories'));
    }
}
