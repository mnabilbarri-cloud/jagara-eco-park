<aside class="sidebar">
    <div class="sidebar-header">
        <div class="logo-icon">
            <i class="fas fa-leaf"></i>
        </div>
        <h2>Jagara Eco Park</h2>
    </div>
    <nav class="sidebar-nav">
        <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="fas fa-home"></i>
            <span>Dashboard</span>
        </a>
        <a href="{{ route('fasilitas.index') }}" class="nav-item {{ request()->routeIs('fasilitas.*') ? 'active' : '' }}">
            <i class="fas fa-campground"></i>
            <span>Kelola Fasilitas</span>
        </a>
        <a href="{{ route('reservasi.index') }}" class="nav-item {{ request()->routeIs('reservasi.*') ? 'active' : '' }}">
            <i class="fas fa-calendar-check"></i>
            <span>Data Reservasi</span>
        </a>
        <a href="{{ route('admin.kuota') }}" class="nav-item {{ request()->routeIs('admin.kuota') ? 'active' : '' }}">
            <i class="fas fa-calendar-alt"></i>
            <span>Kelola Kuota Harian</span>
        </a>
        <a href="{{ route('admin.grafik') }}" class="nav-item {{ request()->routeIs('admin.grafik') ? 'active' : '' }}">
            <i class="fas fa-chart-bar"></i>
            <span>Pendapatan & Analisis Tren Bisnis</span>
        </a>
        <a href="{{ route('admin.petugas') }}" class="nav-item {{ request()->routeIs('admin.petugas') ? 'active' : '' }}">
            <i class="fas fa-users"></i>
            <span>Kelola Petugas Fasilitas</span>
        </a>
        <a href="{{ route('admin.testimoni') }}" class="nav-item {{ request()->routeIs('admin.testimoni') ? 'active' : '' }}">
            <i class="fas fa-comments"></i>
            <span>Kelola Testimoni & Ulasan</span>
        </a>
        <a href="{{ route('admin.loyalty') }}" class="nav-item {{ request()->routeIs('admin.loyalty') ? 'active' : '' }}">
            <i class="fas fa-trophy"></i>
            <span>Kelola Loyalty Rewards</span>
        </a>
    </nav>
    <div class="sidebar-footer">
        <a href="{{ route('logout') }}" class="btn-logout">
            <i class="fas fa-sign-out-alt"></i>
            <span>Keluar</span>
        </a>
    </div>
</aside>
