@extends('adminlte::page')

@section('title', 'Documentation Gallery')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Documentation Gallery</h1>
        </div>
        <div class="col-sm-6 text-right">
            <a href="{{ route('admin.galleries.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Add New Image</a>
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

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th width="150">Image</th>
                        <th>Title & Description</th>
                        <th width="150">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($galleries as $gallery)
                        <tr>
                            <td>
                                <img src="{{ asset('storage/'.$gallery->image) }}" class="img-thumbnail" style="height: 100px; width: 150px; object-fit: cover;">
                            </td>
                            <td>
                                <strong>{{ $gallery->title }}</strong>
                                @if($gallery->gallery_category)
                                    <span class="badge badge-info ml-2">{{ $gallery->gallery_category }}</span>
                                @endif
                                <p class="text-muted small mt-1 mb-0">{{ $gallery->description }}</p>
                                @if($gallery->images && count($gallery->images) > 1)
                                    <span class="badge badge-secondary mt-1">{{ count($gallery->images) }} Photos</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.galleries.edit', $gallery) }}" class="btn btn-sm btn-info"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('admin.galleries.destroy', $gallery) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this image?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center">No images found in gallery.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $galleries->links() }}
        </div>
    </div>
@stop
