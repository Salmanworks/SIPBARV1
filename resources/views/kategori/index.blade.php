<x-layouts.admin title="Kategori Barang">
    <div class="space-y-6">
        {{-- Header Bar --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-gradient-to-r from-slate-900 to-blue-900 p-6 md:p-8 rounded-3xl shadow-2xl shadow-blue-900/30">
            <div class="space-y-1">
                <h1 class="text-2xl font-extrabold text-white tracking-tight">Kategori Barang</h1>
                <p class="text-xs text-slate-300">Kelola pengelompokan jenis dan kategori inventaris sekolah</p>
            </div>
            
            <a href="{{ route('admin.kategori.create') }}" class="inline-flex items-center justify-center gap-2 px-5 py-3 rounded-2xl bg-white text-blue-900 font-bold text-xs uppercase tracking-wider shadow-xl hover:bg-blue-50 hover:scale-105 transition-all duration-300">
                <x-icon name="plus" size="sm" />
                <span>Tambah Kategori</span>
            </a>
        </div>

        <x-alert />

        {{-- Search Toolbar --}}
        <form method="GET" class="bg-white p-4 rounded-2xl border border-slate-200/50 shadow-lg shadow-slate-200/30 flex gap-3 max-w-md">
            <div class="relative flex-1">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                    <x-icon name="magnifying-glass" size="sm" />
                </div>
                <input name="search" type="text" value="{{ request('search') }}" placeholder="Cari nama kategori..." class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all" />
            </div>
            <button type="submit" class="py-2.5 px-5 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-bold text-xs rounded-xl transition-all shadow-lg shadow-blue-500/20">
                Cari
            </button>
        </form>

        {{-- Category Table --}}
        <div class="bg-white rounded-2xl border border-slate-200/50 shadow-lg shadow-slate-200/30 overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gradient-to-r from-slate-50 to-slate-100 border-b border-slate-200 text-xs font-extrabold uppercase tracking-wider text-slate-600">
                        <th class="px-6 py-4">Nama Kategori</th>
                        <th class="px-6 py-4">Deskripsi</th>
                        <th class="px-6 py-4">Jumlah Barang</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm font-medium text-slate-700">
                    @forelse($kategoris as $kategori)
                        <tr class="hover:bg-gradient-to-r hover:from-blue-50 hover:to-indigo-50 transition-all duration-200">
                            <td class="px-6 py-4 font-bold text-slate-900 flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 text-white flex items-center justify-center font-bold text-xs shadow-lg shadow-blue-500/20">
                                    <x-icon name="tag" size="sm" />
                                </div>
                                <span>{{ $kategori->nama_kategori }}</span>
                            </td>
                            <td class="px-6 py-4 text-slate-600">
                                {{ Str::limit($kategori->deskripsi, 65) ?: '—' }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1.5 rounded-full bg-gradient-to-r from-indigo-500 to-indigo-600 text-white font-extrabold text-xs shadow-lg shadow-indigo-500/30">
                                    {{ $kategori->barangs_count }} Items
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.kategori.edit', $kategori) }}" class="px-3 py-1.5 bg-blue-50 hover:bg-blue-100 text-blue-700 font-bold text-xs rounded-lg transition-all shadow-sm hover:shadow-md">
                                        Edit
                                    </a>
                                    <form method="POST" action="{{ route('admin.kategori.destroy', $kategori) }}" onsubmit="return confirm('Hapus kategori ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="px-3 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-700 font-bold text-xs rounded-lg transition-all shadow-sm hover:shadow-md">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center">
                                <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-slate-100 to-slate-200 text-slate-400 flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                                </div>
                                <p class="text-slate-700 font-bold text-base">Belum ada data kategori barang</p>
                                <p class="text-xs text-slate-500 mt-1">Mulai dengan menambahkan kategori baru ke sistem.</p>
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
