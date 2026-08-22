<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PragmaRX\Google2FA\Google2FA;

class TwoFactorController extends Controller
{
    public function showVerification(Request $request)
    {
        if (!session()->has('2fa_user_id')) {
            return redirect()->route('login');
        }

        return view('auth.2fa');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'one_time_password' => 'required',
        ]);

        $userId = session()->get('2fa_user_id');
        if (!$userId) {
            return redirect()->route('login');
        }

        $user = User::findOrFail($userId);
        $google2fa = new Google2FA();
        
        $valid = $google2fa->verifyKey($user->google2fa_secret, $request->one_time_password);

        if ($valid) {
            Auth::login($user, session()->get('2fa_remember', false));
            
            session()->forget(['2fa_user_id', '2fa_remember']);
            
            $user->update(['last_login_at' => now()]);

            app(\App\Services\AffiliateService::class)->ensureAffiliateSetup($user);

            if ($user->isAdmin()) {
                return redirect()->intended(route('admin.dashboard'));
            }

            return redirect()->intended(route('home'));
        }

        return back()->withErrors(['one_time_password' => 'The provided code is invalid.']);
    }
}
