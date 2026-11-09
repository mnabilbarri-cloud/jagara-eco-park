<?php
include '../koneksi.php';

// ambil data fasilitas (FIX: kecuali mushola)
$q = mysqli_query($conn, "SELECT * FROM fasilitas WHERE nama_fasilitas != 'Mushola'");
if (!$q) {
    die("Query fasilitas error: " . mysqli_error($conn));
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Reservasi Jagara Eco Park</title>

<style>
body{
    background: linear-gradient(rgba(1, 103, 103, 0), rgba(18, 14, 14, 0.9)),
    url('../assets/images/hero jagara.jpg') center / cover no-repeat;
}
.box{
    width:520px;
    margin:60px auto;
    background:#fff;
    padding:35px;
    border-radius:14px;
    box-shadow:0 10px 30px rgba(0,0,0,.1);
    border: 1px solid #e0e0e0;
}
h2{
    text-align:center;
    margin-bottom:25px;
}
label{
    display:block;
    margin-top:15px;
}
input,select{
    width:100%;
    padding:12px;
    margin-top:6px;
    border-radius:8px;
    border:1px solid #ccc;
    font-size:14px;
}
button.submit-btn{
    width:100%;
    margin-top:28px;
    padding:14px;
    background:#2e7d32;
    color:#fff;
    border:none;
    border-radius:10px;
    font-size:16px;
    font-weight:bold;
    cursor:pointer;
}
.form-nav{
    margin-top:30px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:15px;
}
.nav-btn{
    flex:1;
    text-align:center;
    padding:12px;
    border-radius:10px;
    text-decoration:none;
    font-weight:bold;
    font-size:14px;
}
.btn-back{
    background:#ecf0f1;
    color:#2e7d32;
    border:2px solid #2e7d32;
}
.btn-status{
    background:#3498db;
    color:#fff;
}
.btn-back:hover{
    background:#2e7d32;
    color:#fff;
}
.btn-status:hover{
    background:#217dbb;
}
</style>
</head>

<body>

<div class="box">
    <h2>Form Reservasi</h2>

    <form method="POST" action="simpan_reservasi.php">

        <label>Nama Pengunjung</label>
        <input type="text" name="nama_pengunjung" required>

        <label>No HP (WhatsApp)</label>
        <input type="tel" name="no_hp" placeholder="08xxxxxxxxxx" pattern="[0-9]{10,15}" required>

        <label>Tanggal Kunjungan</label>
        <input type="date" name="tanggal_kunjungan" min="<?= date('Y-m-d') ?>" required>

        <label>Fasilitas</label>
        <select name="id_fasilitas" required>
            <option value="">-- Pilih Fasilitas --</option>
            <?php while($f = mysqli_fetch_assoc($q)) { ?>
                <option value="<?= $f['id_fasilitas'] ?>">
                    <?= htmlspecialchars($f['nama_fasilitas']) ?>
                </option>
            <?php } ?>
        </select>

        <label>Jumlah Tiket</label>
        <input type="number" name="jumlah_tiket" min="1" required>

        <button type="submit" class="submit-btn">
            Kirim Reservasi
        </button>
    </form>

    <div class="form-nav">
        <a href="../index.php" class="nav-btn btn-back">
            ← Kembali ke Beranda
        </a>

        <a href="status_reservasi.php" class="nav-btn btn-status">
            🔍 Cek Status Reservasi
        </a>
    </div>
</div>

</body>
</html>