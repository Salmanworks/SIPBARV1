<x-layouts.admin title="Kelola Pengguna">
    <div class="space-y-8">
        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 md:p-8 rounded-3xl border border-slate-200/80 shadow-soft">
            <div>
                <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight font-display">Manajemen Pengguna</h1>
                <p class="text-xs text-slate-600 mt-1">Kelola data pengguna, hak akses role (Admin, Petugas, Peminjam), dan nomor induk</p>
            </div>
            
            <a href="{{ route('admin.users.create') }}" class="inline-flex items-center justify-center gap-2 px-5 py-3 rounded-2xl bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold text-xs uppercase tracking-wider shadow-lg shadow-blue-600/30 hover:scale-[1.02] transition-all">
                <x-icon name="plus" size="sm" />
                <span>Tambah Pengguna</span>
            </a>
        </div>

        <x-alert />

        {{-- Filter Bar --}}
        <form method="GET" class="bg-white p-4 rounded-3xl border border-slate-200/80 shadow-soft flex flex-wrap gap-3 items-center">
            <div class="relative flex-1 min-w-[220px]">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <x-icon name="magnifying-glass" size="sm" />
                </div>
                <input name="search" type="text" value="{{ request('search') }}" placeholder="Cari nama, email, atau no. induk..." class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white" />
            </div>

            <select name="role" class="px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 min-w-[160px]">
                <option value="">Semua Peran / Role</option>
                @foreach(\App\Enums\UserRole::cases() as $role)
                    <option value="{{ $role->value }}" @selected(request('role') === $role->value)>{{ $role->label() }}</option>
                @endforeach
            </select>

            <button type="submit" class="py-2.5 px-5 bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs rounded-2xl transition-colors">
                Filter
            </button>
            <a href="{{ route('admin.users.index') }}" class="py-2.5 px-4 bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold text-xs rounded-2xl transition-colors">
                Reset
            </a>
        </form>

        {{-- Users Table --}}
        <div class="bg-white rounded-3xl border border-slate-200/80 shadow-soft overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/80 border-b border-slate-100 text-[11px] font-extrabold uppercase tracking-wider text-slate-600">
                        <th class="px-6 py-4">Nama Pengguna</th>
                        <th class="px-6 py-4">Alamat Email</th>
                        <th class="px-6 py-4">No. Induk (NIS/NIP)</th>
                        <th class="px-6 py-4">Peran (Role)</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs font-medium text-slate-700">
                    @forelse($users as $user)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white font-bold text-xs shadow-md">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-900 text-xs">{{ $user->name }}</p>
                                        <p class="text-[11px] text-slate-400">ID: #{{ $user->id }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 font-mono text-slate-600">
                                {{ $user->email }}
                            </td>
                            <td class="px-6 py-4 font-mono font-semibold text-slate-800">
                                {{ $user->no_induk ?? '—' }}
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $roleColor = match($user->role->value ?? '') {
                                        'admin' => 'bg-rose-50 text-rose-700 border-rose-100',
                                        'petugas' => 'bg-amber-50 text-amber-700 border-amber-100',
                                        default => 'bg-blue-50 text-blue-700 border-blue-100',
                                    };
                                @endphp
                                <span class="px-3 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-wider border {{ $roleColor }}">
                                    {{ $user->role->label() }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.users.edit', $user) }}" class="px-3 py-1.5 bg-blue-50 hover:bg-blue-100 text-blue-700 font-bold text-xs rounded-xl transition-colors">
                                        Edit
                                    </a>
                                    @if($user->id !== auth()->id())
                                        <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Hapus pengguna ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="px-3 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-700 font-bold text-xs rounded-xl transition-colors">
                                                Hapus
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                                Belum ada pengguna terdaftar.
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
