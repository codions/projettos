<?php

namespace App\Http\Middleware;

use App\Settings\GeneralSettings;
use Closure;
use Illuminate\Http\Request;

class PasswordProtected
{
    public function handle(Request $request, Closure $next)
    {
        if (
            app(GeneralSettings::class)->password &&
            ! session('password-login-authorized') &&
            $request->route()->getName() !== 'password.protection' &&
            $request->route()->getName() !== 'password.protection.login'
        ) {
            if ($request->input('secret') === app(GeneralSettings::class)->password) {
                session()->put('password-login-authorized', true);

                return $next($request);
            }

            return redirect()->route('password.protection');
        }

        return $next($request);
    }
}
