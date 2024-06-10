<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', config('app.name'))</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700"/>
    <link rel="stylesheet" href="{{ asset('adminlte-assets/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte-assets/plugins/ionicons/css/ionicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte-assets/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet"
          href="{{ asset('adminlte-assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte-assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte-assets/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte-assets/plugins/sweetalert2/sweetalert2.min.css') }}">
    <link rel="stylesheet"
          href="{{ asset('adminlte-assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    <link rel="stylesheet"
          href="{{ asset('adminlte-assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte-assets/dist/css/loader.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte-assets/dist/css/custom.css') }}">
</head>
<body class="min-vh-100" style="background-color: #e9ecef;">

<div class="overflow"></div>
@include('admin._components.loader')

<div class="wrapper">
    <div class="d-flex align-items-center justify-content-center mt-5">
        @yield('content')
    </div>
</div>

<script src="{{ asset('adminlte-assets/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('adminlte-assets/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<script src="{{ asset('adminlte-assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('adminlte-assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ asset('adminlte-assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<script src="{{ asset('adminlte-assets/dist/js/adminlte.js') }}"></script>

</body>
</html>
