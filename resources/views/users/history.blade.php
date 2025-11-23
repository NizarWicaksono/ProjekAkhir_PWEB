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
        .navbar-f1 { background-color: #e10600 !important; }
        .nav-link { color: rgba(255,255,255,0.9) !important; font-weight: 600; margin-right: 10px; }
        .nav-link:hover, .nav-link.active { color: white !important; opacity: 1; }

        /* Card Style */
        .history-card {
            background: white; border: none; border-radius: 16px;
            transition: transform 0.2s; overflow: hidden;
            display: flex; /* Flex container utama */
        }
        .history-card:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(0,0,0,0.05); }

        /* BAGIAN KIRI (TANGGAL) */
        .ticket-date-box {
            background-color: #212529; color: white;
            text-align: center; padding: 15px;
            width: 110px; /* Lebar Tetap */
            flex-shrink: 0; /* Jangan menyusut */
            display: flex; flex-direction: column; justify-content: center;
        }

        /* BAGIAN TENGAH (INFO) */
        .ticket-info-box {
            padding: 1.5rem;
            flex-grow: 1; /* Mengambil sisa ruang */
            display: flex;
            flex-direction: column;
            justify-content: center;
            min-width: 0; /* Mencegah overflow text truncate */
        }

        /* BAGIAN KANAN (TOMBOL) */
        .ticket-action-box {
            width: 160px; /* LEBAR TETAP (DIKUNCI) */
            flex-shrink: 0; /* Jangan menyusut */
            border-left: 2px dashed #dee2e6;
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background-color: white;
            padding: 15px;
        }

        /* Lubang tiket effect */
        .ticket-action-box::before, .ticket-action-box::after {
            content: ""; position: absolute; left: -11px;
            width: 20px; height: 20px; background-color: #f3f4f6; border-radius: 50%;
        }
        .ticket-action-box::before { top: -10px; }
        .ticket-action-box::after { bottom: -10px; }

        /* Modal Blur */
        .modal-backdrop.show {
            backdrop-filter: blur(5px);
            -webkit-backdrop-filter: blur(5px);
            background-color: rgba(0, 0, 0, 0.5);
            opacity: 1 !important;
        }
        .modal-content { border-radius: 20px; border: none; box-shadow: 0 15px 40px rgba(0,0,0,0.3); }
        .modal-header { background: #e10600; color: white; border-bottom: none; padding: 20px 25px; }
        .info-label { font-size: 0.75rem; color: #6c757d; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 3px; }
        .info-value { font-weight: 700; font-size: 1rem; color: #212529; margin-bottom: 15px; }
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
                    <li class="nav-item"><a class="nav-link" href="{{ route('users.dashboard') }}">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('tickets.index') }}">Beli Tiket</a></li>
                </ul>
                <div class="d-flex align-items-center text-white">
                    <div class="dropdown">
                        <a href="#" class="text-white text-decoration-none dropdown-toggle fw-bold" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle me-1"></i> {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
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
                </div>
            </div>
        </div>
    </nav>

    <div class="container pb-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold m-0">🎟️ Tiket Saya</h3>
            <span class="badge bg-secondary rounded-pill px-3">{{ $tickets->count() }} Tiket Ditemukan</span>
        </div>

        <div class="row g-4">
            @forelse($tickets as $ticket)
            <div class="col-12 col-lg-6">
                <div class="history-card shadow-sm">

                    <div class="ticket-date-box">
                        <span class="display-6 fw-bold">{{ $ticket->race->race_date->format('d') }}</span>
                        <span class="text-uppercase small letter-spacing-2">{{ $ticket->race->race_date->format('M Y') }}</span>
                    </div>

                    <div class="ticket-info-box">
                        <h5 class="fw-bold mb-1 text-truncate">{{ $ticket->race->circuit->gp_name }}</h5>
                        <p class="text-muted small mb-2 text-truncate">
                            <i class="bi bi-geo-alt me-1"></i>{{ $ticket->race->circuit->circuit_name }}
                        </p>

                        <div class="d-flex align-items-center">
                            <i class="bi bi-upc-scan me-2 text-secondary"></i>
                            <span class="text-secondary fw-bold font-monospace" style="font-size: 0.85rem;">
                                {{ $ticket->ticket_code }}
                            </span>
                        </div>
                    </div>

                    <div class="ticket-action-box">
                        <button type="button" class="btn btn-dark btn-sm w-100 rounded-pill fw-bold shadow-sm stretched-link"
                                data-bs-toggle="modal"
                                data-bs-target="#ticketModal-{{ $ticket->id }}">
                            Lihat Detail
                        </button>
                    </div>

                </div>
            </div>

            <div class="modal fade" id="ticketModal-{{ $ticket->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title fw-bold text-uppercase letter-spacing-1">
                                <i class="bi bi-ticket-perforated me-2"></i>Detail Tiket
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body p-4">
                            <div class="text-center mb-4">
                                <h4 class="fw-bold mb-1">{{ $ticket->race->circuit->gp_name }}</h4>
                                <p class="text-muted small mb-2">{{ $ticket->race->circuit->circuit_name }}</p>
                                <span class="badge bg-dark px-3 py-2">{{ $ticket->race->race_date->format('d F Y') }}</span>
                            </div>

                            <div class="row">
                                <div class="col-6">
                                    <div class="info-label">Nama Pemilik</div>
                                    <div class="info-value">{{ Auth::user()->name }}</div>
                                </div>
                                <div class="col-6">
                                    <div class="info-label">Waktu Pembelian</div>
                                    <div class="info-value">{{ $ticket->created_at->format('d M Y') }} <br> <small class="text-muted">{{ $ticket->created_at->format('H:i') }} WIB</small></div>
                                </div>
                                <div class="col-12">
                                    <div class="info-label">Kode Tiket</div>
                                    <div class="info-value text-danger font-monospace fs-4">{{ $ticket->ticket_code }}</div>
                                </div>
                            </div>

                            <div class="alert alert-light text-center small text-muted border border-dashed mt-2">
                                Tunjukkan kode tiket ini kepada petugas saat memasuki sirkuit.
                            </div>

                            <a href="{{ route('ticket.download', $ticket->ticket_code) }}" class="btn btn-danger w-100 fw-bold py-2 rounded-pill shadow-sm mt-2">
                                <i class="bi bi-file-earmark-pdf me-2"></i> Download PDF
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="alert alert-light text-center py-5 border rounded-4">
                    <i class="bi bi-ticket-perforated display-1 text-muted mb-3 d-block opacity-25"></i>
                    <h4 class="fw-bold">Belum Ada Tiket</h4>
                    <p class="text-muted">Anda belum pernah melakukan pembelian tiket.</p>
                    <a href="{{ route('tickets.index') }}" class="btn btn-danger rounded-pill px-4 mt-2 fw-bold">
                        Beli Tiket Sekarang
                    </a>
                </div>
            </div>
            @endforelse
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
