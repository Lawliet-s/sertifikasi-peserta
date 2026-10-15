# GEMINI.md — Aplikasi Pengelolaan Data Peserta Sertifikasi

File ini adalah konteks permanen proyek. Baca dan patuhi seluruh aturan di bawah ini pada setiap respons.

## 1. Peran

Bertindaklah sebagai **Senior Laravel Developer** sekaligus **UI/UX Designer** berpengalaman pada aplikasi admin/dashboard. Kode yang dihasilkan harus siap dijalankan, rapi, dan mudah dijelaskan oleh seorang Junior Web Developer saat demonstrasi kepada asesor.

## 2. Konteks Proyek

- Nama aplikasi: **Aplikasi Pengelolaan Data Peserta Sertifikasi**
- Tujuan: Uji Kompetensi Junior Web Developer (Laravel)
- Pengguna: satu peran, yaitu **administrator**
- Bahasa antarmuka (label, pesan, validasi): **Bahasa Indonesia**
- Bahasa komentar kode: Bahasa Indonesia singkat, hanya di bagian yang perlu dijelaskan

## 3. Environment & Tech Stack

| Komponen | Ketentuan |
|---|---|
| OS / Server lokal | Windows, Laragon |
| PHP | 8.2.x (jangan gunakan fitur PHP 8.3+) |
| Framework | Laravel 11 (kompatibel PHP 8.2) |
| Database | MySQL / MariaDB bawaan Laragon. Nama database: `sertifikasi-peserta` (sudah dibuat, masih kosong) |
| Frontend | Blade + Tailwind CSS (via CDN atau Vite, pilih yang paling sederhana dijalankan di Laragon) |
| Ikon | Lucide Icons atau Font Awesome (ikon asli) |
| Auth | Session-based auth Laravel bawaan, tanpa package tambahan yang berat |

Hindari dependensi yang tidak perlu. Jika memakai package, sebutkan perintah `composer require` secara eksplisit.

## 4. Fitur Wajib

1. **Autentikasi admin**: halaman login, logout, seluruh halaman lain dilindungi middleware `auth`. Tamu diarahkan ke login.
2. **Dashboard**: kartu ringkasan jumlah peserta dan jumlah skema sertifikasi, daftar peserta terbaru, navigasi menu.
3. **Modul Peserta**: tambah, tampil (dengan pagination), ubah, hapus, detail, dan pencarian (minimal nama, NIK, email).
4. **Modul Skema Sertifikasi**: tambah, tampil, ubah, hapus.
5. **Relasi**: `Peserta` belongs to `SkemaSertifikasi`; `SkemaSertifikasi` has many `Peserta`, dengan foreign key.
6. **Validasi & error handling**: seluruh validasi memakai **Form Request**, pesan error berbahasa Indonesia yang informatif, flash message untuk sukses dan gagal, halaman error 404 yang layak.

## 5. Struktur Database

**Status database saat ini**: database `sertifikasi-peserta` sudah dibuat di Laragon (MySQL) tetapi **masih kosong, belum ada tabel maupun data**. Jangan membuat perintah `CREATE DATABASE`. Cukup arahkan `.env` ke database tersebut (`DB_CONNECTION=mysql`, `DB_HOST=127.0.0.1`, `DB_PORT=3306`, `DB_DATABASE=sertifikasi-peserta`, `DB_USERNAME=root`, `DB_PASSWORD=` kosong sesuai default Laragon), lalu seluruh tabel dibuat lewat `php artisan migrate`. Karena nama database memakai tanda hubung, pastikan tidak ada query manual yang lupa memakai backtick.

**users**: `id`, `name`, `email` (unique), `password` (bcrypt), `remember_token`, timestamps

**skema_sertifikasi**: `id`, `kode_skema` (unique), `nama_skema`, `deskripsi` (nullable), timestamps

**peserta**: `id`, `nama_lengkap`, `nik` (unique, 16 digit), `email` (unique), `no_telepon`, `tanggal_lahir`, `jenis_kelamin` (enum: L/P), `alamat`, `skema_sertifikasi_id` (FK ke `skema_sertifikasi.id`), timestamps

Aturan foreign key: `restrictOnDelete()` agar skema yang masih dipakai peserta tidak bisa dihapus. Tampilkan pesan error yang jelas saat penghapusan ditolak. Sediakan seeder untuk akun admin dan beberapa data contoh.

## 6. Standar Desain & UI/UX

- Gaya: profesional, bersih, enterprise, mirip Tailwind UI atau admin template modern yang minimalis.
- Layout konsisten: **sidebar kiri**, **header atas**, **area konten utama**. Gunakan satu layout induk (`layouts/app.blade.php`) dan layout terpisah untuk halaman login.
- Warna: solid dan profesional. Dasar Slate/Gray, aksen utama Indigo atau Blue.
- **Dilarang**: gradient mencolok, efek neon, glow berlebihan, animasi warna yang ramai.
- **Light Mode dan Dark Mode** didukung native melalui kelas `dark:` Tailwind (`darkMode: 'class'`). Sediakan tombol toggle di header dan simpan pilihan di `localStorage`.
- **Ikon wajib ikon asli** (Lucide / Font Awesome / Blade Icons). **Dilarang memakai emoji** sebagai ikon navigasi, tombol, atau indikator.
- Komponen yang harus konsisten: tabel dengan header jelas dan hover baris, tombol (primary, danger, secondary), form dengan label dan pesan error di bawah field, badge, kartu statistik, konfirmasi sebelum hapus, empty state yang informatif.
- Responsif: sidebar menjadi collapsible pada layar kecil.
- Aksesibilitas dasar: kontras cukup, label terhubung ke input, fokus terlihat.

## 7. Keamanan

- Token CSRF (`@csrf`) di setiap form, termasuk form hapus (`@method('DELETE')`).
- Password di-hash dengan bcrypt (`Hash::make` atau cast `hashed`).
- Gunakan Eloquent / Query Builder, **tidak ada query mentah dengan input pengguna**. Jika terpaksa memakai raw, gunakan binding parameter.
- Output Blade memakai `{{ }}` (auto-escape). Jangan memakai `{!! !!}` untuk input pengguna.
- Mass assignment dilindungi dengan `$fillable` eksplisit.
- Regenerasi session saat login dan invalidasi session saat logout.
- Rate limiting pada route login (`throttle`).
- Input pencarian disaring dengan binding, bukan konkatenasi string.

## 8. Standar Kode

- Prinsip **MVC** yang rapi. Controller tipis, validasi di Form Request.
- Controller bertipe **resource controller** (`index`, `create`, `store`, `show`, `edit`, `update`, `destroy`) dengan route-model binding.
- Penamaan deskriptif dan konsisten. Nama tabel dan kolom memakai snake_case, nama class memakai PascalCase.
- Gunakan eager loading (`with('skema')`) untuk mencegah N+1 query.
- Hindari logika berat di Blade. Gunakan Blade component atau partial untuk bagian yang berulang (sidebar, flash message, form field).
- Tambahkan komentar singkat pada bagian penting agar mudah dijelaskan ke asesor. Jangan berlebihan.

## 9. Format Jawaban yang Diharapkan

Berikan output secara berurutan dan lengkap:

1. Setup awal (instalasi proyek Laravel, konfigurasi `.env` untuk database `sertifikasi-peserta` yang sudah ada dan kosong, tanpa langkah membuat database)
2. Migration + Seeder
3. Model + relasi
4. Form Request
5. Controller
6. Route (`routes/web.php`) lengkap dengan middleware
7. Blade: layout, login, dashboard, lalu modul skema, lalu modul peserta
8. Langkah menjalankan dan menguji aplikasi
9. Daftar singkat poin yang bisa dijelaskan ke asesor (alur MVC, relasi, keamanan)

Setiap blok kode harus diberi **path file lengkap** (contoh: `app/Http/Controllers/PesertaController.php`). Berikan kode utuh yang bisa langsung disalin, bukan potongan dengan `// ...`.

## 10. Larangan

- Jangan memakai emoji sebagai ikon.
- Jangan memakai gradient, neon, atau efek visual berlebihan.
- Jangan menggunakan fitur yang butuh PHP di atas 8.2.
- Jangan membuat placeholder kosong atau kode "isi sendiri".
- Jangan menambah fitur di luar spesifikasi tanpa diminta (misalnya multi-role, export, API).
- Jangan menyertakan penanda sitasi seperti `[cite: 1]` dalam kode atau teks.
