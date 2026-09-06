<?php

namespace Udara\LaravelAuth\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Udara\LaravelAuth\Models\Setting;
use Spatie\Permission\Models\Role;

class SettingController extends Controller
{
    public function index(Request $req)
    {
        $setting = Setting::latest()->first();
        return view('settings.index', compact('setting'));
    }

    public function store(Request $req)
    {
        $req->validate([
            'site_name' => 'required|string|max:255',
        ]);

        $setting = Setting::latest()->first();
        if ($setting) {
            $setting->update([
                'site_name' => $req->input('site_name'),
            ]);
        }

        $siteName = $req->input('site_name');
        $envPath = base_path('.env');
        if (File::exists($envPath)) {
            $envContent = File::get($envPath);
            $envContent = preg_replace('/^APP_NAME=.*/m', "APP_NAME=\"$siteName\"", $envContent);
            File::put($envPath, $envContent);
        }

        return redirect()->back()->with('success', 'Settings updated successfully');
    }

    public function themeSettings(Request $request)
    {
        $request->validate([
            'navColor' => 'required|string|regex:/^#[0-9A-Fa-f]{6}$/'
        ]);

        $color = $request->input('navColor');
        $cssPath = public_path('/assets/css/demo.css');

        if (File::exists($cssPath)) {
            $cssContent = File::get($cssPath);
            $cssContent = preg_replace('/\.menu-vertical\s*{[^}]*background-color:\s*#[0-9A-Fa-f]{6}[^}]*}/', '', $cssContent);
            $newCssRule = "\n.menu-vertical { background-color: $color !important; }";
            $cssContent .= $newCssRule;
            File::put($cssPath, $cssContent);
            return redirect()->back()->with('success', 'Menu color updated successfully!');
        }

        return redirect()->back()->with('danger', 'CSS file not found!');
    }

    public function moduleSettings(Request $request)
    {
        $request->validate([
            'self_registration' => 'required|boolean',
            'forgot_password' => 'required|boolean',
            'admin_approvel_for_new_user' => 'required|boolean',
            'delete_own_profile' => 'required|boolean',
            'restore_users' => 'required|boolean',
            'mfa_enable' => 'required|boolean',
        ]);

        $setting = Setting::latest()->first();

        if ($setting) {
            $setting->update([
                'self_registration_enable' => $request->input('self_registration'),
                'forgot_password_enable' => $request->input('forgot_password'),
                'admin_approvel_for_new_user' => $request->input('admin_approvel_for_new_user'),
                'delete_own_profile' => $request->input('delete_own_profile'),
                'restore_users' => $request->input('restore_users'),
                'mfa_enable' => $request->input('mfa_enable'),
            ]);

            if ($request->input('restore_users') == 0) {
                $roles = Role::all();
                foreach ($roles as $role) {
                    $role->revokePermissionTo('restore_user_management');
                }
            }
            return redirect()->back()->with('success', 'Module settings updated successfully!');
        } else {
            return redirect()->back()->with('danger', 'Settings not found!');
        }
    }

    public function authSettings(Request $request)
    {
        $request->validate([
            'enable_recaptcha' => 'required|boolean',
            'recaptcha_site_key' => 'required_if:enable_recaptcha,1|nullable|string',
            'recaptcha_secret_key' => 'required_if:enable_recaptcha,1|nullable|string',
            'force_password_change' => 'required|boolean',
        ]);

        $setting = Setting::latest()->first();

        if ($setting) {
            $setting->update([
                'enable_recaptcha' => $request->input('enable_recaptcha'),
                'recaptcha_site_key' => $request->input('recaptcha_site_key'),
                'recaptcha_secret_key' => $request->input('recaptcha_secret_key'),
                'force_password_change' => $request->input('force_password_change'),
            ]);
            return redirect()->back()->with('success', 'Auth settings updated successfully!');
        } else {
            return redirect()->back()->with('danger', 'Settings not found!');
        }
    }

    public function googleSettings(Request $request)
    {
        $request->validate([
            'enable_google_login' => 'required|boolean',
            'google_client_id' => 'nullable|string',
            'google_client_secret' => 'nullable|string',
            'google_redirect_url' => 'nullable|string',
        ]);

        $setting = Setting::latest()->first();

        if ($setting) {
            $setting->update([
                'enable_google_login' => $request->input('enable_google_login'),
                'google_client_id' => $request->input('google_client_id'),
                'google_client_secret' => $request->input('google_client_secret'),
                'google_redirect_url' => $request->input('google_redirect_url'),
            ]);

            // Update .env file
            $envPath = base_path('.env');
            if (File::exists($envPath)) {
                $envContent = File::get($envPath);

                $envContent = $this->updateEnvVariable('GOOGLE_CLIENT_ID', $request->input('google_client_id'), $envContent);
                $envContent = $this->updateEnvVariable('GOOGLE_CLIENT_SECRET', $request->input('google_client_secret'), $envContent);
                $envContent = $this->updateEnvVariable('GOOGLE_REDIRECT_URI', $request->input('google_redirect_url'), $envContent);

                File::put($envPath, $envContent);
            }

            return redirect()->back()->with('success', 'Google settings updated successfully!');
        } else {
            return redirect()->back()->with('danger', 'Settings not found!');
        }
    }

    private function updateEnvVariable($key, $value, $content)
    {
        if (preg_match("/^{$key}=.*/m", $content)) {
            return preg_replace("/^{$key}=.*/m", "{$key}=\"{$value}\"", $content);
        } else {
            return $content . "\n{$key}=\"{$value}\"";
        }
    }
}
