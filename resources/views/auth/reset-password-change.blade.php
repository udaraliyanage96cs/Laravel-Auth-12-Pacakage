<x-guest-layout>
    <h4 class="mb-2">Reset Default Password 🔒</h4>
    <p class="mb-4">For security reasons, you must change your default password before proceeding to your account.</p>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    @if (session('warning'))
        <div class="alert alert-warning mb-4" role="alert">
            {{ session('warning') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.change.update') }}">
        @csrf
        
        <div class="mb-3">
            <label for="password" class="form-label">New Password</label>
            <input type="password" class="form-control" id="password" name="password" 
                placeholder="Enter new password" autofocus required />
            <x-input-error :messages="$errors->get('password')" class="mt-2"
                style="color: red; list-style-type: none; margin: 0; padding: 0" />
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirm Password</label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" 
                placeholder="Confirm new password" required />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2"
                style="color: red; list-style-type: none; margin: 0; padding: 0" />
        </div>

        <button class="btn btn-success d-grid w-100" type="submit">Update Password</button>
    </form>
    
    <div class="text-center mt-3">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-link text-muted p-0 m-0 align-baseline">
                Cancel & Logout
            </button>
        </form>
    </div>
</x-guest-layout>
