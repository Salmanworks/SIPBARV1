<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        @include('partials.head')
        <title>{{ $title ?? 'Log in' }} — SIPBAR</title>
        <style>
            @keyframes float-ambient {
                0%, 100% { transform: translate(0, 0) scale(1); }
                50% { transform: translate(15px, -15px) scale(1.04); }
            }
            .ambient-orb { animation: float-ambient 10s ease-in-out infinite; }
            .ambient-orb-2 { animation: float-ambient 14s ease-in-out infinite reverse; }
        </style>
    </head>
    <body class="min-h-screen antialiased font-sans bg-[#f4f3fb] text-slate-800 flex items-center justify-center p-4 sm:p-6 lg:p-8">

        {{-- Background Soft Blobs --}}
        <div class="fixed inset-0 overflow-hidden pointer-events-none z-0">
            <div class="ambient-orb absolute -top-24 -left-24 w-[480px] h-[480px] bg-indigo-300/25 rounded-full blur-[120px]"></div>
            <div class="ambient-orb-2 absolute -bottom-24 -right-24 w-[520px] h-[520px] bg-blue-300/25 rounded-full blur-[130px]"></div>
            <div class="absolute inset-0 bg-[radial-gradient(#6366f1_1px,transparent_1px)] [background-size:36px_36px] opacity-[0.03]"></div>
        </div>

        {{-- Main Split Floating Card Container --}}
        <div class="relative z-10 w-full max-w-4xl bg-white rounded-[32px] sm:rounded-[36px] shadow-2xl shadow-indigo-500/10 border border-slate-100/90 p-3 sm:p-4 md:p-5 overflow-hidden flex flex-col md:flex-row gap-4 md:gap-6 min-h-[580px] my-auto">

            {{-- LEFT SIDE: Beautiful Mesh Gradient Banner --}}
            <div class="w-full md:w-[42%] lg:w-[44%] rounded-[26px] sm:rounded-[28px] bg-gradient-to-br from-blue-600 via-indigo-600 to-purple-600 p-7 sm:p-9 flex flex-col justify-between relative overflow-hidden text-white shadow-xl shadow-indigo-600/20 min-h-[220px] md:min-h-[520px]">
                
                {{-- Decorative Ambient Mesh Blur Orbs --}}
                <div class="absolute -top-12 -right-12 w-56 h-56 bg-purple-400/35 rounded-full blur-3xl pointer-events-none"></div>
                <div class="absolute -bottom-12 -left-12 w-56 h-56 bg-blue-400/35 rounded-full blur-3xl pointer-events-none"></div>
                <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_left,rgba(255,255,255,0.15)_0%,transparent_60%)] pointer-events-none"></div>

                {{-- Top Logo / Sparkle Mark --}}
                <div class="relative z-10 flex items-center justify-between">
                    <a href="{{ route('home') }}" class="inline-flex items-center gap-2 group" wire:navigate>
                        <div class="w-10 h-10 rounded-2xl bg-white/15 backdrop-blur-md border border-white/25 flex items-center justify-center group-hover:scale-105 transition-all">
                            {{-- Asterisk / Sparkle Icon matching image --}}
                            <svg class="w-6 h-6 text-white" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 2L13.5 9.5L21 11L13.5 12.5L12 20L10.5 12.5L3 11L10.5 9.5L12 2Z"/>
                            </svg>
                        </div>
                        <span class="text-lg font-black tracking-tight text-white">SIPBAR</span>
                    </a>
                    <span class="px-3 py-1 rounded-full bg-white/15 border border-white/20 text-[10px] font-extrabold uppercase tracking-wider text-white backdrop-blur-sm">v2.0</span>
                </div>

                {{-- Bottom Copywriting --}}
                <div class="relative z-10 space-y-3 mt-10 md:mt-auto">
                    <p class="text-xs font-bold text-blue-200 uppercase tracking-widest">Platform Peminjaman Modern</p>
                    <h2 class="text-2xl sm:text-3xl font-black leading-tight tracking-tight text-white">
                        Dapatkan akses hub inventaris sekolah dengan mudah & cepat.
                    </h2>
                    <p class="text-xs text-white/75 leading-relaxed hidden sm:block">
                        Pantau status barang, ajukan peminjaman online, dan nikmati autentikasi aman di satu tempat.
                    </p>
                </div>
            </div>

            {{-- RIGHT SIDE: Clean White Form Card --}}
            <div class="w-full md:w-[58%] lg:w-[56%] p-4 sm:p-7 md:p-9 flex flex-col justify-center">
                {{ $slot }}
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
