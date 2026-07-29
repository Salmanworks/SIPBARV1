<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\UserRole;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Laravel\Fortify\Contracts\PasskeyUser;
use Laravel\Fortify\PasskeyAuthenticatable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Spatie\Activitylog\Models\Concerns\CausesActivity;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property UserRole $role
 * @property bool $first_login
 * @property string|null $no_hp
 * @property string|null $two_factor_secret
 * @property string|null $two_factor_recovery_codes
 * @property Carbon|null $two_factor_confirmed_at
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read string|null $identitas
 */
class User extends Authenticatable implements PasskeyUser
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, PasskeyAuthenticatable, TwoFactorAuthenticatable, SoftDeletes, CausesActivity, LogsActivity;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'first_login',
        'no_hp',
    ];

    protected $hidden = [
        'password',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'remember_token',
    ];

    protected $appends = [
        'identitas',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'email', 'role', 'first_login', 'no_hp'])
            ->logOnlyDirty()
            ->dontLogEmptyChanges()
            ->useLogName('user')
            ->setDescriptionForEvent(fn (string $eventName) => match ($eventName) {
                'created' => 'Membuat user baru dengan nama :subject.name',
                'updated' => 'Memperbarui data user :subject.name',
                'deleted' => 'Menghapus user :subject.name',
                'restored' => 'Mengembalikan user :subject.name dari tempat sampah',
                default => "User di-{$eventName}",
            });
    }

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'two_factor_confirmed_at' => 'datetime',
            'password' => 'hashed',
            'role' => UserRole::class,
            'first_login' => 'boolean',
        ];
    }

    /**
     * Relasi ke seluruh transaksi peminjaman yang diajukan oleh pengguna.
     */
    public function peminjamans(): HasMany
    {
        return $this->hasMany(Peminjaman::class);
    }

    /**
     * Relasi ke profil guru yang dimiliki oleh pengguna ini.
     */
    public function guru(): HasOne
    {
        return $this->hasOne(Guru::class);
    }

    /**
     * Relasi ke profil siswa yang dimiliki oleh pengguna ini.
     */
    public function siswa(): HasOne
    {
        return $this->hasOne(Siswa::class);
    }

    /**
     * Relasi ke profil siswa baru yang menyimpan NIS, kelas, dan jurusan.
     */
    public function siswaProfile(): HasOne
    {
        return $this->hasOne(SiswaProfile::class);
    }

    /**
     * Relasi ke profil guru baru yang menyimpan NIP dan mata pelajaran.
     */
    public function guruProfile(): HasOne
    {
        return $this->hasOne(GuruProfile::class);
    }

    /**
     * Relasi ke profil admin baru yang menyimpan ID admin dan jabatan.
     */
    public function adminProfile(): HasOne
    {
        return $this->hasOne(AdminProfile::class);
    }

    /**
     * Relasi ke transaksi peminjaman yang pernah disetujui oleh pengguna ini.
     */
    public function approvedPeminjamans(): HasMany
    {
        return $this->hasMany(Peminjaman::class, 'disetujui_oleh');
    }

    public function isAdmin(): bool
    {
        return $this->role === UserRole::Admin;
    }

    public function isGuru(): bool
    {
        return $this->role === UserRole::Guru;
    }

    public function isSiswa(): bool
    {
        return $this->role === UserRole::Siswa;
    }

    /**
     * Mengembalikan identitas utama pengguna berdasarkan role yang dimiliki.
     */
    public function getIdentitasAttribute(): ?string
    {
        if (! ($this->role instanceof UserRole)) {
            return null;
        }

        return match ($this->role) {
            UserRole::Siswa => $this->siswaProfile?->nis,
            UserRole::Guru => $this->guruProfile?->nip,
            UserRole::Admin => $this->adminProfile?->id_admin,
        };
    }

    public function loginField(): string
    {
        return $this->role->loginField();
    }

    public function initials(): string
    {
        $initials = Str::initials($this->name, true);

        return Str::length($initials) > 1
            ? Str::substr($initials, 0, 1).Str::substr($initials, -1)
            : $initials;
    }
}
