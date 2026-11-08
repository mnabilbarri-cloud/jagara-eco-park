<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fasilitas', function (Blueprint $table) {

            $table->integer('id_fasilitas', true);

            $table->string('nama_fasilitas', 100);

            $table->text('keterangan')->nullable();

            $table->integer('harga')->default(0);

            $table->string('gambar', 255)->nullable();

            $table->enum('tipe', ['reservasi', 'umum'])
                  ->default('reservasi');

            $table->integer('kapasitas')->default(50);

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fasilitas');
    }
};