@extends('layouts.admin')

@section('title', 'Detail Artikel - Admin F1')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-10">

            <div class="mb-4">
                <a href="{{ route('admin.articles.index') }}" class="btn btn-outline-dark fw-bold">
                    <i class="bi bi-arrow-left me-2"></i>Kembali ke Daftar
                </a>
            </div>

            @if(session('success'))
                <div class="alert alert-success border-0 shadow-sm mb-4">
                    <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                </div>
            @endif

            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">

                <div id="read-section">
                    <img src="{{ $article->image ? $article->image : 'https://via.placeholder.com/400x250?text=Cover+Artikel' }}"
                         class="w-100 object-fit-cover" style="height: 400px;" alt="Cover">

                    <div class="card-body p-5">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="text-muted small">
                                <span class="me-3"><i class="bi bi-calendar3 me-1"></i> {{ \Carbon\Carbon::parse($article->published_date)->format('d F Y, H:i') }} WIB</span>
                                <span><i class="bi bi-person me-1"></i> Admin</span>
                            </div>
                            <button onclick="toggleEditMode()" class="btn btn-warning btn-sm fw-bold rounded-pill px-4">
                                <i class="bi bi-pencil-square me-1"></i> Edit
                            </button>
                        </div>

                        <h1 class="fw-bold mb-4">{{ $article->title }}</h1>

                        <div class="article-content lh-lg text-secondary" style="white-space: pre-line;">
                            {!! $article->content !!}
                        </div>
                    </div>
                </div>

                <div id="edit-section" class="d-none">
                    <div class="card-header bg-warning text-dark py-3 px-5">
                        <h5 class="m-0 fw-bold"><i class="bi bi-pencil-fill me-2"></i>Mode Edit Artikel</h5>
                    </div>

                    <div class="card-body p-5">
                        <form action="{{ route('admin.articles.update', $article->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="mb-4">
                                <label class="form-label fw-bold">Judul Artikel</label>
                                <input type="text" name="title" class="form-control form-control-lg fw-bold" value="{{ $article->title }}" required>
                            </div>

                            <div class="mb-4 p-3 bg-light rounded border">
                                <label class="form-label fw-bold small text-uppercase text-muted">Update Cover</label>
                                <div class="d-flex align-items-center gap-3">
                                    @if($article->image)
                                        <img src="{{ $article->image }}"
                                             class="rounded object-fit-cover border"
                                             style="width: 120px; height: 80px;" alt="Preview">
                                    @endif
                                    <input type="file" name="image" class="form-control" accept="image/*">
                                </div>
                                <div class="form-text mt-2">Biarkan jika tidak ingin mengubah gambar.</div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold">Isi Berita</label>
                                <textarea name="content" class="form-control" rows="15" required>{{ $article->content }}</textarea>
                            </div>

                            <div class="d-flex justify-content-end gap-2">
                                <button type="button" onclick="toggleEditMode()" class="btn btn-light border fw-bold px-4">Batal</button>
                                <button type="submit" class="btn btn-dark fw-bold px-4">Simpan Perubahan</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>

        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function toggleEditMode() {
            const readSection = document.getElementById('read-section');
            const editSection = document.getElementById('edit-section');

            if (readSection.classList.contains('d-none')) {
                readSection.classList.remove('d-none');
                editSection.classList.add('d-none');
            } else {
                readSection.classList.add('d-none');
                editSection.classList.remove('d-none');
            }
        }
    </script>
@endpush
