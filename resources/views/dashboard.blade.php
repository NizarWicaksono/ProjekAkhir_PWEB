<!DOCTYPE html>
<html lang="id">
<head>
    <title>Dashboard - F1 Hub</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f3f4f6; }

        /* Navbar */
        .navbar-f1 { background-color: #e10600; padding: 15px 0; }
        .navbar-brand { font-weight: 900; letter-spacing: -1px; font-size: 24px; }

        /* Layout Style */
        .section-title {
            font-weight: 800;
            border-left: 5px solid #e10600;
            padding-left: 15px;
            margin-bottom: 25px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Card Berita */
        .news-card {
            border: none;
            border-radius: 12px;
            margin-bottom: 30px;
            transition: transform 0.2s;
            overflow: hidden;
        }
        .news-card:hover { transform: translateY(-3px); }
        .news-img {
            height: 250px;
            object-fit: cover;
            background-color: #ddd;
        }
        .news-meta { font-size: 0.85rem; color: #6c757d; margin-bottom: 10px; }

        /* Sidebar Widget */
        .sidebar-widget {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.05);
            position: sticky; /* Sidebar Nempel saat scroll */
            top: 20px;
        }
        .race-item {
            border-bottom: 1px solid #eee;
            padding-bottom: 15px;
            margin-bottom: 15px;
        }
        .race-item:last-child { border-bottom: none; margin-bottom: 0; padding-bottom: 0; }

        .date-box {
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            text-align: center;
            padding: 5px 10px;
            min-width: 60px;
        }
        .date-day { font-size: 1.2rem; font-weight: 800; line-height: 1; }
        .date-month { font-size: 0.7rem; text-transform: uppercase; font-weight: 600; }

        /* Empty State Style */
        .empty-state {
            text-align: center;
            padding: 40px;
            background: white;
            border-radius: 12px;
            border: 2px dashed #dee2e6;
            color: #adb5bd;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark navbar-f1 shadow-sm mb-4">
        <div class="container">
            <a class="navbar-brand" href="{{ route('dashboard') }}"><i class="bi bi-flag-fill me-2"></i>F1 HUB</a>

            <div class="d-flex align-items-center ms-auto">

                @auth
                    <div class="dropdown">
                        <a href="#" class="text-white text-decoration-none dropdown-toggle fw-bold" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle me-1"></i> {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
                            @if(Auth::user()->role == 'admin')
                                <li><a class="dropdown-item fw-bold text-danger" href="#"><i class="bi bi-speedometer2 me-2"></i>Panel Admin</a></li>
                                <li><hr class="dropdown-divider"></li>
                            @endif

                            <li><a class="dropdown-item" href="#"><i class="bi bi-ticket-perforated me-2"></i>Tiket Saya</a></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="btn btn-sm btn-outline-light me-2 fw-bold">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-sm btn-light text-danger fw-bold">Register</a>
                @endauth

            </div>
        </div>
    </nav>

    <div class="container pb-5">
        <div class="row">

            <div class="col-lg-8">
                <h4 class="section-title">Berita Terbaru</h4>

                @forelse($articles as $article)
                    <div class="card news-card shadow-sm">
                        <img src="{{ $article->image ? asset('storage/'.$article->image) : 'https://images.unsplash.com/photo-1598556965690-65036b75f5d1?q=80&w=2070&auto=format&fit=crop' }}" class="card-img-top news-img" alt="News Cover">

                        <div class="card-body p-4">
                            <div class="news-meta">
                                <i class="bi bi-calendar3 me-1"></i> {{ \Carbon\Carbon::parse($article->published_date)->translatedFormat('d F Y') }}
                                <span class="mx-2">•</span>
                                <i class="bi bi-person me-1"></i> Admin
                            </div>
                            <h3 class="card-title fw-bold mb-3">{{ $article->title }}</h3>
                            <p class="card-text text-secondary">
                                {{ Str::limit($article->content, 150) }} </p>
                            <a href="#" class="btn btn-outline-danger rounded-pill px-4 fw-bold mt-2">Baca Selengkapnya</a>
                        </div>
                    </div>
                @empty
                    <div class="empty-state">
                        <i class="bi bi-newspaper display-4 mb-3 d-block"></i>
                        <h5 class="fw-bold">Belum Ada Berita</h5>
                        <p>Tim redaksi sedang memanaskan mesin. Cek lagi nanti!</p>
                    </div>
                @endforelse

            </div>

            <div class="col-lg-4">
                <div class="sidebar-widget">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="fw-bold m-0">🏁 Next Races</h5>
                        <a href="#" class="text-danger text-decoration-none small fw-bold">Lihat Semua</a>
                    </div>

                    @forelse($races as $race)
                        <div class="race-item d-flex align-items-center">
                            <div class="date-box me-3">
                                <div class="date-day">{{ \Carbon\Carbon::parse($race->race_date)->format('d') }}</div>
                                <div class="date-month">{{ \Carbon\Carbon::parse($race->race_date)->format('M') }}</div>
                            </div>

                            <div class="grow">
                                <h6 class="fw-bold mb-0 text-truncate">{{ $race->name }}</h6>
                                <small class="text-muted d-block mb-1">{{ $race->circuit_name }}</small>
                            </div>

                            <a href="{{ route('booking.show', $race->id) }}" class="btn btn-sm btn-danger rounded-circle">
                                <i class="bi bi-chevron-right"></i>
                            </a>
                        </div>
                    @empty
                        <div class="text-center py-4 text-muted">
                            <i class="bi bi-flag-fill fs-1 mb-2 d-block text-secondary"></i>
                            <p class="small m-0">Musim balap telah berakhir.</p>
                            <p class="small fw-bold">Tidak ada jadwal dekat.</p>
                        </div>
                    @endforelse

                    @if($races->count() > 0)
                    <div class="mt-4 pt-3 border-top text-center">
                        <p class="small text-muted mb-2">Jangan sampai kehabisan tiket!</p>
                        <button class="btn btn-dark w-100 fw-bold py-2">Cek Kalender Lengkap</button>
                    </div>
                    @endif
                </div>

                <div class="card border-0 shadow-sm mt-4 bg-danger text-white text-center p-4" style="border-radius: 12px;">
                    <h5 class="fw-bold">Join Fan Club</h5>
                    <p class="small text-white-50 mb-3">Dapatkan diskon eksklusif dan info tiket presale.</p>
                    <button class="btn btn-light text-danger fw-bold w-100 rounded-pill">Daftar Gratis</button>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
