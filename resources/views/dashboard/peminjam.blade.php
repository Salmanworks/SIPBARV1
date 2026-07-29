@extends('layouts.guest')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 pt-24 pb-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="space-y-7">

                {{-- Welcome Banner --}}
                <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-blue-500 via-indigo-500 to-violet-600 p-8 md:p-10 text-white shadow-xl shadow-blue-500/25">
                    <div class="absolute -right-16 -top-16 w-64 h-64 bg-white/10 rounded-full blur-2xl pointer-events-none"></div>
                    <div class="absolute left-1/3 -bottom-12 w-48 h-48 bg-indigo-400/20 rounded-full blur-2xl pointer-events-none"></div>
                    <div class="absolute -left-8 bottom-0 w-40 h-40 bg-blue-400/20 rounded-full blur-2xl pointer-events-none"></div>
                    <div class="relative z-10 flex flex-col sm:flex-row sm:items-center justify-between gap-5">
                        <div class="space-y-2">
                            <span class="inline-block px-3 py-1 rounded-full bg-white/15 border border-white/25 text-[10px] font-bold tracking-widest uppercase">Portal Peminjam</span>
                            <h1 class="text-2xl md:text-3xl font-extrabold tracking-tight inline-flex items-center gap-2">
                                Halo, {{ auth()->user()->name }}!
                                <svg class="w-6 h-6 text-amber-300" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.25a.75.75 0 01.75.75v2.25a.75.75 0 01-1.5 0V3a.75.75 0 01.75-.75zM7.5 12a4.5 4.5 0 119 0 4.5 4.5 0 01-9 0zM18.894 6.166a.75.75 0 00-1.06-1.06l-1.591 1.59a.75.75 0 101.06 1.061l1.591-1.59zM21.75 12a.75.75 0 01-.75.75h-2.25a.75.75 0 010-1.5H21a.75.75 0 01.75.75zM17.834 18.894a.75.75 0 001.06-1.06l-1.59-1.591a.75.75 0 10-1.061 1.06l1.59 1.591zM12 18a.75.75 0 01.75.75V21a.75.75 0 01-1.5 0v-2.25A.75.75 0 0112 18zM7.758 17.303a.75.75 0 00-1.061-1.06l-1.591 1.59a.75.75 0 001.06 1.061l1.591-1.59zM6 12a.75.75 0 01-.75.75H3a.75.75 0 010-1.5h2.25A.75.75 0 016 12zM6.697 7.757a.75.75 0 001.06-1.06l-1.59-1.591a.75.75 0 00-1.061 1.06l1.59 1.591z"/></svg>
                            </h1>
                            <p class="text-white/75 text-xs max-w-lg leading-relaxed">Kelola pengajuan peminjaman barang dan pantau jadwal pengembalian Anda secara real-time.</p>
                        </div>
                        <a href="{{ route('peminjaman.create') }}" class="flex-shrink-0 inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-2xl bg-white text-blue-700 font-extrabold text-xs uppercase tracking-wider shadow-lg hover:bg-blue-50 hover:scale-105 transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            Ajukan Peminjaman
                        </a>
                    </div>
                </div>

                <x-alert />

                @if(($stats['terlambat'] ?? 0) > 0)
                    <div class="p-5 rounded-2xl bg-rose-50 border border-rose-200 flex items-center gap-4 shadow-sm">
                        <div class="w-11 h-11 rounded-2xl bg-rose-500 text-white flex items-center justify-center flex-shrink-0 font-extrabold text-sm shadow-md">!</div>
                        <div>
                            <h3 class="font-bold text-rose-900 text-sm">Peringatan Keterlambatan</h3>
                            <p class="text-xs text-rose-700 mt-0.5">Anda memiliki <strong class="text-rose-900">{{ $stats['terlambat'] }} peminjaman barang</strong> yang melewati batas waktu pengembalian. Segera kembalikan ke petugas gudang.</p>
                        </div>
                    </div>
                @endif

                {{-- Stat Cards --}}
                <div class="grid gap-5 sm:grid-cols-2 xl:grid-cols-4">
                    <div class="relative bg-white p-6 rounded-3xl border border-slate-100 shadow-sm hover:shadow-lg hover:-translate-y-0.5 transition-all overflow-hidden group">
                        <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-slate-100 to-slate-50 rounded-full blur-xl -translate-y-8 translate-x-8 group-hover:scale-125 transition-transform"></div>
                        <div class="relative z-10">
                            <div class="flex items-center justify-between mb-4">
                                <div class="w-10 h-10 rounded-2xl bg-slate-100 flex items-center justify-center">
                                    <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                </div>
                            </div>
                            <h3 class="text-4xl font-black text-slate-900">{{ number_format($stats['total_pengajuan'] ?? 0) }}</h3>
                            <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mt-1">Total Pengajuan</p>
                            <p class="text-[11px] text-slate-400 mt-1">Seluruh Riwayat Permohonan</p>
                        </div>
                    </div>
                    <div class="relative bg-white p-6 rounded-3xl border border-amber-100 shadow-sm hover:shadow-lg hover:shadow-amber-500/10 hover:-translate-y-0.5 transition-all overflow-hidden group">
                        <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-amber-100 to-amber-50 rounded-full blur-xl -translate-y-8 translate-x-8 group-hover:scale-125 transition-transform"></div>
                        <div class="relative z-10">
                            <div class="flex items-center justify-between mb-4">
                                <div class="w-10 h-10 rounded-2xl bg-amber-100 flex items-center justify-center">
                                    <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </div>
                            </div>
                            <h3 class="text-4xl font-black text-amber-700">{{ number_format($stats['menunggu'] ?? 0) }}</h3>
                            <p class="text-xs font-bold text-amber-600 uppercase tracking-wider mt-1">Menunggu Review</p>
                            <p class="text-[11px] text-amber-600/60 mt-1">Antrean Persetujuan Admin</p>
                        </div>
                    </div>
                    <div class="relative bg-white p-6 rounded-3xl border border-blue-100 shadow-sm hover:shadow-lg hover:shadow-blue-500/10 hover:-translate-y-0.5 transition-all overflow-hidden group">
                        <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-blue-100 to-blue-50 rounded-full blur-xl -translate-y-8 translate-x-8 group-hover:scale-125 transition-transform"></div>
                        <div class="relative z-10">
                            <div class="flex items-center justify-between mb-4">
                                <div class="w-10 h-10 rounded-2xl bg-blue-100 flex items-center justify-center">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                                </div>
                            </div>
                            <h3 class="text-4xl font-black text-blue-700">{{ number_format($stats['aktif'] ?? 0) }}</h3>
                            <p class="text-xs font-bold text-blue-600 uppercase tracking-wider mt-1">Peminjaman Aktif</p>
                            <p class="text-[11px] text-blue-600/60 mt-1">Barang Sedang Anda Pakai</p>
                        </div>
                    </div>
                    <div class="relative bg-white p-6 rounded-3xl border border-rose-100 shadow-sm hover:shadow-lg hover:shadow-rose-500/10 hover:-translate-y-0.5 transition-all overflow-hidden group">
                        <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-rose-100 to-rose-50 rounded-full blur-xl -translate-y-8 translate-x-8 group-hover:scale-125 transition-transform"></div>
                        <div class="relative z-10">
                            <div class="flex items-center justify-between mb-4">
                                <div class="w-10 h-10 rounded-2xl bg-rose-100 flex items-center justify-center">
                                    <svg class="w-5 h-5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                                </div>
                            </div>
                            <h3 class="text-4xl font-black text-rose-700">{{ number_format($stats['terlambat'] ?? 0) }}</h3>
                            <p class="text-xs font-bold text-rose-600 uppercase tracking-wider mt-1">Terlambat</p>
                            <p class="text-[11px] text-rose-600/60 mt-1">Perlu Segera Dikembalikan</p>
                        </div>
                    </div>
                </div>

                {{-- Recent Activity --}}
                <div class="bg-white rounded-3xl border border-slate-200/70 shadow-sm overflow-hidden">
                    <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                        <div>
                            <h2 class="text-base font-extrabold text-slate-900">Riwayat Pengajuan Terbaru</h2>
                            <p class="text-xs text-slate-400 mt-0.5">5 peminjaman terakhir yang Anda ajukan</p>
                        </div>
                        <a href="{{ route('peminjaman.index') }}" class="text-xs font-bold text-blue-600 hover:text-blue-800 bg-blue-50 hover:bg-blue-100 px-3 py-1.5 rounded-xl transition-all">Lihat Semua</a>
                    </div>

                    @if($recent->isEmpty())
                        <div class="p-14 text-center">
                            <div class="w-16 h-16 rounded-3xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            </div>
                            <p class="font-bold text-slate-800 text-sm">Belum Ada Pengajuan</p>
                            <p class="text-xs text-slate-500 mt-1">Klik tombol "Ajukan Peminjaman" untuk membuat permohonan baru.</p>
                            <a href="{{ route('peminjaman.create') }}" class="inline-flex items-center gap-2 mt-4 px-5 py-2.5 rounded-2xl bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold text-xs shadow-md hover:scale-105 transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                Ajukan Sekarang
                            </a>
                        </div>
                    @else
                        <div class="divide-y divide-slate-100">
                            @foreach($recent as $item)
                                <div class="p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4 hover:bg-blue-50/30 transition-colors group">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 rounded-2xl bg-blue-100 text-blue-700 flex items-center justify-center flex-shrink-0">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                        </div>
                                        <div>
                                            <h3 class="font-bold text-slate-900 text-sm">{{ $item->keperluan }}</h3>
                                            <p class="text-xs text-slate-500 font-medium mt-0.5">
                                                {{ $item->tanggal_pinjam->format('d M Y') }}
                                                @if($item->tanggal_kembali_rencana)
                                                — {{ $item->tanggal_kembali_rencana->format('d M Y') }}
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <x-status-peminjaman :status="$item->status" />
                                        <a href="{{ route('peminjaman.show', $item) }}" class="px-3 py-1.5 bg-slate-100 hover:bg-blue-100 hover:text-blue-700 text-slate-700 font-bold text-xs rounded-xl transition-all">Detail</a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
