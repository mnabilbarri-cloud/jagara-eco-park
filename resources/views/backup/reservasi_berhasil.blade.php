<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservasi Berhasil - Jagara Eco Park</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('{{ asset("assets/images/hero jagara.jpg") }}') no-repeat center center fixed;
            background-size: cover;
            font-family: 'Inter', sans-serif;
            display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0; padding: 20px;
        }
        .success-card {
            background: white; width: 100%; max-width: 500px; padding: 40px; border-radius: 20px; box-shadow: 0 20px 40px rgba(0,0,0,0.3); text-align: center;
        }
        .icon-box { color: #2e7d32; font-size: 60px; margin-bottom: 20px; }
        h2 { color: #2e7d32; margin: 0 0 10px 0; font-weight: 800; }
        p { color: #64748b; font-size: 1rem; margin-bottom: 30px; }
        .kode-box {
            background: #f1f5f9; border: 2px dashed #2e7d32; padding: 15px; border-radius: 10px; font-size: 1.2rem; font-weight: 700; color: #1e293b; margin-bottom: 25px; letter-spacing: 1px;
        }
        .detail-table { width: 100%; margin-bottom: 30px; border-collapse: collapse; text-align: left; }
        .detail-table td { padding: 8px 0; font-size: 0.95rem; }
        .detail-table td.label { color: #64748b; }
        .detail-table td.value { color: #1e293b; font-weight: 600; text-align: right; }
        .btn-confirm {
            display: block; background: #2e7d32; color: white; text-decoration: none; padding: 14px; border-radius: 10px; font-weight: 700; transition: 0.3s; text-transform: uppercase;
        }
        .btn-confirm:hover { background: #1b5e20; }
    </style>
</head>
<body>
    <div class="success-card">
        <div class="icon-box"><i class="fas fa-check-circle"></i></div>
        <h2>Reservasi Berhasil!</h2>
        <p>Silakan lakukan pembayaran dan konfirmasi tiket Anda.</p>
        
        <div class="kode-box">
            {{ $reservasi->kode_reservasi }}
        </div>

        <table class="detail-table">
            <tr>
                <td class="label">Nama Lengkap</td>
                <td class="value">{{ $reservasi->nama }}</td>
            </tr>
            <tr>
                <td class="label">Fasilitas Wisata</td>
                <td class="value">{{ $reservasi->nama_fasilitas }}</td>
            </tr>
            <tr>
                <td class="label">Jumlah Tiket</td>
                <td class="value">{{ $reservasi->jumlah_tiket }} Orang</td>
            </tr>
            <tr>
                <td class="label">Total Pembayaran</td>
                <td class="value" style="color: #2e7d32;">IDR {{ number_format($reservasi->total_bayar, 0, ',', '.') }}</td>
            </tr>
        </table>

        <a href="{{ route('reservasi.upload', $reservasi->kode_reservasi) }}" class="btn-confirm">Lanjut ke Pembayaran</a>
    </div>
</body>
</html>