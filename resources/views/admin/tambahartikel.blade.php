@extends('layouts.admin')

@section('title', 'Tulis Artikel - Admin F1')

@section('content')
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

                        <div class="mb-3">
                            <label class="form-label fw-bold">Gambar Cover (Opsional)</label>
                            <input type="file" name="image" class="form-control" accept="image/*">
                            <div class="form-text">Biarkan kosong jika tidak ada gambar.</div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Isi Berita</label>
                            <textarea name="content" class="form-control" rows="8" placeholder="Tulis isi berita di sini..." required></textarea>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-danger fw-bold py-2">
                                <i class="bi bi-send me-2"></i> Terbitkan Artikel Sekarang
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection
