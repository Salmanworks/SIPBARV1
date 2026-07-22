<x-layouts.admin title="Kelola Inventaris Barang">
    <div class="space-y-8">
        {{-- Page Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 md:p-8 rounded-3xl border border-slate-200/80 shadow-soft">
            <div>
                <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight font-display">Kelola Inventaris Barang</h1>
                <p class="text-xs text-slate-600 mt-1">Kelola data seluruh aset, peralatan lab, dan barang inventaris sekolah</p>
            </div>
            
            @if(auth()->user()->isAdmin())
                <a href="{{ route('admin.barang.create') }}" class="inline-flex items-center justify-center gap-2 px-5 py-3 rounded-2xl bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold text-xs uppercase tracking-wider shadow-lg shadow-blue-600/30 hover:scale-[1.02] transition-all">
                    <x-icon name="plus" size="sm" />
                    <span>Tambah Barang Baru</span>
                </a>
            @endif
        </div>

        <x-alert />

        {{-- Filter & Search Form --}}
        <form method="GET" class="bg-white p-5 rounded-3xl border border-slate-200/80 shadow-soft grid gap-4 md:grid-cols-12 items-end">
            <div class="md:col-span-4">
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Pencarian Barang</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <x-icon name="magnifying-glass" size="sm" />
                    </div>
                    <input name="search" type="text" value="{{ request('search') }}" placeholder="Cari nama atau kode barang..." class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white" />
                </div>
            </div>

            <div class="md:col-span-3">
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Kategori</label>
                <select name="kategori_id" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Semua Kategori</option>
                    @foreach($kategoris as $kategori)
                        <option value="{{ $kategori->id }}" @selected(request('kategori_id') == $kategori->id)>{{ $kategori->nama_kategori }}</option>
                    @endforeach
                </select>
            </div>

            <div class="md:col-span-3">
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Status Ketersediaan</label>
                <select name="ketersediaan" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Semua Status Stok</option>
                    <option value="tersedia" @selected(request('ketersediaan') === 'tersedia')>Tersedia (>0)</option>
                    <option value="habis" @selected(request('ketersediaan') === 'habis')>Stok Habis (0)</option>
                </select>
            </div>

            <div class="md:col-span-2 flex items-center gap-2">
                <button type="submit" class="flex-1 py-2.5 px-4 bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs rounded-2xl shadow-md transition-colors">
                    Filter
                </button>
                <a href="{{ route('admin.barang.index') }}" class="py-2.5 px-3 bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold text-xs rounded-2xl transition-colors">
                    Reset
                </a>
            </div>
        </form>

        {{-- Inventory Items Grid --}}
        @if($barangs->isEmpty())
            <div class="bg-white rounded-3xl border border-dashed border-slate-300 p-12 text-center shadow-xs">
                <div class="w-16 h-16 rounded-2xl bg-slate-100 flex items-center justify-center mx-auto text-slate-400 mb-4">
                    <x-icon name="cube" size="xl" />
                </div>
                <h3 class="text-base font-bold text-slate-900">Belum Ada Barang Ditemukan</h3>
                <p class="text-xs text-slate-500 mt-1 max-w-sm mx-auto">Tidak ada barang inventaris yang cocok dengan kriteria pencarian Anda.</p>
            </div>
        @else
            <div class="grid gap-6 sm:grid-cols-2 xl:grid-cols-3">
                @foreach($barangs as $barang)
                    <div class="bg-white rounded-3xl border border-slate-200/80 p-6 shadow-soft hover:shadow-soft-lg transition-all duration-300 flex flex-col justify-between group">
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <span class="px-2.5 py-1 rounded-full bg-blue-50 text-blue-700 text-[10px] font-bold uppercase tracking-wider border border-blue-100">
                                    {{ $barang->kategori->nama_kategori ?? 'Umum' }}
                                </span>
                                <span class="px-2.5 py-1 rounded-full {{ $barang->stok > 0 ? 'bg-emerald-50 text-emerald-700 border border-emerald-100' : 'bg-rose-50 text-rose-700 border border-rose-100' }} text-[10px] font-bold">
                                    {{ $barang->stok > 0 ? 'Stok: '.$barang->stok : 'Stok Habis' }}
                                </span>
                            </div>

                            <div>
                                <p class="text-[11px] font-mono text-slate-600 font-semibold">{{ $barang->kode_barang }}</p>
                                <h3 class="text-base font-bold text-slate-900 mt-0.5 group-hover:text-blue-600 transition-colors">{{ $barang->nama_barang }}</h3>
                                <p class="text-xs text-slate-600 mt-2 line-clamp-2">{{ $barang->deskripsi ?? 'Tidak ada deskripsi barang.' }}</p>
                            </div>
                        </div>

                        <div class="mt-6 pt-4 border-t border-slate-100 flex items-center gap-2">
                            <a href="{{ route('admin.barang.show', $barang) }}" class="flex-1 py-2 text-center bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition-colors">
                                Detail
                            </a>
                            @if(auth()->user()->isAdmin())
                                <a href="{{ route('admin.barang.edit', $barang) }}" class="flex-1 py-2 text-center bg-blue-50 hover:bg-blue-100 text-blue-700 font-bold text-xs rounded-xl transition-colors">
                                    Edit
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $barangs->links() }}
            </div>
        @endif
    </div>
</x-layouts.admin>
