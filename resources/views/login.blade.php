<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Jagara Eco Park</title>
    <!-- Perbaikan: Menggunakan asset() -->
    <link rel="stylesheet" href="{{ asset('assets/login.css') }}">
</head>
<body>
    <div class="login-box">
        <h2>Login Admin</h2>

        <!-- Perbaikan: Menggunakan session error ala Laravel -->
        @if(session('error'))
            <p style="color: #d32f2f; background: #ffcdd2; padding: 10px; border-radius: 8px; text-align: center; font-size: 13px; margin-bottom: 20px; border: 1px solid #ef9a9a;">
                {{ session('error') }}
            </p>
        @endif

        <!-- Perbaikan: Action mengarah ke route 'login.proses' dan tambah @csrf -->
        <form action="{{ route('login.proses') }}" method="post">
            @csrf
            <label>Username</label>
            <input type="text" name="username" placeholder="Masukkan Username" required>
            
            <label>Password</label>
            <input type="password" name="password" placeholder="Masukkan Password" required>
            
            <button type="submit">Masuk</button>
        </form>
 
        <div class="back-home">
            <!-- Perbaikan: Mengarah ke halaman utama -->
            <a href="{{ url('/') }}" class="btn-back">← Kembali ke Website</a>
        </div>

        <div class="login-footer">
            Jagara Eco Park © {{ date('Y') }}
        </div>
    </div>
</body>
</html>