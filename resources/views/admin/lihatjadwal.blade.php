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
        .navbar-admin { background-color: #111; padding: 15px 0; }
        .navbar-brand { font-weight: 900; letter-spacing: -1px; font-size: 24px; color: #e10600 !important; }
        .nav-link { color: #ccc !important; font-weight: 600; font-size: 0.9rem; margin-right: 15px; }
        .nav-link:hover, .nav-link.active { color: white !important; }

        .race-card {
            border: none; border-radius: 12px; transition: transform 0.2s, box-shadow 0.2s;
            background: white; height: 100%; display: flex; flex-direction: column;
        }
        .race-card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1); }
        .race-title { font-weight: 800; font-size: 1.1rem; margin-bottom: 0.5rem; }
        .race-info { font-size: 0.9rem; color: #6c757d; margin-bottom: 0.25rem; }
        .race-price { font-weight: 700; color: #198754; font-size: 1.2rem; margin-top: 0.5rem; }
        .card-top-line { height: 5px; background: #e10600; border-top-left-radius: 12px; border-top-right-radius: 12px; flex-shrink: 0; }

        /* Modal Style */
        .modal-content { border-radius: 16px; border: none; }
        .modal-header { background-color: #212529; color: white; border-top-left-radius: 16px; border-top-right-radius: 16px; }
        .btn-close-white { filter: invert(1) grayscale(100%) brightness(200%); }
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
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.dashboard') }}"><i class="bi bi-grid me-1"></i> Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link active" href="#"><i class="bi bi-ticket-detailed me-1"></i> Tiket & Jadwal</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.articles.index') }}"><i class="bi bi-newspaper me-1"></i> Artikel</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.pendapatan') }}"><i class="bi bi-wallet2 me-1"></i> Pendapatan</a></li>
                </ul>
                <div class="d-flex align-items-center">
                    <span class="text-white me-3 small">Hi, {{ Auth::user()->name }}</span>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf <button type="submit" class="btn btn-sm btn-danger fw-bold">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="container pb-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold m-0">📅 Daftar Jadwal Balapan</h3>

            <button type="button" class="btn btn-danger fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#addRaceModal">
                <i class="bi bi-plus-lg me-1"></i> Tambah Baru
            </button>
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
                            <h5 class="race-title text-dark">{{ $race->circuit->gp_name }}</h5>
                            <p class="race-info">
                                <i class="bi bi-geo-alt-fill text-danger me-2"></i>{{ $race->circuit->circuit_name }}
                            </p>
                            <p class="race-info ps-4 text-muted small">{{ $race->circuit->country }}</p>
                            <p class="race-info mt-2">
                                <i class="bi bi-calendar-event-fill text-secondary me-2"></i>{{ $race->race_date->format('d M Y') }}
                            </p>
                        </div>

                        <hr class="mt-auto mb-3 text-muted opacity-25">

                        <div>
                            <small class="text-muted d-block" style="font-size: 0.8rem;">Harga</small>
                            <div class="race-price">Rp {{ number_format($race->base_price, 0, ',', '.') }}</div>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="alert alert-light text-center border-0 shadow-sm py-5">
                    <i class="bi bi-calendar-x display-4 text-muted mb-3 d-block"></i>
                    <h5 class="fw-bold mb-1">Belum ada jadwal balapan.</h5>
                    <p class="text-muted">Klik tombol "Tambah Baru" di pojok kanan atas.</p>
                </div>
            </div>
            @endforelse
        </div>
    </div>

    <div class="modal fade" id="addRaceModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">🏁 Tambah Jadwal Balapan</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form action="{{ route('admin.races.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-bold small text-muted text-uppercase">Pilih Grand Prix</label>
                            <select name="circuit_id" id="gp_selector" class="form-select" required>
                                <option value="" selected disabled>--Pilih GP--</option>
                                @foreach($circuits as $circuit)
                                    <option value="{{ $circuit->id }}" data-circuit="{{ $circuit->circuit_name }}" data-country="{{ $circuit->country }}">
                                        {{ $circuit->gp_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold small text-muted text-uppercase">Lokasi Sirkuit</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-geo-alt"></i></span>
                                <input type="text" id="circuit_display" class="form-control bg-light text-muted" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 mb-3">
                                <label class="form-label fw-bold small text-muted text-uppercase">Tanggal</label>
                                <input type="date" name="race_date" class="form-control" required>
                            </div>
                            <div class="col-6 mb-3">
                                <label class="form-label fw-bold small text-muted text-uppercase">Harga (IDR)</label>
                                <input type="number" name="base_price" class="form-control" required>
                            </div>
                        </div>
                        <div class="d-grid mt-3">
                            <button type="submit" class="btn btn-danger fw-bold">Simpan Jadwal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const gpSelector = document.getElementById('gp_selector');
        const circuitDisplay = document.getElementById('circuit_display');
        gpSelector.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const circuitName = selectedOption.getAttribute('data-circuit');
            const countryName = selectedOption.getAttribute('data-country');
            circuitDisplay.value = `${circuitName}, ${countryName}`;
        });
    </script>
</body>
</html>
