@extends('adminlte::page')

@section('title', 'Edit Highlight Event')

@section('content_header')
    <h1>Edit Highlight Event</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card card-primary">
                <form action="{{ route('admin.highlights.update', $highlight) }}" method="POST" enctype="multipart/form-data">
                    @csrf @method('PUT')
                    <div class="card-body">
                        <div class="form-group">
                            <label>Title / Name</label>
                            <input type="text" name="title" class="form-control" value="{{ $highlight->title }}" required>
                        </div>
                        <div class="form-group">
                            <label>Content Type</label>
                            <select name="type" class="form-control">
                                <option value="image" {{ $highlight->type == 'image' ? 'selected' : '' }}>Image Banner</option>
                                <option value="video" {{ $highlight->type == 'video' ? 'selected' : '' }}>Video Banner</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Media File (Image / Video)</label>
                            @if($highlight->media_path)
                                <div class="mb-2">
                                    @if($highlight->type == 'video')
                                        <video src="{{ asset('storage/'.$highlight->media_path) }}" controls style="height:150px;"></video>
                                    @else
                                        <img src="{{ asset('storage/'.$highlight->media_path) }}" style="height:150px; border-radius:8px;">
                                    @endif
                                </div>
                            @endif
                            <input type="file" name="media" class="form-control-file" accept="image/*,video/*">
                            <small class="text-muted">Leave empty to keep current media.</small>
                        </div>
                        <div class="form-group">
                            <label>Description (Optional)</label>
                            <textarea name="content" class="form-control" rows="3">{{ $highlight->content }}</textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Action Button Text</label>
                                    <input type="text" name="action_text" class="form-control" value="{{ $highlight->action_text }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Action Button Link</label>
                                    <input type="url" name="action_link" class="form-control" value="{{ $highlight->action_link }}">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Expiration Date & Time</label>
                            <input type="datetime-local" name="expires_at" class="form-control" value="{{ $highlight->expires_at->format('Y-m-d\TH:i') }}" required>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Update Highlight</button>
                        <a href="{{ route('admin.highlights.index') }}" class="btn btn-default float-right">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop
