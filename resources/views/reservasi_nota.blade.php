<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nota - {{ $reservation->kode_reservasi }}</title>
    <link rel="stylesheet" href="{{ asset('assets/nota.css') }}">
</head>
<body onload="window.print()">
    <div class="nota-premium">
        <div class="header-section">
            <h2>JAGARA ECO PARK</h2>
            <p>Bukti Reservasi Resmi</p>
        </div>

        <div class="content-section">
            <table style="width:100%">
                <tr>
                    <td class="label" width="30%">Kode</td>
                    <td class="value">: {{ $reservation->kode_reservasi }}</td>
                </tr>
                <tr>
                    <td class="label">Nama</td>
                    <td class="value">: {{ $reservation->nama_pengunjung }}</td>
                </tr>
                <tr>
                    <td class="label">Fasilitas</td>
                    <td class="value">: {{ $reservation->fasilitas->nama_fasilitas }}</td>
                </tr>
                <tr>
                    <td class="label">Tanggal</td>
                    <td class="value">: {{ $reservation->tanggal_kunjungan }}</td>
                </tr>
                <tr>
                    <td class="label">Status</td>
                    <td class="value">: <strong class="status-text">{{ strtoupper($reservation->status) }}</strong></td>
                </tr>
            </table>
        </div>

        <div class="sekat"></div>

        <div class="qr-section">
            <div class="qr-wrapper">
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ $reservation->kode_reservasi }}" alt="QR Code">
            </div>
            <p class="footer-text">Dicetak pada: {{ date('d/m/Y H:i') }}</p>
        </div>
    </div>
</body>
</html>