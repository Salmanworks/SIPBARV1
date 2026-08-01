@extends('layouts.guest')

@section('content')

    {{-- ============================================================ --}}
    {{-- HERO SECTION                                                  --}}
    {{-- ============================================================ --}}
    <section id="home" class="relative min-h-[92vh] flex items-center overflow-hidden transition-colors duration-300 py-16 sm:py-24"
        style="background: var(--bg-primary);">

        {{-- Dynamic Background Mesh & Pattern --}}
        <div class="absolute inset-0 opacity-[0.035] pointer-events-none">
            <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <pattern id="grid-hero" width="36" height="36" patternUnits="userSpaceOnUse">
                        <circle cx="18" cy="18" r="1.2" fill="currentColor"/>
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#grid-hero)" style="color: var(--accent-from)"/>
            </svg>
        </div>

        {{-- Ambient Glowing Gradient Orbs --}}
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute -top-16 -left-16 w-[450px] h-[450px] rounded-full blur-[100px] animate-pulse-glow"
                 style="background: radial-gradient(circle, rgba(79,70,229,0.18) 0%, rgba(124,58,237,0.05) 70%, transparent 100%);"></div>
            <div class="absolute bottom-10 right-10 w-[500px] h-[500px] rounded-full blur-[110px]"
                 style="animation: pulseGlow 7s ease-in-out infinite 2s; background: radial-gradient(circle, rgba(124,58,237,0.16) 0%, rgba(236,72,153,0.05) 70%, transparent 100%);"></div>
        </div>

        <div class="relative z-10 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-12 gap-12 lg:gap-16 items-center">

                {{-- ====== LEFT CONTENT ====== --}}
                <div class="lg:col-span-7 space-y-8">

                    {{-- Live Trust Badge --}}
                    <div class="inline-flex items-center gap-2.5 px-4 py-2 rounded-full shadow-sm transition-all duration-300 hover:scale-105"
                         style="background: var(--bg-card); border: 1px solid var(--border-card);">
                        <span class="relative flex h-2.5 w-2.5">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-500"></span>
                        </span>
                        <span class="text-xs sm:text-sm font-semibold tracking-wide" style="color: var(--text-body);">
                            Sistem Terpercaya untuk Sekolah Indonesia
                        </span>
                    </div>

                    {{-- Main Heading --}}
                    <div class="space-y-4">
                        <h1 class="text-4xl sm:text-6xl lg:text-6xl font-extrabold tracking-tight leading-[1.15] transition-colors duration-300"
                            style="color: var(--text-heading);">
                            Kelola Inventaris<br>
                            <span style="background: linear-gradient(135deg, #4F46E5 0%, #7C3AED 50%, #EC4899 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                                Sekolah dengan Mudah
                            </span>
                        </h1>
                        <p class="text-lg sm:text-xl leading-relaxed max-w-2xl transition-colors duration-300"
                           style="color: var(--text-body);">
                            SIPBAR membantu sekolah mengelola peminjaman barang inventaris secara digital.
                            Dari pengajuan hingga pengembalian, semua tercatat rapi, transparan, dan real-time.
                        </p>
                    </div>

                    {{-- Quick Feature Highlights Grid --}}
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 pt-2">
                        {{-- Gratis --}}
                        <div class="p-3.5 rounded-2xl transition-all duration-300 hover:-translate-y-1 hover:shadow-lg"
                             style="background: var(--bg-card); border: 1px solid var(--border-card);">
                            <div class="w-9 h-9 rounded-xl flex items-center justify-center mb-2.5" style="background: rgba(34,197,94,0.14);">
                                <x-icon name="check-circle" size="md" class="text-emerald-500" />
                            </div>
                            <p class="font-bold text-sm leading-snug" style="color: var(--text-heading);">100% Gratis</p>
                            <p class="text-xs" style="color: var(--text-muted);">Setup tanpa biaya</p>
                        </div>
                        {{-- Real-time --}}
                        <div class="p-3.5 rounded-2xl transition-all duration-300 hover:-translate-y-1 hover:shadow-lg"
                             style="background: var(--bg-card); border: 1px solid var(--border-card);">
                            <div class="w-9 h-9 rounded-xl flex items-center justify-center mb-2.5" style="background: rgba(79,70,229,0.14);">
                                <x-icon name="clock" size="md" class="text-indigo-500" />
                            </div>
                            <p class="font-bold text-sm leading-snug" style="color: var(--text-heading);">Real-time</p>
                            <p class="text-xs" style="color: var(--text-muted);">Update langsung</p>
                        </div>
                        {{-- Aman --}}
                        <div class="p-3.5 rounded-2xl transition-all duration-300 hover:-translate-y-1 hover:shadow-lg"
                             style="background: var(--bg-card); border: 1px solid var(--border-card);">
                            <div class="w-9 h-9 rounded-xl flex items-center justify-center mb-2.5" style="background: rgba(124,58,237,0.14);">
                                <x-icon name="shield-check" size="md" class="text-violet-500" />
                            </div>
                            <p class="font-bold text-sm leading-snug" style="color: var(--text-heading);">Data Aman</p>
                            <p class="text-xs" style="color: var(--text-muted);">Terenkripsi rapi</p>
                        </div>
                        {{-- Multi-user --}}
                        <div class="p-3.5 rounded-2xl transition-all duration-300 hover:-translate-y-1 hover:shadow-lg"
                             style="background: var(--bg-card); border: 1px solid var(--border-card);">
                            <div class="w-9 h-9 rounded-xl flex items-center justify-center mb-2.5" style="background: rgba(244,63,94,0.14);">
                                <x-icon name="users" size="md" class="text-rose-500" />
                            </div>
                            <p class="font-bold text-sm leading-snug" style="color: var(--text-heading);">Multi-User</p>
                            <p class="text-xs" style="color: var(--text-muted);">3 level akses</p>
                        </div>
                    </div>

                    {{-- CTA Action Buttons --}}
                    <div class="flex flex-wrap items-center gap-4 pt-2">
                        <a href="{{ route('login') }}"
                           class="btn-glow group inline-flex items-center gap-3 px-8 py-4 rounded-2xl text-white font-bold text-base transition-all duration-300 hover:scale-[1.03]"
                           style="background: linear-gradient(135deg, #4F46E5 0%, #7C3AED 100%); box-shadow: 0 12px 36px rgba(79,70,229,0.35);">
                            <span>Mulai Sekarang</span>
                            <x-icon name="arrow-right" size="md" class="transition-transform group-hover:translate-x-1" />
                        </a>
                        <a href="#cara-kerja"
                           class="inline-flex items-center gap-2.5 px-8 py-4 rounded-2xl font-bold text-base transition-all duration-300"
                           style="background: var(--bg-card); border: 1.5px solid var(--border-card); color: var(--text-heading);"
                           onmouseover="this.style.borderColor='#4F46E5'; this.style.color='#4F46E5';"
                           onmouseout="this.style.borderColor='var(--border-card)'; this.style.color='var(--text-heading)';">
                            <x-icon name="sparkles" size="md" />
                            <span>Lihat Cara Kerja</span>
                        </a>
                    </div>

                    {{-- Trust Indicators --}}
                    <div class="flex items-center gap-5 pt-4 border-t transition-colors duration-300" style="border-color: var(--border-card);">
                        <div class="flex -space-x-3">
                            @for($i = 0; $i < 4; $i++)
                            <div class="w-10 h-10 rounded-full border-2 flex items-center justify-center shadow-sm"
                                 style="background: linear-gradient(135deg, #4F46E5, #7C3AED); border-color: var(--bg-primary);">
                                <x-icon name="users" size="sm" class="text-white" />
                            </div>
                            @endfor
                        </div>
                        <div>
                            <div class="flex items-center gap-1">
                                <p class="font-extrabold text-sm" style="color: var(--text-heading);">50+ Sekolah & Instansi</p>
                                <span class="text-xs font-bold text-amber-500">★ 4.9/5</span>
                            </div>
                            <p class="text-xs" style="color: var(--text-muted);">Dipercaya untuk pengelolaan sarana sekolah modern</p>
                        </div>
                    </div>

                </div>

                {{-- ====== RIGHT: DASHBOARD PREVIEW CARD WITH FLOATING NOTIFICATIONS ====== --}}
                <div class="lg:col-span-5 relative mt-6 lg:mt-0">

                    {{-- Main Floating Container --}}
                    <div class="relative max-w-md mx-auto lg:max-w-none animate-float">

                        {{-- Glow background behind card --}}
                        <div class="absolute -inset-2 rounded-3xl opacity-30 blur-2xl pointer-events-none"
                             style="background: linear-gradient(135deg, #4F46E5, #7C3AED, #EC4899);"></div>

                        {{-- Dashboard Preview Window --}}
                        <div class="relative rounded-3xl p-6 sm:p-7 shadow-2xl transition-all duration-300"
                             style="background: var(--bg-card); border: 1.5px solid var(--border-card); box-shadow: 0 25px 60px -15px rgba(79,70,229,0.25);">

                            {{-- Top Bar Header --}}
                            <div class="flex items-center justify-between mb-6 pb-4 border-b" style="border-color: var(--border-card);">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-2xl bg-gradient-to-br from-indigo-500 to-violet-600 flex items-center justify-center shadow-md shadow-indigo-500/30">
                                        <x-icon name="chart-bar" size="md" class="text-white" />
                                    </div>
                                    <div>
                                        <p class="font-bold text-base leading-tight" style="color: var(--text-heading);">Dashboard SIPBAR</p>
                                        <p class="text-xs" style="color: var(--text-muted);">Real-time Analytics</p>
                                    </div>
                                </div>
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold text-emerald-500"
                                      style="background: rgba(34,197,94,0.12);">
                                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                                    Sistem Live
                                </span>
                            </div>

                            {{-- Stats Cards Row --}}
                            <div class="grid grid-cols-2 gap-3 mb-6">
                                <div class="p-4 rounded-2xl transition-all duration-300"
                                     style="background: linear-gradient(135deg, rgba(79,70,229,0.12), rgba(79,70,229,0.04)); border: 1px solid rgba(79,70,229,0.2);">
                                    <div class="flex items-center gap-2 mb-1.5">
                                        <x-icon name="cube" size="sm" class="text-indigo-500" />
                                        <span class="text-xs font-semibold text-indigo-500">Total Barang</span>
                                    </div>
                                    <p class="text-2xl font-black" style="color: var(--text-heading);">150</p>
                                    <p class="text-[11px] text-indigo-500 font-semibold flex items-center gap-1 mt-1">
                                        <x-icon name="arrow-trending-up" size="xs" />
                                        +12 bulan ini
                                    </p>
                                </div>

                                <div class="p-4 rounded-2xl transition-all duration-300"
                                     style="background: linear-gradient(135deg, rgba(124,58,237,0.12), rgba(124,58,237,0.04)); border: 1px solid rgba(124,58,237,0.2);">
                                    <div class="flex items-center gap-2 mb-1.5">
                                        <x-icon name="refresh" size="sm" class="text-violet-500" />
                                        <span class="text-xs font-semibold text-violet-500">Sedang Dipinjam</span>
                                    </div>
                                    <p class="text-2xl font-black" style="color: var(--text-heading);">23</p>
                                    <p class="text-[11px] text-violet-500 font-semibold flex items-center gap-1 mt-1">
                                        <x-icon name="clock" size="xs" />
                                        Aktif saat ini
                                    </p>
                                </div>
                            </div>

                            {{-- Activity Chart Simulation --}}
                            <div class="p-4 rounded-2xl transition-colors duration-300" style="background: var(--bg-card-alt);">
                                <div class="flex items-center justify-between mb-3">
                                    <p class="text-xs font-bold" style="color: var(--text-heading);">Grafik Peminjaman (7 Hari)</p>
                                    <span class="text-[10px] font-semibold text-indigo-500 uppercase tracking-wider">Tingkat Tinggi</span>
                                </div>
                                <div class="flex items-end gap-2.5 h-24 pt-2">
                                    @foreach([55, 80, 60, 95, 75, 85, 100] as $height)
                                    <div class="flex-1 rounded-t-lg transition-all duration-300 hover:opacity-80 cursor-pointer"
                                         style="height: {{ $height }}%; background: linear-gradient(to top, #4F46E5, #7C3AED);"></div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        {{-- Floating Real-time Notification #1 (Top Right) --}}
                        <div class="hidden sm:flex absolute -top-7 -right-6 items-center gap-3 p-3.5 rounded-2xl shadow-xl z-20 transition-all duration-300 hover:scale-105"
                             style="background: var(--bg-card); border: 1.5px solid var(--border-card); box-shadow: 0 15px 35px rgba(0,0,0,0.2); animation: floatSlow 5s ease-in-out infinite;">
                            <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0" style="background: rgba(34,197,94,0.15);">
                                <x-icon name="check-circle" size="md" class="text-emerald-500" />
                            </div>
                            <div>
                                <p class="text-xs font-bold leading-tight" style="color: var(--text-heading);">Peminjaman Disetujui</p>
                                <p class="text-[11px] mt-0.5" style="color: var(--text-muted);">Laptop Pro #23 • Budi S.</p>
                            </div>
                        </div>

                        {{-- Floating Real-time Notification #2 (Bottom Left) --}}
                        <div class="hidden sm:flex absolute -bottom-7 -left-6 items-center gap-3 p-3.5 rounded-2xl shadow-xl z-20 transition-all duration-300 hover:scale-105"
                             style="background: var(--bg-card); border: 1.5px solid var(--border-card); box-shadow: 0 15px 35px rgba(0,0,0,0.2); animation: floatSlow 7s ease-in-out infinite 1s;">
                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-indigo-500 to-pink-500 flex items-center justify-center font-bold text-white text-xs shadow-md">
                                AD
                            </div>
                            <div>
                                <div class="flex items-center gap-1.5">
                                    <p class="text-xs font-bold leading-tight" style="color: var(--text-heading);">Admin Sarpras</p>
                                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                </div>
                                <p class="text-[11px] mt-0.5" style="color: var(--text-muted);">Online — Siap Melayani</p>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- ============================================================ --}}
    {{-- FEATURES SECTION (FITUR UNGGULAN)                            --}}
    {{-- ============================================================ --}}
    <section id="fitur" class="py-24 transition-colors duration-300 relative overflow-hidden"
             style="background-color: var(--bg-section);">
        
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 relative z-10">

            {{-- Section Header --}}
            <div class="text-center max-w-3xl mx-auto mb-16 reveal">
                <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider mb-4"
                      style="background: rgba(79,70,229,0.12); color: var(--accent-from); border: 1px solid rgba(79,70,229,0.2);">
                    <x-icon name="sparkles" size="sm" />
                    Fitur Unggulan
                </span>
                <h2 class="text-3xl sm:text-5xl font-extrabold mb-4 transition-colors duration-300" style="color: var(--text-heading);">
                    Semua yang Anda Butuhkan
                </h2>
                <p class="text-lg sm:text-xl transition-colors duration-300" style="color: var(--text-body);">
                    Fitur terlengkap untuk digitalisasi tata kelola sarana prasarana sekolah secara efisien.
                </p>
            </div>

            {{-- Features Grid (6 Cards) --}}
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach([
                    [
                        'icon'  => 'document-text',
                        'title' => 'Pengajuan Online',
                        'desc'  => 'Guru dan siswa dapat mengajukan peminjaman kapan saja via form digital intuitif.',
                        'gradient' => 'from-indigo-600 to-indigo-700',
                        'icon_color' => 'text-indigo-400'
                    ],
                    [
                        'icon'  => 'check-circle',
                        'title' => 'Approval Cepat',
                        'desc'  => 'Proses verifikasi dan persetujuan admin hanya butuh hitungan detik tanpa berkas fisik.',
                        'gradient' => 'from-emerald-600 to-emerald-700',
                        'icon_color' => 'text-emerald-400'
                    ],
                    [
                        'icon'  => 'refresh',
                        'title' => 'Tracking Real-time',
                        'desc'  => 'Pantau posisi barang, status ketersediaan, peminjam aktif, dan tenggat waktu secara tepat.',
                        'gradient' => 'from-violet-600 to-violet-700',
                        'icon_color' => 'text-violet-400'
                    ],
                    [
                        'icon'  => 'chart-bar',
                        'title' => 'Laporan Otomatis',
                        'desc'  => 'Ekspor laporan peminjaman dan rekapitulasi inventaris secara otomatis dan rapi.',
                        'gradient' => 'from-rose-600 to-rose-700',
                        'icon_color' => 'text-rose-400'
                    ],
                    [
                        'icon'  => 'bell',
                        'title' => 'Notifikasi Pintar',
                        'desc'  => 'Pengingat otomatis saat barang mendekati masa jatuh tempo pengembalian.',
                        'gradient' => 'from-amber-600 to-amber-700',
                        'icon_color' => 'text-amber-400'
                    ],
                    [
                        'icon'  => 'shield-check',
                        'title' => 'Keamanan Data',
                        'desc'  => 'Data tersimpan dengan enkripsi tinggi dan kontrol akses berbasis peran (Role-based).',
                        'gradient' => 'from-cyan-600 to-cyan-700',
                        'icon_color' => 'text-cyan-400'
                    ],
                ] as $index => $feature)
                <div class="reveal group" style="transition-delay: {{ $index * 0.1 }}s;">
                    <div class="h-full rounded-3xl p-7 transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl"
                         style="background: var(--bg-card); border: 1.5px solid var(--border-card);"
                         onmouseover="this.style.borderColor='rgba(79,70,229,0.4)';"
                         onmouseout="this.style.borderColor='var(--border-card)';">
                        <div class="w-14 h-14 rounded-2xl bg-gradient-to-br {{ $feature['gradient'] }} flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300 shadow-md">
                            <x-icon :name="$feature['icon']" size="xl" class="text-white" />
                        </div>
                        <h3 class="text-xl font-bold mb-3 transition-colors duration-300" style="color: var(--text-heading);">
                            {{ $feature['title'] }}
                        </h3>
                        <p class="leading-relaxed text-sm sm:text-base transition-colors duration-300" style="color: var(--text-body);">
                            {{ $feature['desc'] }}
                        </p>
                    </div>
                </div>
                @endforeach
            </div>

        </div>
    </section>

    {{-- ============================================================ --}}
    {{-- HOW IT WORKS SECTION (CARA KERJA)                            --}}
    {{-- ============================================================ --}}
    <section id="cara-kerja" class="py-24 transition-colors duration-300 relative" style="background: var(--bg-primary);">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            {{-- Section Header --}}
            <div class="text-center max-w-3xl mx-auto mb-20 reveal">
                <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider mb-4"
                      style="background: rgba(124,58,237,0.12); color: #7C3AED; border: 1px solid rgba(124,58,237,0.2);">
                    <x-icon name="sparkles" size="sm" />
                    Mudah & Praktis
                </span>
                <h2 class="text-3xl sm:text-5xl font-extrabold mb-4 transition-colors duration-300" style="color: var(--text-heading);">
                    4 Langkah Sederhana
                </h2>
                <p class="text-lg sm:text-xl transition-colors duration-300" style="color: var(--text-body);">
                    Alur kerja terstruktur yang dirancang khusus untuk kenyamanan guru, siswa, dan pengelola.
                </p>
            </div>

            {{-- Step Timeline Cards Grid --}}
            <div class="relative">
                {{-- Desktop Connecting Gradient Line --}}
                <div class="hidden lg:block absolute top-28 left-12 right-12 h-1 rounded-full pointer-events-none"
                     style="background: linear-gradient(90deg, #4F46E5 0%, #7C3AED 50%, #EC4899 100%); opacity: 0.3;"></div>

                <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                    @foreach([
                        ['num' => '01', 'icon' => 'document-text', 'title' => 'Ajukan',       'desc' => 'Pilih barang dan isi formulir peminjaman secara online.'],
                        ['num' => '02', 'icon' => 'check-circle',  'title' => 'Persetujuan','desc' => 'Admin meninjau dan memberikan verifikasi persetujuan.'],
                        ['num' => '03', 'icon' => 'cube',          'title' => 'Ambil Barang', 'desc' => 'Ambil barang di ruang pengelola/gudang sekolah.'],
                        ['num' => '04', 'icon' => 'refresh',       'title' => 'Kembalikan',   'desc' => 'Kembalikan barang tepat waktu sebelum jatuh tempo.'],
                    ] as $index => $step)
                    <div class="reveal relative" style="transition-delay: {{ $index * 0.15 }}s;">
                        <div class="h-full rounded-3xl p-7 transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl relative"
                             style="background: var(--bg-card); border: 1.5px solid var(--border-card);"
                             onmouseover="this.style.borderColor='#4F46E5';"
                             onmouseout="this.style.borderColor='var(--border-card)';">
                            
                            {{-- Step Number Pill Badge --}}
                            <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-indigo-600 to-violet-600 flex items-center justify-center text-white font-black text-lg shadow-lg shadow-indigo-500/30 mb-6">
                                {{ $step['num'] }}
                            </div>

                            {{-- Step Icon & Text --}}
                            <div class="w-12 h-12 rounded-xl flex items-center justify-center mb-5" style="background: rgba(79,70,229,0.1);">
                                <x-icon :name="$step['icon']" size="lg" class="text-indigo-500" />
                            </div>

                            <h3 class="text-xl font-bold mb-2 transition-colors duration-300" style="color: var(--text-heading);">
                                {{ $step['title'] }}
                            </h3>
                            <p class="text-sm leading-relaxed transition-colors duration-300" style="color: var(--text-body);">
                                {{ $step['desc'] }}
                            </p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

        </div>
    </section>

    {{-- ============================================================ --}}
    {{-- STATISTICS & SOCIAL PROOF SECTION                            --}}
    {{-- ============================================================ --}}
    <section id="statistik" class="py-20 transition-colors duration-300 relative overflow-hidden"
             style="background-color: var(--bg-section);">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            {{-- Metrics Grid --}}
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 reveal">
                <div class="p-6 rounded-3xl text-center transition-all duration-300 hover:scale-105"
                     style="background: var(--bg-card); border: 1.5px solid var(--border-card);">
                    <p class="text-4xl sm:text-5xl font-black text-indigo-500 mb-1">150+</p>
                    <p class="text-xs sm:text-sm font-semibold" style="color: var(--text-body);">Barang Inventaris Terdaftar</p>
                </div>
                <div class="p-6 rounded-3xl text-center transition-all duration-300 hover:scale-105"
                     style="background: var(--bg-card); border: 1.5px solid var(--border-card);">
                    <p class="text-4xl sm:text-5xl font-black text-violet-500 mb-1">50+</p>
                    <p class="text-xs sm:text-sm font-semibold" style="color: var(--text-body);">Sekolah & Instansi</p>
                </div>
                <div class="p-6 rounded-3xl text-center transition-all duration-300 hover:scale-105"
                     style="background: var(--bg-card); border: 1.5px solid var(--border-card);">
                    <p class="text-4xl sm:text-5xl font-black text-emerald-500 mb-1">99.9%</p>
                    <p class="text-xs sm:text-sm font-semibold" style="color: var(--text-body);">Akurasi Data Barang</p>
                </div>
                <div class="p-6 rounded-3xl text-center transition-all duration-300 hover:scale-105"
                     style="background: var(--bg-card); border: 1.5px solid var(--border-card);">
                    <p class="text-4xl sm:text-5xl font-black text-rose-500 mb-1">&lt; 5m</p>
                    <p class="text-xs sm:text-sm font-semibold" style="color: var(--text-body);">Proses Approval Cepat</p>
                </div>
            </div>

            {{-- Quote Banner --}}
            <div class="mt-12 p-8 sm:p-10 rounded-3xl reveal transition-all duration-300"
                 style="background: var(--bg-card); border: 1.5px solid var(--border-card);">
                <div class="flex flex-col sm:flex-row items-center gap-6 text-center sm:text-left">
                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-indigo-500 to-violet-600 flex items-center justify-center text-white font-bold text-2xl flex-shrink-0 shadow-lg">
                        “
                    </div>
                    <div>
                        <p class="text-base sm:text-lg italic font-medium leading-relaxed mb-3" style="color: var(--text-heading);">
                            "SIPBAR mengubah tata kelola laboratorium dan barang inventaris sekolah kami menjadi jauh lebih rapi. Tidak ada lagi barang hilang tanpa kejelasan."
                        </p>
                        <p class="text-sm font-bold text-indigo-500">Dra. Hj. Ratna S. — Wakasek Sarpras Sekolah</p>
                    </div>
                </div>
            </div>

        </div>
    </section>

    {{-- ============================================================ --}}
    {{-- CONTACT & FINAL CTA SECTION                                  --}}
    {{-- ============================================================ --}}
    <section id="kontak" class="py-24 relative overflow-hidden transition-colors duration-300"
             style="background: linear-gradient(135deg, #4F46E5 0%, #6366F1 50%, #7C3AED 100%);">
        
        {{-- Background Glowing Texture Patterns --}}
        <div class="absolute inset-0 pointer-events-none opacity-20">
            <div class="absolute top-0 left-0 w-[500px] h-[500px] bg-white rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 right-0 w-[500px] h-[500px] bg-purple-300 rounded-full blur-3xl"></div>
        </div>

        <div class="relative z-10 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 text-white">
            <div class="grid lg:grid-cols-12 gap-12 items-center">

                {{-- Left Content --}}
                <div class="lg:col-span-7 space-y-8 reveal">
                    <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider bg-white/20 backdrop-blur-md border border-white/30 text-white">
                        <x-icon name="sparkles" size="sm" />
                        Modernisasi Sarana Sekolah
                    </span>

                    <h2 class="text-4xl sm:text-5xl font-black leading-tight">
                        Siap Modernisasi<br>Sekolah Anda Hari Ini?
                    </h2>
                    <p class="text-lg sm:text-xl text-indigo-100 max-w-xl leading-relaxed">
                        Bergabunglah dengan puluhan sekolah di Indonesia yang telah mengadopsi SIPBAR untuk pengelolaan inventaris yang lebih efisien.
                    </p>

                    <div class="flex flex-wrap items-center gap-4 pt-2">
                        <a href="{{ route('login') }}"
                           class="inline-flex items-center gap-3 px-8 py-4 rounded-2xl bg-white text-indigo-600 font-extrabold text-base shadow-2xl hover:bg-indigo-50 hover:scale-105 transition-all duration-300">
                            <span>Mulai Gratis Sekarang</span>
                            <x-icon name="arrow-right" size="md" />
                        </a>
                        <a href="#fitur"
                           class="inline-flex items-center gap-2 px-8 py-4 rounded-2xl bg-white/10 backdrop-blur-md border-2 border-white/30 text-white font-bold text-base hover:bg-white/20 transition-all duration-300">
                            <x-icon name="sparkles" size="md" />
                            <span>Pelajari Fitur</span>
                        </a>
                    </div>

                    {{-- School Contact Info List --}}
                    <div class="pt-6 border-t border-white/20 space-y-4">
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 rounded-xl bg-white/15 border border-white/25 flex items-center justify-center flex-shrink-0 mt-0.5">
                                <x-icon name="map-pin" size="md" class="text-white" />
                            </div>
                            <div>
                                <p class="font-bold text-sm text-white">SMK Negeri Contoh</p>
                                <p class="text-xs text-indigo-100">Jl. Pendidikan No. 123, Jakarta 10110</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-white/15 border border-white/25 flex items-center justify-center flex-shrink-0">
                                <x-icon name="envelope" size="md" class="text-white" />
                            </div>
                            <a href="mailto:gudang@sekolah.sch.id" class="text-sm text-indigo-100 hover:text-white transition-colors">
                                gudang@sekolah.sch.id
                            </a>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-white/15 border border-white/25 flex items-center justify-center flex-shrink-0">
                                <x-icon name="phone" size="md" class="text-white" />
                            </div>
                            <a href="tel:+622112345678" class="text-sm text-indigo-100 hover:text-white transition-colors">
                                (021) 1234-5678
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Right Side Checklist Card --}}
                <div class="lg:col-span-5 reveal">
                    <div class="rounded-3xl p-8 bg-white/10 backdrop-blur-xl border border-white/25 shadow-2xl space-y-6">
                        <h3 class="text-2xl font-bold text-white mb-6">Keunggulan Utama SIPBAR</h3>

                        @foreach([
                            ['title' => '100% Gratis',       'sub' => 'Bebas biaya pendaftaran dan setup awal.'],
                            ['title' => 'Setup 10 Menit',    'sub' => 'Langsung siap pakai tanpa instalasi rumit.'],
                            ['title' => 'Support 24/7',      'sub' => 'Tim teknis kami selalu siap membantu.'],
                            ['title' => 'Keamanan Terjamin', 'sub' => 'Data inventaris terenkripsi dengan aman.'],
                        ] as $check)
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-xl bg-white/20 border border-white/30 flex items-center justify-center flex-shrink-0 text-white font-bold">
                                ✓
                            </div>
                            <div>
                                <p class="font-bold text-base text-white">{{ $check['title'] }}</p>
                                <p class="text-xs text-indigo-100">{{ $check['sub'] }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    </section>

@endsection
