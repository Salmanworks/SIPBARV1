# ⚡ Quick Start Guide - SIPBAR

## 🚀 Instalasi Cepat (5 Menit)

```bash
# 1. Install dependencies
composer install
npm install

# 2. Setup environment
copy .env.example .env
php artisan key:generate

# 3. Setup database
php artisan migrate --seed
php artisan storage:link

# 4. Build & run
npm run build
php artisan serve
```

Akses: **http://localhost:8000**

---

## 👤 Login Cepat

| Role | Email | Password |
|------|-------|----------|
| **Admin** | admin@sekolah.sch.id | password |
| **Petugas** | petugas@sekolah.sch.id | password |
| **Peminjam** | peminjam@sekolah.sch.id | password |

---

## 🎯 Fitur Utama per Role

### Admin
✅ Kelola barang & kategori
✅ Kelola user (CRUD)
✅ Approve/reject peminjaman
✅ Laporan lengkap

**Route Prefix**: `/admin/*`

### Petugas
✅ Verifikasi barang keluar
✅ Verifikasi barang masuk
✅ Update kondisi barang

**Route Prefix**: `/petugas/*`

### Peminjam
✅ Ajukan peminjaman
✅ Lihat status pengajuan
✅ Riwayat peminjaman

**Route Prefix**: `/peminjam/*`

---

## 📋 Workflow Peminjaman

```
1. Peminjam → Ajukan Peminjaman
   ↓
2. Admin → Approve/Reject
   ↓
3. Petugas → Verifikasi Keluar (barang dipinjam)
   ↓
4. [Waktu Peminjaman]
   ↓
5. Petugas → Verifikasi Masuk (barang dikembalikan)
   ↓
6. Sistem → Cek keterlambatan & hitung denda
```

---

## 🗂️ Struktur Route

```
/                           → Landing page
/dashboard                  → Auto redirect sesuai role

/admin/dashboard            → Dashboard admin
/admin/barang               → CRUD barang
/admin/kategori             → CRUD kategori
/admin/users                → CRUD user
/admin/peminjaman           → List peminjaman
/admin/peminjaman/approval  → Approval page
/admin/laporan              → Laporan

/petugas/dashboard          → Dashboard petugas
/petugas/verifikasi         → List verifikasi
/petugas/verifikasi/{id}    → Detail verifikasi

/peminjam/dashboard         → Dashboard peminjam
/peminjam/pengajuan/create  → Form pengajuan
/peminjam/riwayat           → Riwayat peminjaman
```

---

## 🎨 Status Badge

| Status | Warna | Keterangan |
|--------|-------|------------|
| 🟡 Diajukan | Yellow | Menunggu approval |
| 🟢 Disetujui | Green | Disetujui, belum diambil |
| 🔵 Dipinjam | Blue | Sedang dipinjam |
| ⚪ Dikembalikan | Gray | Sudah dikembalikan |
| 🔴 Terlambat | Red | Melewati batas waktu |
| ⚫ Ditolak | Dark | Ditolak admin |

---

## 🗄️ Tabel Database

```
users                → Data pengguna
kategoris            → Kategori barang
barangs              → Data barang
peminjamans          → Data peminjaman
detail_peminjamans   → Detail barang per peminjaman
dendas               → Data denda keterlambatan
```

---

## 📦 Data Seeder

Seeder otomatis membuat:
- ✅ 5 user (1 admin, 1 petugas, 3 peminjam)
- ✅ 8 kategori (Elektronik, Olahraga, Lab, dll)
- ✅ 20+ barang contoh
- ✅ 10 peminjaman sample (berbagai status)

---

## 🛠️ Command Berguna

```bash
# Development
npm run dev              # Watch & compile assets
php artisan serve        # Run dev server

# Database
php artisan migrate      # Jalankan migration
php artisan migrate:fresh --seed  # Reset & seed
php artisan db:seed      # Jalankan seeder saja

# Cache
php artisan config:clear # Clear config cache
php artisan route:clear  # Clear route cache
php artisan view:clear   # Clear view cache

# Info
php artisan about        # Info aplikasi
php artisan route:list   # List semua route
```

---

## 🧪 Testing Flow

### Test sebagai Peminjam:
1. Login: `peminjam@sekolah.sch.id`
2. Klik "Ajukan Peminjaman"
3. Pilih barang (cth: Laptop HP)
4. Isi form & submit
5. Status: 🟡 Diajukan

### Test sebagai Admin:
1. Login: `admin@sekolah.sch.id`
2. Menu "Peminjaman" → "Perlu Approval"
3. Klik "Detail" pada pengajuan baru
4. Klik "Setujui"
5. Status berubah: 🟢 Disetujui

### Test sebagai Petugas:
1. Login: `petugas@sekolah.sch.id`
2. Menu "Verifikasi"
3. Pilih peminjaman yang disetujui
4. Klik "Barang Keluar"
5. Status berubah: 🔵 Dipinjam
6. Stok berkurang otomatis

---

## 🎓 Untuk Skripsi/TA

Dokumentasi lengkap tersedia di:
- `README.md` → Overview & instalasi
- `DOKUMENTASI.md` → Analisis, perancangan, testing
- `INSTALASI.md` → Panduan instalasi detail

Gunakan untuk:
- **BAB II**: Landasan teori (tech stack)
- **BAB III**: Analisis & perancangan (ERD, use case, class diagram)
- **BAB IV**: Implementasi & testing
- **LAMPIRAN**: User manual & source code

---

## 🔍 Troubleshooting Cepat

| Error | Solusi |
|-------|--------|
| Storage link error | `php artisan storage:link` |
| Class not found | `composer dump-autoload` |
| Database locked | Restart `php artisan serve` |
| CSS tidak muncul | `npm run build` + Clear cache browser |
| Port 8000 used | `php artisan serve --port=8001` |

---

## 📊 Statistics

- **Total Routes**: 40+
- **Database Tables**: 8 (termasuk sistem)
- **Models**: 6 (User, Barang, Kategori, Peminjaman, DetailPeminjaman, Denda)
- **Controllers**: 10+
- **Views**: 30+ Blade templates
- **Enums**: 4 (UserRole, PeminjamanStatus, KondisiBarang, DendaStatus)

---

## 🎯 Next Steps

1. ✅ **Install & Test**: Ikuti quick start di atas
2. ✅ **Explore**: Login dengan semua role
3. ✅ **Customize**: Ubah nama sekolah, warna, logo
4. ✅ **Develop**: Tambah fitur sesuai kebutuhan
5. ✅ **Deploy**: Deploy ke hosting/server

---

## 📱 Responsive Breakpoints

- 📱 Mobile: < 640px
- 📱 Tablet: 640px - 1024px
- 💻 Desktop: > 1024px

---

## 🎨 Kustomisasi Warna

Edit `tailwind.config.js`:
```js
colors: {
  'primary': '#1e3a8a',    // Navy blue
  'secondary': '#14b8a6',  // Teal
  // Tambah warna custom
}
```

---

## 🔒 Security Features

✅ Password hashing (bcrypt)
✅ CSRF protection
✅ SQL injection prevention (Eloquent ORM)
✅ XSS protection (Blade escaping)
✅ Role-based access control
✅ Session security

---

## 📞 Support

Untuk bantuan lebih lanjut:
- 📖 Baca `README.md` untuk detail
- 📚 Baca `DOKUMENTASI.md` untuk analisis sistem
- 🚀 Baca `INSTALASI.md` untuk troubleshooting

**Happy Coding! 🚀**
