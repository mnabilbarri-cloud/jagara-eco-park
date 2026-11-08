<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Transaksi - Jagara Eco Park</title>
    <link rel="stylesheet" href="{{ asset('assets/index.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/reservasi.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .history-container {
            max-width: 900px;
            margin: 0 auto;
            padding: 20px;
        }
        /* Step 1: Fixed Header Contrast & Typography */
        .history-header {
            background: rgba(15, 23, 42, 0.75);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #ffffff;
            padding: 20px 30px;
            border-radius: 15px;
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .history-header h2 {
            margin: 0;
            font-size: 1.5rem;
            font-weight: 700;
            text-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .history-header span {
            font-weight: 500;
            opacity: 0.9;
        }
        /* Step 2: Redesigned User Info / Status Pelanggan with Premium Loyalty Tiers */
        .user-info {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            padding: 28px;
            border-radius: 18px;
            margin-bottom: 30px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 8px 24px rgba(0,0,0,0.08);
        }
        .user-info h3 {
            color: #0f172a;
            margin: 0 0 12px 0;
            font-size: 1.2rem;
            font-weight: 800;
        }
        .user-info .description {
            color: #475569;
            margin-bottom: 20px;
            line-height: 1.6;
            font-weight: 500;
        }
        .discount-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: linear-gradient(135deg, #00b4d8 0%, #0096c7 100%);
            color: white;
            padding: 10px 22px;
            border-radius: 28px;
            font-size: 1rem;
            font-weight: 800;
            margin-bottom: 16px;
        }
        .progress-container {
            margin-top: 12px;
            margin-bottom: 24px;
        }
        .progress-track {
            background: #e2e8f0;
            height: 10px;
            border-radius: 6px;
            overflow: hidden;
            margin-top: 10px;
        }
        .progress-fill {
            background: linear-gradient(90deg, #00b4d8 0%, #0096c7 100%);
            height: 100%;
            border-radius: 6px;
            transition: width 0.6s ease;
        }
        .progress-text {
            color: #334155;
            font-size: 0.95rem;
            margin-top: 6px;
            font-weight: 700;
        }
        .loyalty-tiers {
            display: grid;
            gap: 14px;
        }
        .tier-card {
            padding: 16px 18px;
            border-radius: 12px;
            border-left: 5px solid;
            background: white;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
            transition: transform 0.2s ease;
        }
        .tier-card:hover {
            transform: translateX(4px);
        }
        .tier-card.current {
            border-left-width: 6px;
            box-shadow: 0 4px 16px rgba(0,0,0,0.12);
        }
        .tier-card.silver { border-left-color: #9ca3af; }
        .tier-card.gold { border-left-color: #f59e0b; }
        .tier-card.platinum { border-left-color: #00b4d8; }
        .tier-header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 8px;
        }
        .tier-icon {
            font-size: 1.3rem;
        }
        .tier-name {
            font-size: 1.05rem;
            font-weight: 800;
            color: #0f172a;
        }
        .tier-range {
            font-size: 0.875rem;
            color: #64748b;
            font-weight: 600;
            margin-left: auto;
        }
        .tier-perks {
            color: #475569;
            font-size: 0.9rem;
            line-height: 1.6;
        }
        .platinum-voucher {
            margin-top: 20px;
            padding: 20px;
            background: linear-gradient(135deg, rgba(0, 180, 216, 0.08) 0%, rgba(0, 150, 199, 0.12) 100%);
            border-radius: 14px;
            border: 2px dashed #00b4d8;
            text-align: center;
        }
        .platinum-voucher h4 {
            font-size: 1.05rem;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        .platinum-voucher p {
            color: #334155;
            font-weight: 600;
            font-size: 0.95rem;
        }
        /* Step 3: Premium Modern Table */
        .history-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        }
        .history-table th {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            color: #ffffff;
            padding: 16px 18px;
            text-align: left;
            font-weight: 700;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .history-table td {
            padding: 16px 18px;
            border-bottom: 1px solid #f1f5f9;
            color: #334155;
        }
        .history-table tbody tr {
            transition: all 0.2s ease-in-out;
        }
        .history-table tbody tr:hover {
            background-color: #f8fafc;
        }
        .history-table tr:last-child td {
            border-bottom: none;
        }
        .status-badge {
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 700;
            display: inline-block;
        }
        .status-menunggu { background: #fffbeb; color: #92400e; border: 1px solid #fbbf24; }
        .status-diterima { background: #d1fae5; color: #065f46; border: 1px solid #10b981; }
        .status-ditolak { background: #fee2e2; color: #991b1b; border: 1px solid #ef4444; }
        .empty-state {
            text-align: center;
            padding: 50px 30px;
            color: #64748b;
            background: white;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        }
        .empty-state i {
            font-size: 56px;
            color: #00b4d8;
            margin-bottom: 20px;
        }
        .btn-kembali {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background-color: #eab308;
            color: #1e293b;
            padding: 10px 18px;
            font-weight: 700;
            border-radius: 8px;
            text-decoration: none;
            transition: all 0.2s;
            margin-bottom: 16px;
        }
        .btn-kembali:hover {
            background-color: #ca8a04;
            transform: translateY(-1px);
        }
        .btn-detail {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: #00b4d8;
            text-decoration: none;
            font-weight: 700;
            padding: 8px 14px;
            border-radius: 8px;
            background: rgba(0, 180, 216, 0.08);
            transition: all 0.2s;
        }
        .btn-detail:hover {
            background: rgba(0, 180, 216, 0.15);
            transform: translateY(-1px);
        }
    </style>
</head>
<body class="status-body" style="padding-top: 100px;">
    @include('partials.header')
    <div class="history-container">
        <a href="{{ url('/') }}" class="btn-kembali">
            <i class="fas fa-arrow-left"></i> Kembali ke Beranda
        </a>
        <div class="history-header">
            <h2>Riwayat Transaksi</h2>
            <span>Halo, {{ Session::get('user_name') }}</span>
        </div>

        <div class="user-info">
            @php
                $currentCount = $jumlahReservasi;
                
                // Determine current tier based on completed (Diterima) reservations only
                if ($currentCount >= 6) {
                    $currentTier = 'platinum';
                    $tierName = 'PLATINUM';
                    $tierIcon = '👑';
                    $nextTarget = null;
                    $progressPercent = 100;
                } elseif ($currentCount >= 3) {
                    $currentTier = 'gold';
                    $tierName = 'GOLD';
                    $tierIcon = '🥇';
                    $nextTarget = 6;
                    $progressPercent = min(100, (($currentCount - 2) / 3) * 100);
                } else {
                    $currentTier = 'silver';
                    $tierName = 'SILVER';
                    $tierIcon = '🥈';
                    $nextTarget = 3;
                    $progressPercent = ($currentCount / 3) * 100;
                }
            @endphp
            
            <h3>🏆 Jagara Loyalty Rewards</h3>
            <p class="description">Kumpulkan jumlah kunjungan Anda! Semakin sering Anda berwisata di Jagara Eco Park, semakin tinggi tingkatan Member Anda dan semakin banyak keuntungan eksklusif serta hadiah langsung yang otomatis Anda dapatkan.</p>
            
            <span class="discount-badge">
                <span>{{ $tierIcon }}</span>
                <span>{{ $tierName }} MEMBER</span>
            </span>
            
            @if($nextTarget)
                <div class="progress-container">
                    <div class="progress-track">
                        <div class="progress-fill" style="width: {{ $progressPercent }}%;"></div>
                    </div>
                    <div class="progress-text">
                        {{ $currentCount }} Reservasi Selesai •
                        @if($currentCount <= 2)
                            Next tier: {{ 3 - $currentCount }} Reservasi lagi untuk mencapai GOLD
                        @elseif($currentCount >= 3 && $currentCount <= 5)
                            Next tier: {{ 6 - $currentCount }} Reservasi lagi untuk mencapai PLATINUM
                        @else
                            Tingkatan Anda sudah maksimal (PLATINUM)!
                        @endif
                    </div>
                </div>
            @endif
            
            <div class="loyalty-tiers">
                <!-- Silver Tier -->
                <div class="tier-card silver {{ $currentTier == 'silver' ? 'current' : '' }}">
                    <div class="tier-header">
                        <span class="tier-icon">🥈</span>
                        <span class="tier-name">SILVER</span>
                        <span class="tier-range">0 - 2 Reservasi</span>
                    </div>
                    <div class="tier-perks">
                        ✅ Akses Reservasi Online Standar
                    </div>
                </div>
                
                <!-- Gold Tier -->
                <div class="tier-card gold {{ $currentTier == 'gold' ? 'current' : '' }}">
                    <div class="tier-header">
                        <span class="tier-icon">🥇</span>
                        <span class="tier-name">GOLD</span>
                        <span class="tier-range">3 - 5 Reservasi</span>
                    </div>
                    <div class="tier-perks">
                        ✅ POTONGAN HARGA 10% (Diskon Otomatis)<br>
                        ✅ Akses Antrean Jalur Cepat (Fast Track Line) di Lokasi Wisata
                    </div>
                </div>
                
                <!-- Platinum Tier -->
                <div class="tier-card platinum {{ $currentTier == 'platinum' ? 'current' : '' }}">
                    <div class="tier-header">
                        <span class="tier-icon">👑</span>
                        <span class="tier-name">PLATINUM</span>
                        <span class="tier-range">&gt; 5 Reservasi</span>
                    </div>
                    <div class="tier-perks">
                        ✅ POTONGAN HARGA 15% (Diskon Otomatis Setiap Reservasi)<br>
                        ✅ GRATIS 1 Tiket Wahana Pendukung (*Hanya diklaim 1x saat naik level)<br>
                        ✅ Hadiah Souvenir/Merchandise Eksklusif (*Hanya diklaim 1x di lokasi)
                    </div>
                </div>
            </div>
            
            @if($currentTier == 'platinum')
                <div class="platinum-voucher">
                    <h4>🎁 VOUCHER SOUVENIR & FREE PASS TIKET</h4>
                    <p>Tunjukkan QR Code Reservasi Anda ke Pusat Informasi Jagara untuk Penukaran Hadiah.</p>
                </div>
            @endif
        </div>

        @if($reservations->count() > 0)
            <table class="history-table">
                <thead>
                    <tr>
                        <th>Kode Reservasi</th>
                        <th>Tanggal</th>
                        <th>Fasilitas</th>
                        <th>Total Bayar</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reservations as $res)
                    <tr>
                        <td><strong>{{ $res->kode_reservasi }}</strong></td>
                        <td>{{ date('d M Y', strtotime($res->created_at)) }}</td>
                        <td>{{ $res->fasilitas->nama_fasilitas }}</td>
                        <td>Rp {{ number_format($res->total_bayar, 0, ',', '.') }}</td>
                        <td>
                            <span class="status-badge status-{{ strtolower($res->status) }}">
                                {{ $res->status }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('reservasi.status', ['kode_reservasi' => $res->kode_reservasi]) }}" 
                               class="btn-detail">
                                <i class="fas fa-eye"></i> Detail
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="empty-state">
                <i class="fas fa-receipt"></i>
                <h3>Belum Ada Transaksi</h3>
                <p>Mulai reservasi sekarang untuk melihat riwayat transaksi Anda.</p>
                <a href="{{ route('reservasi.buat') }}" 
                   style="display: inline-block; margin-top: 20px; background: linear-gradient(135deg, #00b4d8 0%, #0096c7 100%); color: white; padding: 12px 30px; border-radius: 10px; text-decoration: none; font-weight: 600;">
                    Reservasi Sekarang
                </a>
            </div>
        @endif
    </div>
</body>
</html>
