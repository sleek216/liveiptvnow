<?php

namespace App\Http\Controllers;

use App\Models\ChannelCategory;
use Illuminate\View\View;

class ChannelController extends Controller
{
    public function index(): View
    {
        $categories = ChannelCategory::active()
            ->withCount('channels')
            ->orderBy('sort_order')
            ->get();

        return view('channels', compact('categories'));
    }
}
