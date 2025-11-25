@extends('layouts.admin')

@section('title', 'Laporan Pendapatan - Admin F1')

@push('styles')
    <style>
        .card { border: none; border-radius: 12px; box-shadow: 0 2px 15px rgba(0,0,0,0.05); }
        .stat-label { font-size: 0.9rem; color: #6c757d; text-transform: uppercase; font-weight: 600; }
        .stat-value { font-size: 2rem; font-weight: 800; color: #111; }
    </style>
@endpush

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold m-0">💰 Laporan Keuangan</h3>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-6">
            <div class="card p-4 h-100">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="stat-label mb-1">Total Pendapatan Bersih</div>
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
                <div class="d-flex justify-content-between align-items-center">
                    <div>
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
@endsection
