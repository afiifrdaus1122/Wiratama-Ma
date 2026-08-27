<?php

namespace App\Http\Middleware;

use App\Models\Cart;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SyncCartFromDatabase
{
    /**
     * Sync the authenticated user's DB cart to the session on every request.
     * This ensures that `session('cart')` is always up-to-date for Blade views.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $dbCart = Cart::where('user_id', Auth::id())->first();
            $dbItems = $dbCart ? ($dbCart->items ?? []) : [];

            // Only overwrite session if DB cart differs or session is empty
            $sessionCart = session()->get('cart', []);
            if ($dbItems !== $sessionCart) {
                session()->put('cart', $dbItems);
            }
        }

        return $next($request);
    }
}
