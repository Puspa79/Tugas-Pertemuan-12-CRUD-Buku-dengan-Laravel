<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
use App\Models\Buku; // Pastikan model Buku sudah ada
use App\Models\Anggota; // Pastikan model Anggota sudah ada

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik Buku
        $totalBuku = Buku::count();
        $bukuTersedia = Buku::where('stok', '>', 0)->count();
        $bukuHabis = Buku::where('stok', 0)->count();

        // Statistik Anggota
        $totalAnggota = Anggota::count();
        $anggotaAktif = Anggota::where('status', 'aktif')->count();
        $anggotaNonaktif = Anggota::where('status', 'nonaktif')->count();

        // List 5 Terbaru
        $bukuTerbaru = Buku::latest()->take(5)->get();
        $anggotaTerbaru = Anggota::latest()->take(5)->get();

        return view('dashboard.index', compact(
            'totalBuku', 'bukuTersedia', 'bukuHabis',
            'totalAnggota', 'anggotaAktif', 'anggotaNonaktif',
            'bukuTerbaru', 'anggotaTerbaru'
        ));
    }
}