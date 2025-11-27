<!DOCTYPE html>
<html lang="id">
<head>
    <title>Login - F1 Ticketing</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
        }
        .login-image {
            background-image: url('https://images.pexels.com/photos/17555047/pexels-photo-17555047.jpeg');
            background-size: cover;
            background-position: center;
            min-height: 100vh;
        }
        .login-section {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .form-container {
            width: 100%;
            max-width: 450px;
            padding: 40px;
        }
        .btn-f1 {
            background-color: #e10600;
            color: white;
            font-weight: 700;
            border: none;
            padding: 12px;
        }
        .btn-f1:hover {
            background-color: #b30500;
            color: white;
        }
        .form-control:focus {
            border-color: #e10600;
            box-shadow: 0 0 0 0.25rem rgba(225, 6, 0, 0.25);
        }
        .brand-title {
            color: #e10600;
            font-weight: 900;
            letter-spacing: -1px;
        }
        .input-group-text {
            cursor: pointer;
            background-color: white;
            border-left: none;
        }
        .input-with-icon {
            border-right: none;
        }
    </style>
</head>
<body>

<div class="container-fluid p-0">
    <div class="row g-0">
        <div class="col-md-6 col-lg-7 d-none d-md-block login-image"></div>

        <div class="col-md-6 col-lg-5 login-section bg-white">
            <div class="form-container">
                <div class="mb-4">
                    <a href="{{ route('users.dashboard') }}" class="text-decoration-none text-secondary fw-bold small">
                        <i class="bi bi-arrow-left me-1"></i> Kembali ke Dashboard
                    </a>
                </div>

                <div class="mb-5">
                    <h1 class="brand-title">F1 TICKETING.</h1>
                    <p class="text-muted">Masuk untuk memesan kursi terbaikmu.</p>
                </div>

                <form action="{{ route('login.process') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label class="form-label fw-bold text-uppercase small text-muted">Email Address</label>
                        <input type="email" name="email" class="form-control form-control-lg bg-light" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold text-uppercase small text-muted">Password</label>
                        <div class="input-group">
                            <input type="password" name="password" id="password" class="form-control form-control-lg bg-light input-with-icon" required>
                            <span class="input-group-text bg-light" onclick="togglePassword('password', 'eye-icon')">
                                <i class="bi bi-eye" id="eye-icon"></i>
                            </span>
                        </div>
                    </div>

                    <div class="d-grid gap-2 mb-4">
                        <button type="submit" class="btn btn-f1 btn-lg rounded-1">MASUK SEKARANG</button>
                    </div>

                    <div class="text-center">
                        <span class="text-muted">Belum punya akun?</span>
                        <a href="{{ route('register') }}" class="text-decoration-none fw-bold text-dark">Daftar disini</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Alert Error login gagal
    @if($errors->any())
        Swal.fire({
            icon: 'error',
            title: 'Login Gagal',
            html: '@foreach ($errors->all() as $error){{ $error }}<br>@endforeach',
            confirmButtonColor: '#e10600'
        });
    @endif

    // Alert Sukses
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: '{{ session('success') }}',
            confirmButtonColor: '#e10600'
        });
    @endif

    function togglePassword(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);
        if (input.type === "password") {
            input.type = "text";
            icon.classList.remove("bi-eye");
            icon.classList.add("bi-eye-slash");
        } else {
            input.type = "password";
            icon.classList.remove("bi-eye-slash");
            icon.classList.add("bi-eye");
        }
    }
</script>

</body>
</html>
