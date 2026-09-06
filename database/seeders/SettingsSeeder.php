<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Udara\LaravelAuth\Models\Setting;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::updateOrCreate(
            ['id' => 1],  
            [
                'site_name' => env('APP_NAME'),
                'self_registration_enable' => 1,
                'forgot_password_enable' => 1,
                'admin_approvel_for_new_user' => 1,
                'delete_own_profile' => 0,
                'restore_users' => 1,
                'mfa_enable' => 0,
                'force_password_change' => 0,
            ]
        );

        echo "Settings seeded successfully.\n";
    }
}
