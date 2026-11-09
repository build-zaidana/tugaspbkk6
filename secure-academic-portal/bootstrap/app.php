<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Spatie\Permission\Middleware\PermissionMiddleware;
use Spatie\Permission\Middleware\RoleMiddleware;
use Spatie\Permission\Middleware\RoleOrPermissionMiddleware;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Alias middleware bawaan Spatie Laravel Permission (Pertemuan 10).
        $middleware->alias([
            'role' => RoleMiddleware::class,
            'permission' => PermissionMiddleware::class,
            'role_or_permission' => RoleOrPermissionMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*') || $request->expectsJson(),
        );

        // Pesan 403 bawaan Spatie berbahasa Inggris; tampilkan versi Indonesia
        // yang menyebutkan peran atau izin yang dibutuhkan.
        $exceptions->map(UnauthorizedException::class, function (UnauthorizedException $exception) {
            $message = match (true) {
                $exception->getRequiredRoles() !== [] => 'Izin akses ditolak! Halaman ini khusus peran: '
                    .implode(' / ', $exception->getRequiredRoles()).'.',
                $exception->getRequiredPermissions() !== [] => 'Izin akses ditolak! Aksi ini membutuhkan izin: '
                    .implode(' / ', $exception->getRequiredPermissions()).'.',
                default => 'Izin akses ditolak!',
            };

            return new AccessDeniedHttpException($message, $exception);
        });
    })->create();
