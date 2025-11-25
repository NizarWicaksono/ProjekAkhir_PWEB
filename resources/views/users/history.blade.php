<!DOCTYPE html>
<html lang="id">
<head>
    <title>Riwayat Pembelian - F1 Ticket</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f3f4f6; }
        .navbar-f1 { background-color: #e10600; }
        .nav-link { font-weight: 600; }
        .user-sidebar .nav-link { color: #495057; padding: 15px 20px; border-radius: 10px; margin-bottom: 5px; display: flex; align-items: center; transition: all 0.2s; }
        .user-sidebar .nav-link:hover { background-color: #e9ecef; color: #e10600; }
        .user-sidebar .nav-link.active { background-color: #ffe5e5; color: #e10600; font-weight: 800; }
        .user-sidebar .nav-link i { font-size: 1.2rem; margin-right: 15px; width: 24px; text-align: center; }

        /* Style Tambahan untuk Tabel History */
        .ticket-item { transition: transform 0.2s; }
        .ticket-item:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(0,0,0,0.05); }

        /* Modal Styles */
        .modal-header-custom { background: linear-gradient(135deg, #e10600 0%, #ff4d4d 100%); color: white; }
        .detail-label { font-size: 0.8rem; text-transform: uppercase; color: #6c757d; letter-spacing: 0.5px; font-weight: 600; margin-bottom: 2px; }
        .detail-value { font-size: 1rem; font-weight: 700; color: #212529; margin-bottom: 15px; }
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
                        <a class="nav-link active" href="{{ route('users.dashboard') }}">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('tickets.index') }}">Jadwal</a>
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
        <div class="row">

            <div class="col-lg-3 mb-4">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-3 user-sidebar">
                        <div class="d-flex align-items-center p-3 mb-3 border-bottom">
                            <div class="bg-danger text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px; font-size: 1.5rem;">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <div>
                                <small class="text-muted d-block">Halo,</small>
                                <h6 class="fw-bold m-0 text-truncate" style="max-width: 150px;">{{ Auth::user()->name }}</h6>
                            </div>
                        </div>

                        <nav class="nav flex-column">
                            <a class="nav-link" href="{{ route('users.profile') }}">
                                <i class="bi bi-person-vcard"></i> Profil Akun
                            </a>
                            <a class="nav-link active" href="{{ route('users.history') }}">
                                <i class="bi bi-clock-history"></i> Riwayat Pembelian
                            </a>
                            <form action="{{ route('logout') }}" method="POST" class="mt-2 pt-2 border-top">
                                @csrf
                                <button type="submit" class="nav-link w-100 text-start text-danger">
                                    <i class="bi bi-box-arrow-left"></i> Logout
                                </button>
                            </form>
                        </nav>
                    </div>
                </div>
            </div>

            <div class="col-lg-9">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-header bg-white border-bottom-0 py-4 px-4 d-flex justify-content-between align-items-center">
                        <h4 class="fw-bold m-0">Riwayat Tiket</h4>
                        <span class="badge bg-secondary rounded-pill">{{ $tickets->count() }} Transaksi</span>
                    </div>
                    <div class="card-body p-4">

                        @forelse($tickets as $ticket)
                            <div class="card mb-3 border ticket-item">
                                <div class="card-body p-4">
                                    <div class="row align-items-center">
                                        <div class="col-md-2 text-center mb-3 mb-md-0">
                                            <div class="bg-light rounded-3 p-3 text-danger d-inline-block">
                                                <i class="bi bi-ticket-perforated-fill fs-1"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-7 mb-3 mb-md-0">
                                            <h5 class="fw-bold mb-1">{{ $ticket->race->circuit->gp_name }}</h5>
                                            <p class="text-muted small mb-2">
                                                <i class="bi bi-calendar3 me-1"></i> {{ \Carbon\Carbon::parse($ticket->race->race_date)->translatedFormat('d F Y') }}
                                                <span class="mx-2">|</span>
                                                <i class="bi bi-geo-alt me-1"></i> {{ $ticket->race->circuit->circuit_name }}
                                            </p>
                                            <div class="d-flex align-items-center gap-2">
                                                <span class="badge bg-success bg-opacity-10 text-success border border-success px-3">LUNAS</span>
                                                <span class="text-muted small border-start ps-2 ms-1">ID: {{ $ticket->ticket_code }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-3 text-end">
                                            <button type="button" class="btn btn-outline-dark w-100 rounded-pill fw-bold btn-sm"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#detailModal-{{ $ticket->id }}">
                                                    Detail Tiket
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal fade" id="detailModal-{{ $ticket->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content border-0 overflow-hidden">
                                        <div class="modal-header modal-header-custom p-4 border-0">
                                            <div>
                                                <h5 class="modal-title fw-bold text-uppercase ls-1">E-Ticket Detail</h5>
                                                <p class="mb-0 small opacity-75">Tunjukkan tiket ini saat masuk ke venue.</p>
                                            </div>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body p-4">

                                            <div class="text-center mb-4 pb-4 border-bottom">
                                                <h4 class="fw-bold mb-1">{{ $ticket->race->circuit->gp_name }}</h4>
                                                <span class="badge bg-dark rounded-pill px-3 mb-2">
                                                    {{ \Carbon\Carbon::parse($ticket->race->race_date)->translatedFormat('l, d F Y') }}
                                                </span>
                                                <p class="text-muted small">{{ $ticket->race->circuit->circuit_name }}</p>
                                            </div>

                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="detail-label">Pemilik Tiket</div>
                                                    <div class="detail-value">{{ Auth::user()->name }}</div>
                                                </div>

                                                <div class="col-6">
                                                    <div class="detail-label">Tanggal Pembelian</div>
                                                    <div class="detail-value">
                                                        {{ $ticket->created_at->translatedFormat('d M Y') }}
                                                        <br>
                                                        <small class="text-muted fw-normal" style="font-size: 0.85rem;">
                                                            Pukul {{ $ticket->created_at->format('H:i') }} WIB
                                                        </small>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="detail-label">Kode Tiket</div>
                                                    <div class="detail-value font-monospace">{{ $ticket->ticket_code }}</div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="detail-label">Status</div>
                                                    <div class="detail-value text-success">
                                                        <i class="bi bi-check-circle-fill me-1"></i> Paid
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="mt-4 pt-3 border-top">
                                                <a href="{{ route('ticket.download', $ticket->ticket_code) }}" class="btn btn-danger w-100 fw-bold py-3 rounded-3 shadow-sm">
                                                    <i class="bi bi-file-earmark-pdf-fill me-2"></i>Download E-Ticket (PDF)
                                                </a>
                                                <p class="text-center text-muted small mt-2 mb-0">
                                                    *Simpan file PDF sebagai bukti masuk yang sah.
                                                </p>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="text-center py-5">
                                <i class="bi bi-cart-x display-1 text-muted opacity-25"></i>
                                <h5 class="fw-bold mt-3 text-muted">Belum ada riwayat pembelian.</h5>
                                <a href="{{ route('tickets.index') }}" class="btn btn-danger mt-3 rounded-pill fw-bold px-4">Beli Tiket Sekarang</a>
                            </div>
                        @endforelse

                    </div>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
