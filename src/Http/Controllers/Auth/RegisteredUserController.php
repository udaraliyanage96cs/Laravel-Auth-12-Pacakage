<?php

namespace Udara\LaravelAuth\Http\Controllers\Auth;

use Udara\LaravelAuth\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;
use Udara\LaravelAuth\Models\Setting;
use Illuminate\Support\Facades\Mail;
use Udara\LaravelAuth\Mail\UserOnPending;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;
use Udara\LaravelAuth\Models\ActivityLog;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $setting = Setting::latest()->first();
        return view('auth.register', compact('setting'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $setting = Setting::latest()->first();

        if ($setting && $setting->enable_recaptcha == 1) {
            $request->validate([
                'g-recaptcha-response' => 'required|string',
            ]);

            $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                'secret' => $setting->recaptcha_secret_key,
                'response' => $request->input('g-recaptcha-response'),
                'remoteip' => request()->ip(),
            ]);

            $result = $response->json();

            if (!$result || empty($result['success'])) {
                throw ValidationException::withMessages([
                    'g-recaptcha-response' => ['reCAPTCHA verification failed. Please try again.']
                ]);
            }
        }

        $userModel = $this->getUserModel();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . $userModel],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $avatars = [
            'avt1.png', 'avt2.png', 'avt3.png', 'avt4.png', 'avt5.png',
            'avt6.png', 'avt7.png', 'avt8.png', 'avt9.png', 'avt10.png',
        ];

        $randomAvatar = $avatars[array_rand($avatars)];

        try {
            DB::beginTransaction();

            $user = $userModel::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'profile_picture' => $randomAvatar,
                'email_verified_at' => null,
            ]);

            $defaultRole = 'user';
            $role = Role::firstOrCreate(['name' => $defaultRole]);
            $user->assignRole($role);

            event(new Registered($user));

            ActivityLog::create([
                'user_id' => $user->id,
                'action' => 'created',
                'description' => "User has been created",
                'model_type' => get_class($user),
                'model_id' => $user->id
            ]);

            if ($setting && $setting->admin_approvel_for_new_user == 0) {
                DB::commit();
                return redirect()->route('login')->with('status', 'Registration successful. Please check your email inbox to verify your account.');
            } else {
                Mail::to($user->email)->send(new UserOnPending($user));
                DB::commit();
                return redirect('/on-pending');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Something went wrong. Please try again.');
        }
    }
}
