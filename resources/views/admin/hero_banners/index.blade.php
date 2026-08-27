@extends('adminlte::page')

@section('title', 'Hero Banners')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Hero Banners</h1>
        <a href="{{ route('admin.hero-banners.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Add New Banner</a>
    </div>
@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body p-0">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th style="width: 50px">Order</th>
                        <th>Image</th>
                        <th>Page</th>
                        <th>Title</th>
                        <th>Status</th>
                        <th style="width: 150px">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($banners as $banner)
                        <tr>
                            <td class="align-middle">{{ $banner->sort_order }}</td>
                            <td class="align-middle">
                                @if($banner->desktop_image)
                                    <img src="{{ asset('storage/'.$banner->desktop_image) }}" alt="Banner" style="height: 50px; object-fit: cover; border-radius: 4px;">
                                @elseif($banner->background_type == 'color')
                                    <div style="height: 50px; width: 80px; background-color: {{ $banner->background_value }}; border-radius: 4px;"></div>
                                @else
                                    <span class="text-muted">No Image</span>
                                @endif
                            </td>
                            <td class="align-middle"><span class="badge badge-info">{{ $banner->page }}</span></td>
                            <td class="align-middle">
                                <strong>{{ $banner->title ?? 'No Title' }}</strong><br>
                                <small class="text-muted">{{ $banner->subtitle }}</small>
                            </td>
                            <td class="align-middle">
                                @if($banner->is_active)
                                    <span class="badge badge-success">Active</span>
                                @else
                                    <span class="badge badge-danger">Inactive</span>
                                @endif
                            </td>
                            <td class="align-middle">
                                <a href="{{ route('admin.hero-banners.edit', $banner->id) }}" class="btn btn-sm btn-info"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('admin.hero-banners.destroy', $banner->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this banner?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">No hero banners found. Click 'Add New Banner' to create one.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@stop
