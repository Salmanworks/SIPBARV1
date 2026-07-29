<x-layouts.admin title="Kelola Data Guru">
    <div class="space-y-6">
        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-gradient-to-r from-slate-900 to-amber-900 p-6 md:p-8 rounded-3xl shadow-2xl shadow-amber-900/30">
            <div class="space-y-1">
                <h1 class="text-2xl font-extrabold text-white tracking-tight">Manajemen Data Guru</h1>
                <p class="text-xs text-slate-300">Kelola data guru, NIP, jabatan, dan akun login guru</p>
            </div>

            <a href="{{ route('admin.guru.create') }}" class="inline-flex items-center justify-center gap-2 px-5 py-3 rounded-2xl bg-white text-amber-900 font-bold text-xs uppercase tracking-wider shadow-xl hover:bg-amber-50 hover:scale-105 transition-all duration-300">
                <x-icon name="plus" size="sm" />
                <span>Tambah Guru</span>
            </a>
        </div>

        <x-alert />

        {{-- Import Area --}}
        <div class="bg-white rounded-2xl border border-slate-200/50 shadow-lg shadow-slate-200/30 overflow-hidden">
            <div x-data="{ openImport: false }">
                <div class="flex flex-wrap items-center justify-between gap-3 p-4 border-b border-slate-100">
                    <div class="flex items-center gap-2 text-slate-700">
                        <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 text-white flex items-center justify-center shadow-lg shadow-emerald-500/20">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1M12 4v12m0 0l-4-4m4 4l4-4"/></svg>
                        </div>
                        <div>
                            <p class="font-bold text-sm">Import Massal via CSV/Excel</p>
                            <p class="text-xs text-slate-500">Upload ratusan data guru sekaligus, atau download template contoh isian</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 flex-wrap">
                        <a href="{{ route('admin.guru.download-template') }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition-all shadow-sm hover:shadow">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                            Download Template
                        </a>
                        <button type="button" @click="openImport = !openImport" class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white font-bold text-xs transition-all shadow-lg shadow-emerald-600/20">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                            Import CSV
                        </button>
                    </div>
                </div>

                <div x-show="openImport" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-cloak>
                    <form method="POST" action="{{ route('admin.guru.import') }}" enctype="multipart/form-data" class="p-5 border-t border-slate-100 bg-gradient-to-br from-emerald-50/50 to-white space-y-4">
                        @csrf
                        <div class="grid gap-4 md:grid-cols-3">
                            <div class="md:col-span-2">
                                <label for="guru-file" class="block text-xs font-extrabold uppercase tracking-wider text-slate-700 mb-2">
                                    Pilih File CSV / TXT / TSV <span class="text-rose-500">*</span>
                                </label>
                                <input id="guru-file" type="file" name="file" accept=".csv,.tsv,.txt" required
                                       class="w-full px-4 py-3 bg-white border border-slate-200 rounded-2xl text-xs font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-all @error('file') border-rose-500 bg-rose-50/30 @enderror" />
                                @error('file')
                                    <p class="text-xs font-semibold text-rose-500 mt-1.5">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="md:col-span-1 flex md:items-end">
                                <button type="submit" class="w-full inline-flex items-center justify-center gap-1.5 px-5 py-3 rounded-2xl bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white font-bold text-xs uppercase tracking-wider transition-all shadow-lg shadow-emerald-600/25">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    Mulai Import
                                </button>
                            </div>
                        </div>
                        <div class="text-[11px] leading-relaxed text-slate-600 space-y-1 border-t border-slate-200/60 pt-3">
                            <p><b>Format kolom template (berurutan):</b> NIP, Nama_Lengkap, Email, Jabatan, No_HP, Password</p>
                            <p>• Password boleh <b>dikosongi</b> — otomatis dibuat dari NIP dan user akan diminta ganti password saat login pertama.</p>
                            <p>• Jika NIP sudah ada di database, data tersebut akan <b>diperbarui</b> (bukan ditambah duplikat).</p>
                            <p>• Buka file template menggunakan Microsoft Excel, Google Sheet, atau LibreOffice Calc — lalu simpan ulang sebagai <b>CSV (Comma delimited)</b>.</p>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Filter Bar --}}
        <form method="GET" class="bg-white p-4 rounded-2xl border border-slate-200/50 shadow-lg shadow-slate-200/30 flex flex-wrap gap-3 items-center">
            <div class="relative flex-1 min-w-[250px]">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                    <x-icon name="magnifying-glass" size="sm" />
                </div>
                <input name="search" type="text" value="{{ request('search') }}" placeholder="Cari nama, NIP, jabatan, atau email..." class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:bg-white transition-all" />
            </div>

            <button type="submit" class="py-2.5 px-5 bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 text-white font-bold text-xs rounded-xl transition-all shadow-lg shadow-amber-500/20">
                Filter
            </button>
            <a href="{{ route('admin.guru.index') }}" class="py-2.5 px-5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition-all">
                Reset
            </a>
        </form>

        {{-- Guru Table --}}
        <div class="bg-white rounded-2xl border border-slate-200/50 shadow-lg shadow-slate-200/30 overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gradient-to-r from-slate-50 to-slate-100 border-b border-slate-200 text-xs font-extrabold uppercase tracking-wider text-slate-600">
                        <th class="px-6 py-4">Guru</th>
                        <th class="px-6 py-4">NIP</th>
                        <th class="px-6 py-4">Jabatan</th>
                        <th class="px-6 py-4">Email</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm font-medium text-slate-700">
                    @forelse($gurus as $guru)
                        <tr class="hover:bg-gradient-to-r hover:from-amber-50 hover:to-orange-50 transition-all duration-200">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-amber-500 to-orange-600 flex items-center justify-center text-white font-bold text-xs shadow-lg shadow-amber-500/20">
                                        {{ strtoupper(substr($guru->nama_lengkap, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-900 text-sm">{{ $guru->nama_lengkap }}</p>
                                        <p class="text-xs text-slate-400">No. HP: {{ $guru->no_hp ?? '—' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 font-mono font-semibold text-slate-800">
                                {{ $guru->nip }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-wider bg-slate-100 text-slate-700">
                                    {{ $guru->jabatan ?? 'Guru' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 font-mono text-slate-600 text-xs">
                                {{ $guru->user?->email ?? '—' }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.guru.edit', $guru) }}" class="px-3 py-1.5 bg-amber-50 hover:bg-amber-100 text-amber-700 font-bold text-xs rounded-lg transition-all shadow-sm hover:shadow-md">
                                        Edit
                                    </a>
                                    @if($guru->user_id !== auth()->id())
                                        <form method="POST" action="{{ route('admin.guru.destroy', $guru) }}" onsubmit="return confirm('Hapus data guru ini beserta akunnya?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="px-3 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-700 font-bold text-xs rounded-lg transition-all shadow-sm hover:shadow-md">
                                                Hapus
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-slate-100 to-slate-200 text-slate-400 flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                                </div>
                                <p class="text-slate-700 font-bold text-base">Belum ada data guru</p>
                                <p class="text-xs text-slate-500 mt-1">Mulai dengan menambahkan data guru baru ke sistem.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $gurus->links() }}
        </div>
    </div>
</x-layouts.admin>
