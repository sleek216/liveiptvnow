<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class StaffPortalAuthController extends Controller
{
    /**
     * Show dedicated Staff Portal login form.
     */
    public function showLogin(): View|RedirectResponse
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->isAdmin()) {
                if (!$user->isActive()) {
                    Auth::logout();
                    return redirect()->route('staff.portal.login')->with('error', 'Your staff account has been deactivated. Please contact your Super Administrator.');
                }

                $routeName = $user->defaultAdminRouteName() ?: 'admin.dashboard';
                return redirect()->route($routeName);
            }

            Auth::logout();
        }

        return view('admin.auth.staff-login');
    }

    /**
     * Handle Staff Portal login submission.
     */
    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return back()->withErrors([
                'email' => 'The provided staff credentials do not match our records.',
            ])->onlyInput('email');
        }

        if (!$user->isAdmin()) {
            return back()->withErrors([
                'email' => 'Access denied. This portal is exclusively for authorized staff and employees.',
            ])->onlyInput('email');
        }

        if (!$user->isActive()) {
            return back()->withErrors([
                'email' => 'Your staff account has been deactivated. Please contact your Super Administrator.',
            ])->onlyInput('email');
        }

        // Support Two-Factor Authentication if enabled
        if ($user->google2fa_enabled) {
            session()->put([
                '2fa_user_id' => $user->id,
                '2fa_remember' => $request->boolean('remember'),
            ]);

            return redirect()->route('2fa.show');
        }

        Auth::login($user, $request->boolean('remember'));
        $request->session()->regenerate();
        $user->update(['last_login_at' => now()]);

        $routeName = $user->defaultAdminRouteName();
        if ($routeName) {
            return redirect()->intended(route($routeName));
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('staff.portal.login')->with('error', 'Your staff account has no active module permissions assigned.');
    }
}
