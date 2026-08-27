@extends('adminlte::page')

@section('title', 'Pesan Kontak Masuk')

@section('content_header')
    <h1>Pesan Kontak Masuk</h1>
@stop

@section('content')
<div class="container-fluid">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                    <thead class="table-light">
                        <tr>
                            <th>Status</th>
                            <th>Tanggal</th>
                            <th>Pengirim</th>
                            <th>Subjek</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($messages as $msg)
                        <tr class="{{ $msg->is_read ? '' : 'fw-bold bg-light' }}">
                            <td class="text-center">
                                @if($msg->is_read)
                                    <i class="fas fa-envelope-open text-muted" title="Sudah Dibaca"></i>
                                @else
                                    <i class="fas fa-envelope text-primary" title="Belum Dibaca"></i>
                                @endif
                            </td>
                            <td>{{ $msg->created_at->format('d M Y H:i') }}</td>
                            <td>
                                {{ $msg->name }}<br>
                                <small class="text-muted">{{ $msg->email }}</small>
                            </td>
                            <td>{{ Str::limit($msg->subject, 50) }}</td>
                            <td>
                                <a href="{{ route('admin.contacts.show', $msg->id) }}" class="btn btn-sm btn-info text-white">
                                    <i class="fas fa-eye"></i> Buka
                                </a>
                                <form action="{{ route('admin.contacts.destroy', $msg->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus pesan ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">Belum ada pesan masuk.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $messages->links() }}
            </div>
        </div>
    </div>
</div>
@stop
