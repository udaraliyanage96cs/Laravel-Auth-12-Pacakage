<?php

namespace Udara\LaravelAuth\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Udara\LaravelAuth\Models\Setting;

class ForcePasswordChange
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();
            $setting = Setting::latest()->first();

            // Check if force password change setting is enabled and user needs password change
            if ($setting && $setting->force_password_change && isset($user->needs_password_change) && $user->needs_password_change) {
                // Do not redirect if already on the password change routes or logging out
                if (!$request->routeIs('password.change') && !$request->routeIs('password.change.update') && !$request->routeIs('logout')) {
                    return redirect()->route('password.change')->with('warning', __('For security reasons, you must change your default password before proceeding.'));
                }
            }
        }

        return $next($request);
    }
}
