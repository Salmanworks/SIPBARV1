<x-layouts.app title="Ajukan Peminjaman">
    <div class="space-y-6">
        <flux:heading size="xl">Ajukan Peminjaman BarU</flux:heading>
        <x-alert />

        <form method="POST" action="{{ route('peminjaman.store') }}" class="space-y-6">
            @csrf
            
            <div class="grid gap-4 rounded-xl border border-zinc-200 bg-white p-6 md:grid-cols-2 dark:border-zinc-700 dark:bg-zinc-900">
                <flux:input 
                    name="tanggal_pinjam" 
                    type="date" 
                    label="Tanggal Pinjam" 
                    :value="old('tanggal_pinjam', now()->format('Y-m-d'))" 
                    required 
                    :min="now()->format('Y-m-d')"
                />
                <flux:input 
                    name="tanggal_kembali_rencana" 
                    type="date" 
                    label="Tanggal Kembali Rencana" 
                    :value="old('tanggal_kembali_rencana')" 
                    required 
                />
                <div class="md:col-span-2">
                    <flux:textarea 
                        name="keperluan" 
                        label="Keperluan Peminjaman" 
                        rows="3" 
                        placeholder="Jelaskan keperluan peminjaman barang..."
                        required
                    >{{ old('keperluan') }}</flux:textarea>
                    <p class="mt-1 text-xs text-zinc-500">Minimal 10 karakter</p>
                </div>
            </div>

            <div class="rounded-xl border border-zinc-200 bg-white p-6 dark:border-zinc-700 dark:bg-zinc-900">
                <flux:heading size="lg" class="mb-4">Pilih Barang</flux:heading>
                
                @if($barangs->isEmpty())
                    <p class="py-8 text-center text-zinc-500">Tidak ada barang tersedia saat ini.</p>
                @else
                    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach($barangs as $barang)
                            <div class="rounded-lg border border-zinc-200 p-4 dark:border-zinc-700">
                                <label class="flex cursor-pointer items-start gap-3">
                                    <input 
                                        type="checkbox" 
                                        name="barang[{{ $loop->index }}][id]" 
                                        value="{{ $barang->id }}" 
                                        class="mt-1 rounded border-zinc-300"
                                        data-barang-id="{{ $barang->id }}"
                                        onchange="toggleJumlahInput(this)"
                                    >
                                    <div class="flex-1">
                                        <p class="font-medium text-zinc-900">{{ $barang->nama_barang }}</p>
                                        <p class="text-sm text-zinc-500">{{ $barang->kode_barang }}</p>
                                        <p class="text-xs text-zinc-400">Stok: {{ $barang->stok }}</p>
                                        <div class="mt-2 hidden jumlah-input" id="jumlah-{{ $barang->id }}">
                                            <flux:input 
                                                name="barang[{{ $loop->index }}][jumlah]" 
                                                type="number" 
                                                min="1" 
                                                :max="$barang->stok" 
                                                label="Jumlah" 
                                                size="sm"
                                                :value="old('barang.'.$loop->index.'.jumlah', 1)" 
                                            />
                                        </div>
                                    </div>
                                </label>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="flex justify-end gap-3">
                <flux:button href="{{ route('peminjaman.index') }}" variant="ghost">
                    Batal
                </flux:button>
                <flux:button type="submit" icon="paper-airplane">
                    Kirim Pengajuan
                </flux:button>
            </div>
        </form>
    </div>

    <script>
        function toggleJumlahInput(checkbox) {
            const barangId = checkbox.dataset.barangId;
            const jumlahInput = document.getElementById('jumlah-' + barangId);
            
            if (checkbox.checked) {
                jumlahInput.classList.remove('hidden');
            } else {
                jumlahInput.classList.add('hidden');
            }
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('input[type="checkbox"][data-barang-id]').forEach(checkbox => {
                if (checkbox.checked) {
                    toggleJumlahInput(checkbox);
                }
            });
        });
    </script>
</x-layouts.app>
