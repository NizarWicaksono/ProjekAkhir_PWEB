@extends('layouts.admin')

@section('title', 'Laporan Pendapatan - Admin F1')

@push('styles')
    <style>
        /* === MODERN CARD STYLE === */
        .modern-card {
            border: none;
            border-radius: 16px;
            background: white;
            box-shadow: 0 4px 20px rgba(0,0,0,0.03);
            transition: transform 0.2s, box-shadow 0.2s;
            /* Hapus overflow:hidden agar dropdown (jika ada) tidak terpotong, tapi di sini aman */
            overflow: hidden;
        }
        /* Hapus efek hover pada card agar tidak bergerak */
        /* .modern-card:hover { transform: translateY(-3px); box-shadow: ... } */

        /* === TYPOGRAPHY === */
        .stat-label { font-size: 0.9rem; color: #6c757d; text-transform: uppercase; font-weight: 600; letter-spacing: 0.5px; margin-bottom: 5px; }
        .stat-value { font-size: 2rem; font-weight: 800; color: #212529; letter-spacing: -1px; }

        /* === MODERN TABLE === */
        .table-custom thead th {
            background-color: #f8f9fa;
            color: #6c757d;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 0.75rem;
            border-bottom: none;
            padding: 15px;
        }
        .table-custom tbody td {
            padding: 15px;
            vertical-align: middle;
            border-bottom: 1px dashed #e9ecef;
            color: #495057;
            font-weight: 500;
        }
        .table-custom tbody tr:last-child td { border-bottom: none; }

        /* Memastikan tidak ada efek hover pada baris tabel */
        .table-custom tbody tr:hover {
            background-color: transparent !important;
        }

        /* === LIST ITEMS (TRANSAKSI) === */
        .transaction-item {
            padding: 15px;
            border-bottom: 1px dashed #f0f0f0;
            display: flex; align-items: center;
            /* Hapus transition background */
        }
        .transaction-item:last-child { border-bottom: none; }

        /* Hapus efek hover pada item transaksi */
        /* .transaction-item:hover { background-color: #fafafa; } */

        .avatar-circle {
            min-width: 40px; width: 40px; height: 40px;
            background-color: #e9ecef;
            color: #6c757d;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-weight: bold;
            margin-right: 15px;
        }
    </style>
@endpush

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold m-0 text-dark">💰 Laporan Keuangan</h3>
        </div>
    </div>

    {{-- ROW STATISTIK --}}
    <div class="row g-4 mb-4">
        <div class="col-md-6">
            <div class="modern-card p-4 h-100">
                <div class="d-flex justify-content-between align-items-center h-100">
                    <div>
                        <div class="stat-label">Total Pendapatan Bersih</div>
                        <div class="stat-value text-success">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
                    </div>
                    {{-- Icon Asli --}}
                    <div class="bg-success bg-opacity-10 p-3 rounded-3">
                        <i class="bi bi-cash-stack text-success fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="modern-card p-4 h-100">
                <div class="d-flex justify-content-between align-items-center h-100">
                    <div>
                        <div class="stat-label">Total Tiket Terjual</div>
                        <div class="stat-value">{{ $totalTicketsSold }} <span class="fs-6 text-muted fw-normal">Tiket</span></div>
                    </div>
                    {{-- Icon Asli --}}
                    <div class="bg-primary bg-opacity-10 p-3 rounded-3">
                        <i class="bi bi-ticket-perforated-fill text-primary fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        {{-- KOLOM KIRI: TABEL LAPORAN --}}
        <div class="col-lg-8">
            <div class="modern-card">
                <div class="d-flex justify-content-between align-items-center p-4 pb-2 border-bottom border-light">
                    <h6 class="fw-bold m-0 text-uppercase ls-1 text-dark">
                        Pendapatan per Grand Prix
                    </h6>
                </div>
                <div class="table-responsive">
                    {{-- Pastikan class 'table-hover' TIDAK ADA disini --}}
                    <table class="table table-custom mb-0">
                        <thead>
                            <tr>
                                <th class="ps-4">Nama Event</th>
                                <th>Tanggal</th>
                                <th class="text-center">Tiket Terjual</th>
                                <th class="text-end">Total Pendapatan</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($raceReports as $report)
                            <tr>
                                <td class="ps-4">
                                    <span class="fw-bold text-dark">{{ $report->gp_name }}</span>
                                </td>
                                <td class="text-muted small">
                                    {{ \Carbon\Carbon::parse($report->race_date)->format('d M Y') }}
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-secondary bg-opacity-10 text-secondary rounded-pill px-3">
                                        {{ $report->sold_count }}
                                    </span>
                                </td>
                                <td class="text-end fw-bold text-success">
                                    Rp {{ number_format($report->total_income, 0, ',', '.') }}
                                </td>
                                <td class="text-end pe-4">
                                    <a href="{{ route('admin.pendapatan.detail', $report->race_id) }}" class="btn btn-sm btn-outline-dark rounded-pill px-3 fw-bold" style="font-size: 0.75rem;">
                                        Detail <i class="bi bi-arrow-right ms-1"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">
                                    <i class="bi bi-inbox display-6 d-block mb-2 opacity-25"></i>
                                    Belum ada data penjualan.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- KOLOM KANAN: TRANSAKSI TERBARU --}}
        <div class="col-lg-4">
            <div class="modern-card">
                <div class="p-4 pb-2 border-bottom border-light">
                    <h6 class="fw-bold m-0 text-uppercase ls-1 text-dark">
                        <i class="bi bi-clock-history text-primary me-2"></i>Transaksi Terbaru
                    </h6>
                </div>

                <div class="transaction-list">
                    @forelse($recentTransactions as $trx)
                        <div class="transaction-item">
                            <div class="avatar-circle shrink-0">
                                <i class="bi bi-person-fill"></i>
                            </div>
                            <div class="grow pe-3">
                                {{-- Nama Pembeli (Full) --}}
                                <div class="fw-bold text-dark" style="line-height: 1.2; word-break: break-word;">
                                    {{ $trx->user->name ?? 'Guest' }}
                                </div>
                                <div class="text-muted small text-truncate" style="max-width: 180px; font-size: 0.75rem;">
                                    {{ $trx->race->circuit->gp_name ?? 'Unknown GP' }}
                                </div>
                            </div>
                            <div class="text-end shrink-0">
                                {{-- Format Uang Lengkap --}}
                                <div class="fw-bold text-success small">
                                    + Rp {{ number_format($trx->price, 0, ',', '.') }}
                                </div>
                                <div class="text-muted" style="font-size: 0.65rem;">
                                    {{ $trx->created_at->diffForHumans() }}
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5 text-muted small">
                            Belum ada transaksi masuk.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
