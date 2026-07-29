<?php

namespace App\Models;

use App\Enums\KondisiBarang;
use App\Enums\StatusBarang;
use Database\Factories\BarangFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

class Barang extends Model
{
    /** @use HasFactory<BarangFactory> */
    use HasFactory, SoftDeletes, LogsActivity;

    protected $table = 'barangs';

    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'kategori_id',
        'stok',
        'kondisi',
        'foto',
        'deskripsi',
        'lokasi',
        'status',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['kode_barang', 'nama_barang', 'kategori_id', 'stok', 'kondisi', 'lokasi', 'status', 'deskripsi'])
            ->logOnlyDirty()
            ->dontLogEmptyChanges()
            ->useLogName('barang')
            ->setDescriptionForEvent(fn (string $eventName) => match ($eventName) {
                'created' => 'Menambahkan barang baru :subject.nama_barang (Kode: :subject.kode_barang)',
                'updated' => 'Memperbarui data barang :subject.nama_barang',
                'deleted' => 'Menghapus barang :subject.nama_barang',
                'restored' => 'Mengembalikan barang :subject.nama_barang dari tempat sampah',
                default => "Barang di-{$eventName}",
            });
    }

    protected function casts(): array
    {
        return [
            'kondisi' => KondisiBarang::class,
            'status'  => StatusBarang::class,
            'stok' => 'integer',
        ];
    }

    /**
     * Relasi ke kategori tempat barang ini dikelompokkan.
     */
    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class);
    }

    /**
     * Relasi ke detail peminjaman yang memakai barang ini.
     */
    public function detailPeminjamans(): HasMany
    {
        return $this->hasMany(DetailPeminjaman::class);
    }

    /**
     * Menentukan apakah barang tersedia untuk diajukan peminjaman:
     * - stok > 0
     * - kondisi = Baik
     * - status = Tersedia
     */
    public function isTersedia(): bool
    {
        return $this->stok > 0
            && $this->kondisi === KondisiBarang::Baik
            && $this->status === StatusBarang::Tersedia;
    }

    public function fotoUrl(): string
    {
        if ($this->foto && file_exists(public_path('storage/'.$this->foto))) {
            return asset('storage/'.$this->foto);
        }

        return asset('assets/barang-default.svg');
    }
}
