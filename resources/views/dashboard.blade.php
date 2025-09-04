<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Dashboard</title>
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
    <link rel="icon" href="{{ asset('templetes/kaiadmin-lite/assets/img/kaiadmin/favicon.ico') }}"
        type="image/x-icon" />

    <!-- Fonts and icons -->
    <script src="{{ asset('templetes/kaiadmin-lite/assets/js/plugin/webfont/webfont.min.js') }}"></script>
    <script>
        WebFont.load({
            google: {
                families: ["Public Sans:300,400,500,600,700"]
            },
            custom: {
                families: [
                    "Font Awesome 5 Solid",
                    "Font Awesome 5 Regular",
                    "Font Awesome 5 Brands",
                    "simple-line-icons",
                ],
                urls: ["{{ asset('templetes/kaiadmin-lite/assets/css/fonts.min.css') }}"],
            },
            active: function() {
                sessionStorage.fonts = true;
            },
        });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ asset('templetes/kaiadmin-lite/assets/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('templetes/kaiadmin-lite/assets/css/plugins.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('templetes/kaiadmin-lite/assets/css/kaiadmin.min.css') }}" />

    <!-- CSS Just for demo purpose, don't include it in your project -->

    <link rel="stylesheet" href="{{ asset('templetes/kaiadmin-lite/assets/css/demo.css') }}" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    @if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Success',
        text: "{{ session('success') }}",
    });
</script>
@endif

@if(session('error'))
<script>
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: "{{ session('error') }}",
    });
</script>
@endif

    {{-- @php
        dd(session()->all());
    @endphp --}}

    <div class="wrapper">
        <!-- Sidebar -->
        <div class="sidebar sidebar-style-2" data-background-color="dark">
            <div class="sidebar-logo">
                <!-- Logo Header -->
                <div class="logo-header" data-background-color="dark">
                    <a href="index.html" class="logo">
                        <img src="assets/img/kaiadmin/logo_light.svg" alt="navbar brand" class="navbar-brand"
                            height="20" />
                    </a>
                    <div class="nav-toggle">
                        <button class="btn btn-toggle toggle-sidebar">
                            <i class="gg-menu-right"></i>
                        </button>
                        <button class="btn btn-toggle sidenav-toggler">
                            <i class="gg-menu-left"></i>
                        </button>
                    </div>
                    <button class="topbar-toggler more">
                        <i class="gg-more-vertical-alt"></i>
                    </button>
                </div>
                <!-- End Logo Header -->
            </div>
            <div class="sidebar-wrapper scrollbar scrollbar-inner">
                <div class="sidebar-content">
                    <ul class="nav nav-secondary">
                        <li class="nav-item">
                            <a data-bs-toggle="collapse" href="#dashboard" class="collapsed" aria-expanded="false">
                                <i class="fas fa-home"></i>
                                <p>Dashboard</p>
                                <span class="caret"></span>
                            </a>
                            <div class="collapse" id="dashboard">
                                <ul class="nav nav-collapse">
                                    <li>
                                        <a href="../demo1/index.html">
                                            <span class="sub-item">Dashboard 1</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-section">
                            <span class="sidebar-mini-icon">
                                <i class="fa fa-ellipsis-h"></i>
                            </span>
                            <h4 class="text-section">Manu</h4>
                        </li>
                        @php
                            $menus = collect();
                            foreach (auth()->user()->getRoleNames() as $role) {
                                $roleMenus = collect(config('menu.' . $role, []));
                                $menus = $menus->merge($roleMenus);
                            }
                        @endphp

                        @foreach ($menus as $menu)
                            @php
                                $hasChildren = isset($menu['children']);
                                $isParentActive = false; // default

                                // Kalau menu punya route langsung
                                $routeUrl = null;
                                if (isset($menu['route'])) {
                                    $routeName   = is_array($menu['route']) ? $menu['route'][0] : $menu['route'];
                                    $routeParams = (is_array($menu['route']) && isset($menu['route']['params']))
                                                    ? $menu['route']['params']
                                                    : [];
                                    $routeUrl    = route($routeName, $routeParams);
                                    $isParentActive = request()->is(trim(parse_url($routeUrl, PHP_URL_PATH), '/').'*');
                                }
                            @endphp

                            {{-- Kalau parent ada children --}}
                            @if ($hasChildren)
                                @php
                                    foreach ($menu['children'] as $child) {
                                        $childRoute   = $child['route'][0];
                                        $childParams  = $child['route']['params'] ?? [];
                                        $childUrl     = route($childRoute, $childParams);

                                        if (request()->is(trim(parse_url($childUrl, PHP_URL_PATH), '/').'*')) {
                                            $isParentActive = true;
                                            break;
                                        }
                                    }
                                @endphp
                            @endif

                            <li class="nav-item {{ $isParentActive ? 'active submenu' : '' }}">
                                @if ($hasChildren)
                                    {{-- Collapsible Parent --}}
                                    <a data-bs-toggle="collapse" href="#{{ \Illuminate\Support\Str::slug($menu['name']) }}"
                                    aria-expanded="{{ $isParentActive ? 'true' : 'false' }}">
                                        <i class="fas fa-{{ $menu['icon'] }}"></i>
                                        <p>{{ $menu['name'] }}</p>
                                        <span class="caret"></span>
                                    </a>
                                    <div class="collapse {{ $isParentActive ? 'show' : '' }}" id="{{ \Illuminate\Support\Str::slug($menu['name']) }}">
                                        <ul class="nav nav-collapse">
                                            @foreach ($menu['children'] as $child)
                                                @php
                                                    $childRoute   = $child['route'][0];
                                                    $childParams  = $child['route']['params'] ?? [];
                                                    $childUrl     = route($childRoute, $childParams);
                                                    $childActive  = request()->is(trim(parse_url($childUrl, PHP_URL_PATH), '/').'*');
                                                @endphp
                                                <li class="{{ $childActive ? 'active' : '' }}">
                                                    <a href="{{ $childUrl }}">
                                                        <span class="sub-item">{{ $child['name'] }}</span>
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @else
                                    {{-- Normal Menu --}}
                                    @if ($routeUrl)
                                        <a href="{{ $routeUrl }}">
                                            <i class="fas fa-{{ $menu['icon'] }}"></i>
                                            <p>{{ $menu['name'] }}</p>
                                        </a>
                                    @endif
                                @endif
                            </li>
                        @endforeach

                    </ul>
                </div>
            </div>
        </div>
        <!-- End Sidebar -->

        <div class="main-panel">
            <div class="main-header">
                <div class="main-header-logo">
                    <!-- Logo Header -->
                    <div class="logo-header" data-background-color="dark">
                        <a href="index.html" class="logo">
                            <img src="assets/img/kaiadmin/logo_light.svg" alt="navbar brand" class="navbar-brand"
                                height="20" />
                        </a>
                        <div class="nav-toggle">
                            <button class="btn btn-toggle toggle-sidebar">
                                <i class="gg-menu-right"></i>
                            </button>
                            <button class="btn btn-toggle sidenav-toggler">
                                <i class="gg-menu-left"></i>
                            </button>
                        </div>
                        <button class="topbar-toggler more">
                            <i class="gg-more-vertical-alt"></i>
                        </button>
                    </div>
                    <!-- End Logo Header -->
                </div>
                <!-- Navbar Header -->
                <nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
                    <div class="container-fluid">
                        <nav
                            class="navbar navbar-header-left navbar-expand-lg navbar-form nav-search p-0 d-none d-lg-flex">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <button type="submit" class="btn btn-search pe-1">
                                        <i class="fa fa-search search-icon"></i>
                                    </button>
                                </div>
                                <input type="text" placeholder="Search ..." class="form-control" />
                            </div>
                        </nav>

                        <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
                            <li class="nav-item topbar-icon dropdown hidden-caret d-flex d-lg-none">
                                <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#"
                                    role="button" aria-expanded="false" aria-haspopup="true">
                                    <i class="fa fa-search"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-search animated fadeIn">
                                    <form class="navbar-left navbar-form nav-search">
                                        <div class="input-group">
                                            <input type="text" placeholder="Search ..." class="form-control" />
                                        </div>
                                    </form>
                                </ul>
                            </li>
                            <li class="nav-item topbar-icon dropdown hidden-caret">
                                <a class="nav-link dropdown-toggle" href="#" id="messageDropdown"
                                    role="button" data-bs-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                    <i class="fa fa-envelope"></i>
                                </a>
                                <ul class="dropdown-menu messages-notif-box animated fadeIn"
                                    aria-labelledby="messageDropdown">
                                    <li>
                                        <div class="dropdown-title d-flex justify-content-between align-items-center">
                                            Messages
                                            <a href="#" class="small">Mark all as read</a>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="message-notif-scroll scrollbar-outer">
                                            <div class="notif-center">
                                                <a href="#">
                                                    <div class="notif-img">
                                                        <img src="assets/img/jm_denis.jpg" alt="Img Profile" />
                                                    </div>
                                                    <div class="notif-content">
                                                        <span class="subject">Jimmy Denis</span>
                                                        <span class="block"> How are you ? </span>
                                                        <span class="time">5 minutes ago</span>
                                                    </div>
                                                </a>
                                                <a href="#">
                                                    <div class="notif-img">
                                                        <img src="assets/img/chadengle.jpg" alt="Img Profile" />
                                                    </div>
                                                    <div class="notif-content">
                                                        <span class="subject">Chad</span>
                                                        <span class="block"> Ok, Thanks ! </span>
                                                        <span class="time">12 minutes ago</span>
                                                    </div>
                                                </a>
                                                <a href="#">
                                                    <div class="notif-img">
                                                        <img src="assets/img/mlane.jpg" alt="Img Profile" />
                                                    </div>
                                                    <div class="notif-content">
                                                        <span class="subject">Jhon Doe</span>
                                                        <span class="block">
                                                            Ready for the meeting today...
                                                        </span>
                                                        <span class="time">12 minutes ago</span>
                                                    </div>
                                                </a>
                                                <a href="#">
                                                    <div class="notif-img">
                                                        <img src="assets/img/talha.jpg" alt="Img Profile" />
                                                    </div>
                                                    <div class="notif-content">
                                                        <span class="subject">Talha</span>
                                                        <span class="block"> Hi, Apa Kabar ? </span>
                                                        <span class="time">17 minutes ago</span>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <a class="see-all" href="javascript:void(0);">See all messages<i
                                                class="fa fa-angle-right"></i>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item topbar-icon dropdown hidden-caret">
                                <a class="nav-link dropdown-toggle" href="#" id="notifDropdown" role="button"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-bell"></i>
                                    <span class="notification">4</span>
                                </a>
                                <ul class="dropdown-menu notif-box animated fadeIn" aria-labelledby="notifDropdown">
                                    <li>
                                        <div class="dropdown-title">
                                            You have 4 new notification
                                        </div>
                                    </li>
                                    <li>
                                        <div class="notif-scroll scrollbar-outer">
                                            <div class="notif-center">
                                                <a href="#">
                                                    <div class="notif-icon notif-primary">
                                                        <i class="fa fa-user-plus"></i>
                                                    </div>
                                                    <div class="notif-content">
                                                        <span class="block"> New user registered </span>
                                                        <span class="time">5 minutes ago</span>
                                                    </div>
                                                </a>
                                                <a href="#">
                                                    <div class="notif-icon notif-success">
                                                        <i class="fa fa-comment"></i>
                                                    </div>
                                                    <div class="notif-content">
                                                        <span class="block">
                                                            Rahmad commented on Admin
                                                        </span>
                                                        <span class="time">12 minutes ago</span>
                                                    </div>
                                                </a>
                                                <a href="#">
                                                    <div class="notif-img">
                                                        <img src="assets/img/profile2.jpg" alt="Img Profile" />
                                                    </div>
                                                    <div class="notif-content">
                                                        <span class="block">
                                                            Reza send messages to you
                                                        </span>
                                                        <span class="time">12 minutes ago</span>
                                                    </div>
                                                </a>
                                                <a href="#">
                                                    <div class="notif-icon notif-danger">
                                                        <i class="fa fa-heart"></i>
                                                    </div>
                                                    <div class="notif-content">
                                                        <span class="block"> Farrah liked Admin </span>
                                                        <span class="time">17 minutes ago</span>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <a class="see-all" href="javascript:void(0);">See all notifications<i
                                                class="fa fa-angle-right"></i>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item topbar-icon dropdown hidden-caret">
                                <a class="nav-link" data-bs-toggle="dropdown" href="#" aria-expanded="false">
                                    <i class="fas fa-layer-group"></i>
                                </a>
                                <div class="dropdown-menu quick-actions animated fadeIn">
                                    <div class="quick-actions-header">
                                        <span class="title mb-1">Quick Actions</span>
                                        <span class="subtitle op-7">Shortcuts</span>
                                    </div>
                                    <div class="quick-actions-scroll scrollbar-outer">
                                        <div class="quick-actions-items">
                                            <div class="row m-0">
                                                <a class="col-6 col-md-4 p-0" href="#">
                                                    <div class="quick-actions-item">
                                                        <div class="avatar-item bg-danger rounded-circle">
                                                            <i class="far fa-calendar-alt"></i>
                                                        </div>
                                                        <span class="text">Calendar</span>
                                                    </div>
                                                </a>
                                                <a class="col-6 col-md-4 p-0" href="#">
                                                    <div class="quick-actions-item">
                                                        <div class="avatar-item bg-warning rounded-circle">
                                                            <i class="fas fa-map"></i>
                                                        </div>
                                                        <span class="text">Maps</span>
                                                    </div>
                                                </a>
                                                <a class="col-6 col-md-4 p-0" href="#">
                                                    <div class="quick-actions-item">
                                                        <div class="avatar-item bg-info rounded-circle">
                                                            <i class="fas fa-file-excel"></i>
                                                        </div>
                                                        <span class="text">Reports</span>
                                                    </div>
                                                </a>
                                                <a class="col-6 col-md-4 p-0" href="#">
                                                    <div class="quick-actions-item">
                                                        <div class="avatar-item bg-success rounded-circle">
                                                            <i class="fas fa-envelope"></i>
                                                        </div>
                                                        <span class="text">Emails</span>
                                                    </div>
                                                </a>
                                                <a class="col-6 col-md-4 p-0" href="#">
                                                    <div class="quick-actions-item">
                                                        <div class="avatar-item bg-primary rounded-circle">
                                                            <i class="fas fa-file-invoice-dollar"></i>
                                                        </div>
                                                        <span class="text">Invoice</span>
                                                    </div>
                                                </a>
                                                <a class="col-6 col-md-4 p-0" href="#">
                                                    <div class="quick-actions-item">
                                                        <div class="avatar-item bg-secondary rounded-circle">
                                                            <i class="fas fa-credit-card"></i>
                                                        </div>
                                                        <span class="text">Payments</span>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>

                            <li class="nav-item topbar-user dropdown hidden-caret">
                                <a class="dropdown-toggle profile-pic" data-bs-toggle="dropdown" href="#"
                                    aria-expanded="false">
                                    <div class="avatar-sm">
                                        <img src="{{ asset('templetes/kaiadmin-lite/assets/img/profile.jpg') }}"
                                            alt="..." class="avatar-img rounded-circle" />
                                    </div>
                                    <span class="profile-username">
                                        <span class="op-7">Hi,</span>
                                        <span class="fw-bold">{{ session('name') }}</span>
                                    </span>
                                </a>
                                <ul class="dropdown-menu dropdown-user animated fadeIn">
                                    <div class="dropdown-user-scroll scrollbar-outer">
                                        <li>
                                            <div class="user-box">
                                                <div class="avatar-lg">
                                                    <img src="{{ asset('templetes/kaiadmin-lite/assets/img/profile.jpg') }}"
                                                        alt="image profile" class="avatar-img rounded" />
                                                </div>
                                                <div class="u-text">
                                                    <h4>{{ session('name') }}</h4>
                                                    <p class="text-muted">{{ session('email') }}</p>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="dropdown-divider"></div>
                                            @if (session('is_impersonating'))
                                            <a class="dropdown-item" href="{{ route('users.impersonate.back') }}">Dashboard Admin</a>
                                            <div class="dropdown-divider"></div>
                                            @endif
                                            <a class="dropdown-item" href="#">My Profile</a>
                                            <a class="dropdown-item" href="#">Account Setting</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="{{ route('logout') }}"
                                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                Logout
                                            </a>

                                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                class="d-none">
                                                @csrf
                                            </form>

                                        </li>
                                    </div>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>
                <!-- End Navbar -->
            </div>

            <div class="container">
                <div class="page-inner">
                    <div class="page-header">
                        @php
                            $segments = Request::segments();
                        @endphp

                        <ul class="breadcrumbs mb-3">
                            {{-- Home --}}
                            <li class="nav-home">
                                <a href="{{ url('/') }}">
                                    <i class="icon-home"></i>
                                </a>
                            </li>

                            @foreach($segments as $index => $segment)
                                {{-- separator --}}
                                <li class="separator">
                                    <i class="icon-arrow-right"></i>
                                </li>

                                {{-- breadcrumb item --}}
                                <li class="nav-item {{ $loop->last ? 'active' : '' }}">
                                    @php
                                        $url = url(implode('/', array_slice($segments, 0, $index + 1)));

                                        // Clean up segment
                                        $label = is_numeric($segment)
                                            ? 'Show'
                                            : ucwords(str_replace('_', ' ', $segment));
                                    @endphp

                                    @if(!$loop->last)
                                        <a href="{{ $url }}">{{ $label }}</a>
                                    @else
                                        <span>{{ $label }}</span>
                                    @endif
                                </li>
                            @endforeach
                        </ul>

                    </div>

                    @if (Route::current()->getName() == '')
                    @endif
                    @yield('content')
                </div>
            </div>

            <footer class="footer">
                <div class="container-fluid d-flex justify-content-between">
                </div>
            </footer>
        </div>

    </div>

    <!--   Core JS Files   -->
    <script src="{{ asset('templetes/kaiadmin-lite/assets/js/core/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('templetes/kaiadmin-lite/assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('templetes/kaiadmin-lite/assets/js/core/bootstrap.min.js') }}"></script>
    {{-- <script src="assets/js/core/jquery-3.7.1.min.js"></script>
        <script src="assets/js/core/popper.min.js"></script>
        <script src="assets/js/core/bootstrap.min.js"></script> --}}

    <!-- Sweet Alert -->
    {{-- <script src="{{ asset('templetes/kaiadmin-lite/assets/js/plugin/sweetalert/sweetalert.min.js') }}"></script> --}}

    <!-- Kaiadmin JS -->
    <script src="{{ asset('templetes/kaiadmin-lite/assets/js/kaiadmin.min.js') }}"></script>


	<script src="{{ asset('templetes/kaiadmin-lite/assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>	<!-- Datatables -->
	<script src="{{ asset('templetes/kaiadmin-lite/assets/js/plugin/datatables/datatables.min.js') }}"></script>
	<script >
		$(document).ready(function() {
			$('#basic-datatables').DataTable({
			});
        })
    </script>
    <!-- Kaiadmin DEMO methods, don't include it in your project! -->
    {{-- <script src="{{ asset('templetes/kaiadmin-lite/assets/js/setting-demo.js') }}"></script>
    <script src="{{ asset('templetes/kaiadmin-lite/assets/js/demo.js') }}"></script> --}}
    <script>
        $("#lineChart").sparkline([102, 109, 120, 99, 110, 105, 115], {
            type: "line",
            height: "70",
            width: "100%",
            lineWidth: "2",
            lineColor: "#177dff",
            fillColor: "rgba(23, 125, 255, 0.14)",
        });

        $("#lineChart2").sparkline([99, 125, 122, 105, 110, 124, 115], {
            type: "line",
            height: "70",
            width: "100%",
            lineWidth: "2",
            lineColor: "#f3545d",
            fillColor: "rgba(243, 84, 93, .14)",
        });

        $("#lineChart3").sparkline([105, 103, 123, 100, 95, 105, 115], {
            type: "line",
            height: "70",
            width: "100%",
            lineWidth: "2",
            lineColor: "#ffa534",
            fillColor: "rgba(255, 165, 52, .14)",
        });
    </script>
</body>

</html>
