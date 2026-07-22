<x-layouts::auth :title="__('Reset Kata Sandi')">
    {{-- Header --}}
    <div class="text-center mb-8">
        <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-gradient-to-br from-emerald-400 to-teal-500 shadow-lg shadow-emerald-500/30 mb-4">
            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
            </svg>
        </div>
        <h2 class="text-2xl font-black text-slate-900 tracking-tight">Buat Kata Sandi Baru</h2>
        <p class="text-xs text-slate-500 font-medium mt-2 max-w-xs mx-auto leading-relaxed">
            Masukkan kata sandi baru yang kuat untuk mengamankan akun SIPBAR Anda.
        </p>
    </div>

    {{-- Session Status --}}
    @if (session('status'))
        <div class="mb-6 bg-emerald-50 border border-emerald-200/80 text-emerald-800 px-4 py-3 rounded-2xl text-xs font-semibold flex items-center gap-2">
            <svg class="w-4 h-4 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span>{{ session('status') }}</span>
        </div>
    @endif

    <form method="POST" action="{{ route('password.update') }}" class="space-y-5">
        @csrf
        <input type="hidden" name="token" value="{{ request()->route('token') }}">

        {{-- Email Address --}}
        <div>
            <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                Alamat Email
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <input
                    id="email"
                    name="email"
                    type="email"
                    value="{{ request('email') }}"
                    required
                    autocomplete="email"
                    placeholder="nama@sekolah.sch.id"
                    class="w-full pl-10 pr-4 py-3 bg-slate-50/80 border border-slate-200 rounded-2xl text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all duration-200 @error('email') border-rose-500 focus:ring-rose-500 @enderror"
                />
            </div>
            @error('email')
                <p class="mt-2 text-xs text-rose-600 font-medium flex items-center gap-1">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        {{-- Password --}}
        <div>
            <label for="password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                Kata Sandi Baru
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </div>
                <input
                    id="password"
                    name="password"
                    type="password"
                    required
                    autocomplete="new-password"
                    placeholder="Minimal 8 Karakter"
                    class="w-full pl-10 pr-4 py-3 bg-slate-50/80 border border-slate-200 rounded-2xl text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all duration-200 @error('password') border-rose-500 focus:ring-rose-500 @enderror"
                />
            </div>
            @error('password')
                <p class="mt-2 text-xs text-rose-600 font-medium flex items-center gap-1">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        {{-- Confirm Password --}}
        <div>
            <label for="password_confirmation" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                Konfirmasi Kata Sandi
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <input
                    id="password_confirmation"
                    name="password_confirmation"
                    type="password"
                    required
                    autocomplete="new-password"
                    placeholder="Ulangi Kata Sandi"
                    class="w-full pl-10 pr-4 py-3 bg-slate-50/80 border border-slate-200 rounded-2xl text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all duration-200 @error('password_confirmation') border-rose-500 focus:ring-rose-500 @enderror"
                />
            </div>
            @error('password_confirmation')
                <p class="mt-2 text-xs text-rose-600 font-medium flex items-center gap-1">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        {{-- Submit Button --}}
        <button
            type="submit"
            data-test="reset-password-button"
            class="w-full py-3.5 px-6 bg-gradient-to-r from-emerald-500 via-teal-500 to-emerald-600 hover:from-emerald-600 hover:to-teal-600 text-white font-bold text-sm rounded-2xl shadow-lg shadow-emerald-500/30 hover:shadow-xl hover:shadow-emerald-500/40 transition-all duration-300 hover:scale-[1.01] active:scale-[0.99] focus:outline-none focus:ring-2 focus:ring-emerald-500"
        >
            Simpan Kata Sandi Baru
        </button>
    </form>

    {{-- Divider --}}
    <div class="relative my-6">
        <div class="absolute inset-0 flex items-center">
            <div class="w-full border-t border-slate-100"></div>
        </div>
        <div class="relative flex justify-center text-xs">
            <span class="px-3 text-slate-400 bg-white font-medium">atau</span>
        </div>
    </div>

    {{-- Back to Login --}}
    <div class="text-center">
        <p class="text-slate-500 text-xs font-medium">
            Kembali ke halaman
            <a href="{{ route('login') }}" class="font-bold text-blue-600 hover:text-blue-800 transition-colors ml-1" wire:navigate>
                Masuk Sekarang
            </a>
        </p>
    </div>
</x-layouts::auth>
