<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Support\AdminModules;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request): View
    {
        $query = User::withCount('orders');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('role')) {
            $query->where('is_admin', $request->role === 'admin');
        }

        $users = $query->latest()->paginate(20);

        return view('admin.users.index', compact('users'));
    }

    public function show(User $user): View
    {
        $user->load(['orders.package']);
        return view('admin.users.show', compact('user'));
    }

    public function create(): View
    {
        return view('admin.users.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:50',
            'country' => 'nullable|string|max:100',
            'is_admin' => 'boolean',
            'admin_modules' => ['nullable', 'array'],
            'admin_modules.*' => [Rule::in(AdminModules::keys())],
        ]);

        $isAdmin = $request->boolean('is_admin');
        $validated['password'] = Hash::make($validated['password']);
        $validated['is_admin'] = auth()->user()->isSuperAdmin() ? $isAdmin : false;
        $validated['admin_modules'] = auth()->user()->isSuperAdmin()
            ? $this->resolveAdminModules($request, $isAdmin)
            : null;

        User::create($validated);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User created successfully!');
    }

    public function edit(User $user): View
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:50',
            'country' => 'nullable|string|max:100',
            'is_admin' => 'boolean',
            'admin_modules' => ['nullable', 'array'],
            'admin_modules.*' => [Rule::in(AdminModules::keys())],
        ]);

        $isAdmin = $request->boolean('is_admin');
        if (auth()->user()->isSuperAdmin()) {
            $validated['is_admin'] = $isAdmin;
            $validated['admin_modules'] = $this->resolveAdminModules($request, $isAdmin, $user);
        } else {
            unset($validated['is_admin'], $validated['admin_modules']);
        }

        $user->update($validated);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User updated successfully!');
    }

    /**
     * @return array<int, string>|null
     */
    private function resolveAdminModules(Request $request, bool $isAdmin, ?User $user = null): ?array
    {
        if (!$isAdmin) {
            return null;
        }

        if (!auth()->user()->isSuperAdmin()) {
            return $user?->admin_modules;
        }

        if ($user?->hasFullAdminAccess() && !$request->has('admin_modules')) {
            return null;
        }

        $modules = array_values(array_unique($request->input('admin_modules', [])));

        if (empty($modules)) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'admin_modules' => 'Select at least one admin module for this user.',
            ]);
        }

        if (count($modules) === count(AdminModules::keys())) {
            return null;
        }

        return $modules;
    }

    public function resetPassword(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()
            ->route('admin.users.show', $user)
            ->with('success', 'Password reset successfully!');
    }

    public function destroy(User $user): RedirectResponse
    {
        if ($user->id === auth()->id()) {
            return redirect()
                ->route('admin.users.index')
                ->with('error', 'You cannot delete your own account.');
        }

        if ($user->orders()->exists()) {
            return redirect()
                ->route('admin.users.index')
                ->with('error', 'Cannot delete user with existing orders.');
        }

        $user->delete();

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User deleted successfully!');
    }

    public function updateCommissionRate(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'custom_commission_rate' => 'nullable|numeric|min:0|max:100',
        ]);

        // Create affiliate account if it doesn't exist
        if (!$user->affiliate) {
            $user->createAffiliateAccount();
        }

        // Update the custom commission rate
        $user->affiliate->update([
            'custom_commission_rate' => $validated['custom_commission_rate'],
        ]);

        $message = $validated['custom_commission_rate'] 
            ? "Commission rate set to {$validated['custom_commission_rate']}% for {$user->name}"
            : "Commission rate reset to default for {$user->name}";

        return redirect()
            ->route('admin.users.show', $user)
            ->with('success', $message);
    }
}
