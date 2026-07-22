# 🔐 KREDENSIAL LOGIN ADMIN

## Login Administrator

Gunakan kredensial berikut untuk login sebagai Administrator:

```
Email:    admin@sipbar.sch.id
Password: password
Role:     Admin
```

---

## Semua User Test Accounts

### 1. Administrator
```
Email:    admin@sipbar.sch.id
Password: password
Role:     Admin
No Induk: ADM001
Nama:     Administrator SIPBAR
```

**Akses:**
- ✅ Dashboard Admin
- ✅ Kelola Barang
- ✅ Kelola Kategori
- ✅ Kelola Peminjaman
- ✅ Kelola User
- ✅ Laporan
- ✅ Verifikasi Peminjaman

---

### 2. Petugas Gudang
```
Email:    petugas@sipbar.sch.id
Password: password
Role:     Petugas
No Induk: PTG001
Nama:     Budi Santoso
```

**Akses:**
- ✅ Dashboard Petugas
- ✅ Verifikasi Peminjaman
- ✅ Lihat Barang
- ❌ Kelola Barang (tidak bisa tambah/edit/hapus)
- ❌ Kelola User

---

### 3. Guru (Peminjam)
```
Email:    guru@sipbar.sch.id
Password: password
Role:     Peminjam
No Induk: GRU001
Nama:     Siti Rahayu
```

**Akses:**
- ✅ Dashboard Peminjam
- ✅ Ajukan Peminjaman
- ✅ Lihat Riwayat Peminjaman
- ❌ Verifikasi Peminjaman
- ❌ Kelola Barang

---

### 4. Siswa (Peminjam)
```
Email:    siswa@sipbar.sch.id
Password: password
Role:     Peminjam
No Induk: SIS001
Nama:     Ahmad Fauzi
```

**Akses:**
- ✅ Dashboard Peminjam
- ✅ Ajukan Peminjaman
- ✅ Lihat Riwayat Peminjaman
- ❌ Verifikasi Peminjaman
- ❌ Kelola Barang

---

## Cara Login

1. Buka browser dan akses: `http://127.0.0.1:8000/login`
2. Masukkan email dan password sesuai role yang diinginkan
3. Klik tombol **"Masuk"**
4. Anda akan diarahkan ke dashboard sesuai role

---

## URL Penting

### Public
- Homepage: `http://127.0.0.1:8000/`
- Login: `http://127.0.0.1:8000/login`
- Register: `http://127.0.0.1:8000/register`

### Admin
- Dashboard: `http://127.0.0.1:8000/admin/dashboard`
- Kelola Barang: `http://127.0.0.1:8000/admin/barang`
- Kelola Kategori: `http://127.0.0.1:8000/admin/kategori`
- Kelola Peminjaman: `http://127.0.0.1:8000/admin/peminjaman`
- Kelola User: `http://127.0.0.1:8000/admin/user`
- Laporan: `http://127.0.0.1:8000/admin/laporan`

### Petugas
- Dashboard: `http://127.0.0.1:8000/petugas/dashboard`
- Verifikasi: `http://127.0.0.1:8000/petugas/verifikasi`

### Peminjam
- Dashboard: `http://127.0.0.1:8000/peminjam/dashboard`
- Ajukan Peminjaman: `http://127.0.0.1:8000/peminjam/pengajuan/create`
- Riwayat: `http://127.0.0.1:8000/peminjam/riwayat`

---

## Seeding Database

Jika user belum ada di database, jalankan seeder:

```bash
php artisan db:seed --class=UserSeeder
```

Atau reset seluruh database dan seed ulang:

```bash
php artisan migrate:fresh --seed
```

---

## Keamanan

⚠️ **PENTING untuk Production:**

1. **Ubah semua password default** sebelum deploy ke production
2. Gunakan password yang kuat (minimal 12 karakter, kombinasi huruf, angka, simbol)
3. Aktifkan 2FA (Two-Factor Authentication) jika tersedia
4. Jangan gunakan kredensial yang sama untuk multiple environment
5. Simpan kredensial production di password manager yang aman

### Contoh Password Kuat:
```
Admin123!@#SecurePass
P3tug4s_Gudang!2024
Peminjam@Secure99!
```

---

## Troubleshooting

### Login Gagal
```
❌ Problem: Email atau password salah
✅ Solution: 
   1. Pastikan email dan password sesuai
   2. Cek caps lock keyboard
   3. Jalankan seeder: php artisan db:seed --class=UserSeeder
```

### Redirect ke Login Terus
```
❌ Problem: Session atau cookie bermasalah
✅ Solution:
   1. Clear browser cache dan cookies
   2. Restart php artisan serve
   3. php artisan config:clear
   4. php artisan cache:clear
```

### Access Denied (403)
```
❌ Problem: Role tidak sesuai untuk akses halaman
✅ Solution:
   1. Login dengan user yang role-nya sesuai
   2. Admin bisa akses semua
   3. Petugas hanya bisa verifikasi
   4. Peminjam hanya bisa ajukan peminjaman
```

---

## Development Tips

### Cek User yang Sedang Login
```php
auth()->user()->name;  // Nama user
auth()->user()->email; // Email user
auth()->user()->role;  // Role user (Admin, Petugas, Peminjam)
```

### Cek Role
```php
auth()->user()->role === UserRole::Admin;    // true jika admin
auth()->user()->role === UserRole::Petugas;  // true jika petugas
auth()->user()->role === UserRole::Peminjam; // true jika peminjam
```

### Logout Programmatically
```php
Auth::logout();
request()->session()->invalidate();
request()->session()->regenerateToken();
```

---

**Created:** July 20, 2026  
**Status:** ✅ Active  
**Environment:** Development  
**Security Level:** Testing Only (Change for Production!)
