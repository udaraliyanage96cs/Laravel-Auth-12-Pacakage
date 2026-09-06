@push('title')
    User Management
@endpush

<x-app-layout>
    @can('create_user_management')
        <div class="row mb-4">
            <div class="col-md-12 d-flex justify-content-end">
                <button class="btn btn-success shadow-sm" data-bs-toggle="offcanvas" data-bs-target="#addUserOffcanvas">
                    <i class='bx bx-plus fs-5' title="Create A User"></i> New User
                </button>
            </div>
        </div>
    @endcan

    <div class="offcanvas offcanvas-end" id="addUserOffcanvas" aria-hidden="true">
        <div class="offcanvas-header border-bottom">
            <h6 class="offcanvas-title">New User</h6>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body flex-grow-1">
            <form action="/users/create" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="user-name" class="form-label">User Name</label>
                    <input type="text" id="user-name" class="form-control" name="name" placeholder="John Doe" />
                </div>
                <div class="mb-3">
                    <label for="user-email" class="form-label">User Email</label>
                    <input type="email" id="user-email" class="form-control" name="email"
                        placeholder="example@email.com" />
                </div>
                <div class="mb-4">
                    <label for="user-role" class="form-label">Role</label>
                    <select id="user-role" class="form-select" name="role">
                        <option selected>Select A Role</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}">{{ ucfirst($role->name) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3 d-flex justify-content-end flex-wrap">
                    <button type="button" class="btn btn-label-secondary  me-3"
                        data-bs-dismiss="offcanvas">Cancel</button>
                    <button type="submit" class="btn btn-success">Create</button>
                </div>
            </form>
        </div>
    </div>

    @can('view_user_management')
        <!-- Unified Filter & Table Card -->
        <div class="card custom-card rounded-3 shadow-sm border-0 mb-4 overflow-hidden">
            <!-- Filter Section -->
            <div class="card-body p-md-4">
                <form method="GET" action="{{ route('users.index') }}">
                    <div class="row g-3 align-items-end">
                        <div class="col-md-3">
                            <label class="form-label fw-semibold text-slate-600 mb-1">Search</label>
                            <input type="text" name="search" class="form-control rounded-3"
                                placeholder="Search by name or email..." value="{{ request('search') }}">
                        </div>

                        <div class="col-md-2">
                            <label class="form-label fw-semibold text-slate-600 mb-1">Role</label>
                            <select name="role" class="form-select rounded-3">
                                <option value="">All Roles</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->name }}" {{ request('role') == $role->name ? 'selected' : '' }}>
                                        {{ ucfirst($role->name) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label class="form-label fw-semibold text-slate-600 mb-1">Status</label>
                            <select name="approval" class="form-select rounded-3">
                                <option value="">All Statuses</option>
                                <option value="approved" {{ request('approval') == 'approved' ? 'selected' : '' }}>Approved
                                </option>
                                <option value="pending" {{ request('approval') == 'pending' ? 'selected' : '' }}>Pending
                                </option>
                                <option value="deleted" {{ request('approval') == 'deleted' ? 'selected' : '' }}>Deleted
                                </option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label for="date_range" class="form-label fw-semibold text-slate-600 mb-1">Created Date Range</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white text-slate-400 border-end-0 rounded-start-3">
                                    <i class="bx bx-calendar"></i>
                                </span>
                                <input type="text" name="date_range" id="date_range" class="form-control rounded-end-3 daterange-picker border-start-0 ps-0"
                                    value="{{ request('date_range') }}" placeholder="Select date range..." readonly>
                            </div>
                        </div>

                        <div class="col-md-2 d-flex align-items-end justify-content-end gap-2">
                            <button type="submit" class="btn btn-success btn-icon-square shadow-sm" title="Apply Filters"
                                data-bs-toggle="tooltip" data-bs-placement="top">
                                <i class="bx bx-search fs-5"></i>
                            </button>
                            <a href="{{ route('users.index') }}" class="btn btn-secondary btn-icon-square shadow-sm"
                                title="Reset Filters" data-bs-toggle="tooltip" data-bs-placement="top">
                                <i class="bx bx-refresh fs-5"></i>
                            </a>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Table Section -->
            <div class="table-responsive border-top">
                <table class="table custom-table mb-0" id="devtable">
                    <thead class="bg-dark">
                        <tr>
                            <th class="ps-3">User</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Approval</th>
                            <th>Created At</th>
                            <th class="text-end pe-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($users) > 0)
                            @foreach ($users as $user)
                                <tr>
                                    <td class="ps-3">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar me-3 flex-shrink-0">
                                                @if ($user->profile_picture)
                                                    <img src="{{ asset('assets/img/avatars/' . $user->profile_picture) }}" alt="Avatar"
                                                        class="w-px-40 h-px-40 rounded-circle shadow-xs" style="object-fit: cover;" />
                                                @else
                                                    <img src="{{ asset('assets/img/avatars/avt2.png') }}" alt="Avatar"
                                                        class="w-px-40 h-px-40 rounded-circle shadow-xs" style="object-fit: cover;" />
                                                @endif
                                            </div>
                                            <div>
                                                <div class="d-flex align-items-center gap-1">
                                                    <span class="fw-semibold text-slate-800 me-1"
                                                        style="font-size: 0.9rem;">{{ $user->name ?? '' }}</span>
                                                    @if ($user->email_verified_at && !$user->trashed())
                                                        <i class='bx bxs-badge-check text-primary' style="font-size: 1.05rem;"
                                                            title="Verified User" data-bs-toggle="tooltip"></i>
                                                    @endif
                                                </div>
                                                <div class="d-flex align-items-center gap-2 mt-1">
                                                    <span class="text-slate-500 small" style="font-size: 0.76rem;">ID : #{{ $user->id }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td><span class="text-slate-600">{{ $user->email }}</span></td>
                                    <td><span class="fw-semibold text-slate-700">{{ ucfirst($user->getRoleNames()->first()) }}</span>
                                    </td>
                                    <td>
                                        @if ($user->trashed())
                                            <span class="status-badge-deleted">Deleted</span>
                                        @elseif ($user->email_verified_at)
                                            <span class="status-badge-approved">Approved</span>
                                        @else
                                            <span class="status-badge-pending">Pending</span>
                                        @endif
                                    </td>
                                    <td><span class="text-slate-500">{{ $user->created_at->format('Y-m-d h:i A') }}</span></td>
                                    <td class="text-end text-nowrap">
                                        @if ($user->trashed())
                                            @can('view_user_management')
                                                <a class="btn btn-icon-square btn-action-teal shadow-sm me-1"
                                                    href="{{ route('users.show', $user->id) }}" title="View Profile" data-bs-toggle="tooltip">
                                                    <i class='bx bx-show fs-6'></i>
                                                </a>
                                            @endcan
                                            @if ($setting->restore_users == 1)
                                                @can('restore_user_management')
                                                    <a class="btn btn-icon-square btn-success shadow-sm me-1" href="/users/restore/{{ $user->id }}"
                                                        title="Restore User" data-bs-toggle="tooltip">
                                                        <i class='bx bx-recycle fs-6'></i>
                                                    </a>
                                                @endcan
                                            @endif
                                        @else
                                            @can('delete_user_management')
                                                @if (auth()->id() !== $user->id)
                                                    <button type="button" class="btn btn-icon-square btn-danger shadow-sm  me-1"
                                                        data-bs-toggle="modal" data-bs-target="#addNewCCModal-{{ $user->id }}"
                                                        title="Delete User"><i class="bx bx-trash fs-6"></i></button>
                                                @endif
                                            @endcan
                                            @can('update_user_management')
                                                <a class="btn btn-icon-square btn-info shadow-sm me-1"
                                                    href="{{ route('users.show', $user->id) }}" title="View Profile" data-bs-toggle="tooltip">
                                                    <i class='bx bx-show fs-6'></i>
                                                </a>
                                                <a class="btn btn-icon-square btn-primary shadow-sm me-1" href="/users/edit/{{ $user->id }}"
                                                    title="Edit User" data-bs-toggle="tooltip">
                                                    <i class='bx bxs-pencil fs-6'></i>
                                                </a>
                                                @if ($user->email_verified_at == '')
                                                    <button type="button" class="btn btn-icon-square btn-warning shadow-sm me-1"
                                                        data-bs-toggle="modal" data-bs-target="#approveModal-{{ $user->id }}" title="Approve User">
                                                        <i class='bx bxs-lock-open-alt fs-6'></i>
                                                    </button>
                                                @else
                                                    <button type="button" class="btn btn-icon-square btn-success shadow-sm me-1"
                                                        data-bs-toggle="modal" data-bs-target="#disapproveModal-{{ $user->id }}"
                                                        title="Disapprove User">
                                                        <i class='bx bxs-lock-alt fs-6'></i>
                                                    </button>
                                                @endif
                                            @endcan

                                        @endif
                                    </td>
                                </tr>
                                <!-- Modal for deletion confirmation -->
                                <div class="modal fade" id="addNewCCModal-{{ $user->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-simple modal-enable-otp modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-body text-center">
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                                <h3 class="fw-bold">Warning</h3>
                                                <p class="mt-3">Are you sure you want to delete this user?</p>
                                                <p class="mt-2 fw-semibold">User name :- {{ $user->name }}</p>
                                                <p class="mt-2 mb-3 text-muted">User Email :- {{ $user->email }}</p>
                                                <a href="/users/delete/{{ $user->id }}" class="btn btn-danger me-3">Delete</a>
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal for approve confirmation -->
                                <div class="modal fade" id="approveModal-{{ $user->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-simple modal-enable-otp modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-body text-center">
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                                <h3 class="fw-bold">Confirmation</h3>
                                                <p class="mt-3">Are you sure you want to approve this user?</p>
                                                <p class="mt-2 fw-semibold">User name :- {{ $user->name }}</p>
                                                <p class="mt-2 mb-3 text-muted">User Email :- {{ $user->email }}</p>
                                                <a href="/users/approval/{{ $user->id }}" class="btn btn-warning me-3">Approve</a>
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal for disapprove confirmation -->
                                <div class="modal fade" id="disapproveModal-{{ $user->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-simple modal-enable-otp modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-body text-center">
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                                <h3 class="fw-bold">Confirmation</h3>
                                                <p class="mt-3">Are you sure you want to disapprove this user?</p>
                                                <p class="mt-2 fw-semibold">User name :- {{ $user->name }}</p>
                                                <p class="mt-2 mb-3 text-muted">User Email :- {{ $user->email }}</p>
                                                <a href="/users/disapproval/{{ $user->id }}" class="btn btn-success me-3">Disapprove</a>
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">No Data Available</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            <!-- Footer Pagination -->
            <div class="px-3 py-3 border-top d-flex justify-content-between align-items-center flex-wrap bg-white">
                <div class="table-footer-text mb-2 mb-md-0">
                    Showing {{ $users->firstItem() ?? 0 }} to {{ $users->lastItem() ?? 0 }} of {{ $users->total() }} users
                </div>
                <div>
                    {{ $users->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    @endcan
</x-app-layout>