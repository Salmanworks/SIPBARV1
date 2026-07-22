# Changelog - SIPBAR

## [1.0.3] - 2026-07-20 11:00 AM

### Fixed
- ✅ **Database Connection**: Berhasil mengubah koneksi dari SQLite ke MySQL
- ✅ **Model Table Names**: Memperbaiki error table name di models:
  - `Peminjaman.php` → tambah `protected $table = 'peminjamans'`
  - `DetailPeminjaman.php` → tambah `protected $table = 'detail_peminjamans'`
  - `Denda.php` → tambah `protected $table = 'dendas'`
- ✅ **PeminjamanSeeder**: Ubah dari `updateOrCreate` ke `create` untuk menghindari error

### Added
- Database `sipbar` di MySQL berhasil dibuat
- Script `create_database.bat` untuk otomatis create database
- File dokumentasi:
  - `SETUP_MYSQL.md` - Panduan lengkap setup MySQL
  - `CARA_BUAT_DATABASE.txt` - 3 cara membuat database
  - `MYSQL_SUCCESS.txt` - Ringkasan keberhasilan
- 11 tabel berhasil di-migrate
- Data dummy berhasil di-seed (5 users, 8 kategori, 20+ barang, 3 peminjaman)

### Migration Status
```
✅ 0001_01_01_000000_create_users_table
✅ 0001_01_01_000001_create_cache_table
✅ 0001_01_01_000002_create_jobs_table
✅ 2024_01_01_000000_create_passkeys_table
✅ 2025_08_14_170933_add_two_factor_columns_to_users_table
✅ 2026_07_20_000001_add_role_to_users_table
✅ 2026_07_20_000002_create_kategoris_table
✅ 2026_07_20_000003_create_barangs_table
✅ 2026_07_20_000004_create_peminjamans_table
✅ 2026_07_20_000005_create_detail_peminjamans_table
✅ 2026_07_20_000006_create_dendas_table
```

### Configuration
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sipbar
DB_USERNAME=root
DB_PASSWORD=123456
```

---

## [1.0.2] - 2026-07-20 10:40 AM

### Added
- Dokumentasi MySQL setup preparation
- File `database/create_database.sql`

---

## [1.0.1] - 2026-07-20 10:35 AM

### Fixed
- ✅ **Landing Page Error**: Memperbaiki error "Unable to locate a class or view for component [layouts.guest]"
  - Mengubah sintaks dari `<x-layouts.guest>` menjadi `@extends('layouts.guest')`
  - Mengupdate layout guest untuk support `@yield('content')` instead of `{{ $slot }}`
  - Clear view cache

### Changes
- `resources/views/landing/index.blade.php` - Ubah dari component syntax ke extends syntax
- `resources/views/layouts/guest.blade.php` - Ubah dari slot ke yield

### Testing
```bash
# Clear cache
php artisan view:clear

# Restart server
php artisan serve

# Test di browser
http://localhost:8000
```

---

## [1.0.0] - 2026-07-20

### Added - Initial Release
✅ Complete SIPBAR system with all features:
- Authentication & role-based access (Admin, Petugas, Peminjam)
- Manajemen barang & kategori
- Sistem peminjaman end-to-end
- Approval & verifikasi
- Dashboard & laporan
- Sistem denda
- UI/UX responsive
- Full documentation for thesis

### Tech Stack
- Laravel 13.20.0
- PHP 8.5.5
- Livewire 4.3.3
- Livewire Flux 2.13
- Tailwind CSS 3
- SQLite

### Documentation
- README.md
- DOKUMENTASI.md (for thesis)
- INSTALASI.md
- QUICK_START.md
- PROJECT_STATUS.md
- RINGKASAN_PROJECT.txt
- MULAI_DISINI.txt
