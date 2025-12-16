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
</head>

<body class="starter-page-page">

    @include('partials.web.header')

    <main class="main">
        @include('partials.web.hero')
        @include('partials.web.about')
        @include('partials.web.features')
        @include('partials.web.features-cards')
        @include('partials.web.features-2')
        @include('partials.web.call-to-action')
        @include('partials.web.clients')
        @include('partials.web.testimonials')
        @include('partials.web.stats')
        @include('partials.web.services')
        @include('partials.web.pricing')
        @include('partials.web.faq')
        @include('partials.web.call-to-action-2')
        @include('partials.web.contact')
    </main>

    @include('partials.web.footer')

    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    @include('partials.web.js')

</body>

</html>
