<!DOCTYPE html>
<html lang="id">
<head>
    <title>Register - F1 Ticketing</title>
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
        .register-image {
            background-image: url('https://images.unsplash.com/photo-1535138876289-7c73b9819490?q=80&w=2070&auto=format&fit=crop');
            background-size: cover;
            background-position: center;
            min-height: 100vh;
        }
        .register-section {
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

<div class="container-fluid">
    <div class="row g-0">
        <div class="col-md-6 col-lg-7 d-none d-md-block register-image"></div>

        <div class="col-md-6 col-lg-5 register-section bg-white">
            <div class="form-container">
                <div class="mb-4">
                    <h1 class="brand-title">JOIN THE RACE.</h1>
                    <p class="text-muted">Buat akun baru dalam hitungan detik.</p>
                </div>

                <form action="{{ route('register.process') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-bold text-uppercase small text-muted">Nama Lengkap</label>
                        <input type="text" name="name" class="form-control form-control-lg bg-light" placeholder="Max Verstappen" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-uppercase small text-muted">Email Address</label>
                        <input type="email" name="email" class="form-control form-control-lg bg-light" placeholder="nama@email.com" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-uppercase small text-muted">Password</label>
                        <div class="input-group">
                            <input type="password" name="password" id="reg_password" class="form-control form-control-lg bg-light input-with-icon" placeholder="Minimal 8 karakter" required>
                            <span class="input-group-text bg-light" onclick="togglePassword('reg_password', 'icon-pass')">
                                <i class="bi bi-eye" id="icon-pass"></i>
                            </span>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold text-uppercase small text-muted">Konfirmasi Password</label>
                        <div class="input-group">
                            <input type="password" name="password_confirmation" id="reg_confirm" class="form-control form-control-lg bg-light input-with-icon" placeholder="Ulangi password" required>
                            <span class="input-group-text bg-light" onclick="togglePassword('reg_confirm', 'icon-confirm')">
                                <i class="bi bi-eye" id="icon-confirm"></i>
                            </span>
                        </div>
                    </div>

                    <div class="d-grid gap-2 mb-4">
                        <button type="submit" class="btn btn-f1 btn-lg rounded-1">BUAT AKUN</button>
                    </div>

                    <div class="text-center">
                        <span class="text-muted">Sudah punya akun?</span>
                        <a href="{{ route('login') }}" class="text-decoration-none fw-bold text-dark">Login disini</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
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
