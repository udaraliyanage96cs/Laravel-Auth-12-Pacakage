<x-guest-layout>
    <h4 class="mb-2">Verify your email ✉️</h4>
    <p class="mb-4">
        Thanks for signing up! Before getting started, could you verify your email address by clicking
        on the link we just emailed to you? If you didn't receive the email, we will gladly send you
        another.
    </p>

    @if (session('status') == 'verification-link-sent')
        <div class="alert alert-success mb-4" role="alert">
            <div class="alert-body">
                A new verification link has been sent to the email address you provided during registration.
            </div>
        </div>
    @endif

    <div class="mt-4 d-flex justify-content-between">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="btn btn-success">
                Resend Verification Email
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-outline-secondary">
                Log Out
            </button>
        </form>
    </div>
</x-guest-layout>
