<x-layouts.admin title="Dashboard Guru Gudang">
    <div class="space-y-7">

        {{-- Welcome Banner --}}
        <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-emerald-500 via-teal-500 to-cyan-600 p-8 md:p-10 text-white shadow-xl shadow-emerald-500/25">
            <div class="absolute -right-16 -top-16 w-64 h-64 bg-white/10 rounded-full blur-2xl pointer-events-none"></div>
            <div class="absolute left-1/3 -bottom-12 w-48 h-48 bg-teal-400/20 rounded-full blur-2xl pointer-events-none"></div>
            <div class="absolute -left-8 bottom-0 w-40 h-40 bg-emerald-400/20 rounded-full blur-2xl pointer-events-none"></div>
            <div class="relative z-10 flex flex-col sm:flex-row sm:items-center justify-between gap-5">
                <div class="space-y-2">
                    <span class="inline-block px-3 py-1 rounded-full bg-white/15 border border-white/25 text-[10px] font-bold tracking-widest uppercase">Portal Petugas Gudang</span>
                    <h1 class="text-2xl md:text-3xl font-extrabold tracking-tight inline-flex items-center gap-2">
                        Halo, {{ auth()->user()->name }}!
                        <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    </h1>
                    <p class="text-white/75 text-xs max-w-lg leading-relaxed">Lakukan verifikasi penyerahan barang keluar dan verifikasi kondisi pengembalian barang masuk.</p>
                </div>
                <a href="{{ route('guru.verifikasi.index') }}" class="flex-shrink-0 inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-2xl bg-white text-emerald-700 font-extrabold text-xs uppercase tracking-wider shadow-lg hover:bg-emerald-50 hover:scale-105 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Verifikasi Sekarang
                </a>
            </div>
        </div>

        <x-alert />

        {{-- Stat Cards --}}
        <div class="grid gap-5 sm:grid-cols-2 xl:grid-cols-4">
            <div class="relative bg-white p-6 rounded-3xl border border-emerald-100 shadow-sm hover:shadow-lg hover:shadow-emerald-500/10 hover:-translate-y-0.5 transition-all overflow-hidden group">
                <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-emerald-100 to-emerald-50 rounded-full blur-xl -translate-y-8 translate-x-8 group-hover:scale-125 transition-transform"></div>
                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-10 h-10 rounded-2xl bg-emerald-100 flex items-center justify-center">
                            <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                    </div>
                    <h3 class="text-4xl font-black text-emerald-700">{{ number_format($stats['menunggu_verifikasi'] ?? 0) }}</h3>
                    <p class="text-xs font-bold text-emerald-600 uppercase tracking-wider mt-1">Menunggu Verifikasi</p>
                    <p class="text-[11px] text-emerald-600/60 mt-1">Siap Penyerahan Gudang</p>
                </div>
            </div>
            <div class="relative bg-white p-6 rounded-3xl border border-blue-100 shadow-sm hover:shadow-lg hover:shadow-blue-500/10 hover:-translate-y-0.5 transition-all overflow-hidden group">
                <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-blue-100 to-blue-50 rounded-full blur-xl -translate-y-8 translate-x-8 group-hover:scale-125 transition-transform"></div>
                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-10 h-10 rounded-2xl bg-blue-100 flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                        </div>
                    </div>
                    <h3 class="text-4xl font-black text-blue-700">{{ number_format($stats['sedang_dipinjam'] ?? 0) }}</h3>
                    <p class="text-xs font-bold text-blue-600 uppercase tracking-wider mt-1">Sedang Dipinjam</p>
                    <p class="text-[11px] text-blue-600/60 mt-1">Barang Berada di Luar</p>
                </div>
            </div>
            <div class="relative bg-white p-6 rounded-3xl border border-rose-100 shadow-sm hover:shadow-lg hover:shadow-rose-500/10 hover:-translate-y-0.5 transition-all overflow-hidden group">
                <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-rose-100 to-rose-50 rounded-full blur-xl -translate-y-8 translate-x-8 group-hover:scale-125 transition-transform"></div>
                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-10 h-10 rounded-2xl bg-rose-100 flex items-center justify-center">
                            <svg class="w-5 h-5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                    </div>
                    <h3 class="text-4xl font-black text-rose-700">{{ number_format($stats['terlambat'] ?? 0) }}</h3>
                    <p class="text-xs font-bold text-rose-600 uppercase tracking-wider mt-1">Terlambat</p>
                    <p class="text-[11px] text-rose-600/60 mt-1">Perlu Penagihan</p>
                </div>
            </div>
            <div class="relative bg-white p-6 rounded-3xl border border-amber-100 shadow-sm hover:shadow-lg hover:shadow-amber-500/10 hover:-translate-y-0.5 transition-all overflow-hidden group">
                <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-amber-100 to-amber-50 rounded-full blur-xl -translate-y-8 translate-x-8 group-hover:scale-125 transition-transform"></div>
                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-10 h-10 rounded-2xl bg-amber-100 flex items-center justify-center">
                            <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                    </div>
                    <h3 class="text-4xl font-black text-amber-700">{{ number_format($stats['pengembalian_hari_ini'] ?? 0) }}</h3>
                    <p class="text-xs font-bold text-amber-600 uppercase tracking-wider mt-1">Jatuh Tempo Hari Ini</p>
                    <p class="text-[11px] text-amber-600/60 mt-1">Jadwal Pengembalian Hari Ini</p>
                </div>
            </div>
        </div>

        {{-- Pending Verification Table --}}
        <div class="bg-white rounded-3xl border border-slate-200/70 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                <div>
                    <h2 class="text-base font-extrabold text-slate-900">Perlu Verifikasi Gudang</h2>
                    <p class="text-xs text-slate-400 mt-0.5">Daftar transaksi barang yang memerlukan verifikasi keluar atau pengembalian</p>
                </div>
                <a href="{{ route('guru.verifikasi.index') }}" class="text-xs font-bold text-emerald-600 hover:text-emerald-800 bg-emerald-50 hover:bg-emerald-100 px-3 py-1.5 rounded-xl transition-all">Semua Verifikasi</a>
            </div>

            @if($pendingReturns->isEmpty())
                <div class="p-14 text-center">
                    <div class="w-16 h-16 rounded-3xl bg-emerald-50 text-emerald-400 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <p class="font-bold text-slate-800 text-sm">Semua Barang Tersimpan Aman</p>
                    <p class="text-xs text-slate-500 mt-1">Tidak ada peminjaman aktif yang perlu verifikasi saat ini.</p>
                </div>
            @else
                <div class="divide-y divide-slate-100">
                    @foreach($pendingReturns as $item)
                        <div class="p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4 hover:bg-emerald-50/30 transition-colors">
                            <div class="flex items-center gap-3">
                                <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-600 text-white font-extrabold flex items-center justify-center text-sm shadow-md shadow-emerald-500/25">
                                    {{ strtoupper(substr($item->user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <h3 class="font-bold text-slate-900 text-sm">{{ $item->user->name }}</h3>
                                    <p class="text-xs text-slate-500">Kembali: {{ $item->tanggal_kembali_rencana ? $item->tanggal_kembali_rencana->format('d M Y') : '—' }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <x-status-peminjaman :status="$item->status" />
                                <a href="{{ route('guru.verifikasi.show', $item) }}" class="px-4 py-2 bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white font-bold text-xs rounded-xl shadow-md shadow-emerald-500/30 transition-all hover:scale-[1.02]">
                                    Verifikasi
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-layouts.admin>
