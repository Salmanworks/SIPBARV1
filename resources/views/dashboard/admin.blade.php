<x-layouts::app :title="__('Dashboard Admin')">
    <div class="space-y-6">
        {{-- Welcome Header --}}
        <div class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-2xl p-8 text-white shadow-xl">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold mb-2">Selamat Datang, {{ auth()->user()->name }}</h1>
                    <p class="text-blue-100 text-lg">Dashboard Administrator SIPBAR</p>
                </div>
                <div class="hidden md:flex items-center justify-center w-20 h-20 bg-white/20 rounded-2xl backdrop-blur-sm">
                    <x-icon name="shield-check" size="3xl" class="text-white" />
                </div>
            </div>
        </div>

        <x-alert />

        {{-- Alerts --}}
        @if($stats['menunggu_approval'] > 0 || $stats['terlambat'] > 0)
            <div class="grid gap-4 md:grid-cols-2">
                @if($stats['menunggu_approval'] > 0)
                <div class="bg-amber-50 border-l-4 border-amber-500 rounded-xl p-4">
                    <div class="flex items-start gap-3">
                        <div class="flex items-center justify-center w-10 h-10 bg-amber-100 rounded-lg flex-shrink-0">
                            <x-icon name="bell" size="lg" class="text-amber-600" />
                        </div>
                        <div>
                            <h3 class="font-semibold text-amber-900 mb-1">Perlu Persetujuan</h3>
                            <p class="text-amber-700 text-sm">
                                <span class="font-bold">{{ $stats['menunggu_approval'] }} pengajuan</span> menunggu persetujuan Anda
                            </p>
                            <a href="{{ route('admin.peminjaman.index') }}" class="inline-flex items-center gap-1 text-sm text-amber-700 hover:text-amber-800 font-medium mt-2">
                                <span>Lihat Pengajuan</span>
                                <x-icon name="arrow-right" size="sm" />
                            </a>
                        </div>
                    </div>
                </div>
                @endif
                
                @if($stats['terlambat'] > 0)
                <div class="bg-rose-50 border-l-4 border-rose-500 rounded-xl p-4">
                    <div class="flex items-start gap-3">
                        <div class="flex items-center justify-center w-10 h-10 bg-rose-100 rounded-lg flex-shrink-0">
                            <x-icon name="clock" size="lg" class="text-rose-600" />
                        </div>
                        <div>
                            <h3 class="font-semibold text-rose-900 mb-1">Peminjaman Terlambat</h3>
                            <p class="text-rose-700 text-sm">
                                <span class="font-bold">{{ $stats['terlambat'] }} peminjaman</span> melewati batas waktu
                            </p>
                            <a href="{{ route('admin.peminjaman.index') }}" class="inline-flex items-center gap-1 text-sm text-rose-700 hover:text-rose-800 font-medium mt-2">
                                <span>Lihat Detail</span>
                                <x-icon name="arrow-right" size="sm" />
                            </a>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        @endif

        {{-- Stats Cards --}}
        <div class="grid gap-6 sm:grid-cols-2 xl:grid-cols-4">
            {{-- Total Barang --}}
            <div class="bg-white rounded-2xl border border-slate-200 p-6 hover:shadow-xl transition-shadow duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center justify-center w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl">
                        <x-icon name="cube" size="lg" class="text-white" />
                    </div>
                    <span class="text-xs font-semibold text-blue-600 bg-blue-50 px-3 py-1 rounded-full">Inventaris</span>
                </div>
                <div>
                    <p class="text-sm font-medium text-slate-600 mb-1">Total Barang</p>
                    <p class="text-3xl font-bold text-slate-900">{{ number_format($stats['total_barang']) }}</p>
                </div>
                <div class="mt-4 pt-4 border-t border-slate-100">
                    <a href="{{ route('admin.barang.index') }}" class="text-sm text-blue-600 hover:text-blue-700 font-medium inline-flex items-center gap-1">
                        <span>Kelola Barang</span>
                        <x-icon name="arrow-right" size="sm" />
                    </a>
                </div>
            </div>

            {{-- Sedang Dipinjam --}}
            <div class="bg-white rounded-2xl border border-slate-200 p-6 hover:shadow-xl transition-shadow duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center justify-center w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl">
                        <x-icon name="refresh" size="lg" class="text-white" />
                    </div>
                    <span class="text-xs font-semibold text-purple-600 bg-purple-50 px-3 py-1 rounded-full">Aktif</span>
                </div>
                <div>
                    <p class="text-sm font-medium text-slate-600 mb-1">Sedang Dipinjam</p>
                    <p class="text-3xl font-bold text-slate-900">{{ number_format($stats['sedang_dipinjam']) }}</p>
                </div>
                <div class="mt-4 pt-4 border-t border-slate-100">
                    <a href="{{ route('admin.peminjaman.index') }}" class="text-sm text-purple-600 hover:text-purple-700 font-medium inline-flex items-center gap-1">
                        <span>Lihat Detail</span>
                        <x-icon name="arrow-right" size="sm" />
                    </a>
                </div>
            </div>

            {{-- Terlambat --}}
            <div class="bg-white rounded-2xl border border-slate-200 p-6 hover:shadow-xl transition-shadow duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center justify-center w-12 h-12 bg-gradient-to-br from-rose-500 to-rose-600 rounded-xl">
                        <x-icon name="clock" size="lg" class="text-white" />
                    </div>
                    <span class="text-xs font-semibold text-rose-600 bg-rose-50 px-3 py-1 rounded-full">Urgent</span>
                </div>
                <div>
                    <p class="text-sm font-medium text-slate-600 mb-1">Terlambat</p>
                    <p class="text-3xl font-bold text-slate-900">{{ number_format($stats['terlambat']) }}</p>
                </div>
                <div class="mt-4 pt-4 border-t border-slate-100">
                    <a href="{{ route('admin.peminjaman.index') }}" class="text-sm text-rose-600 hover:text-rose-700 font-medium inline-flex items-center gap-1">
                        <span>Tindak Lanjut</span>
                        <x-icon name="arrow-right" size="sm" />
                    </a>
                </div>
            </div>

            {{-- Menunggu Approval --}}
            <div class="bg-white rounded-2xl border border-slate-200 p-6 hover:shadow-xl transition-shadow duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center justify-center w-12 h-12 bg-gradient-to-br from-amber-500 to-amber-600 rounded-xl">
                        <x-icon name="bell" size="lg" class="text-white" />
                    </div>
                    <span class="text-xs font-semibold text-amber-600 bg-amber-50 px-3 py-1 rounded-full">Pending</span>
                </div>
                <div>
                    <p class="text-sm font-medium text-slate-600 mb-1">Menunggu Approval</p>
                    <p class="text-3xl font-bold text-slate-900">{{ number_format($stats['menunggu_approval']) }}</p>
                </div>
                <div class="mt-4 pt-4 border-t border-slate-100">
                    <a href="{{ route('admin.peminjaman.index') }}" class="text-sm text-amber-600 hover:text-amber-700 font-medium inline-flex items-center gap-1">
                        <span>Review Sekarang</span>
                        <x-icon name="arrow-right" size="sm" />
                    </a>
                </div>
            </div>
        </div>

        {{-- Additional Stats Row --}}
        <div class="grid gap-6 md:grid-cols-3">
            <div class="bg-white rounded-2xl border border-slate-200 p-6">
                <div class="flex items-center gap-4">
                    <div class="flex items-center justify-center w-14 h-14 bg-emerald-100 rounded-xl">
                        <x-icon name="tag" size="xl" class="text-emerald-600" />
                    </div>
                    <div>
                        <p class="text-sm font-medium text-slate-600">Total Kategori</p>
                        <p class="text-2xl font-bold text-slate-900">{{ number_format($stats['total_kategori']) }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-slate-200 p-6">
                <div class="flex items-center gap-4">
                    <div class="flex items-center justify-center w-14 h-14 bg-cyan-100 rounded-xl">
                        <x-icon name="users" size="xl" class="text-cyan-600" />
                    </div>
                    <div>
                        <p class="text-sm font-medium text-slate-600">Total Pengguna</p>
                        <p class="text-2xl font-bold text-slate-900">{{ number_format($stats['total_user']) }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-slate-200 p-6">
                <div class="flex items-center gap-4">
                    <div class="flex items-center justify-center w-14 h-14 bg-indigo-100 rounded-xl">
                        <x-icon name="document-text" size="xl" class="text-indigo-600" />
                    </div>
                    <div>
                        <p class="text-sm font-medium text-slate-600">Total Peminjaman</p>
                        <p class="text-2xl font-bold text-slate-900">{{ number_format($stats['total_peminjaman']) }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Recent Peminjaman Table --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm">
            <div class="p-6 border-b border-slate-200">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-xl font-bold text-slate-900">Peminjaman Terbaru</h2>
                        <p class="text-sm text-slate-600 mt-1">5 transaksi peminjaman terakhir</p>
                    </div>
                    <a href="{{ route('admin.peminjaman.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-medium rounded-xl transition-colors">
                        <span>Lihat Semua</span>
                        <x-icon name="arrow-right" size="sm" />
                    </a>
                </div>
            </div>
            
            @if($recentPeminjamans->isEmpty())
                <div class="p-12 text-center">
                    <div class="flex justify-center mb-4">
                        <div class="flex items-center justify-center w-16 h-16 bg-slate-100 rounded-2xl">
                            <x-icon name="document-text" size="2xl" class="text-slate-400" />
                        </div>
                    </div>
                    <p class="text-slate-500 font-medium">Belum ada data peminjaman</p>
                    <p class="text-sm text-slate-400 mt-1">Peminjaman baru akan muncul di sini</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead>
                            <tr class="border-b border-slate-200 bg-slate-50">
                                <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Peminjam</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Tanggal Pinjam</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Keperluan</th>
                                <th class="px-6 py-4 text-right text-xs font-semibold text-slate-600 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($recentPeminjamans as $item)
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="flex items-center justify-center w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex-shrink-0">
                                                <span class="text-white text-sm font-bold">{{ substr($item->user->name, 0, 1) }}</span>
                                            </div>
                                            <div>
                                                <p class="font-semibold text-slate-900">{{ $item->user->name }}</p>
                                                <p class="text-xs text-slate-500">{{ $item->user->no_induk }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <p class="text-sm font-medium text-slate-900">{{ $item->tanggal_pinjam->format('d M Y') }}</p>
                                        <p class="text-xs text-slate-500">{{ $item->tanggal_pinjam->diffForHumans() }}</p>
                                    </td>
                                    <td class="px-6 py-4">
                                        <x-badge-status :status="$item->status" />
                                    </td>
                                    <td class="px-6 py-4">
                                        <p class="text-sm text-slate-700">{{ Str::limit($item->keperluan, 50) }}</p>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <a href="{{ route('admin.peminjaman.show', $item) }}" class="inline-flex items-center gap-1 text-sm text-blue-600 hover:text-blue-700 font-medium">
                                            <span>Detail</span>
                                            <x-icon name="arrow-right" size="sm" />
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</x-layouts::app>
