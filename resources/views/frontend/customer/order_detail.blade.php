@extends('layouts.app')

@section('content')
<div class="bg-light py-4 border-bottom">
    <div class="container">
        <h2 class="fw-bold text-dark mb-0"><i class="bi bi-receipt me-2"></i> Order Details</h2>
    </div>
</div>

<div class="container py-5">
    <div class="mb-4">
        <a href="{{ route('customer.dashboard') }}" class="text-decoration-none"><i class="bi bi-arrow-left me-2"></i> Back to My Orders</a>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold">Items in this Order</h5>
                    <span class="text-muted small">Invoice: <span class="fw-bold text-dark">{{ $order->invoice_number }}</span></span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light text-muted small">
                                <tr>
                                    <th class="ps-4">Product</th>
                                    <th>Price</th>
                                    <th class="text-center">Qty</th>
                                    <th class="text-end pe-4">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                <tr>
                                    <td class="ps-4 py-3">
                                        <span class="text-dark fw-bold">{{ $item->name }}</span>
                                    </td>
                                    <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                    <td class="text-center">{{ $item->quantity }}</td>
                                    <td class="text-end pe-4 fw-bold">Rp {{ number_format($item->total, 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-white border-top-0 pt-0 pb-3">
                    <div class="d-flex justify-content-end mt-3">
                        <div style="width: 300px;">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Subtotal</span>
                                <span>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Shipping</span>
                                <span>Rp {{ number_format($order->total_amount - $order->subtotal, 0, ',', '.') }}</span>
                            </div>
                            <hr class="my-2">
                            <div class="d-flex justify-content-between">
                                <span class="fw-bold">Total Amount</span>
                                <span class="fw-bold text-primary fs-5">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold">Order Information</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <span class="text-muted d-block small">Status</span>
                        @if($order->status == 'pending')
                            <span class="badge bg-warning text-dark px-3 py-2 mt-1">Pending</span>
                            <p class="small text-muted mt-2">Waiting for payment/processing.</p>
                            @if($order->snap_token)
                                <button id="pay-button" class="btn btn-success btn-sm fw-bold px-3 py-2 rounded-pill shadow-sm mt-2">
                                    <i class="bi bi-credit-card me-1"></i> Bayar Sekarang
                                </button>
                            @endif
                        @elseif($order->status == 'processing')
                            <span class="badge bg-info text-dark px-3 py-2 mt-1">Processing</span>
                            <p class="small text-muted mt-2">Your order is being prepared.</p>
                        @elseif($order->status == 'completed')
                            <span class="badge bg-success px-3 py-2 mt-1">Completed</span>
                        @elseif($order->status == 'cancelled')
                            <span class="badge bg-danger px-3 py-2 mt-1">Cancelled</span>
                        @elseif($order->status == 'quotation_requested')
                            <span class="badge bg-primary text-white px-3 py-2 mt-1">Quotation Requested</span>
                            <p class="small text-muted mt-2">Menunggu balasan penawaran dari Admin.</p>
                        @elseif($order->status == 'quotation_sent')
                            <span class="badge bg-success px-3 py-2 mt-1">Quotation Sent</span>
                            <p class="small text-muted mt-2">Admin telah membalas penawaran Anda. Jika harga cocok, Anda bisa membalas email atau menghubungi kami kembali via WhatsApp.</p>
                        @else
                            <span class="badge bg-secondary px-3 py-2 mt-1">{{ ucfirst(str_replace('_', ' ', $order->status)) }}</span>
                        @endif
                    </div>
                    
                    <div class="mb-3">
                        <span class="text-muted d-block small">Order Date</span>
                        <span class="fw-bold">{{ $order->created_at->format('d M Y H:i:s') }}</span>
                    </div>
                    
                    <div>
                        <span class="text-muted d-block small mb-1">Billing Details</span>
                        <strong>{{ $order->contact_person }}</strong><br>
                        {{ $order->phone }}<br>
                        {{ $order->email }}<br><br>
                        {{ $order->address }}<br>
                        {{ $order->city }}
                    </div>
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
                window.location.reload();
            },
            // Optional
            onPending: function(result){
                window.location.reload();
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
