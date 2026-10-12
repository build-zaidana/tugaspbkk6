<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
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
        // Gate global: hanya dosen & asdos yang boleh mengisi nilai proposal.
        Gate::define('kelola-nilai', function (User $user): bool {
            return $user->hasRole(User::ROLE_DOSEN, User::ROLE_ASDOS);
        });

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
