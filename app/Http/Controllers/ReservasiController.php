<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReservasiRequest;
use App\Models\Fasilitas;
use App\Models\Reservasi;
use App\Services\ReservationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ReservasiController extends Controller
{
    protected $reservationService;

    public function __construct(ReservationService $reservationService)
    {
        $this->reservationService = $reservationService;
    }

    /**
     * 1. TAMPILAN FORM RESERVASI (PENGUNJUNG)
     */
    public function create(Request $request)
    {
        $fasilitas = Fasilitas::where('harga', '>', 0)->get();
        $selectedFasilitasId = $request->id_fasilitas;
        return view('reservasi', compact('fasilitas', 'selectedFasilitasId'));
    }

    /**
     * 2. SIMPAN DATA RESERVASI (PENGUNJUNG)
     */
    public function store(ReservasiRequest $request)
    {
        $id_fasilitas = $request->id_fasilitas;
        $tanggal = $request->tanggal_kunjungan;
        $jumlah_tiket = intval($request->jumlah_tiket);
        $metode_pembayaran = $request->metode_pembayaran;

        $fasilitas = Fasilitas::find($id_fasilitas);
        if (!$fasilitas) {
            return redirect()->back()->with('error', 'Fasilitas tidak ditemukan!');
        }

        if ($fasilitas->harga <= 0) {
            return redirect()->back()->withInput()->with('error', 'Fasilitas gratis tidak dapat direservasi!');
        }

        // Get user ID early for checks
        $user_id = Session::has('user_login') ? Session::get('user_id') : null;

        // Check anti-spam: both user_id (if logged in) and no_hp
        if ($this->reservationService->hasRecentPendingReservation($request->no_hp, $user_id)) {
            return redirect()->back()->withInput()->with('error', 'Peringatan: Anda atau Nomor HP ini sudah melakukan reservasi hari ini. Harap tunggu hingga 24 jam untuk melakukan reservasi kembali demi keamanan data.');
        }

        // Check double booking
        if ($this->reservationService->hasDoubleBooking($request->no_hp, $tanggal, $id_fasilitas)) {
            return redirect()->back()->withInput()->with('error', 'Anda sudah memiliki reservasi untuk fasilitas ini pada tanggal tersebut.');
        }

        // Check capacity
        $capacityCheck = $this->reservationService->checkCapacity($id_fasilitas, $tanggal, $jumlah_tiket);
        if (!$capacityCheck['available']) {
            return redirect()->back()->withInput()->with('error', "Maaf, kuota tidak mencukupi. Sisa kuota adalah {$capacityCheck['remaining']} tiket.");
        }

        // Calculate price with discount
        $priceCalculation = $this->reservationService->calculatePrice($fasilitas->harga, $jumlah_tiket, $user_id);

        $kode_reservasi = $this->reservationService->generateReservationCode();

        try {
            $this->reservationService->createReservation([
                'kode_reservasi'    => $kode_reservasi,
                'nama_pengunjung'   => $request->nama_pengunjung,
                'no_hp'             => $request->no_hp,
                'tanggal_kunjungan' => $tanggal,
                'id_fasilitas'      => $id_fasilitas,
                'jumlah_tiket'      => $jumlah_tiket,
                'total_bayar'       => $priceCalculation['total'],
                'status'            => 'Menunggu',
                'user_id'           => $user_id,
                'created_at'        => now()
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }

        // Store payment method in session for the payment page
        Session::put('metode_pembayaran', $metode_pembayaran);

        // Flash message for discount applied
        if ($priceCalculation['discount_percentage'] > 0) {
            Session::put('discount_message', "Diskon {$priceCalculation['discount_percentage']}% berhasil diterapkan!");
        }

        // Redirect to payment page instead of success page
        return redirect()->route('reservasi.pembayaran', ['kode_reservasi' => $kode_reservasi]);
    }

    /**
     * 2.1. HALAMAN PEMBAYARAN (SIMULATED GATEWAY)
     */
    public function pembayaran(string $kode_reservasi)
    {
        $reservation = Reservasi::with('fasilitas')
            ->where('kode_reservasi', $kode_reservasi)
            ->firstOrFail();

        // [KEAMANAN - Proteksi IDOR] Pertemuan 6: Validasi kepemilikan reservasi.
        if ($reservation->user_id && $reservation->user_id != Session::get('user_id')) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk mengakses halaman pembayaran ini.');
        }

        // Security check: if already processed, redirect home
        if (in_array($reservation->status, ['Diterima', 'Ditolak'])) {
            return redirect()->route('home')->with('error', 'Reservasi ini sudah diproses dan tidak dapat diubah.');
        }

        // Check if reservation is still valid (not expired)
        $createdAt = \Carbon\Carbon::parse($reservation->created_at);
        $minutes_elapsed = now()->diffInMinutes($createdAt);

        if ($reservation->status == 'Menunggu' && $minutes_elapsed >= 15) {
            $reservation->update(['status' => 'Ditolak']);
            return redirect()->route('reservasi.status')
                ->with('error', 'Reservasi Anda telah kadaluarsa karena tidak menyelesaikan pembayaran dalam 15 menit.');
        }

        $metode_pembayaran = Session::get('metode_pembayaran', 'QRIS');

        return view('reservasi.pembayaran', compact('reservation', 'metode_pembayaran'));
    }

    /**
     * 2.2. BATALKAN RESERVASI
     */
    public function cancel(string $kode_reservasi)
    {
        $reservation = Reservasi::with('fasilitas')
            ->where('kode_reservasi', $kode_reservasi)
            ->firstOrFail();

        // [KEAMANAN - Proteksi IDOR] Pertemuan 6: Hanya pemilik reservasi yang bisa membatalkan.
        if ($reservation->user_id && $reservation->user_id != Session::get('user_id')) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk membatalkan reservasi ini.');
        }

        // Only cancel if still pending
        if ($reservation->status == 'Menunggu') {
            $reservation->update(['status' => 'Ditolak']);
        }

        // Clear session
        Session::forget('metode_pembayaran');
        Session::forget('discount_message');

        return redirect()->route('home')->with('success', 'Reservasi berhasil dibatalkan. Kuota telah dikembalikan.');
    }

    /**
     * USER TRANSACTION HISTORY
     */
    public function userHistory()
    {
        $user_id = Session::get('user_id');
        $reservations = Reservasi::with('fasilitas')
            ->where('user_id', $user_id)
            ->orderBy('created_at', 'desc')
            ->get();

        $user = \App\Models\User::find($user_id);
        $discount_percentage = $user ? $user->getDiscountPercentage() : 0;
        $is_permanent = $user ? $user->is_permanent : false;

        $jumlahReservasi = \DB::table('reservasi')
            ->where('user_id', $user_id)
            ->where('status', 'Diterima')
            ->count();

        return view('user_history', compact('reservations', 'discount_percentage', 'is_permanent', 'jumlahReservasi'));
    }

    /**
     * 3. HALAMAN STATUS RESERVASI PENGUNJUNG
     */
    public function status(Request $request)
    {
        $kode = $request->query('kode_reservasi');
        $noHp = $request->query('no_hp');
        $reservation = null;
        $sisa_menit = 0;

        if ($kode) {
            $reservation = Reservasi::with('fasilitas')
                ->where('kode_reservasi', $kode)
                ->first();
        } elseif ($noHp) {
            $reservation = Reservasi::with('fasilitas')
                ->where('no_hp', $noHp)
                ->orderBy('created_at', 'desc')
                ->first();
        }

        if ($reservation) {
            $createdAt = \Carbon\Carbon::parse($reservation->created_at);
            $menit_berjalan = now()->diffInMinutes($createdAt);

            if ($reservation->status == 'Menunggu' && $menit_berjalan >= 15) {
                $reservation->update(['status' => 'Ditolak']);
                $reservation->status = 'Ditolak';
            }
            $sisa_menit = max(0, 15 - $menit_berjalan);
        }

        return view('reservasi_status', compact('reservation', 'kode', 'noHp', 'sisa_menit'));
    }

    /**
     * 3.5. HALAMAN LUPA KODE RESERVASI PENGUNJUNG
     */
    public function lupaKode(Request $request)
    {
        $noHp = $request->query('no_hp');
        $reservations = null;

        if ($noHp) {
            $reservations = Reservasi::with('fasilitas')
                ->where('no_hp', $noHp)
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return view('reservasi_lupa_kode', compact('reservations', 'noHp'));
    }

    /**
     * 4. HALAMAN NOTA RESERVASI PENGUNJUNG
     */
    public function nota(string $kode)
{
    $reservation = Reservasi::with('fasilitas')
        ->where('kode_reservasi', $kode)
        ->where('status', 'Diterima')
        ->firstOrFail();

    // [KEAMANAN - Proteksi IDOR] Pertemuan 6: Jika reservasi terkait akun user tertentu,
    // pastikan hanya pemiliknya yang dapat mengakses nota ini.
    if ($reservation->user_id && $reservation->user_id != Session::get('user_id')) {
        abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk melihat nota ini.');
    }

    return view('reservasi_nota', compact('reservation'));
}
    /**
     * 5. HALAMAN KONFIRMASI RESERVASI (SUKSES AWAL)
     */
    public function success(string $kode_reservasi)
{
    $reservation = Reservasi::with('fasilitas')
        ->where('kode_reservasi', $kode_reservasi)
        ->firstOrFail();

    // [KEAMANAN - Proteksi IDOR] Pertemuan 6: Validasi kepemilikan reservasi.
    if ($reservation->user_id && $reservation->user_id != Session::get('user_id')) {
        abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk melihat halaman ini.');
    }

    return view('reservasi_sukses', compact('reservation'));
}

    /**
     * 6. HALAMAN DASHBOARD DATA RESERVASI (ADMIN)
     */
    public function index(Request $request)
    {
        if (!Session::has('login')) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu!');
        }

        // Auto-Reject Menunggu > 15 Menit
        Reservasi::where('status', 'Menunggu')
            ->where('created_at', '<', now()->subMinutes(15))
            ->update(['status' => 'Ditolak']);

        $status = $request->get('status', 'semua');
        $periode = $request->get('periode', 'semua');

        $query = Reservasi::with('fasilitas');

        if ($periode == 'hari') {
            $query->where('created_at', '>=', today());
        }

        if ($periode == 'minggu') {
            $query->where('created_at', '>=', now()->subDays(7));
        }

        if ($periode == 'bulan') {
            $query->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()]);
        }

        if ($status != 'semua') {
            $query->where('status', ucfirst($status));
        }

        $data = $query->orderBy('id_reservasi', 'desc')->get();

        $total_pax_valid = $data->where('status', 'Diterima')->sum('jumlah_tiket');
        $total_pax_ditolak = $data->where('status', 'Ditolak')->sum('jumlah_tiket');
        $total_reservasi = $data->count();

        return view('data_reservasi', compact('data', 'total_pax_valid', 'total_pax_ditolak', 'total_reservasi'))
            ->with([
                'filter_status' => $status,
                'filter_waktu'  => $periode
            ]);
    }

    /**
     * 7. PROSES AKSI TERIMA / TOLAK RESERVASI (ADMIN)
     */
    public function proses(int $id, string $aksi)
    {
        if (!Session::has('login')) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu!');
        }

        $statusBaru = ($aksi == 'terima') ? 'Diterima' : 'Ditolak';
        $reservasi = Reservasi::findOrFail($id);

        if ($reservasi->status != 'Menunggu') {
            return redirect()->back()
                ->with(
                    'error',
                    'Reservasi sudah diproses sebelumnya.'
                );
        }

        // PERBAIKAN: Jika total_bayar > 0 baru wajib bukti pembayaran. Jika gratis (Mushola), bisa diterima langsung.
        if ($aksi == 'terima' && $reservasi->total_bayar > 0 && empty($reservasi->bukti_pembayaran)) {
            return redirect()->back()->with('error', 'Tidak dapat menerima reservasi tanpa bukti pembayaran. Mohon minta pengunjung mengunggah bukti terlebih dahulu.');
        }

        $reservasi->update(['status' => $statusBaru]);

        // Update user discount tier if reservation is accepted and has a user
        if ($aksi == 'terima' && $reservasi->user_id) {
            $this->reservationService->updateUserDiscountTier($reservasi->user_id);
        }

        return redirect()->back()->with('success', 'Reservasi berhasil di' . strtolower($statusBaru) . '!');
    }

    /**
     * 8. FORM UPLOAD BUKTI PEMBAYARAN (PENGUNJUNG)
     */
    public function uploadForm(string $kode)
    {
        $reservation = Reservasi::with('fasilitas')
            ->where('kode_reservasi', $kode)
            ->firstOrFail();

        // [KEAMANAN - Proteksi IDOR] Pertemuan 6: Hanya pemilik reservasi yang bisa upload bukti.
        if ($reservation->user_id && $reservation->user_id != Session::get('user_id')) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk mengupload bukti reservasi ini.');
        }

        return view('reservasi_upload', compact('reservation'));
    }

    /**
     * 9. SIMPAN BUKTI PEMBAYARAN
     */
    public function uploadStore(Request $request, string $kode)
    {
        $reservation = Reservasi::where('kode_reservasi', $kode)->firstOrFail();

        // [KEAMANAN - Proteksi IDOR] Pertemuan 6: Hanya pemilik reservasi yang bisa menyimpan bukti.
        if ($reservation->user_id && $reservation->user_id != Session::get('user_id')) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk mengubah reservasi ini.');
        }

        if ($reservation->status != 'Menunggu') {
            return redirect()->back()
                ->with(
                    'error',
                    'Reservasi sudah diproses admin dan tidak dapat diubah lagi.'
                );
        }

        $request->validate([
            'bukti' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'bukti.required' => 'Silakan pilih file bukti pembayaran.',
            'bukti.image'    => 'File harus berupa gambar yang valid.',
            'bukti.mimes'    => 'Format bukti tidak valid. Hanya JPG atau PNG diperbolehkan.',
            'bukti.max'      => 'Ukuran file terlalu besar. Maksimal 2MB.'
        ]);

        $filename = $this->reservationService->uploadPaymentProof(
            $request->file('bukti'),
            $reservation->kode_reservasi,
            $reservation->bukti_pembayaran
        );

        $reservation->bukti_pembayaran = $filename;
        $reservation->save();

        return redirect()->route(
            'reservasi.sukses',
            [
                'kode_reservasi' => $reservation->kode_reservasi,
                'pesan' => 'upload_berhasil'
            ]
        )->with(
            'success',
            'Bukti pembayaran berhasil diunggah. Terima kasih.'
        );
    }

    /**
     * 10. SIMPAN TESTIMONI DARI PENGUNJUNG
     */
    public function storeTestimoni(Request $request, string $kode)
    {
        $reservation = Reservasi::where('kode_reservasi', $kode)
            ->where('status', 'Diterima')
            ->firstOrFail();

        $request->validate([
            'rating'   => 'required|integer|min:1|max:5',
            'komentar' => 'required|string|max:1000',
        ]);

        $exists = \Illuminate\Support\Facades\DB::table('testimoni')
            ->where('id_reservasi', $reservation->id_reservasi)
            ->exists();

        if ($exists) {
            return redirect()->back()->with('error', 'Anda sudah memberikan ulasan untuk kunjungan ini.');
        }

        \Illuminate\Support\Facades\DB::table('testimoni')->insert([
            'id_reservasi' => $reservation->id_reservasi,
            'rating'       => $request->rating,
            'komentar'     => $request->komentar,
            'created_at'   => now(),
        ]);

        return redirect()->back()->with('success', 'Terima kasih atas ulasan dan pengalaman yang Anda bagikan!');
    }

}

