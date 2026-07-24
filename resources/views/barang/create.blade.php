<x-layouts.admin title="Tambah Barang Baru">
    <div class="max-w-4xl mx-auto space-y-6">
        
        {{-- Page Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 md:p-8 rounded-3xl border border-slate-200/80 shadow-soft">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.barang.index') }}" class="w-10 h-10 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-600 flex items-center justify-center transition-colors flex-shrink-0" title="Kembali">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                </a>
                <div>
                    <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight font-display">Tambah Barang Baru</h1>
                    <p class="text-xs text-slate-500 mt-0.5">Isi rincian informasi barang inventaris untuk ditambahkan ke katalog sistem</p>
                </div>
            </div>
            <div class="hidden sm:block">
                <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-blue-50 text-blue-700 text-xs font-bold border border-blue-100">
                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Form Inventaris
                </span>
            </div>
        </div>

        <x-alert />

        {{-- Form Container --}}
        <form method="POST" action="{{ route('admin.barang.store') }}" enctype="multipart/form-data" class="bg-white rounded-3xl border border-slate-200/80 shadow-soft p-6 md:p-8 space-y-6">
            @csrf

            <div class="grid gap-6 lg:grid-cols-3">
                {{-- Left Section: Fields (2 Cols) --}}
                <div class="lg:col-span-2 space-y-5">
                    
                    {{-- Kode & Nama Barang --}}
                    <div class="grid gap-5 sm:grid-cols-2">
                        <div>
                            <label for="kode_barang" class="block text-xs font-extrabold uppercase tracking-wider text-slate-700 mb-2">
                                Kode Barang <span class="text-rose-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h10M7 12h10M7 17h10"/></svg>
                                </div>
                                <input type="text" id="kode_barang" name="kode_barang" value="{{ old('kode_barang') }}" placeholder="Contoh: BRG-001" required
                                       class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all uppercase placeholder:normal-case @error('kode_barang') border-rose-500 bg-rose-50/30 @enderror" />
                            </div>
                            @error('kode_barang')
                                <p class="text-xs font-semibold text-rose-500 mt-1.5 flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div>
                            <label for="nama_barang" class="block text-xs font-extrabold uppercase tracking-wider text-slate-700 mb-2">
                                Nama Barang <span class="text-rose-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                                </div>
                                <input type="text" id="nama_barang" name="nama_barang" value="{{ old('nama_barang') }}" placeholder="Nama perangkat / barang..." required
                                       class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all @error('nama_barang') border-rose-500 bg-rose-50/30 @enderror" />
                            </div>
                            @error('nama_barang')
                                <p class="text-xs font-semibold text-rose-500 mt-1.5 flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>

                    {{-- Kategori & Stok --}}
                    <div class="grid gap-5 sm:grid-cols-2">
                        <div>
                            <label for="kategori_id" class="block text-xs font-extrabold uppercase tracking-wider text-slate-700 mb-2">
                                Kategori <span class="text-rose-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                                </div>
                                <select id="kategori_id" name="kategori_id" required
                                        class="w-full pl-10 pr-8 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all appearance-none @error('kategori_id') border-rose-500 bg-rose-50/30 @enderror">
                                    <option value="" disabled selected>-- Pilih Kategori --</option>
                                    @foreach($kategoris as $kategori)
                                        <option value="{{ $kategori->id }}" @selected(old('kategori_id') == $kategori->id)>{{ $kategori->nama_kategori }}</option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none text-slate-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                </div>
                            </div>
                            @error('kategori_id')
                                <p class="text-xs font-semibold text-rose-500 mt-1.5">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="stok" class="block text-xs font-extrabold uppercase tracking-wider text-slate-700 mb-2">
                                Stok Awal <span class="text-rose-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/></svg>
                                </div>
                                <input type="number" id="stok" name="stok" min="0" value="{{ old('stok', 0) }}" required
                                       class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all @error('stok') border-rose-500 bg-rose-50/30 @enderror" />
                            </div>
                            @error('stok')
                                <p class="text-xs font-semibold text-rose-500 mt-1.5">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Kondisi Barang --}}
                    <div>
                        <label class="block text-xs font-extrabold uppercase tracking-wider text-slate-700 mb-2">
                            Kondisi Barang <span class="text-rose-500">*</span>
                        </label>
                        <div class="grid grid-cols-2 gap-4">
                            <label class="relative flex items-center gap-3 p-3.5 rounded-2xl border border-slate-200 bg-slate-50 cursor-pointer hover:bg-emerald-50/60 hover:border-emerald-200 transition-all has-[:checked]:bg-emerald-50 has-[:checked]:border-emerald-500 has-[:checked]:ring-2 has-[:checked]:ring-emerald-500/20">
                                <input type="radio" name="kondisi" value="baik" class="w-4 h-4 text-emerald-600 border-slate-300 focus:ring-emerald-500" @checked(old('kondisi', 'baik') === 'baik') required />
                                <div>
                                    <span class="block text-xs font-bold text-slate-900">Baik</span>
                                    <span class="block text-[10px] text-slate-500">Siap dipinjam & digunakan</span>
                                </div>
                            </label>

                            <label class="relative flex items-center gap-3 p-3.5 rounded-2xl border border-slate-200 bg-slate-50 cursor-pointer hover:bg-rose-50/60 hover:border-rose-200 transition-all has-[:checked]:bg-rose-50 has-[:checked]:border-rose-500 has-[:checked]:ring-2 has-[:checked]:ring-rose-500/20">
                                <input type="radio" name="kondisi" value="rusak" class="w-4 h-4 text-rose-600 border-slate-300 focus:ring-rose-500" @checked(old('kondisi') === 'rusak') />
                                <div>
                                    <span class="block text-xs font-bold text-slate-900">Rusak</span>
                                    <span class="block text-[10px] text-slate-500">Perlu perbaikan / maintenance</span>
                                </div>
                            </label>
                        </div>
                        @error('kondisi')
                            <p class="text-xs font-semibold text-rose-500 mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Deskripsi --}}
                    <div>
                        <label for="deskripsi" class="block text-xs font-extrabold uppercase tracking-wider text-slate-700 mb-2">
                            Deskripsi Barang <span class="text-slate-400 font-normal lowercase">(opsional)</span>
                        </label>
                        <textarea id="deskripsi" name="deskripsi" rows="4" placeholder="Tuliskan spesifikasi lengkap, nomor seri, atau keterangan barang..."
                                  class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all resize-none @error('deskripsi') border-rose-500 bg-rose-50/30 @enderror">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <p class="text-xs font-semibold text-rose-500 mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Right Section: Image Upload (1 Col) --}}
                <div class="space-y-3">
                    <label class="block text-xs font-extrabold uppercase tracking-wider text-slate-700">
                        Foto Barang <span class="text-slate-400 font-normal lowercase">(opsional)</span>
                    </label>

                    <div class="bg-slate-50/80 border-2 border-dashed border-slate-300 rounded-3xl p-5 text-center flex flex-col items-center justify-center min-h-[280px] relative group hover:border-blue-500 hover:bg-blue-50/30 transition-all">
                        
                        {{-- Hidden File Input --}}
                        <input type="file" id="foto" name="foto" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" onchange="previewImage(event)" />

                        {{-- Preview Container --}}
                        <div id="preview-wrapper" class="hidden w-full h-full flex-col items-center">
                            <img id="preview-img" src="#" alt="Pratinjau Foto" class="w-full h-48 object-cover rounded-2xl shadow-sm border border-slate-200 mb-3" />
                            <p class="text-[11px] font-bold text-slate-600 truncate max-w-[200px]" id="preview-filename"></p>
                            <span class="text-[10px] text-blue-600 font-bold mt-1">Klik untuk mengganti foto</span>
                        </div>

                        {{-- Default Placeholder --}}
                        <div id="placeholder-wrapper" class="flex flex-col items-center">
                            <div class="w-14 h-14 rounded-2xl bg-blue-100 text-blue-600 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                            <p class="text-xs font-bold text-slate-800">Unggah Gambar Barang</p>
                            <p class="text-[11px] text-slate-500 mt-1 max-w-[180px]">Seret & lepas foto atau klik di sini untuk memilih file</p>
                            <span class="mt-3 px-3 py-1 bg-white border border-slate-200 text-slate-600 rounded-xl text-[10px] font-extrabold shadow-2xs">
                                JPG, PNG, WEBP (Maks 2MB)
                            </span>
                        </div>
                    </div>
                    @error('foto')
                        <p class="text-xs font-semibold text-rose-500 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="pt-6 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('admin.barang.index') }}" class="px-6 py-3 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition-colors">
                    Batal
                </a>
                <button type="submit" class="inline-flex items-center gap-2 px-7 py-3 rounded-2xl bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold text-xs uppercase tracking-wider shadow-lg shadow-blue-600/25 hover:scale-[1.02] active:scale-[0.98] transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Simpan Barang
                </button>
            </div>
        </form>
    </div>

    {{-- Image Preview Script --}}
    <script>
        function previewImage(event) {
            const input = event.target;
            const previewWrapper = document.getElementById('preview-wrapper');
            const placeholderWrapper = document.getElementById('placeholder-wrapper');
            const previewImg = document.getElementById('preview-img');
            const previewFilename = document.getElementById('preview-filename');

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    previewFilename.textContent = input.files[0].name;
                    previewWrapper.classList.remove('hidden');
                    previewWrapper.classList.add('flex');
                    placeholderWrapper.classList.add('hidden');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</x-layouts.admin>
