<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Laravel Starter Kit | Web</title>
    <meta name="description" content="">
    <meta name="keywords" content="">

    <!-- Favicons -->
    <link href="{{ asset('assets/img/logo.png') }}" rel="icon">
    <link href="{{ asset('assets/web/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

    @include('partials.web.css')
    @yield('style')
</head>

<body class="index-page">

    @include('partials.web.header')

    <main class="main">
        @yield('content')
    </main>

    @include('partials.web.footer')

    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    @include('partials.web.js')
    @yield('script')
</body>

</html>
