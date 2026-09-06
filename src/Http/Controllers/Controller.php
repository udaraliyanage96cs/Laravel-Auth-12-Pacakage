<?php

namespace Udara\LaravelAuth\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;

abstract class Controller extends BaseController
{
    /**
     * Helper to get configured User model class.
     */
    protected function getUserModel(): string
    {
        return config('laravel-auth.user_model', config('auth.providers.users.model', \App\Models\User::class));
    }
}
