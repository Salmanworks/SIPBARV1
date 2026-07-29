<x-layouts.admin title="Kelola Data Siswa">
    <div class="space-y-6">
        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-gradient-to-r from-slate-900 to-blue-900 p-6 md:p-8 rounded-3xl shadow-2xl shadow-blue-900/30">
            <div class="space-y-1">
                <h1 class="text-2xl font-extrabold text-white tracking-tight">Manajemen Data Siswa</h1>
                <p class="text-xs text-slate-300">Kelola data siswa, NIS, kelas, jurusan, dan akun login siswa</p>
            </div>

            <a href="{{ route('admin.siswa.create') }}" class="inline-flex items-center justify-center gap-2 px-5 py-3 rounded-2xl bg-white text-blue-900 font-bold text-xs uppercase tracking-wider shadow-xl hover:bg-blue-50 hover:scale-105 transition-all duration-300">
                <x-icon name="plus" size="sm" />
                <span>Tambah Siswa</span>
            </a>
        </div>

        <x-alert />

        {{-- Import Area --}}
        <div class="bg-white rounded-2xl border border-slate-200/50 shadow-lg shadow-slate-200/30 overflow-hidden">
            <div x-data="{ openImport: false }">
                <div class="flex flex-wrap items-center justify-between gap-3 p-4 border-b border-slate-100">
                    <div class="flex items-center gap-2 text-slate-700">
                        <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-sky-500 to-blue-600 text-white flex items-center justify-center shadow-lg shadow-sky-500/20">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1M12 4v12m0 0l-4-4m4 4l4-4"/></svg>
                        </div>
                        <div>
                            <p class="font-bold text-sm">Import Massal via CSV/Excel</p>
                            <p class="text-xs text-slate-500">Upload ratusan data siswa sekaligus, atau download template contoh isian</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 flex-wrap">
                        <a href="{{ route('admin.siswa.download-template') }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition-all shadow-sm hover:shadow">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                            Download Template
                        </a>
                        <button type="button" @click="openImport = !openImport" class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-gradient-to-r from-sky-600 to-blue-600 hover:from-sky-700 hover:to-blue-700 text-white font-bold text-xs transition-all shadow-lg shadow-sky-600/20">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                            Import CSV
                        </button>
                    </div>
                </div>

                <div x-show="openImport" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-cloak>
                    <form method="POST" action="{{ route('admin.siswa.import') }}" enctype="multipart/form-data" class="p-5 border-t border-slate-100 bg-gradient-to-br from-sky-50/50 to-white space-y-4">
                        @csrf
                        <div class="grid gap-4 md:grid-cols-3">
                            <div class="md:col-span-2">
                                <label for="siswa-file" class="block text-xs font-extrabold uppercase tracking-wider text-slate-700 mb-2">
                                    Pilih File CSV / TXT / TSV <span class="text-rose-500">*</span>
                                </label>
                                <input id="siswa-file" type="file" name="file" accept=".csv,.tsv,.txt" required
                                       class="w-full px-4 py-3 bg-white border border-slate-200 rounded-2xl text-xs font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-sky-500 transition-all @error('file') border-rose-500 bg-rose-50/30 @enderror" />
                                @error('file')
                                    <p class="text-xs font-semibold text-rose-500 mt-1.5">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="md:col-span-1 flex md:items-end">
                                <button type="submit" class="w-full inline-flex items-center justify-center gap-1.5 px-5 py-3 rounded-2xl bg-gradient-to-r from-sky-600 to-blue-600 hover:from-sky-700 hover:to-blue-700 text-white font-bold text-xs uppercase tracking-wider transition-all shadow-lg shadow-sky-600/25">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    Mulai Import
                                </button>
                            </div>
                        </div>
                        <div class="text-[11px] leading-relaxed text-slate-600 space-y-1 border-t border-slate-200/60 pt-3">
                            <p><b>Format kolom template (berurutan):</b> NIS, Nama_Lengkap, Kelas, Jurusan, Email, No_HP, Password</p>
                            <p>• Email & Password boleh <b>dikosongi</b> — email auto dibuat <code>siswa_{NIS}@sipbar.sch.id</code>, password auto dari NIS.</p>
                            <p>• Jika NIS sudah ada di database, data tersebut akan <b>diperbarui</b> (bukan ditambah duplikat).</p>
                            <p>• Simpan file hasil edit Excel/Google Sheet sebagai <b>CSV (Comma delimited)</b> sebelum di-upload.</p>
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
                <input name="search" type="text" value="{{ request('search') }}" placeholder="Cari nama, NIS, kelas, atau email..." class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all" />
            </div>

            <select name="kelas" class="px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 min-w-[140px] transition-all">
                <option value="">Semua Kelas</option>
                @foreach($kelasOptions as $kls)
                    <option value="{{ $kls }}" @selected(request('kelas') === $kls)>{{ $kls }}</option>
                @endforeach
            </select>

            <select name="jurusan" class="px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 min-w-[160px] transition-all">
                <option value="">Semua Jurusan</option>
                @foreach($jurusanOptions as $jrs)
                    <option value="{{ $jrs }}" @selected(request('jurusan') === $jrs)>{{ $jrs }}</option>
                @endforeach
            </select>

            <button type="submit" class="py-2.5 px-5 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-bold text-xs rounded-xl transition-all shadow-lg shadow-blue-500/20">
                Filter
            </button>
            <a href="{{ route('admin.siswa.index') }}" class="py-2.5 px-5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition-all">
                Reset
            </a>
        </form>

        {{-- Siswa Table --}}
        <div class="bg-white rounded-2xl border border-slate-200/50 shadow-lg shadow-slate-200/30 overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gradient-to-r from-slate-50 to-slate-100 border-b border-slate-200 text-xs font-extrabold uppercase tracking-wider text-slate-600">
                        <th class="px-6 py-4">Siswa</th>
                        <th class="px-6 py-4">NIS</th>
                        <th class="px-6 py-4">Kelas / Jurusan</th>
                        <th class="px-6 py-4">Email</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm font-medium text-slate-700">
                    @forelse($siswas as $siswa)
                        <tr class="hover:bg-gradient-to-r hover:from-blue-50 hover:to-indigo-50 transition-all duration-200">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white font-bold text-xs shadow-lg shadow-blue-500/20">
                                        {{ strtoupper(substr($siswa->nama_lengkap, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-900 text-sm">{{ $siswa->nama_lengkap }}</p>
                                        <p class="text-xs text-slate-400">No. HP: {{ $siswa->no_hp ?? '—' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 font-mono font-semibold text-slate-800">
                                {{ $siswa->nis }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-col gap-1">
                                    @if($siswa->kelas)
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-wider bg-blue-100 text-blue-700 w-fit">
                                            {{ $siswa->kelas }}
                                        </span>
                                    @endif
                                    @if($siswa->jurusan)
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-wider bg-indigo-100 text-indigo-700 w-fit">
                                            {{ $siswa->jurusan }}
                                        </span>
                                    @endif
                                    @if(!$siswa->kelas && !$siswa->jurusan)
                                        <span class="text-xs text-slate-400">—</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 font-mono text-slate-600 text-xs">
                                {{ $siswa->user?->email ?? '—' }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.siswa.edit', $siswa) }}" class="px-3 py-1.5 bg-blue-50 hover:bg-blue-100 text-blue-700 font-bold text-xs rounded-lg transition-all shadow-sm hover:shadow-md">
                                        Edit
                                    </a>
                                    @if($siswa->user_id !== auth()->id())
                                        <form method="POST" action="{{ route('admin.siswa.destroy', $siswa) }}" onsubmit="return confirm('Hapus data siswa ini beserta akunnya?')">
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
                                <p class="text-slate-700 font-bold text-base">Belum ada data siswa</p>
                                <p class="text-xs text-slate-500 mt-1">Mulai dengan menambahkan data siswa baru ke sistem.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $siswas->links() }}
        </div>
    </div>
</x-layouts.admin>
