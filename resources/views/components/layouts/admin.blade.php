<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('partials.head')
    <title>{{ $title ?? 'Dashboard' }} - SIPBAR Admin</title>
</head>
<body class="min-h-screen bg-slate-50 antialiased">
    <div class="flex h-screen overflow-hidden">
        {{-- Sidebar --}}
        <aside id="sidebar" class="fixed inset-y-0 left-0 z-50 w-64 bg-white border-r border-slate-200 transform transition-transform duration-300 lg:translate-x-0 lg:static lg:inset-auto">
            {{-- Sidebar Header --}}
            <div class="flex items-center gap-3 h-16 px-6 border-b border-slate-200">
                <div class="flex items-center justify-center w-10 h-10 rounded-xl bg-gradient-to-br from-blue-600 to-blue-700 shadow-lg">
                    <x-icon name="cube" size="lg" class="text-white" />
                </div>
                <div>
                    <h1 class="text-lg font-bold text-slate-900">SIPBAR</h1>
                    <p class="text-xs text-slate-600">Admin Panel</p>
                </div>
            </div>

            {{-- Sidebar Navigation --}}
            <nav class="flex-1 overflow-y-auto p-4 space-y-1">
                {{-- Dashboard --}}
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('admin.dashboard') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-slate-700 hover:bg-slate-100' }} transition-colors">
                    <x-icon name="chart-bar" size="md" />
                    <span>Dashboard</span>
                </a>

                {{-- Divider --}}
                <div class="px-4 pt-4 pb-2">
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Inventaris</p>
                </div>

                {{-- Barang --}}
                <a href="{{ route('admin.barang.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('admin.barang.*') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-slate-700 hover:bg-slate-100' }} transition-colors">
                    <x-icon name="cube" size="md" />
                    <span>Kelola Barang</span>
                </a>

                {{-- Kategori --}}
                <a href="{{ route('admin.kategori.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('admin.kategori.*') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-slate-700 hover:bg-slate-100' }} transition-colors">
                    <x-icon name="tag" size="md" />
                    <span>Kategori</span>
                </a>

                {{-- Divider --}}
                <div class="px-4 pt-4 pb-2">
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Transaksi</p>
                </div>

                {{-- Peminjaman --}}
                <a href="{{ route('admin.peminjaman.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('admin.peminjaman.*') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-slate-700 hover:bg-slate-100' }} transition-colors">
                    <x-icon name="document-text" size="md" />
                    <span>Peminjaman</span>
                    @if(isset($stats) && $stats['menunggu_approval'] > 0)
                        <span class="ml-auto bg-amber-500 text-white text-xs font-bold px-2 py-0.5 rounded-full">
                            {{ $stats['menunggu_approval'] }}
                        </span>
                    @endif
                </a>

                {{-- Laporan --}}
                <a href="{{ route('admin.laporan.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('admin.laporan.*') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-slate-700 hover:bg-slate-100' }} transition-colors">
                    <x-icon name="document-text" size="md" />
                    <span>Laporan</span>
                </a>

                {{-- Divider --}}
                <div class="px-4 pt-4 pb-2">
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Sistem</p>
                </div>

                {{-- Users --}}
                <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('admin.users.*') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-slate-700 hover:bg-slate-100' }} transition-colors">
                    <x-icon name="users" size="md" />
                    <span>Kelola User</span>
                </a>
            </nav>

            {{-- Sidebar Footer --}}
            <div class="p-4 border-t border-slate-200">
                <div class="flex items-center gap-3 px-4 py-3 bg-slate-100 rounded-xl">
                    <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-gradient-to-br from-blue-600 to-blue-700">
                        <span class="text-white text-sm font-bold">{{ substr(auth()->user()->name, 0, 1) }}</span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-slate-900 truncate">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-slate-600">Administrator</p>
                    </div>
                </div>
            </div>
        </aside>

        {{-- Main Content --}}
        <div class="flex-1 flex flex-col overflow-hidden">
            {{-- Top Header --}}
            <header class="bg-white border-b border-slate-200 h-16 flex items-center justify-between px-6">
                {{-- Mobile Menu Button --}}
                <button id="mobile-menu-btn" class="lg:hidden p-2 rounded-lg hover:bg-slate-100 transition-colors">
                    <x-icon name="cog" size="md" class="text-slate-700" />
                </button>

                {{-- Page Title (Optional) --}}
                <div class="hidden lg:block">
                    <h2 class="text-xl font-bold text-slate-900">{{ $title ?? 'Dashboard' }}</h2>
                </div>

                {{-- Right Actions --}}
                <div class="flex items-center gap-3">
                    {{-- Notifications --}}
                    <button class="relative p-2 rounded-lg hover:bg-slate-100 transition-colors">
                        <x-icon name="bell" size="md" class="text-slate-700" />
                        @if(isset($stats) && ($stats['menunggu_approval'] > 0 || $stats['terlambat'] > 0))
                            <span class="absolute top-1 right-1 w-2 h-2 bg-rose-500 rounded-full"></span>
                        @endif
                    </button>

                    {{-- User Menu --}}
                    <div class="relative group">
                        <button class="flex items-center gap-2 p-2 rounded-lg hover:bg-slate-100 transition-colors">
                            <div class="flex items-center justify-center w-8 h-8 rounded-lg bg-gradient-to-br from-blue-600 to-blue-700">
                                <span class="text-white text-xs font-bold">{{ substr(auth()->user()->name, 0, 1) }}</span>
                            </div>
                            <x-icon name="arrow-up" size="sm" class="text-slate-700 rotate-180" />
                        </button>

                        {{-- Dropdown --}}
                        <div class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-xl border border-slate-200 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                            <div class="p-4 border-b border-slate-200">
                                <p class="font-semibold text-slate-900">{{ auth()->user()->name }}</p>
                                <p class="text-sm text-slate-600">{{ auth()->user()->email }}</p>
                            </div>
                            <div class="py-2">
                                <a href="{{ route('home') }}" class="flex items-center gap-3 px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 transition-colors">
                                    <x-icon name="home" size="sm" class="text-slate-400" />
                                    <span>Lihat Website</span>
                                </a>
                            </div>
                            <div class="p-2 border-t border-slate-200">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center gap-3 px-4 py-2 text-sm text-rose-600 hover:bg-rose-50 rounded-lg transition-colors font-medium">
                                        <x-icon name="arrow-right" size="sm" class="rotate-180" />
                                        <span>Logout</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            {{-- Main Content Area --}}
            <main class="flex-1 overflow-y-auto p-6">
                {{ $slot }}
            </main>
        </div>
    </div>

    {{-- Mobile Sidebar Overlay --}}
    <div id="sidebar-overlay" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-40 lg:hidden hidden"></div>

    <script>
        // Mobile menu toggle
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const sidebar = document.getElementById('sidebar');
        const sidebarOverlay = document.getElementById('sidebar-overlay');

        mobileMenuBtn?.addEventListener('click', () => {
            sidebar.classList.toggle('-translate-x-full');
            sidebarOverlay.classList.toggle('hidden');
        });

        sidebarOverlay?.addEventListener('click', () => {
            sidebar.classList.add('-translate-x-full');
            sidebarOverlay.classList.add('hidden');
        });

        // Close sidebar on mobile when clicking a link
        document.querySelectorAll('#sidebar a').forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth < 1024) {
                    sidebar.classList.add('-translate-x-full');
                    sidebarOverlay.classList.add('hidden');
                }
            });
        });
    </script>
</body>
</html>
