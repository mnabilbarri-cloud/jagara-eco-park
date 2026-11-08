<?php

use Illuminate\Support\Facades\Route;
use App\Models\Fasilitas;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ReservasiController;
use App\Http\Controllers\FasilitasController;

/*
|--------------------------------------------------------------------------
| Web Routes - Jagara Eco Park (Full Fixed Version)
|--------------------------------------------------------------------------
*/

// ==================== HALAMAN UTAMA ====================

Route::get('/', function () {
    $fasilitas = \App\Models\Fasilitas::all();
    return view('halaman_utama', compact('fasilitas'));
})->name('home');


// ==================== RESERVASI PENGUNJUNG ====================

Route::middleware(['user.auth'])->group(function () {

    Route::get('/reservasi-baru', [ReservasiController::class, 'create'])
        ->name('reservasi.buat');

    Route::post('/reservasi-simpan', [ReservasiController::class, 'store'])
        ->name('reservasi.store');

    // Poin 2.4: Form Lacak & Lihat Status Reservasi
    Route::get('/reservasi/status', [ReservasiController::class, 'status'])
        ->name('reservasi.status');

    Route::get('/reservasi/lupa-kode', [ReservasiController::class, 'lupaKode'])
        ->name('reservasi.lupakode');

    // Poin 2.2: Form Tampilan Reservasi Berhasil
    Route::get('/reservasi/sukses/{kode_reservasi}', [ReservasiController::class, 'success'])
        ->name('reservasi.sukses');

    // NEW: Simulated Payment Gateway Page
    Route::get('/reservasi/pembayaran/{kode_reservasi}', [ReservasiController::class, 'pembayaran'])
        ->name('reservasi.pembayaran');

    // NEW: Cancel Reservation
    Route::get('/reservasi/cancel/{kode_reservasi}', [ReservasiController::class, 'cancel'])
        ->name('reservasi.cancel');

    // NEW: Upload Bukti Pembayaran from Payment Page
    Route::post('/reservasi/upload-bukti/{kode_reservasi}', [ReservasiController::class, 'uploadStore'])
        ->name('reservasi.upload-bukti');

    // Poin 2.3: Form Konfirmasi Pembayaran (Tampilan & Proses Simpan)
    Route::get('/reservasi/upload/{kode_reservasi}', [ReservasiController::class, 'uploadForm'])
        ->name('reservasi.upload');

    Route::post('/reservasi/upload/{kode_reservasi}', [ReservasiController::class, 'uploadStore'])
        ->name('reservasi.upload.store');

    // NEW: Simpan Testimoni dari Halaman Status
    Route::post('/reservasi/testimoni/{kode_reservasi}', [ReservasiController::class, 'storeTestimoni'])
        ->name('reservasi.testimoni.simpan');

    // Poin 2.5: Form Lihat Dan Cetak Nota
    Route::get('/reservasi/nota/{kode_reservasi}', [ReservasiController::class, 'nota'])
        ->name('reservasi.nota');

});



// ==================== LOGIN ====================

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.proses')
    ->middleware('throttle:5,1'); // [KEAMANAN] Pertemuan 6: Maks 5 percobaan login per menit per IP (Anti-Brute Force)

Route::get('/logout', [AuthController::class, 'logout'])
    ->name('logout');


// ==================== USER AUTHENTICATION ====================

Route::get('/register', function () {
    return view('register');
})->name('register');

Route::post('/register', [AuthController::class, 'register'])
    ->name('register.proses');

Route::get('/user/login', function () {
    return view('user_login');
})->name('user.login');

Route::post('/user/login', [AuthController::class, 'userLogin'])
    ->name('user.login.proses')
    ->middleware('throttle:5,1'); // [KEAMANAN] Pertemuan 6: Maks 5 percobaan login per menit per IP (Anti-Brute Force)

Route::get('/user/logout', [AuthController::class, 'userLogout'])
    ->name('user.logout');

Route::get('/user/history', [ReservasiController::class, 'userHistory'])
    ->name('user.history')
    ->middleware('user.auth');


// ==================== ADMIN ROUTES (protected) ====================
Route::middleware('admin.auth')->group(function () {

    // DASHBOARD
    Route::get('/dashboard', [AdminController::class, 'dashboard'])
        ->name('dashboard');

    // GRAFIK PENDAPATAN
    Route::get('/admin/grafik', [AdminController::class, 'grafik'])
        ->name('admin.grafik');

    // KUOTA HARIAN
    Route::get('/admin/kuota', [AdminController::class, 'kuota'])
        ->name('admin.kuota');

    // LOYALTY REWARDS
    Route::get('/admin/loyalty', [AdminController::class, 'loyalty'])
        ->name('admin.loyalty');

    // PETUGAS FASILITAS
    Route::get('/admin/petugas', [AdminController::class, 'petugas'])
        ->name('admin.petugas');

    Route::post('/admin/petugas-simpan', [AdminController::class, 'storePetugas'])
        ->name('admin.petugas.simpan');

    Route::put('/admin/petugas-update', [AdminController::class, 'updatePetugas'])
        ->name('admin.petugas.update');

    Route::delete('/admin/petugas-hapus/{id}', [AdminController::class, 'destroyPetugas'])
        ->name('admin.petugas.destroy');

    // TESTIMONI & ULASAN
    Route::get('/admin/testimoni', [AdminController::class, 'testimoni'])
        ->name('admin.testimoni');

    Route::post('/admin/testimoni-simpan', [AdminController::class, 'storeTestimoni'])
        ->name('admin.testimoni.simpan');

    // HADIAH LOYALTY CRUD
    Route::post('/admin/hadiah-simpan', [AdminController::class, 'storeHadiah'])
        ->name('admin.hadiah.simpan');

    Route::post('/admin/hadiah-update/{id}', [AdminController::class, 'updateHadiah'])
        ->name('admin.hadiah.update');

    Route::get('/admin/hadiah-hapus/{id}', [AdminController::class, 'destroyHadiah'])
        ->name('admin.hadiah.hapus');

    // DATA RESERVASI ADMIN
    Route::get('/reservasi-admin', [ReservasiController::class, 'index'])
        ->name('reservasi.index');

    Route::get('/proses-reservasi/{id}/{aksi}', [ReservasiController::class, 'proses'])
        ->name('reservasi.proses');


    // DATA FASILITAS
    Route::get('/fasilitas-admin', [FasilitasController::class, 'index'])
        ->name('fasilitas.index');


    // TAMBAH FASILITAS
    Route::get('/fasilitas-tambah', [FasilitasController::class, 'create'])
        ->name('fasilitas.tambah');

    Route::post('/fasilitas-simpan', [FasilitasController::class, 'store'])
        ->name('fasilitas.simpan');


    // ==================== EDIT FASILITAS ====================

    Route::get('/fasilitas-edit/{id}', [FasilitasController::class, 'edit'])
        ->name('fasilitas.edit');

    Route::post('/fasilitas-update/{id}', [FasilitasController::class, 'update'])
        ->name('fasilitas.update');


    // ==================== HAPUS FASILITAS ====================

    Route::delete('/fasilitas-hapus/{id}', [FasilitasController::class, 'destroy'])
        ->name('fasilitas.hapus');

});


// ==================== INFORMASI KUNJUNGAN ====================

Route::get('/daftar-harga', function () {
    $fasilitas = \App\Models\Fasilitas::all();
    return view('daftar_harga', compact('fasilitas'));
})->name('daftar_harga');

Route::get('/lokasi', function () {
    return view('lokasi');
})->name('lokasi');

Route::get('/protokol', function () {
    return view('protokol');
})->name('protokol');

Route::get('/fasilitas/{id}', [FasilitasController::class, 'show'])->name('fasilitas.show');