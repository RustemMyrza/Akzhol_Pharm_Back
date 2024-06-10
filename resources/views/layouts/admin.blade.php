<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', config('app.name'))</title>


    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700"/>

    @notifyCss

    <link rel="stylesheet" href="{{ asset('adminlte-assets/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte-assets/plugins/ionicons/css/ionicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte-assets/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet"
          href="{{ asset('adminlte-assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte-assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte-assets/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte-assets/dist/css/bootstrap-grid.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte-assets/plugins/sweetalert2/sweetalert2.min.css') }}">
    <link rel="stylesheet"
          href="{{ asset('adminlte-assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte-assets/dist/css/loader.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte-assets/plugins/flag-icon-css/css/flag-icon.min.css') }}">

    @stack('styles')

    <link rel="stylesheet" href="{{ asset('adminlte-assets/dist/css/custom.css?v=1.3') }}">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="overflow"></div>
@include('admin._components.loader')

<div class="wrapper">
    @includeIf('admin._components.navbar')

    @auth
        @includeIf('admin._components.sidebar')
    @endauth

    <div class="content-wrapper">
        @yield('content')
    </div>
</div>

<script src="{{ asset('adminlte-assets/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('adminlte-assets/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<script src="{{ asset('adminlte-assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('adminlte-assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ asset('adminlte-assets/dist/js/adminlte.js') }}"></script>

@notifyJs

<script>
    const url = window.location;

    $(function () {
        $('ul.nav-sidebar a')
            .filter(function () {
                if (this.href) {
                    return this.href === url || url.href.indexOf(this.href) === 0;
                }
            })
            .addClass('active');

        $('ul.nav-treeview a')
            .filter(function () {
                if (this.href) {
                    return this.href === url || url.href.indexOf(this.href) === 0;
                }
            })
            .parentsUntil(".nav-sidebar > .nav-treeview")
            .addClass('menu-open')
            .prev('a')
            .addClass('active');
    })
</script>

@stack('scripts')
</body>
</html>
