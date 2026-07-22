<x-layouts::app :title="__('Dashboard Petugas')">
    <div class="space-y-6">
        <div>
            <flux:heading size="xl">Dashboard Petugas Gudang</flux:heading>
            <flux:text>Verifikasi barang keluar/masuk dan pantau keterlambatan.</flux:text>
        </div>

        <x-alert />

        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <x-stat-card label="Menunggu Verifikasi" :value="$stats['menunggu_verifikasi']" icon="clipboard-document-check" color="green" />
            <x-stat-card label="Sedang Dipinjam" :value="$stats['sedang_dipinjam']" icon="cube" color="blue" />
            <x-stat-card label="Terlambat" :value="$stats['terlambat']" icon="exclamation-triangle" color="orange" />
            <x-stat-card label="Jatuh Tempo Hari Ini" :value="$stats['pengembalian_hari_ini']" icon="calendar" color="red" />
        </div>

        <div class="rounded-xl border border-zinc-200 bg-white p-6 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:heading size="lg" class="mb-4">Perlu Perhatian</flux:heading>
            @if($pendingReturns->isEmpty())
                <p class="py-8 text-center text-zinc-500">Tidak ada peminjaman aktif saat ini.</p>
            @else
                <div class="space-y-3">
                    @foreach($pendingReturns as $item)
                        <div class="flex flex-wrap items-center justify-between gap-3 rounded-lg border border-zinc-100 p-4 dark:border-zinc-800">
                            <div>
                                <p class="font-medium">{{ $item->user->name }}</p>
                                <p class="text-sm text-zinc-500">Kembali: {{ $item->tanggal_kembali_rencana->format('d M Y') }}</p>
                            </div>
                            <div class="flex items-center gap-3">
                                <x-status-badge :status="$item->status" />
                                <flux:button :href="route('petugas.verifikasi.show', $item)" size="sm" wire:navigate>Verifikasi</flux:button>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-layouts::app>
