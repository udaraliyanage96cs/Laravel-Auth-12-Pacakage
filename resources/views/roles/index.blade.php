<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

@push('title')
    Roles & Permissions
@endpush

<x-app-layout>
    <div class="">
        <div class="">
            <h5 class="py-3 breadcrumb-wrapper mb-2">Roles List</h5>

            <p>
                A role provided access to predefined menus and features so that depending on <br>
                assigned role an administrator can have access to what user needs.
            </p>

            <div class="row g-4">
                @can('view_role_management')
                    @foreach ($roles as $role)
                        <div class="col-xl-4 col-lg-6 col-md-6">
                            <div class="card">
                                <div class="card-body d-flex flex-column justify-content-between">
                                    <div class="d-flex justify-content-between mb-2">
                                        <h6 class="fw-normal">Total {{ count($role->users) }} {{ ucwords($role->name) }}s
                                        </h6>
                                        <ul class="list-unstyled d-flex align-items-center avatar-group mb-0">
                                            @foreach ($role->users->sortByDesc('created_at')->take(10) as $user)
                                                @if ($user->profile_picture)
                                                    <li data-bs-toggle="tooltip" data-popup="tooltip-custom"
                                                        data-bs-placement="top" class="avatar avatar-sm pull-up"
                                                        aria-label="Vinnie Mostowy">
                                                        <img class="rounded-circle"
                                                            src="{{ asset('assets/img/avatars/' . $user->profile_picture) }}"
                                                            alt="Avatar">
                                                    </li>
                                                @else
                                                    <li data-bs-toggle="tooltip" data-popup="tooltip-custom"
                                                        data-bs-placement="top" class="avatar avatar-sm pull-up"
                                                        aria-label="Vinnie Mostowy">
                                                        <img class="rounded-circle"
                                                            src="{{ asset('assets/img/avatars/avt2.png') }}"
                                                            alt="Avatar">
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-end mt-3">
                                        <div class="role-heading">
                                            <h5 class="mb-1">{{ ucfirst($role->name) }}</h5>
                                            <a href="javascript:;" data-bs-toggle="modal"
                                                data-bs-target="#viewRoleModal-{{ $role->id }}"
                                                class="role-edit-modal"><small>View Permissions</small></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="viewRoleModal-{{ $role->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered modal-add-new-role">
                                <div class="modal-content p-3 p-md-5">
                                    <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                    <div class="modal-body">
                                        <div class="text-center mb-4">
                                            <h3 class="role-title">Permissions</h3>
                                        </div>
                                        <form method="POST" action="{{ route('role.updatePermissions', $role->id) }}">
                                            @csrf
                                            @php $i = 0; @endphp
                                            @foreach ($modules as $key => $module)
                                                <div class="row sm-flex">
                                                    <div class="col-md-11 sm-80">
                                                        <strong>{{ ucwords(str_replace('_', ' ', $key)) }}</strong>
                                                    </div>
                                                    <div class="col-md-1 sm-20">
                                                        <input class="form-check-input me-2 permission parent_permissions"
                                                            type="checkbox" name="permission_names[]"
                                                            value="{{ strtolower($key) }}" @disabled(
                                                                ($role->name === 'admin' && !auth()->user()->hasrole('admin')) ||
                                                                    !Auth::user()->can('update_role_management') ||
                                                                    Auth::user()->hasrole($role->name))
                                                            @checked($role->hasPermissionTo(str_replace(' ', '_', strtolower($key))))>
                                                    </div>
                                                </div>
                                                <div class="row mb-3 mt-2">
                                                    @foreach ($module as $action)
                                                        <div class="col-md-2">
                                                            <div class="">
                                                                <input
                                                                    class="form-check-input me-2 permission child_permissions"
                                                                    type="checkbox" name="permission_names[]"
                                                                    value="{{ $action . '_' . str_replace(' ', '_', strtolower($key)) }}"
                                                                    @disabled(
                                                                        ($role->name === 'admin' && !auth()->user()->hasrole('admin')) ||
                                                                            !Auth::user()->can('update_role_management') ||
                                                                            Auth::user()->hasrole($role->name))
                                                                    @checked($role->hasPermissionTo($action . '_' . strtolower($key)))>
                                                                <label for="">{{ ucwords($action) }}</label>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                @if ($i < count($modules) - 1)
                                                    <hr>
                                                @endif
                                                @php $i++; @endphp
                                            @endforeach
                                            @can('update_role_management')
                                                @if (!($role->name === 'admin' && !auth()->user()->hasrole('admin')) && !Auth::user()->hasrole($role->name))
                                                    <div class="d-flex justify-content-end mt-3">
                                                        <button type="submit" class="btn btn-success">Update Permissions</button>
                                                    </div>
                                                @endif
                                            @endcan
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endcan
                @can('create_role_management')
                    <div class="col-xl-4 col-lg-6 col-md-6">
                        <div class="card">
                            <div class="row g-0 align-items-center my-auto">
                                <div class="col-sm-5 text-center">
                                    <div class="p-2">
                                        <img src="{{ asset('assets/img/illustrations/lady-with-laptop-light.png') }}"
                                            class="img-fluid" alt="Image" width="100"
                                            data-app-light-img="illustrations/lady-with-laptop-light.png"
                                            data-app-dark-img="illustrations/lady-with-laptop-dark.png">
                                    </div>
                                </div>
                                <div class="col-sm-7">
                                    <div class="card-body text-sm-end text-center ps-sm-0">
                                        <button data-bs-target="#addRoleModal" data-bs-toggle="modal"
                                            class="btn btn-success mb-3 text-nowrap add-new-role">
                                            Add New Role
                                        </button>
                                        <p class="mb-0 text-muted small">Add role, if it does not exist</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="addRoleModal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered modal-add-new-role">
                            <div class="modal-content p-3 p-md-5">
                                <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                                <div class="modal-body">
                                    <div class="text-center mb-4">
                                        <h3 class="role-title">Add New Role</h3>
                                        <p>Set role permissions</p>
                                    </div>
                                    <!-- Add role form -->
                                    <form id="addRoleForm" class="row g-3" action="{{ route('roles.store') }}"
                                        method="POST">
                                        @csrf
                                        <div class="col-12 mb-4">
                                            <label class="form-label" for="modalRoleName">Role Name</label>
                                            <input type="text" id="name" name="name" class="form-control"
                                                required placeholder="Enter a role name" tabindex="-1" />
                                        </div>
                                        <div class="col-12 text-center">
                                            <button type="reset" class="btn btn-label-secondary me-sm-3 me-1"
                                                data-bs-dismiss="modal" aria-label="Close">
                                                Cancel
                                            </button>
                                            <button type="submit" class="btn btn-success me-sm-3 me-1">Submit</button>
                                        </div>
                                    </form>
                                    <!--/ Add role form -->
                                </div>
                            </div>
                        </div>
                    </div>
                @endcan

            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" crossorigin="anonymous"></script>
    <script>
        $('.parent_permissions').change(function() {
            var parentCheckbox = $(this);
            var isChecked = parentCheckbox.prop('checked');
            parentCheckbox.closest('.row').next('.row').find('.child_permissions').prop('checked', isChecked);
        });
    </script>
</x-app-layout>
