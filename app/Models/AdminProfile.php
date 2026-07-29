<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdminProfile extends Model
{
    use HasFactory;

    protected $table = 'admin_profiles';

    protected $fillable = [
        'user_id',
        'id_admin',
        'jabatan',
    ];

    /**
     * Relasi ke akun pengguna yang memiliki profil admin ini.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
