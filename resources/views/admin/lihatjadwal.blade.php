<!DOCTYPE html>
<html lang="id">
<head>
    <title>Kelola Jadwal - Admin F1</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body class="bg-light">

    <nav class="navbar navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('admin.dashboard') }}">🔙 Kembali ke Dashboard</a>
        </div>
    </nav>

    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold">📅 Daftar Jadwal Balapan</h3>
            <a href="{{ route('admin.tambahjadwal') }}" class="btn btn-danger fw-bold">
                <i class="bi bi-plus-lg me-1"></i> Tambah Baru
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success border-0 shadow-sm">{{ session('success') }}</div>
        @endif

        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Tanggal</th>
                            <th>Nama Event</th>
                            <th>Sirkuit</th>
                            <th>Harga Dasar</th>
                            <th class="text-end pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($races as $race)
                        <tr>
                            <td class="ps-4 fw-bold">{{ $race->race_date->format('d M Y') }}</td>
                            <td>{{ $race->name }}</td>
                            <td class="text-muted">{{ $race->circuit_name }}</td>
                            <td class="text-success fw-bold">Rp {{ number_format($race->base_price, 0, ',', '.') }}</td>
                            <td class="text-end pe-4">
                                <form action="{{ route('admin.races.destroy', $race->id) }}" method="POST" onsubmit="return confirm('Yakin hapus jadwal ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                Belum ada jadwal balapan. Yuk tambah baru!
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
