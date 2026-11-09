<?php
session_start();
// ✅ [KEAMANAN] Cek autentikasi admin
if (!isset($_SESSION['admin'])) {
    header("Location: ../auth/login.php");
    exit;
}

include '../koneksi.php';

$fasilitas = mysqli_query($conn, "SELECT * FROM fasilitas");

if (isset($_POST['simpan'])) {

    // ✅ [KEAMANAN FIX] Dulu: htmlspecialchars saja, bukan prepared statement
    // Sekarang: validasi + prepared statement untuk INSERT
    $kode   = 'JG'.time().rand(10,99);
    $nama   = trim($_POST['nama'] ?? '');
    $no_hp  = trim($_POST['no_hp'] ?? '');
    $tanggal = $_POST['tanggal'] ?? '';
    $id_fasilitas = $_POST['id_fasilitas'] ?? '';
    $jumlah = $_POST['jumlah'] ?? '';
    $status = 'Menunggu';

    // ================= VALIDASI TAMBAHAN =================
    if (empty($nama) || empty($no_hp) || empty($tanggal) || empty($id_fasilitas) || empty($jumlah)) {
        echo "<script>alert('Semua data wajib diisi!'); window.history.back();</script>";
        exit;
    }

    if (!is_numeric($jumlah) || $jumlah <= 0) {
        echo "<script>alert('Jumlah tiket harus angka dan lebih dari 0'); window.history.back();</script>";
        exit;
    }

    // ✅ TAMBAHAN VALIDASI TANGGAL
    if ($tanggal < date('Y-m-d')) {
        echo "<script>alert('Tanggal tidak boleh di masa lalu!'); window.history.back();</script>";
        exit;
    }

    // Amankan tipe data angka
    $id_fasilitas = intval($id_fasilitas);
    $jumlah = intval($jumlah);

    // ✅ PERBAIKAN: prepared statement (AMAN)
    $stmt = mysqli_prepare($conn, "
        INSERT INTO reservasi
        (kode_reservasi, nama_pengunjung, no_hp, tanggal_kunjungan, id_fasilitas, jumlah_tiket, status)
        VALUES (?, ?, ?, ?, ?, ?, ?)
    ");

    mysqli_stmt_bind_param($stmt, "sssssis",
        $kode,
        $nama,
        $no_hp,
        $tanggal,
        $id_fasilitas,
        $jumlah,
        $status
    );

    mysqli_stmt_execute($stmt);

    header("Location: data_reservasi.php");
    exit;
}
?>