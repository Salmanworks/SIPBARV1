<x-layouts::app :title="__('Laporan Peminjaman')">
    <div class="space-y-6">
        <flux:heading size="xl">Laporan Peminjaman</flux:heading>
        <x-alert />

        <form method="GET" class="grid gap-3 rounded-xl border border-zinc-200 bg-white p-4 md:grid-cols-4 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:input name="dari" type="date" label="Dari Tanggal" :value="$from->format('Y-m-d')" />
            <flux:input name="sampai" type="date" label="Sampai Tanggal" :value="$to->format('Y-m-d')" />
            <flux:select name="status" label="Status">
                <option value="">Semua Status</option>
                @foreach(\App\Enums\PeminjamanStatus::cases() as $status)
                    <option value="{{ $status->value }}" @selected(request('status') === $status->value)>{{ $status->label() }}</option>
                @endforeach
            </flux:select>
            <div class="flex items-end gap-2">
                <flux:button type="submit">Tampilkan</flux:button>
            </div>
        </form>

        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-5">
            <x-stat-card label="Total Transaksi" :value="$summary['total']" color="navy" />
            <x-stat-card label="Diajukan" :value="$summary['diajukan']" color="green" />
            <x-stat-card label="Dipinjam" :value="$summary['dipinjam']" color="blue" />
            <x-stat-card label="Dikembalikan" :value="$summary['dikembalikan']" color="green" />
            <x-stat-card label="Terlambat" :value="$summary['terlambat']" color="orange" />
        </div>

        <div class="overflow-hidden rounded-xl border border-zinc-200 bg-white dark:border-zinc-700 dark:bg-zinc-900">
            <table class="min-w-full text-sm">
                <thead class="border-b border-zinc-200 bg-zinc-50 text-left dark:border-zinc-700 dark:bg-zinc-800">
                    <tr>
                        <th class="px-4 py-3">Peminjam</th>
                        <th class="px-4 py-3">Tanggal</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Keperluan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($peminjamans as $item)
                        <tr class="border-b border-zinc-100 dark:border-zinc-800">
                            <td class="px-4 py-3">{{ $item->user->name }}</td>
                            <td class="px-4 py-3">{{ $item->tanggal_pinjam->format('d M Y') }}</td>
                            <td class="px-4 py-3"><x-status-badge :status="$item->status" /></td>
                            <td class="px-4 py-3">{{ Str::limit($item->keperluan, 50) }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="px-4 py-12 text-center text-zinc-500">Tidak ada data pada periode ini.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $peminjamans->links() }}
    </div>
</x-layouts::app>
