<x-layouts::auth :title="__('Register')">
    {{-- Header --}}
    <div class="text-center mb-8">
        <h2 class="text-2xl font-black text-slate-900 tracking-tight font-display">
            Buat Akun SIPBAR
        </h2>
        <p class="text-xs text-slate-500 font-medium mt-1">
            Daftarkan diri Anda untuk mengajukan peminjaman barang inventaris
        </p>
    </div>

    <!-- Session Status -->
    @if (session('status'))
        <div class="mb-6 bg-emerald-50 border border-emerald-200/80 text-emerald-800 px-4 py-3 rounded-2xl text-xs font-semibold flex items-center gap-2">
            <x-icon name="check-circle" size="sm" class="text-emerald-600 flex-shrink-0" />
            <span>{{ session('status') }}</span>
        </div>
    @endif

    <form method="POST" action="{{ route('register.store') }}" class="space-y-4">
        @csrf
        
        <!-- Name Input -->
        <div>
            <label for="name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                Nama Lengkap
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <x-icon name="users" size="sm" />
                </div>
                <input
                    id="name"
                    name="name"
                    type="text"
                    value="{{ old('name') }}"
                    required
                    autofocus
                    autocomplete="name"
                    placeholder="Nama Lengkap Sesuai ID"
                    class="w-full pl-10 pr-4 py-3 bg-slate-50/80 border border-slate-200 rounded-2xl text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all duration-200 @error('name') border-rose-500 focus:ring-rose-500 @enderror"
                />
            </div>
            @error('name')
                <p class="mt-1.5 text-xs text-rose-600 font-medium flex items-center gap-1">
                    <x-icon name="exclamation-triangle" size="xs" />
                    {{ $message }}
                </p>
            @enderror
        </div>

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
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
                    autocomplete="email"
                    placeholder="nama@sekolah.sch.id"
                    class="w-full pl-10 pr-4 py-3 bg-slate-50/80 border border-slate-200 rounded-2xl text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all duration-200 @error('email') border-rose-500 focus:ring-rose-500 @enderror"
                />
            </div>
            @error('email')
                <p class="mt-1.5 text-xs text-rose-600 font-medium flex items-center gap-1">
                    <x-icon name="exclamation-triangle" size="xs" />
                    {{ $message }}
                </p>
            @enderror
        </div>

        <!-- Password Input -->
        <div>
            <label for="password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                Kata Sandi
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <x-icon name="lock-closed" size="sm" />
                </div>
                <input
                    id="password"
                    name="password"
                    type="password"
                    required
                    autocomplete="new-password"
                    placeholder="Minimal 8 Karakter"
                    class="w-full pl-10 pr-4 py-3 bg-slate-50/80 border border-slate-200 rounded-2xl text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all duration-200 @error('password') border-rose-500 focus:ring-rose-500 @enderror"
                />
            </div>
            @error('password')
                <p class="mt-1.5 text-xs text-rose-600 font-medium flex items-center gap-1">
                    <x-icon name="exclamation-triangle" size="xs" />
                    {{ $message }}
                </p>
            @enderror
        </div>

        <!-- Confirm Password Input -->
        <div>
            <label for="password_confirmation" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                Konfirmasi Kata Sandi
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <x-icon name="shield-check" size="sm" />
                </div>
                <input
                    id="password_confirmation"
                    name="password_confirmation"
                    type="password"
                    required
                    autocomplete="new-password"
                    placeholder="Ulangi Kata Sandi"
                    class="w-full pl-10 pr-4 py-3 bg-slate-50/80 border border-slate-200 rounded-2xl text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all duration-200 @error('password_confirmation') border-rose-500 focus:ring-rose-500 @enderror"
                />
            </div>
            @error('password_confirmation')
                <p class="mt-1.5 text-xs text-rose-600 font-medium flex items-center gap-1">
                    <x-icon name="exclamation-triangle" size="xs" />
                    {{ $message }}
                </p>
            @enderror
        </div>

        <!-- Submit Button -->
        <button
            type="submit"
            data-test="register-user-button"
            class="w-full mt-2 py-3.5 px-6 bg-gradient-to-r from-blue-600 via-indigo-600 to-blue-700 hover:from-blue-700 hover:to-indigo-700 text-white font-bold text-sm rounded-2xl shadow-lg shadow-blue-600/30 hover:shadow-xl hover:shadow-blue-600/40 transition-all duration-300 hover:scale-[1.01] active:scale-[0.99] focus:outline-none focus:ring-2 focus:ring-blue-500"
        >
            Daftar Akun Baru
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

    {{-- Login link --}}
    <div class="text-center">
        <p class="text-slate-500 text-xs font-medium">
            Sudah memiliki akun terdaftar?
            <a href="{{ route('login') }}" class="font-bold text-blue-600 hover:text-blue-800 transition-colors ml-1" wire:navigate>
                Masuk Sekarang
            </a>
        </p>
    </div>
</x-layouts::auth>
