@extends('layouts.guest')

@section('content')
    {{-- Hero Section - More Natural & Engaging --}}
    <section id="home" class="relative min-h-screen flex items-center overflow-hidden bg-gradient-to-br from-slate-50 via-blue-50 to-slate-50">
        {{-- Subtle Background Pattern --}}
        <div class="absolute inset-0 opacity-[0.03]">
            <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <pattern id="grid" width="32" height="32" patternUnits="userSpaceOnUse">
                        <circle cx="16" cy="16" r="1" fill="currentColor"/>
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#grid)" class="text-blue-600"/>
            </svg>
        </div>
        
        {{-- Floating Decorative Elements --}}
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute top-20 left-10 w-72 h-72 bg-blue-200/20 rounded-full blur-3xl animate-float"></div>
            <div class="absolute bottom-20 right-10 w-96 h-96 bg-purple-200/20 rounded-full blur-3xl" style="animation: float 8s ease-in-out infinite;"></div>
        </div>
        
        <div class="relative z-10 mx-auto max-w-7xl px-4 py-20 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                {{-- Left Content --}}
                <div class="space-y-8 animate-slide-up">
                    {{-- Badge --}}
                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white shadow-sm border border-slate-200">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                        </span>
                        <span class="text-sm font-medium text-slate-700">Sistem Terpercaya untuk Sekolah Indonesia</span>
                    </div>
                    
                    {{-- Main Heading --}}
                    <div class="space-y-4">
                        <h1 class="text-5xl sm:text-6xl lg:text-7xl font-bold text-slate-900 leading-tight">
                            Kelola Inventaris<br>
                            <span class="text-gradient bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                                Sekolah dengan Mudah
                            </span>
                        </h1>
                        <p class="text-xl text-slate-600 leading-relaxed max-w-2xl">
                            SIPBAR membantu sekolah mengelola peminjaman barang inventaris secara digital. 
                            Dari pengajuan hingga pengembalian, semua tercatat rapi dan real-time.
                        </p>
                    </div>
                    
                    {{-- Quick Features --}}
                    <div class="grid grid-cols-2 gap-4">
                        <div class="flex items-start gap-3">
                            <div class="flex-shrink-0 w-10 h-10 rounded-lg bg-emerald-100 flex items-center justify-center">
                                <x-icon name="check-circle" size="md" class="text-emerald-600" />
                            </div>
                            <div>
                                <p class="font-semibold text-slate-900">Gratis</p>
                                <p class="text-sm text-slate-600">Setup tanpa biaya</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <div class="flex-shrink-0 w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center">
                                <x-icon name="clock" size="md" class="text-blue-600" />
                            </div>
                            <div>
                                <p class="font-semibold text-slate-900">Real-time</p>
                                <p class="text-sm text-slate-600">Update langsung</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <div class="flex-shrink-0 w-10 h-10 rounded-lg bg-purple-100 flex items-center justify-center">
                                <x-icon name="shield-check" size="md" class="text-purple-600" />
                            </div>
                            <div>
                                <p class="font-semibold text-slate-900">Aman</p>
                                <p class="text-sm text-slate-600">Data terenkripsi</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <div class="flex-shrink-0 w-10 h-10 rounded-lg bg-rose-100 flex items-center justify-center">
                                <x-icon name="users" size="md" class="text-rose-600" />
                            </div>
                            <div>
                                <p class="font-semibold text-slate-900">Multi-user</p>
                                <p class="text-sm text-slate-600">3 level akses</p>
                            </div>
                        </div>
                    </div>
                    
                    {{-- CTA Buttons --}}
                    <div class="flex flex-wrap gap-4 pt-4">
                        <a href="{{ route('login') }}" class="group inline-flex items-center gap-2 px-8 py-4 rounded-xl bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold shadow-lg shadow-blue-600/30 hover:shadow-xl hover:shadow-blue-600/40 hover:scale-105 transition-all duration-300">
                            <span>Mulai Sekarang</span>
                            <x-icon name="arrow-right" size="md" class="transition-transform group-hover:translate-x-1" />
                        </a>
                        <a href="#cara-kerja" class="inline-flex items-center gap-2 px-8 py-4 rounded-xl bg-white text-slate-700 font-semibold border-2 border-slate-200 hover:border-blue-600 hover:text-blue-600 transition-all duration-300">
                            <x-icon name="sparkles" size="md" />
                            <span>Lihat Demo</span>
                        </a>
                    </div>
                    
                    {{-- Trust Indicators --}}
                    <div class="flex items-center gap-6 pt-8 border-t border-slate-200">
                        <div class="flex -space-x-2">
                            @for($i = 0; $i < 4; $i++)
                            <div class="w-10 h-10 rounded-full border-2 border-white bg-gradient-to-br from-blue-400 to-purple-400 flex items-center justify-center shadow-md">
                                <x-icon name="users" size="sm" class="text-white" />
                            </div>
                            @endfor
                        </div>
                        <div>
                            <p class="font-semibold text-slate-900">50+ Pengguna Aktif</p>
                            <p class="text-sm text-slate-600">Dipercaya oleh sekolah di Indonesia</p>
                        </div>
                    </div>
                </div>
                
                {{-- Right Side - Dashboard Preview --}}
                <div class="relative animate-scale-in" style="animation-delay: 0.2s;">
                    {{-- Floating Cards --}}
                    <div class="relative">
                        {{-- Main Dashboard Card --}}
                        <div class="relative bg-white rounded-2xl shadow-2xl border border-slate-200 p-6 transform hover:scale-[1.02] transition-transform duration-300">
                            <div class="flex items-center justify-between mb-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center">
                                        <x-icon name="chart-bar" size="md" class="text-white" />
                                    </div>
                                    <div>
                                        <p class="font-semibold text-slate-900">Dashboard</p>
                                        <p class="text-xs text-slate-500">Real-time Analytics</p>
                                    </div>
                                </div>
                                <span class="flex items-center gap-1 text-xs font-medium text-emerald-600">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                    Live
                                </span>
                            </div>
                            
                            {{-- Stats Grid --}}
                            <div class="grid grid-cols-2 gap-4 mb-6">
                                <div class="bg-gradient-to-br from-blue-50 to-blue-100/50 rounded-xl p-4">
                                    <div class="flex items-center gap-2 mb-2">
                                        <x-icon name="cube" size="sm" class="text-blue-600" />
                                        <span class="text-xs font-medium text-blue-900">Total Barang</span>
                                    </div>
                                    <p class="text-2xl font-bold text-blue-900">150</p>
                                    <p class="text-xs text-blue-600 flex items-center gap-1 mt-1">
                                        <x-icon name="arrow-trending-up" size="xs" />
                                        +12% bulan ini
                                    </p>
                                </div>
                                
                                <div class="bg-gradient-to-br from-purple-50 to-purple-100/50 rounded-xl p-4">
                                    <div class="flex items-center gap-2 mb-2">
                                        <x-icon name="refresh" size="sm" class="text-purple-600" />
                                        <span class="text-xs font-medium text-purple-900">Dipinjam</span>
                                    </div>
                                    <p class="text-2xl font-bold text-purple-900">23</p>
                                    <p class="text-xs text-purple-600 flex items-center gap-1 mt-1">
                                        <x-icon name="clock" size="xs" />
                                        Aktif sekarang
                                    </p>
                                </div>
                            </div>
                            
                            {{-- Activity Chart --}}
                            <div class="bg-slate-50 rounded-xl p-4">
                                <p class="text-xs font-medium text-slate-700 mb-3">Aktivitas 7 Hari</p>
                                <div class="flex items-end gap-2 h-20">
                                    @foreach([45, 70, 50, 85, 65, 75, 90] as $height)
                                    <div class="flex-1 bg-gradient-to-t from-blue-500 to-blue-400 rounded-t-md hover:from-blue-400 hover:to-blue-300 transition-all cursor-pointer" 
                                         style="height: {{ $height }}%"></div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        
                        {{-- Floating Notification Card --}}
                        <div class="absolute -top-6 -right-6 bg-white rounded-xl shadow-lg border border-slate-200 p-4 max-w-[200px] animate-float">
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 rounded-lg bg-emerald-100 flex items-center justify-center flex-shrink-0">
                                    <x-icon name="check-circle" size="sm" class="text-emerald-600" />
                                </div>
                                <div>
                                    <p class="text-xs font-semibold text-slate-900">Peminjaman Disetujui</p>
                                    <p class="text-xs text-slate-500 mt-1">Laptop #23 • Budi S.</p>
                                </div>
                            </div>
                        </div>
                        
                        {{-- Floating User Card --}}
                        <div class="absolute -bottom-6 -left-6 bg-white rounded-xl shadow-lg border border-slate-200 p-4 max-w-[200px]" style="animation: float 6s ease-in-out infinite;">
                            <div class="flex items-center gap-3 mb-2">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-purple-400 to-pink-400"></div>
                                <div>
                                    <p class="text-sm font-semibold text-slate-900">Admin</p>
                                    <p class="text-xs text-slate-500">Online</p>
                                </div>
                            </div>
                            <div class="flex gap-1">
                                <div class="flex-1 h-1 rounded-full bg-blue-200"></div>
                                <div class="flex-1 h-1 rounded-full bg-blue-200"></div>
                                <div class="flex-1 h-1 rounded-full bg-blue-500"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        {{-- Scroll Indicator --}}
        <div class="absolute bottom-8 left-1/2 -translate-x-1/2 animate-bounce">
            <div class="flex flex-col items-center gap-2 text-slate-400">
                <span class="text-xs font-medium">Scroll untuk info lebih</span>
                <x-icon name="arrow-up" size="sm" class="rotate-180" />
            </div>
        </div>
    </section>

    {{-- Features Section - Natural & Relatable --}}
    <section id="fitur" class="py-24 bg-white">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            {{-- Section Header --}}
            <div class="text-center mb-16">
                <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-blue-50 text-blue-700 text-sm font-medium mb-4">
                    <x-icon name="sparkles" size="sm" />
                    Kenapa SIPBAR?
                </span>
                <h2 class="text-4xl sm:text-5xl font-bold text-slate-900 mb-4">
                    Semua yang Anda Butuhkan
                </h2>
                <p class="text-xl text-slate-600 max-w-2xl mx-auto">
                    Fitur lengkap untuk mengelola inventaris sekolah tanpa ribet
                </p>
            </div>
            
            {{-- Features Grid --}}
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach([
                    [
                        'icon' => 'document-text',
                        'title' => 'Pengajuan Online',
                        'desc' => 'Guru dan siswa bisa ajukan peminjaman kapan saja melalui formulir online yang mudah digunakan.',
                        'color' => 'blue'
                    ],
                    [
                        'icon' => 'check-circle',
                        'title' => 'Approval Cepat',
                        'desc' => 'Admin bisa review dan setujui peminjaman dalam hitungan menit, tidak perlu antri lagi.',
                        'color' => 'emerald'
                    ],
                    [
                        'icon' => 'refresh',
                        'title' => 'Tracking Real-time',
                        'desc' => 'Pantau status barang mana yang sedang dipinjam, siapa peminjamnya, dan kapan harus dikembalikan.',
                        'color' => 'purple'
                    ],
                    [
                        'icon' => 'chart-bar',
                        'title' => 'Laporan Otomatis',
                        'desc' => 'Generate laporan peminjaman lengkap dengan filter tanggal, kategori, dan status.',
                        'color' => 'rose'
                    ],
                    [
                        'icon' => 'bell',
                        'title' => 'Reminder Pintar',
                        'desc' => 'Sistem otomatis mengingatkan peminjam saat mendekati tenggat pengembalian.',
                        'color' => 'amber'
                    ],
                    [
                        'icon' => 'shield-check',
                        'title' => 'Keamanan Data',
                        'desc' => 'Data disimpan dengan aman, terenkripsi, dan hanya bisa diakses oleh yang berwenang.',
                        'color' => 'cyan'
                    ],
                ] as $index => $feature)
                <div class="group animate-slide-up" style="animation-delay: {{ $index * 0.1 }}s;">
                    <div class="bg-white border-2 border-slate-200 rounded-2xl p-6 hover:border-{{ $feature['color'] }}-300 hover:shadow-xl transition-all duration-300 h-full">
                        <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-{{ $feature['color'] }}-500 to-{{ $feature['color'] }}-600 flex items-center justify-center mb-5 group-hover:scale-110 transition-transform duration-300">
                            <x-icon :name="$feature['icon']" size="xl" class="text-white" />
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-3">{{ $feature['title'] }}</h3>
                        <p class="text-slate-600 leading-relaxed">{{ $feature['desc'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- How It Works - Simplified & Visual --}}
    <section id="cara-kerja" class="py-24 bg-gradient-to-br from-slate-50 to-blue-50">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            {{-- Section Header --}}
            <div class="text-center mb-20">
                <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white shadow-sm text-blue-700 text-sm font-medium mb-4">
                    <x-icon name="sparkles" size="sm" />
                    Mudah Digunakan
                </span>
                <h2 class="text-4xl sm:text-5xl font-bold text-slate-900 mb-4">
                    Cara Kerja SIPBAR
                </h2>
                <p class="text-xl text-slate-600 max-w-2xl mx-auto">
                    Hanya 4 langkah sederhana dari pengajuan sampai pengembalian
                </p>
            </div>
            
            {{-- Steps --}}
            <div class="relative">
                {{-- Connecting Line (Desktop) --}}
                <div class="hidden lg:block absolute top-32 left-0 right-0 h-0.5 bg-gradient-to-r from-blue-200 via-purple-200 to-blue-200"></div>
                
                <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                    @foreach([
                        ['num' => '01', 'icon' => 'document-text', 'title' => 'Ajukan', 'desc' => 'Isi formulir online dengan barang yang ingin dipinjam'],
                        ['num' => '02', 'icon' => 'check-circle', 'title' => 'Approval', 'desc' => 'Admin review dan setujui permintaan Anda'],
                        ['num' => '03', 'icon' => 'cube', 'title' => 'Ambil Barang', 'desc' => 'Ambil barang di gudang setelah disetujui'],
                        ['num' => '04', 'icon' => 'refresh', 'title' => 'Kembalikan', 'desc' => 'Kembalikan barang sebelum tanggal jatuh tempo'],
                    ] as $index => $step)
                    <div class="relative">
                        <div class="bg-white rounded-2xl p-8 border-2 border-slate-200 hover:border-blue-300 hover:shadow-xl transition-all duration-300">
                            {{-- Number --}}
                            <div class="absolute -top-4 left-8 w-12 h-12 rounded-full bg-gradient-to-br from-blue-600 to-purple-600 flex items-center justify-center text-white font-bold shadow-lg">
                                {{ $step['num'] }}
                            </div>
                            
                            {{-- Icon --}}
                            <div class="w-16 h-16 rounded-xl bg-gradient-to-br from-blue-50 to-purple-50 flex items-center justify-center mb-6 mt-4">
                                <x-icon :name="$step['icon']" size="xl" class="text-blue-600" />
                            </div>
                            
                            {{-- Content --}}
                            <h3 class="text-xl font-bold text-slate-900 mb-3">{{ $step['title'] }}</h3>
                            <p class="text-slate-600">{{ $step['desc'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- Contact & CTA Section --}}
    <section id="kontak" class="py-24 bg-gradient-to-br from-blue-600 to-purple-600 text-white relative overflow-hidden">
        {{-- Background Pattern --}}
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-0 left-0 w-96 h-96 bg-white rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 right-0 w-96 h-96 bg-white rounded-full blur-3xl"></div>
        </div>
        
        <div class="relative z-10 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                {{-- Left Side --}}
                <div>
                    <h2 class="text-4xl sm:text-5xl font-bold mb-6">
                        Siap Modernisasi<br>Sekolah Anda?
                    </h2>
                    <p class="text-xl text-blue-100 mb-8">
                        Bergabunglah dengan puluhan sekolah yang sudah menggunakan SIPBAR untuk mengelola inventaris mereka.
                    </p>
                    
                    <div class="flex flex-wrap gap-4 mb-12">
                        <a href="{{ route('login') }}" class="inline-flex items-center gap-2 px-8 py-4 rounded-xl bg-white text-blue-600 font-semibold hover:shadow-2xl hover:scale-105 transition-all duration-300">
                            <span>Mulai Gratis</span>
                            <x-icon name="arrow-right" size="md" />
                        </a>
                        <a href="#fitur" class="inline-flex items-center gap-2 px-8 py-4 rounded-xl bg-white/10 backdrop-blur-sm text-white font-semibold border-2 border-white/30 hover:bg-white/20 transition-all duration-300">
                            <x-icon name="sparkles" size="md" />
                            <span>Lihat Fitur</span>
                        </a>
                    </div>
                    
                    {{-- Contact Info --}}
                    <div class="space-y-4">
                        <div class="flex items-start gap-3">
                            <x-icon name="map-pin" size="md" class="text-blue-200 flex-shrink-0 mt-1" />
                            <div>
                                <p class="font-semibold">SMK Negeri Contoh</p>
                                <p class="text-blue-100">Jl. Pendidikan No. 123, Jakarta 10110</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <x-icon name="envelope" size="md" class="text-blue-200 flex-shrink-0" />
                            <a href="mailto:gudang@sekolah.sch.id" class="hover:text-white transition-colors">
                                gudang@sekolah.sch.id
                            </a>
                        </div>
                        <div class="flex items-center gap-3">
                            <x-icon name="phone" size="md" class="text-blue-200 flex-shrink-0" />
                            <a href="tel:+622112345678" class="hover:text-white transition-colors">
                                (021) 1234-5678
                            </a>
                        </div>
                    </div>
                </div>
                
                {{-- Right Side - Stats --}}
                <div class="bg-white/10 backdrop-blur-xl rounded-3xl p-8 border border-white/20">
                    <h3 class="text-2xl font-bold mb-8">Kenapa Sekolah Memilih SIPBAR?</h3>
                    
                    <div class="space-y-6">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 rounded-xl bg-white/20 flex items-center justify-center flex-shrink-0">
                                <x-icon name="check-circle" size="lg" />
                            </div>
                            <div>
                                <p class="font-semibold text-lg">100% Gratis</p>
                                <p class="text-blue-100">Tidak ada biaya setup atau berlangganan</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 rounded-xl bg-white/20 flex items-center justify-center flex-shrink-0">
                                <x-icon name="clock" size="lg" />
                            </div>
                            <div>
                                <p class="font-semibold text-lg">Setup 10 Menit</p>
                                <p class="text-blue-100">Langsung bisa digunakan tanpa training khusus</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 rounded-xl bg-white/20 flex items-center justify-center flex-shrink-0">
                                <x-icon name="users" size="lg" />
                            </div>
                            <div>
                                <p class="font-semibold text-lg">Support 24/7</p>
                                <p class="text-blue-100">Tim kami siap membantu kapan saja</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 rounded-xl bg-white/20 flex items-center justify-center flex-shrink-0">
                                <x-icon name="shield-check" size="lg" />
                            </div>
                            <div>
                                <p class="font-semibold text-lg">Data Aman</p>
                                <p class="text-blue-100">Terenkripsi dan backup otomatis</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
