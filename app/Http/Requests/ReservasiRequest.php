<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class ReservasiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama_pengunjung'   => 'required|string|max:100|regex:/^[a-zA-Z\s\.\-]+$/',
            'no_hp'             => 'required|string|max:20|regex:/^[0-9\+\-\s]+$/',
            'tanggal_kunjungan' => 'required|date|after_or_equal:today',
            'id_fasilitas'      => 'required|integer|exists:fasilitas,id_fasilitas',
            'jumlah_tiket'      => 'required|integer|min:1|max:50',
            'metode_pembayaran' => 'required|in:QRIS,Transfer,E-Wallet',
            'gambar'            => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'nama_pengunjung.required' => 'Nama pengunjung wajib diisi.',
            'nama_pengunjung.regex' => 'Nama pengunjung hanya boleh berisi huruf, spasi, titik, dan tanda hubung.',
            'no_hp.required' => 'Nomor HP wajib diisi.',
            'no_hp.regex' => 'Nomor HP hanya boleh berisi angka, tanda +, -, dan spasi.',
            'tanggal_kunjungan.required' => 'Tanggal kunjungan wajib diisi.',
            'tanggal_kunjungan.after_or_equal' => 'Tanggal kunjungan tidak boleh di masa lalu!',
            'id_fasilitas.required' => 'Fasilitas wajib dipilih.',
            'id_fasilitas.exists' => 'Fasilitas tidak ditemukan!',
            'jumlah_tiket.required' => 'Jumlah tiket wajib diisi.',
            'jumlah_tiket.min' => 'Minimal 1 tiket.',
            'jumlah_tiket.max' => 'Maksimal 50 tiket per reservasi.',
            'metode_pembayaran.required' => 'Metode pembayaran wajib dipilih.',
            'metode_pembayaran.in' => 'Metode pembayaran tidak valid.',
            'gambar.image' => 'File gambar harus berupa gambar yang valid.',
            'gambar.mimes' => 'Format gambar tidak valid. Hanya JPG dan PNG yang diperbolehkan.',
            'gambar.max' => 'Ukuran gambar terlalu besar. Maksimal 2MB.',
        ];
    }

    protected function prepareForValidation()
    {
        // Sanitize inputs
        $this->merge([
            'nama_pengunjung' => strip_tags(trim($this->nama_pengunjung)),
            'no_hp' => preg_replace('/[^0-9\+\-]/', '', trim($this->no_hp)),
        ]);
    }

    public function validated($key = null, $default = null)
    {
        $validated = parent::validated($key, $default);
        
        // Only apply sanitization if we have an array (not a single value)
        if (is_array($validated) && isset($validated['nama_pengunjung'])) {
            $validated['nama_pengunjung'] = Str::title($validated['nama_pengunjung']);
        }
        
        return $validated;
    }
}
