<?php

namespace App\Models;

use App\Enums\PeminjamanStatus;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

#[Fillable([
    'user_id',
    'tanggal_pinjam',
    'tanggal_kembali_rencana',
    'tanggal_kembali_aktual',
    'status',
    'keperluan',
    'catatan_admin',
    'disetujui_oleh',
    'qr_code',
])]
class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjamans';

    protected function casts(): array
    {
        return [
            'tanggal_pinjam' => 'date',
            'tanggal_kembali_rencana' => 'date',
            'tanggal_kembali_aktual' => 'date',
            'status' => PeminjamanStatus::class,
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'disetujui_oleh');
    }

    public function details(): HasMany
    {
        return $this->hasMany(DetailPeminjaman::class);
    }

    public function denda(): HasOne
    {
        return $this->hasOne(Denda::class);
    }

    public function isOverdue(): bool
    {
        if (in_array($this->status, [PeminjamanStatus::Dikembalikan, PeminjamanStatus::Ditolak], true)) {
            return false;
        }

        return Carbon::parse($this->tanggal_kembali_rencana)->isPast();
    }

    public function syncOverdueStatus(): void
    {
        if ($this->isOverdue() && in_array($this->status, [PeminjamanStatus::Disetujui, PeminjamanStatus::Dipinjam], true)) {
            $this->update(['status' => PeminjamanStatus::Terlambat]);
        }
    }
}
