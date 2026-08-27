@extends('adminlte::page')

@section('title', 'Client Logos')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1>Client Logos (Trust Signals)</h1>
        <a href="{{ route('admin.client-logos.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Add New Logo</a>
    </div>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Logo</th>
                    <th>Name / Alt Text</th>
                    <th>URL</th>
                    <th>Order</th>
                    <th>Status</th>
                    <th width="150px">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logos as $logo)
                <tr>
                    <td><img src="{{ asset('storage/'.$logo->image) }}" height="50"></td>
                    <td>{{ $logo->name }}</td>
                    <td>{{ $logo->url ?? '-' }}</td>
                    <td>{{ $logo->order }}</td>
                    <td>
                        @if($logo->is_active)
                            <span class="badge badge-success">Active</span>
                        @else
                            <span class="badge badge-danger">Inactive</span>
                        @endif
                    </td>
                    <td>
                        <form action="{{ route('admin.client-logos.destroy', $logo) }}" method="POST">
                            <a href="{{ route('admin.client-logos.edit', $logo) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">No client logos found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        {{ $logos->links() }}
    </div>
</div>
@stop
