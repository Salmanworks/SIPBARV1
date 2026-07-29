<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Spatie\Activitylog\Models\Activity;

/**
 * Menampilkan seluruh Activity Log (khusus Admin).
 * Audit trail untuk semua event CRUD: user, guru, siswa, barang, kategori, peminjaman, detail_peminjaman, denda.
 */
class ActivityLogController extends Controller
{
    public function index(Request $request): View
    {
        abort_if(
            ! (auth()->user()?->role === UserRole::Admin),
            403,
            'Hanya Administrator yang dapat melihat Activity Log.'
        );

        $query = Activity::with(['causer', 'subject'])->latest('id');

        // Search by description / causer name
        if ($search = $request->string('search')->trim()->value()) {
            $query->where(function ($q) use ($search) {
                $q->where('description', 'like', "%{$search}%")
                    ->orWhere('log_name', 'like', "%{$search}%")
                    ->orWhereHas('causer', fn ($sub) => $sub->where('name', 'like', "%{$search}%"))
                    ->orWhereHas('causer', fn ($sub) => $sub->where('email', 'like', "%{$search}%"));
            });
        }

        // Filter by log_name (model: user, guru, siswa, barang, kategori, peminjaman, detail_peminjaman, denda)
        if ($request->filled('log_name')) {
            $query->where('log_name', $request->string('log_name')->value());
        }

        // Filter by causer_id (user yang melakukan aksi)
        if ($request->filled('causer_id')) {
            $query->where('causer_type', 'App\Models\User')
                ->where('causer_id', $request->integer('causer_id'));
        }

        // Filter by event type: created / updated / deleted / restored
        if ($request->filled('event')) {
            $query->where('event', $request->string('event')->value());
        }

        $logs = $query->paginate(25)->withQueryString();

        // List log_name untuk dropdown filter
        $logNameOptions = [
            'user' => 'User (Akun Login)',
            'guru' => 'Data Guru',
            'siswa' => 'Data Siswa',
            'kategori' => 'Kategori Barang',
            'barang' => 'Master Barang',
            'peminjaman' => 'Transaksi Peminjaman',
            'detail_peminjaman' => 'Detail Item Peminjaman',
            'denda' => 'Denda Keterlambatan',
        ];

        $eventOptions = [
            'created' => 'Penambahan Data (Created)',
            'updated' => 'Perubahan Data (Updated)',
            'deleted' => 'Penghapusan Data (Deleted)',
            'restored' => 'Restore Data Soft-Deleted',
        ];

        return view('admin.activity-log.index', compact('logs', 'logNameOptions', 'eventOptions'));
    }
}
