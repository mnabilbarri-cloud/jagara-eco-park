<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: ../auth/login.php");
    exit;
}

include '../koneksi.php';

// AUTO REJECT 24 JAM
$query_auto_reject = "UPDATE reservasi 
SET status = 'Ditolak' 
WHERE status = 'Menunggu' 
AND created_at < DATE_SUB(NOW(), INTERVAL 24 HOUR)
AND tanggal_kunjungan <= CURDATE()";
mysqli_query($conn, $query_auto_reject);

// ✅ [KEAMANAN FIX] Whitelist filter — hanya nilai yang diizinkan diterima
// Mencegah manipulasi parameter GET yang bisa memanipulasi query
$allowed_periode = ['semua', 'hari', 'minggu', 'bulan'];
$allowed_status  = ['semua', 'menunggu', 'ditolak', 'diterima'];

$filter_waktu  = in_array($_GET['periode'] ?? 'semua', $allowed_periode)
                 ? ($_GET['periode'] ?? 'semua') : 'semua';
$filter_status = in_array($_GET['status'] ?? 'semua', $allowed_status)
                 ? ($_GET['status'] ?? 'semua') : 'semua';

// QUERY — menggunakan kondisi statis yang sudah aman (tidak ada input user di SQL)
$query_base = "SELECT r.*, f.nama_fasilitas 
               FROM reservasi r 
               JOIN fasilitas f ON r.id_fasilitas = f.id_fasilitas 
               WHERE 1=1";

// ✅ Kondisi filter menggunakan nilai literal dari whitelist, bukan dari user input
if ($filter_waktu == 'hari') {
    $query_base .= " AND DATE(r.created_at) = CURDATE()";
} elseif ($filter_waktu == 'minggu') {
    $query_base .= " AND r.created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)";
} elseif ($filter_waktu == 'bulan') {
    $query_base .= " AND MONTH(r.created_at) = MONTH(CURRENT_DATE()) 
                     AND YEAR(r.created_at) = YEAR(CURRENT_DATE())";
}

if ($filter_status == 'menunggu') {
    $query_base .= " AND r.status = 'Menunggu'";
} elseif ($filter_status == 'ditolak') {
    $query_base .= " AND r.status = 'Ditolak'";
} elseif ($filter_status == 'diterima') {
    $query_base .= " AND r.status = 'Diterima'";
}

$query_base .= " ORDER BY r.id_reservasi DESC";
$result = mysqli_query($conn, $query_base);
if (!$result) {
    die("Query Error: " . mysqli_error($conn));
}

// AMBIL DATA + HITUNG SEKALIGUS
$data = [];
$total_pax_valid = 0;
$total_pax_ditolak = 0;

while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;

    if (strtolower($row['status']) == 'diterima') {
        $total_pax_valid += $row['jumlah_tiket'];
    } elseif (strtolower($row['status']) == 'ditolak') {
        $total_pax_ditolak += $row['jumlah_tiket'];
    }
}

$total_reservasi = count($data);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Manajemen Reservasi Pro - Jagara Eco Park</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

    <link rel="stylesheet" href="../assets/admin.css">
    <style>
        body { background-color: transparent !important; margin: 0; padding: 0; min-height: 100vh; font-family: Arial, sans-serif; }
        .master-container { background: white; margin: 30px auto; padding: 30px; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.3); width: fit-content; min-width: 85%; max-width: 95%; display: block;  overflow: hidden; }
        .filter-row { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; gap: 20px; }
        .filter-group { display: flex; gap: 5px; background: #f0f0f0; padding: 5px; border-radius: 10px; }
        .btn-kembali-master { text-decoration: none; color: #2e7d32; background: white; font-weight: bold; border: 2px solid #2e7d32; padding: 10px 25px; border-radius: 8px; display: inline-block; transition: all 0.3s ease; }
        .btn-kembali-master:hover { background: #2e7d32; color: white; }
        .stat-box { color: white; padding: 10px; border-radius: 10px; min-width: 140px; display: flex; flex-direction: column; justify-content: center; align-items: center; text-align: center; }
        .stat-box small { font-size: 9px; opacity: 0.9; font-weight: bold; margin-bottom: 2px; }
        .stat-box .number { font-size: 20px; font-weight: 800; line-height: 1; }
        .badge { padding: 5px 12px; font-size: 10px; font-weight: bold; border-radius: 15px; text-transform: uppercase; border: 1px solid; }
        .menunggu { background: #fff3e0; color: #ef6c00; border-color: #ef6c00; }
        .diterima { background: #e8f5e9; color: #2e7d32; border-color: #2e7d32; }
        .ditolak { background: #ffe3e3; color: #c62828; border-color: #c62828; }
        .btn-action { cursor: pointer; padding: 4px 8px; border-radius: 4px; border: 1px solid; background: none; transition: 0.2s; }
        .btn-terima { color: #2e7d32; border-color: #2e7d32; }
        .btn-tolak { color: #c62828; border-color: #c62828; }
        .logout-link { color: white; text-decoration: none; font-weight: bold; padding: 5px 10px; border-radius: 5px; transition: 0.3s; }
        .logout-link:hover { background: #c62828; }

        .dropdown-cetak { position: relative; display: inline-block; }
        .dropdown-content { display: none; position: absolute; right: 0; background-color: #f9f9f9; min-width: 160px; box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2); z-index: 100; border-radius: 8px; }
        .dropdown-content a { color: black; padding: 12px 16px; text-decoration: none; display: block; font-size: 13px; cursor: pointer; border-bottom: 1px solid #eee; }
        .dropdown-content a:hover { background-color: #f1f1f1; }
        .dropdown-cetak:hover .dropdown-content { display: block; }

        @media print {
            body { background: white !important; }
            .master-container { box-shadow: none; border: 1px solid #ccc; width: 100%; }
            .admin-header, .filter-row, .btn-action, .btn-kembali-master, .no-print { display: none !important; }
        }
    </style>
</head>
<body class="page-data-reservasi">
    <div class="admin-header" style="background: #2e7d32; padding: 15px 5%; display: flex; justify-content: space-between; color: white; align-items: center;">
        <h3 style="margin: 0;"><i class="fas fa-tasks"></i> Manajemen Reservasi</h3>
        <a href="../auth/logout.php" class="logout-link">Logout</a>
    </div>

    <div class="master-container" id="areaLaporan">
        <div class="filter-row no-print">
            <div style="display: flex; gap: 10px;">
                <div class="filter-group" style="background: #fff; border: 1px solid #ddd; padding: 2px 8px;">
                    <i class="fas fa-calendar-alt" style="color: #2e7d32; margin-right: 5px; margin-left: 5px;"></i>
                    <select onchange="location = this.value;" style="border: none; background: transparent; padding: 8px; font-weight: bold; cursor: pointer; color: #444; outline: none;">
                        <option value="?periode=semua&status=<?= $filter_status ?>" <?= $filter_waktu == 'semua' ? 'selected' : '' ?>>Semua Waktu</option>
                        <option value="?periode=hari&status=<?= $filter_status ?>" <?= $filter_waktu == 'hari' ? 'selected' : '' ?>>📅 Hari Ini</option>
                        <option value="?periode=minggu&status=<?= $filter_status ?>" <?= $filter_waktu == 'minggu' ? 'selected' : '' ?>>📊 Minggu Ini</option>
                        <option value="?periode=bulan&status=<?= $filter_status ?>" <?= $filter_waktu == 'bulan' ? 'selected' : '' ?>>🗓️ Bulan Ini</option>
                    </select>
                </div>

                <div class="filter-group" style="background: #fff; border: 1px solid #ddd; padding: 2px 8px;">
                    <i class="fas fa-filter" style="color: #d32f2f; margin-right: 5px; margin-left: 5px;"></i>
                    <select onchange="location = this.value;" style="border: none; background: transparent; padding: 8px; font-weight: bold; cursor: pointer; color: #444; outline: none;">
                        <option value="?status=semua&periode=<?= $filter_waktu ?>" <?= $filter_status == 'semua' ? 'selected' : '' ?>>Semua Data</option>
                        <option value="?status=diterima&periode=<?= $filter_waktu ?>" <?= $filter_status == 'diterima' ? 'selected' : '' ?>>✅ Diterima</option>
                        <option value="?status=menunggu&periode=<?= $filter_waktu ?>" <?= $filter_status == 'menunggu' ? 'selected' : '' ?>>⏳ Menunggu</option>
                        <option value="?status=ditolak&periode=<?= $filter_waktu ?>" <?= $filter_status == 'ditolak' ? 'selected' : '' ?>>❌ Ditolak</option>
                    </select>
                </div>
            </div>

            <div class="dropdown-cetak">
                <button style="background: #1565c0; color: white; padding: 10px 20px; border-radius: 8px; border: none; font-size: 12px; font-weight: bold; display: flex; align-items: center; gap: 8px; cursor: pointer;">
                    <i class="fas fa-print"></i> Opsi Cetak <i class="fas fa-chevron-down"></i>
                </button>
                <div class="dropdown-content">
                    <a onclick="exportPDF()"><i class="fas fa-file-pdf" style="color:red"></i> Cetak PDF</a>
                    <a onclick="exportWord()"><i class="fas fa-file-word" style="color:blue"></i> Cetak Word</a>
                    <a onclick="exportExcel()"><i class="fas fa-file-excel" style="color:green"></i> Cetak Excel</a>
                    <a onclick="exportImage('png')"><i class="fas fa-image"></i> Cetak PNG</a>
                    <a onclick="exportImage('jpg')"><i class="fas fa-image"></i> Cetak JPG</a>
                </div>
            </div>
        </div>

        <h3 style="text-align: center; color: #2e7d32; margin-bottom: 25px;">Laporan Reservasi Pengunjung</h3>

        <table id="tabelData" width="100%" style="border-collapse: collapse; text-align: center;">
            <thead>
                <tr style="background: #2e7d32; color: white;">
                    <th style="padding: 15px;">No</th>
                    <th>Nama Pengunjung</th>
                    <th>Tanggal Kunjungan</th>
                    <th>Fasilitas</th>
                    <th>Jumlah</th>
                    <th>Status</th>
                    <th class="no-print">Aksi</th>
                </tr>
            </thead>
            <tbody>
<?php $no = 1; foreach ($data as $r): 
    $st = strtolower($r['status']);
    $badge_class = ($st == 'diterima') ? "diterima" : (($st == 'ditolak') ? "ditolak" : "menunggu");
?>
<tr style="border-bottom: 1px solid #eee;">
    <td style="padding: 15px;"><?= $no++ ?></td>
    <td><strong><?= htmlspecialchars($r['nama_pengunjung']) ?></strong></td>
    <td><?= date('d M Y', strtotime($r['tanggal_kunjungan'])) ?></td>
    <td><?= htmlspecialchars($r['nama_fasilitas']) ?></td>
    <td><?= (int)$r['jumlah_tiket'] ?> Orang</td>
    <td><span class="badge <?= $badge_class ?>"><?= $r['status'] ?></span></td>
    <td class="no-print">
        <?php if ($r['status'] == 'Menunggu') : ?>
            <button onclick="konfirmasiStatus('<?= $r['id_reservasi'] ?>', 'terima')" class="btn-action btn-terima"><i class="fas fa-check"></i></button>
            <button onclick="konfirmasiStatus('<?= $r['id_reservasi'] ?>', 'tolak')" class="btn-action btn-tolak"><i class="fas fa-times"></i></button>
        <?php else : ?>
            <span style="font-size: 11px; color: #bbb; font-style: italic;">Selesai</span>
        <?php endif; ?>
    </td>
</tr>
<?php endforeach; ?>
</tbody>
        </table>

        <div style="margin-top: 30px; display: flex; justify-content: space-between; align-items: center;">
            <a href="../admin/dashboard.php" class="btn-kembali-master no-print">← Kembali</a>
            
            <div style="display: flex; gap: 10px;">
                <div class="stat-box" style="background: #1565c0;">
                    <small>TOTAL ORANG (VALID)</small>
                    <div class="number"><?= $total_pax_valid ?></div>
                </div>
                <div class="stat-box" style="background: #c62828;">
                    <small>TOTAL ORANG (DITOLAK)</small>
                    <div class="number"><?= $total_pax_ditolak ?></div>
                </div>
                <div class="stat-box" style="background: #2e7d32;">
                    <small>TOTAL DATA TAMPIL</small>
                    <div class="number"><?= $total_reservasi ?></div>
                </div>
            </div>
        </div>
    </div>

    <script>
    function konfirmasiStatus(id, aksi) {
        Swal.fire({
            title: (aksi === 'terima' ? 'Terima Reservasi?' : 'Tolak Reservasi?'),
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: (aksi === 'terima' ? '#2e7d32' : '#d33'),
            confirmButtonText: 'Ya, Proses!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = `proses_reservasi.php?id=${id}&aksi=${aksi}`;
            }
        });
    }

    function exportPDF() {
        const element = document.getElementById('areaLaporan');
        const opt = {
            margin: 0.5,
            filename: 'Laporan_Reservasi.pdf',
            image: { type: 'jpeg', quality: 0.98 },
            html2canvas: { scale: 2, ignoreElements: (el) => el.classList.contains('no-print') },
            jsPDF: { unit: 'in', format: 'letter', orientation: 'landscape' }
        };
        html2pdf().set(opt).from(element).save();
    }

    function exportExcel() {
        var table = document.getElementById("tabelData");
        var wb = XLSX.utils.table_to_book(table, {sheet: "Data Reservasi"});
        XLSX.writeFile(wb, "Laporan_Reservasi.xlsx");
    }

    function exportWord() {
        var content = document.getElementById("areaLaporan").innerHTML;
        var style = "<style>table {border-collapse:collapse; width:100%;} th, td {border:1px solid black; padding:8px; text-align:center;} .no-print {display:none;}</style>";
        var html = "<html><head><meta charset='utf-8'></head><body>" + style + content + "</body></html>";
        
        var blob = new Blob(['\ufeff', html], { type: 'application/msword' });
        var url = URL.createObjectURL(blob);
        var link = document.createElement("a");
        link.href = url;
        link.download = "Laporan_Reservasi.doc";
        link.click();
    }

    function exportImage(format) {
        const element = document.getElementById('areaLaporan');
        html2canvas(element, {
            ignoreElements: (el) => el.classList.contains('no-print'),
            backgroundColor: "#ffffff"
        }).then(canvas => {
            var link = document.createElement('a');
            link.download = 'Laporan_Reservasi.' + format;
            link.href = canvas.toDataURL("image/" + (format === 'jpg' ? 'jpeg' : 'png'));
            link.click();
        });
    }
    </script>
    <?php if (isset($_GET['pesan']) && $_GET['pesan'] == 'berhasil'): ?>
<script>
Swal.fire({
    icon: 'success',
    title: 'Berhasil!',
    text: 'Status reservasi berhasil diperbarui'
});
</script>
<?php endif; ?>

<?php if (isset($_GET['pesan']) && $_GET['pesan'] == 'sudah_diproses'): ?>
<script>
Swal.fire({
    icon: 'info',
    title: 'Info',
    text: 'Reservasi sudah pernah diproses'
});
</script>
<?php endif; ?>
</body>
</html>