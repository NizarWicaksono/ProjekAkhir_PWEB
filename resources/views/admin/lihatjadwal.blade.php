<!DOCTYPE html>
<html lang="id">
<head>
    <title>Kelola Jadwal - Admin F1</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f3f4f6; }

        /* NAVBAR ADMIN */
        .navbar-admin { background-color: #111; padding: 15px 0; }
        .navbar-brand { font-weight: 900; letter-spacing: -1px; font-size: 24px; color: #e10600 !important; }
        .nav-link { color: #ccc !important; font-weight: 600; font-size: 0.9rem; margin-right: 15px; }
        .nav-link:hover, .nav-link.active { color: white !important; }

        /* STYLE CARD JADWAL */
        .race-card {
            border: none;
            border-radius: 12px;
            transition: transform 0.2s, box-shadow 0.2s;
            background: white;
            height: 100%; /* Wajib full height */
            display: flex;
            flex-direction: column; /* Susun konten ke bawah */
        }
        .race-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        .race-title { font-weight: 800; font-size: 1.1rem; margin-bottom: 0.5rem; }
        .race-info { font-size: 0.9rem; color: #6c757d; margin-bottom: 0.25rem; }
        .race-price { font-weight: 700; color: #198754; font-size: 1.2rem; margin-top: 0.5rem; }

        /* Decoration Line */
        .card-top-line {
            height: 5px;
            background: #e10600;
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
            flex-shrink: 0;
        }
    </style>
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-admin shadow-sm mb-5">
        <div class="container">
            <a class="navbar-brand" href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2 me-2"></i>ADMIN PANEL</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.dashboard') }}">
                            <i class="bi bi-grid me-1"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="#">
                            <i class="bi bi-ticket-detailed me-1"></i> Tiket & Jadwal
                        </a>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="#"><i class="bi bi-newspaper me-1"></i> Artikel</a></li>
                    <li class="nav-item"><a class="nav-link" href="#"><i class="bi bi-wallet2 me-1"></i> Pendapatan</a></li>
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

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold m-0">📅 Daftar Jadwal Balapan</h3>
            <a href="{{ route('admin.tambahjadwal') }}" class="btn btn-danger fw-bold shadow-sm">
                <i class="bi bi-plus-lg me-1"></i> Tambah Baru
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success border-0 shadow-sm mb-4">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            </div>
        @endif

        <div class="row g-4">
            @forelse($races as $race)
            <div class="col-md-4 col-lg-3">
                <div class="race-card shadow-sm position-relative">
                    <div class="card-top-line"></div>

                    <div class="card-body p-4 d-flex flex-column h-100">

                        <div>
                            <h5 class="race-title text-dark">{{ $race->name }}</h5>
                            <p class="race-info">
                                <i class="bi bi-geo-alt-fill text-danger me-2"></i>{{ $race->circuit_name }}
                            </p>
                            <p class="race-info">
                                <i class="bi bi-calendar-event-fill text-secondary me-2"></i>
                                {{ $race->race_date->format('d M Y') }}
                            </p>
                        </div>

                        <hr class="mt-auto mb-3 text-muted opacity-25">

                        <div>
                            <small class="text-muted d-block" style="font-size: 0.8rem;">Harga Mulai</small>
                            <div class="race-price">
                                Rp {{ number_format($race->base_price, 0, ',', '.') }}
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="alert alert-light text-center border-0 shadow-sm py-5">
                    <i class="bi bi-calendar-x display-4 text-muted mb-3 d-block"></i>
                    <h5 class="fw-bold mb-1">Belum ada jadwal balapan.</h5>
                    <p class="text-muted">Klik tombol "Tambah Baru" di pojok kanan atas untuk memulai.</p>
                </div>
            </div>
            @endforelse
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
