<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Pembayaran - Jagara Eco Park</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('{{ asset("assets/images/hero jagara.jpg") }}') no-repeat center center fixed;
            background-size: cover; font-family: 'Inter', sans-serif; display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0; padding: 20px;
        }
        .form-card { background: white; width: 100%; max-width: 500px; padding: 40px; border-radius: 20px; box-shadow: 0 25px 50px rgba(0,0,0,0.4); }
        h3 { color: #2e7d32; text-align: center; font-weight: 800; margin-top: 0; text-transform: uppercase; margin-bottom: 25px; }
        .info-bank { background: #f8fafc; padding: 15px; border-radius: 10px; border-left: 4px solid #2e7d32; margin-bottom: 25px; font-size: 0.9rem; color: #334155; }
        label { display: block; font-weight: 600; color: #334155; margin-bottom: 8px; font-size: 0.9rem; }
        input[type="file"] { padding: 12px; background: #f8fafc; border: 2px dashed #cbd5e1; width: 100%; border-radius: 10px; box-sizing: border-box; }
        .btn-submit { width: 100%; background: #2e7d32; color: white; border: none; padding: 14px; border-radius: 10px; font-weight: 700; cursor: pointer; text-transform: uppercase; margin-top: 20px; transition: 0.3s; }
        .btn-submit:hover { background: #1b5e20; }
    </style>
</head>
<body>
    <div class="form-card">
        <h3><i class="fas fa-receipt"></i> Konfirmasi Bayar</h3>
        
        <div class="info-bank">
            <strong>Transfer Bank Tujuan:</strong><br>
            Bank Mandiri: 131-0012-3456-78<br>
            a.n Jagara Eco Park Official<br>
            Total Tagihan: <strong>IDR {{ number_format($reservasi->total_bayar, 0, ',', '.') }}</strong>
        </div>

        <form action="{{ route('reservasi.upload.store', $reservasi->kode_reservasi) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div>
                <label>Unggah Gambar Bukti Transfer</label>
                <input type="file" name="bukti_pembayaran" accept="image/*" required>
                <small style="color: #64748b; display: block; margin-top: 5px;">Format: JPG, JPEG, PNG (Maks 2MB)</small>
            </div>
            
            <button type="submit" class="btn-submit">Kirim Bukti Pembayaran</button>
        </form>
    </div>
</body>
</html>