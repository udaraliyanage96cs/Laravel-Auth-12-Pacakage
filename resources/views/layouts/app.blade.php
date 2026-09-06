<!DOCTYPE html>

<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed" dir="ltr" data-theme="theme-default"
    data-assets-path="/assets/" data-template="vertical-menu-template">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>{{ env('APP_NAME') }} | @stack('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('assets/img/favicon/favicon.svg') }}" />
    <link rel="alternate icon" type="image/x-icon" href="{{ asset('assets/img/favicon/favicon.svg') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Rubik:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/boxicons.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/fontawesome.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/flag-icons.css') }}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/core.css') }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/theme-default.css') }}" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/typeahead-js/typeahead.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/apex-charts/apex-charts.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.css') }}" />

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="{{ asset('assets/vendor/js/helpers.js') }}"></script>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->

            <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
                <div class="app-brand demo">
                    <a href="/" class="app-brand-link">
                        <span class="app-brand-logo demo">
                            <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
                        </span>
                        <span class="app-brand-text demo menu-text fw-bold ms-2">{{ env('APP_NAME') }}</span>
                    </a>
                </div>

                <div class="menu-divider mt-0"></div>

                <div class="menu-inner-shadow"></div>

                <ul class="menu-inner py-1">
                    <li class="menu-item {{ Request::is('dashboard*') ? 'active' : '' }}">
                        <a href="/dashboard" class="menu-link">
                            <i class='menu-icon bx bxs-dashboard'></i>
                            <div data-i18n="Support">Dashboard</div>
                        </a>
                    </li>
                    <li class="menu-header small text-uppercase">
                        <span class="menu-header-text">ADMINISTRATION</span>
                    </li>

                    @if(auth()->user()->can('user_management') || auth()->user()->can('role_management'))
                        <li class="menu-item {{ Request::is('users*') || Request::is('roles*') ? 'active open' : '' }}">
                            <a href="javascript:void(0);" class="menu-link menu-toggle">
                                <i class='menu-icon bx bx-group'></i>
                                <div data-i18n="Access Control">Access Control</div>
                            </a>
                            <ul class="menu-sub">
                                @can('user_management')
                                    <li class="menu-item {{ Request::is('users*') ? 'active' : '' }}">
                                        <a href="/users" class="menu-link">
                                            <div data-i18n="Users Management">Users Management</div>
                                        </a>
                                    </li>
                                @endcan
                                @can('role_management')
                                    <li class="menu-item {{ Request::is('roles*') ? 'active' : '' }}">
                                        <a href="/roles" class="menu-link">
                                            <div data-i18n="Roles & RBAC">Roles & RBAC</div>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </li>
                    @endif

                    @can('notification_management')
                        <li class="menu-item {{ Request::is('notifications*') ? 'active' : '' }}">
                            <a href="/notifications" class="menu-link">
                                <i class='menu-icon bx bxs-bell'></i>
                                <div data-i18n="Notifications">Notifications</div>
                            </a>
                        </li>
                    @endcan

                    @can('activity_management')
                        <li class="menu-item {{ Request::is('activity-log*') ? 'active' : '' }}">
                            <a href="/activity-log" class="menu-link">
                                <i class='menu-icon bx bxs-book-content'></i>
                                <div data-i18n="Support">Activity Management</div>
                            </a>
                        </li>
                    @endcan

                    @can('setting_management')
                        <li class="menu-item {{ Request::is('settings*') ? 'active' : '' }}">
                            <a href="/settings" class="menu-link">
                                <i class='menu-icon bx bxs-cog'></i>
                                <div data-i18n="Support">Settings Management</div>
                            </a>
                        </li>
                    @endcan



                </ul>
            </aside>
            <!-- / Menu -->

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->

                <nav class="layout-navbar navbar navbar-expand-xl align-items-center bg-navbar-theme"
                    id="layout-navbar">
                    <div class="container-fluid">
                        <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0">
                            <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                                <i class="bx bx-menu bx-sm"></i>
                            </a>
                        </div>

                        <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">

                            <ul class="navbar-nav flex-row align-items-center ms-auto">

                                <!-- Notification -->
                                @can('notification_management')
                                    <li class="nav-item dropdown-notifications navbar-dropdown dropdown me-3 me-xl-2">
                                        <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);"
                                            data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                                            <i class="bx bx-bell bx-sm"></i>
                                            <span
                                                class="badge bg-danger rounded-pill badge-notifications">{{ count($notifications) }}</span>
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-end py-0">
                                            <li class="dropdown-menu-header border-bottom">
                                                <div class="dropdown-header d-flex align-items-center py-3">
                                                    <h5 class="text-body mb-0 me-auto">Notification</h5>
                                                    <form action="{{ route('notifications.readAll') }}" method="POST">
                                                        @csrf
                                                        <button type="submit" title="Mark all as read"><i
                                                                class="bx fs-4 bx-envelope-open"></i></button>
                                                    </form>

                                                </div>
                                            </li>
                                            <li class="dropdown-notifications-list scrollable-container">
                                                <ul class="list-group list-group-flush">
                                                    @foreach ($notifications as $notification)
                                                        <li
                                                            class="list-group-item list-group-item-action dropdown-notifications-item">
                                                            <div class="d-flex">
                                                                <div class="flex-shrink-0 me-3">
                                                                    <div class="avatar">
                                                                        @if (isset($notification->data['sender']) && $notification->data['sender']['profile_picture'])
                                                                            <img src="{{ asset('assets/img/avatars/' . $notification->data['sender']['profile_picture']) }}"
                                                                                alt class="w-px-40 h-auto rounded-circle" />
                                                                        @else
                                                                            <img src="{{ asset('assets/img/avatars/avt2.png') }}"
                                                                                alt class="w-px-40 h-auto rounded-circle" />
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                <div class="flex-grow-1">
                                                                    <h6 class="mb-1">{{ $notification->data['title'] }}
                                                                    </h6>
                                                                    <p class="mb-0">
                                                                        {{ \Illuminate\Support\Str::limit($notification->data['message'], 100, '...') }}
                                                                    </p>
                                                                    <small
                                                                        class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </li>
                                            <li class="dropdown-menu-footer border-top">
                                                <a href="/notifications"
                                                    class="dropdown-item d-flex justify-content-center p-3">
                                                    View all notifications
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                @endcan
                                <!--/ Notification -->

                                <!-- User -->
                                <li class="nav-item navbar-dropdown dropdown-user dropdown">
                                    <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);"
                                        data-bs-toggle="dropdown">
                                        <div class="avatar avatar-online">
                                            @if (Auth::User()->profile_picture)
                                                <img src="{{ asset('assets/img/avatars/' . Auth::User()->profile_picture) }}"
                                                    alt class="w-px-40 h-auto rounded-circle" />
                                            @else
                                                <img src="{{ asset('assets/img/avatars/avt2.png') }}" alt
                                                    class="w-px-40 h-auto rounded-circle" />
                                            @endif
                                        </div>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a class="dropdown-item" href="#">
                                                <div class="d-flex">
                                                    <div class="flex-shrink-0 me-3">
                                                        <div class="avatar avatar-online">
                                                            @if (Auth::User()->profile_picture)
                                                                <img src="{{ asset('assets/img/avatars/' . Auth::User()->profile_picture) }}"
                                                                    alt class="w-px-40 h-auto rounded-circle" />
                                                            @else
                                                                <img src="{{ asset('assets/img/avatars/avt2.png') }}" alt
                                                                    class="w-px-40 h-auto rounded-circle" />
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <span
                                                            class="fw-semibold d-block lh-1">{{ Auth::User()->name }}</span>
                                                        <small>{{ Auth::User()->getRoleNames()->first() }}</small>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <div class="dropdown-divider"></div>
                                        </li>
                                        <x-slot name="content">
                                            <form method="POST" action="{{ route('logout') }}">
                                                @csrf

                                                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault();
                                                                this.closest('form').submit();">
                                                    {{ __('Log Out') }}
                                                </x-dropdown-link>
                                            </form>
                                        </x-slot>
                                        <li>
                                            <x-dropdown-link :href="route('profile.edit')">
                                                <i class="bx bx-user me-2"></i>
                                                <span class="align-middle">My Profile</span>
                                            </x-dropdown-link>
                                        </li>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <li>
                                                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                                    <i class="bx bx-power-off me-2"></i>
                                                    <span class="align-middle">Log Out</span>
                                                </x-dropdown-link>
                                            </li>
                                        </form>
                                    </ul>
                                </li>
                                <!--/ User -->
                            </ul>

                        </div>

                        <!-- Search Small Screens -->
                        <div class="navbar-search-wrapper search-input-wrapper d-none">
                            <input type="text" class="form-control search-input container-fluid border-0"
                                placeholder="Search..." aria-label="Search..." />
                            <i class="bx bx-x bx-sm search-toggler cursor-pointer"></i>
                        </div>
                    </div>
                </nav>

                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->

                    <div class="flex-grow-1">
                        <div class="row">
                            <main>
                                <div class="alertbox">
                                    @if (session('success'))
                                        <div class="bs-toast toast fade show" role="alert" aria-live="assertive"
                                            aria-atomic="true" id="success-alert">
                                            <div class="toast-header bg-success">
                                                <div class="me-auto fw-semibold">{{ env('APP_NAME') }} Alerts</div>
                                                <button type="button" class="btn-close" data-bs-dismiss="toast"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="toast-body">{{ session('success') }}</div>
                                        </div>
                                    @endif

                                    @if (session('info'))
                                        <div class="bs-toast toast fade show" role="alert" aria-live="assertive"
                                            aria-atomic="true" id="success-alert">
                                            <div class="toast-header bg-info">
                                                <div class="me-auto fw-semibold">{{ env('APP_NAME') }} Alerts</div>
                                                <button type="button" class="btn-close" data-bs-dismiss="toast"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="toast-body">{{ session('info') }}</div>
                                        </div>
                                    @endif

                                    @if (session('warning'))
                                        <div class="bs-toast toast fade show" role="alert" aria-live="assertive"
                                            aria-atomic="true" id="success-alert">
                                            <div class="toast-header bg-warning">
                                                <div class="me-auto fw-semibold">{{ env('APP_NAME') }} Alerts</div>
                                                <button type="button" class="btn-close" data-bs-dismiss="toast"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="toast-body">{{ session('warning') }}</div>
                                        </div>
                                    @endif

                                    @if (session('danger'))
                                        <div class="bs-toast toast fade show" role="alert" aria-live="assertive"
                                            aria-atomic="true" id="success-alert">
                                            <div class="toast-header bg-danger">
                                                <div class="me-auto fw-semibold">{{ env('APP_NAME') }} Alerts</div>
                                                <button type="button" class="btn-close" data-bs-dismiss="toast"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="toast-body">{{ session('danger') }}</div>
                                        </div>
                                    @endif

                                    @if($errors->any())
                                        <div class="bs-toast toast fade show" role="alert" aria-live="assertive"
                                            aria-atomic="true" id="success-alert">
                                            <div class="toast-header bg-danger">
                                                <div class="me-auto fw-semibold">{{ env('APP_NAME') }} Alerts</div>
                                                <button type="button" class="btn-close" data-bs-dismiss="toast"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="toast-body">{{ $errors->first() }}</div>
                                        </div>
                                    @endif
                                </div>
                                {{ $slot }}
                            </main>
                        </div>
                    </div>
                    <!-- / Content -->

                    <!-- Footer -->
                    <footer class="content-footer footer bg-footer-theme mb-3">
                        <div
                            class="d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
                            <div class="mb-2 mb-md-0">
                                ©
                                <script>
                                    document.write(new Date().getFullYear());
                                </script>
                                made with ❤️ by
                                <a href="https://udarax.me" target="_blank" class="footer-link fw-semibold">UDARAX</a>
                            </div>
                        </div>
                    </footer>
                    <!-- / Footer -->

                    <div class="content-backdrop fade"></div>
                </div>
                <!-- Content wrapper -->
            </div>
            <!-- / Layout page -->
        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>

        <!-- Drag Target Area To SlideIn Menu On Small Screens -->
        <div class="drag-target"></div>
    </div>
    <!-- / Layout wrapper -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>

    <script src="{{ asset('assets/vendor/libs/hammer/hammer.js') }}"></script>

    <script src="{{ asset('assets/vendor/libs/i18n/i18n.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/typeahead-js/typeahead.js') }}"></script>

    <script src="{{ asset('assets/vendor/js/menu.js') }}"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="{{ asset('assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/moment/moment.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.js') }}"></script>

    <!-- Main JS -->
    <script src="{{ asset('assets/js/config.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script>
        $("#success-alert, #info-alert, #warning-alert, #danger-alert, #validation-alert").fadeTo(5000, 500).slideUp(500, function () {
            $(this).slideUp(500);
        });

        // Initialize Bootstrap tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Initialize Bootstrap Date Range Pickers
        $(".daterange-picker").each(function () {
            var $input = $(this);
            var currentVal = $input.val();
            var startDate = null;
            var endDate = null;

            // Parse persisted value (format: "YYYY-MM-DD to YYYY-MM-DD")
            if (currentVal && currentVal.indexOf(' to ') !== -1) {
                var parts = currentVal.split(' to ');
                startDate = moment(parts[0].trim(), 'YYYY-MM-DD');
                endDate   = moment(parts[1].trim(), 'YYYY-MM-DD');
            }

            var options = {
                autoUpdateInput: false,
                showDropdowns: true,
                linkedCalendars: false,
                ranges: {
                    'Today':        [moment(), moment()],
                    'Yesterday':    [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days':  [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month':   [moment().startOf('month'), moment().endOf('month')],
                    'Last Month':   [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
                locale: {
                    format: 'YYYY-MM-DD',
                    separator: ' to ',
                    applyLabel: 'Apply',
                    cancelLabel: 'Clear'
                }
            };

            if (startDate && endDate) {
                options.startDate = startDate;
                options.endDate   = endDate;
            }

            $input.daterangepicker(options, function (start, end) {
                $input.val(start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
            });

            // Clear button resets the field
            $input.on('cancel.daterangepicker', function () {
                $input.val('');
            });
        });
    </script>

    <!-- Page JS -->
</body>

</html>