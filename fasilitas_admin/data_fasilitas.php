<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: ../auth/login.php");
    exit;
}
include '../koneksi.php';
$data = mysqli_query($conn, "SELECT * FROM fasilitas");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Fasilitas - Jagara Eco Park</title>
    <link rel="stylesheet" href="../assets/admin.css">
    <link rel="stylesheet" href="../assets/admin_table.css">
    
    <style>
        /* KODE KRITIS: Memastikan container dan tabel berada di tengah */
        body {
            display: block; /* Menghindari konflik flex dari login.css jika terbawa */
        }
        
        .container {
            margin: 40px auto !important; /* !important memaksa margin tetap di tengah */
            float: none !important;
            clear: both;
            width: 90%;
            max-width: 1200px;
        }

        .table-wrapper {
            display: block !important; /* Mengubah dari flex ke block agar margin auto bekerja */
            width: 100%;
            overflow-x: auto;
        }

        .table-admin {
            margin: 0 auto !important; /* Memaksa tabel ke tengah */
            width: 100% !important;
        }

        .admin-footer-action {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
            padding: 20px 0;
            border-top: 1px solid #eee;
        }
    </style>
</head>
<body>
    <div class="admin-header">
        <h2>Data Fasilitas</h2>
        <a href="../auth/logout.php" class="btn-logout">Logout</a>
    </div>

    <div class="container">
        <h2 class="page-title">Fasilitas Jagara Eco Park</h2>
        
        <div class="table-wrapper">
            <table class="table-admin">
                <thead>
                    <tr>
                        <th width="60">No</th>
                        <th>Nama Fasilitas</th>
                        <th>Keterangan</th>
                        <th width="140">Gambar</th>
                        <th width="160">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no=1; while($f=mysqli_fetch_assoc($data)) { ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><strong><?= htmlspecialchars($f['nama_fasilitas']) ?></strong></td>
                        <td><?= htmlspecialchars($f['keterangan']) ?></td>
                        <td>
                            <img src="../assets/images/<?= $f['gambar'] ?>" class="img-thumb" style="width: 100px; height: 70px; object-fit: cover;">
                        </td>
                        <td class="action">
                            <a href="edit_fasilitas.php?id=<?= $f['id_fasilitas'] ?>" class="link-edit">Edit</a>
                            <a href="hapus_fasilitas.php?id=<?= $f['id_fasilitas'] ?>"
                               class="link-delete"
                               onclick="return confirm('Hapus fasilitas ini?')">Hapus</a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <div class="admin-footer-action">
            <a href="../admin/dashboard.php" class="btn-secondary">
                ← Kembali ke Dashboard
            </a>
            <a href="tambah_fasilitas.php" class="btn-primary">
                + Tambah Fasilitas
            </a>
        </div>
    </div>
</body>
</html>