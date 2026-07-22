<?php

namespace App\Models;

use App\Enums\KondisiBarang;
use Database\Factories\BarangFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'kode_barang',
    'nama_barang',
    'kategori_id',
    'stok',
    'kondisi',
    'foto',
    'deskripsi',
])]
class Barang extends Model
{
    /** @use HasFactory<BarangFactory> */
    use HasFactory;

    protected function casts(): array
    {
        return [
            'kondisi' => KondisiBarang::class,
            'stok' => 'integer',
        ];
    }

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class);
    }

    public function detailPeminjamans(): HasMany
    {
        return $this->hasMany(DetailPeminjaman::class);
    }

    public function isTersedia(): bool
    {
        return $this->stok > 0 && $this->kondisi === KondisiBarang::Baik;
    }

    public function fotoUrl(): string
    {
        if ($this->foto && file_exists(public_path('storage/'.$this->foto))) {
            return asset('storage/'.$this->foto);
        }

        return asset('assets/barang-default.svg');
    }
}
