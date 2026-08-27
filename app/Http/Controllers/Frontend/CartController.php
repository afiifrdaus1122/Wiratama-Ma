<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // -------------------------------------------------------
    // HELPERS — read / write cart from DB (auth) or session (guest)
    // -------------------------------------------------------

    /**
     * Get the current cart array (keyed by product_id).
     */
    private function getCart(): array
    {
        if (Auth::check()) {
            $dbCart = Cart::where('user_id', Auth::id())->first();
            return $dbCart ? ($dbCart->items ?? []) : [];
        }

        return session()->get('cart', []);
    }

    /**
     * Persist the cart array (keyed by product_id).
     */
    private function saveCart(array $cart): void
    {
        if (Auth::check()) {
            Cart::updateOrCreate(
                ['user_id' => Auth::id()],
                ['items' => $cart]
            );
        } else {
            session()->put('cart', $cart);
        }
    }

    // -------------------------------------------------------
    // ACTIONS
    // -------------------------------------------------------

    public function index()
    {
        $cart = $this->getCart();
        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        // PPN 11%
        $ppn    = count($cart) > 0 ? $subtotal * 0.11 : 0;
        $total  = $subtotal + $ppn;

        return view('frontend.cart.index', compact('cart', 'subtotal', 'ppn', 'total'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);

        // Stock checks
        if ($product->stock < 0) {
            return redirect()->back()->with('error', 'Produk tidak tersedia.');
        } elseif ($product->stock > 0 && $product->stock < $request->quantity) {
            return redirect()->back()->with('error', 'Jumlah pesanan melebihi stok yang tersedia.');
        }

        $cart = $this->getCart();

        if (isset($cart[$product->id])) {
            $newQuantity = $cart[$product->id]['quantity'] + $request->quantity;
            if ($product->stock > 0 && $product->stock < $newQuantity) {
                return redirect()->back()->with('error', 'Jumlah pesanan di keranjang melebihi stok yang tersedia.');
            }
            $cart[$product->id]['quantity'] = $newQuantity;
        } else {
            $cart[$product->id] = [
                'id'       => $product->id,
                'name'     => $product->name,
                'sku'      => $product->sku,
                'quantity' => $request->quantity,
                'price'    => $product->price,
                'image'    => $product->image,
                'slug'     => $product->slug,
                'stock'    => $product->stock,
            ];
        }

        $this->saveCart($cart);

        return redirect()->back()->with('success', 'Product added to cart successfully!');
    }

    public function update(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer',
            'quantity'   => 'required|integer|min:1',
        ]);

        $cart = $this->getCart();

        if (isset($cart[$request->product_id])) {
            $product = Product::findOrFail($request->product_id);

            if ($product->stock < 0) {
                return redirect()->back()->with('error', 'Produk tidak tersedia.');
            } elseif ($product->stock > 0 && $product->stock < $request->quantity) {
                return redirect()->back()->with('error', 'Jumlah pesanan melebihi stok yang tersedia.');
            }

            $cart[$request->product_id]['quantity'] = $request->quantity;
            $this->saveCart($cart);

            return redirect()->back()->with('success', 'Cart updated successfully.');
        }

        return redirect()->back();
    }

    public function remove(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer',
        ]);

        $cart = $this->getCart();

        if (isset($cart[$request->product_id])) {
            unset($cart[$request->product_id]);
            $this->saveCart($cart);

            return redirect()->back()->with('success', 'Product removed from cart.');
        }

        return redirect()->back();
    }
}
