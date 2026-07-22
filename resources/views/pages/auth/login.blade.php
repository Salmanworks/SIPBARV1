<x-layouts::auth :title="__('Masuk ke Akun')">

    {{-- Top Sparkle Icon & Header matching reference image --}}
    <div class="mb-5">
        <div class="w-8 h-8 rounded-xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-600 mb-2.5">
            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                <path d="M12 2L13.5 9.5L21 11L13.5 12.5L12 20L10.5 12.5L3 11L10.5 9.5L12 2Z"/>
            </svg>
        </div>
        <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
            Masuk ke Akun
        </h1>
        <p class="text-xs text-slate-500 font-medium mt-1 leading-relaxed">
            Pilih peran Anda dan masukkan data login untuk mengakses sistem SIPBAR.
        </p>
    </div>

    <!-- Session Status Alert -->
    @if (session('status'))
        <div class="mb-5 bg-emerald-50 border border-emerald-200/80 text-emerald-800 px-4 py-3 rounded-2xl text-xs font-semibold flex items-center gap-2">
            <svg class="w-4 h-4 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            <span>{{ session('status') }}</span>
        </div>
    @endif

    <form method="POST" action="{{ route('login.store') }}" class="space-y-4">
        @csrf

        {{-- DROPDOWN ROLE SELECTION (PILIH GURU ATU SISWA) --}}
        <div>
            <label for="role-select" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5 flex items-center justify-between">
                <span>Pilih Peran Pengguna</span>
                <span id="role-badge" class="text-[10px] text-indigo-600 font-semibold bg-indigo-50 px-2.5 py-0.5 rounded-full border border-indigo-100 flex items-center gap-1">
                    🎓 Mode Siswa
                </span>
            </label>
            <div class="relative">
                <div id="role-icon-container" class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-base">
                    🎓
                </div>
                <select
                    id="role-select"
                    name="role_type"
                    onchange="handleRoleChange(this.value)"
                    class="w-full pl-10 pr-10 py-3 bg-slate-50/90 border border-slate-200 rounded-2xl text-sm font-bold text-slate-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white focus:border-indigo-500 transition-all duration-200 appearance-none cursor-pointer shadow-sm hover:border-indigo-300"
                >
                    <option value="siswa" selected>🎓 Siswa (Menggunakan NIS)</option>
                    <option value="guru">👨‍🏫 Guru / Staff (Menggunakan NIP)</option>
                    <option value="petugas">👨‍💼 Admin / Petugas Gudang</option>
                </select>
                {{-- Custom Dropdown Chevron Icon --}}
                <div class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                    </svg>
                </div>
            </div>
        </div>

        {{-- KOLOM 1: Username --}}
        <div>
            <label id="label-email" for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                Username Siswa
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                </div>
                <input
                    id="email"
                    name="email"
                    type="text"
                    value="{{ old('email') }}"
                    required
                    autofocus
                    autocomplete="username"
                    placeholder="Masukkan username siswa"
                    class="w-full pl-10 pr-4 py-3 bg-slate-50/80 border border-slate-200 rounded-2xl text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all duration-200 @error('email') border-rose-500 focus:ring-rose-500 @enderror"
                />
            </div>
            @error('email')
                <p class="mt-1 text-xs text-rose-600 font-medium flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        {{-- KOLOM 2: NIS / NIP (Kata Sandi) --}}
        <div>
            <div class="flex items-center justify-between mb-1.5">
                <label id="label-password" for="password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                    NIS (Kata Sandi)
                </label>
                <span id="hint-password" class="text-[10px] text-slate-500 font-medium">Siswa: NIS</span>
            </div>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                </div>
                <input
                    id="password"
                    name="password"
                    type="password"
                    required
                    autocomplete="current-password"
                    placeholder="Masukkan NIS Siswa (contoh: 222310123)"
                    class="w-full pl-10 pr-11 py-3 bg-slate-50/80 border border-slate-200 rounded-2xl text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all duration-200 @error('password') border-rose-500 focus:ring-rose-500 @enderror"
                />
                {{-- Eye Toggle Button --}}
                <button
                    type="button"
                    onclick="togglePasswordVisibility()"
                    class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 focus:outline-none"
                    aria-label="Toggle password view"
                >
                    <svg id="eye-icon" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                </button>
            </div>
            @error('password')
                <p class="mt-1 text-xs text-rose-600 font-medium flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        {{-- KOLOM 3: Nomor WhatsApp (+62 Indonesia) --}}
        <div>
            <label for="whatsapp" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5 flex items-center justify-between">
                <span>Nomor WhatsApp (+62)</span>
                <span class="text-[10px] text-emerald-600 font-semibold bg-emerald-50 px-2 py-0.5 rounded-full border border-emerald-100">🇮🇩 Indonesia</span>
            </label>
            <div class="relative flex rounded-2xl overflow-hidden shadow-sm border border-slate-200 bg-slate-50/80 focus-within:ring-2 focus-within:ring-indigo-500 focus-within:bg-white transition-all">
                <span class="inline-flex items-center px-3.5 bg-slate-100 text-slate-600 font-extrabold text-xs border-r border-slate-200 select-none">
                    🇮🇩 +62
                </span>
                <input
                    id="whatsapp"
                    name="whatsapp"
                    type="tel"
                    value="{{ old('whatsapp') }}"
                    placeholder="812-3456-7890"
                    class="w-full pl-3.5 pr-4 py-3 bg-transparent text-sm text-slate-900 placeholder-slate-400 focus:outline-none"
                />
            </div>
            @error('whatsapp')
                <p class="mt-1 text-xs text-rose-600 font-medium flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        <!-- Remember Me Checkbox -->
        <div class="flex items-center justify-between pt-1">
            <label class="flex items-center gap-2 cursor-pointer select-none">
                <input
                    id="remember"
                    name="remember"
                    type="checkbox"
                    {{ old('remember') ? 'checked' : '' }}
                    class="w-4 h-4 text-indigo-600 bg-slate-50 border-slate-300 rounded-md focus:ring-2 focus:ring-indigo-500 cursor-pointer"
                />
                <span class="text-xs font-semibold text-slate-600">
                    Ingat saya di perangkat ini
                </span>
            </label>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-xs text-indigo-600 hover:text-indigo-800 font-bold transition-colors" wire:navigate>
                    Lupa Kata Sandi?
                </a>
            @endif
        </div>

        <!-- Submit Button -->
        <button
            type="submit"
            class="w-full mt-2 py-3.5 px-6 bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-extrabold text-sm rounded-2xl shadow-lg shadow-indigo-500/25 hover:shadow-xl hover:shadow-indigo-500/35 hover:scale-[1.01] active:scale-[0.99] transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-indigo-500"
        >
            Masuk ke Akun
        </button>
    </form>

    {{-- Passkey Component Integration --}}
    <div class="mt-4">
        <x-passkey-verify />
    </div>

    {{-- Divider --}}
    <div class="relative my-5">
        <div class="absolute inset-0 flex items-center">
            <div class="w-full border-t border-slate-100"></div>
        </div>
        <div class="relative flex justify-center text-xs">
            <span class="px-3 text-slate-400 bg-white font-medium">
                atau
            </span>
        </div>
    </div>

    {{-- Register Link Footer --}}
    <div class="text-center">
        <p class="text-slate-500 text-xs font-medium">
            Belum memiliki akun SIPBAR?
            <a href="{{ route('register') }}" class="font-bold text-indigo-600 hover:text-indigo-800 transition-colors ml-1" wire:navigate>
                Daftar Akun Baru
            </a>
        </p>
    </div>

    <script>
        function handleRoleChange(role) {
            const roleBadge = document.getElementById('role-badge');
            const roleIconContainer = document.getElementById('role-icon-container');
            const labelEmail = document.getElementById('label-email');
            const inputEmail = document.getElementById('email');
            const labelPassword = document.getElementById('label-password');
            const hintPassword = document.getElementById('hint-password');
            const inputPassword = document.getElementById('password');

            if (role === 'siswa') {
                roleBadge.innerHTML = '🎓 Mode Siswa';
                roleIconContainer.innerHTML = '🎓';
                labelEmail.innerText = 'Username Siswa';
                inputEmail.placeholder = 'Masukkan username siswa';
                labelPassword.innerText = 'NIS (Kata Sandi)';
                hintPassword.innerText = 'Siswa: NIS';
                inputPassword.placeholder = 'Masukkan NIS Siswa (contoh: 222310123)';
            } else if (role === 'guru') {
                roleBadge.innerHTML = '👨‍🏫 Mode Guru / Staff';
                roleIconContainer.innerHTML = '👨‍🏫';
                labelEmail.innerText = 'Username / NIP Guru';
                inputEmail.placeholder = 'Masukkan NIP atau username guru';
                labelPassword.innerText = 'NIP (Kata Sandi)';
                hintPassword.innerText = 'Guru: NIP';
                inputPassword.placeholder = 'Masukkan NIP Guru (contoh: 19850101...)';
            } else if (role === 'petugas') {
                roleBadge.innerHTML = '👨‍💼 Mode Admin / Petugas';
                roleIconContainer.innerHTML = '👨‍💼';
                labelEmail.innerText = 'Username Admin / Petugas';
                inputEmail.placeholder = 'Masukkan username admin atau petugas';
                labelPassword.innerText = 'Kata Sandi Petugas';
                hintPassword.innerText = 'Admin / Petugas Gudang';
                inputPassword.placeholder = '••••••••••••';
            }
        }

        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858-5.908a9.979 9.979 0 013.122-.563c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m-4.692-4.692a3 3 0 00-4.243-4.243"/>`;
            } else {
                passwordInput.type = 'password';
                eyeIcon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>`;
            }
        }
    </script>
</x-layouts::auth>
