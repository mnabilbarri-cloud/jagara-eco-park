<?php

namespace App\Http\Controllers;

use App\Services\DashboardService;
use App\Models\User;
use App\Models\Fasilitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    protected $dashboardService;

    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    // ══════════════════════════════════════════
    // DASHBOARD
    // ══════════════════════════════════════════
    public function dashboard(Request $request)
    {
        if (!Session::has('login')) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu!');
        }

        $filter = $request->get('periode', 'hari');
        $stats  = $this->dashboardService->getDashboardStats($filter);

        return view('dashboard', $stats);
    }

    // ══════════════════════════════════════════
    // GRAFIK PENDAPATAN
    // ══════════════════════════════════════════
    public function grafik()
    {
        if (!Session::has('login')) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu!');
        }

        $monthlyRevenueData = $this->dashboardService->getMonthlyRevenueData(6);

        $chartLabels   = ['Feb 2026', 'Mar 2026', 'Apr 2026', 'May 2026', 'Jun 2026', 'Jul 2026'];
        $monthlyRevenue = [2 => 0, 3 => 0, 4 => 0, 5 => 0, 6 => 0, 7 => 0];

        $trends = DB::table('reservasi')
            ->select(DB::raw('MONTH(tanggal_kunjungan) as bulan'), DB::raw('SUM(total_bayar) as total'))
            ->where('status', 'Diterima')
            ->whereYear('tanggal_kunjungan', 2026)
            ->groupBy('bulan')
            ->get();

        foreach ($trends as $row) {
            if (array_key_exists($row->bulan, $monthlyRevenue)) {
                $monthlyRevenue[$row->bulan] = (int) $row->total;
            }
        }

        $chartData = [
            $monthlyRevenue[2], $monthlyRevenue[3], $monthlyRevenue[4],
            $monthlyRevenue[5], $monthlyRevenue[6], $monthlyRevenue[7],
        ];

        return view('admin.grafik', [
            'monthlyRevenue'               => $monthlyRevenueData['revenue'],
            'monthlyLabels'                => $monthlyRevenueData['labels'],
            'monthlyCompletedReservations' => $monthlyRevenueData['completed_reservations'],
            'monthlyTrends'                => $monthlyRevenueData['trends'],
            'chartLabels'                  => $chartLabels,
            'chartData'                    => $chartData,
        ]);
    }

    // ══════════════════════════════════════════
    // KUOTA HARIAN
    // ══════════════════════════════════════════
    public function kuota()
    {
        if (!Session::has('login')) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu!');
        }

        $dailyQuotaData = $this->dashboardService->getDailyQuotaData();

        return view('admin.kuota', compact('dailyQuotaData'));
    }

    // ══════════════════════════════════════════
    // KELOLA PETUGAS FASILITAS
    // ══════════════════════════════════════════
    public function petugas()
    {
        if (!Session::has('login')) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu!');
        }

        $petugas = DB::table('petugas')
            ->leftJoin('fasilitas', 'petugas.id_fasilitas', '=', 'fasilitas.id_fasilitas')
            ->select('petugas.*', 'fasilitas.nama_fasilitas')
            ->orderBy('petugas.nama_petugas')
            ->get();

        $fasilitas = Fasilitas::where('tipe', 'reservasi')->orderBy('nama_fasilitas')->get();

        return view('admin.petugas', compact('petugas', 'fasilitas'));
    }

    public function storePetugas(Request $request)
    {
        if (!Session::has('login')) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu!');
        }

        $request->validate([
            'nama_petugas' => 'required|string|max:100',
            'jabatan'      => 'required|string|max:50',
            'no_hp'        => 'nullable|string|max:20',
            'id_fasilitas' => 'nullable|exists:fasilitas,id_fasilitas',
        ]);

        DB::table('petugas')->insert([
            'nama_petugas' => $request->nama_petugas,
            'jabatan'      => $request->jabatan,
            'no_hp'        => $request->no_hp,
            'id_fasilitas' => $request->id_fasilitas ?: null,
            'created_at'   => now(),
        ]);

        return redirect()->back()->with('success', 'Data petugas berhasil ditambahkan!');
    }

    public function updatePetugas(Request $request)
    {
        if (!Session::has('login')) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu!');
        }

        $request->validate([
            'id_petugas' => 'required',
            'nama_petugas' => 'required|string|max:100',
            'jabatan' => 'required|string|max:50',
            'no_hp' => 'nullable|string|max:20',
            'id_fasilitas' => 'nullable|integer'
        ]);

        DB::table('petugas')->where('id_petugas', $request->id_petugas)->update([
            'nama_petugas' => $request->nama_petugas,
            'jabatan' => $request->jabatan,
            'no_hp' => $request->no_hp,
            'id_fasilitas' => $request->id_fasilitas,
            'updated_at' => now()
        ]);

        return redirect()->back()->with('success', 'Data petugas berhasil diperbarui!');
    }

    public function destroyPetugas($id)
    {
        if (!Session::has('login')) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu!');
        }

        DB::table('petugas')->where('id_petugas', $id)->delete();
        return redirect()->back()->with('success', 'Petugas berhasil dihapus!');
    }

    // ══════════════════════════════════════════
    // KELOLA TESTIMONI & ULASAN
    // ══════════════════════════════════════════
    public function testimoni()
    {
        if (!Session::has('login')) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu!');
        }

        // Real DB data – JOIN testimoni → reservasi → fasilitas
        $testimonis = DB::table('testimoni')
            ->join('reservasi', 'testimoni.id_reservasi', '=', 'reservasi.id_reservasi')
            ->join('fasilitas', 'reservasi.id_fasilitas', '=', 'fasilitas.id_fasilitas')
            ->select(
                'testimoni.id_testimoni',
                'testimoni.rating',
                'testimoni.komentar',
                'testimoni.created_at',
                'reservasi.nama_pengunjung',
                'fasilitas.nama_fasilitas'
            )
            ->orderByDesc('testimoni.id_testimoni')
            ->get();

        // Reservasi 'Diterima' that don't yet have a testimoni (for simulation form)
        $reservasiDiterima = DB::table('reservasi')
            ->leftJoin('testimoni', 'reservasi.id_reservasi', '=', 'testimoni.id_reservasi')
            ->join('fasilitas', 'reservasi.id_fasilitas', '=', 'fasilitas.id_fasilitas')
            ->whereNull('testimoni.id_reservasi')
            ->where('reservasi.status', 'Diterima')
            ->select('reservasi.id_reservasi', 'reservasi.nama_pengunjung', 'fasilitas.nama_fasilitas')
            ->get();

        return view('admin.testimoni', compact('testimonis', 'reservasiDiterima'));
    }

    public function storeTestimoni(Request $request)
    {
        if (!Session::has('login')) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu!');
        }

        $request->validate([
            'id_reservasi' => 'required|exists:reservasi,id_reservasi',
            'rating'       => 'required|integer|min:1|max:5',
            'komentar'     => 'required|string|max:1000',
        ]);

        // Prevent duplicate testimoni for the same reservasi
        $exists = DB::table('testimoni')->where('id_reservasi', $request->id_reservasi)->exists();
        if ($exists) {
            return redirect()->back()->with('error', 'Testimoni untuk reservasi ini sudah ada.');
        }

        DB::table('testimoni')->insert([
            'id_reservasi' => $request->id_reservasi,
            'rating'       => $request->rating,
            'komentar'     => $request->komentar,
            'created_at'   => now(),
        ]);

        return redirect()->back()->with('success', 'Testimoni berhasil ditambahkan!');
    }

    // ══════════════════════════════════════════
    // KELOLA LOYALTY REWARDS
    // ══════════════════════════════════════════
    public function loyalty()
    {
        if (!Session::has('login')) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu!');
        }

        // COUNT only Diterima reservations per user
        $loyaltyUsers = DB::table('users')
            ->leftJoin('reservasi', function ($join) {
                $join->on('users.id', '=', 'reservasi.user_id')
                     ->where('reservasi.status', '=', 'Diterima');
            })
            ->select(
                'users.id',
                'users.name',
                'users.email',
                DB::raw('COUNT(reservasi.id_reservasi) as total_success')
            )
            ->groupBy('users.id', 'users.name', 'users.email')
            ->orderByDesc('total_success')
            ->get()
            ->map(function ($u) {
                $total = (int) $u->total_success;

                if ($total >= 5) {
                    $tier = 'Gold';
                } elseif ($total >= 1) {
                    $tier = 'Silver';
                } else {
                    $tier = 'Normal';
                }

                return [
                    'name'           => $u->name,
                    'email'          => $u->email,
                    'totalReservasi' => $total,
                    'tier'           => $tier,
                    'statusKlaim'    => 'Belum Diklaim',
                ];
            });

        $hadiahList = DB::table('hadiah_loyalty')->orderBy('minimal_reservasi')->get();

        return view('admin.loyalty', compact('loyaltyUsers', 'hadiahList'));
    }

    // ══════════════════════════════════════════
    // CRUD HADIAH LOYALTY
    // ══════════════════════════════════════════
    public function storeHadiah(Request $request)
    {
        if (!Session::has('login')) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu!');
        }

        $request->validate([
            'nama_hadiah'       => 'required|string|max:100',
            'minimal_reservasi' => 'required|integer|min:1',
            'stok'              => 'required|integer|min:0',
        ]);

        DB::table('hadiah_loyalty')->insert([
            'nama_hadiah'       => $request->nama_hadiah,
            'minimal_reservasi' => $request->minimal_reservasi,
            'stok'              => $request->stok,
            'created_at'        => now(),
        ]);

        return redirect()->back()->with('success', 'Hadiah berhasil ditambahkan!');
    }

    public function updateHadiah(Request $request, $id)
    {
        if (!Session::has('login')) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu!');
        }

        $request->validate([
            'nama_hadiah'       => 'required|string|max:100',
            'minimal_reservasi' => 'required|integer|min:1',
            'stok'              => 'required|integer|min:0',
        ]);

        DB::table('hadiah_loyalty')->where('id_hadiah', $id)->update([
            'nama_hadiah'       => $request->nama_hadiah,
            'minimal_reservasi' => $request->minimal_reservasi,
            'stok'              => $request->stok,
            'updated_at'        => now(),
        ]);

        return redirect()->back()->with('success', 'Hadiah berhasil diperbarui!');
    }

    public function destroyHadiah($id)
    {
        if (!Session::has('login')) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu!');
        }

        DB::table('hadiah_loyalty')->where('id_hadiah', $id)->delete();

        return redirect()->back()->with('success', 'Hadiah berhasil dihapus!');
    }
}
