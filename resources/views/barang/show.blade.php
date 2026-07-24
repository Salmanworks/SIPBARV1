<x-layouts.admin title="{{ $barang->nama_barang }} — Detail Barang">
    <div class="max-w-4xl mx-auto space-y-6">
        
        {{-- Page Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 md:p-8 rounded-3xl border border-slate-200/80 shadow-soft">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.barang.index') }}" class="w-10 h-10 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-600 flex items-center justify-center transition-colors flex-shrink-0" title="Kembali">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                </a>
                <div>
                    <div class="flex items-center gap-2">
                        <span class="px-2.5 py-0.5 rounded-full bg-blue-50 text-blue-700 text-[10px] font-bold uppercase tracking-wider border border-blue-100">
                            {{ $barang->kategori->nama_kategori ?? 'Umum' }}
                        </span>
                        <span class="text-xs font-mono text-slate-600 font-semibold">{{ $barang->kode_barang }}</span>
                    </div>
                    <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight font-display mt-0.5">{{ $barang->nama_barang }}</h1>
                </div>
            </div>

            @if(auth()->user()->isAdmin())
                <div class="flex items-center gap-2">
                    <a href="{{ route('admin.barang.edit', $barang) }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-2xl bg-blue-50 hover:bg-blue-100 text-blue-700 font-bold text-xs transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        Edit Barang
                    </a>
                    <form method="POST" action="{{ route('admin.barang.destroy', $barang) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus barang ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-2xl bg-rose-50 hover:bg-rose-100 text-rose-700 font-bold text-xs transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            Hapus
                        </button>
                    </form>
                </div>
            @endif
        </div>

        <x-alert />

        {{-- Product Details Grid --}}
        <div class="grid gap-6 lg:grid-cols-12 items-start">
            
            {{-- Photo Card --}}
            <div class="lg:col-span-5 bg-white rounded-3xl border border-slate-200/80 p-5 shadow-soft space-y-4">
                <div class="relative rounded-2xl overflow-hidden bg-slate-100 border border-slate-100 aspect-square group">
                    <img src="{{ $barang->fotoUrl() }}" alt="{{ $barang->nama_barang }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
                    
                    <div class="absolute top-3 left-3 flex flex-col gap-2">
                        @if($barang->isTersedia())
                            <span class="px-3 py-1 rounded-full bg-emerald-500/90 backdrop-blur-md text-white text-xs font-bold shadow-md">
                                Tersedia
                            </span>
                        @else
                            <span class="px-3 py-1 rounded-full bg-rose-500/90 backdrop-blur-md text-white text-xs font-bold shadow-md">
                                Stok Habis
                            </span>
                        @endif
                    </div>

                    <div class="absolute bottom-3 right-3">
                        <span class="px-3 py-1 rounded-full bg-slate-900/80 backdrop-blur-md text-white text-xs font-bold capitalize">
                            Kondisi: {{ $barang->kondisi->label() }}
                        </span>
                    </div>
                </div>

                <div class="p-3 rounded-2xl bg-slate-50 border border-slate-100 flex items-center justify-between text-xs">
                    <span class="text-slate-500 font-medium">Status Penggunaan</span>
                    <span class="font-bold text-slate-900">
                        {{ $barang->stok > 0 ? 'Dapat Dipinjam' : 'Tidak Dapat Dipinjam' }}
                    </span>
                </div>
            </div>

            {{-- Specifications Card --}}
            <div class="lg:col-span-7 bg-white rounded-3xl border border-slate-200/80 p-6 md:p-8 shadow-soft space-y-6">
                <div>
                    <h2 class="text-base font-extrabold text-slate-900 border-b border-slate-100 pb-3 flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        Informasi Spesifikasi & Inventaris
                    </h2>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100">
                        <p class="text-[10px] font-extrabold uppercase tracking-wider text-slate-500">Kode Barang</p>
                        <p class="text-sm font-mono font-bold text-slate-900 mt-1">{{ $barang->kode_barang }}</p>
                    </div>

                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100">
                        <p class="text-[10px] font-extrabold uppercase tracking-wider text-slate-500">Kategori</p>
                        <p class="text-sm font-bold text-blue-700 mt-1">{{ $barang->kategori->nama_kategori ?? 'Umum' }}</p>
                    </div>

                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100">
                        <p class="text-[10px] font-extrabold uppercase tracking-wider text-slate-500">Jumlah Stok</p>
                        <p class="text-2xl font-extrabold text-slate-900 mt-0.5">{{ $barang->stok }} <span class="text-xs font-normal text-slate-500">unit</span></p>
                    </div>

                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100">
                        <p class="text-[10px] font-extrabold uppercase tracking-wider text-slate-500">Kondisi Fisik</p>
                        <div class="mt-1.5">
                            @if($barang->kondisi->value === 'baik')
                                <span class="px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-800 text-xs font-bold inline-flex items-center gap-1">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                    Baik (Normal)
                                </span>
                            @else
                                <span class="px-2.5 py-1 rounded-full bg-rose-100 text-rose-800 text-xs font-bold inline-flex items-center gap-1">
                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                    Rusak
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Deskripsi --}}
                <div class="space-y-2">
                    <p class="text-[10px] font-extrabold uppercase tracking-wider text-slate-500">Deskripsi / Catatan Barang</p>
                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100 text-xs text-slate-700 leading-relaxed min-h-[100px]">
                        {{ $barang->deskripsi ?: 'Tidak ada catatan atau deskripsi tambahan untuk barang ini.' }}
                    </div>
                </div>

                {{-- Metadata --}}
                <div class="pt-4 border-t border-slate-100 flex flex-wrap items-center justify-between text-[11px] text-slate-500 gap-2">
                    <div>Ditambahkan: <strong>{{ $barang->created_at ? $barang->created_at->translatedFormat('d F Y, H:i') : '-' }}</strong></div>
                    <div>Diperbarui: <strong>{{ $barang->updated_at ? $barang->updated_at->translatedFormat('d F Y, H:i') : '-' }}</strong></div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.admin>
