<!DOCTYPE html>
<html lang="id">
<head>
    <title>Checkout Tiket</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f3f4f6; }

        /* Card Styling */
        .booking-card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            overflow: hidden;
        }
        .card-header-custom {
            background: linear-gradient(135deg, #e10600 0%, #ff4d4d 100%);
            color: white;
            padding: 25px;
            text-align: center;
        }

        /* Input Quantity Styling */
        .qty-input-group {
            background-color: #f8f9fa;
            border-radius: 12px;
            padding: 5px;
            border: 1px solid #dee2e6;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .btn-qty {
            width: 40px;
            height: 40px;
            border-radius: 8px !important;
            font-weight: 800;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: 0.2s;
            cursor: pointer;
        }
        .btn-minus { background-color: #e9ecef; color: #495057; }
        .btn-minus:hover { background-color: #ced4da; }
        .btn-minus:active { transform: scale(0.95); }

        .btn-plus { background-color: #212529; color: white; }
        .btn-plus:hover { background-color: #000; }
        .btn-plus:active { transform: scale(0.95); }

        .input-qty {
            border: none;
            background: transparent;
            text-align: center;
            font-size: 1.2rem;
            font-weight: 800;
            width: 80px; /* Diperlebar sedikit agar muat angka manual */
            outline: none;
        }
        /* Hilangkan panah number default di browser */
        .input-qty::-webkit-outer-spin-button,
        .input-qty::-webkit-inner-spin-button {
            -webkit-appearance: none; margin: 0;
        }
    </style>
</head>
<body class="bg-light">

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">

                <a href="{{ route('tickets.index') }}" class="text-decoration-none fw-bold text-secondary mb-4 d-inline-flex align-items-center">
                    <div class="bg-white p-2 rounded-circle shadow-sm me-2"><i class="bi bi-arrow-left"></i></div>
                    Batal & Kembali
                </a>

                <div class="card booking-card">
                    <div class="card-header-custom">
                        <h5 class="fw-bold mb-0 text-uppercase letter-spacing-1">Konfirmasi Pesanan</h5>
                        <p class="small opacity-75 mb-0">Lengkapi detail di bawah ini</p>
                    </div>

                    <div class="card-body p-4">
                        <div class="text-center mb-4">
                            <span class="badge bg-danger bg-opacity-10 text-danger border border-danger mb-2 px-3">
                                {{ $race->race_date->format('d F Y') }}
                            </span>
                            <h3 class="fw-bold mb-1">{{ $race->circuit->gp_name }}</h3>
                            <p class="text-muted small">
                                <i class="bi bi-geo-alt-fill text-danger"></i> {{ $race->circuit->circuit_name }}
                            </p>
                        </div>

                        <hr class="border-dashed opacity-25 my-4">

                        <form action="{{ route('booking.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="race_id" value="{{ $race->id }}">

                            <div class="mb-4">
                                <label class="fw-bold mb-2 d-block text-center text-muted small text-uppercase">Jumlah Tiket</label>

                                <div class="d-flex justify-content-center">
                                    <div class="qty-input-group shadow-sm" style="width: 200px;">
                                        <button type="button" class="btn btn-qty btn-minus" id="btn-minus">
                                            <i class="bi bi-dash-lg"></i>
                                        </button>

                                        <input type="number" name="quantity" id="qty" class="input-qty" value="1" min="1" max="99">

                                        <button type="button" class="btn btn-qty btn-plus" id="btn-plus">
                                            <i class="bi bi-plus-lg"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="text-center mt-2">
                                    <small class="text-muted" style="font-size: 0.7rem;">Min: 1, Max: 99 Tiket</small>
                                </div>
                            </div>

                            <div class="bg-light p-3 rounded-3 mb-4 border">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span class="text-muted small">Harga Satuan</span>
                                    <span class="fw-bold small">Rp {{ number_format($race->base_price, 0, ',', '.') }}</span>
                                </div>
                                <hr class="my-2">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="fw-bold text-dark">Total Bayar</span>
                                    <span class="fw-bold fs-4 text-success" id="total">
                                        Rp {{ number_format($race->base_price, 0, ',', '.') }}
                                    </span>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-dark w-100 py-3 fw-bold shadow-sm rounded-3">
                                BAYAR SEKARANG <i class="bi bi-arrow-right-circle ms-2"></i>
                            </button>
                        </form>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <small class="text-muted"><i class="bi bi-shield-lock-fill me-1"></i> Pembayaran Aman & Terenkripsi</small>
                </div>

            </div>
        </div>
    </div>

    <script>
        const basePrice = {{ $race->base_price }};
        const qtyInput = document.getElementById('qty');
        const totalDisplay = document.getElementById('total');
        const btnMinus = document.getElementById('btn-minus');
        const btnPlus = document.getElementById('btn-plus');
        const MAX_TICKET = 99;

        // Fungsi Update Harga
        function updatePrice() {
            let qty = parseInt(qtyInput.value);

            // Validasi agar tidak NaN atau 0 saat perhitungan
            if (isNaN(qty) || qty < 1) qty = 0;

            const total = basePrice * qty;
            // Format Rupiah
            totalDisplay.innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(total);
        }

        // Fungsi Validasi Input (Dipanggil saat user selesai ngetik / blur)
        function validateInput() {
            let qty = parseInt(qtyInput.value);

            // Jika kosong, kurang dari 1, atau bukan angka -> set ke 1
            if (isNaN(qty) || qty < 1) {
                qtyInput.value = 1;
            }
            // Jika lebih dari max -> set ke max
            else if (qty > MAX_TICKET) {
                qtyInput.value = MAX_TICKET;
            }

            updatePrice(); // Update harga dengan angka yang sudah divalidasi
        }

        // Event Listener untuk Input Manual
        qtyInput.addEventListener('input', updatePrice); // Update harga real-time saat ngetik
        qtyInput.addEventListener('blur', validateInput); // Validasi saat kursor keluar dari input

        // Event Tombol Kurang (-)
        btnMinus.addEventListener('click', function() {
            let currentValue = parseInt(qtyInput.value) || 0; // Handle jika kosong
            if (currentValue > 1) {
                qtyInput.value = currentValue - 1;
                updatePrice();
            }
        });

        // Event Tombol Tambah (+)
        btnPlus.addEventListener('click', function() {
            let currentValue = parseInt(qtyInput.value) || 0; // Handle jika kosong
            if (currentValue < MAX_TICKET) {
                qtyInput.value = currentValue + 1;
                updatePrice();
            }
        });
    </script>
</body>
</html>
