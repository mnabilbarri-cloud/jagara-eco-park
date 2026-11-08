<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cek Status Reservasi - Jagara Eco Park</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background: #f1f5f9; font-family: 'Inter', sans-serif; display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0; padding: 20px;
        }
        .status-container { background: white; width: 100%; max-width: 550px; padding: 40px; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); }
        h2 { color: #2e7d32; font-weight: 800; text-align: center; margin-top: 0; margin-bottom: 30px; }
        .search-group { display: flex; gap: 10px; margin-bottom: 30px; }
        .search-group input { flex: 1; padding: 12px 15px; border: 2px solid #e2e8f0; border-radius: 10px; font-size: 1rem; }
        .search-group button { background: #2e7d32; color: white; border: none; padding: 0 20px; border-radius: 10px; font-weight: 600; cursor: pointer; }
        .status-badge { display: inline-block; padding: 6px 15px; border-radius: 20px; font-weight: 700; text-transform: uppercase; font-size: 0.85rem; }
        .status-menunggu { background: #fef3c7; color: #d97706; }
        .status-diterima { background: #dcfce7; color: #15803d; }
        .status-ditolak { background: #fee2e2; color: #b91c1c; }
        .result-card { border-top: 2px solid #e2e8f0; padding-top: 20px; }
        .btn-print { display: block; text-align: center; background: #1e293b; color: white; text-decoration: none; padding: 12px; border-radius: 10px; font-weight: 600; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="status-container">
        <h2><i class="fas fa-search"></i> Status Tiket Anda</h2>
        
        <form action="{{ route('reservasi.status') }}" method="GET" class="search-group">
            <input type="text" name="search" value="{{ $search }}" placeholder="Masukkan Kode Reservasi Anda..." required>
            <button type="submit">Cari</button>
        </form>

        @if(session('success'))
            <p style="color: #15803d; text-align:center; font-weight:600;">{{ session('success') }}</p>
        @endif

        @if($reservasi)
            <div class="result-card">
                <table style="width:100%; border-collapse:collapse; margin-bottom:20px;">
                    <tr style="height:40px;">
                        <td style="color:#64748b;">Kode Tiket</td>
                        <td style="text-align:right; font-weight:700;">{{ $reservasi->kode_reservasi }}</td>
                    </tr>
                    <tr style="height:40px;">
                        <td style="color:#64748b;">Nama Pengunjung</td>
                        <td style="text-align:right; font-weight:600;">{{ $reservasi->nama }}</td>
                    </tr>
                    <tr style="height:40px;">
                        <td style="color:#64748b;">Fasilitas</td>
                        <td style="text-align:right; font-weight:600;">{{ $reservasi->nama_fasilitas }}</td>
                    </tr>
                    <tr style="height:40px;">
                        <td style="color:#64748b;">Status Validasi</td>
                        <td style="text-align:right;">
                            @if($reservasi->status == 'Menunggu')
                                <span class="status-badge status-menunggu">Menunggu</span>
                            @elseif($reservasi->status == 'Diterima')
                                <span class="status-badge status-diterima">Disetujui</span>
                            @else
                                <span class="status-badge status-ditolak">Ditolak</span>
                            @endif
                        </td>
                    </tr>
                </table>

                @if($reservasi->status == 'Diterima')
                    <a href="{{ route('reservasi.nota', $reservasi->kode_reservasi) }}" target="_blank" class="btn-print"><i class="fas fa-print"></i> Lihat & Cetak Nota</a>
                @endif
            </div>
        @elseif($search)
            <p style="text-align:center; color:#b91c1c; font-weight:600;">Kode reservasi tidak valid atau belum terdaftar.</p>
        @endif
    </div>
</body>
</html>