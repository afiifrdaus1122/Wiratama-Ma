@extends('adminlte::page')

@section('title', 'Event Highlights')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1>Manage Event Highlights</h1>
        <a href="{{ route('admin.highlights.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> New Highlight</a>
    </div>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Type</th>
                            <th>Media</th>
                            <th>Status / Expires At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($events as $event)
                            <tr>
                                <td>{{ $event->title }}</td>
                                <td><span class="badge badge-info">{{ strtoupper($event->type) }}</span></td>
                                <td>
                                    @if($event->media_path)
                                        @if($event->type == 'video')
                                            <span class="badge badge-secondary"><i class="fas fa-video"></i> Video File</span>
                                        @else
                                            <img src="{{ asset('storage/'.$event->media_path) }}" height="50" class="rounded">
                                        @endif
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @if($event->expires_at > now())
                                        <span class="badge badge-success">ACTIVE</span><br>
                                        <small class="text-muted">Until: {{ $event->expires_at->format('d M Y H:i') }}</small>
                                    @else
                                        <span class="badge badge-danger">EXPIRED</span><br>
                                        <small class="text-muted">Expired on: {{ $event->expires_at->format('d M Y H:i') }}</small>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.highlights.edit', $event) }}" class="btn btn-sm btn-info"><i class="fas fa-edit"></i></a>
                                    <form action="{{ route('admin.highlights.destroy', $event) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this highlight?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">No highlights found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop
