<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Support\PackageDurations;
use Illuminate\View\View;

class PackageController extends Controller
{
    public function index(): View
    {
        $allPackages = Package::active()
            ->regular()
            ->with('features')
            ->orderBy('sort_order')
            ->get();

        $packagesByDuration = PackageDurations::group($allPackages, includeAll: true);
        $packages = $packagesByDuration['all'];

        return view('packages.index', compact('packages', 'packagesByDuration'));
    }

    public function show(string $slug): View
    {
        $package = Package::where('slug', $slug)->active()->with('features')->firstOrFail();

        $relatedPackages = Package::active()
            ->where('id', '!=', $package->id)
            ->where('duration_months', $package->duration_months)
            ->with('features')
            ->orderBy('sort_order')
            ->get();

        return view('packages.show', compact('package', 'relatedPackages'));
    }
}
