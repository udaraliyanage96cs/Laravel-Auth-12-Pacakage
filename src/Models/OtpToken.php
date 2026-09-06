<?php

namespace Udara\LaravelAuth\Models;

use Illuminate\Database\Eloquent\Model;

class OtpToken extends Model
{
    protected $fillable = [
        'user_id',
        'otp',
        'expires_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
    ];

    /**
     * The user this OTP belongs to.
     */
    public function user()
    {
        $userModel = config('laravel-auth.user_model', config('auth.providers.users.model', \App\Models\User::class));
        return $this->belongsTo($userModel, 'user_id');
    }

    /**
     * Check whether this OTP has expired.
     */
    public function isExpired(): bool
    {
        return now()->isAfter($this->expires_at);
    }
}
