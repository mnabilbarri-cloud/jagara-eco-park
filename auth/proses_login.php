<?php
session_start();

// ✅ [KEAMANAN FIX] Rate Limiting sederhana via session
// Mencegah brute force attack pada form login admin
if (!isset($_SESSION['login_attempt'])) {
    $_SESSION['login_attempt'] = 0;
    $_SESSION['login_time']    = time();
}

// Reset counter jika sudah lebih dari 15 menit
if (time() - $_SESSION['login_time'] > 900) {
    $_SESSION['login_attempt'] = 0;
    $_SESSION['login_time']    = time();
}

// Blokir jika sudah 5x gagal dalam 15 menit
if ($_SESSION['login_attempt'] >= 5) {
    $sisa = ceil((900 - (time() - $_SESSION['login_time'])) / 60);
    die("Terlalu banyak percobaan login gagal. Coba lagi dalam " . $sisa . " menit.");
}

include '../koneksi.php';

// ✅ [KEAMANAN] Hanya terima request POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: login.php");
    exit;
}

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

// ✅ [KEAMANAN] Validasi input tidak boleh kosong
if (empty($username) || empty($password)) {
    header("Location: login.php?error=1");
    exit;
}

// ✅ [KEAMANAN FIX] Dulu: "SELECT * FROM admin WHERE username='$username'"
// → SQL Injection! Misal: username: admin' OR '1'='1'-- bisa bypass login
// Sekarang: Prepared Statement, input tidak pernah dieksekusi sebagai SQL
$stmt = mysqli_prepare($conn, "SELECT id_admin, username, password FROM admin WHERE username = ?");
if (!$stmt) {
    // Log internal, jangan tampil ke user
    error_log("Prepare error: " . mysqli_error($conn));
    header("Location: login.php?error=2");
    exit;
}

mysqli_stmt_bind_param($stmt, "s", $username);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$data   = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

if ($data && password_verify($password, $data['password'])) {
    // ✅ [KEAMANAN] Login berhasil — reset counter brute force
    $_SESSION['login_attempt'] = 0;

    // ✅ [KEAMANAN] Regenerate session ID untuk mencegah Session Fixation Attack
    session_regenerate_id(true);

    // Simpan data session yang aman (hanya ID dan username, bukan seluruh row)
    $_SESSION['admin']    = $data['username'];
    $_SESSION['admin_id'] = $data['id_admin'];

    header("Location: ../admin/dashboard.php");
    exit;

} else {
    // ✅ [KEAMANAN] Tambah counter gagal
    $_SESSION['login_attempt']++;

    // Delay 1 detik untuk memperlambat brute force
    sleep(1);

    header("Location: login.php?error=1");
    exit;
}
?>
