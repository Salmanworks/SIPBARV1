<x-layouts.admin title="Verifikasi Peminjaman">
    <div class="space-y-7">

        {{-- Header --}}
        <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-emerald-500 via-teal-500 to-cyan-600 p-8 md:p-10 text-white shadow-xl shadow-emerald-500/25">
            <div class="absolute -right-16 -top-16 w-64 h-64 bg-white/10 rounded-full blur-2xl pointer-events-none"></div>
            <div class="absolute left-1/3 -bottom-12 w-48 h-48 bg-teal-400/20 rounded-full blur-2xl pointer-events-none"></div>
            <div class="relative z-10 flex flex-col sm:flex-row sm:items-center justify-between gap-5">
                <div class="space-y-2">
                    <span class="inline-block px-3 py-1 rounded-full bg-white/15 border border-white/25 text-[10px] font-bold tracking-widest uppercase">Guru Gudang</span>
                    <h1 class="text-2xl md:text-3xl font-extrabold tracking-tight">Verifikasi Peminjaman</h1>
                    <p class="text-white/75 text-xs max-w-lg leading-relaxed">Kelola dan verifikasi penyerahan barang keluar serta pengembalian barang dari peminjam.</p>
                </div>
                <a href="{{ route('guru.dashboard') }}" class="flex-shrink-0 inline-flex items-center justify-center gap-2 px-5 py-3 rounded-2xl bg-white/20 hover:bg-white/30 border border-white/30 text-white font-bold text-xs uppercase tracking-wider transition-all hover:scale-105">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    Dashboard
                </a>
            </div>
        </div>

        <x-alert />

        {{-- Filter --}}
        <div class="bg-white rounded-2xl border border-slate-200/70 shadow-sm p-5">
            <form method="GET" class="flex flex-wrap gap-3 items-end">
                <div class="flex-1 min-w-[180px]">
                    <label class="block text-xs font-bold text-slate-600 mb-1.5 uppercase tracking-wider">Filter Status</label>
                    <select name="status" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm font-medium text-slate-700 focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:border-emerald-400 transition-all">
                        <option value="">Semua Status Aktif</option>
                        <option value="disetujui" @selected(request('status') === 'disetujui')>Disetujui — Siap Serah</option>
                        <option value="dipinjam" @selected(request('status') === 'dipinjam')>Sedang Dipinjam</option>
                        <option value="terlambat" @selected(request('status') === 'terlambat')>Terlambat</option>
                    </select>
                </div>
                <button type="submit" class="px-5 py-2.5 bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white font-bold text-xs rounded-xl shadow-md shadow-emerald-500/30 transition-all hover:scale-[1.02]">
                    Terapkan Filter
                </button>
                @if(request('status'))
                    <a href="{{ route('guru.verifikasi.index') }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold text-xs rounded-xl transition-all">
                        Reset
                    </a>
                @endif
            </form>
        </div>

        {{-- Tabel Verifikasi --}}
        <div class="bg-white rounded-3xl border border-slate-200/70 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                <div>
                    <h2 class="text-base font-extrabold text-slate-900">Daftar Peminjaman Aktif</h2>
                    <p class="text-xs text-slate-400 mt-0.5">{{ $peminjamans->total() }} transaksi ditemukan</p>
                </div>
            </div>

            @if($peminjamans->isEmpty())
                <div class="p-14 text-center">
                    <div class="w-16 h-16 rounded-3xl bg-emerald-50 text-emerald-400 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <p class="font-bold text-slate-800 text-sm">Tidak Ada Data</p>
                    <p class="text-xs text-slate-500 mt-1">Tidak ada peminjaman aktif yang perlu diverifikasi.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="border-b border-slate-100 bg-slate-50/70">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Peminjam</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Tanggal Pinjam</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Rencana Kembali</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-right text-xs font-bold text-slate-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($peminjamans as $item)
                                <tr class="hover:bg-emerald-50/30 transition-colors group">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-9 h-9 rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-600 text-white font-extrabold flex items-center justify-center text-xs shadow-sm">
                                                {{ strtoupper(substr($item->user->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <p class="font-bold text-slate-900 text-sm">{{ $item->user->name }}</p>
                                                <p class="text-xs text-slate-400">{{ $item->user->email }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-slate-600 font-medium">
                                        {{ $item->tanggal_pinjam->format('d M Y') }}
                                    </td>
                                    <td class="px-6 py-4 text-slate-600 font-medium">
                                        {{ $item->tanggal_kembali_rencana ? $item->tanggal_kembali_rencana->format('d M Y') : '—' }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <x-status-peminjaman :status="$item->status" />
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <a href="{{ route('guru.verifikasi.show', $item) }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white font-bold text-xs rounded-xl shadow-sm shadow-emerald-500/25 transition-all hover:scale-[1.02]">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            Verifikasi
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="px-6 py-4 border-t border-slate-100">
                    {{ $peminjamans->links() }}
                </div>
            @endif
        </div>
    </div>
</x-layouts.admin>
