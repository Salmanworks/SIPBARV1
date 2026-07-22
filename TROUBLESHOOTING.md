# 🔧 Troubleshooting Guide - SIPBAR

## Error yang Sudah Diperbaiki

### ✅ Error: "Unable to locate a class or view for component [layouts.guest]"

**Status**: ✅ FIXED (v1.0.1)

**Penyebab**: 
- File landing page menggunakan sintaks component (`<x-layouts.guest>`) yang tidak kompatibel dengan struktur project

**Solusi yang Telah Diterapkan**:
```bash
# 1. View cache sudah di-clear
php artisan view:clear

# 2. File sudah diperbaiki:
- resources/views/landing/index.blade.php (ubah ke @extends)
- resources/views/layouts/guest.blade.php (ubah ke @yield)
```

**Cara Test**:
```bash
# Refresh browser atau restart server
php artisan serve
```

Akses: http://localhost:8000

---

## Common Errors & Solutions

### 1. Storage Link Error
```
The [public/storage] link already exists
```

**Solusi**:
```bash
# Windows PowerShell
Remove-Item public/storage -Force

# Lalu buat ulang
php artisan storage:link
```

---

### 2. Class Not Found
```
Class 'XXX' not found
```

**Solusi**:
```bash
composer dump-autoload
```

---

### 3. Database Locked (SQLite)
```
SQLSTATE[HY000]: General error: 5 database is locked
```

**Solusi**:
```bash
# Restart development server
# 1. Ctrl+C untuk stop server
# 2. Jalankan ulang:
php artisan serve
```

---

### 4. CSS Tidak Muncul

**Solusi**:
```bash
# 1. Build ulang assets
npm run build

# 2. Clear browser cache
# Chrome/Edge: Ctrl + Shift + Del
# Atau hard refresh: Ctrl + F5
```

---

### 5. Port 8000 Sudah Digunakan
```
Failed to listen on 127.0.0.1:8000
```

**Solusi**:
```bash
# Gunakan port lain
php artisan serve --port=8001

# Atau stop proses yang menggunakan port 8000
# Windows: taskkill /F /IM php.exe
```

---

### 6. Migration Error
```
SQLSTATE[HY000]: General error: 1 table 'xxx' already exists
```

**Solusi**:
```bash
# Reset database (⚠️ HAPUS SEMUA DATA!)
php artisan migrate:fresh --seed
```

---

### 7. View/Blade Error
```
View [xxx] not found
```

**Solusi**:
```bash
# Clear view cache
php artisan view:clear

# Pastikan file view ada di:
# resources/views/xxx.blade.php
```

---

### 8. Route Not Found (404)
```
404 | NOT FOUND
```

**Solusi**:
```bash
# Clear route cache
php artisan route:clear

# List semua route untuk cek
php artisan route:list
```

---

### 9. Config Cache Issue

**Solusi**:
```bash
# Clear semua cache
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear
```

---

### 10. Permission Denied (Storage/Logs)

**Solusi Windows**:
```bash
# Pastikan folder memiliki permission write
# Klik kanan folder → Properties → Security → Edit
# Berikan Full Control untuk user Anda
```

**Solusi Linux/Mac**:
```bash
chmod -R 775 storage bootstrap/cache
```

---

### 11. NPM Install Error

**Solusi**:
```bash
# Hapus node_modules dan package-lock.json
Remove-Item node_modules -Recurse -Force
Remove-Item package-lock.json -Force

# Install ulang
npm install
```

---

### 12. Composer Install Error

**Solusi**:
```bash
# Update composer
composer self-update

# Clear cache
composer clear-cache

# Install ulang
composer install
```

---

### 13. .env File Not Found
```
No application encryption key has been specified
```

**Solusi**:
```bash
# Copy .env.example
copy .env.example .env

# Generate key
php artisan key:generate
```

---

### 14. SQLite Database Not Found
```
unable to open database file
```

**Solusi**:
```bash
# Buat file database
# Windows PowerShell:
New-Item database/database.sqlite -ItemType File

# Windows CMD:
type nul > database\database.sqlite

# Jalankan migration
php artisan migrate --seed
```

---

### 15. CSRF Token Mismatch
```
419 | PAGE EXPIRED
```

**Solusi**:
```bash
# 1. Clear browser cookies untuk localhost
# 2. Clear config cache
php artisan config:clear

# 3. Restart server
php artisan serve
```

---

### 16. Session Error

**Solusi**:
```bash
# Clear sessions
php artisan session:clear

# Atau reset database sessions (jika pakai DB session)
php artisan migrate:fresh --seed
```

---

### 17. Livewire Error
```
Livewire component not found
```

**Solusi**:
```bash
# Clear Livewire
php artisan livewire:delete-upgrades

# Clear cache
php artisan view:clear
```

---

### 18. Vite/Assets Error
```
Failed to resolve entry
```

**Solusi**:
```bash
# Rebuild assets
npm run build

# Atau untuk development
npm run dev
```

---

## Quick Fix Commands

Jika mengalami error yang tidak jelas, coba command ini secara berurutan:

```bash
# 1. Clear all cache
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear

# 2. Reload autoload
composer dump-autoload

# 3. Rebuild assets
npm run build

# 4. Restart server
php artisan serve
```

---

## Debug Mode

Untuk melihat error detail:

1. **Edit `.env`**:
```env
APP_DEBUG=true
APP_ENV=local
```

2. **Cek Log**:
```bash
# Windows
type storage\logs\laravel.log

# PowerShell
Get-Content storage/logs/laravel.log -Tail 50
```

---

## Browser Console Errors

Jika ada error di browser console (F12):

1. **404 Not Found** (CSS/JS):
   ```bash
   npm run build
   php artisan serve
   ```

2. **CORS Error**:
   - Pastikan akses dari `http://localhost:8000`
   - Bukan dari `http://127.0.0.1:8000`

3. **Mixed Content** (HTTP/HTTPS):
   - Pastikan `APP_URL` di `.env` sesuai
   - `APP_URL=http://localhost`

---

## Database Issues

### Reset Database (Kehilangan Semua Data!)
```bash
php artisan migrate:fresh --seed
```

### Backup Database (SQLite)
```bash
# Windows
copy database\database.sqlite database\backup\database_backup_%date:~-4,4%%date:~-10,2%%date:~-7,2%.sqlite
```

### Switch ke MySQL
1. Edit `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sipbar
DB_USERNAME=root
DB_PASSWORD=
```

2. Buat database:
```sql
CREATE DATABASE sipbar CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

3. Migrate:
```bash
php artisan migrate --seed
```

---

## Performance Issues

### Slow Loading
```bash
# Optimize untuk production
composer install --optimize-autoloader --no-dev
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Clear All Optimizations (Development)
```bash
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

---

## Contact Support

Jika masih mengalami masalah:

1. **Cek Log**: `storage/logs/laravel.log`
2. **Cek Console**: Browser F12 → Console
3. **Cek Dokumentasi**: Baca `INSTALASI.md`
4. **Google Error**: Search error message di Google
5. **Laravel Docs**: https://laravel.com/docs

---

## Version Info

- **Laravel**: 13.20.0
- **PHP**: 8.5.5
- **Livewire**: 4.3.3
- **Flux**: 2.13.1

---

**Updated**: 20 Juli 2026
**Version**: 1.0.1
