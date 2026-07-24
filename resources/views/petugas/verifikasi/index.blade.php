<x-layouts::app :title="__('Verifikasi Peminjaman')">
    <div class="space-y-6">
        <flux:heading size="xl">Verifikasi Peminjaman</flux:heading>
        <x-alert />

        <form method="GET" class="flex gap-3">
            <flux:select name="status" class="max-w-xs">
                <option value="">Semua Status Aktif</option>
                <option value="disetujui" @selected(request('status') === 'disetujui')>Disetujui</option>
                <option value="dipinjam" @selected(request('status') === 'dipinjam')>Dipinjam</option>
                <option value="terlambat" @selected(request('status') === 'terlambat')>Terlambat</option>
            </flux:select>
            <flux:button type="submit">Filter</flux:button>
        </form>

        <div class="overflow-hidden rounded-xl border border-zinc-200 bg-white dark:border-zinc-700 dark:bg-zinc-900">
            <table class="min-w-full text-sm">
                <thead class="border-b border-zinc-200 bg-zinc-50 text-left dark:border-zinc-700 dark:bg-zinc-800">
                    <tr>
                        <th class="px-4 py-3">Peminjam</th>
                        <th class="px-4 py-3">Tanggal</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($peminjamans as $item)
                        <tr class="border-b border-zinc-100 dark:border-zinc-800">
                            <td class="px-4 py-3">{{ $item->user->name }}</td>
                            <td class="px-4 py-3">{{ $item->tanggal_pinjam->format('d M Y') }}</td>
                            <td class="px-4 py-3"><x-status-badge :status="$item->status" /></td>
                            <td class="px-4 py-3 text-right">
                                <flux:button :href="route('guru.verifikasi.show', $item)" size="sm" wire:navigate>Verifikasi</flux:button>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="px-4 py-12 text-center text-zinc-500">Tidak ada data.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $peminjamans->links() }}
    </div>
</x-layouts::app>
