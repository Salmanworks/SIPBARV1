<x-layouts.guest>
    @include('partials.navbar')
    
    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 pt-24 pb-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="space-y-6">
                <div class="flex items-center justify-between">
                    <flux:heading size="xl">Detail Peminjaman #{{ $peminjaman->id }}</flux:heading>
                    <flux:badge variant="{{ $peminjaman->status->color() }}">
                        {{ $peminjaman->status->label() }}
                    </flux:badge>
                </div>

                <x-alert />

                <div class="grid gap-4 rounded-xl border border-zinc-200 bg-white p-6 md:grid-cols-2 dark:border-zinc-700 dark:bg-zinc-900">
                    <div>
                        <span class="text-sm text-zinc-500">Tanggal Pinjam</span>
                        <p class="font-medium">{{ $peminjaman->tanggal_pinjam->format('d M Y') }}</p>
                    </div>
                    <div>
                        <span class="text-sm text-zinc-500">Rencana Kembali</span>
                        <p class="font-medium">{{ $peminjaman->tanggal_kembali_rencana->format('d M Y') }}</p>
                    </div>
                    @if($peminjaman->tanggal_kembali_aktual)
                        <div>
                            <span class="text-sm text-zinc-500">Tanggal Kembali Aktual</span>
                            <p class="font-medium">{{ $peminjaman->tanggal_kembali_aktual->format('d M Y') }}</p>
                        </div>
                    @endif
                    <div>
                        <span class="text-sm text-zinc-500">Disetujui Oleh</span>
                        <p class="font-medium">{{ $peminjaman->approver?->name ?? '—' }}</p>
                    </div>
                    <div class="md:col-span-2">
                        <span class="text-sm text-zinc-500">Keperluan</span>
                        <p>{{ $peminjaman->keperluan }}</p>
                    </div>
                    @if($peminjaman->catatan_admin)
                        <div class="md:col-span-2">
                            <span class="text-sm text-zinc-500">Catatan Admin</span>
                            <p>{{ $peminjaman->catatan_admin }}</p>
                        </div>
                    @endif
                </div>

                <div class="rounded-xl border border-zinc-200 bg-white p-6 dark:border-zinc-700 dark:bg-zinc-900">
                    <flux:heading size="lg" class="mb-4">Barang Dipinjam</flux:heading>
                    <div class="space-y-3">
                        @foreach($peminjaman->details as $detail)
                            <div class="flex justify-between rounded-lg border border-zinc-100 p-4 dark:border-zinc-800">
                                <div>
                                    <p class="font-medium text-zinc-900">{{ $detail->barang->nama_barang }}</p>
                                    <p class="text-sm text-zinc-500">{{ $detail->barang->kode_barang }}</p>
                                    @if($detail->kondisi_saat_kembali)
                                        <p class="text-xs text-zinc-400 mt-1">
                                            Kondisi saat kembali: {{ $detail->kondisi_saat_kembali->label() }}
                                        </p>
                                    @endif
                                </div>
                                <p class="font-semibold">{{ $detail->jumlah }} unit</p>
                            </div>
                        @endforeach
                    </div>
                </div>

                @if($peminjaman->qr_code && $peminjaman->status->value === 'dipinjam')
                    <div class="rounded-xl border border-zinc-200 bg-white p-6 dark:border-zinc-700 dark:bg-zinc-900">
                        <flux:heading size="lg" class="mb-4">QR Code Peminjaman</flux:heading>
                        <div class="flex justify-center">
                            <img src="{{ asset('storage/' . $peminjaman->qr_code) }}" alt="QR Code" class="h-64 w-64 rounded-lg">
                        </div>
                        <p class="mt-4 text-center text-sm text-zinc-500">Tunjukkan QR code ini saat pengembalian barang</p>
                    </div>
                @endif

                @if($peminjaman->denda)
                    <flux:callout variant="warning" icon="banknotes">
                        <div class="font-medium">Denda Keterlambatan</div>
                        <p>Rp {{ number_format($peminjaman->denda->nominal_denda, 0, ',', '.') }} ({{ $peminjaman->denda->jumlah_hari_telat }} hari) — {{ $peminjaman->denda->status_bayar->label() }}</p>
                    </flux:callout>
                @endif

                <div class="flex justify-between">
                    <flux:button href="{{ route('peminjaman.index') }}" variant="ghost">
                        Kembali
                    </flux:button>
                    @if(in_array($peminjaman->status->value, ['diajukan', 'disetujui']))
                        <flux:button 
                            href="{{ route('peminjaman.cancel', $peminjaman) }}" 
                            variant="danger"
                            onclick="return confirm('Batalkan peminjaman ini?')"
                        >
                            Batalkan Peminjaman
                        </flux:button>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    @include('partials.footer')
</x-layouts.guest>
