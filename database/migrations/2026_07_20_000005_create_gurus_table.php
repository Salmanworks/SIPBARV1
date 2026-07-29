<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabel profil guru yang terhubung ke akun pengguna bertipe guru.
        Schema::create('gurus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
            $table->string('nip', 30)->unique();
            $table->string('nama_lengkap');
            $table->string('jabatan')->nullable();
            $table->string('no_hp', 20)->nullable();
            $table->string('foto')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gurus');
    }
};
