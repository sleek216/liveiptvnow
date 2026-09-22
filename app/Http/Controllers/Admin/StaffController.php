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
    public function index()
    {
        $staff = User::where('is_admin', true)->latest()->paginate(15);
        return view('admin.staff.index', compact('staff'));
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
