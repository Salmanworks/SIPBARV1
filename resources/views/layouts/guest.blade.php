<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('partials.head')
    <title>SIPBAR — Sistem Peminjaman Barang Sekolah</title>
    <style>
        /* Smooth scroll behavior */
        html {
            scroll-behavior: smooth;
        }
        
        /* Navbar scroll effect */
        .navbar-scroll {
            transition: all 0.3s ease;
        }
        
        .navbar-scrolled {
            @apply bg-white/95 backdrop-blur-xl shadow-lg border-b border-slate-200;
        }
        
        /* Dropdown animation */
        .dropdown-menu {
            opacity: 0;
            transform: translateY(-10px);
            transition: all 0.2s ease;
            pointer-events: none;
        }
        
        .dropdown:hover .dropdown-menu {
            opacity: 1;
            transform: translateY(0);
            pointer-events: auto;
        }
        
        /* Mobile menu animation */
        .mobile-menu-enter {
            animation: slideDown 0.3s ease-out;
        }
        
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body class="min-h-screen bg-white text-slate-800 antialiased">
    {{-- Premium Navbar --}}
    <header class="navbar-scroll fixed top-0 left-0 right-0 z-50 bg-white border-b border-slate-100">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                {{-- Logo --}}
                <a href="/" class="flex items-center gap-3 group">
                    <div class="relative">
                        <div class="absolute inset-0 bg-gradient-to-br from-blue-600 to-purple-600 rounded-xl blur-sm group-hover:blur-md transition-all"></div>
                        <div class="relative flex items-center justify-center w-12 h-12 rounded-xl bg-gradient-to-br from-blue-600 to-purple-600 shadow-lg group-hover:shadow-xl group-hover:scale-105 transition-all duration-300">
                            <x-icon name="cube" size="lg" class="text-white" />
                        </div>
                    </div>
                    <div>
                        <p class="text-xl font-bold bg-gradient-to-r from-slate-900 to-slate-700 bg-clip-text text-transparent group-hover:from-blue-600 group-hover:to-purple-600 transition-all">
                            SIPBAR
                        </p>
                        <p class="text-xs text-slate-500 hidden sm:block">Sistem Peminjaman Barang</p>
                    </div>
                </a>
                
                {{-- Desktop Navigation --}}
                <nav class="hidden md:flex items-center gap-2">
                    <a href="#home" class="px-4 py-2 text-sm font-medium text-slate-700 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all">
                        Beranda
                    </a>
                    <a href="#fitur" class="px-4 py-2 text-sm font-medium text-slate-700 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all">
                        Fitur
                    </a>
                    <a href="#cara-kerja" class="px-4 py-2 text-sm font-medium text-slate-700 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all">
                        Cara Kerja
                    </a>
                    <a href="#kontak" class="px-4 py-2 text-sm font-medium text-slate-700 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all">
                        Kontak
                    </a>
                </nav>
                
                {{-- Right Side Actions --}}
                <div class="flex items-center gap-3">
                    @auth
                        {{-- User Dropdown (Authenticated) --}}
                        <div class="relative dropdown">
                            <button class="flex items-center gap-3 px-4 py-2.5 rounded-xl bg-gradient-to-r from-slate-50 to-slate-100 border border-slate-200 hover:shadow-md transition-all duration-300">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-lg bg-gradient-to-br from-blue-600 to-purple-600 flex items-center justify-center shadow-md">
                                        <span class="text-white text-sm font-bold">{{ substr(auth()->user()->name, 0, 1) }}</span>
                                    </div>
                                    <div class="hidden sm:block text-left">
                                        <p class="text-sm font-semibold text-slate-900">{{ auth()->user()->name }}</p>
                                        <p class="text-xs text-slate-500 capitalize">{{ auth()->user()->role->value }}</p>
                                    </div>
                                </div>
                                <x-icon name="arrow-up" size="sm" class="text-slate-400 rotate-180 hidden sm:block" />
                            </button>
                            
                            {{-- Dropdown Menu --}}
                            <div class="dropdown-menu absolute right-0 mt-2 w-64 bg-white rounded-xl shadow-2xl border border-slate-200 overflow-hidden">
                                <div class="p-4 border-b border-slate-100 bg-gradient-to-br from-blue-50 to-purple-50">
                                    <p class="font-semibold text-slate-900">{{ auth()->user()->name }}</p>
                                    <p class="text-sm text-slate-600">{{ auth()->user()->email }}</p>
                                    <span class="inline-flex items-center gap-1 mt-2 px-2 py-1 rounded-full bg-white text-xs font-medium text-blue-600 border border-blue-200">
                                        <x-icon name="shield-check" size="xs" />
                                        <span class="capitalize">{{ auth()->user()->role->value }}</span>
                                    </span>
                                </div>
                                
                                <div class="py-2">
                                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-sm text-slate-700 hover:bg-slate-50 transition-colors">
                                        <x-icon name="chart-bar" size="sm" class="text-slate-400" />
                                        <span>Dashboard</span>
                                    </a>
                                    
                                    @if(auth()->user()->role->value === 'admin')
                                    <a href="{{ route('admin.barang.index') }}" class="flex items-center gap-3 px-4 py-3 text-sm text-slate-700 hover:bg-slate-50 transition-colors">
                                        <x-icon name="cube" size="sm" class="text-slate-400" />
                                        <span>Kelola Barang</span>
                                    </a>
                                    @endif
                                    
                                    @if(in_array(auth()->user()->role->value, ['peminjam', 'admin', 'petugas']))
                                    <a href="{{ route('peminjam.pengajuan.create') }}" class="flex items-center gap-3 px-4 py-3 text-sm text-slate-700 hover:bg-slate-50 transition-colors">
                                        <x-icon name="document-text" size="sm" class="text-slate-400" />
                                        <span>Ajukan Peminjaman</span>
                                    </a>
                                    @endif
                                    
                                    <a href="{{ route('settings') }}" class="flex items-center gap-3 px-4 py-3 text-sm text-slate-700 hover:bg-slate-50 transition-colors">
                                        <x-icon name="cog" size="sm" class="text-slate-400" />
                                        <span>Pengaturan</span>
                                    </a>
                                </div>
                                
                                <div class="p-2 border-t border-slate-100">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 text-sm text-rose-600 hover:bg-rose-50 rounded-lg transition-colors font-medium">
                                            <x-icon name="arrow-right" size="sm" class="rotate-180" />
                                            <span>Keluar</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        {{-- Guest Actions --}}
                        <a href="{{ route('login') }}" class="hidden sm:flex items-center gap-2 px-5 py-2.5 text-sm font-medium text-slate-700 hover:text-blue-600 transition-colors">
                            <span>Masuk</span>
                        </a>
                        <a href="{{ route('login') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-gradient-to-r from-blue-600 to-purple-600 text-white font-semibold shadow-lg shadow-blue-600/30 hover:shadow-xl hover:shadow-blue-600/40 hover:scale-105 transition-all duration-300">
                            <x-icon name="sparkles" size="sm" />
                            <span>Mulai Gratis</span>
                        </a>
                    @endauth
                    
                    {{-- Mobile Menu Button --}}
                    <button id="mobile-menu-button" class="md:hidden p-2.5 rounded-lg hover:bg-slate-100 transition-colors">
                        <x-icon name="cog" size="md" class="text-slate-700" />
                    </button>
                </div>
            </div>
            
            {{-- Mobile Menu --}}
            <div id="mobile-menu" class="hidden md:hidden pb-4 border-t border-slate-100 mt-4">
                <nav class="flex flex-col gap-1 pt-4">
                    <a href="#home" class="px-4 py-3 text-sm font-medium text-slate-700 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all">
                        Beranda
                    </a>
                    <a href="#fitur" class="px-4 py-3 text-sm font-medium text-slate-700 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all">
                        Fitur
                    </a>
                    <a href="#cara-kerja" class="px-4 py-3 text-sm font-medium text-slate-700 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all">
                        Cara Kerja
                    </a>
                    <a href="#kontak" class="px-4 py-3 text-sm font-medium text-slate-700 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all">
                        Kontak
                    </a>
                    
                    @auth
                    <div class="mt-4 pt-4 border-t border-slate-200">
                        <div class="px-4 py-3 bg-gradient-to-br from-blue-50 to-purple-50 rounded-lg mb-2">
                            <p class="font-semibold text-slate-900 text-sm">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-slate-600">{{ auth()->user()->email }}</p>
                        </div>
                        <a href="{{ route('dashboard') }}" class="flex items-center gap-2 px-4 py-3 text-sm text-slate-700 hover:bg-slate-50 rounded-lg">
                            <x-icon name="chart-bar" size="sm" />
                            <span>Dashboard</span>
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full flex items-center gap-2 px-4 py-3 text-sm text-rose-600 hover:bg-rose-50 rounded-lg font-medium">
                                <x-icon name="arrow-right" size="sm" class="rotate-180" />
                                <span>Keluar</span>
                            </button>
                        </form>
                    </div>
                    @endauth
                </nav>
            </div>
        </div>
    </header>

    <main class="pt-20">
        @yield('content')
    </main>

    {{-- Enhanced Footer --}}
    <footer class="bg-slate-900 text-white">
        <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                {{-- Brand --}}
                <div class="col-span-1 md:col-span-2">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-gradient-to-br from-blue-500 to-purple-600">
                            <x-icon name="cube" size="md" class="text-white" />
                        </div>
                        <span class="text-lg font-bold">SIPBAR</span>
                    </div>
                    <p class="text-slate-400 mb-4 max-w-sm">
                        Sistem Informasi Peminjaman Barang untuk sekolah. Kelola inventaris dengan mudah, cepat, dan akurat.
                    </p>
                    <div class="flex items-center gap-3">
                        <a href="#" class="w-10 h-10 rounded-lg bg-slate-800 hover:bg-blue-600 flex items-center justify-center transition-colors">
                            <x-icon name="envelope" size="sm" />
                        </a>
                        <a href="#" class="w-10 h-10 rounded-lg bg-slate-800 hover:bg-blue-600 flex items-center justify-center transition-colors">
                            <x-icon name="phone" size="sm" />
                        </a>
                    </div>
                </div>
                
                {{-- Links --}}
                <div>
                    <h3 class="font-semibold mb-4">Menu</h3>
                    <ul class="space-y-2 text-sm text-slate-400">
                        <li><a href="#home" class="hover:text-white transition-colors">Beranda</a></li>
                        <li><a href="#fitur" class="hover:text-white transition-colors">Fitur</a></li>
                        <li><a href="#cara-kerja" class="hover:text-white transition-colors">Cara Kerja</a></li>
                        <li><a href="#kontak" class="hover:text-white transition-colors">Kontak</a></li>
                    </ul>
                </div>
                
                {{-- Contact --}}
                <div>
                    <h3 class="font-semibold mb-4">Kontak</h3>
                    <ul class="space-y-3 text-sm text-slate-400">
                        <li class="flex items-start gap-2">
                            <x-icon name="map-pin" size="sm" class="text-slate-500 flex-shrink-0 mt-0.5" />
                            <span>Jl. Pendidikan No. 123<br>Jakarta 10110</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <x-icon name="envelope" size="sm" class="text-slate-500 flex-shrink-0" />
                            <span>gudang@sekolah.sch.id</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <x-icon name="phone" size="sm" class="text-slate-500 flex-shrink-0" />
                            <span>(021) 1234-5678</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-slate-800 pt-8 flex flex-col sm:flex-row justify-between items-center gap-4">
                <p class="text-sm text-slate-400">
                    © {{ date('Y') }} SIPBAR. All rights reserved.
                </p>
                <div class="flex items-center gap-2 text-sm text-slate-400">
                    <span>Made with</span>
                    <x-icon name="heart" size="sm" class="text-rose-500" />
                    <span>by SMK Negeri Contoh</span>
                </div>
            </div>
        </div>
    </footer>
    
    {{-- Scripts --}}
    <script>
        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar-scroll');
            if (window.scrollY > 20) {
                navbar.classList.add('navbar-scrolled');
            } else {
                navbar.classList.remove('navbar-scrolled');
            }
        });
        
        // Mobile menu toggle
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');
        
        if (mobileMenuButton && mobileMenu) {
            mobileMenuButton.addEventListener('click', function() {
                mobileMenu.classList.toggle('hidden');
                if (!mobileMenu.classList.contains('hidden')) {
                    mobileMenu.classList.add('mobile-menu-enter');
                }
            });
            
            // Close mobile menu when clicking on a link
            document.querySelectorAll('#mobile-menu a').forEach(link => {
                link.addEventListener('click', function() {
                    mobileMenu.classList.add('hidden');
                });
            });
        }
    </script>
</body>
</html>
