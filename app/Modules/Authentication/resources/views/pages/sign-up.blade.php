<!doctype html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" 
    class="layout-wide  customizer-hide" dir="ltr"
    data-skin="default" data-assets-path="{{ asset('assets/admin') . '/' }}" 
    data-template="vertical-menu-template"
    data-bs-theme="light">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <meta name="robots" content="noindex, nofollow" />

    <title>Laravel Starter Kit | Guest</title>

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
                <!-- Register -->
                <div class="card px-sm-6 px-0">
                    <div class="card-body">
                        <!-- Logo -->
                        <div class="app-brand justify-content-center mb-6">
                            <a href="#" class="app-brand-link gap-2">
                                <span class="app-brand-logo demo">
                                    <span class="text-primary">
                                        <img src="{{ asset('assets/img/logo.png') }}" 
                                        class="img-fluid rounded-circle" 
                                        style="max-width:50px;"
                                        alt="Logo"/>
                                    </span>
                                </span>
                                {{-- <span class="app-brand-text demo text-heading fw-bold">Laravel Starter Kit</span> --}}
                            </a>
                        </div>
                        <!-- /Logo -->
                        <h4 class="mb-1">Laravel Starter Kit</h4>
                        <p class="mb-6">Make your app management easy and fun!</p>

                        <form id="formAuthentication_001" class="mb-6" action="{{ url('/auth/sign-up') }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-6 form-control-validation">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    placeholder="Enter your full name" autofocus />
                            </div>
                            <div class="mb-6 form-control-validation">
                                <label for="email" class="form-label">Email</label>
                                <input type="text" class="form-control" id="email" name="email"
                                    placeholder="Enter your email" />
                            </div>
                            <div class="mb-6 form-control-validation">
                                <label for="gender_code" class="form-label">Gender</label>
                                <select id="gender_code" name="gender_code" class="form-control">
                                    <option value="" disabled selected>Select your gender</option>
                                    <option value="M">Male</option>
                                    <option value="F">Female</option>
                                    <option value="O">Other</option>
                                    <option value="N">Not aoolicable</option>
                                </select>
                            </div>
                            <div class="mb-6 form-control-validation">
                                <label for="avatar" class="form-label">Avatar</label>
                                <input type="file" class="form-control" id="avatar" name="avatar"
                                    accept="image/*" onchange="previewAvatar()" />
                                <div class="mt-3">
                                    <img id="avatarPreview" src="#" alt="Avatar Preview"
                                        style="display:none; max-width: 150px; border-radius: 50%;" />
                                </div>
                            </div>
                            <div class="form-password-toggle form-control-validation">
                                <label class="form-label" for="password">Password</label>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password" class="form-control" name="password"
                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                        aria-describedby="password" />
                                    <span class="input-group-text cursor-pointer"><i
                                            class="icon-base bx bx-hide"></i></span>
                                </div>
                            </div>
                            <div class="my-7 form-control-validation">
                                <div class="form-check mb-0">
                                    <input class="form-check-input" type="checkbox" id="terms-conditions"
                                        name="terms" />
                                    <label class="form-check-label" for="terms-conditions">
                                        I agree to
                                        <a href="javascript:void(0);">privacy policy & terms</a>
                                    </label>
                                </div>
                            </div>
                            <button class="btn btn-primary d-grid w-100">Sign up</button>
                        </form>

                        <p class="text-center">
                            <span>Already have an account?</span>
                            <a href="{{ url('/auth/sign-in') }}">
                                <span>Sign in instead</span>
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
                <!-- /Register -->
            </div>
        </div>
    </div>

    <!-- / Content -->

    @include('partials.admin.js')
    <!-- Page JS -->
    <script src="{{ asset('assets/admin/js/pages-auth.js') }}"></script>

    <script>
        function previewAvatar() {
            const input = document.getElementById('avatar');
            const preview = document.getElementById('avatarPreview');

            const file = input.files[0];
            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            } else {
                preview.src = '#';
                preview.style.display = 'none';
            }
        }
    </script>





</body>



</html>
