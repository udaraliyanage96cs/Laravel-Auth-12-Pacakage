<?php

namespace Udara\LaravelAuth\Traits;

use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;
use Udara\LaravelAuth\Notifications\CustomResetPasswordNotification;
use Udara\LaravelAuth\Models\ActivityLog;
use Udara\LaravelAuth\Models\OtpToken;

trait HasLaravelAuth
{
    use SoftDeletes, HasRoles;

    /**
     * Initialize the trait.
     */
    public function initializeHasLaravelAuth(): void
    {
        $this->mergeFillable([
            'profile_picture',
            'google_id',
            'needs_password_change',
        ]);

        $this->mergeCasts([
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'needs_password_change' => 'boolean',
        ]);
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token): void
    {
        $this->notify(new CustomResetPasswordNotification($token));
    }

    /**
     * Activity logs relationship.
     */
    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class, 'user_id');
    }

    /**
     * OTP tokens relationship.
     */
    public function otpTokens()
    {
        return $this->hasMany(OtpToken::class, 'user_id');
    }
}
