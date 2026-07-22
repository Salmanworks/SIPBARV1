<x-layouts.admin title="{{ $barang->nama_barang }}">
    <div class="mx-auto max-w-3xl space-y-6">
        <div class="flex flex-wrap items-start justify-between gap-4">
            <div>
                <flux:heading size="xl">{{ $barang->nama_barang }}</flux:heading>
                <flux:text>{{ $barang->kode_barang }} — {{ $barang->kategori->nama_kategori }}</flux:text>
            </div>
            @if(auth()->user()->isAdmin())
                <flux:button :href="route('admin.barang.edit', $barang)" icon="pencil" wire:navigate>Edit</flux:button>
            @endif
        </div>

        <div class="grid gap-6 md:grid-cols-2">
            <div class="overflow-hidden rounded-xl border border-zinc-200 dark:border-zinc-700">
                <img src="{{ $barang->fotoUrl() }}" alt="{{ $barang->nama_barang }}" class="aspect-square w-full object-cover">
            </div>
            <div class="space-y-4 rounded-xl border border-zinc-200 bg-white p-6 dark:border-zinc-700 dark:bg-zinc-900">
                <div><span class="text-sm text-zinc-500">Stok</span><p class="text-2xl font-bold">{{ $barang->stok }}</p></div>
                <div><span class="text-sm text-zinc-500">Kondisi</span><p class="font-medium capitalize">{{ $barang->kondisi->label() }}</p></div>
                <div><span class="text-sm text-zinc-500">Status</span>
                    @if($barang->isTersedia())
                        <flux:badge color="green">Tersedia</flux:badge>
                    @else
                        <flux:badge color="red">Tidak Tersedia</flux:badge>
                    @endif
                </div>
                <div><span class="text-sm text-zinc-500">Deskripsi</span><p>{{ $barang->deskripsi ?: '—' }}</p></div>
            </div>
        </div>
    </div>
</x-layouts::app>
