<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('frontend.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Capture guest cart BEFORE session is regenerated on login
        $guestCart = session()->get('cart', []);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Merge guest cart into the user's DB cart
            $this->mergeGuestCartToDatabase($guestCart, Auth::id());

            // Sync DB cart into session so views render immediately
            $this->syncDbCartToSession(Auth::id());

            return redirect()->intended('/my-account');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function showRegisterForm()
    {
        return view('frontend.auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone'    => ['required', 'string', 'max:20'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $guestCart = session()->get('cart', []);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'password' => Hash::make($request->password),
            'role'     => 'customer',
        ]);

        Auth::login($user);

        // Save guest cart to DB for new user
        if (!empty($guestCart)) {
            Cart::updateOrCreate(
                ['user_id' => $user->id],
                ['items'   => $guestCart]
            );
        }

        return redirect('/my-account');
    }

    public function logout(Request $request)
    {
        // Persist DB cart is already in DB, no need to clear it.
        // Just forget the session cart copy so guests start fresh.
        session()->forget('cart');

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    // -------------------------------------------------------
    // Private helpers
    // -------------------------------------------------------

    /**
     * Merge guest (session) cart items into the authenticated user's DB cart.
     * If a product already exists in the DB cart, quantities are added together.
     */
    private function mergeGuestCartToDatabase(array $guestCart, int $userId): void
    {
        if (empty($guestCart)) {
            return;
        }

        $dbCartRecord = Cart::where('user_id', $userId)->first();
        $dbItems      = $dbCartRecord ? ($dbCartRecord->items ?? []) : [];

        foreach ($guestCart as $productId => $guestItem) {
            if (isset($dbItems[$productId])) {
                // Merge quantities (respect stock limit)
                $product     = Product::find($productId);
                $merged      = $dbItems[$productId]['quantity'] + $guestItem['quantity'];
                $maxStock    = $product ? ($product->stock > 0 ? $product->stock : PHP_INT_MAX) : PHP_INT_MAX;
                $dbItems[$productId]['quantity'] = min($merged, $maxStock);
            } else {
                $dbItems[$productId] = $guestItem;
            }
        }

        Cart::updateOrCreate(
            ['user_id' => $userId],
            ['items'   => $dbItems]
        );
    }

    /**
     * Copy the DB cart into the session so Blade views can read `session('cart')`.
     */
    private function syncDbCartToSession(int $userId): void
    {
        $dbCart = Cart::where('user_id', $userId)->first();
        session()->put('cart', $dbCart ? ($dbCart->items ?? []) : []);
    }
}
