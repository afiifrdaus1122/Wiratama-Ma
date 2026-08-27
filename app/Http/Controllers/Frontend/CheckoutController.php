<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Models\OrderStatusHistory;
use App\Mail\RfqOrderMail;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        
        if (count($cart) == 0) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja Anda kosong.');
        }

        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }
        
        $ppn = $subtotal * 0.11;
        $total = $subtotal + $ppn;

        return view('frontend.checkout.index', compact('cart', 'subtotal', 'ppn', 'total'));
    }

    public function store(Request $request)
    {
        $cart = session()->get('cart', []);
        
        if (count($cart) == 0) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja Anda kosong.');
        }

        $validated = $request->validate([
            'contact_person' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'company_name' => 'nullable|string|max:255',
            'address' => 'required|string',
            'city' => 'required|string|max:255',
            'notes' => 'nullable|string'
        ]);

        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }
        
        $ppn = $subtotal * 0.11;
        $total = $subtotal + $ppn;

        DB::beginTransaction();

        try {
            // Generate Invoice Number (e.g. INV-YYYYMMDD-XXXX)
            $datePrefix = date('Ymd');
            $lastOrder = Order::where('invoice_number', 'LIKE', "INV-{$datePrefix}-%")->orderBy('id', 'desc')->first();
            $nextNumber = 1;
            if ($lastOrder) {
                $lastNumber = (int) substr($lastOrder->invoice_number, -4);
                $nextNumber = $lastNumber + 1;
            }
            $invoiceNumber = "INV-{$datePrefix}-" . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

            $checkoutType = $request->input('checkout_type', 'checkout');
            $status = $checkoutType === 'rfq' ? 'quotation_requested' : 'pending';

            // Create Order
            $order = Order::create([
                'user_id' => \Illuminate\Support\Facades\Auth::id(),
                'invoice_number' => $invoiceNumber,
                'contact_person' => $validated['contact_person'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'company_name' => $validated['company_name'] ?? null,
                'address' => $validated['address'],
                'city' => $validated['city'],
                'notes' => $validated['notes'] ?? null,
                'subtotal' => $subtotal,
                'tax' => $ppn,
                'total_amount' => $total,
                'status' => $status,
                'quotation_number' => $status === 'quotation_requested' ? 'RFQ-' . date('Ymd') . '-' . str_pad((string) (Order::whereDate('created_at', today())->count() + 1), 4, '0', STR_PAD_LEFT) : null,
            ]);

            if ($status === 'quotation_requested') {
                OrderStatusHistory::create([
                    'order_id' => $order->id,
                    'status' => $status,
                    'note' => 'RFQ diterima dari pelanggan.',
                    'changed_by' => Auth::id(),
                ]);
            }

            // Create Order Items
            foreach ($cart as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['id'],
                    'name' => $item['name'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'total' => $item['price'] * $item['quantity'],
                ]);
            }

            // Generate Snap Token for Direct Checkout
            if ($status === 'pending') {
                $serverKey = config('services.midtrans.server_key');
                if (!empty($serverKey)) {
                    \Midtrans\Config::$serverKey = $serverKey;
                    \Midtrans\Config::$isProduction = config('services.midtrans.is_production');
                    \Midtrans\Config::$isSanitized = true;
                    \Midtrans\Config::$is3ds = true;

                $params = [
                    'transaction_details' => [
                        'order_id' => $order->invoice_number,
                        'gross_amount' => (int) $order->total_amount,
                    ],
                    'customer_details' => [
                        'first_name' => $order->contact_person,
                        'email' => $order->email,
                        'phone' => $order->phone,
                        'billing_address' => [
                            'first_name' => $order->contact_person,
                            'address' => $order->address,
                            'city' => $order->city,
                        ]
                    ],
                ];

                $snapToken = \Midtrans\Snap::getSnapToken($params);
                $order->update(['snap_token' => $snapToken]);
                }
            }

            DB::commit();

            if ($status === 'quotation_requested') {
                try {
                    Mail::to(config('mail.sales_address', 'sales@wma.co.id'))->send(new RfqOrderMail($order->fresh('items')));
                } catch (\Throwable $e) {
                    \Illuminate\Support\Facades\Log::error('RFQ order email failed: ' . $e->getMessage());
                }
            }

            // Send Email to Customer & Admin
            try {
                \Illuminate\Support\Facades\Mail::to($order->email)->send(new \App\Mail\OrderPlacedMail($order));
            } catch (\Exception $e) {
                // Ignore mail errors so checkout still succeeds
            }

            // Clear Cart (session + database for authenticated users)
            session()->forget('cart');
            if (Auth::check()) {
                Cart::where('user_id', Auth::id())->delete();
            }

            return redirect()->route('checkout.success', ['order' => $order->invoice_number])->with('success', 'Pesanan Anda berhasil dibuat.');

        } catch (\Exception $e) {
            DB::rollBack();
            \Illuminate\Support\Facades\Log::error('Checkout Error: ' . $e->getMessage() . ' at ' . $e->getFile() . ':' . $e->getLine());
            return redirect()->back()->with('error', 'Terjadi kesalahan sistem saat menyimpan pesanan: ' . $e->getMessage())->withInput();
        }
    }

    public function success(Order $order)
    {
        return view('frontend.checkout.success', compact('order'));
    }
}
