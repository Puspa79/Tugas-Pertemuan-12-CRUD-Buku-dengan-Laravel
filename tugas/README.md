# Dashboard, Advanced Validation, Bulk Operations & CSV Export — Pertemuan 12

**Nama:** Puspa Dwi Setyorini  
**NIM:** 60324003  
**Prodi:** Informatika  
**Semester:** 4  
**Mata Kuliah:** Pemrograman Web II  
**Repository:** [Link GitHub](https://github.com/Puspa79/Tugas-Pertemuan-12-CRUD-Buku-dengan-Laravel.git)

## Perintah & Fitur Baru yang Dijalankan:
* `Route::delete('/buku/bulk-delete', [BukuController::class, 'bulkDelete'])`
* `Route::get('/buku/export', [BukuController::class, 'export'])`
* Pembuatan aturan Regex & Kondisional Validasi pada Form Tambah Buku
* Pembuatan file `README.md` terstruktur untuk pelaporan tugas perpustakaan

---

## TUGAS 1 - Form Validasi Lanjutan (Tambah Buku Baru)
### 1. Deskripsi Fitur
Mengembangkan sistem validasi berlapis dan kondisional pada form tambah data buku baru menggunakan Form Request Laravel. Terdapat tiga aturan validasi khusus yang diterapkan:
1. **Kode Buku:** Wajib mengikuti format kode unik instansi yaitu `BK-XXX-000` (Contoh: `BK-PROG-001`). Jika input tidak sesuai pola regex, sistem akan langsung menolak proses simpan.
2. **Bahasa:** Bersifat kondisional (*Conditional Validation*), di mana buku dengan kategori **Programming** wajib menggunakan pilihan bahasa **Inggris**.
3. **Stok Buku:** Batasan kuantitas berdasarkan tahun, di mana buku lama yang diterbitkan **sebelum tahun 2000** hanya boleh memiliki kuantitas stok maksimal **5 buku**.

### 2. Hasil Implementasi Validasi Form

* **Kondisi Data Input Tidak Valid:** Tampilan antarmuka ketika pengguna memasukkan data yang melanggar aturan format kode buku, logika kesesuaian bahasa kategori programming, serta pembatasan stok buku lama. Komponen form otomatis merespons dengan garis tepi merah (*is-invalid*) dan memunculkan instruksi perbaikan yang interaktif.
![Input Tidak Valid](screenshot/tidak_valid.png)

* **Kondisi Form Siap Dikirim (Valid):** Tampilan ketika seluruh kolom input telah memenuhi kriteria validasi backend yang ditetapkan dan form siap disimpan ke dalam database.
![Input Valid](screenshot/input_valid.png)

---

## TUGAS 2 - Bulk Delete Operations (Hapus Massal)
### 1. Deskripsi Fitur
Menyediakan fitur efisiensi pengelolaan data melalui operasi hapus data massal (*Bulk Delete*). Pengguna dapat memilih beberapa buku sekaligus memanfaatkan kotak *checkbox* yang tertanam rapi pada tiap baris kartu (*card*) buku, atau menggunakan fitur pintas "Pilih Semua Buku". Data ID yang terpilih kemudian dikirim secara kolektif menuju server menggunakan metode HTTP `DELETE` untuk dibersihkan secara instan melalui Eloquent.

### 2. Hasil Implementasi Fitur Bulk Delete
Menampilkan komponen checkbox penanda pada sisi paling kiri tiap kartu buku yang telah dipertegas dengan garis pembatas solid, lengkap dengan tombol aksi "Hapus Buku Terpilih" di bagian atas daftar.
![Fitur Bulk Delete](screenshot/bulk_delete.jpeg)

---

## TUGAS 3 - Data Export via CSV (Unduh Spreadsheet)
### 1. Deskripsi Fitur
Menyediakan fitur utilitas laporan instan berupa fungsi ekspor data buku ke dalam dokumen eksternal berformat Comma-Separated Values (`.csv`). Menggunakan komponen `StreamedResponse` milik Symfony untuk mengalirkan baris data langsung dari database ke output stream browser. Teknik ini memastikan proses pengunduhan berkas berukuran besar berjalan sangat cepat, hemat memori server, dan menghasilkan struktur kolom spreadsheet yang presisi sesuai urutan properti model di database.

### 2. Hasil Implementasi Tombol Export CSV
Tombol aksi **Export CSV** telah berhasil ditempatkan secara ergonomis di pojok kanan atas halaman daftar utama, berdampingan langsung dengan tombol **Tambah Buku** untuk mempermudah aksesibilitas pengguna.
![Tombol Export CSV](screenshot/button_csv.png)

* **Hasil Unduhan Dokumen:** Lembar data yang berhasil diunduh memuat seluruh atribut lengkap buku mulai dari `kode_buku`, `judul`, `kategori`, `pengarang`, `penerbit`, `tahun_terbit`, `isbn`, `harga`, `stok`, `deskripsi`, hingga `bahasa`.
![Hasil Validasi Data CSV](screenshot/hasil_valid.png)