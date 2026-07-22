# 🚀 Panduan Instalasi SIPBAR

## Prerequisites

Pastikan sistem Anda sudah terinstal:
- ✅ PHP 8.3 atau lebih tinggi
- ✅ Composer (PHP package manager)
- ✅ Node.js 18+ dan NPM
- ✅ SQLite atau MySQL

### Cek Versi
```bash
php -v          # Harus 8.3+
composer -v     # Harus terinstal
node -v         # Harus 18+
npm -v          # Harus terinstal
```

---

## Langkah Instalasi

### 1. Persiapan Project

Jika Anda sudah berada di folder project (c:\Users\Dell\SIPBAR), lanjut ke langkah 2.

### 2. Install Dependencies PHP

```bash
composer install
```

**Tunggu hingga selesai** (download ~100MB dependencies)

### 3. Install Dependencies JavaScript

```bash
npm install
```

**Tunggu hingga selesai** (download node_modules)

### 4. Setup Environment File

```bash
# Windows Command Prompt
copy .env.example .env

# Windows PowerShell
Copy-Item .env.example .env
```

### 5. Generate Application Key

```bash
php artisan key:generate
```

Output: `Application key set successfully.`

### 6. Konfigurasi Database

Buka file `.env` dengan text editor, pastikan konfigurasi berikut:

#### Opsi A: Menggunakan SQLite (Recommended untuk development)
```env
DB_CONNECTION=sqlite
# DB_HOST, DB_PORT, dll tidak perlu diisi
```

File database sudah ada di `database/database.sqlite`

#### Opsi B: Menggunakan MySQL
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sipbar
DB_USERNAME=root
DB_PASSWORD=
```

**Jika pakai MySQL**, buat database dulu:
```sql
CREATE DATABASE sipbar CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 7. Jalankan Migration & Seeder

```bash
php artisan migrate --seed
```

Perintah ini akan:
- ✅ Membuat semua tabel database
- ✅ Mengisi data dummy (user, kategori, barang, peminjaman)

Output yang benar:
```
Migration table created successfully.
Migrating: 0001_01_01_000000_create_users_table
Migrated:  0001_01_01_000000_create_users_table
...
Seeding: Database\Seeders\UserSeeder
Seeded:  Database\Seeders\UserSeeder
...
```

### 8. Create Storage Link

```bash
php artisan storage:link
```

Output: `The [public/storage] link has been connected to [storage/app/public].`

Fungsi: Agar foto barang yang diupload bisa diakses dari browser

### 9. Build Frontend Assets

#### Development (untuk development)
```bash
npm run dev
```

#### Production (untuk production/demo)
```bash
npm run build
```

**Untuk development**, biarkan terminal ini terbuka. Buka terminal baru untuk langkah selanjutnya.

### 10. Jalankan Development Server

```bash
php artisan serve
```

Output:
```
INFO  Server running on [http://127.0.0.1:8000].

Press Ctrl+C to stop the server
```

### 11. Akses Aplikasi

Buka browser, akses: **http://localhost:8000**

---

## 👤 User Default untuk Testing

Setelah seeding, Anda dapat login dengan akun berikut:

### Admin
- **Email**: `admin@sekolah.sch.id`
- **Password**: `password`
- **Akses**: Full control sistem

### Petugas Gudang
- **Email**: `petugas@sekolah.sch.id`
- **Password**: `password`
- **Akses**: Verifikasi barang keluar/masuk

### Peminjam 1
- **Email**: `peminjam@sekolah.sch.id`
- **Password**: `password`
- **Akses**: Ajukan peminjaman, lihat riwayat

### Peminjam 2 (Guru)
- **Email**: `guru@sekolah.sch.id`
- **Password**: `password`

### Peminjam 3 (Siswa)
- **Email**: `siswa@sekolah.sch.id`
- **Password**: `password`

---

## 🔧 Troubleshooting

### Error: "No application encryption key has been specified"
**Solusi:**
```bash
php artisan key:generate
```

### Error: "SQLSTATE[HY000] [14] unable to open database file"
**Solusi:**
1. Pastikan file `database/database.sqlite` ada
2. Buat manual jika belum ada:
   ```bash
   # Windows PowerShell
   New-Item database/database.sqlite -ItemType File
   
   # Windows CMD
   type nul > database\database.sqlite
   ```
3. Jalankan ulang migration:
   ```bash
   php artisan migrate --seed
   ```

### Error: "The [public/storage] link already exists"
**Solusi:**
Link sudah ada, abaikan error atau hapus dulu:
```bash
# Windows PowerShell
Remove-Item public/storage

# Lalu jalankan ulang
php artisan storage:link
```

### Error: "Class 'XXX' not found"
**Solusi:**
```bash
composer dump-autoload
```

### npm install Error
**Solusi:**
1. Hapus folder `node_modules` dan file `package-lock.json`
2. Jalankan ulang:
   ```bash
   npm install
   ```

### Port 8000 sudah digunakan
**Solusi:** Gunakan port lain
```bash
php artisan serve --port=8001
```

### Tampilan CSS tidak muncul
**Solusi:**
1. Pastikan `npm run dev` atau `npm run build` sudah dijalankan
2. Clear browser cache (Ctrl + Shift + Del)
3. Hard refresh (Ctrl + F5)

### Database SQLite tidak bisa diakses
**Solusi:** Pastikan ekstensi SQLite PHP aktif
```bash
php -m | findstr sqlite
```
Output harus menampilkan: `sqlite3`, `pdo_sqlite`

---

## 🔄 Reset Database

Jika ingin reset database (hapus semua data & isi ulang):

```bash
php artisan migrate:fresh --seed
```

**⚠️ PERINGATAN**: Perintah ini akan menghapus SEMUA data!

---

## 📦 Development Workflow

### 1. Setiap kali mulai development

**Terminal 1:**
```bash
npm run dev
```

**Terminal 2:**
```bash
php artisan serve
```

### 2. Setelah update code

#### Jika update migration:
```bash
php artisan migrate
```

#### Jika update routes:
```bash
php artisan route:clear
```

#### Jika update config:
```bash
php artisan config:clear
```

#### Jika update views:
```bash
php artisan view:clear
```

---

## 🚀 Deployment ke Production

### 1. Update `.env` untuk production
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://sipbar.sekolah.sch.id
```

### 2. Optimize aplikasi
```bash
composer install --optimize-autoloader --no-dev
php artisan config:cache
php artisan route:cache
php artisan view:cache
npm run build
```

### 3. Set permissions (Linux/Unix)
```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

### 4. Setup Web Server

#### Apache (.htaccess sudah ada)
- Document root: `/public`
- Enable `mod_rewrite`

#### Nginx
```nginx
server {
    listen 80;
    server_name sipbar.sekolah.sch.id;
    root /path/to/sipbar/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.3-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

---

## 📊 Database Backup

### Manual Backup (SQLite)
```bash
# Windows
copy database\database.sqlite database\backup\database_backup_%date:~-4,4%%date:~-10,2%%date:~-7,2%.sqlite
```

### Manual Backup (MySQL)
```bash
mysqldump -u root -p sipbar > backup_sipbar.sql
```

---

## ✅ Checklist Instalasi

- [ ] PHP 8.3+ terinstal
- [ ] Composer terinstal
- [ ] Node.js & NPM terinstal
- [ ] `composer install` berhasil
- [ ] `npm install` berhasil
- [ ] `.env` file sudah ada
- [ ] `php artisan key:generate` berhasil
- [ ] Database dikonfigurasi di `.env`
- [ ] `php artisan migrate --seed` berhasil
- [ ] `php artisan storage:link` berhasil
- [ ] `npm run build` berhasil
- [ ] `php artisan serve` berjalan
- [ ] Bisa login dengan user default
- [ ] Tampilan website normal (CSS muncul)
- [ ] Upload foto barang berhasil

---

## 📞 Bantuan

Jika mengalami masalah:
1. Cek error di terminal/console browser
2. Cek log Laravel di `storage/logs/laravel.log`
3. Pastikan semua langkah sudah diikuti
4. Restart development server

**Selamat menggunakan SIPBAR! 🎉**
