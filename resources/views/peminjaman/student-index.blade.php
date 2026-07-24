<x-layouts.app title="Peminjaman Saya">
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <flux:heading size="xl">Peminjaman Saya</flux:heading>
            <flux:button href="{{ route('peminjaman.create') }}" icon="plus">
                Ajukan Peminjaman
            </flux:button>
        </div>

        <x-alert />

        @if($peminjamans->isEmpty())
            <div class="rounded-xl border border-zinc-200 bg-white p-12 text-center dark:border-zinc-700 dark:bg-zinc-900">
                <flux:icon name="document" variant="outline" size="lg" class="mx-auto mb-4 text-zinc-400" />
                <p class="text-zinc-500">Belum ada peminjaman. Mulai dengan mengajukan peminjaman barang.</p>
            </div>
        @else
            <div class="space-y-4">
                @foreach($peminjamans as $peminjaman)
                    <div class="rounded-xl border border-zinc-200 bg-white p-6 dark:border-zinc-700 dark:bg-zinc-900">
                        <div class="flex items-start justify-between gap-4">
                            <div class="flex-1">
                                <div class="flex items-center gap-3 mb-2">
                                    <flux:badge variant="{{ $peminjaman->status->color() }}">
                                        {{ $peminjaman->status->label() }}
                                    </flux:badge>
                                    <span class="text-sm text-zinc-500">#{{ $peminjaman->id }}</span>
                                </div>
                                <p class="font-medium text-zinc-900 mb-1">{{ $peminjaman->keperluan }}</p>
                                <p class="text-sm text-zinc-500">
                                    {{ $peminjaman->tanggal_pinjam->format('d M Y') }} — 
                                    {{ $peminjaman->tanggal_kembali_rencana->format('d M Y') }}
                                </p>
                                <div class="mt-3 flex flex-wrap gap-2">
                                    @foreach($peminjaman->details->take(3) as $detail)
                                        <span class="inline-flex items-center gap-1 rounded-lg bg-zinc-100 px-2 py-1 text-xs font-medium text-zinc-700 dark:bg-zinc-800 dark:text-zinc-300">
                                            {{ $detail->barang->nama_barang }} ({{ $detail->jumlah }})
                                        </span>
                                    @endforeach
                                    @if($peminjaman->details->count() > 3)
                                        <span class="text-xs text-zinc-500">+{{ $peminjaman->details->count() - 3 }} lainnya</span>
                                    @endif
                                </div>
                            </div>
                            <div class="flex gap-2">
                                <flux:button href="{{ route('peminjaman.show', $peminjaman) }}" variant="ghost" size="sm">
                                    Detail
                                </flux:button>
                                @if(in_array($peminjaman->status->value, ['diajukan', 'disetujui']))
                                    <flux:button 
                                        href="{{ route('peminjaman.cancel', $peminjaman) }}" 
                                        variant="danger" 
                                        size="sm"
                                        onclick="return confirm('Batalkan peminjaman ini?')"
                                    >
                                        Batalkan
                                    </flux:button>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $peminjamans->links() }}
            </div>
        @endif
    </div>
</x-layouts.app>
