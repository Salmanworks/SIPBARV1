@extends('layouts.auth.simple')

@section('content')
<div class="w-full max-w-4xl bg-white rounded-[32px] shadow-[0_25px_60px_-15px_rgba(99,102,241,0.18)] p-4 sm:p-5 md:p-6 flex flex-col md:flex-row gap-6 md:gap-8 border border-slate-100/90 my-auto relative z-10">

    {{-- LEFT PANEL: Vivid Animated Mesh Hero Graphic --}}
    <div class="w-full md:w-1/2 rounded-[24px] hero-mesh p-8 md:p-10 flex flex-col justify-between text-white relative min-h-[340px] md:min-h-[500px] overflow-hidden shadow-lg">
        {{-- Top Star Logo Icon --}}
        <div>
            <div class="w-11 h-11 rounded-2xl bg-white/20 backdrop-blur-md border border-white/30 flex items-center justify-center shadow-md">
                <svg class="w-6 h-6 text-white" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 2L13.5 9.5L21 11L13.5 12.5L12 20L10.5 12.5L3 11L10.5 9.5L12 2Z"/>
                </svg>
            </div>
        </div>

        {{-- Bottom Hero Text --}}
        <div class="space-y-2 z-10">
            <p class="text-xs font-extrabold text-white/80 tracking-widest uppercase">SISTEM PEMINJAMAN BARANG</p>
            <h2 class="text-2xl lg:text-3xl font-black text-white tracking-tight leading-snug">
                Akses mudah &amp; cepat untuk peminjaman barang sekolah.
            </h2>
        </div>

        {{-- Decorative Soft Lighting Orbs --}}
        <div class="absolute -top-20 -left-20 w-60 h-60 bg-white/15 rounded-full blur-2xl pointer-events-none"></div>
        <div class="absolute -bottom-20 -right-20 w-60 h-60 bg-purple-500/25 rounded-full blur-2xl pointer-events-none"></div>
    </div>

    {{-- RIGHT PANEL: Clean High-Contrast Form --}}
    <div class="w-full md:w-1/2 p-3 sm:p-5 md:p-6 flex flex-col justify-center">

        {{-- Star Logo Icon --}}
        <div class="mb-3">
            <svg class="w-7 h-7 text-indigo-600" viewBox="0 0 24 24" fill="currentColor">
                <path d="M12 2L13.5 9.5L21 11L13.5 12.5L12 20L10.5 12.5L3 11L10.5 9.5L12 2Z"/>
            </svg>
        </div>

        {{-- Title & Subtitle --}}
        <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
            Masuk ke Akun
        </h1>
        <p class="text-xs text-slate-500 font-medium mt-1 mb-6 leading-relaxed">
            Pilih peran Anda dan masukkan data login untuk mengakses sistem SIPBAR.
        </p>

        {{-- Session / Error Alert --}}
        @if ($errors->any())
            <div class="mb-5 p-3.5 rounded-2xl bg-rose-50 border border-rose-200 text-rose-700 text-xs space-y-1">
                <div class="flex items-center gap-1.5 font-bold">
                    <svg class="w-4 h-4 text-rose-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>Gagal Masuk</span>
                </div>
                <ul class="list-disc list-inside pl-1 text-[11px] text-rose-600">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Form --}}
        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf

            {{-- Role Select --}}
            <div>
                <label for="role" class="block text-xs font-extrabold text-slate-800 uppercase tracking-wider mb-1.5">
                    Peran Pengguna
                </label>
                <div class="relative">
                    <select id="role" name="role" required
                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200/90 rounded-xl text-xs font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all appearance-none cursor-pointer shadow-2xs">
                        <option value="admin" @selected(old('role') === 'admin')>👨‍💼 Administrator (Admin)</option>
                        <option value="guru" @selected(old('role') === 'guru')>👷 Guru Gudang / Petugas</option>
                        <option value="siswa" @selected(old('role', 'siswa') === 'siswa')>👤 Siswa (Peminjam)</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/></svg>
                    </div>
                </div>
            </div>

            {{-- Identifier Input --}}
            <div>
                <label for="identifier" id="identifier-label" class="block text-xs font-extrabold text-slate-800 uppercase tracking-wider mb-1.5">
                    Email / NIP / NIS
                </label>
                <input type="text" id="identifier" name="identifier" value="{{ old('identifier') }}" required autofocus
                       placeholder="Masukkan email, NIP, atau NIS"
                       class="w-full px-4 py-3 bg-slate-50 border border-slate-200/90 rounded-xl text-xs font-semibold text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all shadow-2xs" />
            </div>

            {{-- Password Input --}}
            <div>
                <label for="password" class="block text-xs font-extrabold text-slate-800 uppercase tracking-wider mb-1.5">
                    Password
                </label>
                <div class="relative">
                    <input type="password" id="password" name="password" required placeholder="••••••••••••"
                           class="w-full pl-4 pr-10 py-3 bg-slate-50 border border-slate-200/90 rounded-xl text-xs font-semibold text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all shadow-2xs" />
                    <button type="button" onclick="togglePasswordVisibility()" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 transition-colors">
                        <svg id="eye-icon" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </button>
                </div>
            </div>

            {{-- Submit Button --}}
            <button type="submit" class="w-full py-3.5 px-6 rounded-xl bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-extrabold text-xs uppercase tracking-wider shadow-lg shadow-indigo-500/25 hover:shadow-indigo-500/35 hover:scale-[1.01] active:scale-[0.99] transition-all flex items-center justify-center gap-2 mt-3">
                <span>Masuk Sekarang</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
            </button>
        </form>

        {{-- Divider --}}
        <div class="relative my-5 text-center">
            <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-slate-200/80"></div></div>
            <span class="relative bg-white px-3 text-[10px] font-extrabold text-slate-400 uppercase tracking-widest">SMKN 1 BANGSRI</span>
        </div>

        {{-- Footer Link --}}
        <div class="text-center">
            <a href="{{ route('home') }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-800 transition-colors inline-flex items-center gap-1">
                <span>Kembali ke Halaman Utama</span>
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const roleSelect = document.getElementById('role');
        const identifierInput = document.getElementById('identifier');
        const identifierLabel = document.getElementById('identifier-label');
        const placeholders = {
            admin: { label: 'Email Admin', placeholder: 'admin@sipbar.sch.id' },
            guru: { label: 'NIP / No. Induk Guru', placeholder: 'Contoh: GRU001' },
            siswa: { label: 'NIS / No. Induk Siswa', placeholder: 'Contoh: SIS001' }
        };

        function updateIdentifier() {
            const role = roleSelect.value;
            if (placeholders[role]) {
                identifierLabel.textContent = placeholders[role].label;
                identifierInput.placeholder = placeholders[role].placeholder;
            }
        }

        roleSelect.addEventListener('change', updateIdentifier);
        updateIdentifier();
    });

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
@endsection
