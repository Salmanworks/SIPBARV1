<x-layouts.admin title="Edit Data Siswa — {{ $siswa->nama_lengkap }}">
    <div class="max-w-2xl mx-auto space-y-6">

        {{-- Page Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 md:p-8 rounded-3xl border border-slate-200/80 shadow-soft">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.siswa.index') }}" class="w-10 h-10 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-600 flex items-center justify-center transition-colors flex-shrink-0" title="Kembali">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                </a>
                <div>
                    <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight font-display">Edit Data Siswa</h1>
                    <p class="text-xs text-slate-500 mt-0.5">Perbarui informasi siswa <strong>{{ $siswa->nama_lengkap }}</strong> beserta akunnya</p>
                </div>
            </div>
        </div>

        <x-alert />

        {{-- Form Container --}}
        <form method="POST" action="{{ route('admin.siswa.update', $siswa) }}" enctype="multipart/form-data" class="bg-white rounded-3xl border border-slate-200/80 shadow-soft p-6 md:p-8 space-y-6">
            @csrf
            @method('PUT')

            <div class="space-y-5">
                <div class="grid gap-5 sm:grid-cols-2">
                    <div>
                        <label for="nis" class="block text-xs font-extrabold uppercase tracking-wider text-slate-700 mb-2">
                            NIS <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" id="nis" name="nis" value="{{ old('nis', $siswa->nis) }}" required
                               class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all @error('nis') border-rose-500 bg-rose-50/30 @enderror" />
                        @error('nis')
                            <p class="text-xs font-semibold text-rose-500 mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="nama_lengkap" class="block text-xs font-extrabold uppercase tracking-wider text-slate-700 mb-2">
                            Nama Lengkap <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap', $siswa->nama_lengkap) }}" required
                               class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all @error('nama_lengkap') border-rose-500 bg-rose-50/30 @enderror" />
                        @error('nama_lengkap')
                            <p class="text-xs font-semibold text-rose-500 mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid gap-5 sm:grid-cols-2">
                    <div>
                        <label for="kelas" class="block text-xs font-extrabold uppercase tracking-wider text-slate-700 mb-2">
                            Kelas
                        </label>
                        <input type="text" id="kelas" name="kelas" value="{{ old('kelas', $siswa->kelas) }}" placeholder="Contoh: X-IPA-1"
                               class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all @error('kelas') border-rose-500 bg-rose-50/30 @enderror" />
                        @error('kelas')
                            <p class="text-xs font-semibold text-rose-500 mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="jurusan" class="block text-xs font-extrabold uppercase tracking-wider text-slate-700 mb-2">
                            Jurusan
                        </label>
                        <select id="jurusan" name="jurusan"
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all @error('jurusan') border-rose-500 bg-rose-50/30 @enderror">
                            <option value="">Pilih Jurusan (opsional)</option>
                            @php
                                $jurusans = ['IPA', 'IPS', 'Bahasa', 'Teknik Komputer', 'Teknik Mesin', 'Akuntansi', 'Pemasaran', 'Perhotelan'];
                            @endphp
                            @foreach($jurusans as $jrs)
                                <option value="{{ $jrs }}" @selected(old('jurusan', $siswa->jurusan) === $jrs)>{{ $jrs }}</option>
                            @endforeach
                        </select>
                        @error('jurusan')
                            <p class="text-xs font-semibold text-rose-500 mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid gap-5 sm:grid-cols-2">
                    <div>
                        <label for="email" class="block text-xs font-extrabold uppercase tracking-wider text-slate-700 mb-2">
                            Alamat Email
                        </label>
                        <input type="email" id="email" name="email" value="{{ old('email', $siswa->user?->email) }}"
                               class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all @error('email') border-rose-500 bg-rose-50/30 @enderror" />
                        @error('email')
                            <p class="text-xs font-semibold text-rose-500 mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="no_hp" class="block text-xs font-extrabold uppercase tracking-wider text-slate-700 mb-2">
                            No. HP / WhatsApp
                        </label>
                        <input type="tel" id="no_hp" name="no_hp" value="{{ old('no_hp', $siswa->no_hp) }}"
                               class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all @error('no_hp') border-rose-500 bg-rose-50/30 @enderror" />
                        @error('no_hp')
                            <p class="text-xs font-semibold text-rose-500 mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid gap-5 sm:grid-cols-2">
                    <div>
                        <label for="password" class="block text-xs font-extrabold uppercase tracking-wider text-slate-700 mb-2">
                            Password Baru <span class="text-slate-400 font-normal lowercase">(kosongkan = tidak diubah)</span>
                        </label>
                        <input type="password" id="password" name="password" placeholder="••••••••"
                               class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all @error('password') border-rose-500 bg-rose-50/30 @enderror" />
                        @error('password')
                            <p class="text-xs font-semibold text-rose-500 mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-xs font-extrabold uppercase tracking-wider text-slate-700 mb-2">
                            Konfirmasi Password
                        </label>
                        <input type="password" id="password_confirmation" name="password_confirmation" placeholder="••••••••"
                               class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all" />
                    </div>
                </div>

                <div>
                    <label for="foto" class="block text-xs font-extrabold uppercase tracking-wider text-slate-700 mb-2">
                        Foto Siswa
                    </label>
                    @if($siswa->foto)
                        <div class="mb-3 flex items-center gap-3">
                            <img src="{{ asset('storage/'.$siswa->foto) }}" alt="Foto Siswa" class="w-16 h-16 rounded-2xl object-cover border-2 border-slate-200">
                            <span class="text-xs font-semibold text-slate-600">Foto saat ini. Upload di bawah untuk mengganti.</span>
                        </div>
                    @endif
                    <input type="file" id="foto" name="foto" accept="image/*"
                           class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all @error('foto') border-rose-500 bg-rose-50/30 @enderror" />
                    @error('foto')
                        <p class="text-xs font-semibold text-rose-500 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="pt-6 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('admin.siswa.index') }}" class="px-6 py-3 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition-colors">
                    Batal
                </a>
                <button type="submit" class="inline-flex items-center gap-2 px-7 py-3 rounded-2xl bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold text-xs uppercase tracking-wider shadow-lg shadow-blue-600/25 hover:scale-[1.02] active:scale-[0.98] transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Perbarui Siswa
                </button>
            </div>
        </form>
    </div>
</x-layouts.admin>
