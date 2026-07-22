<x-layouts::app :title="__('Detail Peminjaman')">
    <div class="mx-auto max-w-3xl space-y-6">
        <div class="flex items-center justify-between">
            <flux:heading size="xl">Detail Peminjaman</flux:heading>
            <x-status-badge :status="$peminjaman->status" />
        </div>
        <x-alert />

        <div class="grid gap-4 rounded-xl border border-zinc-200 bg-white p-6 md:grid-cols-2 dark:border-zinc-700 dark:bg-zinc-900">
            <div><span class="text-sm text-zinc-500">Tanggal Pinjam</span><p>{{ $peminjaman->tanggal_pinjam->format('d M Y') }}</p></div>
            <div><span class="text-sm text-zinc-500">Rencana Kembali</span><p>{{ $peminjaman->tanggal_kembali_rencana->format('d M Y') }}</p></div>
            @if($peminjaman->tanggal_kembali_aktual)
                <div><span class="text-sm text-zinc-500">Tanggal Kembali Aktual</span><p>{{ $peminjaman->tanggal_kembali_aktual->format('d M Y') }}</p></div>
            @endif
            <div class="md:col-span-2"><span class="text-sm text-zinc-500">Keperluan</span><p>{{ $peminjaman->keperluan }}</p></div>
            @if($peminjaman->catatan_admin)
                <div class="md:col-span-2"><span class="text-sm text-zinc-500">Catatan</span><p>{{ $peminjaman->catatan_admin }}</p></div>
            @endif
        </div>

        <div class="rounded-xl border border-zinc-200 bg-white p-6 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:heading size="lg" class="mb-4">Barang</flux:heading>
            @foreach($peminjaman->details as $detail)
                <div class="flex justify-between border-b border-zinc-100 py-2 last:border-0 dark:border-zinc-800">
                    <span>{{ $detail->barang->nama_barang }}</span>
                    <span>{{ $detail->jumlah }} unit</span>
                </div>
            @endforeach
        </div>

        @if($peminjaman->denda)
            <flux:callout variant="warning" icon="banknotes">
                Denda: Rp {{ number_format($peminjaman->denda->nominal_denda, 0, ',', '.') }} — {{ $peminjaman->denda->status_bayar->label() }}
            </flux:callout>
        @endif
    </div>
</x-layouts::app>
