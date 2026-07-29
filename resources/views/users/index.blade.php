<x-layouts.admin title="Kelola Pengguna">
    <div class="space-y-6">
        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-gradient-to-r from-slate-900 to-blue-900 p-6 md:p-8 rounded-3xl shadow-2xl shadow-blue-900/30">
            <div class="space-y-1">
                <h1 class="text-2xl font-extrabold text-white tracking-tight">Manajemen Pengguna</h1>
                <p class="text-xs text-slate-300">Kelola data pengguna, hak akses role (Admin, Petugas, Peminjam), dan nomor induk</p>
            </div>
            
            <a href="{{ route('admin.users.create') }}" class="inline-flex items-center justify-center gap-2 px-5 py-3 rounded-2xl bg-white text-blue-900 font-bold text-xs uppercase tracking-wider shadow-xl hover:bg-blue-50 hover:scale-105 transition-all duration-300">
                <x-icon name="plus" size="sm" />
                <span>Tambah Pengguna</span>
            </a>
        </div>

        <x-alert />

        {{-- Filter Bar --}}
        <form method="GET" class="bg-white p-4 rounded-2xl border border-slate-200/50 shadow-lg shadow-slate-200/30 flex flex-wrap gap-3 items-center">
            <div class="relative flex-1 min-w-[250px]">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                    <x-icon name="magnifying-glass" size="sm" />
                </div>
                <input name="search" type="text" value="{{ request('search') }}" placeholder="Cari nama, email, atau no. induk..." class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all" />
            </div>

            <select name="role" class="px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 min-w-[160px] transition-all">
                <option value="">Semua Peran / Role</option>
                @foreach(\App\Enums\UserRole::cases() as $role)
                    <option value="{{ $role->value }}" @selected(request('role') === $role->value)>{{ $role->label() }}</option>
                @endforeach
            </select>

            <button type="submit" class="py-2.5 px-5 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-bold text-xs rounded-xl transition-all shadow-lg shadow-blue-500/20">
                Filter
            </button>
            <a href="{{ route('admin.users.index') }}" class="py-2.5 px-5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition-all">
                Reset
            </a>
        </form>

        {{-- Users Table --}}
        <div class="bg-white rounded-2xl border border-slate-200/50 shadow-lg shadow-slate-200/30 overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gradient-to-r from-slate-50 to-slate-100 border-b border-slate-200 text-xs font-extrabold uppercase tracking-wider text-slate-600">
                        <th class="px-6 py-4">Nama Pengguna</th>
                        <th class="px-6 py-4">Alamat Email</th>
                        <th class="px-6 py-4">No. Induk (NIS/NIP)</th>
                        <th class="px-6 py-4">Peran (Role)</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm font-medium text-slate-700">
                    @forelse($users as $user)
                        <tr class="hover:bg-gradient-to-r hover:from-blue-50 hover:to-indigo-50 transition-all duration-200">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white font-bold text-xs shadow-lg shadow-blue-500/20">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-900 text-sm">{{ $user->name }}</p>
                                        <p class="text-xs text-slate-400">ID: #{{ $user->id }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 font-mono text-slate-600">
                                {{ $user->email }}
                            </td>
                            <td class="px-6 py-4 font-mono font-semibold text-slate-800">
                                {{ $user->identitas ?? '—' }}
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $roleColor = match($user->role->value ?? '') {
                                        'admin' => 'bg-gradient-to-r from-rose-500 to-rose-600 text-white shadow-lg shadow-rose-500/30',
                                        'guru' => 'bg-gradient-to-r from-amber-500 to-amber-600 text-white shadow-lg shadow-amber-500/30',
                                        default => 'bg-gradient-to-r from-blue-500 to-blue-600 text-white shadow-lg shadow-blue-500/30',
                                    };
                                @endphp
                                <span class="px-3 py-1.5 rounded-full text-xs font-extrabold uppercase tracking-wider {{ $roleColor }}">
                                    {{ $user->role->label() }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.users.edit', $user) }}" class="px-3 py-1.5 bg-blue-50 hover:bg-blue-100 text-blue-700 font-bold text-xs rounded-lg transition-all shadow-sm hover:shadow-md">
                                        Edit
                                    </a>
                                    @if($user->id !== auth()->id())
                                        <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Hapus pengguna ini?')">
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
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                </div>
                                <p class="text-slate-700 font-bold text-base">Belum ada pengguna terdaftar</p>
                                <p class="text-xs text-slate-500 mt-1">Mulai dengan menambahkan pengguna baru ke sistem.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $users->links() }}
        </div>
    </div>
</x-layouts.admin>
