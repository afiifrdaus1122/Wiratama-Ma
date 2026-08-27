<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class CustomerController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $orders = Order::where('user_id', $user->id)->with('items')->orderBy('created_at', 'desc')->get();
        $stats = [
            'total' => $orders->count(),
            'active_rfqs' => $orders->whereIn('status', ['quotation_requested', 'quotation_sent', 'negotiation'])->count(),
            'completed' => $orders->whereIn('status', ['completed', 'deal_won'])->count(),
        ];
        
        return view('frontend.customer.dashboard', compact('user', 'orders', 'stats'));
    }

    public function orderDetail(Order $order)
    {
        // Ensure this user owns the order
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $order->load('items.product', 'statusHistories');
        return view('frontend.customer.order_detail', compact('order'));
    }

    public function downloadQuotation(Order $order)
    {
        abort_unless($order->user_id === Auth::id(), 403);
        $order->load('items.product');
        return Pdf::loadView('frontend.customer.quotation_pdf', compact('order'))
            ->setPaper('a4')
            ->download(($order->quotation_number ?: $order->invoice_number) . '.pdf');
    }
    public function checkoutQuotation(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        // Allow checkout if status is quotation_sent
        if ($order->status == 'quotation_sent') {
            $order->update(['status' => 'pending']);

            // Generate Snap Token
            if (!$order->snap_token) {
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

            return redirect()->route('customer.order_detail', $order->invoice_number)->with('success', 'Penawaran disetujui. Pesanan Anda sekarang masuk ke tahap proses/pembayaran (Pending).');
        }

        return redirect()->back()->with('error', 'Status pesanan tidak valid untuk proses checkout.');
    }

    public function editProfile()
    {
        $user = Auth::user();
        return view('frontend.customer.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'company_name' => 'nullable|string|max:255',
            'npwp' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:255',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $data = $request->only(['name', 'email', 'phone', 'company_name', 'npwp', 'address', 'city']);
        
        if ($request->filled('password')) {
            $data['password'] = \Illuminate\Support\Facades\Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
    }
}
