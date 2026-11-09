<?php

namespace App\Services;

class FileUploadService
{
    /**
     * Upload facility image
     */
    public function uploadFacilityImage($file, string $oldImage = null): string
    {
        $dest = public_path('assets/images');
        
        if (!file_exists($dest)) {
            mkdir($dest, 0755, true);
        }

        // Delete old image if exists
        if ($oldImage && $oldImage !== 'default.jpg') {
            $oldPath = public_path('assets/images/' . $oldImage);
            if (file_exists($oldPath)) {
                @unlink($oldPath);
            }
        }

        if ($file) {
            // [KEAMANAN] Gunakan getMimeType() bukan getClientOriginalExtension()
            // getClientOriginalExtension() bisa dimanipulasi attacker dengan rename file
            // getMimeType() membaca isi file sesungguhnya (lebih aman)
            $mimeToExt = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/gif' => 'gif', 'image/webp' => 'webp'];
            $mime = $file->getMimeType();
            $ext = $mimeToExt[$mime] ?? 'jpg'; // default jpg jika tidak dikenali
            $nama_gambar = uniqid('fasilitas_') . '_' . time() . '.' . $ext;
            $file->move($dest, $nama_gambar);
            return $nama_gambar;
        }

        return $oldImage ?? 'default.jpg';
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

    /**
     * Delete facility image
     */
    public function deleteFacilityImage(string $imageName): void
    {
        if ($imageName && $imageName !== 'default.jpg') {
            $path = public_path('assets/images/' . $imageName);
            if (file_exists($path)) {
                @unlink($path);
            }
        }
    }
}
