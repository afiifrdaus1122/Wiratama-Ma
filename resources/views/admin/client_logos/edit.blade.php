@extends('adminlte::page')

@section('title', 'Edit Client Logo')

@section('content_header')
    <h1>Edit Client Logo</h1>
@stop

@section('content')
<div class="card card-primary">
    <form action="{{ route('admin.client-logos.update', $clientLogo) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="card-body">
            <div class="form-group">
                <label>Company Name (Alt Text)</label>
                <input type="text" name="name" class="form-control" required value="{{ old('name', $clientLogo->name) }}">
            </div>
            <div class="form-group">
                <label>Logo Image</label>
                <div class="mb-2">
                    <img src="{{ asset('storage/'.$clientLogo->image) }}" height="50">
                </div>
                <input type="file" name="image" class="form-control-file" accept="image/*">
                <small class="text-muted">Leave empty to keep the current image.</small>
            </div>
            <div class="form-group">
                <label>Company URL (Optional)</label>
                <input type="url" name="url" class="form-control" value="{{ old('url', $clientLogo->url) }}">
            </div>
            <div class="form-group">
                <label>Display Order</label>
                <input type="number" name="order" class="form-control" value="{{ old('order', $clientLogo->order) }}">
            </div>
            <div class="form-group">
                <div class="custom-control custom-switch">
                    <input type="checkbox" name="is_active" class="custom-control-input" id="isActive" {{ $clientLogo->is_active ? 'checked' : '' }} value="1">
                    <label class="custom-control-label" for="isActive">Active</label>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update Logo</button>
            <a href="{{ route('admin.client-logos.index') }}" class="btn btn-default">Cancel</a>
        </div>
    </form>
</div>
@stop
