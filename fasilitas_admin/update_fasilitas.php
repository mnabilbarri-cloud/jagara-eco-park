<?php
session_start();
// ✅ [KEAMANAN] Cek autentikasi admin
if (!isset($_SESSION['admin'])) {
    header("Location: ../auth/login.php");
    exit;
}

include '../koneksi.php';

// ✅ [KEAMANAN FIX] Validasi input wajib ada
if (!isset($_POST['id'], $_POST['nama'], $_POST['keterangan'])) {
    header("Location: data_fasilitas.php");
    exit;
}

// ✅ [KEAMANAN FIX] Dulu: $id = $_POST['id'] langsung → SQL Injection
// Sekarang: intval() untuk ID integer
$id         = intval($_POST['id']);
$nama       = trim($_POST['nama']);
$keterangan = trim($_POST['keterangan']);

// Validasi tidak boleh kosong
if (empty($nama) || empty($keterangan) || $id <= 0) {
    header("Location: data_fasilitas.php?error=invalid_input");
    exit;
}

if (!empty($_FILES['gambar']['name'])) {
    // ✅ [KEAMANAN FIX] Dulu: langsung move file tanpa validasi MIME
    // Sekarang: validasi MIME type dari file bytes, bukan nama file
    $allowed_mimes = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
    $real_mime = mime_content_type($_FILES['gambar']['tmp_name']);

    if (!in_array($real_mime, $allowed_mimes)) {
        die("Error: File gambar tidak valid! Hanya JPG, PNG, WEBP yang diperbolehkan.");
    }

    // Sanitasi nama file: hanya alfanumerik + ekstensi yang aman
    $ext_map = [
        'image/jpeg' => 'jpg',
        'image/png'  => 'png',
        'image/webp' => 'webp',
        'image/gif'  => 'gif',
    ];
    $safe_ext    = $ext_map[$real_mime];
    $safe_name   = 'fasilitas_' . time() . '_' . rand(100, 999) . '.' . $safe_ext;
    $upload_path = "../assets/images/" . $safe_name;

    move_uploaded_file($_FILES['gambar']['tmp_name'], $upload_path);

    // ✅ [KEAMANAN FIX] Prepared Statement untuk UPDATE dengan gambar
    $stmt = mysqli_prepare($conn,
        "UPDATE fasilitas SET nama_fasilitas = ?, keterangan = ?, gambar = ? WHERE id_fasilitas = ?"
    );
    if (!$stmt) die("Prepare error: " . mysqli_error($conn));

    mysqli_stmt_bind_param($stmt, "sssi", $nama, $keterangan, $safe_name, $id);
} else {
    // ✅ [KEAMANAN FIX] Prepared Statement untuk UPDATE tanpa gambar
    $stmt = mysqli_prepare($conn,
        "UPDATE fasilitas SET nama_fasilitas = ?, keterangan = ? WHERE id_fasilitas = ?"
    );
    if (!$stmt) die("Prepare error: " . mysqli_error($conn));

    mysqli_stmt_bind_param($stmt, "ssi", $nama, $keterangan, $id);
}

mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

header("Location: data_fasilitas.php");
exit;
?>
