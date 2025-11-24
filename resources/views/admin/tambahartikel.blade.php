<!DOCTYPE html>
<html lang="id">
<head>
    <title>Tulis Artikel - Admin F1</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f3f4f6; }
        .navbar-admin { background-color: #111; padding: 15px 0; }
        .navbar-brand { font-weight: 900; letter-spacing: -1px; font-size: 24px; color: #e10600 !important; }
    </style>
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-admin shadow-sm mb-5">
        <div class="container">
            <a class="navbar-brand" href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2 me-2"></i>ADMIN PANEL</a>
        </div>
    </nav>

    <div class="container pb-5">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <div class="mb-4">
                    <a href="{{ route('admin.articles.index') }}" class="text-decoration-none text-muted fw-bold">
                        <i class="bi bi-arrow-left me-2"></i>Kembali ke Daftar Artikel
                    </a>
                </div>

                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="m-0 fw-bold">✏️ Tulis Artikel Baru</h5>
                    </div>
                    <div class="card-body p-4">

                        <form action="{{ route('admin.articles.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label fw-bold">Judul Artikel</label>
                                <input type="text" name="title" class="form-control" placeholder="Contoh: Max Verstappen Juara Dunia..." required>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Tanggal Tayang</label>
                                    <input type="date" name="published_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Gambar Cover (Opsional)</label>
                                    <input type="file" name="image" class="form-control" accept="image/*">
                                    <div class="form-text">Biarkan kosong jika tidak ada gambar.</div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold">Isi Berita</label>
                                <textarea name="content" class="form-control" rows="8" placeholder="Tulis isi berita di sini..." required></textarea>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-danger fw-bold py-2">
                                    Terbitkan Artikel
                                </button>
                            </div>

                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

</body>
</html>
