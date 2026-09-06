@push('title')
    Edit User
@endpush

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<x-app-layout>
    @can('update_user_management')
        <!-- Personal Information Card -->
        <div class="card custom-card shadow-sm border border-light rounded-3 mb-4">
            <div class="card-header border-bottom bg-transparent py-3">
                <h5 class="card-title fw-bold text-slate-800 mb-0">Personal Information</h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('users.update', $user->id) }}" method="POST" id="userForm">
                    @csrf
                    @method('PUT')

                    <div class="row g-3 mb-4">
                        <!-- Full Name -->
                        <div class="col-md-6">
                            <label for="name" class="form-label fw-semibold text-slate-700 mb-1">Full Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control rounded-3" id="name"
                                value="{{ old('name', $user->name ?? '') }}" required placeholder="Enter full name">
                        </div>

                        <!-- Email Address (Disabled) -->
                        <div class="col-md-6">
                            <label for="email" class="form-label fw-semibold text-slate-700 mb-1">Email Address</label>
                            <input type="email" name="email" class="form-control rounded-3 bg-light" id="email"
                                value="{{ old('email', $user->email ?? '') }}" disabled>
                        </div>

                        <!-- Role -->
                        <div class="col-md-6">
                            <label for="role" class="form-label fw-semibold text-slate-700 mb-1">Assigned Role <span class="text-danger">*</span></label>
                            <select name="role" class="form-select rounded-3" id="role" required>
                                <option value="">Select a role...</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->name }}"
                                        @if ($user->roles->contains('name', $role->name)) selected @endif>
                                        {{ ucfirst($role->name) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 pt-3">
                        <a href="{{ route('users.index') }}" class="btn btn-secondary rounded-3 shadow-xs">
                            Cancel
                        </a>
                        <button type="submit" class="btn btn-success rounded-3 shadow-xs">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Password Management Card -->
        <div class="card custom-card shadow-sm border border-light rounded-3 mb-4">
            <div class="card-header border-bottom bg-transparent py-3">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                    <h5 class="card-title fw-bold text-slate-800 mb-0">Password Management</h5>
                    <small class="text-muted">Leave blank to keep current password</small>
                </div>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('users.resetpassword', $user->id) }}" method="POST" id="passwordForm">
                    @csrf
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label for="password" class="form-label fw-semibold text-slate-700 mb-1">New Password</label>
                            <input type="password" name="password" class="form-control rounded-3" id="password" placeholder="Minimum 8 characters">
                        </div>
                        <div class="col-md-6">
                            <label for="password_confirmation" class="form-label fw-semibold text-slate-700 mb-1">Confirm New Password</label>
                            <input type="password" name="password_confirmation" class="form-control rounded-3" id="password_confirmation" placeholder="Re-enter new password">
                        </div>
                    </div>
                    <div class="d-flex justify-content-end pt-3">
                        <button type="submit" class="btn btn-success rounded-3 shadow-xs">
                            Reset Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endcan

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Auto-generate username from name
            $('input[name="name"]').on('input', function() {
                if (!$('input[name="username"]').val()) {
                    let username = $(this).val()
                        .toLowerCase()
                        .trim()
                        .replace(/[^a-z0-9\s]/g, '') // Remove special characters
                        .replace(/\s+/g, '_'); // Replace spaces with underscores
                    $('input[name="username"]').val(username);
                }
            });

            // Password confirmation validation
            $('input[name="password_confirmation"]').on('input', function() {
                let password = $('input[name="password"]').val();
                let confirmPassword = $(this).val();

                if (password !== confirmPassword && confirmPassword.length > 0) {
                    $(this).addClass('is-invalid');
                    if (!$(this).next('.invalid-feedback').length) {
                        $(this).after('<div class="invalid-feedback">Passwords do not match</div>');
                    }
                } else {
                    $(this).removeClass('is-invalid');
                    $(this).next('.invalid-feedback').remove();
                }
            });
        });
    </script>
</x-app-layout>
