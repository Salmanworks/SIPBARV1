<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Menambahkan kolom `qr_token` untuk menyimpan random unique token
     * yang tertanam di QR Code (sesuai brief Secure QR Token).
     * Diperlukan saat scan:  app verify `qr_token` DB == hasil decode QR.
     */
    public function up(): void
    {
        Schema::table('peminjamans', function (Blueprint $table) {
            $table->string('qr_token', 100)->nullable()->unique()->after('qr_code')
                ->comment('Unique token tertanam di QR, untuk verifikasi saat scan');
        });
    }

    public function down(): void
    {
        Schema::table('peminjamans', function (Blueprint $table) {
            $table->dropUnique(['qr_token']);
            $table->dropColumn('qr_token');
        });
    }
};
