<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PragmaRX\Google2FALaravel\Support\Authenticator;
use Illuminate\Support\Facades\Auth;
use PragmaRX\Google2FA\Google2FA;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;

class SecurityController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $google2fa = new Google2FA();
        
        $qrCode = null;
        if (!$user->google2fa_secret) {
            $user->google2fa_secret = $google2fa->generateSecretKey();
            $user->save();
        }

        $qrCodeUrl = $google2fa->getQRCodeUrl(
            config('app.name'),
            $user->email,
            $user->google2fa_secret
        );

        $renderer = new ImageRenderer(
            new RendererStyle(200),
            new SvgImageBackEnd()
        );
        $writer = new Writer($renderer);
        $qrCode = $writer->writeString($qrCodeUrl);

        return view('admin.security.index', [
            'user' => $user,
            'qrCode' => $qrCode,
            'secret' => $user->google2fa_secret
        ]);
    }

    public function enable(Request $request)
    {
        $user = Auth::user();
        $google2fa = new Google2FA();
        
        $secret = $request->input('secret');
        $valid = $google2fa->verifyKey($user->google2fa_secret, $secret);

        if ($valid) {
            $user->google2fa_enabled = true;
            $user->save();
            return redirect()->back()->with('success', '2FA enabled successfully!');
        }

        return redirect()->back()->with('error', 'Invalid 2FA code. Please try again.');
    }

    public function disable(Request $request)
    {
        $user = Auth::user();
        $user->google2fa_enabled = false;
        $user->google2fa_secret = null; // Reset secret
        $user->save();
        
        return redirect()->back()->with('success', '2FA disabled successfully.');
    }
}
