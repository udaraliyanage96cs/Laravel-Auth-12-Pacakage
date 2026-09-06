<div id="auth-settings" class="content">
    <form action="{{ route('settings.authsettings') }}" method="POST">
        @csrf
        <div>
            <div class="content-header mb-3">
                <h6 class="mb-0">reCAPTCHA Settings</h6>
            </div>
            <div class="col-sm-6">
                <label class="form-label" for="enable_recaptcha">Enable reCAPTCHA <span
                        class="text-danger">*</span></label>
                <select class="form-select" name="enable_recaptcha" id="enable_recaptcha" required>
                    <option value="1" @selected($setting->enable_recaptcha == 1)>Enabled</option>
                    <option value="0" @selected($setting->enable_recaptcha == 0)>Disabled</option>
                </select>
                <p class="form-text">
                    Enable or disable Google reCAPTCHA protection for the system.
                </p>
            </div>
            <div class="" id="recaptcha-keys"
                style="display: {{ $setting->enable_recaptcha == 1 ? 'block' : 'none' }}">
                <hr>
                <div class="row g-3">
                    <div class="col-sm-6">
                        <label class="form-label" for="recaptcha_site_key">reCAPTCHA Site Key
                            (V2)<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="recaptcha_site_key" id="recaptcha_site_key"
                            value="{{ old('recaptcha_site_key', $setting->recaptcha_site_key ?? '') }}" @required($setting->enable_recaptcha == 1)>
                        <p class="form-text">
                            Enter the Google reCAPTCHA site key. This key is used to verify user
                            interactions.
                        </p>
                    </div>
                    <div class="col-sm-6">
                        <label class="form-label" for="recaptcha_secret_key">reCAPTCHA Secret Key (V2)
                            <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="recaptcha_secret_key" id="recaptcha_secret_key"
                            value="{{ old('recaptcha_secret_key', $setting->recaptcha_secret_key ?? '') }}" @required($setting->enable_recaptcha == 1)>
                        <p class="form-text">
                            Enter the Google reCAPTCHA secret key. This key is used for server-side
                            validation.
                        </p>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row g-3">
                <div class="col-sm-6">
                    <label class="form-label" for="force_password_change">Force Password Reset for New Users <span class="text-danger">*</span></label>
                    <select class="form-select" name="force_password_change" id="force_password_change" required>
                        <option value="1" @selected($setting->force_password_change == 1)>Enabled</option>
                        <option value="0" @selected($setting->force_password_change == 0)>Disabled</option>
                    </select>
                    <p class="form-text">
                        If enabled, users created or approved via the admin panel must reset their password on their first login.
                    </p>
                </div>
            </div>
            <div class="col-12 d-flex justify-content-end mt-3">
                <input class="btn btn-success" type="submit" value="Update">
            </div>
        </div>
    </form>
</div>
