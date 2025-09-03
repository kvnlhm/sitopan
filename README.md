Sistem Audit Terintegrasi (Laravel)

Deskripsi
Proyek ini adalah aplikasi web untuk manajemen proses audit: mulai dari pengelolaan proyek, proses audit, bank pertanyaan, lembar kerja, logging aktivitas, hingga laporan PDF. Dibangun menggunakan Laravel dengan Blade templating.

Fitur Utama
- Autentikasi pengguna (login/register) dan middleware keamanan
- Manajemen proyek, proses audit, pertanyaan, lembar kerja
- Generasi PDF untuk lembar kerja/laporan
- Logging aktivitas (audit trail)
- UI berbasis Blade, dengan komponen DataTables dan Toastr

Teknologi
- PHP 8.x, Laravel 8/9+
- Composer (dependency manager)
- MySQL/MariaDB
- Blade Templating, jQuery/DataTables, Toastr

Persyaratan
- PHP 8.1+ (disarankan)
- Composer 2+
- MySQL/MariaDB
- Laragon (disarankan untuk Windows) atau stack lokal setara

Instalasi (Windows/Laragon)
1. Clone atau salin source code ke folder Laragon: C:\laragon\www\clientShlSI2020
2. Masuk ke folder proyek via terminal/PowerShell:
   cd C:\laragon\www\clientShlSI2020
3. Install dependencies PHP:
   composer install
4. Salin file env dan generate APP_KEY:
   copy .env.example .env
   php artisan key:generate
5. Konfigurasi database di .env sesuai MySQL Laragon (DB_DATABASE, DB_USERNAME, DB_PASSWORD).
6. Migrasi (jika tersedia) dan seeding (opsional):
   php artisan migrate --seed
7. Buat storage symlink untuk akses file publik:
   php artisan storage:link
8. Jalankan server (bila tidak memakai Laragon auto-virtual host):
   php artisan serve

Struktur Direktori (ringkas)
- app/Http/Controllers: Controller untuk autentikasi, audit, proyek, proses audit, pertanyaan, log
- app/Models: Model Eloquent (User, Proyek, Audit, ProsesAudit, Pertanyaan, Log, Privilege)
- resources/views: Blade views untuk dashboard, audit, proyek, proses audit, pertanyaan, log, lembar kerja (termasuk pdf)
- routes/web.php: Definisi route web
- storage/app/public/gambar/profil: Penyimpanan gambar profil

Konfigurasi Lingkungan (.env)
- Pastikan variabel berikut dikonfigurasi:
  - APP_NAME, APP_ENV, APP_KEY, APP_URL
  - DB_CONNECTION, DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD
  - FILESYSTEM_DRIVER=public (untuk storage link)

Build Aset Frontend
Jika menggunakan asset pipeline (Vite/Mix), jalankan sesuai konfigurasi Anda. Proyek ini utamanya menggunakan Blade + plugin JS (DataTables/Toastr). Jika ada package frontend, jalankan:
  npm install
  npm run dev

Manajemen Akun
- Pendaftaran dan login tersedia via views di resources/views/auth
- Gambar profil disimpan di storage/app/public/gambar/profil dan diakses via public/storage setelah storage:link

Troubleshooting Cepat
- 404 untuk gambar/file publik: pastikan php artisan storage:link sudah dijalankan
- APP_KEY missing: jalankan php artisan key:generate
- Error koneksi DB: cek kredensial .env dan status MySQL

Lisensi
Proyek ini untuk keperluan pembelajaran/portofolio. Sesuaikan lisensi sesuai kebutuhan Anda.

# Sistem Audit Terintegrasi (Laravel)

Aplikasi web untuk mengelola proses audit end-to-end: manajemen proyek, proses/tahapan audit, bank pertanyaan, lembar kerja, logging, autentikasi dan kontrol privilese.

## Fitur Utama
- Manajemen Proyek Audit (`Proyek`)
- Proses Audit & Tahapan (`ProsesAudit`)
- Bank Pertanyaan Audit (`Pertanyaan`)
- Lembar Kerja Audit, termasuk ekspor PDF
- Log Aktivitas Sistem
- Autentikasi pengguna (login/registrasi) dan manajemen profil
- Role/Privilege dasar (kontrol akses)
- UI berbasis Blade, DataTables, dan notifikasi Toastr

## Tech Stack
- Backend: Laravel (PHP)
- Frontend: Blade Templates, jQuery, DataTables, Toastr
- Database: MySQL/MariaDB
- PDF: DomPDF/laravel-snappy (atau pustaka PDF Laravel serupa)
- Local Dev: Laragon (Windows) atau PHP built-in server

## Struktur Proyek (ringkas)
```
app/
  Http/
    Controllers/ (Audit, ProsesAudit, Proyek, User, dll)
    Middleware/
    Helpers/
  Models/ (Audit, ProsesAudit, Proyek, Pertanyaan, User, Log, Privilege)
resources/
  views/ (Blade: audit, proses_audit, proyek, user, dll)
routes/
  web.php
storage/app/public/gambar/profil/
```

## Prasyarat
- PHP 8.x
- Composer
- MySQL/MariaDB
- Node.js + npm/yarn (jika ada asset build; opsional)
- Laragon (opsional, untuk Windows)

## Setup Cepat (Laragon – Windows)
1. Clone repo ke `C:\laragon\www\clientShlSI2020` (atau sesuai preferensi).
2. Buka Terminal/PowerShell di folder proyek, jalankan:
   ```bash
   composer install
   cp .env.example .env  # Jika .env belum ada
   php artisan key:generate
   ```
3. Atur `.env` untuk koneksi database: `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`.
4. Migrasi dan (opsional) seeder:
   ```bash
   php artisan migrate
   # php artisan db:seed
   ```
5. Buat symlink storage publik:
   ```bash
   php artisan storage:link
   ```
6. Jalankan aplikasi via Laragon atau:
   ```bash
   php artisan serve
   ```

## Setup Umum (tanpa Laragon)
1. Clone repo, lalu:
   ```bash
   composer install
   cp .env.example .env
   php artisan key:generate
   ```
2. Konfigurasi `.env` untuk database.
3. Migrasi & (opsional) seeder:
   ```bash
   php artisan migrate
   # php artisan db:seed
   ```
4. Publik storage:
   ```bash
   php artisan storage:link
   ```
5. Jalankan server lokal:
   ```bash
   php artisan serve
   ```

## Konfigurasi Penting
- `.env`
  - `APP_NAME`, `APP_URL`
  - `DB_*` untuk koneksi database
  - `FILESYSTEM_DISK=public` (upload ke `storage/app/public`)
- Pastikan direktori `storage/` dan `bootstrap/cache/` writable oleh web server.

## Akun & Akses
- Registrasi tersedia di halaman auth bila diaktifkan.
- Untuk demo cepat, gunakan form registrasi lalu atur privilese via UI/DB atau siapkan seeder admin.

## Perintah Artisan Berguna
```bash
php artisan route:list | cat     # daftar route
php artisan migrate:fresh --seed # reset DB + seed (opsional)
php artisan tinker               # REPL untuk model/logic
```

## Testing (opsional)
Jika tersedia test:
```bash
php artisan test
```

## Lisensi
Proyek ini untuk tujuan pembelajaran/pengembangan internal. Sesuaikan lisensi sesuai kebutuhan.

## Kontribusi
Pull request dipersilakan. Untuk perubahan besar, mohon buka issue terlebih dahulu untuk diskusi.

## Kredit
Dibangun dengan Laravel dan ekosistem open-source terkait. UI menggunakan Blade, DataTables, dan Toastr. Fitur PDF mengandalkan pustaka PDF Laravel yang umum digunakan.
