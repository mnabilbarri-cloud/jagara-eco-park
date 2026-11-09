<?php
session_start();

// ✅ [KEAMANAN] Cek autentikasi admin
if (!isset($_SESSION['admin'])) {
    header("Location: ../auth/login.php");
    exit;
}

// ✅ [KEAMANAN] Hanya terima POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: data_fasilitas.php");
    exit;
}

include '../koneksi.php';

// ✅ [KEAMANAN] Validasi input wajib
if (!isset($_POST['id_fasilitas'], $_POST['nama_fasilitas'], $_POST['keterangan'])) {
    header("Location: data_fasilitas.php?error=invalid");
    exit;
}

$id         = intval($_POST['id_fasilitas']);
$nama       = trim($_POST['nama_fasilitas']);
$keterangan = trim($_POST['keterangan']);

if ($id <= 0 || empty($nama) || empty($keterangan)) {
    header("Location: data_fasilitas.php?error=empty");
    exit;
}

if (!empty($_FILES['gambar']['name'])) {
    // ✅ [KEAMANAN] Validasi MIME type dari konten file (bukan ekstensi)
    $allowed_mimes = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
    $real_mime = mime_content_type($_FILES['gambar']['tmp_name']);

    if (!in_array($real_mime, $allowed_mimes)) {
        die("Error: Tipe file tidak diizinkan. Hanya JPG, PNG, WEBP, GIF.");
    }

    if ($_FILES['gambar']['size'] > 5 * 1024 * 1024) {
        die("Error: Ukuran file terlalu besar (maks 5 MB).");
    }

    $ext_map   = ['image/jpeg'=>'jpg','image/png'=>'png','image/webp'=>'webp','image/gif'=>'gif'];
    $safe_ext  = $ext_map[$real_mime];
    $safe_name = 'fasilitas_' . time() . '_' . rand(1000, 9999) . '.' . $safe_ext;
    move_uploaded_file($_FILES['gambar']['tmp_name'], "../assets/images/" . $safe_name);

    // ✅ [KEAMANAN] UPDATE dengan gambar — Prepared Statement
    $stmt = mysqli_prepare($conn,
        "UPDATE fasilitas SET nama_fasilitas=?, keterangan=?, gambar=? WHERE id_fasilitas=?"
    );
    if (!$stmt) die("Prepare error: " . mysqli_error($conn));
    mysqli_stmt_bind_param($stmt, "sssi", $nama, $keterangan, $safe_name, $id);
} else {
    // ✅ [KEAMANAN] UPDATE tanpa gambar — Prepared Statement
    $stmt = mysqli_prepare($conn,
        "UPDATE fasilitas SET nama_fasilitas=?, keterangan=? WHERE id_fasilitas=?"
    );
    if (!$stmt) die("Prepare error: " . mysqli_error($conn));
    mysqli_stmt_bind_param($stmt, "ssi", $nama, $keterangan, $id);
}

mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

header("Location: data_fasilitas.php?success=updated");
exit;
?>
