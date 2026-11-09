# 🌿 Jagara Eco Park — Aplikasi Web Reservasi

Aplikasi web sistem reservasi wisata **Jagara Eco Park** berbasis PHP & MySQL.

**Dibuat oleh:** Muhamad Nabil Barri  
**Mata Kuliah:** Pengembangan & Publikasi Aplikasi Web (Cyber Security)  
**Semester:** 5 — Teknik Informatika  

---

## 🚀 Fitur Utama

| Fitur | Keterangan |
|-------|-----------|
| 📋 Reservasi Pengunjung | Form reservasi online dengan validasi lengkap |
| 🔐 Login Admin | Autentikasi admin dengan bcrypt + rate limiting |
| 🏕️ Manajemen Fasilitas | CRUD fasilitas wisata (tambah, lihat, edit, hapus) |
| 📊 Manajemen Reservasi | Approve/reject reservasi, ekspor PDF/Excel/Word |
| 🔍 Cek Status Reservasi | Pengunjung bisa cek status dengan kode reservasi |
| 🛡️ Dashboard Admin | Statistik real-time dengan filter waktu |

---

## 🛡️ Implementasi Keamanan (Cyber Security)

### Keamanan yang Diterapkan:

1. **SQL Injection Prevention** — Semua query database menggunakan **Prepared Statement** (`mysqli_prepare`), tidak ada string concatenation dengan input user
2. **XSS Prevention** — Semua output data ke HTML menggunakan `htmlspecialchars(ENT_QUOTES, 'UTF-8')`
3. **Authentication & Session Security** — Session regeneration setelah login (`session_regenerate_id(true)`), session fixation prevention
4. **Brute Force Protection** — Rate limiting via session counter (maks 5 percobaan per 15 menit)
5. **File Upload Security** — Validasi MIME type dari konten file (bukan ekstensi), nama file di-sanitasi
6. **Input Validation & Whitelist** — Semua input divalidasi (tipe, panjang, format), filter parameter menggunakan whitelist
7. **HTTP Security Headers** (via `.htaccess`):
   - `Strict-Transport-Security` (HSTS) — paksa HTTPS
   - `X-Frame-Options: SAMEORIGIN` — anti clickjacking
   - `X-Content-Type-Options: nosniff` — anti MIME sniffing
   - `X-XSS-Protection: 1; mode=block`
   - `Content-Security-Policy` — batasi sumber resource
   - `Referrer-Policy: strict-origin-when-cross-origin`
8. **Directory Listing Disabled** — `Options -Indexes` di `.htaccess`
9. **Sensitive File Protection** — `.htaccess` blokir akses ke `koneksi.php`, `.env`, `.log`
10. **Force HTTPS** — Redirect HTTP → HTTPS via `.htaccess` (R=301)
11. **Custom Error Pages** — Error 403/404/500 redirect ke halaman aman (tidak bocorkan info server)
12. **Scanner/Bot Blocking** — User-agent berbahaya (sqlmap, nikto, nmap, dll.) diblokir

---

## 🗂️ Struktur Folder

```
jagara-eco-park/
├── .htaccess              ← Security headers + Force HTTPS
├── index.php              ← Halaman utama (homepage)
├── koneksi.php            ← Koneksi database
├── auth/
│   ├── login.php          ← Form login admin
│   ├── proses_login.php   ← Proses login (prepared stmt + rate limit)
│   └── logout.php         ← Logout + session destroy
├── admin/
│   └── dashboard.php      ← Dashboard statistik admin
├── fasilitas_admin/
│   ├── data_fasilitas.php ← Daftar fasilitas (CRUD)
│   ├── tambah_fasilitas.php
│   ├── proses_tambah.php  ← Proses tambah (prepared stmt + MIME check)
│   ├── edit_fasilitas.php
│   ├── proses_edit.php    ← Proses edit (prepared stmt + MIME check)
│   └── hapus_fasilitas.php ← Hapus (prepared stmt)
├── reservasi_admin/
│   ├── data_reservasi.php ← Manajemen reservasi (whitelist filter)
│   ├── proses_reservasi.php ← Approve/reject (prepared stmt)
│   └── tambah_reservasi.php ← Tambah reservasi manual
└── pengunjung/
    ├── reservasi.php       ← Form reservasi pengunjung
    ├── simpan_reservasi.php ← Simpan reservasi (prepared stmt + validasi)
    ├── sukses.php          ← Halaman sukses (XSS-safe)
    └── status_reservasi.php ← Cek status (prepared stmt + XSS-safe)
```

---

## ⚙️ Teknologi

- **Backend:** PHP 8+ dengan MySQLi (Prepared Statements)
- **Database:** MySQL
- **Frontend:** HTML5, CSS3, JavaScript (Vanilla)
- **Library:** SweetAlert2, Font Awesome, XLSX.js, html2pdf.js
- **Security Layer:** Apache `.htaccess` (mod_headers, mod_rewrite)

---

## 📋 Cara Install (Lokal)

1. Clone repo ini ke folder XAMPP `htdocs`
2. Import database SQL ke phpMyAdmin
3. Edit `koneksi.php` sesuai kredensial database lokal
4. Akses via `http://localhost/jagara-eco-park/`

---

## 🔐 Default Admin

| Field | Value |
|-------|-------|
| Username | `admin` |
| Password | `admin` |

> ⚠️ Ganti password di production!
