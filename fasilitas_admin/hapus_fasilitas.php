<?php
session_start();
// ✅ [KEAMANAN] Cek autentikasi admin
if (!isset($_SESSION['admin'])) {
    header("Location: ../auth/login.php");
    exit;
}

include '../koneksi.php';

// ✅ [KEAMANAN FIX] Dulu: $id = $_GET['id'] langsung → SQL Injection
// Sekarang: gunakan intval() agar hanya angka integer yang diterima
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: data_fasilitas.php");
    exit;
}

$id = intval($_GET['id']);

// ✅ [KEAMANAN] Gunakan Prepared Statement, bukan string concatenation
$stmt = mysqli_prepare($conn, "DELETE FROM fasilitas WHERE id_fasilitas = ?");
if (!$stmt) {
    die("Prepare error: " . mysqli_error($conn));
}

mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

header("Location: data_fasilitas.php");
exit;
?>
