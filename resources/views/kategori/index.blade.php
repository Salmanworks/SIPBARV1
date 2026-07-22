<x-layouts::app :title="__('Kategori Barang')">
    <div class="space-y-6">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <flux:heading size="xl">Kategori Barang</flux:heading>
            <flux:button :href="route('admin.kategori.create')" icon="plus" wire:navigate>Tambah Kategori</flux:button>
        </div>
        <x-alert />

        <form method="GET" class="flex gap-3">
            <flux:input name="search" placeholder="Cari kategori..." :value="request('search')" class="max-w-sm" />
            <flux:button type="submit">Cari</flux:button>
        </form>

        <div class="overflow-hidden rounded-xl border border-zinc-200 bg-white dark:border-zinc-700 dark:bg-zinc-900">
            <table class="min-w-full text-sm">
                <thead class="border-b border-zinc-200 bg-zinc-50 text-left dark:border-zinc-700 dark:bg-zinc-800">
                    <tr>
                        <th class="px-4 py-3">Nama Kategori</th>
                        <th class="px-4 py-3">Deskripsi</th>
                        <th class="px-4 py-3">Jumlah Barang</th>
                        <th class="px-4 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kategoris as $kategori)
                        <tr class="border-b border-zinc-100 dark:border-zinc-800">
                            <td class="px-4 py-3 font-medium">{{ $kategori->nama_kategori }}</td>
                            <td class="px-4 py-3 text-zinc-500">{{ Str::limit($kategori->deskripsi, 60) ?: '—' }}</td>
                            <td class="px-4 py-3">{{ $kategori->barangs_count }}</td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex justify-end gap-2">
                                    <flux:button :href="route('admin.kategori.edit', $kategori)" size="sm" variant="ghost" wire:navigate>Edit</flux:button>
                                    <form method="POST" action="{{ route('admin.kategori.destroy', $kategori) }}" onsubmit="return confirm('Hapus kategori ini?')">
                                        @csrf @method('DELETE')
                                        <flux:button type="submit" size="sm" variant="danger">Hapus</flux:button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="px-4 py-12 text-center text-zinc-500">Belum ada kategori.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $kategoris->links() }}
    </div>
</x-layouts::app>
