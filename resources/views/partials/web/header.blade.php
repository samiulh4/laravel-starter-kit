<header id="header" class="header d-flex align-items-center fixed-top">
    <div
        class="header-container container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

        <a href="index.html" class="logo d-flex align-items-center me-auto me-xl-0">
            <!-- Uncomment the line below if you also wish to use an image logo -->
            <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" class="rounded-circle" />
            {{-- <h1 class="sitename">Starter Kit</h1> --}}
        </a>

        @include('partials.web.navbar')

        <!-- Auth User Dropdown -->
        @if (auth()->check())
            <div class="dropdown">
                <button class="btn dropdown-toggle p-0" type="button" id="userDropdown" data-bs-toggle="dropdown"
                    aria-expanded="false" style="border: none; background: none;">
                    <img src="{{ auth()->user()->getAvatarUrl() }}"
                        alt="Profile" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">
                </button>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                    <li>
                        <a class="dropdown-item" href="{{ url('profile.show') ?? '#' }}">
                            <i class="bi bi-person-circle"></i> {{ auth()->user()->name }}
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ url('profile.edit') ?? '#' }}">
                            <i class="bi bi-gear"></i> Profile Settings
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ url('/auth/sign-out') }}"
                            onclick="event.preventDefault();document.getElementById('webSignOutForm').submit();">
                            <i class="bi bi-box-arrow-right"></i> Sign Out
                        </a>
                        <form id="webSignOutForm" action="{{ url('/auth/sign-out') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
        @else
            <a class="btn-getstarted" href="{{ url('/auth/sign-in') }}">Sign In</a>
        @endif

    </div>
</header>
