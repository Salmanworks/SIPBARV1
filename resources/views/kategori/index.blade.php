<x-layouts.admin title="Kategori Barang">
    <div class="space-y-8">
        {{-- Header Bar --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 md:p-8 rounded-3xl border border-slate-200/80 shadow-soft">
            <div>
                <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight font-display">Kategori Barang</h1>
                <p class="text-xs text-slate-600 mt-1">Kelola pengelompokan jenis dan kategori inventaris sekolah</p>
            </div>
            
            <a href="{{ route('admin.kategori.create') }}" class="inline-flex items-center justify-center gap-2 px-5 py-3 rounded-2xl bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold text-xs uppercase tracking-wider shadow-lg shadow-blue-600/30 hover:scale-[1.02] transition-all">
                <x-icon name="plus" size="sm" />
                <span>Tambah Kategori</span>
            </a>
        </div>

        <x-alert />

        {{-- Search Toolbar --}}
        <form method="GET" class="bg-white p-4 rounded-3xl border border-slate-200/80 shadow-soft flex gap-3 max-w-md">
            <div class="relative flex-1">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <x-icon name="magnifying-glass" size="sm" />
                </div>
                <input name="search" type="text" value="{{ request('search') }}" placeholder="Cari nama kategori..." class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white" />
            </div>
            <button type="submit" class="py-2.5 px-5 bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs rounded-2xl transition-colors">
                Cari
            </button>
        </form>

        {{-- Category Table --}}
        <div class="bg-white rounded-3xl border border-slate-200/80 shadow-soft overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/80 border-b border-slate-100 text-[11px] font-extrabold uppercase tracking-wider text-slate-600">
                        <th class="px-6 py-4">Nama Kategori</th>
                        <th class="px-6 py-4">Deskripsi</th>
                        <th class="px-6 py-4">Jumlah Barang</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs font-medium text-slate-700">
                    @forelse($kategoris as $kategori)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="px-6 py-4 font-bold text-slate-900 flex items-center gap-3">
                                <div class="w-8 h-8 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-xs">
                                    <x-icon name="tag" size="sm" />
                                </div>
                                <span>{{ $kategori->nama_kategori }}</span>
                            </td>
                            <td class="px-6 py-4 text-slate-600">
                                {{ Str::limit($kategori->deskripsi, 65) ?: '—' }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-1 rounded-full bg-indigo-50 text-indigo-700 font-extrabold text-[11px]">
                                    {{ $kategori->barangs_count }} Items
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.kategori.edit', $kategori) }}" class="px-3 py-1.5 bg-blue-50 hover:bg-blue-100 text-blue-700 font-bold text-xs rounded-xl transition-colors">
                                        Edit
                                    </a>
                                    <form method="POST" action="{{ route('admin.kategori.destroy', $kategori) }}" onsubmit="return confirm('Hapus kategori ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="px-3 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-700 font-bold text-xs rounded-xl transition-colors">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-slate-400">
                                Belum ada data kategori barang.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $kategoris->links() }}
        </div>
    </div>
</x-layouts.admin>
