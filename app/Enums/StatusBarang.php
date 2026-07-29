<?php

namespace App\Enums;

enum StatusBarang: string
{
    case Tersedia = 'tersedia';
    case Dipinjam = 'dipinjam';
    case Perbaikan = 'perbaikan';

    public function label(): string
    {
        return match ($this) {
            self::Tersedia => 'Tersedia',
            self::Dipinjam => 'Dipinjam',
            self::Perbaikan => 'Dalam Perbaikan',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Tersedia => 'success',
            self::Dipinjam => 'warning',
            self::Perbaikan => 'danger',
        };
    }
}
