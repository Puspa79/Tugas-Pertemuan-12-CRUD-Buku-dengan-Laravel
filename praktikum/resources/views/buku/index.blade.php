@extends('layouts.app')
 
@section('title', 'Daftar Buku')
 
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>
        <i class="bi bi-book"></i>
        Daftar Buku
    </h1>
    <a href="{{ route('buku.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Tambah Buku
    </a>
</div>
 
{{-- Statistik Cards --}}
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card border-primary">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Total Buku</h6>
                        <h2 class="mb-0">{{ $totalBuku }}</h2>
                    </div>
                    <div class="text-primary">
                        <i class="bi bi-book-fill" style="font-size: 3rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card border-success">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Buku Tersedia</h6>
                        <h2 class="mb-0">{{ $bukuTersedia }}</h2>
                    </div>
                    <div class="text-success">
                        <i class="bi bi-check-circle-fill" style="font-size: 3rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card border-danger">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Buku Habis</h6>
                        <h2 class="mb-0">{{ $bukuHabis }}</h2>
                    </div>
                    <div class="text-danger">
                        <i class="bi bi-x-circle-fill" style="font-size: 3rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
 
{{-- Filter & Pencarian Kategori --}}
<div class="card mb-4 shadow-sm">
    <div class="card-body">
        
        <h5 class="card-title text-secondary mb-3"><i class="bi bi-search"></i> Pencarian Buku</h5>
        <form action="{{ url('/buku/search') }}" method="GET" class="row g-3 mb-4">
            
            <div class="col-md-5">
                <input type="text" name="keyword" class="form-control" placeholder="Cari Judul, Pengarang, atau Penerbit..." value="{{ request('keyword') }}">
            </div>

            <div class="col-md-3">
                <select name="tahun" class="form-select">
                    <option value="">-- Pilih Tahun --</option>
                    @foreach($bukus->pluck('tahun_terbit')->unique()->sort() as $tahun)
                        <option value="{{ $tahun }}" {{ request('tahun') == $tahun ? 'selected' : '' }}>{{ $tahun }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-2">
                <select name="ketersediaan" class="form-select">
                    <option value="">-- Status --</option>
                    <option value="Tersedia" {{ request('ketersediaan') == 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
                    <option value="Habis" {{ request('ketersediaan') == 'Habis' ? 'selected' : '' }}>Habis</option>
                </select>
            </div>

            <div class="col-md-2 d-flex gap-2">
                <button type="submit" class="btn btn-primary w-100">Cari</button>
                @if(request()->has('keyword') || request()->has('tahun') || request()->has('ketersediaan'))
                    <a href="{{ route('buku.index') }}" class="btn btn-outline-danger">Reset</a>
                @endif
            </div>
        </form>
        
        <hr> 
        <h6 class="text-secondary mb-2">Filter Kategori:</h6>
        <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('buku.index') }}" class="btn btn-sm {{ !request('kategori') ? 'btn-primary' : 'btn-outline-primary' }}">Semua</a>
            <a href="{{ route('buku.kategori', 'Programming') }}" class="btn btn-sm {{ request('kategori') == 'Programming' ? 'btn-primary' : 'btn-outline-primary' }}">Programming</a>
            <a href="{{ route('buku.kategori', 'Database') }}" class="btn btn-sm {{ request('kategori') == 'Database' ? 'btn-primary' : 'btn-outline-primary' }}">Database</a>
            <a href="{{ route('buku.kategori', 'Web Design') }}" class="btn btn-sm {{ request('kategori') == 'Web Design' ? 'btn-primary' : 'btn-outline-primary' }}">Web Design</a>
            <a href="{{ route('buku.kategori', 'Networking') }}" class="btn btn-sm {{ request('kategori') == 'Networking' ? 'btn-primary' : 'btn-outline-primary' }}">Networking</a>
            <a href="{{ route('buku.kategori', 'Data Science') }}" class="btn btn-sm {{ request('kategori') == 'Data Science' ? 'btn-primary' : 'btn-outline-primary' }}">Data Science</a>
        </div>

    </div>
</div>
 
{{-- Daftar Buku --}}
@forelse ($bukus as $buku)
    <div class="card mb-3 shadow-sm">
        <div class="card-body">
            <div class="row align-items-center">
                
                <div class="col-md-2 text-center">
                    <i class="bi bi-book text-primary" style="font-size: 4rem;"></i>
                    <div class="mt-2">
                        <span class="badge bg-{{ $buku->kategori == 'Programming' ? 'primary' : ($buku->kategori == 'Database' ? 'success' : ($buku->kategori == 'Web Design' ? 'info' : ($buku->kategori == 'Networking' ? 'warning' : 'danger'))) }}">
                            {{ $buku->kategori }}
                        </span>
                    </div>
                </div>
                
                <div class="col-md-7">
                    <h5 class="card-title fw-bold">
                        <a href="{{ route('buku.show', $buku->id) }}" class="text-decoration-none text-primary">
                            {{ $buku->judul }}
                        </a>
                    </h5>
                    
                    <p class="card-text text-muted mb-2">
                        <i class="bi bi-person"></i> {{ $buku->pengarang }} | 
                        <i class="bi bi-building"></i> {{ $buku->penerbit }} | 
                        <i class="bi bi-calendar"></i> {{ $buku->tahun_terbit }}
                    </p>
                    
                    @if ($buku->isbn)
                        <p class="card-text small text-muted mb-1">
                            <i class="bi bi-upc"></i> ISBN: {{ $buku->isbn }}
                        </p>
                    @endif
                    
                    @if ($buku->deskripsi)
                        <p class="card-text text-secondary small">
                            {{ Str::limit($buku->deskripsi, 150) }}
                        </p>
                    @endif
                </div>
                
                <div class="col-md-3" style="display: flex; flex-direction: column; align-items: flex-end; justify-content: center; text-align: right;">
                    
                    <h4 class="text-primary fw-bold mb-2">
                        Rp {{ number_format($buku->harga, 0, ',', '.') }}
                    </h4>
                                                                        
                    <div class="mb-3" style="display: flex; flex-direction: column; align-items: flex-end;">
                        @if ($buku->stok > 0)
                            <span class="badge bg-success">
                                <i class="bi bi-check-circle"></i> Tersedia
                            </span>
                            <div class="text-muted small mt-1">
                                Stok: {{ $buku->stok }} buku
                            </div>
                        @else
                            <span class="badge bg-danger">
                                <i class="bi bi-x-circle"></i> Habis
                            </span>
                            <div class="text-muted small mt-1">
                                Stok: 0 buku
                            </div>
                        @endif
                    </div>
                    
                    <div style="display: flex; flex-direction: column; gap: 8px; width: 100%; max-width: 120px;">
                        <a href="{{ route('buku.show', $buku->id) }}" class="btn btn-sm btn-info text-white text-center">
                            <i class="bi bi-eye"></i> Detail
                        </a>
                        <a href="{{ route('buku.edit', $buku->id) }}" class="btn btn-sm btn-warning text-white text-center">
                            <i class="bi bi-pencil"></i> Edit
                        </a>

                        {{-- SEKARANG SUDAH MENGGUNAKAN FORM SWEETALERT BARU --}}
                        <form action="{{ route('buku.destroy', $buku->id) }}" 
                            method="POST" 
                            class="d-inline delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-sm btn-danger btn-delete w-100" 
                                    data-judul="{{ $buku->judul }}">
                                <i class="bi bi-trash"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
@empty
    <div class="alert alert-info">
        <i class="bi bi-info-circle"></i>
        Tidak ada data buku
        @isset($kategori)
            dengan kategori <strong>{{ $kategori }}</strong>
        @endisset
    </div>
@endforelse
 
@if ($bukus->count() > 0)
    <div class="text-center mt-4">
        <p class="text-muted">
            Menampilkan {{ $bukus->count() }} buku
            @isset($kategori)
                dari kategori <strong>{{ $kategori }}</strong>
            @endisset
        </p>
    </div>
@endif
@endsection

{{-- BAGIAN JAVASCRIPT SWEETALERT DI TARUH DI LUAR UTAMA SEPERTI INI --}}
@push('scripts')
<script>
    // SweetAlert confirmation untuk delete
    document.querySelectorAll('.btn-delete').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const form = this.closest('form');
            const judul = this.getAttribute('data-judul');
            
            Swal.fire({
                title: 'Konfirmasi Hapus',
                text: `Apakah Anda yakin ingin menghapus buku "${judul}"?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
@endpush