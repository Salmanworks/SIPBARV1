<x-layouts::auth :title="__('Log in')">
    {{-- Card Header --}}
    <div class="text-center mb-8">
        <h2 class="text-2xl font-black text-slate-900 tracking-tight font-display">
            Selamat Datang Kembali
        </h2>
        <p class="text-xs text-slate-500 font-medium mt-1">
            Masuk dengan akun terdaftar Anda untuk mengakses SIPBAR
        </p>
    </div>

    <!-- Session Status Alert -->
    @if (session('status'))
        <div class="mb-6 bg-emerald-50 border border-emerald-200/80 text-emerald-800 px-4 py-3 rounded-2xl text-xs font-semibold flex items-center gap-2">
            <x-icon name="check-circle" size="sm" class="text-emerald-600 flex-shrink-0" />
            <span>{{ session('status') }}</span>
        </div>
    @endif

    {{-- Passkey Quick Verification Component if available --}}
    <div class="mb-6">
        <x-passkey-verify />
    </div>

    <form method="POST" action="{{ route('login.store') }}" class="space-y-5">
        @csrf

        <!-- Email Input -->
        <div>
            <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                Alamat Email
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <x-icon name="envelope" size="sm" />
                </div>
                <input
                    id="email"
                    name="email"
                    type="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
                    autocomplete="email"
                    placeholder="nama@sekolah.sch.id"
                    class="w-full pl-10 pr-4 py-3 bg-slate-50/80 border border-slate-200 rounded-2xl text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all duration-200 @error('email') border-rose-500 focus:ring-rose-500 @enderror"
                />
            </div>
            @error('email')
                <p class="mt-2 text-xs text-rose-600 font-medium flex items-center gap-1">
                    <x-icon name="exclamation-triangle" size="xs" />
                    {{ $message }}
                </p>
            @enderror
        </div>

        <!-- Password Input -->
        <div>
            <div class="flex items-center justify-between mb-2">
                <label for="password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                    Kata Sandi
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-xs text-blue-600 hover:text-blue-800 font-bold transition-colors" wire:navigate>
                        Lupa Kata Sandi?
                    </a>
                @endif
            </div>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <x-icon name="lock-closed" size="sm" />
                </div>
                <input
                    id="password"
                    name="password"
                    type="password"
                    required
                    autocomplete="current-password"
                    placeholder="••••••••"
                    class="w-full pl-10 pr-4 py-3 bg-slate-50/80 border border-slate-200 rounded-2xl text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all duration-200 @error('password') border-rose-500 focus:ring-rose-500 @enderror"
                />
            </div>
            @error('password')
                <p class="mt-2 text-xs text-rose-600 font-medium flex items-center gap-1">
                    <x-icon name="exclamation-triangle" size="xs" />
                    {{ $message }}
                </p>
            @enderror
        </div>

        <!-- Remember Me Checkbox -->
        <div class="flex items-center justify-between pt-1">
            <label class="flex items-center gap-2.5 cursor-pointer select-none">
                <input
                    id="remember"
                    name="remember"
                    type="checkbox"
                    {{ old('remember') ? 'checked' : '' }}
                    class="w-4 h-4 text-blue-600 bg-slate-50 border-slate-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:ring-offset-0 cursor-pointer"
                />
                <span class="text-xs font-semibold text-slate-600">
                    Ingat saya di perangkat ini
                </span>
            </label>
        </div>

        <!-- Submit Button -->
        <button
            type="submit"
            data-test="login-button"
            class="w-full py-3.5 px-6 bg-gradient-to-r from-blue-600 via-indigo-600 to-blue-700 hover:from-blue-700 hover:to-indigo-700 text-white font-bold text-sm rounded-2xl shadow-lg shadow-blue-600/30 hover:shadow-xl hover:shadow-blue-600/40 transition-all duration-300 hover:scale-[1.01] active:scale-[0.99] focus:outline-none focus:ring-2 focus:ring-blue-500"
        >
            Masuk ke Akun
        </button>
    </form>

    {{-- Divider --}}
    <div class="relative my-6">
        <div class="absolute inset-0 flex items-center">
            <div class="w-full border-t border-slate-100"></div>
        </div>
        <div class="relative flex justify-center text-xs">
            <span class="px-3 text-slate-400 bg-white font-medium">
                atau
            </span>
        </div>
    </div>

    {{-- Register Link --}}
    <div class="text-center">
        <p class="text-slate-500 text-xs font-medium">
            Belum memiliki akun SIPBAR?
            <a href="{{ route('register') }}" class="font-bold text-blue-600 hover:text-blue-800 transition-colors ml-1" wire:navigate>
                Daftar Akun Baru
            </a>
        </p>
    </div>
</x-layouts::auth>
