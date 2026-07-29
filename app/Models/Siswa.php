<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

class Siswa extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $table = 'siswas';

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['nis', 'nama_lengkap', 'kelas', 'jurusan', 'no_hp', 'user_id'])
            ->logOnlyDirty()
            ->dontLogEmptyChanges()
            ->useLogName('siswa')
            ->setDescriptionForEvent(fn (string $eventName) => match ($eventName) {
                'created' => 'Menambahkan siswa baru :subject.nama_lengkap (NIS: :subject.nis)',
                'updated' => 'Memperbarui data siswa :subject.nama_lengkap',
                'deleted' => 'Menghapus siswa :subject.nama_lengkap',
                'restored' => 'Mengembalikan siswa :subject.nama_lengkap dari tempat sampah',
                default => "Siswa di-{$eventName}",
            });
    }

    protected $fillable = [
        'user_id',
        'nis',
        'nama_lengkap',
        'kelas',
        'jurusan',
        'no_hp',
        'foto',
    ];

    /**
     * Relasi ke akun pengguna yang menjadi induk data siswa ini.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
