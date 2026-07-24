<x-layouts::app :title="__('Verifikasi Peminjaman')">
    <div class="mx-auto max-w-3xl space-y-6">
        <div class="flex items-center justify-between">
            <flux:heading size="xl">Verifikasi #{{ $peminjaman->id }}</flux:heading>
            <x-status-badge :status="$peminjaman->status" />
        </div>
        <x-alert />

        <div class="rounded-xl border border-zinc-200 bg-white p-6 dark:border-zinc-700 dark:bg-zinc-900">
            <p><strong>Peminjam:</strong> {{ $peminjaman->user->name }}</p>
            <p class="mt-1"><strong>Keperluan:</strong> {{ $peminjaman->keperluan }}</p>
            <p class="mt-1"><strong>Periode:</strong> {{ $peminjaman->tanggal_pinjam->format('d M Y') }} — {{ $peminjaman->tanggal_kembali_rencana->format('d M Y') }}</p>
        </div>

        <div class="rounded-xl border border-zinc-200 bg-white p-6 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:heading size="lg" class="mb-4">Daftar Barang</flux:heading>
            @foreach($peminjaman->details as $detail)
                <div class="flex justify-between border-b border-zinc-100 py-2 last:border-0 dark:border-zinc-800">
                    <span>{{ $detail->barang->nama_barang }}</span>
                    <span>{{ $detail->jumlah }} unit</span>
                </div>
            @endforeach
        </div>

        <div class="flex flex-wrap gap-3">
            @if($peminjaman->status === \App\Enums\PeminjamanStatus::Disetujui)
                <form method="POST" action="{{ route('guru.verifikasi.keluar', $peminjaman) }}">
                    @csrf
                    <flux:button type="submit" icon="arrow-right">Verifikasi Keluar</flux:button>
                </form>
            @endif

            @if(in_array($peminjaman->status, [\App\Enums\PeminjamanStatus::Dipinjam, \App\Enums\PeminjamanStatus::Terlambat], true))
                <form method="POST" action="{{ route('guru.verifikasi.kembali', $peminjaman) }}" class="w-full space-y-4 rounded-xl border border-zinc-200 p-4 dark:border-zinc-700">
                    @csrf
                    <flux:heading size="sm">Verifikasi Pengembalian</flux:heading>
                    @foreach($peminjaman->details as $detail)
                        <flux:select name="kondisi[{{ $detail->id }}]" label="Kondisi {{ $detail->barang->nama_barang }}" required>
                            <option value="baik">Baik</option>
                            <option value="rusak">Rusak</option>
                        </flux:select>
                    @endforeach
                    <flux:button type="submit" variant="primary" icon="check">Konfirmasi Pengembalian</flux:button>
                </form>
            @endif
        </div>
    </div>
</x-layouts::app>
