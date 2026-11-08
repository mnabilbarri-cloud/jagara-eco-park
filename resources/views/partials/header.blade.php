<header class="header" id="mainHeader">
    <div class="brand">
        <img src="{{ asset('assets/images/logo.jpg') }}"
             class="logo"
             alt="Logo"
             style="height:40px;border-radius:50%;">
        <h1>Jagara Eco Park</h1>
    </div>

    <ul class="nav-menu">
        <li><a href="{{ route('home') }}">Beranda</a></li>
        <li><a href="{{ route('home') }}#fasilitas">Fasilitas & Wahana</a></li>
        <li><a href="{{ route('daftar_harga') }}">Daftar Harga</a></li>
        <li><a href="{{ route('lokasi') }}">Lokasi</a></li>
        <li><a href="{{ route('protokol') }}">Protokol</a></li>
    </ul>

    <div class="nav-btns">
        @if(Session::has('user_login'))
            <a href="{{ route('user.history') }}" class="btn-admin">
                Riwayat
            </a>
            <a href="{{ route('user.logout') }}" class="btn-admin">
                Logout ({{ Session::get('user_name') }})
            </a>
        @else
            <a href="{{ route('user.login') }}" class="btn-admin">
                Login
            </a>
            <a href="{{ route('register') }}" class="btn-admin">
                Daftar
            </a>
            <a href="{{ route('login') }}" class="btn-admin">
                Admin
            </a>
        @endif
    </div>
</header>

<!-- Feedback Alert -->
@if(session('success'))
    <div style="position: fixed; top: 80px; right: 20px; background: #e0f2fe; color: #0369a1; padding: 15px 25px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.2); z-index: 2000; border-left: 4px solid #0369a1; animation: slideIn 0.5s ease-out;">
        <i class="fas fa-check-circle" style="margin-right: 10px;"></i>
        {{ session('success') }}
    </div>
    <script>
        setTimeout(function() {
            document.querySelector('[style*="position: fixed"][style*="top: 80px"]').style.display = 'none';
        }, 5000);
    </script>
@endif

@if(session('error'))
    <div style="position: fixed; top: 80px; right: 20px; background: #f8d7da; color: #721c24; padding: 15px 25px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.2); z-index: 2000; border-left: 4px solid #dc3545; animation: slideIn 0.5s ease-out;">
        <i class="fas fa-exclamation-circle" style="margin-right: 10px;"></i>
        {{ session('error') }}
    </div>
    <script>
        setTimeout(function() {
            document.querySelector('[style*="position: fixed"][style*="top: 80px"]').style.display = 'none';
        }, 5000);
    </script>
@endif

<style>
    @keyframes slideIn {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
</style>
