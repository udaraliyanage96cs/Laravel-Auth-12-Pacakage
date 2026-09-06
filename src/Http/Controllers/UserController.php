<?php

namespace Udara\LaravelAuth\Http\Controllers;

use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Udara\LaravelAuth\Mail\UserCreated;
use Udara\LaravelAuth\Models\Setting;
use Udara\LaravelAuth\Models\ActivityLog;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $setting = Setting::latest()->first();
        $userModel = $this->getUserModel();
        $query = $userModel::query();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('role')) {
            $query->whereHas('roles', function ($q) use ($request) {
                $q->where('name', $request->role);
            });
        }

        if ($request->filled('approval')) {
            if ($request->approval == 'approved') {
                $query->whereNotNull('email_verified_at');
            } elseif ($request->approval == 'pending') {
                $query->whereNull('email_verified_at')->whereNull('deleted_at');
            } elseif ($request->approval == 'deleted') {
                $query->onlyTrashed();
            }
        }

        if ($request->filled('date_range')) {
            $dates = explode(' to ', $request->date_range);
            if (count($dates) === 2) {
                $query->whereBetween(DB::raw('DATE(created_at)'), [trim($dates[0]), trim($dates[1])]);
            } elseif (count($dates) === 1) {
                $query->whereDate('created_at', trim($dates[0]));
            }
        } elseif ($request->filled('from_date') && $request->filled('to_date')) {
            $query->whereBetween(DB::raw('DATE(created_at)'), [$request->from_date, $request->to_date]);
        } else {
            if ($request->filled('from_date')) {
                $query->whereDate('created_at', '>=', $request->from_date);
            }
            if ($request->filled('to_date')) {
                $query->whereDate('created_at', '<=', $request->to_date);
            }
        }

        $users = $query->withTrashed()
            ->where('email', '<>', 'admin@auth.com')
            ->orderBy('id', 'desc')
            ->paginate(10);
        $roles = Role::where('name', '<>', 'admin')->get();

        return view('user.index', compact('users', 'roles', 'setting'));
    }

    public function create(Request $request)
    {
        $randomPassword = Str::random(10);

        DB::beginTransaction();

        $avatars = [
            'avt1.png', 'avt2.png', 'avt3.png', 'avt4.png', 'avt5.png',
            'avt6.png', 'avt7.png', 'avt8.png', 'avt9.png', 'avt10.png',
        ];

        $randomAvatar = $avatars[array_rand($avatars)];

        try {
            $setting = Setting::latest()->first();
            $pwd = null;

            if ($setting && $setting->admin_approvel_for_new_user == 0) {
                $pwd = bcrypt($randomPassword);
            }

            $userModel = $this->getUserModel();
            $user = $userModel::firstOrCreate(
                ['email' => $request->email],
                [
                    'name' => $request->name,
                    'password' => $pwd,
                    'profile_picture' => $randomAvatar,
                    'email_verified_at' => ($setting && $setting->admin_approvel_for_new_user == 0) ? now() : null,
                    'needs_password_change' => true,
                ]
            );

            $role = Role::firstOrCreate(['id' => $request->role]);
            $user->assignRole($role);

            ActivityLog::create([
                'user_id' => Auth::id(),
                'action' => 'created',
                'description' => "User has been created",
                'model_type' => get_class($user),
                'model_id' => $user->id
            ]);

            DB::commit();

            if ($setting && $setting->admin_approvel_for_new_user == 0) {
                Mail::to($user->email)->send(new UserCreated($user, $randomPassword));
            }

            if ($user->wasRecentlyCreated) {
                return redirect()->route('users.index')->with('success', 'User created successfully with a random password.');
            } else {
                return redirect()->route('users.index')->with('info', 'User already exists and role assigned.');
            }

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('users.index')->with('error', 'An error occurred while creating the user: ' . $e->getMessage());
        }
    }

    public function approval(Request $request, $id)
    {
        $userModel = $this->getUserModel();
        $user = $userModel::find($id);
        $randomPassword = Str::random(10);

        if ($user) {
            $user->email_verified_at = now();
            if ($user->password == '') {
                $user->password = bcrypt($randomPassword);
                $user->needs_password_change = true;
            } else {
                $randomPassword = "Your previous password is still valid.";
            }
            $user->save();

            ActivityLog::create([
                'user_id' => Auth::id(),
                'action' => 'approved',
                'description' => "User has been approved",
                'model_type' => get_class($user),
                'model_id' => $user->id
            ]);

            Mail::to($user->email)->send(new UserCreated($user, $randomPassword));
            return redirect()->route('users.index')->with('success', 'User approved successfully.');
        } else {
            return redirect()->route('users.index')->with('error', 'User not found.');
        }
    }

    public function show(Request $request, $id)
    {
        $userModel = $this->getUserModel();
        $user = $userModel::withTrashed()->find($id);

        if ($user) {
            $logs = ActivityLog::where('model_type', get_class($user))
                ->where('model_id', $user->id)
                ->orWhere('user_id', $user->id)
                ->latest()
                ->take(20)
                ->get();
            return view('user.show', compact('user', 'logs'));
        } else {
            return redirect()->route('users.index')->with('error', 'User not found.');
        }
    }

    public function edit(Request $request, $id)
    {
        $userModel = $this->getUserModel();
        $user = $userModel::find($id);

        if ($user) {
            $roles = Role::where('name', '<>', 'admin')->get();
            return view('user.edit', compact('user', 'roles'));
        } else {
            return redirect()->route('users.index')->with('error', 'User not found.');
        }
    }

    public function update(Request $request, $id)
    {
        $userModel = $this->getUserModel();
        $user = $userModel::find($id);

        if (!$user) {
            abort(404, 'User not found.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|exists:roles,name',
        ]);

        $user->update([
            'name' => $request->name,
        ]);

        $user->syncRoles([$request->role]);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'updated',
            'description' => "User details updated",
            'model_type' => get_class($user),
            'model_id' => $user->id
        ]);

        return redirect()->route('users.edit', ['id' => $user->id])->with('success', 'User updated successfully!');
    }

    public function disapproval(Request $request, $id)
    {
        $userModel = $this->getUserModel();
        $user = $userModel::find($id);

        if ($user) {
            $user->email_verified_at = null;
            $user->save();

            ActivityLog::create([
                'user_id' => Auth::id(),
                'action' => 'disabled',
                'description' => "User has been disabled",
                'model_type' => get_class($user),
                'model_id' => $user->id
            ]);

            return redirect()->route('users.index')->with('success', 'User disapproved successfully.');
        } else {
            return redirect()->route('users.index')->with('error', 'User not found.');
        }
    }

    public function destroy(Request $request, $id)
    {
        if (Auth::id() == $id) {
            return redirect()->route('users.index')->with('error', 'You cannot delete your own account.');
        }

        $userModel = $this->getUserModel();
        $user = $userModel::find($id);

        if ($user) {
            ActivityLog::create([
                'user_id' => Auth::id(),
                'action' => 'deleted',
                'description' => "User has been deleted",
                'model_type' => get_class($user),
                'model_id' => $user->id
            ]);

            $user->delete();
            return redirect()->route('users.index')->with('success', 'User deleted successfully.');
        } else {
            return redirect()->route('users.index')->with('error', 'User not found.');
        }
    }

    public function restore(Request $request, $id)
    {
        $userModel = $this->getUserModel();
        $user = $userModel::withTrashed()->find($id);
        if ($user) {
            $user->restore();

            ActivityLog::create([
                'user_id' => Auth::id(),
                'action' => 'restored',
                'description' => "User has been restored",
                'model_type' => get_class($user),
                'model_id' => $user->id
            ]);

            return redirect()->route('users.index')->with('success', 'User restored successfully.');
        } else {
            return redirect()->route('users.index')->with('error', 'User not found.');
        }
    }

    public function resetpassword(Request $request, $id)
    {
        $userModel = $this->getUserModel();
        $user = $userModel::withTrashed()->find($id);

        $request->validate([
            'password' => 'nullable|min:8|confirmed',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id'
        ]);

        if ($user) {
            $user->update([
                'password' => Hash::make($request->password),
            ]);

            ActivityLog::create([
                'user_id' => Auth::id(),
                'action' => 'reset password',
                'description' => "User password has been reset user " . $user->id,
                'model_type' => get_class($user),
                'model_id' => $user->id
            ]);

            return redirect()->route('users.index')->with('success', 'Password reset successfully.');
        } else {
            return redirect()->route('users.index')->with('error', 'User not found.');
        }
    }
}
