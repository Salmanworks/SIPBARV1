<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        @include('partials.head')
        <style>
            @keyframes float-up {
                0%, 100% { transform: translateY(0) scale(1); opacity: 0.5; }
                50% { transform: translateY(-20px) scale(1.05); opacity: 0.8; }
            }
            .blob { animation: float-up 12s ease-in-out infinite; }
            .blob-2 { animation-delay: 4s; animation-duration: 15s; }
            .blob-3 { animation-delay: 8s; animation-duration: 10s; }
        </style>
    </head>
    <body class="h-full antialiased font-sans bg-gradient-to-br from-blue-50 via-white to-indigo-50 text-slate-800 overflow-x-hidden">

        {{-- Colorful Floating Background Blobs --}}
        <div class="fixed inset-0 overflow-hidden pointer-events-none z-0">
            <div class="blob absolute -top-32 -left-32 w-[500px] h-[500px] bg-blue-400/20 rounded-full blur-[100px]"></div>
            <div class="blob blob-2 absolute top-1/3 -right-32 w-[400px] h-[400px] bg-indigo-400/15 rounded-full blur-[90px]"></div>
            <div class="blob blob-3 absolute -bottom-32 left-1/4 w-[450px] h-[450px] bg-violet-400/15 rounded-full blur-[110px]"></div>
            <div class="absolute inset-0 bg-[radial-gradient(#6366f1_1px,transparent_1px)] [background-size:32px_32px] opacity-[0.04]"></div>
        </div>

        {{-- Main Container --}}
        <div class="relative z-10 min-h-screen flex flex-col items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
            <div class="w-full max-w-md space-y-8">

                {{-- Brand Header --}}
                <div class="text-center">
                    <a href="{{ route('home') }}" class="inline-flex flex-col items-center gap-3 group" wire:navigate>
                        <div class="relative">
                            <div class="absolute inset-0 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl blur-lg opacity-30 group-hover:opacity-60 transition-opacity"></div>
                            <div class="relative flex items-center justify-center w-16 h-16 rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-600 shadow-xl shadow-blue-500/30 border border-white group-hover:scale-105 transition-all duration-300">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                            </div>
                        </div>
                        <div>
                            <h1 class="text-3xl font-black tracking-tight text-slate-900">SIPBAR</h1>
                            <p class="text-xs font-semibold text-blue-600 tracking-widest uppercase mt-0.5">Sistem Peminjaman Barang</p>
                        </div>
                    </a>
                </div>

                {{-- Auth Form Card --}}
                <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/80 border border-slate-200/70 p-8 md:p-10 relative overflow-hidden">
                    <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-blue-500 via-indigo-500 to-violet-500"></div>
                    {{ $slot }}
                </div>

                {{-- Footer Link --}}
                <div class="text-center">
                    <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-xs font-semibold text-slate-500 hover:text-blue-600 transition-colors group py-2.5 px-5 rounded-full bg-white/80 backdrop-blur-sm border border-slate-200 shadow-sm hover:shadow-md hover:border-blue-200" wire:navigate>
                        <svg class="w-3 h-3 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                        Kembali ke Halaman Utama
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
