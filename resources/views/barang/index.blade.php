<x-layouts.admin title="Kelola Inventaris Barang">
    <div class="space-y-8">
        
        {{-- Page Header --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-white p-6 md:p-8 rounded-3xl border border-slate-200/80 shadow-soft">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-50 text-blue-700 text-xs font-bold mb-2">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    Katalog Inventaris
                </div>
                <h1 class="text-2xl md:text-3xl font-extrabold text-slate-900 tracking-tight font-display">Kelola Inventaris Barang</h1>
                <p class="text-xs text-slate-500 mt-1">Kelola data seluruh aset, peralatan laboratorium, dan fasilitas inventaris sekolah</p>
            </div>
            
            @if(auth()->user()->isAdmin())
                <a href="{{ route('admin.barang.create') }}" class="inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-2xl bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold text-xs uppercase tracking-wider shadow-lg shadow-blue-600/30 hover:scale-[1.02] active:scale-[0.98] transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                    <span>Tambah Barang Baru</span>
                </a>
            @endif
        </div>

        <x-alert />

        {{-- Statistics Overview Widgets --}}
        @php
            $totalItems = \App\Models\Barang::count();
            $availableItems = \App\Models\Barang::where('stok', '>', 0)->count();
            $outOfStockItems = \App\Models\Barang::where('stok', '<=', 0)->count();
            $totalCategories = $kategoris->count();
        @endphp
        
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            <div class="bg-white rounded-3xl p-5 border border-slate-200/80 shadow-soft flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold flex-shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                </div>
                <div>
                    <p class="text-[10px] font-extrabold uppercase tracking-wider text-slate-400">Total Barang</p>
                    <h3 class="text-2xl font-extrabold text-slate-900 mt-0.5">{{ number_format($totalItems) }}</h3>
                </div>
            </div>

            <div class="bg-white rounded-3xl p-5 border border-slate-200/80 shadow-soft flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold flex-shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <p class="text-[10px] font-extrabold uppercase tracking-wider text-slate-400">Stok Tersedia</p>
                    <h3 class="text-2xl font-extrabold text-slate-900 mt-0.5">{{ number_format($availableItems) }}</h3>
                </div>
            </div>

            <div class="bg-white rounded-3xl p-5 border border-slate-200/80 shadow-soft flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center font-bold flex-shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
                <div>
                    <p class="text-[10px] font-extrabold uppercase tracking-wider text-slate-400">Stok Habis</p>
                    <h3 class="text-2xl font-extrabold text-slate-900 mt-0.5">{{ number_format($outOfStockItems) }}</h3>
                </div>
            </div>

            <div class="bg-white rounded-3xl p-5 border border-slate-200/80 shadow-soft flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold flex-shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                </div>
                <div>
                    <p class="text-[10px] font-extrabold uppercase tracking-wider text-slate-400">Kategori</p>
                    <h3 class="text-2xl font-extrabold text-slate-900 mt-0.5">{{ number_format($totalCategories) }}</h3>
                </div>
            </div>
        </div>

        {{-- Filter & Search Bar --}}
        <form method="GET" action="{{ route('admin.barang.index') }}" class="bg-white p-5 rounded-3xl border border-slate-200/80 shadow-soft grid gap-4 md:grid-cols-12 items-end">
            <div class="md:col-span-4">
                <label for="search" class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Pencarian Barang</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                    <input id="search" name="search" type="text" value="{{ request('search') }}" placeholder="Cari nama atau kode barang..."
                           class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all" />
                </div>
            </div>

            <div class="md:col-span-3">
                <label for="kategori_id" class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Kategori</label>
                <select id="kategori_id" name="kategori_id" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all">
                    <option value="">Semua Kategori</option>
                    @foreach($kategoris as $kategori)
                        <option value="{{ $kategori->id }}" @selected(request('kategori_id') == $kategori->id)>{{ $kategori->nama_kategori }}</option>
                    @endforeach
                </select>
            </div>

            <div class="md:col-span-3">
                <label for="ketersediaan" class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Status Stok</label>
                <select id="ketersediaan" name="ketersediaan" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all">
                    <option value="">Semua Status Stok</option>
                    <option value="tersedia" @selected(request('ketersediaan') === 'tersedia')>Tersedia (>0)</option>
                    <option value="habis" @selected(request('ketersediaan') === 'habis')>Stok Habis (0)</option>
                </select>
            </div>

            <div class="md:col-span-2 flex items-center gap-2">
                <button type="submit" class="flex-1 py-2.5 px-4 bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs rounded-2xl shadow-md transition-colors">
                    Filter
                </button>
                @if(request()->anyFilled(['search', 'kategori_id', 'ketersediaan']))
                    <a href="{{ route('admin.barang.index') }}" class="py-2.5 px-3 bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold text-xs rounded-2xl transition-colors" title="Reset Filter">
                        Reset
                    </a>
                @endif
            </div>
        </form>

        {{-- Inventory Items Grid --}}
        @if($barangs->isEmpty())
            <div class="bg-white rounded-3xl border border-dashed border-slate-300 p-12 text-center shadow-soft">
                <div class="w-16 h-16 rounded-2xl bg-blue-50 text-blue-500 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                </div>
                <h3 class="text-base font-extrabold text-slate-900">Belum Ada Barang Ditemukan</h3>
                <p class="text-xs text-slate-500 mt-1 max-w-sm mx-auto">Tidak ada barang inventaris yang sesuai dengan filter pencarian Anda.</p>
                @if(request()->anyFilled(['search', 'kategori_id', 'ketersediaan']))
                    <a href="{{ route('admin.barang.index') }}" class="inline-flex items-center gap-2 mt-4 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition-colors">
                        Bersihkan Filter
                    </a>
                @endif
            </div>
        @else
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                @foreach($barangs as $barang)
                    <div class="bg-white rounded-3xl border border-slate-200/80 p-5 shadow-soft hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between group">
                        
                        <div class="space-y-3">
                            {{-- Image Showcase --}}
                            <div class="relative rounded-2xl overflow-hidden bg-slate-100 aspect-[4/3] border border-slate-100">
                                <img src="{{ $barang->fotoUrl() }}" alt="{{ $barang->nama_barang }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
                                
                                {{-- Kategori Tag --}}
                                <div class="absolute top-2.5 left-2.5">
                                    <span class="px-2.5 py-1 rounded-xl bg-white/90 backdrop-blur-md text-blue-700 text-[10px] font-bold shadow-sm border border-white/40">
                                        {{ $barang->kategori->nama_kategori ?? 'Umum' }}
                                    </span>
                                </div>

                                {{-- Stok Tag --}}
                                <div class="absolute top-2.5 right-2.5">
                                    <span class="px-2.5 py-1 rounded-xl {{ $barang->stok > 0 ? 'bg-emerald-500/90 text-white' : 'bg-rose-500/90 text-white' }} backdrop-blur-md text-[10px] font-extrabold shadow-sm">
                                        {{ $barang->stok > 0 ? 'Stok: '.$barang->stok : 'Stok Habis' }}
                                    </span>
                                </div>
                            </div>

                            {{-- Product Meta --}}
                            <div>
                                <div class="flex items-center justify-between gap-2">
                                    <span class="px-2 py-0.5 rounded-lg bg-slate-100 text-slate-600 font-mono text-[10px] font-bold">
                                        {{ $barang->kode_barang }}
                                    </span>
                                    <span class="text-[10px] font-semibold text-slate-400 capitalize">
                                        Kondisi: {{ $barang->kondisi->label() }}
                                    </span>
                                </div>

                                <h3 class="text-sm font-extrabold text-slate-900 mt-2 group-hover:text-blue-600 transition-colors line-clamp-1">
                                    {{ $barang->nama_barang }}
                                </h3>
                                <p class="text-xs text-slate-500 mt-1 line-clamp-2 leading-relaxed">
                                    {{ $barang->deskripsi ?: 'Tidak ada deskripsi barang.' }}
                                </p>
                            </div>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="mt-5 pt-3 border-t border-slate-100 flex items-center gap-2">
                            <a href="{{ route('admin.barang.show', $barang) }}" class="flex-1 py-2 text-center bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition-colors">
                                Detail
                            </a>
                            @if(auth()->user()->isAdmin())
                                <a href="{{ route('admin.barang.edit', $barang) }}" class="flex-1 py-2 text-center bg-blue-50 hover:bg-blue-100 text-blue-700 font-bold text-xs rounded-xl transition-colors">
                                    Edit
                                </a>
                                <form method="POST" action="{{ route('admin.barang.destroy', $barang) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus {{ $barang->nama_barang }}?')" class="flex-shrink-0">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 bg-rose-50 hover:bg-rose-100 text-rose-600 rounded-xl transition-colors" title="Hapus Barang">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-8">
                {{ $barangs->links() }}
            </div>
        @endif
    </div>
</x-layouts.admin>
