<?php
include '../koneksi.php';

// ✅ [KEAMANAN FIX] Dulu: $kode = $_GET['kode'] langsung di-inject ke SQL
// Sekarang: trim + length check + Prepared Statement
$kode = isset($_GET['kode']) ? trim($_GET['kode']) : '';

$data    = null;
$sisa_jam = 0;

if ($kode !== '') {
    // ✅ [KEAMANAN] Validasi format kode (hanya alfanumerik, maks 30 karakter)
    if (!preg_match('/^[A-Za-z0-9]{1,30}$/', $kode)) {
        $kode = ''; // kode tidak valid, abaikan
    }
}

if ($kode !== '') {
    // ✅ [KEAMANAN FIX] Prepared Statement — kode tidak bisa injeksi SQL
    $stmt = mysqli_prepare($conn, "
        SELECT *,
        TIMESTAMPDIFF(HOUR, created_at, NOW()) AS jam_berjalan
        FROM reservasi
        WHERE kode_reservasi = ?
    ");

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $kode);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $data   = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);

        if ($data) {
            if ($data['jam_berjalan'] >= 24 && $data['status'] == 'Menunggu') {
                // ✅ [KEAMANAN FIX] Update juga pakai Prepared Statement
                $upd = mysqli_prepare($conn, "UPDATE reservasi SET status='Kadaluarsa' WHERE kode_reservasi = ?");
                if ($upd) {
                    mysqli_stmt_bind_param($upd, "s", $kode);
                    mysqli_stmt_execute($upd);
                    mysqli_stmt_close($upd);
                }
                $data['status'] = 'Kadaluarsa';
            }
            $sisa_jam = max(0, 24 - $data['jam_berjalan']);
        }
    }
}

function badge($status) {
    if ($status == 'Menunggu') return 'badge waiting';
    if ($status == 'Diterima') return 'badge success';
    if ($status == 'Ditolak')  return 'badge danger';
    return 'badge expired';
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Status Reservasi - Jagara Eco Park</title>
<style>
* { box-sizing:border-box; font-family:'Segoe UI', Arial; }
body {
    background: linear-gradient(rgba(1,103,103,0), rgba(18,14,14,0.9)),
    url('../assets/images/hero jagara.jpg') center / cover no-repeat;
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    margin: 0;
}
.box {
    background: #fff;
    padding: 35px;
    border-radius: 16px;
    width: 500px;
    box-shadow: 0 15px 35px rgba(0,0,0,.2);
}
h2 { text-align: center; color: #2e7d32; margin-bottom: 20px; }
input[type=text] {
    width: 100%; padding: 12px; border-radius: 8px;
    border: 1px solid #ccc; font-size: 14px; margin-top: 6px;
}
button.cek-btn {
    width: 100%; margin-top: 15px; padding: 13px;
    background: #2e7d32; color: #fff; border: none;
    border-radius: 10px; font-size: 15px; font-weight: bold; cursor: pointer;
}
.result-card {
    margin-top: 20px; padding: 20px;
    border: 1px solid #e0e0e0; border-radius: 10px; background: #fafafa;
}
.result-row { display: flex; justify-content: space-between; margin: 8px 0; }
.label { color: #888; font-size: 13px; }
.value { font-weight: bold; font-size: 13px; }
.badge { padding: 5px 14px; border-radius: 15px; font-size: 11px; font-weight: bold; }
.waiting  { background: #fff3e0; color: #ef6c00; border: 1px solid #ef6c00; }
.success  { background: #e8f5e9; color: #2e7d32; border: 1px solid #2e7d32; }
.danger   { background: #ffe3e3; color: #c62828; border: 1px solid #c62828; }
.expired  { background: #f5f5f5; color: #9e9e9e; border: 1px solid #bdbdbd; }
.btn-back {
    display: inline-block; margin-top: 20px; text-align: center;
    color: #2e7d32; text-decoration: none; font-size: 13px;
}
.alert-error {
    background: #ffebee; border: 1px solid #ef9a9a; color: #c62828;
    padding: 12px 15px; border-radius: 8px; margin-top: 15px; font-size: 13px;
}
</style>
</head>
<body>
<div class="box">
    <h2>🔍 Cek Status Reservasi</h2>

    <form method="GET" action="status_reservasi.php">
        <label>Masukkan Kode Reservasi Anda:</label>
        <!-- ✅ maxlength membatasi input di sisi client -->
        <input type="text" name="kode" maxlength="30"
               value="<?= htmlspecialchars($kode, ENT_QUOTES, 'UTF-8') ?>"
               placeholder="Contoh: JG17xxxxxx99" required>
        <button class="cek-btn" type="submit">Cek Status</button>
    </form>

    <?php if (isset($_GET['kode']) && $kode === '' && !empty($_GET['kode'])): ?>
        <!-- ✅ [KEAMANAN] Pesan error tidak memantulkan input user mentah -->
        <div class="alert-error">⚠️ Format kode tidak valid.</div>

    <?php elseif ($kode !== '' && $data === null): ?>
        <div class="alert-error">❌ Kode reservasi tidak ditemukan.</div>

    <?php elseif ($data): ?>
        <div class="result-card">
            <div class="result-row">
                <span class="label">Kode Reservasi</span>
                <!-- ✅ [KEAMANAN FIX] htmlspecialchars() — cegah XSS dari data DB -->
                <span class="value"><?= htmlspecialchars($data['kode_reservasi'], ENT_QUOTES, 'UTF-8') ?></span>
            </div>
            <div class="result-row">
                <span class="label">Nama</span>
                <span class="value"><?= htmlspecialchars($data['nama_pengunjung'], ENT_QUOTES, 'UTF-8') ?></span>
            </div>
            <div class="result-row">
                <span class="label">Tanggal Kunjungan</span>
                <span class="value"><?= htmlspecialchars(date('d M Y', strtotime($data['tanggal_kunjungan'])), ENT_QUOTES, 'UTF-8') ?></span>
            </div>
            <div class="result-row">
                <span class="label">Jumlah Tiket</span>
                <span class="value"><?= (int)$data['jumlah_tiket'] ?> Orang</span>
            </div>
            <div class="result-row">
                <span class="label">Status</span>
                <span class="value">
                    <span class="badge <?= badge($data['status']) ?>">
                        <?= htmlspecialchars($data['status'], ENT_QUOTES, 'UTF-8') ?>
                    </span>
                </span>
            </div>

            <?php if ($data['status'] == 'Menunggu' && $sisa_jam > 0): ?>
            <div class="result-row">
                <span class="label">Sisa Waktu Konfirmasi</span>
                <span class="value" style="color: #ef6c00;">~<?= (int)$sisa_jam ?> jam lagi</span>
            </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <div style="text-align:center;">
        <a href="../index.php" class="btn-back">← Kembali ke Beranda</a>
    </div>
</div>
</body>
</html>
