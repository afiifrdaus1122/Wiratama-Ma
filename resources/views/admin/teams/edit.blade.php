@extends('adminlte::page')

@section('title', 'Edit Team Member')

@section('content_header')
    <h1>Edit Team Member</h1>
@stop

@section('content')
    <div class="card card-primary card-outline">
        <form action="{{ route('admin.teams.update', $team) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control" value="{{ $team->name }}" required>
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Position / Title (Optional)</label>
                        <input type="text" name="position" class="form-control" value="{{ $team->position }}">
                    </div>
                </div>
                <div class="form-group">
                    <label>Current Photo</label><br>
                    @if($team->photo)
                        <img src="{{ asset('storage/'.$team->photo) }}" class="img-thumbnail mb-2" style="max-height: 150px;"><br>
                    @endif
                    <label>Upload New Photo (Leave empty to keep current)</label>
                    <input type="file" name="photo" class="form-control-file" accept="image/*">
                </div>
                <div class="form-group">
                    <label>Biography</label>
                    <textarea name="bio" class="form-control" rows="3">{{ $team->bio }}</textarea>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Update Member</button>
                <a href="{{ route('admin.teams.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
@stop
