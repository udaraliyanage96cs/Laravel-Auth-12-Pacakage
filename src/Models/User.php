<?php

namespace Udara\LaravelAuth\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Udara\LaravelAuth\Traits\HasLaravelAuth;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, HasLaravelAuth;

    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_picture',
        'google_id',
        'email_verified_at',
        'needs_password_change',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'needs_password_change' => 'boolean',
        ];
    }
}
