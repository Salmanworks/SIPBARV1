<x-layouts.admin title="Dashboard Admin">
    <div class="space-y-5">

        {{-- Hero Welcome Banner --}}
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-blue-600 via-blue-700 to-indigo-700 p-5 md:p-6 text-white shadow-lg shadow-blue-700/20">
            {{-- Subtle background blobs --}}
            <div class="absolute -top-10 -right-10 w-48 h-48 bg-white/5 rounded-full blur-2xl pointer-events-none"></div>
            <div class="absolute bottom-0 left-1/3 w-40 h-40 bg-indigo-400/10 rounded-full blur-2xl pointer-events-none"></div>

            <div class="relative z-10 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                {{-- Left: text --}}
                <div class="flex items-center gap-4">
                    <div class="w-11 h-11 rounded-2xl bg-white/15 border border-white/20 flex items-center justify-center text-white font-black text-lg flex-shrink-0">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div>
                        <div class="flex items-center gap-2 mb-1">
                            <span class="relative flex h-2 w-2">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-400"></span>
                            </span>
                            <span class="text-[10px] font-bold text-white/60 uppercase tracking-widest">Sistem Aktif</span>
                        </div>
                        <h1 class="text-lg md:text-xl font-extrabold text-white leading-tight">
                            <span class="inline-flex items-center gap-1">
                                Selamat Datang, {{ Str::limit(auth()->user()->name, 24) }}!
                                <svg class="w-5 h-5 text-amber-300" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.25a.75.75 0 01.75.75v2.25a.75.75 0 01-1.5 0V3a.75.75 0 01.75-.75zM7.5 12a4.5 4.5 0 119 0 4.5 4.5 0 01-9 0zM18.894 6.166a.75.75 0 00-1.06-1.06l-1.591 1.59a.75.75 0 101.06 1.061l1.591-1.59zM21.75 12a.75.75 0 01-.75.75h-2.25a.75.75 0 010-1.5H21a.75.75 0 01.75.75zM17.834 18.894a.75.75 0 001.06-1.06l-1.59-1.591a.75.75 0 10-1.061 1.06l1.59 1.591zM12 18a.75.75 0 01.75.75V21a.75.75 0 01-1.5 0v-2.25A.75.75 0 0112 18zM7.758 17.303a.75.75 0 00-1.061-1.06l-1.591 1.59a.75.75 0 001.06 1.061l1.591-1.59zM6 12a.75.75 0 01-.75.75H3a.75.75 0 010-1.5h2.25A.75.75 0 016 12zM6.697 7.757a.75.75 0 001.06-1.06l-1.59-1.591a.75.75 0 00-1.061 1.06l1.59 1.591z"/></svg>
                            </span>
                        </h1>
                        <p class="text-white/60 text-xs mt-0.5 hidden sm:block">
                            Panel kontrol peminjaman inventaris SIPBAR.
                        </p>
                    </div>
                </div>

                {{-- Right: action buttons --}}
                <div class="flex items-center gap-2 flex-shrink-0">
                    <a href="{{ route('admin.barang.create') }}"
                       class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-white text-blue-700 font-bold text-xs shadow-md hover:bg-blue-50 hover:shadow-lg transition-all">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                        Tambah Barang
                    </a>
                    <a href="{{ route('admin.laporan.index') }}"
                       class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-white/10 border border-white/20 text-white font-bold text-xs hover:bg-white/20 transition-all">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        Cetak Laporan
                    </a>
                </div>
            </div>
        </div>

        {{-- Alert Notifications --}}
        @if(($stats['menunggu_approval'] ?? 0) > 0 || ($stats['terlambat'] ?? 0) > 0)
            <div class="grid gap-3 md:grid-cols-2">
                @if(($stats['menunggu_approval'] ?? 0) > 0)
                <div class="flex items-center gap-3 p-3.5 rounded-xl bg-amber-50 border border-amber-200">
                    <div class="w-8 h-8 rounded-xl bg-amber-500 text-white flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-bold text-amber-900"><span class="font-black">{{ $stats['menunggu_approval'] }}</span> pengajuan menunggu persetujuan.</p>
                    </div>
                    <a href="{{ route('admin.peminjaman.index') }}"
                       class="flex-shrink-0 text-[11px] font-bold text-amber-700 hover:text-amber-900 bg-amber-100 hover:bg-amber-200 px-3 py-1.5 rounded-lg transition-colors whitespace-nowrap">
                        Proses →
                    </a>
                </div>
                @endif

                @if(($stats['terlambat'] ?? 0) > 0)
                <div class="flex items-center gap-3 p-3.5 rounded-xl bg-rose-50 border border-rose-200">
                    <div class="w-8 h-8 rounded-xl bg-rose-500 text-white flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-bold text-rose-900"><span class="font-black">{{ $stats['terlambat'] }}</span> peminjaman melewati tenggat pengembalian.</p>
                    </div>
                    <a href="{{ route('admin.peminjaman.index') }}"
                       class="flex-shrink-0 text-[11px] font-bold text-rose-700 hover:text-rose-900 bg-rose-100 hover:bg-rose-200 px-3 py-1.5 rounded-lg transition-colors whitespace-nowrap">
                        Tindak Lanjut →
                    </a>
                </div>
                @endif
            </div>
        @endif

        {{-- Primary KPI Cards --}}
        <div class="grid gap-3 sm:grid-cols-2 xl:grid-cols-4">
            {{-- Total Barang --}}
            <div class="group bg-white rounded-xl p-4 border border-slate-200/80 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
                <div class="flex items-start justify-between mb-3">
                    <div class="w-10 h-10 rounded-xl bg-blue-500 text-white flex items-center justify-center shadow-md shadow-blue-500/25 group-hover:scale-105 transition-transform">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    </div>
                    <span class="text-[10px] font-bold text-blue-600 bg-blue-50 px-2 py-0.5 rounded-full">Inventaris</span>
                </div>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Total Barang</p>
                <h3 class="text-3xl font-extrabold text-slate-900 mt-1 mb-3">{{ number_format($stats['total_barang'] ?? 0) }}</h3>
                <div class="flex items-center justify-between pt-3 border-t border-slate-100">
                    <span class="text-[11px] text-slate-400">Katalog Aktif</span>
                    <a href="{{ route('admin.barang.index') }}" class="text-blue-600 hover:text-blue-800 font-bold text-[11px] inline-flex items-center gap-0.5 group-hover:gap-1.5 transition-all">
                        Kelola <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>
            </div>

            {{-- Sedang Dipinjam --}}
            <div class="group bg-white rounded-xl p-4 border border-slate-200/80 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
                <div class="flex items-start justify-between mb-3">
                    <div class="w-10 h-10 rounded-xl bg-violet-500 text-white flex items-center justify-center shadow-md shadow-violet-500/25 group-hover:scale-105 transition-transform">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                    </div>
                    <span class="text-[10px] font-bold text-violet-600 bg-violet-50 px-2 py-0.5 rounded-full">Aktif</span>
                </div>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Sedang Dipinjam</p>
                <h3 class="text-3xl font-extrabold text-slate-900 mt-1 mb-3">{{ number_format($stats['sedang_dipinjam'] ?? 0) }}</h3>
                <div class="flex items-center justify-between pt-3 border-t border-slate-100">
                    <span class="text-[11px] text-slate-400">Peminjaman Luar</span>
                    <a href="{{ route('admin.peminjaman.index') }}" class="text-violet-600 hover:text-violet-800 font-bold text-[11px] inline-flex items-center gap-0.5 group-hover:gap-1.5 transition-all">
                        Rincian <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>
            </div>

            {{-- Menunggu Approval --}}
            <div class="group bg-white rounded-xl p-4 border border-slate-200/80 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
                <div class="flex items-start justify-between mb-3">
                    <div class="w-10 h-10 rounded-xl bg-amber-500 text-white flex items-center justify-center shadow-md shadow-amber-500/25 group-hover:scale-105 transition-transform">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                    </div>
                    <span class="text-[10px] font-bold text-amber-600 bg-amber-50 px-2 py-0.5 rounded-full">Review</span>
                </div>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Menunggu Approval</p>
                <h3 class="text-3xl font-extrabold text-slate-900 mt-1 mb-3">{{ number_format($stats['menunggu_approval'] ?? 0) }}</h3>
                <div class="flex items-center justify-between pt-3 border-t border-slate-100">
                    <span class="text-[11px] text-slate-400">Antrean Masuk</span>
                    <a href="{{ route('admin.peminjaman.index') }}" class="text-amber-600 hover:text-amber-800 font-bold text-[11px] inline-flex items-center gap-0.5 group-hover:gap-1.5 transition-all">
                        Verifikasi <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>
            </div>

            {{-- Terlambat --}}
            <div class="group bg-white rounded-xl p-4 border border-slate-200/80 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
                <div class="flex items-start justify-between mb-3">
                    <div class="w-10 h-10 rounded-xl bg-rose-500 text-white flex items-center justify-center shadow-md shadow-rose-500/25 group-hover:scale-105 transition-transform">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <span class="text-[10px] font-bold text-rose-600 bg-rose-50 px-2 py-0.5 rounded-full">Tenggat</span>
                </div>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Peminjaman Terlambat</p>
                <h3 class="text-3xl font-extrabold text-slate-900 mt-1 mb-3">{{ number_format($stats['terlambat'] ?? 0) }}</h3>
                <div class="flex items-center justify-between pt-3 border-t border-slate-100">
                    <span class="text-[11px] text-slate-400">Perlu Tindakan</span>
                    <a href="{{ route('admin.peminjaman.index') }}" class="text-rose-600 hover:text-rose-800 font-bold text-[11px] inline-flex items-center gap-0.5 group-hover:gap-1.5 transition-all">
                        Tindak Lanjut <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>
            </div>
        </div>

        {{-- Secondary Stats --}}
        <div class="grid gap-3 md:grid-cols-3">
            <div class="bg-white rounded-xl p-4 border border-slate-200/80 shadow-sm flex items-center gap-4 hover:shadow-md transition-all">
                <div class="w-10 h-10 rounded-xl bg-emerald-500 text-white flex items-center justify-center shadow-md shadow-emerald-500/25 flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Total Kategori</p>
                    <p class="text-2xl font-extrabold text-slate-900 leading-tight">{{ number_format($stats['total_kategori'] ?? 0) }}</p>
                </div>
            </div>
            <div class="bg-white rounded-xl p-4 border border-slate-200/80 shadow-sm flex items-center gap-4 hover:shadow-md transition-all">
                <div class="w-10 h-10 rounded-xl bg-cyan-500 text-white flex items-center justify-center shadow-md shadow-cyan-500/25 flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Total Terdaftar</p>
                    <p class="text-2xl font-extrabold text-slate-900 leading-tight">{{ number_format($stats['total_user'] ?? 0) }} <span class="text-base font-semibold text-slate-500">User</span></p>
                </div>
            </div>
            <div class="bg-white rounded-xl p-4 border border-slate-200/80 shadow-sm flex items-center gap-4 hover:shadow-md transition-all">
                <div class="w-10 h-10 rounded-xl bg-purple-500 text-white flex items-center justify-center shadow-md shadow-purple-500/25 flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Riwayat Akumulasi</p>
                    <p class="text-2xl font-extrabold text-slate-900 leading-tight">{{ number_format($stats['total_peminjaman'] ?? 0) }} <span class="text-base font-semibold text-slate-500">Transaksi</span></p>
                </div>
            </div>
        </div>

        {{-- Recent Transactions Table --}}
        <div class="bg-white rounded-xl border border-slate-200/80 shadow-sm overflow-hidden">
            <div class="px-5 py-4 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div>
                    <h2 class="text-sm font-extrabold text-slate-900">Peminjaman Terbaru</h2>
                    <p class="text-[11px] text-slate-400 mt-0.5">5 transaksi aktivitas peminjaman terkini</p>
                </div>
                <a href="{{ route('admin.peminjaman.index') }}"
                   class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-blue-500 hover:bg-blue-600 text-white text-xs font-bold rounded-lg transition-colors shadow-sm shadow-blue-500/20">
                    Lihat Semua
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>

            @if($recentPeminjamans->isEmpty())
                <div class="py-14 text-center">
                    <div class="w-14 h-14 rounded-2xl bg-slate-100 text-slate-300 flex items-center justify-center mx-auto mb-3">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <p class="text-slate-600 font-bold text-sm">Belum Ada Transaksi</p>
                    <p class="text-xs text-slate-400 mt-1">Transaksi peminjaman baru akan muncul di sini.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-100 text-[10px] font-extrabold uppercase tracking-wider text-slate-400">
                                <th class="px-5 py-3">Peminjam</th>
                                <th class="px-5 py-3">Tanggal Pinjam</th>
                                <th class="px-5 py-3">Status</th>
                                <th class="px-5 py-3">Keperluan</th>
                                <th class="px-5 py-3 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($recentPeminjamans as $item)
                                <tr class="hover:bg-slate-50/80 transition-colors">
                                    <td class="px-5 py-3.5">
                                        <div class="flex items-center gap-2.5">
                                            <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white font-bold text-xs shadow-sm flex-shrink-0">
                                                {{ strtoupper(substr($item->user->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <p class="font-semibold text-slate-900 text-xs">{{ $item->user->name }}</p>
                                                <p class="text-[10px] text-slate-400 font-mono">{{ $item->user->identitas ?? '—' }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-5 py-3.5">
                                        <p class="font-semibold text-slate-700 text-xs">{{ $item->tanggal_pinjam->format('d M Y') }}</p>
                                        <p class="text-[10px] text-slate-400">{{ $item->tanggal_pinjam->diffForHumans() }}</p>
                                    </td>
                                    <td class="px-5 py-3.5">
                                        <x-status-peminjaman :status="$item->status" />
                                    </td>
                                    <td class="px-5 py-3.5 max-w-[180px]">
                                        <span class="text-slate-500 text-xs truncate block">{{ Str::limit($item->keperluan, 40) }}</span>
                                    </td>
                                    <td class="px-5 py-3.5 text-right">
                                        <a href="{{ route('admin.peminjaman.show', $item) }}"
                                           class="inline-flex items-center gap-1 text-xs font-bold text-blue-600 hover:text-blue-800 bg-blue-50 hover:bg-blue-100 px-2.5 py-1.5 rounded-lg transition-colors">
                                            Detail
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</x-layouts.admin>
