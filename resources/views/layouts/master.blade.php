<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>KeenEye Test</title>

    <link rel="stylesheet" href="/css/app.css">
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper" id="app">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light border-bottom">
            <!-- Left navbar links -->


            <!-- SEARCH FORM -->
            <form class="form-inline ml-3">
                <div class="input-group input-group-sm">
                    <input class="form-control form-control-navbar" type="search" placeholder="Search"
                        aria-label="Search">
                    <div class="input-group-append">
                        <button class="btn btn-navbar" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>

            <!-- Right navbar links -->

        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="index3.html" class="brand-link">
                <img src="./images/logo.png" alt="Keeneye Logo" class="brand-image img-circle elevation-3"
                    style="opacity: .8">
                <span class="brand-text font-weight-light">Keeneye Test</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="./images/person.png" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block"> {{ Auth::user()->type }}</a>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
                         with font-awesome or any other icon font library -->
                        {{--                    <li class="nav-item has-treeview menu-open">--}}
                        {{--                        <a href="#" class="nav-link active">--}}
                        {{--                            <i class="nav-icon fas fa-tachometer-alt"></i>--}}
                        {{--                            <p>--}}
                        {{--                                User--}}
                        {{--                                <i class="right fas fa-angle-left"></i>--}}
                        {{--                            </p>--}}
                        {{--                        </a>--}}
                        {{--                        <ul class="nav nav-treeview">--}}
                        {{--                            <li class="nav-item">--}}
                        {{--                                <a href="#" class="nav-link active">--}}
                        {{--                                    <i class="far fa-circle nav-icon"></i>--}}
                        {{--                                    <p>Active Page</p>--}}
                        {{--                                </a>--}}
                        {{--                            </li>--}}
                        {{--                            <li class="nav-item">--}}
                        {{--                                <a href="#" class="nav-link">--}}
                        {{--                                    <i class="far fa-circle nav-icon"></i>--}}
                        {{--                                    <p>Inactive Page</p>--}}
                        {{--                                </a>--}}
                        {{--                            </li>--}}
                        {{--                        </ul>--}}
                        {{--                    </li>--}}
                        @can('isAdmin')
                        <li class="nav-item">
                            <router-link to="/user" class="nav-link">
                                <i class="nav-icon fas fa-users-cog"></i>
                                <p>
                                    User Managmant
                                </p>
                            </router-link>
                        </li>
                        @endcan
                        <li class="nav-item">
                            <router-link to="/home" href="#" class="nav-link">
                                <i class="nav-icon fas fa-cube"></i>
                                <p>
                                    Product Management
                                </p>
                            </router-link>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">

                                <i class="nav-icon fas fa-cube"></i>
                                <p>
                                    Logout
                                </p>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                </form>
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
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <router-view></router-view>


                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <div class="content">

            </div>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->


        <!-- Main Footer -->
        <footer class="main-footer">
            <!-- To the right -->
            <div class="float-right d-none d-sm-inline">
                Anything you want
            </div>
            <!-- Default to the left -->
            <strong>Copyright &copy; 2014-2019 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights
            reserved.
        </footer>
    </div>





    @auth
    <script>
        window.user =@json(auth()->user())
    </script>
    @endauth
    <script src="/js/app.js"></script>
</body>

</html>
