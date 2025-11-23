<!doctype html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" 
    class="layout-wide customizer-hide" dir="ltr"
    data-skin="default" 
    data-assets-path="{{ asset('assets/admin') . '/' }}" 
    data-template="vertical-menu-template"
    data-bs-theme="light">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <meta name="robots" content="noindex, nofollow" />

    <title>Laravel Dev Kit | Guest </title>

    <!-- Canonical SEO -->
    <meta name="description" content="Laravel 12 and Bootstrap 5 admin for responsive web apps." />
    <meta name="keywords" content="laravel 12, bootstrap 5" />

    <!-- Open Graph (OG) meta tags -->
    @include('partials.admin.open-grap-meta-tags')

    <link rel="canonical" href="https://themeselection.com/item/sneat-dashboard-pro-bootstrap/" />

    <!-- Google Tag Manager -->
    {{-- @include('partials.admin.google-tag-manager') --}}


    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/admin/img/favicon/favicon.ico') }}" />

    @include('partials.admin.css')

    <!-- Page CSS -->
    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/css/pages/page-auth.css') }}" />

    @include('partials.admin.head-js')

</head>

<body>


    @include('partials.admin.no-script')


    <!-- Content -->

    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner">
              @include('partials.admin.message')
                <!-- Login -->
                <div class="card px-sm-6 px-0">
                    <div class="card-body">
                        <!-- Logo -->
                        <div class="app-brand justify-content-center">
                            <a href="#"
                                class="app-brand-link gap-2">
                                <span class="app-brand-logo demo">
                                    <span class="text-primary">
                                        <img src="{{ asset('assets/img/logo.png') }}" 
                                        class="img-fluid rounded-circle" 
                                        style="max-width:50px;"
                                        alt="Logo"/>
                                    </span>
                                </span>
                                {{-- <span class="app-brand-text demo text-heading fw-bold">sneat</span> --}}
                            </a>
                        </div>
                        <!-- /Logo -->
                        {{-- <h4 class="mb-1">Welcome to sneat! 👋</h4> --}}
                        <p class="mb-6">Please sign-in to your account and start the adventure</p>

                        <form id="formAuthentication_001" class="mb-6"
                            action="{{ url('auth/sign-in') }}"
                            method="POST">
                            @csrf
                            <div class="mb-6 form-control-validation">
                                <label for="identity" class="form-label">Identity</label>
                                <input type="identity" class="form-control @error('identity') is-invalid @enderror" id="identity" name="identity"
                                    placeholder="Enter your email/mobile" value="{{ old('identity') }}" autofocus />
                                @error('identity')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-6 form-password-toggle form-control-validation">
                                <label class="form-label" for="password">Password</label>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password" class="form-control @error('password') is-invalid @enderror" name="password"
                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                        aria-describedby="password" />
                                    <span class="input-group-text cursor-pointer"><i
                                            class="icon-base bx bx-hide"></i></span>
                                </div>
                                @error('password')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-7">
                                <div class="d-flex justify-content-between">
                                    <div class="form-check mb-0">
                                        <input class="form-check-input" type="checkbox" id="remember-me" />
                                        <label class="form-check-label" for="remember-me"> Remember Me </label>
                                    </div>
                                    <a
                                        href="#">
                                        <span>Forgot Password?</span>
                                    </a>
                                </div>
                            </div>
                            <div class="mb-6">
                                <button class="btn btn-primary d-grid w-100" type="submit">Login</button>
                            </div>
                        </form>

                        <p class="text-center">
                            <span>New on our platform?</span>
                            <a
                                href="{{ url('admin/sign-up') }}">
                                <span>Create an account</span>
                            </a>
                        </p>

                        <div class="divider my-6">
                            <div class="divider-text">or</div>
                        </div>

                        <div class="d-flex justify-content-center">
                            <a href="javascript:;"
                                class="btn btn-sm btn-icon rounded-circle btn-text-facebook me-1_5">
                                <i class="icon-base bx bxl-facebook-circle icon-20px"></i>
                            </a>

                            <a href="javascript:;" class="btn btn-sm btn-icon rounded-circle btn-text-twitter me-1_5">
                                <i class="icon-base bx bxl-twitter icon-20px"></i>
                            </a>

                            <a href="javascript:;" class="btn btn-sm btn-icon rounded-circle btn-text-github me-1_5">
                                <i class="icon-base bx bxl-github icon-20px"></i>
                            </a>

                            <a href="javascript:;" class="btn btn-sm btn-icon rounded-circle btn-text-google-plus">
                                <i class="icon-base bx bxl-google icon-20px"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <!-- /Login -->
            </div>
        </div>
    </div>

    <!-- / Content -->

    @include('partials.admin.js')


    <!-- Page JS -->
    <script src="{{ asset('assets/admin/js/pages-auth.js') }}"></script>

</body>



</html>
