<?php
include 'koneksi.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Jagara Eco Park</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

<!-- ✅ TOP INFO BAR (PROFESIONAL & CLEAN) -->
<div style="
    width:100%;
    background:#1b5e20;
    color:white;
    text-align:center;
    padding:8px 10px;
    font-size:13px;
    letter-spacing:0.5px;
">
    🕘 Jam Operasional: 09.00 - 22.00 &nbsp; | &nbsp; 
    Info & Reservasi silakan klik tombol di bawah
</div>

<header class="header">
    <div class="brand">
        <img src="assets/images/logo.jpg" class="logo">
        <h1>Jagara Eco Park</h1>
    </div>
    <div class="nav-btn">
        <a href="auth/login.php" class="btn btn-outline">Login Admin</a>
    </div>
</header>

<section class="hero">
    <div class="hero-content">
        <h2>Selamat Datang di Jagara Eco Park</h2>
        <p>Aplikasi reservasi wisata berbasis web</p>
        <a href="pengunjung/reservasi.php" class="btn">
            Pesan Sekarang
        </a>
    </div>
</section>

<section class="fasilitas">
    <h2>Fasilitas & Wahana</h2>
    <div class="grid">
    <?php
        $data = mysqli_query($conn, "SELECT * FROM fasilitas");
        while ($f = mysqli_fetch_array($data)) { ?>
        <div class="card">
            <div class="img-box">
                <!-- ✅ [KEAMANAN FIX] htmlspecialchars() mencegah XSS dari data database -->
                <img src="assets/images/<?php echo htmlspecialchars($f['gambar'], ENT_QUOTES, 'UTF-8'); ?>"
                     alt="<?php echo htmlspecialchars($f['nama_fasilitas'], ENT_QUOTES, 'UTF-8'); ?>">
            </div>                   
            <h3><?php echo htmlspecialchars($f['nama_fasilitas'], ENT_QUOTES, 'UTF-8'); ?></h3>
            <p><?php echo htmlspecialchars($f['keterangan'], ENT_QUOTES, 'UTF-8'); ?></p>
        </div>
    <?php } ?>
    </div>
</section>

<section class="cta">
    <h2>Siap Berkunjung ke Jagara Eco Park?</h2>
    <p>Nikmati wisata alam dan wahana seru bersama keluarga</p>
    <a href="pengunjung/reservasi.php" class="btn">
        Reservasi Sekarang
    </a>
</section>

<footer class="footer">
    <p>&copy; <?php echo date('Y'); ?> Jagara Eco Park</p>
</footer>

</body>
</html>