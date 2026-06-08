<?php

namespace Database\Seeders;

// use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
   public function run(): void
{
    $this->call([
        KategoriSeeder::class, // Seeder kategori pertemuan 10 kemarin
        BukuSeeder::class,     // Panggil seeder buku Anda
        AnggotaSeeder::class,  // Panggil seeder anggota Anda
    ]);
}
}
