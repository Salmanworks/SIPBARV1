# SIPBAR - Sistem Peminjaman Barang Sekolah

![Laravel](https://img.shields.io/badge/Laravel-13-red)
![PHP](https://img.shields.io/badge/PHP-8.3+-blue)
![License](https://img.shields.io/badge/License-MIT-green)

## 📋 Deskripsi

**SIPBAR** adalah aplikasi web untuk mengelola peminjaman inventaris/barang sekolah (laptop, proyektor, alat lab, alat olahraga, dll) oleh guru, siswa, dan staf. Sistem ini mendigitalisasi proses peminjaman yang sebelumnya manual (buku catatan) menjadi sistem terkomputerisasi agar data peminjaman, stok barang, dan histori pengembalian lebih akurat dan mudah dipantau.

## 🎯 Tujuan

Mendigitalisasi proses peminjaman barang sekolah untuk:
- ✅ Data peminjaman lebih akurat dan terstruktur
- ✅ Tracking stok barang real-time
- ✅ Histori peminjaman tercatat lengkap
- ✅ Proses approval yang terstandar
- ✅ Laporan yang mudah diakses

## 🛠️ Tech Stack

- **Backend**: Laravel 13 (PHP 8.3+)
- **Database**: SQLite (dapat diganti ke MySQL)
- **Frontend**: Blade Templates + Tailwind CSS
- **UI Components**: Livewire Flux
- **Authentication**: Laravel Fortify (dengan Passkey support)
- **Interactive Components**: Livewire 4

## 👥 Role Pengguna

### 1. Admin
- Kelola data barang dan kategori
- Kelola user (tambah, edit, hapus)
- Approve/reject pengajuan peminjaman
- Akses laporan lengkap
- Dashboard statistik menyeluruh

### 2. Petugas Gudang
- Verifikasi barang keluar/masuk
- Update kondisi barang saat pengembalian
- Monitoring peminjaman aktif
- Dashboard khusus verifikasi

### 3. Peminjam (Guru/Siswa/Staf)
- Ajukan peminjaman barang
- Lihat status pengajuan
- Lihat riwayat peminjaman
- Notifikasi jatuh tempo

## ✨ Fitur Utama

### Autentikasi & Manajemen User
- [x] Login/Register dengan Laravel Fortify
- [x] Support Passkey (WebAuthn)
- [x] Role-based access control
- [x] Profile management

### Manajemen Barang
- [x] CRUD barang lengkap
- [x] Kategori barang (elektronik, olahraga, lab, dll)
- [x] Upload foto barang
- [x] Tracking stok dan kondisi
- [x] Pencarian & filter (nama, kategori, ketersediaan)
- [x] Kode barang unik

### Peminjaman
- [x] Form pengajuan peminjaman (pilih barang, jumlah, tanggal)
- [x] Sistem approval (approve/reject dengan catatan)
- [x] Status tracking (diajukan, disetujui, dipinjam, dikembalikan, terlambat)
- [x] Verifikasi keluar/masuk barang
- [x] Validasi stok otomatis
- [x] Multi-barang per peminjaman

### Monitoring & Laporan
- [x] Dashboard berbeda per role
- [x] Statistik real-time (total barang, dipinjam, terlambat)
- [x] Riwayat peminjaman lengkap
- [x] Filter dan pencarian laporan
- [x] Status badge berwarna (visual indicator)

### Sistem Denda
- [x] Tracking keterlambatan
- [x] Perhitungan denda otomatis
- [x] Status pembayaran denda

## 📁 Struktur Project

```
sipbar/
├── app/
│   ├── Enums/                    # Enum classes (UserRole, PeminjamanStatus, dll)
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/            # Controllers untuk Admin
│   │   │   ├── Petugas/          # Controllers untuk Petugas
│   │   │   └── Peminjam/         # Controllers untuk Peminjam
│   │   └── Middleware/
│   │       └── CheckRole.php     # Role-based middleware
│   ├── Models/                   # Eloquent models
│   └── Concerns/                 # Reusable traits
│
├── database/
│   ├── migrations/               # Database migrations
│   └── seeders/                  # Database seeders (dummy data)
│
├── resources/
│   └── views/
│       ├── layouts/              # Layout templates
│       ├── landing/              # Landing page
│       ├── dashboard/            # Dashboard per role
│       ├── barang/               # Views barang (CRUD)
│       ├── kategori/             # Views kategori
│       ├── peminjaman/           # Views peminjaman
│       ├── laporan/              # Views laporan
│       ├── users/                # Views user management
│       └── components/           # Reusable components
│
└── routes/
    └── web.php                   # Route definitions
```

## 🗄️ Database Schema

### Users
- `id`, `name`, `email`, `password`
- `role` (admin/petugas/peminjam)
- `no_induk` (NIP/NIS)

### Kategoris
- `id`, `nama_kategori`, `deskripsi`

### Barangs
- `id`, `kode_barang`, `nama_barang`
- `kategori_id`, `stok`, `kondisi`
- `foto`, `deskripsi`

### Peminjamans
- `id`, `user_id`
- `tanggal_pinjam`, `tanggal_kembali_rencana`, `tanggal_kembali_aktual`
- `status`, `keperluan`, `catatan_admin`
- `disetujui_oleh`

### Detail Peminjamans
- `id`, `peminjaman_id`, `barang_id`
- `jumlah`, `kondisi_saat_kembali`

### Dendas
- `id`, `peminjaman_id`
- `jumlah_hari_telat`, `nominal_denda`
- `status_bayar`, `tanggal_bayar`

## 🚀 Instalasi

### Prerequisites
- PHP 8.3 atau lebih tinggi
- Composer
- Node.js & NPM
- SQLite atau MySQL

### Langkah Instalasi

1. **Clone atau extract project**
   ```bash
   cd c:\Users\Dell\SIPBAR
   ```

2. **Install dependencies PHP**
   ```bash
   composer install
   ```

3. **Install dependencies JavaScript**
   ```bash
   npm install
   ```

4. **Setup environment**
   ```bash
   copy .env.example .env
   php artisan key:generate
   ```

5. **Konfigurasi database di `.env`**
   ```env
   DB_CONNECTION=sqlite
   # Atau jika pakai MySQL:
   # DB_CONNECTION=mysql
   # DB_HOST=127.0.0.1
   # DB_PORT=3306
   # DB_DATABASE=sipbar
   # DB_USERNAME=root
   # DB_PASSWORD=
   ```

6. **Jalankan migration & seeder**
   ```bash
   php artisan migrate --seed
   ```

7. **Create storage link**
   ```bash
   php artisan storage:link
   ```

8. **Build assets**
   ```bash
   npm run build
   ```

9. **Jalankan development server**
   ```bash
   php artisan serve
   ```

10. **Akses aplikasi**
    - URL: http://localhost:8000
    - Lihat kredensial default di seeder

## 👤 User Default (Seeder)

Setelah menjalankan seeder, Anda dapat login dengan:

### Admin
- Email: `admin@sekolah.sch.id`
- Password: `password`

### Petugas Gudang
- Email: `petugas@sekolah.sch.id`
- Password: `password`

### Peminjam
- Email: `peminjam@sekolah.sch.id`
- Password: `password`

## 🎨 Design System

### Color Palette
- **Primary**: Navy Blue (#1e3a8a) - Kepercayaan & institusional
- **Secondary**: White (#ffffff) - Clean & modern
- **Success**: Teal/Green (#14b8a6) - Status "tersedia"
- **Danger**: Red/Orange (#ef4444) - Status "terlambat"
- **Warning**: Yellow (#f59e0b) - Status "pending"

### Typography
- **Font Family**: Inter / System UI
- **Weights**: 400 (regular), 600 (semibold), 700 (bold)

### Status Badges
- 🟡 **Diajukan** (pending)
- 🟢 **Disetujui** (approved)
- 🔵 **Dipinjam** (borrowed)
- ⚪ **Dikembalikan** (returned)
- 🔴 **Terlambat** (overdue)
- ⚫ **Ditolak** (rejected)

## 🔐 Role-Based Access Control

### Middleware Configuration
```php
// bootstrap/app.php
$middleware->alias([
    'role' => \App\Http\Middleware\CheckRole::class,
]);
```

### Route Protection
```php
Route::middleware('role:admin')->group(function () {
    // Admin routes
});

Route::middleware('role:petugas,admin')->group(function () {
    // Petugas & Admin routes
});
```

## 📊 Alur Data Sistem

### 1. Pengajuan Peminjaman
```
Peminjam → Form Pengajuan → Validasi Stok → Database (status: diajukan)
```

### 2. Approval
```
Admin/Petugas → Review Pengajuan → Approve/Reject → Update Status → Notifikasi
```

### 3. Verifikasi Keluar
```
Petugas → Scan/Verifikasi Barang → Update Status (dipinjam) → Kurangi Stok
```

### 4. Verifikasi Kembali
```
Petugas → Cek Kondisi Barang → Update Status (dikembalikan) → Tambah Stok
→ Cek Keterlambatan → Hitung Denda (jika ada)
```

## 📱 Responsive Design

Aplikasi fully responsive dengan breakpoint:
- **Mobile**: < 640px
- **Tablet**: 640px - 1024px
- **Desktop**: > 1024px

## 🧪 Testing

```bash
# Run all tests
php artisan test

# Run with coverage
php artisan test --coverage

# Run specific test
php artisan test --filter=UserTest
```

## 🔍 Code Quality

```bash
# Laravel Pint (code formatter)
composer lint

# PHPStan (static analysis)
composer types:check

# Run all checks
composer test
```

## 📦 Deployment

### Production Setup

1. **Set environment to production**
   ```env
   APP_ENV=production
   APP_DEBUG=false
   ```

2. **Optimize**
   ```bash
   composer install --optimize-autoloader --no-dev
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   npm run build
   ```

3. **Setup web server** (Apache/Nginx)
   - Document root: `/public`
   - Enable `.htaccess` (Apache) atau setup Nginx config

## 🤝 Kontribusi

Untuk skripsi/tugas akhir, dokumentasikan:
1. Analisis kebutuhan sistem
2. Perancangan database (ERD)
3. Perancangan interface (mockup/wireframe)
4. Implementasi & testing
5. User manual

## 📝 License

MIT License - Free to use for educational purposes.

## 📧 Support

Untuk pertanyaan atau bantuan:
- Email: admin@sekolah.sch.id
- GitHub Issues: (jika dipublish)

## 🙏 Credits

- Built with [Laravel 13](https://laravel.com)
- UI Components: [Livewire Flux](https://flux.laravel.com)
- Icons: Heroicons
- Styling: Tailwind CSS

---

**Dibuat dengan ❤️ untuk digitalisasi pendidikan Indonesia**
