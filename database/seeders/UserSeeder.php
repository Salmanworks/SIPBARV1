<?php

namespace Database\Seeders;

use App\Enums\KondisiBarang;
use App\Enums\PeminjamanStatus;
use App\Enums\UserRole;
use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@sipbar.sch.id'],
            [
                'name' => 'Administrator SIPBAR',
                'password' => Hash::make('password'),
                'role' => UserRole::Admin,
                'no_induk' => 'ADM001',
                'email_verified_at' => now(),
            ]
        );

        User::updateOrCreate(
            ['email' => 'petugas@sipbar.sch.id'],
            [
                'name' => 'Budi Santoso',
                'password' => Hash::make('password'),
                'role' => UserRole::Petugas,
                'no_induk' => 'PTG001',
                'email_verified_at' => now(),
            ]
        );

        User::updateOrCreate(
            ['email' => 'guru@sipbar.sch.id'],
            [
                'name' => 'Siti Rahayu',
                'password' => Hash::make('password'),
                'role' => UserRole::Peminjam,
                'no_induk' => 'GRU001',
                'email_verified_at' => now(),
            ]
        );

        User::updateOrCreate(
            ['email' => 'siswa@sipbar.sch.id'],
            [
                'name' => 'Ahmad Fauzi',
                'password' => Hash::make('password'),
                'role' => UserRole::Peminjam,
                'no_induk' => 'SIS001',
                'email_verified_at' => now(),
            ]
        );
    }
}
