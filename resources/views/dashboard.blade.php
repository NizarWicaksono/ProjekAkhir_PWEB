<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
</head>
<body>
    <h1>Halo, {{ Auth::user()->name }}!</h1>
    <p>Selamat datang di sistem pembelian tiket F1.</p>

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit">Logout</button>
    </form>

    <hr>
    <h3>Menu:</h3>
    <ul>
        <li><a href="#">Lihat Jadwal Balapan (Segera)</a></li>
        <li><a href="#">Riwayat Pembelian (Segera)</a></li>
    </ul>
</body>
</html>
