<?php

namespace App\Enums;

enum UserRole: string
{
    case Admin = 'admin';
    case Guru = 'guru';
    case Siswa = 'siswa';

    public function label(): string
    {
        return match ($this) {
            self::Admin => 'Administrator',
            self::Guru => 'Guru',
            self::Siswa => 'Siswa',
        };
    }

    public function loginField(): string
    {
        return match ($this) {
            self::Admin => 'email',
            self::Guru => 'no_induk',
            self::Siswa => 'no_induk',
        };
    }
}
