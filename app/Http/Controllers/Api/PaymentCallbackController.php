<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Midtrans\Config;
use Midtrans\Notification;

class PaymentCallbackController extends Controller
{
    public function callback(Request $request)
    {
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');
        
        try {
            $notification = new Notification();
        } catch (\Exception $e) {
            return response()->json(['message' => 'Invalid signature or payload'], 400);
        }

        $status = $notification->transaction_status;
        $type = $notification->payment_type;
        $orderId = $notification->order_id;
        $fraudStatus = $notification->fraud_status;

        $order = Order::where('invoice_number', $orderId)->first();

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        if ($status == 'capture') {
            if ($fraudStatus == 'challenge') {
                $order->payment_status = 'pending';
            } else if ($fraudStatus == 'accept') {
                $order->payment_status = 'paid';
                $order->status = 'processing';
            }
        } else if ($status == 'settlement') {
            $order->payment_status = 'paid';
            $order->status = 'processing';
        } else if ($status == 'cancel' || $status == 'deny' || $status == 'expire') {
            $order->payment_status = 'failed';
            if ($status == 'expire') {
                $order->payment_status = 'expired';
            }
            $order->status = 'cancelled';
        } else if ($status == 'pending') {
            $order->payment_status = 'pending';
        }

        $order->payment_type = $type;
        $order->save();

        return response()->json(['message' => 'Payment status updated successfully']);
    }
}
