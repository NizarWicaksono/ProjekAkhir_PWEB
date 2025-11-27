@extends('layouts.user')

@section('title', 'Profil Saya - F1 Ticket')

@push('styles')
<style>
    .user-sidebar .nav-link {
        color: #495057 !important;
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

    .form-control-plaintext {
        font-weight: 600;
        font-size: 1.1rem;
        color: #212529;
    }
    .readonly-field {
        background-color: #f8f9fa;
        padding: 10px 15px;
        border-radius: 8px;
        border: 1px solid #dee2e6;
    }
</style>
@endpush

@section('content')
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
                    <a class="nav-link {{ request()->routeIs('users.profile') ? 'active' : '' }}" href="{{ route('users.profile') }}">
                        <i class="bi bi-person-vcard"></i> Profil Akun
                    </a>
                    <a class="nav-link {{ request()->routeIs('users.history') ? 'active' : '' }}" href="{{ route('users.history') }}">
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

                    <div class="mb-5">
                        <label class="text-muted small fw-bold text-uppercase mb-2">Alamat Email</label>
                        <div class="readonly-field d-flex align-items-center">
                            <i class="bi bi-envelope text-secondary me-3 fs-5"></i>
                            <span class="fw-bold text-dark">{{ Auth::user()->email }}</span>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-danger px-4 py-2 fw-bold rounded-pill shadow-sm" onclick="enableEditMode()">
                            <i class="bi bi-pencil-square me-2"></i>Update Akun
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
                            <button type="button" class="btn btn-outline-secondary px-4 py-2 fw-bold rounded-pill" onclick="cancelEditMode()">Batal</button>
                            <button type="submit" class="btn btn-success px-5 py-2 fw-bold rounded-pill shadow-sm"><i class="bi bi-check-lg me-2"></i>Simpan</button>
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
    // Fungsi Toggle Password
    function togglePassword(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);
        if (input.type === 'password') { input.type = 'text'; icon.classList.remove('bi-eye-slash'); icon.classList.add('bi-eye'); }
        else { input.type = 'password'; icon.classList.remove('bi-eye'); icon.classList.add('bi-eye-slash'); }
    }
</script>
@endpush
