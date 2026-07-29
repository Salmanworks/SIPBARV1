<?php

namespace App\Models;

use App\Enums\DendaStatus;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

#[Fillable([
    'peminjaman_id',
    'jumlah_hari_telat',
    'nominal_denda',
    'status_bayar',
])]
class Denda extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['jumlah_hari_telat', 'nominal_denda', 'status_bayar'])
            ->logOnlyDirty()
            ->dontLogEmptyChanges()
            ->useLogName('denda');
    }
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
