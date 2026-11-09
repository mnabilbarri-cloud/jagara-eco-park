<?php
// Coba koneksi ke database jagara_framework_db (sesuai database aktif di XAMPP/phpMyAdmin)
$db_name = "jagara_framework_db";
$conn = @mysqli_connect("127.0.0.1", "root", "", $db_name);

if (!$conn) {
    $conn = @mysqli_connect("127.0.0.1", "root", "", "jagara_db");
}

if (!$conn) {
    $conn = @mysqli_connect("localhost", "root", "", $db_name) ?: @mysqli_connect("localhost", "root", "", "jagara_db");
}

if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

date_default_timezone_set('Asia/Jakarta');
?>
