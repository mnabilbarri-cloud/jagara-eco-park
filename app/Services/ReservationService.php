<?php

namespace App\Services;

use App\Models\Fasilitas;
use App\Models\Reservasi;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ReservationService
{
    /**
     * Check if user has recent pending reservation (anti-spam)
     */
    public function hasRecentPendingReservation(string $noHp, ?int $userId = null): bool
    {
        $query = Reservasi::where('status', 'Menunggu')
            ->where('created_at', '>', now()->subHours(24));
        
        $query->where(function($q) use ($noHp, $userId) {
            $q->where('no_hp', $noHp);
            if ($userId) {
                $q->orWhere('user_id', $userId);
            }
        });

        return $query->exists();
    }

    /**
     * Check for double booking
     */
    public function hasDoubleBooking(string $noHp, string $tanggal, int $idFasilitas): bool
    {
        return Reservasi::where('no_hp', $noHp)
            ->where('tanggal_kunjungan', $tanggal)
            ->where('id_fasilitas', $idFasilitas)
            ->whereIn('status', ['Menunggu', 'Diterima'])
            ->exists();
    }

    /**
     * Check facility capacity
     */
    public function checkCapacity(int $idFasilitas, string $tanggal, int $jumlahTiket): array
    {
        $fasilitas = Fasilitas::lockForUpdate()->find($idFasilitas);
        
        if (!$fasilitas || $fasilitas->kapasitas === null) {
            return ['available' => true, 'remaining' => null];
        }

        $totalBooked = Reservasi::where('id_fasilitas', $idFasilitas)
            ->where('tanggal_kunjungan', $tanggal)
            ->whereIn('status', ['Diterima', 'Menunggu'])
            ->sum('jumlah_tiket');

        $remaining = $fasilitas->kapasitas - $totalBooked;

        return [
            'available' => $jumlahTiket <= $remaining,
            'remaining' => $remaining
        ];
    }

    /**
     * Generate unique reservation code
     */
    public function generateReservationCode(): string
    {
        do {
            $kode = 'JG' . date('YmdHis') . rand(1000, 9999);
        } while (Reservasi::where('kode_reservasi', $kode)->exists());

        return $kode;
    }

    /**
     * Calculate price with discount for logged-in user
     */
    public function calculatePrice(int $basePrice, int $jumlahTiket, ?int $userId = null): array
    {
        $total = $basePrice * $jumlahTiket;
        $discountPercentage = 0;
        $discountAmount = 0;

        if ($userId) {
            $user = \App\Models\User::find($userId);
            if ($user) {
                $discountPercentage = $user->getDiscountPercentage();
                if ($discountPercentage > 0) {
                    $discountAmount = ($total * $discountPercentage) / 100;
                    $total = $total - $discountAmount;
                }
            }
        }

        return [
            'total' => $total,
            'discount_percentage' => $discountPercentage,
            'discount_amount' => $discountAmount
        ];
    }

    /**
     * Create reservation with transaction
     */
    public function createReservation(array $data): Reservasi
    {
        return DB::transaction(function() use ($data) {
            return Reservasi::create($data);
        });
    }

    /**
     * Update user discount tier after successful reservation
     */
    public function updateUserDiscountTier(int $userId): void
    {
        $user = \App\Models\User::find($userId);
        if ($user) {
            $user->updateDiscountTier();
        }
    }

    /**
     * Upload payment proof
     */
    public function uploadPaymentProof($file, string $kodeReservasi, string $oldFile = null): string
    {
        $targetDir = public_path('assets/images/bukti_bayar');

        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }

        // Delete old file if exists
        if ($oldFile) {
            $oldPath = public_path('assets/images/bukti_bayar/' . $oldFile);
            if (file_exists($oldPath)) {
                unlink($oldPath);
            }
        }

        $ext = strtolower($file->getMimeType() === 'image/png' ? 'png' : 'jpg');
        $filename = 'BUKTI_' . $kodeReservasi . '_' . time() . '.' . $ext;
        $file->move($targetDir, $filename);

        return $filename;
    }
}
