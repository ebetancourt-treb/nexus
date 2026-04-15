<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withProviders([
        \App\Providers\CashierServiceProvider::class,
    ])
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Middleware de tenant en TODAS las rutas web autenticadas
        $middleware->appendToGroup('web', [
            \App\Http\Middleware\SetCurrentTenant::class,
        ]);

        // Excluir webhook de Stripe de CSRF
        $middleware->validateCsrfTokens(except: ['stripe/webhook']);

        // Aliases para uso en rutas
        $middleware->alias([
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
            'plan_feature' => \App\Http\Middleware\EnsurePlanFeature::class,
            'set_warehouse' => \App\Http\Middleware\SetActiveWarehouse::class,
            'verified' => \App\Http\Middleware\EnsureEmailIsVerified::class,
        ]);

        
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
