<!DOCTYPE html>
<html>
<head>
    <title>E-Ticket F1</title>
    <style>
        body {
            font-family: sans-serif;
            color: #333;
        }
        .header {
            background-color: #e10600;
            color: white; padding: 20px;
            text-align: center;
        }
        .content { padding: 30px; }
        .title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 5px;
            text-align: center;
        }
        .subtitle {
            font-size: 14px;
            color: #666;
            margin-bottom: 30px;
            text-align: center;
        }
        .row {
            margin-bottom: 20px;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }
        .label {
            font-weight: bold;
            font-size: 12px;
            color: #888;
            text-transform: uppercase;
            margin-bottom: 5px;
        }
        .value {
            font-size: 16px;
            font-weight: bold;
        }
        .ticket-code-box {
            text-align: center;
            margin-top: 40px;
            padding: 20px;
            border: 2px dashed #333;
            border-radius: 10px;
            background-color: #f9f9f9;
        }
        .footer {
            text-align: center;
            margin-top: 40px;
            font-size: 10px;
            color: #aaa;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>FORMULA 1 TICKET</h1>
        <p>Official Digital Pass</p>
    </div>

    <div class="content">
        <div class="title">{{ $ticket->race->circuit->gp_name }}</div>
        <div class="subtitle">
            {{ $ticket->race->circuit->circuit_name }} <br>
            {{ $ticket->race->race_date->format('d F Y, H:i') }}
        </div>

        <div class="row">
            <div class="label">Pemilik Tiket</div>
            <div class="value">{{ $ticket->user->name }}</div>
            <div style="font-size: 12px; color: #666; margin-top: 2px;">{{ $ticket->user->email }}</div>
        </div>

        <div class="row">
            <div class="label">Waktu Transaksi</div>
            <div class="value">{{ $ticket->created_at->format('d F Y') }}</div>
            <div style="font-size: 12px; color: #666;">Pukul {{ $ticket->created_at->format('H:i') }} WIB</div>
        </div>

        <div class="row">
            <div class="label">Harga Tiket</div>
            <div class="value">Rp {{ number_format($ticket->price, 0, ',', '.') }}</div>
        </div>

        <div class="ticket-code-box">
            <div style="font-size: 12px; color: #666; margin-bottom: 5px;">KODE TIKET</div>
            <h2 style="font-family: monospace; font-size: 30px; letter-spacing: 3px; margin: 0;">
                {{ $ticket->ticket_code }}
            </h2>
        </div>
    </div>

    <div class="footer">
        &copy; 2025 F1 Ticket System. Harap membawa identitas diri saat penukaran tiket.
    </div>
</body>
</html>
