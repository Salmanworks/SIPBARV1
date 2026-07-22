@props([
    'icon' => 'cube', // heroicon name
    'title' => 'Tidak ada data',
    'description' => 'Belum ada data yang tersedia.',
    'actionText' => null,
    'actionUrl' => null,
    'gradient' => 'blue', // blue, purple, emerald, rose
])

@php
    $gradientClasses = [
        'blue' => 'from-blue-500 to-blue-600',
        'purple' => 'from-purple-500 to-purple-600',
        'emerald' => 'from-emerald-500 to-emerald-600',
        'rose' => 'from-rose-500 to-rose-600',
        'amber' => 'from-amber-500 to-amber-600',
    ];
@endphp

<div {{ $attributes->merge(['class' => 'text-center py-16 px-4']) }}>
    {{-- Icon Container --}}
    <div class="relative inline-block mb-6">
        {{-- Glow Effect --}}
        <div class="absolute inset-0 bg-gradient-to-br {{ $gradientClasses[$gradient] }} rounded-full opacity-20 blur-2xl animate-pulse-soft"></div>
        
        {{-- Icon --}}
        <div class="relative inline-flex items-center justify-center w-24 h-24 rounded-full bg-gradient-to-br {{ $gradientClasses[$gradient] }} shadow-2xl">
            <x-icon :name="$icon" size="3xl" class="text-white" />
        </div>
    </div>
    
    <h3 class="text-2xl font-bold text-slate-900 mb-3">{{ $title }}</h3>
    <p class="text-slate-600 max-w-md mx-auto mb-8 text-lg">{{ $description }}</p>
    
    @if($actionText && $actionUrl)
        <a href="{{ $actionUrl }}" class="btn-glow inline-flex items-center gap-2 group">
            <x-icon name="plus" size="md" />
            <span>{{ $actionText }}</span>
            <x-icon name="arrow-right" size="sm" class="transition-transform group-hover:translate-x-1" />
        </a>
    @endif
    
    {{ $slot }}
</div>
