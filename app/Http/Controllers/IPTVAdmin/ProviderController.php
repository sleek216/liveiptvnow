<?php

namespace App\Http\Controllers\IPTVAdmin;

use App\Http\Controllers\Controller;
use App\Models\IPTVProvider;
use Illuminate\Http\Request;

class ProviderController extends Controller
{
    public function index()
    {
        $providers = IPTVProvider::all();
        return view('iptv-admin.providers.index', compact('providers'));
    }

    public function store(Request $request)
    {
        IPTVProvider::create($request->all());
        return back()->with('success', 'Provider added successfully.');
    }
}
