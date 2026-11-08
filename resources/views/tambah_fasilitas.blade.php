<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Fasilitas - Jagara Eco Park</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/admin.css') }}">
    
    <style>
        .form-card {
            background: white;
            width: 100%;
            max-width: 600px;
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            border: 1px solid var(--slate-200);
        }
        label {
            display: block;
            font-weight: 600;
            color: var(--slate-700);
            margin-bottom: 8px;
            font-size: 0.9rem;
        }
        .input-group { margin-bottom: 24px; }
        input[type="text"], 
        input[type="number"], 
        textarea,
        select {
            width: 100%;
            padding: 14px 18px;
            border: 1px solid var(--slate-300);
            border-radius: 12px;
            font-family: inherit;
            box-sizing: border-box;
            transition: all 0.2s ease;
            font-size: 1rem;
        }
        input:focus, textarea:focus, select:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
        }
        input[type="file"] {
            padding: 14px;
            background: var(--slate-50);
            border-radius: 12px;
            border: 2px dashed var(--slate-300);
            width: 100%;
            box-sizing: border-box;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        input[type="file"]:hover { border-color: var(--primary); background: rgba(59,130,246,0.05); }
        .btn-container {
            display: flex;
            gap: 16px;
            margin-top: 32px;
        }
        .btn-cancel {
            flex: 1;
            background: var(--slate-100);
            color: var(--slate-700);
            text-decoration: none;
            text-align: center;
            padding: 14px;
            border-radius: 12px;
            font-weight: 700;
            transition: all 0.2s ease;
            border: 1px solid var(--slate-300);
        }
        .btn-cancel:hover { background: var(--slate-200); color: var(--slate-800); }
    </style>
</head>
<body>

<div class="admin-layout">
    @include('sidebar')

    <main class="main-content" style="display: flex; align-items: center; justify-content: center; padding-top: 60px;">
        <div class="form-card">
            <h2 style="margin: 0 0 8px 0; color: var(--slate-800); font-weight: 800; font-size: 1.75rem;">
                <i class="fas fa-plus-circle" style="color: var(--primary); margin-right: 10px;"></i>Tambah Fasilitas Baru
            </h2>
            <p style="margin: 0 0 36px 0; color: var(--slate-500); font-size: 0.95rem;">Isi semua detail fasilitas di bawah ini</p>
            
            <form action="{{ route('fasilitas.simpan') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="input-group">
                    <label>Nama Fasilitas</label>
                    <input type="text" name="nama_fasilitas" placeholder="Contoh: Kolam Renang" required>
                </div>

                <div class="input-group">
                    <label>Harga Tiket (IDR)</label>
                    <input type="number" name="harga" placeholder="Masukkan 0 jika gratis" required>
                </div>

                <div class="input-group">
                    <label>Deskripsi Keterangan</label>
                    <textarea name="keterangan" rows="4" placeholder="Jelaskan detail fasilitas..." required></textarea>
                </div>

                <div class="input-group">
                    <label>Tipe Fasilitas</label>
                    <select name="tipe">
                        <option value="reservasi">Reservasi (Berbayar)</option>
                        <option value="umum">Umum (Gratis)</option>
                    </select>
                </div>

                <div class="input-group">
                    <label>Kapasitas Pengunjung (orang)</label>
                    <input type="number" name="kapasitas" placeholder="Contoh: 50" min="1" value="50" required>
                </div>

                <div class="input-group">
                    <label>Foto Visual Fasilitas</label>
                    <input type="file" name="gambar" accept=".jpg,.jpeg,.png" required>
                    <small style="color: var(--slate-500); margin-top: 8px; display: block;">
                        <i class="fas fa-info-circle"></i> Format gambar: JPG atau PNG (maksimal 2MB)
                    </small>
                </div>
                
                <div class="btn-container">
                    <a href="{{ route('fasilitas.index') }}" class="btn-cancel">Batal</a>
                    <button type="submit" class="btn-primary" style="flex: 2; font-size: 1rem; text-transform: none;">
                        <i class="fas fa-save"></i> Simpan Data Fasilitas
                    </button>
                </div>
            </form>
        </div>
    </main>
</div>

</body>
</html>
