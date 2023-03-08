<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>cctv powerball | Dashboard</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('admin/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet"
        href="{{ asset('admin/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('admin/dist/css/adminlte.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('admin/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset('admin/plugins/daterangepicker/daterangepicker.css') }}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{ asset('admin/plugins/summernote/summernote-bs4.min.css') }}">
    <!-- video types -->
    <link rel="stylesheet" href="{{ asset('main/css/videoT.css') }}">
    <!-- video list -->
    <link rel="stylesheet" href="{{ asset('main/css/videolist.css') }}">
    <!-- balancing -->
    <link rel="stylesheet" href="{{ asset('main/css/balancing.css') }}">
    <!-- datatable -->
    <link rel="stylesheet" href="{{asset('main/js/simple-datatables/style.css')}}">




    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="{{ asset('admin/dist/img/AdminLTELogo.png') }}" alt="AdminLTELogo"
                height="60" width="60">
        </div>

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="/" class="nav-link">{{ __('public.main') }}</a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- language select -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        Languages
                    </a>
                    <ul class="dropdown-menu drop_menu p-2" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="{{ ('/lang/change?lang=en') }}" {{ session()->get('locale') == 'en' ? 'selected' : '' }}>English</a></li>
                        <li><a class="dropdown-item" href="{{ ('/lang/change?lang=ko') }}" value="ko" {{ session()->get('locale') == 'ko' ? 'selected' : '' }}>Korean</a></li>
                    </ul>
                  </li>
                <!-- Navbar Search -->
                <li class="nav-item">
                    <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                        <i class="fas fa-search"></i>
                    </a>
                    <div class="navbar-search-block">
                        <form class="form-inline">
                            <div class="input-group input-group-sm">
                                <input class="form-control form-control-navbar" type="search" placeholder="Search"
                                    aria-label="Search">
                                <div class="input-group-append">
                                    <button class="btn btn-navbar" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                    <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>

                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        Admin
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('logout') }}">Logout</a>
                    </div>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="#" class="brand-link">
                <img src="{{ asset('admin/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo"
                    class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">Cctv Powerball</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- SidebarSearch Form -->
                <!--
                <div class="form-inline">
                    <div class="input-group" data-widget="sidebar-search">
                        <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                            aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-sidebar">
                                <i class="fas fa-search fa-fw"></i>
                            </button>
                        </div>
                    </div>
                </div>
            -->
                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <li class="nav-item">
                            <a href="{{ url('home') }}" class="nav-link">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                {{ __('public.dashboard') }}
                                </p>
                            </a>
                        </li>

                        <!-- <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-edit"></i>
                                <p>
                                    Game Result Settings
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                        </li> -->

                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-solid fa-video"></i>
                                <p>
                                    {{ __('public.Playlist setting') }}
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="/playlist/3min" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>3-{{ __('public.minutes') }}</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/playlist/5min" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>5-{{ __('public.minutes') }}</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon far fa-image"></i>
                                <p>
                                    {{ __('public.Video List') }}
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="/video_list/3min" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>3-{{ __('public.minutes') }}</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/video_list/5min" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>5-{{ __('public.minutes') }}</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="/balancing" class="nav-link">
                                <i class="nav-icon fas fa-solid fa-balance-scale"></i>
                                <p>
                                    {{ __('public.Balancing') }}
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="/balancing/3min" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>3-{{ __('public.minutes') }}</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/balancing/5min" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>5-{{ __('public.minutes') }}</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/father_site_balancing/3min" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>{{ __('public.father_site_data_3min') }}</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/father_site_balancing/5min" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>{{ __('public.father_site_data_5min') }}</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/balancing/add/test" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>{{ __('public.add balancing') }}</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item">
                            <a href="/api_management" class="nav-link">
                                <i class="nav-icon fas fa-th"></i>
                                <p>
                                    {{ __('public.API Management') }}
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="/maintain_settings" class="nav-link">
                                <i class="nav-icon fas fa-tools"></i>
                                <p>
                                    {{ __('Maintenance Settings') }}
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-fill"></i>
                                <p>
                                    {{ __('Add Missing Data') }}
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="/missing/power_ball" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>{{ __('Live Power Ball') }}</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/missing/dh_powerball" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>{{ __('DH Power Ball') }}</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/missing/speed_kino" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>{{ __('DH Speed Kino') }}</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-header">{{ __('public.user setting') }}</li>
                        <!-- <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="fas fa-circle nav-icon"></i>
                                <p>User Profile</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="fas fa-circle nav-icon"></i>
                                <p>Password Reset</p>
                            </a>
                        </li> -->
                        <li class="nav-item">
                            <a href="{{ route('logout') }}" class="nav-link">
                                <i class="fas fa-circle nav-icon"></i>
                                <p>{{ __('public.logout') }}</p>
                            </a>
                        </li>

                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">

            @yield('content')
            <footer class="main-footer">
                <strong>Copyright &copy; 2022 <a href="#">cctv powerball</a>.</strong>
                All rights reserved.
                <div class="float-right d-none d-sm-inline-block">
                    <b>Version</b> 1.0.0
                </div>
            </footer>

            <!-- Control Sidebar -->
            <aside class="control-sidebar control-sidebar-dark">
                <!-- Control sidebar content goes here -->
            </aside>
            <!-- /.control-sidebar -->
        </div>
        <!-- ./wrapper -->

        <!-- Language select -->
        {{-- <script type="text/javascript">

            var url = "{{ route('changeLang') }}";

            $(".changeLang").change(function(){
                window.location.href = url + "?lang="+ $(this).val();
            });

        </script> --}}
        <!-- jQuery -->
        <script src="{{ asset('admin/plugins/jquery/jquery.min.js') }}"></script>
        <!-- jQuery UI 1.11.4 -->
        <script src="{{ asset('admin/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
        <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
        <script>
            $.widget.bridge('uibutton', $.ui.button)
        </script>
        <!-- Bootstrap 4 -->
        <script src="{{ asset('admin/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <!-- daterangepicker -->
        <script src="{{ asset('admin/plugins/moment/moment.min.js') }}"></script>
        <script src="{{ asset('admin/plugins/daterangepicker/daterangepicker.js') }}"></script>
        <!-- Tempusdominus Bootstrap 4 -->
        <script
            src="{{ asset('admin/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
        <!-- Summernote -->
        <script src="{{ asset('admin/plugins/summernote/summernote-bs4.min.js') }}"></script>
        <!-- overlayScrollbars -->
        <script src="{{ asset('admin/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
        <!-- AdminLTE App -->
        <script src="{{ asset('admin/dist/js/adminlte.js') }}"></script>
        <!-- draggable -->
        <script src="{{ asset('main/js/draggable.js') }}"></script>
        <!-- datepicker -->
        <script src="{{ asset('main/js/datepicker.js') }}"></script>
        <!-- Socket IO -->
        <script src="https://cdn.socket.io/4.5.0/socket.io.min.js"></script>
        <!-- Sweet Alert -->
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script src="https://unpkg.com/ionicons@4.5.10-0/dist/ionicons.js"></script>

        <script src="https://js.pusher.com/7.2/pusher.min.js"></script>

        @stack('scripts')
</body>

</html>
