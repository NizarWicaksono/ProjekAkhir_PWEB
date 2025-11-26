<!DOCTYPE html>
<html lang="id">
<head>
    <title>@yield('title', 'Admin Panel - F1 Hub')</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        /* === GLOBAL STYLE (Sama seperti User Theme) === */
        body {
            font-family: 'Inter', sans-serif;
            /* Menggunakan Gradient Light Modern agar bersih & konsisten */
            background: linear-gradient(135deg, #e3e9f2 0%, #d4dde9 100%);
            background-attachment: fixed;
            color: #212529;
        }

        /* === NAVBAR ADMIN (Warna Asli, Style Modern) === */
        .navbar-admin {
            background-color: #111; /* TETAP HITAM (Sesuai Permintaan) */
            padding: 15px 0;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1); /* Tambahan shadow halus agar tidak 'mati' */
        }

        .navbar-brand {
            font-weight: 900;
            letter-spacing: -1px;
            font-size: 1.5rem;
            color: #e10600 !important; /* Aksen Merah pada Logo */
            text-transform: uppercase;
            font-style: italic;
        }

        /* Link Menu */
        .nav-link {
            color: rgba(255,255,255,0.7) !important; /* Warna teks agak redup */
            font-weight: 600;
            font-size: 0.9rem;
            margin-right: 15px;
            transition: all 0.2s ease-in-out;
        }

        /* Efek Hover Modern (Melayang) */
        .nav-link:hover, .nav-link.active {
            color: #fff !important; /* Putih terang saat aktif */
            transform: translateY(-2px); /* Efek naik sedikit saat di-hover */
            text-shadow: 0 4px 8px rgba(0,0,0,0.3);
        }

        /* Badge User di Navbar */
        .admin-badge {
            background: rgba(255,255,255,0.1);
            padding: 6px 15px;
            border-radius: 30px;
            color: white;
            font-weight: 600;
            font-size: 0.85rem;
            display: flex;
            align-items: center;
            border: 1px solid rgba(255,255,255,0.1);
        }
    </style>

    @stack('styles')
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark navbar-admin mb-5 sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('admin.dashboard') }}">
                <i class="bi bi-speedometer2 me-2 text-white"></i>ADMIN PANEL
            </a>

            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                           href="{{ route('admin.dashboard') }}">
                           <i class="bi bi-grid-fill me-1"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.lihatjadwal') ? 'active' : '' }}"
                           href="{{ route('admin.lihatjadwal') }}">
                           <i class="bi bi-calendar-week-fill me-1"></i> Jadwal
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.articles*') ? 'active' : '' }}"
                           href="{{ route('admin.articles.index') }}">
                           <i class="bi bi-newspaper me-1"></i> Berita
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.pendapatan') ? 'active' : '' }}"
                           href="{{ route('admin.pendapatan') }}">
                           <i class="bi bi-cash-coin me-1"></i> Keuangan
                        </a>
                    </li>
                </ul>

                <div class="d-flex align-items-center gap-3">
                    <div class="admin-badge">
                        <i class="bi bi-person-circle me-2"></i>
                        <span>{{ Auth::user()->name }}</span>
                    </div>

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-danger fw-bold rounded-pill px-4 shadow-sm">
                            Logout <i class="bi bi-box-arrow-right ms-1"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="container pb-5">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // --- Konfigurasi SweetAlert Modern ---

        // Notifikasi Sukses (Popup Tengah)
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 2000,
                background: '#fff',
                iconColor: '#198754',
                customClass: {
                    popup: 'rounded-4 shadow-lg',
                    title: 'fw-bold text-dark'
                }
            });
        @endif

        // Notifikasi Error
        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: '{{ session('error') }}',
                confirmButtonColor: '#333',
                customClass: {
                    popup: 'rounded-4 shadow-lg'
                }
            });
        @endif

        // Fungsi Global Konfirmasi Hapus (Style Modern)
        function confirmDelete(event) {
            event.preventDefault();
            const form = event.target;

            Swal.fire({
                title: 'Hapus Data?',
                text: "Data yang dihapus tidak bisa dikembalikan.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33', // Merah untuk hapus
                cancelButtonColor: '#333',  // Hitam untuk batal
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                background: '#fff',
                customClass: {
                    popup: 'rounded-4 border-0 shadow-lg',
                    title: 'fw-bold text-dark'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        }
    </script>

    @stack('scripts')
</body>
</html>
