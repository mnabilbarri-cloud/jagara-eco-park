<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Kode Reservasi - Jagara Eco Park</title>
    <link rel="stylesheet" href="{{ asset('assets/index.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/reservasi.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(rgba(0,0,0,0.65), rgba(0,0,0,0.65)), url('{{ asset("assets/images/hero jagara.jpg") }}') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
            padding-top: 140px;
            box-sizing: border-box;
        }
        .card-lupa-kode {
            background: #ffffff;
            border-radius: 24px;
            padding: 40px;
            max-width: 600px;
            width: 100%;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(0,0,0,0.05);
            margin: 20px auto;
        }
        .title-lupa-kode {
            color: #0F766E;
            font-weight: 800;
            text-align: center;
            margin-top: 0;
            margin-bottom: 10px;
            font-size: 24px;
        }
        .subtitle-lupa-kode {
            color: #64748b;
            text-align: center;
            font-size: 14px;
            margin-bottom: 25px;
            line-height: 1.5;
        }
        .input-group {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }
        .input-group input {
            flex: 1;
            margin-top: 0;
            padding: 14px 18px;
            border-radius: 12px;
            border: 1px solid #cbd5e1;
            font-size: 15px;
            background: #f8fafc;
            transition: all 0.3s ease;
        }
        .input-group input:focus {
            background: #ffffff;
            border-color: #0F766E;
            box-shadow: 0 0 0 4px rgba(15, 118, 110, 0.1);
        }
        .btn-cari {
            background: #0F766E;
            color: white;
            border: none;
            padding: 0 24px;
            border-radius: 12px;
            cursor: pointer;
            font-weight: bold;
            font-size: 15px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .btn-cari:hover {
            background: #0D6F67;
            transform: translateY(-1px);
        }
        .btn-kembali-outline {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            background: #f1f5f9;
            color: #475569;
            border: 1px solid #cbd5e1;
            padding: 14px;
            border-radius: 12px;
            font-weight: bold;
            font-size: 15px;
            text-decoration: none;
            transition: all 0.3s ease;
            width: 100%;
            margin-top: 20px;
            box-sizing: border-box;
        }
        .btn-kembali-outline:hover {
            background: #e2e8f0;
            color: #1e293b;
            border-color: #94a3b8;
        }
        .results-section {
            margin-top: 30px;
        }
        .results-title {
            text-align: left;
            font-size: 16px;
            color: #1e293b;
            margin-top: 0;
            margin-bottom: 15px;
            border-bottom: 2px solid #e2e8f0;
            padding-bottom: 8px;
        }
        .reservation-list-container {
            max-height: 380px;
            overflow-y: auto;
            padding-right: 5px;
        }
        /* Custom scrollbar for beautiful listing */
        .reservation-list-container::-webkit-scrollbar {
            width: 6px;
        }
        .reservation-list-container::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 10px;
        }
        .reservation-list-container::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }
        .reservation-list-container::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
        .reservation-item {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            padding: 18px;
            margin-bottom: 15px;
            text-align: left;
            transition: all 0.3s ease;
        }
        .reservation-item:hover {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
            border-color: #cbd5e1;
            background: #ffffff;
        }
        .res-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
            border-bottom: 1px dashed #e2e8f0;
            padding-bottom: 10px;
        }
        .res-code-box {
            font-weight: 700;
            color: #0f172a;
            font-size: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .btn-copy {
            background: #e2e8f0;
            border: none;
            color: #475569;
            cursor: pointer;
            padding: 6px 10px;
            border-radius: 6px;
            font-size: 13px;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }
        .btn-copy:hover {
            background: #0F766E;
            color: white;
        }
        .res-detail {
            font-size: 13px;
            color: #475569;
            margin-bottom: 6px;
            display: flex;
            justify-content: space-between;
        }
        .res-detail b {
            color: #1e293b;
        }
        .res-actions {
            margin-top: 14px;
            display: flex;
            gap: 10px;
        }
        .btn-action-sm {
            flex: 1;
            padding: 10px;
            border-radius: 10px;
            text-align: center;
            text-decoration: none;
            font-size: 13px;
            font-weight: bold;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }
        .btn-action-primary {
            background: #0F766E;
            color: white !important;
        }
        .btn-action-primary:hover {
            background: #0D6F67;
        }
        .btn-action-secondary {
            background: #0284c7;
            color: white !important;
        }
        .btn-action-secondary:hover {
            background: #0369a1;
        }
        .btn-action-info {
            background: #f1f5f9;
            color: #475569 !important;
            border: 1px solid #cbd5e1;
        }
        .btn-action-info:hover {
            background: #e2e8f0;
            color: #0f172a !important;
        }
        .toast-copy {
            position: fixed;
            bottom: 25px;
            left: 50%;
            transform: translateX(-50%);
            background: rgba(15, 23, 42, 0.95);
            color: white;
            padding: 12px 24px;
            border-radius: 50px;
            font-size: 14px;
            font-weight: 600;
            display: none;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.3);
            z-index: 1000;
            animation: fadeIn 0.3s ease;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translate(-50%, 10px); }
            to { opacity: 1; transform: translate(-50%, 0); }
        }
    </style>
</head>
<body>
    @include('partials.header')
    <div class="card-lupa-kode">
        <h2 class="title-lupa-kode">Lupa Kode Reservasi</h2>
        <p class="subtitle-lupa-kode">Masukkan nomor WhatsApp/Telepon yang terdaftar saat Anda melakukan reservasi untuk mencari kode reservasi Anda.</p>

        <form method="GET" action="{{ route('reservasi.lupakode') }}">
            <div class="input-group">
                <input type="text" name="no_hp" placeholder="Masukkan Nomor WhatsApp (contoh: 085795...)" 
                       value="{{ $noHp ?? '' }}" required>
                <button type="submit" class="btn-cari">
                    <i class="fa-solid fa-magnifying-glass"></i> Cari Kode
                </button>
            </div>
        </form>

        @if($noHp)
            <div class="results-section">
                <h3 class="results-title">
                    Hasil Pencarian untuk WhatsApp: <b>{{ htmlspecialchars($noHp) }}</b>
                </h3>

                @if($reservations && $reservations->count() > 0)
                    <div class="reservation-list-container">
                        @foreach($reservations as $res)
                            <div class="reservation-item">
                                <div class="res-header">
                                    <div class="res-code-box">
                                        <span>{{ $res->kode_reservasi }}</span>
                                        <button class="btn-copy" onclick="copyToClipboard('{{ $res->kode_reservasi }}')" title="Salin Kode">
                                            <i class="fa-regular fa-copy"></i> Salin
                                        </button>
                                    </div>
                                    <span class="badge @if($res->status == 'Menunggu') waiting @elseif($res->status == 'Diterima') success @elseif($res->status == 'Ditolak') danger @else expired @endif" style="font-size: 11px; padding: 4px 10px;">
                                        {{ $res->status }}
                                    </span>
                                </div>
                                <div class="res-detail">
                                    <span>Nama Pengunjung:</span>
                                    <b>{{ htmlspecialchars($res->nama_pengunjung) }}</b>
                                </div>
                                <div class="res-detail">
                                    <span>Fasilitas Wisata:</span>
                                    <b>{{ $res->fasilitas->nama_fasilitas ?? 'Fasilitas Wisata' }}</b>
                                </div>
                                <div class="res-detail">
                                    <span>Tanggal Kunjungan:</span>
                                    <b>{{ date('d M Y', strtotime($res->tanggal_kunjungan)) }}</b>
                                </div>
                                <div class="res-detail">
                                    <span>Total Bayar:</span>
                                    <b style="color: #F59E0B;">Rp {{ number_format($res->total_bayar, 0, ',', '.') }}</b>
                                </div>

                                <div class="res-actions">
                                    @if($res->status == 'Diterima')
                                        <a href="{{ route('reservasi.nota', $res->kode_reservasi) }}" target="_blank" class="btn-action-sm btn-action-primary">
                                            <i class="fa-solid fa-print"></i> Cetak Nota
                                        </a>
                                    @elseif($res->status == 'Menunggu')
                                        @if(empty($res->bukti_pembayaran))
                                            <a href="{{ route('reservasi.upload', $res->kode_reservasi) }}" class="btn-action-sm btn-action-secondary">
                                                <i class="fa-solid fa-upload"></i> Upload Bukti
                                            </a>
                                        @else
                                            <div class="btn-action-sm btn-action-info" style="pointer-events: none; border-color: transparent; opacity: 0.8;">
                                                <i class="fa-solid fa-clock"></i> Bukti Menunggu Verifikasi
                                            </div>
                                        @endif
                                    @endif
                                    <a href="{{ route('reservasi.status', ['kode_reservasi' => $res->kode_reservasi]) }}" class="btn-action-sm btn-action-info">
                                        Detail Status
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="not-found" style="text-align: center; margin-top: 20px;">
                        <i class="fa-solid fa-triangle-exclamation" style="font-size: 24px; color: #d32f2f; margin-bottom: 10px; display: block;"></i>
                        Tidak ada data reservasi ditemukan untuk nomor WhatsApp ini. Silakan periksa kembali nomor yang Anda masukkan.
                    </div>
                @endif
            </div>
        @endif

        <a href="{{ route('reservasi.status') }}" class="btn-kembali-outline">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Cek Status
        </a>
    </div>

    <div id="toast" class="toast-copy">Kode reservasi berhasil disalin!</div>

    <script>
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(function() {
                var toast = document.getElementById("toast");
                toast.style.display = "block";
                setTimeout(function() {
                    toast.style.display = "none";
                }, 2000);
            }, function(err) {
                console.error('Gagal menyalin teks: ', err);
            });
        }
    </script>
</body>
</html>
