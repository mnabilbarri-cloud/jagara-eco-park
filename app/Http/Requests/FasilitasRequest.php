<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FasilitasRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama_fasilitas' => 'required|string|max:255',
            'keterangan'     => 'nullable|string|max:1000',
            'harga'          => 'required|numeric|min:0',
            'gambar'         => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'nama_fasilitas.required' => 'Nama fasilitas wajib diisi.',
            'harga.required' => 'Harga fasilitas wajib diisi.',
            'harga.numeric' => 'Harga harus berupa angka.',
            'harga.min' => 'Harga tidak boleh negatif.',
            'gambar.image' => 'File gambar harus berupa gambar yang valid.',
            'gambar.mimes' => 'Format gambar tidak valid. Hanya JPG dan PNG yang diperbolehkan.',
            'gambar.max' => 'Ukuran gambar terlalu besar. Maksimal 2MB.',
        ];
    }
}
