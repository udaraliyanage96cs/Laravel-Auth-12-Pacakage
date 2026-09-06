<?php

namespace Udara\LaravelAuth\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $fillable = ['user_id', 'action', 'description', 'model_type', 'model_id'];

    public function user()
    {
        $userModel = config('laravel-auth.user_model', config('auth.providers.users.model', \App\Models\User::class));
        return $this->belongsTo($userModel, 'user_id');
    }
}
