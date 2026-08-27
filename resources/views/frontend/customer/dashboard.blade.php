@extends('layouts.app')

@section('content')
<div class="bg-light py-4 border-bottom">
    <div class="container">
        <h2 class="fw-bold text-dark mb-0"><i class="bi bi-person-circle me-2"></i> My Account</h2>
    </div>
</div>

<div class="container py-5">
    <div class="row g-3 mb-4">
        <div class="col-md-4"><div class="card border-0 shadow-sm"><div class="card-body"><small class="text-muted">Total Request</small><h3 class="fw-bold mb-0">{{ $stats['total'] }}</h3></div></div></div>
        <div class="col-md-4"><div class="card border-0 shadow-sm"><div class="card-body"><small class="text-muted">RFQ Aktif</small><h3 class="fw-bold text-primary mb-0">{{ $stats['active_rfqs'] }}</h3></div></div></div>
        <div class="col-md-4"><div class="card border-0 shadow-sm"><div class="card-body"><small class="text-muted">Selesai</small><h3 class="fw-bold text-success mb-0">{{ $stats['completed'] }}</h3></div></div></div>
    </div>
    <div class="row g-4">
        <!-- Sidebar -->
        <div class="col-md-3">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body text-center">
                    <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px; font-size: 2rem;">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <h5 class="fw-bold mb-1">{{ $user->name }}</h5>
                    <p class="text-muted small">{{ $user->email }}</p>
                    
                    <form action="{{ route('customer.logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger btn-sm w-100">Logout</button>
                    </form>
                </div>
            </div>
            
            <div class="list-group shadow-sm border-0">
                <a href="{{ route('customer.dashboard') }}" class="list-group-item list-group-item-action active fw-bold">
                    <i class="bi bi-box-seam me-2"></i> My Orders
                </a>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="col-md-9">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold">Order History</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light text-muted small">
                                <tr>
                                    <th class="ps-4">Invoice Number</th>
                                    <th>Date</th>
                                    <th>Total Amount</th>
                                    <th>Status</th>
                                    <th class="pe-4 text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($orders as $order)
                                <tr>
                                    <td class="ps-4 fw-bold text-primary">{{ $order->invoice_number }}</td>
                                    <td>{{ $order->created_at->format('d M Y') }}</td>
                                    <td>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                    <td>
                                        @if($order->status == 'pending')
                                            <span class="badge bg-warning text-dark">Pending</span>
                                        @elseif($order->status == 'processing')
                                            <span class="badge bg-info text-dark">Processing</span>
                                        @elseif($order->status == 'completed')
                                            <span class="badge bg-success">Completed</span>
                                        @elseif($order->status == 'cancelled')
                                            <span class="badge bg-danger">Cancelled</span>
                                        @elseif($order->status == 'quotation_requested')
                                            <span class="badge bg-primary">RFQ Diterima</span>
                                        @elseif($order->status == 'quotation_sent')
                                            <span class="badge bg-success">Quotation Tersedia</span>
                                        @elseif($order->status == 'negotiation')
                                            <span class="badge bg-info text-dark">Negosiasi</span>
                                        @elseif($order->status == 'deal_won')
                                            <span class="badge bg-success">Deal Won</span>
                                        @elseif($order->status == 'deal_lost')
                                            <span class="badge bg-danger">Deal Lost</span>
                                        @else
                                            <span class="badge bg-secondary">{{ ucfirst(str_replace('_', ' ', $order->status)) }}</span>
                                        @endif
                                    </td>
                                    <td class="pe-4 text-center">
                                        <a href="{{ route('customer.order_detail', $order->invoice_number) }}" class="btn btn-sm btn-outline-primary">View Detail</a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">You haven't placed any orders yet.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
