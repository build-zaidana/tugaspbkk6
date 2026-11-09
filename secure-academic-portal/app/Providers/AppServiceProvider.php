<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Izin seperti 'kelola-nilai' dan 'hapus-data' kini berasal dari tabel
        // Spatie (lihat RoleAndPermissionSeeder) dan otomatis terdaftar di Gate,
        // sehingga @can, Gate::authorize, dan middleware permission: tetap bekerja.

        // Tantangan A+: maksimal 3 kali submit proposal per menit per user.
        RateLimiter::for('submit-proposal', function (Request $request) {
            return Limit::perMinute(3)
                ->by($request->user()?->id ?: $request->ip())
                ->response(function () {
                    return back()->withInput()->withErrors([
                        'judul' => 'Terlalu banyak pengajuan. Maksimal 3 proposal per menit, coba lagi sebentar.',
                    ]);
                });
        });
    }
}
