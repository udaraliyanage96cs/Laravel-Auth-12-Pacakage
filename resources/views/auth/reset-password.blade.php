<x-guest-layout>
    <h4 class="mb-2">Reset Password 👩🏻‍💻</h4>
    <p class="mb-4">for <span class="fw-bold">{{ $request->email }}</span></p>

    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email"
                value="{{ old('email', $request->email) }}" placeholder="Enter your email" required
                autocomplete="username" readonly />
            <x-input-error :messages="$errors->get('email')" class="mt-2"
                style="color: red;list-style-type: none; margin: 0;padding: 0" />
        </div>

        <div class="mb-3 form-password-toggle">
            <label class="form-label" for="password">New Password</label>
            <div class="input-group input-group-merge">
                <input type="password" id="password" class="form-control" name="password"
                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                    aria-describedby="password" required autocomplete="new-password" autofocus />
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

        <button class="btn btn-success d-grid w-100" type="submit">Set New Password</button>
    </form>
    <div class="text-center mt-3">
        <a href="{{ route('login') }}" class="d-flex align-items-center justify-content-center text-success fw-semibold text-decoration-none">
            <i class="bx bx-chevron-left scaleX-n1-rtl me-1"></i>
            Back to login
        </a>
    </div>
</x-guest-layout>
