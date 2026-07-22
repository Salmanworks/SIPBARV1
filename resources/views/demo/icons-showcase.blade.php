@extends('layouts.guest')

@section('content')
<div class="min-h-screen bg-slate-50">
    {{-- Header --}}
    <div class="bg-gradient-mesh py-24 text-white">
        <div class="container mx-auto px-4">
            <div class="text-center animate-slide-up">
                <div class="inline-flex items-center gap-3 glass-light rounded-full px-6 py-3 mb-6">
                    <x-icon name="sparkles" size="md" class="text-yellow-300" />
                    <span class="font-semibold">Professional Icon System</span>
                </div>
                <h1 class="text-6xl font-bold mb-6 text-shadow-lg">
                    <x-icon name="star" size="3xl" class="inline-block float" />
                    Icon Showcase
                </h1>
                <p class="text-xl text-blue-100 max-w-2xl mx-auto">
                    30+ Heroicons terintegrasi dengan <span class="text-gradient-primary font-bold">SIPBAR Design System</span>
                </p>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-16 space-y-20">
        
        {{-- Size Variants --}}
        <section>
            <h2 class="text-4xl font-bold text-primary-900 mb-8 flex items-center gap-3">
                <x-icon name="sparkles" size="lg" class="text-purple-600" />
                Size Variants
            </h2>
            <div class="glass-card">
                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-7 gap-8">
                    @foreach(['xs', 'sm', 'md', 'lg', 'xl', '2xl', '3xl'] as $size)
                    <div class="text-center">
                        <div class="flex items-center justify-center h-24 mb-3">
                            <x-icon name="cube" :size="$size" class="text-blue-600" />
                        </div>
                        <p class="text-sm font-semibold text-slate-700">{{ $size }}</p>
                        <p class="text-xs text-slate-500">
                            {{ ['xs' => '12px', 'sm' => '16px', 'md' => '20px', 'lg' => '24px', 'xl' => '32px', '2xl' => '40px', '3xl' => '48px'][$size] }}
                        </p>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- All Icons Grid --}}
        <section>
            <h2 class="text-4xl font-bold text-primary-900 mb-8 flex items-center gap-3">
                <x-icon name="star" size="lg" class="text-amber-500" />
                All Available Icons
            </h2>
            
            @php
            $iconCategories = [
                'Business & Data' => [
                    ['name' => 'cube', 'label' => 'Cube', 'color' => 'blue'],
                    ['name' => 'chart-bar', 'label' => 'Chart Bar', 'color' => 'purple'],
                    ['name' => 'document-text', 'label' => 'Document', 'color' => 'emerald'],
                    ['name' => 'tag', 'label' => 'Tag', 'color' => 'rose'],
                ],
                'Users & People' => [
                    ['name' => 'users', 'label' => 'Users', 'color' => 'blue'],
                    ['name' => 'academic-cap', 'label' => 'Academic', 'color' => 'indigo'],
                ],
                'Time & Status' => [
                    ['name' => 'clock', 'label' => 'Clock', 'color' => 'blue'],
                    ['name' => 'calendar', 'label' => 'Calendar', 'color' => 'purple'],
                    ['name' => 'bell', 'label' => 'Bell', 'color' => 'amber'],
                ],
                'Actions & Status' => [
                    ['name' => 'check-circle', 'label' => 'Check', 'color' => 'emerald'],
                    ['name' => 'x-circle', 'label' => 'X Circle', 'color' => 'rose'],
                    ['name' => 'exclamation-triangle', 'label' => 'Warning', 'color' => 'amber'],
                    ['name' => 'shield-check', 'label' => 'Shield', 'color' => 'cyan'],
                ],
                'Navigation' => [
                    ['name' => 'arrow-right', 'label' => 'Arrow Right', 'color' => 'blue'],
                    ['name' => 'arrow-up', 'label' => 'Arrow Up', 'color' => 'purple'],
                    ['name' => 'arrow-trending-up', 'label' => 'Trending Up', 'color' => 'emerald'],
                    ['name' => 'arrow-trending-down', 'label' => 'Trending Down', 'color' => 'rose'],
                ],
                'Process & Actions' => [
                    ['name' => 'refresh', 'label' => 'Refresh', 'color' => 'blue'],
                    ['name' => 'sparkles', 'label' => 'Sparkles', 'color' => 'yellow'],
                    ['name' => 'fire', 'label' => 'Fire', 'color' => 'orange'],
                    ['name' => 'plus', 'label' => 'Plus', 'color' => 'emerald'],
                ],
                'Contact & Location' => [
                    ['name' => 'envelope', 'label' => 'Envelope', 'color' => 'blue'],
                    ['name' => 'phone', 'label' => 'Phone', 'color' => 'emerald'],
                    ['name' => 'map-pin', 'label' => 'Map Pin', 'color' => 'rose'],
                ],
                'Tools & Settings' => [
                    ['name' => 'magnifying-glass', 'label' => 'Search', 'color' => 'blue'],
                    ['name' => 'camera', 'label' => 'Camera', 'color' => 'purple'],
                    ['name' => 'cog', 'label' => 'Settings', 'color' => 'slate'],
                ],
                'Special' => [
                    ['name' => 'star', 'label' => 'Star', 'color' => 'yellow'],
                    ['name' => 'heart', 'label' => 'Heart', 'color' => 'rose'],
                ],
            ];
            @endphp

            @foreach($iconCategories as $category => $icons)
            <div class="mb-12">
                <h3 class="text-2xl font-bold text-slate-800 mb-6">{{ $category }}</h3>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    @foreach($icons as $icon)
                    <div class="glass-card hover-scale group text-center">
                        <div class="flex items-center justify-center h-20 mb-4">
                            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-{{ $icon['color'] }}-500 to-{{ $icon['color'] }}-600 flex items-center justify-center shadow-xl shadow-{{ $icon['color'] }}-500/50 group-hover:scale-110 transition-all">
                                <x-icon :name="$icon['name']" size="xl" class="text-white" />
                            </div>
                        </div>
                        <p class="font-semibold text-slate-900">{{ $icon['label'] }}</p>
                        <code class="text-xs text-slate-500 font-mono">{{ $icon['name'] }}</code>
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        </section>

        {{-- Variants --}}
        <section>
            <h2 class="text-4xl font-bold text-primary-900 mb-8 flex items-center gap-3">
                <x-icon name="sparkles" size="lg" class="text-purple-600" />
                Outline vs Solid
            </h2>
            <div class="grid md:grid-cols-2 gap-6">
                <div class="glass-card">
                    <h3 class="text-xl font-bold mb-6 flex items-center gap-2">
                        <x-icon name="check-circle" size="md" />
                        Outline (Default)
                    </h3>
                    <div class="grid grid-cols-4 gap-6">
                        @foreach(['check-circle', 'star', 'heart', 'bell'] as $icon)
                        <div class="text-center">
                            <x-icon :name="$icon" size="2xl" class="text-blue-600 mb-2" />
                            <p class="text-xs text-slate-600">{{ $icon }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>
                
                <div class="glass-card">
                    <h3 class="text-xl font-bold mb-6 flex items-center gap-2">
                        <x-icon name="check-circle" size="md" variant="solid" />
                        Solid
                    </h3>
                    <div class="grid grid-cols-4 gap-6">
                        @foreach(['check-circle', 'star', 'heart', 'bell'] as $icon)
                        <div class="text-center">
                            <x-icon :name="$icon" size="2xl" class="text-blue-600 mb-2" variant="solid" />
                            <p class="text-xs text-slate-600">{{ $icon }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>

        {{-- Color Examples --}}
        <section>
            <h2 class="text-4xl font-bold text-primary-900 mb-8 flex items-center gap-3">
                <x-icon name="sparkles" size="lg" class="text-rose-600" />
                Color Variants
            </h2>
            <div class="glass-card">
                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-6">
                    @foreach([
                        ['color' => 'emerald-500', 'label' => 'Success'],
                        ['color' => 'blue-500', 'label' => 'Info'],
                        ['color' => 'amber-500', 'label' => 'Warning'],
                        ['color' => 'rose-500', 'label' => 'Danger'],
                        ['color' => 'purple-500', 'label' => 'Purple'],
                        ['color' => 'slate-700', 'label' => 'Slate'],
                    ] as $colorVar)
                    <div class="text-center">
                        <x-icon name="check-circle" size="3xl" class="text-{{ $colorVar['color'] }} mb-2" variant="solid" />
                        <p class="text-sm font-semibold">{{ $colorVar['label'] }}</p>
                        <code class="text-xs text-slate-500">text-{{ $colorVar['color'] }}</code>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- Usage Examples --}}
        <section>
            <h2 class="text-4xl font-bold text-primary-900 mb-8 flex items-center gap-3">
                <x-icon name="document-text" size="lg" class="text-blue-600" />
                Usage Examples
            </h2>
            
            <div class="space-y-6">
                {{-- Buttons --}}
                <div class="glass-card">
                    <h3 class="text-xl font-bold mb-4">Buttons with Icons</h3>
                    <div class="flex flex-wrap gap-4">
                        <button class="btn-glow group">
                            <x-icon name="plus" size="md" />
                            <span>Add New</span>
                            <x-icon name="arrow-right" size="sm" class="transition-transform group-hover:translate-x-1" />
                        </button>
                        
                        <button class="glass-medium rounded-xl px-6 py-3 font-semibold hover:glass-heavy transition-all inline-flex items-center gap-2">
                            <x-icon name="magnifying-glass" size="md" />
                            <span>Search</span>
                        </button>
                        
                        <button class="glass-light rounded-xl px-6 py-3 font-semibold hover:glass-medium transition-all inline-flex items-center gap-2 border border-slate-300">
                            <x-icon name="cog" size="md" />
                            <span>Settings</span>
                        </button>
                    </div>
                </div>
                
                {{-- Status Badges --}}
                <div class="glass-card">
                    <h3 class="text-xl font-bold mb-4">Status Badges</h3>
                    <div class="flex flex-wrap gap-3">
                        <x-badge-status status="success">Available</x-badge-status>
                        <x-badge-status status="success" pulse>Live</x-badge-status>
                        <x-badge-status status="warning">Pending</x-badge-status>
                        <x-badge-status status="danger" pulse>Critical</x-badge-status>
                        <x-badge-status status="info">Info</x-badge-status>
                        <x-badge-status status="purple" icon="star">Premium</x-badge-status>
                    </div>
                </div>
                
                {{-- Feature List --}}
                <div class="glass-card">
                    <h3 class="text-xl font-bold mb-4">Feature List</h3>
                    <ul class="space-y-3">
                        <li class="flex items-center gap-3">
                            <x-icon name="check-circle" size="md" class="text-emerald-500 flex-shrink-0" variant="solid" />
                            <span>Real-time inventory tracking</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <x-icon name="check-circle" size="md" class="text-emerald-500 flex-shrink-0" variant="solid" />
                            <span>Automated reporting system</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <x-icon name="check-circle" size="md" class="text-emerald-500 flex-shrink-0" variant="solid" />
                            <span>Multi-user role management</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <x-icon name="check-circle" size="md" class="text-emerald-500 flex-shrink-0" variant="solid" />
                            <span>Secure data encryption</span>
                        </li>
                    </ul>
                </div>
            </div>
        </section>

        {{-- Back to Home --}}
        <div class="text-center py-8">
            <a href="{{ route('landing') }}" class="inline-flex items-center gap-3 btn-glow group">
                <x-icon name="arrow-right" size="md" class="rotate-180" />
                <span>Back to Landing Page</span>
            </a>
        </div>
    </div>
</div>
@endsection
