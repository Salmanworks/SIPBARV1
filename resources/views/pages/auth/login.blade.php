<x-layouts::auth :title="__('Log in')">
    {{-- Header --}}
    <div class="text-center mb-8">
        <h2 class="text-2xl font-bold text-slate-900 mb-2">
            Masuk ke SIPBAR
        </h2>
        <p class="text-slate-600">
            Silakan masuk dengan akun Anda
        </p>
    </div>

    <!-- Session Status -->
    @if (session('status'))
        <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl text-sm">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login.store') }}" class="space-y-5">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-semibold text-slate-700 mb-2">
                Email
            </label>
            <input
                id="email"
                name="email"
                type="email"
                value="{{ old('email') }}"
                required
                autofocus
                autocomplete="email"
                placeholder="nama@email.com"
                class="w-full px-4 py-3 bg-white border-2 border-slate-300 rounded-xl text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 @error('email') border-rose-500 focus:ring-rose-500 @enderror"
            />
            @error('email')
                <p class="mt-2 text-sm text-rose-600 flex items-center gap-1">
                    <x-icon name="exclamation-triangle" size="sm" />
                    {{ $message }}
                </p>
            @enderror
        </div>

        <!-- Password -->
        <div>
            <div class="flex items-center justify-between mb-2">
                <label for="password" class="block text-sm font-semibold text-slate-700">
                    Password
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-sm text-blue-600 hover:text-blue-700 font-medium transition-colors" wire:navigate>
                        Lupa Password?
                    </a>
                @endif
            </div>
            <input
                id="password"
                name="password"
                type="password"
                required
                autocomplete="current-password"
                placeholder="Masukkan password"
                class="w-full px-4 py-3 bg-white border-2 border-slate-300 rounded-xl text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 @error('password') border-rose-500 focus:ring-rose-500 @enderror"
            />
            @error('password')
                <p class="mt-2 text-sm text-rose-600 flex items-center gap-1">
                    <x-icon name="exclamation-triangle" size="sm" />
                    {{ $message }}
                </p>
            @enderror
        </div>

        <!-- Remember Me -->
        <div class="flex items-center gap-2">
            <input
                id="remember"
                name="remember"
                type="checkbox"
                {{ old('remember') ? 'checked' : '' }}
                class="w-4 h-4 text-blue-600 bg-white border-2 border-slate-300 rounded focus:ring-2 focus:ring-blue-500 focus:ring-offset-0 cursor-pointer"
            />
            <label for="remember" class="text-sm font-medium text-slate-700 cursor-pointer select-none">
                Ingat saya
            </label>
        </div>

        <!-- Submit Button -->
        <button
            type="submit"
            data-test="login-button"
            class="w-full py-3.5 px-6 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold rounded-xl shadow-lg shadow-blue-600/30 hover:shadow-xl hover:shadow-blue-600/40 transition-all duration-300 hover:scale-[1.02] focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
        >
            Masuk
        </button>
    </form>

    {{-- Divider --}}
    <div class="relative my-8">
        <div class="absolute inset-0 flex items-center">
            <div class="w-full border-t border-slate-200"></div>
        </div>
        <div class="relative flex justify-center text-sm">
            <span class="px-4 text-slate-500 bg-white">
                atau
            </span>
        </div>
    </div>

    {{-- Sign up link --}}
    <div class="text-center">
        <p class="text-slate-600 text-sm">
            Belum punya akun?
            <a href="{{ route('register') }}" class="font-semibold text-blue-600 hover:text-blue-700 transition-colors ml-1" wire:navigate>
                Daftar Sekarang
            </a>
        </p>
    </div>
</x-layouts::auth>
