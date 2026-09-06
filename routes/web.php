<?php

use Udara\LaravelAuth\Http\Controllers\ProfileController;
use Udara\LaravelAuth\Http\Controllers\RoleController;
use Udara\LaravelAuth\Http\Controllers\UserController;
use Udara\LaravelAuth\Http\Controllers\SettingController;
use Udara\LaravelAuth\Http\Controllers\NotificationController;
use Udara\LaravelAuth\Http\Controllers\WelcomeController;
use Udara\LaravelAuth\Http\Controllers\ActivityLogController;
use Illuminate\Support\Facades\Route;

Route::get('/', [WelcomeController::class, 'index']);
Route::get('/on-pending', [WelcomeController::class, 'onPending'])->middleware('guest');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware('permission:role_management')->group(function () {
        Route::prefix('roles')->group(function () {
            Route::get('/', [RoleController::class, 'index'])->name('roles.index');
            Route::post('/store', [RoleController::class, 'store'])->name('roles.store');
            Route::post('/{role}/permissions', [RoleController::class, 'updatePermissions'])->name('role.updatePermissions');
        });
    });

    Route::middleware('permission:user_management')->group(function () {
        Route::prefix('users')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('users.index');
            Route::post('/create', [UserController::class, 'create'])->middleware('permission:create_user_management');
            Route::get('/approval/{id}', [UserController::class, 'approval'])->name('users.approval')->middleware('permission:update_user_management');
            Route::get('/show/{id}', [UserController::class, 'show'])->name('users.show')->middleware('permission:view_user_management');
            Route::get('/edit/{id}', [UserController::class, 'edit'])->name('users.edit')->middleware('permission:update_user_management');
            Route::put('/update/{id}', [UserController::class, 'update'])->name('users.update')->middleware('permission:update_user_management');
            Route::get('/delete/{id}', [UserController::class, 'destroy'])->name('users.destroy')->middleware('permission:delete_user_management');
            Route::get('/disapproval/{id}', [UserController::class, 'disapproval'])->name('users.disapproval')->middleware('permission:update_user_management');
            Route::get('/restore/{id}', [UserController::class, 'restore'])->name('users.restore')->middleware('permission:restore_user_management');
            Route::post('/resetpassword/{id}', [UserController::class, 'resetpassword'])->name('users.resetpassword')->middleware('permission:update_user_management');
        });
    });

    Route::middleware('permission:notification_management')->group(function () {
        Route::prefix('notifications')->group(function () {
            Route::get('/', [NotificationController::class, 'index'])->name("notifications.index");
            Route::get('/test', [NotificationController::class, 'testNotifications']);
            Route::post('/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.readAll');
            Route::post('/read/{id}', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
            Route::post('/send', [NotificationController::class, 'sendNotification'])->name('notifications.send');
        });
    });

    Route::middleware('permission:setting_management')->group(function () {
        Route::prefix('settings')->group(function () {
            Route::get('/', [SettingController::class, 'index'])->name('settings.index');
            Route::post('/store', [SettingController::class, 'store'])->name('settings.store');
            Route::post('/theme-settings', [SettingController::class, 'themeSettings'])->name('settings.themesettings');
            Route::post('/modules-settings', [SettingController::class, 'moduleSettings'])->name('settings.modulesettings');
            Route::post('/auth-settings', [SettingController::class, 'authSettings'])->name('settings.authsettings');
            Route::post('/google-settings', [SettingController::class, 'googleSettings'])->name('settings.googlesettings');
        });
    });

    Route::middleware('permission:activity_management')->group(function () {
        Route::prefix('activity-log')->group(function () {
            Route::get('/', [ActivityLogController::class, 'index'])->name('settings.index');
            Route::get('/activity-logs', [ActivityLogController::class, 'index'])->name('activity.logs');
        });
    });
});
