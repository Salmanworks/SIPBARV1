<?php

namespace App\Models;

use App\Enums\DendaStatus;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'peminjaman_id',
    'jumlah_hari_telat',
    'nominal_denda',
    'status_bayar',
])]
class Denda extends Model
{
    protected $table = 'dendas';

    protected function casts(): array
    {
        return [
            'jumlah_hari_telat' => 'integer',
            'nominal_denda' => 'decimal:2',
            'status_bayar' => DendaStatus::class,
        ];
    }

    public function peminjaman(): BelongsTo
    {
        return $this->belongsTo(Peminjaman::class);
    }
}
