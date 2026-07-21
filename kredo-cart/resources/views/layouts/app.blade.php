<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }} | @yield('title')</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body class="d-flex flex-column min-vh-100">
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-dark bg-dark shadow-sm">
            <div class="container">
                <a class="navbar-brand fw-bold" href="{{ route('products.index') }}">
                    <i class="fa-solid fa-store text-warning"></i> KredoCart
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    {{-- Left side --}}
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a href="{{ route('home') }}" class="nav-link">
                                <i class="fa-solid fa-house"></i> Home
                            </a>
                        </li>

                    </ul>

                    {{-- Right side --}}
                    <ul class="navbar-nav ms-auto">
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">
                                    Login
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="btn btn-warning btn-sm text-dark ms-2" href="{{ route('register') }}">
                                    Register
                                </a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a href="{{ route('orders.index') }}" class="nav-link">
                                    <i class="fa-solid fa-bag-shopping"></i> My Orders
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('cart.index') }}" class="nav-link position-relative">
                                    <i class="fa-solid fa-cart-shopping"></i>
                                    {{-- @php
                                        $orderItemsCount = Auth::user()->orderItemsCount();
                                    @endphp

                                    @if ($orderItemsCount > 0)
                                        <span class="position-absolute translate-middle badge rounded-pill bg-danger">
                                            {{ $orderItemsCount }}
                                        </span>
                                    @endif --}}
                                </a>
                            </li>

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
                                    <div class="rounded-circle bg-warning text-dark fw-bold d-flex justify-content-center align-items-center me-2" style="width:35px; height:35px;">
                                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                    </div>

                                    {{ Auth::user()->name }}
                                </a>

                                <ul class="dropdown-menu dropdown-menu-end">

                                      @can('admin')
                                        {{-- Admin Controls --}}
                                        <a href="{{ route('admin.products.index') }}" class="dropdown-item">
                                            <i class="fa-solid fa-user-gear"></i> Admin
                                        </a>
                                        <hr class="dropdown-divider">
                                    @endcan
                                    <li class="nav-item">
                                        <a href="{{ route('orders.index') }}" class="dropdown-item">
                                            <i class="fa-solid fa-bag-shopping"></i> My Orders
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="{{ route('cart.index') }}" class="dropdown-item">
                                            <i class="fa-solid fa-cart-shopping"></i> My Cart
                                        </a>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li>
                                        <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                                            onclick="event.preventDefault(); document .getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                            class="d-none">
                                            @csrf
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>


        <main class="flex-grow-1 py-4">

            {{-- Flash Message --}}
            @if (session('success'))
                <div class="container">
                    <div class="alert alert-success alert-dismissible fade show">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="container">
                    <div class="alert alert-danger alert-dismissible fade show">
                        {{ session('error') }}

                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                </div>
            @endif

            @if ($errors->any())
                <div class="container">
                    <div class="alert alert-danger alert-dismissible fade show">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</body>

<footer class="bg-dark text-light mt-auto pt-5 pb-3">
    <div class="container">

        <div class="row">

            {{-- Logo --}}
            <div class="col-lg-4 mb-4">
                <h5 class="fw-bold">
                    <i class="fa-solid fa-store text-warning"></i>
                    KredoCart
                </h5>

                <p class="text-secondary small">
                    Your one-stop shop for quality products at affordable prices.
                    We deliver excellence right to your doorstep.
                </p>
            </div>

            {{-- Quick Links --}}
            <div class="col-lg-2 col-md-4 mb-4">
                <h6 class="fw-bold text-warning">
                    Quick Links
                </h6>

                <ul class="list-unstyled">
                    <li>
                        <a href="{{ route('home') }}" class="text-decoration-none text-secondary">
                            Home
                        </a>
                    </li>

                    <li class="mt-2">
                        <a href="{{ route('products.index') }}" class="text-decoration-none text-secondary">
                            Products
                        </a>
                    </li>

                    <li class="mt-2">
                        <a href="#" class="text-decoration-none text-secondary">
                            About Us
                        </a>
                    </li>
                </ul>
            </div>

            {{-- Customer Service --}}
            <div class="col-lg-3 col-md-4 mb-4">
                <h6 class="fw-bold text-warning">
                    Customer Service
                </h6>

                <ul class="list-unstyled">
                    <li>
                        <a href="#" class="text-decoration-none text-secondary">
                            Contact Us
                        </a>
                    </li>

                    <li class="mt-2">
                        <a href="#" class="text-decoration-none text-secondary">
                            FAQs
                        </a>
                    </li>

                    <li class="mt-2">
                        <a href="#" class="text-decoration-none text-secondary">
                            Return Policy
                        </a>
                    </li>
                </ul>
            </div>

            {{-- Social --}}
            <div class="col-lg-3 col-md-4 mb-4">
                <h6 class="fw-bold text-warning">
                    Connect With Us
                </h6>

                <a href="#" class="text-secondary me-3 fs-5 text-decoration-none d-inline-flex align-items-center">
                    <i class="fab fa-facebook"></i>
                </a>

                <a href="#" class="text-secondary me-3 fs-5 text-decoration-none d-inline-flex align-items-center">
                    <i class="fab fa-twitter"></i>
                </a>

                <a href="#" class="text-secondary fs-5 text-decoration-none d-inline-flex align-items-center">
                    <i class="fab fa-instagram"></i>
                </a>
            </div>

        </div>

        <hr class="border-secondary">

        <div class="text-center text-secondary small">
            © {{ date('Y') }} KredoCart. All rights reserved.
        </div>

    </div>
</footer>

</html>
