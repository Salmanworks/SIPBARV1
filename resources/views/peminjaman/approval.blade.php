<x-layouts::app :title="__('Approval Peminjaman')">
    <div class="space-y-6">
        <flux:heading size="xl">Approval Peminjaman</flux:heading>
        <x-alert />

        @if($peminjamans->isEmpty())
            <div class="rounded-xl border border-dashed border-zinc-300 p-12 text-center dark:border-zinc-700">
                <flux:icon icon="inbox" class="mx-auto size-12 text-zinc-400" />
                <p class="mt-4 text-zinc-500">Tidak ada pengajuan menunggu persetujuan.</p>
            </div>
        @else
            <div class="space-y-4">
                @foreach($peminjamans as $item)
                    <div class="rounded-xl border border-zinc-200 bg-white p-6 dark:border-zinc-700 dark:bg-zinc-900">
                        <div class="mb-4 flex flex-wrap items-start justify-between gap-3">
                            <div>
                                <p class="font-semibold">{{ $item->user->name }}</p>
                                <p class="text-sm text-zinc-500">{{ $item->tanggal_pinjam->format('d M Y') }} — {{ $item->tanggal_kembali_rencana->format('d M Y') }}</p>
                                <p class="mt-2">{{ $item->keperluan }}</p>
                            </div>
                            <x-status-badge :status="$item->status" />
                        </div>
                        <div class="mb-4 space-y-2">
                            @foreach($item->details as $detail)
                                <div class="flex justify-between text-sm">
                                    <span>{{ $detail->barang->nama_barang }}</span>
                                    <span>{{ $detail->jumlah }} unit (stok: {{ $detail->barang->stok }})</span>
                                </div>
                            @endforeach
                        </div>
                        <div class="flex flex-wrap gap-3">
                            <form method="POST" action="{{ route('admin.peminjaman.approve', $item) }}" class="flex flex-1 flex-wrap items-end gap-2">
                                @csrf
                                <flux:input name="catatan_admin" placeholder="Catatan (opsional)" class="min-w-[200px] flex-1" />
                                <flux:button type="submit" variant="primary">Setujui</flux:button>
                            </form>
                            <form method="POST" action="{{ route('admin.peminjaman.reject', $item) }}" class="flex flex-1 flex-wrap items-end gap-2">
                                @csrf
                                <flux:input name="catatan_admin" placeholder="Alasan penolakan" required class="min-w-[200px] flex-1" />
                                <flux:button type="submit" variant="danger">Tolak</flux:button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
            {{ $peminjamans->links() }}
        @endif
    </div>
</x-layouts::app>
