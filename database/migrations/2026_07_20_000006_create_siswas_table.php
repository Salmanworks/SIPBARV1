<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabel profil siswa yang terhubung ke akun pengguna bertipe siswa.
        Schema::create('siswas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
            $table->string('nis', 20)->unique();
            $table->string('nama_lengkap');
            $table->string('kelas', 10)->nullable();
            $table->string('jurusan')->nullable();
            $table->string('no_hp', 20)->nullable();
            $table->string('foto')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('siswas');
    }
};
