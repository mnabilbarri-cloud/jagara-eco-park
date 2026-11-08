<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Reservasi - Jagara Eco Park</title>
    <link rel="stylesheet" href="{{ asset('assets/index.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/reservasi.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .btn-lupa-kode {
            color: #1b4332;
            text-decoration: none;
            font-size: 0.88rem;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            border-radius: 8px;
            background: rgba(27, 67, 50, 0.06);
        }
        .btn-lupa-kode:hover {
            color: #0f3d26;
            background: rgba(27, 67, 50, 0.12);
            transform: translateY(-1px);
        }
    </style>
</head>
<body class="status-body" style="padding-top: 100px;">
    @include('partials.header')
    <div class="card-status">
        <h2 class="title-status">Cek Status Reservasi</h2>
        
        <form method="GET" action="{{ route('reservasi.status') }}" style="display: flex; gap: 10px; margin-bottom: 15px;">
            <input type="text" name="kode_reservasi" placeholder="Masukkan Kode Reservasi" 
                   value="{{ $kode ?? '' }}" 
                   style="flex:1; margin-top:0;" required>
            <button type="submit" class="btn-cek-inline">Cek</button>
        </form>
        <div style="text-align: right; margin-bottom: 25px; padding-right: 5px;">
            <a href="{{ route('reservasi.lupakode') }}" class="btn-lupa-kode">
                <i class="fa-solid fa-circle-question"></i> Lupa Kode Reservasi?
            </a>
        </div>

        @if(!$reservation)
            <div style="background: #f0f9ff; border: 1px solid #bae6fd; padding: 15px; border-radius: 16px; margin-bottom: 25px; font-size: 13.5px; color: #0369a1; text-align: left; display: flex; align-items: flex-start; gap: 10px; line-height: 1.5; box-sizing: border-box;">
                <i class="fa-solid fa-lightbulb" style="color: #eab308; font-size: 18px; margin-top: 2px;"></i>
                <span><b>Petunjuk Pembayaran:</b> Jika Anda sudah melakukan reservasi tetapi belum membayar, masukkan kode reservasi Anda di atas, lalu klik <b>Cek</b> untuk melanjutkan pembayaran.</span>
            </div>
        @endif

        @if($kode && !$reservation)
            <div class="not-found">Kode reservasi tidak ditemukan.</div>
        @endif

        @if($reservation)
            <div class="info-content">
                <div class="info-row">
                    <b>Nama Pengunjung</b> 
                    <span>{{ $reservation->nama_pengunjung }}</span>
                </div>
                <div class="info-row">
                    <b>Nomor WhatsApp</b> 
                    <span>{{ $reservation->no_hp }}</span>
                </div>
                <div class="info-row">
                    <b>Tanggal Kunjungan</b> 
                    <span>{{ date('d M Y', strtotime($reservation->tanggal_kunjungan)) }}</span>
                </div>
            </div>

            <div style="text-align: center; margin-top: 20px;">
                <span class="badge @if($reservation->status == 'Menunggu') waiting @elseif($reservation->status == 'Diterima') success @elseif($reservation->status == 'Ditolak') danger @else expired @endif">
                    {{ $reservation->status }}
                </span>
            </div>

            @if($reservation->status == 'Diterima')
                <div class="instruction-box">
                    <p class="instruction-text">
                        Reservasi Anda telah disetujui. Silakan cetak nota resmi untuk digunakan sebagai akses masuk lokasi.
                    </p>
                    <a href="{{ route('reservasi.nota', $reservation->kode_reservasi) }}" target="_blank" class="btn-main-action">
                        Lihat & Cetak Nota Resmi
                    </a>
                </div>
            @elseif($reservation->status == 'Ditolak')
                <div class="reject-box-modern">
                    <p>Mohon maaf, reservasi Anda tidak dapat kami setujui saat ini.</p>
                </div>
            @elseif($reservation->status == 'Menunggu')
                <div style="background: #fffbeb; border: 1px solid #fef3c7; padding: 25px; border-radius: 20px; margin-top: 25px; text-align: center;">
                    <span style="font-size: 14px; color: #92400e; font-weight: 600; display: block; margin-bottom: 8px;">
                        ⏳ Menunggu pembayaran (Sisa: <b>{{ $sisa_menit ?? 15 }} menit</b>)
                    </span>
                    <p style="font-size: 12px; color: #b45309; margin: 0 0 20px 0;">Mohon cek kembali secara berkala.</p>

                    @if(empty($reservation->bukti_pembayaran))
                        <div style="background: #fff; border: 1px solid #fde68a; padding: 18px; border-radius: 12px; margin-top: 15px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); text-align: center;">
                            <p style="font-size: 13px; color: #78350f; margin: 0 0 12px 0; font-weight: 600; display: flex; align-items: center; justify-content: center; gap: 6px;">
                                <i class="fa-solid fa-triangle-exclamation" style="color: #d97706;"></i> Anda belum mengunggah bukti pembayaran!
                            </p>
                            <a href="{{ route('reservasi.sukses', $reservation->kode_reservasi) }}" class="btn-main-action" style="background: #d97706; box-shadow: 0 4px 6px rgba(217, 119, 6, 0.15); display: inline-flex; align-items: center; justify-content: center; gap: 8px; width: 100%; box-sizing: border-box; text-decoration: none; color: white;">
                                <i class="fa-solid fa-money-bill-wave"></i> Lanjut ke Pembayaran & Upload
                            </a>
                        </div>
                    @else
                        <div style="background: #f0fdf4; border: 1px solid #bbf7d0; padding: 12px; border-radius: 12px; margin-top: 15px; color: #166534; font-size: 13px; font-weight: 600; display: inline-flex; align-items: center; gap: 8px; justify-content: center; width: 100%; box-sizing: border-box;">
                            <i class="fa-solid fa-circle-check"></i> Bukti pembayaran terkirim. Menunggu verifikasi admin.
                        </div>
                    @endif
                </div>
            @endif
        @endif

        @if($reservation && $reservation->status == 'Diterima')
            @php
                $hasTestimoni = \DB::table('testimoni')->where('id_reservasi', $reservation->id_reservasi)->exists();
            @endphp
            @if(!$hasTestimoni)
                <div style="background: #ffffff; border: 1px solid #e2e8f0; padding: 25px; border-radius: 20px; margin-top: 25px; box-shadow: 0 10px 25px -5px rgba(0,0,0,0.05);">
                    <h3 style="margin-top: 0; font-size: 1.1rem; color: #0f172a; margin-bottom: 15px;">
                        <i class="fas fa-star" style="color: #f59e0b; margin-right: 8px;"></i>
                        Bagikan Pengalaman Anda
                    </h3>
                    <p style="font-size: 0.9rem; color: #64748b; margin-bottom: 20px;">
                        Ulasan Anda membantu kami meningkatkan layanan Jagara Eco Park.
                    </p>
                    <form action="{{ route('reservasi.testimoni.simpan', $reservation->kode_reservasi) }}" method="POST">
                        @csrf
                        <div style="margin-bottom: 15px;">
                            <label style="display: block; font-size: 0.85rem; font-weight: 600; color: #334155; margin-bottom: 8px;">Rating Bintang <span style="color: #ef4444;">*</span></label>
                            <div style="display: flex; gap: 8px; flex-direction: row-reverse; justify-content: flex-end;">
                                @for($s = 5; $s >= 1; $s--)
                                    <input type="radio" id="star{{ $s }}" name="rating" value="{{ $s }}" style="display: none;" required>
                                    <label for="star{{ $s }}" style="font-size: 24px; color: #d1d5db; cursor: pointer; transition: color 0.2s;" onmouseover="this.style.color='#f59e0b'" onmouseout="if(!document.getElementById('star{{ $s }}').checked) this.style.color='#d1d5db'" onclick="highlightStars({{ $s }})"><i class="fas fa-star"></i></label>
                                @endfor
                            </div>
                        </div>
                        <div style="margin-bottom: 15px;">
                            <label style="display: block; font-size: 0.85rem; font-weight: 600; color: #334155; margin-bottom: 8px;">Isi Komentar / Kesan <span style="color: #ef4444;">*</span></label>
                            <textarea name="komentar" style="width: 100%; padding: 12px; border: 1.5px solid #e2e8f0; border-radius: 10px; resize: vertical; min-height: 80px; font-family: inherit; font-size: 0.9rem; outline: none; box-sizing: border-box;" placeholder="Ceritakan keseruan Anda di sini..." required></textarea>
                        </div>
                        <button type="submit" style="background: linear-gradient(135deg, #00b4d8, #0096c7); color: white; border: none; padding: 10px 20px; border-radius: 10px; font-weight: 600; font-size: 0.9rem; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; transition: all 0.2s;">
                            <i class="fas fa-paper-plane"></i> Kirim Ulasan
                        </button>
                    </form>
                    <script>
                        function highlightStars(val) {
                            for(let i=1; i<=5; i++) {
                                document.querySelector('label[for="star'+i+'"]').style.color = (i <= val) ? '#f59e0b' : '#d1d5db';
                            }
                        }
                    </script>
                </div>
            @else
                <div style="background: #f0fdf4; border: 1px solid #bbf7d0; padding: 15px; border-radius: 12px; margin-top: 25px; color: #166534; font-size: 13.5px; font-weight: 600; text-align: center;">
                    <i class="fa-solid fa-check-circle" style="margin-right: 6px;"></i> Terima kasih, Anda sudah memberikan ulasan untuk kunjungan ini!
                </div>
            @endif
        @endif

        <div class="actions" style="margin-top: 30px;">
            <a href="{{ route('reservasi.buat') }}" class="nav-btn btn-status-blue">
                + Reservasi Baru
            </a>
            <a href="{{ route('home') }}" class="nav-btn btn-home-grey">
                🏠 Beranda
            </a>
        </div>
    </div>
</body>
</html>