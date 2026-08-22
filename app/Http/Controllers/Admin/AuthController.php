<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLogin(): View|RedirectResponse
    {
        if (Auth::check()) {
            if (Auth::user()->isAdmin()) {
                $routeName = Auth::user()->defaultAdminRouteName() ?: 'admin.dashboard';
                return redirect()->route($routeName);
            }

            // If non-admin is already logged in, logout or redirect to home
            Auth::logout();
        }

        return view('admin.auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::validate($credentials)) {
            $user = User::where('email', $credentials['email'])->first();

            // Strict security check: User must be an Administrator
            if (!$user || !$user->isAdmin()) {
                return back()->withErrors([
                    'email' => 'Access denied. You do not have administrator privileges.',
                ])->onlyInput('email');
            }

            // Check 2FA
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

            return redirect()->route('admin.login')->with('error', 'Your admin account has no module access assigned.');
        }

        return back()->withErrors([
            'email' => 'The provided administrator credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
