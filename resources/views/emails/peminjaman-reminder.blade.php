<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIPBAR — Notifikasi Peminjaman Barang</title>
    <style>
        * { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Arial, sans-serif; margin: 0; padding: 0; box-sizing: border-box; }
        body { background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%); padding: 32px 16px; }
        .container { max-width: 640px; margin: 0 auto; background: white; border-radius: 24px; overflow: hidden; box-shadow: 0 20px 50px -10px rgba(15,23,42,0.15); }
        .header { padding: 32px; color: white; background: linear-gradient(135deg, {{ $headerGradient }} 100%); }
        .header .badge { display: inline-block; padding: 6px 12px; background: rgba(255,255,255,0.2); backdrop-filter: blur(4px); border: 1px solid rgba(255,255,255,0.25); border-radius: 9999px; font-size: 10px; font-weight: 900; letter-spacing: 0.08em; text-transform: uppercase; }
        .header h1 { margin-top: 14px; font-size: 22px; font-weight: 900; letter-spacing: -0.01em; }
        .header p { margin-top: 8px; font-size: 13px; opacity: 0.9; font-weight: 500; }
        .body { padding: 28px 32px 12px; }
        .salutation { font-size: 15px; color: #1e293b; font-weight: 700; margin-bottom: 10px; }
        .lead { font-size: 14px; color: #334155; line-height: 1.7; margin-bottom: 22px; }
        .card-detail { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 16px; padding: 18px 20px; margin-bottom: 22px; }
        .row { display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px dashed #e2e8f0; font-size: 13px; }
        .row:last-child { border-bottom: 0; }
        .row .label { color: #64748b; font-weight: 600; }
        .row .value { color: #0f172a; font-weight: 800; text-align: right; max-width: 55%; word-wrap: break-word; }
        .item-list { margin-top: 4px; background: white; border: 1px solid #e2e8f0; border-radius: 12px; padding: 10px 12px; }
        .item { display: flex; justify-content: space-between; padding: 6px 0; font-size: 12.5px; border-bottom: 1px solid #f1f5f9; }
        .item:last-child { border-bottom: 0; }
        .item .name { color: #1e293b; font-weight: 700; }
        .item .qty { color: #475569; font-weight: 800; font-variant-numeric: tabular-nums; }
        @if($type === 'terlambat')
        .alert-denda { background: linear-gradient(135deg, #fff1f2, #fee2e2); border: 1px solid #fecdd3; border-left: 5px solid #f43f5e; color: #881337; padding: 14px 16px; border-radius: 14px; font-size: 13px; font-weight: 700; margin-bottom: 22px; line-height: 1.6; }
        @endif
        .cta-btn { display: block; text-align: center; text-decoration: none; padding: 14px 18px; background: linear-gradient(135deg, {{ $headerGradient }}); color: white; border-radius: 14px; font-weight: 900; font-size: 14px; margin-bottom: 18px; box-shadow: 0 10px 20px -8px rgba(15,23,42,0.2); }
        .footer { padding: 20px 32px 28px; text-align: center; color: #64748b; font-size: 11px; line-height: 1.8; border-top: 1px solid #f1f5f9; }
        .brand { display: inline-flex; align-items: center; gap: 10px; margin-bottom: 10px; font-weight: 900; color: #0f172a; font-size: 14px; }
        .brand-dot { width: 28px; height: 28px; border-radius: 9px; background: linear-gradient(135deg, #0ea5e9, #6366f1); color: white; font-weight: 900; font-size: 12px; display: inline-flex; align-items: center; justify-content: center; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <span class="badge">{{ $badgeText }}</span>
            <h1>{{ $type === 'terlambat' ? '⚠️ Ada Pinjaman yang Terlambat!' : '📢 Pengingat Peminjaman Barang' }}</h1>
            <p>Dikirim oleh SIPBAR — Sistem Informasi Peminjaman Barang Sekolah</p>
        </div>

        <div class="body">
            <p class="salutation">Halo, {{ $peminjaman->user?->name ?? 'Saudara Peminjam' }}.</p>

            <p class="lead">
                @if($type === 'h1')
                    Ini adalah pengingat H-1 sebelum batas waktu pengembalian pinjaman barang. Besok ({{ $peminjaman->tanggal_kembali_rencana?->format('l, d F Y') ?? 'besok' }}) adalah batas terakhir pengembalian. Segera kembalikan barang agar tidak terkena denda.
                @elseif($type === 'hari_ini')
                    📅 <b>HARI INI</b> adalah batas akhir pengembalian barang pinjaman Anda ({{ $peminjaman->tanggal_kembali_rencana?->format('d F Y') }}). Silakan kembalikan ke petugas inventaris sebelum jam operasional sekolah berakhir.
                @elseif($type === 'terlambat')
                    <span style="color:#be123c;font-weight:900;">PERINGATAN:</span> Peminjaman Anda telah melewati batas pengembalian selama <b>{{ $daysOverdue }} hari</b>. Segera kembalikan barang untuk membatasi akumulasi denda keterlambatan yang berlaku.
                @endif
            </p>

            @if($type === 'terlambat')
            <div class="alert-denda">
                ⚠️ Denda keterlambatan berlaku sesuai kebijakan sekolah. Jumlah hari terlambat saat ini: <b>{{ $daysOverdue }} hari</b>. Kembalikan segera untuk menghindari sanksi lebih lanjut.
            </div>
            @endif

            <div class="card-detail">
                <div class="row">
                    <span class="label">ID Peminjaman</span>
                    <span class="value">#{{ $peminjaman->id }}</span>
                </div>
                <div class="row">
                    <span class="label">Status</span>
                    <span class="value">{{ method_exists($peminjaman->status, 'label') ? $peminjaman->status->label() : (string) $peminjaman->status }}</span>
                </div>
                <div class="row">
                    <span class="label">Tanggal Pinjam</span>
                    <span class="value">{{ $peminjaman->tanggal_pinjam?->format('d F Y') ?? '-' }}</span>
                </div>
                <div class="row">
                    <span class="label">Tgl. Kembali (Rencana)</span>
                    <span class="value">{{ $peminjaman->tanggal_kembali_rencana?->format('d F Y') ?? '-' }}</span>
                </div>
                <div class="row">
                    <span class="label">Keperluan</span>
                    <span class="value">{{ $peminjaman->keperluan ?? '-' }}</span>
                </div>
                @if($peminjaman->details && $peminjaman->details->isNotEmpty())
                <div class="row" style="display:block;margin-top:6px;">
                    <span class="label">📦 Daftar Barang ({{ $peminjaman->details->count() }} jenis)</span>
                    <div class="item-list" style="margin-top:10px;">
                        @foreach($peminjaman->details as $detail)
                            <div class="item">
                                <span class="name">{{ $detail->barang?->nama_barang ?? 'Barang #'.$detail->barang_id }} @if($detail->barang?->kode_barang)<span style="color:#64748b;font-weight:500;font-size:11px;">({{ $detail->barang->kode_barang }})</span>@endif</span>
                                <span class="qty">× {{ $detail->jumlah }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            <a href="{{ url('/login') }}" class="cta-btn">{{ $ctaText }} &rarr;</a>

            <p style="font-size:12px;color:#475569;margin-bottom:6px;">💡 <b>Petunjuk:</b> Bawa barang beserta kartu identitas saat menyerahkan ke petugas inventaris. Tanyakan QR Code bukti serah-terima kepada petugas.</p>
        </div>

        <div class="footer">
            <div class="brand"><span class="brand-dot">SB</span>SIPBAR &mdash; Sistem Informasi Peminjaman Barang Sekolah</div>
            Email ini dikirim otomatis oleh sistem Scheduler SIPBAR. Mohon tidak membalas email ini.<br>
            Jika Anda merasa salah menerima, silakan hubungi Admin / Tata Usaha sekolah.
        </div>
    </div>
</body>
</html>
