<div id="google-settings" class="content">
    <div class="content-header mb-3">
        <h6 class="mb-0">Google Authentication Settings</h6>
        <small>Setup Google OAuth credentials for Sign-In</small>
    </div>
    <form action="{{ route('settings.googlesettings') }}" method="POST">
        @csrf
        <div class="row g-3">
            <div class="col-sm-6">
                <label class="form-label" for="enable_google_login">Enable Google Login</label>
                <select id="enable_google_login" name="enable_google_login" class="form-select">
                    <option value="1" {{ $setting->enable_google_login ? 'selected' : '' }}>Enable</option>
                    <option value="0" {{ !$setting->enable_google_login ? 'selected' : '' }}>Disable</option>
                </select>
            </div>
            <div id="google-keys" style="display: {{ $setting->enable_google_login ? 'block' : 'none' }}">
                <div class="col-12 mb-3">
                    <label class="form-label" for="google_client_id">Google Client ID</label>
                    <input type="text" id="google_client_id" name="google_client_id" class="form-control"
                        placeholder="Enter Google Client ID" value="{{ $setting->google_client_id }}" />
                </div>
                <div class="col-12 mb-3">
                    <label class="form-label" for="google_client_secret">Google Client Secret</label>
                    <input type="password" id="google_client_secret" name="google_client_secret" class="form-control"
                        placeholder="Enter Google Client Secret" value="{{ $setting->google_client_secret }}" />
                </div>
                <div class="col-12 mb-3">
                    <label class="form-label" for="google_redirect_url">Google Redirect URL</label>
                    <input type="text" id="google_redirect_url" name="google_redirect_url" class="form-control"
                        placeholder="Enter Google Redirect URL" value="{{ $setting->google_redirect_url }}" />
                    <small class="text-muted">Example: {{ url('/auth/google/callback') }}</small>
                </div>
            </div>

            <div class="col-12 d-flex justify-content-end">
                <button type="submit" class="btn btn-success">
                    Update
                </button>
            </div>
        </div>
    </form>
</div>
<script>
    document.getElementById('enable_google_login').addEventListener('change', function () {
        let keysDiv = document.getElementById('google-keys');
        keysDiv.style.display = this.value == '1' ? 'block' : 'none';
    });
</script>