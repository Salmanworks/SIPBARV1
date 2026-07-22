<?php

namespace App\Enums;

enum PeminjamanStatus: string
{
    case Diajukan = 'diajukan';
    case Disetujui = 'disetujui';
    case Ditolak = 'ditolak';
    case Dipinjam = 'dipinjam';
    case Dikembalikan = 'dikembalikan';
    case Terlambat = 'terlambat';

    public function label(): string
    {
        return match ($this) {
            self::Diajukan => 'Diajukan',
            self::Disetujui => 'Disetujui',
            self::Ditolak => 'Ditolak',
            self::Dipinjam => 'Dipinjam',
            self::Dikembalikan => 'Dikembalikan',
            self::Terlambat => 'Terlambat',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Diajukan => 'amber',
            self::Disetujui => 'green',
            self::Ditolak => 'red',
            self::Dipinjam => 'blue',
            self::Dikembalikan => 'zinc',
            self::Terlambat => 'orange',
        };
    }
}
