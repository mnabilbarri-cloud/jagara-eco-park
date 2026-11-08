<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed Admin
        DB::table('admin')->updateOrInsert(
            ['id_admin' => 1],
            [
                'username' => 'admin',
                'password' => '$2y$10$hkQGH8GJbIHdbvorWnReQOri7R7Dc0KK1NGQF4RlzLSBKtOkbqWLq' // password: admin
            ]
        );

        // 2. Seed Fasilitas
        $fasilitas = [
            [
                'id_fasilitas' => 1,
                'nama_fasilitas' => 'Resto Jagara',
                'keterangan' => 'Tempat makan dengan suasana alam.',
                'harga' => 10000,
                'gambar' => 'resto.jpg',
                'tipe' => 'reservasi',
                'kapasitas' => 50
            ],
            [
                'id_fasilitas' => 2,
                'nama_fasilitas' => 'Area Indoor',
                'keterangan' => 'Cocok untuk acara keluarga dan meeting.',
                'harga' => 15000,
                'gambar' => 'indoor.jpg',
                'tipe' => 'reservasi',
                'kapasitas' => 50
            ],
            [
                'id_fasilitas' => 3,
                'nama_fasilitas' => 'Area Outdoor',
                'keterangan' => 'Area terbuka untuk keluarga dan komunitas.',
                'harga' => 10000,
                'gambar' => 'outdoor.jpg',
                'tipe' => 'reservasi',
                'kapasitas' => 50
            ],
            [
                'id_fasilitas' => 4,
                'nama_fasilitas' => 'ATV Adventure',
                'keterangan' => 'Wahana petualangan penuh tantangan.',
                'harga' => 40000,
                'gambar' => 'atv.jpg',
                'tipe' => 'reservasi',
                'kapasitas' => 50
            ],
            [
                'id_fasilitas' => 5,
                'nama_fasilitas' => 'Mini Gokart',
                'keterangan' => 'Wahana balap mini untuk semua umur.',
                'harga' => 30000,
                'gambar' => 'gokart.jpg',
                'tipe' => 'reservasi',
                'kapasitas' => 50
            ],
            [
                'id_fasilitas' => 6,
                'nama_fasilitas' => 'Fun Slide',
                'keterangan' => 'Seluncuran seru untuk keluarga.',
                'harga' => 35000,
                'gambar' => 'funslide.jpg',
                'tipe' => 'reservasi',
                'kapasitas' => 50
            ],
            [
                'id_fasilitas' => 7,
                'nama_fasilitas' => 'Cabin Teras Bumi',
                'keterangan' => 'Penginapan bernuansa alam.',
                'harga' => 80000,
                'gambar' => 'cabin.jpg',
                'tipe' => 'reservasi',
                'kapasitas' => 50
            ],
            [
                'id_fasilitas' => 8,
                'nama_fasilitas' => 'Istana Balon',
                'keterangan' => 'Wahana bermain anak-anak.',
                'harga' => 20000,
                'gambar' => 'balon.jpg',
                'tipe' => 'reservasi',
                'kapasitas' => 50
            ],
            [
                'id_fasilitas' => 9,
                'nama_fasilitas' => 'Mushola',
                'keterangan' => 'Fasilitas ibadah yang nyaman.',
                'harga' => 0,
                'gambar' => 'mushola.jpg',
                'tipe' => 'umum',
                'kapasitas' => 50
            ],
        ];

        foreach ($fasilitas as $f) {
            DB::table('fasilitas')->updateOrInsert(
                ['id_fasilitas' => $f['id_fasilitas']],
                $f
            );
        }
    }
}
