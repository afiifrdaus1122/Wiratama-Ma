@extends('adminlte::page')

@section('title', 'Add Client Logo')

@section('content_header')
    <h1>Add Client Logo</h1>
@stop

@section('content')
<div class="card card-primary">
    <form action="{{ route('admin.client-logos.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card-body">
            <div class="form-group">
                <label>Company Name (Alt Text)</label>
                <input type="text" name="name" class="form-control" required value="{{ old('name') }}">
            </div>
            <div class="form-group">
                <label>Logo Image</label>
                <input type="file" name="image" class="form-control-file" accept="image/*" required>
            </div>
            <div class="form-group">
                <label>Company URL (Optional)</label>
                <input type="url" name="url" class="form-control" value="{{ old('url') }}">
            </div>
            <div class="form-group">
                <label>Display Order</label>
                <input type="number" name="order" class="form-control" value="{{ old('order', 0) }}">
            </div>
            <div class="form-group">
                <div class="custom-control custom-switch">
                    <input type="checkbox" name="is_active" class="custom-control-input" id="isActive" checked value="1">
                    <label class="custom-control-label" for="isActive">Active</label>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save Logo</button>
            <a href="{{ route('admin.client-logos.index') }}" class="btn btn-default">Cancel</a>
        </div>
    </form>
</div>
@stop
