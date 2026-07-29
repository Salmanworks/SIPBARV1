<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('partials.head')
    <title>SIPBAR — Sistem Peminjaman Barang Sekolah</title>
    <style>
        html { scroll-behavior: smooth; }

        /* ===== NAVBAR ===== */
        .navbar {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            background: rgba(255,255,255,0.92);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(226,232,240,0.6);
        }
        .navbar-scrolled {
            background: rgba(255,255,255,0.98);
            backdrop-filter: blur(30px);
            box-shadow: 0 1px 3px rgba(0,0,0,0.05), 0 4px 24px rgba(99,102,241,0.08);
            border-bottom: 1px solid rgba(199,210,254,0.5);
        }

        /* Nav link underline effect */
        .nav-link {
            position: relative;
            font-size: 0.875rem;
            font-weight: 600;
            color: #475569;
            padding: 0.5rem 0.75rem;
            border-radius: 0.75rem;
            transition: all 0.2s ease;
            text-decoration: none;
        }
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 2px;
            left: 50%;
            transform: translateX(-50%);
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, #3b82f6, #6366f1);
            border-radius: 9999px;
            transition: width 0.25s ease;
        }
        .nav-link:hover { color: #3b82f6; background: rgba(239,246,255,0.8); }
        .nav-link:hover::after { width: 60%; }

        /* Dropdown */
        .dropdown-panel {
            opacity: 0;
            transform: translateY(-10px) scale(0.96);
            transition: all 0.2s cubic-bezier(0.4,0,0.2,1);
            pointer-events: none;
            visibility: hidden;
        }
        .dropdown-trigger:focus-within .dropdown-panel,
        .dropdown-trigger:hover .dropdown-panel {
            opacity: 1;
            transform: translateY(0) scale(1);
            pointer-events: auto;
            visibility: visible;
        }

        /* Mobile menu */
        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-12px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .slide-down { animation: slideDown 0.3s cubic-bezier(0.4,0,0.2,1); }

        /* Floating badge pulse */
        @keyframes badge-float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-3px); }
        }
        .badge-float { animation: badge-float 2.5s ease-in-out infinite; }

        /* Glow button effect */
        .btn-glow {
            position: relative;
            overflow: hidden;
        }
        .btn-glow::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(45deg, transparent 30%, rgba(255,255,255,0.15) 50%, transparent 70%);
            transform: translateX(-100%);
            transition: transform 0.6s ease;
        }
        .btn-glow:hover::before { transform: translateX(100%); }

        /* Scroll progress bar */
        #scroll-progress {
            position: fixed;
            top: 0;
            left: 0;
            height: 3px;
            background: linear-gradient(90deg, #3b82f6, #6366f1, #8b5cf6);
            z-index: 100;
            transition: width 0.1s linear;
            border-radius: 0 3px 3px 0;
        }
    </style>
</head>
<body class="min-h-screen bg-white text-slate-800 antialiased">

    {{-- Scroll Progress Bar --}}
    <div id="scroll-progress" style="width:0%"></div>

    {{-- ===== PREMIUM NAVBAR ===== --}}
    <header id="navbar" class="navbar fixed top-0 left-0 right-0 z-50">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-[72px]">

                {{-- Logo --}}
                <a href="/" class="flex items-center gap-3 group flex-shrink-0">
                    <div class="relative">
                        <div class="absolute inset-0 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl blur-md opacity-25 group-hover:opacity-60 transition-all duration-500 group-hover:blur-lg"></div>
                        <div class="relative flex items-center justify-center w-11 h-11 rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-600 shadow-lg shadow-blue-500/25 group-hover:scale-110 group-hover:shadow-blue-500/40 transition-all duration-300">
                            <svg class="w-6 h-6 text-white drop-shadow" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                        </div>
                    </div>
                    <div class="hidden sm:block">
                        <p class="text-lg font-black text-slate-900 leading-tight tracking-tight group-hover:text-blue-700 transition-colors">SIPBAR</p>
                        <p class="text-[10px] text-slate-400 leading-tight tracking-widest uppercase font-semibold">Peminjaman Barang</p>
                    </div>
                </a>

                {{-- Desktop Navigation --}}
                <nav class="hidden md:flex items-center gap-1 bg-slate-50/80 border border-slate-200/70 rounded-2xl px-2 py-1.5 backdrop-blur-sm">
                    <a href="#home" class="nav-link">Beranda</a>
                    <a href="#fitur" class="nav-link">Fitur</a>
                    <a href="#cara-kerja" class="nav-link">Cara Kerja</a>
                    <a href="#kontak" class="nav-link">Kontak</a>
                </nav>

                {{-- Right Actions --}}
                <div class="flex items-center gap-2.5">
                    @auth
                        {{-- Authenticated User Dropdown --}}
                        <div class="dropdown-trigger relative">
                            <button class="flex items-center gap-2.5 pl-2 pr-3.5 py-2 rounded-2xl bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200/70 hover:border-blue-300 hover:shadow-md hover:shadow-blue-500/10 transition-all duration-300">
                                <div class="relative w-8 h-8 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center shadow-md shadow-blue-500/30">
                                    <span class="text-white text-xs font-black">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                                    <span class="absolute -bottom-0.5 -right-0.5 w-2.5 h-2.5 bg-emerald-400 rounded-full border-2 border-white"></span>
                                </div>
                                <div class="hidden sm:block text-left">
                                    <p class="text-xs font-bold text-slate-900 leading-none">{{ Str::limit(auth()->user()->name, 14) }}</p>
                                    <p class="text-[10px] text-slate-500 capitalize leading-none mt-0.5">{{ auth()->user()->role->value }}</p>
                                </div>
                                <svg class="w-3.5 h-3.5 text-slate-400 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/></svg>
                            </button>

                            <div class="dropdown-panel absolute right-0 mt-3 w-64 bg-white rounded-3xl shadow-2xl shadow-slate-300/40 border border-slate-100 overflow-hidden">
                                {{-- User Info Header --}}
                                <div class="p-4 bg-gradient-to-br from-blue-600 to-indigo-600 text-white relative overflow-hidden">
                                    <div class="absolute -top-6 -right-6 w-24 h-24 bg-white/10 rounded-full blur-xl"></div>
                                    <div class="flex items-center gap-3 relative z-10">
                                        <div class="w-11 h-11 rounded-2xl bg-white/20 border border-white/30 flex items-center justify-center font-black text-lg">
                                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="font-bold text-sm truncate">{{ auth()->user()->name }}</p>
                                            <p class="text-xs text-blue-100 truncate">{{ auth()->user()->email }}</p>
                                            <span class="inline-block mt-1 px-2 py-0.5 rounded-md bg-white/20 border border-white/25 text-[10px] font-bold uppercase tracking-wider">{{ auth()->user()->role->value }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="p-2">
                                    @if(auth()->user()->role->value === 'admin')
                                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 text-sm font-semibold text-slate-700 hover:bg-blue-50 hover:text-blue-700 rounded-2xl transition-all group">
                                        <span class="w-8 h-8 rounded-xl bg-blue-100 group-hover:bg-blue-600 text-blue-600 group-hover:text-white flex items-center justify-center transition-all flex-shrink-0">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                                        </span>
                                        Dashboard Admin
                                    </a>
                                    @else
                                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 text-sm font-semibold text-slate-700 hover:bg-blue-50 hover:text-blue-700 rounded-2xl transition-all group">
                                        <span class="w-8 h-8 rounded-xl bg-blue-100 group-hover:bg-blue-600 text-blue-600 group-hover:text-white flex items-center justify-center transition-all flex-shrink-0">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                                        </span>
                                        Dashboard Saya
                                    </a>
                                    @endif
                                    <a href="{{ route('settings') }}" class="flex items-center gap-3 px-3 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50 hover:text-slate-900 rounded-2xl transition-all group">
                                        <span class="w-8 h-8 rounded-xl bg-slate-100 group-hover:bg-slate-200 text-slate-500 flex items-center justify-center transition-all flex-shrink-0">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                        </span>
                                        Pengaturan Akun
                                    </a>
                                    <div class="border-t border-slate-100 mt-1 pt-1">
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="w-full flex items-center gap-3 px-3 py-2.5 text-sm font-bold text-rose-600 hover:bg-rose-50 rounded-2xl transition-all group">
                                                <span class="w-8 h-8 rounded-xl bg-rose-50 group-hover:bg-rose-100 text-rose-500 flex items-center justify-center transition-all flex-shrink-0">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                                </span>
                                                Keluar dari Akun
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        {{-- Guest Actions --}}
                        <a href="{{ route('login') }}" class="hidden sm:flex items-center px-4 py-2.5 text-sm font-semibold text-slate-600 hover:text-blue-600 hover:bg-blue-50 rounded-xl transition-all">
                            Masuk
                        </a>
                        <a href="{{ route('login') }}" class="btn-glow inline-flex items-center gap-2 px-5 py-2.5 rounded-2xl bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold text-sm shadow-lg shadow-blue-500/30 hover:shadow-xl hover:shadow-blue-500/40 hover:scale-[1.04] transition-all duration-300">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                            Mulai Sekarang
                        </a>
                    @endauth

                    {{-- Mobile Toggle --}}
                    <button id="mobile-toggle" class="md:hidden relative w-10 h-10 rounded-xl bg-slate-100 hover:bg-slate-200 flex items-center justify-center transition-colors" aria-label="Menu">
                        <span id="icon-open" class="block">
                            <svg class="w-5 h-5 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                        </span>
                        <span id="icon-close" class="hidden">
                            <svg class="w-5 h-5 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </span>
                    </button>
                </div>
            </div>

            {{-- Mobile Menu --}}
            <div id="mobile-menu" class="hidden md:hidden border-t border-slate-100 pb-4 pt-3">
                <nav class="flex flex-col gap-1 slide-down">
                    <a href="#home" class="flex items-center gap-2 px-4 py-3 text-sm font-semibold text-slate-700 hover:text-blue-600 hover:bg-blue-50 rounded-xl transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        Beranda
                    </a>
                    <a href="#fitur" class="flex items-center gap-2 px-4 py-3 text-sm font-semibold text-slate-700 hover:text-blue-600 hover:bg-blue-50 rounded-xl transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                        Fitur
                    </a>
                    <a href="#cara-kerja" class="flex items-center gap-2 px-4 py-3 text-sm font-semibold text-slate-700 hover:text-blue-600 hover:bg-blue-50 rounded-xl transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                        Cara Kerja
                    </a>
                    <a href="#kontak" class="flex items-center gap-2 px-4 py-3 text-sm font-semibold text-slate-700 hover:text-blue-600 hover:bg-blue-50 rounded-xl transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        Kontak
                    </a>
                    @guest
                    <div class="pt-3 border-t border-slate-100 mt-2 flex flex-col gap-2">
                        <a href="{{ route('login') }}" class="flex justify-center py-3 px-5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold text-sm rounded-2xl shadow-md">
                            Masuk / Daftar Sekarang
                        </a>
                    </div>
                    @endguest
                </nav>
            </div>
        </div>
    </header>

    {{-- CONTENT --}}
    <main class="pt-[72px]">
        @yield('content')
    </main>

    {{-- ===== PREMIUM FOOTER (HIGH CONTRAST DARK THEME) ===== --}}
    <footer class="relative overflow-hidden bg-slate-950 text-slate-300 border-t border-slate-800">
        {{-- Subtle Ambient Glows --}}
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute -top-24 left-1/4 w-96 h-96 bg-blue-600/10 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-24 right-1/4 w-96 h-96 bg-indigo-600/10 rounded-full blur-3xl"></div>
        </div>

        <div class="relative mx-auto max-w-7xl px-4 pt-16 pb-8 sm:px-6 lg:px-8">
            {{-- Main Footer Grid --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-10 mb-12">
                {{-- Brand Column --}}
                <div class="sm:col-span-2 lg:col-span-5 space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="relative flex items-center justify-center w-11 h-11 rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-600 shadow-lg shadow-blue-500/30">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                        </div>
                        <div>
                            <p class="text-2xl font-black tracking-tight text-white">SIPBAR</p>
                            <p class="text-[10px] text-blue-400 uppercase tracking-widest font-bold">Sistem Peminjaman Barang</p>
                        </div>
                    </div>
                    <p class="text-slate-400 text-sm leading-relaxed max-w-sm">
                        Platform digital manajemen inventaris dan peminjaman barang untuk sekolah modern. Efisien, transparan, dan terintegrasi secara real-time.
                    </p>
                    {{-- Social Links --}}
                    <div class="flex items-center gap-3 pt-1">
                        <a href="#" aria-label="Email" class="w-10 h-10 rounded-xl bg-slate-900 border border-slate-800 text-slate-400 hover:text-white hover:bg-blue-600 hover:border-blue-600 flex items-center justify-center transition-all duration-200 shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </a>
                        <a href="#" aria-label="Telepon" class="w-10 h-10 rounded-xl bg-slate-900 border border-slate-800 text-slate-400 hover:text-white hover:bg-emerald-600 hover:border-emerald-600 flex items-center justify-center transition-all duration-200 shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        </a>
                    </div>
                </div>

                {{-- Quick Links --}}
                <div class="lg:col-span-3">
                    <h3 class="font-extrabold text-xs text-white uppercase tracking-widest mb-4">Navigasi</h3>
                    <ul class="space-y-3">
                        @foreach(['Beranda' => '#home', 'Fitur' => '#fitur', 'Cara Kerja' => '#cara-kerja', 'Kontak' => '#kontak'] as $label => $href)
                        <li>
                            <a href="{{ $href }}" class="text-slate-400 hover:text-blue-400 text-sm font-medium transition-colors flex items-center gap-2 group">
                                <span class="w-1.5 h-1.5 rounded-full bg-blue-500 opacity-0 group-hover:opacity-100 transition-opacity"></span>
                                {{ $label }}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>

                {{-- Contact Info --}}
                <div class="lg:col-span-4">
                    <h3 class="font-extrabold text-xs text-white uppercase tracking-widest mb-4">Kontak Kami</h3>
                    <ul class="space-y-3.5">
                        <li class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-xl bg-slate-900 border border-slate-800 text-blue-400 flex items-center justify-center flex-shrink-0 mt-0.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </div>
                            <span class="text-slate-300 text-sm leading-relaxed">Jl. Pendidikan No. 123, Jakarta 10110</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-xl bg-slate-900 border border-slate-800 text-indigo-400 flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            </div>
                            <span class="text-slate-300 text-sm">gudang@sekolah.sch.id</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-xl bg-slate-900 border border-slate-800 text-emerald-400 flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            </div>
                            <span class="text-slate-300 text-sm">(021) 1234-5678</span>
                        </li>
                    </ul>
                </div>
            </div>

            {{-- Bottom Copyright Bar --}}
            <div class="border-t border-slate-800/80 pt-8 flex flex-col sm:flex-row justify-between items-center gap-4 text-sm text-slate-400">
                <p>© {{ date('Y') }} SIPBAR. All rights reserved.</p>
                <div class="flex items-center gap-1.5">
                    <span>Dibuat dengan</span>
                    <svg class="w-4 h-4 text-rose-500 animate-pulse" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                    <span>untuk pendidikan Indonesia</span>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Scroll progress bar
        window.addEventListener('scroll', () => {
            const scrolled = (window.scrollY / (document.documentElement.scrollHeight - window.innerHeight)) * 100;
            document.getElementById('scroll-progress').style.width = Math.min(scrolled, 100) + '%';

            // Navbar scroll effect
            const navbar = document.getElementById('navbar');
            if (window.scrollY > 30) { navbar.classList.add('navbar-scrolled'); }
            else { navbar.classList.remove('navbar-scrolled'); }
        });

        // Mobile menu toggle
        const toggle = document.getElementById('mobile-toggle');
        const menu = document.getElementById('mobile-menu');
        const iconOpen = document.getElementById('icon-open');
        const iconClose = document.getElementById('icon-close');

        toggle?.addEventListener('click', () => {
            const isOpen = !menu.classList.contains('hidden');
            menu.classList.toggle('hidden');
            iconOpen.classList.toggle('hidden', !isOpen);
            iconOpen.classList.toggle('block', isOpen);
            iconClose.classList.toggle('hidden', isOpen);
            iconClose.classList.toggle('block', !isOpen);
        });

        // Close mobile menu on link click
        document.querySelectorAll('#mobile-menu a').forEach(link => {
            link.addEventListener('click', () => {
                menu.classList.add('hidden');
                iconOpen.classList.remove('hidden');
                iconOpen.classList.add('block');
                iconClose.classList.add('hidden');
                iconClose.classList.remove('block');
            });
        });
    </script>
</body>
</html>
