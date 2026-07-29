<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

#[Fillable(['nama_kategori', 'deskripsi'])]
class Kategori extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['nama_kategori', 'deskripsi'])
            ->logOnlyDirty()
            ->dontLogEmptyChanges()
            ->useLogName('kategori')
            ->setDescriptionForEvent(fn (string $eventName) => match ($eventName) {
                'created' => 'Menambahkan kategori barang baru :subject.nama_kategori',
                'updated' => 'Memperbarui kategori :subject.nama_kategori',
                'deleted' => 'Menghapus kategori :subject.nama_kategori',
                'restored' => 'Mengembalikan kategori :subject.nama_kategori',
                default => "Kategori di-{$eventName}",
            });
    }

    public function barangs(): HasMany
    {
        return $this->hasMany(Barang::class);
    }
}
