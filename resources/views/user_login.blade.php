<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Pengunjung - Jagara Eco Park</title>
    <link rel="stylesheet" href="{{ asset('assets/index.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/reservasi.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="status-body" style="padding-top: 100px;">
    @include('partials.header')
    <div class="card">
        <h2>Login Pengunjung</h2>

        @if(session('success'))
            <div style="background: #d4edda; color: #155724; padding: 12px; border-radius: 8px; margin-bottom: 20px; text-align: center;">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div style="background: #f8d7da; color: #721c24; padding: 12px; border-radius: 8px; margin-bottom: 20px; text-align: center;">
                {{ session('error') }}
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

        <form action="{{ route('user.login.proses') }}" method="POST">
            @csrf
            
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="Masukkan email" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Masukkan password" required>

            <div style="text-align: right; margin-top: 8px; margin-bottom: 16px;">
                <a href="javascript:void(0);" onclick="showResetPasswordSimulation();" style="font-size: 0.875rem; color: #0ea5e9; text-decoration: none; transition: color 0.15s ease-in-out; font-weight: 500;" onmouseover="this.style.color='#0284c7'" onmouseout="this.style.color='#0ea5e9'">
                    Lupa Password?
                </a>
            </div>

            <button type="submit" class="submit-btn">Login</button>
        </form>

        <div class="form-nav">
            <a href="{{ route('home') }}" class="nav-btn btn-home-grey"><i class="fas fa-home"></i> Beranda</a>
            <a href="{{ route('register') }}" class="nav-btn btn-status-blue"><i class="fas fa-user-plus"></i> Daftar</a>
        </div>
    </div>

    <script>
        function showResetPasswordSimulation() {
            let email = prompt("Masukkan Email terdaftar Anda untuk mereset password:");
            if (email) {
                alert("Sistem Demo UAS: Instruksi pengaturan ulang kata sandi telah dikirimkan ke email: " + email);
            }
        }
    </script>
</body>
</html>
