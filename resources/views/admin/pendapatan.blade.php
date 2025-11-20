<!DOCTYPE html>
<html lang="id">
<head>
    <title>Laporan Pendapatan - Admin F1</title>
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

        .card { border: none; border-radius: 12px; box-shadow: 0 2px 15px rgba(0,0,0,0.05); }
        .stat-label { font-size: 0.9rem; color: #6c757d; text-transform: uppercase; font-weight: 600; }
        .stat-value { font-size: 2rem; font-weight: 800; color: #111; }
    </style>
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-admin shadow-sm mb-5">
        <div class="container">
            <a class="navbar-brand" href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2 me-2"></i>ADMIN PANEL</a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.dashboard') }}"><i class="bi bi-grid me-1"></i> Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.lihatjadwal') }}"><i class="bi bi-ticket-detailed me-1"></i> Tiket & Jadwal</a></li>
                    <li class="nav-item"><a class="nav-link" href="#"><i class="bi bi-newspaper me-1"></i> Artikel</a></li>
                    <li class="nav-item"><a class="nav-link active" href="#"><i class="bi bi-wallet2 me-1"></i> Pendapatan</a></li>
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
            <h3 class="fw-bold m-0">💰 Laporan Keuangan</h3>
            <button onclick="window.print()" class="btn btn-outline-dark btn-sm fw-bold"><i class="bi bi-printer me-1"></i> Cetak Laporan</button>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-md-6">
                <div class="card p-4 h-100">
                    <div class="d-flex align-items-center">
                        <div class="grow">
                            <div class="stat-label mb-1">Total Pendapatan</div>
                            <div class="stat-value text-success">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
                        </div>
                        <div class="bg-success bg-opacity-10 p-3 rounded-3">
                            <i class="bi bi-cash-stack text-success fs-1"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card p-4 h-100">
                    <div class="d-flex align-items-center">
                        <div class="grow">
                            <div class="stat-label mb-1">Total Tiket Terjual</div>
                            <div class="stat-value">{{ $totalTicketsSold }} <span class="fs-6 text-muted fw-normal">Tiket</span></div>
                        </div>
                        <div class="bg-primary bg-opacity-10 p-3 rounded-3">
                            <i class="bi bi-ticket-perforated-fill text-primary fs-1"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8 mb-4">
                <div class="card h-100">
                    <div class="card-header bg-white py-3 border-0">
                        <h6 class="m-0 fw-bold">🏎️ Rincian Pendapatan per Grand Prix</h6>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">Nama Event</th>
                                    <th>Tanggal</th>
                                    <th class="text-center">Tiket Terjual</th>
                                    <th class="text-end">Total Pendapatan</th>
                                    <th class="text-end pe-4">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($raceReports as $report)
                                <tr>
                                    <td class="ps-4 fw-bold">{{ $report->gp_name }}</td>
                                    <td class="small text-muted">{{ \Carbon\Carbon::parse($report->race_date)->format('d M Y') }}</td>
                                    <td class="text-center"><span class="badge bg-secondary">{{ $report->sold_count }}</span></td>
                                    <td class="text-end fw-bold text-success">Rp {{ number_format($report->total_income, 0, ',', '.') }}</td>

                                    <td class="text-end pe-4">
                                        <a href="{{ route('admin.pendapatan.detail', $report->race_id) }}" class="btn btn-sm btn-outline-primary fw-bold">
                                            Detail <i class="bi bi-arrow-right"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="5" class="text-center py-5 text-muted">Belum ada data penjualan.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 mb-4">
                <div class="card h-100">
                    <div class="card-header bg-white py-3 border-0">
                        <h6 class="m-0 fw-bold">🕒 Transaksi Terbaru</h6>
                    </div>
                    <div class="card-body p-0">
                        <ul class="list-group list-group-flush">
                            @forelse($recentTransactions as $trx)
                            <li class="list-group-item p-3 border-0 border-bottom">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <div class="fw-bold text-dark">{{ $trx->user->name ?? 'Guest' }}</div>
                                        <div class="small text-muted">{{ $trx->race->circuit->gp_name ?? 'Unknown GP' }}</div>
                                        <div class="small text-secondary" style="font-size: 0.75rem;">
                                            {{ $trx->created_at->diffForHumans() }}
                                        </div>
                                    </div>
                                    <div class="fw-bold text-success small">
                                        + Rp {{ number_format($trx->price, 0, ',', '.') }}
                                    </div>
                                </div>
                            </li>
                            @empty
                            <li class="list-group-item text-center py-4 text-muted">Belum ada transaksi.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
