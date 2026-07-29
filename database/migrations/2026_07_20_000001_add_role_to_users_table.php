<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Menambahkan peran pengguna untuk membedakan admin, guru, dan siswa.
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('siswa')->after('password');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role']);
        });
    }
};
