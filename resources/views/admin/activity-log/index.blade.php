<x-layouts.admin title="Activity Log — Jejak Audit Sistem">
    <div class="space-y-6">
        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-gradient-to-r from-slate-900 to-rose-900 p-6 md:p-8 rounded-3xl shadow-2xl shadow-rose-900/30">
            <div class="space-y-1">
                <h1 class="text-2xl font-extrabold text-white tracking-tight">Activity Log — Audit Trail</h1>
                <p class="text-xs text-slate-300">Mencatat seluruh perubahan data sistem: siapa, kapan, apa yang diubah, nilai lama & baru</p>
            </div>

            <div class="inline-flex items-center gap-2 px-4 py-2.5 rounded-2xl bg-white/10 backdrop-blur-sm border border-white/10 text-xs text-slate-200">
                <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>Auto-tracking aktif. Data tidak bisa diedit/dihapus (immutable log).</span>
            </div>
        </div>

        <x-alert />

        {{-- Filter Bar --}}
        <form method="GET" class="bg-white p-4 rounded-2xl border border-slate-200/50 shadow-lg shadow-slate-200/30 grid gap-3 items-end md:grid-cols-5">
            <div class="md:col-span-2 relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                    <x-icon name="magnifying-glass" size="sm" />
                </div>
                <input name="search" type="text" value="{{ request('search') }}" placeholder="Cari deskripsi, nama pelaku, atau email..." class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-rose-500 focus:bg-white transition-all" />
            </div>

            <select name="log_name" class="px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-rose-500 transition-all">
                <option value="">Semua Entitas</option>
                @foreach($logNameOptions as $val => $label)
                    <option value="{{ $val }}" @selected(request('log_name') === $val)>{{ $label }}</option>
                @endforeach
            </select>

            <select name="event" class="px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-rose-500 transition-all">
                <option value="">Semua Aksi</option>
                @foreach($eventOptions as $val => $label)
                    <option value="{{ $val }}" @selected(request('event') === $val)>{{ $label }}</option>
                @endforeach
            </select>

            <div class="flex gap-2">
                <button type="submit" class="flex-1 py-2.5 px-5 bg-gradient-to-r from-rose-600 to-rose-700 hover:from-rose-700 hover:to-rose-800 text-white font-bold text-xs rounded-xl transition-all shadow-lg shadow-rose-500/20">
                    Filter
                </button>
                <a href="{{ route('admin.activity-log.index') }}" class="py-2.5 px-4 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition-all">
                    Reset
                </a>
            </div>
        </form>

        {{-- Activity Table --}}
        <div class="bg-white rounded-2xl border border-slate-200/50 shadow-lg shadow-slate-200/30 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse min-w-[900px]">
                    <thead>
                        <tr class="bg-gradient-to-r from-slate-50 to-slate-100 border-b border-slate-200 text-xs font-extrabold uppercase tracking-wider text-slate-600">
                            <th class="px-6 py-4 w-44">Waktu</th>
                            <th class="px-6 py-4 w-40">Actor (Pelaku)</th>
                            <th class="px-6 py-4 w-32">Entitas</th>
                            <th class="px-6 py-4 w-28">Aksi</th>
                            <th class="px-6 py-4">Deskripsi & Detail Perubahan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm font-medium text-slate-700">
                        @forelse($logs as $log)
                            @php
                                $badgeColor = match($log->event) {
                                    'created' => 'bg-emerald-100 text-emerald-800 border-emerald-200',
                                    'updated' => 'bg-amber-100 text-amber-800 border-amber-200',
                                    'deleted' => 'bg-rose-100 text-rose-800 border-rose-200',
                                    'restored' => 'bg-sky-100 text-sky-800 border-sky-200',
                                    default => 'bg-slate-100 text-slate-800 border-slate-200',
                                };
                                $logNameBadge = match($log->log_name) {
                                    'peminjaman','detail_peminjaman','denda' => 'bg-indigo-100 text-indigo-800',
                                    'guru','siswa','user' => 'bg-amber-100 text-amber-800',
                                    'barang','kategori' => 'bg-teal-100 text-teal-800',
                                    default => 'bg-slate-100 text-slate-800',
                                };
                                $properties = $log->properties?->toArray() ?? [];
                            @endphp
                            <tr class="hover:bg-gradient-to-r hover:from-slate-50 hover:to-slate-100 transition-all duration-200 align-top">
                                <td class="px-6 py-4 align-top">
                                    <div class="text-xs font-bold text-slate-900">{{ $log->created_at?->format('d M Y') }}</div>
                                    <div class="text-[10px] font-semibold text-slate-500 font-mono mt-0.5">{{ $log->created_at?->format('H:i:s') }} WIB</div>
                                    <div class="text-[10px] font-mono text-slate-400 mt-1">ID #{{ $log->id }}</div>
                                </td>
                                <td class="px-6 py-4 align-top">
                                    @if($log->causer)
                                        <div class="flex items-center gap-2">
                                            <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-slate-700 to-slate-900 text-white flex items-center justify-center font-bold text-xs flex-shrink-0">
                                                {{ strtoupper(substr($log->causer->name ?? '?', 0, 1)) }}
                                            </div>
                                            <div class="min-w-0">
                                                <p class="font-bold text-slate-900 text-xs truncate">{{ $log->causer->name ?? 'System' }}</p>
                                                <p class="text-[10px] font-mono text-slate-500 truncate">{{ $log->causer->email ?? '' }}</p>
                                                @if(method_exists($log->causer, 'role') || property_exists($log->causer, 'role'))
                                                    <span class="inline-block mt-0.5 px-2 py-0.5 rounded-full bg-slate-100 text-slate-700 font-extrabold uppercase tracking-wider text-[9px]">
                                                        {{ is_object($log->causer->role) ? $log->causer->role->label() : ($log->causer->role ?? '') }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    @else
                                        <span class="px-2.5 py-1 rounded-full bg-slate-100 text-slate-600 text-[10px] font-bold uppercase tracking-wider">System / CLI</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 align-top">
                                    <span class="px-2.5 py-1 rounded-lg text-[10px] font-extrabold uppercase tracking-wider border {{ $logNameBadge }}">
                                        {{ $logNameOptions[$log->log_name] ?? ucfirst(str_replace('_', ' ', (string) $log->log_name)) }}
                                    </span>
                                    @if($log->subject_type)
                                        <div class="mt-1.5 text-[10px] font-mono text-slate-500 break-all">
                                            ID: {{ $log->subject_id ?? '—' }}
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 align-top">
                                    <span class="px-2.5 py-1 rounded-lg text-[10px] font-extrabold uppercase tracking-wider border {{ $badgeColor }}">
                                        {{ $eventOptions[$log->event] ?? ucfirst((string) $log->event) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 align-top">
                                    <p class="font-bold text-slate-900 text-xs leading-relaxed mb-2">{{ $log->description }}</p>

                                    @if(! empty($properties))
                                        <div class="space-y-1.5 text-[11px] leading-relaxed">
                                            @if(! empty($properties['old']))
                                                <details class="group rounded-xl bg-rose-50 border border-rose-100 open:bg-rose-50">
                                                    <summary class="cursor-pointer select-none list-none px-2.5 py-1.5 font-bold text-rose-800 flex items-center justify-between gap-2">
                                                        <span class="inline-flex items-center gap-1">
                                                            <x-icon name="arrow-uturn-left" size="sm" class="w-3 h-3" />
                                                            Nilai Sebelumnya ({{ count($properties['old']) }} diubah)
                                                        </span>
                                                        <span class="text-[9px] font-mono text-rose-600 group-open:hidden">▲ expand</span>
                                                        <span class="text-[9px] font-mono text-rose-600 hidden group-open:inline">▼ collapse</span>
                                                    </summary>
                                                    <pre class="px-2.5 pb-2 pt-1 text-[10px] font-mono text-rose-900 overflow-x-auto whitespace-pre-wrap">{{ json_encode($properties['old'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                                                </details>
                                            @endif
                                            @if(! empty($properties['attributes']))
                                                <details class="group rounded-xl bg-emerald-50 border border-emerald-100 open:bg-emerald-50">
                                                    <summary class="cursor-pointer select-none list-none px-2.5 py-1.5 font-bold text-emerald-800 flex items-center justify-between gap-2">
                                                        <span class="inline-flex items-center gap-1">
                                                            <x-icon name="sparkles" size="sm" class="w-3 h-3" />
                                                            Nilai Terbaru ({{ count($properties['attributes']) }} kolom)
                                                        </span>
                                                        <span class="text-[9px] font-mono text-emerald-600 group-open:hidden">▲ expand</span>
                                                        <span class="text-[9px] font-mono text-emerald-600 hidden group-open:inline">▼ collapse</span>
                                                    </summary>
                                                    <pre class="px-2.5 pb-2 pt-1 text-[10px] font-mono text-emerald-900 overflow-x-auto whitespace-pre-wrap">{{ json_encode($properties['attributes'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                                                </details>
                                            @endif
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-16 text-center">
                                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-slate-100 to-slate-200 text-slate-400 flex items-center justify-center mx-auto mb-4">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                    </div>
                                    <p class="text-slate-700 font-bold text-base">Belum ada activity log yang tercatat</p>
                                    <p class="text-xs text-slate-500 mt-1">Lakukan CRUD pada modul apapun — log akan tersimpan otomatis.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-4">
            {{ $logs->links() }}
        </div>
    </div>
</x-layouts.admin>
