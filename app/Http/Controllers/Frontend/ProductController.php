<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\RfqMail;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderStatusHistory;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::where('is_active', true)->with('category');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($searchQuery) use ($search) {
                $searchQuery->where('name', 'like', '%' . $search . '%')
                    ->orWhere('sku', 'like', '%' . $search . '%')
                    ->orWhere('brand', 'like', '%' . $search . '%');
            });
        }

        $activeCategory = null;
        if ($request->filled('category')) {
            $activeCategory = Category::where('slug', $request->category)->first();
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        $products = $query->latest()->paginate(12);
        $categories = Category::withCount(['products' => function($q) {
            $q->where('is_active', true);
        }])->get();

        return view('frontend.products.index', compact('products', 'categories', 'activeCategory'));
    }

    public function show($slug)
    {
        $product = Product::where('slug', $slug)->where('is_active', true)->firstOrFail();
        
        $related_products = Product::where('is_active', true)
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->inRandomOrder()
            ->take(4)
            ->get();

        return view('frontend.products.show', compact('product', 'related_products'));
    }

    public function autocomplete(Request $request)
    {
        $search = trim((string) $request->input('q'));
        if (strlen($search) < 2) {
            return response()->json([]);
        }

        return response()->json(Product::where('is_active', true)
            ->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('sku', 'like', '%' . $search . '%')
                    ->orWhere('brand', 'like', '%' . $search . '%');
            })
            ->with('category:id,name')
            ->select('id', 'name', 'slug', 'sku', 'brand', 'image', 'category_id')
            ->limit(8)
            ->get()
            ->map(fn ($product) => [
                'name' => $product->name,
                'sku' => $product->sku,
                'brand' => $product->brand,
                'category' => $product->category?->name,
                'url' => route('products.show', $product->slug),
                'image' => $product->image ? asset('storage/' . $product->image) : null,
            ]));
    }

    public function sendRfq(Request $request, $slug)
    {
        $product = Product::where('slug', $slug)->where('is_active', true)->firstOrFail();

        $validated = $request->validate([
            'email' => ['required', 'email', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'company' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:30'],
            'quantity' => ['required', 'integer', 'min:1', 'max:9999'],
            'language' => ['required', 'in:id,en'],
            'notes' => ['required', 'string', 'max:5000'],
        ]);

        try {
            Mail::to(config('mail.sales_address', 'sales@wma.co.id'))
                ->send(new RfqMail($product, $validated));

            $order = Order::create([
                'user_id' => auth()->id(),
                'invoice_number' => 'INV-' . now()->format('YmdHis') . '-' . $product->id,
                'quotation_number' => 'RFQ-' . now()->format('YmdHis') . '-' . $product->id,
                'contact_person' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'company_name' => $validated['company'],
                'address' => '-',
                'city' => '-',
                'notes' => $validated['notes'],
                'subtotal' => $product->price * $validated['quantity'],
                'tax' => 0,
                'total_amount' => $product->price * $validated['quantity'],
                'status' => 'quotation_requested',
            ]);
            OrderItem::create(['order_id' => $order->id, 'product_id' => $product->id, 'name' => $product->name, 'quantity' => $validated['quantity'], 'price' => $product->price, 'total' => $product->price * $validated['quantity']]);
            OrderStatusHistory::create(['order_id' => $order->id, 'status' => 'quotation_requested', 'note' => 'RFQ diterima dari halaman produk.', 'changed_by' => auth()->id()]);
        } catch (\Throwable $exception) {
            Log::error('RFQ email failed: ' . $exception->getMessage());

            return redirect()->route('products.show', $product->slug)
                ->with('error', 'RFQ belum terkirim. Periksa konfigurasi email server.');
        }

        return redirect()->route('products.show', $product->slug)
            ->with('success', 'RFQ berhasil dikirim ke tim sales.');
    }
}
