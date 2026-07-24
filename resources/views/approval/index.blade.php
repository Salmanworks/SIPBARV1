<x-layouts.admin title="Persetujuan Peminjaman">
    <div class="space-y-8">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 md:p-8 rounded-3xl border border-slate-200/80 shadow-soft">
            <div>
                <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight font-display">Persetujuan Peminjaman</h1>
                <p class="text-xs text-slate-600 mt-1">Review dan setujui pengajuan peminjaman dari siswa</p>
            </div>
            
            <div class="flex items-center gap-2">
                <span class="inline-flex items-center gap-1 px-3 py-1.5 rounded-xl bg-amber-50 text-amber-700 text-xs font-bold">
                    <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                    {{ $peminjamans->total() }} Menunggu
                </span>
            </div>
        </div>

        <x-alert />

        @if($peminjamans->isEmpty())
            <div class="bg-white rounded-3xl border border-slate-200/80 shadow-soft p-12 text-center">
                <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-slate-100 flex items-center justify-center">
                    <x-icon name="check-circle" size="lg" class="text-slate-400" />
                </div>
                <p class="text-slate-500 font-medium">Tidak ada pengajuan peminjaman yang menunggu persetujuan</p>
            </div>
        @else
            <div class="space-y-4">
                @foreach($peminjamans as $peminjaman)
                    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-soft p-6">
                        <div class="flex flex-col lg:flex-row lg:items-start gap-6">
                            <div class="flex-1">
                                <div class="flex items-center gap-3 mb-4">
                                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-600 to-indigo-600 flex items-center justify-center text-white font-bold text-sm shadow-md">
                                        {{ strtoupper(substr($peminjaman->user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-900">{{ $peminjaman->user->name }}</p>
                                        <p class="text-xs text-slate-400">{{ $peminjaman->user->siswa?->kelas ?? '—' }} — {{ $peminjaman->user->siswa?->jurusan ?? '—' }}</p>
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
                                    <div>
                                        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Tanggal Pinjam</p>
                                        <p class="font-semibold text-slate-900 text-sm">{{ $peminjaman->tanggal_pinjam->format('d M Y') }}</p>
                                    </div>
                                    <div>
                                        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Rencana Kembali</p>
                                        <p class="font-semibold text-slate-900 text-sm">{{ $peminjaman->tanggal_kembali_rencana->format('d M Y') }}</p>
                                    </div>
                                    <div>
                                        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Diajukan</p>
                                        <p class="font-semibold text-slate-900 text-sm">{{ $peminjaman->created_at->diffForHumans() }}</p>
                                    </div>
                                    <div>
                                        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Status</p>
                                        <x-status-peminjaman :status="$peminjaman->status" />
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-2">Keperluan</p>
                                    <p class="text-sm text-slate-700">{{ $peminjaman->keperluan }}</p>
                                </div>

                                <div>
                                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-2">Barang yang Diminta</p>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach($peminjaman->details as $detail)
                                            <span class="inline-flex items-center gap-1 px-3 py-1.5 rounded-xl bg-slate-50 border border-slate-200 text-xs font-semibold text-slate-700">
                                                {{ $detail->barang->nama_barang }} ({{ $detail->jumlah }})
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div class="flex lg:flex-col gap-2 lg:w-48">
                                <form method="POST" action="{{ route('approval.approve', $peminjaman) }}" class="flex-1">
                                    @csrf
                                    <input type="hidden" name="catatan_admin" value="">
                                    <button type="submit" class="w-full py-2.5 px-4 bg-green-500 hover:bg-green-600 text-white font-bold text-xs rounded-xl transition-colors flex items-center justify-center gap-2">
                                        <x-icon name="check" size="xs" />
                                        Setujui
                                    </button>
                                </form>
                                <button 
                                    onclick="openRejectModal({{ $peminjaman->id }})" 
                                    class="w-full py-2.5 px-4 bg-red-500 hover:bg-red-600 text-white font-bold text-xs rounded-xl transition-colors flex items-center justify-center gap-2"
                                >
                                    <x-icon name="x" size="xs" />
                                    Tolak
                                </button>
                                <a href="{{ route('peminjaman.show', $peminjaman) }}" class="w-full py-2.5 px-4 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition-colors text-center">
                                    Detail
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-4">
                {{ $peminjamans->links() }}
            </div>
        @endif
    </div>

    @foreach($peminjamans as $peminjaman)
        <dialog id="reject-modal-{{ $peminjaman->id }}" class="rounded-2xl p-0 shadow-2xl backdrop:bg-black/50">
            <form method="POST" action="{{ route('approval.reject', $peminjaman) }}" class="w-full max-w-md">
                @csrf
                <div class="bg-white rounded-2xl overflow-hidden">
                    <div class="p-6 border-b border-slate-100">
                        <h3 class="font-bold text-slate-900">Tolak Peminjaman</h3>
                        <p class="text-sm text-slate-500 mt-1">Masukkan alasan penolakan</p>
                    </div>
                    <div class="p-6">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Alasan Penolakan</label>
                        <textarea 
                            name="catatan_admin" 
                            rows="4" 
                            required 
                            minlength="5"
                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:bg-white"
                            placeholder="Jelaskan alasan penolakan..."
                        ></textarea>
                    </div>
                    <div class="p-6 bg-slate-50 flex justify-end gap-3">
                        <button type="button" onclick="document.getElementById('reject-modal-{{ $peminjaman->id }}').close()" class="py-2.5 px-4 bg-white border border-slate-200 text-slate-700 font-bold text-xs rounded-xl hover:bg-slate-50 transition-colors">
                            Batal
                        </button>
                        <button type="submit" class="py-2.5 px-4 bg-red-500 hover:bg-red-600 text-white font-bold text-xs rounded-xl transition-colors">
                            Tolak Peminjaman
                        </button>
                    </div>
                </div>
            </form>
        </dialog>
    @endforeach

    <script>
        function openRejectModal(id) {
            document.getElementById('reject-modal-' + id).showModal();
        }
    </script>
</x-layouts.admin>
