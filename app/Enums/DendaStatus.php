<?php

namespace App\Enums;

enum DendaStatus: string
{
    case BelumBayar = 'belum_bayar';
    case Lunas = 'lunas';

    public function label(): string
    {
        return match ($this) {
            self::BelumBayar => 'Belum Bayar',
            self::Lunas => 'Lunas',
        };
    }
}
