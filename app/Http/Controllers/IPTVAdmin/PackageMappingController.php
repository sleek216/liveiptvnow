<?php

namespace App\Http\Controllers\IPTVAdmin;

use App\Http\Controllers\Controller;
use App\Models\IPTVPackageMapping;
use App\Models\IPTVProvider;
use App\Models\IPTVWebsite;
use Illuminate\Http\Request;

class PackageMappingController extends Controller
{
    public function index()
    {
        $mappings = IPTVPackageMapping::with(['website', 'provider'])->get();
        $websites = IPTVWebsite::all();
        $providers = IPTVProvider::all();
        
        return view('iptv-admin.mappings.index', compact('mappings', 'websites', 'providers'));
    }

    public function store(Request $request)
    {
        IPTVPackageMapping::create($request->all());
        return back()->with('success', 'Mapping added successfully.');
    }
}
