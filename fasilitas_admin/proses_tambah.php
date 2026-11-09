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

// ✅ [KEAMANAN] Validasi input wajib ada
if (!isset($_POST['nama_fasilitas'], $_POST['keterangan'])) {
    header("Location: tambah_fasilitas.php?error=invalid");
    exit;
}

$nama       = trim($_POST['nama_fasilitas']);
$keterangan = trim($_POST['keterangan']);

// Validasi tidak boleh kosong
if (empty($nama) || empty($keterangan)) {
    header("Location: tambah_fasilitas.php?error=empty");
    exit;
}

// Validasi panjang
if (strlen($nama) > 100 || strlen($keterangan) > 1000) {
    header("Location: tambah_fasilitas.php?error=too_long");
    exit;
}

// ✅ [KEAMANAN] Validasi dan upload gambar
$gambar = 'default.jpg'; // default jika tidak upload

if (!empty($_FILES['gambar']['name'])) {
    // Validasi MIME type dari konten file (bukan ekstensi nama)
    $allowed_mimes = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
    $real_mime = mime_content_type($_FILES['gambar']['tmp_name']);

    if (!in_array($real_mime, $allowed_mimes)) {
        die("Error: Tipe file tidak diizinkan. Hanya JPG, PNG, WEBP, GIF.");
    }

    // Validasi ukuran (maks 5 MB)
    if ($_FILES['gambar']['size'] > 5 * 1024 * 1024) {
        die("Error: Ukuran file terlalu besar (maks 5 MB).");
    }

    // Buat nama file yang aman (bukan dari nama asli user — bisa path traversal)
    $ext_map = [
        'image/jpeg' => 'jpg',
        'image/png'  => 'png',
        'image/webp' => 'webp',
        'image/gif'  => 'gif',
    ];
    $safe_ext  = $ext_map[$real_mime];
    $gambar    = 'fasilitas_' . time() . '_' . rand(1000, 9999) . '.' . $safe_ext;
    $dest_path = "../assets/images/" . $gambar;

    if (!move_uploaded_file($_FILES['gambar']['tmp_name'], $dest_path)) {
        die("Error: Gagal menyimpan file gambar.");
    }
}

// ✅ [KEAMANAN] INSERT dengan Prepared Statement — cegah SQL Injection
$stmt = mysqli_prepare($conn,
    "INSERT INTO fasilitas (nama_fasilitas, keterangan, gambar) VALUES (?, ?, ?)"
);

if (!$stmt) {
    die("Prepare error: " . mysqli_error($conn));
}

mysqli_stmt_bind_param($stmt, "sss", $nama, $keterangan, $gambar);

if (mysqli_stmt_execute($stmt)) {
    mysqli_stmt_close($stmt);
    header("Location: data_fasilitas.php?success=1");
} else {
    mysqli_stmt_close($stmt);
    die("Gagal menyimpan data: " . mysqli_error($conn));
}
exit;
?>
