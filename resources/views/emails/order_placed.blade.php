<!DOCTYPE html>
<html>
<head>
    <title>Order Confirmation - {{ $order->invoice_number }}</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-top: 4px solid #0d47a1;">
        <h2 style="color: #0d47a1;">Terima Kasih Atas Pesanan Anda!</h2>
        <p>Halo <strong>{{ $order->contact_person }}</strong>,</p>
        <p>Pesanan Anda dengan nomor Invoice <strong>{{ $order->invoice_number }}</strong> telah kami terima dan saat ini sedang menunggu proses selanjutnya oleh tim kami.</p>

        <h3 style="border-bottom: 1px solid #eee; padding-bottom: 10px;">Detail Pemesan</h3>
        <ul style="list-style: none; padding: 0;">
            <li><strong>Perusahaan:</strong> {{ $order->company_name ?: '-' }}</li>
            <li><strong>Email:</strong> {{ $order->email }}</li>
            <li><strong>No. WhatsApp:</strong> {{ $order->phone }}</li>
            <li><strong>Alamat Pengiriman:</strong> {{ $order->address }}, {{ $order->city }}</li>
        </ul>

        <h3 style="border-bottom: 1px solid #eee; padding-bottom: 10px;">Ringkasan Pesanan</h3>
        <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
            <thead>
                <tr style="background-color: #f8f9fa;">
                    <th style="padding: 10px; text-align: left; border: 1px solid #ddd;">Produk</th>
                    <th style="padding: 10px; text-align: center; border: 1px solid #ddd;">Qty</th>
                    <th style="padding: 10px; text-align: right; border: 1px solid #ddd;">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                <tr>
                    <td style="padding: 10px; border: 1px solid #ddd;">{{ $item->name }}</td>
                    <td style="padding: 10px; text-align: center; border: 1px solid #ddd;">{{ $item->quantity }}</td>
                    <td style="padding: 10px; text-align: right; border: 1px solid #ddd;">Rp {{ number_format($item->total, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="2" style="padding: 10px; text-align: right; border: 1px solid #ddd;">Subtotal</th>
                    <th style="padding: 10px; text-align: right; border: 1px solid #ddd;">Rp {{ number_format($order->subtotal, 0, ',', '.') }}</th>
                </tr>
                <tr>
                    <th colspan="2" style="padding: 10px; text-align: right; border: 1px solid #ddd;">Shipping Estimasi</th>
                    <th style="padding: 10px; text-align: right; border: 1px solid #ddd;">Rp {{ number_format($order->total_amount - $order->subtotal, 0, ',', '.') }}</th>
                </tr>
                <tr>
                    <th colspan="2" style="padding: 10px; text-align: right; border: 1px solid #ddd; color: #0d47a1;">Total Amount</th>
                    <th style="padding: 10px; text-align: right; border: 1px solid #ddd; color: #0d47a1;">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</th>
                </tr>
            </tfoot>
        </table>

        <p>Tim admin kami akan segera menghubungi Anda melalui nomor WhatsApp atau Email yang terdaftar untuk konfirmasi lebih lanjut terkait pembayaran dan pengiriman.</p>

        <p style="margin-top: 30px; font-size: 0.9em; color: #777;">
            Salam hormat,<br>
            <strong>PT Wiratama Mitra Abadi</strong>
        </p>
    </div>
</body>
</html>
