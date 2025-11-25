<!DOCTYPE html>
<html lang="id">
<head>
    <title>{{ $article->title }} - F1 Ticket</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f3f4f6; }

        /* Navbar Style (Konsisten dengan Dashboard) */
        .navbar-f1 { background-color: #e10600; }
        .nav-link { color: rgba(255,255,255,0.8) !important; font-weight: 600; margin-right: 15px; }
        .nav-link:hover, .nav-link.active { color: white !important; opacity: 1; }

        /* Detail Artikel Style */
        .article-card { border: none; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.05); }
        .article-img-header {
            width: 100%;
            height: 400px;
            object-fit: cover;
            object-position: center;
        }
        .article-content { font-size: 1.1rem; line-height: 1.8; color: #333; }
        .meta-info { font-size: 0.9rem; color: #6c757d; }
    </style>
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark navbar-f1 shadow-sm mb-4 sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold fst-italic" href="{{ route('users.dashboard') }}">
                <i class="bi bi-flag-fill me-2"></i>F1 TICKET
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('users.dashboard') }}">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('tickets.index') }}">Beli Tiket</a>
                    </li>
                </ul>

                <div class="d-flex align-items-center text-white">
                    @auth
                        <div class="dropdown">
                            <a href="#" class="text-white text-decoration-none dropdown-toggle fw-bold" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle me-1"></i> {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
                                <li><a class="dropdown-item" href="{{ route('users.profile') }}">Profil Saya</a></li>
                                <li><a class="dropdown-item" href="{{ route('users.history') }}">Riwayat</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger fw-bold">Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-sm btn-light text-danger fw-bold me-2">Login</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <div class="container pb-5">
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('users.dashboard') }}" class="text-decoration-none text-danger fw-bold">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Detail Berita</li>
            </ol>
        </nav>

        <div class="row justify-content-center">
            <div class="col-lg-10">

                <div class="card article-card bg-white">
                    <img src="{{ $article->image ? asset('storage/'.$article->image) : 'https://images.unsplash.com/photo-1598556965690-65036b75f5d1?q=80&w=2070&auto=format&fit=crop' }}"
                         class="article-img-header"
                         alt="{{ $article->title }}">

                    <div class="card-body p-4 p-md-5">
                        <h1 class="fw-bold mb-3 display-6">{{ $article->title }}</h1>

                        <div class="d-flex align-items-center mb-4 pb-3 border-bottom meta-info">
                            <div class="d-flex align-items-center me-4">
                                <i class="bi bi-calendar3 me-2 text-danger"></i>
                                {{ \Carbon\Carbon::parse($article->published_date)->translatedFormat('l, d F Y') }}
                            </div>
                            <div class="d-flex align-items-center">
                                <i class="bi bi-person-circle me-2 text-danger"></i>
                                <span>Admin Redaksi</span>
                            </div>
                        </div>

                        <div class="article-content text-justify">
                            {{-- Gunakan {!! !!} jika konten mengandung HTML editor, atau {{ }} jika teks biasa --}}
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
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
