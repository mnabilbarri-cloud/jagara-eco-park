<?php

namespace App\Http\Controllers;

use App\Http\Requests\FasilitasRequest;
use App\Models\Fasilitas;
use App\Models\Reservasi;
use App\Services\FileUploadService;
use Carbon\Carbon;

class FasilitasController extends Controller
{
    protected $fileUploadService;

    public function __construct(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }

    public function index()
    {
        $fasilitas = Fasilitas::orderBy('id_fasilitas', 'desc')->get();

        return view('data_fasilitas', compact('fasilitas'));
    }

    public function create()
    {
        return view('tambah_fasilitas');
    }

    public function store(FasilitasRequest $request)
    {
        $nama_gambar = $this->fileUploadService->uploadFacilityImage(
            $request->hasFile('gambar') ? $request->file('gambar') : null
        );

        Fasilitas::create([
            'nama_fasilitas' => $request->nama_fasilitas,
            'keterangan'     => $request->keterangan,
            'harga'          => $request->harga,
            'gambar'         => $nama_gambar,
            'tipe'           => $request->tipe ?? 'reservasi',
            'kapasitas'      => $request->kapasitas ?? 50
        ]);

        return redirect()
            ->route('fasilitas.index')
            ->with('success', 'Fasilitas berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $data = Fasilitas::findOrFail($id);

        return view('edit_fasilitas', [
            'f' => $data
        ]);
    }

    public function update(FasilitasRequest $request, $id)
    {
        $fasilitas = Fasilitas::findOrFail($id);

        $fasilitas->gambar = $this->fileUploadService->uploadFacilityImage(
            $request->hasFile('gambar') ? $request->file('gambar') : null,
            $fasilitas->gambar
        );

        $fasilitas->nama_fasilitas = $request->nama_fasilitas;
        $fasilitas->keterangan = $request->keterangan;
        $fasilitas->harga = $request->harga;
        $fasilitas->tipe = $request->tipe ?? $fasilitas->tipe;
        $fasilitas->kapasitas = $request->kapasitas ?? $fasilitas->kapasitas;
        $fasilitas->save();

        return redirect()
            ->route('fasilitas.index')
            ->with('success', 'Fasilitas berhasil diperbarui!');
    }

    public function show($id)
    {
        $fasilitas = Fasilitas::findOrFail($id);
        
        // Get all other facilities for recommendations
        $all_fasilitas = Fasilitas::all();
        
        // Calculate availability for next 14 days
        $availabilityData = [];
        $today = Carbon::today();
        
        for ($i = 0; $i < 14; $i++) {
            $date = $today->copy()->addDays($i);
            $dateStr = $date->toDateString();
            
            // Get total booked tickets for this date
            $bookedTickets = Reservasi::where('id_fasilitas', $id)
                ->whereDate('tanggal_kunjungan', $dateStr)
                ->where('status', '!=', 'Ditolak')
                ->sum('jumlah_tiket');
                
            $remaining = $fasilitas->kapasitas - $bookedTickets;
            $isAvailable = $remaining > 0;
            
            $availabilityData[] = [
                'date' => $dateStr,
                'formatted_date' => $date->translatedFormat('d F Y'),
                'weekday' => $date->translatedFormat('l'),
                'booked' => $bookedTickets,
                'remaining' => $remaining,
                'capacity' => $fasilitas->kapasitas,
                'is_available' => $isAvailable
            ];
        }
        
        $reviewStats = \DB::table('testimoni')
            ->join('reservasi', 'testimoni.id_reservasi', '=', 'reservasi.id_reservasi')
            ->where('reservasi.id_fasilitas', $id)
            ->select(\DB::raw('AVG(testimoni.rating) as avg_rating'), \DB::raw('COUNT(testimoni.id_testimoni) as total_reviews'))
            ->first();

        $ulasanList = \DB::table('testimoni')
            ->join('reservasi', 'testimoni.id_reservasi', '=', 'reservasi.id_reservasi')
            ->join('users', 'reservasi.user_id', '=', 'users.id')
            ->where('reservasi.id_fasilitas', $id)
            ->select('users.name', 'testimoni.rating', 'testimoni.komentar', 'testimoni.created_at')
            ->orderByDesc('testimoni.created_at')
            ->get();
        
        return view('fasilitas.show', compact('fasilitas', 'availabilityData', 'all_fasilitas', 'reviewStats', 'ulasanList'));
    }

    public function destroy($id)
    {
        $fasilitas = Fasilitas::findOrFail($id);

        $this->fileUploadService->deleteFacilityImage($fasilitas->gambar);

        $fasilitas->delete();

        return redirect()
            ->route('fasilitas.index')
            ->with('success', 'Fasilitas berhasil dihapus!');
    }
}
