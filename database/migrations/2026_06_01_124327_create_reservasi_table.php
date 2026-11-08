<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reservasi', function (Blueprint $table) {

            $table->integer('id_reservasi', true);

            $table->string('kode_reservasi', 20)
                  ->nullable()
                  ->unique();

            $table->string('nama_pengunjung', 100);

            $table->string('no_hp', 20)
                  ->nullable()
                  ->index();

            $table->date('tanggal_kunjungan')
                  ->nullable()
                  ->index();

            $table->integer('id_fasilitas')
                  ->nullable();

            $table->integer('jumlah_tiket');

            $table->integer('total_bayar')
                  ->nullable();

            $table->enum('status', [
                'Menunggu',
                'Diterima',
                'Ditolak'
            ])->default('Menunggu')
              ->index();

            $table->string('bukti_pembayaran', 255)
                  ->nullable();

            $table->text('catatan_admin')
                  ->nullable();

            $table->timestamp('created_at')
                  ->useCurrent()
                  ->index();

            // Composite index for fast capacity queries
            $table->index(['id_fasilitas', 'tanggal_kunjungan', 'status'], 'idx_capacity_check');
        });

        Schema::table('reservasi', function (Blueprint $table) {

            $table->foreign('id_fasilitas')
                  ->references('id_fasilitas')
                  ->on('fasilitas')
                  ->onDelete('cascade');

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservasi');
    }
};