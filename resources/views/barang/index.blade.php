<x-layouts::app :title="__('Data Barang')">
    <div class="space-y-6">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <flux:heading size="xl">Data Barang</flux:heading>
            @if(auth()->user()->isAdmin())
                <flux:button :href="route('admin.barang.create')" icon="plus" wire:navigate>Tambah Barang</flux:button>
            @endif
        </div>

        <x-alert />

        <form method="GET" class="grid gap-3 rounded-xl border border-zinc-200 bg-white p-4 md:grid-cols-4 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:input name="search" label="Cari" placeholder="Nama atau kode..." :value="request('search')" />
            <flux:select name="kategori_id" label="Kategori">
                <option value="">Semua Kategori</option>
                @foreach($kategoris as $kategori)
                    <option value="{{ $kategori->id }}" @selected(request('kategori_id') == $kategori->id)>{{ $kategori->nama_kategori }}</option>
                @endforeach
            </flux:select>
            <flux:select name="ketersediaan" label="Ketersediaan">
                <option value="">Semua</option>
                <option value="tersedia" @selected(request('ketersediaan') === 'tersedia')>Tersedia</option>
                <option value="habis" @selected(request('ketersediaan') === 'habis')>Habis</option>
            </flux:select>
            <div class="flex items-end gap-2">
                <flux:button type="submit">Filter</flux:button>
                <flux:button :href="route('admin.barang.index')" variant="ghost">Reset</flux:button>
            </div>
        </form>

        @if($barangs->isEmpty())
            <div class="rounded-xl border border-dashed border-zinc-300 p-12 text-center dark:border-zinc-700">
                <flux:icon icon="cube" class="mx-auto size-12 text-zinc-400" />
                <p class="mt-4 text-zinc-500">Belum ada barang ditemukan.</p>
            </div>
        @else
            <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
                @foreach($barangs as $barang)
                    <x-card-barang :barang="$barang">
                        <div class="mt-3 flex gap-2">
                            <flux:button :href="route('admin.barang.show', $barang)" size="sm" variant="ghost" class="flex-1" wire:navigate>Detail</flux:button>
                            @if(auth()->user()->isAdmin())
                                <flux:button :href="route('admin.barang.edit', $barang)" size="sm" class="flex-1" wire:navigate>Edit</flux:button>
                            @endif
                        </div>
                    </x-card-barang>
                @endforeach
            </div>
            <div class="mt-4">{{ $barangs->links() }}</div>
        @endif
    </div>
</x-layouts::app>
