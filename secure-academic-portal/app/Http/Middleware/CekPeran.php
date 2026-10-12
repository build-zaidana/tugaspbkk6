<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CekPeran
{
    /**
     * Hanya loloskan user yang memiliki salah satu peran yang diizinkan.
     * Contoh pemakaian: ->middleware('cek.peran:dosen,asdos')
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (! $user) {
            return redirect()->route('login')
                ->with('status', 'Silakan login terlebih dahulu.');
        }

        if (! $user->hasRole(...$roles)) {
            abort(403, 'Izin akses ditolak! Halaman ini khusus '.implode(' / ', $roles).'.');
        }

        return $next($request);
    }
}
