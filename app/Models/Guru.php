<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

class Guru extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['nip', 'nama_lengkap', 'jabatan', 'no_hp', 'user_id'])
            ->logOnlyDirty()
            ->dontLogEmptyChanges()
            ->useLogName('guru')
            ->setDescriptionForEvent(fn (string $eventName) => match ($eventName) {
                'created' => 'Menambahkan guru baru :subject.nama_lengkap (NIP: :subject.nip)',
                'updated' => 'Memperbarui data guru :subject.nama_lengkap',
                'deleted' => 'Menghapus guru :subject.nama_lengkap',
                'restored' => 'Mengembalikan guru :subject.nama_lengkap dari tempat sampah',
                default => "Guru di-{$eventName}",
            });
    }

    protected $fillable = [
        'user_id',
        'nip',
        'nama_lengkap',
        'jabatan',
        'no_hp',
        'foto',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
