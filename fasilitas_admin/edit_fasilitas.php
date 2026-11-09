<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: ../auth/login.php");
    exit;
}
include '../koneksi.php';

// Ambil ID dari URL dan pastikan aman
$id = mysqli_real_escape_string($conn, $_GET['id']);
$result = mysqli_query($conn, "SELECT * FROM fasilitas WHERE id_fasilitas = '$id'");
$f = mysqli_fetch_assoc($result);

if (!$f) {
    header("Location: data_fasilitas.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Fasilitas - Jagara Eco Park</title>
    <link rel="stylesheet" href="../assets/admin.css">
    <style>
        /* RESET & ANTI-BOCOR PUTIH */
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

        /* CONTAINER PERSEGI PANJANG (DILEBARKAN) */
        .container {
            margin: auto !important; 
            width: 95%;
            max-width: 850px; /* Diubah dari 600px ke 850px agar lebih persegi panjang */
            background: #fff;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
            box-sizing: border-box;
            min-height: auto !important;
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

        .form-group input[type="text"], 
        .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-sizing: border-box;
            font-family: inherit;
        }

        .current-img {
            margin-bottom: 10px;
            border-radius: 8px;
            border: 1px solid #eee;
            display: block;
            max-width: 150px; /* Sedikit diperbesar agar proporsional */
            height: auto;
            object-fit: cover;
        }

        .admin-footer-action {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }

        /* TOMBOL UPDATE TETAP HIJAU */
        .btn-update {
            background-color: #2e7d32;
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            transition: 0.3s;
        }

        .btn-update:hover {
            background-color: #1b5e20;
            transform: translateY(-2px);
        }

        /* TOMBOL BATAL JADI MERAH SOLID */
        .btn-cancel {
            text-decoration: none;
            background-color: #d32f2f; /* Merah Solid */
            color: white; /* Teks Putih agar kontras */
            padding: 12px 25px;
            border-radius: 8px;
            font-weight: bold;
            transition: 0.3s;
            display: inline-block;
        }

        .btn-cancel:hover {
            background-color: #b71c1c; /* Merah lebih gelap saat kursor menempel */
            color: white;
            box-shadow: 0 4px 12px rgba(211, 47, 47, 0.3);
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <div class="admin-header">
        <h2>Edit Fasilitas</h2>
        <a href="../auth/logout.php" class="btn-logout">Logout</a>
    </div>

    <div class="container">
        <h2 class="page-title" style="margin-top:0; text-align:center; color:#2e7d32;">Edit Data Fasilitas</h2>
        
        <form action="proses_edit.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id_fasilitas" value="<?= $f['id_fasilitas'] ?>">

            <div class="form-group">
                <label>Nama Fasilitas</label>
                <input type="text" name="nama_fasilitas" value="<?= htmlspecialchars($f['nama_fasilitas']) ?>" required>
            </div>

            <div class="form-group">
                <label>Keterangan</label>
                <textarea name="keterangan" rows="5" required><?= htmlspecialchars($f['keterangan']) ?></textarea>
            </div>

            <div class="form-group">
                <label>Gambar Saat Ini</label>
                <img src="../assets/images/<?= $f['gambar'] ?>" class="current-img" alt="Foto Fasilitas">
                
                <label style="font-size: 12px; color: #888;">Ganti Gambar (Hanya JPG, PNG, WEBP)</label>
                <input type="file" name="gambar" accept="image/png, image/jpeg, image/jpg, image/webp">
            </div>

            <div class="admin-footer-action">
                <a href="data_fasilitas.php" class="btn-cancel">
                    ← Batalkan
                </a>
                <button type="submit" name="update" class="btn-update">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</body>
</html>