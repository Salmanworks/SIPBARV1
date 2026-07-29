<?php

namespace App\Models;

use App\Enums\PeminjamanStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

class Peminjaman extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $table = 'peminjamans';

    protected $fillable = [
        'user_id',
        'tanggal_pinjam',
        'tanggal_kembali_rencana',
        'tanggal_kembali_aktual',
        'status',
        'keperluan',
        'catatan_admin',
        'disetujui_oleh',
        'qr_code',
        'qr_token',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['tanggal_pinjam', 'tanggal_kembali_rencana', 'tanggal_kembali_aktual', 'status', 'keperluan', 'disetujui_oleh', 'catatan_admin'])
            ->logOnlyDirty()
            ->dontLogEmptyChanges()
            ->useLogName('peminjaman')
            ->setDescriptionForEvent(function (string $eventName) {
                $status = $this->status instanceof \BackedEnum ? $this->status->label() : (string) $this->status;

                return match ($eventName) {
                    'created' => "Membuat pengajuan peminjaman baru dengan status {$status} oleh :subject.user.name",
                    'updated' => "Memperbarui peminjaman ID :subject.id. Status menjadi: {$status}",
                    'deleted' => 'Menghapus peminjaman ID :subject.id',
                    'restored' => 'Mengembalikan peminjaman ID :subject.id',
                    default => "Peminjaman di-{$eventName}",
                };
            });
    }

    protected function casts(): array
    {
        return [
            'tanggal_pinjam' => 'date',
            'tanggal_kembali_rencana' => 'date',
            'tanggal_kembali_aktual' => 'date',
            'status' => PeminjamanStatus::class,
        ];
    }

    /**
     * Relasi ke pengguna yang mengajukan peminjaman.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke pengguna yang menyetujui transaksi peminjaman.
     */
    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'disetujui_oleh');
    }

    /**
     * Relasi ke seluruh item barang yang tercatat pada transaksi ini.
     */
    public function details(): HasMany
    {
        return $this->hasMany(DetailPeminjaman::class);
    }

    /**
     * Relasi ke data denda yang timbul dari transaksi ini.
     */
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
