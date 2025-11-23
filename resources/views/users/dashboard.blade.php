<!DOCTYPE html>
<html lang="id">
<head>
    <title>Dashboard F1</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f3f4f6; }

        /* WARNA MERAH F1 (VIBRANT) - TANPA PADDING TAMBAHAN */
        .navbar-f1 {
            background-color: #e10600 !important; /* Merah Menyala */
        }

        .nav-link { color: rgba(255,255,255,0.9) !important; font-weight: 600; margin-right: 10px; }
        .nav-link:hover, .nav-link.active { color: white !important; opacity: 1; }

        /* Sidebar Widget */
        .sidebar-widget {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.05);
            position: sticky;
            top: 20px;
        }
        .race-item {
            border-bottom: 1px solid #eee;
            padding-bottom: 15px;
            margin-bottom: 15px;
        }
        .race-item:last-child { border-bottom: none; margin-bottom: 0; padding-bottom: 0; }

        .date-box {
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            text-align: center;
            padding: 5px 10px;
            min-width: 60px;
        }
        .date-day { font-size: 1.2rem; font-weight: 800; line-height: 1; }
        .date-month { font-size: 0.7rem; text-transform: uppercase; font-weight: 600; }
    </style>
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark navbar-f1 shadow-sm mb-4 sticky-top">
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
                        <a class="nav-link {{ Route::is('users.dashboard') ? 'active' : '' }}" href="{{ route('users.dashboard') }}">
                            Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('tickets.index') ? 'active' : '' }}" href="{{ route('tickets.index') }}">
                            Beli Tiket
                        </a>
                    </li>
                </ul>

                <div class="d-flex align-items-center text-white">
                    @auth
                        <div class="dropdown">
                            <a href="#" class="text-white text-decoration-none dropdown-toggle fw-bold" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle me-1"></i> {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
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
            <div class="alert alert-success border-0 shadow-sm mb-4">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            </div>
        @endif

        <div class="row">

            <div class="col-lg-8">
                <h4 class="fw-bold mb-4">🔥 Berita Terbaru</h4>

                @forelse($articles as $article)
                    <div class="card border-0 shadow-sm mb-4 overflow-hidden">
                        <div class="card-body p-4">
                            <div class="text-muted small mb-2">
                                <i class="bi bi-calendar3 me-1"></i> {{ $article->created_at->format('d F Y') }}
                                <span class="mx-2">•</span> F1 News
                            </div>
                            <h3 class="card-title fw-bold mb-3">{{ $article->title }}</h3>
                            <p class="card-text text-secondary">
                                {{ Str::limit($article->content, 150) }}
                            </p>
                            <a href="#" class="btn btn-outline-danger rounded-pill px-4 fw-bold mt-2 btn-sm">Baca Selengkapnya</a>
                        </div>
                    </div>
                @empty
                    <div class="alert alert-light border text-center py-5">
                        <i class="bi bi-newspaper display-4 text-muted mb-3 d-block"></i>
                        <h5 class="fw-bold">Belum Ada Berita</h5>
                        <p class="text-muted">Tim redaksi sedang memanaskan mesin.</p>
                    </div>
                @endforelse
            </div>

            <div class="col-lg-4">
                <div class="sidebar-widget">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="fw-bold m-0">🏁 Next Races</h5>
                        <a href="{{ route('tickets.index') }}" class="text-danger text-decoration-none small fw-bold">
                            Lihat Semua
                        </a>
                    </div>

                    @forelse($races as $race)
                        <div class="race-item d-flex align-items-center">
                            <div class="date-box me-3">
                                <div class="date-day">{{ $race->race_date->format('d') }}</div>
                                <div class="date-month">{{ $race->race_date->format('M') }}</div>
                            </div>

                            <div class="flex-grow-1">
                                <h6 class="fw-bold mb-0 text-truncate">{{ $race->circuit->gp_name }}</h6>
                                <small class="text-muted d-block mb-1">{{ $race->circuit->circuit_name }}</small>
                                <small class="text-success fw-bold" style="font-size: 0.75rem;">
                                    Mulai Rp {{ number_format($race->base_price, 0, ',', '.') }}
                                </small>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-4 text-muted">
                            <i class="bi bi-flag-fill fs-1 mb-2 d-block text-secondary"></i>
                            <p class="small fw-bold">Tidak ada jadwal dekat.</p>
                        </div>
                    @endforelse
                </div>

                <div class="card border-0 shadow-sm mt-4 bg-dark text-white text-center p-4" style="border-radius: 12px;">
                    <h5 class="fw-bold">Ingin Nonton Langsung?</h5>
                    <p class="small text-white-50 mb-3">Cek ketersediaan tiket untuk balapan favoritmu di menu tiket.</p>
                    <a href="{{ route('tickets.index') }}" class="btn btn-danger fw-bold w-100 rounded-pill">
                        Ke Menu Beli Tiket
                    </a>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
