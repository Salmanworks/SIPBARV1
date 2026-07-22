@props(['barang'])

<div class="flex flex-col overflow-hidden rounded-xl border border-zinc-200 bg-white shadow-sm transition hover:shadow-md dark:border-zinc-700 dark:bg-zinc-900">
    <div class="aspect-[4/3] overflow-hidden bg-gradient-to-br from-blue-900 to-blue-700">
        <img src="{{ $barang->fotoUrl() }}" alt="{{ $barang->nama_barang }}" class="size-full object-cover opacity-90">
    </div>
    <div class="flex flex-1 flex-col gap-2 p-4">
        <div class="flex items-start justify-between gap-2">
            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-blue-700 dark:text-blue-300">{{ $barang->kode_barang }}</p>
                <h3 class="font-semibold text-zinc-900 dark:text-white">{{ $barang->nama_barang }}</h3>
            </div>
            @if($barang->isTersedia())
                <flux:badge color="green" size="sm">Tersedia</flux:badge>
            @else
                <flux:badge color="red" size="sm">Habis</flux:badge>
            @endif
        </div>
        <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ $barang->kategori->nama_kategori ?? '-' }}</p>
        <div class="mt-auto flex items-center justify-between pt-2">
            <span class="text-sm text-zinc-600 dark:text-zinc-300">Stok: <strong>{{ $barang->stok }}</strong></span>
            <span class="text-xs capitalize text-zinc-500">{{ $barang->kondisi->label() }}</span>
        </div>
        {{ $slot ?? '' }}
    </div>
</div>
