@extends('adminlte::page')

@section('title', 'All Articles')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>All Articles</h1>
        </div>
        <div class="col-sm-6 text-right">
            <a href="{{ route('admin.articles.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Write New Article</a>
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

            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th width="80">Thumb</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th width="150">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($articles as $article)
                        <tr>
                            <td>
                                @if($article->image)
                                    <img src="{{ asset('storage/'.$article->image) }}" alt="thumb" class="img-thumbnail" style="height: 50px; width: 80px; object-fit: cover;">
                                @else
                                    <span class="text-muted small">No Image</span>
                                @endif
                            </td>
                            <td>
                                <strong>{{ $article->title }}</strong><br>
                                <a href="{{ route('blog.show', $article->slug) }}" target="_blank" class="text-muted small"><i class="fas fa-external-link-alt"></i> View</a>
                            </td>
                            <td>{{ $article->category ? $article->category->name : 'Uncategorized' }}</td>
                            <td>
                                @if($article->is_published)
                                    <span class="badge badge-success">Published</span>
                                @else
                                    <span class="badge badge-secondary">Draft</span>
                                @endif
                            </td>
                            <td>{{ $article->created_at->format('M d, Y') }}</td>
                            <td>
                                <a href="{{ route('admin.articles.edit', $article) }}" class="btn btn-sm btn-info"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('admin.articles.destroy', $article) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this article?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">No articles found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $articles->links() }}
        </div>
    </div>
@stop
