@extends('layouts.user')

@section('title', 'Katalog Tiket - F1 Ticket')

@push('styles')
<style>
    /* CSS Khusus Tiket */
    .ticket-card { border: none; border-radius: 16px; background: white; transition: transform 0.2s, box-shadow 0.2s; height: 100%; overflow: hidden; display: flex; flex-direction: column; }
    .ticket-card:hover { transform: translateY(-5px); box-shadow: 0 10px 25px rgba(0,0,0,0.1); }
    .card-top-accent { height: 6px; background: linear-gradient(90deg, #e10600, #ff4d4d); }
    .ticket-price { color: #198754; font-weight: 800; font-size: 1.1rem; }
    .sidebar-card { background: white; border-radius: 16px; border: none; box-shadow: 0 4px 20px rgba(0,0,0,0.05); position: sticky; top: 90px; }
    .icon-box { width: 50px; height: 50px; background-color: #fff5f5; color: #e10600; display: flex; align-items: center; justify-content: center; border-radius: 12px; font-size: 1.5rem; }

    /* Modal Styles */
    .modal-content { border-radius: 20px; border: none; overflow: hidden; }
    .modal-header-custom { background: linear-gradient(135deg, #e10600 0%, #ff4d4d 100%); color: white; padding: 20px 25px; }
    .qty-input-group { background-color: #f8f9fa; border-radius: 12px; padding: 5px; border: 1px solid #dee2e6; display: flex; align-items: center; justify-content: space-between; width: 100%; max-width: 200px; margin: 0 auto; }
    .btn-qty { width: 40px; height: 40px; border-radius: 8px !important; font-weight: 800; border: none; display: flex; align-items: center; justify-content: center; transition: 0.2s; cursor: pointer; }
    .btn-minus { background-color: #e9ecef; color: #495057; }
    .btn-plus { background-color: #212529; color: white; }
    .input-qty { border: none; background: transparent; text-align: center; font-size: 1.2rem; font-weight: 800; width: 60px; outline: none; }
    .modal-backdrop.show { backdrop-filter: blur(5px); -webkit-backdrop-filter: blur(5px); background-color: rgba(0, 0, 0, 0.5); opacity: 1 !important; }
</style>
@endpush

@section('content')
<div class="row g-4">
    <div class="col-lg-8">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold m-0 text-dark">🏁 Kalender Balapan Resmi</h4>
            <span class="badge bg-dark">{{ $races->count() }} Event Tersedia</span>
        </div>

        <div class="row g-3">
            @forelse($races as $race)
            <div class="col-md-6">
                <div class="ticket-card shadow-sm">
                    <div class="card-top-accent"></div>
                    <div class="card-body p-4 d-flex flex-column h-100">
                        <div class="mb-3">
                            <span class="badge bg-danger bg-opacity-10 text-danger border border-danger mb-2 px-2">
                                {{ $race->race_date->format('d M Y') }}
                            </span>
                            <h5 class="fw-bold text-dark mb-1">{{ $race->circuit->gp_name }}</h5>
                            <small class="text-muted d-block">
                                <i class="bi bi-geo-alt-fill me-1 text-secondary"></i> {{ $race->circuit->circuit_name }}
                            </small>
                        </div>
                        <hr class="border-secondary opacity-10 my-auto">
                        <div class="mt-3 d-flex justify-content-between align-items-end">
                            <div>
                                <small class="text-muted d-block" style="font-size: 0.75rem;">Mulai dari</small>
                                <div class="ticket-price">Rp {{ number_format($race->base_price, 0, ',', '.') }}</div>
                            </div>
                            @auth
                                <button type="button" class="btn btn-dark rounded-pill px-4 fw-bold" data-bs-toggle="modal" data-bs-target="#buyModal-{{ $race->id }}">Beli<i class="bi bi-cart-plus ms-1"></i></button>
                            @else
                                <button type="button" class="btn btn-dark rounded-pill px-4 fw-bold" data-bs-toggle="modal" data-bs-target="#guestModal">Beli<i class="bi bi-lock-fill ms-1"></i></button>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>

            @auth
            <div class="modal fade" id="buyModal-{{ $race->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header-custom d-flex justify-content-between align-items-center">
                            <h5 class="fw-bold m-0 text-uppercase letter-spacing-1">Checkout Tiket</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body p-4">
                            <div class="text-center mb-4">
                                <h4 class="fw-bold mb-1">{{ $race->circuit->gp_name }}</h4>
                                <p class="text-muted small mb-2">{{ $race->circuit->circuit_name }}</p>
                                <span class="badge bg-dark">{{ $race->race_date->format('d F Y') }}</span>
                            </div>
                            <form action="{{ route('booking.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="race_id" value="{{ $race->id }}">
                                <div class="mb-4 text-center">
                                    <label class="fw-bold mb-2 text-muted small text-uppercase">Jumlah Tiket</label>
                                    <div class="qty-input-group shadow-sm">
                                        <button type="button" class="btn btn-qty btn-minus" onclick="updateQty({{ $race->id }}, -1)"><i class="bi bi-dash-lg"></i></button>
                                        <input type="number" name="quantity" id="qty-{{ $race->id }}" class="input-qty" value="1" min="1" max="99" oninput="updateTotal({{ $race->id }})">
                                        <button type="button" class="btn btn-qty btn-plus" onclick="updateQty({{ $race->id }}, 1)"><i class="bi bi-plus-lg"></i></button>
                                    </div>
                                </div>
                                <div class="bg-light p-3 rounded-3 mb-4 border d-flex justify-content-between align-items-center">
                                    <div><small class="text-muted d-block">Total Bayar</small><small class="text-muted">@ Rp {{ number_format($race->base_price, 0, ',', '.') }}</small></div>
                                    <span class="fw-bold fs-4 text-success" id="total-{{ $race->id }}">Rp {{ number_format($race->base_price, 0, ',', '.') }}</span>
                                </div>
                                <button type="submit" class="btn btn-danger w-100 py-3 fw-bold rounded-pill shadow-sm">BAYAR SEKARANG <i class="bi bi-credit-card-2-front ms-2"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endauth
            @empty
            <div class="col-12"><div class="alert alert-light border text-center py-5 rounded-4"><h5 class="fw-bold">Jadwal Belum Tersedia</h5></div></div>
            @endforelse
        </div>
    </div>

    <div class="col-lg-4">
        <div class="sidebar-card p-4">
            <h5 class="fw-bold mb-4">Dompet Tiket</h5>
            <div class="d-flex align-items-center mb-4 p-3 bg-light rounded-3 border">
                <div class="icon-box me-3"><i class="bi bi-qr-code-scan"></i></div>
                <div><small class="text-muted d-block fw-bold text-uppercase" style="font-size: 0.7rem;">Tiket Dimiliki</small><h2 class="fw-bold m-0 text-dark">{{ $myTicketCount }}</h2></div>
            </div>
            @auth
                <a href="{{ route('users.history') }}" class="btn btn-outline-dark w-100 fw-bold py-2 rounded-pill"><i class="bi bi-clock-history me-2"></i> Lihat Riwayat</a>
            @else
                <a href="{{ route('login') }}" class="btn btn-outline-danger w-100 fw-bold py-2 rounded-pill"><i class="bi bi-box-arrow-in-right me-2"></i> Login untuk Riwayat</a>
            @endauth
        </div>
    </div>
</div>

<div class="modal fade" id="guestModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content text-center p-3">
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
    const prices = { @foreach($races as $race) {{ $race->id }}: {{ $race->base_price }}, @endforeach };
    function updateQty(id, change) {
        const input = document.getElementById('qty-' + id);
        if(!input) return;
        let newVal = parseInt(input.value) + change;
        if (newVal < 1) newVal = 1; if (newVal > 99) newVal = 99;
        input.value = newVal; updateTotal(id);
    }
    function updateTotal(id) {
        const input = document.getElementById('qty-' + id);
        const totalDisplay = document.getElementById('total-' + id);
        if(!input || !totalDisplay) return;
        let qty = parseInt(input.value);
        if (isNaN(qty) || qty < 1) qty = 1; if (qty > 99) { qty = 99; input.value = 99; }
        const total = prices[id] * qty;
        totalDisplay.innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(total);
    }
</script>
@endpush
