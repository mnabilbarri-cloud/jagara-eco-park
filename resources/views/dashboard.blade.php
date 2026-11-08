<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Jagara Eco Park</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/admin.css') }}">
</head>
<body>

<div class="admin-layout">
    @include('sidebar')

    <!-- Main Content -->
    <main class="main-content">
        <div class="page-header">
            <div class="page-header-text">
                <h1 class="page-title">Dashboard Admin</h1>
                <p class="page-subtitle">Selamat datang di sistem manajemen Jagara Eco Park. Pantau dan kelola semua aktivitas operasional.</p>
            </div>
            <div style="text-align: right;">
                <p style="margin:0; color: var(--slate-500); font-size:13px; font-weight:500;">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</p>
            </div>
        </div>

        <!-- Time Filter Pills -->
        <div class="filter-section">
            <div class="filter-box">
                <a href="?periode=hari" class="filter-pill {{ $filter == 'hari' ? 'active-filter' : '' }}">Hari Ini</a>
                <a href="?periode=minggu" class="filter-pill {{ $filter == 'minggu' ? 'active-filter' : '' }}">1 Minggu</a>
                <a href="?periode=bulan" class="filter-pill {{ $filter == 'bulan' ? 'active-filter' : '' }}">Bulan Ini</a>
                <a href="?periode=bulan_lalu" class="filter-pill {{ $filter == 'bulan_lalu' ? 'active-filter' : '' }}">Bulan Kemarin</a>
                <a href="?periode=semua" class="filter-pill {{ $filter == 'semua' ? 'active-filter' : '' }}">Semua Data</a>
            </div>
        </div>

        <!-- Metrics Grid -->
        <div class="stat-grid">
            <!-- Row 1 -->
            <div class="stat-card bg-fasilitas">
                <div class="stat-card-icon">
                    <i class="fas fa-building"></i>
                </div>
                <h4>Total Fasilitas</h4>
                <span>{{ $totalFasilitas }}</span>
            </div>
            <div class="stat-card bg-reservasi">
                <div class="stat-card-icon">
                    <i class="fas fa-ticket-alt"></i>
                </div>
                <h4>Total Reservasi</h4>
                <span>{{ $totalReservasi }}</span>
            </div>
            <div class="stat-card bg-diterima">
                <div class="stat-card-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <h4>Reservasi Diterima</h4>
                <span>{{ $totalDiterima }}</span>
            </div>

            <!-- Row 2 -->
            <div class="stat-card bg-menunggu">
                <div class="stat-card-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <h4>Menunggu Konfirmasi</h4>
                <span>{{ $totalMenunggu }}</span>
            </div>
            <div class="stat-card bg-ditolak">
                <div class="stat-card-icon">
                    <i class="fas fa-times-circle"></i>
                </div>
                <h4>Reservasi Ditolak</h4>
                <span>{{ $totalDitolak }}</span>
            </div>
            <div class="stat-card bg-pendapatan">
                <div class="stat-card-icon">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <h4>Total Pendapatan</h4>
                <span>Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</span>
            </div>
        </div>

        <!-- Management Cards -->
        <div class="dashboard-grid">
            <div class="dashboard-card fasilitas">
                <div class="dashboard-card-icon">
                    <i class="fas fa-campground"></i>
                </div>
                <h3>Kelola Fasilitas</h3>
                <p>Tambah, edit, dan hapus data fasilitas wisata</p>
                <a href="{{ route('fasilitas.index') }}" class="btn-primary">
                    <i class="fas fa-external-link-alt"></i>
                    Buka Manajemen
                </a>
            </div>
            <div class="dashboard-card reservasi">
                <div class="dashboard-card-icon">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <h3>Data Reservasi</h3>
                <p>Kelola dan konfirmasi semua reservasi pengunjung</p>
                <a href="{{ route('reservasi.index') }}" class="btn-primary">
                    <i class="fas fa-external-link-alt"></i>
                    Buka Manajemen
                </a>
            </div>
        </div>

        <!-- Last Month Comparison Widget -->
        <div class="widget-card">
            <div class="widget-header">
                <h3 class="widget-title">Komparasi Bulan Kemarin</h3>
            </div>
            <div class="comparison-grid">
                <div class="comparison-item">
                    <h4>Menunggu</h4>
                    <span>{{ $lastMonthMenunggu }}</span>
                </div>
                <div class="comparison-item">
                    <h4>Diterima</h4>
                    <span>{{ $lastMonthDiterima }}</span>
                </div>
                <div class="comparison-item">
                    <h4>Ditolak</h4>
                    <span>{{ $lastMonthDitolak }}</span>
                </div>
            </div>
        </div>

        <!-- Quick Links Widget to New Features -->
        <div class="widget-card">
            <div class="widget-header">
                <h3 class="widget-title">
                    <i class="fas fa-th-large" style="margin-right:10px;"></i>
                    Akses Fitur Cepat
                </h3>
            </div>
            <div class="comparison-grid">
                <div class="comparison-item" style="cursor:pointer; transition:transform 0.2s;" onclick="window.location='{{ route('admin.grafik') }}'">
                    <i class="fas fa-chart-line" style="font-size:2rem; color:var(--primary); margin-bottom:8px;"></i>
                    <h4>Grafik Pendapatan</h4>
                </div>
                <div class="comparison-item" style="cursor:pointer; transition:transform 0.2s;" onclick="window.location='{{ route('admin.kuota') }}'">
                    <i class="fas fa-calendar-alt" style="font-size:2rem; color:var(--accent); margin-bottom:8px;"></i>
                    <h4>Kuota Harian</h4>
                </div>
                <div class="comparison-item" style="cursor:pointer; transition:transform 0.2s;" onclick="window.location='{{ route('admin.loyalty') }}'">
                    <i class="fas fa-trophy" style="font-size:2rem; color:#10b981; margin-bottom:8px;"></i>
                    <h4>Loyalty Rewards</h4>
                </div>
            </div>
        </div>
    </main>
</div>

</body>
</html>
