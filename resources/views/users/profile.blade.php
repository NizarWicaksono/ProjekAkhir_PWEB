<!DOCTYPE html>
<html lang="id">
<head>
    <title>Profil Saya - F1 Ticket</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f3f4f6; }
        .navbar-f1 { background-color: #e10600; }

        /* PERBAIKAN DI SINI: Tambahkan .navbar-f1 di depannya */
        /* Agar warna putih hanya berlaku di menu atas, bukan di sidebar */
        .navbar-f1 .nav-link {
            color: rgba(255,255,255,0.9) !important;
            font-weight: 600;
            margin-right: 10px;
        }
        .navbar-f1 .nav-link:hover, .navbar-f1 .nav-link.active {
            color: white !important;
            opacity: 1;
        }

        /* Sidebar Style - Pastikan warnanya gelap agar terlihat di background putih */
        .user-sidebar .nav-link {
            color: #495057 !important; /* Pakai !important untuk memastikan warna abu-abu */
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 5px;
            display: flex;
            align-items: center;
            transition: all 0.2s;
            font-weight: 600;
        }
        .user-sidebar .nav-link:hover {
            background-color: #e9ecef;
            color: #e10600 !important;
        }
        .user-sidebar .nav-link.active {
            background-color: #ffe5e5;
            color: #e10600 !important;
            font-weight: 800;
        }
        .user-sidebar .nav-link i {
            font-size: 1.2rem;
            margin-right: 15px;
            width: 24px;
            text-align: center;
        }

        /* Form Style */
        .form-control-plaintext { font-weight: 600; font-size: 1.1rem; color: #212529; }
        .readonly-field { background-color: #f8f9fa; padding: 10px 15px; border-radius: 8px; border: 1px solid #dee2e6; }
    </style>
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark navbar-f1 shadow-sm mb-5 sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold fst-italic" href="{{ route('users.dashboard') }}">
                <i class="bi bi-flag-fill me-2"></i>F1 TICKET
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ route('users.dashboard') }}">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('tickets.index') }}">Beli Tiket</a></li>
                </ul>
                <div class="d-flex align-items-center text-white">
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
                </div>
            </div>
        </div>
    </nav>

    <div class="container pb-5">
        <div class="row">

            <div class="col-lg-3 mb-4">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-3 user-sidebar">
                        <div class="d-flex align-items-center p-3 mb-3 border-bottom">
                            <div class="bg-danger text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px; font-size: 1.5rem;">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <div>
                                <small class="text-muted d-block">Halo,</small>
                                <h6 class="fw-bold m-0 text-truncate" style="max-width: 150px;">{{ Auth::user()->name }}</h6>
                            </div>
                        </div>
                        <nav class="nav flex-column">
                            <a class="nav-link active" href="{{ route('users.profile') }}">
                                <i class="bi bi-person-vcard"></i> Profil Akun
                            </a>
                            <a class="nav-link" href="{{ route('users.history') }}">
                                <i class="bi bi-clock-history"></i> Riwayat Pembelian
                            </a>
                            <form action="{{ route('logout') }}" method="POST" class="mt-2 pt-2 border-top">
                                @csrf
                                <button type="submit" class="nav-link w-100 text-start text-danger">
                                    <i class="bi bi-box-arrow-left"></i> Logout
                                </button>
                            </form>
                        </nav>
                    </div>
                </div>
            </div>

            <div class="col-lg-9">
                @if(session('success'))
                    <div class="alert alert-success border-0 shadow-sm rounded-3 mb-4">
                        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                    </div>
                @endif

                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-header bg-white border-bottom-0 py-4 px-4">
                        <h4 class="fw-bold m-0">Informasi Akun</h4>
                    </div>
                    <div class="card-body p-4">

                        <div id="view-mode">
                            <div class="mb-4">
                                <label class="text-muted small fw-bold text-uppercase mb-2">Nama Lengkap</label>
                                <div class="readonly-field d-flex align-items-center">
                                    <i class="bi bi-person text-secondary me-3 fs-5"></i>
                                    <span class="fw-bold text-dark">{{ Auth::user()->name }}</span>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="text-muted small fw-bold text-uppercase mb-2">Alamat Email</label>
                                <div class="readonly-field d-flex align-items-center">
                                    <i class="bi bi-envelope text-secondary me-3 fs-5"></i>
                                    <span class="fw-bold text-dark">{{ Auth::user()->email }}</span>
                                </div>
                            </div>

                            <div class="mb-5">
                                <label class="text-muted small fw-bold text-uppercase mb-2">Password</label>
                                <div class="readonly-field d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-key text-secondary me-3 fs-5"></i>
                                        <input type="password" value="DummyPassword123" class="border-0 bg-transparent fw-bold text-dark" id="dummy-password" readonly style="outline: none; width: 200px;">
                                    </div>
                                    <button type="button" class="btn btn-sm btn-link text-decoration-none text-secondary" onclick="toggleDummyPassword()">
                                        <i class="bi bi-eye-slash" id="dummy-eye-icon"></i>
                                    </button>
                                </div>
                                <small class="text-muted fst-italic mt-1 d-block">*Password terenkripsi demi keamanan.</small>
                            </div>

                            <div class="d-flex justify-content-end">
                                <button type="button" class="btn btn-danger px-4 py-2 fw-bold rounded-pill shadow-sm" onclick="enableEditMode()">
                                    <i class="bi bi-pencil-square me-2"></i>Update Profil
                                </button>
                            </div>
                        </div>

                        <div id="edit-mode" style="display: none;">
                            <form action="{{ route('users.profile.update') }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="alert alert-info border-0 d-flex align-items-center mb-4">
                                    <i class="bi bi-info-circle-fill me-2"></i>
                                    <small>Silakan ubah data yang ingin diperbarui.</small>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label text-muted small fw-bold">Nama Lengkap</label>
                                        <input type="text" name="name" class="form-control form-control-lg bg-light border-0" value="{{ old('name', Auth::user()->name) }}" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label text-muted small fw-bold">Email Address</label>
                                        <input type="email" name="email" class="form-control form-control-lg bg-light border-0" value="{{ old('email', Auth::user()->email) }}" required>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <h6 class="fw-bold text-danger mb-3 border-bottom pb-2">
                                        <i class="bi bi-shield-lock me-2"></i>Ganti Password
                                    </h6>
                                    <div class="p-3 bg-light rounded-3 border border-dashed">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label text-muted small fw-bold">Password Baru</label>
                                                <div class="input-group">
                                                    <input type="password" name="password" id="new-password" class="form-control border-0" placeholder="Biarkan kosong jika tetap">
                                                    <span class="input-group-text bg-white border-0 cursor-pointer" onclick="togglePassword('new-password', 'eye-icon-1')">
                                                        <i class="bi bi-eye-slash" id="eye-icon-1"></i>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label text-muted small fw-bold">Konfirmasi Password</label>
                                                <div class="input-group">
                                                    <input type="password" name="password_confirmation" id="confirm-password" class="form-control border-0" placeholder="Ulangi password baru">
                                                    <span class="input-group-text bg-white border-0 cursor-pointer" onclick="togglePassword('confirm-password', 'eye-icon-2')">
                                                        <i class="bi bi-eye-slash" id="eye-icon-2"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <small class="text-muted">*Kosongkan form password jika tidak ingin mengubahnya.</small>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end gap-2">
                                    <button type="button" class="btn btn-outline-secondary px-4 py-2 fw-bold rounded-pill" onclick="cancelEditMode()">
                                        Batal
                                    </button>
                                    <button type="submit" class="btn btn-success px-5 py-2 fw-bold rounded-pill shadow-sm">
                                        <i class="bi bi-check-lg me-2"></i>Simpan
                                    </button>
                                </div>
                            </form>
                        </div>
                        </div>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Logika Ganti Mode (Lihat <-> Edit)
        function enableEditMode() {
            document.getElementById('view-mode').style.display = 'none';
            document.getElementById('edit-mode').style.display = 'block';
            document.getElementById('edit-mode').style.opacity = 0;
            setTimeout(() => {
                document.getElementById('edit-mode').style.transition = 'opacity 0.3s';
                document.getElementById('edit-mode').style.opacity = 1;
            }, 10);
        }

        function cancelEditMode() {
            document.getElementById('edit-mode').style.display = 'none';
            document.getElementById('view-mode').style.display = 'block';
        }

        // Toggle Mata untuk Password Dummy
        function toggleDummyPassword() {
            const input = document.getElementById('dummy-password');
            const icon = document.getElementById('dummy-eye-icon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            } else {
                input.type = 'password';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            }
        }

        // Toggle Mata untuk Input Password (Form Edit)
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            } else {
                input.type = 'password';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            }
        }
    </script>
</body>
</html>
