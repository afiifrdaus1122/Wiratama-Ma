<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class BackupBeforeAdminChange
{
    public function handle(Request $request, Closure $next): Response
    {
        if (in_array($request->method(), ['POST', 'PUT', 'PATCH', 'DELETE'], true)) {
            try {
                $exitCode = Artisan::call('backup:database', ['--keep' => 14]);
                if ($exitCode !== 0) {
                    abort(503, 'Perubahan dibatalkan karena backup database gagal.');
                }
            } catch (Throwable $exception) {
                report($exception);
                abort(503, 'Perubahan dibatalkan karena backup database gagal.');
            }
        }

        return $next($request);
    }
}
