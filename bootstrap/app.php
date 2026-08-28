<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withCommands([
        __DIR__.'/../app/Console/Commands',
    ])
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'admin.backup' => \App\Http\Middleware\BackupBeforeAdminChange::class,
        ]);
        $middleware->append(\App\Http\Middleware\SecurityHeaders::class);
        $middleware->validateCsrfTokens(except: [
            'midtrans/callback',
        ]);
        $middleware->redirectGuestsTo(function (\Illuminate\Http\Request $request) {
            if ($request->is('admin*')) {
                return route('login');
            }
            return route('customer.login');
        });
        // Sync authenticated user's DB cart → session on every request
        $middleware->appendToGroup('web', \App\Http\Middleware\SyncCartFromDatabase::class);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
