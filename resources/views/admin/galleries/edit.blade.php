@extends('adminlte::page')

@section('title', 'Edit Gallery Image')

@section('content_header')
    <h1>Edit Gallery Image</h1>
@stop

@section('content')
    <div class="card card-primary card-outline">
        <form action="{{ route('admin.galleries.update', $gallery) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="form-group">
                    <label>Title</label>
                    <input type="text" name="title" class="form-control" value="{{ $gallery->title }}" required>
                </div>
                <div class="form-group">
                    <label>Gallery Category</label>
                    <input list="categoryList" name="gallery_category" class="form-control" value="{{ $gallery->gallery_category }}" placeholder="Type a new category or select existing" required>
                    <datalist id="categoryList">
                        @foreach($galleryCategories as $cat)
                            <option value="{{ $cat }}">
                        @endforeach
                    </datalist>
                    <small class="form-text text-muted">Example: Flow Meter Installation, PLC Programming, etc.</small>
                </div>
                <div class="form-group">
                    <label>Current Images</label><br>
                    @if($gallery->images && count($gallery->images) > 0)
                        @foreach($gallery->images as $img)
                            <img src="{{ asset('storage/'.$img) }}" class="img-thumbnail mb-2 me-2" style="max-height: 150px;">
                        @endforeach
                    @else
                        <img src="{{ asset('storage/'.$gallery->image) }}" class="img-thumbnail mb-2" style="max-height: 150px;">
                    @endif
                    <br>
                    <label>Upload New Images (Leave empty to keep current)</label>
                    <input type="file" name="image_path[]" class="form-control-file" accept="image/*" multiple>
                </div>
                <div class="form-group">
                    <label>Description (Optional)</label>
                    <textarea name="description" class="form-control" rows="3">{{ $gallery->description }}</textarea>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Update Image</button>
                <a href="{{ route('admin.galleries.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
@stop
