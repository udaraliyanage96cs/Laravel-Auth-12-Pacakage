<?php

namespace Udara\LaravelAuth\Http\Controllers\Auth;

use Udara\LaravelAuth\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Udara\LaravelAuth\Models\Setting;

class EmailVerificationPromptController extends Controller
{
    /**
     * Display the email verification prompt.
     */
    public function __invoke(Request $request): RedirectResponse|View
    {
        $setting = Setting::latest()->first();
        return $request->user()->hasVerifiedEmail()
            ? redirect()->intended(route('dashboard', absolute: false))
            : view('auth.verify-email', compact('setting'));
    }
}
