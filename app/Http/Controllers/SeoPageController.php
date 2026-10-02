<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SeoPageController extends Controller
{
    public function show($slug)
    {
        // Try to find a specific view for this slug
        if (view()->exists('seo.' . $slug)) {
            return view('seo.' . $slug, compact('slug'));
        }

        // Fallback to a generic dynamic view
        return view('seo.dynamic', compact('slug'));
    }
}
