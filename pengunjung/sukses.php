<?php
// ✅ [KEAMANAN FIX] Dulu: $kode = $_GET['kode'] langsung di-echo → XSS
// Sekarang: validasi format + htmlspecialchars sebelum ditampilkan

$kode_raw = isset($_GET['kode']) ? trim($_GET['kode']) : '';

// Validasi: hanya alfanumerik, maks 30 karakter
$kode = '';
if (preg_match('/^[A-Za-z0-9]{1,30}$/', $kode_raw)) {
    $kode = $kode_raw;
}

// Jika kode tidak valid atau kosong, redirect ke halaman reservasi
if ($kode === '') {
    header("Location: reservasi.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
     <meta charset="UTF-8">
     <title>Reservasi Berhasil - Jagara Eco Park</title>
<style>
body {
    margin: 0;
    background: linear-gradient(rgba(1,103,103,0), rgba(18,14,14,0.9)),
    url('../assets/images/hero jagara.jpg') center / cover no-repeat;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    font-family: Arial;
}
.box {
    background: #fff;
    padding: 40px;
    border-radius: 16px;
    text-align: center;
    width: 420px;
    box-shadow: 0 15px 35px rgba(0,0,0,.15);
}
.kode-box {
    background: #e8f5e9;
    border: 2px dashed #2e7d32;
    border-radius: 10px;
    padding: 15px 20px;
    margin: 15px 0;
    font-size: 22px;
    font-weight: bold;
    color: #1b5e20;
    letter-spacing: 2px;
}
.btn {
    display: inline-block;
    padding: 12px 24px;
    border-radius: 10px;
    text-decoration: none;
    font-weight: bold;
    margin: 10px;
}
.primary   { background: #2e7d32; color: #fff; }
.secondary { border: 2px solid #2e7d32; color: #2e7d32; }
.icon-success { font-size: 48px; margin-bottom: 10px; }
</style>
</head>
<body>
<div class="box">
    <div class="icon-success">✅</div>
    <h2>Reservasi Berhasil!</h2>
    <p>Kode Reservasi Anda:</p>
    <!-- ✅ [KEAMANAN FIX] htmlspecialchars() — cegah XSS jika kode berisi karakter berbahaya -->
    <div class="kode-box"><?= htmlspecialchars($kode, ENT_QUOTES, 'UTF-8') ?></div>
    <p style="font-size:13px; color:#666;">
        Simpan kode ini! Gunakan untuk mengecek status reservasi Anda.
    </p>
    <a href="status_reservasi.php?kode=<?= urlencode($kode) ?>" class="btn primary">
        🔍 Cek Status Reservasi
    </a>
    <a href="../index.php" class="btn secondary">
        ← Kembali ke Beranda
    </a>
</div>
</body>
</html>
