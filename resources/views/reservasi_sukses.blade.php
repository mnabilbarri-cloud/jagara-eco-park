@php
    $user_tier = 'silver';
    if ($reservation->user_id) {
        $user = \App\Models\User::find($reservation->user_id);
        if ($user) {
            $completed = $user->reservations()->whereIn('status', ['Diterima'])->count();
            if ($completed >= 6) {
                $user_tier = 'platinum';
            } elseif ($completed >= 3) {
                $user_tier = 'gold';
            }
        }
    }
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservasi Berhasil - Jagara Eco Park</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/index.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/reservasi.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/style.css') }}">
    <style>
        /* Override reservasi.css body styles to fix centering */
        body.success-container {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            align-items: stretch;
            justify-content: flex-start;
            padding-top: 0;
            padding-bottom: 0;
            margin: 0;
        }
        .success-body {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            padding-top: 100px;
            width: 100%;
        }
        .ticket-card {
            margin: 0 auto; /* Ensure card is centered */
        }
    </style>
</head>
<body class="success-container">
    @include('partials.header')
    <div class="success-body">
        <div class="ticket-card">
        <div class="ticket-header">
            <div class="success-icon-wrapper">
                <i class="fa-solid fa-circle-check"></i>
            </div>
            <h2>Reservasi Berhasil</h2>
            <p>Terima kasih telah memilih Jagara Eco Park</p>
        </div>

        <div class="ticket-body">
            <span class="label">KODE RESERVASI ANDA</span>
            <div class="booking-code">{{ $reservation->kode_reservasi }}</div>
            
            <div class="payment-summary-box">
                <p>Total Pembayaran:</p>
                <h3>Rp {{ number_format($reservation->total_bayar, 0, ',', '.') }}</h3>
                <small>Transfer ke: <b>{{ config('app.bank_account', 'BCA 12345678 a/n Jagara') }}</b></small>
            </div>

            @if(in_array($user_tier, ['gold', 'platinum']))
                <div style="background: linear-gradient(135deg, #FEF3C7 0%, #FDE68A 100%); border-left: 6px solid #F59E0B; border-radius: 12px; padding: 16px; margin: 20px 0; text-align: center;">
                    <h4 style="margin: 0 0 8px 0; color: #78350F; font-weight: 800; font-size: 1rem;">🚀 AKSES JALUR CEPAT (FAST TRACK)</h4>
                    <p style="margin: 0; color: #92400E; font-weight: 600; font-size: 0.9rem;">Tunjukkan halaman ini atau print out tiket kepada petugas gerbang utama untuk mengakses jalur cepat!</p>
                </div>
            @endif

            @if($reservation->status == 'Diterima')
                <div class="qr-section">
                    <p>Silakan scan QR ini saat tiba di lokasi:</p>
                    <div class="qr-wrapper">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ $reservation->kode_reservasi }}" alt="QR Code">
                    </div>
                    <div class="qr-note">*Tunjukkan kode ini kepada petugas loket</div>
                </div>
            @else
                <div class="qr-section pending-box">
                    <p>Status: <b>{{ $reservation->status }}</b></p>
                    @if(empty($reservation->bukti_pembayaran))
                        <p class="small-text">Segera upload bukti bayar Anda:</p>
                        <a href="{{ route('reservasi.upload', $reservation->kode_reservasi) }}" class="btn-upload-bukti">
                            <i class="fa-solid fa-upload"></i> Upload Bukti
                        </a>
                    @else
                        <p class="small-text" style="color: #F59E0B;">
                            <strong><i class="fa-solid fa-check-double"></i> Bukti sudah terkirim.</strong><br>Mohon tunggu verifikasi admin.
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="ticket-footer">
            <div class="button-group">
                <a href="{{ route('reservasi.status', ['kode_reservasi' => $reservation->kode_reservasi]) }}" class="btn-pro btn-status">
                    <i class="fa-solid fa-magnifying-glass"></i> Cek Status
                </a>
                <a href="{{ route('home') }}" class="btn-pro btn-home">
                    <i class="fa-solid fa-house"></i> Beranda
                </a>
            </div>
        </div>
        </div>
    </div>

    <!-- Retention & Feedback Modal -->
    <div id="retentionModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.7); z-index: 3000; align-items: center; justify-content: center;">
        <div style="background: #E0F7FA; width: 90%; max-width: 450px; border-radius: 20px; padding: 30px; position: relative; box-shadow: 0 20px 50px rgba(0,0,0,0.5); text-align: center;">
            <button onclick="closeRetentionModal()" style="position: absolute; top: 15px; right: 15px; background: none; border: none; font-size: 24px; cursor: pointer; color: #00b4d8;">&times;</button>
            <div style="font-size: 48px; color: #00b4d8; margin-bottom: 15px;">
                <i class="fas fa-heart"></i>
            </div>
            <h3 style="color: #00b4d8; margin: 0 0 15px 0;">Bagaimana Kesan Anda?</h3>
            <p style="color: #555; line-height: 1.6; margin: 0 0 20px 0;">
                Apakah Anda ingin berkunjung kembali ke Jagara Eco Park? Berikan penilaian Anda untuk membantu kami menjadi lebih baik!
            </p>
            
            <!-- Star Rating -->
            <div style="margin-bottom: 20px;">
                <p style="color: #666; margin-bottom: 10px;">Penilaian Anda:</p>
                <div id="starRating" style="font-size: 30px; color: #d1d5db; cursor: pointer;">
                    <span class="star" data-rating="1">★</span>
                    <span class="star" data-rating="2">★</span>
                    <span class="star" data-rating="3">★</span>
                    <span class="star" data-rating="4">★</span>
                    <span class="star" data-rating="5">★</span>
                </div>
            </div>

            <div style="display: flex; gap: 10px; justify-content: center;">
                <a href="{{ route('reservasi.buat') }}" style="flex: 1; display: block; background: linear-gradient(135deg, #00b4d8 0%, #0096c7 100%); color: white; padding: 12px; border-radius: 10px; text-decoration: none; font-weight: 600; transition: 0.3s;" onmouseover="this.style.background='linear-gradient(135deg, #0096c7 0%, #0077b6 100%)'" onmouseout="this.style.background='linear-gradient(135deg, #00b4d8 0%, #0096c7 100%)'">
                    <i class="fas fa-calendar-plus"></i> Reservasi Lagi
                </a>
                <button onclick="closeRetentionModal()" style="flex: 1; background: #e0e0e0; color: #555; border: none; padding: 12px; border-radius: 10px; font-weight: 600; cursor: pointer; transition: 0.3s;" onmouseover="this.style.background='#d0d0d0'" onmouseout="this.style.background='#e0e0e0'">
                    Nanti Saja
                </button>
            </div>
        </div>
    </div>

    <script>
        // Star rating functionality
        const stars = document.querySelectorAll('#starRating .star');
        stars.forEach(star => {
            star.addEventListener('click', function() {
                const rating = this.getAttribute('data-rating');
                updateStars(rating);
                alert('Terima kasih atas penilaian Anda! (' + rating + ' bintang)');
                closeRetentionModal();
            });
            
            star.addEventListener('mouseover', function() {
                const rating = this.getAttribute('data-rating');
                highlightStars(rating);
            });
            
            star.addEventListener('mouseout', function() {
                const activeStar = document.querySelector('#starRating .star.active');
                if (activeStar) {
                    updateStars(activeStar.getAttribute('data-rating'));
                } else {
                    updateStars(0);
                }
            });
        });

        function highlightStars(rating) {
            stars.forEach((star, index) => {
                if (index < rating) {
                    star.style.color = '#F59E0B';
                } else {
                    star.style.color = '#d1d5db';
                }
            });
        }

        function updateStars(rating) {
            stars.forEach((star, index) => {
                if (index < rating) {
                    star.style.color = '#F59E0B';
                    star.classList.add('active');
                } else {
                    star.style.color = '#d1d5db';
                    star.classList.remove('active');
                }
            });
        }

        // Show retention modal after 3 seconds
        setTimeout(function() {
            document.getElementById('retentionModal').style.display = 'flex';
        }, 3000);

        function closeRetentionModal() {
            document.getElementById('retentionModal').style.display = 'none';
        }

        // Close modal when clicking outside
        document.getElementById('retentionModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeRetentionModal();
            }
        });
    </script>
</body>
</html>