<x-layouts.admin title="Proses Peminjaman #{{ $peminjaman->id }}">
    <div class="space-y-8">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 md:p-8 rounded-3xl border border-slate-200/80 shadow-soft">
            <div>
                <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight font-display">Proses Peminjaman #{{ $peminjaman->id }}</h1>
                <p class="text-xs text-slate-600 mt-1">Verifikasi penyerahan dan pengembalian barang inventaris</p>
            </div>
            <div>
                @php
                    $badgeClass = match ($peminjaman->status->value) {
                        'diajukan'     => 'bg-amber-50 text-amber-700 border-amber-200',
                        'disetujui'    => 'bg-green-50 text-green-700 border-green-200',
                        'ditolak'      => 'bg-red-50 text-red-700 border-red-200',
                        'dipinjam'     => 'bg-blue-50 text-blue-700 border-blue-200',
                        'dikembalikan' => 'bg-slate-50 text-slate-700 border-slate-200',
                        'terlambat'    => 'bg-orange-50 text-orange-700 border-orange-200',
                        default        => 'bg-slate-50 text-slate-700 border-slate-200',
                    };
                @endphp
                <span class="inline-flex items-center gap-1 px-4 py-1.5 rounded-xl border text-xs font-bold tracking-wide {{ $badgeClass }}">
                    <span class="w-2 h-2 rounded-full animate-pulse bg-current opacity-60"></span>
                    {{ $peminjaman->status->label() }}
                </span>
            </div>
        </div>

        <x-alert />

        <div class="grid gap-4 md:grid-cols-2 bg-white rounded-3xl border border-slate-200/80 shadow-soft p-6 md:p-8">
            <div>
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1">Peminjam</p>
                <p class="font-semibold text-slate-900">{{ $peminjaman->user->name }}</p>
                <p class="text-xs text-slate-500">{{ $peminjaman->user->siswa?->kelas ?? '—' }} — {{ $peminjaman->user->siswa?->jurusan ?? '—' }}</p>
            </div>
            <div>
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1">Disetujui Oleh</p>
                <p class="font-semibold text-slate-900">{{ $peminjaman->approver?->name ?? '—' }}</p>
            </div>
            <div>
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1">Tanggal Pinjam</p>
                <p class="font-semibold text-slate-900">{{ $peminjaman->tanggal_pinjam->format('d M Y') }}</p>
            </div>
            <div>
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1">Rencana Kembali</p>
                <p class="font-semibold text-slate-900">{{ $peminjaman->tanggal_kembali_rencana->format('d M Y') }}</p>
            </div>
            <div class="md:col-span-2">
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1">Keperluan</p>
                <p class="text-slate-700">{{ $peminjaman->keperluan }}</p>
            </div>
            @if($peminjaman->catatan_admin)
                <div class="md:col-span-2">
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1">Catatan Admin</p>
                    <p class="text-slate-700">{{ $peminjaman->catatan_admin }}</p>
                </div>
            @endif
        </div>

        <div class="bg-white rounded-3xl border border-slate-200/80 shadow-soft p-6 md:p-8">
            <h2 class="text-lg font-extrabold text-slate-900 tracking-tight font-display mb-5">Barang Dipinjam</h2>
            <div class="space-y-3">
                @foreach($peminjaman->details as $detail)
                    <div class="flex justify-between items-center rounded-2xl border border-slate-100 p-4">
                        <div>
                            <p class="font-semibold text-slate-900">{{ $detail->barang->nama_barang }}</p>
                            <p class="text-xs text-slate-500">{{ $detail->barang->kode_barang }} • {{ $detail->barang->kategori?->nama_kategori ?? 'Umum' }}</p>
                            @if($detail->kondisi_saat_kembali)
                                <p class="text-[11px] text-zinc-400 mt-1 font-semibold uppercase tracking-wide">
                                    Kondisi saat kembali: {{ $detail->kondisi_saat_kembali->label() }}
                                </p>
                            @endif
                        </div>
                        <p class="font-extrabold text-slate-800 text-sm bg-slate-50 border border-slate-200 px-3 py-1.5 rounded-xl">{{ $detail->jumlah }} unit</p>
                    </div>
                @endforeach
            </div>
        </div>

        @if($peminjaman->status->value === 'disetujui')
            <div class="bg-white rounded-3xl border border-green-200/80 shadow-soft p-6 md:p-8">
                <h2 class="text-lg font-extrabold text-slate-900 tracking-tight font-display mb-2 flex items-center gap-2">
                    <span class="w-8 h-8 rounded-xl bg-green-100 text-green-600 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                    </span>
                    Proses Penyerahan Barang
                </h2>
                <p class="text-sm text-slate-500 mb-5">Pastikan barang fisik sudah diperiksa dan diserahkan kepada siswa. Setelah diklik, status akan berubah menjadi <b>Dipinjam</b> dan stok barang berkurang otomatis.</p>
                <form method="POST" action="{{ route('approval.process-borrowing', $peminjaman) }}">
                    @csrf
                    <button type="submit" class="inline-flex items-center gap-2 px-6 py-3 rounded-2xl bg-gradient-to-r from-green-500 to-emerald-600 text-white font-bold text-sm shadow-lg shadow-green-500/30 hover:shadow-xl hover:shadow-green-500/40 hover:scale-[1.02] transition-all duration-300">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        Serahkan Barang & Konfirmasi Dipinjam
                    </button>
                </form>
            </div>
        @endif

        @if($peminjaman->qr_code && in_array($peminjaman->status->value, ['dipinjam', 'terlambat']))
            <div class="bg-white rounded-3xl border border-blue-200/80 shadow-soft p-6 md:p-8">
                <h2 class="text-lg font-extrabold text-slate-900 tracking-tight font-display mb-4 flex items-center gap-2">
                    <span class="w-8 h-8 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
                    </span>
                    QR Code Peminjaman
                </h2>
                <div class="flex flex-col justify-center items-center gap-4">
                    <div class="p-4 bg-slate-50 rounded-2xl border border-slate-200">
                        <img src="{{ asset('storage/' . $peminjaman->qr_code) }}" alt="QR Code Peminjaman" class="h-64 w-64 object-contain">
                    </div>
                    <p class="text-center text-sm text-slate-500 max-w-sm">Tunjukkan QR code ini kepada guru saat pengembalian barang untuk verifikasi cepat.</p>
                    <p class="text-center text-[11px] text-slate-400 font-mono tracking-wider uppercase">Token: {{ Str::limit($peminjaman->qr_token, 16, '...') }}</p>
                </div>
            </div>
        @endif

        @if(in_array($peminjaman->status->value, ['dipinjam', 'terlambat']))
            <div class="bg-white rounded-3xl border border-indigo-200/80 shadow-soft p-6 md:p-8">
                <h2 class="text-lg font-extrabold text-slate-900 tracking-tight font-display mb-5 flex items-center gap-2">
                    <span class="w-8 h-8 rounded-xl bg-indigo-100 text-indigo-600 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/></svg>
                    </span>
                    Proses Pengembalian Barang
                </h2>
                <form method="POST" action="{{ route('approval.process-return', $peminjaman) }}" class="space-y-4">
                    @csrf
                    <div class="space-y-3">
                        @foreach($peminjaman->details as $detail)
                            <div class="rounded-2xl border border-slate-100 p-5 bg-slate-50/60">
                                <p class="font-semibold text-slate-900 mb-3">{{ $detail->barang->nama_barang }} <span class="font-bold text-slate-500">({{ $detail->jumlah }} unit)</span></p>
                                <div class="grid grid-cols-2 gap-3">
                                    <label class="flex items-center gap-3 p-3 rounded-xl border-2 border-slate-200 bg-white cursor-pointer has-[:checked]:border-green-500 has-[:checked]:bg-green-50 has-[:checked]:shadow-md has-[:checked]:shadow-green-500/10 transition-all">
                                        <input type="radio" id="kondisi_baik_{{ $detail->id }}" name="kondisi[{{ $detail->id }}]" value="{{ \App\Enums\KondisiBarang::Baik->value }}" checked required class="w-5 h-5 text-green-600 border-slate-300 focus:ring-green-500">
                                        <div>
                                            <span class="block text-sm font-bold text-slate-800">Baik</span>
                                            <span class="block text-[11px] text-slate-500">Barang kembali utuh</span>
                                        </div>
                                    </label>
                                    <label class="flex items-center gap-3 p-3 rounded-xl border-2 border-slate-200 bg-white cursor-pointer has-[:checked]:border-red-500 has-[:checked]:bg-red-50 has-[:checked]:shadow-md has-[:checked]:shadow-red-500/10 transition-all">
                                        <input type="radio" id="kondisi_rusak_{{ $detail->id }}" name="kondisi[{{ $detail->id }}]" value="{{ \App\Enums\KondisiBarang::Rusak->value }}" required class="w-5 h-5 text-red-600 border-slate-300 focus:ring-red-500">
                                        <div>
                                            <span class="block text-sm font-bold text-slate-800">Rusak</span>
                                            <span class="block text-[11px] text-slate-500">Barang cacat / hilang</span>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <button type="submit" class="inline-flex items-center gap-2 px-6 py-3 rounded-2xl bg-gradient-to-r from-indigo-500 to-purple-600 text-white font-bold text-sm shadow-lg shadow-indigo-500/30 hover:shadow-xl hover:shadow-indigo-500/40 hover:scale-[1.02] transition-all duration-300">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/></svg>
                        Konfirmasi Pengembalian & Simpan
                    </button>
                </form>
            </div>
        @endif

        @if($peminjaman->denda)
            <div class="rounded-3xl border border-amber-300 bg-gradient-to-br from-amber-50 to-orange-50 p-6 md:p-8 shadow-soft">
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-amber-500 text-white flex items-center justify-center flex-shrink-0 shadow-md shadow-amber-500/30">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-base font-extrabold text-amber-900 mb-1">Denda Keterlambatan</h3>
                        <p class="text-sm text-amber-800 font-semibold">Rp {{ number_format($peminjaman->denda->nominal_denda, 0, ',', '.') }} <span class="text-xs opacity-80 font-normal">(Terlambat {{ $peminjaman->denda->jumlah_hari_telat }} hari)</span></p>
                        <p class="text-xs text-amber-700 mt-1 font-semibold uppercase tracking-wide">Status: {{ $peminjaman->denda->status_bayar->label() }}</p>
                    </div>
                </div>
            </div>
        @endif

        <div class="flex flex-col sm:flex-row justify-between items-stretch sm:items-center gap-3">
            <a href="{{ route('approval.index') }}" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-2xl border border-slate-200 bg-white text-slate-700 font-bold text-xs hover:bg-slate-50 hover:border-slate-300 transition-all">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali ke Daftar Pengajuan
            </a>
            <a href="{{ route('peminjaman.show', $peminjaman) }}" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-2xl bg-slate-100 text-slate-700 font-bold text-xs hover:bg-slate-200 transition-all">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                Lihat Detail Lengkap
            </a>
        </div>
    </div>
</x-layouts.admin>
