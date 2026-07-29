<?php

namespace App\Models;

use App\Enums\KondisiBarang;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

class DetailPeminjaman extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $table = 'detail_peminjamans';

    protected $fillable = [
        'peminjaman_id',
        'barang_id',
        'jumlah',
        'kondisi_saat_kembali',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['barang_id', 'jumlah', 'kondisi_saat_kembali'])
            ->logOnlyDirty()
            ->dontLogEmptyChanges()
            ->useLogName('detail_peminjaman');
    }

    protected function casts(): array
    {
        return [
            'jumlah' => 'integer',
            'kondisi_saat_kembali' => KondisiBarang::class,
        ];
    }

    /**
     * Relasi ke transaksi peminjaman induk dari detail item ini.
     */
    public function peminjaman(): BelongsTo
    {
        return $this->belongsTo(Peminjaman::class);
    }

    /**
     * Relasi ke barang yang dipinjam pada baris detail ini.
     */
    public function barang(): BelongsTo
    {
        return $this->belongsTo(Barang::class);
    }
}
