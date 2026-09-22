<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Support\AdminModules;

class StaffController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('is_admin', true);

        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('designation', 'like', "%{$search}%");
            });
        }

        if ($request->filled('role')) {
            if ($request->role === 'super') {
                $query->whereNull('admin_modules');
            } elseif ($request->role === 'staff') {
                $query->whereNotNull('admin_modules');
            }
        }

        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        $staff = $query->latest()->paginate(15)->withQueryString();

        $stats = [
            'total' => User::where('is_admin', true)->count(),
            'active' => User::where('is_admin', true)->where('is_active', true)->count(),
            'super' => User::where('is_admin', true)->whereNull('admin_modules')->count(),
            'staff_only' => User::where('is_admin', true)->whereNotNull('admin_modules')->count(),
            'inactive' => User::where('is_admin', true)->where('is_active', false)->count(),
        ];

        $staffPortalUrl = route('staff.portal.login');

        return view('admin.staff.index', compact('staff', 'stats', 'staffPortalUrl'));
    }

    public function create()
    {
        $modules = AdminModules::all();
        return view('admin.staff.create', compact('modules'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'designation' => 'nullable|string|max:255',
            'is_active' => 'boolean',
            'is_super_admin' => 'boolean',
            'admin_modules' => 'nullable|array',
            'admin_modules.*' => 'string',
        ]);

        $user = new User();
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->password = Hash::make($validated['password']);
        $user->designation = $validated['designation'] ?? null;
        $user->is_admin = true;
        $user->is_active = $request->boolean('is_active', true);
        
        if ($request->boolean('is_super_admin')) {
            $user->admin_modules = null;
        } else {
            $user->admin_modules = $validated['admin_modules'] ?? [];
        }

        $user->save();

        return redirect()->route('admin.staff.index')->with('success', 'Staff member created successfully.');
    }

    public function edit(User $staff)
    {
        if (!$staff->isAdmin()) {
            abort(404);
        }
        $modules = AdminModules::all();
        return view('admin.staff.edit', compact('staff', 'modules'));
    }

    public function update(Request $request, User $staff)
    {
        if (!$staff->isAdmin()) {
            abort(404);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($staff->id)],
            'password' => 'nullable|string|min:8',
            'designation' => 'nullable|string|max:255',
            'is_active' => 'boolean',
            'is_super_admin' => 'boolean',
            'admin_modules' => 'nullable|array',
            'admin_modules.*' => 'string',
        ]);

        $staff->name = $validated['name'];
        $staff->email = $validated['email'];
        if (!empty($validated['password'])) {
            $staff->password = Hash::make($validated['password']);
        }
        $staff->designation = $validated['designation'] ?? null;
        $staff->is_active = $request->boolean('is_active', true);
        
        if ($request->boolean('is_super_admin')) {
            $staff->admin_modules = null;
        } else {
            $staff->admin_modules = $validated['admin_modules'] ?? [];
        }

        $staff->save();

        return redirect()->route('admin.staff.index')->with('success', 'Staff member updated successfully.');
    }

    public function destroy(User $staff)
    {
        if (!$staff->isAdmin() || $staff->id === auth()->id()) {
            return back()->with('error', 'Cannot delete this user.');
        }

        $staff->delete();
        return redirect()->route('admin.staff.index')->with('success', 'Staff member deleted successfully.');
    }
}
