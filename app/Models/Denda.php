<?php

namespace App\Models;

use App\Enums\DendaStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

class Denda extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $table = 'dendas';

    protected $fillable = [
        'peminjaman_id',
        'jumlah_hari_telat',
        'nominal_denda',
        'status_bayar',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['jumlah_hari_telat', 'nominal_denda', 'status_bayar'])
            ->logOnlyDirty()
            ->dontLogEmptyChanges()
            ->useLogName('denda');
    }

    protected function casts(): array
    {
        return [
            'jumlah_hari_telat' => 'integer',
            'nominal_denda' => 'decimal:2',
            'status_bayar' => DendaStatus::class,
        ];
    }

    /**
     * Relasi ke transaksi peminjaman yang menghasilkan denda ini.
     */
    public function peminjaman(): BelongsTo
    {
        return $this->belongsTo(Peminjaman::class);
    }
}
