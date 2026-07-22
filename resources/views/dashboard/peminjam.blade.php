<x-layouts::app :title="__('Dashboard Peminjam')">
    <div class="space-y-6">
        <div class="flex flex-wrap items-start justify-between gap-4">
            <div>
                <flux:heading size="xl">Dashboard Peminjam</flux:heading>
                <flux:text>Kelola pengajuan dan pantau status peminjaman Anda.</flux:text>
            </div>
            <flux:button :href="route('peminjam.pengajuan.create')" icon="plus" wire:navigate>Ajukan Peminjaman</flux:button>
        </div>

        <x-alert />

        @if($stats['terlambat'] > 0)
            <flux:callout variant="danger" icon="exclamation-circle">
                Anda memiliki {{ $stats['terlambat'] }} peminjaman terlambat. Segera kembalikan barang.
            </flux:callout>
        @endif

        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <x-stat-card label="Total Pengajuan" :value="$stats['total_pengajuan']" icon="document-text" color="navy" />
            <x-stat-card label="Menunggu Approval" :value="$stats['menunggu']" icon="clock" color="green" />
            <x-stat-card label="Peminjaman Aktif" :value="$stats['aktif']" icon="cube" color="blue" />
            <x-stat-card label="Terlambat" :value="$stats['terlambat']" icon="exclamation-triangle" color="orange" />
        </div>

        <div class="rounded-xl border border-zinc-200 bg-white p-6 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:heading size="lg" class="mb-4">Riwayat Terbaru</flux:heading>
            @if($recent->isEmpty())
                <p class="py-8 text-center text-zinc-500">Belum ada pengajuan peminjaman.</p>
            @else
                <div class="space-y-3">
                    @foreach($recent as $item)
                        <div class="flex flex-wrap items-center justify-between gap-3 rounded-lg border border-zinc-100 p-4 dark:border-zinc-800">
                            <div>
                                <p class="font-medium">{{ $item->keperluan }}</p>
                                <p class="text-sm text-zinc-500">{{ $item->tanggal_pinjam->format('d M Y') }} — {{ $item->tanggal_kembali_rencana->format('d M Y') }}</p>
                            </div>
                            <div class="flex items-center gap-3">
                                <x-status-badge :status="$item->status" />
                                <flux:button :href="route('peminjam.riwayat.show', $item)" size="sm" variant="ghost" wire:navigate>Detail</flux:button>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-layouts::app>
