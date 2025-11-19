<!DOCTYPE html>
<html lang="id">
<head>
    <title>Tambah Jadwal - Admin F1</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow-sm border-0" style="max-width: 600px; margin: 0 auto;">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold">🏁 Tambah Jadwal Balapan</h5>
            </div>
            <div class="card-body p-4">

                <form action="{{ route('admin.races.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Grand Prix</label>
                        <input type="text" name="name" class="form-control" placeholder="Contoh: Bahrain Grand Prix" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Sirkuit</label>
                        <input type="text" name="circuit_name" class="form-control" placeholder="Contoh: Bahrain International Circuit" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Tanggal Balapan</label>
                            <input type="date" name="race_date" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Harga Dasar Tiket (IDR)</label>
                            <input type="number" name="base_price" class="form-control" placeholder="1500000" required>
                            <small class="text-muted">Harga termurah (General Admission)</small>
                        </div>
                    </div>

                    <div class="d-grid gap-2 mt-4">
                        <button type="submit" class="btn btn-dark fw-bold">Simpan Jadwal</button>
                        <a href="{{ route('admin.lihatjadwal') }}" class="btn btn-outline-secondary">Batal</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</body>
</html>
