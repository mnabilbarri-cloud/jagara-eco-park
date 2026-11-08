<?php

namespace App\Services;

use App\Models\Fasilitas;
use App\Models\Reservasi;
use Carbon\Carbon;

class DashboardService
{
    /**
     * Get dashboard statistics based on filter period
     */
    public function getDashboardStats(string $filter = 'hari'): array
    {
        // Auto-reject pending reservations older than 24 hours
        $this->autoRejectExpiredReservations();

        $query = Reservasi::query();

        if ($filter == 'hari') {
            $query->where('created_at', '>=', today());
        } elseif ($filter == 'minggu') {
            $query->where('created_at', '>=', now()->subDays(7));
        } elseif ($filter == 'bulan') {
            $query->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()]);
        }

        $totalFasilitas = Fasilitas::count();
        $totalReservasi = $query->count();
        $totalDiterima = (clone $query)->where('status', 'Diterima')->count();
        $totalMenunggu = Reservasi::where('status', 'Menunggu')->count();
        $totalDitolak = (clone $query)->where('status', 'Ditolak')->count(); // Added for rejected count
        $totalPendapatan = \DB::table('reservasi')->where('status', 'Diterima')->sum('total_bayar');

        $lastMonthStats = $this->getLastMonthStats();
        $monthlyRevenueData = $this->getMonthlyRevenueData(6);

        $dailyQuotaData = $this->getDailyQuotaData();

        return [
            'filter' => $filter,
            'totalFasilitas' => $totalFasilitas,
            'totalReservasi' => $totalReservasi,
            'totalDiterima' => $totalDiterima,
            'totalMenunggu' => $totalMenunggu,
            'totalDitolak' => $totalDitolak, // Added to returned array
            'totalPendapatan' => $totalPendapatan,
            'lastMonthMenunggu' => $lastMonthStats['menunggu'],
            'lastMonthDiterima' => $lastMonthStats['diterima'],
            'lastMonthDitolak' => $lastMonthStats['ditolak'],
            'monthlyRevenue' => $monthlyRevenueData['revenue'],
            'monthlyLabels' => $monthlyRevenueData['labels'],
            'dailyQuotaData' => $dailyQuotaData,
        ];
    }

    /**
     * Auto-reject reservations pending more than 24 hours
     */
    private function autoRejectExpiredReservations(): void
    {
        Reservasi::where('status', 'Menunggu')
            ->where('created_at', '<', now()->subHours(24))
            ->update(['status' => 'Ditolak']);
    }

    /**
     * Get last month's statistics
     */
    private function getLastMonthStats(): array
    {
        $lastMonth = now()->subMonth();
        $lastMonthStart = $lastMonth->copy()->startOfMonth();
        $lastMonthEnd = $lastMonth->copy()->endOfMonth();

        return [
            'menunggu' => Reservasi::whereBetween('created_at', [$lastMonthStart, $lastMonthEnd])
                ->where('status', 'Menunggu')->count(),
            'diterima' => Reservasi::whereBetween('created_at', [$lastMonthStart, $lastMonthEnd])
                ->where('status', 'Diterima')->count(),
            'ditolak' => Reservasi::whereBetween('created_at', [$lastMonthStart, $lastMonthEnd])
                ->where('status', 'Ditolak')->count(),
        ];
    }

    /**
     * Get monthly revenue data for chart and trend analysis
     */
    public function getMonthlyRevenueData(int $months): array
    {
        $trends = \DB::table('reservasi')
            ->select(
                \DB::raw('YEAR(tanggal_kunjungan) as tahun'), 
                \DB::raw('MONTH(tanggal_kunjungan) as bulan'), 
                \DB::raw('SUM(total_bayar) as total'),
                \DB::raw('COUNT(id_reservasi) as total_reservasi')
            )
            ->where('status', 'Diterima')
            ->groupBy('tahun', 'bulan')
            ->orderBy('tahun', 'asc')
            ->orderBy('bulan', 'asc')
            ->get();

        $monthlyRevenue = [];
        $monthlyLabels = [];
        $monthlyCompletedReservations = [];
        $monthlyTrends = [];

        $monthNames = [
            1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'May', 6 => 'Jun',
            7 => 'Jul', 8 => 'Aug', 9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dec'
        ];

        foreach ($trends as $index => $data) {
            $monthlyLabels[] = $monthNames[$data->bulan] . ' ' . $data->tahun;
            $monthlyRevenue[] = (float) $data->total;
            $monthlyCompletedReservations[] = (int) $data->total_reservasi;

            if ($index === 0) {
                $monthlyTrends[] = 'stable';
            } else {
                $prevRevenue = $monthlyRevenue[$index - 1];
                $currRevenue = (float) $data->total;
                
                if ($currRevenue > $prevRevenue) {
                    $monthlyTrends[] = 'up';
                } elseif ($currRevenue < $prevRevenue) {
                    $monthlyTrends[] = 'down';
                } else {
                    $monthlyTrends[] = 'stable';
                }
            }
        }

        if (empty($monthlyLabels)) {
            $monthlyLabels[] = date('M Y');
            $monthlyRevenue[] = 0;
            $monthlyCompletedReservations[] = 0;
            $monthlyTrends[] = 'stable';
        }

        return [
            'revenue' => $monthlyRevenue,
            'labels' => $monthlyLabels,
            'completed_reservations' => $monthlyCompletedReservations,
            'trends' => $monthlyTrends,
        ];
    }

    /**
     * Get daily quota breakdown for next 14 days
     */
    public function getDailyQuotaData(): array
    {
        $startDate = today();
        $endDate = today()->addDays(13);
        $dailyData = [];

        // Get all reservable facilities (excluding 'umum' like Mushola)
        $reservableFacilities = Fasilitas::where('tipe', 'reservasi')->get();

        for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
            $dateStr = $date->format('Y-m-d');
            $dayData = [
                'date' => $dateStr,
                'formatted_date' => $date->locale('id')->isoFormat('D MMMM Y'),
                'weekday' => $date->locale('id')->isoFormat('dddd'),
                'facilities' => [],
            ];

            foreach ($reservableFacilities as $facility) {
                // Calculate booked tickets for this date and facility
                $terpakai = \DB::table('reservasi')
                    ->where('id_fasilitas', $facility->id_fasilitas)
                    ->whereDate('tanggal_kunjungan', $dateStr)
                    ->where('status', 'Diterima')
                    ->sum('jumlah_tiket');

                $capacity = $facility->kapasitas;
                $remaining = $capacity - $terpakai;

                $dayData['facilities'][] = [
                    'id' => $facility->id_fasilitas,
                    'name' => $facility->nama_fasilitas,
                    'booked' => $terpakai,
                    'capacity' => $capacity,
                    'remaining' => max(0, $remaining),
                    'is_full' => $remaining <= 0,
                    'is_almost_full' => $remaining <= $capacity * 0.2 && $remaining > 0,
                ];
            }

            $dailyData[] = $dayData;
        }

        return $dailyData;
    }
}
