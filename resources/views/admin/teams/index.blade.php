@extends('adminlte::page')

@section('title', 'Team Members')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Team Members</h1>
        </div>
        <div class="col-sm-6 text-right">
            <a href="{{ route('admin.teams.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Add Team Member</a>
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
                        <th width="100">Photo</th>
                        <th>Name & Position</th>
                        <th>Bio</th>
                        <th width="150">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($teams as $team)
                        <tr>
                            <td>
                                @if($team->photo)
                                    <img src="{{ asset('storage/'.$team->photo) }}" class="img-circle img-thumbnail" style="height: 60px; width: 60px; object-fit: cover;">
                                @else
                                    <div class="bg-secondary img-circle d-flex align-items-center justify-content-center" style="height: 60px; width: 60px;">
                                        <i class="fas fa-user text-white"></i>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <strong>{{ $team->name }}</strong><br>
                                <span class="badge badge-info">{{ $team->position }}</span>
                            </td>
                            <td>{{ Str::limit($team->bio, 50) }}</td>
                            <td>
                                <a href="{{ route('admin.teams.edit', $team) }}" class="btn btn-sm btn-info"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('admin.teams.destroy', $team) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this member?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">No team members found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $teams->links() }}
        </div>
    </div>
@stop
