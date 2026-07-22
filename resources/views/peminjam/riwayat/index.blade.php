<x-layouts::app :title="__('Riwayat Peminjaman')">
    <div class="space-y-6">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <flux:heading size="xl">Riwayat Peminjaman</flux:heading>
            <flux:button :href="route('peminjam.pengajuan.create')" icon="plus" wire:navigate>Ajukan Baru</flux:button>
        </div>
        <x-alert />

        <form method="GET" class="flex gap-3">
            <flux:select name="status" class="max-w-xs">
                <option value="">Semua Status</option>
                @foreach(\App\Enums\PeminjamanStatus::cases() as $status)
                    <option value="{{ $status->value }}" @selected(request('status') === $status->value)>{{ $status->label() }}</option>
                @endforeach
            </flux:select>
            <flux:button type="submit">Filter</flux:button>
        </form>

        <div class="space-y-3">
            @forelse($peminjamans as $item)
                <div class="flex flex-wrap items-center justify-between gap-3 rounded-xl border border-zinc-200 bg-white p-4 dark:border-zinc-700 dark:bg-zinc-900">
                    <div>
                        <p class="font-medium">{{ $item->keperluan }}</p>
                        <p class="text-sm text-zinc-500">{{ $item->tanggal_pinjam->format('d M Y') }} — {{ $item->tanggal_kembali_rencana->format('d M Y') }}</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <x-status-badge :status="$item->status" />
                        <flux:button :href="route('peminjam.riwayat.show', $item)" size="sm" variant="ghost" wire:navigate>Detail</flux:button>
                    </div>
                </div>
            @empty
                <div class="rounded-xl border border-dashed border-zinc-300 p-12 text-center dark:border-zinc-700">
                    <p class="text-zinc-500">Belum ada riwayat peminjaman.</p>
                </div>
            @endforelse
        </div>
        {{ $peminjamans->links() }}
    </div>
</x-layouts::app>
