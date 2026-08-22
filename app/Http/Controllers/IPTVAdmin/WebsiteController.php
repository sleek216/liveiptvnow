<?php

namespace App\Http\Controllers\IPTVAdmin;

use App\Http\Controllers\Controller;
use App\Models\IPTVWebsite;
use Illuminate\Http\Request;

class WebsiteController extends Controller
{
    public function index()
    {
        $websites = IPTVWebsite::all();
        return view('iptv-admin.websites.index', compact('websites'));
    }

    public function store(Request $request)
    {
        IPTVWebsite::create($request->all());
        return back()->with('success', 'Website added successfully.');
    }
}
