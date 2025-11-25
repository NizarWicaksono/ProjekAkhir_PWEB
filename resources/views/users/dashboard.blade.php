@extends('layouts.user')

@section('title', 'Dashboard F1')

@push('styles')
<style>
    /* CSS Khusus Dashboard */
    .sidebar-widget { background: white; border-radius: 12px; padding: 20px; box-shadow: 0 2px 15px rgba(0,0,0,0.05); }
    .sticky-sidebar { position: sticky; top: 100px; z-index: 10; }
    .race-item { border-bottom: 1px solid #eee; padding-bottom: 15px; margin-bottom: 15px; }
    .race-item:last-child { border-bottom: none; margin-bottom: 0; padding-bottom: 0; }
    .date-box { background: #f8f9fa; border: 1px solid #e9ecef; border-radius: 8px; text-align: center; padding: 5px 10px; min-width: 60px; }
    .date-day { font-size: 1.2rem; font-weight: 800; line-height: 1; }
    .date-month { font-size: 0.7rem; text-transform: uppercase; font-weight: 600; }
    .news-card-hover { transition: transform 0.3s ease, box-shadow 0.3s ease; overflow: hidden; border-radius: 12px; border: none; background: white; }
    .news-card-hover:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important; }
    .news-card-hover img { transition: transform 0.5s ease; }
    .news-card-hover:hover img { transform: scale(1.05); }
</style>
@endpush

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="d-flex justify-content-between align-items-center mb-4 border-start border-5 border-danger ps-3">
            <h4 class="fw-bold m-0">F1 News</h4>
        </div>

        <div class="row">
            @forelse($articles as $article)
                <div class="col-md-6 mb-4">
                    <div class="card news-card-hover shadow-sm h-100 position-relative">
                        <a href="{{ route('news.show', $article->id) }}" class="stretched-link"></a>
                        <div style="height: 200px; overflow: hidden;">
                            <img src="{{ $article->image ? asset('storage/'.$article->image) : 'https://images.unsplash.com/photo-1598556965690-65036b75f5d1?q=80&w=2070&auto=format&fit=crop' }}"
                                 class="card-img-top w-100 h-100" style="object-fit: cover;" alt="News Cover">
                        </div>
                        <div class="card-body p-3 d-flex flex-column">
                            <div class="news-meta small text-muted mb-2">
                                <i class="bi bi-calendar3 me-1"></i> {{ \Carbon\Carbon::parse($article->published_date)->translatedFormat('d M Y') }}
                            </div>
                            <h5 class="card-title fw-bold mb-2">{{ Str::limit($article->title, 50) }}</h5>
                            <p class="card-text text-secondary small grow">
                                {{ Str::limit($article->content, 90) }}
                            </p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="empty-state text-center py-5 bg-white rounded shadow-sm">
                        <i class="bi bi-newspaper display-4 mb-3 d-block text-muted"></i>
                        <h5 class="fw-bold">Belum Ada Berita</h5>
                        <p class="text-muted">Tim redaksi sedang memanaskan mesin. Cek lagi nanti!</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    <div class="col-lg-4">
        <div class="sticky-sidebar">

            <div class="sidebar-widget">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold m-0">🏁 Next Races</h5>
                </div>

                @forelse($races as $race)
                    <div class="race-item d-flex align-items-center">
                        <div class="date-box me-3">
                            <div class="date-day">{{ $race->race_date->format('d') }}</div>
                            <div class="date-month">{{ $race->race_date->format('M') }}</div>
                        </div>
                        <div class="grow">
                            <h6 class="fw-bold mb-0 text-truncate">{{ $race->circuit->gp_name }}</h6>
                            <small class="text-muted d-block mb-1">
                                {{ $race->circuit->circuit_name }}
                            </small>
                            <small class="text-danger fw-bold d-block mb-1" style="font-size: 0.75rem;">
                                <i class="bi bi-clock me-1"></i> {{ $race->race_date->format('H:i') }} WIB
                            </small>

                            <small class="text-success fw-bold" style="font-size: 0.75rem;">
                                Rp {{ number_format($race->base_price, 0, ',', '.') }}
                            </small>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-4 text-muted">
                        <i class="bi bi-flag-fill fs-1 mb-2 d-block text-secondary"></i>
                        <p class="small fw-bold">Tidak ada jadwal dekat.</p>
                    </div>
                @endforelse
            </div>

            <div class="card border-0 shadow-sm mt-4 bg-dark text-white text-center p-4" style="border-radius: 12px;">
                <h5 class="fw-bold">Ingin Nonton Langsung?</h5>
                <p class="small text-white-50 mb-3">Cek ketersediaan tiket untuk balapan favoritmu sekarang.</p>
                <a href="{{ route('tickets.index') }}" class="btn btn-danger fw-bold w-100 rounded-pill">Beli Tiket Sekarang</a>
            </div>

        </div>
    </div>
</div>
@endsection
