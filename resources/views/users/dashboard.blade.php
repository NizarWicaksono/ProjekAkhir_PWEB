@extends('layouts.user')

@section('title', 'Dashboard F1')

@push('styles')
<style>
    /* === CARD BERITA (CLEAN STYLE) === */
    .news-card {
        position: relative;
        border: none;
        border-radius: 16px;
        background: #fff;
        /* Shadow lembut agar card melayang */
        box-shadow: 0 2px 20px rgba(0,0,0,0.04);
        transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        height: 100%;
        overflow: hidden;
    }
    .news-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.1); /* Shadow lebih dalam saat hover */
    }

    .news-img-wrapper {
        height: 220px;
        overflow: hidden;
        position: relative;
    }
    .news-img-wrapper img {
        transition: transform 0.5s ease;
        width: 100%; height: 100%; object-fit: cover;
    }
    .news-card:hover .news-img-wrapper img {
        transform: scale(1.05);
    }

    /* Badge Kategori di atas gambar */
    .category-badge {
        position: absolute; top: 15px; left: 15px;
        background: rgba(225, 6, 0, 0.9); color: white;
        padding: 4px 12px; border-radius: 30px;
        font-size: 0.75rem; font-weight: 700;
        box-shadow: 0 4px 10px rgba(0,0,0,0.2);
    }

    /* === SIDEBAR MODERN === */
    .sidebar-wrapper {
        position: sticky; top: 100px;
    }
    .sidebar-card {
        background: #fff;
        border-radius: 16px;
        padding: 25px;
        border: none;
        box-shadow: 0 4px 25px rgba(0,0,0,0.05);
    }

    .section-header {
        display: flex; align-items: center; margin-bottom: 20px;
        border-bottom: 2px solid #f0f0f0; padding-bottom: 15px;
    }
    .section-title {
        font-weight: 800; font-size: 1.1rem; margin: 0;
        text-transform: uppercase; color: #212529;
        letter-spacing: 0.5px;
    }

    /* List Balapan */
    .race-item {
        display: flex; align-items: center;
        padding: 12px 0;
        border-bottom: 1px dashed #eee;
    }
    .race-item:last-child { border-bottom: none; }

    /* Kotak Tanggal Minimalis */
    .date-box {
        background: #f8f9fa;
        color: #212529;
        border-radius: 10px;
        text-align: center;
        padding: 8px 12px;
        min-width: 65px;
        font-weight: 800;
        line-height: 1.1;
        border: 1px solid #e9ecef;
    }
    .date-month { font-size: 0.7rem; color: #e10600; text-transform: uppercase; font-weight: 700; display: block; }
</style>
@endpush

@section('content')
<div class="row g-4">

    <div class="col-lg-8">
        <div class="d-flex align-items-center mb-4">
            <div class="bg-danger rounded-pill me-3" style="width: 5px; height: 30px;"></div>
            <h3 class="fw-bold m-0 ls-1">F1 NEWS</h3>
        </div>

        <div class="row g-4">
            @forelse($articles as $article)
                <div class="col-md-6">
                    <div class="news-card">
                        <a href="{{ route('news.show', $article->id) }}" class="stretched-link"></a>
                        <div class="news-img-wrapper">
                            <img src="{{ $article->image ? $article->image : 'https://via.placeholder.com/400x250?text=F1+News' }}" alt="Cover Berita">
                        </div>
                        <div class="card-body p-4 d-flex flex-column">
                            <div class="d-flex align-items-center text-muted small mb-2 fw-bold" style="font-size: 0.75rem;">
                                <i class="bi bi-calendar-event me-2"></i>
                                {{ \Carbon\Carbon::parse($article->published_date)->format('d F Y') }}
                            </div>
                            <h5 class="card-title fw-bold text-dark mb-2" style="line-height: 1.4;">
                                {{ Str::limit($article->title, 55) }}
                            </h5>
                            <p class="card-text text-secondary small mb-0 grow">
                                {{ Str::limit($article->content, 80) }}
                            </p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-light text-center py-5 border-0 shadow-sm rounded-4">
                        <i class="bi bi-newspaper display-4 text-muted mb-3 d-block opacity-50"></i>
                        <h6 class="fw-bold text-muted">Belum ada berita saat ini.</h6>
                    </div>
                </div>
            @endforelse
        </div>

        <div class="d-flex justify-content-center mt-5">
            {{ $articles->links() }}
        </div>
    </div>

    <div class="col-lg-4">
        <div class="sidebar-wrapper">

            <div class="sidebar-card mb-4">
                <div class="section-header">
                    <h5 class="section-title grow">Up Next</h5>
                    <a href="{{ route('tickets.index') }}" class="text-danger fw-bold small text-decoration-none">VIEW ALL</a>
                </div>

                @forelse($races as $race)
                    <div class="race-item">
                        <div class="date-box me-3">
                            <span class="fs-4">{{ $race->race_date->format('d') }}</span>
                            <span class="date-month">{{ $race->race_date->format('M') }}</span>
                        </div>
                        <div class="grow">
                            <h6 class="fw-bold mb-0 text-dark text-truncate">{{ $race->circuit->gp_name }}</h6>
                            <small class="text-muted d-block mb-1" style="font-size: 0.8rem;">{{ $race->circuit->country }}</small>

                            <div class="d-flex align-items-center justify-content-between mt-1">
                                <span class="badge bg-light text-dark border fw-bold">
                                    <i class="bi bi-clock me-1"></i> {{ $race->race_date->format('H:i') }}
                                </span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-4 text-muted">
                        <i class="bi bi-flag-fill fs-4 mb-2 d-block opacity-25"></i>
                        <p class="small fw-bold mb-0">Tidak ada jadwal dekat.</p>
                    </div>
                @endforelse
            </div>

            <div class="card border-0 shadow-sm overflow-hidden rounded-4 text-white text-center" style="background: linear-gradient(135deg, #111 0%, #333 100%);">
                <div class="card-body p-4">
                    <h5 class="fw-bold fst-italic">SECURE YOUR SEAT!</h5>
                    <p class="small text-white-50 mb-4">Jangan lewatkan aksi balapan langsung di sirkuit favoritmu.</p>
                    <a href="{{ route('tickets.index') }}" class="btn btn-danger fw-bold w-100 rounded-pill shadow">BELI TIKET SEKARANG</a>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
