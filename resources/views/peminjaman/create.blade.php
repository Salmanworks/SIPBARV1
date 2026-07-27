@extends('layouts.guest')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 pt-24 pb-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="space-y-7">

            {{-- Header Banner --}}
            <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-blue-500 via-indigo-500 to-violet-600 p-8 md:p-10 text-white shadow-xl shadow-blue-500/25">
                <div class="absolute -right-16 -top-16 w-64 h-64 bg-white/10 rounded-full blur-2xl pointer-events-none"></div>
                <div class="absolute left-1/3 -bottom-12 w-48 h-48 bg-indigo-400/20 rounded-full blur-2xl pointer-events-none"></div>
                <div class="absolute -left-8 bottom-0 w-40 h-40 bg-blue-400/20 rounded-full blur-2xl pointer-events-none"></div>
                <div class="relative z-10 flex flex-col sm:flex-row sm:items-center justify-between gap-5">
                    <div class="space-y-2">
                        <span class="inline-block px-3 py-1 rounded-full bg-white/15 border border-white/25 text-[10px] font-bold tracking-widest uppercase">Buat Pengajuan</span>
                        <h1 class="text-2xl md:text-3xl font-extrabold tracking-tight">Ajukan Peminjaman Baru</h1>
                        <p class="text-white/75 text-xs max-w-lg leading-relaxed">Isi formulir di bawah ini untuk mengajukan peminjaman barang. Pengajuan Anda akan direview oleh admin.</p>
                    </div>
                </div>
            </div>

            <x-alert />

            {{-- Filter Section --}}
            <div class="bg-white rounded-3xl border border-slate-200/70 shadow-sm overflow-hidden">
                <div class="p-6">
                    <h2 class="text-base font-extrabold text-slate-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                        </svg>
                        Cari & Filter Barang
                    </h2>
                    <form method="GET" action="{{ route('peminjam.pengajuan.create') }}" class="flex flex-wrap gap-3">
                        <input type="text" name="search" placeholder="Cari barang..." value="{{ request('search') }}" class="flex-1 min-w-[200px] px-4 py-2.5 rounded-2xl border border-slate-200 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none transition-all" />
                        <select name="kategori_id" class="px-4 py-2.5 rounded-2xl border border-slate-200 text-sm font-medium focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none transition-all bg-white">
                            <option value="">Semua Kategori</option>
                            @foreach($kategoris as $kategori)
                                <option value="{{ $kategori->id }}" {{ request('kategori_id') == $kategori->id ? 'selected' : '' }}>{{ $kategori->nama_kategori }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="px-6 py-2.5 rounded-2xl bg-blue-600 text-white font-bold text-sm hover:bg-blue-700 hover:scale-105 transition-all shadow-md">Filter</button>
                    </form>
                </div>
            </div>


            {{-- Main Form --}}
            <form method="POST" action="{{ route('peminjam.pengajuan.store') }}" class="space-y-6">
                @csrf
                
                {{-- Detail Peminjaman Card --}}
                <div class="bg-white rounded-3xl border border-slate-200/70 shadow-sm overflow-hidden">
                    <div class="p-6 border-b border-slate-100">
                        <h2 class="text-base font-extrabold text-slate-900 flex items-center gap-2">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Detail Peminjaman
                        </h2>
                    </div>
                    <div class="p-6 bg-gradient-to-b from-slate-50 to-white">
                        <div class="grid gap-5 md:grid-cols-2">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Tanggal Pinjam</label>
                                <input type="date" name="tanggal_pinjam" value="{{ old('tanggal_pinjam', today()->format('Y-m-d')) }}" required class="w-full px-4 py-3 rounded-2xl border border-slate-200 text-sm font-medium focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none transition-all bg-white" />
                                @error('tanggal_pinjam')
                                    <p class="text-xs text-rose-600 mt-1 font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Tanggal Kembali</label>
                                <input type="date" name="tanggal_kembali_rencana" value="{{ old('tanggal_kembali_rencana') }}" required class="w-full px-4 py-3 rounded-2xl border border-slate-200 text-sm font-medium focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none transition-all bg-white" />
                                @error('tanggal_kembali_rencana')
                                    <p class="text-xs text-rose-600 mt-1 font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Keperluan</label>
                                <textarea name="keperluan" rows="3" required placeholder="Jelaskan keperluan peminjaman barang..." class="w-full px-4 py-3 rounded-2xl border border-slate-200 text-sm resize-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none transition-all bg-white">{{ old('keperluan') }}</textarea>
                                @error('keperluan')
                                    <p class="text-xs text-rose-600 mt-1 font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>


                {{-- Pilih Barang Card --}}
                <div class="bg-white rounded-3xl border border-slate-200/70 shadow-sm overflow-hidden">
                    <div class="p-6 border-b border-slate-100">
                        <h2 class="text-base font-extrabold text-slate-900 flex items-center gap-2">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                            Pilih Barang yang Akan Dipinjam
                        </h2>
                        <p class="text-xs text-slate-400 mt-0.5">Centang barang yang ingin Anda pinjam</p>
                    </div>
                    
                    @if($barangs->isEmpty())
                        <div class="p-14 text-center bg-gradient-to-b from-slate-50 to-white">
                            <div class="w-16 h-16 rounded-3xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                </svg>
                            </div>
                            <p class="font-bold text-slate-800 text-sm">Tidak Ada Barang Tersedia</p>
                            <p class="text-xs text-slate-500 mt-1">Coba ubah filter pencarian Anda.</p>
                        </div>
                    @else
                        <div class="p-6 bg-gradient-to-b from-slate-50 to-white">
                            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                                @foreach($barangs as $barang)
                                    <div class="relative p-5 rounded-2xl border-2 border-slate-200 bg-white transition-all hover:border-blue-300 hover:-translate-y-0.5 hover:shadow-md">
                                        <label class="flex items-start gap-3 cursor-pointer">
                                            <input type="checkbox" name="barang_id[]" value="{{ $barang->id }}" {{ in_array($barang->id, old('barang_id', [])) ? 'checked' : '' }} class="mt-1 w-5 h-5 rounded border-slate-300 text-blue-600 focus:ring-2 focus:ring-blue-200" />
                                            <div class="flex-1">
                                                <h3 class="font-bold text-slate-900 text-sm pr-6 mb-1">{{ $barang->nama_barang }}</h3>
                                                <p class="text-xs text-slate-600 font-medium mb-2">{{ $barang->kode_barang }}</p>
                                                <div class="flex items-center gap-2 mb-3">
                                                    <span class="px-2 py-1 rounded-lg bg-emerald-100 text-emerald-700 text-[10px] font-bold">Stok: {{ $barang->stok }}</span>
                                                </div>
                                                <div>
                                                    <label class="block text-[10px] font-bold text-slate-700 uppercase tracking-wider mb-1.5">Jumlah</label>
                                                    <input type="number" name="jumlah[{{ $barang->id }}]" min="1" max="{{ $barang->stok }}" value="{{ old('jumlah.'.$barang->id, 1) }}" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-sm font-bold text-center focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none transition-all bg-white" />
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            
                            <div class="mt-6">
                                {{ $barangs->links() }}
                            </div>
                        </div>
                    @endif
                </div>


                {{-- Action Buttons --}}
                <div class="flex flex-col sm:flex-row gap-3 justify-end">
                    <a href="{{ route('peminjam.dashboard') }}" class="inline-flex items-center justify-center gap-2.5 px-8 py-4 rounded-2xl bg-white text-slate-700 font-bold text-sm border border-slate-200 shadow-sm hover:bg-slate-50 hover:scale-105 transition-all duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Batal
                    </a>
                    <button type="submit" class="inline-flex items-center justify-center gap-2.5 px-8 py-4 rounded-2xl bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-extrabold text-sm shadow-xl shadow-blue-500/30 hover:shadow-2xl hover:shadow-blue-500/45 hover:scale-105 transition-all duration-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                        </svg>
                        Kirim Pengajuan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
