<?php

namespace Udara\LaravelAuth;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Routing\Router;
use Udara\LaravelAuth\Console\Commands\InstallCommand;
use Udara\LaravelAuth\Console\Commands\ProjectInit;
use Udara\LaravelAuth\Console\Commands\GenModule;
use Udara\LaravelAuth\Http\Middleware\CheckPermission;
use Udara\LaravelAuth\Http\Middleware\CheckRegistrationEnabled;
use Udara\LaravelAuth\Http\Middleware\CheckForgotPasswordEnabled;
use Udara\LaravelAuth\Http\Middleware\ForcePasswordChange;
use Udara\LaravelAuth\Http\Middleware\RoleMiddleware;
use Udara\LaravelAuth\Http\Middleware\CheckAdmin;
use Udara\LaravelAuth\View\Components\AppLayout;
use Udara\LaravelAuth\View\Components\GuestLayout;

class LaravelAuthServiceProvider extends ServiceProvider
{
    /**
     * Register any package services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/laravel-auth.php',
            'laravel-auth'
        );
    }

    /**
     * Bootstrap any package services.
     */
    public function boot(): void
    {
        // 1. Load routes
        $this->registerRoutes();

        // 2. Load migrations
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        // 3. Load views (namespaced and fallback location)
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'laravel-auth');
        if (is_dir(__DIR__ . '/../resources/views')) {
            View::addLocation(__DIR__ . '/../resources/views');
        }

        // 4. Register Blade layout components
        Blade::component('app-layout', AppLayout::class);
        Blade::component('guest-layout', GuestLayout::class);

        // 5. Register middleware
        $this->registerMiddleware();

        // 6. Pagination & Mail Customizations
        \Illuminate\Support\Facades\Schema::defaultStringLength(191);
        \Illuminate\Pagination\Paginator::useBootstrapFive();
        \Illuminate\Auth\Notifications\VerifyEmail::toMailUsing(function (object $notifiable, string $url) {
            return (new \Illuminate\Notifications\Messages\MailMessage)
                ->subject('Verify your email address - ' . config('app.name', env('APP_NAME', 'Laravel Auth')))
                ->view('emails.verify-email', [
                    'notifiable' => $notifiable,
                    'url' => $url
                ]);
        });

        // 7. Register commands & publishables in console
        if ($this->app->runningInConsole()) {
            $this->commands([
                InstallCommand::class,
                ProjectInit::class,
                GenModule::class,
            ]);

            $this->registerPublishables();
        }
    }

    /**
     * Register package routes.
     */
    protected function registerRoutes(): void
    {
        if (file_exists(__DIR__ . '/../routes/web.php')) {
            $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        }

        if (file_exists(__DIR__ . '/../routes/auth.php')) {
            $this->loadRoutesFrom(__DIR__ . '/../routes/auth.php');
        }
    }

    /**
     * Register middleware aliases and push global web middleware.
     */
    protected function registerMiddleware(): void
    {
        /** @var Router $router */
        $router = $this->app['router'];

        $router->aliasMiddleware('permission', CheckPermission::class);
        $router->aliasMiddleware('check.registration', CheckRegistrationEnabled::class);
        $router->aliasMiddleware('check.forgotPassword', CheckForgotPasswordEnabled::class);
        $router->aliasMiddleware('role', RoleMiddleware::class);
        $router->aliasMiddleware('check.admin', CheckAdmin::class);

        $router->pushMiddlewareToGroup('web', ForcePasswordChange::class);
    }

    /**
     * Register vendor publishable resources.
     */
    protected function registerPublishables(): void
    {
        // Config
        $this->publishes([
            __DIR__ . '/../config/laravel-auth.php' => config_path('laravel-auth.php'),
        ], 'laravel-auth-config');

        // Static Assets (Admin theme CSS, JS, Images, Fonts)
        if (is_dir(__DIR__ . '/../resources/assets')) {
            $this->publishes([
                __DIR__ . '/../resources/assets' => public_path('assets'),
            ], 'laravel-auth-assets');
        }

        // Blade Views
        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/laravel-auth'),
        ], 'laravel-auth-views');

        // Seeders
        $this->publishes([
            __DIR__ . '/../database/seeders' => database_path('seeders'),
        ], 'laravel-auth-seeders');

        // Migrations
        $this->publishes([
            __DIR__ . '/../database/migrations' => database_path('migrations'),
        ], 'laravel-auth-migrations');

        // Stubs
        if (is_dir(__DIR__ . '/../stubs')) {
            $this->publishes([
                __DIR__ . '/../stubs' => base_path('stubs'),
            ], 'laravel-auth-stubs');
        }
    }
}
