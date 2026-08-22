<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\View\View;

class ResellerController extends Controller
{
    public function index(): View
    {
        // Fetch only reseller packages
        $packages = Package::active()
            ->reseller()
            ->with('features')
            ->orderBy('sort_order')
            ->get();

        return view('reseller.index', compact('packages'));
    }
}
