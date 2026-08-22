<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\Feature;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;

class PackageController extends Controller
{
    public function index(): View
    {
        $packages = Package::withCount('orders')
            ->orderBy('sort_order')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.packages.index', compact('packages'));
    }

    public function create(): View
    {
        $features = Feature::orderBy('name')->get();
        return view('admin.packages.create', compact('features'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'duration_months' => 'nullable|integer|min:0',
            'duration_days' => 'nullable|integer|min:0',
            'duration_label' => 'nullable|string|max:50',
            'connections' => 'required|integer|min:1',
            'features_list' => 'nullable|array',
            'is_featured' => 'boolean',
            'is_trial' => 'boolean',
            'is_active' => 'boolean',
            'is_reseller' => 'boolean',
            'sort_order' => 'integer|min:0',
            'feature_ids' => 'nullable|array',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['is_trial'] = $request->boolean('is_trial');
        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['is_reseller'] = $request->boolean('is_reseller');
        $validated['duration_months'] = $validated['duration_months'] ?? 0;
        $validated['duration_days'] = $validated['duration_days'] ?? 0;
        $validated['devices'] = $validated['connections'] ?? 1;
        
        // Auto-detect lifetime packages and set duration_months to 999
        if (isset($validated['duration_label']) && 
            (stripos($validated['duration_label'], 'lifetime') !== false || 
             stripos($validated['duration_label'], 'life time') !== false)) {
            $validated['duration_months'] = 999;
        }

        $package = Package::create($validated);

        if ($request->has('feature_ids')) {
            $package->features()->sync($request->feature_ids);
        }

        return redirect()
            ->route('admin.packages.index')
            ->with('success', 'Package created successfully!');
    }

    public function edit(Package $package): View
    {
        $features = Feature::orderBy('name')->get();
        $selectedFeatures = $package->features->pluck('id')->toArray();
        
        return view('admin.packages.edit', compact('package', 'features', 'selectedFeatures'));
    }

    public function update(Request $request, Package $package): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'duration_months' => 'nullable|integer|min:0',
            'duration_days' => 'nullable|integer|min:0',
            'duration_label' => 'nullable|string|max:50',
            'connections' => 'required|integer|min:1',
            'features_list' => 'nullable|array',
            'is_featured' => 'boolean',
            'is_trial' => 'boolean',
            'is_active' => 'boolean',
            'is_reseller' => 'boolean',
            'sort_order' => 'integer|min:0',
            'feature_ids' => 'nullable|array',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['is_trial'] = $request->boolean('is_trial');
        $validated['is_active'] = $request->boolean('is_active');
        $validated['is_reseller'] = $request->boolean('is_reseller');
        $validated['duration_months'] = $validated['duration_months'] ?? 0;
        $validated['duration_days'] = $validated['duration_days'] ?? 0;
        $validated['devices'] = $validated['connections'] ?? 1;
        
        // Auto-detect lifetime packages and set duration_months to 999
        if (isset($validated['duration_label']) && 
            (stripos($validated['duration_label'], 'lifetime') !== false || 
             stripos($validated['duration_label'], 'life time') !== false)) {
            $validated['duration_months'] = 999;
        }

        $package->update($validated);

        if ($request->has('feature_ids')) {
            $package->features()->sync($request->feature_ids);
        } else {
            $package->features()->detach();
        }

        return redirect()
            ->route('admin.packages.index')
            ->with('success', 'Package updated successfully!');
    }

    public function destroy(Package $package): RedirectResponse
    {
        if ($package->orders()->exists()) {
            return redirect()
                ->route('admin.packages.index')
                ->with('error', 'Cannot delete package with existing orders.');
        }

        $package->features()->detach();
        $package->delete();

        return redirect()
            ->route('admin.packages.index')
            ->with('success', 'Package deleted successfully!');
    }

    public function toggleActive(Package $package): RedirectResponse
    {
        $package->update(['is_active' => !$package->is_active]);

        return redirect()
            ->route('admin.packages.index')
            ->with('success', 'Package status updated!');
    }
}
