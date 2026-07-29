<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Menambahkan kolom `lokasi` (Lokasi Rak/Lemari) dan `status` (Status Ketersediaan)
     * ke tabel `barangs` sesuai spesifikasi BRIEF SIPBAR Master Barang.
     */
    public function up(): void
    {
        Schema::table('barangs', function (Blueprint $table) {
            $table->string('lokasi', 150)->nullable()->after('deskripsi')
                ->comment('Lokasi fisik barang, contoh: Lemari A Rak 2');

            $table->string('status', 20)->default('tersedia')->after('lokasi')
                ->comment('Status ketersediaan: tersedia, dipinjam, perbaikan');

            $table->index(['status', 'kategori_id']);
        });
    }

    public function down(): void
    {
        Schema::table('barangs', function (Blueprint $table) {
            $table->dropIndex(['status', 'kategori_id']);
            $table->dropColumn(['lokasi', 'status']);
        });
    }
};
