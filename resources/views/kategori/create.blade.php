<x-layouts.admin title="Tambah Kategori">
    <div class="mx-auto max-w-xl space-y-6">
        <flux:heading size="xl">Tambah Kategori</flux:heading>
        <x-alert />
        <form method="POST" action="{{ route('admin.kategori.store') }}" class="space-y-4 rounded-xl border border-zinc-200 bg-white p-6 dark:border-zinc-700 dark:bg-zinc-900">
            @csrf
            <flux:input name="nama_kategori" label="Nama Kategori" :value="old('nama_kategori')" required />
            <flux:textarea name="deskripsi" label="Deskripsi" rows="3">{{ old('deskripsi') }}</flux:textarea>
            <div class="flex gap-3">
                <flux:button type="submit">Simpan</flux:button>
                <flux:button :href="route('admin.kategori.index')" variant="ghost" wire:navigate>Batal</flux:button>
            </div>
        </form>
    </div>
</x-layouts::app>
