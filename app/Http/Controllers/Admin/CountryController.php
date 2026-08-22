<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class CountryController extends Controller
{
    public function index(): View
    {
        $countries = Country::orderBy('sort_order')
            ->orderBy('name')
            ->paginate(30);

        return view('admin.countries.index', compact('countries'));
    }

    public function create(): View
    {
        return view('admin.countries.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:3|unique:countries',
            'flag' => 'nullable|string|max:255',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        Country::create($validated);

        return redirect()
            ->route('admin.countries.index')
            ->with('success', 'Country added successfully!');
    }

    public function edit(Country $country): View
    {
        return view('admin.countries.edit', compact('country'));
    }

    public function update(Request $request, Country $country): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:3|unique:countries,code,' . $country->id,
            'flag' => 'nullable|string|max:255',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        $country->update($validated);

        return redirect()
            ->route('admin.countries.index')
            ->with('success', 'Country updated successfully!');
    }

    public function destroy(Country $country): RedirectResponse
    {
        if ($country->orders()->exists()) {
            return redirect()
                ->route('admin.countries.index')
                ->with('error', 'Cannot delete country with existing orders.');
        }

        $country->delete();

        return redirect()
            ->route('admin.countries.index')
            ->with('success', 'Country deleted successfully!');
    }

    public function toggleActive(Country $country): RedirectResponse
    {
        $country->update(['is_active' => !$country->is_active]);

        return redirect()
            ->route('admin.countries.index')
            ->with('success', 'Country status updated!');
    }
}
