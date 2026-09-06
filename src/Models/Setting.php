<?php

namespace Udara\LaravelAuth\Models;

class Setting extends BaseModel
{
    protected $fillable = [
        'site_name',
        'self_registration_enable',
        'forgot_password_enable',
        'admin_approvel_for_new_user',
        'delete_own_profile',
        'restore_users',
        'enable_recaptcha',
        'recaptcha_site_key',
        'recaptcha_secret_key',
        'google_client_id',
        'google_client_secret',
        'google_redirect_url',
        'enable_google_login',
        'mfa_enable',
        'force_password_change',
    ];
}
