<x-layouts.admin title="Dashboard Admin">
    <div class="space-y-8">

        {{-- Hero Welcome Banner (Light) --}}
        <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-blue-600 via-indigo-500 to-violet-600 p-8 md:p-10 text-white shadow-xl shadow-blue-500/25">
            <div class="absolute -right-16 -top-16 w-64 h-64 bg-white/10 rounded-full blur-2xl pointer-events-none"></div>
            <div class="absolute right-1/3 -bottom-12 w-48 h-48 bg-indigo-400/20 rounded-full blur-2xl pointer-events-none"></div>
            <div class="absolute -left-8 bottom-0 w-40 h-40 bg-blue-400/20 rounded-full blur-2xl pointer-events-none"></div>

            <div class="relative z-10 flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
                <div class="space-y-3 max-w-2xl">
                    <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-white/15 backdrop-blur-md border border-white/25 text-xs font-semibold text-white">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-400"></span>
                        </span>
                        Sistem Aktif & Terhubung
                    </div>
                    <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight text-white">
                        Selamat Datang, {{ auth()->user()->name }}! 👋
                    </h1>
                    <p class="text-white/80 text-sm md:text-base leading-relaxed">
                        Kelola seluruh aktivitas peminjaman inventaris, tinjau pengajuan yang masuk, dan pantau status barang secara real-time dari panel kontrol utama SIPBAR.
                    </p>
                </div>

                <div class="flex flex-wrap md:flex-col gap-3 min-w-[180px]">
                    <a href="{{ route('admin.barang.create') }}" class="inline-flex items-center justify-center gap-2 px-5 py-3 rounded-2xl bg-white text-blue-700 font-bold text-xs uppercase tracking-wider shadow-lg hover:bg-blue-50 hover:scale-[1.02] transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Tambah Barang
                    </a>
                    <a href="{{ route('admin.laporan.index') }}" class="inline-flex items-center justify-center gap-2 px-5 py-3 rounded-2xl bg-white/15 border border-white/30 text-white font-bold text-xs uppercase tracking-wider hover:bg-white/25 transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        Cetak Laporan
                    </a>
                </div>
            </div>
        </div>

        {{-- Alert Notifications --}}
        @if(($stats['menunggu_approval'] ?? 0) > 0 || ($stats['terlambat'] ?? 0) > 0)
            <div class="grid gap-4 md:grid-cols-2">
                @if(($stats['menunggu_approval'] ?? 0) > 0)
                <div class="p-5 rounded-2xl bg-amber-50 border border-amber-200 flex items-start gap-4 shadow-sm">
                    <div class="w-11 h-11 rounded-2xl bg-amber-500 text-white flex items-center justify-center shadow-md shadow-amber-500/30 flex-shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center justify-between">
                            <h3 class="font-bold text-amber-900 text-sm">Persetujuan Diperlukan</h3>
                            <span class="px-2.5 py-0.5 rounded-full bg-amber-500 text-white text-xs font-black">{{ $stats['menunggu_approval'] }} Pending</span>
                        </div>
                        <p class="text-xs text-amber-700 mt-1">Terdapat <strong>{{ $stats['menunggu_approval'] }} pengajuan baru</strong> yang memerlukan tinjauan Anda.</p>
                        <a href="{{ route('admin.peminjaman.index') }}" class="inline-flex items-center gap-1 text-xs text-amber-700 hover:text-amber-900 font-bold mt-2 group">
                            Proses Sekarang
                            <svg class="w-3 h-3 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    </div>
                </div>
                @endif

                @if(($stats['terlambat'] ?? 0) > 0)
                <div class="p-5 rounded-2xl bg-rose-50 border border-rose-200 flex items-start gap-4 shadow-sm">
                    <div class="w-11 h-11 rounded-2xl bg-rose-500 text-white flex items-center justify-center shadow-md shadow-rose-500/30 flex-shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center justify-between">
                            <h3 class="font-bold text-rose-900 text-sm">Peminjaman Terlambat</h3>
                            <span class="px-2.5 py-0.5 rounded-full bg-rose-500 text-white text-xs font-black">{{ $stats['terlambat'] }} Overdue</span>
                        </div>
                        <p class="text-xs text-rose-700 mt-1"><strong>{{ $stats['terlambat'] }} peminjaman barang</strong> telah melewati tenggat waktu pengembalian.</p>
                        <a href="{{ route('admin.peminjaman.index') }}" class="inline-flex items-center gap-1 text-xs text-rose-700 hover:text-rose-900 font-bold mt-2 group">
                            Lihat Daftar Terlambat
                            <svg class="w-3 h-3 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    </div>
                </div>
                @endif
            </div>
        @endif

        {{-- Primary KPI Cards --}}
        <div class="grid gap-5 sm:grid-cols-2 xl:grid-cols-4">
            {{-- Total Barang --}}
            <div class="group card-hover bg-white rounded-3xl p-6 border border-slate-200/70 shadow-sm overflow-hidden relative">
                <div class="absolute inset-0 bg-gradient-to-br from-blue-50/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-5">
                        <div class="w-12 h-12 rounded-2xl bg-blue-100 text-blue-600 flex items-center justify-center group-hover:bg-blue-600 group-hover:text-white transition-all duration-300 shadow-sm">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                        </div>
                        <span class="text-[11px] font-bold text-blue-600 bg-blue-50 px-2.5 py-1 rounded-full">Inventaris</span>
                    </div>
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Total Barang</p>
                    <h3 class="text-4xl font-extrabold text-slate-900 mt-1">{{ number_format($stats['total_barang'] ?? 0) }}</h3>
                    <div class="mt-4 pt-4 border-t border-slate-100 flex items-center justify-between text-xs">
                        <span class="text-slate-500 font-medium">Katalog Aktif</span>
                        <a href="{{ route('admin.barang.index') }}" class="text-blue-600 hover:text-blue-800 font-bold inline-flex items-center gap-1">
                            Kelola
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    </div>
                </div>
            </div>

            {{-- Sedang Dipinjam --}}
            <div class="group card-hover bg-white rounded-3xl p-6 border border-slate-200/70 shadow-sm overflow-hidden relative">
                <div class="absolute inset-0 bg-gradient-to-br from-violet-50/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-5">
                        <div class="w-12 h-12 rounded-2xl bg-violet-100 text-violet-600 flex items-center justify-center group-hover:bg-violet-600 group-hover:text-white transition-all duration-300 shadow-sm">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                        </div>
                        <span class="text-[11px] font-bold text-violet-600 bg-violet-50 px-2.5 py-1 rounded-full">Aktif</span>
                    </div>
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Sedang Dipinjam</p>
                    <h3 class="text-4xl font-extrabold text-slate-900 mt-1">{{ number_format($stats['sedang_dipinjam'] ?? 0) }}</h3>
                    <div class="mt-4 pt-4 border-t border-slate-100 flex items-center justify-between text-xs">
                        <span class="text-slate-500 font-medium">Peminjaman Luar</span>
                        <a href="{{ route('admin.peminjaman.index') }}" class="text-violet-600 hover:text-violet-800 font-bold inline-flex items-center gap-1">
                            Rincian
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    </div>
                </div>
            </div>

            {{-- Menunggu Approval --}}
            <div class="group card-hover bg-white rounded-3xl p-6 border border-slate-200/70 shadow-sm overflow-hidden relative">
                <div class="absolute inset-0 bg-gradient-to-br from-amber-50/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-5">
                        <div class="w-12 h-12 rounded-2xl bg-amber-100 text-amber-600 flex items-center justify-center group-hover:bg-amber-500 group-hover:text-white transition-all duration-300 shadow-sm">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                        </div>
                        <span class="text-[11px] font-bold text-amber-600 bg-amber-50 px-2.5 py-1 rounded-full">Review</span>
                    </div>
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Menunggu Approval</p>
                    <h3 class="text-4xl font-extrabold text-slate-900 mt-1">{{ number_format($stats['menunggu_approval'] ?? 0) }}</h3>
                    <div class="mt-4 pt-4 border-t border-slate-100 flex items-center justify-between text-xs">
                        <span class="text-slate-500 font-medium">Antrean Masuk</span>
                        <a href="{{ route('admin.peminjaman.index') }}" class="text-amber-600 hover:text-amber-800 font-bold inline-flex items-center gap-1">
                            Verifikasi
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    </div>
                </div>
            </div>

            {{-- Terlambat --}}
            <div class="group card-hover bg-white rounded-3xl p-6 border border-slate-200/70 shadow-sm overflow-hidden relative">
                <div class="absolute inset-0 bg-gradient-to-br from-rose-50/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-5">
                        <div class="w-12 h-12 rounded-2xl bg-rose-100 text-rose-600 flex items-center justify-center group-hover:bg-rose-600 group-hover:text-white transition-all duration-300 shadow-sm">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <span class="text-[11px] font-bold text-rose-600 bg-rose-50 px-2.5 py-1 rounded-full">Tenggat</span>
                    </div>
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Peminjaman Terlambat</p>
                    <h3 class="text-4xl font-extrabold text-slate-900 mt-1">{{ number_format($stats['terlambat'] ?? 0) }}</h3>
                    <div class="mt-4 pt-4 border-t border-slate-100 flex items-center justify-between text-xs">
                        <span class="text-slate-500 font-medium">Perlu Tindakan</span>
                        <a href="{{ route('admin.peminjaman.index') }}" class="text-rose-600 hover:text-rose-800 font-bold inline-flex items-center gap-1">
                            Tindak Lanjut
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Secondary Stats --}}
        <div class="grid gap-5 md:grid-cols-3">
            <div class="bg-white rounded-2xl p-5 border border-slate-200/70 shadow-sm flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-emerald-100 text-emerald-600 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Total Kategori</p>
                    <p class="text-2xl font-extrabold text-slate-900">{{ number_format($stats['total_kategori'] ?? 0) }}</p>
                </div>
            </div>
            <div class="bg-white rounded-2xl p-5 border border-slate-200/70 shadow-sm flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-cyan-100 text-cyan-600 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Total Terdaftar</p>
                    <p class="text-2xl font-extrabold text-slate-900">{{ number_format($stats['total_user'] ?? 0) }} User</p>
                </div>
            </div>
            <div class="bg-white rounded-2xl p-5 border border-slate-200/70 shadow-sm flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-purple-100 text-purple-600 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Riwayat Akumulasi</p>
                    <p class="text-2xl font-extrabold text-slate-900">{{ number_format($stats['total_peminjaman'] ?? 0) }} Transaksi</p>
                </div>
            </div>
        </div>

        {{-- Recent Transactions Table --}}
        <div class="bg-white rounded-3xl border border-slate-200/70 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h2 class="text-base font-extrabold text-slate-900">Peminjaman Terbaru</h2>
                    <p class="text-xs text-slate-500 mt-0.5">Ringkasan 5 transaksi aktivitas peminjaman barang terkini</p>
                </div>
                <a href="{{ route('admin.peminjaman.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-50 hover:bg-blue-100 text-blue-700 text-xs font-bold rounded-xl transition-all border border-blue-200/70">
                    Lihat Semua Transaksi
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>

            @if($recentPeminjamans->isEmpty())
                <div class="p-14 text-center">
                    <div class="w-16 h-16 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-3">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <p class="text-slate-700 font-semibold text-sm">Belum Ada Transaksi Peminjaman</p>
                    <p class="text-xs text-slate-500 mt-1">Seluruh transaksi peminjaman baru akan ditampilkan di sini.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-100 text-[11px] font-extrabold uppercase tracking-wider text-slate-500">
                                <th class="px-6 py-4">Peminjam</th>
                                <th class="px-6 py-4">Tanggal Pinjam</th>
                                <th class="px-6 py-4">Status</th>
                                <th class="px-6 py-4">Keperluan</th>
                                <th class="px-6 py-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($recentPeminjamans as $item)
                                <tr class="hover:bg-blue-50/30 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white font-bold text-xs shadow-md">
                                                {{ strtoupper(substr($item->user->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <p class="font-bold text-slate-900 text-xs">{{ $item->user->name }}</p>
                                                <p class="text-[11px] text-slate-500 font-mono">{{ $item->user->no_induk ?? 'N/A' }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <p class="font-semibold text-slate-900 text-xs">{{ $item->tanggal_pinjam->format('d M Y') }}</p>
                                        <p class="text-[11px] text-slate-500">{{ $item->tanggal_pinjam->diffForHumans() }}</p>
                                    </td>
                                    <td class="px-6 py-4">
                                        <x-status-peminjaman :status="$item->status" />
                                    </td>
                                    <td class="px-6 py-4 max-w-xs">
                                        <span class="text-slate-600 text-xs truncate block max-w-[180px]">{{ Str::limit($item->keperluan, 45) }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <a href="{{ route('admin.peminjaman.show', $item) }}" class="inline-flex items-center gap-1 text-xs font-bold text-blue-600 hover:text-blue-800 bg-blue-50 hover:bg-blue-100 px-3 py-1.5 rounded-lg transition-all">
                                            Detail
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
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
