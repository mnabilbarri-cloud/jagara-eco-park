<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: ../auth/login.php");
    exit;
}
include '../koneksi.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Fasilitas - Jagara Eco Park</title>
    <link rel="stylesheet" href="../assets/admin.css">
    <style>
        /* CSS KHUSUS UNTUK MENGHILANGKAN PUTIH DI BAWAH & SCROLL HORIZONTAL */
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
            background-color: #1a1a1a;
        }

        body {
            background: url('../assets/images/hero jagara.jpg') no-repeat center center fixed;
            background-size: cover !important; 
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .container {
            margin: auto !important;
            width: 90%;
            max-width: 600px;
            background: #fff;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
            box-sizing: border-box;
        }

        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #333;
        }

        .form-group input, .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-sizing: border-box;
        }

        .admin-footer-action {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }

        .btn-simpan {
            background-color: #2e7d32;
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            transition: 0.3s;
        }

        .btn-simpan:hover {
            background-color: #1b5e20;
        }
    </style>
</head>
<body>

    <div class="admin-header">
        <h2>Tambah Fasilitas</h2>
        <a href="../auth/logout.php" class="btn-logout">Logout</a>
    </div>

    <div class="container">
        <h2 class="page-title" style="margin-top:0;">Form Tambah Fasilitas</h2>
        
        <form action="proses_tambah.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label>Nama Fasilitas</label>
                <input type="text" name="nama_fasilitas" placeholder="Masukkan nama fasilitas" required>
            </div>

            <div class="form-group">
                <label>Keterangan</label>
                <textarea name="keterangan" rows="4" placeholder="Deskripsi fasilitas" required></textarea>
            </div>

            <div class="form-group">
                <label>Gambar Fasilitas</label>
                <!-- INI YANG DIPERBAIKI -->
                <input type="file" name="gambar" accept="image/png, image/jpeg, image/jpg" required>
            </div>

            <div class="admin-footer-action">
                <a href="data_fasilitas.php" class="btn-secondary" style="text-decoration:none;">
                    ← Kembali
                </a>
                <button type="submit" name="submit" class="btn-simpan">
                    Simpan Fasilitas
                </button>
            </div>
        </form>
    </div>

</body>
</html>