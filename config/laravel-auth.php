<?php

return [
    /*
    |--------------------------------------------------------------------------
    | User Model
    |--------------------------------------------------------------------------
    |
    | The Eloquent model that should be used for authentication and user
    | management. In standard Laravel applications, this is App\Models\User.
    |
    */
    'user_model' => env('LARAVEL_AUTH_USER_MODEL', \App\Models\User::class),

    /*
    |--------------------------------------------------------------------------
    | Route Configurations
    |--------------------------------------------------------------------------
    |
    | You can configure route prefixes and middleware applied to the package
    | routes. By default, routes use standard web middleware.
    |
    */
    'routes' => [
        // Prefix for management routes (roles, users, settings, activity logs)
        'prefix' => '',

        // Middleware for authenticated management routes
        'middleware' => ['web', 'auth'],

        // Middleware for guest authentication routes (login, register, forgot-password)
        'guest_middleware' => ['web'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Redirection Paths
    |--------------------------------------------------------------------------
    |
    | Where to redirect users after various authentication events.
    |
    */
    'redirects' => [
        'login' => '/dashboard',
        'logout' => '/login',
        'home' => '/',
    ],

    /*
    |--------------------------------------------------------------------------
    | Default Admin Configuration
    |--------------------------------------------------------------------------
    |
    | Used by the `php artisan laravel-auth:install` or `app:project-init` command
    | when seeding the initial administrator account.
    |
    */
    'admin' => [
        'name' => env('LARAVEL_AUTH_ADMIN_NAME', 'Admin'),
        'email' => env('LARAVEL_AUTH_ADMIN_EMAIL', 'ldudaraliyanage@gmail.com'),
        'password' => env('LARAVEL_AUTH_ADMIN_PASSWORD', '123456'),
        'profile_picture' => 'avt8.png',
    ],
];
