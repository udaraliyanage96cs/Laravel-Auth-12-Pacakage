<x-guest-layout>
    <h4 class="mb-2">Adventure starts here 🚀</h4>
    <p class="mb-4">Make your app management easy and fun!</p>

    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}"
                placeholder="Enter your Name" autofocus required autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2"
                style="color: red;list-style-type: none; margin: 0;padding: 0" />
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}"
                placeholder="Enter your Email Address" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2"
                style="color: red;list-style-type: none; margin: 0;padding: 0" />
        </div>
        <div class="mb-3 form-password-toggle">
            <label class="form-label" for="password">Password</label>
            <div class="input-group input-group-merge">
                <input type="password" id="password" class="form-control" name="password"
                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                    aria-describedby="password" required autocomplete="new-password" />
                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2"
                style="color: red;list-style-type: none; margin: 0;padding: 0" />
        </div>
        <div class="mb-3 form-password-toggle">
            <label class="form-label" for="password_confirmation">Confirm Password</label>
            <div class="input-group input-group-merge">
                <input type="password" id="password_confirmation" class="form-control" name="password_confirmation"
                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                    aria-describedby="password_confirmation" required autocomplete="new-password" />
                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2"
                style="color: red;list-style-type: none; margin: 0;padding: 0" />
        </div>
        @if ($setting->enable_recaptcha == 1)
            <div class="form-group mt-3 mb-3">
                <div class="g-recaptcha " data-sitekey={{ $setting->recaptcha_site_key }}></div>
                @error('g-recaptcha-response')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        @endif
        <button class="btn btn-success d-grid w-100" type="submit">Sign Up</button>

        <p class="text-center mt-3">
            <span>Already have an account?</span>
            <a href="{{ route('login') }}" class="text-success fw-semibold text-decoration-none">
                <span>Sign in instead</span>
            </a>
        </p>

        @if ($setting->enable_google_login)
            <div class="divider my-4">
                <div class="divider-text">or</div>
            </div>

            <div class="d-flex justify-content-center">
                <a href="{{ route('auth.google') }}"
                    class="btn btn-google d-flex align-items-center justify-content-center w-100">
                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                        xmlns="http://www.w3.org/2000/svg" style="margin-right: 12px;">
                        <path
                            d="M17.64 9.20454C17.64 8.56636 17.5827 7.95272 17.4764 7.36363H9V10.845H13.8436C13.635 11.97 13.0009 12.9231 12.0477 13.5613V15.8195H14.9564C16.6582 14.2527 17.64 11.9454 17.64 9.20454Z"
                            fill="#4285F4" />
                        <path
                            d="M9 18C11.43 18 13.4673 17.1941 14.9564 15.8195L12.0477 13.5613C11.2418 14.1013 10.2109 14.4204 9 14.4204C6.65591 14.4204 4.67182 12.8372 3.96409 10.71H0.957275V13.0418C2.43818 15.9831 5.48182 18 9 18Z"
                            fill="#34A853" />
                        <path
                            d="M3.96409 10.71C3.78409 10.17 3.68182 9.59318 3.68182 9C3.68182 8.40682 3.78409 7.83 3.96409 7.29V4.95818H0.957275C0.347727 6.17318 0 7.54772 0 9C0 10.4523 0.347727 11.8268 0.957275 13.0418L3.96409 10.71Z"
                            fill="#FBBC05" />
                        <path
                            d="M9 3.57955C10.3214 3.57955 11.5077 4.03364 12.4405 4.92545L15.0218 2.34409C13.4632 0.891818 11.4259 0 9 0C5.48182 0 2.43818 2.01682 0.957275 4.95818L3.96409 7.29C4.67182 5.16273 6.65591 3.57955 9 3.57955Z"
                            fill="#EA4335" />
                    </svg>
                    Sign up with Google
                </a>
            </div>
        @endif
    </form>
</x-guest-layout>
