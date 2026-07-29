<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\AdminProfile;
use App\Models\Guru;
use App\Models\GuruProfile;
use App\Models\Siswa;
use App\Models\SiswaProfile;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun Admin
        $admin = User::updateOrCreate(
            ['email' => 'admin@sipbar.sch.id'],
            [
                'name' => 'Administrator SIPBAR',
                'password' => Hash::make('password'),
                'role' => UserRole::Admin,
                'email_verified_at' => now(),
            ]
        );

        AdminProfile::updateOrCreate(
            ['user_id' => $admin->id],
            [
                'id_admin' => 'ADM001',
                'jabatan' => 'Administrator Utama',
            ]
        );

        // 2. Akun Guru
        $guru = User::updateOrCreate(
            ['email' => 'guru@sipbar.sch.id'],
            [
                'name' => 'Siti Rahayu',
                'password' => Hash::make('password'),
                'role' => UserRole::Guru,
                'email_verified_at' => now(),
            ]
        );

        GuruProfile::updateOrCreate(
            ['user_id' => $guru->id],
            [
                'nip' => 'GRU001',
                'mapel' => 'Pemrograman Web',
            ]
        );

        Guru::updateOrCreate(
            ['user_id' => $guru->id],
            [
                'nip' => 'GRU001',
                'nama_lengkap' => 'Siti Rahayu',
                'jabatan' => 'Guru Pemrograman',
            ]
        );

        // 3. Akun Siswa
        $siswa = User::updateOrCreate(
            ['email' => 'siswa@sipbar.sch.id'],
            [
                'name' => 'Ahmad Fauzi',
                'password' => Hash::make('password'),
                'role' => UserRole::Siswa,
                'email_verified_at' => now(),
            ]
        );

        SiswaProfile::updateOrCreate(
            ['user_id' => $siswa->id],
            [
                'nis' => 'SIS001',
                'kelas' => 'XII RPL 1',
                'jurusan' => 'Rekayasa Perangkat Lunak',
            ]
        );

        Siswa::updateOrCreate(
            ['user_id' => $siswa->id],
            [
                'nis' => 'SIS001',
                'nama_lengkap' => 'Ahmad Fauzi',
                'kelas' => 'XII RPL 1',
                'jurusan' => 'Rekayasa Perangkat Lunak',
            ]
        );
    }
}
