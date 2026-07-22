@props([
    'status' => 'info', // success, warning, danger, info, purple
    'pulse' => false,
    'icon' => null, // heroicon name
    'size' => 'md', // sm, md, lg
])

@php
    $statusClasses = [
        'success' => 'badge-success',
        'warning' => 'badge-warning',
        'danger' => 'badge-danger',
        'info' => 'badge-info',
        'purple' => 'badge-purple',
    ];
    
    $statusIcons = [
        'success' => 'check-circle',
        'warning' => 'exclamation-triangle',
        'danger' => 'x-circle',
        'info' => 'sparkles',
        'purple' => 'star',
    ];
    
    $sizeClasses = [
        'sm' => 'text-xs px-2 py-0.5',
        'md' => 'text-sm px-3 py-1.5',
        'lg' => 'text-base px-4 py-2',
    ];
    
    $iconSizes = [
        'sm' => 'xs',
        'md' => 'sm',
        'lg' => 'md',
    ];
@endphp

<span {{ $attributes->merge(['class' => "badge-glass {$statusClasses[$status]} {$sizeClasses[$size]}"]) }}>
    @if($pulse)
        <span class="pulse-dot"></span>
    @endif
    
    @if($icon)
        <x-icon :name="$icon" :size="$iconSizes[$size]" />
    @elseif(isset($statusIcons[$status]))
        <x-icon :name="$statusIcons[$status]" :size="$iconSizes[$size]" />
    @endif
    
    <span class="font-medium">{{ $slot }}</span>
</span>
