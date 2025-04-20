<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use PragmaRX\Google2FA\Google2FA;
use Illuminate\Support\Str;

class TwoFactorController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        $google2fa = new Google2FA();
        if (!$user->two_factor_secret) {
            $secret = $google2fa->generateSecretKey();
            $user->two_factor_secret = Crypt::encryptString($secret);
            $user->save();
        } else {
            $secret = Crypt::decryptString($user->two_factor_secret);
        }
        $QR_Image = $google2fa->getQRCodeInline(
            config('app.name'),
            $user->email,
            $secret
        );
        return view('seguranca.2fa', compact('user', 'secret', 'QR_Image'));
    }

    public function enable(Request $request)
    {
        $request->validate(['code' => 'required|digits:6']);
        $user = Auth::user();
        $google2fa = new Google2FA();
        $secret = Crypt::decryptString($user->two_factor_secret);
        if ($google2fa->verifyKey($secret, $request->code)) {
            $user->two_factor_enabled = true;
            $user->save();
            return redirect()->route('configuracoes')->with('success', '2FA ativada com sucesso!');
        }
        return back()->withErrors(['code' => 'Código inválido.']);
    }

    public function disable()
    {
        $user = Auth::user();
        $user->two_factor_enabled = false;
        $user->two_factor_secret = null;
        $user->save();
        return redirect()->route('configuracoes')->with('success', '2FA desativada.');
    }
}
