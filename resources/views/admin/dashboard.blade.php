@extends('layouts.admin')

@section('title', 'Admin Panel - F1 Hub')

@push('styles')
    <style>
        .stat-card {
            border: none;
            border-radius: 20px;
            background: white;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.04);
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            height: 100%;
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
        }

        .stat-icon-wrapper {
            width: 60px;
            height: 60px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.75rem;
            margin-bottom: 25px;
            color: white;
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        }

        .bg-grad-red { background: linear-gradient(135deg, #ff4d4d 0%, #c20b04 100%); }
        .bg-grad-green { background: linear-gradient(135deg, #2ecc71 0%, #218c74 100%); }
        .bg-grad-blue { background: linear-gradient(135deg, #3498db 0%, #2980b9 100%); }
        .bg-grad-purple { background: linear-gradient(135deg, #9b59b6 0%, #8e44ad 100%); }

        .stat-value {
            font-size: 2.25rem;
            font-weight: 800;
            color: #212529;
            line-height: 1.1;
            margin-bottom: 5px;
            letter-spacing: -1px;
        }
        .stat-label {
            font-size: 0.9rem;
            color: #adb5bd;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .stat-decoration {
            position: absolute;
            top: -30px; right: -30px;
            width: 120px; height: 120px;
            border-radius: 50%;
            opacity: 0.05;
            z-index: 0;
        }
        .bg-dec-red { background-color: #e10600; }
        .bg-dec-green { background-color: #2ecc71; }
        .bg-dec-blue { background-color: #3498db; }
        .bg-dec-purple { background-color: #9b59b6; }
    </style>
@endpush

@section('content')
    <div class="d-flex justify-content-between align-items-end mb-5">
        <div>
            <h2 class="fw-bold m-0 text-dark">Welcome, Admin!</h2>
            <p class="text-muted m-0 mt-2">Berikut adalah overview statistik dari F1 Ticket</p>
        </div>
        <div class="text-end d-none d-md-block">
            <span class="badge bg-light text-dark border px-3 py-2 rounded-pill shadow-sm">
                <i class="bi bi-calendar3 me-2"></i> {{ now()->translatedFormat('l, d F Y') }}
            </span>
        </div>
    </div>

    <div class="row g-4">
        {{-- Pendapatan --}}
        <div class="col-md-6 col-xl-3">
            <div class="stat-card">
                <div class="stat-decoration bg-dec-red"></div>
                <div class="stat-icon-wrapper bg-grad-red">
                    <i class="bi bi-wallet2"></i>
                </div>
                <div>
                    <div class="stat-value">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
                    <div class="stat-label">Total Pendapatan</div>
                </div>
            </div>
        </div>

        {{-- Tiket Terjual --}}
        <div class="col-md-6 col-xl-3">
            <div class="stat-card">
                <div class="stat-decoration bg-dec-green"></div>
                <div class="stat-icon-wrapper bg-grad-green">
                    <i class="bi bi-ticket-perforated-fill"></i>
                </div>
                <div>
                    <div class="stat-value">{{ number_format($totalTickets, 0, ',', '.') }}</div>
                    <div class="stat-label">Tiket Terjual</div>
                </div>
            </div>
        </div>

        {{-- Jadwal Balapan --}}
        <div class="col-md-6 col-xl-3">
            <div class="stat-card">
                <div class="stat-decoration bg-dec-blue"></div>
                <div class="stat-icon-wrapper bg-grad-blue">
                    <i class="bi bi-flag-fill"></i>
                </div>
                <div>
                    <div class="stat-value">{{ $totalRaces }}</div>
                    <div class="stat-label">Jadwal Balapan</div>
                </div>
            </div>
        </div>

        {{-- User Terdaftar --}}
        <div class="col-md-6 col-xl-3">
            <div class="stat-card">
                <div class="stat-decoration bg-dec-purple"></div>
                <div class="stat-icon-wrapper bg-grad-purple">
                    <i class="bi bi-people-fill"></i>
                </div>
                <div>
                    <div class="stat-value">{{ $totalUsers }}</div>
                    <div class="stat-label">User Terdaftar</div>
                </div>
            </div>
        </div>

    </div>
@endsection
