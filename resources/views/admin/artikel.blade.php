<!DOCTYPE html>
<html lang="id">
<head>
    <title>Kelola Artikel - Admin F1</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f3f4f6; }
        .navbar-admin { background-color: #111; padding: 15px 0; }
        .navbar-brand { font-weight: 900; letter-spacing: -1px; font-size: 24px; color: #e10600 !important; }
        .nav-link { color: #ccc !important; font-weight: 600; font-size: 0.9rem; margin-right: 15px; }
        .nav-link:hover, .nav-link.active { color: white !important; }

        .article-card {
            border: none; border-radius: 12px; overflow: hidden;
            background: white; transition: transform 0.2s; height: 100%;
            display: flex; flex-direction: column;
        }
        .article-card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1); }
        .article-img { height: 180px; object-fit: cover; background-color: #eee; }
    </style>
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-admin shadow-sm mb-5">
        <div class="container">
            <a class="navbar-brand" href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2 me-2"></i>ADMIN PANEL</a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.dashboard') }}"><i class="bi bi-grid me-1"></i> Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.lihatjadwal') }}"><i class="bi bi-ticket-detailed me-1"></i> Tiket & Jadwal</a></li>
                    <li class="nav-item"><a class="nav-link active" href="{{ route('admin.articles.index') }}"><i class="bi bi-newspaper me-1"></i> Artikel</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.pendapatan') }}"><i class="bi bi-wallet2 me-1"></i> Pendapatan</a></li>
                </ul>
                <div class="d-flex align-items-center">
                    <span class="text-white me-3 small">Hi, {{ Auth::user()->name }}</span>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf <button type="submit" class="btn btn-sm btn-danger fw-bold">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="container pb-5">
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
                    <img src="{{ $article->image ? asset('storage/' . $article->image) : 'https://images.unsplash.com/photo-1568605117036-5fe5e7bab0b7?q=80&w=2070&auto=format&fit=crop' }}"
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
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
