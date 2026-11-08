<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Reservasi - Jagara Eco Park</title>
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html-to-image/1.11.1/html-to-image.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/admin.css') }}">

    <style>
        /* Extra styles for reservation page */
        .dropdown { position: relative; display: inline-block; }
        .btn-dropdown {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            padding: 12px 24px;
            border-radius: 12px;
            border: none;
            font-weight: 700;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: all 0.2s ease;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.35);
        }
        .btn-dropdown:hover { transform: translateY(-2px); filter: brightness(1.05); }

        .dropdown-content {
            display: none;
            position: absolute;
            right: 0;
            background: white;
            min-width: 240px;
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
            z-index: 1000;
            border-radius: 12px;
            margin-top: 8px;
            overflow: hidden;
            border: 1px solid var(--slate-200);
        }
        .dropdown-content.show { display: block; animation: fadeIn 0.2s ease; }
        .dropdown-content a {
            color: var(--slate-700);
            padding: 14px 20px;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 14px;
            font-weight: 600;
            transition: background 0.2s ease;
            border-bottom: 1px solid var(--slate-100);
        }
        .dropdown-content a:hover { background: var(--slate-50); color: var(--primary); }
        .dropdown-content a:last-child { border-bottom: none; }

        @keyframes fadeIn { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }

        .page-header-actions { display: flex; gap: 12px; }

        .custom-select {
            padding: 12px 18px;
            border-radius: 10px;
            border: 1px solid var(--slate-300);
            background: white;
            font-size: 14px;
            font-weight: 600;
            color: var(--slate-700);
            cursor: pointer;
            transition: border-color 0.2s ease;
        }
        .custom-select:focus { outline: none; border-color: var(--primary); }

        .data-table { width: 100%; border-collapse: separate; border-spacing: 0; }
        .data-table thead th {
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            color: #e2e8f0;
            padding: 16px 18px;
            text-align: center;
            font-weight: 700;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.7px;
            border-right: 1px solid rgba(51, 65, 85, 0.5);
        }
        .data-table thead th:last-child {
            border-right: none;
        }
        .data-table thead th:first-child { border-radius: 16px 0 0 0; }
        .data-table thead th:last-child { border-radius: 0 16px 0 0; }

        .data-table tbody td {
            padding: 16px 18px;
            border-bottom: 1px solid #e2e8f0;
            border-right: 1px solid #e2e8f0;
            background: white;
            color: #334155;
            vertical-align: middle;
            font-size: 14px;
            white-space: nowrap;
            text-align: center;
        }
        .data-table tbody td:last-child {
            border-right: none;
        }
        .data-table tbody tr:hover td { background: #f8fafc; }
        .data-table tbody tr:last-child td:first-child { border-radius: 0 0 0 16px; }
        .data-table tbody tr:last-child td:last-child { border-radius: 0 0 16px 0; }

        .visitor-name {
            color: var(--slate-900) !important;
            font-weight: 700;
            font-size: 14px;
        }

        .btn-preview-bukti {
            width: 48px;
            height: 48px;
            object-fit: cover;
            border-radius: 10px;
            border: 2px solid var(--slate-200);
            cursor: pointer;
            transition: all 0.2s ease;
        }
        .btn-preview-bukti:hover { transform: scale(1.05); border-color: var(--primary); }

        .badge {
            padding: 6px 14px;
            border-radius: 100px;
            font-size: 12px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .badge-diterima { background: #e0f2fe; color: #0ea5e9; }
        .badge-menunggu { background: #FFF7ED; color: #F59E0B; }
        .badge-ditolak { background: #ffebee; color: #c62828; }

        .btn-action {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 10px;
            border: 1px solid transparent;
            cursor: pointer;
            transition: all 0.2s ease;
            font-size: 15px;
            margin: 2px 4px;
            text-decoration: none;
        }
        .btn-action:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1); }

        .btn-terima {
            background: #e0f2fe;
            color: #0ea5e9;
            border-color: rgba(15, 118, 110, 0.2);
        }
        .btn-terima:hover {
            background: #0ea5e9;
            color: white;
            border-color: #0ea5e9;
        }

        .btn-tolak {
            background: #ffebee;
            color: #c62828;
            border-color: rgba(198, 40, 40, 0.2);
        }
        .btn-tolak:hover {
            background: #c62828;
            color: white;
            border-color: #c62828;
        }

        .btn-cetak {
            background: #dbeafe;
            color: #1d4ed8;
            border-color: rgba(37, 99, 235, 0.2);
        }
        .btn-cetak:hover {
            background: #1d4ed8;
            color: white;
            border-color: #1d4ed8;
        }

        .btn-disabled {
            background: var(--slate-100) !important;
            color: var(--slate-400) !important;
            border-color: var(--slate-300) !important;
            cursor: not-allowed !important;
            box-shadow: none !important;
        }
        .btn-disabled:hover { transform: none !important; }

        .stats-summary { display: flex; gap: 16px; }
        .stat-item {
            padding: 20px 28px;
            background: white;
            border-radius: 12px;
            border: 1px solid var(--slate-200);
        }

        @media print {
            .no-print, .sidebar, .admin-header, .btn-dropdown, .dropdown, .btn-print-action, #backButton { display: none !important; }
            .main-content { margin-left: 0; width: 100%; }
            .master-container { width: 100%; }
        }
    </style>
</head>
<body>

<div class="admin-layout">
    @include('sidebar')

    <!-- Main Content -->
    <main class="main-content">
        <div class="master-container" id="reportArea">
            <!-- Export Header (Hidden by Default) -->
            <div id="exportHeader" style="display:none; text-align:center; margin-bottom:30px;">
                <h1 style="margin:0; color: var(--primary); font-size: 28px; font-weight: 800;">JAGARA ECO PARK</h1>
                <h3 style="margin:8px 0; color: var(--slate-600); font-size: 16px; font-weight: 600;">Laporan Rekapitulasi Reservasi Pengunjung</h3>
                <p style="margin:0; color: var(--slate-500);">Tanggal Unduh: <span id="downloadDate"></span></p>
                <div style="height: 3px; background: linear-gradient(90deg, var(--primary) 0%, var(--secondary) 100%); margin-top: 20px; border-radius: 2px;"></div>
            </div>

            <!-- Page Header -->
            <div class="page-header no-print">
                <div class="page-header-text">
                    <h1 class="page-title">Manajemen Reservasi</h1>
                    <p class="page-subtitle">Kelola dan konfirmasi semua reservasi pengunjung Jagara Eco Park</p>
                </div>
                <div class="page-header-actions">
                    <div style="display: flex; gap: 12px;">
                        <select class="custom-select" onchange="applyFilter('periode', this.value);">
                            <option value="semua" {{ $filter_waktu == 'semua' ? 'selected' : '' }}>📅 Semua Waktu</option>
                            <option value="hari" {{ $filter_waktu == 'hari' ? 'selected' : '' }}>Hari Ini</option>
                            <option value="minggu" {{ $filter_waktu == 'minggu' ? 'selected' : '' }}>1 Minggu</option>
                            <option value="bulan" {{ $filter_waktu == 'bulan' ? 'selected' : '' }}>Bulan Ini</option>
                            <option value="bulan_lalu" {{ $filter_waktu == 'bulan_lalu' ? 'selected' : '' }}>Bulan Kemarin</option>
                        </select>
                        <select class="custom-select" onchange="applyFilter('status', this.value);">
                            <option value="semua" {{ $filter_status == 'semua' ? 'selected' : '' }}>🔍 Semua Status</option>
                            <option value="menunggu" {{ $filter_status == 'menunggu' ? 'selected' : '' }}>Menunggu Konfirmasi</option>
                            <option value="diterima" {{ $filter_status == 'diterima' ? 'selected' : '' }}>Diterima</option>
                            <option value="ditolak" {{ $filter_status == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                    </div>
                    <div class="dropdown">
                        <button class="btn-dropdown" onclick="toggleDropdown(event)">
                            <i class="fas fa-file-export"></i> EKSPOR DATA <i class="fas fa-caret-down"></i>
                        </button>
                        <div id="myDropdown" class="dropdown-content">
                            <a href="javascript:void(0)" onclick="exportPDF()"><i class="fas fa-file-pdf" style="color: #ef4444; font-size: 18px;"></i> Simpan PDF</a>
                            <a href="javascript:void(0)" onclick="exportExcel()"><i class="fas fa-file-excel" style="color: #10b981; font-size: 18px;"></i> Simpan Excel</a>
                            <a href="javascript:void(0)" onclick="exportWord()"><i class="fas fa-file-word" style="color: #3b82f6; font-size: 18px;"></i> Simpan Word</a>
                            <a href="javascript:void(0)" onclick="exportImage('png')"><i class="fas fa-image" style="color: #f59e0b; font-size: 18px;"></i> Simpan PNG</a>
                            <a href="javascript:void(0)" onclick="exportImage('jpg')"><i class="fas fa-image" style="color: #d97706; font-size: 18px;"></i> Simpan JPG</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Title for Report -->
            <div id="mainTitle" style="text-align: center; margin-bottom: 30px;">
                <h2 style="margin: 0; color: var(--slate-800); font-weight: 700; font-size: 20px; text-transform: uppercase; letter-spacing: 1px;">Laporan Reservasi Pengunjung</h2>
            </div>

            <!-- Table -->
            <div class="widget-card" style="padding: 0;">
                <div style="overflow-x: auto;">
                    <table class="data-table" id="tabelData">
                        <thead>
                            <tr>
                                <th style="width: 60px; text-align: center;">NO</th>
                                <th style="width: 240px;">NAMA PENGUNJUNG</th>
                                <th style="width: 140px;">TANGGAL KUNJUNGAN</th>
                                <th style="width: 180px;">FASILITAS</th>
                                <th style="width: 160px;">TOTAL BAYAR</th>
                                <th style="width: 100px; text-align: center;">BUKTI</th>
                                <th style="width: 140px; text-align: center;">STATUS</th>
                                <th class="no-print" style="width: 180px; text-align: center;">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $index => $r)
                            <tr>
                                <td style="text-align: center; font-weight: 700; color: var(--slate-500);">{{ $index + 1 }}</td>
                                <td>
                                    <div class="visitor-name">{{ $r->nama_pengunjung }}</div>
                                    <div style="font-size: 12px; color: var(--slate-500); margin-top: 4px;">ID: {{ $r->kode_reservasi }}</div>
                                </td>
                                <td style="font-weight: 600;">{{ date('d M Y', strtotime($r->tanggal_kunjungan)) }}</td>
                                <td style="font-weight: 600;">{{ $r->fasilitas->nama_fasilitas ?? '-' }}</td>
                                <td style="font-weight: 800; color: var(--accent);">Rp {{ number_format($r->total_bayar, 0, ',', '.') }}</td>
                                <td style="text-align: center;">
                                    @if($r->bukti_pembayaran)
                                        <img src="{{ asset('assets/images/bukti_bayar/' . $r->bukti_pembayaran) }}" class="btn-preview-bukti" data-url="{{ asset('assets/images/bukti_bayar/' . $r->bukti_pembayaran) }}" data-nama="{{ $r->nama_pengunjung }}" onclick="showBukti(this.dataset.url, this.dataset.nama)">
                                    @else
                                        <span style="font-size: 12px; color: var(--slate-400);">Tidak Ada</span>
                                    @endif
                                </td>
                                <td style="text-align: center;">
                                    <span class="badge @if(strtolower($r->status) == 'diterima') badge-diterima @elseif(strtolower($r->status) == 'ditolak') badge-ditolak @else badge-menunggu @endif">
                                        {{ $r->status }}
                                    </span>
                                </td>
                                <td class="no-print" style="text-align: center;">
                                    @if($r->status == 'Diterima')
                                        <a href="{{ route('reservasi.nota', $r->kode_reservasi) }}" target="_blank" class="btn-action btn-cetak" title="Cetak Nota">
                                            <i class="fas fa-print"></i>
                                        </a>
                                    @elseif($r->status == 'Menunggu')
                                        @if(!empty($r->bukti_pembayaran))
                                            <button onclick="konfirmasiStatus('{{ $r->id_reservasi }}', 'terima')" class="btn-action btn-terima" title="Terima">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        @else
                                            <button class="btn-action btn-disabled" title="Bukti Bayar Belum Ada" onclick="Swal.fire('Perhatian','Pengunjung belum upload bukti bayar!','info')">
                                                <i class="fas fa-hourglass-half"></i>
                                            </button>
                                        @endif
                                        <button onclick="konfirmasiStatus('{{ $r->id_reservasi }}', 'tolak')" class="btn-action btn-tolak" title="Tolak">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    @else
                                        <span style="color: var(--slate-400); font-size: 12px;">-</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Back Button and Stats -->
            <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-top: 32px;">
                <div class="no-print" id="backButton">
                    <a href="{{ route('dashboard') }}" class="btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
                    </a>
                </div>
                
                <div class="stats-summary">
                    <div style="display: flex; gap: 16px;">
                        <div class="widget-card" style="padding: 20px 28px; margin-bottom: 0;">
                            <div style="font-size: 12px; color: var(--slate-500); font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">Total Valid</div>
                            <div style="font-size: 24px; font-weight: 800; color: var(--primary);">{{ $data->where('status', 'Diterima')->count() }}</div>
                        </div>
                        <div class="widget-card" style="padding: 20px 28px; margin-bottom: 0;">
                            <div style="font-size: 12px; color: var(--slate-500); font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">Total Ditolak</div>
                            <div style="font-size: 24px; font-weight: 800; color: var(--danger);">{{ $data->where('status', 'Ditolak')->count() }}</div>
                        </div>
                        <div class="widget-card" style="padding: 20px 28px; margin-bottom: 0;">
                            <div style="font-size: 12px; color: var(--slate-500); font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">Total Data</div>
                            <div style="font-size: 24px; font-weight: 800; color: var(--accent);">{{ $data->count() }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<script>
    function showBukti(url, nama) {
        Swal.fire({
            title: 'Bukti Pembayaran: ' + nama,
            imageUrl: url,
            imageAlt: 'Bukti Pembayaran',
            width: 600,
            confirmButtonText: 'Tutup',
            confirmButtonColor: '#3b82f6'
        });
    }

    function konfirmasiStatus(id, aksi) {
        Swal.fire({
            title: (aksi === 'terima' ? 'Terima Reservasi?' : 'Tolak Reservasi?'),
            text: "Tindakan ini akan mengubah status reservasi pengunjung secara permanen.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: (aksi === 'terima' ? '#10b981' : '#ef4444'),
            confirmButtonText: 'Ya, Proses!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = `/proses-reservasi/${id}/${aksi}`;
            }
        });
    }

    function toggleDropdown(e) {
        e.stopPropagation();
        document.getElementById("myDropdown").classList.toggle("show");
    }

    window.onclick = function(event) {
        if (!event.target.matches('.btn-dropdown') && !event.target.matches('.btn-dropdown *')) {
            var d = document.getElementById("myDropdown");
            if (d && d.classList.contains('show')) d.classList.remove('show');
        }
    }

    function prepareForExport() {
        document.getElementById('downloadDate').innerText = new Date().toLocaleString('id-ID');
        document.getElementById('exportHeader').style.display = 'block';
        document.getElementById('mainTitle').style.display = 'none';
        document.querySelectorAll('.no-print').forEach(el => {
            el.style.display = 'none';
        });
    }

    function resetAfterExport() {
        document.getElementById('exportHeader').style.display = 'none';
        document.getElementById('mainTitle').style.display = 'block';
        document.querySelectorAll('.no-print').forEach(el => {
            el.style.display = '';
        });
    }

    function exportPDF() {
        let date = new Date().toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
        
        let pdfContainer = document.createElement("div");
        pdfContainer.style.padding = "40px";
        pdfContainer.style.background = "#ffffff";
        pdfContainer.style.fontFamily = "'Inter', 'Segoe UI', Roboto, sans-serif";
        pdfContainer.style.color = "#1e293b";
        pdfContainer.style.width = "1050px";
        pdfContainer.style.boxSizing = "border-box";
        
        pdfContainer.innerHTML = `
            <div style="text-align: center; margin-bottom: 30px;">
                <h1 style="margin:0 0 5px 0; color: #3b82f6; font-size: 28px; font-weight: 800; letter-spacing: 1.5px; text-transform: uppercase;">Jagara Eco Park</h1>
                <h3 style="margin:0 0 8px 0; color: #475569; font-size: 16px; font-weight: 600;">Laporan Rekapitulasi Reservasi Pengunjung</h3>
                <p style="margin:0; color: #64748b; font-size: 12px; font-weight: 500;">Dicetak pada: ${date}</p>
                <div style="height: 4px; background: linear-gradient(90deg, #3b82f6 0%, #6366f1 100%); margin-top: 20px; border-radius: 2px;"></div>
            </div>
        `;
        
        let tableHtml = `
            <table style="width: 100%; border-collapse: collapse; margin-top: 20px; font-size: 13px; border: 1px solid #e2e8f0;">
                <thead>
                    <tr style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); color: white;">
                        <th style="padding: 14px 10px; border: 1px solid #334155; text-align: center; font-weight: 700; width: 6%; font-size: 12px; text-transform: uppercase;">NO</th>
                        <th style="padding: 14px 12px; border: 1px solid #334155; text-align: left; font-weight: 700; width: 34%; font-size: 12px; text-transform: uppercase;">NAMA PENGUNJUNG</th>
                        <th style="padding: 14px 10px; border: 1px solid #334155; text-align: center; font-weight: 700; width: 14%; font-size: 12px; text-transform: uppercase;">TANGGAL</th>
                        <th style="padding: 14px 12px; border: 1px solid #334155; text-align: left; font-weight: 700; width: 18%; font-size: 12px; text-transform: uppercase;">FASILITAS</th>
                        <th style="padding: 14px 12px; border: 1px solid #334155; text-align: right; font-weight: 700; width: 14%; font-size: 12px; text-transform: uppercase;">TOTAL BAYAR</th>
                        <th style="padding: 14px 10px; border: 1px solid #334155; text-align: center; font-weight: 700; width: 14%; font-size: 12px; text-transform: uppercase;">STATUS</th>
                    </tr>
                </thead>
                <tbody>
        `;
        
        let originalRows = document.querySelectorAll("#tabelData tbody tr");
        originalRows.forEach((row, index) => {
            let name = row.querySelector(".visitor-name") ? row.querySelector(".visitor-name").innerText.trim() : "";
            let id = row.querySelector("small") ? row.querySelector("small").innerText.replace("ID:", "").trim() : "";
            let tanggal = row.cells[2].innerText.trim();
            let fasilitas = row.cells[3].innerText.trim();
            let total = row.cells[4].innerText.trim();
            let status = row.querySelector(".badge") ? row.querySelector(".badge").innerText.trim() : "";
            
            let statusBg, statusColor;
            if (status.toLowerCase() === 'diterima') { statusBg = "#e0f2fe"; statusColor = "#0ea5e9"; }
            else if (status.toLowerCase() === 'ditolak') { statusBg = "#ffebee"; statusColor = "#c62828"; }
            else { statusBg = "#FFF7ED"; statusColor = "#F59E0B"; }
            
            let rowBg = index % 2 === 1 ? "#f8fafc" : "#ffffff";
            
            tableHtml += `
                <tr style="background-color: ${rowBg};">
                    <td style="padding: 12px 10px; border: 1px solid #e2e8f0; text-align: center; color: #64748b;">${index + 1}</td>
                    <td style="padding: 12px 12px; border: 1px solid #e2e8f0; text-align: left;">
                        <div style="color: #0f172a; font-size: 13.5px; font-weight: 700;">${name}</div>
                        <div style="color: #64748b; font-size: 11px; margin-top: 4px;">ID: ${id}</div>
                    </td>
                    <td style="padding: 12px 10px; border: 1px solid #e2e8f0; text-align: center; color: #334155; font-weight: 600;">${tanggal}</td>
                    <td style="padding: 12px 12px; border: 1px solid #e2e8f0; color: #334155; font-weight: 600;">${fasilitas}</td>
                    <td style="padding: 12px 12px; border: 1px solid #e2e8f0; text-align: right; font-weight: 800; color: #f59e0b;">${total}</td>
                    <td style="padding: 12px 10px; border: 1px solid #e2e8f0; text-align: center;">
                        <span style="display: inline-block; padding: 6px 14px; border-radius: 100px; font-size: 11px; font-weight: 700; background-color: ${statusBg}; color: ${statusColor}; text-transform: uppercase; letter-spacing: 0.5px;">${status}</span>
                    </td>
                </tr>
            `;
        });
        
        tableHtml += `</tbody></table>`;
        pdfContainer.innerHTML += tableHtml;
        
        // Add Stats
        let totalValid = "{{ $data->where('status', 'Diterima')->count() }}";
        let totalDitolak = "{{ $data->where('status', 'Ditolak')->count() }}";
        let totalData = "{{ $data->count() }}";
        
        pdfContainer.innerHTML += `
            <div style="margin-top: 35px; display: flex; justify-content: flex-end; gap: 20px; align-items: center;">
                <div style="background-color: #f8fafc; border: 1px solid #e2e8f0; padding: 16px 28px; border-radius: 12px; text-align: center; min-width: 140px; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
                    <small style="color: #64748b; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 4px;">Total Valid</small>
                    <span style="font-size: 24px; font-weight: 800; color: #3b82f6;">${totalValid}</span>
                </div>
                <div style="background-color: #f8fafc; border: 1px solid #e2e8f0; padding: 16px 28px; border-radius: 12px; text-align: center; min-width: 140px; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
                    <small style="color: #64748b; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 4px;">Total Ditolak</small>
                    <span style="font-size: 24px; font-weight: 800; color: #ef4444;">${totalDitolak}</span>
                </div>
                <div style="background-color: #f8fafc; border: 1px solid #e2e8f0; padding: 16px 28px; border-radius: 12px; text-align: center; min-width: 140px; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
                    <small style="color: #64748b; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 4px;">Total Data</small>
                    <span style="font-size: 24px; font-weight: 800; color: #f59e0b;">${totalData}</span>
                </div>
            </div>
        `;
        
        const opt = {
            margin: [0.4, 0.4, 0.4, 0.4],
            filename: 'Laporan_Reservasi_Jagara.pdf',
            image: { type: 'jpeg', quality: 1 },
            html2canvas: { scale: 2.5, useCORS: true, logging: false },
            jsPDF: { unit: 'in', format: 'a4', orientation: 'landscape' }
        };
        
        html2pdf().set(opt).from(pdfContainer).save();
    }

    function exportExcel() {
        let virtualTable = document.createElement("table");
        
        let headers = ["NO", "NAMA PENGUNJUNG", "ID RESERVASI", "TANGGAL KUNJUNGAN", "FASILITAS WISATA", "TOTAL BAYAR", "STATUS"];
        let thead = document.createElement("thead");
        let headerRow = document.createElement("tr");
        headers.forEach(h => {
            let th = document.createElement("th");
            th.innerText = h;
            headerRow.appendChild(th);
        });
        thead.appendChild(headerRow);
        virtualTable.appendChild(thead);
        
        let tbody = document.createElement("tbody");
        let originalRows = document.querySelectorAll("#tabelData tbody tr");
        
        originalRows.forEach((row, index) => {
            let tr = document.createElement("tr");
            
            let tdNo = document.createElement("td");
            tdNo.innerText = index + 1;
            tr.appendChild(tdNo);
            
            let tdNama = document.createElement("td");
            let nameEl = row.querySelector(".visitor-name");
            tdNama.innerText = nameEl ? nameEl.innerText.trim() : "";
            tr.appendChild(tdNama);
            
            let tdId = document.createElement("td");
            let idEl = row.querySelector("small");
            tdId.innerText = idEl ? idEl.innerText.replace("ID:", "").trim() : "";
            tr.appendChild(tdId);
            
            let tdTgl = document.createElement("td");
            tdTgl.innerText = row.cells[2].innerText.trim();
            tr.appendChild(tdTgl);
            
            let tdFas = document.createElement("td");
            tdFas.innerText = row.cells[3].innerText.trim();
            tr.appendChild(tdFas);
            
            let tdBayar = document.createElement("td");
            let rawBayar = row.cells[4].innerText.replace(/[^\d]/g, "");
            tdBayar.innerText = rawBayar ? parseInt(rawBayar) : 0;
            tr.appendChild(tdBayar);
            
            let tdStatus = document.createElement("td");
            let badgeEl = row.querySelector(".badge");
            tdStatus.innerText = badgeEl ? badgeEl.innerText.trim() : "";
            tr.appendChild(tdStatus);
            
            tbody.appendChild(tr);
        });
        virtualTable.appendChild(tbody);
        
        let wb = XLSX.utils.table_to_book(virtualTable, {sheet: "Rekap Reservasi"});
        XLSX.writeFile(wb, "Laporan_Reservasi_Jagara.xlsx");
    }

    function exportWord() {
        let date = new Date().toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
        
        let tableRowsHtml = "";
        let originalRows = document.querySelectorAll("#tabelData tbody tr");
        
        originalRows.forEach((row, index) => {
            let name = row.querySelector(".visitor-name") ? row.querySelector(".visitor-name").innerText.trim() : "";
            let id = row.querySelector("small") ? row.querySelector("small").innerText.replace("ID:", "").trim() : "";
            let tanggal = row.cells[2].innerText.trim();
            let fasilitas = row.cells[3].innerText.trim();
            let total = row.cells[4].innerText.trim();
            let status = row.querySelector(".badge") ? row.querySelector(".badge").innerText.trim() : "";
            
            let statusStyle = "";
            if (status.toLowerCase() === 'diterima') statusStyle = "background-color: #e0f2fe; color: #0ea5e9; border: 1px solid #bae6fd;";
            else if (status.toLowerCase() === 'ditolak') statusStyle = "background-color: #fee2e2; color: #991b1b; border: 1px solid #fecaca;";
            else statusStyle = "background-color: #FFF7ED; color: #f59e0b; border: 1px solid #fed7aa;";
            
            tableRowsHtml += `
                <tr>
                    <td style="text-align: center; padding: 10px; border: 1px solid #e2e8f0; font-size: 11px;">${index + 1}</td>
                    <td style="padding: 10px; border: 1px solid #e2e8f0; font-size: 11px;">
                        <b style="color: #1e293b;">${name}</b><br>
                        <span style="color: #64748b; font-size: 9px;">ID: ${id}</span>
                    </td>
                    <td style="text-align: center; padding: 10px; border: 1px solid #e2e8f0; font-size: 11px;">${tanggal}</td>
                    <td style="padding: 10px; border: 1px solid #e2e8f0; font-size: 11px;">${fasilitas}</td>
                    <td style="text-align: right; padding: 10px; border: 1px solid #e2e8f0; font-weight: bold; color: #f59e0b; font-size: 11px;">${total}</td>
                    <td style="text-align: center; padding: 10px; border: 1px solid #e2e8f0; font-size: 11px;">
                        <span style="display: inline-block; padding: 4px 10px; border-radius: 100px; font-size: 10px; font-weight: bold; ${statusStyle}; text-transform: uppercase;">${status}</span>
                    </td>
                </tr>
            `;
        });

        let content = `
            <html xmlns:o='urn:schemas-microsoft-com:office:office' xmlns:w='urn:schemas-microsoft-com:office:word' xmlns='http://www.w3.org/TR/REC-html40'>
            <head>
                <title>Laporan Reservasi Jagara</title>
                <style>
                    body { font-family: 'Inter', 'Segoe UI', Arial, sans-serif; }
                    table { width: 100%; border-collapse: collapse; margin-top: 20px; }
                    th { background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); color: white; font-weight: bold; padding: 14px 12px; border: 1px solid #334155; font-size: 11px; text-transform: uppercase; }
                </style>
            </head>
            <body>
                <div style="text-align: center; margin-bottom: 30px;">
                    <h1 style="margin:0 0 5px 0; color: #3b82f6; font-size: 24px; font-weight: 800; text-transform: uppercase;">JAGARA ECO PARK</h1>
                    <h3 style="margin:0 0 8px 0; color: #475569; font-size: 14px; font-weight: 600;">Laporan Rekapitulasi Reservasi Pengunjung</h3>
                    <p style="margin:0; color: #64748b; font-size: 11px;">Tanggal Cetak: ${date}</p>
                    <hr style="border: 1px solid #3b82f6; margin-top: 20px;">
                </div>
                <table>
                    <thead>
                        <tr>
                            <th width="6%">NO</th>
                            <th width="34%">NAMA PENGUNJUNG</th>
                            <th width="14%">TANGGAL</th>
                            <th width="18%">FASILITAS WISATA</th>
                            <th width="14%">TOTAL BAYAR</th>
                            <th width="14%">STATUS</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${tableRowsHtml}
                    </tbody>
                </table>
            </body>
            </html>`;

        let blob = new Blob(['\ufeff' + content], { 
            type: 'application/msword' 
        });
        
        let url = URL.createObjectURL(blob);
        let link = document.createElement('a');
        link.href = url;
        link.download = 'Laporan_Reservasi_Jagara.doc';
        link.click();
    }

    function applyFilter(name, value) {
        const url = new URL(window.location.href);
        url.searchParams.set(name, value);
        if (name === 'periode' && !url.searchParams.has('status')) {
            url.searchParams.set('status', '{{ $filter_status }}');
        }
        if (name === 'status' && !url.searchParams.has('periode')) {
            url.searchParams.set('periode', '{{ $filter_waktu }}');
        }
        window.location.href = url.toString();
    }

    function exportImage(type) {
        prepareForExport();
        const node = document.getElementById('reportArea');
        const func = type === 'png' ? htmlToImage.toPng : htmlToImage.toJpeg;
        
        func(node, { backgroundColor: '#ffffff', quality: 1 }).then(function (dataUrl) {
            var link = document.createElement('a');
            link.download = 'Laporan_Reservasi_Jagara.' + type;
            link.href = dataUrl;
            link.click();
            resetAfterExport();
        }).catch(function (error) {
            console.error('Export Error:', error);
            resetAfterExport();
        });
    }
</script>

</body>
</html>
