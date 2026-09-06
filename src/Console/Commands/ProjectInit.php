<?php

namespace Udara\LaravelAuth\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;
use Database\Seeders\RoleSeeder;
use Database\Seeders\SettingsSeeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;

class ProjectInit extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:project-init';

    protected $hidden = true;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Initialize the project with migrations, seeders, and admin user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Initializing the project...');

        $this->info('Running migrations...');
        Artisan::call('migrate', ['--force' => true]);

        $this->info('Seeding settings...');
        if (class_exists(SettingsSeeder::class)) {
            $settingsSeeder = new SettingsSeeder();
            $settingsSeeder->run();
        }

        $this->info('Seeding roles and permissions...');
        if (class_exists(RoleSeeder::class)) {
            $seeder = new RoleSeeder();
            $seeder->run();
        }

        $role = Role::firstOrCreate(['name' => 'admin']);

        $name = config('laravel-auth.admin.name', 'Admin');
        $email = config('laravel-auth.admin.email', 'ldudaraliyanage@gmail.com');
        $password = config('laravel-auth.admin.password', '123456');
        $profilePicture = config('laravel-auth.admin.profile_picture', 'avt8.png');

        $userModel = config('laravel-auth.user_model', config('auth.providers.users.model', \App\Models\User::class));

        $admin = $userModel::firstOrCreate(
            ['email' => $email],
            [
                'name' => $name,
                'password' => Hash::make($password),
                'profile_picture' => $profilePicture,
                'email_verified_at' => now(),
            ]
        );

        if (method_exists($admin, 'hasRole')) {
            if (!$admin->hasRole('admin')) {
                $admin->assignRole($role);
            }
        } else {
            $this->warn('Notice: HasLaravelAuth trait not yet detected on User model.');
            $this->warn('Add HasLaravelAuth to App\Models\User and re-run php artisan app:project-init to assign the admin role.');
        }

        $this->info('Admin user created successfully!');
        $this->line("Name: $name");
        $this->line("Email: $email");

        return 0;
    }
}
