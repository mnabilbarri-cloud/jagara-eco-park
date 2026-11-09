<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: ../auth/login.php");
    exit;
}
include '../koneksi.php';

// ================= FILTER WAKTU =================
$filter = isset($_GET['periode']) ? $_GET['periode'] : 'hari';

$where = "WHERE 1=1";

if ($filter == 'hari') {
    $where .= " AND DATE(created_at) = CURDATE()";
} elseif ($filter == 'minggu') {
    $where .= " AND created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)";
} elseif ($filter == 'bulan') {
    $where .= " AND MONTH(created_at)=MONTH(CURRENT_DATE()) 
                AND YEAR(created_at)=YEAR(CURRENT_DATE())";
}

// ================= OPTIMASI QUERY =================
$qFasilitas = mysqli_query($conn, "SELECT COUNT(*) as total FROM fasilitas");
$totalFasilitas = mysqli_fetch_assoc($qFasilitas)['total'];

$qReservasi = mysqli_query($conn, "SELECT COUNT(*) as total FROM reservasi $where");
$totalReservasi = mysqli_fetch_assoc($qReservasi)['total'];

// ================= STATUS =================
$qDiterima = mysqli_query($conn, "SELECT COUNT(*) as total FROM reservasi $where AND status='Diterima'");
$totalDiterima = mysqli_fetch_assoc($qDiterima)['total'];

$qMenunggu = mysqli_query($conn, "
    SELECT COUNT(*) as total FROM reservasi 
    WHERE status='Menunggu' 
    AND created_at >= DATE_SUB(NOW(), INTERVAL 24 HOUR)
");
$totalMenunggu = mysqli_fetch_assoc($qMenunggu)['total'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard Admin - Jagara Eco Park</title>
<link rel="stylesheet" href="../assets/admin.css">

<style>
/* ===== RESET & BASE LAYOUT ===== */
html, body {
    margin: 0;
    padding: 0;
    width: 100%;
    min-height: 100vh;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

body {
    background: url('../assets/images/hero jagara.jpg') no-repeat center center fixed;
    background-size: cover;
    display: flex;
    flex-direction: column;
}

/* ===== HEADER ===== */
.admin-header {
    width: 100%;
    padding: 15px 25px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color: #2d7a32;
    color: white;
    box-shadow: 0 2px 10px rgba(0,0,0,0.2);
    box-sizing: border-box;
}

.admin-header h2 {
    margin: 0;
    font-size: 1.5rem;
}

.btn-logout {
    padding: 8px 20px;
    color: white;
    text-decoration: none;
    border: 1px solid white;
    border-radius: 5px;
    transition: 0.3s;
    font-weight: 500;
}

.btn-logout:hover {
    background-color: #d32f2f;
    border-color: #d32f2f;
}

/* ===== CONTAINER ===== */
.container {
    margin: 40px auto !important; 
    width: 90%;
    max-width: 850px;
    background: rgba(255, 255, 255, 0.96);
    padding: 40px;
    border-radius: 20px;
    box-shadow: 0 15px 35px rgba(0,0,0,0.4);
}

.page-title {
    text-align: center;
    margin-bottom: 30px;
    color: #2d7a32;
    font-weight: 700;
}

/* ===== FILTER BOX ===== */
.filter-box {
    display: flex;
    justify-content: center;
    gap: 10px;
    margin-bottom: 30px;
    flex-wrap: wrap;
}

.filter-box a {
    text-decoration: none;
    padding: 8px 18px;
    border-radius: 20px;
    font-size: 13px;
    border: 1px solid #2d7a32;
    color: #2d7a32 !important;
    background: white !important;
    transition: 0.3s;
    font-weight: 600;
}

.filter-box a:hover, .filter-box a.active-filter {
    background: #2d7a32 !important;
    color: white !important;
}

/* ===== STATISTICS CARDS (Pembaruan Warna Akses) ===== */
.stat-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    margin-bottom: 20px;
}

.stat-card {
    color: white;
    padding: 25px 15px;
    border-radius: 15px;
    text-align: center;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

/* Warna Baru untuk Fasilitas (Teal/Emerald modern) */
.bg-fasilitas {
    background: linear-gradient(135deg, #00897b, #00695c);
}

/* Warna Baru untuk Total Reservasi (Indigo/Blue modern) */
.bg-reservasi {
    background: linear-gradient(135deg, #3f97f4, #046fe2);
}

/* Warna Reservasi Diterima (Sukses/Hijau Luar Biasa) */
.bg-diterima {
    background: linear-gradient(135deg, #d85757, #f70303);
}

/* Warna Menunggu (Amber/Orange modern) */
.bg-menunggu {
    background: linear-gradient(135deg, #e29c41, #ff6f00);
}

.stat-card h4 {
    margin: 0 0 10px 0;
    font-weight: 500;
    text-transform: uppercase;
    font-size: 0.85rem;
    letter-spacing: 1px;
    opacity: 0.9;
}

.stat-card span {
    font-size: 2.8rem;
    font-weight: 800;
    display: block;
}

/* ===== NAVIGATION CARDS ===== */
.dashboard-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 25px;
    margin-top: 20px;
}

.dashboard-card {
    background: #ffffff;
    padding: 35px 25px;
    border-radius: 15px;
    text-align: center;
    border: 1px solid #e0e0e0;
    box-shadow: 0 4px 6px rgba(0,0,0,0.05);
}

.dashboard-card h3 {
    margin: 0 0 25px 0;
    color: #333;
    font-size: 1.3rem;
}

.btn-primary {
    display: inline-block;
    padding: 12px 35px;
    background-color: #2d7a32;
    color: white;
    text-decoration: none;
    border-radius: 8px;
    font-weight: 600;
    transition: 0.3s;
}

.btn-primary:hover {
    background-color: #1e5222;
    transform: translateY(-2px);
}

@media (max-width: 600px) {
    .stat-grid, .dashboard-grid {
        grid-template-columns: 1fr;
    }
}
</style>
</head>

<body>

<div class="admin-header">
    <h2>Dashboard Admin</h2>
    <a href="../auth/logout.php" class="btn-logout">Logout</a>
</div>

<div class="container">
    <h2 class="page-title">Dashboard Jagara Eco Park</h2>

    <div class="filter-box">
        <a href="?periode=hari" class="<?= $filter=='hari'?'active-filter':'' ?>">Hari Ini</a>
        <a href="?periode=minggu" class="<?= $filter=='minggu'?'active-filter':'' ?>">7 Hari</a>
        <a href="?periode=bulan" class="<?= $filter=='bulan'?'active-filter':'' ?>">Bulan Ini</a>
        <a href="?periode=semua" class="<?= $filter=='semua'?'active-filter':'' ?>">Semua Data</a>
    </div>

    <div class="stat-grid">
        <div class="stat-card bg-fasilitas">
            <h4>Total Fasilitas</h4>
            <span><?= $totalFasilitas ?></span>
        </div>
        <div class="stat-card bg-reservasi">
            <h4>Total Reservasi</h4>
            <span><?= $totalReservasi ?></span>
        </div>
    </div>

    <div class="stat-grid">
        <div class="stat-card bg-diterima">
            <h4>Reservasi Diterima</h4>
            <span><?= $totalDiterima ?></span>
        </div>
        <div class="stat-card bg-menunggu">
            <h4>Menunggu (&lt;24 Jam)</h4>
            <span><?= $totalMenunggu ?></span>
        </div>
    </div>

    <div class="dashboard-grid">
        <div class="dashboard-card">
            <h3>Kelola Fasilitas</h3>
            <a href="../fasilitas_admin/data_fasilitas.php" class="btn-primary">Buka</a>
        </div>

        <div class="dashboard-card">
            <h3>Data Reservasi</h3>
            <a href="../reservasi_admin/data_reservasi.php" class="btn-primary">Buka</a>
        </div>
    </div>

</div>

</body>
</html>