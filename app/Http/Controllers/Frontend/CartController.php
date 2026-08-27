<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }
        
        // PPN 11%
        $ppn = count($cart) > 0 ? $subtotal * 0.11 : 0;
        $total = $subtotal + $ppn;

        return view('frontend.cart.index', compact('cart', 'subtotal', 'ppn', 'total'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $product = Product::findOrFail($request->product_id);
        
        // Check stock availability
        if ($product->stock < 0) {
            return redirect()->back()->with('error', 'Produk tidak tersedia.');
        } elseif ($product->stock > 0 && $product->stock < $request->quantity) {
            return redirect()->back()->with('error', 'Jumlah pesanan melebihi stok yang tersedia.');
        }

        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            $newQuantity = $cart[$product->id]['quantity'] + $request->quantity;
            if ($product->stock > 0 && $product->stock < $newQuantity) {
                return redirect()->back()->with('error', 'Jumlah pesanan di keranjang melebihi stok yang tersedia.');
            }
            $cart[$product->id]['quantity'] = $newQuantity;
        } else {
            $cart[$product->id] = [
                "id" => $product->id,
                "name" => $product->name,
                "sku" => $product->sku,
                "quantity" => $request->quantity,
                "price" => $product->price,
                "image" => $product->image,
                "slug" => $product->slug,
                "stock" => $product->stock
            ];
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Product added to cart successfully!');
    }

    public function update(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer',
            'quantity' => 'required|integer|min:1'
        ]);

        $cart = session()->get('cart', []);
        
        if (isset($cart[$request->product_id])) {
            $product = Product::findOrFail($request->product_id);
            if ($product->stock < 0) {
                return redirect()->back()->with('error', 'Produk tidak tersedia.');
            } elseif ($product->stock > 0 && $product->stock < $request->quantity) {
                return redirect()->back()->with('error', 'Jumlah pesanan melebihi stok yang tersedia.');
            }
            $cart[$request->product_id]['quantity'] = $request->quantity;
            session()->put('cart', $cart);
            return redirect()->back()->with('success', 'Cart updated successfully.');
        }

        return redirect()->back();
    }

    public function remove(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer'
        ]);

        $cart = session()->get('cart', []);

        if (isset($cart[$request->product_id])) {
            unset($cart[$request->product_id]);
            session()->put('cart', $cart);
            return redirect()->back()->with('success', 'Product removed from cart.');
        }

        return redirect()->back();
    }
}
