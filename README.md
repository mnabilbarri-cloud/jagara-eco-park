# 🌿 Jagara Eco Park - Sistem Informasi & Reservasi Wisata Berbasis Web

Aplikasi web sistem informasi dan pemesanan tiket wisata Jagara Eco Park berbasis framework **Laravel 10**, dikembangkan dengan menerapkan prinsip-prinsip **Cyber Security** dan **Secure Coding** sesuai standar OWASP Top 10 dan NIST.

Proyek ini disusun untuk memenuhi tugas besar mata kuliah **Cyber Security (Pra-UTS)**, Program Studi Teknik Informatika.

---

## 📌 1. Deskripsi Aplikasi

**Jagara Eco Park** adalah platform reservasi wisata yang memfasilitasi pengunjung untuk melihat informasi fasilitas wisata, daftar harga tiket, jam operasional, serta melakukan pemesanan dan pembayaran tiket secara daring. Sistem ini juga dilengkapi panel administrasi untuk memantau pendapatan, kuota harian tiket, verifikasi pembayaran, validasi pengunjung, dan manajemen penghargaan loyalitas (*loyalty rewards*).

---

## ✨ 2. Fitur Utama

### 👤 Pengunjung (User / Customer)
- **Registrasi & Login Akun:** Pendaftaran akun pengunjung dengan kebijakan password aman dan enkripsi Bcrypt.
- **Katalog Fasilitas & Informasi:** Menampilkan wahana, deskripsi fasilitas, harga tiket, lokasi, dan protokol kunjungan.
- **Pemesanan / Reservasi Tiket:** Pemilihan tanggal kunjungan, jumlah tiket, dan metode pembayaran dengan validasi kuota otomatis.
- **Simulasi Gateway Pembayaran & Upload Bukti:** Unggah bukti pembayaran aman dengan validasi tipe berkas (*MIME type*) dan ukuran maksimum.
- **Nota Pemesanan Digital:** Cetak e-tiket/nota reservasi resmi dengan kode transaksi unik.
- **Riwayat Reservasi & Program Loyalitas:** Pengunjung dapat melihat riwayat transaksi dan akumulasi tier diskon loyalty (Silver/Gold).
- **Ulasan & Testimoni:** Pengunjung yang telah selesai berkunjung dapat memberikan ulasan dan rating kepuasan.

### 🛡️ Administrator
- **Dashboard Monitoring:** Ringkasan statistik reservasi harian, mingguan, bulanan, dan total pengunjung.
- **Grafik Tren Pendapatan:** Visualisasi analitik pendapatan bulanan secara terstruktur.
- **Manajemen Kuota Harian:** Pemantauan sisa kuota tiket per tanggal kunjungan untuk mencegah *overcapacity*.
- **Verifikasi & Validasi Reservasi:** Penerimaan atau penolakan bukti pembayaran pengunjung.
- **Manajemen Fasilitas (CRUD):** Tambah, ubah, dan hapus wahana wisata beserta harga tiket dan kapasitas.
- **Manajemen Petugas & Hadiah Loyalty:** Pengelolaan staf fasilitas dan katalog hadiah poin pengunjung.

---

## 🔒 3. Penerapan Aspek Keamanan Siber (Cyber Security)

Mengacu pada materi perkuliahan Pertemuan 1 s.d. 8 (CIA Triad, Kriptografi, OWASP Top 10, dan Access Control):

| No | Aspek Keamanan | Implementasi pada Aplikasi | Materi Terkait |
|:---:|:---|:---|:---:|
| 1 | **Password Hashing (Kriptografi Satu Arah)** | Menggunakan algoritma **Bcrypt** (`Hash::make()` & `Hash::check()`) dengan salt unik otomatis, bukan plaintext atau MD5 usang. | Pertemuan 2 & 6 |
| 2 | **Pencegahan SQL Injection** | Semua operasi database menggunakan **Eloquent ORM** dan **PDO Prepared Statements**, menolak manipulasi karakter input berbahaya. | Pertemuan 5 |
| 3 | **Pencegahan Cross-Site Scripting (XSS)** | Template engine Blade secara otomatis menjalankan *Output Encoding* (`htmlspecialchars()`) pada sintaks `{{ $data }}`. | Pertemuan 5 |
| 4 | **Pencegahan IDOR (Insecure Direct Object Reference)** | Validasi kepemilikan sesi (`user_id` transaksi vs `user_id` session) pada akses nota, pembayaran, dan unggah bukti transaksi. | Pertemuan 6 |
| 5 | **Proteksi Brute Force (Rate Limiting)** | Endpoint login (`/login` dan `/user/login`) dilindungi middleware `throttle:5,1` (maksimal 5 percobaan per menit per alamat IP). | Pertemuan 6 & 7 |
| 6 | **Proteksi CSRF (Cross-Site Request Forgery)** | Seluruh formulir HTTP POST/PUT/DELETE wajib menyertakan token `@csrf` valid yang divalidasi oleh `VerifyCsrfToken` middleware. | Pertemuan 5 |
| 7 | **Manajemen Sesi & Enkripsi Cookie** | Middleware `EncryptCookies` mengenkripsi cookie sesi secara simetris; sesi di-invalidate penuh saat aksi logout. | Pertemuan 2 & 5 |
| 8 | **Manajemen Secret & Kredensial** | File konfigurasi sensitif (koneksi DB, APP_KEY) diisolasi dalam environment variable `.env` dan diabaikan oleh `.gitignore`. | Pertemuan 3 & 6 |
| 9 | **Validasi & Sanitasi Berkas Unggahan** | Verifikasi ekstensi berkas (`mimes:jpg,jpeg,png`), pengecekan MIME type, dan pembatasan ukuran berkas maksimal 2MB. | Pertemuan 4 & 5 |

---

## 🛠️ 4. Teknologi yang Digunakan

- **Backend Framework:** Laravel 10.x (PHP 8.1+)
- **Database:** MySQL / MariaDB
- **Frontend:** Blade Templating, Custom CSS, Font Awesome 6, Google Fonts (Poppins)
- **Web Server:** Apache (XAMPP) / Artisan CLI Server
- **Version Control:** Git & GitHub

---

## 🚀 5. Panduan Instalasi Lokal

Ikuti langkah-langkah berikut untuk menjalankan aplikasi di komputer lokal:

### Prasyarat
- PHP >= 8.1
- Composer
- MySQL / MariaDB (XAMPP)
- Web Browser

### Langkah Instalasi
1. **Clone repository:**
   ```bash
   git clone https://github.com/mnabilbarri-cloud/jagara-eco-park.git
   cd jagara-eco-park
   ```

2. **Instal dependensi PHP:**
   ```bash
   composer install
   ```

3. **Konfigurasi Environment:**
   Salin berkas `.env.example` menjadi `.env`:
   ```bash
   cp .env.example .env
   ```
   Sesuaikan parameter database di file `.env`:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=jagara_framework_db
   DB_USERNAME=root
   DB_PASSWORD=
   ```

4. **Generate Application Key:**
   ```bash
   php artisan key:generate
   ```

5. **Migrasi Database & Seeder:**
   ```bash
   php artisan migrate --seed
   ```

6. **Jalankan Server Lokal:**
   ```bash
   php artisan serve
   ```
   Akses aplikasi melalui peramban di: **`http://127.0.0.1:8000`**

---

## 🔑 6. Akun Pengujian (Demo Accounts)

Untuk memfasilitasi pengujian fitur dan kontrol akses:

* **Akun Administrator:**
  * URL Login: `/login` (Klik tombol **ADMIN** di navigasi atas)
  * **Username:** `admin`
  * **Password:** `admin`

* **Akun Pengunjung (User Demo):**
  * URL Login: `/user/login` (Klik tombol **LOGIN** di navigasi atas)
  * Dapat mendaftar langsung melalui menu **DAFTAR** (`/register`).

---

## 🧪 7. Ringkasan Self-Testing Keamanan

| Skenario Uji | Vektor Uji | Hasil Ekspektasi | Hasil Aktual | Status |
|:---|:---|:---|:---|:---:|
| **Uji SQL Injection (Login)** | Input `' OR '1'='1' --` pada kolom login | Login ditolak, query tidak termanipulasi | Akses ditolak secara aman | **LOLOS** |
| **Uji Stored XSS** | Payload `<script>alert('XSS')</script>` pada input nama / ulasan | Skrip tidak dieksekusi di browser | Terekodifikasi sebagai teks aman | **LOLOS** |
| **Uji IDOR (Akses Nota)** | Pengunjung A mengakses nota transaksi milik Pengunjung B via URL | Akses diblokir | Muncul HTTP 403 Forbidden | **LOLOS** |
| **Uji Brute Force Login** | Menembak form login > 5 kali percobaan berturut-turut | Akses dibatasi sementara | Muncul HTTP 429 Too Many Requests | **LOLOS** |
| **Uji Dependency Security** | Menjalankan `composer audit` terhadap vendor package | Tidak ada kerentanan kritis yang aktif | 0 CVE / Zero Known Vulnerability | **LOLOS** |

---

## 🤖 8. Transparansi Penggunaan AI Agent

Sesuai dengan ketentuan tugas (poin 3e dan 4):
* **AI Tool yang Digunakan:** Antigravity AI Assistant.
* **Bagian Pekerjaan yang Dibantu:**
  1. Audit analisis keamanan kode terhadap celah IDOR (*Insecure Direct Object References*) dan penambahan mitigasi otorisasi.
  2. Implementasi pembatasan laju request (*Rate Limiting*) pada rute autentikasi untuk memitigasi serangan brute force.
  3. Perancangan skenario *self-testing* keamanan dan penyusunan dokumentasi teknis *README.md*.
* **Verifikasi oleh Mahasiswa:** Seluruh kode yang dihasilkan ditinjau secara manual, diuji pada server lokal, dan dipastikan berjalan sesuai dengan modul perkuliahan Cyber Security.

---

## 📄 Lisensi & Hak Cipta
Dikembangkan untuk keperluan akademik Mata Kuliah Cyber Security, Semester 5, Program Studi Teknik Informatika.
