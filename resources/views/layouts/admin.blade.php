<!DOCTYPE html>
<html lang="id">
<head>
    <title>@yield('title', 'Admin Panel - F1 Hub')</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">

    <style>
        /* Global Admin Styles */
        body { font-family: 'Inter', sans-serif; background-color: #f3f4f6; }

        /* Navbar Style */
        .navbar-admin { background-color: #111; padding: 15px 0; }
        .navbar-brand { font-weight: 900; letter-spacing: -1px; font-size: 24px; color: #e10600 !important; }
        .nav-link { color: #ccc !important; font-weight: 600; font-size: 0.9rem; margin-right: 15px; }
        .nav-link:hover, .nav-link.active { color: white !important; }
    </style>

    @stack('styles')
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-admin shadow-sm mb-5">
        <div class="container">
            <a class="navbar-brand" href="{{ route('admin.dashboard') }}">
                <i class="bi bi-speedometer2 me-2"></i>ADMIN PANEL
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                           href="{{ route('admin.dashboard') }}">
                           <i class="bi bi-grid me-1"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.lihatjadwal') ? 'active' : '' }}"
                           href="{{ route('admin.lihatjadwal') }}">
                           <i class="bi bi-ticket-detailed me-1"></i> Tiket & Jadwal
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.articles*') ? 'active' : '' }}"
                           href="{{ route('admin.articles.index') }}">
                           <i class="bi bi-newspaper me-1"></i> Artikel
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.pendapatan') ? 'active' : '' }}"
                           href="{{ route('admin.pendapatan') }}">
                           <i class="bi bi-wallet2 me-1"></i> Pendapatan
                        </a>
                    </li>
                </ul>

                <div class="d-flex align-items-center">
                    <span class="text-white me-3 small">Hi, {{ Auth::user()->name }}</span>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-danger fw-bold">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="container pb-5">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')
</body>
</html>
