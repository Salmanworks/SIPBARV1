@extends('layouts.guest')

@section('content')
<div class="min-h-screen bg-slate-50">
    {{-- Header --}}
    <div class="bg-gradient-mesh py-20 text-white">
        <div class="container mx-auto px-4">
            <div class="text-center animate-slide-up">
                <h1 class="text-5xl font-bold mb-4 text-shadow-lg">
                    🎨 SIPBAR Design System
                </h1>
                <p class="text-xl text-blue-100">
                    Glassmorphism & Gradient Flow Theme
                </p>
                <div class="mt-6 flex justify-center gap-4">
                    <x-badge-status status="success" pulse>Live</x-badge-status>
                    <x-badge-status status="info">v1.0.0</x-badge-status>
                </div>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-12 space-y-16">
        
        {{-- Stat Cards --}}
        <section>
            <h2 class="text-3xl font-bold text-primary-900 mb-8">📊 Stat Cards</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <x-stat-card 
                    title="Total Barang" 
                    value="150" 
                    icon="📦"
                    gradient="blue"
                    trend="up"
                    trendValue="+12%"
                    description="bulan ini"
                />
                
                <x-stat-card 
                    title="Dipinjam" 
                    value="23" 
                    icon="🔄"
                    gradient="purple"
                    trend="down"
                    trendValue="-5%"
                    description="dari kemarin"
                />
                
                <x-stat-card 
                    title="Terlambat" 
                    value="5" 
                    icon="⚠️"
                    gradient="rose"
                />
                
                <x-stat-card 
                    title="Pengguna Aktif" 
                    value="50" 
                    icon="👥"
                    gradient="emerald"
                    trend="up"
                    trendValue="+8%"
                />
            </div>
        </section>

        {{-- Status Badges --}}
        <section>
            <h2 class="text-3xl font-bold text-primary-900 mb-8">🏷️ Status Badges</h2>
            <div class="flex flex-wrap gap-4">
                <x-badge-status status="success">Tersedia</x-badge-status>
                <x-badge-status status="success" pulse>Live Status</x-badge-status>
                <x-badge-status status="warning">Pending</x-badge-status>
                <x-badge-status status="warning" icon="⏳">Processing</x-badge-status>
                <x-badge-status status="danger">Terlambat</x-badge-status>
                <x-badge-status status="danger" pulse>Critical</x-badge-status>
                <x-badge-status status="info">Info</x-badge-status>
                <x-badge-status status="purple">Premium</x-badge-status>
            </div>
        </section>

        {{-- Glass Cards --}}
        <section>
            <h2 class="text-3xl font-bold text-primary-900 mb-8">💎 Glass Cards</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <x-glass-card variant="light" class="p-6">
                    <h3 class="text-xl font-bold text-primary-900 mb-2">Light Glass</h3>
                    <p class="text-slate-600">Subtle background with 5% opacity</p>
                </x-glass-card>
                
                <x-glass-card variant="medium" hover class="p-6">
                    <h3 class="text-xl font-bold text-primary-900 mb-2">Medium Glass</h3>
                    <p class="text-slate-600">With hover effect (15% opacity)</p>
                </x-glass-card>
                
                <x-glass-card variant="heavy" hover shine class="p-6">
                    <h3 class="text-xl font-bold text-primary-900 mb-2">Heavy Glass</h3>
                    <p class="text-slate-600">With hover & shine (20% opacity)</p>
                </x-glass-card>
            </div>
        </section>

        {{-- Buttons --}}
        <section>
            <h2 class="text-3xl font-bold text-primary-900 mb-8">🔘 Buttons</h2>
            <div class="flex flex-wrap gap-4">
                <button class="btn-glow">
                    Primary Button
                </button>
                
                <button class="glass-medium rounded-xl px-6 py-3 font-semibold text-primary-900 hover:glass-heavy transition-all">
                    Secondary Button
                </button>
                
                <button class="glass-light rounded-xl px-6 py-3 font-semibold text-slate-700 hover:glass-medium transition-all border border-slate-300">
                    Outline Button
                </button>
                
                <button class="text-gradient-primary font-semibold px-4 py-2 hover:scale-105 transition-transform">
                    Link Button
                </button>
            </div>
        </section>

        {{-- Animations --}}
        <section>
            <h2 class="text-3xl font-bold text-primary-900 mb-8">✨ Animations</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <div class="glass-card text-center">
                    <div class="text-5xl mb-4 float">🎈</div>
                    <p class="text-sm text-slate-600">Float</p>
                </div>
                
                <div class="glass-card text-center">
                    <div class="text-5xl mb-4 animate-pulse-soft">💫</div>
                    <p class="text-sm text-slate-600">Pulse Soft</p>
                </div>
                
                <div class="glass-card text-center shimmer">
                    <div class="text-5xl mb-4">✨</div>
                    <p class="text-sm text-slate-600">Shimmer</p>
                </div>
                
                <div class="glass-card text-center hover-scale">
                    <div class="text-5xl mb-4">🚀</div>
                    <p class="text-sm text-slate-600">Hover Scale</p>
                </div>
            </div>
        </section>

        {{-- Gradients --}}
        <section>
            <h2 class="text-3xl font-bold text-primary-900 mb-8">🌈 Gradients</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-gradient-primary rounded-2xl p-8 text-white text-center">
                    <p class="font-semibold">Primary Gradient</p>
                </div>
                
                <div class="bg-gradient-purple rounded-2xl p-8 text-white text-center">
                    <p class="font-semibold">Purple Gradient</p>
                </div>
                
                <div class="bg-gradient-success rounded-2xl p-8 text-white text-center">
                    <p class="font-semibold">Success Gradient</p>
                </div>
            </div>
            
            <div class="mt-6">
                <div class="bg-gradient-animated rounded-2xl p-8 text-white text-center">
                    <p class="font-semibold">Animated Gradient</p>
                </div>
            </div>
        </section>

        {{-- Empty State --}}
        <section>
            <h2 class="text-3xl font-bold text-primary-900 mb-8">📭 Empty State</h2>
            <div class="glass-card">
                <x-empty-state
                    icon="📦"
                    title="Belum Ada Peminjaman"
                    description="Anda belum memiliki riwayat peminjaman. Mulai ajukan peminjaman sekarang!"
                    actionText="Ajukan Peminjaman"
                    actionUrl="#"
                />
            </div>
        </section>

        {{-- Loading Skeletons --}}
        <section>
            <h2 class="text-3xl font-bold text-primary-900 mb-8">⏳ Loading Skeletons</h2>
            
            <h3 class="text-xl font-semibold text-slate-700 mb-4">Card Skeleton</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <x-loading-skeleton type="card" count="3" />
            </div>
            
            <h3 class="text-xl font-semibold text-slate-700 mb-4">List Skeleton</h3>
            <div class="glass-card">
                <x-loading-skeleton type="list" count="3" />
            </div>
        </section>

        {{-- Text Effects --}}
        <section>
            <h2 class="text-3xl font-bold text-primary-900 mb-8">✍️ Text Effects</h2>
            <div class="space-y-4">
                <h1 class="text-5xl font-bold text-gradient">Gradient Text</h1>
                <h2 class="text-4xl font-bold text-gradient-primary">Primary Gradient Text</h2>
                <p class="text-2xl text-shadow-lg font-bold text-primary-900">Text with Shadow</p>
            </div>
        </section>

        {{-- Interactive Examples --}}
        <section>
            <h2 class="text-3xl font-bold text-primary-900 mb-8">🎯 Interactive Examples</h2>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                {{-- Product Card --}}
                <div class="glass-card card-lift">
                    <img src="https://via.placeholder.com/400x200/3b82f6/ffffff?text=Product+Image" 
                         alt="Product" 
                         class="rounded-xl mb-4 w-full">
                    <div class="flex items-start justify-between mb-2">
                        <div>
                            <h3 class="font-bold text-lg text-primary-900">Laptop Dell XPS 15</h3>
                            <p class="text-sm text-slate-600">Elektronik</p>
                        </div>
                        <x-badge-status status="success" pulse>Tersedia</x-badge-status>
                    </div>
                    <p class="text-slate-600 text-sm mb-4">
                        Laptop untuk keperluan pembelajaran dan presentasi
                    </p>
                    <div class="flex items-center justify-between">
                        <span class="font-semibold text-primary-900">Stok: 8</span>
                        <button class="btn-glow text-sm px-4 py-2">
                            Pinjam
                        </button>
                    </div>
                </div>
                
                {{-- Status Timeline --}}
                <div class="glass-card">
                    <h3 class="font-bold text-lg text-primary-900 mb-6">Status Timeline</h3>
                    <div class="space-y-4">
                        <div class="flex gap-4">
                            <div class="flex flex-col items-center">
                                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-emerald-500 to-emerald-600 flex items-center justify-center text-white">
                                    ✓
                                </div>
                                <div class="w-0.5 h-full bg-emerald-500 mt-2"></div>
                            </div>
                            <div class="flex-1 pb-8">
                                <p class="font-semibold text-primary-900">Diajukan</p>
                                <p class="text-sm text-slate-600">20 Jul 2024, 10:00</p>
                                <p class="text-xs text-slate-500 mt-1">Oleh: Budi Santoso</p>
                            </div>
                        </div>
                        
                        <div class="flex gap-4">
                            <div class="flex flex-col items-center">
                                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center text-white animate-pulse-soft">
                                    ⏳
                                </div>
                                <div class="w-0.5 h-full bg-slate-300 mt-2"></div>
                            </div>
                            <div class="flex-1 pb-8">
                                <p class="font-semibold text-primary-900">Menunggu Approval</p>
                                <p class="text-sm text-slate-600">Sedang direview</p>
                            </div>
                        </div>
                        
                        <div class="flex gap-4">
                            <div class="flex flex-col items-center">
                                <div class="w-8 h-8 rounded-full bg-slate-300 flex items-center justify-center text-slate-500">
                                    ○
                                </div>
                            </div>
                            <div class="flex-1">
                                <p class="font-semibold text-slate-400">Barang Keluar</p>
                                <p class="text-sm text-slate-400">Belum diproses</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Back to Top --}}
        <div class="text-center py-8">
            <a href="#" class="inline-flex items-center gap-2 glass-medium rounded-full px-6 py-3 font-semibold text-primary-900 hover:glass-heavy transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                </svg>
                Back to Top
            </a>
        </div>
    </div>
</div>
@endsection
