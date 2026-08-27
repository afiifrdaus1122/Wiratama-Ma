@extends('adminlte::page')

@section('title', 'Order Details - ' . $order->invoice_number)

@section('content_header')
    <h1>Order Details</h1>
@stop

@section('content')
<div class="row">
    <div class="col-12">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h5><i class="icon fas fa-check"></i> Success!</h5>
                {{ session('success') }}
            </div>
        @endif
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Customer Information</h3>
            </div>
            <div class="card-body">
                <strong>Invoice Number</strong>
                <p class="text-muted">{{ $order->invoice_number }}</p>
                
                <strong>Customer Name</strong>
                <p class="text-muted">{{ $order->contact_person }}</p>

                <strong>Company Name</strong>
                <p class="text-muted">{{ $order->company_name ?: '-' }}</p>

                <strong>Email</strong>
                <p class="text-muted">{{ $order->email }}</p>

                <strong>WhatsApp / Phone</strong>
                <p class="text-muted">{{ $order->phone }}</p>

                <strong>City</strong>
                <p class="text-muted">{{ $order->city }}</p>

                <strong>Address</strong>
                <p class="text-muted">{{ $order->address }}</p>

                <strong>Notes</strong>
                <p class="text-muted">{{ $order->notes ?: '-' }}</p>
                
                <strong>Order Date</strong>
                <p class="text-muted">{{ $order->created_at->format('d M Y H:i:s') }}</p>
                
                <strong>Update Status</strong>
                <form action="{{ route('admin.orders.update', $order) }}" method="POST" class="mt-2">
                    @csrf
                    @method('PUT')
                    <div class="input-group">
                        <select name="status" class="form-control">
                            <option value="quotation_requested" {{ $order->status == 'quotation_requested' ? 'selected' : '' }}>Quotation Requested (New)</option>
                            <option value="quotation_sent" {{ $order->status == 'quotation_sent' ? 'selected' : '' }}>Quotation Sent (Waiting Client)</option>
                            <option value="negotiation" {{ $order->status == 'negotiation' ? 'selected' : '' }}>Negotiation</option>
                            <option value="deal_won" {{ $order->status == 'deal_won' ? 'selected' : '' }}>Deal Won (PO Received)</option>
                            <option value="deal_lost" {{ $order->status == 'deal_lost' ? 'selected' : '' }}>Deal Lost</option>
                            <option disabled>--- E-Commerce Legacy ---</option>
                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                            <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                        <span class="input-group-append">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </span>
                    </div>
                    <textarea name="note" class="form-control mt-2" rows="2" placeholder="Catatan perubahan status (opsional)"></textarea>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Order Items</h3>
            </div>
            <div class="card-body p-0">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Product Name</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th class="text-right">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                        <tr>
                            <td>{{ $item->name }}</td>
                            <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td class="text-right">Rp {{ number_format($item->total, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="3" class="text-right">Subtotal:</th>
                            <th class="text-right">Rp {{ number_format($order->subtotal, 0, ',', '.') }}</th>
                        </tr>
                        <tr>
                            <th colspan="3" class="text-right">Shipping:</th>
                            <th class="text-right">Rp {{ number_format($order->total_amount - $order->subtotal, 0, ',', '.') }}</th>
                        </tr>
                        <tr>
                            <th colspan="3" class="text-right">Total Amount:</th>
                            <th class="text-right text-success"><h4>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</h4></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="card-footer">
                <a href="{{ route('admin.orders.index') }}" class="btn btn-default"><i class="fas fa-arrow-left"></i> Back to Orders</a>
            </div>
        </div>
    </div>
</div>
@stop
