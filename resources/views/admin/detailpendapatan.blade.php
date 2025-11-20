<!DOCTYPE html>
<html lang="id">
<head>
    <title>Detail Transaksi - Admin F1</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style> body { font-family: sans-serif; background-color: #f3f4f6; } </style>
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm mb-5" style="background-color: #111 !important;">
        <div class="container">
            <a class="navbar-brand fw-bold text-warning" href="{{ route('admin.dashboard') }}">ADMIN PANEL</a>
        </div>
    </nav>

    <div class="container pb-5">

        <div class="mb-4">
            <a href="{{ route('admin.pendapatan') }}" class="btn btn-outline-dark btn-sm fw-bold mb-3">
                <i class="bi bi-arrow-left me-1"></i> Kembali ke Laporan
            </a>

            <div class="d-flex justify-content-between align-items-end">
                <div>
                    <h5 class="text-muted mb-1">Rincian Transaksi Untuk:</h5>
                    <h2 class="fw-bold mb-0">{{ $race->circuit->gp_name }}</h2>
                    <p class="text-muted"><i class="bi bi-calendar-event me-1"></i> {{ $race->race_date->format('d F Y') }}</p>
                </div>
                <div class="text-end">
                    <h6 class="text-muted mb-1">Total Pendapatan Event Ini</h6>
                    <h3 class="fw-bold text-success">Rp {{ number_format($transactions->sum('price'), 0, ',', '.') }}</h3>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4 py-3">No</th>
                            <th>Nama Pembeli</th>
                            <th>Email</th>
                            <th>Kode Tiket</th>
                            <th>Waktu Pembelian</th>
                            <th class="text-end pe-4">Nominal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $index => $ticket)
                        <tr>
                            <td class="ps-4">{{ $index + 1 }}</td>
                            <td>
                                <div class="fw-bold">{{ $ticket->user->name ?? 'User Terhapus' }}</div>
                            </td>
                            <td class="text-muted small">{{ $ticket->user->email ?? '-' }}</td>
                            <td><span class="badge bg-light text-dark border">{{ $ticket->ticket_code }}</span></td>
                            <td>
                                {{ \Carbon\Carbon::parse($ticket->purchase_date)->format('d M Y, H:i') }} WIB
                            </td>
                            <td class="text-end pe-4 fw-bold text-success">
                                Rp {{ number_format($ticket->price, 0, ',', '.') }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">Tidak ada data transaksi.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>
</html>
