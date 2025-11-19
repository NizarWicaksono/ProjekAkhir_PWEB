<!DOCTYPE html>
<html lang="id">
<head>
    <title>Tambah Jadwal - Admin F1</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f3f4f6; }
        .card { border-radius: 12px; }
    </style>
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-admin shadow-sm mb-5" style="background-color: #111;">
        <div class="container">
            <a class="navbar-brand" href="{{ route('admin.dashboard') }}" style="color: #e10600; font-weight: 900;">ADMIN PANEL</a>
        </div>
    </nav>

    <div class="container pb-5">

        <div class="d-flex justify-content-between align-items-center mb-2">
            <h3 class="fw-bold m-0">🏁 Tambah Jadwal Balapan</h3>
        </div>

        <div class="d-flex justify-content-start mb-4">
             <a class="btn btn-sm btn-outline-dark fw-bold" href="{{ route('admin.dashboard') }}">
                 <i class="bi bi-arrow-left me-1"></i> Kembali ke Dashboard
            </a>
        </div>

        <div class="card shadow-sm border-0" style="max-width: 600px; margin: 0 auto;">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold">Input Detail Balapan</h5>
            </div>
            <div class="card-body p-4">

                <form action="{{ route('admin.races.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-bold">1. Pilih Grand Prix</label>
                        <select name="circuit_id" id="gp_selector" class="form-select" required>
                            <option value="" selected disabled>-- Pilih Nama GP --</option>
                            @foreach($circuits as $circuit)
                                <option
                                    value="{{ $circuit->id }}"
                                    data-circuit="{{ $circuit->circuit_name }}"
                                    data-country="{{ $circuit->country }}">
                                    {{ $circuit->gp_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">2. Lokasi Sirkuit </label>
                        <input type="text" id="circuit_display" class="form-control bg-light" readonly>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Tanggal Balapan</label>
                            <input type="date" name="race_date" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Harga Tiket (IDR)</label>
                            <input type="number" name="base_price" class="form-control" required>
                        </div>
                    </div>

                    <div class="d-grid gap-2 mt-4">
                        <button type="submit" class="btn btn-dark fw-bold">Simpan Jadwal</button>
                        <a href="{{ route('admin.lihatjadwal') }}" class="btn btn-outline-secondary">Batal / Lihat Daftar</a>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        const gpSelector = document.getElementById('gp_selector');
        const circuitDisplay = document.getElementById('circuit_display');

        gpSelector.addEventListener('change', function() {
            // Ambil option yang sedang dipilih
            const selectedOption = this.options[this.selectedIndex];

            // Ambil data dari atribut 'data-circuit' dan 'data-country'
            const circuitName = selectedOption.getAttribute('data-circuit');
            const countryName = selectedOption.getAttribute('data-country');

            // Isi kolom input otomatis
            circuitDisplay.value = `${circuitName}, ${countryName}`;
        });
    </script>
</body>
</html>
