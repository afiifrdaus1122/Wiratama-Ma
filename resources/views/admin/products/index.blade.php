@extends('adminlte::page')

@section('title', 'Products')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>All Products</h1>
        </div>
        <div class="col-sm-6 text-right">
            <a href="{{ route('admin.products.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Add New Product</a>
        </div>
    </div>
@stop

@section('content')
    <div class="card card-primary card-outline">
        <div class="card-body p-0">
            @if(session('success'))
                <div class="alert alert-success m-3">
                    {{ session('success') }}
                </div>
            @endif

            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th width="80">Image</th>
                        <th>Product Details</th>
                        <th>Category & Brand</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th width="150">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                        <tr>
                            <td>
                                @if($product->image)
                                    <img src="{{ asset('storage/'.$product->image) }}" alt="thumb" class="img-thumbnail" style="height: 60px; width: 60px; object-fit: cover;">
                                @else
                                    <div class="bg-secondary text-center rounded d-flex align-items-center justify-content-center" style="height: 60px; width: 60px;">
                                        <i class="fas fa-box text-white"></i>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <strong>{{ $product->name }}</strong><br>
                                <a href="{{ route('products.show', $product->slug) }}" target="_blank" class="text-muted small"><i class="fas fa-external-link-alt"></i> View</a>
                            </td>
                            <td>
                                {{ $product->category->name }}<br>
                                <span class="badge badge-info">{{ $product->brand ?? 'No Brand' }}</span>
                            </td>
                            <td>
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </td>
                            <td>
                                @if($product->is_active)
                                    <span class="badge badge-success">Active</span>
                                @else
                                    <span class="badge badge-secondary">Inactive</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-info"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this product?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">No products found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $products->links() }}
        </div>
    </div>
@stop
