@props(['status'])

@php
    $enum = $status instanceof \App\Enums\PeminjamanStatus
        ? $status
        : \App\Enums\PeminjamanStatus::from($status);
@endphp

<flux:badge :color="$enum->color()" size="sm">{{ $enum->label() }}</flux:badge>
