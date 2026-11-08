<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservasi extends Model
{
    use HasFactory;

    protected $table = 'reservasi';

    protected $primaryKey = 'id_reservasi';

    public $timestamps = false;

    protected $fillable = [
        'kode_reservasi',
        'nama_pengunjung',
        'no_hp',
        'tanggal_kunjungan',
        'id_fasilitas',
        'jumlah_tiket',
        'total_bayar',
        'status',
        'bukti_pembayaran',
        'catatan_admin',
        'user_id'
    ];

    public function fasilitas()
    {
        return $this->belongsTo(
            Fasilitas::class,
            'id_fasilitas',
            'id_fasilitas'
        );
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}   