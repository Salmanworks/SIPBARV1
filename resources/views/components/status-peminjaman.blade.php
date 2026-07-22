@props(['status'])

@php
use App\Enums\PeminjamanStatus;

// Map status ke style
$statusConfig = match($status) {
    PeminjamanStatus::Diajukan => [
        'class' => 'bg-amber-100 text-amber-700 border-amber-200',
        'icon' => 'clock',
        'label' => 'Diajukan'
    ],
    PeminjamanStatus::Disetujui => [
        'class' => 'bg-blue-100 text-blue-700 border-blue-200',
        'icon' => 'check-circle',
        'label' => 'Disetujui'
    ],
    PeminjamanStatus::Ditolak => [
        'class' => 'bg-rose-100 text-rose-700 border-rose-200',
        'icon' => 'x-circle',
        'label' => 'Ditolak'
    ],
    PeminjamanStatus::Dipinjam => [
        'class' => 'bg-purple-100 text-purple-700 border-purple-200',
        'icon' => 'refresh',
        'label' => 'Dipinjam'
    ],
    PeminjamanStatus::Dikembalikan => [
        'class' => 'bg-emerald-100 text-emerald-700 border-emerald-200',
        'icon' => 'check-circle',
        'label' => 'Dikembalikan'
    ],
    PeminjamanStatus::Terlambat => [
        'class' => 'bg-red-100 text-red-700 border-red-200',
        'icon' => 'exclamation-triangle',
        'label' => 'Terlambat'
    ],
    default => [
        'class' => 'bg-slate-100 text-slate-700 border-slate-200',
        'icon' => 'sparkles',
        'label' => 'Unknown'
    ]
};
@endphp

<span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold border {{ $statusConfig['class'] }}">
    <x-icon :name="$statusConfig['icon']" size="xs" />
    <span>{{ $statusConfig['label'] }}</span>
</span>
