<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    @include('partials.head')
    <title>{{ $title ?? 'Dashboard' }} — SIPBAR</title>
    <style>
        /* ── App shell ─────────────────────────────── */
        #app-shell {
            display: flex !important;
            height: 100vh !important;
            overflow: hidden !important;
            width: 100% !important;
        }

        /* ── Sidebar ────────────────────────────────── */
        #sidebar {
            width: 256px !important;
            min-width: 256px !important;
            max-width: 256px !important;
            flex-shrink: 0 !important;
            background: #ffffff !important;
            border-right: 1px solid #e2e8f0 !important;
            display: flex !important;
            flex-direction: column !important;
            height: 100vh !important;
            position: relative !important;
            z-index: 50 !important;
            transform: none !important;
        }

        #sidebar-brand {
            height: 64px !important;
            display: flex !important;
            align-items: center !important;
            padding: 0 20px !important;
            border-bottom: 1px solid #e2e8f0 !important;
            flex-shrink: 0 !important;
            box-sizing: border-box !important;
        }

        #sidebar-nav {
            flex: 1 !important;
            overflow-y: auto !important;
            padding: 12px 10px !important;
        }

        #sidebar-nav::-webkit-scrollbar { width: 3px; }
        #sidebar-nav::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 99px; }

        #sidebar-footer {
            padding: 12px !important;
            border-top: 1px solid #f1f5f9 !important;
            flex-shrink: 0 !important;
        }

        /* ── Main area ──────────────────────────────── */
        #main-area {
            flex: 1 !important;
            min-width: 0 !important;
            display: flex !important;
            flex-direction: column !important;
            overflow: hidden !important;
            background: #f1f5f9 !important;
        }

        #top-navbar {
            height: 64px !important;
            min-height: 64px !important;
            background: #ffffff !important;
            border-bottom: 1px solid #e2e8f0 !important;
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
            padding: 0 24px !important;
            flex-shrink: 0 !important;
            box-sizing: border-box !important;
            box-shadow: 0 1px 3px rgba(15,23,42,0.06) !important;
        }

        #page-content {
            flex: 1 !important;
            overflow-y: auto !important;
            padding: 24px !important;
            box-sizing: border-box !important;
        }

        /* ── Nav items ──────────────────────────────── */
        .nav-group-label {
            font-size: 10px;
            font-weight: 800;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            padding: 18px 12px 6px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 12px;
            border-radius: 10px;
            font-size: 13.5px;
            font-weight: 600;
            color: #475569;
            text-decoration: none;
            transition: all 0.15s ease;
            margin-bottom: 1px;
        }

        .nav-item:hover {
            background: #eff6ff;
            color: #2563eb;
        }

        .nav-item.active {
            background: linear-gradient(135deg, #3b82f6, #6366f1);
            color: #ffffff;
            box-shadow: 0 3px 10px rgba(99,102,241,0.25);
        }

        .nav-item.active svg { color: #ffffff; }

        .nav-item svg { width: 17px; height: 17px; flex-shrink: 0; }

        /* ── Mobile sidebar ─────────────────────────── */
        @media (max-width: 1023px) {
            #sidebar {
                position: fixed !important;
                top: 0 !important;
                left: 0 !important;
                bottom: 0 !important;
                height: 100vh !important;
                transform: translateX(-100%) !important;
                transition: transform 0.3s ease !important;
                box-shadow: 4px 0 20px rgba(15,23,42,0.12) !important;
            }
            #sidebar.open {
                transform: translateX(0) !important;
            }
            #mobile-toggle { display: flex !important; }
        }

        @media (min-width: 1024px) {
            #mobile-toggle { display: none !important; }
            #sidebar-overlay { display: none !important; }
        }

        /* ── Status pulse ───────────────────────────── */
        @keyframes status-pulse {
            0%, 100% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.5); opacity: 0.6; }
        }
        .status-pulse { animation: status-pulse 2s ease-in-out infinite; }

        /* ── Dropdown ───────────────────────────────── */
        .user-dropdown { position: relative; }
        .user-dropdown:hover .dropdown-menu { opacity: 1; visibility: visible; }
        .dropdown-menu {
            position: absolute;
            right: 0;
            top: calc(100% + 8px);
            width: 240px;
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            box-shadow: 0 10px 40px rgba(15,23,42,0.12);
            opacity: 0;
            visibility: hidden;
            transition: all 0.2s ease;
            z-index: 100;
            overflow: hidden;
        }
    </style>
</head>
<body>
<div id="app-shell">

    {{-- ===================== SIDEBAR ===================== --}}
    <aside id="sidebar">

        {{-- Brand --}}
        <div id="sidebar-brand">
            @auth
            @php $userRole = auth()->user()->role->value ?? 'admin'; @endphp
            <a href="{{ $userRole === 'guru' ? route('guru.dashboard') : route('admin.dashboard') }}"
               style="display:flex; align-items:center; gap:12px; text-decoration:none;">
                <div style="width:36px; height:36px; border-radius:10px; background: {{ $userRole === 'guru' ? 'linear-gradient(135deg,#10b981,#0d9488)' : 'linear-gradient(135deg,#3b82f6,#6366f1)' }}; display:flex; align-items:center; justify-content:center; flex-shrink:0; box-shadow: 0 3px 8px rgba(99,102,241,0.25);">
                    <svg width="18" height="18" fill="none" stroke="white" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                </div>
                <div>
                    <div style="font-size:14px; font-weight:900; color:#0f172a; line-height:1;">SIPBAR</div>
                    <div style="font-size:9px; font-weight:700; color:#94a3b8; letter-spacing:0.1em; text-transform:uppercase; margin-top:2px;">{{ $userRole === 'guru' ? 'Guru Portal' : 'Admin Panel' }}</div>
                </div>
            </a>
            @endauth
            <button id="close-sidebar-btn" onclick="closeSidebar()"
                style="margin-left:auto; width:28px; height:28px; border-radius:8px; background:#f1f5f9; border:none; cursor:pointer; display:none; align-items:center; justify-content:center;">
                <svg width="14" height="14" fill="none" stroke="#475569" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        {{-- Navigation --}}
        <nav id="sidebar-nav">
            @auth
            @php $userRole = auth()->user()->role->value ?? 'admin'; @endphp

            @if($userRole === 'guru')
                <a href="{{ route('guru.dashboard') }}" class="nav-item {{ request()->routeIs('guru.dashboard') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    <span>Dashboard</span>
                </a>
                <div class="nav-group-label">Verifikasi</div>
                <a href="{{ route('guru.verifikasi.index') }}" class="nav-item {{ request()->routeIs('guru.verifikasi.*') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>Verifikasi Peminjaman</span>
                </a>
                <div class="nav-group-label">Akun</div>
                <a href="{{ route('settings') }}" class="nav-item {{ request()->routeIs('settings*') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <span>Pengaturan Akun</span>
                </a>
            @else
                <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    <span>Dashboard</span>
                </a>

                <div class="nav-group-label">Inventaris</div>
                <a href="{{ route('admin.barang.index') }}" class="nav-item {{ request()->routeIs('admin.barang.*') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    <span>Kelola Barang</span>
                </a>
                <a href="{{ route('admin.kategori.index') }}" class="nav-item {{ request()->routeIs('admin.kategori.*') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                    <span>Kategori</span>
                </a>

                <div class="nav-group-label">Transaksi</div>
                <a href="{{ route('admin.peminjaman.index') }}" class="nav-item {{ request()->routeIs('admin.peminjaman.*') ? 'active' : '' }}" style="justify-content:space-between;">
                    <span style="display:flex;align-items:center;gap:10px;">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" style="width:17px;height:17px;flex-shrink:0;"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        Peminjaman
                    </span>
                    @if(isset($stats) && ($stats['menunggu_approval'] ?? 0) > 0)
                        <span style="background:#f59e0b;color:#fff;font-size:10px;font-weight:800;padding:2px 7px;border-radius:99px;">{{ $stats['menunggu_approval'] }}</span>
                    @endif
                </a>
                <a href="{{ route('admin.laporan.index') }}" class="nav-item {{ request()->routeIs('admin.laporan.*') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    <span>Laporan</span>
                </a>

                <div class="nav-group-label">Sistem</div>
                <a href="{{ route('admin.users.index') }}" class="nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    <span>Kelola User</span>
                </a>
                <a href="{{ route('settings') }}" class="nav-item {{ request()->routeIs('settings*') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <span>Pengaturan</span>
                </a>
            @endif
            @endauth
        </nav>

        {{-- Sidebar Footer --}}
        <div id="sidebar-footer">
            @auth
            @php $userRole = auth()->user()->role->value ?? 'admin'; @endphp
            <div style="display:flex; align-items:center; gap:10px; padding:10px; border-radius:12px; background: {{ $userRole === 'guru' ? '#f0fdf4' : '#eff6ff' }}; border: 1px solid {{ $userRole === 'guru' ? '#bbf7d0' : '#bfdbfe' }};">
                <div style="position:relative; flex-shrink:0;">
                    <div style="width:34px; height:34px; border-radius:9px; background: {{ $userRole === 'guru' ? 'linear-gradient(135deg,#10b981,#0d9488)' : 'linear-gradient(135deg,#3b82f6,#6366f1)' }}; display:flex; align-items:center; justify-content:center; color:#fff; font-weight:800; font-size:13px;">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <span class="status-pulse" style="position:absolute; bottom:-1px; right:-1px; width:9px; height:9px; border-radius:50%; background:#34d399; border:2px solid #fff;"></span>
                </div>
                <div style="flex:1; min-width:0;">
                    <div style="font-size:12px; font-weight:700; color:#0f172a; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">{{ Str::limit(auth()->user()->name, 18) }}</div>
                    <div style="font-size:10px; color:#94a3b8; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">{{ Str::limit(auth()->user()->email, 24) }}</div>
                </div>
                <form method="POST" action="{{ route('logout') }}" style="flex-shrink:0;">
                    @csrf
                    <button type="submit" title="Keluar" style="width:30px; height:30px; border-radius:8px; background:#fff1f2; border:1px solid #fecdd3; color:#f43f5e; cursor:pointer; display:flex; align-items:center; justify-content:center; transition:background 0.15s;">
                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    </button>
                </form>
            </div>
            @endauth
        </div>
    </aside>

    {{-- ===================== MAIN AREA ===================== --}}
    <div id="main-area">

        {{-- Top Navbar --}}
        <header id="top-navbar">
            <div style="display:flex; align-items:center; gap:16px;">
                <button id="mobile-toggle" onclick="openSidebar()"
                    style="width:36px; height:36px; border-radius:9px; background:#f1f5f9; border:none; cursor:pointer; align-items:center; justify-content:center;">
                    <svg width="18" height="18" fill="none" stroke="#475569" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                <div>
                    <div style="font-size:11px; font-weight:600; color:#94a3b8; display:flex; align-items:center; gap:4px; margin-bottom:2px;">
                        <a href="{{ route('admin.dashboard') }}" style="color:#94a3b8; text-decoration:none;">Admin</a>
                        <svg width="10" height="10" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                        <span style="color:#1e293b; font-weight:700;">{{ $title ?? 'Dashboard' }}</span>
                    </div>
                    <div style="font-size:15px; font-weight:800; color:#0f172a; line-height:1;">{{ $title ?? 'Dashboard' }}</div>
                </div>
            </div>

            <div style="display:flex; align-items:center; gap:8px;">
                <a href="{{ route('home') }}" target="_blank"
                   style="display:inline-flex; align-items:center; gap:6px; padding:7px 14px; border-radius:9px; background:#f1f5f9; color:#475569; font-size:12px; font-weight:700; text-decoration:none; border:1px solid transparent; transition:all 0.15s;">
                    <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    Website
                </a>

                <button style="width:36px; height:36px; border-radius:9px; background:#f1f5f9; border:none; cursor:pointer; display:flex; align-items:center; justify-content:center; position:relative;">
                    <svg width="17" height="17" fill="none" stroke="#475569" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                    @if(isset($stats) && (($stats['menunggu_approval'] ?? 0) > 0 || ($stats['terlambat'] ?? 0) > 0))
                        <span style="position:absolute; top:7px; right:7px; width:7px; height:7px; border-radius:50%; background:#ef4444; border:2px solid #fff;"></span>
                    @endif
                </button>

                <div style="width:1px; height:24px; background:#e2e8f0; margin:0 4px;"></div>

                <div class="user-dropdown">
                    <button style="display:flex; align-items:center; gap:10px; padding:6px 12px 6px 7px; border-radius:12px; background:linear-gradient(to right,#eff6ff,#eef2ff); border:1px solid #bfdbfe; cursor:pointer;">
                        <div style="width:30px; height:30px; border-radius:8px; background:linear-gradient(135deg,#3b82f6,#6366f1); display:flex; align-items:center; justify-content:center; color:#fff; font-weight:800; font-size:12px;">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <div style="text-align:left;">
                            <div style="font-size:12px; font-weight:800; color:#0f172a; line-height:1;">{{ Str::limit(auth()->user()->name, 14) }}</div>
                            <div style="font-size:10px; color:#94a3b8; line-height:1; margin-top:2px;">Administrator</div>
                        </div>
                        <svg width="12" height="12" fill="none" stroke="#94a3b8" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div class="dropdown-menu">
                        <div style="padding:14px 16px; background:linear-gradient(135deg,#2563eb,#6366f1);">
                            <div style="display:flex; align-items:center; gap:10px;">
                                <div style="width:36px; height:36px; border-radius:9px; background:rgba(255,255,255,0.2); display:flex; align-items:center; justify-content:center; color:#fff; font-weight:800;">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                                <div style="min-width:0;">
                                    <div style="font-size:13px; font-weight:700; color:#fff; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">{{ auth()->user()->name }}</div>
                                    <div style="font-size:11px; color:rgba(255,255,255,0.6); overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">{{ auth()->user()->email }}</div>
                                </div>
                            </div>
                        </div>
                        <div style="padding:6px;">
                            <a href="{{ route('settings') }}" style="display:flex; align-items:center; gap:10px; padding:9px 12px; border-radius:9px; font-size:13px; font-weight:600; color:#334155; text-decoration:none; transition:background 0.15s;" onmouseover="this.style.background='#f1f5f9'" onmouseout="this.style.background='transparent'">
                                <svg width="15" height="15" fill="none" stroke="#94a3b8" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                Pengaturan Akun
                            </a>
                            <div style="border-top:1px solid #f1f5f9; margin:4px 0;"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" style="width:100%; display:flex; align-items:center; gap:10px; padding:9px 12px; border-radius:9px; font-size:13px; font-weight:700; color:#ef4444; background:transparent; border:none; cursor:pointer; transition:background 0.15s;" onmouseover="this.style.background='#fff1f2'" onmouseout="this.style.background='transparent'">
                                    <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                    Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        {{-- Page Content --}}
        <main id="page-content">
            {{ $slot }}
        </main>
    </div>
</div>

{{-- Mobile Overlay --}}
<div id="sidebar-overlay" onclick="closeSidebar()"
     style="display:none; position:fixed; inset:0; background:rgba(15,23,42,0.4); backdrop-filter:blur(4px); z-index:40;"></div>

<script>
    function openSidebar() {
        document.getElementById('sidebar').classList.add('open');
        document.getElementById('sidebar-overlay').style.display = 'block';
        document.getElementById('close-sidebar-btn').style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }
    function closeSidebar() {
        document.getElementById('sidebar').classList.remove('open');
        document.getElementById('sidebar-overlay').style.display = 'none';
        document.getElementById('close-sidebar-btn').style.display = 'none';
        document.body.style.overflow = '';
    }
</script>
</body>
</html>
