<?php

namespace Udara\LaravelAuth\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Udara\LaravelAuth\Models\Permissions;
use Udara\LaravelAuth\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    public function index(Request $req)
    {
        $roles = Role::all();
        $permissions = Permission::all();
        $modules = Permissions::$modules;

        return view('roles.index', compact('roles', 'permissions', 'modules'));
    }

    public function store(Request $req)
    {
        $req->validate([
            'name' => 'required|string|max:255',
        ]);
        $existingRole = Role::where('name', $req->name)->where('guard_name', 'web')->first();
        if ($existingRole) {
            return redirect()->route('roles.index')->with('danger', 'The role already exists!');
        }
        $role = Role::create(['name' => $req->name, 'guard_name' => 'web']);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'created',
            'description' => "Role has been created",
            'model_type' => Role::class,
            'model_id' => $role->id
        ]);

        return redirect()->route('roles.index')->with('success', 'Role created successfully!');
    }

    public function updatePermissions(Request $request, $roleId)
    {
        $role = Role::findOrFail($roleId);
        $permissions = Permission::whereIn('name', $request->input('permission_names', []))->get();
        $role->syncPermissions($permissions);
        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'updated',
            'description' => "Permission has been Updated",
            'model_type' => Permission::class,
            'model_id' => 0
        ]);
        return redirect()->route('roles.index')->with('success', 'Permissions updated successfully!');
    }
}
