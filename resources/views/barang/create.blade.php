<x-layouts.admin title="Tambah Barang">
    <div class="mx-auto max-w-2xl space-y-6">
        <flux:heading size="xl">Tambah Barang</flux:heading>
        <x-alert />

        <form method="POST" action="{{ route('admin.barang.store') }}" enctype="multipart/form-data" class="space-y-4 rounded-xl border border-zinc-200 bg-white p-6 dark:border-zinc-700 dark:bg-zinc-900">
            @csrf
            <div class="grid gap-4 md:grid-cols-2">
                <flux:input name="kode_barang" label="Kode Barang" :value="old('kode_barang')" required />
                <flux:input name="nama_barang" label="Nama Barang" :value="old('nama_barang')" required />
            </div>
            <flux:select name="kategori_id" label="Kategori" required>
                <option value="">Pilih Kategori</option>
                @foreach($kategoris as $kategori)
                    <option value="{{ $kategori->id }}" @selected(old('kategori_id') == $kategori->id)>{{ $kategori->nama_kategori }}</option>
                @endforeach
            </flux:select>
            <div class="grid gap-4 md:grid-cols-2">
                <flux:input name="stok" type="number" min="0" label="Stok" :value="old('stok', 0)" required />
                <flux:select name="kondisi" label="Kondisi" required>
                    <option value="baik" @selected(old('kondisi') === 'baik')>Baik</option>
                    <option value="rusak" @selected(old('kondisi') === 'rusak')>Rusak</option>
                </flux:select>
            </div>
            <flux:textarea name="deskripsi" label="Deskripsi" rows="3">{{ old('deskripsi') }}</flux:textarea>
            <flux:input name="foto" type="file" label="Foto Barang" accept="image/*" />
            <div class="flex gap-3">
                <flux:button type="submit">Simpan</flux:button>
                <flux:button :href="route('admin.barang.index')" variant="ghost" wire:navigate>Batal</flux:button>
            </div>
        </form>
    </div>
</x-layouts::app>
