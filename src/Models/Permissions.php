<?php

namespace Udara\LaravelAuth\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permissions extends Model
{
    use HasFactory;

    protected $fillable = [];

    public static $modules = [
        'dashboard' => ['view'],
        'user_management' => ['view', 'create', 'update', 'delete', 'restore'],
        'notification_management' => ['view', 'manual'],
        'role_management' => ['view', 'create', 'update'],
        'setting_management' => [],
        'activity_management' => [],
    ];
}
