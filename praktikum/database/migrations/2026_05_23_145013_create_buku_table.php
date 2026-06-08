<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('buku', function (Blueprint $table) {
        $table->id(); // ID Utama
        $table->string('judul', 100); // Kolom Judul Buku
        $table->integer('stok'); // WAJIB: Untuk logika status_stok_badge & scope stokMenipis
        $table->integer('harga'); // WAJIB: Untuk logika scope hargaRange
        $table->integer('tahun_terbit'); // WAJIB: Untuk logika tahun_label & scope terbaru
        $table->timestamps(); // Menggenerate otomatis created_at dan updated_at
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buku');
    }
};
