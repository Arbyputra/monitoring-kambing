<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <style>
        .nav-link.custom-link {
            transition: 0.3s;
            position: relative;
        }

        .nav-link.custom-link:hover {
            color: orange;
        }

        .nav-link.active-tab {
            color: orange;
            text-decoration: underline;
            text-underline-offset: 4px;
            font-weight: bold;
        }
    </style>

</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                @auth
                    <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
                        <div class="rounded-circle overflow-hidden border border-secondary"
                            style="width: 45px; height: 45px;">
                            <img src="{{ asset('images/goat_icon.jpg') }}" alt="Logo Goat"
                                class="img-fluid h-100 w-100 object-fit-cover">
                        </div>
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">

                        <!-- Left Side Of Navbar -->

                        <ul class="navbar-nav me-auto align-items-center">
                            <li class="nav-item ms-3">
                                <a href="{{ url('/dashboard') }}"
                                    class="nav-link custom-link {{ request()->is('dashboard') ? 'active-tab' : '' }}">
                                    Dashboard
                                </a>
                            </li>
                            <li class="nav-item ms-3">
                                <a href="{{ url('/data-kambing') }}"
                                    class="nav-link custom-link {{ request()->is('data-kambing*') ? 'active-tab' : '' }}">
                                    Data Kambing
                                </a>
                            </li>
                        </ul>
                    @endauth
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <form class="d-flex me-3" role="search" action="#" method="GET">
                                <input class="form-control form-control-sm me-2" type="search" name="q"
                                    placeholder="Cari..." aria-label="Search">
                                <button class="btn btn-outline-primary btn-sm" type="submit">
                                    <i class="bi bi-search"></i>
                                </button>
                            </form>

                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <i class="bi bi-person-circle me-1"></i> {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
    @yield('scripts')
    @stack('scripts')
</body>

</html>
