<?php

namespace Udara\LaravelAuth\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'laravel-auth:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the Laravel Auth package, publish assets, run migrations, and initialize seeders';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('=============================================');
        $this->info('   Installing Udara Laravel Auth Package     ');
        $this->info('=============================================');

        // 1. Publish configuration
        $this->info('Publishing package configuration...');
        $this->callSilent('vendor:publish', [
            '--tag' => 'laravel-auth-config',
            '--force' => true,
        ]);

        // 2. Publish static assets to public/assets
        $this->info('Publishing admin template assets to public/assets...');
        $this->callSilent('vendor:publish', [
            '--tag' => 'laravel-auth-assets',
            '--force' => true,
        ]);

        // 3. Publish seeders
        $this->info('Publishing seeders...');
        $this->callSilent('vendor:publish', [
            '--tag' => 'laravel-auth-seeders',
            '--force' => true,
        ]);

        // 4. Publish Spatie Permission migrations if not yet published
        $this->info('Checking Spatie permission migrations...');
        $this->callSilent('vendor:publish', [
            '--provider' => 'Spatie\Permission\PermissionServiceProvider',
        ]);

        // 5. Run migrations
        $this->info('Running database migrations...');
        $this->call('migrate', ['--force' => true]);

        // 6. Run ProjectInit (seeds settings, roles, permissions, admin user)
        $this->info('Initializing settings, permissions, and administrator user...');
        $this->call('app:project-init');

        // 7. Check if User model has the trait
        $this->checkUserModelTrait();

        $this->newLine();
        $this->info('=============================================');
        $this->info('   Installation Completed Successfully!      ');
        $this->info('=============================================');
        $this->line('Admin Login: ' . config('laravel-auth.admin.email', 'ldudaraliyanage@gmail.com'));
        $this->line('Password:    ' . config('laravel-auth.admin.password', '123456'));
        $this->line('Dashboard:   ' . url(config('laravel-auth.redirects.login', '/dashboard')));
        $this->newLine();

        return 0;
    }

    /**
     * Check if the host User model implements HasLaravelAuth trait.
     */
    protected function checkUserModelTrait(): void
    {
        $userModelPath = app_path('Models/User.php');

        if (File::exists($userModelPath)) {
            $userContent = File::get($userModelPath);

            if (!str_contains($userContent, 'HasLaravelAuth')) {
                $this->warn('NOTE: Please add the HasLaravelAuth trait to your App\Models\User model:');
                $this->line('  use Udara\LaravelAuth\Traits\HasLaravelAuth;');
                $this->line('  class User extends Authenticatable {');
                $this->line('      use HasLaravelAuth;');
                $this->line('  }');
            }
        }
    }
}
