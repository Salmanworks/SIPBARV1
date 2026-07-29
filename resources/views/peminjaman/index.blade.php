<x-layouts.admin title="Kelola Peminjaman">
    <div class="space-y-8">
        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 md:p-8 rounded-3xl border border-slate-200/80 shadow-soft">
            <div>
                <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight font-display">Data Transaksi Peminjaman</h1>
                <p class="text-xs text-slate-600 mt-1">Kelola permohonan, tinjau approval, dan pantau pengembalian barang inventaris</p>
            </div>
            
            <a href="{{ route('admin.peminjaman.approval') }}" class="inline-flex items-center justify-center gap-2 px-5 py-3 rounded-2xl bg-amber-500 hover:bg-amber-600 text-white font-bold text-xs uppercase tracking-wider shadow-lg shadow-amber-500/30 hover:scale-[1.02] transition-all">
                <x-icon name="bell" size="sm" />
                <span>Antrean Review Approval</span>
            </a>
        </div>

        <x-alert />

        {{-- Search & Filter Toolbar --}}
        <form method="GET" class="bg-white p-4 rounded-3xl border border-slate-200/80 shadow-soft flex flex-wrap gap-3 items-center">
            <div class="relative flex-1 min-w-[220px]">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <x-icon name="magnifying-glass" size="sm" />
                </div>
                <input name="search" type="text" value="{{ request('search') }}" placeholder="Cari nama peminjam atau keperluan..." class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white" />
            </div>

            <select name="status" class="px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 min-w-[160px]">
                <option value="">Semua Status Transaksi</option>
                @foreach(\App\Enums\PeminjamanStatus::cases() as $status)
                    <option value="{{ $status->value }}" @selected(request('status') === $status->value)>{{ $status->label() }}</option>
                @endforeach
            </select>

            <button type="submit" class="py-2.5 px-5 bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs rounded-2xl transition-colors">
                Filter
            </button>
            <a href="{{ route('admin.peminjaman.index') }}" class="py-2.5 px-4 bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold text-xs rounded-2xl transition-colors">
                Reset
            </a>
        </form>

        {{-- Transactions Table --}}
        <div class="bg-white rounded-3xl border border-slate-200/80 shadow-soft overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/80 border-b border-slate-100 text-[11px] font-extrabold uppercase tracking-wider text-slate-600">
                        <th class="px-6 py-4">Peminjam</th>
                        <th class="px-6 py-4">Tanggal Pinjam</th>
                        <th class="px-6 py-4">Estimasi Pengembalian</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs font-medium text-slate-700">
                    @forelse($peminjamans as $item)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-blue-600 to-indigo-600 flex items-center justify-center text-white font-bold text-xs shadow-md">
                                        {{ strtoupper(substr($item->user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-900 text-xs">{{ $item->user->name }}</p>
                                        <p class="text-[11px] text-slate-400 font-mono">{{ $item->user->identitas ?? 'N/A' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <p class="font-semibold text-slate-900">{{ $item->tanggal_pinjam->format('d M Y') }}</p>
                                <p class="text-[11px] text-slate-400">{{ $item->tanggal_pinjam->diffForHumans() }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <p class="font-semibold text-slate-900">{{ $item->tanggal_kembali_rencana ? $item->tanggal_kembali_rencana->format('d M Y') : '—' }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <x-status-peminjaman :status="$item->status" />
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('admin.peminjaman.show', $item) }}" class="inline-flex items-center gap-1 px-3 py-1.5 bg-blue-50 hover:bg-blue-100 text-blue-700 font-bold text-xs rounded-xl transition-colors">
                                    <span>Detail Rincian</span>
                                    <x-icon name="arrow-right" size="xs" />
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                                Belum ada data transaksi peminjaman.
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
