<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;
use App\Http\Requests\StoreBukuRequest;
use App\Http\Requests\UpdateBukuRequest;

class BukuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil semua data buku dari database
        $bukus = Buku::latest()->get();
        
        // Statistik untuk card
        $totalBuku = Buku::count();
        $bukuTersedia = Buku::where('stok', '>', 0)->count();
        $bukuHabis = Buku::where('stok', 0)->count();
        
        // Return view dengan data
        return view('buku.index', compact(
            'bukus',
            'totalBuku',
            'bukuTersedia',
            'bukuHabis'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('buku.create');
    }
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBukuRequest $request)
    {
        try {
        // Create buku baru dengan validated data
        Buku::create($request->validated());
        
        // Redirect dengan success message
        return redirect()->route('buku.index')
                         ->with('success', 'Buku berhasil ditambahkan!');
                         
        } catch (\Exception $e) {
            // Redirect dengan error message jika gagal
            return redirect()->back()
                            ->withInput()
                            ->with('error', 'Gagal menambahkan buku: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Find buku by ID, throw 404 if not found
        $buku = Buku::findOrFail($id);
        
        // Return view detail buku
        return view('buku.show', compact('buku'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $buku = Buku::findOrFail($id);
        return view('buku.edit', compact('buku'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBukuRequest $request, string $id)
    {
        try {
        $buku = Buku::findOrFail($id);
        
        // Update buku dengan validated data
        $buku->update($request->validated());
        
        // Redirect dengan success message
        return redirect()->route('buku.show', $buku->id)
                         ->with('success', 'Buku berhasil diupdate!');
                         
        } catch (\Exception $e) {
            // Redirect dengan error message jika gagal
            return redirect()->back()
                            ->withInput()
                            ->with('error', 'Gagal mengupdate buku: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
         try {
        $buku = Buku::findOrFail($id);
        $judulBuku = $buku->judul;
        
        // Delete buku
        $buku->delete();
        
        // Redirect dengan success message
        return redirect()->route('buku.index')
                         ->with('success', "Buku '{$judulBuku}' berhasil dihapus!");
                         
        } catch (\Exception $e) {
            // Redirect dengan error message jika gagal
            return redirect()->back()
                            ->with('error', 'Gagal menghapus buku: ' . $e->getMessage());
        }
    }

    /**
     * Search resource from storage.
     */
    public function search(Request $request)
    {
        $query = Buku::query();
        
        // 1. Filter berdasarkan Keyword (Sudah dikembalikan agar bisa mencari Judul, Pengarang, dan Penerbit)
        if ($request->has('keyword') && $request->keyword != '') {
            $query->where(function($q) use ($request) {
                $q->where('judul', 'like', '%' . $request->keyword . '%')
                  ->orWhere('pengarang', 'like', '%' . $request->keyword . '%')
                  ->orWhere('penerbit', 'like', '%' . $request->keyword . '%');
            });
        }

        // 2. Filter berdasarkan Tahun Terbit
        if ($request->has('tahun') && $request->tahun != '') {
            $query->where('tahun_terbit', $request->tahun);
        }

        // 3. Filter berdasarkan Ketersediaan Stok
        if ($request->has('ketersediaan') && $request->ketersediaan != '') {
            if ($request->ketersediaan == 'Tersedia') {
                $query->where('stok', '>', 0);
            } elseif ($request->ketersediaan == 'Habis') {
                $query->where('stok', 0);
            }
        }
        
        $bukus = $query->latest()->get();

        // Mengambil ulang data statistik agar kotak atas di halaman index tidak kosong saat dicari
        $totalBuku = Buku::count();
        $bukuTersedia = Buku::where('stok', '>', 0)->count();
        $bukuHabis = Buku::where('stok', '=', 0)->count();

        // Kirim semua variabel secara lengkap ke view
        return view('buku.index', compact('bukus', 'totalBuku', 'bukuTersedia', 'bukuHabis'));
    }

    /**
     * Filter buku berdasarkan kategori.
     */
    public function filterKategori($kategori)
    {
        // Ambil buku berdasarkan kategori saja
        $bukus = Buku::where('kategori', $kategori)->latest()->get();
        
        // Hitung statistik global (dari seluruh buku di perpustakaan) agar angka kotak atas tetap akurat
        $totalBuku = Buku::count();
        $bukuTersedia = Buku::where('stok', '>', 0)->count();
        $bukuHabis = Buku::where('stok', 0)->count();
        
        return view('buku.index', compact(
            'bukus',
            'totalBuku',
            'bukuTersedia',
            'bukuHabis',
            'kategori'
        ));
    }
}