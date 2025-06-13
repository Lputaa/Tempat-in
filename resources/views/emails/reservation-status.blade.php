<!DOCTYPE html>
<html>
<head>
    <title>Update Status Reservasi</title>
</head>
<body style="font-family: sans-serif; color: #333;">
    <h2>Halo, {{ $reservation->user->name }}!</h2>
    <p>
        Ini adalah pemberitahuan bahwa status untuk reservasi Anda di <strong>{{ $reservation->restaurant->name }}</strong> telah diperbarui.
    </p>
    <hr>
    <p><strong>Detail Reservasi:</strong></p>
    <ul>
        <li><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($reservation->reservation_date)->format('d F Y') }}</li>
        <li><strong>Waktu:</strong> {{ \Carbon\Carbon::parse($reservation->reservation_time)->format('H:i') }}</li>
        <li><strong>Jumlah Tamu:</strong> {{ $reservation->number_of_guests }} orang</li>
        <li><strong>Status Baru:</strong> <strong>{{ ucfirst($reservation->status) }}</strong></li>
    </ul>
    <hr>
    <p>
        Terima kasih telah menggunakan layanan kami.
    </p>
    <p>
        Salam,<br>
        Tim Tempat-In
    </p>
</body>
</html>