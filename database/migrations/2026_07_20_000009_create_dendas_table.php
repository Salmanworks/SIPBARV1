<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabel denda untuk mencatat keterlambatan dan status pembayaran peminjaman.
        Schema::create('dendas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('peminjaman_id')->unique()->constrained(table: 'peminjamans')->cascadeOnDelete();
            $table->unsignedInteger('jumlah_hari_telat');
            $table->decimal('nominal_denda', 12, 2);
            $table->string('status_bayar')->default('belum_bayar');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dendas');
    }
};
