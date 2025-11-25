@extends('layouts.admin')

@section('title', 'Kelola Artikel - Admin F1')

@push('styles')
    <style>
        /* Article Card Styles (Khusus Artikel) */
        .article-card {
            border: none; border-radius: 12px; overflow: hidden;
            background: white; transition: transform 0.2s; height: 100%;
            display: flex; flex-direction: column;
            position: relative;
            cursor: pointer;
        }
        .article-card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1); }
        .article-img { height: 180px; object-fit: cover; background-color: #eee; }

        .btn-delete-wrapper {
            position: relative;
            z-index: 2;
        }
    </style>
@endpush

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold m-0">📰 Daftar Artikel Berita</h3>
        <a href="{{ route('admin.articles.create') }}" class="btn btn-danger fw-bold shadow-sm">
            <i class="bi bi-pencil-square me-1"></i> Tulis Artikel Baru
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm mb-4">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
        </div>
    @endif

    <div class="row g-4">
        @forelse($articles as $article)
        <div class="col-md-4">
            <div class="article-card shadow-sm">

                <a href="{{ route('admin.articles.show', $article->id) }}" class="stretched-link"></a>

                <img src="{{ $article->image ? $article->image : 'https://via.placeholder.com/400x250?text=Cover+Artikel' }}"
                     class="article-img" alt="Cover">

                <div class="card-body p-4 d-flex flex-column h-100">
                    <span class="badge bg-light text-muted border mb-2 w-auto align-self-start">
                        <i class="bi bi-clock me-1"></i>
                        {{ $article->created_at->format('d M Y, H:i') }} WIB
                    </span>

                    <h5 class="fw-bold mb-2 text-dark" style="min-height: 3rem;">{{ Str::limit($article->title, 50) }}</h5>
                    <p class="text-muted small mb-3 grow">
                        {{ Str::limit($article->content, 100) }}
                    </p>

                    <div class="mt-auto pt-3 border-top d-flex justify-content-between align-items-center">
                        <small class="text-muted"><i class="bi bi-person-circle me-1"></i> Admin</small>

                        <div class="btn-delete-wrapper">
                            <form action="{{ route('admin.articles.destroy', $article->id) }}" method="POST" onsubmit="return confirm('Hapus artikel ini?');">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger rounded-pill px-3">
                                    <i class="bi bi-trash"></i> Hapus
                                </button>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="alert alert-light text-center border-0 shadow-sm py-5">
                <i class="bi bi-newspaper display-4 text-muted mb-3 d-block"></i>
                <h5 class="fw-bold mb-1">Belum ada artikel.</h5>
                <p class="text-muted">Mulai menulis berita terbaru seputar F1 sekarang.</p>
            </div>
        </div>
        @endforelse
    </div>

    {{-- TAMBAHKAN PAGINATION DI SINI --}}
    <div class="d-flex justify-content-center mt-5">
        {{ $articles->links() }}
    </div>

@endsection
