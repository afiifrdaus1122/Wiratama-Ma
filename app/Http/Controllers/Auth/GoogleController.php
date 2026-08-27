<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Capture guest cart BEFORE login changes the session
            $guestCart = session()->get('cart', []);

            $user = User::where('google_id', $googleUser->id)
                        ->orWhere('email', $googleUser->email)
                        ->first();

            if ($user) {
                if (empty($user->google_id)) {
                    $user->update(['google_id' => $googleUser->id]);
                }
                Auth::login($user);
            } else {
                $user = User::create([
                    'name'      => $googleUser->name,
                    'email'     => $googleUser->email,
                    'google_id' => $googleUser->id,
                    'password'  => null,
                    'role'      => 'customer',
                ]);
                Auth::login($user);
            }

            // Merge guest cart into DB cart
            $this->mergeGuestCartToDatabase($guestCart, $user->id);

            return redirect()->route('home');
        } catch (\Exception $e) {
            return redirect()->route('customer.login')->with('error', 'Login dengan Google gagal. Silakan coba lagi.');
        }
    }

    private function mergeGuestCartToDatabase(array $guestCart, int $userId): void
    {
        if (empty($guestCart)) {
            return;
        }

        $dbCartRecord = Cart::where('user_id', $userId)->first();
        $dbItems      = $dbCartRecord ? ($dbCartRecord->items ?? []) : [];

        foreach ($guestCart as $productId => $guestItem) {
            if (isset($dbItems[$productId])) {
                $product  = Product::find($productId);
                $merged   = $dbItems[$productId]['quantity'] + $guestItem['quantity'];
                $maxStock = $product ? ($product->stock > 0 ? $product->stock : PHP_INT_MAX) : PHP_INT_MAX;
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
}
