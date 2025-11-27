@extends('layouts.user')

@section('title', $article->title . ' - F1 Ticket')

@push('styles')
    <style>
        .article-card {
            border: none;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        }
        .article-img-header {
            width: 100%;
            height: 400px;
            object-fit: cover;
            object-position: center;
        }
        .article-content {
            font-size: 1.1rem;
            line-height: 1.8;
            color: #333;
        }
        .meta-info {
            font-size: 0.9rem;
            color: #6c757d;
        }
    </style>
@endpush

@section('content')
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('users.dashboard') }}" class="text-decoration-none text-danger fw-bold">Dashboard</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Detail Berita</li>
        </ol>
    </nav>

    <div class="row justify-content-center">
        <div class="col-lg-10">

            <div class="card article-card bg-white">
                <img src="{{ $article->image ? $article->image : 'https://via.placeholder.com/400x250?text=Cover+Artikel' }}" class="article-img-header" alt= "Cover Artikel">

                <div class="card-body p-4 p-md-5">
                    <h1 class="fw-bold mb-3 display-6">{{ $article->title }}</h1>

                    <div class="d-flex align-items-center mb-4 pb-3 border-bottom meta-info">
                        <div class="d-flex align-items-center me-4">
                            <i class="bi bi-calendar3 me-2 text-danger"></i>
                            {{ \Carbon\Carbon::parse($article->published_date)->translatedFormat('l, d F Y') }}
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="bi bi-person-circle me-2 text-danger"></i>
                            <span>Admin</span>
                        </div>
                    </div>

                    <div class="article-content text-justify">
                        {!! nl2br(e($article->content)) !!}
                    </div>
                    <div class="mt-5 pt-4 border-top">
                        <a href="{{ route('users.dashboard') }}" class="btn btn-outline-secondary rounded-pill px-4 fw-bold">
                            <i class="bi bi-arrow-left me-2"></i>Kembali ke Dashboard
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
