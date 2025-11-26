@extends('layouts.admin')

@section('title', 'Kelola Artikel - Admin F1')

@push('styles')
    <style>
        .article-card {
            border: none;
            border-radius: 12px;
            overflow: hidden;
            background: white;
            transition: transform 0.2s;
            height: 100%;
            display: flex;
            flex-direction: column;
            position: relative;
            cursor: pointer;
        }
        .article-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        .article-img {
            height: 180px;
            object-fit: cover;
            background-color: #eee;
        }

        .btn-delete-wrapper {
            position: relative;
            z-index: 2;
        }

        .clean-pagination .text-muted,
        .clean-pagination .small.text-muted {
            display: none !important;
        }

        .clean-pagination nav > div {
            justify-content: center !important;
            box-shadow: none !important;
        }

        .pagination {
            gap: 8px;
            justify-content: center;
            margin: 0;
        }

        .page-item:first-child .page-link,
        .page-item:last-child .page-link {
            border-radius: 50% !important;
        }

        .page-link {
            border: none;
            border-radius: 50% !important;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6c757d;
            font-weight: 700;
            font-size: 0.9rem;
            background-color: #fff;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        }

        .page-link:hover {
            background-color: #fff;
            color: #e10600;
            transform: translateY(-3px);
            box-shadow: 0 8px 15px rgba(0,0,0,0.1);
        }

        .page-item.active .page-link {
            background: linear-gradient(135deg, #e10600 0%, #ff4d4d 100%);
            color: white;
            box-shadow: 0 8px 20px rgba(225, 6, 0, 0.3);
            transform: scale(1.1);
        }

        .page-item.disabled .page-link {
            background-color: #f8f9fa;
            color: #dee2e6;
            box-shadow: none;
            transform: none;
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

    <div class="row g-4">
        @forelse($articles as $article)
        <div class="col-md-4">
            <div class="article-card shadow-sm">

                <a href="{{ route('admin.articles.show', $article->id) }}" class="stretched-link"></a>

                <img src="{{ $article->image ? $article->image : 'https://via.placeholder.com/400x250?text=Cover+Artikel' }}"
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
                            <form action="{{ route('admin.articles.destroy', $article->id) }}" method="POST" onsubmit="confirmDelete(event)">
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

    <div class="d-flex justify-content-center mt-5 clean-pagination">
        {{ $articles->links() }}
    </div>

@endsection
