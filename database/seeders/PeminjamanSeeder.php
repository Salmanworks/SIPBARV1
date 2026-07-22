<?php

namespace Database\Seeders;

use App\Enums\PeminjamanStatus;
use App\Models\Barang;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Database\Seeder;

class PeminjamanSeeder extends Seeder
{
    public function run(): void
    {
        $peminjam = User::where('email', 'guru@sipbar.sch.id')->first();
        $admin = User::where('email', 'admin@sipbar.sch.id')->first();
        $laptop = Barang::where('kode_barang', 'ELK-001')->first();
        $proyektor = Barang::where('kode_barang', 'ELK-002')->first();

        if (! $peminjam || ! $laptop || ! $proyektor) {
            return;
        }

        // Peminjaman 1: Sedang dipinjam
        $peminjaman1 = Peminjaman::create([
            'user_id' => $peminjam->id,
            'tanggal_pinjam' => now()->subDays(3),
            'tanggal_kembali_rencana' => now()->addDays(2),
            'status' => PeminjamanStatus::Dipinjam,
            'keperluan' => 'Presentasi rapat kurikulum',
            'disetujui_oleh' => $admin?->id,
        ]);

        $peminjaman1->details()->createMany([
            ['barang_id' => $laptop->id, 'jumlah' => 1],
            ['barang_id' => $proyektor->id, 'jumlah' => 1],
        ]);

        // Peminjaman 2: Baru diajukan
        Peminjaman::create([
            'user_id' => $peminjam->id,
            'tanggal_pinjam' => now(),
            'tanggal_kembali_rencana' => now()->addDays(5),
            'status' => PeminjamanStatus::Diajukan,
            'keperluan' => 'Praktikum biologi kelas XI',
        ]);

        // Peminjaman 3: Sudah dikembalikan
        $peminjaman3 = Peminjaman::create([
            'user_id' => $peminjam->id,
            'tanggal_pinjam' => now()->subDays(10),
            'tanggal_kembali_rencana' => now()->subDays(3),
            'tanggal_kembali_aktual' => now()->subDays(2),
            'status' => PeminjamanStatus::Dikembalikan,
            'keperluan' => 'Kegiatan ekstrakurikuler',
            'disetujui_oleh' => $admin?->id,
        ]);

        $peminjaman3->details()->create([
            'barang_id' => $proyektor->id,
            'jumlah' => 1,
            'kondisi_saat_kembali' => 'baik',
        ]);
    }
}
