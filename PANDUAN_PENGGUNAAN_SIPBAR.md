# 📚 PANDUAN PENGGUNAAN SIPBAR
## (Sistem Informasi Peminjaman Barang Sekolah)

---

## 📖 Daftar Isi
1. [Gambaran Umum](#1-gambaran-umum)
2. [Persiapan & Instalasi Awal](#2-persiapan--instalasi-awal)
3. [Akses Login & 3 Role Pengguna](#3-akses-login--3-role-pengguna)
4. [Panduan Role ADMINISTRATOR](#4-panduan-role-administrator)
5. [Panduan Role GURU](#5-panduan-role-guru)
6. [Panduan Role SISWA](#6-panduan-role-siswa)
7. [Alur Peminjaman Barang (Lengkap Step-by-Step)](#7-alur-peminjaman-barang-lengkap-step-by-step)
8. [Alur Pengembalian Barang (Lengkap Step-by-Step)](#8-alur-pengembalian-barang-lengkap-step-by-step)
9. [Denda Keterlambatan](#9-denda-keterlambatan)
10. [Tips Keamanan & FAQ](#10-tips-keamanan--faq)

---

## 1. Gambaran Umum

**SIPBAR** adalah *web-based application* berbasis Laravel 13 untuk mengelola **peminjaman barang inventaris sekolah** secara digital, tertib, dan *paperless*.

### Fitur Unggulan:
✅ **3 Role Terpisah** (Admin / Guru / Siswa) dengan 1 halaman login otomatis detect  
✅ **QR Code Secure Signed** (setiap transaksi punya token unik anti palsu)  
✅ **Stok Otomatis Jalan** (kurang saat penyerahan, bertambah saat pengembalian)  
✅ **First Login Wajib Ganti Password** (keamanan akun terjamin)  
✅ **Activity Log** semua perubahan data tercatat (spatie/laravel-activitylog)  
✅ **Denda Keterlambatan Otomatis** dihitung per hari  
✅ **Soft Delete** semua data (tidak benar-benar hilang meskipun dihapus)  
✅ **Import CSV Massal** untuk Guru & Siswa (download template tersedia)

---

## 2. Persiapan & Instalasi Awal

### 2.1 Jalankan Server Lokal
Pastikan **Terminal** sudah berjalan dengan server Laravel:
```bash
# Port default yang digunakan:
# http://127.0.0.1:8000
php artisan serve --host=127.0.0.1 --port=8000
```

### 2.2 Link Storage (WAJIB — untuk tampilkan gambar QR Code / Foto Profil)
```bash
php artisan storage:link
```
> Jalankan ini **sekali saja** saat pertama kali setup project.  
> Tanpa perintah ini → gambar QR Code di dashboard Siswa/Guru TIDAK AKAN MUNCUL ❌

### 2.3 Jalankan Migrasi & Seeder (Data Awal)
```bash
# Membuat semua tabel di database MySQL:
php artisan migrate --fresh

# Isi data awal (user admin, guru, siswa default + barang demo):
php artisan db:seed
```

---

## 3. Akses Login & 3 Role Pengguna

Buka Browser → **http://127.0.0.1:8000/login**

SIPBAR menggunakan **SATU HALAMAN LOGIN untuk SEMUA ROLE**. Sistem **OTOMATIS DETECT** role berdasarkan kolom login yang kamu masukkan:

| 🔑 KOLOM LOGIN DIGUNAKAN | ROLE | CONTOH DEFAULT AKUN | PASSWORD DEFAULT |
|---|---|---|---|
| **📧 Email** | 🛡️ ADMIN | `admin@sipbar.sch.id` | `password` |
| **🆔 NIP (16 digit)** | 👨‍🏫 GURU | `GRU001` | `password` |
| **🆔 NIS** | 🎓 SISWA | `SIS001` | `password` |

---

### ⚠️ RULE PERTAMA LOGIN (WAJIB BACA)
> Setiap akun **BARU / PERTAMA KALI LOGIN** akan **DIPAKSA MENGUBAH PASSWORD** (tombol Submit akan selalu redirect ke halaman `Edit Profile` sampai password diganti).  
> **Alasan**: Keamanan — agar tidak terus pakai default password (NIP/NIS).

Cara melewati First Login:
1. Login pertama kali → otomatis masuk halaman **Profil Saya**
2. Isi 3 field:
   - **Password Lama**: `password` (atau NIP/NISmu)
   - **Password Baru**: min 8 karakter (campuran huruf+angka disarankan)
   - **Konfirmasi Password Baru**: isi ulang
3. Klik **Simpan Password** → selesai, sekarang bisa akses menu sidebar.

---

## 4. Panduan Role ADMINISTRATOR

> **Role ini punya akses TERTINGGI**. Bisa CRUD semua master data, lihat seluruh transaksi, kelola user. Jangan bagikan akun Admin ke sembarang orang!

### 📌 Menu Sidebar Admin:
```
📊 Dashboard          → Lihat statistik + grafik bulanan
📦 Inventaris
  ├─ 📚 Kelola Barang → CRUD barang, stok, kondisi, foto
  └─ 🏷️ Kategori      → CRUD kategori barang (Elektronik, ATK, DLL)
👥 Pengguna
  ├─ 👨‍🏫 Guru          → CRUD data guru + Import CSV
  ├─ 🎓 Siswa         → CRUD data siswa + Import CSV
  └─ 🫂 Kelola User   → List semua akun + reset password
💸 Transaksi
  ├─ 📑 Peminjaman    → Lihat SEMUA peminjaman (bisa filter status)
  └─ 📈 Laporan       → Rekap bulanan peminjaman & pengembalian
⚙️ Sistem
  ├─ 📝 Activity Log  → Audit log SIAPA yang UBAH/HAPUS data & KAPAN
  └─ 👤 Profil Saya   → Ganti nama, email, password
```

---

### 4.1 CARA TAMBAH BARANG (Admin)
1. Sidebar → `📚 Kelola Barang` → tombol **➕ Tambah Barang** (kanan atas)
2. Isi Form:
   - **Kode Barang** (unik, misal `ELK-001`, `ATK-015`)
   - **Nama Barang**
   - **Kategori** (pilih dropdown, jika belum ada → buat dulu di menu 🏷️ Kategori)
   - **Lokasi** (misal: `Lemari A Rak 2`)
   - **Stok / Jumlah** (integer > 0)
   - **Kondisi** (Baik / Rusak / Perbaiki)
   - **Status** (Tersedia / Dipinjam / Rusak)
   - **📷 Foto Barang** (opsional, upload file gambar JPG/PNG)
3. Klik **💾 Simpan**

---

### 4.2 CARA IMPORT GURU MASSAL (LEBIH DARI 10 DATA)
> Jangan input manual 1 per 1! Pakai fitur Import CSV:
1. Sidebar → `👨‍🏫 Guru` → tombol **📥 Import Guru**
2. Pertama Klik **📄 Download Template CSV** → dapat file `template_guru.csv`
3. Buka file tersebut pakai **Excel / Google Spreadsheet / LibreOffice Calc**
   - Isi kolom: `nip, nama_guru, email, jabatan, nomor_telepon, alamat`
   - **JANGAN UBAH BARIS PERTAMA (HEADER)** biarkan persis!
4. Simpan / **Download As CSV** (File → Save As → CSV UTF-8)
5. Kembali ke halaman Import → **Pilih File CSV** yang barusan diedit → **Unggah**
6. ✅ Status: Berhasil di-insert / update (jika NIP sudah pernah ada = dia akan UPDATE data lama)

> 💡 Tips untuk **Siswa Import CSV**: Caranya SAMA PENUH, cuma beda menu di `🎓 Siswa` → `📥 Import Siswa` → `Download Template Siswa`. Kolom template Siswa: `nis, nama_siswa, kelas, jurusan, nomor_telepon, alamat` (Email akan dibuat otomatis `siswa_{NIS}@sipbar.sch.id` oleh sistem).

---

## 5. Panduan Role GURU

> **Guru adalah Approver + Petugas Lapangan.** Bertugas menyetujui pengajuan siswa, menyerahkan barang, memproses pengembalian, scan QR.

### 📌 Menu Sidebar Guru:
```
🏠 Dashboard Guru   → Pengajuan baru (badge angka merah!), Barang dipinjam, Terlambat
✅ Persetujuan       → LIST UTAMA KERJA GURU (semua pengajuan siswa pending)
📋 Riwayat          → Semua transaksi yang pernah diproses
⚠️ Keterlambatan    → Siswa terlambat mengembalikan + nominal denda
📷 Scan QR          → (Coming soon) Scan QR bawaan browser
👤 Profil Saya      → Ganti password / data pribadi
```

---

## 6. Panduan Role SISWA

> **Siswa adalah pihak yang meminjam barang.**

### 📌 Menu Sidebar Siswa:
```
🎓 Dashboard Siswa   → Jumlah pengajuan saya, QR aktif, riwayat singkat
📦 Pinjam Barang     → KATALOG BARANG (cari + filter barang tersedia)
📜 Riwayat Saya      → Semua peminjaman: status + detail (bisa buka QR)
🔒 Ubah Password     → Ganti password
```

---

## 7. Alur Peminjaman Barang (Lengkap Step-by-Step)
> 6 Status Peminjaman: **Diajukan → Disetujui / Ditolak → Dipinjam → (Terlambat?) → Selesai**

---

### 🔹 STEP 1 — SISWA: AJUKAN PEMINJAMAN
1. Login sebagai **Siswa** (contoh: `SIS001`)
2. Sidebar → `📦 Pinjam Barang`
3. Cari barang yang ingin dipinjam (ketik di kolom 🔍 Search, atau filter Kategori dropdown)
4. Klik kartu barang / tombol **📝 Ajukan Pinjam**
5. Isi Form Pengajuan:
   - ✅ **Barang** (sudah terisi otomatis)
   - 🔢 **Jumlah Unit** (jangan melebihi Stok Tersedia ya!)
   - 📅 **Tanggal Pinjam** (tanggal kamu mau ambil barang)
   - 📅 **Tanggal Rencana Kembali** (maks lama pinjam = biasanya 7 hari)
   - 📝 **Keperluan** (jelaskan secara singkat: "Tugas kelompok IPA kelas 10")
6. Klik **📤 Ajukan Peminjaman**
7. ✅ Berhasil! Status sekarang = **DIAJUKAN (Pending)**. Kamu bisa lihat di `📜 Riwayat Saya`.

---

### 🔹 STEP 2 — GURU: REVIEW & SETUJU / TOLAK
1. Login sebagai **Guru** (contoh: `GRU001`)
2. Sidebar → `✅ Persetujuan` (disini muncul semua pengajuan baru, badge MERAH di angka)
3. Klik baris pengajuan yang ingin diproses → tombol **👁️ Detail**
4. Guru membuka halaman Detail:
   - **Cek Kelayakan**: Apakah siswa punya tanggungan denda? Stok barang benar tersedia?
5. Ada **2 Tombol** di bawah:
   - 🟢 **✅ SETUJUI PEMINJAMAN** → otomatis sistem GENERATE QR CODE SECURE + TOKEN 40 KARAKTER (status berubah **DISETUJUI**)
   - 🔴 **❌ TOLAK PEMINJAMAN** → wajib isi `Alasan Penolakan` (misal: "Stok sedang kosong"), status berubah **DITOLAK** → Siswa menerima notifikasi penolakan.

---

### 🔹 STEP 3 — SISWA DATANG KE RUANGAN SARANA + TUNJUKKAN QR
1. Siswa login lagi → buka `📜 Riwayat Saya` → cari transaksi Status = **Disetujui** → klik **Lihat Detail**
2. Disini akan muncul **Kotak QR Code BESAR** + Nomor Transaksi
3. Siswa **menunjukkan HP/Layar QR ini ke Guru** saat hendak mengambil barang.

---

### 🔹 STEP 4 — GURU: SCAN / BUKA HALAMAN PROSES + SERAHKAN BARANG
1. Guru buka menu `✅ Persetujuan` → cari transaksi Status = **Disetujui** → klik tombol **⚙️ Proses**
2. (Atau jika ada Scanner QR: Guru Scan QR dari HP Siswa → otomatis redirect ke halaman yang sama)
3. Guru memverifikasi FISIK BARANG yang hendak diserahkan (jumlah unit, kondisi awal Baik)
4. Klik tombol BESAR **✅ Serahkan Barang & Konfirmasi Dipinjam** (hijau gradient)
5. ✅ SELESAI!
   - Status sekarang = **DIPINJAM**
   - **⚠️ STOK BARANG OTOMATIS BERKURANG ⚠️** (dijalankan oleh sistem di belakang)
   - Tanggal peminjaman resmi dicatat.

---

## 8. Alur Pengembalian Barang (Lengkap Step-by-Step)

### 🔹 STEP 1 — GURU BUKA HALAMAN PROSES PENGEMBALIAN
1. Siswa mengembalikan barang fisik ke Guru / Ruang Sarana
2. Guru login → `✅ Persetujuan` (atau `📋 Riwayat`) → filter **Status: Dipinjam** → klik **⚙️ Proses**
3. Scroll ke bawah → Menemukan kartu **"🔄 Proses Pengembalian Barang"**

---

### 🔹 STEP 2 — GURU CEK KONDISI FISIK SETIAP BARANG
> UNTUK SETIAP BARANG YANG DIPINJAM → Guru WAJIB memilih 1 opsi kondisi:
```
☑️ (A) BAIK   → Barang kembali utuh, tidak cacat, fungsi normal
☑️ (B) RUSAK  → Barang penyok / hilang komponen / error / hilang total
```
> 💡 **PENTING**: Jika Kamu pilih **RUSAK** → sistem akan otomatis UPDATE **Master Kondisi Barang** di menu Kelola Barang menjadi "Rusak" agar tidak bisa dipinjam dulu sebelum diperbaiki.

---

### 🔹 STEP 3 — KLIK KONFIRMASI PENGEMBALIAN
1. Semua kondisi radio terisi (tidak ada yang kosong)
2. Klik tombol **✅ Konfirmasi Pengembalian & Simpan** (biru gradient besar)
3. ✅ SISTEM MENJALANKAN 4 HAL OTOMATIS SEKALI JALAN (atomic transaction):
   - 1️⃣ Status berubah **SELESAI (Dikembalikan)**
   - 2️⃣ **⚠️ STOK BARANG OTOMATIS BERTAMBAH KEMBALI** (sesuai jumlah unit per barang)
   - 3️⃣ `kondisi_saat_kembali` di detail_peminjaman tercatat permanen
   - 4️⃣ **QR Code file + token dihapus** (transaksi selesai, QR tidak berlaku lagi)
   - 5️⃣ *(jika terlambat)* → DENDA dibuat otomatis (lihat bab berikutnya)

---

## 9. Denda Keterlambatan

### 💸 Perhitungan Otomatis:
Saat Guru klik **Konfirmasi Pengembalian**:
```
Jumlah Hari Terlambat = MAX(0, (Tanggal Kembali Aktual) − (Tanggal Rencana Kembali))

Nominal Denda = (Jumlah Hari Terlambat) × Rp 5.000
```
> Contoh: Pinjam barang 2 unit, rencana kembali 30 Juli, tapi baru dikembalikan 1 Agustus.
> → Terlambat = **2 hari**
> → Denda = 2 × 5.000 = **Rp 10.000**

### Dimana melihat denda?
- Siswa: Dashboard → card **Denda Saya**
- Guru: Sidebar → **⚠️ Keterlambatan** (muncul list semua siswa terlambat + nominal denda)
- Admin: Dashboard Statistik → widget **Jumlah Denda Belum Lunas**

---

## 10. Tips Keamanan & FAQ

### 🔐 TIPS KEAMANAN:
1. **GANTI PASSWORD DEFAULT SEGERA** setelah login pertama! (wajib oleh sistem)
2. **Jangan Share Akun**: 1 akun = 1 orang. Activity Log akan mencatat SIAPA yang mengubah data.
3. **Logout jika selesai**: Jangan biarkan akun tetap login di PC lab / warnet.
4. **QR Code HANYA BERLAKU 1 KALI**: Setelah status jadi `Dipinjam` → QR tidak bisa dipakai lagi untuk approve baru.
5. **Hindari Klik Link Aneh**: Akses SIPBAR hanya via URL resmi server sekolah.

---

### ❓ FREQUENTLY ASKED QUESTIONS (FAQ)

---
**Q: Saya (Admin) sudah buat akun Guru/Siswa baru, tapi orang tersebut LOGIN ERROR?**  
A: 3 hal yang harus dicek:
 1. Apakah **Password yang dia masukkan = NIP / NIS**? (default sebelum first login change password)
 2. Apakah Guru memasukkan **NIP bukan Email**? (Guru → Login via NIP, bukan email!)
 3. Jalankan `php artisan cache:clear` jika habis import massal.

---
**Q: Gambar QR Code tidak muncul (broken image icon)?**  
A: **Storage belum di-link!** Jalankan 1x:
```bash
php artisan storage:link
```

---
**Q: Status pengajuan siswa sudah "Disetujui" tapi stok barang belum berkurang?**  
A: NORMAL. Stok baru berkurang di step **Serahkan Barang** (step 4 alur peminjaman). Karena stok belum berkurang jika siswa BATAL sebelum mengambil barang — stok tidak salah hitung.

---
**Q: Bagaimana menghapus data Guru / Barang / Siswa? Apakah hilang permanen?**  
A: Semua menggunakan **Soft Delete**. Data yang dihapus tidak tampil di list lagi tapi TETAP ADA di database (kolom `deleted_at` terisi). Bisa restore lewat **php artisan tinker** jika tidak sengaja terhapus.

---
**Q: Import Guru/Siswa error? CSV tidak terbaca?**  
A: Pastikan:
1. Kamu pakai **Template Resmi** yang di-download dari tombol `Download Template CSV` (JANGAN buat header sendiri)
2. Simpan file sebagai **CSV UTF-8** (bukan XLSX / ODS)
3. Tidak ada **KOMA ( , )** di dalam 1 cell (misal alamat `Jl. Merdeka, No. 12` — ganti koma dengan titik koma `;` atau titik `.`)
4. **NIP / NIS tidak duplikat** di baris lain (cek dulu sebelum import)

---
**Q: Laptop saya mau install SIPBAR offline?**  
A: Minimal spesifikasi:
   - PHP 8.3+ (ekstensi: pdo_mysql, mbstring, fileinfo, gd)
   - MySQL 8 / MariaDB 10.11+
   - Composer 2.7+
   - Web Server: Apache / Nginx (atau pakai `php artisan serve` untuk lokal)
   - Browser: Chrome / Edge / Firefox versi terbaru.

---

## 🎉 SELESAI — SELAMAT MENGGUNAKAN SIPBAR!

Jika ada pertanyaan / laporan error → Hubungi **Team Developer SIPBAR** atau Admin Sistem Sekolah.
