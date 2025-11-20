<!DOCTYPE html>
<html lang="id">
<head>
    <title>Beli Tiket F1</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f3f4f6; }
        .ticket-card {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        }
        .ticket-header {
            background-color: #e10600;
            color: white;
            padding: 20px;
            text-align: center;
        }
        .price-summary {
            background-color: #f8f9fa;
            border-radius: 12px;
            padding: 20px;
        }
    </style>
</head>
<body>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">

                <div class="mb-3">
                    <a href="{{ route('users.dashboard') }}" class="text-decoration-none text-muted fw-bold">
                        <i class="bi bi-arrow-left me-1"></i> Batal & Kembali
                    </a>
                </div>

                <div class="ticket-card">
                    <div class="ticket-header">
                        <h5 class="mb-0 fw-bold text-uppercase letter-spacing-1">FORMULA 1 TICKET</h5>
                    </div>

                    <div class="p-4">
                        <div class="text-center mb-4">
                            <h2 class="fw-bold mb-1">{{ $race->circuit->gp_name }}</h2>
                            <p class="text-muted mb-1">{{ $race->circuit->circuit_name }}</p>
                            <span class="badge bg-dark text-white px-3 py-2 mt-2">
                                <i class="bi bi-calendar-event me-1"></i> {{ $race->race_date->format('d F Y') }}
                            </span>
                        </div>

                        <hr class="border-dashed my-4">

                        <form action="{{ route('booking.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="race_id" value="{{ $race->id }}">

                            <div class="mb-4">
                                <label class="form-label fw-bold">Jumlah Tiket</label>
                                <select name="quantity" id="quantity" class="form-select form-select-lg text-center fw-bold">
                                    <option value="1">1 Tiket</option>
                                    <option value="2">2 Tiket</option>
                                    <option value="3">3 Tiket</option>
                                    <option value="4">4 Tiket</option>
                                    <option value="5">5 Tiket</option>
                                </select>
                            </div>

                            <div class="price-summary">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Harga Satuan</span>
                                    <span class="fw-bold">Rp {{ number_format($race->base_price, 0, ',', '.') }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-3">
                                    <span class="text-muted">Jumlah</span>
                                    <span class="fw-bold" id="qty-display">x 1</span>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="fw-bold fs-5">Total Bayar</span>
                                    <span class="fw-bold fs-4 text-danger" id="total-price">
                                        Rp {{ number_format($race->base_price, 0, ',', '.') }}
                                    </span>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-danger w-100 btn-lg mt-4 fw-bold shadow-sm">
                                BAYAR SEKARANG <i class="bi bi-credit-card-2-front ms-2"></i>
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        const basePrice = {{ $race->base_price }};
        const quantitySelect = document.getElementById('quantity');
        const totalPriceEl = document.getElementById('total-price');
        const qtyDisplayEl = document.getElementById('qty-display');

        quantitySelect.addEventListener('change', function() {
            const qty = this.value;
            const total = basePrice * qty;

            // Update Tampilan
            qtyDisplayEl.innerText = 'x ' + qty;

            // Format Rupiah sederhana
            totalPriceEl.innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(total);
        });
    </script>

</body>
</html>
