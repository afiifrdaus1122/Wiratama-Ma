@extends('adminlte::page')

@section('title', 'Tanya Jawab Produk')

@section('content_header')
    <h1>Tanya Jawab Produk</h1>
@stop

@section('content')
<div class="container-fluid">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                    <thead class="table-light">
                        <tr>
                            <th>Tanggal</th>
                            <th>Pengguna</th>
                            <th>Produk</th>
                            <th>Pertanyaan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($questions as $q)
                        <tr>
                            <td>{{ $q->created_at->format('d M Y H:i') }}</td>
                            <td>{{ $q->user->name ?? 'Guest' }}</td>
                            <td>
                                <a href="{{ route('products.show', $q->product->slug) }}" target="_blank">
                                    {{ Str::limit($q->product->name, 30) }}
                                </a>
                            </td>
                            <td>{{ Str::limit($q->question, 50) }}</td>
                            <td>
                                @if($q->status == 'pending')
                                    <span class="badge bg-warning text-dark">Menunggu Balasan</span>
                                @else
                                    <span class="badge bg-success">Terjawab</span>
                                @endif
                            </td>
                            <td>
                                <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#replyModal{{ $q->id }}">
                                    <i class="bi bi-reply"></i> Balas
                                </button>
                                <form action="{{ route('admin.product-questions.destroy', $q->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus pertanyaan ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>

                        <!-- Reply Modal -->
                        <div class="modal fade" id="replyModal{{ $q->id }}" tabindex="-1" aria-labelledby="replyModalLabel{{ $q->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('admin.product-questions.update', $q->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="replyModalLabel{{ $q->id }}">Balas Pertanyaan</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <strong>Produk:</strong> {{ $q->product->name }}<br>
                                                <strong>Pengguna:</strong> {{ $q->user->name ?? 'Guest' }}
                                            </div>
                                            <div class="mb-3 p-3 bg-light rounded">
                                                <strong>Pertanyaan:</strong><br>
                                                {{ $q->question }}
                                            </div>
                                            <div class="mb-3">
                                                <label for="answer" class="form-label">Jawaban Admin:</label>
                                                <textarea class="form-control" name="answer" rows="4" required>{{ $q->answer }}</textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                            <button type="submit" class="btn btn-primary">Simpan Balasan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">Belum ada pertanyaan produk.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $questions->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
