@extends('layouts.guest')

@section('content')

{{-- ===== HERO SECTION ===== --}}
<section id="home" class="relative min-h-[92vh] flex items-center overflow-hidden py-20 lg:py-24">

    {{-- Layered Background --}}
    <div class="absolute inset-0 bg-gradient-to-br from-slate-50 via-blue-50/60 to-indigo-50/80"></div>
    <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_left,rgba(99,102,241,0.08)_0%,transparent_60%)]"></div>
    <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_bottom_right,rgba(59,130,246,0.06)_0%,transparent_60%)]"></div>
    <div class="absolute inset-0 bg-[radial-gradient(#6366f1_1px,transparent_1px)] [background-size:44px_44px] opacity-[0.035]"></div>

    {{-- Animated Orbs --}}
    <div class="absolute top-10 right-[5%] w-[500px] h-[500px] bg-blue-400/8 rounded-full blur-[120px] animate-pulse pointer-events-none"></div>
    <div class="absolute -bottom-20 left-[5%] w-[450px] h-[450px] bg-indigo-500/6 rounded-full blur-[100px] animate-pulse pointer-events-none" style="animation-delay:2s;"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[400px] bg-violet-400/5 rounded-full blur-[150px] pointer-events-none"></div>

    <div class="relative z-10 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 w-full">
        <div class="grid lg:grid-cols-2 gap-14 lg:gap-20 items-center">

            {{-- Left: Hero Text --}}
            <div class="space-y-8 text-center lg:text-left">

                {{-- Status Badge --}}
                <div class="inline-flex items-center gap-2.5 px-4 py-2 rounded-full bg-white border border-blue-200 shadow-sm shadow-blue-500/10 text-xs font-bold text-blue-700">
                    <span class="relative flex h-2.5 w-2.5">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-500"></span>
                    </span>
                    Sistem Aktif & Siap Digunakan
                    <span class="px-2 py-0.5 bg-blue-100 rounded-full text-blue-800 text-[10px]">v2.0</span>
                </div>

                {{-- Headline --}}
                <div class="space-y-5">
                    <h1 class="text-5xl sm:text-6xl xl:text-7xl font-black tracking-tight leading-[1.05] text-slate-900">
                        Kelola
                        <span class="relative inline-block">
                            <span class="bg-gradient-to-r from-blue-600 via-indigo-600 to-violet-600 bg-clip-text text-transparent">Inventaris</span>
                            <svg class="absolute -bottom-2 left-0 w-full" viewBox="0 0 200 8" fill="none"><path d="M0 6 Q100 0 200 6" stroke="url(#u)" stroke-width="3" stroke-linecap="round"/><defs><linearGradient id="u" x1="0" y1="0" x2="200" y2="0" gradientUnits="userSpaceOnUse"><stop stop-color="#3b82f6"/><stop offset="1" stop-color="#8b5cf6"/></linearGradient></defs></svg>
                        </span>
                        <br>Sekolah Modern
                    </h1>
                    <p class="text-lg xl:text-xl text-slate-600 leading-relaxed max-w-xl mx-auto lg:mx-0 font-normal">
                        SIPBAR mentransformasi proses peminjaman inventaris sekolah secara <strong class="text-slate-800 font-semibold">100% digital</strong>. Transparan, real-time, dan dapat dipantau dari mana saja.
                    </p>
                </div>

                {{-- Social Proof Stats --}}
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                    <div class="p-4 rounded-2xl bg-white border border-slate-200/80 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all text-center">
                        <p class="text-2xl font-black bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">100%</p>
                        <p class="text-[11px] text-slate-500 font-semibold mt-0.5">Paperless</p>
                    </div>
                    <div class="p-4 rounded-2xl bg-white border border-slate-200/80 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all text-center">
                        <p class="text-2xl font-black bg-gradient-to-r from-indigo-600 to-violet-600 bg-clip-text text-transparent">Live</p>
                        <p class="text-[11px] text-slate-500 font-semibold mt-0.5">Real-Time</p>
                    </div>
                    <div class="p-4 rounded-2xl bg-white border border-slate-200/80 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all text-center">
                        <p class="text-2xl font-black bg-gradient-to-r from-emerald-600 to-teal-600 bg-clip-text text-transparent">🔐</p>
                        <p class="text-[11px] text-slate-500 font-semibold mt-0.5">Passkey</p>
                    </div>
                    <div class="p-4 rounded-2xl bg-white border border-slate-200/80 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all text-center">
                        <p class="text-2xl font-black bg-gradient-to-r from-violet-600 to-purple-600 bg-clip-text text-transparent">3</p>
                        <p class="text-[11px] text-slate-500 font-semibold mt-0.5">Akses Peran</p>
                    </div>
                </div>

                {{-- CTA Buttons --}}
                <div class="flex flex-col sm:flex-row gap-3 justify-center lg:justify-start">
                    <a href="{{ route('login') }}" class="group relative inline-flex items-center justify-center gap-2.5 px-8 py-4 rounded-2xl bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-extrabold text-sm shadow-xl shadow-blue-500/30 hover:shadow-2xl hover:shadow-blue-500/45 hover:scale-[1.03] transition-all duration-300 overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-r from-indigo-600 to-blue-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        <svg class="relative w-5 h-5 group-hover:rotate-12 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        <span class="relative">Mulai Gratis Sekarang</span>
                    </a>
                    <a href="#fitur" class="inline-flex items-center justify-center gap-2.5 px-8 py-4 rounded-2xl bg-white text-slate-700 font-bold text-sm border border-slate-200 shadow-sm hover:bg-blue-50 hover:border-blue-200 hover:text-blue-700 hover:scale-[1.02] transition-all duration-200">
                        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Lihat Demo
                    </a>
                </div>

                {{-- Trust Line --}}
                <div class="flex items-center gap-2 justify-center lg:justify-start text-xs text-slate-400 font-medium">
                    <svg class="w-4 h-4 text-emerald-500" fill="currentColor" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    <span>Gratis • Tidak Perlu Kartu Kredit • Setup 5 Menit</span>
                </div>
            </div>

            {{-- Right: Premium Dashboard Preview --}}
            <div class="relative hidden lg:flex justify-center">
                {{-- Floating decoration --}}
                <div class="absolute -top-8 -left-8 w-32 h-32 bg-blue-400/15 rounded-3xl blur-2xl"></div>
                <div class="absolute -bottom-8 -right-8 w-40 h-40 bg-violet-400/10 rounded-full blur-3xl"></div>

                {{-- Main Card --}}
                <div class="relative w-full max-w-[480px] bg-white rounded-[28px] shadow-2xl shadow-slate-300/40 border border-slate-100 overflow-hidden">
                    {{-- Card Top Bar --}}
                    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-5 py-4 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <div class="w-7 h-7 rounded-lg bg-white/20 flex items-center justify-center">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                            </div>
                            <div>
                                <p class="text-white font-extrabold text-sm leading-none">SIPBAR</p>
                                <p class="text-blue-200 text-[10px] leading-none mt-0.5">Dashboard Overview</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2.5">
                            <div class="flex gap-1.5">
                                <div class="w-2.5 h-2.5 rounded-full bg-rose-400"></div>
                                <div class="w-2.5 h-2.5 rounded-full bg-amber-400"></div>
                                <div class="w-2.5 h-2.5 rounded-full bg-emerald-400"></div>
                            </div>
                        </div>
                    </div>

                    <div class="p-5 bg-gradient-to-b from-slate-50 to-white">
                        {{-- KPI Cards Row --}}
                        <div class="grid grid-cols-2 gap-3 mb-4">
                            <div class="p-4 rounded-2xl bg-gradient-to-br from-blue-500 to-blue-700 text-white shadow-md shadow-blue-500/25">
                                <p class="text-[10px] font-bold text-blue-200 uppercase tracking-wider">Total Barang</p>
                                <p class="text-3xl font-black mt-1">248</p>
                                <div class="flex items-center gap-1 mt-2">
                                    <svg class="w-3 h-3 text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg>
                                    <span class="text-[10px] text-emerald-300 font-bold">+12 bulan ini</span>
                                </div>
                            </div>
                            <div class="p-4 rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-600 text-white shadow-md shadow-emerald-500/25">
                                <p class="text-[10px] font-bold text-emerald-200 uppercase tracking-wider">Dipinjam</p>
                                <p class="text-3xl font-black mt-1">32</p>
                                <div class="flex items-center gap-1 mt-2">
                                    <span class="w-2 h-2 rounded-full bg-emerald-300 animate-pulse inline-block"></span>
                                    <span class="text-[10px] text-emerald-200 font-bold">Aktif sekarang</span>
                                </div>
                            </div>
                            <div class="p-4 rounded-2xl bg-gradient-to-br from-amber-400 to-orange-500 text-white shadow-md shadow-amber-500/25">
                                <p class="text-[10px] font-bold text-amber-100 uppercase tracking-wider">Pending</p>
                                <p class="text-3xl font-black mt-1">7</p>
                                <p class="text-[10px] text-amber-200 font-bold mt-2">Butuh Persetujuan</p>
                            </div>
                            <div class="p-4 rounded-2xl bg-gradient-to-br from-violet-500 to-purple-700 text-white shadow-md shadow-violet-500/25">
                                <p class="text-[10px] font-bold text-violet-200 uppercase tracking-wider">User Aktif</p>
                                <p class="text-3xl font-black mt-1">120</p>
                                <p class="text-[10px] text-violet-200 font-bold mt-2">Terdaftar</p>
                            </div>
                        </div>

                        {{-- Recent Activity --}}
                        <div class="bg-white rounded-2xl border border-slate-100 overflow-hidden shadow-sm">
                            <div class="px-4 py-3 border-b border-slate-100 flex items-center justify-between">
                                <p class="text-xs font-extrabold text-slate-900">Aktivitas Terbaru</p>
                                <span class="text-[10px] text-blue-600 font-bold cursor-pointer">Lihat Semua</span>
                            </div>
                            <div class="divide-y divide-slate-50">
                                <div class="flex items-center justify-between px-4 py-3">
                                    <div class="flex items-center gap-2.5">
                                        <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 text-white flex items-center justify-center text-xs font-black shadow-sm">A</div>
                                        <div>
                                            <p class="text-xs font-bold text-slate-800">Ahmad Rizal</p>
                                            <p class="text-[10px] text-slate-400">Laptop Dell — 3 hari</p>
                                        </div>
                                    </div>
                                    <span class="px-2 py-1 rounded-full bg-emerald-100 text-emerald-700 text-[10px] font-bold">Aktif</span>
                                </div>
                                <div class="flex items-center justify-between px-4 py-3">
                                    <div class="flex items-center gap-2.5">
                                        <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-amber-400 to-orange-500 text-white flex items-center justify-center text-xs font-black shadow-sm">S</div>
                                        <div>
                                            <p class="text-xs font-bold text-slate-800">Siti Nurhaliza</p>
                                            <p class="text-[10px] text-slate-400">Proyektor — Review</p>
                                        </div>
                                    </div>
                                    <span class="px-2 py-1 rounded-full bg-amber-100 text-amber-700 text-[10px] font-bold">Pending</span>
                                </div>
                                <div class="flex items-center justify-between px-4 py-3">
                                    <div class="flex items-center gap-2.5">
                                        <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-violet-500 to-purple-600 text-white flex items-center justify-center text-xs font-black shadow-sm">B</div>
                                        <div>
                                            <p class="text-xs font-bold text-slate-800">Budi Santoso</p>
                                            <p class="text-[10px] text-slate-400">Kamera DSLR — 1 hari</p>
                                        </div>
                                    </div>
                                    <span class="px-2 py-1 rounded-full bg-rose-100 text-rose-700 text-[10px] font-bold">Terlambat</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Floating Badges --}}
                <div class="absolute -top-4 -right-4 badge-float bg-white rounded-2xl shadow-xl shadow-emerald-500/15 border border-emerald-100 px-3.5 py-2.5 flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-xl bg-emerald-100 flex items-center justify-center">
                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <p class="text-xs font-extrabold text-slate-900">Disetujui!</p>
                        <p class="text-[10px] text-emerald-600 font-semibold">Peminjaman #BR-128</p>
                    </div>
                </div>

                <div class="absolute -bottom-4 -left-4 badge-float bg-white rounded-2xl shadow-xl shadow-blue-500/15 border border-blue-100 px-3.5 py-2.5 flex items-center gap-2.5" style="animation-delay:1.2s;">
                    <div class="w-8 h-8 rounded-xl bg-blue-100 flex items-center justify-center">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    </div>
                    <div>
                        <p class="text-xs font-extrabold text-slate-900">Passkey Login</p>
                        <p class="text-[10px] text-blue-600 font-semibold">Aman & Cepat</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ===== TRUSTED BY SECTION ===== --}}
<section class="py-12 bg-white border-y border-slate-100">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row items-center justify-between gap-6">
            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest flex-shrink-0">Dipercaya Untuk</p>
            <div class="flex flex-wrap items-center justify-center gap-8 opacity-50">
                @foreach(['SMK Teknologi', 'SMK Bisnis', 'SMA Negeri', 'MAN Unggulan', 'SMK Pertanian'] as $school)
                <span class="text-slate-700 font-extrabold text-sm tracking-tight">{{ $school }}</span>
                @endforeach
            </div>
        </div>
    </div>
</section>

{{-- ===== FEATURES SECTION ===== --}}
<section id="fitur" class="py-24 bg-gradient-to-b from-white to-slate-50/80">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <span class="inline-block px-4 py-1.5 rounded-full bg-blue-100 text-blue-700 text-xs font-bold uppercase tracking-wider mb-4">✨ Fitur Unggulan</span>
            <h2 class="text-4xl md:text-5xl font-black text-slate-900 tracking-tight">Semua Fitur yang Anda Butuhkan</h2>
            <p class="mt-4 text-lg text-slate-600 max-w-2xl mx-auto font-normal leading-relaxed">Platform lengkap untuk mengelola seluruh siklus peminjaman inventaris sekolah dengan mudah, cepat, dan akurat.</p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-5">
            @php
            $features = [
                ['icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z', 'from' => 'blue-500', 'to' => 'blue-700', 'bg' => 'blue-50', 'text' => 'blue-600', 'title' => 'Pengajuan Digital', 'desc' => 'Ajukan peminjaman kapan saja, dari mana saja. Tidak perlu antri atau isi formulir kertas yang memakan waktu.'],
                ['icon' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z', 'from' => 'indigo-500', 'to' => 'indigo-700', 'bg' => 'indigo-50', 'text' => 'indigo-600', 'title' => 'Dashboard Real-Time', 'desc' => 'Pantau seluruh status barang, peminjaman aktif, dan notifikasi keterlambatan secara langsung dan akurat.'],
                ['icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z', 'from' => 'emerald-500', 'to' => 'teal-600', 'bg' => 'emerald-50', 'text' => 'emerald-600', 'title' => 'Laporan & Ekspor', 'desc' => 'Generate laporan peminjaman per periode, ekspor ke PDF atau Excel untuk keperluan administrasi dan audit.'],
                ['icon' => 'M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9', 'from' => 'amber-400', 'to' => 'orange-500', 'bg' => 'amber-50', 'text' => 'amber-600', 'title' => 'Notifikasi Pintar', 'desc' => 'Sistem otomatis mendeteksi dan menandai peminjaman yang melewati batas waktu pengembalian.'],
                ['icon' => 'M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z', 'from' => 'violet-500', 'to' => 'purple-700', 'bg' => 'violet-50', 'text' => 'violet-600', 'title' => 'Passkey WebAuthn', 'desc' => 'Keamanan tingkat enterprise dengan WebAuthn Passkey — autentikasi tanpa password yang aman dan modern.'],
                ['icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z', 'from' => 'rose-500', 'to' => 'pink-600', 'bg' => 'rose-50', 'text' => 'rose-600', 'title' => 'Multi-Role Access', 'desc' => 'Tiga tingkat akses — Admin, Petugas Gudang, dan Peminjam — dengan hak akses yang tepat dan terstruktur.'],
            ];
            @endphp

            @foreach($features as $i => $f)
            <div class="group relative p-7 rounded-3xl bg-white border border-slate-200/80 shadow-sm hover:shadow-xl hover:shadow-{{ $f['text'] }}/8 hover:-translate-y-1.5 transition-all duration-300 cursor-default overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-br from-{{ $f['bg'] }}/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-3xl"></div>
                <div class="relative z-10">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-{{ $f['from'] }} to-{{ $f['to'] }} flex items-center justify-center mb-5 shadow-lg shadow-{{ $f['text'] }}/25 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="{{ $f['icon'] }}"/></svg>
                    </div>
                    <h3 class="text-lg font-extrabold text-slate-900 mb-2 group-hover:text-{{ $f['text'] }} transition-colors">{{ $f['title'] }}</h3>
                    <p class="text-sm text-slate-600 leading-relaxed">{{ $f['desc'] }}</p>
                </div>
                <div class="absolute top-4 right-4 text-{{ $f['bg'] }} opacity-30 group-hover:opacity-60 transition-opacity">
                    <span class="text-6xl font-black">0{{ $i+1 }}</span>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ===== HOW IT WORKS ===== --}}
<section id="cara-kerja" class="py-24 bg-white">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <span class="inline-block px-4 py-1.5 rounded-full bg-indigo-100 text-indigo-700 text-xs font-bold uppercase tracking-wider mb-4">🔄 Cara Kerja</span>
            <h2 class="text-4xl md:text-5xl font-black text-slate-900 tracking-tight">Proses 4 Langkah Mudah</h2>
            <p class="mt-4 text-lg text-slate-600 max-w-xl mx-auto">Dari pengajuan hingga pengembalian, semua terpantau dalam satu platform.</p>
        </div>

        <div class="relative">
            {{-- Connecting Line --}}
            <div class="hidden lg:block absolute top-12 left-[calc(12.5%+1.5rem)] right-[calc(12.5%+1.5rem)] h-0.5">
                <div class="w-full h-full bg-gradient-to-r from-blue-300 via-indigo-300 via-violet-300 to-emerald-300 rounded-full"></div>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                @php
                $steps = [
                    ['num' => '01', 'emoji' => '👤', 'from' => 'blue-500', 'to' => 'blue-700', 'title' => 'Daftar & Masuk', 'desc' => 'Buat akun dengan email sekolah atau daftarkan Passkey untuk login aman tanpa password.'],
                    ['num' => '02', 'emoji' => '📋', 'from' => 'indigo-500', 'to' => 'indigo-700', 'title' => 'Ajukan Peminjaman', 'desc' => 'Pilih barang dari katalog, isi keperluan dan tanggal pengembalian rencana.'],
                    ['num' => '03', 'emoji' => '✅', 'from' => 'violet-500', 'to' => 'violet-700', 'title' => 'Proses Persetujuan', 'desc' => 'Admin mereview, menyetujui, dan petugas gudang menyerahkan barang ke peminjam.'],
                    ['num' => '04', 'emoji' => '📦', 'from' => 'emerald-500', 'to' => 'teal-600', 'title' => 'Kembalikan Tepat Waktu', 'desc' => 'Petugas gudang memverifikasi kondisi dan mencatat pengembalian ke sistem secara real-time.'],
                ];
                @endphp

                @foreach($steps as $step)
                <div class="relative flex flex-col items-center text-center p-7 rounded-3xl bg-white border border-slate-200/80 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
                    <div class="relative mb-5">
                        <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-{{ $step['from'] }} to-{{ $step['to'] }} flex items-center justify-center shadow-lg text-2xl">
                            {{ $step['emoji'] }}
                        </div>
                        <div class="absolute -top-2 -right-2 w-6 h-6 rounded-full bg-slate-900 text-white text-[10px] font-black flex items-center justify-center">{{ $step['num'] }}</div>
                    </div>
                    <h3 class="text-base font-extrabold text-slate-900 mb-2">{{ $step['title'] }}</h3>
                    <p class="text-sm text-slate-600 leading-relaxed">{{ $step['desc'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

{{-- ===== ROLE SECTION ===== --}}
<section class="py-24 bg-gradient-to-br from-slate-50 to-blue-50/50">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14">
            <span class="inline-block px-4 py-1.5 rounded-full bg-violet-100 text-violet-700 text-xs font-bold uppercase tracking-wider mb-4">👥 Akses Per Peran</span>
            <h2 class="text-4xl md:text-5xl font-black text-slate-900 tracking-tight">Satu Sistem, Tiga Peran</h2>
        </div>

        <div class="grid md:grid-cols-3 gap-6">
            <div class="p-8 rounded-3xl bg-gradient-to-br from-blue-600 to-indigo-700 text-white shadow-xl shadow-blue-500/25 hover:-translate-y-1 transition-all">
                <div class="w-14 h-14 rounded-2xl bg-white/20 border border-white/25 flex items-center justify-center text-3xl mb-5">👨‍💼</div>
                <h3 class="text-xl font-extrabold mb-3">Admin</h3>
                <ul class="space-y-2 text-sm text-blue-100">
                    <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-emerald-400 flex-shrink-0"></span>Kelola semua data inventaris</li>
                    <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-emerald-400 flex-shrink-0"></span>Approve / tolak pengajuan</li>
                    <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-emerald-400 flex-shrink-0"></span>Kelola akun pengguna</li>
                    <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-emerald-400 flex-shrink-0"></span>Generate laporan & ekspor</li>
                </ul>
            </div>
            <div class="p-8 rounded-3xl bg-gradient-to-br from-emerald-500 to-teal-700 text-white shadow-xl shadow-emerald-500/25 hover:-translate-y-1 transition-all">
                <div class="w-14 h-14 rounded-2xl bg-white/20 border border-white/25 flex items-center justify-center text-3xl mb-5">🏭</div>
                <h3 class="text-xl font-extrabold mb-3">Petugas Gudang</h3>
                <ul class="space-y-2 text-sm text-emerald-100">
                    <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-amber-300 flex-shrink-0"></span>Verifikasi penyerahan barang</li>
                    <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-amber-300 flex-shrink-0"></span>Verifikasi pengembalian</li>
                    <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-amber-300 flex-shrink-0"></span>Pantau kondisi barang</li>
                    <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-amber-300 flex-shrink-0"></span>Catat keterlambatan</li>
                </ul>
            </div>
            <div class="p-8 rounded-3xl bg-gradient-to-br from-violet-500 to-purple-700 text-white shadow-xl shadow-violet-500/25 hover:-translate-y-1 transition-all">
                <div class="w-14 h-14 rounded-2xl bg-white/20 border border-white/25 flex items-center justify-center text-3xl mb-5">🎓</div>
                <h3 class="text-xl font-extrabold mb-3">Peminjam</h3>
                <ul class="space-y-2 text-sm text-violet-100">
                    <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-pink-300 flex-shrink-0"></span>Ajukan peminjaman online</li>
                    <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-pink-300 flex-shrink-0"></span>Pantau status real-time</li>
                    <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-pink-300 flex-shrink-0"></span>Lihat riwayat peminjaman</li>
                    <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-pink-300 flex-shrink-0"></span>Login dengan Passkey</li>
                </ul>
            </div>
        </div>
    </div>
</section>

{{-- ===== CTA SECTION ===== --}}
<section id="kontak" class="py-24 bg-white">
    <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
        <div class="relative overflow-hidden rounded-[32px] bg-gradient-to-r from-blue-600 via-indigo-600 to-violet-600 p-12 md:p-16 text-white shadow-2xl shadow-indigo-500/30">
            <div class="absolute inset-0 overflow-hidden pointer-events-none">
                <div class="absolute -top-20 -right-20 w-72 h-72 bg-white/8 rounded-full blur-3xl"></div>
                <div class="absolute -bottom-20 -left-20 w-72 h-72 bg-white/6 rounded-full blur-3xl"></div>
                <div class="absolute inset-0 bg-[radial-gradient(#fff_1px,transparent_1px)] [background-size:28px_28px] opacity-[0.04]"></div>
            </div>
            <div class="relative z-10 text-center">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/15 border border-white/25 text-xs font-bold mb-6 badge-float">
                    🚀 Mulai Hari Ini — 100% Gratis
                </div>
                <h2 class="text-4xl md:text-5xl font-black tracking-tight mb-5 leading-tight">
                    Siap Digitalisasi<br>Inventaris Sekolah Anda?
                </h2>
                <p class="text-white/75 text-lg mb-10 max-w-2xl mx-auto leading-relaxed">
                    Bergabunglah dan rasakan kemudahan manajemen inventaris yang modern, transparan, dan efisien.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('register') }}" class="inline-flex items-center justify-center gap-2.5 px-8 py-4 rounded-2xl bg-white text-blue-700 font-extrabold text-sm shadow-xl hover:bg-blue-50 hover:scale-[1.03] transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                        Daftar Akun Gratis
                    </a>
                    <a href="{{ route('login') }}" class="inline-flex items-center justify-center gap-2.5 px-8 py-4 rounded-2xl bg-white/12 border border-white/25 text-white font-bold text-sm hover:bg-white/20 hover:scale-[1.02] transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                        Sudah Punya Akun
                    </a>
                </div>

                {{-- Feature Pills --}}
                <div class="mt-8 flex flex-wrap gap-2 justify-center">
                    @foreach(['✓ Gratis Selamanya', '✓ Tidak Perlu Kartu Kredit', '✓ Setup 5 Menit', '✓ Support Passkey'] as $pill)
                    <span class="px-3 py-1.5 rounded-full bg-white/10 border border-white/20 text-xs font-semibold text-white/90">{{ $pill }}</span>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
