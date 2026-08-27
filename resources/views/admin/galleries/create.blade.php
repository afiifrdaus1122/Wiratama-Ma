@extends('adminlte::page')

@section('title', 'Add Gallery Image')

@section('content_header')
    <h1>Add New Image to Gallery</h1>
@stop

@section('content')
    <div class="card card-primary card-outline">
        <form action="{{ route('admin.galleries.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label>Title</label>
                    <input type="text" name="title" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Gallery Category</label>
                    <input list="categoryList" name="gallery_category" class="form-control" placeholder="Type a new category or select existing" required>
                    <datalist id="categoryList">
                        @foreach($galleryCategories as $cat)
                            <option value="{{ $cat }}">
                        @endforeach
                    </datalist>
                    <small class="form-text text-muted">Example: Flow Meter Installation, PLC Programming, etc.</small>
                </div>
                <div class="form-group">
                    <label>Image Files (You can select multiple photos)</label>
                    <input type="file" name="image_path[]" class="form-control-file" accept="image/*" multiple required>
                </div>
                <div class="form-group">
                    <label>Description (Optional)</label>
                    <textarea name="description" class="form-control" rows="3"></textarea>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Upload Image</button>
                <a href="{{ route('admin.galleries.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
@stop
