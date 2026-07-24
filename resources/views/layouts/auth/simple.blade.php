<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full light" style="color-scheme: light !important;">
    <head>
        @include('partials.head')
        <title>{{ $title ?? 'SIPBAR — Login' }}</title>
        <style>
            /* Force clean light background regardless of system dark mode preference */
            html, body {
                background-color: #f4f3ff !important;
                color: #0f172a !important;
            }
            .dark body, .dark html {
                background-color: #f4f3ff !important;
                color: #0f172a !important;
            }

            @keyframes mesh-gradient {
                0% { background-position: 0% 50%; }
                50% { background-position: 100% 50%; }
                100% { background-position: 0% 50%; }
            }
            .hero-mesh {
                background: linear-gradient(-45deg, #38bdf8, #4f46e5, #7c3aed, #c084fc);
                background-size: 300% 300%;
                animation: mesh-gradient 10s ease infinite;
            }

            /* Custom input fix for autofill & dark mode overrides */
            input, select {
                background-color: #f8fafc !important;
                color: #0f172a !important;
            }
            input:focus, select:focus {
                background-color: #ffffff !important;
            }
        </style>
    </head>
    <body class="h-full antialiased font-sans bg-[#f4f3ff] text-slate-800 flex items-center justify-center p-4 sm:p-6 lg:p-8">

        {{-- Outer Background Decorative Soft Blobs --}}
        <div class="fixed inset-0 overflow-hidden pointer-events-none z-0">
            <div class="absolute -top-32 -left-32 w-[500px] h-[500px] bg-blue-300/20 rounded-full blur-[120px]"></div>
            <div class="absolute top-1/3 -right-32 w-[450px] h-[450px] bg-indigo-300/20 rounded-full blur-[100px]"></div>
            <div class="absolute -bottom-32 left-1/4 w-[450px] h-[450px] bg-purple-300/20 rounded-full blur-[110px]"></div>
        </div>

        {{-- Main Layout Container --}}
        <div class="w-full flex items-center justify-center relative z-10">
            @if(isset($slot) && !empty((string)$slot))
                {{ $slot }}
            @else
                @yield('content')
            @endif
        </div>

        @persist('toast')
            <flux:toast.group>
                <flux:toast />
            </flux:toast.group>
        @endpersist

        @fluxScripts
    </body>
</html>
