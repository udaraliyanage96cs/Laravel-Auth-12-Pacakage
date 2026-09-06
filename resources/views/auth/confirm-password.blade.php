<x-guest-layout>
    <h4 class="mb-2">Confirm Password 🔐</h4>
    <p class="mb-4">
        This is a secure area of the application. Please confirm your password before continuing.
    </p>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <!-- Password -->
        <div class="mb-3 form-password-toggle">
            <label class="form-label" for="password">Password</label>
            <div class="input-group input-group-merge">
                <input type="password" id="password" class="form-control" name="password"
                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                    aria-describedby="password" required autocomplete="current-password" autofocus />
                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2"
                style="color: red;list-style-type: none; margin: 0;padding: 0" />
        </div>

        <button class="btn btn-success d-grid w-100" type="submit">Confirm</button>
    </form>
</x-guest-layout>
