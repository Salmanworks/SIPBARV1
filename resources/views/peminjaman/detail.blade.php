<x-layouts.admin title="Detail Peminjaman">
    <div class="mx-auto max-w-3xl space-y-6">
        <div class="flex items-center justify-between">
            <flux:heading size="xl">Detail Peminjaman #{{ $peminjaman->id }}</flux:heading>
            <x-status-badge :status="$peminjaman->status" />
        </div>
        <x-alert />

        <div class="grid gap-4 rounded-xl border border-zinc-200 bg-white p-6 md:grid-cols-2 dark:border-zinc-700 dark:bg-zinc-900">
            <div><span class="text-sm text-zinc-500">Peminjam</span><p class="font-medium">{{ $peminjaman->user->name }}</p></div>
            <div><span class="text-sm text-zinc-500">Disetujui Oleh</span><p class="font-medium">{{ $peminjaman->approver?->name ?? '—' }}</p></div>
            <div><span class="text-sm text-zinc-500">Tanggal Pinjam</span><p>{{ $peminjaman->tanggal_pinjam->format('d M Y') }}</p></div>
            <div><span class="text-sm text-zinc-500">Rencana Kembali</span><p>{{ $peminjaman->tanggal_kembali_rencana->format('d M Y') }}</p></div>
            <div class="md:col-span-2"><span class="text-sm text-zinc-500">Keperluan</span><p>{{ $peminjaman->keperluan }}</p></div>
            @if($peminjaman->catatan_admin)
                <div class="md:col-span-2"><span class="text-sm text-zinc-500">Catatan Admin</span><p>{{ $peminjaman->catatan_admin }}</p></div>
            @endif
        </div>

        <div class="rounded-xl border border-zinc-200 bg-white p-6 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:heading size="lg" class="mb-4">Barang Dipinjam</flux:heading>
            <div class="space-y-3">
                @foreach($peminjaman->details as $detail)
                    <div class="flex justify-between rounded-lg border border-zinc-100 p-3 dark:border-zinc-800">
                        <div>
                            <p class="font-medium">{{ $detail->barang->nama_barang }}</p>
                            <p class="text-sm text-zinc-500">{{ $detail->barang->kode_barang }}</p>
                        </div>
                        <p class="font-semibold">{{ $detail->jumlah }} unit</p>
                    </div>
                @endforeach
            </div>
        </div>

        @if($peminjaman->denda)
            <flux:callout variant="warning" icon="banknotes">
                Denda keterlambatan: Rp {{ number_format($peminjaman->denda->nominal_denda, 0, ',', '.') }}
                ({{ $peminjaman->denda->jumlah_hari_telat }} hari) — {{ $peminjaman->denda->status_bayar->label() }}
            </flux:callout>
        @endif
    </div>
</x-layouts::app>
