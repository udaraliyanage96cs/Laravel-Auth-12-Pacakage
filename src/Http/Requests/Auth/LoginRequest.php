<?php

namespace Udara\LaravelAuth\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Udara\LaravelAuth\Models\Setting;
use Udara\LaravelAuth\Models\OtpToken;
use Udara\LaravelAuth\Models\ActivityLog;
use Udara\LaravelAuth\Mail\OtpMail;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        $setting = Setting::latest()->first();

        if ($setting && $setting->enable_recaptcha == 1) {
            $this->validate([
                'g-recaptcha-response' => 'required|string',
            ]);

            $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                'secret' => $setting->recaptcha_secret_key,
                'response' => $this->input('g-recaptcha-response'),
                'remoteip' => request()->ip(),
            ]);

            $result = $response->json();

            if (!$result || empty($result['success'])) {
                throw ValidationException::withMessages([
                    'g-recaptcha-response' => ['reCAPTCHA verification failed. Please try again.']
                ]);
            }
        }

        $credentials = $this->only('email', 'password');

        if (! Auth::validate($credentials)) {
            $attempts = Cache::get('login_attempts:' . $this->throttleKey(), 0) + 1;
            Cache::put('login_attempts:' . $this->throttleKey(), $attempts, now()->addMinutes(30));

            if ($attempts >= 3) {
                Cache::put('login_blocked:' . $this->throttleKey(), time() + 1800, now()->addMinutes(30));
                Cache::forget('login_attempts:' . $this->throttleKey());

                throw ValidationException::withMessages([
                    'email' => __('Too many incorrect password attempts. Your account/IP is blocked for 30 minutes.'),
                ]);
            }

            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }

        $userModel = config('laravel-auth.user_model', config('auth.providers.users.model', \App\Models\User::class));
        $user = $userModel::where('email', $this->email)->first();

        if (!$user) {
            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }

        if (empty($user->email_verified_at)) {
            if ($setting && $setting->admin_approvel_for_new_user == 1) {
                throw ValidationException::withMessages([
                    'email' => __('Your account is currently under review or temporarily unavailable. Please contact the admin for further assistance.'),
                ]);
            } else {
                throw ValidationException::withMessages([
                    'email' => __('Please verify your email address to log in.'),
                ]);
            }
        }

        if ($setting && $setting->mfa_enable == 1) {
            // Check if user is blocked due to too many invalid OTP verification attempts
            if (Cache::has('otp_verify_blocked:' . $user->id)) {
                $blockedUntil = Cache::get('otp_verify_blocked:' . $user->id);
                $seconds = $blockedUntil - time();
                if ($seconds > 0) {
                    $minutes = ceil($seconds / 60);
                    throw ValidationException::withMessages([
                        'email' => __('Too many invalid OTP attempts. Your account is temporarily blocked from OTP verification for :minutes minutes.', ['minutes' => $minutes]),
                    ]);
                } else {
                    Cache::forget('otp_verify_blocked:' . $user->id);
                }
            }

            // Check if OTP requests are blocked
            if (Cache::has('otp_blocked:' . $user->email)) {
                $blockedUntil = Cache::get('otp_blocked:' . $user->email);
                $seconds = $blockedUntil - time();
                if ($seconds > 0) {
                    $minutes = ceil($seconds / 60);
                    throw ValidationException::withMessages([
                        'email' => __('You have requested too many OTPs. You are blocked from requesting OTPs for :minutes minutes.', ['minutes' => $minutes]),
                    ]);
                } else {
                    Cache::forget('otp_blocked:' . $user->email);
                }
            }

            // Check if count already reached 3
            $otpCount = Cache::get('otp_requests:' . $user->email, 0);

            if ($otpCount >= 3) {
                Cache::put('otp_blocked:' . $user->email, time() + 1800, now()->addMinutes(30));
                Cache::forget('otp_requests:' . $user->email);
                throw ValidationException::withMessages([
                    'email' => __('You have requested 3 OTPs and are now blocked from requesting new OTPs for 30 minutes.'),
                ]);
            }

            // Generate OTP
            $otp = rand(100000, 999999);

            // Delete any existing OTP tokens for this user
            OtpToken::where('user_id', $user->id)->delete();

            // Store hashed OTP in database
            OtpToken::create([
                'user_id' => $user->id,
                'otp' => bcrypt($otp),
                'expires_at' => now()->addMinutes(10),
            ]);

            // Store verification details in session
            session([
                'mfa_user_id' => $user->id,
                'mfa_remember' => $this->boolean('remember'),
            ]);

            // Increment count and record timestamp
            Cache::put('otp_requests:' . $user->email, $otpCount + 1, now()->addMinutes(30));
            Cache::put('otp_last_sent:' . $user->email, time(), now()->addSeconds(60));

            // Send OTP email
            Mail::to($user->email)->send(new OtpMail($user, $otp));

            return;
        }

        // Standard Login (No MFA)
        if ($this->boolean('remember')) {
            Auth::guard('web')->setRememberDuration(10080);
        }
        Auth::login($user, $this->boolean('remember'));

        ActivityLog::create([
            'user_id' => $user->id,
            'action' => 'login',
            'description' => "User has been login",
            'model_type' => get_class($user),
            'model_id' => $user->id
        ]);

        Cache::forget('login_attempts:' . $this->throttleKey());
        Cache::forget('login_blocked:' . $this->throttleKey());
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (Cache::has('login_blocked:' . $this->throttleKey())) {
            $blockedUntil = Cache::get('login_blocked:' . $this->throttleKey());
            $seconds = $blockedUntil - time();

            if ($seconds > 0) {
                $minutes = ceil($seconds / 60);
                throw ValidationException::withMessages([
                    'email' => __('Too many incorrect password attempts. Your account/IP is blocked for :minutes minutes.', ['minutes' => $minutes]),
                ]);
            } else {
                Cache::forget('login_blocked:' . $this->throttleKey());
            }
        }
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->string('email')).'|'.$this->ip());
    }
}
