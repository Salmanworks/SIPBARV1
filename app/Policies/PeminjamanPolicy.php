<?php

namespace App\Policies;

use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PeminjamanPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Peminjaman $peminjaman): bool
    {
        return $user->id === $peminjaman->user_id || $user->isAdmin() || $user->isGuru();
    }

    public function create(User $user): bool
    {
        return $user->isSiswa();
    }

    public function cancel(User $user, Peminjaman $peminjaman): bool
    {
        return $user->id === $peminjaman->user_id && $user->isSiswa();
    }

    public function approve(User $user): bool
    {
        return $user->isGuru() || $user->isAdmin();
    }

    public function process(User $user): bool
    {
        return $user->isGuru() || $user->isAdmin();
    }
}
