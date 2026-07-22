@props([
    'type' => 'card', // card, list, table, text
    'count' => 1,
])

@if($type === 'card')
    @for($i = 0; $i < $count; $i++)
    <div class="glass-card animate-pulse">
        <div class="h-48 bg-slate-200 rounded-xl mb-4"></div>
        <div class="h-4 bg-slate-200 rounded w-3/4 mb-2"></div>
        <div class="h-4 bg-slate-200 rounded w-1/2"></div>
    </div>
    @endfor
@elseif($type === 'list')
    @for($i = 0; $i < $count; $i++)
    <div class="flex items-center gap-4 p-4 mb-2 animate-pulse">
        <div class="w-12 h-12 bg-slate-200 rounded-full flex-shrink-0"></div>
        <div class="flex-1">
            <div class="h-4 bg-slate-200 rounded w-3/4 mb-2"></div>
            <div class="h-3 bg-slate-200 rounded w-1/2"></div>
        </div>
    </div>
    @endfor
@elseif($type === 'table')
    <div class="animate-pulse">
        @for($i = 0; $i < $count; $i++)
        <div class="grid grid-cols-4 gap-4 p-4 border-b border-slate-200">
            <div class="h-4 bg-slate-200 rounded"></div>
            <div class="h-4 bg-slate-200 rounded"></div>
            <div class="h-4 bg-slate-200 rounded"></div>
            <div class="h-4 bg-slate-200 rounded"></div>
        </div>
        @endfor
    </div>
@else
    <div class="animate-pulse space-y-2">
        @for($i = 0; $i < $count; $i++)
        <div class="h-4 bg-slate-200 rounded w-full"></div>
        @endfor
    </div>
@endif
