<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GuruProfile extends Model
{
    use HasFactory;

    protected $table = 'guru_profiles';

    protected $fillable = [
        'user_id',
        'nip',
        'mapel',
    ];

    /**
     * Relasi ke akun pengguna yang memiliki profil guru ini.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
