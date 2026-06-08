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
    Schema::create('anggota', function (Blueprint $table) {
        $table->id(); // ID Utama
        $table->string('nama', 100); // Kolom Nama Anggota
        $table->integer('umur'); // WAJIB: Untuk logika kategori_usia (Remaja, Dewasa, Senior)
        $table->string('jenis_kelamin', 10); // WAJIB: Untuk logika scope jenisKelamin (L/P)
        $table->string('status', 20); // WAJIB: Untuk logika status_badge (Aktif/Nonaktif)
        $table->timestamps(); // WAJIB: Kolom created_at untuk logika scope terdaftarBulanIni
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anggota');
    }
};
