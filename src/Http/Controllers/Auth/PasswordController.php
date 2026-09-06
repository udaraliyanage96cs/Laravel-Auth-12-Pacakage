<?php

namespace Udara\LaravelAuth\Http\Controllers\Auth;

use Udara\LaravelAuth\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Udara\LaravelAuth\Models\ActivityLog;

class PasswordController extends Controller
{
    /**
     * Update the user's password.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('status', 'password-updated');
    }

    /**
     * Show the force password change form.
     */
    public function showChangeForm(Request $request)
    {
        return view('auth.reset-password-change');
    }

    /**
     * Update the user's password and clear the needs_password_change flag.
     */
    public function forceUpdatePassword(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        $user = $request->user();

        $user->update([
            'password' => Hash::make($validated['password']),
            'needs_password_change' => false,
        ]);

        // Log activity
        ActivityLog::create([
            'user_id' => $user->id,
            'action' => 'password change required',
            'description' => "User changed their required default password",
            'model_type' => get_class($user),
            'model_id' => $user->id
        ]);

        return redirect()->route('dashboard')->with('success', __('Your password has been successfully updated.'));
    }
}
