<?php

namespace Database\Seeders;

use App\Models\Barang;
use App\Models\Kategori;
use Illuminate\Database\Seeder;

class BarangSeeder extends Seeder
{
    public function run(): void
    {
        $elektronik = Kategori::where('nama_kategori', 'Elektronik')->first();
        $olahraga = Kategori::where('nama_kategori', 'Olahraga')->first();
        $lab = Kategori::where('nama_kategori', 'Laboratorium')->first();
        $multimedia = Kategori::where('nama_kategori', 'Multimedia')->first();

        $barangs = [
            ['kode_barang' => 'ELK-001', 'nama_barang' => 'Laptop Lenovo ThinkPad', 'kategori_id' => $elektronik?->id, 'stok' => 10, 'kondisi' => 'baik', 'deskripsi' => 'Laptop untuk presentasi dan administrasi.'],
            ['kode_barang' => 'ELK-002', 'nama_barang' => 'Proyektor Epson EB-X06', 'kategori_id' => $elektronik?->id, 'stok' => 5, 'kondisi' => 'baik', 'deskripsi' => 'Proyektor ruang kelas.'],
            ['kode_barang' => 'ELK-003', 'nama_barang' => 'Speaker Portable JBL', 'kategori_id' => $elektronik?->id, 'stok' => 8, 'kondisi' => 'baik', 'deskripsi' => 'Speaker untuk acara sekolah.'],
            ['kode_barang' => 'OLG-001', 'nama_barang' => 'Bola Basket', 'kategori_id' => $olahraga?->id, 'stok' => 15, 'kondisi' => 'baik', 'deskripsi' => 'Bola basket standar ukuran 7.'],
            ['kode_barang' => 'OLG-002', 'nama_barang' => 'Net Badminton', 'kategori_id' => $olahraga?->id, 'stok' => 6, 'kondisi' => 'baik', 'deskripsi' => 'Net badminton portable.'],
            ['kode_barang' => 'OLG-003', 'nama_barang' => 'Matras Senam', 'kategori_id' => $olahraga?->id, 'stok' => 20, 'kondisi' => 'baik', 'deskripsi' => 'Matras senam lipat.'],
            ['kode_barang' => 'LAB-001', 'nama_barang' => 'Mikroskop Binokuler', 'kategori_id' => $lab?->id, 'stok' => 12, 'kondisi' => 'baik', 'deskripsi' => 'Mikroskop untuk praktikum biologi.'],
            ['kode_barang' => 'LAB-002', 'nama_barang' => 'Kit Kimia Dasar', 'kategori_id' => $lab?->id, 'stok' => 4, 'kondisi' => 'baik', 'deskripsi' => 'Perlengkapan praktikum kimia dasar.'],
            ['kode_barang' => 'MUL-001', 'nama_barang' => 'Kamera DSLR Canon', 'kategori_id' => $multimedia?->id, 'stok' => 3, 'kondisi' => 'baik', 'deskripsi' => 'Kamera dokumentasi kegiatan sekolah.'],
            ['kode_barang' => 'MUL-002', 'nama_barang' => 'Tripod Kamera', 'kategori_id' => $multimedia?->id, 'stok' => 5, 'kondisi' => 'baik', 'deskripsi' => 'Tripod aluminium adjustable.'],
        ];

        foreach ($barangs as $barang) {
            if ($barang['kategori_id']) {
                Barang::updateOrCreate(
                    ['kode_barang' => $barang['kode_barang']],
                    $barang
                );
            }
        }
    }
}
