@extends('layouts.user')

@section('title', 'Katalog Tiket - F1 Ticket')

@push('styles')
<style>
    /* === GAYA CARD BARU (Mengadopsi Style Dashboard) === */
    .ticket-card {
        border: none;
        border-radius: 16px; /* Sudut membulat modern */
        background: #fff;
        /* Shadow lembut seperti di dashboard */
        box-shadow: 0 4px 20px rgba(0,0,0,0.03);
        transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        height: 100%;
        overflow: hidden;
        position: relative;
        display: flex;
        flex-direction: column;
    }
    .ticket-card:hover {
        transform: translateY(-5px); /* Efek melayang */
        box-shadow: 0 15px 30px rgba(0,0,0,0.1);
    }

    /* Aksen visual F1 yang lebih halus */
    .card-accent-strip {
        height: 6px;
        background: linear-gradient(90deg, #e10600 0%, #ff4d4d 100%);
        width: 100%;
    }

    /* Badge Tanggal Modern */
    .date-badge {
        background-color: #f8f9fa;
        color: #212529;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        padding: 6px 12px;
        font-weight: 700;
        font-size: 0.85rem;
        display: inline-flex;
        align-items: center;
        margin-bottom: 15px;
    }
    .date-badge i { color: #e10600; margin-right: 6px; }

    /* Tipografi Judul */
    .race-title {
        font-weight: 800;
        font-size: 1.25rem;
        margin-bottom: 5px;
        color: #212529;
        line-height: 1.2;
    }

    .circuit-info {
        font-size: 0.9rem;
        color: #6c757d;
        font-weight: 500;
    }

    /* Harga & Footer Card */
    .card-footer-custom {
        margin-top: auto;
        padding-top: 20px;
        border-top: 1px dashed #eee;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .price-label { font-size: 0.7rem; text-transform: uppercase; color: #adb5bd; font-weight: 700; display: block; }
    .ticket-price { color: #198754; font-weight: 800; font-size: 1.2rem; }

    /* === SIDEBAR STYLE (Konsisten dengan Dashboard) === */
    .sidebar-card {
        background: #fff;
        border-radius: 16px;
        padding: 25px;
        border: none;
        box-shadow: 0 4px 25px rgba(0,0,0,0.05);
        position: sticky;
        top: 100px;
    }
    .icon-box {
        width: 50px; height: 50px;
        background-color: #fff5f5;
        color: #e10600;
        display: flex; align-items: center; justify-content: center;
        border-radius: 12px; font-size: 1.5rem;
        box-shadow: 0 4px 10px rgba(225, 6, 0, 0.1);
    }

    /* === MODAL STYLE === */
    .modal-content { border-radius: 20px; border: none; overflow: hidden; }
    .modal-header-custom {
        background: linear-gradient(135deg, #e10600 0%, #b30500 100%);
        color: white; padding: 20px 25px;
    }

    /* Input Qty Modern */
    .qty-input-group {
        background-color: #f8f9fa;
        border-radius: 12px; padding: 5px;
        border: 1px solid #dee2e6;
        display: flex; align-items: center; justify-content: space-between;
        width: 140px;
    }
    .btn-qty {
        width: 36px; height: 36px;
        border-radius: 8px !important;
        font-weight: 800; border: none;
        display: flex; align-items: center; justify-content: center;
        transition: 0.2s; cursor: pointer;
    }
    .btn-minus { background-color: #fff; color: #333; box-shadow: 0 2px 5px rgba(0,0,0,0.05); }
    .btn-plus { background-color: #212529; color: white; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
    .input-qty {
        border: none; background: transparent;
        text-align: center; font-size: 1.1rem; font-weight: 800;
        width: 40px; outline: none;
    }
</style>
@endpush

@section('content')
<div class="row g-4">

    <div class="col-lg-8">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="d-flex align-items-center">
                <div class="bg-danger rounded-pill me-3" style="width: 5px; height: 30px;"></div>
                <h4 class="fw-bold m-0 text-uppercase ls-1">Kalender Balapan</h4>
            </div>
            <span class="badge bg-white text-dark border shadow-sm px-3 py-2 rounded-pill">
                {{ $races->total() }} Event
            </span>
        </div>

        <div class="row g-4"> {{-- Tetap menggunakan Grid System --}}
            @forelse($races as $race)
            <div class="col-md-6">
                <div class="ticket-card">
                    <div class="card-accent-strip"></div>

                    <div class="card-body p-4 d-flex flex-column">
                        <div>
                            <div class="date-badge">
                                <i class="bi bi-calendar-event"></i>
                                {{ $race->race_date->format('d M Y, H:i') }} WIB
                            </div>
                        </div>

                        <h5 class="race-title">{{ $race->circuit->gp_name }}</h5>
                        <div class="circuit-info mb-3">
                            <i class="bi bi-geo-alt-fill me-1 text-danger opacity-75"></i>
                            {{ $race->circuit->circuit_name }}
                        </div>

                        <div class="card-footer-custom">
                            <div>
                                <span class="price-label">Mulai Dari</span>
                                <div class="ticket-price">Rp {{ number_format($race->base_price, 0, ',', '.') }}</div>
                            </div>

                            @auth
                                <button type="button" class="btn btn-dark rounded-pill px-4 py-2 fw-bold shadow-sm"
                                        data-bs-toggle="modal"
                                        data-bs-target="#bookModal-{{ $race->id }}">
                                    Beli
                                </button>
                            @else
                                <button type="button" class="btn btn-outline-danger rounded-pill px-4 py-2 fw-bold"
                                        data-bs-toggle="modal"
                                        data-bs-target="#guestModal">
                                    Beli
                                </button>
                            @endauth
                        </div>
                    </div>
                </div>

                {{-- MODAL BOOKING (Tetap Disertakan) --}}
                @auth
                <div class="modal fade" id="bookModal-{{ $race->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content shadow-lg">
                            <div class="modal-header-custom d-flex justify-content-between align-items-center">
                                <h5 class="fw-bold m-0 text-uppercase"><i class="bi bi-ticket-perforated me-2"></i>Booking Tiket</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>

                            <form action="{{ route('booking.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="race_id" value="{{ $race->id }}">

                                <div class="modal-body p-4">
                                    <div class="text-center mb-4">
                                        <h4 class="fw-bold mb-1">{{ $race->circuit->gp_name }}</h4>
                                        <p class="text-muted small mb-2">{{ $race->circuit->circuit_name }}</p>
                                        <span class="badge bg-dark px-3 py-2 rounded-pill">
                                            <i class="bi bi-clock me-1"></i> {{ $race->race_date->format('d F Y • H:i') }} WIB
                                        </span>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center mb-4 p-3 bg-light rounded-4 border">
                                        <div>
                                            <small class="text-muted d-block fw-bold text-uppercase" style="font-size: 0.7rem;">Total Harga</small>
                                            <h4 class="fw-bold m-0 text-danger" id="total-{{ $race->id }}">
                                                Rp {{ number_format($race->base_price, 0, ',', '.') }}
                                            </h4>
                                        </div>
                                        <div class="qty-input-group bg-white shadow-sm">
                                            <button type="button" class="btn-qty btn-minus" onclick="updateQty({{ $race->id }}, -1)">-</button>
                                            <input type="number" name="quantity" id="qty-{{ $race->id }}" class="input-qty" value="1" readonly>
                                            <button type="button" class="btn-qty btn-plus" onclick="updateQty({{ $race->id }}, 1)">+</button>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-danger w-100 fw-bold py-3 rounded-pill shadow-sm hover-scale">
                                        Bayar Sekarang <i class="bi bi-arrow-right-circle-fill ms-2"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @endauth
            </div>
            @empty
            <div class="col-12">
                <div class="alert alert-light border text-center py-5 rounded-4 shadow-sm">
                    <i class="bi bi-calendar-x display-4 text-muted mb-3 d-block opacity-50"></i>
                    <h5 class="fw-bold text-muted">Jadwal Belum Tersedia</h5>
                </div>
            </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        <div class="d-flex justify-content-center mt-5">
            {{ $races->links() }}
        </div>
    </div>

    <div class="col-lg-4">
        <div class="sidebar-card">
            <div class="d-flex align-items-center mb-4 border-bottom pb-3">
                <h5 class="fw-bold m-0 text-uppercase grow">Dompet Tiket</h5>
                <i class="bi bi-wallet2 fs-4 text-secondary"></i>
            </div>

            <div class="d-flex align-items-center mb-4 p-3 bg-light rounded-4 border">
                <div class="icon-box me-3 shadow-sm">
                    <i class="bi bi-qr-code-scan"></i>
                </div>
                <div>
                    <small class="text-muted d-block fw-bold text-uppercase" style="font-size: 0.7rem;">Tiket Dimiliki</small>
                    <h2 class="fw-bold m-0 text-dark">{{ $myTicketCount }} <span class="fs-6 text-muted fw-normal">Tiket</span></h2>
                </div>
            </div>

            @auth
                <a href="{{ route('users.history') }}" class="btn btn-outline-dark w-100 fw-bold py-2 rounded-pill mb-2">
                    <i class="bi bi-clock-history me-2"></i> Lihat Riwayat
                </a>
            @else
                <a href="{{ route('login') }}" class="btn btn-outline-danger w-100 fw-bold py-2 rounded-pill mb-2">
                    <i class="bi bi-box-arrow-in-right me-2"></i> Login Akses
                </a>
            @endauth
        </div>
    </div>
</div>

{{-- Modal Guest --}}
<div class="modal fade" id="guestModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content text-center p-3 shadow-lg">
            <div class="modal-body">
                <div class="mb-3 text-danger"><i class="bi bi-shield-lock-fill display-1"></i></div>
                <h4 class="fw-bold mb-2">Akses Terbatas</h4>
                <p class="text-muted small mb-4">Anda harus login terlebih dahulu.</p>
                <div class="d-grid gap-2">
                    <a href="{{ route('login') }}" class="btn btn-danger fw-bold rounded-pill">Login Sekarang</a>
                    <button type="button" class="btn btn-outline-secondary fw-bold rounded-pill" data-bs-dismiss="modal">Nanti Saja</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Script Logika Harga (Sama seperti sebelumnya)
    const prices = {
        @foreach($races as $race)
            {{ $race->id }}: {{ $race->base_price }},
        @endforeach
    };

    function updateQty(id, change) {
        const input = document.getElementById('qty-' + id);
        if(!input) return;

        let newVal = parseInt(input.value) + change;
        if (newVal < 1) newVal = 1;
        if (newVal > 10) newVal = 10;

        input.value = newVal;
        updateTotal(id);
    }

    function updateTotal(id) {
        const input = document.getElementById('qty-' + id);
        const totalDisplay = document.getElementById('total-' + id);

        if(!input || !totalDisplay) return;

        let qty = parseInt(input.value);
        const total = prices[id] * qty;

        totalDisplay.innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(total);
    }
</script>
@endpush
