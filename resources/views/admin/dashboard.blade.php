@extends('layouts.admin')

@section('title', 'Admin Panel - F1 Hub')

@push('styles')
    <style>
        /* Stats Card Styles (Khusus Dashboard) */
        .stat-card {
            border: none;
            border-radius: 12px;
            background: white;
            padding: 25px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.05);
            transition: transform 0.2s;
            height: 100%;
        }
        .stat-card:hover { transform: translateY(-5px); }
        .stat-icon {
            width: 50px; height: 50px;
            background-color: #fff5f5;
            color: #e10600;
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.5rem; margin-bottom: 15px;
        }
        .stat-value { font-size: 2rem; font-weight: 800; color: #111; line-height: 1; }
        .stat-label { font-size: 0.85rem; color: #6c757d; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600; }

        /* Quick Action Button Styles */
        .btn-action {
            padding: 30px;
            border: 2px dashed #ddd;
            background: white;
            color: #555;
            font-weight: 700;
            border-radius: 12px;
            width: 100%;
            transition: all 0.2s;
        }
        .btn-action:hover {
            border-color: #e10600;
            color: #e10600;
            background: #fff5f5;
        }
    </style>
@endpush

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold m-0">📊 Overview Statistik</h3>
        <a href="{{ route('users.dashboard') }}" class="btn btn-outline-dark btn-sm fw-bold">
            <i class="bi bi-box-arrow-up-right me-1"></i> Lihat Website User
        </a>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon"><i class="bi bi-cash-coin"></i></div>
                <div class="stat-value">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
                <div class="stat-label">Total Pendapatan</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon" style="color: #2ecc71; background: #eafff0;">
                    <i class="bi bi-ticket-perforated-fill"></i>
                </div>
                <div class="stat-value">{{ number_format($totalTickets, 0, ',', '.') }}</div>
                <div class="stat-label">Tiket Terjual</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon" style="color: #3498db; background: #f0f8ff;"><i class="bi bi-flag-fill"></i></div>
                <div class="stat-value">{{ $totalRaces }}</div>
                <div class="stat-label">Jadwal Balapan</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon" style="color: #9b59b6; background: #fcf0ff;"><i class="bi bi-people-fill"></i></div>
                <div class="stat-value">{{ $totalUsers }}</div>
                <div class="stat-label">User Terdaftar</div>
            </div>
        </div>
    </div>

    <h5 class="fw-bold mb-3">⚡ Aksi Cepat</h5>
    <div class="row g-3">
        <div class="col-md-4">
            <a href="#" class="btn-action d-block text-decoration-none text-center">
                <i class="bi bi-plus-circle display-6 d-block mb-2"></i>
                Tambah Jadwal Balapan
            </a>
        </div>
        <div class="col-md-4">
            <a href="#" class="btn-action d-block text-decoration-none text-center">
                <i class="bi bi-pencil-square display-6 d-block mb-2"></i>
                Tulis Artikel Baru
            </a>
        </div>
        <div class="col-md-4">
            <a href="{{ route('admin.pendapatan') }}" class="btn-action d-block text-decoration-none text-center">
                <i class="bi bi-file-earmark-spreadsheet display-6 d-block mb-2"></i>
                Export Laporan Penjualan
            </a>
        </div>
    </div>
@endsection
