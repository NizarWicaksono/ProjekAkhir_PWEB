<!DOCTYPE html>
<html lang="id">
<head>
    <title>Katalog Tiket</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-danger mb-4 shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold fst-italic" href="{{ route('users.dashboard') }}">F1 TICKET</a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ route('users.dashboard') }}">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link active fw-bold" href="#">Beli Tiket</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <h4 class="fw-bold mb-4">🏁 Jadwal Balapan</h4>
                <div class="row g-3">
                    @forelse($races as $race)
                    <div class="col-md-6">
                        <div class="card shadow-sm h-100 border-0">
                            <div class="card-body">
                                <span class="badge bg-danger mb-2">{{ $race->race_date->format('d M Y') }}</span>
                                <h5 class="card-title fw-bold">{{ $race->circuit->gp_name }}</h5>
                                <p class="text-muted small mb-3">{{ $race->circuit->circuit_name }}</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="fw-bold text-success">Rp {{ number_format($race->base_price, 0, ',', '.') }}</span>
                                    <a href="{{ route('booking.show', $race->id) }}" class="btn btn-dark btn-sm">Beli</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-12 text-center py-5">Belum ada jadwal tersedia.</div>
                    @endforelse
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card border-0 shadow-sm p-3">
                    <div class="d-flex align-items-center">
                        <div class="bg-light p-3 rounded-circle me-3">
                            <i class="bi bi-ticket-perforated-fill fs-3 text-danger"></i>
                        </div>
                        <div>
                            <small class="text-muted d-block">Tiket Saya</small>
                            <h3 class="fw-bold m-0">{{ $myTicketCount }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
