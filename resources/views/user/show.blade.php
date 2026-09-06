@push('title')
    User Profile
@endpush

<x-app-layout>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-3" role="alert" id="success-alert">
            <i class="bx bx-check-circle me-1"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
            <i class="bx bx-x-circle me-1"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row g-4 align-items-start">

        {{-- LEFT: Profile Info Card --}}
        <div class="col-xl-3 col-lg-4">
            <div class="card custom-card">
                <div class="card-body p-4">

                    {{-- Avatar + Name --}}
                    <div class="text-center mb-4">
                        <div class="mb-3 d-flex justify-content-center">
                            @if ($user->profile_picture)
                                <img src="{{ asset('assets/img/avatars/' . $user->profile_picture) }}" alt="Avatar"
                                    class="rounded-circle shadow-sm mx-auto d-block" style="width:72px; height:72px; object-fit:cover;" />
                            @else
                                <img src="{{ asset('assets/img/avatars/avt2.png') }}" alt="Avatar"
                                    class="rounded-circle shadow-sm mx-auto d-block" style="width:72px; height:72px; object-fit:cover;" />
                            @endif
                        </div>
                        <h6 class="fw-bold mb-1" style="color:#1e293b;">{{ $user->name }}</h6>
                        <p class="text-muted mb-2" style="font-size:0.8rem;">{{ $user->email }}</p>

                        {{-- Status --}}
                        @if($user->trashed())
                            <span class="status-badge-deleted">
                                <i class="bx bx-trash me-1"></i> Deleted
                            </span>
                        @elseif($user->email_verified_at)
                            <span class="status-badge-approved">
                                <i class="bx bx-check-circle me-1"></i> Active
                            </span>
                        @else
                            <span class="status-badge-pending">
                                <i class="bx bx-time-five me-1"></i> Pending
                            </span>
                        @endif
                    </div>

                    <hr style="border-color:#f1f5f9;">

                    <div class="mb-3">
                        <span class="d-block text-muted mb-1"
                            style="font-size:0.72rem;text-transform:uppercase;letter-spacing:0.05em;">Assigned
                            Roles</span>
                        @if($user->roles->isNotEmpty())
                            @foreach($user->roles as $role)
                                <span class="badge badge-service text-uppercase me-1"
                                    style="font-size:0.68rem;letter-spacing:0.05em;">
                                    {{ $role->name }}
                                </span>
                            @endforeach
                        @else
                            <em class="text-muted small">No roles assigned</em>
                        @endif
                    </div>

                    <div class="mb-3">
                        <span class="d-block text-muted mb-1"
                            style="font-size:0.72rem;text-transform:uppercase;letter-spacing:0.05em;">Created On</span>
                        <strong style="font-size:0.875rem;color:#1e293b;">
                            {{ $user->created_at ? $user->created_at->format('Y-m-d H:i:s') : 'N/A' }}
                        </strong>
                    </div>

                    <div class="mb-3">
                        <span class="d-block text-muted mb-1"
                            style="font-size:0.72rem;text-transform:uppercase;letter-spacing:0.05em;">Last
                            Updated</span>
                        <strong style="font-size:0.875rem;color:#1e293b;">
                            {{ $user->updated_at ? $user->updated_at->format('Y-m-d H:i:s') : 'N/A' }}
                        </strong>
                    </div>

                    @if($user->email_verified_at)
                        <div class="mb-3">
                            <span class="d-block text-muted mb-1"
                                style="font-size:0.72rem;text-transform:uppercase;letter-spacing:0.05em;">Email
                                Verified</span>
                            <strong style="font-size:0.875rem;color:#1e293b;">
                                {{ $user->email_verified_at->format('Y-m-d H:i:s') }}
                            </strong>
                        </div>
                    @endif

                    <hr style="border-color:#f1f5f9;">

                    {{-- Action Buttons --}}
                    <div class="d-flex justify-content-center gap-2 flex-wrap">
                        <a href="{{ route('users.index') }}" class="btn btn-icon-square btn-secondary shadow-sm"
                            title="Back to Users" data-bs-toggle="tooltip">
                            <i class="bx bx-arrow-back fs-6"></i>
                        </a>

                        @can('update_user_management')
                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-icon-square btn-primary shadow-sm"
                                title="Edit User" data-bs-toggle="tooltip">
                                <i class="bx bxs-pencil fs-6"></i>
                            </a>
                        @endcan

                        @can('approve_user_management')
                            @if(!$user->email_verified_at && !$user->trashed())
                                <button class="btn btn-icon-square btn-success shadow-sm" data-bs-toggle="modal"
                                    data-bs-target="#approveUserModal" title="Approve User" data-bs-toggle="tooltip">
                                    <i class="bx bx-check fs-6"></i>
                                </button>
                            @endif
                            @if($user->email_verified_at && !$user->trashed())
                                <button class="btn btn-icon-square btn-warning shadow-sm" data-bs-toggle="modal"
                                    data-bs-target="#disapproveUserModal" title="Deactivate User" data-bs-toggle="tooltip">
                                    <i class="bx bx-block fs-6"></i>
                                </button>
                            @endif
                        @endcan

                        @can('delete_user_management')
                            @if(!$user->trashed() && auth()->id() !== $user->id)
                                <button class="btn btn-icon-square btn-danger shadow-sm" data-bs-toggle="modal"
                                    data-bs-target="#deleteUserModal" title="Delete User" data-bs-toggle="tooltip">
                                    <i class="bx bx-trash fs-6"></i>
                                </button>
                            @endif
                        @endcan
                    </div>

                </div>
            </div>
        </div>

        {{-- RIGHT: Activity Log --}}
        <div class="col-xl-9 col-lg-8">

            <div class="card custom-card overflow-hidden">
                <div class="card-header border-bottom bg-transparent py-3 px-4">
                    <h6 class="fw-bold mb-1" style="color:#1e293b;">User Activity Log</h6>
                    <p class="text-muted mb-0" style="font-size:0.8rem;">Audit record for events associated with this
                        user account.</p>
                </div>

                <div class="table-responsive">
                    <table class="table custom-table mb-0">
                        <thead>
                            <tr>
                                <th class="ps-4">Timestamp</th>
                                <th>Action</th>
                                <th>Description</th>
                                <th class="pe-4">Model</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($logs as $log)
                                @php $actionLower = strtolower($log->action); @endphp
                                <tr>
                                    <td class="ps-4">
                                        <div style="font-size:0.875rem;color:#334155;font-weight:500;">
                                            {{ $log->created_at->format('Y-m-d H:i:s') }}
                                        </div>
                                        <div style="font-size:0.75rem;color:#94a3b8;">
                                            {{ $log->created_at->diffForHumans() }}
                                        </div>
                                    </td>
                                    <td>
                                        @if(in_array($actionLower, ['created', 'stored', 'login', 'approved', 'restored']))
                                            <span class="badge status-badge-approved">{{ ucfirst($log->action) }}</span>
                                        @elseif(in_array($actionLower, ['updated', 'edited', 'rotated', 'reset password']))
                                            <span class="badge bg-label-info">{{ ucfirst($log->action) }}</span>
                                        @elseif(in_array($actionLower, ['deleted', 'destroyed', 'delete']))
                                            <span class="badge status-badge-deleted">{{ ucfirst($log->action) }}</span>
                                        @elseif(in_array($actionLower, ['disapproved', 'disabled', 'logout', 'deactivate']))
                                            <span class="badge status-badge-pending">{{ ucfirst($log->action) }}</span>
                                        @else
                                            <span class="badge badge-service">{{ ucfirst($log->action) }}</span>
                                        @endif
                                    </td>
                                    <td style="font-size:0.875rem;color:#475569;max-width:260px;">
                                        {{ $log->description ?? '—' }}
                                    </td>
                                    <td class="pe-4">
                                        @if($log->model_type)
                                            <span class="badge badge-service" style="font-size:0.68rem;">
                                                {{ class_basename($log->model_type) }}
                                                @if($log->model_id) #{{ $log->model_id }} @endif
                                            </span>
                                        @else
                                            <span class="text-muted small">—</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5 text-muted">
                                        <i class="bx bx-history d-block mb-2" style="font-size:2rem;color:#cbd5e1;"></i>
                                        No activity logs found for this user.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    {{-- ========== MODALS ========== --}}

    @can('delete_user_management')
        @if(!$user->trashed() && auth()->id() !== $user->id)
            <div class="modal fade" id="deleteUserModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Confirm Delete</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure you want to delete <strong>{{ $user->name }}</strong>?</p>
                            <div class="alert alert-danger py-2 px-3" style="font-size:0.875rem;">
                                <i class="bx bx-error-circle me-1"></i> This action cannot be undone.
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                            <a href="{{ route('users.destroy', $user->id) }}" class="btn btn-danger btn-sm">
                                <i class="bx bx-trash me-1"></i> Delete
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endcan

    @can('approve_user_management')
        @if(!$user->email_verified_at && !$user->trashed())
            <div class="modal fade" id="approveUserModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Approve User</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <p>Approve <strong>{{ $user->name }}</strong> and grant them system access?</p>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                            <a href="{{ route('users.approval', $user->id) }}" class="btn btn-success btn-sm">
                                <i class="bx bx-check me-1"></i> Approve
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if($user->email_verified_at && !$user->trashed())
            <div class="modal fade" id="disapproveUserModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Deactivate User</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <p>Deactivate <strong>{{ $user->name }}</strong>? They will lose access until re-approved.</p>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                            <a href="{{ route('users.disapproval', $user->id) }}" class="btn btn-warning btn-sm">
                                <i class="bx bx-block me-1"></i> Deactivate
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endcan

</x-app-layout>