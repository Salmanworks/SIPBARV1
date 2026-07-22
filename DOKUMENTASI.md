# 📚 DOKUMENTASI SIPBAR - Untuk Skripsi/Tugas Akhir

## Daftar Isi
1. [Analisis Kebutuhan Sistem](#1-analisis-kebutuhan-sistem)
2. [Perancangan Database](#2-perancangan-database)
3. [Perancangan Sistem](#3-perancangan-sistem)
4. [Implementasi](#4-implementasi)
5. [Testing](#5-testing)
6. [User Manual](#6-user-manual)

---

## 1. Analisis Kebutuhan Sistem

### 1.1 Latar Belakang
Sekolah masih menggunakan buku catatan manual untuk mencatat peminjaman barang inventaris. Hal ini menyebabkan:
- Data peminjaman tidak terstruktur
- Sulit melacak barang yang sedang dipinjam
- Rawan kehilangan data
- Proses approval tidak standar
- Laporan sulit dibuat

### 1.2 Tujuan Sistem
Membuat sistem informasi berbasis web untuk:
- Digitalisasi proses peminjaman barang
- Tracking stok real-time
- Proses approval terstandar
- Histori peminjaman tercatat
- Laporan yang mudah diakses

### 1.3 Ruang Lingkup
**Dalam lingkup:**
- Manajemen data barang dan kategori
- Pengajuan dan approval peminjaman
- Verifikasi keluar/masuk barang
- Tracking status peminjaman
- Sistem denda keterlambatan
- Laporan dan riwayat

**Luar lingkup:**
- Notifikasi via SMS/WhatsApp
- Integrasi dengan sistem akademik
- Mobile app native

### 1.4 Identifikasi Aktor

| Aktor | Deskripsi | Hak Akses |
|-------|-----------|-----------|
| **Admin** | Kepala gudang/TU | Full access: kelola barang, user, approval, laporan |
| **Petugas Gudang** | Staff gudang | Verifikasi barang keluar/masuk, update kondisi |
| **Peminjam** | Guru/Siswa/Staff | Ajukan peminjaman, lihat riwayat |

### 1.5 Kebutuhan Fungsional

| ID | Kebutuhan | Prioritas |
|----|-----------|-----------|
| F-01 | Sistem dapat melakukan autentikasi user | Tinggi |
| F-02 | Sistem dapat membedakan hak akses berdasarkan role | Tinggi |
| F-03 | Admin dapat mengelola data barang (CRUD) | Tinggi |
| F-04 | Admin dapat mengelola kategori barang | Sedang |
| F-05 | Admin dapat mengelola user | Tinggi |
| F-06 | Peminjam dapat mengajukan peminjaman | Tinggi |
| F-07 | Admin dapat approve/reject peminjaman | Tinggi |
| F-08 | Petugas dapat verifikasi barang keluar | Tinggi |
| F-09 | Petugas dapat verifikasi barang masuk | Tinggi |
| F-10 | Sistem dapat menghitung keterlambatan | Sedang |
| F-11 | Sistem dapat menghitung denda | Sedang |
| F-12 | User dapat melihat riwayat peminjaman | Sedang |
| F-13 | Admin dapat melihat laporan | Tinggi |
| F-14 | Sistem dapat filter dan search data | Sedang |

### 1.6 Kebutuhan Non-Fungsional

| ID | Kebutuhan | Deskripsi |
|----|-----------|-----------|
| NF-01 | **Performance** | Response time < 2 detik |
| NF-02 | **Security** | Password hashing, CSRF protection |
| NF-03 | **Usability** | Interface intuitif, responsive |
| NF-04 | **Reliability** | Uptime 99%, data backup |
| NF-05 | **Maintainability** | Code terstruktur, dokumentasi |

---

## 2. Perancangan Database

### 2.1 Entity Relationship Diagram (ERD)

```
┌─────────────┐         ┌──────────────┐         ┌─────────────┐
│   USERS     │         │ PEMINJAMANS  │         │  BARANGS    │
├─────────────┤         ├──────────────┤         ├─────────────┤
│ PK id       │────┐    │ PK id        │    ┌───│ PK id       │
│    name     │    │    │ FK user_id   │    │   │    kode_    │
│    email    │    └───>│    tanggal_  │    │   │    barang   │
│    password │         │    pinjam    │    │   │    nama_    │
│    role     │    ┌───>│    tanggal_  │    │   │    barang   │
│    no_induk │    │    │    kembali_  │    │   │ FK kategori_│
│    ...      │    │    │    rencana   │    │   │    id       │
└─────────────┘    │    │    tanggal_  │    │   │    stok     │
                   │    │    kembali_  │    │   │    kondisi  │
                   │    │    aktual    │    │   │    foto     │
                   │    │    status    │    │   │    deskripsi│
                   │    │    keperluan │    │   └─────────────┘
                   │    │    catatan_  │    │          │
                   │    │    admin     │    │          │
                   │    │ FK disetujui_│    │          │
                   │    │    oleh      │    │   ┌──────────────┐
                   │    └──────────────┘    │   │  KATEGORIS   │
                   │           │            │   ├──────────────┤
                   │           │            │   │ PK id        │
                   │           │            │   │    nama_     │
                   │           │            │   │    kategori  │
                   │           │            └──>│    deskripsi │
                   │           │                └──────────────┘
                   │           │
                   │           ▼
                   │    ┌──────────────────┐
                   │    │ DETAIL_          │
                   │    │ PEMINJAMANS      │
                   │    ├──────────────────┤
                   │    │ PK id            │
                   │    │ FK peminjaman_id │
                   │    │ FK barang_id     │
                   │    │    jumlah        │
                   │    │    kondisi_saat_ │
                   │    │    kembali       │
                   │    └──────────────────┘
                   │           │
                   │           │
                   │           ▼
                   │    ┌──────────────┐
                   │    │   DENDAS     │
                   │    ├──────────────┤
                   │    │ PK id        │
                   └───>│ FK peminjaman│
                        │    _id       │
                        │    jumlah_   │
                        │    hari_telat│
                        │    nominal_  │
                        │    denda     │
                        │    status_   │
                        │    bayar     │
                        │    tanggal_  │
                        │    bayar     │
                        └──────────────┘
```

### 2.2 Spesifikasi Tabel

#### Tabel: users
| Field | Type | Constraint | Keterangan |
|-------|------|------------|------------|
| id | BIGINT | PK, AI | ID user |
| name | VARCHAR(255) | NOT NULL | Nama lengkap |
| email | VARCHAR(255) | UNIQUE, NOT NULL | Email user |
| password | VARCHAR(255) | NOT NULL | Password (hashed) |
| role | ENUM | NOT NULL | admin/petugas/peminjam |
| no_induk | VARCHAR(50) | NULLABLE | NIP/NIS |
| email_verified_at | TIMESTAMP | NULLABLE | Verifikasi email |
| remember_token | VARCHAR(100) | NULLABLE | Remember me token |
| created_at | TIMESTAMP | | Waktu dibuat |
| updated_at | TIMESTAMP | | Waktu diupdate |

#### Tabel: kategoris
| Field | Type | Constraint | Keterangan |
|-------|------|------------|------------|
| id | BIGINT | PK, AI | ID kategori |
| nama_kategori | VARCHAR(100) | NOT NULL | Nama kategori |
| deskripsi | TEXT | NULLABLE | Deskripsi |
| created_at | TIMESTAMP | | Waktu dibuat |
| updated_at | TIMESTAMP | | Waktu diupdate |

#### Tabel: barangs
| Field | Type | Constraint | Keterangan |
|-------|------|------------|------------|
| id | BIGINT | PK, AI | ID barang |
| kode_barang | VARCHAR(50) | UNIQUE, NOT NULL | Kode unik barang |
| nama_barang | VARCHAR(255) | NOT NULL | Nama barang |
| kategori_id | BIGINT | FK kategoris(id) | ID kategori |
| stok | INT | NOT NULL, DEFAULT 0 | Jumlah stok |
| kondisi | ENUM | NOT NULL | baik/rusak |
| foto | VARCHAR(255) | NULLABLE | Path foto |
| deskripsi | TEXT | NULLABLE | Deskripsi barang |
| created_at | TIMESTAMP | | Waktu dibuat |
| updated_at | TIMESTAMP | | Waktu diupdate |

#### Tabel: peminjamans
| Field | Type | Constraint | Keterangan |
|-------|------|------------|------------|
| id | BIGINT | PK, AI | ID peminjaman |
| user_id | BIGINT | FK users(id) | ID peminjam |
| tanggal_pinjam | DATE | NOT NULL | Tanggal pinjam |
| tanggal_kembali_rencana | DATE | NOT NULL | Rencana kembali |
| tanggal_kembali_aktual | DATE | NULLABLE | Tanggal kembali aktual |
| status | ENUM | NOT NULL | diajukan/disetujui/ditolak/dipinjam/dikembalikan/terlambat |
| keperluan | TEXT | NULLABLE | Keperluan peminjaman |
| catatan_admin | TEXT | NULLABLE | Catatan approval |
| disetujui_oleh | BIGINT | FK users(id), NULLABLE | ID admin/petugas |
| created_at | TIMESTAMP | | Waktu dibuat |
| updated_at | TIMESTAMP | | Waktu diupdate |

#### Tabel: detail_peminjamans
| Field | Type | Constraint | Keterangan |
|-------|------|------------|------------|
| id | BIGINT | PK, AI | ID detail |
| peminjaman_id | BIGINT | FK peminjamans(id) | ID peminjaman |
| barang_id | BIGINT | FK barangs(id) | ID barang |
| jumlah | INT | NOT NULL | Jumlah dipinjam |
| kondisi_saat_kembali | ENUM | NULLABLE | baik/rusak |
| created_at | TIMESTAMP | | Waktu dibuat |
| updated_at | TIMESTAMP | | Waktu diupdate |

#### Tabel: dendas
| Field | Type | Constraint | Keterangan |
|-------|------|------------|------------|
| id | BIGINT | PK, AI | ID denda |
| peminjaman_id | BIGINT | FK peminjamans(id) | ID peminjaman |
| jumlah_hari_telat | INT | NOT NULL | Hari keterlambatan |
| nominal_denda | DECIMAL(10,2) | NOT NULL | Nominal denda |
| status_bayar | ENUM | NOT NULL | belum_bayar/sudah_bayar |
| tanggal_bayar | DATE | NULLABLE | Tanggal bayar |
| created_at | TIMESTAMP | | Waktu dibuat |
| updated_at | TIMESTAMP | | Waktu diupdate |

### 2.3 Relasi Tabel

1. **users ← peminjamans** (1:N)
   - Satu user dapat memiliki banyak peminjaman
   
2. **users ← peminjamans** (1:N via disetujui_oleh)
   - Satu admin/petugas dapat menyetujui banyak peminjaman

3. **kategoris ← barangs** (1:N)
   - Satu kategori dapat memiliki banyak barang

4. **peminjamans ← detail_peminjamans** (1:N)
   - Satu peminjaman dapat memiliki banyak detail (multi-barang)

5. **barangs ← detail_peminjamans** (1:N)
   - Satu barang dapat dipinjam berkali-kali

6. **peminjamans → dendas** (1:1)
   - Satu peminjaman dapat memiliki satu denda

---

## 3. Perancangan Sistem

### 3.1 Use Case Diagram

```
┌─────────────┐
│   Peminjam  │
└──────┬──────┘
       │
       ├──> UC-01: Login
       ├──> UC-02: Lihat Katalog Barang
       ├──> UC-03: Ajukan Peminjaman
       ├──> UC-04: Lihat Status Peminjaman
       └──> UC-05: Lihat Riwayat

┌─────────────┐
│   Petugas   │
└──────┬──────┘
       │
       ├──> UC-01: Login
       ├──> UC-06: Verifikasi Barang Keluar
       ├──> UC-07: Verifikasi Barang Masuk
       ├──> UC-08: Update Kondisi Barang
       └──> UC-09: Lihat Dashboard Verifikasi

┌─────────────┐
│    Admin    │
└──────┬──────┘
       │
       ├──> UC-01: Login
       ├──> UC-10: Kelola Data Barang
       ├──> UC-11: Kelola Kategori
       ├──> UC-12: Kelola User
       ├──> UC-13: Approve/Reject Peminjaman
       ├──> UC-14: Kelola Denda
       └──> UC-15: Generate Laporan
```

### 3.2 Activity Diagram - Proses Peminjaman

```
[Peminjam]          [Sistem]           [Admin]           [Petugas]
    │                   │                  │                  │
    ├─ Login ──────────>│                  │                  │
    │                   │                  │                  │
    ├─ Pilih Barang ───>│                  │                  │
    │                   │                  │                  │
    ├─ Isi Form ───────>│                  │                  │
    │                   │                  │                  │
    ├─ Submit ─────────>│                  │                  │
    │                   │                  │                  │
    │                   ├─ Validasi Stok  │                  │
    │                   │                  │                  │
    │                   ├─ Simpan ────────>│                  │
    │                   │                  │                  │
    │                   │            Review Pengajuan         │
    │                   │                  │                  │
    │                   │            Approve/Reject           │
    │                   │                  │                  │
    │                   │<─────────────────┤                  │
    │<─ Notifikasi ─────┤                  │                  │
    │                   │                  │                  │
    │                   │                  │    Verifikasi    │
    │                   │                  │    Barang Keluar │
    │                   │                  │                  │
    │                   │<─────────────────┼──────────────────┤
    │                   │                  │                  │
    │                   ├─ Update Status   │                  │
    │                   │   (Dipinjam)     │                  │
    │                   │                  │                  │
    │   ... Waktu Peminjaman ...           │                  │
    │                   │                  │                  │
    │                   │                  │    Verifikasi    │
    │                   │                  │    Barang Masuk  │
    │                   │                  │                  │
    │                   │<─────────────────┼──────────────────┤
    │                   │                  │                  │
    │                   ├─ Cek Keterlambatan                  │
    │                   │                  │                  │
    │                   ├─ Hitung Denda (jika telat)          │
    │                   │                  │                  │
    │                   ├─ Update Status   │                  │
    │                   │   (Dikembalikan) │                  │
    │                   │                  │                  │
    │<─ Notifikasi ─────┤                  │                  │
    │   (+ Denda)       │                  │                  │
    │                   │                  │                  │
```

### 3.3 Sequence Diagram - Approval Peminjaman

```
Peminjam    Controller    Model    Database    Admin    Notification
   │            │           │          │          │           │
   ├─ Submit ──>│           │          │          │           │
   │            │           │          │          │           │
   │            ├─ Validate>│          │          │           │
   │            │           │          │          │           │
   │            │           ├─ Insert─>│          │           │
   │            │           │          │          │           │
   │            │<──────────┴──────────┘          │           │
   │            │                                 │           │
   │<─ Response─┤                                 │           │
   │            │                                 │           │
   │            │                       Review   <┤           │
   │            │                       Pengajuan │           │
   │            │                                 │           │
   │            │<────────────────────── Approve ─┤           │
   │            │                                 │           │
   │            ├─ Update ────────────>│          │           │
   │            │   Status              │         │           │
   │            │                       │         │           │
   │            ├───────────────────────┴─────────┴──────────>│
   │            │                                 Send Email  │
   │            │                                              │
   │<───────────┴──────────────────────────────────────────────┤
   │            Notification                                   │
```

### 3.4 Class Diagram (Models)

```
┌──────────────────┐
│      User        │
├──────────────────┤
│ - id             │
│ - name           │
│ - email          │
│ - password       │
│ - role           │
│ - no_induk       │
├──────────────────┤
│ + peminjamans()  │
│ + isAdmin()      │
│ + isPetugas()    │
│ + isPeminjam()   │
└──────────────────┘
         │ 1
         │
         │ *
┌──────────────────┐         ┌──────────────────┐
│   Peminjaman     │ 1     * │ DetailPeminjaman │
├──────────────────┤─────────├──────────────────┤
│ - id             │         │ - id             │
│ - user_id        │         │ - peminjaman_id  │
│ - tanggal_pinjam │         │ - barang_id      │
│ - ...            │         │ - jumlah         │
│ - status         │         │ - kondisi_...    │
├──────────────────┤         └──────────────────┘
│ + user()         │                  │ *
│ + details()      │                  │
│ + denda()        │                  │ 1
│ + isOverdue()    │         ┌──────────────────┐
└──────────────────┘         │     Barang       │
         │ 1                 ├──────────────────┤
         │                   │ - id             │
         │ 1                 │ - kode_barang    │
┌──────────────────┐         │ - nama_barang    │
│      Denda       │         │ - kategori_id    │
├──────────────────┤         │ - stok           │
│ - id             │         │ - kondisi        │
│ - peminjaman_id  │         ├──────────────────┤
│ - jumlah_hari... │         │ + kategori()     │
│ - nominal_denda  │         │ + isTersedia()   │
│ - status_bayar   │         │ + fotoUrl()      │
└──────────────────┘         └──────────────────┘
                                      │ *
                                      │
                                      │ 1
                             ┌──────────────────┐
                             │    Kategori      │
                             ├──────────────────┤
                             │ - id             │
                             │ - nama_kategori  │
                             │ - deskripsi      │
                             ├──────────────────┤
                             │ + barangs()      │
                             └──────────────────┘
```

---

## 4. Implementasi

### 4.1 Teknologi yang Digunakan

| Komponen | Teknologi | Versi | Fungsi |
|----------|-----------|-------|--------|
| Backend Framework | Laravel | 13 | PHP framework MVC |
| Database | SQLite | 3.x | Database relasional |
| Frontend | Blade | - | Template engine |
| CSS Framework | Tailwind CSS | 3.x | Styling responsive |
| UI Components | Livewire Flux | 2.x | Interactive components |
| Authentication | Laravel Fortify | 1.37+ | Auth & registration |
| Interactive | Livewire | 4.1+ | Real-time components |

### 4.2 Struktur Folder

```
app/
├── Enums/                  # Enum untuk status, role, dll
├── Http/
│   ├── Controllers/        # Logic controller
│   └── Middleware/         # Custom middleware
├── Models/                 # Eloquent models
└── Concerns/               # Reusable traits

database/
├── migrations/             # Database schema
└── seeders/                # Data dummy

resources/
├── views/                  # Blade templates
└── css/js                  # Assets

routes/
└── web.php                 # Route definitions
```

### 4.3 Fitur Keamanan

1. **Password Hashing**: Menggunakan bcrypt
2. **CSRF Protection**: Token di setiap form
3. **SQL Injection Prevention**: Eloquent ORM
4. **XSS Protection**: Blade escaping
5. **Role-based Access**: Middleware CheckRole
6. **Session Management**: Secure session
7. **File Upload Validation**: Size & type check

### 4.4 Optimasi Performance

1. **Eager Loading**: `with()` untuk relasi
2. **Pagination**: Limit data per halaman
3. **Caching**: Config, route, view cache
4. **Database Indexing**: Index pada foreign key
5. **Asset Optimization**: Vite build & minify

---

## 5. Testing

### 5.1 Test Plan

| Test Case | Input | Expected Output | Status |
|-----------|-------|-----------------|--------|
| TC-01: Login Admin | Email: admin@, Pass: password | Redirect ke dashboard admin | ✅ |
| TC-02: Login Peminjam | Email: peminjam@, Pass: password | Redirect ke dashboard peminjam | ✅ |
| TC-03: Tambah Barang | Form valid | Barang tersimpan | ✅ |
| TC-04: Ajukan Peminjaman | Form valid, stok cukup | Status diajukan | ✅ |
| TC-05: Approve Peminjaman | ID valid, stok cukup | Status disetujui | ✅ |
| TC-06: Reject Peminjaman | ID valid, catatan diisi | Status ditolak | ✅ |
| TC-07: Verifikasi Keluar | ID valid | Status dipinjam, stok berkurang | ✅ |
| TC-08: Verifikasi Masuk | ID valid | Status dikembalikan, stok bertambah | ✅ |
| TC-09: Keterlambatan | Tanggal > rencana | Status terlambat, denda dihitung | ✅ |
| TC-10: Filter Laporan | Tanggal range | Data terfilter | ✅ |

### 5.2 Browser Compatibility

| Browser | Versi | Status |
|---------|-------|--------|
| Chrome | 90+ | ✅ |
| Firefox | 88+ | ✅ |
| Safari | 14+ | ✅ |
| Edge | 90+ | ✅ |

### 5.3 Device Testing

| Device | Resolution | Status |
|--------|------------|--------|
| Desktop | 1920x1080 | ✅ |
| Laptop | 1366x768 | ✅ |
| Tablet | 768x1024 | ✅ |
| Mobile | 375x667 | ✅ |

---

## 6. User Manual

### 6.1 Untuk Admin

#### Login
1. Buka browser, akses `http://localhost:8000`
2. Klik "Masuk ke Sistem"
3. Input email: `admin@sekolah.sch.id`, password: `password`
4. Klik "Login"

#### Mengelola Barang
1. Dari dashboard, klik menu "Barang"
2. Klik "Tambah Barang"
3. Isi form: kode, nama, kategori, stok, kondisi, foto
4. Klik "Simpan"

#### Approve Peminjaman
1. Klik menu "Peminjaman" → "Perlu Approval"
2. Lihat detail pengajuan
3. Klik "Setujui" atau "Tolak"
4. Isi catatan (jika tolak, wajib)
5. Konfirmasi

### 6.2 Untuk Petugas

#### Verifikasi Barang Keluar
1. Login sebagai petugas
2. Klik menu "Verifikasi"
3. Pilih peminjaman dengan status "Disetujui"
4. Cek fisik barang
5. Klik "Barang Keluar"
6. Konfirmasi

#### Verifikasi Barang Masuk
1. Klik menu "Verifikasi"
2. Pilih peminjaman dengan status "Dipinjam"
3. Cek kondisi barang saat kembali
4. Pilih kondisi per barang
5. Klik "Barang Masuk"
6. Sistem otomatis cek keterlambatan

### 6.3 Untuk Peminjam

#### Mengajukan Peminjaman
1. Login sebagai peminjam
2. Klik "Ajukan Peminjaman"
3. Pilih barang dan jumlah
4. Isi tanggal pinjam dan kembali
5. Isi keperluan
6. Klik "Ajukan"
7. Tunggu approval dari admin

#### Melihat Status
1. Klik menu "Riwayat"
2. Lihat status pengajuan (pending/approved/rejected/borrowed/returned)
3. Klik "Detail" untuk info lengkap

---

## 7. Kesimpulan & Saran

### 7.1 Kesimpulan
1. SIPBAR berhasil mendigitalisasi proses peminjaman barang sekolah
2. Sistem memiliki 3 role dengan hak akses berbeda
3. Fitur tracking real-time memudahkan monitoring stok
4. Proses approval terstandar dan tercatat
5. Laporan dapat diakses dan difilter dengan mudah

### 7.2 Saran Pengembangan
1. **Notifikasi Real-time**: Implementasi WebSocket/Pusher
2. **Email Notification**: Kirim email saat approval/reminder
3. **Barcode Scanner**: Scan barcode untuk verifikasi cepat
4. **Export Laporan**: Export ke Excel/PDF
5. **Mobile App**: Native app Android/iOS
6. **Integrasi Akademik**: Sync dengan sistem akademik sekolah
7. **Dashboard Analytics**: Grafik statistik lebih lengkap
8. **Multi-language**: Support bahasa Inggris

---

**Dokumentasi ini dapat digunakan sebagai referensi untuk:**
- Bab II (Landasan Teori)
- Bab III (Analisis & Perancangan Sistem)
- Bab IV (Implementasi & Testing)
- Lampiran (User Manual)
