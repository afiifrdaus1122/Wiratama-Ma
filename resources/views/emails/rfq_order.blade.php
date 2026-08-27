<h2>Permohonan Penawaran Harga (RFQ)</h2>
<p>Yth. Tim Sales PT Wiratama Mitra Abadi,</p>
<p>Mohon dibuatkan penawaran resmi untuk RFQ <strong>{{ $order->quotation_number ?: $order->invoice_number }}</strong>.</p>
<p><strong>Data pemohon</strong><br>
Nama PIC: {{ $order->contact_person }}<br>
Perusahaan: {{ $order->company_name ?: '-' }}<br>
Email: {{ $order->email }}<br>
Telepon: {{ $order->phone }}<br>
Alamat: {{ $order->address }}, {{ $order->city }}</p>
<table cellpadding="6" cellspacing="0" border="1">
    <thead><tr><th>Produk</th><th>SKU</th><th>Jumlah</th><th>Estimasi Nilai</th></tr></thead>
    <tbody>@foreach($order->items as $item)<tr><td>{{ $item->name }}</td><td>{{ $item->product->sku ?? '-' }}</td><td>{{ $item->quantity }}</td><td>Rp {{ number_format($item->total, 0, ',', '.') }}</td></tr>@endforeach</tbody>
</table>
<p>Mohon mencantumkan harga terbaik, ketersediaan, estimasi pengiriman, masa berlaku penawaran, garansi, dan ketentuan pembayaran.</p>
<p>Hormat kami,<br>{{ $order->contact_person }}<br>{{ $order->company_name ?: '-' }}<br>{{ $order->phone }}<br>{{ $order->email }}</p>