<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

class Anggota extends Model {
// --- ACCESSOR ---
protected $table = 'anggota';

    protected $fillable = [
        'nama',
        'umur',
        'jenis_kelamin',
        'status'
    ];

// Accessor status_badge: $anggota->status_badge
public function getStatusBadgeAttribute(): string
{
    // Asumsi nilai status adalah 'aktif' atau 1
    if ($this->status === 'aktif' || $this->status == 1) {
        return '<span class="badge bg-success">Aktif</span>';
    }
    return '<span class="badge bg-secondary">Nonaktif</span>';
}

// Accessor kategori_usia: $anggota->kategori_usia
public function getKategoriUsiaAttribute(): string
{
    $umur = $this->umur;

    if ($umur < 20) {
        return 'Remaja';
    } elseif ($umur >= 20 && $umur <= 50) {
        return 'Dewasa';
    } else {
        return 'Senior';
    }
}

// --- QUERY SCOPES ---

// Scope jenisKelamin($jk)
public function scopeJenisKelamin($query, $jk)
{
    return $query->where('jenis_kelamin', $jk);
}

// Scope terdaftarBulanIni()
public function scopeTerdaftarBulanIni($query)
{
    return $query->whereMonth('created_at', Carbon::now()->month)
                 ->whereYear('created_at', Carbon::now()->year);
}
}