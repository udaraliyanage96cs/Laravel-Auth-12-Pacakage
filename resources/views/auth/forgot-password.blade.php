<x-guest-layout>
    <h4 class="mb-2">Forgot Password? 🔒</h4>
    <p class="mb-4">Enter your email and we'll send you instructions to reset your password</p>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}"
                placeholder="Enter your email" autofocus required />
            <x-input-error :messages="$errors->get('email')" class="mt-2"
                style="color: red;list-style-type: none; margin: 0;padding: 0" />
        </div>
        <button class="btn btn-success d-grid w-100" type="submit">Send Reset Link</button>
    </form>
    <div class="text-center mt-3">
        <a href="{{ route('login') }}" class="d-flex align-items-center justify-content-center text-success fw-semibold text-decoration-none">
            <i class="bx bx-chevron-left scaleX-n1-rtl me-1"></i>
            Back to login
        </a>
    </div>
</x-guest-layout>
