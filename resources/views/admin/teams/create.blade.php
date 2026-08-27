@extends('adminlte::page')

@section('title', 'Add Team Member')

@section('content_header')
    <h1>Add Team Member</h1>
@stop

@section('content')
    <div class="card card-primary card-outline">
        <form action="{{ route('admin.teams.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Position / Title (Optional)</label>
                        <input type="text" name="position" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label>Photo</label>
                    <input type="file" name="photo" class="form-control-file" accept="image/*">
                </div>
                <div class="form-group">
                    <label>Biography</label>
                    <textarea name="bio" class="form-control" rows="3"></textarea>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Save Member</button>
                <a href="{{ route('admin.teams.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
@stop
