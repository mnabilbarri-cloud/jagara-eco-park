<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi - Jagara Eco Park</title>
    <link rel="stylesheet" href="{{ asset('assets/index.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/reservasi.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="status-body" style="padding-top: 100px;">
    @include('partials.header')
    <div class="card">
        <h2>Registrasi Akun</h2>

        @if(session('success'))
            <div style="background: #d4edda; color: #155724; padding: 12px; border-radius: 8px; margin-bottom: 20px; text-align: center;">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div style="background: #f8d7da; color: #721c24; padding: 12px; border-radius: 8px; margin-bottom: 20px;">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register.proses') }}" method="POST">
            @csrf
            
            <label for="name">Nama Lengkap</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Masukkan nama lengkap" required>

            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="Masukkan email" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Minimal 6 karakter" required>

            <label for="password_confirmation">Konfirmasi Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Ulangi password" required>

            <button type="submit" class="submit-btn">Daftar</button>
        </form>

        <div class="form-nav">
            <a href="{{ route('home') }}" class="nav-btn btn-home-grey"><i class="fas fa-home"></i> Beranda</a>
            <a href="{{ route('user.login') }}" class="nav-btn btn-status-blue"><i class="fas fa-sign-in-alt"></i> Login</a>
        </div>
    </div>
</body>
</html>
