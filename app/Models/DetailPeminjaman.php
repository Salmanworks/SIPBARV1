<?php

namespace App\Models;

use App\Enums\KondisiBarang;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'peminjaman_id',
    'barang_id',
    'jumlah',
    'kondisi_saat_kembali',
])]
class DetailPeminjaman extends Model
{
    protected $table = 'detail_peminjamans';

    protected function casts(): array
    {
        return [
            'jumlah' => 'integer',
            'kondisi_saat_kembali' => KondisiBarang::class,
        ];
    }

    public function peminjaman(): BelongsTo
    {
        return $this->belongsTo(Peminjaman::class);
    }

    public function barang(): BelongsTo
    {
        return $this->belongsTo(Barang::class);
    }
}
