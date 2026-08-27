@extends('adminlte::page')

@section('title', 'New Highlight Event')

@section('content_header')
    <h1>Create New Highlight Event</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card card-primary">
                <form action="{{ route('admin.highlights.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label>Title / Name</label>
                            <input type="text" name="title" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Content Type</label>
                            <select name="type" class="form-control">
                                <option value="image">Image Banner</option>
                                <option value="video">Video Banner</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Media File (Image / Video)</label>
                            <input type="file" name="media" class="form-control-file" accept="image/*,video/*" required>
                            <small class="text-muted">For video, please keep it under 20MB and use MP4/WEBM.</small>
                        </div>
                        <div class="form-group">
                            <label>Description (Optional)</label>
                            <textarea name="content" class="form-control" rows="3"></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Action Button Text</label>
                                    <input type="text" name="action_text" class="form-control" placeholder="e.g. Read More">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Action Button Link</label>
                                    <input type="url" name="action_link" class="form-control" placeholder="https://...">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Expiration Date & Time</label>
                            <input type="datetime-local" name="expires_at" class="form-control" required>
                            <small class="text-muted">The highlight will disappear automatically from the homepage after this time.</small>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Save & Publish</button>
                        <a href="{{ route('admin.highlights.index') }}" class="btn btn-default float-right">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop
