<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Testimoni & Ulasan - Jagara Eco Park</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/admin.css') }}">
    <style>
        .star-rating { color: #f59e0b; font-size: 15px; }
        .btn-action {
            display: inline-flex; align-items: center; justify-content: center;
            width: 38px; height: 38px; border-radius: 10px;
            border: 1px solid transparent; cursor: pointer;
            transition: all 0.2s ease; font-size: 15px; margin: 2px 4px;
            text-decoration: none;
        }
        .btn-action:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
        .btn-setujui  { background:#d1fae5; color:#059669; border-color:rgba(5,150,105,.2); }
        .btn-setujui:hover  { background:#059669; color:#fff; }
        .btn-sembunyikan { background:#fee2e2; color:#dc2626; border-color:rgba(220,38,38,.2); }
        .btn-sembunyikan:hover { background:#dc2626; color:#fff; }

        /* ── Modal ── */
        .modal-overlay { display:none; position:fixed; inset:0; background:rgba(15,23,42,.55);
            backdrop-filter:blur(4px); z-index:1000; align-items:center; justify-content:center; }
        .modal-overlay.active { display:flex; }
        .modal-card { background:#fff; border-radius:20px; padding:36px 40px; width:100%;
            max-width:520px; box-shadow:0 24px 60px rgba(0,0,0,.18); position:relative;
            animation:modalIn .25s ease; }
        @keyframes modalIn {
            from { opacity:0; transform:translateY(-20px) scale(.97); }
            to   { opacity:1; transform:translateY(0) scale(1); }
        }
        .modal-title { font-size:19px; font-weight:800; color:#0f172a; margin:0 0 5px; }
        .modal-subtitle { font-size:13px; color:#64748b; margin:0 0 26px; }
        .modal-close { position:absolute; top:16px; right:18px; background:none; border:none;
            font-size:18px; cursor:pointer; color:#94a3b8; transition:color .2s; }
        .modal-close:hover { color:#334155; }
        .form-group { margin-bottom:16px; }
        .form-label { display:block; font-size:13px; font-weight:600; color:#334155; margin-bottom:6px; }
        .form-input, .form-select, .form-textarea {
            width:100%; padding:10px 13px; border:1.5px solid #e2e8f0;
            border-radius:10px; font-size:14px; font-family:'Inter',sans-serif;
            color:#1e293b; background:#f8fafc; outline:none;
            transition:border-color .2s,box-shadow .2s; box-sizing:border-box;
        }
        .form-input:focus, .form-select:focus, .form-textarea:focus {
            border-color:#6366f1; box-shadow:0 0 0 3px rgba(99,102,241,.12); background:#fff;
        }
        .form-textarea { resize:vertical; min-height:90px; }
        .modal-actions { display:flex; gap:12px; margin-top:24px; justify-content:flex-end; }
        .btn-cancel { padding:10px 20px; border-radius:10px; border:1.5px solid #e2e8f0;
            background:#f8fafc; color:#475569; font-size:14px; font-weight:600; cursor:pointer;
            font-family:'Inter',sans-serif; }
        .btn-submit { padding:10px 24px; border-radius:10px; border:none;
            background:linear-gradient(135deg,#6366f1,#4f46e5); color:#fff; font-size:14px;
            font-weight:700; cursor:pointer; font-family:'Inter',sans-serif;
            display:inline-flex; align-items:center; gap:8px; }
        .btn-submit:hover { opacity:.9; }

        /* ── Alert ── */
        .alert-success { background:#d1fae5; border:1.5px solid #6ee7b7; color:#065f46;
            border-radius:12px; padding:13px 18px; margin-bottom:18px; font-size:14px;
            font-weight:600; display:flex; align-items:center; gap:10px; }
        .alert-error { background:#fee2e2; border:1.5px solid #fca5a5; color:#991b1b;
            border-radius:12px; padding:13px 18px; margin-bottom:18px; font-size:14px; font-weight:600; }

        /* ── Star input ── */
        .star-input { display:flex; gap:6px; flex-direction:row-reverse; justify-content:flex-end; }
        .star-input input { display:none; }
        .star-input label { font-size:26px; color:#d1d5db; cursor:pointer; transition:color .15s; }
        .star-input input:checked ~ label,
        .star-input label:hover,
        .star-input label:hover ~ label { color:#f59e0b; }

        .empty-state { text-align:center; padding:46px 20px; color:#94a3b8; }
        .empty-state i { font-size:38px; margin-bottom:12px; display:block; }
    </style>
</head>
<body>

<div class="admin-layout">
    @include('sidebar')

    <main class="main-content">
        <div class="page-header">
            <div class="page-header-text">
                <h1 class="page-title">Kelola Testimoni & Ulasan</h1>
                <p class="page-subtitle">Moderasi ulasan dan testimoni pelanggan sebelum ditampilkan</p>
                <span style="display:inline-block; margin-top:10px; background:#eef2ff; color:#4f46e5; padding:6px 12px; border-radius:8px; font-size:12px; font-weight:600; border:1px solid #c7d2fe;">
                    <i class="fas fa-info-circle"></i> Info Akademik: Ulasan diisi oleh pelanggan melalui halaman Status/Riwayat Reservasi setelah status menjadi 'Diterima'.
                </span>
            </div>
        </div>

        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert-error"><i class="fas fa-exclamation-circle" style="margin-right:8px;"></i> {{ session('error') }}</div>
        @endif
        @if($errors->any())
            <div class="alert-error">
                @foreach($errors->all() as $err) {{ $err }}<br> @endforeach
            </div>
        @endif

        <div class="widget-card">
            <div class="widget-header">
                <h3 class="widget-title">
                    <i class="fas fa-star" style="margin-right:10px;"></i>
                    Daftar Testimoni & Ulasan
                    <span style="margin-left:10px;background:#e0e7ff;color:#4338ca;font-size:12px;
                        padding:3px 12px;border-radius:100px;font-weight:700;">
                        {{ $testimonis->count() }} Ulasan
                    </span>
                </h3>
            </div>
            <div class="quota-table-wrapper" style="overflow-x: auto;">
                <table class="quota-table" style="width: 100%; min-width: 800px; font-size: 15px;">
                    <thead>
                        <tr>
                            <th style="width:18%; padding: 12px 16px;">Nama Pelanggan</th>
                            <th style="width:18%; padding: 12px 16px;">Fasilitas yang Dinilai</th>
                            <th style="width:14%; padding: 12px 16px; text-align: center;">Rating Bintang</th>
                            <th style="width:35%; padding: 12px 16px;">Isi Komentar/Kesan</th>
                            <th style="width:15%; padding: 12px 16px; text-align: center;">Aksi Moderasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($testimonis as $t)
                            <tr>
                                <td style="font-weight:700;color:var(--slate-800); padding: 12px 16px;">{{ $t->nama_pengunjung }}</td>
                                <td style="color:var(--slate-600); padding: 12px 16px;">{{ $t->nama_fasilitas }}</td>
                                <td style="padding: 12px 16px;">
                                    <div style="display: flex; align-items: center; justify-content: center; gap: 4px; white-space: nowrap; color: #ffc107;">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $t->rating)
                                                <i class="fas fa-star"></i>
                                            @else
                                                <i class="far fa-star" style="color:#d1d5db;"></i>
                                            @endif
                                        @endfor
                                    </div>
                                </td>
                                <td style="color:var(--slate-600);white-space:normal;word-break:break-word; padding: 12px 16px;">
                                    {{ $t->komentar }}
                                </td>
                                <td style="padding: 12px 16px;">
                                    <div style="display:flex;gap:8px;justify-content:center;align-items:center;flex-wrap:wrap;">
                                        <button onclick="konfirmasiModerasi({{ $t->id_testimoni }}, 'setujui')"
                                                class="btn-action btn-setujui" title="Setujui Tampilkan">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button onclick="konfirmasiModerasi({{ $t->id_testimoni }}, 'sembunyikan')"
                                                class="btn-action btn-sembunyikan" title="Sembunyikan">
                                            <i class="fas fa-eye-slash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">
                                    <div class="empty-state">
                                        <i class="fas fa-comment-slash"></i>
                                        <p>Belum ada testimoni. Ulasan diisi oleh pelanggan melalui halaman Status/Riwayat Reservasi setelah status menjadi 'Diterima'.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>

{{-- Modal Add Testimoni dihilangkan dari sisi Admin --}}

<script>

    function konfirmasiModerasi(id, aksi) {
        Swal.fire({
            title: aksi === 'setujui' ? 'Setujui Testimoni?' : 'Sembunyikan Testimoni?',
            text: 'Tindakan ini akan mengubah status tampil testimoni.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: aksi === 'setujui' ? '#059669' : '#dc2626',
            confirmButtonText: 'Ya, Proses!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire(
                    'Berhasil!',
                    aksi === 'setujui' ? 'Testimoni telah disetujui dan ditampilkan.' : 'Testimoni telah disembunyikan.',
                    'success'
                );
            }
        });
    }
</script>

</body>
</html>
