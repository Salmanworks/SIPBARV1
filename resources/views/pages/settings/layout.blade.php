<div class="space-y-6">
    {{-- Header Banner Card --}}
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-blue-600 via-indigo-600 to-indigo-700 p-6 text-white shadow-lg shadow-blue-700/20">
        <div class="absolute -top-10 -right-10 w-48 h-48 bg-white/10 rounded-full blur-2xl pointer-events-none"></div>
        <div class="absolute bottom-0 left-1/3 w-40 h-40 bg-indigo-400/10 rounded-full blur-2xl pointer-events-none"></div>
        
        <div class="relative z-10 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-white/15 border border-white/20 flex items-center justify-center text-white flex-shrink-0 shadow-md">
                    <x-icon name="cog" size="lg" class="text-white" />
                </div>
                <div>
                    <h1 class="text-xl md:text-2xl font-extrabold text-white leading-tight">Pengaturan Akun</h1>
                    <p class="text-white/80 text-xs sm:text-sm mt-0.5">
                        Kelola profil, keamanan kata sandi, dan preferensi tampilan sistem Anda.
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- Horizontal Tab Navigation --}}
    <div class="flex items-center gap-2 p-1.5 rounded-2xl bg-slate-200/60 border border-slate-200/80 max-w-fit">
        <a href="{{ route('profile.edit') }}" wire:navigate
           class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-xs sm:text-sm transition-all duration-200 {{ request()->routeIs('profile.*') || request()->routeIs('settings') ? 'bg-white text-blue-600 font-extrabold shadow-sm border border-slate-200/80' : 'text-slate-600 hover:text-slate-900 font-semibold hover:bg-white/50' }}">
            <x-icon name="user" size="sm" />
            <span>Profil Saya</span>
        </a>

        <a href="{{ route('security.edit') }}" wire:navigate
           class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-xs sm:text-sm transition-all duration-200 {{ request()->routeIs('security.*') ? 'bg-white text-blue-600 font-extrabold shadow-sm border border-slate-200/80' : 'text-slate-600 hover:text-slate-900 font-semibold hover:bg-white/50' }}">
            <x-icon name="shield-check" size="sm" />
            <span>Keamanan & Password</span>
        </a>

        <a href="{{ route('appearance.edit') }}" wire:navigate
           class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-xs sm:text-sm transition-all duration-200 {{ request()->routeIs('appearance.*') ? 'bg-white text-blue-600 font-extrabold shadow-sm border border-slate-200/80' : 'text-slate-600 hover:text-slate-900 font-semibold hover:bg-white/50' }}">
            <x-icon name="sparkles" size="sm" />
            <span>Tampilan</span>
        </a>
    </div>

    {{-- Content Area --}}
    <div class="w-full">
        {{ $slot }}
    </div>
</div>
