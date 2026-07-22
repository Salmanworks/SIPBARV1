<x-layouts::app :title="__('Data Peminjaman')">
    <div class="space-y-6">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <flux:heading size="xl">Data Peminjaman</flux:heading>
            <flux:button :href="route('admin.peminjaman.approval')" icon="clipboard-document-check" wire:navigate>Approval</flux:button>
        </div>
        <x-alert />

        <form method="GET" class="flex flex-wrap gap-3">
            <flux:input name="search" placeholder="Cari peminjam..." :value="request('search')" class="max-w-xs" />
            <flux:select name="status" class="max-w-xs">
                <option value="">Semua Status</option>
                @foreach(\App\Enums\PeminjamanStatus::cases() as $status)
                    <option value="{{ $status->value }}" @selected(request('status') === $status->value)>{{ $status->label() }}</option>
                @endforeach
            </flux:select>
            <flux:button type="submit">Filter</flux:button>
        </form>

        <div class="overflow-hidden rounded-xl border border-zinc-200 bg-white dark:border-zinc-700 dark:bg-zinc-900">
            <table class="min-w-full text-sm">
                <thead class="border-b border-zinc-200 bg-zinc-50 text-left dark:border-zinc-700 dark:bg-zinc-800">
                    <tr>
                        <th class="px-4 py-3">Peminjam</th>
                        <th class="px-4 py-3">Tanggal Pinjam</th>
                        <th class="px-4 py-3">Kembali</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($peminjamans as $item)
                        <tr class="border-b border-zinc-100 dark:border-zinc-800">
                            <td class="px-4 py-3">{{ $item->user->name }}</td>
                            <td class="px-4 py-3">{{ $item->tanggal_pinjam->format('d M Y') }}</td>
                            <td class="px-4 py-3">{{ $item->tanggal_kembali_rencana->format('d M Y') }}</td>
                            <td class="px-4 py-3"><x-status-badge :status="$item->status" /></td>
                            <td class="px-4 py-3 text-right">
                                <flux:button :href="route('admin.peminjaman.show', $item)" size="sm" variant="ghost" wire:navigate>Detail</flux:button>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-4 py-12 text-center text-zinc-500">Belum ada data peminjaman.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $peminjamans->links() }}
    </div>
</x-layouts::app>
