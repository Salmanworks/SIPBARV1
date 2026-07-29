<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabel transaksi utama untuk mencatat pengajuan dan proses peminjaman barang.
        Schema::create('peminjamans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->date('tanggal_pinjam');
            $table->date('tanggal_kembali_rencana');
            $table->date('tanggal_kembali_aktual')->nullable();
            $table->string('status')->default('diajukan');
            $table->text('keperluan');
            $table->text('catatan_admin')->nullable();
            $table->foreignId('disetujui_oleh')->nullable()->constrained(table: 'users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peminjamans');
    }
};
