@if($details['language'] === 'en')
<h2>Request for Quotation (RFQ)</h2>

<p>Dear Sales Team of PT Wiratama Mitra Abadi,</p>

<p>We would like to request your formal quotation for the following product:</p>

<table cellpadding="6" cellspacing="0" border="0">
    <tr><td><strong>Produk</strong></td><td>{{ $product->name }}</td></tr>
    <tr><td><strong>Quantity</strong></td><td>{{ $details['quantity'] }} unit</td></tr>
    <tr><td><strong>Contact Person</strong></td><td>{{ $details['name'] }}</td></tr>
    <tr><td><strong>Company</strong></td><td>{{ $details['company'] }}</td></tr>
    <tr><td><strong>Email</strong></td><td>{{ $details['email'] }}</td></tr>
    <tr><td><strong>Phone / WhatsApp</strong></td><td>{{ $details['phone'] }}</td></tr>
</table>

<p>Please include your best price, product availability, estimated delivery time, quotation validity, warranty, and payment terms.</p>
<p><strong>Additional requirements:</strong></p>
<p>{!! nl2br(e($details['notes'])) !!}</p>

<p>Thank you for your attention and cooperation. We look forward to your quotation.</p>

<p>Best regards,<br>
{{ $details['name'] }}<br>
{{ $details['company'] }}<br>
{{ $details['phone'] }}<br>
{{ $details['email'] }}</p>
@else
<h2>Permohonan Penawaran Harga (RFQ)</h2>

<p>Yth. Tim Sales PT Wiratama Mitra Abadi,</p>
<p>Dengan hormat, berikut permohonan penawaran harga resmi kami:</p>
<table cellpadding="6" cellspacing="0" border="0">
    <tr><td><strong>Produk</strong></td><td>{{ $product->name }}</td></tr>
    <tr><td><strong>Jumlah</strong></td><td>{{ $details['quantity'] }} unit</td></tr>
    <tr><td><strong>Nama PIC</strong></td><td>{{ $details['name'] }}</td></tr>
    <tr><td><strong>Perusahaan</strong></td><td>{{ $details['company'] }}</td></tr>
    <tr><td><strong>Email</strong></td><td>{{ $details['email'] }}</td></tr>
    <tr><td><strong>Telepon / WhatsApp</strong></td><td>{{ $details['phone'] }}</td></tr>
</table>
<p>Mohon mencantumkan harga terbaik, ketersediaan barang, estimasi pengiriman, masa berlaku penawaran, garansi, dan ketentuan pembayaran.</p>
<p><strong>Detail kebutuhan:</strong></p>
<p>{!! nl2br(e($details['notes'])) !!}</p>
<p>Atas perhatian dan kerja sama yang baik, kami ucapkan terima kasih.</p>
<p>Hormat kami,<br>
{{ $details['name'] }}<br>
{{ $details['company'] }}<br>
{{ $details['phone'] }}<br>
{{ $details['email'] }}</p>
@endif