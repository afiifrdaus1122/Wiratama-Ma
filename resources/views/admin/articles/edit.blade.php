@extends('adminlte::page')

@section('title', 'Edit Article')

@section('content_header')
    <h1>Edit Article</h1>
@stop

@section('content')
    <form action="{{ route('admin.articles.update', $article) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-md-8">
                <div class="card card-primary card-outline">
                    <div class="card-body">
                        <div class="form-group">
                            <label>Article Title</label>
                            <input type="text" name="title" class="form-control" value="{{ old('title', $article->title) }}" required>
                        </div>

                        <div class="form-group">
                            <label>Content</label>
                            <textarea name="content" class="summernote" required>{{ old('content', $article->content) }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="card card-secondary">
                    <div class="card-header">
                        <h3 class="card-title">SEO Settings</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Meta Title</label>
                            <input type="text" name="meta_title" class="form-control" value="{{ old('meta_title', $article->meta_title) }}" placeholder="Judul SEO Google (Max 60 karakter)">
                        </div>
                        <div class="form-group">
                            <label>Meta Keywords</label>
                            <input type="text" name="meta_keywords" class="form-control" value="{{ old('meta_keywords', $article->meta_keywords) }}" placeholder="Contoh: artikel wma, info flow meter, konsultasi industri">
                        </div>
                        <div class="form-group">
                            <label>Meta Description</label>
                            <textarea name="meta_description" class="form-control" rows="3" placeholder="Ringkasan artikel di pencarian Google (Max 160 karakter)">{{ old('meta_description', $article->meta_description) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Publish Options</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Status</label>
                            <select name="is_published" class="form-control">
                                <option value="1" {{ $article->is_published ? 'selected' : '' }}>Published</option>
                                <option value="0" {{ !$article->is_published ? 'selected' : '' }}>Draft</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Category</label>
                            <select name="article_category_id" class="form-control select2-tags">
                                <option value="">-- Select or Type New Category --</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ $article->article_category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Thumbnail Image</label>
                            @if($article->image)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/'.$article->image) }}" class="img-fluid rounded" alt="Current Image">
                                </div>
                            @endif
                            <input type="file" name="image" class="form-control-file" accept="image/*">
                            <small class="text-muted">Leave empty to keep current image</small>
                        </div>

                        <hr>
                        <button type="submit" class="btn btn-primary btn-block"><i class="fas fa-save"></i> Update Article</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@stop

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@1.5.2/dist/select2-bootstrap4.min.css" rel="stylesheet" />
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.summernote').summernote({
                height: 400,
            });
            $('.select2-tags').select2({
                theme: 'bootstrap4',
                tags: true,
                placeholder: "-- Select or Type New Category --",
                allowClear: true
            });
        });
    </script>
@stop
