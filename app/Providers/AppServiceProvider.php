<?php

namespace App\Providers;

use App\Contracts\WhatsAppNotifierInterface;
use App\Services\LogWhatsAppNotifierService;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Dependency Inversion: Interface WA Notifier → concrete service.
        // Ganti binding ini nanti ketika pakai gateway WA prod (Fonnte/Wablas/dll).
        $this->app->bind(WhatsAppNotifierInterface::class, LogWhatsAppNotifierService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configureDefaults();

        // Share stats data with all admin layout views
        view()->composer('components.layouts.admin', function ($view) {
            if (!isset($view->getData()['stats'])) {
                $stats = [
                    'total_barang' => \App\Models\Barang::count(),
                    'total_kategori' => \App\Models\Kategori::count(),
                    'total_user' => \App\Models\User::count(),
                    'total_peminjaman' => \App\Models\Peminjaman::count(),
                    'sedang_dipinjam' => \App\Models\Peminjaman::whereIn('status', [
                        \App\Enums\PeminjamanStatus::Dipinjam,
                        \App\Enums\PeminjamanStatus::Terlambat,
                    ])->count(),
                    'terlambat' => \App\Models\Peminjaman::where('status', \App\Enums\PeminjamanStatus::Terlambat)->count(),
                    'menunggu_approval' => \App\Models\Peminjaman::where('status', \App\Enums\PeminjamanStatus::Diajukan)->count(),
                ];
                $view->with('stats', $stats);
            }
        });
    }

    /**
     * Configure default behaviors for production-ready applications.
     */
    protected function configureDefaults(): void
    {
        Date::use(CarbonImmutable::class);

        DB::prohibitDestructiveCommands(
            app()->isProduction(),
        );

        Password::defaults(fn (): ?Password => app()->isProduction()
            ? Password::min(12)
                ->mixedCase()
                ->letters()
                ->numbers()
                ->symbols()
                ->uncompromised()
            : null,
        );
    }
}
