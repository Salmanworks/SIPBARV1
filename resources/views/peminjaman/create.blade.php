<x-layouts::app :title="__('Ajukan Peminjaman')">
    <div class="space-y-6">
        <flux:heading size="xl">Ajukan Peminjaman</flux:heading>
        <x-alert />

        <form method="GET" action="{{ route('peminjam.pengajuan.create') }}" class="flex flex-wrap gap-3">
            <flux:input name="search" placeholder="Cari barang..." :value="request('search')" class="max-w-xs" />
            <flux:select name="kategori_id" class="max-w-xs">
                <option value="">Semua Kategori</option>
                @foreach($kategoris as $kategori)
                    <option value="{{ $kategori->id }}" @selected(request('kategori_id') == $kategori->id)>{{ $kategori->nama_kategori }}</option>
                @endforeach
            </flux:select>
            <flux:button type="submit">Filter</flux:button>
        </form>

        <form method="POST" action="{{ route('peminjam.pengajuan.store') }}" class="space-y-6">
            @csrf
            <div class="grid gap-4 rounded-xl border border-zinc-200 bg-white p-6 md:grid-cols-2 dark:border-zinc-700 dark:bg-zinc-900">
                <flux:input name="tanggal_pinjam" type="date" label="Tanggal Pinjam" :value="old('tanggal_pinjam', today()->format('Y-m-d'))" required />
                <flux:input name="tanggal_kembali_rencana" type="date" label="Tanggal Kembali" :value="old('tanggal_kembali_rencana')" required />
                <div class="md:col-span-2">
                    <flux:textarea name="keperluan" label="Keperluan" rows="3" required>{{ old('keperluan') }}</flux:textarea>
                </div>
            </div>

            @if($barangs->isEmpty())
                <p class="py-8 text-center text-zinc-500">Tidak ada barang tersedia.</p>
            @else
                <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
                    @foreach($barangs as $barang)
                        <div class="rounded-xl border border-zinc-200 bg-white p-4 dark:border-zinc-700 dark:bg-zinc-900">
                            <label class="flex cursor-pointer items-start gap-3">
                                <input type="checkbox" name="barang_id[]" value="{{ $barang->id }}" class="mt-1 rounded border-zinc-300" @checked(in_array($barang->id, old('barang_id', [])))>
                                <div class="flex-1">
                                    <p class="font-medium">{{ $barang->nama_barang }}</p>
                                    <p class="text-sm text-zinc-500">{{ $barang->kode_barang }} — Stok: {{ $barang->stok }}</p>
                                    <flux:input name="jumlah[{{ $barang->id }}]" type="number" min="1" :max="$barang->stok" label="Jumlah" class="mt-2" :value="old('jumlah.'.$barang->id, 1)" />
                                </div>
                            </label>
                        </div>
                    @endforeach
                </div>
                {{ $barangs->links() }}
            @endif

            <flux:button type="submit" icon="paper-airplane">Kirim Pengajuan</flux:button>
        </form>
    </div>
</x-layouts::app>
