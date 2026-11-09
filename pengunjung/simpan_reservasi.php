<?php
include '../koneksi.php';

// ================= VALIDASI INPUT =================
if (
    !isset($_POST['nama_pengunjung']) ||
    !isset($_POST['no_hp']) ||
    !isset($_POST['tanggal_kunjungan']) ||
    !isset($_POST['id_fasilitas']) ||
    !isset($_POST['jumlah_tiket'])
) {
    die("Akses tidak valid!");
}

$nama     = trim($_POST['nama_pengunjung']);
$hp       = trim($_POST['no_hp']);
$tanggal  = $_POST['tanggal_kunjungan'];
$fasil    = intval($_POST['id_fasilitas']);
$jumlah   = intval($_POST['jumlah_tiket']);

// ================= VALIDASI LOGIKA =================

// Cek kosong
if (empty($nama) || empty($hp) || empty($tanggal) || $jumlah <= 0) {
    die("Semua data wajib diisi dengan benar!");
}

// Validasi panjang nama
if (strlen($nama) < 3) {
    die("Nama terlalu pendek!");
}

// Validasi no HP (hanya angka, minimal 10 digit)
if (!preg_match('/^[0-9]{10,15}$/', $hp)) {
    die("Nomor HP tidak valid!");
}

// Validasi tanggal (tidak boleh masa lalu)
if ($tanggal < date('Y-m-d')) {
    die("Tanggal kunjungan tidak boleh di masa lalu!");
}

// ================= PROTEKSI 24 JAM =================
$stmt = mysqli_prepare($conn, "
    SELECT id_reservasi FROM reservasi 
    WHERE no_hp = ? 
    AND status = 'Menunggu' 
    AND created_at > DATE_SUB(NOW(), INTERVAL 24 HOUR)
");

if (!$stmt) {
    die("Prepare gagal: " . mysqli_error($conn));
}

mysqli_stmt_bind_param($stmt, "s", $hp);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) > 0) {
    header("Location: status_reservasi.php?pesan=tunggu_24jam");
    exit;
}

// ================= DOUBLE BOOKING =================
$stmt = mysqli_prepare($conn, "
    SELECT id_reservasi FROM reservasi 
    WHERE no_hp = ?
    AND tanggal_kunjungan = ?
    AND id_fasilitas = ?
    AND status IN ('Menunggu','Diterima')
");

if (!$stmt) {
    die("Prepare gagal: " . mysqli_error($conn));
}

mysqli_stmt_bind_param($stmt, "ssi", $hp, $tanggal, $fasil);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) > 0) {
    header("Location: status_reservasi.php?pesan=sudah_ada");
    exit;
}

// ================= CEK KAPASITAS =================
// (Misal maksimal 100 orang per hari per fasilitas)
$kapasitas_maks = 100;

$stmt = mysqli_prepare($conn, "
    SELECT SUM(jumlah_tiket) as total 
    FROM reservasi 
    WHERE tanggal_kunjungan = ?
    AND id_fasilitas = ?
    AND status = 'Diterima'
");

if (!$stmt) {
    die("Prepare gagal: " . mysqli_error($conn));
}

mysqli_stmt_bind_param($stmt, "si", $tanggal, $fasil);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$data = mysqli_fetch_assoc($result);

$total_sekarang = $data['total'] ?? 0;

if (($total_sekarang + $jumlah) > $kapasitas_maks) {
    header("Location: status_reservasi.php?pesan=kapasitas_penuh");
    exit;
}

// ================= GENERATE KODE UNIK =================
$kode = 'JG' . time() . rand(10,99);

// ================= INSERT DATA =================
$stmt = mysqli_prepare($conn, "
    INSERT INTO reservasi 
    (kode_reservasi, nama_pengunjung, no_hp, tanggal_kunjungan, id_fasilitas, jumlah_tiket, status)
    VALUES (?, ?, ?, ?, ?, ?, 'Menunggu')
");

if (!$stmt) {
    die("Prepare gagal: " . mysqli_error($conn));
}

mysqli_stmt_bind_param($stmt, "ssssii", $kode, $nama, $hp, $tanggal, $fasil, $jumlah);

if (mysqli_stmt_execute($stmt)) {
    header("Location: sukses.php?kode=" . urlencode($kode));
} else {
    echo "Gagal menyimpan data: " . mysqli_error($conn);
}

exit;
?>