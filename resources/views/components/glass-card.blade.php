@props([
    'variant' => 'default', // default, light, medium, heavy
    'hover' => true,
    'shine' => false,
])

@php
    $baseClasses = 'rounded-2xl backdrop-blur-lg border shadow-glass transition-all duration-300';
    
    $variantClasses = [
        'default' => 'bg-white/10 border-white/20',
        'light' => 'bg-white/5 border-white/10',
        'medium' => 'bg-white/15 border-white/25',
        'heavy' => 'bg-white/20 border-white/30',
        'white' => 'bg-white border-slate-200',
    ];
    
    $hoverClasses = $hover ? 'hover:shadow-glass-lg hover:-translate-y-1' : '';
    $shineClasses = $shine ? 'card-shine' : '';
@endphp

<div {{ $attributes->merge(['class' => "$baseClasses {$variantClasses[$variant]} $hoverClasses $shineClasses"]) }}>
    {{ $slot }}
</div>
