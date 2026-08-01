<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light">
<head>
    @include('partials.head')
    <title>SIPBAR — Sistem Peminjaman Barang Sekolah</title>
    <style>
        /* ===== DARK / LIGHT MODE CSS VARIABLES ===== */
        :root {
            --bg-primary:    #FFFFFF;
            --bg-section:    #F8FAFC;
            --bg-card:       #FFFFFF;
            --bg-card-alt:   #F1F5F9;
            --border-card:   rgba(226, 232, 240, 0.9);
            --text-heading:  #0F172A;
            --text-body:     #475569;
            --text-muted:    #94A3B8;
            --accent-from:   #4F46E5;
            --accent-to:     #7C3AED;
            --navbar-bg:     rgba(255, 255, 255, 0.85);
            --navbar-scrolled-bg: rgba(255, 255, 255, 0.96);
            --navbar-border: rgba(226, 232, 240, 0.7);
            --navbar-text:   #0F172A;
            --nav-link-text: #475569;
            --nav-link-hover-bg: rgba(79, 70, 229, 0.08);
            --nav-pill-bg:   rgba(248, 250, 252, 0.85);
            --nav-pill-border: rgba(226, 232, 240, 0.8);
            --mobile-menu-bg: rgba(255, 255, 255, 0.98);
            --mobile-border: rgba(226, 232, 240, 0.6);
        }

        html.dark {
            --bg-primary:    #0B0F1A;
            --bg-section:    #0D1220;
            --bg-card:       #151B2E;
            --bg-card-alt:   #1A2235;
            --border-card:   rgba(255, 255, 255, 0.08);
            --text-heading:  #FFFFFF;
            --text-body:     #9CA3AF;
            --text-muted:    #6B7280;
            --accent-from:   #4F46E5;
            --accent-to:     #7C3AED;
            --navbar-bg:     rgba(11, 15, 26, 0.82);
            --navbar-scrolled-bg: rgba(11, 15, 26, 0.96);
            --navbar-border: rgba(255, 255, 255, 0.08);
            --navbar-text:   #FFFFFF;
            --nav-link-text: #CBD5E1;
            --nav-link-hover-bg: rgba(79, 70, 229, 0.15);
            --nav-pill-bg:   rgba(21, 27, 46, 0.8);
            --nav-pill-border: rgba(255, 255, 255, 0.08);
            --mobile-menu-bg: rgba(11, 15, 26, 0.98);
            --mobile-border: rgba(255, 255, 255, 0.06);
        }

        html { scroll-behavior: smooth; }

        body {
            background-color: var(--bg-primary);
            color: var(--text-body);
            transition: background-color 0.35s ease, color 0.35s ease;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
        }

        /* ===== NAVBAR ===== */
        .navbar {
            transition: background 0.35s ease, border-color 0.35s ease, box-shadow 0.35s ease;
            background: var(--navbar-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--navbar-border);
        }
        .navbar-scrolled {
            background: var(--navbar-scrolled-bg);
            backdrop-filter: blur(28px);
            box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.1), 0 4px 20px rgba(79, 70, 229, 0.08);
            border-bottom: 1px solid var(--navbar-border);
        }

        /* Nav link */
        .nav-link {
            position: relative;
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--nav-link-text);
            padding: 0.5rem 0.85rem;
            border-radius: 0.75rem;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            text-decoration: none;
        }
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 3px;
            left: 50%;
            transform: translateX(-50%);
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, #4F46E5, #7C3AED);
            border-radius: 9999px;
            transition: width 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .nav-link:hover {
            color: var(--accent-from);
            background: var(--nav-link-hover-bg);
        }
        .nav-link:hover::after { width: 55%; }

        .nav-pill {
            background: var(--nav-pill-bg);
            border: 1px solid var(--nav-pill-border);
        }

        .logo-text { color: var(--navbar-text); transition: color 0.3s; }
        html.dark .logo-text { color: #FFFFFF; }
        .logo-sub { color: var(--text-muted); }

        /* Mobile menu slide */
        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-10px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .slide-down { animation: slideDown 0.3s cubic-bezier(0.4, 0, 0.2, 1); }

        .mobile-menu-panel {
            background: var(--mobile-menu-bg);
            border-top: 1px solid var(--mobile-border);
        }
        .mobile-menu-link {
            color: var(--nav-link-text);
        }
        .mobile-menu-link:hover {
            color: var(--accent-from);
            background: var(--nav-link-hover-bg);
        }

        .mobile-toggle-btn {
            background: var(--bg-card-alt);
            border: 1px solid var(--border-card);
        }

        /* ===== DARK MODE TOGGLE SWITCH (PREMIUM) ===== */
        @keyframes toggle-pulse {
            0%   { box-shadow: 0 1px 3px rgba(0,0,0,0.20), 0 1px 8px rgba(0,0,0,0.12); }
            40%  { box-shadow: 0 0 0 6px rgba(79,70,229,0.18), 0 2px 12px rgba(79,70,229,0.30); }
            100% { box-shadow: 0 1px 3px rgba(0,0,0,0.20), 0 1px 8px rgba(0,0,0,0.12); }
        }
        @keyframes toggle-pulse-dark {
            0%   { box-shadow: 0 1px 3px rgba(0,0,0,0.35), 0 2px 12px rgba(79,70,229,0.30); }
            40%  { box-shadow: 0 0 0 6px rgba(124,58,237,0.22), 0 2px 16px rgba(124,58,237,0.40); }
            100% { box-shadow: 0 1px 3px rgba(0,0,0,0.35), 0 2px 12px rgba(79,70,229,0.30); }
        }
        .theme-toggle-thumb.is-clicking {
            animation: toggle-pulse 0.45s cubic-bezier(0.4, 0, 0.2, 1) forwards;
        }
        html.dark .theme-toggle-thumb.is-clicking {
            animation: toggle-pulse-dark 0.45s cubic-bezier(0.4, 0, 0.2, 1) forwards;
        }

        .theme-toggle {
            display: inline-flex;
            align-items: center;
            cursor: pointer;
            user-select: none;
            outline: none;
            border: none;
            background: none;
            padding: 2px;
            border-radius: 9999px;
            transition: background 0.2s ease;
        }
        .theme-toggle:focus-visible {
            outline: 2px solid #4F46E5;
            outline-offset: 2px;
        }
        .theme-toggle:hover {
            background: rgba(79, 70, 229, 0.06);
        }

        .theme-toggle-track {
            width: 48px;
            height: 26px;
            border-radius: 9999px;
            background: #CBD5E1;
            position: relative;
            flex-shrink: 0;
            border: 1.5px solid rgba(0, 0, 0, 0.07);
            transition:
                background   0.45s cubic-bezier(0.4, 0, 0.2, 1),
                border-color 0.45s ease,
                box-shadow   0.45s ease;
        }
        html.dark .theme-toggle-track {
            background: linear-gradient(135deg, #4F46E5 0%, #7C3AED 100%);
            border-color: rgba(255, 255, 255, 0.10);
            box-shadow: 0 0 0 1px rgba(79, 70, 229, 0.20), 0 0 14px rgba(79, 70, 229, 0.18);
        }

        .theme-toggle-thumb {
            position: absolute;
            top: 2px;
            left: 2px;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: #FFFFFF;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.18), 0 1px 8px rgba(0, 0, 0, 0.10);
            transition: transform 0.42s cubic-bezier(0.34, 1.45, 0.64, 1), box-shadow 0.38s ease;
        }
        html.dark .theme-toggle-thumb {
            transform: translateX(22px);
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.30), 0 2px 12px rgba(79, 70, 229, 0.28);
        }

        .toggle-icon-sun,
        .toggle-icon-moon {
            position: absolute;
            top: 50%;
            left: 50%;
            margin-top: -6px;
            margin-left: -6px;
            width: 12px;
            height: 12px;
            display: block;
            line-height: 0;
            transition: opacity 0.30s ease, transform 0.40s cubic-bezier(0.4, 0, 0.2, 1);
            pointer-events: none;
        }
        .toggle-icon-sun svg,
        .toggle-icon-moon svg {
            width:  12px;
            height: 12px;
            display: block;
        }

        .toggle-icon-sun  { opacity: 1; transform: rotate(0deg) scale(1); }
        .toggle-icon-moon { opacity: 0; transform: rotate(-90deg) scale(0.5); }

        html.dark .toggle-icon-sun  { opacity: 0; transform: rotate(90deg) scale(0.5); }
        html.dark .toggle-icon-moon { opacity: 1; transform: rotate(0deg) scale(1); }

        /* ===== DROPDOWN USER PANEL ===== */
        .dropdown-panel {
            opacity: 0;
            transform: translateY(-10px) scale(0.96);
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            pointer-events: none;
            visibility: hidden;
            background: var(--bg-card);
            border: 1px solid var(--border-card);
        }
        .dropdown-trigger:focus-within .dropdown-panel,
        .dropdown-trigger:hover .dropdown-panel {
            opacity: 1;
            transform: translateY(0) scale(1);
            pointer-events: auto;
            visibility: visible;
        }

        /* ===== ANIMATIONS & SCROLL REVEAL ===== */
        @keyframes floatSlow {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50%       { transform: translateY(-12px) rotate(0.8deg); }
        }
        .animate-float { animation: floatSlow 6s ease-in-out infinite; }

        @keyframes pulseGlow {
            0%, 100% { opacity: 0.4; transform: scale(1); }
            50%       { opacity: 0.7; transform: scale(1.05); }
        }
        .animate-pulse-glow { animation: pulseGlow 5s ease-in-out infinite; }

        /* Scroll reveal class */
        .reveal {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.6s cubic-bezier(0.4, 0, 0.2, 1), transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .reveal.active {
            opacity: 1;
            transform: translateY(0);
        }

        /* Glow buttons */
        .btn-glow {
            position: relative;
            overflow: hidden;
        }
        .btn-glow::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(45deg, transparent 30%, rgba(255,255,255,0.2) 50%, transparent 70%);
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
            background: linear-gradient(90deg, #4F46E5, #7C3AED, #EC4899);
            z-index: 100;
            transition: width 0.1s linear;
            border-radius: 0 3px 3px 0;
        }
    </style>
</head>
<body class="min-h-screen antialiased" style="background-color: var(--bg-primary); color: var(--text-body);">

    {{-- Scroll Progress Bar --}}
    <div id="scroll-progress" style="width:0%"></div>

    {{-- ===== PREMIUM STICKY NAVBAR ===== --}}
    <header id="navbar" class="navbar fixed top-0 left-0 right-0 z-50">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-[72px]">

                {{-- Logo --}}
                <a href="/" class="flex items-center gap-3 group flex-shrink-0">
                    <div class="relative">
                        <div class="absolute inset-0 bg-gradient-to-br from-indigo-500 to-violet-600 rounded-2xl blur-md opacity-25 group-hover:opacity-60 transition-all duration-500 group-hover:blur-lg"></div>
                        <div class="relative flex items-center justify-center w-11 h-11 rounded-2xl bg-gradient-to-br from-indigo-600 to-violet-600 shadow-lg shadow-indigo-500/30 group-hover:scale-105 transition-all duration-300">
                            <svg class="w-6 h-6 text-white drop-shadow" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                        </div>
                    </div>
                    <div class="hidden sm:block">
                        <p class="text-lg font-black leading-tight tracking-tight logo-text group-hover:text-indigo-500 transition-colors">SIPBAR</p>
                        <p class="text-[10px] leading-tight tracking-widest uppercase font-bold logo-sub">Peminjaman Barang</p>
                    </div>
                </a>

                {{-- Desktop Navigation Pill --}}
                <nav class="hidden md:flex items-center gap-1 rounded-2xl px-2 py-1.5 backdrop-blur-md nav-pill shadow-sm">
                    <a href="#home" class="nav-link">Beranda</a>
                    <a href="#fitur" class="nav-link">Fitur</a>
                    <a href="#cara-kerja" class="nav-link">Cara Kerja</a>
                    <a href="#statistik" class="nav-link">Statistik</a>
                    <a href="#kontak" class="nav-link">Kontak</a>
                </nav>

                {{-- Right Actions --}}
                <div class="flex items-center gap-3">

                    {{-- ☀️🌙 Theme Toggle Switch --}}
                    <button
                        id="theme-toggle-btn"
                        class="theme-toggle"
                        aria-label="Toggle dark/light mode"
                        title="Toggle dark/light mode"
                    >
                        <div class="theme-toggle-track">
                            <div class="theme-toggle-thumb" id="toggle-thumb">
                                <span class="toggle-icon-sun" aria-hidden="true">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="#6D28D9" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="12" cy="12" r="4"/>
                                        <line x1="12" y1="2"  x2="12" y2="5"/>
                                        <line x1="12" y1="19" x2="12" y2="22"/>
                                        <line x1="4.22" y1="4.22"  x2="6.34" y2="6.34"/>
                                        <line x1="17.66" y1="17.66" x2="19.78" y2="19.78"/>
                                        <line x1="2"  y1="12" x2="5"  y2="12"/>
                                        <line x1="19" y1="12" x2="22" y2="12"/>
                                        <line x1="4.22" y1="19.78" x2="6.34" y2="17.66"/>
                                        <line x1="17.66" y1="6.34" x2="19.78" y2="4.22"/>
                                    </svg>
                                </span>
                                <span class="toggle-icon-moon" aria-hidden="true">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="#7C3AED" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/>
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </button>

                    @auth
                        {{-- Authenticated User Dropdown --}}
                        <div class="dropdown-trigger relative">
                            <button class="flex items-center gap-2.5 pl-2 pr-3.5 py-2 rounded-2xl transition-all duration-300" style="background: var(--bg-card-alt); border: 1px solid var(--border-card);">
                                <div class="relative w-8 h-8 rounded-xl bg-gradient-to-br from-indigo-600 to-violet-600 flex items-center justify-center shadow-md shadow-indigo-500/30">
                                    <span class="text-white text-xs font-black">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                                    <span class="absolute -bottom-0.5 -right-0.5 w-2.5 h-2.5 bg-emerald-400 rounded-full border-2 border-white"></span>
                                </div>
                                <div class="hidden sm:block text-left">
                                    <p class="text-xs font-bold leading-none" style="color: var(--text-heading);">{{ Str::limit(auth()->user()->name, 14) }}</p>
                                    <p class="text-[10px] capitalize leading-none mt-0.5" style="color: var(--text-muted);">{{ auth()->user()->role->value }}</p>
                                </div>
                                <svg class="w-3.5 h-3.5 transition-transform duration-200" style="color: var(--text-muted);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/></svg>
                            </button>

                            <div class="dropdown-panel absolute right-0 mt-3 w-64 rounded-3xl shadow-2xl overflow-hidden">
                                <div class="p-4 bg-gradient-to-br from-indigo-600 to-violet-700 text-white relative overflow-hidden">
                                    <div class="absolute -top-6 -right-6 w-24 h-24 bg-white/10 rounded-full blur-xl"></div>
                                    <div class="flex items-center gap-3 relative z-10">
                                        <div class="w-11 h-11 rounded-2xl bg-white/20 border border-white/30 flex items-center justify-center font-black text-lg">
                                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="font-bold text-sm truncate">{{ auth()->user()->name }}</p>
                                            <p class="text-xs text-indigo-100 truncate">{{ auth()->user()->email }}</p>
                                            <span class="inline-block mt-1 px-2 py-0.5 rounded-md bg-white/20 border border-white/25 text-[10px] font-bold uppercase tracking-wider">{{ auth()->user()->role->value }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="p-2">
                                    @if(auth()->user()->role->value === 'admin')
                                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 text-sm font-semibold rounded-2xl transition-all hover:bg-indigo-500/10 hover:text-indigo-500" style="color: var(--text-body);">
                                        Dashboard Admin
                                    </a>
                                    @else
                                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 text-sm font-semibold rounded-2xl transition-all hover:bg-indigo-500/10 hover:text-indigo-500" style="color: var(--text-body);">
                                        Dashboard Saya
                                    </a>
                                    @endif
                                    <a href="{{ route('settings') }}" class="flex items-center gap-3 px-3 py-2.5 text-sm font-semibold rounded-2xl transition-all hover:bg-indigo-500/10 hover:text-indigo-500" style="color: var(--text-body);">
                                        Pengaturan Akun
                                    </a>
                                    <div class="border-t mt-1 pt-1" style="border-color: var(--border-card);">
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="w-full flex items-center gap-3 px-3 py-2.5 text-sm font-bold text-rose-500 hover:bg-rose-500/10 rounded-2xl transition-all">
                                                Keluar dari Akun
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        {{-- Guest Actions --}}
                        <a href="{{ route('login') }}" class="hidden sm:flex items-center px-4 py-2.5 text-sm font-semibold rounded-xl transition-all hover:bg-indigo-500/10" style="color: var(--text-body);">
                            Masuk
                        </a>
                        <a href="{{ route('login') }}" class="btn-glow inline-flex items-center gap-2 px-5 py-2.5 rounded-2xl bg-gradient-to-r from-indigo-600 to-violet-600 text-white font-bold text-sm shadow-lg shadow-indigo-500/30 hover:shadow-xl hover:shadow-indigo-500/40 hover:scale-[1.03] transition-all duration-300">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                            Mulai Sekarang
                        </a>
                    @endauth

                    {{-- Mobile Toggle --}}
                    <button id="mobile-toggle" class="mobile-toggle-btn md:hidden relative w-10 h-10 rounded-xl flex items-center justify-center transition-colors" aria-label="Menu">
                        <span id="icon-open" class="block">
                            <svg class="w-5 h-5" style="color: var(--text-heading);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                        </span>
                        <span id="icon-close" class="hidden">
                            <svg class="w-5 h-5" style="color: var(--text-heading);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </span>
                    </button>
                </div>
            </div>

            {{-- Mobile Menu --}}
            <div id="mobile-menu" class="hidden md:hidden mobile-menu-panel pb-4 pt-3 rounded-b-2xl">
                <nav class="flex flex-col gap-1 slide-down px-2">
                    <a href="#home" class="mobile-menu-link flex items-center gap-2 px-4 py-3 text-sm font-semibold rounded-xl transition-all">
                        Beranda
                    </a>
                    <a href="#fitur" class="mobile-menu-link flex items-center gap-2 px-4 py-3 text-sm font-semibold rounded-xl transition-all">
                        Fitur
                    </a>
                    <a href="#cara-kerja" class="mobile-menu-link flex items-center gap-2 px-4 py-3 text-sm font-semibold rounded-xl transition-all">
                        Cara Kerja
                    </a>
                    <a href="#statistik" class="mobile-menu-link flex items-center gap-2 px-4 py-3 text-sm font-semibold rounded-xl transition-all">
                        Statistik
                    </a>
                    <a href="#kontak" class="mobile-menu-link flex items-center gap-2 px-4 py-3 text-sm font-semibold rounded-xl transition-all">
                        Kontak
                    </a>
                    @guest
                    <div class="pt-3 border-t mt-2 flex flex-col gap-2" style="border-color: var(--mobile-border);">
                        <a href="{{ route('login') }}" class="flex justify-center py-3 px-5 bg-gradient-to-r from-indigo-600 to-violet-600 text-white font-bold text-sm rounded-2xl shadow-md">
                            Masuk / Daftar Sekarang
                        </a>
                    </div>
                    @endguest
                </nav>
            </div>
        </div>
    </header>

    {{-- MAIN CONTENT --}}
    <main class="pt-[72px]">
        @yield('content')
    </main>

    {{-- ===== PREMIUM FOOTER (DARK THEME) ===== --}}
    <footer class="relative overflow-hidden bg-[#0B0F1A] text-slate-300 border-t border-slate-800/80">
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute -top-24 left-1/4 w-96 h-96 bg-indigo-600/10 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-24 right-1/4 w-96 h-96 bg-violet-600/10 rounded-full blur-3xl"></div>
        </div>

        <div class="relative mx-auto max-w-7xl px-4 pt-16 pb-8 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-10 mb-12">
                <div class="sm:col-span-2 lg:col-span-5 space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="relative flex items-center justify-center w-11 h-11 rounded-2xl bg-gradient-to-br from-indigo-500 to-violet-600 shadow-lg shadow-indigo-500/30">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                        </div>
                        <div>
                            <p class="text-2xl font-black tracking-tight text-white">SIPBAR</p>
                            <p class="text-[10px] text-indigo-400 uppercase tracking-widest font-bold">Sistem Peminjaman Barang</p>
                        </div>
                    </div>
                    <p class="text-slate-400 text-sm leading-relaxed max-w-sm">
                        Platform digital manajemen inventaris dan peminjaman barang untuk sekolah modern. Efisien, transparan, dan terintegrasi secara real-time.
                    </p>
                    <div class="flex items-center gap-3 pt-1">
                        <a href="#" aria-label="Email" class="w-10 h-10 rounded-xl bg-slate-900 border border-slate-800 text-slate-400 hover:text-white hover:bg-indigo-600 hover:border-indigo-600 flex items-center justify-center transition-all duration-200 shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </a>
                        <a href="#" aria-label="Telepon" class="w-10 h-10 rounded-xl bg-slate-900 border border-slate-800 text-slate-400 hover:text-white hover:bg-emerald-600 hover:border-emerald-600 flex items-center justify-center transition-all duration-200 shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        </a>
                    </div>
                </div>

                <div class="lg:col-span-3">
                    <h3 class="font-extrabold text-xs text-white uppercase tracking-widest mb-4">Navigasi</h3>
                    <ul class="space-y-3">
                        @foreach(['Beranda' => '#home', 'Fitur' => '#fitur', 'Cara Kerja' => '#cara-kerja', 'Statistik' => '#statistik', 'Kontak' => '#kontak'] as $label => $href)
                        <li>
                            <a href="{{ $href }}" class="text-slate-400 hover:text-indigo-400 text-sm font-medium transition-colors flex items-center gap-2 group">
                                <span class="w-1.5 h-1.5 rounded-full bg-indigo-500 opacity-0 group-hover:opacity-100 transition-opacity"></span>
                                {{ $label }}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>

                <div class="lg:col-span-4">
                    <h3 class="font-extrabold text-xs text-white uppercase tracking-widest mb-4">Kontak Kami</h3>
                    <ul class="space-y-3.5">
                        <li class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-xl bg-slate-900 border border-slate-800 text-indigo-400 flex items-center justify-center flex-shrink-0 mt-0.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </div>
                            <span class="text-slate-300 text-sm leading-relaxed">Jl. Pendidikan No. 123, Jakarta 10110</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-xl bg-slate-900 border border-slate-800 text-violet-400 flex items-center justify-center flex-shrink-0">
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
        // ===== THEME TOGGLE & JS =====
        const html = document.documentElement;
        const toggleBtn = document.getElementById('theme-toggle-btn');
        const toggleThumb = document.getElementById('toggle-thumb');

        const savedTheme = localStorage.getItem('sipbar-theme') || 'dark';
        applyTheme(savedTheme);

        toggleBtn?.addEventListener('click', () => {
            const isDark = html.classList.contains('dark');
            if (toggleThumb) {
                toggleThumb.classList.add('is-clicking');
                setTimeout(() => toggleThumb.classList.remove('is-clicking'), 450);
            }
            applyTheme(isDark ? 'light' : 'dark');
        });

        function applyTheme(theme) {
            if (theme === 'dark') {
                html.classList.remove('light');
                html.classList.add('dark');
                toggleBtn?.setAttribute('aria-label', 'Switch to light mode');
            } else {
                html.classList.remove('dark');
                html.classList.add('light');
                toggleBtn?.setAttribute('aria-label', 'Switch to dark mode');
            }
            localStorage.setItem('sipbar-theme', theme);
        }

        // ===== SCROLL PROGRESS & NAVBAR =====
        window.addEventListener('scroll', () => {
            const scrolled = (window.scrollY / (document.documentElement.scrollHeight - window.innerHeight)) * 100;
            document.getElementById('scroll-progress').style.width = Math.min(scrolled, 100) + '%';

            const navbar = document.getElementById('navbar');
            if (window.scrollY > 25) { navbar.classList.add('navbar-scrolled'); }
            else { navbar.classList.remove('navbar-scrolled'); }
        });

        // ===== MOBILE MENU =====
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

        document.querySelectorAll('#mobile-menu a').forEach(link => {
            link.addEventListener('click', () => {
                menu.classList.add('hidden');
                iconOpen.classList.remove('hidden');
                iconOpen.classList.add('block');
                iconClose.classList.add('hidden');
                iconClose.classList.remove('block');
            });
        });

        // ===== INTERSECTION OBSERVER FOR SCROLL REVEAL =====
        const observerOptions = {
            root: null,
            rootMargin: '0px 0px -50px 0px',
            threshold: 0.15
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('active');
                }
            });
        }, observerOptions);

        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
        });
    </script>
</body>
</html>
