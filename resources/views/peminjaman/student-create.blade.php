@extends('layouts.guest')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 pt-24 pb-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="space-y-7">

            {{-- Header Banner --}}
            <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-blue-500 via-indigo-500 to-violet-600 p-8 md:p-10 text-white shadow-xl shadow-blue-500/25">
                <div class="absolute -right-16 -top-16 w-64 h-64 bg-white/10 rounded-full blur-2xl pointer-events-none"></div>
                <div class="absolute left-1/3 -bottom-12 w-48 h-48 bg-indigo-400/20 rounded-full blur-2xl pointer-events-none"></div>
                <div class="absolute -left-8 bottom-0 w-40 h-40 bg-blue-400/20 rounded-full blur-2xl pointer-events-none"></div>
                <div class="relative z-10 flex flex-col sm:flex-row sm:items-center justify-between gap-5">
                    <div class="space-y-2">
                        <span class="inline-block px-3 py-1 rounded-full bg-white/15 border border-white/25 text-[10px] font-bold tracking-widest uppercase">Buat Pengajuan</span>
                        <h1 class="text-2xl md:text-3xl font-extrabold tracking-tight">Ajukan Peminjaman Baru</h1>
                        <p class="text-white/75 text-xs max-w-lg leading-relaxed">Pilih barang yang dibutuhkan, isi keperluan, lalu kirim pengajuan untuk direview Guru/Admin.</p>
                    </div>
                </div>
            </div>

            <x-alert />

            {{-- Filter Section --}}
            <div class="bg-white rounded-3xl border border-slate-200/70 shadow-soft overflow-hidden">
                <div class="p-6">
                    <h2 class="text-base font-extrabold text-slate-900 mb-5 flex items-center gap-2.5">
                        <span class="w-10 h-10 rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-600 text-white flex items-center justify-center shadow-glow-sm">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                            </svg>
                        </span>
                        <div>
                            <p class="leading-tight">Cari & Filter Barang</p>
                            <p class="text-[11px] font-semibold text-slate-500 mt-0.5 leading-tight">Temukan barang dengan cepat menggunakan pencarian atau filter kategori</p>
                        </div>
                    </h2>
                    <form method="GET" action="{{ route('peminjaman.create') }}" class="grid gap-3 lg:grid-cols-12">
                        {{-- Search Input --}}
                        <div class="lg:col-span-7 relative group">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400 group-focus-within:text-blue-600 transition-colors pointer-events-none z-10">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            </span>
                            <input type="text" name="search" placeholder="Cari nama / kode / lokasi barang..." value="{{ request('search') }}" class="w-full pl-12 pr-4 py-3.5 rounded-2xl border-2 border-slate-200 text-sm font-semibold focus:border-blue-500 focus:ring-4 focus:ring-blue-100/60 outline-none transition-all bg-white shadow-sm placeholder:font-medium" />
                        </div>

                        {{-- Kategori Dropdown (UPGRADED PREMIUM) --}}
                        <div class="lg:col-span-3 relative group">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400 group-focus-within:text-blue-600 transition-colors pointer-events-none z-10">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                            </span>
                            <select name="kategori_id" class="w-full pl-12 pr-10 py-3.5 rounded-2xl border-2 border-slate-200 text-sm font-bold focus:border-blue-500 focus:ring-4 focus:ring-blue-100/60 outline-none transition-all bg-white shadow-sm cursor-pointer appearance-none">
                                <option value="" class="font-semibold text-slate-500">Semua Kategori</option>
                                @foreach($kategoris as $kategori)
                                    <option value="{{ $kategori->id }}" {{ request('kategori_id') == $kategori->id ? 'selected' : '' }} class="font-semibold">
                                        {{ $kategori->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Tombol Filter --}}
                        <div class="lg:col-span-2 flex gap-2">
                            <button type="submit" class="flex-1 px-5 py-3.5 rounded-2xl bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-extrabold text-sm hover:from-blue-700 hover:to-indigo-700 hover:scale-[1.03] hover:shadow-glow transition-all duration-200 shadow-lg shadow-blue-500/25 btn-glow">
                                <svg class="w-4 h-4 inline mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                                Filter
                            </button>
                            @if(request()->filled('search') || request()->filled('kategori_id'))
                                <a href="{{ route('peminjaman.create') }}" class="flex items-center justify-center px-4 py-3.5 rounded-2xl bg-slate-100 text-slate-600 font-bold text-sm hover:bg-slate-200 hover:scale-[1.03] transition-all shadow-sm" title="Reset Filter">
                                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>


            {{-- Main Form --}}
            <form method="POST" action="{{ route('peminjaman.store') }}" class="space-y-6">
                @csrf

                {{-- Detail Peminjaman Card --}}
                <div class="bg-white rounded-3xl border border-slate-200/70 shadow-soft overflow-hidden">
                    <div class="p-6 border-b border-slate-100">
                        <h2 class="text-base font-extrabold text-slate-900 flex items-center gap-2.5">
                            <span class="w-10 h-10 rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-600 text-white flex items-center justify-center shadow-glow-sm">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </span>
                            Detail Peminjaman
                        </h2>
                    </div>
                    <div class="p-6 bg-gradient-to-b from-slate-50/70 to-white">
                        <div class="grid gap-5 md:grid-cols-2">
                            <div>
                                <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-2.5">Tanggal Pinjam <span class="text-rose-500">*</span></label>
                                <div class="relative group">
                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400 group-focus-within:text-blue-600 transition-colors pointer-events-none z-10">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    </span>
                                    <input type="date" name="tanggal_pinjam" value="{{ old('tanggal_pinjam', today()->format('Y-m-d')) }}" min="{{ today()->format('Y-m-d') }}" required class="w-full pl-12 pr-4 py-3.5 rounded-2xl border-2 border-slate-200 text-sm font-semibold focus:border-blue-500 focus:ring-4 focus:ring-blue-100/60 outline-none transition-all bg-white shadow-sm" />
                                </div>
                                @error('tanggal_pinjam')
                                    <p class="text-xs text-rose-600 mt-2 font-bold bg-rose-50 px-3 py-1.5 rounded-xl border border-rose-200 flex items-center gap-1.5">
                                        <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-2.5">Tanggal Kembali Rencana <span class="text-rose-500">*</span></label>
                                <div class="relative group">
                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400 group-focus-within:text-blue-600 transition-colors pointer-events-none z-10">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    </span>
                                    <input type="date" name="tanggal_kembali_rencana" value="{{ old('tanggal_kembali_rencana') }}" required class="w-full pl-12 pr-4 py-3.5 rounded-2xl border-2 border-slate-200 text-sm font-semibold focus:border-blue-500 focus:ring-4 focus:ring-blue-100/60 outline-none transition-all bg-white shadow-sm" />
                                </div>
                                @error('tanggal_kembali_rencana')
                                    <p class="text-xs text-rose-600 mt-2 font-bold bg-rose-50 px-3 py-1.5 rounded-xl border border-rose-200 flex items-center gap-1.5">
                                        <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-2.5">Keperluan Peminjaman <span class="text-rose-500">*</span></label>
                                <div class="relative group">
                                    <span class="absolute left-4 top-4 w-5 h-5 text-slate-400 group-focus-within:text-blue-600 transition-colors pointer-events-none z-10">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </span>
                                    <textarea name="keperluan" rows="4" required placeholder="Jelaskan keperluan peminjaman barang secara jelas (contoh: Tugas presentasi kelompok IPA kelas 10A untuk lomba sains)" minlength="10" maxlength="500" id="keperluan-ta" class="w-full pl-12 pr-4 py-3.5 rounded-2xl border-2 border-slate-200 text-sm font-semibold resize-none focus:border-blue-500 focus:ring-4 focus:ring-blue-100/60 outline-none transition-all bg-white shadow-sm leading-relaxed">{{ old('keperluan') }}</textarea>
                                </div>
                                <div class="flex justify-between mt-2">
                                    <p class="text-[11px] font-semibold text-slate-500 flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        Minimal 10 karakter | Maksimal 500 karakter
                                    </p>
                                    <p class="text-[11px] font-extrabold text-slate-500" id="keperluan-counter">{{ old('keperluan') ? strlen(old('keperluan')) : 0 }} / 500</p>
                                </div>
                                @error('keperluan')
                                    <p class="text-xs text-rose-600 mt-2 font-bold bg-rose-50 px-3 py-1.5 rounded-xl border border-rose-200 flex items-center gap-1.5">
                                        <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>


                {{-- Pilih Barang Card --}}
                <div class="bg-white rounded-3xl border border-slate-200/70 shadow-soft overflow-hidden">
                    <div class="p-6 border-b border-slate-100">
                        <h2 class="text-base font-extrabold text-slate-900 flex items-center gap-2.5">
                            <span class="w-10 h-10 rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-600 text-white flex items-center justify-center shadow-glow-sm">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                </svg>
                            </span>
                            <div>
                                <p class="leading-tight">Pilih Barang yang Akan Dipinjam <span class="text-rose-500 text-xs font-black">*</span></p>
                                <p class="text-[11px] font-semibold text-slate-500 mt-0.5 leading-tight">Centang barang (minimal 1). Maksimal pinjam 10 unit per jenis barang</p>
                            </div>
                        </h2>
                        @error('barang')
                            <p class="text-xs text-rose-600 mt-3 font-bold bg-rose-50 px-4 py-2.5 rounded-2xl border border-rose-200 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    @if($barangs->isEmpty())
                        <div class="p-14 text-center bg-gradient-to-b from-slate-50 to-white">
                            <div class="w-16 h-16 rounded-3xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                </svg>
                            </div>
                            <p class="font-bold text-slate-800 text-sm">Tidak Ada Barang Tersedia</p>
                            <p class="text-xs text-slate-500 mt-1">Coba ubah filter pencarian atau hubungi Admin.</p>
                        </div>
                    @else
                        <div class="p-6 bg-gradient-to-b from-slate-50 to-white">
                            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3" id="barang-list">
                                @php $index = 0; @endphp
                                @foreach($barangs as $barang)
                                    <div class="barang-card relative p-5 rounded-2xl border-2 border-slate-200 bg-white transition-all duration-200 hover:border-blue-300 hover:-translate-y-0.5 hover:shadow-md group">
                                        <label class="flex items-start gap-3 cursor-pointer">
                                            <input
                                                type="checkbox"
                                                name="barang[{{ $index }}][id]"
                                                value="{{ $barang->id }}"
                                                data-card-id="{{ $barang->id }}"
                                                data-index="{{ $index }}"
                                                {{ old('barang.'.$index.'.id') == $barang->id ? 'checked' : '' }}
                                                class="barang-checkbox mt-1 w-6 h-6 rounded-lg border-2 border-slate-300 text-blue-600 focus:ring-4 focus:ring-blue-200 cursor-pointer flex-shrink-0"
                                            />
                                            <div class="flex-1">
                                                <h3 class="font-black text-slate-900 text-sm pr-6 mb-1 leading-tight group-hover:text-blue-700 transition-colors">{{ $barang->nama_barang }}</h3>
                                                <p class="text-xs text-slate-700 font-bold mb-1.5">{{ $barang->kode_barang }} • {{ $barang->kategori ? $barang->kategori->nama_kategori : 'Tidak Berkategori' }}</p>
                                                <div class="flex flex-wrap items-center gap-2 mb-3">
                                                    <span class="px-2.5 py-1 rounded-xl bg-gradient-to-r from-emerald-50 to-teal-50 border border-emerald-200 text-emerald-700 text-[10px] font-black shadow-sm">
                                                        <svg class="w-3 h-3 inline mr-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                                                        Stok: {{ $barang->stok }}
                                                    </span>
                                                    <span class="px-2.5 py-1 rounded-xl bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 text-blue-700 text-[10px] font-black shadow-sm">
                                                        <svg class="w-3 h-3 inline mr-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                                        {{ Str::limit($barang->lokasi, 20) }}
                                                    </span>
                                                </div>
                                                <div class="jumlah-wrapper">
                                                    <label class="block text-[10px] font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Jumlah Unit</label>
                                                    <input
                                                        type="number"
                                                        name="barang[{{ $index }}][jumlah]"
                                                        min="1"
                                                        max="{{ min($barang->stok, 10) }}"
                                                        value="{{ old('barang.'.$index.'.jumlah', 1) }}"
                                                        class="jumlah-input w-full px-3 py-2.5 rounded-xl border-2 border-slate-200 text-sm font-black text-center focus:border-emerald-500 focus:ring-4 focus:ring-emerald-100/60 outline-none transition-all bg-white shadow-sm"
                                                        disabled
                                                    />
                                                    <p class="text-[10px] text-slate-500 mt-1.5 font-semibold flex items-center gap-1">
                                                        <svg class="w-3 h-3 text-amber-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                                        Min. 1 unit | Maks. {{ min($barang->stok, 10) }} unit
                                                    </p>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                    @php $index++; @endphp
                                @endforeach
                            </div>

                            <div class="mt-6">
                                {{ $barangs->links() }}
                            </div>
                        </div>
                    @endif
                </div>


                {{-- Action Buttons --}}
                <div class="flex flex-col sm:flex-row gap-3 justify-end">
                    <a href="{{ route('peminjaman.index') }}" class="inline-flex items-center justify-center gap-2.5 px-8 py-4 rounded-2xl bg-white text-slate-700 font-bold text-sm border border-slate-200 shadow-sm hover:bg-slate-50 hover:scale-105 transition-all duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Kembali ke Daftar
                    </a>
                    <button type="submit" class="inline-flex items-center justify-center gap-2.5 px-8 py-4 rounded-2xl bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-extrabold text-sm shadow-xl shadow-blue-500/30 hover:shadow-2xl hover:shadow-blue-500/45 hover:scale-105 transition-all duration-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                        </svg>
                        Kirim Pengajuan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Enable/disable jumlah input based on checkbox checked state
    document.addEventListener('DOMContentLoaded', function () {
        const checkboxes = document.querySelectorAll('.barang-checkbox');

        checkboxes.forEach(checkbox => {
            toggleJumlah(checkbox); // init on load
            checkbox.addEventListener('change', function () {
                toggleJumlah(this);
            });
        });

        function toggleJumlah(checkbox) {
            const card = checkbox.closest('.barang-card');
            const jumlahInput = card.querySelector('.jumlah-input');
            const wrapper = card.querySelector('.jumlah-wrapper');

            if (checkbox.checked) {
                // aktifkan
                jumlahInput.disabled = false;
                wrapper.classList.remove('opacity-50');
                card.classList.add('border-blue-400', 'bg-blue-50/40');
            } else {
                // nonaktifkan + reset ke 1
                jumlahInput.disabled = true;
                jumlahInput.value = 1;
                wrapper.classList.add('opacity-50');
                card.classList.remove('border-blue-400', 'bg-blue-50/40');
            }
        }
    });

    // Counter keperluan live
    document.addEventListener('DOMContentLoaded', function () {
        const textarea = document.getElementById('keperluan-ta');
        if (!textarea) return;
        const counter = document.getElementById('keperluan-counter');
        if (!counter) return;
        textarea.addEventListener('input', function () {
            const len = this.value.length;
            counter.textContent = len + ' / 500';
            if (len > 500) {
                counter.classList.add('text-rose-600');
                counter.classList.add('font-black');
            } else {
                counter.classList.remove('text-rose-600');
            }
            if (len >= 10 && len <= 500) {
                counter.classList.add('text-emerald-600');
            } else {
                counter.classList.remove('text-emerald-600');
            }
        });
        // Trigger sekali saat load
        textarea.dispatchEvent(new Event('input'));
    });
</script>
@endsection
