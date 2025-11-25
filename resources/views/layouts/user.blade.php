<!DOCTYPE html>
<html lang="id">
<head>
    <title>@yield('title', 'F1 Ticket')</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f3f4f6; }

        /* === GLOBAL NAVBAR STYLE === */
        .navbar-f1 { background-color: #e10600; }

        .navbar-f1 .nav-link {
            color: rgba(255,255,255,0.5) !important; /* Redup saat tidak aktif */
            font-weight: 600;
            margin-right: 10px;
            transition: all 0.3s ease;
        }

        .navbar-f1 .nav-link:hover,
        .navbar-f1 .nav-link.active {
            color: #ffffff !important; /* Putih Terang saat aktif */
            opacity: 1;
            text-shadow: 0 0 5px rgba(0,0,0,0.2);
        }
    </style>

    @stack('styles')
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark navbar-f1 shadow-sm mb-5 sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold fst-italic" href="{{ route('users.dashboard') }}">
                <i class="bi bi-flag-fill me-2"></i>F1 TICKET
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('users.dashboard') ? 'active' : '' }}"
                           href="{{ route('users.dashboard') }}">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('tickets.index') ? 'active' : '' }}"
                           href="{{ route('tickets.index') }}">Jadwal</a>
                    </li>
                </ul>

                <div class="d-flex align-items-center text-white">
                    @auth
                        <div class="dropdown">
                            <a href="#" class="text-white text-decoration-none dropdown-toggle fw-bold" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle me-1"></i> {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
                                <li><a class="dropdown-item" href="{{ route('users.profile') }}">Profil Saya</a></li>
                                <li><a class="dropdown-item" href="{{ route('users.history') }}">Riwayat</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger fw-bold">Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-sm btn-light text-danger fw-bold me-2">Login</a>
                        <a href="{{ route('register') }}" class="btn btn-sm btn-outline-light fw-bold">Register</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <div class="container pb-5">
        @if(session('success'))
            <div class="alert alert-success border-0 shadow-sm mb-4 d-flex align-items-center">
                <i class="bi bi-check-circle-fill fs-4 me-3"></i>
                <div>{{ session('success') }}</div>
            </div>
        @endif

        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')
</body>
</html>
