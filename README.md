# Aplikasi Pengelolaan Data Peserta Sertifikasi

## Asset Offline
Aset Tailwind dan Lucide disimpan secara lokal di `public/vendor/tailwindcss/tailwindcss.js` dan `public/vendor/lucide/lucide.min.js` agar aplikasi tetap dapat berjalan secara offline saat demonstrasi tanpa koneksi internet.

## Fitur Import Excel Peserta
Administrator dapat mengimpor data peserta secara massal menggunakan file Excel (`.xlsx`, `.xls`, `.csv`).
- **Struktur Kolom Template**: `nama_lengkap`, `nik`, `email`, `no_telepon`, `tanggal_lahir`, `jenis_kelamin`, `alamat`, `kode_skema`, `status`.
- **Cara Pakai**:
  1. Masuk ke menu **Data Peserta**.
  2. Klik tombol **Import Excel**.
  3. Unduh template resmi dengan klik **Unduh Template Excel**.
  4. Isi data sesuai kolom dan unggah file lewat form yang tersedia.

## Skenario Pengujian Import
1. **File Valid**: Semua baris sesuai aturan dan skema terimpor dengan sukses.
2. **Baris Tidak Valid**: File dengan beberapa baris salah akan mengimpor baris yang benar dan melaporkan nomor baris serta detail error baris yang gagal di tabel ringkasan.
3. **Format File Salah**: Mengunggah file non-Excel ditolak oleh validasi Form Request.
4. **Duplikasi Data**: NIK/Email yang duplikat di dalam file yang sama atau sudah terdaftar di database akan dilewati dengan pesan error yang jelas.
5. **Format NIK Ilmiah**: NIK yang terdeteksi sebagai notasi ilmiah/scientific notation ditolak untuk mencegah kerusakan digit.
