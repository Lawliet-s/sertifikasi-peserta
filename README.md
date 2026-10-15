# Aplikasi Pengelolaan Data Peserta Sertifikasi

## Asset Offline
Aset Tailwind dan Lucide disimpan secara lokal di `public/vendor/tailwindcss/tailwindcss.js` dan `public/vendor/lucide/lucide.min.js` agar aplikasi tetap dapat berjalan secara offline saat demonstrasi tanpa koneksi internet.

Perintah download offline:
```powershell
New-Item -ItemType Directory -Force -Path "public\vendor\tailwindcss"; New-Item -ItemType Directory -Force -Path "public\vendor\lucide"; Invoke-WebRequest -Uri "https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4" -OutFile "public\vendor\tailwindcss\tailwindcss.js"; Invoke-WebRequest -Uri "https://unpkg.com/lucide@0.469.0/dist/umd/lucide.min.js" -OutFile "public\vendor\lucide\lucide.min.js"
```
