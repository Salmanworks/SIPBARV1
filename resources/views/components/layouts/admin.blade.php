<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('partials.head')
    <title>{{ $title ?? 'Dashboard' }} - SIPBAR Admin</title>
    <style>
        *, *::before, *::after { box-sizing: border-box; }
        html, body { margin: 0; padding: 0; height: 100%; }
        #sidebar-overlay { display: none; }
    </style>
</head>
<body class="min-h-screen bg-slate-50 text-slate-900 antialiased">
    <div class="flex min-h-screen">
        {{-- Sidebar: always fixed, shown via lg:translate-x-0, never in normal flex flow --}}
        <aside id="sidebar" class="fixed inset-y-0 left-0 z-50 flex flex-col w-64 bg-gradient-to-b from-slate-900 via-slate-900 to-slate-950 border-r border-slate-800 shadow-xl -translate-x-full transition-transform duration-300 ease-in-out lg:translate-x-0">
            {{-- Sidebar Header --}}
            <div class="flex items-center gap-3 h-14 px-5 border-b border-slate-700/50">
                <div class="flex items-center justify-center w-9 h-9 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 shadow-lg shadow-blue-500/30">
                    <x-icon name="cube" size="md" class="text-white" />
                </div>
                <div>
                    <h1 class="text-base font-bold text-white">SIPBAR</h1>
                    <p class="text-[10px] uppercase tracking-[0.15em] text-slate-400">Admin Panel</p>
                </div>
            </div>

            {{-- Sidebar Navigation --}}
            <nav class="flex-1 overflow-y-auto p-3 space-y-0.5">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2.5 px-3 py-2.5 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold shadow-lg shadow-blue-500/30' : 'text-slate-300 hover:bg-slate-700/50 hover:text-white' }}">
                    <x-icon name="chart-bar" size="sm" />
                    <span class="text-sm">Dashboard</span>
                </a>

                <div class="px-3 pt-3 pb-1.5">
                    <p class="text-[9px] font-semibold text-slate-500 uppercase tracking-[0.15em]">Inventaris</p>
                </div>

                <a href="{{ route('admin.barang.index') }}" class="flex items-center gap-2.5 px-3 py-2.5 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.barang.*') ? 'bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold shadow-lg shadow-blue-500/30' : 'text-slate-300 hover:bg-slate-700/50 hover:text-white' }}">
                    <x-icon name="cube" size="sm" />
                    <span class="text-sm">Kelola Barang</span>
                </a>

                <a href="{{ route('admin.kategori.index') }}" class="flex items-center gap-2.5 px-3 py-2.5 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.kategori.*') ? 'bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold shadow-lg shadow-blue-500/30' : 'text-slate-300 hover:bg-slate-700/50 hover:text-white' }}">
                    <x-icon name="tag" size="sm" />
                    <span class="text-sm">Kategori</span>
                </a>

                <div class="px-3 pt-3 pb-1.5">
                    <p class="text-[9px] font-semibold text-slate-500 uppercase tracking-[0.15em]">Pengguna</p>
                </div>

                <a href="{{ route('admin.guru.index') }}" class="flex items-center gap-2.5 px-3 py-2.5 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.guru.*') ? 'bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold shadow-lg shadow-blue-500/30' : 'text-slate-300 hover:bg-slate-700/50 hover:text-white' }}">
                    <x-icon name="users" size="sm" />
                    <span class="text-sm">Guru</span>
                </a>

                <a href="{{ route('admin.siswa.index') }}" class="flex items-center gap-2.5 px-3 py-2.5 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.siswa.*') ? 'bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold shadow-lg shadow-blue-500/30' : 'text-slate-300 hover:bg-slate-700/50 hover:text-white' }}">
                    <x-icon name="users" size="sm" />
                    <span class="text-sm">Siswa</span>
                </a>

                <div class="px-3 pt-3 pb-1.5">
                    <p class="text-[9px] font-semibold text-slate-500 uppercase tracking-[0.15em]">Transaksi</p>
                </div>

                <a href="{{ route('admin.peminjaman.index') }}" class="flex items-center gap-2.5 px-3 py-2.5 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.peminjaman.*') ? 'bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold shadow-lg shadow-blue-500/30' : 'text-slate-300 hover:bg-slate-700/50 hover:text-white' }}">
                    <x-icon name="document-text" size="sm" />
                    <span class="text-sm">Peminjaman</span>
                    @if(isset($stats) && data_get($stats, 'menunggu_approval', 0) > 0)
                        <span class="ml-auto inline-flex items-center justify-center rounded-full bg-amber-500 px-2 py-0.5 text-[9px] font-semibold text-white shadow-lg shadow-amber-500/30">
                            {{ data_get($stats, 'menunggu_approval', 0) }}
                        </span>
                    @endif
                </a>

                <a href="{{ route('admin.laporan.index') }}" class="flex items-center gap-2.5 px-3 py-2.5 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.laporan.*') ? 'bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold shadow-lg shadow-blue-500/30' : 'text-slate-300 hover:bg-slate-700/50 hover:text-white' }}">
                    <x-icon name="document-text" size="sm" />
                    <span class="text-sm">Laporan</span>
                </a>

                <div class="px-3 pt-3 pb-1.5">
                    <p class="text-[9px] font-semibold text-slate-500 uppercase tracking-[0.15em]">Sistem</p>
                </div>

                <a href="{{ route('admin.users.index') }}" class="flex items-center gap-2.5 px-3 py-2.5 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.users.*') ? 'bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold shadow-lg shadow-blue-500/30' : 'text-slate-300 hover:bg-slate-700/50 hover:text-white' }}">
                    <x-icon name="users" size="sm" />
                    <span class="text-sm">Kelola User</span>
                </a>

                <a href="{{ route('admin.activity-log.index') }}" class="flex items-center gap-2.5 px-3 py-2.5 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.activity-log.*') ? 'bg-gradient-to-r from-rose-500 to-rose-600 text-white font-semibold shadow-lg shadow-rose-500/30' : 'text-slate-300 hover:bg-slate-700/50 hover:text-white' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                    <span class="text-sm">Activity Log</span>
                </a>
            </nav>

            {{-- Sidebar Footer --}}
            <div class="p-3 border-t border-slate-700/50">
                <div class="flex items-center gap-2.5 px-3 py-2.5 bg-slate-700/30 rounded-xl border border-slate-600/30">
                    <div class="flex items-center justify-center w-8 h-8 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 text-white font-semibold shadow-lg shadow-blue-500/30 text-xs">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div class="min-w-0">
                        <p class="text-xs font-semibold text-white truncate">{{ auth()->user()->name }}</p>
                        <p class="text-[10px] text-slate-400">Administrator</p>
                    </div>
                </div>
            </div>
        </aside>

        {{-- Main Content: full width, offset left by sidebar width on desktop --}}
        <div class="flex-1 flex flex-col min-w-0 w-full lg:pl-64">
            <header class="sticky top-0 z-40 border-b border-slate-200 bg-white/95 backdrop-blur-sm shadow-sm">
                <div class="flex items-center justify-between gap-3 px-4 py-4 md:px-6">
                    <div class="flex items-center gap-3">
                        <button id="mobile-menu-btn" class="lg:hidden inline-flex items-center justify-center w-10 h-10 rounded-2xl bg-slate-100 text-slate-700 hover:bg-slate-200 transition-colors">
                            <x-icon name="bars-3" size="md" />
                        </button>
                        <div>
                            <h2 class="text-base font-semibold text-slate-900">{{ $title ?? 'Dashboard' }}</h2>
                            <p class="text-xs text-slate-500">Panel kontrol admin yang lebih rapi dan mudah digunakan.</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        <button class="relative inline-flex items-center justify-center w-10 h-10 rounded-2xl bg-slate-100 text-slate-700 hover:bg-slate-200 transition-colors">
                            <x-icon name="bell" size="md" class="text-slate-700" />
                            @if(isset($stats) && (data_get($stats, 'menunggu_approval', 0) > 0 || data_get($stats, 'terlambat', 0) > 0))
                                <span class="absolute top-2 right-2 inline-block h-2 w-2 rounded-full bg-rose-500 ring-2 ring-white"></span>
                            @endif
                        </button>

                        <div class="relative group">
                            <button class="inline-flex items-center gap-2 px-3 py-2 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-700 transition-colors">
                                <div class="flex items-center justify-center w-8 h-8 rounded-xl bg-gradient-to-br from-blue-600 to-indigo-600 text-white font-semibold text-sm">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                                <span class="hidden sm:inline text-sm font-semibold">{{ Str::limit(auth()->user()->name, 14) }}</span>
                                <x-icon name="chevron-down" size="sm" class="text-slate-500" />
                            </button>

                            <div class="absolute right-0 mt-2 w-64 overflow-hidden rounded-3xl bg-white border border-slate-200 shadow-2xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                                <div class="p-4 bg-gradient-to-r from-blue-600 to-indigo-600 text-white">
                                    <div class="flex items-center gap-3">
                                        <div class="flex items-center justify-center w-10 h-10 rounded-2xl bg-white/15 text-white font-semibold">
                                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                        </div>
                                        <div class="min-w-0">
                                            <p class="text-sm font-bold truncate">{{ auth()->user()->name }}</p>
                                            <p class="text-xs opacity-80 truncate">{{ auth()->user()->email }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-2">
                                    <a href="{{ route('home') }}" class="flex items-center gap-3 px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 rounded-2xl transition-colors">
                                        <x-icon name="home" size="sm" class="text-slate-400" />
                                        <span>Lihat Website</span>
                                    </a>
                                    <a href="{{ route('settings') }}" class="flex items-center gap-3 px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 rounded-2xl transition-colors">
                                        <x-icon name="cog" size="sm" class="text-slate-400" />
                                        <span>Pengaturan</span>
                                    </a>
                                </div>
                                <div class="border-t border-slate-200 p-2">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="w-full flex items-center gap-3 px-4 py-2 text-sm text-rose-600 hover:bg-rose-50 rounded-2xl transition-colors font-semibold">
                                            <x-icon name="arrow-right" size="sm" class="rotate-180" />
                                            <span>Logout</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto">
                <div class="p-5 sm:p-6 lg:p-7 min-w-0 w-full">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>

    <div id="sidebar-overlay" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-40 lg:hidden" style="display:none;"></div>

    <script>
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const sidebar = document.getElementById('sidebar');
        const sidebarOverlay = document.getElementById('sidebar-overlay');

        function openSidebar() {
            sidebar.classList.remove('-translate-x-full');
            if (sidebarOverlay) sidebarOverlay.style.display = 'block';
            document.body.style.overflow = 'hidden';
        }

        function closeSidebar() {
            sidebar.classList.add('-translate-x-full');
            if (sidebarOverlay) sidebarOverlay.style.display = 'none';
            document.body.style.overflow = '';
        }

        mobileMenuBtn?.addEventListener('click', () => {
            if (sidebar.classList.contains('-translate-x-full')) {
                openSidebar();
            } else {
                closeSidebar();
            }
        });

        sidebarOverlay?.addEventListener('click', closeSidebar);

        document.querySelectorAll('#sidebar a').forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth < 1024) {
                    closeSidebar();
                }
            });
        });
    </script>
</body>
</html>
