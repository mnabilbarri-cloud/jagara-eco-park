@php
    $user_id = Session::has('user_login') ? Session::get('user_id') : null;
    $discount_percentage = 0;
    $current_tier = 'silver';
    $completed_reservations = 0;
    if ($user_id) {
        $user = \App\Models\User::find($user_id);
        if ($user) {
            $completed_reservations = $user->reservations()->whereIn('status', ['Diterima'])->count();
            if ($completed_reservations >= 6) {
                $current_tier = 'platinum';
                $discount_percentage = 15;
            } elseif ($completed_reservations >= 3) {
                $current_tier = 'gold';
                $discount_percentage = 10;
            } else {
                $current_tier = 'silver';
                $discount_percentage = 0;
            }
        }
    }
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Reservasi - Jagara Eco Park</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/index.css') }}">
    <style>
        .reservasi-container {
            margin-top: 80px;
            max-width: 1280px;
            margin-left: auto;
            margin-right: auto;
            padding: 32px 24px;
        }
        .page-title {
            font-size: 2rem;
            font-weight: 800;
            color: #1f2937;
            margin-bottom: 32px;
        }
        .grid-layout {
            display: grid;
            grid-template-columns: 1fr;
            gap: 32px;
        }
        @media (min-width: 1024px) {
            .grid-layout {
                grid-template-columns: 2fr 1fr;
            }
        }
        .form-card {
            background: white;
            border-radius: 20px;
            padding: 32px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.08);
        }
        .section-label {
            font-size: 1.125rem;
            font-weight: 700;
            color: #00b4d8;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .input-group {
            margin-bottom: 24px;
        }
        .input-group label {
            display: block;
            font-weight: 600;
            color: #374151;
            margin-bottom: 8px;
        }
        .input-group input,
        .input-group select,
        .input-group textarea {
            width: 100%;
            padding: 14px 16px;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            font-size: 1rem;
            font-family: 'Poppins', sans-serif;
            transition: all 0.3s ease;
            box-sizing: border-box;
        }
        .input-group input:focus,
        .input-group select:focus,
        .input-group textarea:focus {
            outline: none;
            border-color: #00b4d8;
            box-shadow: 0 0 0 4px rgba(0, 180, 216, 0.1);
        }
        .input-group textarea {
            min-height: 120px;
            resize: vertical;
        }
        .payment-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 16px;
        }
        @media (min-width: 640px) {
            .payment-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }
        .payment-card {
            border: 2px solid #e5e7eb;
            border-radius: 16px;
            padding: 20px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .payment-card:hover {
            border-color: #00b4d8;
            box-shadow: 0 4px 15px rgba(0, 180, 216, 0.15);
        }
        .payment-card.selected {
            border-color: #00b4d8;
            background: linear-gradient(135deg, #e0f7fa 0%, #f0f9ff 100%);
            box-shadow: 0 4px 20px rgba(0, 180, 216, 0.2);
        }
        .payment-icon {
            font-size: 2rem;
            color: #00b4d8;
            margin-bottom: 12px;
        }
        .payment-name {
            font-weight: 700;
            color: #1f2937;
        }
        .summary-card {
            background: white;
            border-radius: 20px;
            padding: 28px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.12);
            position: sticky;
            top: 112px;
        }
        .summary-title {
            font-size: 1.25rem;
            font-weight: 800;
            color: #1f2937;
            margin-bottom: 24px;
        }
        .summary-item {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid #e5e7eb;
        }
        .summary-item:last-of-type {
            border-bottom: none;
        }
        .summary-label {
            color: #6b7280;
            font-weight: 500;
        }
        .summary-value {
            color: #1f2937;
            font-weight: 600;
        }
        .total-section {
            background: linear-gradient(135deg, #00b4d8 0%, #0096c7 100%);
            border-radius: 16px;
            padding: 20px;
            margin-top: 24px;
            text-align: center;
        }
        .total-label {
            color: #e0f7fa;
            font-weight: 600;
            font-size: 0.875rem;
            margin-bottom: 8px;
        }
        .total-amount {
            color: white;
            font-size: 2rem;
            font-weight: 800;
        }
        .checkout-btn {
            width: 100%;
            background: #00b4d8;
            color: white;
            font-weight: 800;
            font-size: 1.125rem;
            padding: 18px;
            border: none;
            border-radius: 16px;
            margin-top: 24px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 10px 30px rgba(0, 180, 216, 0.35);
        }
        .checkout-btn:hover {
            background: #0096c7;
            transform: translateY(-4px);
            box-shadow: 0 16px 40px rgba(0, 180, 216, 0.45);
        }
        .info-banner {
            background: linear-gradient(135deg, #e0f7fa 0%, #f0f9ff 100%);
            border: 1px solid #a5f3fc;
            border-radius: 12px;
            padding: 16px;
            display: flex;
            align-items: flex-start;
            gap: 12px;
            margin-bottom: 28px;
        }
        .info-banner i {
            color: #48cae4;
            font-size: 1.25rem;
            flex-shrink: 0;
        }
        .info-banner p {
            color: #00b4d8;
            margin: 0;
            line-height: 1.6;
        }
        .info-banner a {
            color: #00b4d8;
            font-weight: 700;
            text-decoration: underline;
        }
        .hidden-radio {
            display: none;
        }
    </style>
</head>
<body>
    @include('partials.header')

    <div class="reservasi-container">
        <a href="{{ $selectedFasilitasId ? route('fasilitas.show', $selectedFasilitasId) : route('home') }}" 
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
        <h1 class="page-title">
            <i class="fas fa-calendar-check text-sky-600 mr-3"></i>
            Form Reservasi
        </h1>

        <div class="grid-layout">
            <!-- Left Column - Input Fields -->
            <div>
                <div class="form-card">
                    <div class="info-banner">
                        <i class="fas fa-circle-info"></i>
                        <p>Sudah melakukan reservasi tapi belum bayar? <a href="{{ route('reservasi.status') }}">Cek Status & Bayar Di Sini</a></p>
                    </div>

                    <form action="{{ url('/reservasi-simpan') }}" method="POST">
                        @csrf

                        <h2 class="section-label">
                            <i class="fas fa-user"></i>
                            Data Diri Pengunjung
                        </h2>

                        <div class="input-group">
                            <label for="nama_pengunjung">Nama Pengunjung</label>
                            <input type="text" id="nama_pengunjung" name="nama_pengunjung" value="{{ old('nama_pengunjung') }}" placeholder="Masukkan nama lengkap" required>
                        </div>

                        <div class="input-group">
                            <label for="no_hp">No HP (WhatsApp)</label>
                            <input type="text" id="no_hp" name="no_hp" value="{{ old('no_hp') }}" placeholder="08xxxxxxxxxx" required>
                        </div>

                        <h2 class="section-label" style="margin-top: 32px;">
                            <i class="fas fa-calendar-days"></i>
                            Detail Kunjungan
                        </h2>

                        <div class="input-group">
                            <label for="tanggal_kunjungan">Tanggal Kunjungan</label>
                            <input type="date" id="tanggal_kunjungan" name="tanggal_kunjungan" min="{{ date('Y-m-d') }}" value="{{ old('tanggal_kunjungan', request('tanggal_kunjungan', date('Y-m-d'))) }}" required>
                        </div>

                        <div class="input-group">
                            <label for="sesi_waktu">Sesi Waktu Kunjungan</label>
                            <select id="sesi_waktu" name="sesi_waktu" required>
                                <option value="">-- Pilih Sesi Waktu --</option>
                                <option value="Pagi (09:00 - 13:00)" {{ old('sesi_waktu') == 'Pagi (09:00 - 13:00)' ? 'selected' : '' }}>Pagi (09:00 - 13:00)</option>
                                <option value="Siang (13:00 - 17:00)" {{ old('sesi_waktu') == 'Siang (13:00 - 17:00)' ? 'selected' : '' }}>Siang (13:00 - 17:00)</option>
                                <option value="Sore/Malam (17:00 - 22:00)" {{ old('sesi_waktu') == 'Sore/Malam (17:00 - 22:00)' ? 'selected' : '' }}>Sore/Malam (17:00 - 22:00)</option>
                            </select>
                        </div>

                        <div class="input-group">
                            <label for="id_fasilitas">Fasilitas & Wahana</label>
                            <select id="id_fasilitas" name="id_fasilitas" required>
                                <option value="">-- Pilih Fasilitas --</option>
                                @foreach($fasilitas as $f)
                                    <option value="{{ $f->id_fasilitas }}" data-harga="{{ $f->harga }}" data-nama="{{ $f->nama_fasilitas }}" {{ old('id_fasilitas', request('id_fasilitas')) == $f->id_fasilitas ? 'selected' : '' }}>
                                        {{ $f->nama_fasilitas }} - Rp {{ number_format($f->harga, 0, ',', '.') }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="input-group">
                            <label for="jumlah_tiket">Jumlah Pengunjung / Tiket</label>
                            <input type="number" id="jumlah_tiket" name="jumlah_tiket" min="1" value="{{ old('jumlah_tiket', request('jumlah_tiket', 1)) }}" placeholder="Jumlah orang" required>
                        </div>

                        <div class="input-group">
                            <label for="catatan_khusus">Catatan Khusus (Opsional)</label>
                            <textarea id="catatan_khusus" name="catatan_khusus" placeholder="Contoh: Membawa lansia/kursi roda, Request meja dekat kaca, dll">{{ old('catatan_khusus') }}</textarea>
                        </div>

                        <h2 class="section-label" style="margin-top: 32px;">
                            <i class="fas fa-credit-card"></i>
                            Metode Pembayaran
                        </h2>

                        <div class="payment-grid">
                            <div class="payment-card" data-payment="QRIS">
                                <i class="fas fa-qrcode payment-icon"></i>
                                <div class="payment-name">QRIS (Otomatis)</div>
                            </div>
                            <div class="payment-card" data-payment="Transfer">
                                <i class="fas fa-building-columns payment-icon"></i>
                                <div class="payment-name">Transfer Bank (BCA/Mandiri)</div>
                            </div>
                            <div class="payment-card" data-payment="E-Wallet">
                                <i class="fas fa-mobile-screen-button payment-icon"></i>
                                <div class="payment-name">E-Wallet (Dana/Gopay)</div>
                            </div>
                        </div>

                        <input type="hidden" id="metode_pembayaran" name="metode_pembayaran" value="">
                        <input type="hidden" id="total_bayar" name="total_bayar" value="0">

                        <div style="margin-top: 32px;">
                            <button type="submit" class="checkout-btn">
                                <i class="fas fa-check-circle mr-2"></i>
                                Konfirmasi & Bayar Sekarang
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Right Column - Summary -->
            <div>
                <div class="summary-card">
                    <h3 class="summary-title">
                        <i class="fas fa-receipt text-sky-600 mr-2"></i>
                        Ringkasan Pesanan
                    </h3>

                    <div class="summary-item">
                        <span class="summary-label">Nama Wahana</span>
                        <span class="summary-value" id="summary-fasilitas">--</span>
                    </div>
                    <div class="summary-item">
                        <span class="summary-label">Harga Satuan</span>
                        <span class="summary-value" id="summary-harga">Rp 0</span>
                    </div>
                    <div class="summary-item">
                        <span class="summary-label">Jumlah Tiket</span>
                        <span class="summary-value" id="summary-jumlah">1</span>
                    </div>
                    <div class="summary-item" id="discount-row">
                        <span class="summary-label" id="discount-label">Diskon Member</span>
                        <span class="summary-value" id="discount-amount" style="color: #10b981;">Rp 0</span>
                    </div>

                    <div class="total-section">
                        <div class="total-label">Total Pembayaran</div>
                        <div class="total-amount" id="summary-total">Rp 0</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const fasilitasSelect = document.getElementById('id_fasilitas');
        const jumlahInput = document.getElementById('jumlah_tiket');
        const summaryFasilitas = document.getElementById('summary-fasilitas');
        const summaryHarga = document.getElementById('summary-harga');
        const summaryJumlah = document.getElementById('summary-jumlah');
        const summaryTotal = document.getElementById('summary-total');
        const discountLabel = document.getElementById('discount-label');
        const discountAmount = document.getElementById('discount-amount');
        const totalHidden = document.getElementById('total_bayar');
        const paymentCards = document.querySelectorAll('.payment-card');
        const metodePembayaranInput = document.getElementById('metode_pembayaran');

        // Discount info from Blade
        const DISCOUNT_PERCENTAGE = {{ $discount_percentage }};
        const CURRENT_TIER = "{{ $current_tier }}";

        function formatRupiah(angka) {
            return 'Rp ' + angka.toLocaleString('id-ID');
        }

        function hitungTotal() {
            const selectedOption = fasilitasSelect.options[fasilitasSelect.selectedIndex];
            
            if (selectedOption && selectedOption.value) {
                const harga = parseInt(selectedOption.getAttribute('data-harga'));
                const nama = selectedOption.getAttribute('data-nama');
                const jumlah = parseInt(jumlahInput.value) || 1;
                const subtotal = harga * jumlah;

                // Calculate discount
                const discountValue = Math.floor(subtotal * (DISCOUNT_PERCENTAGE / 100));
                const total = subtotal - discountValue;

                // Update discount label
                if (CURRENT_TIER === 'gold') {
                    discountLabel.textContent = 'Diskon Member Gold (10%)';
                } else if (CURRENT_TIER === 'platinum') {
                    discountLabel.textContent = 'Diskon Member Platinum (15%)';
                } else {
                    discountLabel.textContent = 'Diskon Member';
                }

                if (discountValue > 0) {
                    discountAmount.textContent = '- ' + formatRupiah(discountValue);
                    discountAmount.style.color = '#10b981';
                } else {
                    discountAmount.textContent = 'Rp 0';
                }

                summaryFasilitas.textContent = nama;
                summaryHarga.textContent = formatRupiah(harga);
                summaryJumlah.textContent = jumlah;
                summaryTotal.textContent = formatRupiah(total);
                totalHidden.value = total;
            } else {
                summaryFasilitas.textContent = '--';
                summaryHarga.textContent = 'Rp 0';
                summaryJumlah.textContent = '1';
                discountLabel.textContent = 'Diskon Member';
                discountAmount.textContent = 'Rp 0';
                summaryTotal.textContent = 'Rp 0';
                totalHidden.value = 0;
            }
        }

        // Payment card selection
        paymentCards.forEach(card => {
            card.addEventListener('click', () => {
                paymentCards.forEach(c => c.classList.remove('selected'));
                card.classList.add('selected');
                metodePembayaranInput.value = card.getAttribute('data-payment');
            });
        });

        // Event listeners
        fasilitasSelect.addEventListener('change', hitungTotal);
        jumlahInput.addEventListener('input', hitungTotal);

        document.addEventListener("DOMContentLoaded", function() {
            hitungTotal();
        });
    </script>
</body>
</html>
