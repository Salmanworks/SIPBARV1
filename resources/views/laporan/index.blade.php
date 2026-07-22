<x-layouts.admin title="Laporan & Ekspor Peminjaman">
    <div class="space-y-8">
        {{-- Header Bar --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 md:p-8 rounded-3xl border border-slate-200/80 shadow-soft">
            <div>
                <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight font-display">Laporan & Ekspor Data Peminjaman</h1>
                <p class="text-xs text-slate-600 mt-1">Filter rekapitulasi data peminjaman barang berdasarkan periode tanggal dan status</p>
            </div>
            
            <button onclick="window.print()" class="inline-flex items-center justify-center gap-2 px-5 py-3 rounded-2xl bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs uppercase tracking-wider shadow-md transition-all">
                <x-icon name="printer" size="sm" />
                <span>Cetak Laporan</span>
            </button>
        </div>

        <x-alert />

        {{-- Date & Status Filter Form --}}
        <form method="GET" class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-soft grid gap-4 md:grid-cols-12 items-end">
            <div class="md:col-span-4">
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Dari Tanggal</label>
                <input name="dari" type="date" value="{{ $from->format('Y-m-d') }}" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500" />
            </div>

            <div class="md:col-span-4">
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Sampai Tanggal</label>
                <input name="sampai" type="date" value="{{ $to->format('Y-m-d') }}" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500" />
            </div>

            <div class="md:col-span-3">
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Filter Status</label>
                <select name="status" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Semua Status Transaksi</option>
                    @foreach(\App\Enums\PeminjamanStatus::cases() as $status)
                        <option value="{{ $status->value }}" @selected(request('status') === $status->value)>{{ $status->label() }}</option>
                    @endforeach
                </select>
            </div>

            <div class="md:col-span-1">
                <button type="submit" class="w-full py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs rounded-2xl transition-colors">
                    Tampilkan
                </button>
            </div>
        </form>

        {{-- Metric Summary Cards --}}
        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-5">
            <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs">
                <p class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Total Transaksi</p>
                <p class="text-2xl font-extrabold text-slate-900 mt-1">{{ number_format($summary['total']) }}</p>
            </div>
            <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs">
                <p class="text-[11px] font-bold text-amber-700 uppercase tracking-wider">Diajukan</p>
                <p class="text-2xl font-extrabold text-amber-900 mt-1">{{ number_format($summary['diajukan']) }}</p>
            </div>
            <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs">
                <p class="text-[11px] font-bold text-blue-700 uppercase tracking-wider">Dipinjam</p>
                <p class="text-2xl font-extrabold text-blue-900 mt-1">{{ number_format($summary['dipinjam']) }}</p>
            </div>
            <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs">
                <p class="text-[11px] font-bold text-emerald-700 uppercase tracking-wider">Dikembalikan</p>
                <p class="text-2xl font-extrabold text-emerald-900 mt-1">{{ number_format($summary['dikembalikan']) }}</p>
            </div>
            <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs">
                <p class="text-[11px] font-bold text-rose-700 uppercase tracking-wider">Terlambat</p>
                <p class="text-2xl font-extrabold text-rose-900 mt-1">{{ number_format($summary['terlambat']) }}</p>
            </div>
        </div>

        {{-- Laporan Table --}}
        <div class="bg-white rounded-3xl border border-slate-200/80 shadow-soft overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/80 border-b border-slate-100 text-[11px] font-extrabold uppercase tracking-wider text-slate-600">
                        <th class="px-6 py-4">Peminjam</th>
                        <th class="px-6 py-4">Tanggal Pinjam</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Keperluan Peminjaman</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs font-medium text-slate-700">
                    @forelse($peminjamans as $item)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-xl bg-slate-100 text-slate-700 font-bold text-xs flex items-center justify-center">
                                        {{ strtoupper(substr($item->user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-900 text-xs">{{ $item->user->name }}</p>
                                        <p class="text-[11px] text-slate-400 font-mono">{{ $item->user->no_induk ?? 'N/A' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <p class="font-semibold text-slate-900">{{ $item->tanggal_pinjam->format('d M Y') }}</p>
                                <p class="text-[11px] text-slate-400">s/d {{ $item->tanggal_kembali_rencana ? $item->tanggal_kembali_rencana->format('d M Y') : '—' }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <x-status-peminjaman :status="$item->status" />
                            </td>
                            <td class="px-6 py-4 text-slate-600 max-w-sm">
                                {{ Str::limit($item->keperluan, 65) }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-slate-400">
                                Tidak ada transaksi peminjaman pada periode tanggal ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $peminjamans->links() }}
        </div>
    </div>
</x-layouts.admin>
