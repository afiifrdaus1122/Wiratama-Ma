@extends('adminlte::page')

@section('title', 'Manage Orders')

@section('content_header')
    <h1>Manage Orders</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title">Order List</h3>
        <a href="{{ route('admin.orders.export') }}" class="btn btn-success btn-sm ml-auto"><i class="fas fa-file-excel"></i> Export Excel</a>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h5><i class="icon fas fa-check"></i> Success!</h5>
                {{ session('success') }}
            </div>
        @endif
        
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Invoice Number</th>
                    <th>Customer Name</th>
                    <th>Email</th>
                    <th>City</th>
                    <th>Total Amount</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th width="150px">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr>
                    <td>{{ $order->invoice_number }}</td>
                    <td>{{ $order->contact_person }}</td>
                    <td>{{ $order->email }}</td>
                    <td>{{ $order->city }}</td>
                    <td>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                    <td>
                        @if($order->status == 'quotation_requested')
                            <span class="badge badge-info"><i class="fas fa-file-invoice"></i> Requested</span>
                        @elseif($order->status == 'quotation_sent')
                            <span class="badge badge-primary"><i class="fas fa-paper-plane"></i> Sent</span>
                        @elseif($order->status == 'negotiation')
                            <span class="badge badge-warning"><i class="fas fa-comments"></i> Negotiation</span>
                        @elseif($order->status == 'deal_won')
                            <span class="badge badge-success"><i class="fas fa-handshake"></i> Won</span>
                        @elseif($order->status == 'deal_lost' || $order->status == 'cancelled')
                            <span class="badge badge-danger"><i class="fas fa-times-circle"></i> {{ $order->status == 'cancelled' ? 'Cancelled' : 'Lost' }}</span>
                        @elseif($order->status == 'pending')
                            <span class="badge badge-warning">Pending (Legacy)</span>
                        @elseif($order->status == 'completed')
                            <span class="badge badge-success">Completed (Legacy)</span>
                        @else
                            <span class="badge badge-secondary">{{ ucfirst(str_replace('_', ' ', $order->status)) }}</span>
                        @endif
                    </td>
                    <td>{{ $order->created_at->format('d M Y H:i') }}</td>
                    <td>
                        <form action="{{ route('admin.orders.destroy', $order) }}" method="POST">
                            <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-info" title="View Detail"><i class="fas fa-eye"></i></a>
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this order?')" title="Delete"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center">No orders found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer clearfix">
        {{ $orders->links() }}
    </div>
</div>
@stop
