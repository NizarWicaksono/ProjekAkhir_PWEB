<!DOCTYPE html>
<html lang="id">
<head>
    <title>Admin Panel - F1 Hub</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f3f4f6; }

        /* Admin Navbar (Warna Hitam biar beda dikit sama User) */
        .navbar-admin { background-color: #111; padding: 15px 0; }
        .navbar-brand { font-weight: 900; letter-spacing: -1px; font-size: 24px; color: #e10600 !important; }
        .nav-link { color: #ccc !important; font-weight: 600; font-size: 0.9rem; margin-right: 15px; }
        .nav-link:hover, .nav-link.active { color: white !important; }

        /* Stats Card */
        .stat-card {
            border: none;
            border-radius: 12px;
            background: white;
            padding: 25px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.05);
            transition: transform 0.2s;
            height: 100%;
        }
        .stat-card:hover { transform: translateY(-5px); }
        .stat-icon {
            width: 50px; height: 50px;
            background-color: #fff5f5;
            color: #e10600;
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.5rem; margin-bottom: 15px;
        }
        .stat-value { font-size: 2rem; font-weight: 800; color: #111; line-height: 1; }
        .stat-label { font-size: 0.85rem; color: #6c757d; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600; }

        /* Quick Action Button */
        .btn-action {
            padding: 30px;
            border: 2px dashed #ddd;
            background: white;
            color: #555;
            font-weight: 700;
            border-radius: 12px;
            width: 100%;
            transition: all 0.2s;
        }
        .btn-action:hover {
            border-color: #e10600;
            color: #e10600;
            background: #fff5f5;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-admin shadow-sm mb-5">
        <div class="container">
            <a class="navbar-brand" href="#"><i class="bi bi-speedometer2 me-2"></i>ADMIN PANEL</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link active" href="#"><i class="bi bi-grid me-1"></i> Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.lihatjadwal') }}"><i class="bi bi-ticket-detailed me-1"></i> Tiket & Jadwal</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.articles.index') }}"><i class="bi bi-newspaper me-1"></i> Artikel</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.pendapatan') }}"><i class="bi bi-wallet2 me-1"></i> Pendapatan</a></li>
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
            <h3 class="fw-bold m-0">📊 Overview Statistik</h3>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-dark btn-sm fw-bold">
                <i class="bi bi-box-arrow-up-right me-1"></i> Lihat Website User
            </a>
        </div>

        <div class="row g-4 mb-5">
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-icon"><i class="bi bi-cash-coin"></i></div>
                    <div class="stat-value">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
                    <div class="stat-label">Total Pendapatan</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-icon" style="color: #2ecc71; background: #eafff0;">
                        <i class="bi bi-ticket-perforated-fill"></i>
                    </div>

                    <div class="stat-value">{{ number_format($totalTickets, 0, ',', '.') }}</div>

                    <div class="stat-label">Tiket Terjual</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-icon" style="color: #3498db; background: #f0f8ff;"><i class="bi bi-flag-fill"></i></div>
                    <div class="stat-value">{{ $totalRaces }}</div>
                    <div class="stat-label">Jadwal Balapan</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-icon" style="color: #9b59b6; background: #fcf0ff;"><i class="bi bi-people-fill"></i></div>
                    <div class="stat-value">{{ $totalUsers }}</div>
                    <div class="stat-label">User Terdaftar</div>
                </div>
            </div>
        </div>

        <h5 class="fw-bold mb-3">⚡ Aksi Cepat</h5>
        <div class="row g-3">
            <div class="col-md-4">
                <a href="#" class="btn-action d-block text-decoration-none text-center">
                    <i class="bi bi-plus-circle display-6 d-block mb-2"></i>
                    Tambah Jadwal Balapan
                </a>
            </div>
            <div class="col-md-4">
                <a href="#" class="btn-action d-block text-decoration-none text-center">
                    <i class="bi bi-pencil-square display-6 d-block mb-2"></i>
                    Tulis Artikel Baru
                </a>
            </div>
            <div class="col-md-4">
                <a href="{{ route('admin.pendapatan') }}" class="btn-action d-block text-decoration-none text-center">
                    <i class="bi bi-file-earmark-spreadsheet display-6 d-block mb-2"></i>
                    Export Laporan Penjualan
                </a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
