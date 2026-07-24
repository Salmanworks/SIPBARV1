<x-layouts.admin title="Proses Peminjaman #{{ $peminjaman->id }}">
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <flux:heading size="xl">Proses Peminjaman #{{ $peminjaman->id }}</flux:heading>
            <flux:badge variant="{{ $peminjaman->status->color() }}">
                {{ $peminjaman->status->label() }}
            </flux:badge>
        </div>

        <x-alert />

        <div class="grid gap-4 rounded-xl border border-zinc-200 bg-white p-6 md:grid-cols-2 dark:border-zinc-700 dark:bg-zinc-900">
            <div>
                <span class="text-sm text-zinc-500">Peminjam</span>
                <p class="font-medium">{{ $peminjaman->user->name }}</p>
                <p class="text-sm text-zinc-500">{{ $peminjaman->user->siswa?->kelas ?? '—' }} — {{ $peminjaman->user->siswa?->jurusan ?? '—' }}</p>
            </div>
            <div>
                <span class="text-sm text-zinc-500">Disetujui Oleh</span>
                <p class="font-medium">{{ $peminjaman->approver?->name ?? '—' }}</p>
            </div>
            <div>
                <span class="text-sm text-zinc-500">Tanggal Pinjam</span>
                <p class="font-medium">{{ $peminjaman->tanggal_pinjam->format('d M Y') }}</p>
            </div>
            <div>
                <span class="text-sm text-zinc-500">Rencana Kembali</span>
                <p class="font-medium">{{ $peminjaman->tanggal_kembali_rencana->format('d M Y') }}</p>
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
                        </div>
                        <p class="font-semibold">{{ $detail->jumlah }} unit</p>
                    </div>
                @endforeach
            </div>
        </div>

        @if($peminjaman->status->value === 'disetujui')
            <div class="rounded-xl border border-zinc-200 bg-white p-6 dark:border-zinc-700 dark:bg-zinc-900">
                <flux:heading size="lg" class="mb-4">Proses Peminjaman</flux:heading>
                <p class="text-sm text-zinc-500 mb-4">Klik tombol di bawah untuk mengubah status menjadi "Dipinjam" dan generate QR Code.</p>
                <form method="POST" action="{{ route('approval.process-borrowing', $peminjaman) }}">
                    @csrf
                    <flux:button type="submit" icon="qr-code">
                        Proses Peminjaman & Generate QR
                    </flux:button>
                </form>
            </div>
        @endif

        @if($peminjaman->qr_code && in_array($peminjaman->status->value, ['dipinjam', 'terlambat']))
            <div class="rounded-xl border border-zinc-200 bg-white p-6 dark:border-zinc-700 dark:bg-zinc-900">
                <flux:heading size="lg" class="mb-4">QR Code Peminjaman</flux:heading>
                <div class="flex justify-center">
                    <img src="{{ asset('storage/' . $peminjaman->qr_code) }}" alt="QR Code" class="h-64 w-64 rounded-lg">
                </div>
                <p class="mt-4 text-center text-sm text-zinc-500">QR Code untuk verifikasi pengembalian</p>
            </div>
        @endif

        @if(in_array($peminjaman->status->value, ['dipinjam', 'terlambat']))
            <div class="rounded-xl border border-zinc-200 bg-white p-6 dark:border-zinc-700 dark:bg-zinc-900">
                <flux:heading size="lg" class="mb-4">Proses Pengembalian</flux:heading>
                <form method="POST" action="{{ route('approval.process-return', $peminjaman) }}" class="space-y-4">
                    @csrf
                    <div class="space-y-3">
                        @foreach($peminjaman->details as $detail)
                            <div class="rounded-lg border border-zinc-100 p-4 dark:border-zinc-800">
                                <p class="font-medium text-zinc-900 mb-2">{{ $detail->barang->nama_barang }} ({{ $detail->jumlah }} unit)</p>
                                <flux:radio-group name="kondisi[{{ $detail->id }}][kondisi]" required>
                                    <flux:radio value="baik" label="Baik" />
                                    <flux:radio value="rusak" label="Rusak" />
                                </flux:radio-group>
                                <input type="hidden" name="kondisi[{{ $detail->id }}][detail_id]" value="{{ $detail->id }}">
                            </div>
                        @endforeach
                    </div>
                    <flux:button type="submit" icon="arrow-uturn-left" variant="success">
                        Proses Pengembalian
                    </flux:button>
                </form>
            </div>
        @endif

        <div class="flex justify-between">
            <flux:button href="{{ route('approval.index') }}" variant="ghost">
                Kembali ke Daftar
            </flux:button>
            <flux:button href="{{ route('peminjaman.show', $peminjaman) }}" variant="secondary">
                Lihat Detail Lengkap
            </flux:button>
        </div>
    </div>
</x-layouts.admin>
