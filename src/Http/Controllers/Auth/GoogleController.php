<?php

namespace Udara\LaravelAuth\Http\Controllers\Auth;

use Udara\LaravelAuth\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Exception;
use Spatie\Permission\Models\Role;
use Udara\LaravelAuth\Models\Setting;
use Illuminate\Support\Facades\Mail;
use Udara\LaravelAuth\Mail\WelcomeMail;

class GoogleController extends Controller
{
    /**
     * Redirect the user to the Google authentication page.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from Google.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleGoogleCallback()
    {
        try {
            /** @var \Laravel\Socialite\Two\User $user */
            $user = Socialite::driver('google')->user();

            $userModel = $this->getUserModel();
            $findUser = $userModel::where('google_id', $user->getId())
                ->orWhere('email', $user->getEmail())
                ->first();

            if ($findUser) {
                if (!$findUser->google_id) {
                    $findUser->update(['google_id' => $user->getId()]);
                }
                $setting = Setting::latest()->first();

                if ($setting && $setting->admin_approvel_for_new_user == 1 && $findUser->email_verified_at == null) {
                    return redirect('/login')->with('error', 'User not approved.');
                }

                Auth::login($findUser);
                return redirect()->intended('dashboard');
            } else {
                $newUser = $userModel::updateOrCreate(['email' => $user->getEmail()], [
                    'name' => $user->getName(),
                    'google_id' => $user->getId(),
                    'password' => bcrypt(str()->random(16)), // Random secure password
                    'email_verified_at' => now()
                ]);

                $defaultRole = 'user';
                $role = Role::firstOrCreate(['name' => $defaultRole]);
                $newUser->assignRole($role);

                Mail::to($newUser->email)->send(new WelcomeMail($newUser));

                Auth::login($newUser);
                return redirect()->intended('dashboard');
            }
        } catch (Exception $e) {
            return redirect('login')->with('danger', 'Something went wrong: ' . $e->getMessage());
        }
    }
}
