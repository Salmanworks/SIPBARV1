<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
        <style>
            /* Subtle gradient animation for accents */
            @keyframes gentle-pulse {
                0%, 100% { opacity: 0.5; }
                50% { opacity: 0.3; }
            }
            
            /* Glass card blur effect */
            .glass-card {
                backdrop-filter: blur(16px) saturate(180%);
                -webkit-backdrop-filter: blur(16px) saturate(180%);
            }
        </style>
    </head>
    <body class="min-h-screen antialiased overflow-x-hidden bg-gradient-to-br from-slate-50 via-blue-50 to-slate-100">
        {{-- Subtle Decorative Pattern --}}
        <div class="fixed inset-0 overflow-hidden pointer-events-none z-0 opacity-40">
            <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <pattern id="auth-grid" width="32" height="32" patternUnits="userSpaceOnUse">
                        <circle cx="16" cy="16" r="1" fill="#3b82f6" opacity="0.1"/>
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#auth-grid)"/>
            </svg>
        </div>
        
        {{-- Floating Accent Elements --}}
        <div class="fixed inset-0 overflow-hidden pointer-events-none z-0">
            <div class="absolute top-20 right-20 w-96 h-96 bg-blue-200/20 rounded-full blur-3xl" style="animation: gentle-pulse 8s ease-in-out infinite;"></div>
            <div class="absolute bottom-20 left-20 w-80 h-80 bg-slate-200/20 rounded-full blur-3xl" style="animation: gentle-pulse 10s ease-in-out infinite; animation-delay: 2s;"></div>
        </div>
        
        {{-- Main Content --}}
        <div class="relative z-10 min-h-screen flex flex-col items-center justify-center py-8 px-4 sm:px-6 lg:px-8">
            <div class="w-full max-w-md">
                {{-- Logo & Brand --}}
                <div class="text-center mb-8">
                    <a href="{{ route('home') }}" class="inline-flex flex-col items-center gap-3 group" wire:navigate>
                        {{-- Logo --}}
                        <div class="relative">
                            <div class="absolute inset-0 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl blur-lg opacity-20 group-hover:opacity-30 transition-opacity"></div>
                            <div class="relative flex items-center justify-center w-14 h-14 rounded-2xl bg-gradient-to-br from-blue-600 to-blue-700 shadow-xl group-hover:scale-105 transition-transform duration-300">
                                <x-icon name="cube" size="lg" class="text-white" />
                            </div>
                        </div>
                        
                        {{-- Brand name --}}
                        <div>
                            <h1 class="text-2xl font-bold text-slate-900">SIPBAR</h1>
                            <p class="text-sm text-slate-600 font-medium">Sistem Peminjaman Barang</p>
                        </div>
                    </a>
                </div>
                
                {{-- White Card Container --}}
                <div class="bg-white rounded-2xl shadow-xl border border-slate-200/60 p-8">
                    {{ $slot }}
                </div>
                
                {{-- Footer Link --}}
                <div class="text-center mt-6">
                    <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-sm text-slate-600 hover:text-blue-600 transition-colors group" wire:navigate>
                        <x-icon name="arrow-right" size="sm" class="rotate-180 transition-transform group-hover:-translate-x-1" />
                        <span>Kembali ke Beranda</span>
                    </a>
                </div>
            </div>
        </div>

        @persist('toast')
            <flux:toast.group>
                <flux:toast />
            </flux:toast.group>
        @endpersist

        @fluxScripts
    </body>
</html>
