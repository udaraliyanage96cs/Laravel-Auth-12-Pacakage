<?php

namespace Udara\LaravelAuth\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Udara\LaravelAuth\Models\Setting;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class CheckForgotPasswordEnabled
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $setting = Setting::latest()->first();
        if ($setting && !$setting->forgot_password_enable) {
            throw new AccessDeniedHttpException('Forgot Password is disabled.');
        }
        return $next($request);
    }
}
