<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Petugas Fasilitas - Jagara Eco Park</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/admin.css') }}">
    <style>
        /* ── Modal Overlay ── */
        .modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.55);
            backdrop-filter: blur(4px);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }
        .modal-overlay.active { display: flex; }

        /* ── Modal Card ── */
        .modal-card {
            background: #ffffff;
            border-radius: 20px;
            padding: 36px 40px;
            width: 100%;
            max-width: 520px;
            box-shadow: 0 24px 60px rgba(0,0,0,0.18);
            position: relative;
            animation: modalIn 0.25s ease;
        }
        @keyframes modalIn {
            from { opacity: 0; transform: translateY(-24px) scale(0.97); }
            to   { opacity: 1; transform: translateY(0)    scale(1);    }
        }

        .modal-title {
            font-size: 20px;
            font-weight: 800;
            color: var(--slate-900, #0f172a);
            margin: 0 0 6px;
        }
        .modal-subtitle {
            font-size: 13px;
            color: var(--slate-500, #64748b);
            margin: 0 0 28px;
        }
        .modal-close {
            position: absolute;
            top: 18px; right: 20px;
            background: none; border: none;
            font-size: 18px; cursor: pointer;
            color: var(--slate-400, #94a3b8);
            transition: color .2s;
        }
        .modal-close:hover { color: var(--slate-700, #334155); }

        /* ── Form Inputs ── */
        .form-group { margin-bottom: 18px; }
        .form-label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: var(--slate-700, #334155);
            margin-bottom: 6px;
        }
        .form-input, .form-select {
            width: 100%;
            padding: 11px 14px;
            border: 1.5px solid #e2e8f0;
            border-radius: 10px;
            font-size: 14px;
            font-family: 'Inter', sans-serif;
            color: var(--slate-800, #1e293b);
            background: #f8fafc;
            outline: none;
            transition: border-color .2s, box-shadow .2s;
            box-sizing: border-box;
        }
        .form-input:focus, .form-select:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99,102,241,0.12);
            background: #ffffff;
        }

        /* ── Modal Actions ── */
        .modal-actions {
            display: flex;
            gap: 12px;
            margin-top: 28px;
            justify-content: flex-end;
        }
        .btn-cancel {
            padding: 10px 22px;
            border-radius: 10px;
            border: 1.5px solid #e2e8f0;
            background: #f8fafc;
            color: var(--slate-600, #475569);
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            font-family: 'Inter', sans-serif;
            transition: background .2s;
        }
        .btn-cancel:hover { background: #f1f5f9; }
        .btn-submit {
            padding: 10px 26px;
            border-radius: 10px;
            border: none;
            background: linear-gradient(135deg, #6366f1, #4f46e5);
            color: #ffffff;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            font-family: 'Inter', sans-serif;
            transition: opacity .2s, transform .15s;
            display: inline-flex; align-items: center; gap: 8px;
        }
        .btn-submit:hover { opacity: .9; transform: translateY(-1px); }

        /* ── Alert ── */
        .alert-success {
            background: #d1fae5;
            border: 1.5px solid #6ee7b7;
            color: #065f46;
            border-radius: 12px;
            padding: 14px 18px;
            margin-bottom: 20px;
            font-size: 14px;
            font-weight: 600;
            display: flex; align-items: center; gap: 10px;
        }
        .alert-error {
            background: #fee2e2;
            border: 1.5px solid #fca5a5;
            color: #991b1b;
            border-radius: 12px;
            padding: 14px 18px;
            margin-bottom: 20px;
            font-size: 14px;
            font-weight: 600;
        }

        /* ── Empty State ── */
        .empty-state {
            text-align: center;
            padding: 50px 20px;
            color: var(--slate-400, #94a3b8);
        }
        .empty-state i { font-size: 40px; margin-bottom: 12px; display: block; }
        .empty-state p { font-size: 14px; }

        /* ── Action Buttons ── */
        .action-buttons {
            display: flex;
            gap: 8px;
            align-items: center;
        }
        .btn-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            transition: all 0.2s ease;
            color: #fff;
            font-size: 14px;
        }
        .btn-icon-edit {
            background: #f59e0b;
            box-shadow: 0 2px 4px rgba(245, 158, 11, 0.2);
        }
        .btn-icon-edit:hover {
            background: #d97706;
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(245, 158, 11, 0.3);
        }
        .btn-icon-delete {
            background: #ef4444;
            box-shadow: 0 2px 4px rgba(239, 68, 68, 0.2);
        }
        .btn-icon-delete:hover {
            background: #dc2626;
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(239, 68, 68, 0.3);
        }
    </style>
</head>
<body>

<div class="admin-layout">
    @include('sidebar')

    <main class="main-content">
        <div class="page-header">
            <div class="page-header-text">
                <h1 class="page-title">Kelola Petugas Fasilitas</h1>
                <p class="page-subtitle">Manajemen data petugas dan penempatan di wahana/fasilitas</p>
            </div>
            <div>
                <button class="btn-primary" style="display:inline-flex;align-items:center;gap:8px;"
                        onclick="document.getElementById('modalTambahPetugas').classList.add('active')">
                    <i class="fas fa-plus"></i>
                    Tambah Petugas
                </button>
            </div>
        </div>

        {{-- ── Success / Error Flash ── --}}
        @if(session('success'))
            <div class="alert-success">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif
        @if($errors->any())
            <div class="alert-error">
                <i class="fas fa-exclamation-circle" style="margin-right:8px;"></i>
                @foreach($errors->all() as $err)
                    {{ $err }}<br>
                @endforeach
            </div>
        @endif

        <div class="widget-card">
            <div class="widget-header">
                <h3 class="widget-title">
                    <i class="fas fa-user-tie" style="margin-right:10px;"></i>
                    Daftar Petugas Fasilitas
                </h3>
            </div>
            <div class="quota-table-wrapper">
                <table class="quota-table">
                    <thead>
                        <tr>
                            <th>Nama Petugas</th>
                            <th>Jabatan</th>
                            <th>Kontak/No HP</th>
                            <th>Penempatan Wahana/Fasilitas</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($petugas as $p)
                            <tr>
                                <td style="font-weight:700;color:var(--slate-800);">{{ $p->nama_petugas }}</td>
                                <td style="color:var(--slate-600);">{{ $p->jabatan }}</td>
                                <td style="color:var(--slate-600);">{{ $p->no_hp ?? '-' }}</td>
                                <td style="color:var(--slate-600);">
                                    {!! $p->nama_fasilitas ?? '<span style="color:#94a3b8;font-style:italic;">Belum ditetapkan</span>' !!}
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <button type="button" class="btn-icon btn-icon-edit" title="Edit Petugas" onclick="openEditPetugasModal({{ $p->id_petugas }}, '{{ addslashes($p->nama_petugas) }}', '{{ $p->jabatan }}', '{{ $p->no_hp }}', '{{ $p->id_fasilitas }}')">
                                            <i class="fas fa-edit"></i>
                                        </button>

                                        <form action="{{ route('admin.petugas.destroy', $p->id_petugas) }}" method="POST" style="margin:0;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus petugas ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-icon btn-icon-delete" title="Hapus Petugas">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4">
                                    <div class="empty-state">
                                        <i class="fas fa-users-slash"></i>
                                        <p>Belum ada data petugas. Klik <strong>+ Tambah Petugas</strong> untuk menambahkan.</p>
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

{{-- ══════════════════════════════════════
     MODAL – TAMBAH PETUGAS
══════════════════════════════════════ --}}
<div class="modal-overlay" id="modalTambahPetugas">
    <div class="modal-card">
        <button class="modal-close" type="button"
                onclick="document.getElementById('modalTambahPetugas').classList.remove('active')">
            <i class="fas fa-times"></i>
        </button>

        <p class="modal-title"><i class="fas fa-user-plus" style="margin-right:10px;color:#6366f1;"></i>Tambah Petugas Baru</p>
        <p class="modal-subtitle">Isi data berikut untuk mendaftarkan petugas ke dalam sistem.</p>

        <form action="{{ route('admin.petugas.simpan') }}" method="POST">
            @csrf

            <div class="form-group">
                <label class="form-label" for="nama_petugas">Nama Petugas <span style="color:#ef4444;">*</span></label>
                <input class="form-input" type="text" id="nama_petugas" name="nama_petugas"
                       placeholder="Contoh: Budi Santoso" value="{{ old('nama_petugas') }}" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="jabatan">Jabatan <span style="color:#ef4444;">*</span></label>
                <input class="form-input" type="text" id="jabatan" name="jabatan"
                       placeholder="Contoh: Petugas Wahana / Penjaga Gerbang" value="{{ old('jabatan') }}" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="no_hp">No HP / Kontak</label>
                <input class="form-input" type="text" id="no_hp" name="no_hp"
                       placeholder="Contoh: 0812-3456-7890" value="{{ old('no_hp') }}">
            </div>

            <div class="form-group">
                <label class="form-label" for="id_fasilitas">Penempatan Wahana/Fasilitas</label>
                <select class="form-select" id="id_fasilitas" name="id_fasilitas">
                    <option value="">— Pilih Fasilitas (Opsional) —</option>
                    @foreach($fasilitas as $f)
                        <option value="{{ $f->id_fasilitas }}"
                            {{ old('id_fasilitas') == $f->id_fasilitas ? 'selected' : '' }}>
                            {{ $f->nama_fasilitas }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="modal-actions">
                <button type="button" class="btn-cancel"
                        onclick="document.getElementById('modalTambahPetugas').classList.remove('active')">
                    Batal
                </button>
                <button type="submit" class="btn-submit">
                    <i class="fas fa-save"></i> Simpan Petugas
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ══════════════════════════════════════
     MODAL – EDIT PETUGAS
══════════════════════════════════════ --}}
<div class="modal-overlay" id="modalEditPetugas">
    <div class="modal-card">
        <button class="modal-close" type="button"
                onclick="document.getElementById('modalEditPetugas').classList.remove('active')">
            <i class="fas fa-times"></i>
        </button>

        <p class="modal-title"><i class="fas fa-user-edit" style="margin-right:10px;color:#f59e0b;"></i>Edit Petugas</p>
        <p class="modal-subtitle">Perbarui data petugas di bawah ini.</p>

        <form action="{{ route('admin.petugas.update') }}" method="POST">
            @csrf
            @method('PUT')
            
            <input type="hidden" name="id_petugas" id="edit_id_petugas">

            <div class="form-group">
                <label class="form-label" for="edit_nama_petugas">Nama Petugas <span style="color:#ef4444;">*</span></label>
                <input class="form-input" type="text" id="edit_nama_petugas" name="nama_petugas" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="edit_jabatan">Jabatan <span style="color:#ef4444;">*</span></label>
                <input class="form-input" type="text" id="edit_jabatan" name="jabatan" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="edit_no_hp">No HP / Kontak</label>
                <input class="form-input" type="text" id="edit_no_hp" name="no_hp">
            </div>

            <div class="form-group">
                <label class="form-label" for="edit_id_fasilitas">Penempatan Wahana/Fasilitas</label>
                <select class="form-select" id="edit_id_fasilitas" name="id_fasilitas">
                    <option value="">— Pilih Fasilitas (Opsional) —</option>
                    @foreach($fasilitas as $f)
                        <option value="{{ $f->id_fasilitas }}">{{ $f->nama_fasilitas }}</option>
                    @endforeach
                </select>
            </div>

            <div class="modal-actions">
                <button type="button" class="btn-cancel"
                        onclick="document.getElementById('modalEditPetugas').classList.remove('active')">
                    Batal
                </button>
                <button type="submit" class="btn-submit" style="background: linear-gradient(135deg, #f59e0b, #d97706);">
                    <i class="fas fa-save"></i> Perbarui Data
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openEditPetugasModal(id, nama, jabatan, no_hp, id_fasilitas) {
        document.getElementById('edit_id_petugas').value = id;
        document.getElementById('edit_nama_petugas').value = nama;
        document.getElementById('edit_jabatan').value = jabatan;
        document.getElementById('edit_no_hp').value = no_hp;
        document.getElementById('edit_id_fasilitas').value = id_fasilitas;
        
        document.getElementById('modalEditPetugas').classList.add('active');
    }

    // Close edit modal when clicking the dark overlay backdrop
    document.getElementById('modalEditPetugas').addEventListener('click', function(e) {
        if (e.target === this) this.classList.remove('active');
    });

    // Auto-reopen modal if validation errors exist
    @if($errors->any())
        document.getElementById('modalTambahPetugas').classList.add('active');
    @endif

    // Close modal when clicking the dark overlay backdrop
    document.getElementById('modalTambahPetugas').addEventListener('click', function(e) {
        if (e.target === this) this.classList.remove('active');
    });
</script>

</body>
</html>
