<?php

namespace App\Support;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

final class RecaptchaVerifier
{
    public static function verify(Request $request): bool
    {
        if (!config('siduta.recaptcha.enabled')) {
            return true;
        }

        $token = trim((string) $request->input('g-recaptcha-response', ''));
        $secret = (string) config('siduta.recaptcha.secret_key', '');
        if ($token === '' || $secret === '') {
            return false;
        }

        try {
            $resp = Http::asForm()->timeout(5)->post('https://www.google.com/recaptcha/api/siteverify', [
                'secret' => $secret,
                'response' => $token,
                'remoteip' => $request->ip(),
            ]);
            return (bool) data_get($resp->json(), 'success', false);
        } catch (\Throwable) {
            return false;
        }
    }
}
