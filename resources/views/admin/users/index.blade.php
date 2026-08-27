@extends('adminlte::page')

@section('title', 'Admin Management')

@section('content_header')
    <h1>Admin Management</h1>
@stop

@section('content')
<div class="row">
    <!-- Add Admin Form -->
    <div class="col-md-4">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Add New Admin</h3>
            </div>
            <form action="{{ route('admin.admin-users.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="form-group">
                        <label>Full Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Enter full name" required>
                    </div>
                    <div class="form-group">
                        <label>Email address</label>
                        <input type="email" name="email" class="form-control" placeholder="Enter email" required>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Password (Min 8 characters)" required>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary w-100">Add Admin</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Admin List -->
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">List of Administrators</h3>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($admins as $admin)
                        <tr>
                            <td>{{ $admin->id }}</td>
                            <td>{{ $admin->name }}</td>
                            <td>{{ $admin->email }}</td>
                            <td>
                                @if($admin->role == 'superadmin')
                                    <span class="badge badge-danger">Superadmin</span>
                                @else
                                    <span class="badge badge-primary">Admin</span>
                                @endif
                            </td>
                            <td>{{ $admin->created_at->format('d M Y') }}</td>
                            <td>
                                @if($admin->id !== auth()->id() && $admin->role !== 'superadmin')
                                <form action="{{ route('admin.admin-users.destroy', $admin) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this admin?')">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </form>
                                @else
                                    <button class="btn btn-sm btn-secondary" disabled>No Action</button>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@stop
