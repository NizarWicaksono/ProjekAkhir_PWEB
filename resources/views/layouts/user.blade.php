<!DOCTYPE html>
<html lang="id">
<head>
    <title>@yield('title', 'F1 Ticket')</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700;800&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(180deg, #faf3e6 0%, #cecece 100%);
            background-attachment: fixed;
            color: #212529;
        }

        .navbar-f1 {
            background-color: #e10600;
            box-shadow: 0 4px 12px rgba(225, 6, 0, 0.2);
            padding: 12px 0;
        }

        .navbar-brand {
            font-weight: 800;
            font-style: italic;
            letter-spacing: -0.5px;
            font-size: 1.5rem;
        }

        .nav-link {
            color: rgba(255,255,255,0.85) !important;
            font-weight: 600;
            font-size: 0.95rem;
            margin: 0 8px;
            transition: all 0.2s;
        }

        .nav-link:hover, .nav-link.active {
            color: #fff !important;
            transform: translateY(-1px);
        }

        .user-pill {
            background: rgba(255,255,255,0.15);
            border-radius: 50px;
            padding: 5px 15px 5px 5px;
        }
        .user-pill:hover { background: rgba(255,255,255,0.25); }
    </style>

    @stack('styles')
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark navbar-f1 mb-5 sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('users.dashboard') }}">
                <i class="bi bi-flag-fill me-2"></i>F1 TICKET
            </a>

            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('users.dashboard') ? 'active' : '' }}" href="{{ route('users.dashboard') }}">DASHBOARD</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('tickets.index') ? 'active' : '' }}" href="{{ route('tickets.index') }}">JADWAL & TICKETS</a></li>
                </ul>

                <div class="d-flex align-items-center">
                    @auth
                        <div class="dropdown">
                            <a href="#" class="text-white text-decoration-none dropdown-toggle user-pill d-flex align-items-center" data-bs-toggle="dropdown">
                                <div class="bg-white text-danger rounded-circle d-flex align-items-center justify-content-center me-2 shadow-sm" style="width: 32px; height: 32px;">
                                    <i class="bi bi-person-fill"></i>
                                </div>
                                <span class="small fw-bold">{{ Auth::user()->name }}</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg mt-2 rounded-4 overflow-hidden p-2">
                                <li><a class="dropdown-item rounded-3" href="{{ route('users.profile') }}"><i class="bi bi-person-vcard me-2"></i> Profil Saya</a></li>
                                <li><a class="dropdown-item rounded-3" href="{{ route('users.history') }}"><i class="bi bi-clock-history me-2"></i> Riwayat Tiket</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger fw-bold rounded-3">Log Out</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-white fw-bold text-decoration-none me-4 small">LOGIN</a>
                        <a href="{{ route('register') }}" class="btn btn-light text-danger fw-bold rounded-pill px-4 shadow-sm btn-sm">REGISTER</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <div class="container pb-5">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'BERHASIL!',
                text: '{{ session('success') }}',
                showConfirmButton: true,
                confirmButtonText: 'OK, Siap!',
                confirmButtonColor: '#e10600',
                background: '#fff',
                timer: 5000,
                timerProgressBar: true,
                customClass: {
                    title: 'fw-bold',
                    popup: 'rounded-4'
                }
            });
        @endif

        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: '{{ session('error') }}',
                confirmButtonColor: '#333'
            });
        @endif

        @if($errors->any())
            Swal.fire({
                icon: 'warning',
                title: 'Perhatian',
                html: '<ul class="text-start m-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>',
                confirmButtonColor: '#e10600'
            });
        @endif
    </script>

    @stack('scripts')
</body>
</html>
