# 🗄️ Panduan Setup MySQL untuk SIPBAR

## Langkah 1: Pastikan MySQL Terinstal & Berjalan

### Cek Status MySQL
```bash
# Windows (Command Prompt)
mysql --version
```

Jika muncul versi MySQL (contoh: mysql Ver 8.0.xx), berarti MySQL sudah terinstal.

### Start MySQL Service (Windows)
```bash
# Buka Command Prompt as Administrator
net start mysql80
# atau
net start mysql
```

---

## Langkah 2: Buat Database SIPBAR

### Opsi A: Menggunakan MySQL Command Line

1. **Login ke MySQL**:
```bash
mysql -u root -p
```
Masukkan password: `123456`

2. **Jalankan SQL**:
```sql
CREATE DATABASE sipbar CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

3. **Verifikasi**:
```sql
SHOW DATABASES;
USE sipbar;
```

4. **Exit**:
```sql
exit;
```

### Opsi B: Menggunakan File SQL

```bash
# Di folder SIPBAR
mysql -u root -p123456 < database\create_database.sql
```

### Opsi C: Menggunakan phpMyAdmin

1. Buka phpMyAdmin (biasanya: http://localhost/phpmyadmin)
2. Login dengan:
   - Username: `root`
   - Password: `123456`
3. Klik tab "SQL"
4. Copy-paste isi dari `database/create_database.sql`
5. Klik "Go"

---

## Langkah 3: Verifikasi Konfigurasi

File `.env` sudah diupdate dengan konfigurasi berikut:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sipbar
DB_USERNAME=root
DB_PASSWORD=123456
```

### Test Koneksi Database
```bash
php artisan db:show
```

Jika berhasil, akan menampilkan informasi database:
- Database: sipbar
- Connection: mysql
- Version: 8.0.xx

---

## Langkah 4: Jalankan Migration & Seeder

```bash
# Clear config cache dulu
php artisan config:clear

# Jalankan migration & seeder
php artisan migrate --seed
```

**Output yang benar**:
```
INFO  Preparing database.
Creating migration table .................................... 10ms DONE

INFO  Running migrations.
2024_01_01_000000_create_users_table ....................... 15ms DONE
2024_01_01_000001_create_cache_table ....................... 12ms DONE
...
2026_07_20_000006_create_dendas_table ...................... 10ms DONE

INFO  Seeding database.
Database\Seeders\UserSeeder ................................ 50ms DONE
Database\Seeders\KategoriSeeder ............................ 20ms DONE
Database\Seeders\BarangSeeder .............................. 30ms DONE
Database\Seeders\PeminjamanSeeder .......................... 40ms DONE
```

---

## Langkah 5: Restart Server & Test

```bash
# Stop server (Ctrl+C jika masih running)

# Clear all cache
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Start server
php artisan serve
```

Akses: **http://localhost:8000**

Login dengan:
- Email: `admin@sekolah.sch.id`
- Password: `password`

---

## Troubleshooting

### Error: Access denied for user 'root'@'localhost'

**Penyebab**: Password salah

**Solusi**: Update password di `.env`
```env
DB_PASSWORD=password_mysql_anda
```

---

### Error: SQLSTATE[HY000] [2002] Connection refused

**Penyebab**: MySQL service tidak running

**Solusi**:
```bash
# Windows (as Administrator)
net start mysql80
# atau
net start mysql
```

---

### Error: Unknown database 'sipbar'

**Penyebab**: Database belum dibuat

**Solusi**: Ikuti Langkah 2 (Buat Database)

---

### Error: SQLSTATE[42000]: Syntax error or access violation

**Penyebab**: Migration error

**Solusi**:
```bash
# Reset migration
php artisan migrate:fresh --seed
```

---

### Error: Nothing to migrate

**Penyebab**: Migration sudah pernah dijalankan

**Solusi**: 
```bash
# Lihat status migration
php artisan migrate:status

# Atau reset (HAPUS SEMUA DATA!)
php artisan migrate:fresh --seed
```

---

## Perbandingan SQLite vs MySQL

| Feature | SQLite (Sebelumnya) | MySQL (Sekarang) |
|---------|---------------------|------------------|
| File Database | 1 file (.sqlite) | Server database |
| Performance | Cukup untuk dev | Lebih cepat untuk production |
| Concurrent Users | Limited | Unlimited |
| Production Ready | ❌ | ✅ |
| Backup | Copy file | Export SQL |
| Tools | Limited | phpMyAdmin, MySQL Workbench |

---

## MySQL Management Tools

### 1. MySQL Workbench (Recommended)
- Download: https://dev.mysql.com/downloads/workbench/
- GUI visual untuk manage database
- Support ERD generation

### 2. phpMyAdmin
- Web-based (included in XAMPP/WAMP)
- URL: http://localhost/phpmyadmin

### 3. HeidiSQL
- Download: https://www.heidisql.com/
- Lightweight & fast

### 4. DBeaver
- Download: https://dbeaver.io/
- Universal database tool

---

## Backup & Restore Database

### Backup (Export)
```bash
# Windows
mysqldump -u root -p123456 sipbar > backup_sipbar_%date:~-4,4%%date:~-10,2%%date:~-7,2%.sql
```

### Restore (Import)
```bash
mysql -u root -p123456 sipbar < backup_sipbar.sql
```

---

## SQL Useful Commands

### Lihat semua tabel
```sql
USE sipbar;
SHOW TABLES;
```

### Lihat struktur tabel
```sql
DESCRIBE users;
DESC barangs;
```

### Lihat data
```sql
SELECT * FROM users;
SELECT * FROM barangs LIMIT 10;
```

### Count data
```sql
SELECT COUNT(*) FROM peminjamans;
SELECT status, COUNT(*) FROM peminjamans GROUP BY status;
```

### Reset auto increment
```sql
ALTER TABLE users AUTO_INCREMENT = 1;
```

### Drop database (HATI-HATI!)
```sql
DROP DATABASE sipbar;
```

---

## Konfigurasi MySQL Production

Untuk production, tambahkan konfigurasi keamanan:

### 1. Buat User Khusus (Jangan Pakai root!)
```sql
-- Login sebagai root
mysql -u root -p

-- Buat user baru
CREATE USER 'sipbar_user'@'localhost' IDENTIFIED BY 'password_kuat_123';

-- Berikan privileges
GRANT ALL PRIVILEGES ON sipbar.* TO 'sipbar_user'@'localhost';
FLUSH PRIVILEGES;

-- Exit
EXIT;
```

### 2. Update .env
```env
DB_USERNAME=sipbar_user
DB_PASSWORD=password_kuat_123
```

---

## Performance Optimization

### 1. Index Optimization

Migration sudah include index pada:
- Foreign keys (user_id, kategori_id, barang_id, dll)
- Unique keys (email, kode_barang)

### 2. Connection Pooling

Edit `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sipbar
DB_USERNAME=root
DB_PASSWORD=123456

# Tambahan untuk production
DB_POOL=10
```

### 3. Query Optimization

Sudah menggunakan:
- ✅ Eager Loading: `with(['user', 'barang'])`
- ✅ Pagination: `paginate(10)`
- ✅ Indexing: Foreign keys & unique keys

---

## Monitoring Database

### Size Database
```sql
SELECT 
    table_schema AS 'Database',
    ROUND(SUM(data_length + index_length) / 1024 / 1024, 2) AS 'Size (MB)'
FROM information_schema.tables
WHERE table_schema = 'sipbar'
GROUP BY table_schema;
```

### Jumlah Records per Tabel
```sql
SELECT 
    table_name AS 'Tabel',
    table_rows AS 'Jumlah Records'
FROM information_schema.tables
WHERE table_schema = 'sipbar'
ORDER BY table_rows DESC;
```

---

## Checklist Setup MySQL

- [ ] MySQL terinstal & service running
- [ ] Database 'sipbar' sudah dibuat
- [ ] File `.env` sudah diupdate
- [ ] Config cache sudah di-clear
- [ ] Migration berhasil dijalankan
- [ ] Seeder berhasil dijalankan
- [ ] Test koneksi berhasil
- [ ] Website bisa diakses
- [ ] Login berhasil
- [ ] Data dummy muncul di dashboard

---

## Next Steps

Setelah MySQL setup berhasil:

1. ✅ **Test Semua Fitur**
   - Login semua role
   - CRUD barang
   - Peminjaman workflow

2. ✅ **Backup Database**
   ```bash
   mysqldump -u root -p sipbar > backup_sipbar.sql
   ```

3. ✅ **Setup Cron/Scheduler** (Optional)
   - Auto check keterlambatan
   - Auto send email reminder

4. ✅ **Production Optimization**
   - Buat user khusus (jangan pakai root)
   - Enable query cache
   - Setup monitoring

---

## Support

Jika ada masalah:
1. Cek error di: `storage/logs/laravel.log`
2. Baca: `TROUBLESHOOTING.md`
3. Test koneksi: `php artisan db:show`

---

**Setup Complete! 🎉**

Database MySQL siap digunakan untuk SIPBAR!

---

_Updated: 20 Juli 2026_
_Version: 1.0.2_
