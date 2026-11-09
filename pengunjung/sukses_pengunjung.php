<?php
if (!isset($_GET['kode'])) {
    die("Kode tidak ditemukan!");
}
$kode = $_GET['kode'];
?>

<h3 style="margin-top:20px;">QR Code Reservasi Anda</h3>

<p>Silakan scan QR ini saat datang ke lokasi:</p>

<img src="qr.php?kode=<?= $kode ?>" 
     style="width:200px; height:200px; border:1px solid #ccc; padding:10px; border-radius:10px;">

<p style="margin-top:10px; font-size:14px; color:#555;">
    Atau buka link ini:<br>
    <a href="qr.php?kode=<?= $kode ?>" target="_blank">
        Lihat QR Code
    </a>
</p>