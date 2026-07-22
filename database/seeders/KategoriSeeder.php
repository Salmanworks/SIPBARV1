<?php

namespace Database\Seeders;

use App\Models\Kategori;
use Illuminate\Database\Seeder;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        $kategoris = [
            ['nama_kategori' => 'Elektronik', 'deskripsi' => 'Perangkat elektronik seperti laptop, proyektor, dan speaker.'],
            ['nama_kategori' => 'Olahraga', 'deskripsi' => 'Alat olahraga dan perlengkapan kegiatan fisik.'],
            ['nama_kategori' => 'Laboratorium', 'deskripsi' => 'Alat praktikum dan bahan laboratorium.'],
            ['nama_kategori' => 'Multimedia', 'deskripsi' => 'Kamera, tripod, dan peralatan dokumentasi.'],
            ['nama_kategori' => 'Kantor', 'deskripsi' => 'Perlengkapan administrasi dan kantor.'],
        ];

        foreach ($kategoris as $kategori) {
            Kategori::updateOrCreate(
                ['nama_kategori' => $kategori['nama_kategori']],
                $kategori
            );
        }
    }
}
