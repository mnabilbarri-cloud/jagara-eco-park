<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Loyalty Rewards - Jagara Eco Park</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/admin.css') }}">
    <style>
        /* ── Loyalty table ── */
        .loyalty-table-wrapper { overflow-x: auto; }
        .loyalty-table { width:100%; border-collapse:separate; border-spacing:0; }
        .loyalty-table thead th {
            background:linear-gradient(135deg,#1e293b 0%,#0f172a 100%);
            color:#e2e8f0; padding:16px 18px; text-align:center; font-weight:700;
            font-size:12px; text-transform:uppercase; letter-spacing:.7px;
            border-right:1px solid rgba(51,65,85,.5);
        }
        .loyalty-table thead th:first-child { border-radius:16px 0 0 0; }
        .loyalty-table thead th:last-child  { border-radius:0 16px 0 0; border-right:none; }
        .loyalty-table tbody td {
            padding:16px 18px; border-bottom:1px solid #e2e8f0; border-right:1px solid #e2e8f0;
            vertical-align:middle; background:white; color:#334155; font-size:14px;
            white-space:nowrap; text-align:center;
        }
        .loyalty-table tbody td:last-child { border-right:none; }
        .loyalty-table tbody tr:hover td { background:#f8fafc; }
        .loyalty-table tbody tr:last-child td:first-child { border-radius:0 0 0 16px; }
        .loyalty-table tbody tr:last-child td:last-child  { border-radius:0 0 16px 0; }

        /* ── Tier badges ── */
        .tier-badge {
            display:inline-block; padding:7px 16px; border-radius:100px;
            font-weight:800; font-size:12px; text-transform:uppercase; letter-spacing:.7px;
        }
        .tier-normal  { background:#f1f5f9; color:#64748b; }
        .tier-silver  { background:#e2e8f0; color:#475569; }
        .tier-gold    { background:#fef3c7; color:#d97706; }
        .tier-platinum{ background:linear-gradient(135deg,#dbeafe,#bfdbfe); color:#1d4ed8; }

        /* ── Klaim badges ── */
        .klaim-badge {
            display:inline-block; padding:7px 14px; border-radius:100px;
            font-weight:700; font-size:12px; text-transform:uppercase; letter-spacing:.5px;
        }
        .klaim-belum { background:#fee2e2; color:#991b1b; }
        .klaim-sudah { background:#d1fae5; color:#047857; }

        .name-cell       { font-weight:800; color:var(--slate-900); }
        .email-cell      { color:var(--slate-500); font-size:13px; }
        .total-reservasi { font-weight:800; color:var(--primary); font-size:16px; }

        /* ── Hadiah table ── */
        .hadiah-table { width:100%; border-collapse:separate; border-spacing:0; }
        .hadiah-table thead th {
            background:linear-gradient(135deg,#1e293b,#0f172a);
            color:#e2e8f0; padding:14px 16px; text-align:center;
            font-weight:700; font-size:12px; text-transform:uppercase; letter-spacing:.7px;
            border-right:1px solid rgba(51,65,85,.5);
        }
        .hadiah-table thead th:first-child { border-radius:14px 0 0 0; }
        .hadiah-table thead th:last-child  { border-radius:0 14px 0 0; border-right:none; }
        .hadiah-table tbody td {
            padding:14px 16px; border-bottom:1px solid #e2e8f0; border-right:1px solid #e2e8f0;
            background:white; color:#334155; font-size:14px; text-align:center; vertical-align:middle;
        }
        .hadiah-table tbody td:last-child { border-right:none; }
        .hadiah-table tbody tr:hover td { background:#f8fafc; }

        /* ── Modal ── */
        .modal-overlay { display:none; position:fixed; inset:0; background:rgba(15,23,42,.55);
            backdrop-filter:blur(4px); z-index:1000; align-items:center; justify-content:center; }
        .modal-overlay.active { display:flex; }
        .modal-card { background:#fff; border-radius:20px; padding:34px 38px; width:100%;
            max-width:500px; box-shadow:0 24px 60px rgba(0,0,0,.18); position:relative;
            animation:modalIn .25s ease; }
        @keyframes modalIn {
            from { opacity:0; transform:translateY(-20px) scale(.97); }
            to   { opacity:1; transform:translateY(0) scale(1); }
        }
        .modal-title    { font-size:19px; font-weight:800; color:#0f172a; margin:0 0 5px; }
        .modal-subtitle { font-size:13px; color:#64748b; margin:0 0 24px; }
        .modal-close    { position:absolute; top:16px; right:18px; background:none; border:none;
            font-size:18px; cursor:pointer; color:#94a3b8; }
        .modal-close:hover { color:#334155; }
        .form-group  { margin-bottom:15px; }
        .form-label  { display:block; font-size:13px; font-weight:600; color:#334155; margin-bottom:6px; }
        .form-input  { width:100%; padding:10px 13px; border:1.5px solid #e2e8f0;
            border-radius:10px; font-size:14px; font-family:'Inter',sans-serif;
            color:#1e293b; background:#f8fafc; outline:none; box-sizing:border-box;
            transition:border-color .2s,box-shadow .2s; }
        .form-input:focus { border-color:#6366f1; box-shadow:0 0 0 3px rgba(99,102,241,.12); background:#fff; }
        .modal-actions { display:flex; gap:12px; margin-top:22px; justify-content:flex-end; }
        .btn-cancel { padding:10px 20px; border-radius:10px; border:1.5px solid #e2e8f0;
            background:#f8fafc; color:#475569; font-size:14px; font-weight:600;
            cursor:pointer; font-family:'Inter',sans-serif; }
        .btn-submit { padding:10px 22px; border-radius:10px; border:none;
            background:linear-gradient(135deg,#6366f1,#4f46e5); color:#fff; font-size:14px;
            font-weight:700; cursor:pointer; font-family:'Inter',sans-serif;
            display:inline-flex; align-items:center; gap:8px; }
        .btn-submit:hover { opacity:.9; }
        .btn-edit   { display:inline-flex; align-items:center; justify-content:center;
            width:36px; height:36px; border-radius:9px; border:none; background:#dbeafe;
            color:#1d4ed8; cursor:pointer; font-size:14px; transition:all .2s; }
        .btn-edit:hover { background:#1d4ed8; color:#fff; }
        .btn-delete { display:inline-flex; align-items:center; justify-content:center;
            width:36px; height:36px; border-radius:9px; border:none; background:#fee2e2;
            color:#dc2626; cursor:pointer; font-size:14px; transition:all .2s; text-decoration:none; }
        .btn-delete:hover { background:#dc2626; color:#fff; }

        /* ── Alert ── */
        .alert-success { background:#d1fae5; border:1.5px solid #6ee7b7; color:#065f46;
            border-radius:12px; padding:13px 18px; margin-bottom:18px; font-size:14px;
            font-weight:600; display:flex; align-items:center; gap:10px; }
        .alert-error { background:#fee2e2; border:1.5px solid #fca5a5; color:#991b1b;
            border-radius:12px; padding:13px 18px; margin-bottom:18px; font-size:14px; font-weight:600; }

        .section-divider {
            margin: 28px 0 0;
            padding: 22px 28px 8px;
            border-top: 2px solid #e2e8f0;
            display: flex; align-items: center; justify-content: space-between;
        }
        .section-title { font-size:17px; font-weight:800; color:#1e293b; }
        .empty-state { text-align:center; padding:38px 20px; color:#94a3b8; }
        .empty-state i { font-size:34px; margin-bottom:10px; display:block; }
    </style>
</head>
<body>

<div class="admin-layout">
    @include('sidebar')

    <main class="main-content">
        <div class="page-header">
            <div class="page-header-text">
                <h1 class="page-title">Kelola Loyalty Rewards</h1>
                <p class="page-subtitle">Pantau dan kelola status tier serta klaim souvenir member loyal</p>
            </div>
            <div style="text-align:right;">
                <p style="margin:0;color:var(--slate-500);font-size:13px;font-weight:500;">
                    {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
                </p>
            </div>
        </div>

        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="alert-error">
                @foreach($errors->all() as $e) {{ $e }}<br> @endforeach
            </div>
        @endif

        {{-- ══ TABEL MEMBER LOYALTY ══ --}}
        <div class="widget-card" style="padding:0;">
            <div style="padding:20px 24px 0;">
                <h3 class="widget-title" style="margin:0 0 2px;">
                    <i class="fas fa-trophy" style="margin-right:10px;color:#d97706;"></i>
                    Status Member & Tier Pelanggan
                </h3>
                <p style="margin:0 0 18px;font-size:13px;color:#64748b;">
                    Tier dihitung dari total reservasi berstatus <strong>Diterima</strong>
                    — Normal (0), Silver (≥1), Gold (≥5)
                </p>
            </div>
            <div class="loyalty-table-wrapper">
                <table class="loyalty-table">
                    <thead>
                        <tr>
                            <th>Nama Pelanggan</th>
                            <th>Email</th>
                            <th>Total Reservasi Selesai</th>
                            <th>Status Tier</th>
                            <th>Status Klaim Hadiah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($loyaltyUsers as $user)
                            <tr>
                                <td><div class="name-cell">{{ $user['name'] }}</div></td>
                                <td><div class="email-cell">{{ $user['email'] }}</div></td>
                                <td><span class="total-reservasi">{{ $user['totalReservasi'] }}</span></td>
                                <td>
                                    <span class="tier-badge
                                        @if($user['tier'] === 'Gold') tier-gold
                                        @elseif($user['tier'] === 'Silver') tier-silver
                                        @elseif($user['tier'] === 'Platinum') tier-platinum
                                        @else tier-normal
                                        @endif">
                                        {{ $user['tier'] }}
                                    </span>
                                </td>
                                <td>
                                    <span class="klaim-badge {{ $user['statusKlaim'] === 'Sudah Diklaim' ? 'klaim-sudah' : 'klaim-belum' }}">
                                        {{ $user['statusKlaim'] }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">
                                    <div class="empty-state">
                                        <i class="fas fa-users-slash"></i>
                                        <p>Belum ada data pengguna terdaftar.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- ══ MANAJEMEN HADIAH LOYALTY ══ --}}
            <div class="section-divider">
                <div>
                    <p class="section-title"><i class="fas fa-gift" style="margin-right:8px;color:#6366f1;"></i>Manajemen Hadiah / Souvenir</p>
                    <p style="margin:4px 0 0;font-size:13px;color:#64748b;">Kelola daftar hadiah berdasarkan ambang minimal reservasi</p>
                </div>
                <button class="btn-primary" style="display:inline-flex;align-items:center;gap:8px;"
                        onclick="document.getElementById('modalTambahHadiah').classList.add('active')">
                    <i class="fas fa-plus"></i> Tambah Hadiah
                </button>
            </div>

            <div style="padding:12px 24px 28px;">
                <table class="hadiah-table">
                    <thead>
                        <tr>
                            <th style="width:5%;">#</th>
                            <th style="width:45%;text-align:left;">Nama Hadiah</th>
                            <th style="width:20%;">Minimal Reservasi</th>
                            <th style="width:15%;">Stok</th>
                            <th style="width:15%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($hadiahList as $index => $hadiah)
                            <tr>
                                <td style="color:#94a3b8;font-weight:600;">{{ $index + 1 }}</td>
                                <td style="text-align:left;font-weight:700;color:#1e293b;">{{ $hadiah->nama_hadiah }}</td>
                                <td>
                                    <span style="background:#e0e7ff;color:#3730a3;padding:5px 14px;border-radius:100px;font-weight:700;font-size:13px;">
                                        {{ $hadiah->minimal_reservasi }}x
                                    </span>
                                </td>
                                <td>
                                    <span style="background:{{ $hadiah->stok > 0 ? '#d1fae5' : '#fee2e2' }};
                                        color:{{ $hadiah->stok > 0 ? '#065f46' : '#991b1b' }};
                                        padding:5px 14px;border-radius:100px;font-weight:700;font-size:13px;">
                                        {{ $hadiah->stok }}
                                    </span>
                                </td>
                                <td>
                                    <div style="display:flex;gap:8px;justify-content:center;">
                                        <button class="btn-edit" title="Edit"
                                                onclick="bukaEditHadiah({{ $hadiah->id_hadiah }}, '{{ addslashes($hadiah->nama_hadiah) }}', {{ $hadiah->minimal_reservasi }}, {{ $hadiah->stok }})">
                                            <i class="fas fa-pen"></i>
                                        </button>
                                        <a href="{{ route('admin.hadiah.hapus', $hadiah->id_hadiah) }}"
                                           class="btn-delete" title="Hapus"
                                           onclick="return confirm('Yakin ingin menghapus hadiah ini?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">
                                    <div class="empty-state">
                                        <i class="fas fa-box-open"></i>
                                        <p>Belum ada hadiah. Klik <strong>+ Tambah Hadiah</strong> untuk menambahkan.</p>
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

{{-- ══ MODAL TAMBAH HADIAH ══ --}}
<div class="modal-overlay" id="modalTambahHadiah">
    <div class="modal-card">
        <button class="modal-close" type="button"
                onclick="document.getElementById('modalTambahHadiah').classList.remove('active')">
            <i class="fas fa-times"></i>
        </button>
        <p class="modal-title"><i class="fas fa-gift" style="margin-right:10px;color:#6366f1;"></i>Tambah Hadiah Baru</p>
        <p class="modal-subtitle">Isi detail hadiah untuk ditambahkan ke dalam sistem loyalty.</p>

        <form action="{{ route('admin.hadiah.simpan') }}" method="POST">
            @csrf
            <div class="form-group">
                <label class="form-label" for="nama_hadiah_add">Nama Hadiah <span style="color:#ef4444;">*</span></label>
                <input class="form-input" type="text" id="nama_hadiah_add" name="nama_hadiah"
                       placeholder="Contoh: Kaos Jagara Eco Park" value="{{ old('nama_hadiah') }}" required>
            </div>
            <div class="form-group">
                <label class="form-label" for="minimal_reservasi_add">Minimal Reservasi <span style="color:#ef4444;">*</span></label>
                <input class="form-input" type="number" id="minimal_reservasi_add" name="minimal_reservasi"
                       placeholder="Contoh: 5" min="1" value="{{ old('minimal_reservasi') }}" required>
            </div>
            <div class="form-group">
                <label class="form-label" for="stok_add">Stok <span style="color:#ef4444;">*</span></label>
                <input class="form-input" type="number" id="stok_add" name="stok"
                       placeholder="Contoh: 50" min="0" value="{{ old('stok') }}" required>
            </div>
            <div class="modal-actions">
                <button type="button" class="btn-cancel"
                        onclick="document.getElementById('modalTambahHadiah').classList.remove('active')">Batal</button>
                <button type="submit" class="btn-submit"><i class="fas fa-save"></i> Simpan Hadiah</button>
            </div>
        </form>
    </div>
</div>

{{-- ══ MODAL EDIT HADIAH ══ --}}
<div class="modal-overlay" id="modalEditHadiah">
    <div class="modal-card">
        <button class="modal-close" type="button"
                onclick="document.getElementById('modalEditHadiah').classList.remove('active')">
            <i class="fas fa-times"></i>
        </button>
        <p class="modal-title"><i class="fas fa-pen" style="margin-right:10px;color:#6366f1;"></i>Edit Hadiah</p>
        <p class="modal-subtitle">Perbarui informasi hadiah yang telah ada.</p>

        <form id="formEditHadiah" action="" method="POST">
            @csrf
            <div class="form-group">
                <label class="form-label" for="nama_hadiah_edit">Nama Hadiah <span style="color:#ef4444;">*</span></label>
                <input class="form-input" type="text" id="nama_hadiah_edit" name="nama_hadiah" required>
            </div>
            <div class="form-group">
                <label class="form-label" for="minimal_reservasi_edit">Minimal Reservasi <span style="color:#ef4444;">*</span></label>
                <input class="form-input" type="number" id="minimal_reservasi_edit" name="minimal_reservasi" min="1" required>
            </div>
            <div class="form-group">
                <label class="form-label" for="stok_edit">Stok <span style="color:#ef4444;">*</span></label>
                <input class="form-input" type="number" id="stok_edit" name="stok" min="0" required>
            </div>
            <div class="modal-actions">
                <button type="button" class="btn-cancel"
                        onclick="document.getElementById('modalEditHadiah').classList.remove('active')">Batal</button>
                <button type="submit" class="btn-submit"><i class="fas fa-save"></i> Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<script>
    // Close modals on backdrop click
    ['modalTambahHadiah', 'modalEditHadiah'].forEach(function(id) {
        document.getElementById(id).addEventListener('click', function(e) {
            if (e.target === this) this.classList.remove('active');
        });
    });

    // Auto-open Add modal on validation error (only if triggered from Tambah form)
    @if($errors->any() && !old('_edit_mode'))
        document.getElementById('modalTambahHadiah').classList.add('active');
    @endif

    function bukaEditHadiah(id, nama, minimal, stok) {
        var baseUrl = "{{ url('admin/hadiah-update') }}/";
        document.getElementById('formEditHadiah').action = baseUrl + id;
        document.getElementById('nama_hadiah_edit').value = nama;
        document.getElementById('minimal_reservasi_edit').value = minimal;
        document.getElementById('stok_edit').value = stok;
        document.getElementById('modalEditHadiah').classList.add('active');
    }
</script>

</body>
</html>
