<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SiswaProfile extends Model
{
    use HasFactory;

    protected $table = 'siswa_profiles';

    protected $fillable = [
        'user_id',
        'nis',
        'kelas',
        'jurusan',
    ];

    /**
     * Relasi ke akun pengguna yang memiliki profil siswa ini.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
