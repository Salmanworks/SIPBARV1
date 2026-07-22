@props([
    'title' => '',
    'value' => '',
    'icon' => 'cube', // heroicon name
    'trend' => null, // 'up', 'down', null
    'trendValue' => '',
    'description' => '',
    'gradient' => 'blue', // blue, purple, emerald, rose
])

@php
    $gradientClasses = [
        'blue' => 'from-blue-500 to-blue-600',
        'purple' => 'from-purple-500 to-purple-600',
        'emerald' => 'from-emerald-500 to-emerald-600',
        'rose' => 'from-rose-500 to-rose-600',
        'amber' => 'from-amber-500 to-amber-600',
        'cyan' => 'from-cyan-500 to-cyan-600',
        'indigo' => 'from-indigo-500 to-indigo-600',
    ];
    
    $glowClasses = [
        'blue' => 'shadow-blue-500/50',
        'purple' => 'shadow-purple-500/50',
        'emerald' => 'shadow-emerald-500/50',
        'rose' => 'shadow-rose-500/50',
        'amber' => 'shadow-amber-500/50',
        'cyan' => 'shadow-cyan-500/50',
        'indigo' => 'shadow-indigo-500/50',
    ];
@endphp

<div {{ $attributes->merge(['class' => 'glass-card hover-scale group']) }}>
    <div class="flex items-start justify-between">
        <div class="flex-1">
            <p class="text-sm font-medium text-slate-600 dark:text-slate-400 mb-2 uppercase tracking-wide">{{ $title }}</p>
            <p class="text-4xl font-bold text-slate-900 dark:text-white mb-1">{{ $value }}</p>
            
            @if($trend)
                <div class="mt-3 flex items-center gap-2 text-sm">
                    @if($trend === 'up')
                        <div class="flex items-center gap-1 px-2 py-1 bg-emerald-100 text-emerald-700 rounded-full">
                            <x-icon name="arrow-trending-up" size="sm" />
                            <span class="font-semibold">{{ $trendValue }}</span>
                        </div>
                    @else
                        <div class="flex items-center gap-1 px-2 py-1 bg-rose-100 text-rose-700 rounded-full">
                            <x-icon name="arrow-trending-down" size="sm" />
                            <span class="font-semibold">{{ $trendValue }}</span>
                        </div>
                    @endif
                    @if($description)
                        <span class="text-slate-500 text-xs">{{ $description }}</span>
                    @endif
                </div>
            @endif
        </div>
        
        <div class="flex-shrink-0">
            <div class="flex items-center justify-center w-16 h-16 rounded-2xl bg-gradient-to-br {{ $gradientClasses[$gradient] }} shadow-xl {{ $glowClasses[$gradient] }} group-hover:scale-110 transition-all duration-300">
                <x-icon :name="$icon" size="xl" class="text-white" />
            </div>
        </div>
    </div>
    
    {{-- Bottom Progress Bar (Optional) --}}
    <div class="mt-4 h-1 w-full bg-slate-200 rounded-full overflow-hidden">
        <div class="h-full bg-gradient-to-r {{ $gradientClasses[$gradient] }} rounded-full" style="width: {{ rand(40, 95) }}%"></div>
    </div>
</div>
