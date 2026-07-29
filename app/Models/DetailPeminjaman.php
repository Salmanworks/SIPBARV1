<?php

namespace App\Models;

use App\Enums\KondisiBarang;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

#[Fillable([
    'peminjaman_id',
    'barang_id',
    'jumlah',
    'kondisi_saat_kembali',
])]
class DetailPeminjaman extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['barang_id', 'jumlah', 'kondisi_saat_kembali'])
            ->logOnlyDirty()
            ->dontLogEmptyChanges()
            ->useLogName('detail_peminjaman');
    }
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
