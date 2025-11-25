<!DOCTYPE html>
<html lang="id">
<head>
    <title>{{ $article->title }} - F1 News</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&family=Merriweather:ital,wght@0,300;0,700;1,300&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8f9fa; }
        .navbar-f1 { background-color: #e10600 !important; }

        /* Hero Image */
        .article-hero {
            height: 400px; width: 100%;
            object-fit: cover;
            border-radius: 0 0 20px 20px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }

        /* Container Artikel */
        .article-container { max-width: 800px; margin: -100px auto 0; position: relative; z-index: 10; }
        .article-paper { background: white; padding: 40px; border-radius: 20px; box-shadow: 0 10px 40px rgba(0,0,0,0.05); }
        .article-title { font-weight: 900; color: #111; font-size: 2rem; margin-bottom: 15px; }
        .article-meta { color: #6c757d; font-size: 0.9rem; margin-bottom: 30px; padding-bottom: 20px; border-bottom: 1px solid #eee; }
        .article-body {
            font-family: 'Merriweather', serif; /* Font enak untuk baca */
            font-size: 1.1rem; line-height: 1.8; color: #333;
        }
        .article-body p { margin-bottom: 20px; }

        /* Sidebar Rekomendasi */
        .rec-card { border: none; background: white; transition: 0.2s; border-radius: 12px; overflow: hidden; }
        .rec-card:hover { transform: translateY(-3px); box-shadow: 0 5px 15px rgba(0,0,0,0.05); }
        .rec-img { height: 120px; object-fit: cover; }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark navbar-f1 shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold fst-italic" href="{{ route('users.dashboard') }}">
                <i class="bi bi-arrow-left me-2"></i> Kembali ke Dashboard
            </a>
        </div>
    </nav>

    <img src="{{ $article->image ? asset('storage/' . $article->image) : 'https://images.unsplash.com/photo-1568605117036-5fe5e7bab0b7?q=80&w=2070&auto=format&fit=crop' }}" class="article-hero">

    <div class="container pb-5">
        <div class="row">
            <div class="col-lg-8 mx-auto article-container">

                <div class="article-paper">
                    <span class="badge bg-danger mb-2">F1 NEWS</span>
                    <h1 class="article-title">{{ $article->title }}</h1>

                    <div class="article-meta d-flex align-items-center">
                        <div class="me-3"><i class="bi bi-calendar3 me-1"></i> {{ \Carbon\Carbon::parse($article->published_date)->translatedFormat('d F Y') }}</div>
                        <div><i class="bi bi-person-circle me-1"></i> Admin Redaksi</div>
                    </div>

                    <div class="article-body">
                        {!! nl2br(e($article->content)) !!}
                    </div>

                    <hr class="my-5">
                    <div class="text-center">
                        <small class="text-muted">Bagikan berita ini:</small>
                        <div class="mt-2">
                            <button class="btn btn-outline-dark btn-sm rounded-circle me-1"><i class="bi bi-whatsapp"></i></button>
                            <button class="btn btn-outline-dark btn-sm rounded-circle me-1"><i class="bi bi-twitter-x"></i></button>
                            <button class="btn btn-outline-dark btn-sm rounded-circle"><i class="bi bi-facebook"></i></button>
                        </div>
                    </div>
                </div>

                <h5 class="fw-bold mt-5 mb-3">Berita Lainnya</h5>
                <div class="row g-3">
                    @foreach($otherArticles as $item)
                    <div class="col-md-4">
                        <a href="{{ route('news.show', $item->id) }}" class="text-decoration-none text-dark">
                            <div class="rec-card h-100 shadow-sm">
                                <img src="{{ $item->image ? asset('storage/' . $item->image) : 'https://via.placeholder.com/300x200' }}" class="w-100 rec-img">
                                <div class="p-3">
                                    <small class="text-muted d-block mb-1">{{ \Carbon\Carbon::parse($item->published_date)->format('d M Y') }}</small>
                                    <h6 class="fw-bold mb-0 text-truncate">{{ $item->title }}</h6>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>

            </div>
        </div>
    </div>

</body>
</html>
