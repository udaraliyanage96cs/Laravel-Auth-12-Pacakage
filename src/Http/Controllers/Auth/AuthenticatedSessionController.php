<?php

namespace Udara\LaravelAuth\Http\Controllers\Auth;

use Udara\LaravelAuth\Http\Controllers\Controller;
use Udara\LaravelAuth\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use Udara\LaravelAuth\Models\Setting;
use Udara\LaravelAuth\Models\OtpToken;
use Udara\LaravelAuth\Models\ActivityLog;
use Udara\LaravelAuth\Mail\OtpMail;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        $setting = Setting::latest()->first();
        return view('auth.login', compact('setting'));
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        if (session()->has('mfa_user_id')) {
            return redirect()->route('login.otp');
        }

        $request->session()->regenerate();

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Show the OTP input form.
     */
    public function showOtpForm(): View|RedirectResponse
    {
        if (!session()->has('mfa_user_id')) {
            return redirect()->route('login');
        }

        $userId = session('mfa_user_id');

        if (Cache::has('otp_verify_blocked:' . $userId)) {
            $blockedUntil = Cache::get('otp_verify_blocked:' . $userId);
            $seconds = $blockedUntil - time();
            if ($seconds > 0) {
                $minutes = ceil($seconds / 60);
                session()->forget(['mfa_user_id', 'mfa_remember']);
                return redirect()->route('login')->with('error', __('Too many invalid OTP attempts. Your account is temporarily blocked from OTP verification for :minutes minutes.', ['minutes' => $minutes]));
            } else {
                Cache::forget('otp_verify_blocked:' . $userId);
            }
        }

        return view('auth.otp');
    }

    /**
     * Verify the user's OTP code.
     */
    public function verifyOtp(Request $request): RedirectResponse
    {
        if (!session()->has('mfa_user_id')) {
            return redirect()->route('login');
        }

        $userId = session('mfa_user_id');

        if (Cache::has('otp_verify_blocked:' . $userId)) {
            $blockedUntil = Cache::get('otp_verify_blocked:' . $userId);
            $seconds = $blockedUntil - time();
            if ($seconds > 0) {
                $minutes = ceil($seconds / 60);
                session()->forget(['mfa_user_id', 'mfa_remember']);
                return redirect()->route('login')->with('error', __('Too many invalid OTP attempts. Your account is temporarily blocked from OTP verification for :minutes minutes.', ['minutes' => $minutes]));
            } else {
                Cache::forget('otp_verify_blocked:' . $userId);
            }
        }

        $request->validate([
            'otp' => 'required|string|size:6',
        ]);

        $otpToken = OtpToken::where('user_id', $userId)->first();

        if (!$otpToken || $otpToken->isExpired()) {
            if ($otpToken) {
                $otpToken->delete();
            }
            return redirect()->back()->with('error', __('The verification code has expired. Please request a new one.'));
        }

        if (!Hash::check($request->input('otp'), $otpToken->otp)) {
            $attempts = Cache::get('otp_attempts:' . $userId, 0) + 1;
            Cache::put('otp_attempts:' . $userId, $attempts, now()->addMinutes(30));

            if ($attempts >= 5) {
                $otpToken->delete();
                Cache::put('otp_verify_blocked:' . $userId, time() + 1800, now()->addMinutes(30));
                Cache::forget('otp_attempts:' . $userId);
                session()->forget(['mfa_user_id', 'mfa_remember']);

                return redirect()->route('login')->with('error', __('Too many invalid OTP attempts. Your account is temporarily blocked from OTP verification for 30 minutes.'));
            }

            $remaining = 5 - $attempts;
            return redirect()->back()->withErrors(['otp' => __('The verification code is incorrect. You have :count attempt(s) remaining.', ['count' => $remaining])]);
        }

        $userModel = $this->getUserModel();
        $user = $userModel::find($userId);
        if (!$user) {
            return redirect()->route('login')->with('error', __('User not found.'));
        }

        $remember = session('mfa_remember', false);
        if ($remember) {
            Auth::guard('web')->setRememberDuration(10080);
        }

        Auth::login($user, $remember);

        // Delete used token
        $otpToken->delete();

        // Clear MFA session keys and attempts
        Cache::forget('otp_attempts:' . $userId);
        session()->forget(['mfa_user_id', 'mfa_remember']);

        // Log activity
        ActivityLog::create([
            'user_id' => $user->id,
            'action' => 'login',
            'description' => "User has logged in with MFA verification",
            'model_type' => get_class($user),
            'model_id' => $user->id
        ]);

        $request->session()->regenerate();

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Resend a new OTP code.
     */
    public function resendOtp(Request $request): RedirectResponse
    {
        if (!session()->has('mfa_user_id')) {
            return redirect()->route('login');
        }

        $userId = session('mfa_user_id');
        $userModel = $this->getUserModel();
        $user = $userModel::find($userId);

        if (!$user) {
            return redirect()->route('login')->with('error', __('User not found.'));
        }

        // Check if user is blocked from verification
        if (Cache::has('otp_verify_blocked:' . $userId)) {
            $blockedUntil = Cache::get('otp_verify_blocked:' . $userId);
            $seconds = $blockedUntil - time();
            if ($seconds > 0) {
                $minutes = ceil($seconds / 60);
                session()->forget(['mfa_user_id', 'mfa_remember']);
                return redirect()->route('login')->with('error', __('Too many invalid OTP attempts. Your account is temporarily blocked from OTP verification for :minutes minutes.', ['minutes' => $minutes]));
            }
        }

        // Check 60-second cooldown between resends
        if (Cache::has('otp_last_sent:' . $user->email)) {
            $lastSent = Cache::get('otp_last_sent:' . $user->email);
            $secondsRemaining = 60 - (time() - $lastSent);
            if ($secondsRemaining > 0) {
                return redirect()->back()->with('error', __('Please wait :seconds seconds before requesting a new verification code.', ['seconds' => $secondsRemaining]));
            }
        }

        // Check if OTP requests are blocked
        if (Cache::has('otp_blocked:' . $user->email)) {
            $blockedUntil = Cache::get('otp_blocked:' . $user->email);
            $seconds = $blockedUntil - time();
            if ($seconds > 0) {
                $minutes = ceil($seconds / 60);
                return redirect()->back()->with('error', __('You are blocked from requesting OTPs for another :minutes minutes.', ['minutes' => $minutes]));
            } else {
                Cache::forget('otp_blocked:' . $user->email);
            }
        }

        // Check count
        $otpCount = Cache::get('otp_requests:' . $user->email, 0);
        if ($otpCount >= 3) {
            Cache::put('otp_blocked:' . $user->email, time() + 1800, now()->addMinutes(30));
            Cache::forget('otp_requests:' . $user->email);
            return redirect()->back()->with('error', __('You have requested 3 OTPs and are now blocked from requesting new OTPs for 30 minutes.'));
        }

        // Generate OTP
        $otp = rand(100000, 999999);

        // Delete any existing OTP tokens for this user
        OtpToken::where('user_id', $user->id)->delete();

        // Create new OTP token in the DB
        OtpToken::create([
            'user_id' => $user->id,
            'otp' => bcrypt($otp),
            'expires_at' => now()->addMinutes(10),
        ]);

        // Increment count and record timestamp
        Cache::put('otp_requests:' . $user->email, $otpCount + 1, now()->addMinutes(30));
        Cache::put('otp_last_sent:' . $user->email, time(), now()->addSeconds(60));

        // Send OTP email
        Mail::to($user->email)->send(new OtpMail($user, $otp));

        return redirect()->back()->with('status', __('A new verification code has been sent to your email.'));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
