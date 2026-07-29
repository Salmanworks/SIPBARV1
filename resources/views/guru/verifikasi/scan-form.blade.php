<x-layouts.admin title="Scan QR Code — Verifikasi Serah Terima Barang">
    <div class="space-y-6 max-w-4xl mx-auto">
        <div class="flex flex-col gap-4 bg-gradient-to-r from-slate-900 via-indigo-900 to-slate-900 p-6 md:p-8 rounded-3xl shadow-2xl shadow-indigo-900/40">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-indigo-500 to-fuchsia-500 flex items-center justify-center shadow-xl shadow-indigo-500/30">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
                </div>
                <div>
                    <h1 class="text-2xl font-extrabold text-white tracking-tight">Scan QR Code Peminjaman</h1>
                    <p class="text-xs text-indigo-200 mt-1">Tempel hasil scan QR dari HP (Scanner App) atau klik link langsung. Verifikasi 1-langkah untuk Serahkan / Kembalikan Barang.</p>
                </div>
            </div>

            <div class="grid gap-4 md:grid-cols-3 text-[11px]">
                <div class="p-3 rounded-2xl bg-white/10 border border-white/10 backdrop-blur-sm">
                    <div class="font-extrabold text-emerald-300 uppercase tracking-wide mb-1 flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                        Step 1
                    </div>
                    <p class="text-indigo-100/90 leading-relaxed">Scan QR yang diberikan siswa/guru saat serah-terima menggunakan kamera HP.</p>
                </div>
                <div class="p-3 rounded-2xl bg-white/10 border border-white/10 backdrop-blur-sm">
                    <div class="font-extrabold text-amber-300 uppercase tracking-wide mb-1 flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                        Step 2
                    </div>
                    <p class="text-indigo-100/90 leading-relaxed">Copy teks hasil scan (format: <code class="text-indigo-300 font-mono bg-black/30 px-1 rounded">sipbar://qr/...</code>) dan paste di bawah.</p>
                </div>
                <div class="p-3 rounded-2xl bg-white/10 border border-white/10 backdrop-blur-sm">
                    <div class="font-extrabold text-sky-300 uppercase tracking-wide mb-1 flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        Step 3
                    </div>
                    <p class="text-indigo-100/90 leading-relaxed">Cek detail barang di halaman hasil → klik tombol <b>Serahkan</b> / <b>Kembalikan</b>.</p>
                </div>
            </div>
        </div>

        <x-alert />

        @if(isset($autoError) && $autoError)
            <div class="p-4 rounded-2xl bg-rose-50 border-2 border-rose-200">
                <div class="flex items-start gap-2">
                    <div class="w-9 h-9 rounded-xl bg-rose-600 text-white flex items-center justify-center flex-shrink-0 shadow-lg shadow-rose-500/30">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    </div>
                    <div class="min-w-0">
                        <p class="font-extrabold text-rose-900 text-sm mb-0.5 flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-rose-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                            QR Code Gagal Diverifikasi (Auto-scan via URL)
                        </p>
                        <p class="text-sm text-rose-800 leading-relaxed">{{ $autoError }}</p>
                    </div>
                </div>
            </div>
        @endif

        @if(isset($autoPeminjaman) && $autoPeminjaman instanceof \App\Models\Peminjaman)
            <div class="p-4 rounded-2xl bg-emerald-50 border-2 border-emerald-200">
                <div class="flex items-start gap-3">
                    <div class="w-9 h-9 rounded-xl bg-emerald-600 text-white flex items-center justify-center flex-shrink-0 shadow-lg shadow-emerald-500/30">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="font-extrabold text-emerald-900 text-sm mb-0.5 flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            QR Code Valid! Deep-link dari Scanner terdeteksi.
                        </p>
                        <p class="text-sm text-emerald-800">Peminjaman <b>#{{ $autoPeminjaman->id }}</b> - Peminjam: <b>{{ $autoPeminjaman->user?->name ?? '?' }}</b> — klik tombol di bawah untuk lihat detail + aksi.</p>
                    </div>
                    <a href="{{ route('approval.scan-result', [$autoPeminjaman, 'sig' => $autoPayload['sig'] ?? '', 'from_scan' => 1]) }}"
                       class="shrink-0 px-4 py-2.5 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white font-bold text-xs shadow-xl shadow-emerald-500/30 transition-all">
                        Buka Hasil Scan &rarr;
                    </a>
                </div>
            </div>
        @endif

        <form method="POST" action="{{ route('approval.scan-process') }}" class="bg-white rounded-2xl border border-slate-200/50 shadow-xl shadow-slate-200/30 p-5 space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-extrabold text-slate-900 mb-2">
                    <span class="inline-flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        Isi QR Code (Text Hasil Scan)
                    </span>
                </label>
                <textarea
                    name="qr_content"
                    required
                    rows="5"
                    class="w-full px-4 py-3 rounded-xl font-mono text-xs bg-slate-50 border-2 border-slate-200 focus:border-indigo-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-indigo-500/10 transition-all resize-y"
                    placeholder='Contoh format valid:
sipbar://qr/eyJwaWQiOjEyMywidG9rIjoiYWJj... (tempel string dari scanner)
Ataupun JSON langsung valid seperti: {"pid":123,"tok":"xxx","st":"disetujui","d":"2026-07-28","sig":"..."}'
                >{{ old('qr_content') }}</textarea>
                <x-input-error for="qr_content" class="mt-1.5" />
                <p class="mt-2 text-[11px] text-slate-500 flex items-start gap-1.5">
                    <svg class="w-3.5 h-3.5 text-amber-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>Tips: Jika pakai HP scan QR → pilih <span class="font-bold">"Share / Bagikan Teks"</span> → paste ke sini, atau buka link <span class="font-mono text-indigo-600">?data=...</span> di browser.</span>
                </p>
            </div>

            <div class="flex items-center justify-end gap-2 pt-2">
                <a href="{{ route('approval.index') }}"
                   class="px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition-all">
                    ← Kembali ke List Verifikasi
                </a>
                <button type="submit"
                        class="inline-flex items-center gap-1.5 px-6 py-2.5 rounded-xl bg-gradient-to-r from-indigo-600 to-fuchsia-600 hover:from-indigo-700 hover:to-fuchsia-700 text-white text-xs font-extrabold uppercase tracking-wide shadow-xl shadow-indigo-500/30 transition-all">
                    <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    Verifikasi QR Code
                </button>
            </div>
        </form>
    </div>
</x-layouts.admin>
