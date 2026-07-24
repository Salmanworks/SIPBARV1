<x-layouts.admin title="Verifikasi #{{ $peminjaman->id }}">
    <div class="space-y-7">

        {{-- Header --}}
        <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-emerald-500 via-teal-500 to-cyan-600 p-8 md:p-10 text-white shadow-xl shadow-emerald-500/25">
            <div class="absolute -right-16 -top-16 w-64 h-64 bg-white/10 rounded-full blur-2xl pointer-events-none"></div>
            <div class="absolute left-1/3 -bottom-12 w-48 h-48 bg-teal-400/20 rounded-full blur-2xl pointer-events-none"></div>
            <div class="relative z-10 flex flex-col sm:flex-row sm:items-center justify-between gap-5">
                <div class="space-y-2">
                    <span class="inline-block px-3 py-1 rounded-full bg-white/15 border border-white/25 text-[10px] font-bold tracking-widest uppercase">Detail Verifikasi</span>
                    <h1 class="text-2xl md:text-3xl font-extrabold tracking-tight">Peminjaman #{{ $peminjaman->id }}</h1>
                    <p class="text-white/75 text-xs max-w-lg leading-relaxed">Verifikasi penyerahan atau pengembalian barang untuk peminjaman ini.</p>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('guru.verifikasi.index') }}" class="flex-shrink-0 inline-flex items-center justify-center gap-2 px-5 py-3 rounded-2xl bg-white/20 hover:bg-white/30 border border-white/30 text-white font-bold text-xs uppercase tracking-wider transition-all hover:scale-105">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                        Kembali
                    </a>
                </div>
            </div>
        </div>

        <x-alert />

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Info Peminjaman --}}
            <div class="lg:col-span-2 space-y-6">

                {{-- Detail Peminjam --}}
                <div class="bg-white rounded-3xl border border-slate-200/70 shadow-sm p-7">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 rounded-2xl bg-emerald-100 flex items-center justify-center">
                            <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </div>
                        <h2 class="text-sm font-extrabold text-slate-900 uppercase tracking-wider">Informasi Peminjam</h2>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <p class="text-xs text-slate-400 font-bold uppercase tracking-wider mb-1">Nama Peminjam</p>
                            <p class="font-bold text-slate-900">{{ $peminjaman->user->name }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400 font-bold uppercase tracking-wider mb-1">Status</p>
                            <x-status-peminjaman :status="$peminjaman->status" />
                        </div>
                        <div>
                            <p class="text-xs text-slate-400 font-bold uppercase tracking-wider mb-1">Tanggal Pinjam</p>
                            <p class="font-bold text-slate-900">{{ $peminjaman->tanggal_pinjam->format('d M Y') }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400 font-bold uppercase tracking-wider mb-1">Rencana Kembali</p>
                            <p class="font-bold {{ $peminjaman->tanggal_kembali_rencana && $peminjaman->tanggal_kembali_rencana->isPast() ? 'text-rose-600' : 'text-slate-900' }}">
                                {{ $peminjaman->tanggal_kembali_rencana ? $peminjaman->tanggal_kembali_rencana->format('d M Y') : '—' }}
                            </p>
                        </div>
                        <div class="sm:col-span-2">
                            <p class="text-xs text-slate-400 font-bold uppercase tracking-wider mb-1">Keperluan</p>
                            <p class="font-medium text-slate-700">{{ $peminjaman->keperluan ?? '—' }}</p>
                        </div>
                    </div>
                </div>

                {{-- Daftar Barang --}}
                <div class="bg-white rounded-3xl border border-slate-200/70 shadow-sm overflow-hidden">
                    <div class="p-6 border-b border-slate-100 flex items-center gap-3">
                        <div class="w-10 h-10 rounded-2xl bg-blue-100 flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                        </div>
                        <div>
                            <h2 class="text-sm font-extrabold text-slate-900 uppercase tracking-wider">Daftar Barang</h2>
                            <p class="text-xs text-slate-400">{{ $peminjaman->details->count() }} item</p>
                        </div>
                    </div>
                    <div class="divide-y divide-slate-100">
                        @foreach($peminjaman->details as $detail)
                            <div class="px-6 py-4 flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-xl bg-slate-100 flex items-center justify-center">
                                        <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-900 text-sm">{{ $detail->barang->nama_barang }}</p>
                                        @if($detail->kondisi_saat_kembali)
                                            <span class="text-xs {{ $detail->kondisi_saat_kembali->value === 'rusak' ? 'text-rose-600 font-bold' : 'text-emerald-600 font-bold' }}">
                                                Kondisi kembali: {{ ucfirst($detail->kondisi_saat_kembali->value) }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <span class="px-3 py-1 bg-slate-100 text-slate-700 font-bold text-xs rounded-lg">
                                    {{ $detail->jumlah }} unit
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Panel Aksi --}}
            <div class="space-y-6">

                {{-- Verifikasi Keluar --}}
                @if($peminjaman->status === \App\Enums\PeminjamanStatus::Disetujui)
                    <div class="bg-white rounded-3xl border border-emerald-200 shadow-sm p-7">
                        <div class="flex items-center gap-3 mb-5">
                            <div class="w-10 h-10 rounded-2xl bg-emerald-100 flex items-center justify-center">
                                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                            </div>
                            <div>
                                <h3 class="text-sm font-extrabold text-slate-900">Verifikasi Keluar</h3>
                                <p class="text-xs text-slate-500 mt-0.5">Serahkan barang ke peminjam</p>
                            </div>
                        </div>
                        <p class="text-xs text-slate-500 mb-5 leading-relaxed">Pastikan semua barang sudah disiapkan dan siap diserahkan kepada peminjam sebelum menekan tombol konfirmasi.</p>
                        <form method="POST" action="{{ route('guru.verifikasi.keluar', $peminjaman) }}">
                            @csrf
                            <button type="submit" class="w-full px-5 py-3 bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white font-extrabold text-sm rounded-2xl shadow-lg shadow-emerald-500/30 transition-all hover:scale-[1.02] flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Konfirmasi Barang Keluar
                            </button>
                        </form>
                    </div>
                @endif

                {{-- Verifikasi Pengembalian --}}
                @if(in_array($peminjaman->status, [\App\Enums\PeminjamanStatus::Dipinjam, \App\Enums\PeminjamanStatus::Terlambat], true))
                    <div class="bg-white rounded-3xl border border-blue-200 shadow-sm p-7">
                        <div class="flex items-center gap-3 mb-5">
                            <div class="w-10 h-10 rounded-2xl bg-blue-100 flex items-center justify-center">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"/></svg>
                            </div>
                            <div>
                                <h3 class="text-sm font-extrabold text-slate-900">Verifikasi Pengembalian</h3>
                                <p class="text-xs text-slate-500 mt-0.5">Periksa kondisi barang kembali</p>
                            </div>
                        </div>
                        <form method="POST" action="{{ route('guru.verifikasi.kembali', $peminjaman) }}" class="space-y-4">
                            @csrf
                            @foreach($peminjaman->details as $detail)
                                <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100">
                                    <label class="block text-xs font-bold text-slate-600 mb-2">{{ $detail->barang->nama_barang }}</label>
                                    <select name="kondisi[{{ $detail->id }}]" required class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm font-medium text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition-all">
                                        <option value="baik">✅ Kondisi Baik</option>
                                        <option value="rusak">⚠️ Rusak / Perlu Perbaikan</option>
                                    </select>
                                </div>
                            @endforeach
                            <button type="submit" class="w-full px-5 py-3 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-extrabold text-sm rounded-2xl shadow-lg shadow-blue-500/30 transition-all hover:scale-[1.02] flex items-center justify-center gap-2 mt-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Konfirmasi Pengembalian
                            </button>
                        </form>
                    </div>
                @endif

                {{-- Denda (jika ada) --}}
                @if($peminjaman->denda)
                    <div class="bg-white rounded-3xl border border-rose-200 shadow-sm p-7">
                        <div class="flex items-center gap-3 mb-5">
                            <div class="w-10 h-10 rounded-2xl bg-rose-100 flex items-center justify-center">
                                <svg class="w-5 h-5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <div>
                                <h3 class="text-sm font-extrabold text-slate-900">Informasi Denda</h3>
                                <p class="text-xs text-slate-500 mt-0.5">Keterlambatan pengembalian</p>
                            </div>
                        </div>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center">
                                <span class="text-xs text-slate-500 font-medium">Hari Terlambat</span>
                                <span class="font-bold text-rose-600">{{ $peminjaman->denda->jumlah_hari_telat }} hari</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-xs text-slate-500 font-medium">Total Denda</span>
                                <span class="font-extrabold text-rose-700 text-lg">Rp {{ number_format($peminjaman->denda->nominal_denda, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-xs text-slate-500 font-medium">Status Bayar</span>
                                <span class="px-2.5 py-1 rounded-lg text-xs font-bold {{ $peminjaman->denda->status_bayar->value === 'lunas' ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700' }}">
                                    {{ ucfirst($peminjaman->denda->status_bayar->value) }}
                                </span>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Status sudah selesai --}}
                @if($peminjaman->status === \App\Enums\PeminjamanStatus::Dikembalikan || $peminjaman->status === \App\Enums\PeminjamanStatus::Selesai)
                    <div class="bg-emerald-50 rounded-3xl border border-emerald-200 p-7 text-center">
                        <div class="w-14 h-14 rounded-3xl bg-emerald-100 flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <p class="font-extrabold text-emerald-800 text-sm">Peminjaman Selesai</p>
                        <p class="text-xs text-emerald-600 mt-1">Barang telah dikembalikan dan diverifikasi.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-layouts.admin>
