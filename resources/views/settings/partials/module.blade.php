<div id="module-settings" class="content">
    <form action="{{ route('settings.modulesettings') }}" method="POST">
        @csrf
        <div>
            <div class="content-header mb-3">
                <h6 class="mb-0">Module Settings</h6>
            </div>
            <div class="row g-3">
                <div class="col-sm-6">
                    <label class="form-label" for="self_registration">Require Admin Approval for New
                        Users</label>

                    <select class="form-select" name="admin_approvel_for_new_user" id="admin_approvel_for_new_user"
                        required>
                        <option value="1" @selected($setting->admin_approvel_for_new_user == 1)>Enabled</option>
                        <option value="0" @selected($setting->admin_approvel_for_new_user == 0)>Disabled</option>
                    </select>
                    <p class="form-text">
                        Choose whether new user accounts require admin approval before sending login
                        details via email. When enabled, admins must approve new users before they can
                        access the system.
                    </p>
                </div>
                <hr>
                <div class="col-sm-6">
                    <label class="form-label" for="self_registration">Self Registration</label>

                    <select class="form-select" name="self_registration" id="self_registration" required>
                        <option value="1" @selected($setting->self_registration_enable == 1)>Enabled</option>
                        <option value="0" @selected($setting->self_registration_enable == 0)>Disabled</option>
                    </select>
                    <p class="form-text">
                        Enable or disable guest user registration to control who can sign up for the
                        system. When disabled, only authorized users can create new accounts.
                    </p>
                </div>
                <div class="col-sm-6">
                    <label class="form-label" for="forgot_password">Forgot Password</label>
                    <select class="form-select" name="forgot_password" id="forgot_password" required>
                        <option value="1" @selected($setting->forgot_password_enable == 1)>Enabled</option>
                        <option value="0" @selected($setting->forgot_password_enable == 0)>Disabled</option>
                    </select>
                    <p class="form-text">
                        Allow users to reset their password securely if they forget it. When enabled,
                        users can request a password reset link via email to regain access to their
                        account.
                    </p>
                </div>
                <hr>
                <div class="col-sm-6">
                    <label class="form-label" for="delete_own_profile">Delete Profile</label>
                    <select class="form-select" name="delete_own_profile" id="delete_own_profile" required>
                        <option value="1" @selected($setting->delete_own_profile == 1)>Enabled</option>
                        <option value="0" @selected($setting->delete_own_profile == 0)>Disabled</option>
                    </select>
                    <p class="form-text">
                        Allow users to delete their profile from the system. When enabled, users will
                        have the ability to delete their own account along with all associated data.
                    </p>
                </div>
                <div class="col-sm-6">
                    <label class="form-label" for="restore_users">Restore Delete Users</label>
                    <select class="form-select" name="restore_users" id="restore_users" required>
                        <option value="1" @selected($setting->restore_users == 1)>Enabled</option>
                        <option value="0" @selected($setting->restore_users == 0)>Disabled</option>
                    </select>
                    <p class="form-text">
                        Allow restore deleted accounts. When enabled, users will have the
                        ability to recover their profiles.
                    </p>
                </div>
                <div class="col-sm-6">
                    <label class="form-label" for="mfa_enable">Multi-Factor Authentication (MFA)</label>
                    <select class="form-select" name="mfa_enable" id="mfa_enable" required>
                        <option value="1" @selected($setting->mfa_enable == 1)>Enabled</option>
                        <option value="0" @selected($setting->mfa_enable == 0)>Disabled</option>
                    </select>
                    <p class="form-text">
                        Require users to verify their login with an email OTP (One Time Password).
                    </p>
                </div>
            </div>

            <div class="col-12 d-flex justify-content-end mt-3">
                <input class="btn btn-success" type="submit" value="Update">
            </div>
        </div>
    </form>

</div>
