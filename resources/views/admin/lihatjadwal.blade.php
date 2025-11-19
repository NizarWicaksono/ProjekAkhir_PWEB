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

        /* STYLE NAVBAR ADMIN (Sama persis dengan Dashboard) */
        .navbar-admin { background-color: #111; padding: 15px 0; }
        .navbar-brand { font-weight: 900; letter-spacing: -1px; font-size: 24px; color: #e10600 !important; }
        .nav-link { color: #ccc !important; font-weight: 600; font-size: 0.9rem; margin-right: 15px; }
        .nav-link:hover, .nav-link.active { color: white !important; }

        /* Style Tabel */
        .card { border-radius: 12px; overflow: hidden; }
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

        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4 py-3">Tanggal</th>
                            <th>Nama Event</th>
                            <th>Sirkuit</th>
                            <th>Harga Dasar</th>
                            <th class="text-end pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($races as $race)
                        <tr>
                            <td class="ps-4 fw-bold">{{ $race->race_date->format('d M Y') }}</td>
                            <td>{{ $race->name }}</td>
                            <td class="text-muted small">{{ $race->circuit_name }}</td>
                            <td class="text-success fw-bold">Rp {{ number_format($race->base_price, 0, ',', '.') }}</td>
                            <td class="text-end pe-4">
                                <form action="{{ route('admin.races.destroy', $race->id) }}" method="POST" onsubmit="return confirm('Yakin hapus jadwal ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus Jadwal">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <div class="mb-2"><i class="bi bi-calendar-x display-4"></i></div>
                                <p class="fw-bold mb-1">Belum ada jadwal balapan.</p>
                                <p class="small">Klik tombol "Tambah Baru" di pojok kanan atas.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
