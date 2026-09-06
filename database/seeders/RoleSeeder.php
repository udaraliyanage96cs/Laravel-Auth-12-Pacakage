<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Udara\LaravelAuth\Models\Permissions;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $modules = [
            'dashboard',
            'user_management',
            'notification_management',
            'notification_send_manually',
            'role_management',
            'setting_management',
            'activity_management'
        ];

        foreach ($modules as $module) {
            Permission::firstOrCreate(['name' => $module]);
        }

        $permissions = Permissions::$modules;

        foreach ($permissions as $permission => $actions) {
            foreach ($actions as $action) {
                $permissionName = "{$action}_" . str_replace(' ', '_', strtolower($permission));
                Permission::firstOrCreate(['name' => $permissionName]);
            }
        }

        $adminPermissions = [
            'dashboard',
            'view_dashboard',
            'user_management',
            'view_user_management',
            'create_user_management',
            'update_user_management',
            'delete_user_management',
            'restore_user_management',
            'notification_management',
            'view_notification_management',
            'manual_notification_management',
            'role_management',
            'view_role_management',
            'create_role_management',
            'update_role_management',
            'setting_management',
            'activity_management',
        ];

        $userPermissions = [
            'dashboard',
            'notification_management'
        ];

        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $userRole = Role::firstOrCreate(['name' => 'user']);

        $adminRole->syncPermissions($adminPermissions);
        $userRole->syncPermissions($userPermissions);

        echo "Roles and permissions seeded successfully.\n";
    }
}
