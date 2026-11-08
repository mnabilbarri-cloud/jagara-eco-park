<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Fasilitas - Jagara Eco Park</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="{{ asset('assets/admin.css') }}">

    <style>
        .img-wrapper img {
            width: 100px;
            height: 65px;
            object-fit: cover;
            border-radius: 10px;
            border: 2px solid var(--slate-200);
            display: block;
        }
        .price-text {
            font-weight: 800;
            color: var(--accent);
            font-size: 1rem;
        }
        .badge-free {
            background: #dcfce7;
            color: #166534;
            padding: 6px 14px;
            border-radius: 100px;
            font-weight: 700;
            font-size: 0.75rem;
            border: 1px solid #86efac;
        }
        .table-footer {
            padding: 20px;
            background: var(--slate-50);
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-top: 1px solid var(--slate-200);
            border-radius: 0 0 16px 16px;
        }
    </style>
</head>
<body>

<div class="admin-layout">
    @include('sidebar')

    <main class="main-content">
        <div class="page-header">
            <div class="page-header-text">
                <h1 class="page-title">Kelola Fasilitas</h1>
                <p class="page-subtitle">Tambah, edit, dan hapus data fasilitas wisata</p>
            </div>
        </div>

        <div class="widget-card" style="padding: 0;">
            <div style="overflow-x: auto;">
                <table class="quota-table">
                    <thead>
                        <tr>
                            <th style="width: 60px; text-align: center;">No</th>
                            <th style="width: 140px; text-align: center;">Visual</th>
                            <th>Nama Fasilitas</th>
                            <th style="width: 180px;">Harga Tiket</th>
                            <th>Keterangan Deskripsi</th>
                            <th style="width: 240px; text-align: center;">Opsi Pengelolaan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($fasilitas as $key => $f)
                        <tr>
                            <td style="text-align: center; font-weight: 700; color: var(--slate-500);">{{ $key + 1 }}</td>
                            <td style="text-align: center;">
                                <div class="img-wrapper" style="display: flex; justify-content: center;">
                                    <img src="{{ asset('assets/images/' . $f->gambar) }}" alt="facility">
                                </div>
                            </td>
                            <td>
                                <div style="font-weight: 700; color: var(--slate-800); font-size: 1rem;">
                                    {{ $f->nama_fasilitas }}
                                </div>
                            </td>
                            <td>
                                @if($f->harga <= 0)
                                    <span class="badge-free">GRATIS</span>
                                @else
                                    <span class="price-text">Rp {{ number_format($f->harga, 0, ',', '.') }}</span>
                                @endif
                            </td>
                            <td style="font-size: 0.9rem; color: var(--slate-600); line-height: 1.6;">
                                {{ Str::limit($f->keterangan, 160) }}
                            </td>
                            <td style="text-align: center;">
                                <div style="display: flex; gap: 10px; justify-content: center;">
                                    <a href="{{ route('fasilitas.edit', $f->id_fasilitas) }}" style="px-3 py-1.5 bg-indigo-50 text-indigo-600 hover:bg-indigo-600 hover:text-white rounded-lg text-xs font-semibold transition-all duration-200 flex items-center inline-flex gap-1 shadow-sm; padding: 6px 12px; background-color: #eef2ff; color: #4f46e5; border-radius: 8px; font-size: 0.75rem; font-weight: 600; display: inline-flex; align-items: center; gap: 6px; box-shadow: 0 1px 2px 0 rgba(0,0,0,0.05); transition: all 0.2s ease;" onmouseover="this.style.backgroundColor='#4f46e5'; this.style.color='white';" onmouseout="this.style.backgroundColor='#eef2ff'; this.style.color='#4f46e5';">
                                        <i class="fas fa-pencil-alt"></i> Ubah
                                    </a>
                                    <a href="javascript:void(0)" onclick="confirmDelete('{{ $f->id_fasilitas }}', '{{ $f->nama_fasilitas }}')" style="px-3 py-1.5 bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white rounded-lg text-xs font-semibold transition-all duration-200 flex items-center inline-flex gap-1 shadow-sm; padding: 6px 12px; background-color: #fff1f2; color: #e11d48; border-radius: 8px; font-size: 0.75rem; font-weight: 600; display: inline-flex; align-items: center; gap: 6px; box-shadow: 0 1px 2px 0 rgba(0,0,0,0.05); transition: all 0.2s ease;" onmouseover="this.style.backgroundColor='#e11d48'; this.style.color='white';" onmouseout="this.style.backgroundColor='#fff1f2'; this.style.color='#e11d48';">
                                        <i class="fas fa-trash-alt"></i> Hapus
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" style="padding: 100px; text-align: center; background: white;">
                                <i class="fas fa-folder-open" style="font-size: 3rem; color: var(--slate-300); margin-bottom: 12px;"></i>
                                <p style="color: var(--slate-500); font-weight: 600; margin: 0;">Belum ada data fasilitas tersimpan.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="table-footer">
                <a href="{{ route('dashboard') }}" class="btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
                </a>
                <a href="{{ route('fasilitas.tambah') }}" class="btn-primary">
                    <i class="fas fa-plus-circle"></i> Tambah Fasilitas Baru
                </a>
            </div>
        </div>
    </main>
</div>

<script>
    function confirmDelete(id, nama) {
        Swal.fire({
            title: 'Hapus Fasilitas?',
            text: "Data '" + nama + "' akan dihapus secara permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            confirmButtonText: 'YA, HAPUS',
            cancelButtonText: 'BATAL'
        }).then((result) => {
            if (result.isConfirmed) {
                let form = document.createElement('form');
                form.method = 'POST';
                form.action = "{{ url('/fasilitas-hapus') }}/" + id;
                
                let csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = "{{ csrf_token() }}";
                
                let methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'DELETE';
                
                form.appendChild(csrfInput);
                form.appendChild(methodInput);
                document.body.appendChild(form);
                form.submit();
            }
        });
    }
</script>

@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'BERHASIL!',
        text: "{{ session('success') }}",
        timer: 2000,
        showConfirmButton: false
    });
</script>
@endif

</body>
</html>
