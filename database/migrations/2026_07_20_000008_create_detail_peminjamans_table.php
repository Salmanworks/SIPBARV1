<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabel detail transaksi untuk menyimpan daftar barang pada setiap peminjaman.
        Schema::create('detail_peminjamans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('peminjaman_id')->constrained(table: 'peminjamans')->cascadeOnDelete();
            $table->foreignId('barang_id')->constrained(table: 'barangs')->cascadeOnDelete();
            $table->unsignedInteger('jumlah');
            $table->string('kondisi_saat_kembali')->nullable();
            $table->timestamps();

            $table->unique(['peminjaman_id', 'barang_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_peminjamans');
    }
};
