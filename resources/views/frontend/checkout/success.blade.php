@extends('layouts.app')

@section('content')
<div class="container py-5 mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <div class="card border-0 shadow-sm rounded-0 p-5">
                <div class="mb-4">
                    <i class="bi bi-check-circle-fill text-success" style="font-size: 5rem;"></i>
                </div>
                <h2 class="fw-bold text-dark mb-3">Terima Kasih Atas Pesanan Anda!</h2>
                <p class="text-muted fs-5 mb-4">
                    Pesanan Anda telah berhasil dibuat dengan nomor Invoice: <br>
                    <span class="fw-bold text-primary fs-4">{{ $order->invoice_number }}</span>
                </p>
                <p class="text-muted mb-5">
                    Tim kami akan segera menghubungi Anda melalui nomor WhatsApp ({{ $order->phone }}) atau Email ({{ $order->email }}) yang Anda berikan untuk proses selanjutnya.
                </p>
                
                <div>
                    @if($order->status == 'pending' && $order->snap_token)
                        <button id="pay-button" class="btn btn-success rounded-pill px-4 me-2"><i class="bi bi-credit-card me-2"></i> Bayar Sekarang</button>
                    @endif
                    <a href="{{ route('home') }}" class="btn btn-outline-primary rounded-pill px-4 me-2">Kembali ke Beranda</a>
                    <a href="{{ route('products.index') }}" class="btn btn-primary rounded-pill px-4">Lanjut Belanja</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
@if($order->status == 'pending' && $order->snap_token)
<script src="{{ config('services.midtrans.is_production') ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js' }}" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
<script>
    document.getElementById('pay-button').onclick = function(e){
        e.preventDefault();
        // SnapToken acquired from previous step
        snap.pay('{{ $order->snap_token }}', {
            // Optional
            onSuccess: function(result){
                window.location.href = "{{ route('customer.order_detail', $order->invoice_number) }}";
            },
            // Optional
            onPending: function(result){
                window.location.href = "{{ route('customer.order_detail', $order->invoice_number) }}";
            },
            // Optional
            onError: function(result){
                alert("Pembayaran gagal!");
            }
        });
    };
</script>
@endif
@endpush
