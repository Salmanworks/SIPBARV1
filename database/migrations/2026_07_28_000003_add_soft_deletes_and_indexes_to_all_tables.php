<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Menambahkan SoftDeletes + Index ke semua tabel master dan transaksi.
 *
 * SoftDeletes: Agar data yang dihapus tidak benar-benar hilang (restoreable).
 * Index:       Untuk optimasi query WHERE / ORDER BY pada kolom yang sering diakses.
 */
return new class extends Migration
{
    public function up(): void
    {
        // ========== TABEL USERS ==========
        Schema::table('users', function (Blueprint $table) {
            $table->softDeletes();
            $table->index(['role', 'deleted_at']);
            $table->index(['no_induk', 'deleted_at']);
        });

        // ========== TABEL GURUS ==========
        Schema::table('gurus', function (Blueprint $table) {
            $table->softDeletes();
            $table->index(['nip', 'deleted_at']);
            $table->index(['user_id', 'deleted_at']);
        });

        // ========== TABEL SISWAS ==========
        Schema::table('siswas', function (Blueprint $table) {
            $table->softDeletes();
            $table->index(['nis', 'deleted_at']);
            $table->index(['user_id', 'deleted_at']);
            $table->index(['kelas', 'jurusan', 'deleted_at']);
        });

        // ========== TABEL KATEGORIS ==========
        Schema::table('kategoris', function (Blueprint $table) {
            $table->softDeletes();
            $table->index(['nama_kategori', 'deleted_at']);
        });

        // ========== TABEL BARANGS ==========
        Schema::table('barangs', function (Blueprint $table) {
            $table->softDeletes();
            $table->index(['kode_barang', 'deleted_at']);
            $table->index(['kategori_id', 'deleted_at']);
            $table->index(['status', 'deleted_at']);
            $table->index(['kondisi', 'deleted_at']);
        });

        // ========== TABEL PEMINJAMANS ==========
        Schema::table('peminjamans', function (Blueprint $table) {
            $table->softDeletes();
            $table->index(['user_id', 'deleted_at']);
            $table->index(['status', 'deleted_at']);
            $table->index(['tanggal_pinjam', 'deleted_at']);
            $table->index(['tanggal_kembali_rencana', 'deleted_at']);
            $table->index(['disetujui_oleh', 'deleted_at']);
            $table->index(['qr_token', 'deleted_at']);
            // Composite index untuk query dashboard "pinjaman aktif user"
            $table->index(['user_id', 'status', 'deleted_at']);
        });

        // ========== TABEL DETAIL_PEMINJAMANS ==========
        Schema::table('detail_peminjamans', function (Blueprint $table) {
            $table->softDeletes();
            $table->index(['peminjaman_id', 'deleted_at']);
            $table->index(['barang_id', 'deleted_at']);
        });

        // ========== TABEL DENDAS ==========
        Schema::table('dendas', function (Blueprint $table) {
            $table->softDeletes();
            $table->index(['peminjaman_id', 'deleted_at']);
            $table->index(['status_bayar', 'deleted_at']);
        });
    }

    public function down(): void
    {
        $tables = [
            'dendas',
            'detail_peminjamans',
            'peminjamans',
            'barangs',
            'kategoris',
            'siswas',
            'gurus',
            'users',
        ];

        foreach ($tables as $tbl) {
            Schema::table($tbl, function (Blueprint $table) use ($tbl) {
                $table->dropSoftDeletes();
            });
        }
    }
};
