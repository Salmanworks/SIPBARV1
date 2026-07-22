<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    @include('partials.head')
    <title>{{ $title ?? 'Dashboard' }} — SIPBAR</title>
    <style>
        /* Sidebar active indicator */
        .nav-item { transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1); }
        .nav-item.active {
            background: linear-gradient(135deg, #3b82f6 0%, #6366f1 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(99, 102, 241, 0.3);
        }
        .nav-item:not(.active):hover {
            background: #eff6ff;
            color: #2563eb;
        }
        .nav-item.active svg, .nav-item.active span { color: white; }

        /* Content card hover */
        .card-lift { transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1); }
        .card-lift:hover { transform: translateY(-2px); box-shadow: 0 12px 36px rgba(99,102,241,0.1); }

        /* Smooth scrollbar */
        ::-webkit-scrollbar { width: 4px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 99px; }
        ::-webkit-scrollbar-thumb:hover { background: #cbd5e1; }

        /* Shimmer on CTA */
        .shimmer-btn { position: relative; overflow: hidden; }
        .shimmer-btn::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(105deg, transparent 40%, rgba(255,255,255,0.18) 50%, transparent 60%);
            transform: translateX(-100%);
            animation: shimmer 2.5s infinite;
        }
        @keyframes shimmer { to { transform: translateX(200%); } }

        /* Status dot pulse */
        @keyframes status-pulse {
            0%, 100% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.4); opacity: 0.7; }
        }
        .status-pulse { animation: status-pulse 2s ease-in-out infinite; }
    </style>
</head>
<body class="h-full bg-slate-50/70 text-slate-800 antialiased font-sans">
<div class="flex h-screen overflow-hidden">

    {{-- ===== SIDEBAR ===== --}}
    <aside id="sidebar" class="fixed inset-y-0 left-0 z-50 w-[268px] bg-white border-r border-slate-200/60 transform -translate-x-full lg:translate-x-0 lg:static transition-transform duration-300 ease-in-out flex flex-col shadow-xl shadow-slate-200/40">

        {{-- Brand Header --}}
        <div class="flex items-center justify-between px-5 h-[72px] border-b border-slate-100 flex-shrink-0">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 group">
                <div class="relative">
                    <div class="absolute inset-0 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl blur-md opacity-20 group-hover:opacity-50 transition-opacity duration-400"></div>
                    <div class="relative w-10 h-10 rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center shadow-md shadow-blue-500/25 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    </div>
                </div>
                <div>
                    <h1 class="text-base font-black text-slate-900 tracking-tight leading-none">SIPBAR</h1>
                    <p class="text-[9px] text-slate-400 tracking-widest uppercase font-bold leading-none mt-0.5">Admin Portal</p>
                </div>
            </a>
            <button id="close-sidebar-btn" class="lg:hidden w-8 h-8 rounded-xl bg-slate-100 hover:bg-slate-200 flex items-center justify-center transition-colors">
                <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        {{-- Navigation --}}
        <nav class="flex-1 overflow-y-auto py-4 px-3 space-y-0.5">

            {{-- Dashboard --}}
            <a href="{{ route('admin.dashboard') }}"
               class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }} flex items-center gap-3 px-3.5 py-2.5 rounded-2xl whitespace-nowrap text-slate-600 text-sm font-semibold focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500">
                <svg class="w-[18px] h-[18px] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                <span>Dashboard</span>
                @if(request()->routeIs('admin.dashboard'))
                <span class="ml-auto w-1.5 h-1.5 rounded-full bg-white opacity-80"></span>
                @endif
            </a>

            {{-- Group: Inventaris --}}
            <div class="px-3.5 pt-5 pb-1.5">
                <p class="text-[10px] font-extrabold text-slate-400 uppercase tracking-[0.12em]">Inventaris</p>
            </div>

            <a href="{{ route('admin.barang.index') }}"
               class="nav-item {{ request()->routeIs('admin.barang.*') ? 'active' : '' }} flex items-center gap-3 px-3.5 py-2.5 rounded-2xl text-slate-600 text-sm font-semibold">
                <svg class="w-[18px] h-[18px] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                <span>Kelola Barang</span>
            </a>

            <a href="{{ route('admin.kategori.index') }}"
               class="nav-item {{ request()->routeIs('admin.kategori.*') ? 'active' : '' }} flex items-center gap-3 px-3.5 py-2.5 rounded-2xl text-slate-600 text-sm font-semibold">
                <svg class="w-[18px] h-[18px] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                <span>Kategori Barang</span>
            </a>

            {{-- Group: Transaksi --}}
            <div class="px-3.5 pt-5 pb-1.5">
                <p class="text-[10px] font-extrabold text-slate-400 uppercase tracking-[0.12em]">Transaksi</p>
            </div>

            <a href="{{ route('admin.peminjaman.index') }}"
               class="nav-item {{ request()->routeIs('admin.peminjaman.*') ? 'active' : '' }} flex items-center gap-3 px-3.5 py-2.5 rounded-2xl text-slate-600 text-sm font-semibold">
                <svg class="w-[18px] h-[18px] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                <span class="flex-1">Peminjaman</span>
                @if(isset($stats) && ($stats['menunggu_approval'] ?? 0) > 0)
                    <span class="w-6 h-6 rounded-xl bg-amber-500 text-white text-[10px] font-extrabold flex items-center justify-center shadow-sm animate-bounce">
                        {{ min($stats['menunggu_approval'], 9) }}{{ $stats['menunggu_approval'] > 9 ? '+' : '' }}
                    </span>
                @endif
            </a>

            <a href="{{ route('admin.laporan.index') }}"
               class="nav-item {{ request()->routeIs('admin.laporan.*') ? 'active' : '' }} flex items-center gap-3 px-3.5 py-2.5 rounded-2xl text-slate-600 text-sm font-semibold">
                <svg class="w-[18px] h-[18px] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                <span>Laporan & Ekspor</span>
            </a>

            {{-- Group: Sistem --}}
            <div class="px-3.5 pt-5 pb-1.5">
                <p class="text-[10px] font-extrabold text-slate-400 uppercase tracking-[0.12em]">Pengaturan Sistem</p>
            </div>

            <a href="{{ route('admin.user.index') }}"
               class="nav-item {{ request()->routeIs('admin.user.*') ? 'active' : '' }} flex items-center gap-3 px-3.5 py-2.5 rounded-2xl text-slate-600 text-sm font-semibold">
                <svg class="w-[18px] h-[18px] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                <span>Kelola Pengguna</span>
            </a>

            <a href="{{ route('settings') }}"
               class="nav-item {{ request()->routeIs('settings*') ? 'active' : '' }} flex items-center gap-3 px-3.5 py-2.5 rounded-2xl text-slate-600 text-sm font-semibold">
                <svg class="w-[18px] h-[18px] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                <span>Pengaturan Akun</span>
            </a>
        </nav>

        {{-- Sidebar Footer --}}
        <div class="p-3 border-t border-slate-100 flex-shrink-0">
            <div class="flex items-center gap-3 p-3 rounded-2xl bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-100/80 group hover:border-blue-200 transition-colors cursor-pointer" title="{{ auth()->user()->name }}">
                <div class="relative flex-shrink-0">
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white font-extrabold text-sm shadow-md shadow-blue-500/25">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <span class="status-pulse absolute -bottom-0.5 -right-0.5 w-3 h-3 rounded-full bg-emerald-400 border-2 border-white shadow-sm"></span>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-xs font-bold text-slate-900 truncate">{{ auth()->user()->name }}</p>
                    <p class="text-[10px] text-slate-500 truncate">{{ auth()->user()->email }}</p>
                </div>
                <form method="POST" action="{{ route('logout') }}" class="flex-shrink-0">
                    @csrf
                    <button type="submit" class="relative inline-flex items-center justify-center gap-2.5 px-4 py-2 rounded-2xl bg-gradient-to-r from-rose-500 to-pink-500 text-white font-bold hover:from-rose-600 hover:to-pink-600 shadow-lg hover:shadow-xl transition-all shimmer-btn" title="Keluar">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        Keluar dari Akun
                    </button>
                </form>
            </div>
        </div>
    </aside>

    {{-- ===== MAIN CONTENT ===== --}}
    <div class="flex-1 flex flex-col min-w-0 overflow-hidden">

        {{-- Top Header --}}
        <header class="bg-white/90 backdrop-blur-xl border-b border-slate-200/60 h-[72px] flex items-center justify-between px-5 md:px-7 sticky top-0 z-30 shadow-sm shadow-slate-100/80">

            {{-- Left --}}
            <div class="flex items-center gap-4">
                <button id="mobile-menu-btn" class="lg:hidden w-10 h-10 rounded-xl bg-slate-100 hover:bg-slate-200 flex items-center justify-center transition-colors">
                    <svg class="w-5 h-5 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                <div>
                    <div class="flex items-center gap-2 text-[11px] font-semibold text-slate-400 mb-0.5">
                        <a href="{{ route('admin.dashboard') }}" class="hover:text-blue-600 transition-colors">Admin</a>
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        <span class="text-slate-700 font-bold">{{ $title ?? 'Dashboard' }}</span>
                    </div>
                    <h2 class="text-base font-extrabold text-slate-900 leading-none">{{ $title ?? 'Dashboard Overview' }}</h2>
                </div>
            </div>

            {{-- Right --}}
            <div class="flex items-center gap-2">

                {{-- View Website --}}
                <a href="{{ route('home') }}" target="_blank" class="hidden sm:inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-slate-100 hover:bg-blue-100 text-slate-600 hover:text-blue-700 text-xs font-bold border border-transparent hover:border-blue-200 transition-all">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    Website
                </a>

                {{-- Notifications --}}
                <button class="relative w-10 h-10 rounded-xl bg-slate-100 hover:bg-slate-200 flex items-center justify-center transition-colors">
                    <svg class="w-4.5 h-4.5 text-slate-600 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                    @if(isset($stats) && (($stats['menunggu_approval'] ?? 0) > 0 || ($stats['terlambat'] ?? 0) > 0))
                        <span class="absolute top-2 right-2 w-2 h-2 rounded-full bg-rose-500 ring-2 ring-white animate-pulse"></span>
                    @endif
                </button>

                {{-- Divider --}}
                <div class="w-px h-6 bg-slate-200 mx-1"></div>

                {{-- User Dropdown --}}
                <div class="relative group">
                    <button class="flex items-center gap-2.5 pl-2 pr-3.5 py-2 rounded-2xl bg-gradient-to-r from-blue-50 to-indigo-50 hover:from-blue-100 hover:to-indigo-100 border border-blue-200/60 hover:border-blue-300 transition-all duration-200 shadow-sm">
                        <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white font-extrabold text-xs shadow-md shadow-blue-500/25">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <div class="hidden md:block text-left">
                            <p class="text-xs font-extrabold text-slate-900 leading-none">{{ Str::limit(auth()->user()->name, 14) }}</p>
                            <p class="text-[10px] text-slate-500 leading-none mt-0.5">Administrator</p>
                        </div>
                        <svg class="w-3.5 h-3.5 text-slate-400 transition-transform duration-200 group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/></svg>
                    </button>

                    <div class="absolute right-0 mt-2 w-60 bg-white rounded-3xl shadow-2xl shadow-slate-200/60 border border-slate-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50 overflow-hidden">
                        <div class="p-4 bg-gradient-to-r from-blue-600 to-indigo-600 relative overflow-hidden">
                            <div class="absolute -top-4 -right-4 w-20 h-20 bg-white/10 rounded-full blur-xl"></div>
                            <div class="relative flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-white/20 border border-white/30 flex items-center justify-center font-extrabold text-white">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-bold text-white truncate">{{ auth()->user()->name }}</p>
                                    <p class="text-xs text-blue-100 truncate">{{ auth()->user()->email }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="p-2">
                            <a href="{{ route('home') }}" class="flex items-center gap-2.5 px-3 py-2.5 text-sm font-semibold text-slate-700 hover:bg-blue-50 hover:text-blue-700 rounded-2xl transition-all">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                                Lihat Website
                            </a>
                            <a href="{{ route('settings') }}" class="flex items-center gap-2.5 px-3 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-100 rounded-2xl transition-all">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                Pengaturan Akun
                            </a>
                            <div class="border-t border-slate-100 mt-1 pt-1">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center gap-2.5 px-3 py-2.5 text-sm font-bold text-rose-600 hover:bg-rose-50 rounded-2xl transition-all">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                        Keluar dari Akun
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        {{-- Page Content --}}
        <main class="flex-1 overflow-y-auto p-5 md:p-7 space-y-6">
            {{ $slot }}
        </main>
    </div>
</div>

{{-- Mobile Overlay --}}
<div id="sidebar-overlay" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-40 lg:hidden hidden transition-opacity" role="dialog" aria-modal="true"></div>

<script>
    const mobileMenuBtn = document.getElementById('mobile-menu-btn');
    const closeSidebarBtn = document.getElementById('close-sidebar-btn');
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebar-overlay');

    function openSidebar() {
        sidebar.classList.remove('-translate-x-full');
        overlay.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
    function closeSidebar() {
        sidebar.classList.add('-translate-x-full');
        overlay.classList.add('hidden');
        document.body.style.overflow = '';
    }

    mobileMenuBtn?.addEventListener('click', openSidebar);
    closeSidebarBtn?.addEventListener('click', closeSidebar);
    overlay?.addEventListener('click', closeSidebar);
</script>
</body>
</html>
