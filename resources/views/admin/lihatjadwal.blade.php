@extends('layouts.admin')

@section('title', 'Kelola Jadwal - Admin F1')

@push('styles')
    <style>
        .race-card {
            border: none;
            border-radius: 12px;
            transition: transform 0.2s, box-shadow 0.2s;
            background: white;
            height: 100%;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }
        .race-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        .race-title {
            font-weight: 800;
            font-size: 1.1rem;
            margin-bottom: 0.5rem;
        }
        .race-info {
            font-size: 0.9rem;
            color: #6c757d;
            margin-bottom: 0.25rem;
        }
        .race-price {
            font-weight: 700;
            color: #198754;
            font-size: 1.2rem;
            margin-top: 0.5rem;
        }
        .card-top-line {
            height: 5px;
            background: #e10600;
        }
        .race-card.past-race .card-top-line { background: #6c757d; }

        .nav-tabs {
            border-bottom: none;
            margin-bottom: 30px;
            gap: 15px;
        }
        /* Tampilan tidak aktif */
        .nav-tabs .nav-link {
            color: rgba(255, 255, 255, 0.8);
            background-color: #212529;
            font-weight: 700;
            border: none;
            padding: 12px 30px;
            border-radius: 50px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }
        .nav-tabs .nav-link:hover {
            background-color: #000;
            color: #e10600;
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(0,0,0,0.2);
        }
        /* Tampilan aktif */
        .nav-tabs .nav-link.active {
            background-color: #e10600 !important;
            color: white !important;
            box-shadow: 0 5px 15px rgba(225, 6, 0, 0.4);
        }
        .nav-tabs .nav-link .badge {
            background-color: rgba(255,255,255,0.2) !important;
            color: white;
            margin-left: 8px;
        }
        .modal-content {
            border-radius: 16px;
            border: none;
        }
        .modal-header {
            background-color: #212529;
            color: white;
            border-top-left-radius: 16px;
            border-top-right-radius: 16px;
        }
        .btn-close-white { filter: invert(1) grayscale(100%) brightness(200%); }
    </style>
@endpush

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold m-0">🏁 Jadwal Balapan</h3>
        <button type="button" class="btn btn-danger fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#addRaceModal">
            <i class="bi bi-plus-lg me-1"></i> Tambah Jadwal Baru
        </button>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm mb-4">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
        </div>
    @endif

    <ul class="nav nav-tabs" id="scheduleTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="active-tab" data-bs-toggle="tab" data-bs-target="#active" type="button" role="tab">
                Akan Datang <span class="badge bg-danger ms-1 rounded-pill">{{ $activeRaces->total() }}</span>
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="past-tab" data-bs-toggle="tab" data-bs-target="#past" type="button" role="tab">
                Sudah Selesai <span class="badge bg-secondary ms-1 rounded-pill">{{ $pastRaces->total() }}</span>
            </button>
        </li>
    </ul>

    <div class="tab-content" id="scheduleTabContent">
        {{-- Jadwal Aktif --}}
        <div class="tab-pane fade show active" id="active" role="tabpanel">
            <div class="row g-4">
                @forelse($activeRaces as $race)
                <div class="col-md-4 col-lg-3">
                    <div class="race-card shadow-sm">
                        <div class="card-top-line"></div> <div class="card-body p-4 d-flex flex-column h-100">
                            <span class="badge bg-light text-danger border border-danger w-auto align-self-start mb-2">
                                <i class="bi bi-clock me-1"></i> Segera
                            </span>

                            <h5 class="race-title text-dark">{{ $race->circuit->gp_name }}</h5>
                            <p class="race-info"><i class="bi bi-geo-alt-fill text-danger me-2"></i>{{ $race->circuit->circuit_name }}</p>
                            <p class="race-info ps-4 text-muted small">{{ $race->circuit->country }}</p>
                            <p class="race-info mt-2"><i class="bi bi-calendar-event-fill text-secondary me-2"></i>{{ $race->race_date->format('d M Y, H:i') }} WIB</p>

                            <hr class="mt-auto mb-3 text-muted opacity-25">
                            <div class="d-flex justify-content-between align-items-end">
                                <div>
                                    <small class="text-muted d-block" style="font-size: 0.8rem;">Harga</small>
                                    <div class="race-price">Rp {{ number_format($race->base_price, 0, ',', '.') }}</div>
                                </div>

                                <div class="d-flex gap-2">
                                    {{-- Tomblo Edit --}}
                                    <button class="btn btn-sm btn-warning text-white border hover-shadow btn-edit"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editRaceModal"
                                        data-id="{{ $race->id }}"
                                        data-circuit="{{ $race->circuit_id }}"
                                        data-date="{{ $race->race_date->format('Y-m-d\TH:i') }}"
                                        data-price="{{ $race->base_price }}">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>

                                    <form action="{{ route('admin.races.destroy', $race->id) }}" method="POST" onsubmit="return confirm('Yakin hapus jadwal ini?');">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-light text-danger border hover-shadow">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 py-5 text-center">
                    <img src="https://cdn-icons-png.flaticon.com/512/7486/7486744.png" width="100" class="mb-3 opacity-50" alt="Empty">
                    <h5 class="text-muted fw-bold">Tidak ada jadwal aktif.</h5>
                    <p class="text-secondary small">Tambahkan jadwal baru untuk memulai penjualan tiket.</p>
                </div>
                @endforelse
            </div>
            <div class="d-flex justify-content-center mt-4">
                {{ $activeRaces->appends(request()->query())->links() }}
            </div>
        </div>
        {{-- Jadwal Tidak Aktif --}}
        <div class="tab-pane fade" id="past" role="tabpanel">
            <div class="row g-4">
                @forelse($pastRaces as $race)
                <div class="col-md-4 col-lg-3">
                    <div class="race-card past-race shadow-sm bg-light" style="opacity: 0.8;">
                        <div class="card-top-line"></div> <div class="card-body p-4 d-flex flex-column h-100">
                            <span class="badge bg-secondary w-auto align-self-start mb-2">
                                <i class="bi bi-check-circle me-1"></i> Selesai
                            </span>
                            <h5 class="race-title text-muted">{{ $race->circuit->gp_name }}</h5>
                            <p class="race-info text-muted"><i class="bi bi-geo-alt-fill me-2"></i>{{ $race->circuit->circuit_name }}</p>
                            <p class="race-info mt-2 text-decoration-line-through">
                                <i class="bi bi-calendar-check me-2"></i>{{ $race->race_date->format('d M Y, H:i') }} WIB
                            </p>
                            <hr class="mt-auto mb-3 text-muted opacity-25">
                            <div class="d-flex justify-content-between align-items-center">
                                <a href="{{ route('admin.pendapatan.detail', $race->id) }}" class="btn btn-sm btn-outline-dark fw-bold w-100">
                                    <i class="bi bi-wallet2 me-1"></i> Cek Laporan
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 py-5 text-center">
                    <h5 class="text-muted fw-bold">Belum ada history balapan.</h5>
                </div>
                @endforelse
            </div>
            <div class="d-flex justify-content-center mt-4">
                {{ $pastRaces->appends(request()->query())->links() }}
            </div>
        </div>

    </div>
    {{-- Modal Tambah Jadwal --}}
    <div class="modal fade" id="addRaceModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Tambah Jadwal Balapan</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form action="{{ route('admin.races.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-bold small text-muted text-uppercase">Pilih Grand Prix</label>
                            <select name="circuit_id" id="gp_selector" class="form-select" required>
                                <option value="" selected disabled>--Pilih GP--</option>
                                @foreach($circuits as $circuit)
                                    <option value="{{ $circuit->id }}" data-circuit="{{ $circuit->circuit_name }}" data-country="{{ $circuit->country }}">
                                        {{ $circuit->gp_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold small text-muted text-uppercase">Lokasi Sirkuit</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-geo-alt"></i></span>
                                <input type="text" id="circuit_display" class="form-control bg-light text-muted" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 mb-3">
                                <label class="form-label fw-bold small text-muted text-uppercase">Tanggal & Jam</label>
                                <input type="datetime-local" name="race_date" class="form-control" required>
                            </div>
                            <div class="col-6 mb-3">
                                <label class="form-label fw-bold small text-muted text-uppercase">Harga (IDR)</label>
                                <input type="number" name="base_price" class="form-control" required>
                            </div>
                        </div>
                        <div class="d-grid mt-3">
                            <button type="submit" class="btn btn-danger fw-bold">Simpan Jadwal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- Modal Edit Jadwal --}}
    <div class="modal fade" id="editRaceModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title fw-bold">✏️ Edit Jadwal Balapan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    {{-- Form action akan di-set lewat JS --}}
                    <form id="editForm" action="" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label fw-bold small text-muted text-uppercase">Pilih Grand Prix</label>
                            <select name="circuit_id" id="gp_selector_edit" class="form-select" required>
                                <option value="" disabled>--Pilih GP--</option>
                                @foreach($circuits as $circuit)
                                    <option value="{{ $circuit->id }}" data-circuit="{{ $circuit->circuit_name }}" data-country="{{ $circuit->country }}">
                                        {{ $circuit->gp_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold small text-muted text-uppercase">Lokasi Sirkuit</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-geo-alt"></i></span>
                                <input type="text" id="circuit_display_edit" class="form-control bg-light text-muted" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 mb-3">
                                <label class="form-label fw-bold small text-muted text-uppercase">Tanggal & Jam</label>
                                <input type="datetime-local" name="race_date" id="race_date_edit" class="form-control" required>
                            </div>
                            <div class="col-6 mb-3">
                                <label class="form-label fw-bold small text-muted text-uppercase">Harga (IDR)</label>
                                <input type="number" name="base_price" id="base_price_edit" class="form-control" required>
                            </div>
                        </div>
                        <div class="d-grid mt-3">
                            <button type="submit" class="btn btn-warning fw-bold">Update Jadwal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Script Modal Tambah Jadwal
        const gpSelector = document.getElementById('gp_selector');
        const circuitDisplay = document.getElementById('circuit_display');

        if(gpSelector) {
            gpSelector.addEventListener('change', function() {
                updateDisplay(this, circuitDisplay);
            });
        }
        // Script Modal Edit Jadwal
        const editButtons = document.querySelectorAll('.btn-edit');
        const editForm = document.getElementById('editForm');
        const gpSelectorEdit = document.getElementById('gp_selector_edit');
        const circuitDisplayEdit = document.getElementById('circuit_display_edit');
        const raceDateEdit = document.getElementById('race_date_edit');
        const basePriceEdit = document.getElementById('base_price_edit');

        // Base URL untuk update
        const baseUrl = "{{ url('/admin/races') }}";

        // Logic tombol edit diklik
        editButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const circuitId = this.getAttribute('data-circuit');
                const date = this.getAttribute('data-date');
                const price = this.getAttribute('data-price');
                // 1. Update Action URL Form
                editForm.action = `${baseUrl}/${id}`;
                // 2. Isi Value Input
                gpSelectorEdit.value = circuitId;
                raceDateEdit.value = date;
                basePriceEdit.value = price;
                // Update Display Sirkuit
                updateDisplay(gpSelectorEdit, circuitDisplayEdit);
            });
        });

        // Event Listener Dropdown di Modal Edit
        if(gpSelectorEdit) {
            gpSelectorEdit.addEventListener('change', function() {
                updateDisplay(this, circuitDisplayEdit);
            });
        }

        // Fungsi Helper agar tidak menulis ulang logic display
        function updateDisplay(selector, displayTarget) {
            const selectedOption = selector.options[selector.selectedIndex];
            const circuitName = selectedOption.getAttribute('data-circuit');
            const countryName = selectedOption.getAttribute('data-country');
            displayTarget.value = `${circuitName}, ${countryName}`;
        }
    </script>
@endpush
