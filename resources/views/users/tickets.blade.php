<!DOCTYPE html>
<html lang="id">
<head>
    <title>Katalog Tiket - F1 Ticket</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f3f4f6; }

        /* NAVBAR (Sama persis dengan Dashboard) */
        .navbar-f1 { background-color: #e10600 !important; }
        .nav-link { color: rgba(255,255,255,0.9) !important; font-weight: 600; margin-right: 10px; }
        .nav-link:hover, .nav-link.active { color: white !important; opacity: 1; }

        /* CARD TIKET */
        .ticket-card {
            border: none;
            border-radius: 16px;
            background: white;
            transition: transform 0.2s, box-shadow 0.2s;
            height: 100%;
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }
        .ticket-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }
        .card-top-accent {
            height: 6px;
            background: linear-gradient(90deg, #e10600, #ff4d4d);
        }
        .ticket-price {
            color: #198754;
            font-weight: 800;
            font-size: 1.1rem;
        }

        /* SIDEBAR */
        .sidebar-card {
            background: white;
            border-radius: 16px;
            border: none;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
            position: sticky; top: 20px;
        }
        .icon-box {
            width: 50px; height: 50px;
            background-color: #fff5f5;
            color: #e10600;
            display: flex; align-items: center; justify-content: center;
            border-radius: 12px;
            font-size: 1.5rem;
        }
    </style>
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
                        <a class="nav-link" href="{{ route('users.dashboard') }}">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Beli Tiket</a>
                    </li>
                </ul>

                <div class="d-flex align-items-center text-white">
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
                </div>
            </div>
        </div>
    </nav>

    <div class="container pb-5">
        <div class="row g-4">

            <div class="col-lg-8">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="fw-bold m-0 text-dark">🏁 Kalender Balapan Resmi</h4>
                    <span class="badge bg-dark">{{ $races->count() }} Event Tersedia</span>
                </div>

                <div class="row g-3">
                    @forelse($races as $race)
                    <div class="col-md-6">
                        <div class="ticket-card shadow-sm">
                            <div class="card-top-accent"></div>

                            <div class="card-body p-4 d-flex flex-column h-100">
                                <div class="mb-3">
                                    <span class="badge bg-danger bg-opacity-10 text-danger border border-danger mb-2 px-2">
                                        {{ $race->race_date->format('d M Y') }}
                                    </span>
                                    <h5 class="fw-bold text-dark mb-1">{{ $race->circuit->gp_name }}</h5>
                                    <small class="text-muted d-block">
                                        <i class="bi bi-geo-alt-fill me-1 text-secondary"></i>
                                        {{ $race->circuit->circuit_name }}
                                    </small>
                                </div>

                                <hr class="border-secondary opacity-10 my-auto">

                                <div class="mt-3 d-flex justify-content-between align-items-end">
                                    <div>
                                        <small class="text-muted d-block" style="font-size: 0.75rem;">Mulai dari</small>
                                        <div class="ticket-price">Rp {{ number_format($race->base_price, 0, ',', '.') }}</div>
                                    </div>

                                    <a href="{{ route('booking.show', $race->id) }}" class="btn btn-dark rounded-pill px-4 fw-bold">
                                        Beli <i class="bi bi-arrow-right ms-1"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-12">
                        <div class="alert alert-light border text-center py-5 rounded-4">
                            <div class="mb-3 text-muted"><i class="bi bi-calendar-x display-1"></i></div>
                            <h5 class="fw-bold">Jadwal Belum Tersedia</h5>
                            <p class="text-muted">Mohon tunggu update selanjutnya dari admin.</p>
                        </div>
                    </div>
                    @endforelse
                </div>
            </div>

            <div class="col-lg-4">
                <div class="sidebar-card p-4">
                    <h5 class="fw-bold mb-4">Dompet Tiket</h5>

                    <div class="d-flex align-items-center mb-4 p-3 bg-light rounded-3 border">
                        <div class="icon-box me-3">
                            <i class="bi bi-qr-code-scan"></i>
                        </div>
                        <div>
                            <small class="text-muted d-block fw-bold text-uppercase" style="font-size: 0.7rem; letter-spacing: 1px;">Tiket Dimiliki</small>
                            <h2 class="fw-bold m-0 text-dark">{{ $myTicketCount }}</h2>
                        </div>
                    </div>

                    <div class="alert alert-info border-0 d-flex align-items-start gap-2">
                        <i class="bi bi-info-circle-fill mt-1"></i>
                        <div class="small line-height-sm">
                            Tiket yang sudah dibeli akan dikirimkan ke email Anda dan tersimpan otomatis di sistem kami.
                        </div>
                    </div>

                    <button class="btn btn-outline-dark w-100 fw-bold py-2 rounded-pill disabled" disabled>
                        <i class="bi bi-clock-history me-2"></i> Riwayat (Coming Soon)
                    </button>
                </div>

                <div class="mt-4 text-center">
                    <small class="text-muted">Butuh bantuan? <a href="#" class="text-decoration-none fw-bold text-dark">Hubungi CS</a></small>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
