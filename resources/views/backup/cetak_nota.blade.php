<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nota_{{ $reservasi->kode_reservasi }}</title>
    <style>
        body { font-family: 'Arial', sans-serif; color: #333; padding: 30px; margin: 0; }
        .invoice-box { max-width: 600px; margin: auto; padding: 20px; border: 1px solid #eee; border-radius: 8px; }
        .header { text-align: center; border-bottom: 2px solid #2e7d32; padding-bottom: 15px; margin-bottom: 20px; }
        .header h2 { margin: 0; color: #2e7d32; text-transform: uppercase; }
        .header p { margin: 5px 0 0 0; font-size: 0.9rem; color: #666; }
        .info-table, .item-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .info-table td { padding: 5px 0; font-size: 0.95rem; }
        .item-table th { background: #2e7d32; color: white; padding: 10px; text-align: left; }
        .item-table td { padding: 10px; border-bottom: 1px solid #eee; }
        .total-row { font-weight: bold; font-size: 1.1rem; color: #2e7d32; }
        .footer { text-align: center; margin-top: 40px; font-size: 0.85rem; color: #888; }
        .btn-print-block { text-align: center; margin-top: 20px; }
        .btn-print { background: #2e7d32; color: white; padding: 10px 20px; border: none; border-radius: 5px; font-weight: bold; cursor: pointer; }
        @media print {
            .btn-print-block { display: none; }
            body { padding: 0; }
            .invoice-box { border: none; }
        }
    </style>
</head>
<body>

    <div class="invoice-box">
        <div class="header">
            <h2>Jagara Eco Park</h2>
            <p>Kawasan Wisata Alam & Edukasi Hijau Lestari</p>
        </div>

        <table class="info-table">
            <tr>
                <td><strong>Kode Nota:</strong> {{ $reservasi->kode_reservasi }}</td>
                <td style="text-align: right;"><strong>Tanggal Kunjungan:</strong> {{ date('d M Y', strtotime($reservasi->tanggal_kunjungan)) }}</td>
            </tr>
            <tr>
                <td><strong>Nama Pengunjung:</strong> {{ $reservasi->nama }}</td>
                <td style="text-align: right;"><strong>Status:</strong> LUNAS / DISETUJUI</td>
            </tr>
        </table>

        <table class="item-table">
            <thead>
                <tr>
                    <th>Deskripsi Fasilitas</th>
                    <th style="text-align: center;">Jumlah Tiket</th>
                    <th style="text-align: right;">Total Bayar</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $reservasi->nama_fasilitas }}</td>
                    <td style="text-align: center;">{{ $reservasi->jumlah_tiket }} Pcs</td>
                    <td style="text-align: right;">IDR {{ number_format($reservasi->total_bayar, 0, ',', '.') }}</td>
                </tr>
                <tr class="total-row">
                    <td colspan="2" style="text-align: right; padding-top:15px;">TOTAL LUNAS</td>
                    <td style="text-align: right; padding-top:15px;">IDR {{ number_format($reservasi->total_bayar, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>

        <div class="footer">
            <p>Terima kasih telah melakukan reservasi di Jagara Eco Park.<br>Harap bawa lembaran nota cetak ini saat berkunjung ke loket utama pintu masuk.</p>
        </div>
    </div>

    <div class="btn-print-block">
        <button class="btn-print" onclick="window.print()"><i class="fas fa-print"></i> Cetak Struk Nota</button>
    </div>

</body>
</html>