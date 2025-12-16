<header id="header" class="header d-flex align-items-center fixed-top">
    <div class="header-container container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

      <a href="index.html" class="logo d-flex align-items-center me-auto me-xl-0">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" class="rounded-circle"/>
        {{-- <h1 class="sitename">Starter Kit</h1> --}}
      </a>

      @include('partials.web.navbar')

      <a class="btn-getstarted" href="{{ url('/auth/sign-in') }}">Sign In</a>

    </div>
  </header>