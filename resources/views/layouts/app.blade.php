<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
    <meta name="author" content="Bebewash">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Bebewash | @yield('title')</title>
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/images/ic-logo-bebewash.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/images/ic-logo-bebewash.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/images/ic-logo-bebewash.png') }}">
    <link rel="mask-icon" href="{{ asset('assets/images/favicons/ic-logo-bebewash.png') }}" color="#ffffff">
    <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap/dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/font-awesome/css/font-awesome.css') }}">
    <link rel="stylesheet" src="{{ asset('assets/vendor/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css') }}">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        @include('includes/flash_messages')
        @include('includes/header')
        @include('includes/sidebar')
        <main class="main">
            @yield('content')
        </main>
    </div>

    <!-- Scripts -->
    <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
</body>
</html>
