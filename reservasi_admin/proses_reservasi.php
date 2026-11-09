<?php
session_start();

// ================= CEK LOGIN =================
if (!isset($_SESSION['admin'])) {
    header("Location: ../auth/login.php");
    exit;
}

include '../koneksi.php';

// ================= VALIDASI PARAMETER =================
if (!isset($_GET['id']) || !isset($_GET['aksi'])) {
    header("Location: data_reservasi.php");
    exit;
}

$id   = intval($_GET['id']);
$aksi = htmlspecialchars($_GET['aksi']); // ✅ tambahan keamanan

// ================= VALIDASI AKSI =================
if (!in_array($aksi, ['terima', 'tolak'])) {
    header("Location: data_reservasi.php");
    exit;
}

// Tentukan status
$status = ($aksi === 'terima') ? 'Diterima' : 'Ditolak';

// ================= CEK DATA ADA =================
$stmt = mysqli_prepare($conn, "SELECT status FROM reservasi WHERE id_reservasi = ?");
if (!$stmt) {
    die("Query error (SELECT): " . mysqli_error($conn));
}

mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) === 0) {
    mysqli_stmt_close($stmt);
    die("Data tidak ditemukan!");
}

$data = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

// ================= CEK STATUS SEBELUMNYA =================
if ($data['status'] !== 'Menunggu') {
    header("Location: data_reservasi.php?pesan=sudah_diproses");
    exit;
}

// ================= UPDATE STATUS =================
$stmt = mysqli_prepare($conn, "UPDATE reservasi SET status = ? WHERE id_reservasi = ?");
if (!$stmt) {
    die("Query error (UPDATE): " . mysqli_error($conn));
}

mysqli_stmt_bind_param($stmt, "si", $status, $id);

if (mysqli_stmt_execute($stmt)) {
    mysqli_stmt_close($stmt);
    header("Location: data_reservasi.php?pesan=berhasil");
    exit;
} else {
    mysqli_stmt_close($stmt);
    echo "Gagal update status: " . mysqli_error($conn);
    exit;
}
?>