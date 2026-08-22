<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password as PasswordFacade;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;

use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{


    public function showForgotPassword(): View
    {
        return view('auth.forgot-password');
    }

    public function sendResetLink(Request $request): RedirectResponse
    {
        $request->validate(['email' => 'required|email']);

        try {
            $status = PasswordFacade::sendResetLink(
                $request->only('email')
            );

            if ($status === PasswordFacade::RESET_THROTTLED) {
                return back()->withErrors([
                    'email' => __('Please wait a few seconds before requesting another reset link.')
                ])->onlyInput('email');
            }

            // Industry standard: Always return clean, positive confirmation (prevents email enumeration and gives smooth UX)
            return back()->with('status', __("If an account exists for this email address, you will receive a password reset link within a few minutes. Please check your Inbox and Spam folder."));
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::warning('Password reset notification caught error: ' . $e->getMessage());

            // Graceful industry standard fallback
            return back()->with('status', __("If an account exists for this email address, you will receive a password reset link within a few minutes. Please check your Inbox and Spam folder."));
        }
    }

    public function showResetPassword(Request $request, string $token): View
    {
        return view('auth.reset-password', ['token' => $token, 'email' => $request->email]);
    }

    public function resetPassword(Request $request): RedirectResponse
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        try {
            $status = PasswordFacade::reset(
                $request->only('email', 'password', 'password_confirmation', 'token'),
                function ($user, $password) {
                    $user->forceFill([
                        'password' => Hash::make($password)
                    ])->setRememberToken(Str::random(60));

                    $user->save();

                    event(new PasswordReset($user));
                }
            );

            return $status === PasswordFacade::PASSWORD_RESET
                        ? redirect()->route('login')->with('success', __($status))
                        : back()->withErrors(['email' => __($status)]);
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Password reset update error: ' . $e->getMessage());

            return back()->withErrors([
                'email' => 'Password reset error: ' . $e->getMessage()
            ])->onlyInput('email');
        }
    }

    public function showLogin(): View
    {
        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::validate($credentials)) {
            $user = User::where('email', $credentials['email'])->first();

            if ($user->google2fa_enabled) {
                session()->put([
                    '2fa_user_id' => $user->id,
                    '2fa_remember' => $request->boolean('remember'),
                ]);

                return redirect()->route('2fa.show');
            }

            Auth::login($user, $request->boolean('remember'));
            $request->session()->regenerate();

            // Update last login
            $user->update(['last_login_at' => now()]);

            app(\App\Services\AffiliateService::class)->ensureAffiliateSetup($user);

            // Redirect admin to first allowed admin section
            if ($user->isAdmin()) {
                $routeName = $user->defaultAdminRouteName();

                if ($routeName) {
                    return redirect()->intended(route($routeName));
                }

                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()->route('login')->with('error', 'Your admin account has no module access assigned.');
            }

            return redirect()->intended(route('home'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function showRegister(): View
    {
        return view('auth.register');
    }

    public function register(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'phone' => 'nullable|string|max:50',
            'country' => 'nullable|string|max:100',
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'country' => $validated['country'] ?? null,
            'password' => Hash::make($validated['password']),
        ]);

        // Create affiliate account for new user
        $affiliateService = app(\App\Services\AffiliateService::class);
        $affiliateService->ensureAffiliateSetup($user);

        Auth::login($user);

        return redirect()
            ->route('home')
            ->with('success', 'Account created successfully!');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }

    public function showProfile(): View
    {
        $user = Auth::user();
        $orders = $user->orders()->with('package')->latest()->get();
        
        // Create affiliate account if doesn't exist and apply referral cookie
        $affiliateService = app(\App\Services\AffiliateService::class);
        $affiliate = $affiliateService->ensureAffiliateSetup($user);
        $stats = $affiliateService->getAffiliateStats($affiliate);

        return view('auth.profile', compact('user', 'orders', 'affiliate', 'stats'));
    }

    public function updateProfile(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:50',
            'country' => 'nullable|string|max:100',
        ]);

        $user->update($validated);

        return redirect()
            ->route('profile')
            ->with('success', 'Profile updated successfully!');
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'current_password' => 'required|current_password',
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        Auth::user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()
            ->route('profile')
            ->with('success', 'Password changed successfully!');
    }
}
