@extends('layouts.guest')

@section('content')
    {{-- Hero Section with Advanced Glassmorphism & 3D Effects --}}
    <section class="relative min-h-screen overflow-hidden bg-gradient-mesh px-4 py-20 text-white sm:px-6 lg:px-8">
        {{-- Animated Background Orbs --}}
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute -top-1/2 -left-1/4 h-[600px] w-[600px] rounded-full bg-blue-500/30 blur-3xl float"></div>
            <div class="absolute -bottom-1/2 -right-1/4 h-[600px] w-[600px] rounded-full bg-purple-500/30 blur-3xl" style="animation: float 8s ease-in-out infinite;"></div>
            <div class="absolute top-1/2 left-1/2 h-[400px] w-[400px] -translate-x-1/2 -translate-y-1/2 rounded-full bg-blue-400/20 blur-3xl" style="animation: float 10s ease-in-out infinite;"></div>
            <div class="absolute top-1/4 right-1/4 h-[300px] w-[300px] rounded-full bg-cyan-400/20 blur-3xl" style="animation: float 12s ease-in-out infinite;"></div>
        </div>
        
        {{-- Grid Pattern Overlay --}}
        <div class="absolute inset-0 grid-pattern opacity-10"></div>
        
        {{-- Content --}}
        <div class="relative mx-auto grid max-w-7xl gap-12 lg:grid-cols-2 lg:items-center lg:gap-20 pt-12">
            {{-- Left Column - Text Content --}}
            <div class="animate-slide-up space-y-8">
                {{-- Badge --}}
                <div class="inline-flex items-center gap-3 glass-light rounded-full px-5 py-2.5 text-sm font-medium shadow-glass backdrop-blur-xl">
                    <span class="flex items-center justify-center w-6 h-6 rounded-full bg-emerald-500 shadow-lg shadow-emerald-500/50">
                        <span class="pulse-dot bg-white"></span>
                    </span>
                    <x-icon name="sparkles" size="sm" class="text-emerald-300" />
                    <span class="font-semibold">Digitalisasi Inventaris Sekolah</span>
                </div>
                
                {{-- Main Heading --}}
                <div class="space-y-4">
                    <h1 class="text-5xl font-bold leading-tight sm:text-6xl lg:text-7xl text-shadow-lg">
                        Kelola Peminjaman 
                        <span class="relative inline-block mt-2">
                            <span class="text-gradient">Lebih Mudah</span>
                            <svg class="absolute -bottom-2 left-0 w-full" height="8" viewBox="0 0 300 8" fill="none">
                                <path d="M2 6C50 2 100 1 150 2C200 3 250 4 298 6" stroke="url(#gradient)" stroke-width="3" stroke-linecap="round"/>
                                <defs>
                                    <linearGradient id="gradient" x1="0%" y1="0%" x2="100%" y2="0%">
                                        <stop offset="0%" style="stop-color:#3b82f6;stop-opacity:1" />
                                        <stop offset="100%" style="stop-color:#8b5cf6;stop-opacity:1" />
                                    </linearGradient>
                                </defs>
                            </svg>
                        </span>
                    </h1>
                </div>
                
                {{-- Description --}}
                <p class="text-lg text-blue-100 sm:text-xl leading-relaxed max-w-2xl">
                    SIPBAR membantu <span class="font-semibold text-white">admin, petugas gudang, dan peminjam</span> mengelola inventaris sekolah — dari pengajuan hingga pengembalian — secara terpusat dan akurat.
                </p>
                
                {{-- Feature Pills --}}
                <div class="flex flex-wrap gap-3">
                    <span class="badge-glass badge-success inline-flex items-center gap-2">
                        <x-icon name="shield-check" size="sm" />
                        <span>Real-time Tracking</span>
                    </span>
                    <span class="badge-glass badge-purple inline-flex items-center gap-2">
                        <x-icon name="chart-bar" size="sm" />
                        <span>Laporan Lengkap</span>
                    </span>
                    <span class="badge-glass badge-info inline-flex items-center gap-2">
                        <x-icon name="shield-check" size="sm" />
                        <span>Aman & Terpercaya</span>
                    </span>
                </div>
                
                {{-- CTA Buttons --}}
                <div class="flex flex-wrap gap-4 pt-4">
                    <a href="{{ route('login') }}" class="btn-glow group inline-flex items-center gap-3">
                        <span class="relative z-10 font-semibold">Masuk ke Sistem</span>
                        <x-icon name="arrow-right" size="md" class="relative z-10 transition-transform group-hover:translate-x-1" />
                    </a>
                    <a href="#cara-kerja" class="glass-medium rounded-xl px-6 py-3.5 font-semibold text-white hover:glass-heavy transition-all duration-300 hover:scale-105 inline-flex items-center gap-2">
                        <x-icon name="sparkles" size="md" />
                        <span>Pelajari Cara Kerja</span>
                    </a>
                </div>
                
                {{-- Social Proof --}}
                <div class="flex items-center gap-8 pt-8 border-t border-white/20">
                    <div class="flex -space-x-3">
                        @for($i = 1; $i <= 5; $i++)
                        <div class="w-12 h-12 rounded-full border-3 border-white bg-gradient-to-br from-blue-400 to-purple-400 flex items-center justify-center text-sm font-bold shadow-xl">
                            <x-icon name="users" size="md" class="text-white" />
                        </div>
                        @endfor
                    </div>
                    <div>
                        <p class="font-bold text-xl">50+ Pengguna Aktif</p>
                        <p class="text-sm text-blue-200 flex items-center gap-2 mt-1">
                            <x-icon name="star" size="xs" variant="solid" class="text-yellow-400" />
                            <span>Dipercaya oleh SMK & SMA</span>
                        </p>
                    </div>
                </div>
            </div>
            
            {{-- Right Column - Advanced Stats Dashboard --}}
            <div class="animate-scale-in" style="animation-delay: 0.2s;">
                <div class="glass-card card-shine hover-scale relative overflow-hidden">
                    {{-- Decorative Corner --}}
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-blue-400/20 to-transparent rounded-bl-full"></div>
                    
                    {{-- Header --}}
                    <div class="mb-8 flex items-center justify-between relative z-10">
                        <div class="flex items-center gap-3">
                            <div class="flex items-center justify-center w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-500 to-emerald-600 shadow-lg">
                                <x-icon name="chart-bar" size="md" class="text-white" />
                            </div>
                            <div>
                                <h3 class="text-xl font-bold">Statistik Real-time</h3>
                                <p class="text-sm text-blue-200">Live Analytics</p>
                            </div>
                        </div>
                        <span class="flex items-center gap-2 text-sm font-medium">
                            <span class="pulse-dot bg-emerald-400"></span>
                            <span>Online</span>
                        </span>
                    </div>
                    
                    {{-- Stats Grid --}}
                    <div class="grid grid-cols-2 gap-5">
                        {{-- Stat Card 1 --}}
                        <div class="glass-light rounded-2xl p-6 hover:glass-medium transition-all duration-300 group relative overflow-hidden">
                            <div class="absolute top-0 right-0 opacity-10 group-hover:opacity-20 transition-opacity">
                                <x-icon name="cube" size="3xl" />
                            </div>
                            <div class="relative z-10">
                                <div class="flex items-center gap-2 mb-3">
                                    <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-blue-500/20">
                                        <x-icon name="cube" size="md" class="text-blue-300" />
                                    </div>
                                </div>
                                <p class="text-4xl font-bold mb-1 group-hover:scale-110 transition-transform">150+</p>
                                <p class="text-sm text-blue-100 mb-3">Barang Terdata</p>
                                <div class="flex items-center gap-1 text-emerald-400 text-xs font-semibold">
                                    <x-icon name="arrow-trending-up" size="xs" />
                                    <span>+12% bulan ini</span>
                                </div>
                            </div>
                        </div>
                        
                        {{-- Stat Card 2 --}}
                        <div class="glass-light rounded-2xl p-6 hover:glass-medium transition-all duration-300 group relative overflow-hidden">
                            <div class="absolute top-0 right-0 opacity-10 group-hover:opacity-20 transition-opacity">
                                <x-icon name="clock" size="3xl" />
                            </div>
                            <div class="relative z-10">
                                <div class="flex items-center gap-2 mb-3">
                                    <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-purple-500/20">
                                        <x-icon name="clock" size="md" class="text-purple-300" />
                                    </div>
                                </div>
                                <p class="text-4xl font-bold mb-1 group-hover:scale-110 transition-transform">24/7</p>
                                <p class="text-sm text-blue-100 mb-3">Akses Online</p>
                                <div class="flex items-center gap-1 text-blue-300 text-xs font-semibold">
                                    <span class="pulse-dot bg-blue-400"></span>
                                    <span>Always Available</span>
                                </div>
                            </div>
                        </div>
                        
                        {{-- Stat Card 3 --}}
                        <div class="glass-light rounded-2xl p-6 hover:glass-medium transition-all duration-300 group relative overflow-hidden">
                            <div class="absolute top-0 right-0 opacity-10 group-hover:opacity-20 transition-opacity">
                                <x-icon name="users" size="3xl" />
                            </div>
                            <div class="relative z-10">
                                <div class="flex items-center gap-2 mb-3">
                                    <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-emerald-500/20">
                                        <x-icon name="users" size="md" class="text-emerald-300" />
                                    </div>
                                </div>
                                <p class="text-4xl font-bold mb-1 group-hover:scale-110 transition-transform">3</p>
                                <p class="text-sm text-blue-100 mb-3">Peran Pengguna</p>
                                <div class="text-xs text-purple-300 font-medium">
                                    Admin • Petugas • Peminjam
                                </div>
                            </div>
                        </div>
                        
                        {{-- Stat Card 4 --}}
                        <div class="glass-light rounded-2xl p-6 hover:glass-medium transition-all duration-300 group relative overflow-hidden">
                            <div class="absolute top-0 right-0 opacity-10 group-hover:opacity-20 transition-opacity">
                                <x-icon name="document-text" size="3xl" />
                            </div>
                            <div class="relative z-10">
                                <div class="flex items-center gap-2 mb-3">
                                    <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-rose-500/20">
                                        <x-icon name="document-text" size="md" class="text-rose-300" />
                                    </div>
                                </div>
                                <p class="text-4xl font-bold mb-1 group-hover:scale-110 transition-transform">100%</p>
                                <p class="text-sm text-blue-100 mb-3">Riwayat Tercatat</p>
                                <div class="flex items-center gap-1 text-emerald-400 text-xs font-semibold">
                                    <x-icon name="check-circle" size="xs" />
                                    <span>Akurat & Lengkap</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    {{-- Mini Activity Chart --}}
                    <div class="mt-6 glass-light rounded-xl p-5">
                        <div class="flex items-center justify-between mb-4">
                            <p class="text-sm font-semibold flex items-center gap-2">
                                <x-icon name="fire" size="sm" class="text-orange-400" />
                                <span>Aktivitas 7 Hari Terakhir</span>
                            </p>
                            <span class="text-xs text-blue-300 flex items-center gap-1">
                                <span class="pulse-dot bg-emerald-400"></span>
                                <span>Live</span>
                            </span>
                        </div>
                        <div class="flex items-end gap-2 h-20">
                            @foreach([40, 65, 45, 80, 60, 75, 90] as $index => $height)
                            <div class="flex-1 group relative">
                                <div class="bg-gradient-to-t from-blue-500 to-purple-500 rounded-t-lg transition-all duration-300 hover:from-blue-400 hover:to-purple-400 cursor-pointer" 
                                     style="height: {{ $height }}%"></div>
                                <div class="absolute -top-8 left-1/2 -translate-x-1/2 bg-slate-900 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none">
                                    {{ $height }}%
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div class="flex justify-between mt-3 text-xs text-blue-300">
                            <span>Sen</span>
                            <span>Sel</span>
                            <span>Rab</span>
                            <span>Kam</span>
                            <span>Jum</span>
                            <span>Sab</span>
                            <span>Min</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        {{-- Scroll Indicator --}}
        <div class="absolute bottom-10 left-1/2 -translate-x-1/2 animate-bounce">
            <div class="flex flex-col items-center gap-2">
                <span class="text-sm text-white/60 font-medium">Scroll</span>
                <x-icon name="arrow-up" size="md" class="text-white/60 rotate-180" />
            </div>
        </div>
    </section>

    {{-- How It Works Section - Enhanced with 3D Cards --}}
    <section id="cara-kerja" class="relative mx-auto max-w-7xl px-4 py-32 sm:px-6 lg:px-8">
        {{-- Background Decoration --}}
        <div class="absolute inset-0 -z-10">
            <div class="absolute top-20 left-10 w-72 h-72 bg-blue-500/5 rounded-full blur-3xl"></div>
            <div class="absolute bottom-20 right-10 w-72 h-72 bg-purple-500/5 rounded-full blur-3xl"></div>
        </div>
        
        {{-- Section Header --}}
        <div class="mb-20 text-center animate-slide-up">
            <div class="inline-flex items-center gap-2 badge-glass badge-info mb-6">
                <x-icon name="sparkles" size="sm" />
                <span class="font-semibold">Mudah & Cepat</span>
            </div>
            <h2 class="text-4xl font-bold text-primary-900 sm:text-5xl lg:text-6xl mb-6">
                Cara Kerja <span class="text-gradient">SIPBAR</span>
            </h2>
            <p class="text-lg text-slate-600 max-w-3xl mx-auto leading-relaxed">
                Empat langkah sederhana menggantikan buku catatan manual dengan sistem digital yang efisien dan modern
            </p>
        </div>
        
        {{-- Steps Grid with Timeline --}}
        <div class="relative">
            {{-- Connection Line (Desktop) --}}
            <div class="hidden lg:block absolute top-24 left-0 right-0 h-0.5 bg-gradient-to-r from-blue-500 via-purple-500 to-rose-500 opacity-20"></div>
            
            <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-4">
                @foreach([
                    [
                        'num' => '1', 
                        'icon' => 'document-text', 
                        'title' => 'Ajukan Peminjaman', 
                        'desc' => 'Peminjam memilih barang, jumlah, dan tanggal melalui formulir online yang mudah digunakan.',
                        'color' => 'blue',
                        'bgGradient' => 'from-blue-500 to-blue-600',
                    ],
                    [
                        'num' => '2', 
                        'icon' => 'check-circle', 
                        'title' => 'Approval Admin', 
                        'desc' => 'Admin atau petugas meninjau dan menyetujui/menolak pengajuan dengan cepat.',
                        'color' => 'purple',
                        'bgGradient' => 'from-purple-500 to-purple-600',
                    ],
                    [
                        'num' => '3', 
                        'icon' => 'refresh', 
                        'title' => 'Verifikasi Keluar/Masuk', 
                        'desc' => 'Petugas gudang memverifikasi barang keluar dan kembali dengan sistem tracking.',
                        'color' => 'emerald',
                        'bgGradient' => 'from-emerald-500 to-emerald-600',
                    ],
                    [
                        'num' => '4', 
                        'icon' => 'chart-bar', 
                        'title' => 'Laporan & Riwayat', 
                        'desc' => 'Semua transaksi tercatat dan dapat difilter untuk membuat laporan detail.',
                        'color' => 'rose',
                        'bgGradient' => 'from-rose-500 to-rose-600',
                    ],
                ] as $index => $step)
                    <div class="group relative animate-slide-up" style="animation-delay: {{ $index * 0.15 }}s;">
                        {{-- Card --}}
                        <div class="relative h-full card-lift border-gradient rounded-3xl bg-white p-8 shadow-xl hover:shadow-2xl overflow-hidden">
                            {{-- Background Pattern --}}
                            <div class="absolute inset-0 opacity-5">
                                <div class="absolute inset-0 bg-gradient-to-br {{ $step['bgGradient'] }}"></div>
                            </div>
                            
                            {{-- Number Badge (Floating) --}}
                            <div class="absolute -top-6 -right-6 w-24 h-24 rounded-full bg-gradient-to-br {{ $step['bgGradient'] }} opacity-10 group-hover:opacity-20 transition-opacity"></div>
                            <div class="absolute -top-3 -right-3 w-14 h-14 rounded-full bg-gradient-to-br {{ $step['bgGradient'] }} text-white font-bold flex items-center justify-center shadow-2xl text-xl ring-4 ring-white animate-glow z-10">
                                {{ $step['num'] }}
                            </div>
                            
                            {{-- Icon Container --}}
                            <div class="relative mb-6">
                                <div class="inline-flex items-center justify-center w-20 h-20 rounded-2xl bg-gradient-to-br {{ $step['bgGradient'] }} shadow-xl shadow-{{ $step['color'] }}-500/50 group-hover:scale-110 transition-all duration-300">
                                    <x-icon :name="$step['icon']" size="xl" class="text-white" />
                                </div>
                                {{-- Glow effect --}}
                                <div class="absolute inset-0 bg-gradient-to-br {{ $step['bgGradient'] }} rounded-2xl blur-xl opacity-30 group-hover:opacity-50 transition-opacity -z-10"></div>
                            </div>
                            
                            {{-- Title --}}
                            <h3 class="font-bold text-2xl text-primary-900 mb-4 group-hover:text-{{ $step['color'] }}-600 transition-colors relative z-10">
                                {{ $step['title'] }}
                            </h3>
                            
                            {{-- Description --}}
                            <p class="text-slate-600 leading-relaxed relative z-10 mb-6">
                                {{ $step['desc'] }}
                            </p>
                            
                            {{-- Decorative Line --}}
                            <div class="relative z-10 h-1 rounded-full bg-gradient-to-r {{ $step['bgGradient'] }} w-16 group-hover:w-full transition-all duration-500"></div>
                            
                            {{-- Arrow (Desktop Only) --}}
                            @if($index < 3)
                            <div class="hidden lg:block absolute top-1/2 -right-12 -translate-y-1/2 z-20">
                                <x-icon name="arrow-right" size="lg" class="text-{{ $step['color'] }}-300 animate-pulse-soft" />
                            </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        
        {{-- Bottom CTA Card --}}
        <div class="mt-20 animate-slide-up" style="animation-delay: 0.6s;">
            <div class="glass-card bg-gradient-to-r from-blue-50 via-purple-50 to-blue-50 border-2 border-white shadow-2xl">
                <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                    <div class="flex items-center gap-6">
                        <div class="flex-shrink-0">
                            <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center shadow-xl shadow-blue-500/50">
                                <x-icon name="sparkles" size="2xl" class="text-white" />
                            </div>
                        </div>
                        <div class="text-left">
                            <p class="font-bold text-2xl text-primary-900 mb-1">Siap mencoba SIPBAR?</p>
                            <p class="text-slate-600">Mulai digitalisasi peminjaman barang sekolah Anda sekarang</p>
                        </div>
                    </div>
                    <a href="{{ route('login') }}" class="btn-glow group flex-shrink-0">
                        <span class="relative z-10 flex items-center gap-2 font-semibold">
                            <span>Mulai Sekarang</span>
                            <x-icon name="arrow-right" size="md" class="transition-transform group-hover:translate-x-1" />
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- Features Section - Before Contact --}}
    <section class="relative bg-slate-50 py-32 px-4 sm:px-6 lg:px-8 overflow-hidden">
        {{-- Background Decoration --}}
        <div class="absolute inset-0 -z-10">
            <div class="absolute top-0 right-0 w-96 h-96 bg-purple-500/5 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 left-0 w-96 h-96 bg-blue-500/5 rounded-full blur-3xl"></div>
        </div>
        
        <div class="mx-auto max-w-7xl">
            {{-- Section Header --}}
            <div class="text-center mb-20 animate-slide-up">
                <div class="inline-flex items-center gap-2 badge-glass badge-purple mb-6">
                    <x-icon name="star" size="sm" variant="solid" />
                    <span class="font-semibold">Fitur Unggulan</span>
                </div>
                <h2 class="text-4xl font-bold text-primary-900 sm:text-5xl mb-6">
                    Kenapa Memilih <span class="text-gradient">SIPBAR</span>?
                </h2>
                <p class="text-lg text-slate-600 max-w-3xl mx-auto">
                    Solusi lengkap untuk manajemen inventaris sekolah yang modern dan efisien
                </p>
            </div>
            
            {{-- Features Grid --}}
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach([
                    ['icon' => 'shield-check', 'title' => 'Aman & Terpercaya', 'desc' => 'Data terenkripsi dengan standar keamanan tinggi', 'gradient' => 'emerald'],
                    ['icon' => 'clock', 'title' => 'Real-time Updates', 'desc' => 'Notifikasi instan untuk setiap transaksi', 'gradient' => 'blue'],
                    ['icon' => 'document-text', 'title' => 'Laporan Otomatis', 'desc' => 'Generate laporan lengkap dengan satu klik', 'gradient' => 'purple'],
                    ['icon' => 'users', 'title' => 'Multi User Role', 'desc' => 'Akses berbeda untuk Admin, Petugas & Peminjam', 'gradient' => 'cyan'],
                    ['icon' => 'camera', 'title' => 'Upload Foto Barang', 'desc' => 'Dokumentasi visual untuk setiap item', 'gradient' => 'rose'],
                    ['icon' => 'bell', 'title' => 'Reminder Otomatis', 'desc' => 'Pengingat otomatis untuk jatuh tempo', 'gradient' => 'amber'],
                ] as $index => $feature)
                <div class="group animate-slide-up" style="animation-delay: {{ $index * 0.1 }}s;">
                    <div class="glass-card hover-scale h-full">
                        {{-- Icon --}}
                        <div class="mb-6">
                            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-gradient-to-br from-{{ $feature['gradient'] }}-500 to-{{ $feature['gradient'] }}-600 shadow-xl shadow-{{ $feature['gradient'] }}-500/50 group-hover:scale-110 transition-all duration-300">
                                <x-icon :name="$feature['icon']" size="xl" class="text-white" />
                            </div>
                        </div>
                        
                        {{-- Content --}}
                        <h3 class="text-xl font-bold text-primary-900 mb-3">{{ $feature['title'] }}</h3>
                        <p class="text-slate-600 leading-relaxed">{{ $feature['desc'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Footer / Contact Section - Enhanced --}}
    <section class="relative overflow-hidden bg-gradient-animated px-4 py-32 text-white sm:px-6 lg:px-8">
        {{-- Decorative Elements --}}
        <div class="absolute inset-0">
            <div class="absolute top-0 left-1/4 w-96 h-96 bg-white/10 rounded-full blur-3xl wave-animation"></div>
            <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-purple-500/20 rounded-full blur-3xl" style="animation: wave 25s ease-in-out infinite;"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-64 h-64 bg-cyan-500/10 rounded-full blur-3xl" style="animation: wave 30s ease-in-out infinite;"></div>
        </div>
        
        <div class="relative mx-auto max-w-7xl">
            <div class="grid gap-16 lg:grid-cols-2 lg:items-center">
                {{-- Left Column - Contact Info --}}
                <div class="animate-slide-up space-y-10">
                    <div>
                        <div class="inline-flex items-center gap-2 badge-glass badge-success mb-6">
                            <x-icon name="envelope" size="sm" />
                            <span class="font-semibold">Hubungi Kami</span>
                        </div>
                        <h2 class="text-5xl font-bold sm:text-6xl text-shadow-lg mb-6">
                            Kontak Sekolah
                        </h2>
                        <p class="text-xl text-blue-100 leading-relaxed">
                            Hubungi kami untuk informasi lebih lanjut tentang SIPBAR dan konsultasi implementasi
                        </p>
                    </div>
                    
                    <div class="space-y-5">
                        {{-- Address --}}
                        <div class="flex items-start gap-5 glass-light rounded-2xl p-6 hover:glass-medium transition-all group">
                            <div class="flex-shrink-0">
                                <div class="flex items-center justify-center w-14 h-14 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 shadow-xl group-hover:scale-110 transition-transform">
                                    <x-icon name="map-pin" size="lg" />
                                </div>
                            </div>
                            <div class="flex-1">
                                <p class="font-bold text-lg mb-2">Alamat</p>
                                <p class="text-blue-100 leading-relaxed">SMK Negeri Contoh</p>
                                <p class="text-blue-100 leading-relaxed">Jl. Pendidikan No. 123, Jakarta 10110</p>
                            </div>
                        </div>
                        
                        {{-- Email --}}
                        <div class="flex items-start gap-5 glass-light rounded-2xl p-6 hover:glass-medium transition-all group">
                            <div class="flex-shrink-0">
                                <div class="flex items-center justify-center w-14 h-14 rounded-xl bg-gradient-to-br from-emerald-500 to-emerald-600 shadow-xl group-hover:scale-110 transition-transform">
                                    <x-icon name="envelope" size="lg" />
                                </div>
                            </div>
                            <div class="flex-1">
                                <p class="font-bold text-lg mb-2">Email</p>
                                <a href="mailto:gudang@sekolah.sch.id" class="text-blue-100 hover:text-white transition-colors inline-flex items-center gap-2 group">
                                    <span>gudang@sekolah.sch.id</span>
                                    <x-icon name="arrow-right" size="sm" class="transition-transform group-hover:translate-x-1" />
                                </a>
                            </div>
                        </div>
                        
                        {{-- Phone --}}
                        <div class="flex items-start gap-5 glass-light rounded-2xl p-6 hover:glass-medium transition-all group">
                            <div class="flex-shrink-0">
                                <div class="flex items-center justify-center w-14 h-14 rounded-xl bg-gradient-to-br from-purple-500 to-purple-600 shadow-xl group-hover:scale-110 transition-transform">
                                    <x-icon name="phone" size="lg" />
                                </div>
                            </div>
                            <div class="flex-1">
                                <p class="font-bold text-lg mb-2">Telepon</p>
                                <a href="tel:+622112345678" class="text-blue-100 hover:text-white transition-colors inline-flex items-center gap-2 group">
                                    <span>(021) 1234-5678</span>
                                    <x-icon name="arrow-right" size="sm" class="transition-transform group-hover:translate-x-1" />
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                
                {{-- Right Column - CTA Card --}}
                <div class="animate-scale-in" style="animation-delay: 0.2s;">
                    <div class="glass-card text-center relative overflow-hidden">
                        {{-- Decorative Background --}}
                        <div class="absolute inset-0 bg-gradient-to-br from-blue-500/10 to-purple-500/10"></div>
                        
                        <div class="relative z-10">
                            {{-- Icon --}}
                            <div class="inline-flex items-center justify-center w-24 h-24 rounded-3xl bg-gradient-to-br from-blue-500 to-purple-600 shadow-2xl shadow-blue-500/50 mb-8 animate-float">
                                <x-icon name="academic-cap" size="3xl" class="text-white" />
                            </div>
                            
                            <h3 class="text-3xl font-bold mb-4">Siap Modernisasi Sekolah Anda?</h3>
                            <p class="text-blue-100 mb-10 text-lg leading-relaxed max-w-md mx-auto">
                                Bergabunglah dengan sekolah-sekolah yang sudah mempercayai SIPBAR untuk mengelola inventaris mereka
                            </p>
                            
                            <div class="space-y-4 mb-10">
                                <a href="{{ route('login') }}" class="block w-full btn-glow group">
                                    <span class="relative z-10 flex items-center justify-center gap-2 font-semibold">
                                        <span>Masuk ke Sistem</span>
                                        <x-icon name="arrow-right" size="md" class="transition-transform group-hover:translate-x-1" />
                                    </span>
                                </a>
                                <a href="{{ route('register') }}" class="block w-full glass-medium rounded-xl px-6 py-4 font-semibold hover:glass-heavy transition-all inline-flex items-center justify-center gap-2">
                                    <x-icon name="sparkles" size="md" />
                                    <span>Daftar Sekarang</span>
                                </a>
                            </div>
                            
                            {{-- Features Grid --}}
                            <div class="grid grid-cols-2 gap-4 text-sm">
                                <div class="flex items-center gap-3 glass-light rounded-xl p-4">
                                    <x-icon name="check-circle" size="md" class="text-emerald-400 flex-shrink-0" variant="solid" />
                                    <span class="font-medium text-left">Gratis Setup</span>
                                </div>
                                <div class="flex items-center gap-3 glass-light rounded-xl p-4">
                                    <x-icon name="check-circle" size="md" class="text-emerald-400 flex-shrink-0" variant="solid" />
                                    <span class="font-medium text-left">Support 24/7</span>
                                </div>
                                <div class="flex items-center gap-3 glass-light rounded-xl p-4">
                                    <x-icon name="check-circle" size="md" class="text-emerald-400 flex-shrink-0" variant="solid" />
                                    <span class="font-medium text-left">Data Aman</span>
                                </div>
                                <div class="flex items-center gap-3 glass-light rounded-xl p-4">
                                    <x-icon name="check-circle" size="md" class="text-emerald-400 flex-shrink-0" variant="solid" />
                                    <span class="font-medium text-left">Update Rutin</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            {{-- Footer Bottom --}}
            <div class="mt-24 text-center border-t border-white/20 pt-12 space-y-6">
                <div class="flex items-center justify-center gap-8">
                    <div class="flex items-center gap-3">
                        <x-icon name="shield-check" size="md" class="text-emerald-400" />
                        <span class="text-blue-200 font-medium">Secure & Encrypted</span>
                    </div>
                    <div class="hidden sm:block w-px h-6 bg-white/20"></div>
                    <div class="flex items-center gap-3">
                        <x-icon name="star" size="md" class="text-yellow-400" variant="solid" />
                        <span class="text-blue-200 font-medium">Trusted by Schools</span>
                    </div>
                </div>
                
                <p class="text-blue-200 text-lg font-medium">
                    © {{ date('Y') }} SIPBAR - Sistem Informasi Peminjaman Barang
                </p>
                <p class="text-sm text-blue-300 flex items-center justify-center gap-2">
                    <span>Built with</span>
                    <x-icon name="heart" size="sm" class="text-rose-400 animate-pulse-soft" />
                    <span>using Laravel & Tailwind CSS</span>
                </p>
            </div>
        </div>
    </section>
@endsection
