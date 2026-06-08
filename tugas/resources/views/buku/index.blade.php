@extends('layouts.app')
 
@section('title', 'Daftar Buku')
 
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold mb-0">
        <i class="bi bi-book-half text-primary me-2"></i>Daftar Buku
    </h2>
    {{-- Kelompok Tombol Aksi di Kanan Atas --}}
    <div class="d-flex gap-2">
        {{-- Tombol Tambah Buku yang Sudah Ada --}}
        <a href="{{ route('buku.create') }}" class="btn btn-primary fw-semibold shadow-sm d-flex align-items-center">
            <i class="bi bi-plus-circle me-2"></i>Tambah Buku
        </a>

        {{-- Tombol Export CSV Baru (Tugas 3) --}}
        <a href="{{ route('buku.export') }}" class="btn btn-success fw-semibold shadow-sm d-flex align-items-center">
            <i class="bi bi-file-earmark-arrow-down me-2"></i>Export CSV
        </a>
    </div>
</div>
 
{{-- Statistik Cards (Dipertegas dengan Border Solid) --}}
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card shadow-sm bg-white rounded-3 border border-secondary-subtle">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted text-uppercase small fw-bold mb-1">Total Buku</h6>
                        <h2 class="fw-bold mb-0 text-dark">{{ $totalBuku }}</h2>
                    </div>
                    <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-3">
                        <i class="bi bi-book-fill fs-3"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card shadow-sm bg-white rounded-3 border border-secondary-subtle">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted text-uppercase small fw-bold mb-1">Buku Tersedia</h6>
                        <h2 class="fw-bold mb-0 text-success">{{ $bukuTersedia }}</h2>
                    </div>
                    <div class="bg-success bg-opacity-10 text-success p-3 rounded-3">
                        <i class="bi bi-check-circle-fill fs-3"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card shadow-sm bg-white rounded-3 border border-secondary-subtle">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted text-uppercase small fw-bold mb-1">Buku Habis</h6>
                        <h2 class="fw-bold mb-0 text-danger">{{ $bukuHabis }}</h2>
                    </div>
                    <div class="bg-danger bg-opacity-10 text-danger p-3 rounded-3">
                        <i class="bi bi-x-circle-fill fs-3"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
 
{{-- Filter & Pencarian Kategori (Dipertegas dengan Border Solid) --}}
<div class="card shadow-sm mb-4 rounded-3 bg-white border border-secondary-subtle">
    <div class="card-body p-4">
        <h5 class="card-title fw-bold text-dark mb-3">
            <i class="bi bi-search me-2 text-secondary"></i>Pencarian Buku
        </h5>
        <form action="{{ url('/buku/search') }}" method="GET" class="row g-3 mb-4">
            <div class="col-md-5">
                <input type="text" name="keyword" class="form-control bg-light border border-secondary-subtle py-2 px-3" placeholder="Cari Judul, Pengarang, atau Penerbit..." value="{{ request('keyword') }}">
            </div>

            <div class="col-md-3">
                <select name="tahun" class="form-select bg-light border border-secondary-subtle py-2">
                    <option value="">-- Pilih Tahun --</option>
                    @foreach($bukus->pluck('tahun_terbit')->unique()->sort() as $tahun)
                        <option value="{{ $tahun }}" {{ request('tahun') == $tahun ? 'selected' : '' }}>{{ $tahun }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-2">
                <select name="ketersediaan" class="form-select bg-light border border-secondary-subtle py-2">
                    <option value="">-- Status --</option>
                    <option value="Tersedia" {{ request('ketersediaan') == 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
                    <option value="Habis" {{ request('ketersediaan') == 'Habis' ? 'selected' : '' }}>Habis</option>
                </select>
            </div>

            <div class="col-md-2 d-flex gap-2">
                <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">Cari</button>
                @if(request()->has('keyword') || request()->has('tahun') || request()->has('ketersediaan'))
                    <a href="{{ route('buku.index') }}" class="btn btn-light text-danger border border-secondary-subtle py-2 px-3"><i class="bi bi-arrow-counterclockwise"></i></a>
                @endif
            </div>
        </form>
        
        <hr class="text-muted opacity-25"> 
        <h6 class="text-secondary fw-bold small mb-2">Filter Kategori:</h6>
        <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('buku.index') }}" class="btn btn-sm rounded-pill px-3 {{ !request('kategori') ? 'btn-primary' : 'btn-outline-primary' }}">Semua</a>
            <a href="{{ route('buku.kategori', 'Programming') }}" class="btn btn-sm rounded-pill px-3 {{ request('kategori') == 'Programming' ? 'btn-primary' : 'btn-outline-primary' }}">Programming</a>
            <a href="{{ route('buku.kategori', 'Database') }}" class="btn btn-sm rounded-pill px-3 {{ request('kategori') == 'Database' ? 'btn-primary' : 'btn-outline-primary' }}">Database</a>
            <a href="{{ route('buku.kategori', 'Web Design') }}" class="btn btn-sm rounded-pill px-3 {{ request('kategori') == 'Web Design' ? 'btn-primary' : 'btn-outline-primary' }}">Web Design</a>
            <a href="{{ route('buku.kategori', 'Networking') }}" class="btn btn-sm rounded-pill px-3 {{ request('kategori') == 'Networking' ? 'btn-primary' : 'btn-outline-primary' }}">Networking</a>
            <a href="{{ route('buku.kategori', 'Data Science') }}" class="btn btn-sm rounded-pill px-3 {{ request('kategori') == 'Data Science' ? 'btn-primary' : 'btn-outline-primary' }}">Data Science</a>
        </div>
    </div>
</div>

<form action="{{ route('buku.bulk-delete') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus buku-buku yang dipilih?')">
    @csrf

    <div class="d-flex justify-content-between align-items-center mb-3 bg-white p-3 rounded-3 shadow-sm border-start border-danger border-3">
        <div class="form-check m-0 d-flex align-items-center">
            <input class="form-check-input" type="checkbox" id="select-all" style="transform: scale(1.2); cursor: pointer;">
            <label class="form-check-label fw-bold text-dark ms-2" for="select-all" style="cursor: pointer; user-select: none;">
                Pilih Semua Buku
            </label>
        </div>
        
        <button type="submit" class="btn btn-danger btn-sm px-3 fw-semibold shadow-sm">
            <i class="bi bi-trash3-fill me-2"></i>Hapus Buku Terpilih
        </button>
    </div>
 
{{-- Daftar Buku (Garis Kotak Dipertegas & Lebih Gelap) --}}
    @forelse ($bukus as $buku)
        <div class="card shadow-sm mb-3 rounded-3 overflow-hidden bg-white border border-secondary" style="border-width: 1.5px !important;">
            <div class="card-body p-4">
                <div class="row align-items-center g-3">
                    
                    {{-- 1. Checkbox Kolom dengan Pembatas Vertikal yang Jelas --}}
                    <div class="col-auto d-flex align-items-center pe-3 border-end border-secondary-subtle">
                        <input type="checkbox" name="buku_ids[]" value="{{ $buku->id }}" class="form-check-input border-secondary" style="transform: scale(1.3); cursor: pointer;">
                    </div>
                    
                    {{-- 2. Ikon Buku Besar & Badge Kategori --}}
                    <div class="col-md-2 text-center border-end border-light-subtle pr-3">
                        <div class="bg-light p-3 rounded-3 d-inline-block mb-2 border border-light-subtle">
                            <i class="bi bi-book text-primary" style="font-size: 3rem;"></i>
                        </div>
                        <div>
                            <span class="badge rounded-pill bg-{{ $buku->kategori == 'Programming' ? 'primary' : ($buku->kategori == 'Database' ? 'success' : ($buku->kategori == 'Web Design' ? 'info' : ($buku->kategori == 'Networking' ? 'warning' : 'danger'))) }} px-3">
                                {{ $buku->kategori }}
                            </span>
                        </div>
                    </div>
                    
                    {{-- 3. Informasi Utama Buku --}}
                    <div class="col-md-5"> 
                        <h5 class="fw-bold mb-2">
                            <a href="{{ route('buku.show', $buku->id) }}" class="text-decoration-none text-dark hover-primary">
                                {{ $buku->judul }}
                            </a>
                        </h5>
                        
                        <div class="text-muted small mb-2 d-flex flex-wrap gap-2 align-items-center">
                            <span><i class="bi bi-person me-1"></i>{{ $buku->pengarang }}</span>
                            <span class="text-light-emphasis">|</span>
                            <span><i class="bi bi-building me-1"></i>{{ $buku->penerbit }}</span>
                            <span class="text-light-emphasis">|</span>
                            <span><i class="bi bi-calendar me-1"></i>{{ $buku->tahun_terbit }}</span>
                        </div>
                        
                        @if ($buku->isbn)
                            <div class="badge bg-light text-secondary border border-secondary-subtle small fw-normal text-start">
                                <i class="bi bi-upc me-1"></i>ISBN: {{ $buku->isbn }}
                            </div>
                        @endif
                    </div>
                    
                    {{-- 4. Harga & Ketersediaan Stok --}}
                    <div class="col-md-2 text-center text-md-end border-start border-light-subtle pr-3">
                        <h4 class="text-primary fw-bold mb-1">
                            Rp {{ number_format($buku->harga, 0, ',', '.') }}
                        </h4>
                        <div>
                            @if ($buku->stok > 0)
                                <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-2 py-1">
                                    <i class="bi bi-check-circle me-1"></i>Tersedia ({{ $buku->stok }})
                                </span>
                            @else
                                <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 px-2 py-1">
                                    <i class="bi bi-x-circle me-1"></i>Habis
                                </span>
                            @endif
                        </div>
                    </div>

                    {{-- 5. Kelompok Tombol Aksi Horizontal --}}
                    <div class="col-md-2 text-center text-md-end">
                        <div class="d-flex justify-content-center justify-content-md-end gap-2">
                            <a href="{{ route('buku.show', $buku->id) }}" class="btn btn-outline-info btn-sm rounded-3 shadow-sm px-2 border-secondary-subtle" title="Detail">
                                <i class="bi bi-eye-fill"></i>
                            </a>
                            <a href="{{ route('buku.edit', $buku->id) }}" class="btn btn-outline-warning btn-sm rounded-3 shadow-sm px-2 border-secondary-subtle" title="Edit">
                                <i class="bi bi-pencil-fill"></i>
                            </a>
                            <form action="{{ route('buku.destroy', $buku->id) }}" method="POST" class="d-inline delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-outline-danger btn-sm rounded-3 shadow-sm px-2 btn-delete border-secondary-subtle" data-judul="{{ $buku->judul }}" title="Hapus">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    @empty
        <div class="alert alert-light border shadow-sm text-center py-4 rounded-3">
            <i class="bi bi-info-circle text-info fs-3 d-block mb-2"></i>
            <span class="text-muted">Tidak ada data buku ditemukan</span>
            @isset($kategori)
                dengan kategori <strong>{{ $kategori }}</strong>
            @endisset
        </div>
    @endforelse
</form>
 
@if ($bukus->count() > 0)
    <div class="text-center mt-4">
        <p class="small text-muted fw-medium">
            Menampilkan {{ $bukus->count() }} buku sesuai kriteria filter.
        </p>
    </div>
@endif
@endsection

@push('scripts')
<script>
    // Logika Otomatisasi Checkbox Select All
    document.getElementById('select-all').addEventListener('change', function() {
        document.querySelectorAll('input[name="buku_ids[]"]').forEach(cb => {
            cb.checked = this.checked;
        });
    });

    // SweetAlert confirmation untuk single delete
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