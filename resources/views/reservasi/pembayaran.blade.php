<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Reservasi - Jagara Eco Park</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/index.css') }}">
    <style>
        .payment-container {
            margin-top: 80px;
            max-width: 1000px;
            margin-left: auto;
            margin-right: auto;
            padding: 32px 24px;
        }
        .countdown-box {
            background: linear-gradient(135deg, #00b4d8 0%, #0096c7 100%);
            color: white;
            padding: 24px;
            border-radius: 20px;
            margin-bottom: 32px;
            text-align: center;
            box-shadow: 0 10px 40px rgba(0, 180, 216, 0.3);
        }
        .countdown-timer {
            font-size: 3rem;
            font-weight: 800;
            letter-spacing: 4px;
            margin: 12px 0;
        }
        .invoice-card {
            background: white;
            border-radius: 20px;
            padding: 32px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.08);
            margin-bottom: 32px;
        }
        .section-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .section-title i {
            color: #00b4d8;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid #e5e7eb;
        }
        .info-row:last-of-type {
            border-bottom: none;
        }
        .info-label {
            color: #6b7280;
            font-weight: 500;
        }
        .info-value {
            color: #1f2937;
            font-weight: 600;
        }
        .total-amount {
            background: linear-gradient(135deg, #e0f7fa 0%, #f0f9ff 100%);
            padding: 24px;
            border-radius: 16px;
            text-align: center;
            margin: 24px 0;
        }
        .total-label {
            color: #0369a1;
            font-weight: 600;
            font-size: 0.9rem;
            margin-bottom: 8px;
        }
        .total-value {
            color: #00b4d8;
            font-size: 2.5rem;
            font-weight: 800;
        }
        .payment-method-box {
            background: linear-gradient(135deg, #e0f7fa 0%, #f0f9ff 100%);
            border: 2px solid #00b4d8;
            border-radius: 16px;
            padding: 32px;
            margin-bottom: 32px;
        }
        .payment-method-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: #0369a1;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .qr-placeholder {
            width: 250px;
            height: 250px;
            margin: 0 auto;
            display: block;
            background: white;
            padding: 10px;
            border-radius: 8px;
        }
        .copy-box {
            background: white;
            padding: 16px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            margin-top: 16px;
        }
        .copy-text {
            font-family: monospace;
            font-size: 1.1rem;
            color: #1f2937;
            flex: 1;
        }
        .copy-btn {
            background: #00b4d8;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .copy-btn:hover {
            background: #0096c7;
        }
        .upload-section {
            background: white;
            border: 2px dashed #00b4d8;
            border-radius: 16px;
            padding: 32px;
            text-align: center;
        }
        .upload-btn {
            background: linear-gradient(135deg, #00b4d8 0%, #0096c7 100%);
            color: white;
            font-weight: 700;
            padding: 14px 32px;
            border-radius: 12px;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 10px 30px rgba(0, 180, 216, 0.3);
        }
        .upload-btn:hover {
            background: linear-gradient(135deg, #0096c7 0%, #0077b6 100%);
            transform: translateY(-2px);
        }
        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #00b4d8;
            font-weight: 600;
            text-decoration: none;
            margin-bottom: 16px;
            transition: all 0.3s ease;
        }
        .back-link:hover {
            color: #0096c7;
        }
        .cancel-btn {
            display: inline-block;
            padding: 14px 32px;
            border: 2px solid #cbd5e1;
            border-radius: 12px;
            color: #475569;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            width: 100%;
            margin-top: 12px;
            border-radius: 0.75rem;
            padding-top: 0.75rem;
            padding-bottom: 0.75rem;
        }
        .btn-cancel:hover {
            background-color: #f8fafc;
        }
    </style>
</head>
<body>
    @include('partials.header')

    <div class="payment-container">
        <a href="javascript:void(0);" 
           onclick="alert('Peringatan: Anda tidak dapat kembali! Harap selesaikan proses pembayaran Anda untuk menghindari penumpukan atau manipulasi data reservasi.');"
           style="color: #00b4d8; 
                  text-decoration: none; 
                  margin-bottom: 20px; 
                  display: inline-flex; 
                  align-items: center; 
                  gap: 8px; 
                  font-weight: 600; 
                  padding: 10px 20px; 
                  border-radius: 8px; 
                  border: 1px solid #00b4d8; 
                  background: transparent; 
                  transition: all 0.3s ease;"
           onmouseover="this.style.backgroundColor='#00b4d8'; this.style.color='#ffffff';" 
           onmouseout="this.style.backgroundColor='transparent'; this.style.color='#00b4d8';">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>

        <!-- Countdown Timer -->
        <div class="countdown-box">
            <i class="fas fa-clock" style="font-size: 2rem; margin-bottom: 12px;"></i>
            <h2 style="font-size: 1.25rem; font-weight: 700; margin: 0;">Segera selesaikan pembayaran sebelum waktu habis!</h2>
            <div class="countdown-timer" id="countdown">15:00</div>
            <p style="opacity: 0.9; margin: 0;">Reservasi akan otomatis dibatalkan jika tidak diselesaikan dalam 15 menit</p>
        </div>

        <!-- Invoice Card -->
        <div class="invoice-card">
            <h3 class="section-title">
                <i class="fas fa-receipt"></i>
                Detail Reservasi
            </h3>
            <div class="info-row">
                <span class="info-label">Kode Reservasi</span>
                <span class="info-value" style="font-family: monospace; font-size: 1.1rem;">{{ $reservation->kode_reservasi }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Nama Pengunjung</span>
                <span class="info-value">{{ $reservation->nama_pengunjung }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Fasilitas / Wahana</span>
                <span class="info-value">{{ $reservation->fasilitas->nama_fasilitas }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Tanggal Kunjungan</span>
                <span class="info-value">{{ \Carbon\Carbon::parse($reservation->tanggal_kunjungan)->format('d F Y') }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Jumlah Tiket</span>
                <span class="info-value">{{ $reservation->jumlah_tiket }} tiket</span>
            </div>
            <div class="total-amount">
                <div class="total-label">Total Pembayaran</div>
                <div class="total-value">Rp {{ number_format($reservation->total_bayar, 0, ',', '.') }}</div>
            </div>
        </div>

        <!-- Payment Method Instructions -->
        <div class="payment-method-box">
            @if($metode_pembayaran == 'QRIS')
                <h3 class="payment-method-title">
                    <i class="fas fa-qrcode"></i>
                    Pembayaran via QRIS
                </h3>
                <p style="color: #374151; margin-bottom: 24px;">Scan QR Code berikut untuk melakukan pembayaran:</p>
                <div style="text-align: center; margin-bottom: 20px;">
                    <div class="qr-placeholder">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=230x230&data=JagaraEcoPark_Simulasi_Pembayaran_Valid" alt="QRIS Jagara Eco Park" style="width: 100%; height: 100%; border-radius: 4px; display: block;">
                    </div>
                    <span style="color: #6b7280; font-weight: 600; margin-top: 12px; display: block;">QRIS Jagara Eco Park</span>
                </div>
                <p style="color: #6b7280; text-align: center; font-size: 0.9rem;">Scan menggunakan aplikasi mobile banking atau e-wallet Anda</p>
            @elseif($metode_pembayaran == 'Transfer')
                <h3 class="payment-method-title">
                    <i class="fas fa-building-columns"></i>
                    Pembayaran via Transfer Bank
                </h3>
                <p style="color: #374151; margin-bottom: 16px;">Silakan transfer ke rekening berikut:</p>
                <div class="copy-box">
                    <span class="copy-text">BRILink / Bank BRI - 013301088006504 a.n. Jagara Eco Park</span>
                    <button class="copy-btn" onclick="copyText('BRILink / Bank BRI - 013301088006504 a.n. Jagara Eco Park')">
                        <i class="fas fa-copy"></i> Salin
                    </button>
                </div>
            @else
                <h3 class="payment-method-title">
                    <i class="fas fa-mobile-screen-button"></i>
                    Pembayaran via E-Wallet
                </h3>
                <p style="color: #374151; margin-bottom: 16px;">Silakan transfer ke e-wallet berikut:</p>
                <div class="copy-box">
                    <span class="copy-text">Dana / ShopeePay / Gopay - 085795798560 a.n. Jagara Eco Park</span>
                    <button class="copy-btn" onclick="copyText('Dana / ShopeePay / Gopay - 085795798560 a.n. Jagara Eco Park')">
                        <i class="fas fa-copy"></i> Salin
                    </button>
                </div>
            @endif
        </div>

        <!-- Upload Payment Proof -->
        <div class="upload-section">
            <h3 class="section-title" style="justify-content: center;">
                <i class="fas fa-file-upload"></i>
                Unggah Bukti Pembayaran
            </h3>
            <p style="color: #6b7280; margin-bottom: 24px;">Setelah melakukan pembayaran, silakan unggah bukti transfer di bawah ini</p>
            <form action="{{ route('reservasi.upload-bukti', $reservation->kode_reservasi) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div style="margin-bottom: 24px;">
                    <input type="file" name="bukti" id="bukti" accept="image/jpeg,image/png,image/jpg" required style="display: none;">
                    <label for="bukti" style="cursor: pointer; display: inline-flex; align-items: center; gap: 8px; background: white; border: 2px dashed #00b4d8; padding: 16px 32px; border-radius: 12px; color: #00b4d8; font-weight: 600; transition: all 0.3s ease;">
                        <i class="fas fa-cloud-upload-alt"></i>
                        Pilih File Bukti Pembayaran
                    </label>
                    <p id="file-name" style="color: #6b7280; margin-top: 12px; font-size: 0.9rem;">Belum ada file dipilih</p>
                </div>
                <button type="submit" class="upload-btn" style="margin-bottom: 12px;">
                    <i class="fas fa-paper-plane"></i>
                    Kirim Bukti Pembayaran
                </button>
                <a href="javascript:void(0);" 
                   onclick="alert('Peringatan: Anda tidak dapat membatalkan! Harap selesaikan proses pembayaran Anda untuk menghindari penumpukan atau manipulasi data reservasi.');"
                   class="btn-cancel" 
                   style="display: block; text-align: center; margin-top: 12px; border: 1px solid #cbd5e1; color: #475569; padding: 12px; border-radius: 8px; text-decoration: none; font-weight: 500; transition: background 0.2s;">
                    Batalkan & Cari Tanggal Lain
                </a>
            </form>
        </div>
    </div>

    <script>
        // File name display
        document.getElementById('bukti').addEventListener('change', function(e) {
            if (e.target.files.length > 0) {
                document.getElementById('file-name').textContent = e.target.files[0].name;
            } else {
                document.getElementById('file-name').textContent = 'Belum ada file dipilih';
            }
        });

        // Copy text function
        function copyText(text) {
            navigator.clipboard.writeText(text).then(function() {
                alert('Teks berhasil disalin!');
            });
        }

        // Countdown Timer (15 minutes)
        let totalSeconds = 15 * 60; // 15 minutes in seconds
        const countdownEl = document.getElementById('countdown');
        const reservationCreatedAt = new Date('{{ $reservation->created_at }}');
        const now = new Date();
        const elapsedSeconds = Math.floor((now - reservationCreatedAt) / 1000);
        totalSeconds = Math.max(0, (15 * 60) - elapsedSeconds);

        function updateCountdown() {
            const minutes = Math.floor(totalSeconds / 60);
            const seconds = totalSeconds % 60;
            countdownEl.textContent = String(minutes).padStart(2, '0') + ':' + String(seconds).padStart(2, '0');

            if (totalSeconds > 0) {
                totalSeconds--;
                setTimeout(updateCountdown, 1000);
            } else {
                // Time's up - redirect
                window.location.href = '{{ route('reservasi.status') }}';
            }
        }

        // Start the countdown
        updateCountdown();
    </script>
</body>
</html>