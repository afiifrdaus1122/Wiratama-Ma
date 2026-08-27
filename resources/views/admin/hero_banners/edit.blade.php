@extends('adminlte::page')

@section('title', 'Edit Hero Banner')

@section('content_header')
    <h1>Edit Hero Banner</h1>
@stop

@section('content')
    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">Banner Configuration</h3>
        </div>
        <form action="{{ route('admin.hero-banners.update', $heroBanner->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card-body row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Page to Display</label>
                        <select name="page" class="form-control">
                            <option value="home" {{ $heroBanner->page == 'home' ? 'selected' : '' }}>Home (Beranda)</option>
                            <option value="products" {{ $heroBanner->page == 'products' ? 'selected' : '' }}>Products</option>
                            <option value="about" {{ $heroBanner->page == 'about' ? 'selected' : '' }}>About Us</option>
                            <option value="contact" {{ $heroBanner->page == 'contact' ? 'selected' : '' }}>Contact</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" name="title" class="form-control" value="{{ old('title', $heroBanner->title) }}">
                    </div>

                    <div class="form-group">
                        <label>Subtitle</label>
                        <input type="text" name="subtitle" class="form-control" value="{{ old('subtitle', $heroBanner->subtitle) }}">
                    </div>

                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="description" class="form-control" rows="3">{{ old('description', $heroBanner->description) }}</textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Call to Action (Button) Text</label>
                            <input type="text" name="cta_text" class="form-control" value="{{ old('cta_text', $heroBanner->cta_text) }}" placeholder="e.g. Shop Now">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Call to Action URL</label>
                            <input type="text" name="cta_url" class="form-control" value="{{ old('cta_url', $heroBanner->cta_url) }}" placeholder="e.g. /products">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Content Position</label>
                        <select name="position" class="form-control">
                            <option value="left" {{ $heroBanner->position == 'left' ? 'selected' : '' }}>Left</option>
                            <option value="center" {{ $heroBanner->position == 'center' ? 'selected' : '' }}>Center</option>
                            <option value="right" {{ $heroBanner->position == 'right' ? 'selected' : '' }}>Right</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Background Type</label>
                        <select name="background_type" class="form-control" id="bg_type">
                            <option value="image" {{ $heroBanner->background_type == 'image' ? 'selected' : '' }}>Image Upload</option>
                            <option value="color" {{ $heroBanner->background_type == 'color' ? 'selected' : '' }}>Solid Color</option>
                        </select>
                    </div>

                    <div class="form-group" id="bg_color_wrapper" style="display: {{ $heroBanner->background_type == 'color' ? 'block' : 'none' }};">
                        <label>Background Color</label>
                        <input type="color" name="background_value" class="form-control" value="{{ old('background_value', $heroBanner->background_value ?? '#2b3b55') }}">
                    </div>

                    <div class="form-group" id="bg_image_desktop_wrapper" style="display: {{ $heroBanner->background_type == 'image' ? 'block' : 'none' }};">
                        <label>Desktop Image (Recommended: 1920x800)</label>
                        @if($heroBanner->desktop_image)
                            <div class="mb-2">
                                <img src="{{ asset('storage/'.$heroBanner->desktop_image) }}" alt="Desktop" style="max-height: 100px; border-radius: 4px;">
                            </div>
                        @endif
                        <input type="file" name="desktop_image" class="form-control-file" accept="image/*">
                        <small class="text-muted">Leave blank to keep current image</small>
                    </div>

                    <div class="form-group" id="bg_image_mobile_wrapper" style="display: {{ $heroBanner->background_type == 'image' ? 'block' : 'none' }};">
                        <label>Mobile Image (Recommended: 800x1200)</label>
                        @if($heroBanner->mobile_image)
                            <div class="mb-2">
                                <img src="{{ asset('storage/'.$heroBanner->mobile_image) }}" alt="Mobile" style="max-height: 100px; border-radius: 4px;">
                            </div>
                        @endif
                        <input type="file" name="mobile_image" class="form-control-file" accept="image/*">
                        <small class="text-muted">Leave blank to keep current image</small>
                    </div>

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Overlay Color</label>
                            <input type="color" name="overlay_color" class="form-control" value="{{ old('overlay_color', $heroBanner->overlay_color) }}">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Overlay Opacity (0.0 to 1.0)</label>
                            <input type="number" step="0.1" name="overlay_opacity" class="form-control" value="{{ old('overlay_opacity', $heroBanner->overlay_opacity) }}" min="0" max="1">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Height (vh) 10-100</label>
                            <input type="number" name="height_vh" class="form-control" value="{{ old('height_vh', $heroBanner->height_vh) }}" min="10" max="100">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Sort Order</label>
                            <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $heroBanner->sort_order) }}">
                        </div>
                    </div>

                    <div class="form-group mt-4">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" {{ $heroBanner->is_active ? 'checked' : '' }}>
                            <label class="custom-control-label" for="is_active">Publish this banner</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-info">Update Banner</button>
                <a href="{{ route('admin.hero-banners.index') }}" class="btn btn-default">Cancel</a>
            </div>
        </form>
    </div>
@stop

@section('js')
<script>
    document.getElementById('bg_type').addEventListener('change', function() {
        if(this.value == 'color') {
            document.getElementById('bg_color_wrapper').style.display = 'block';
            document.getElementById('bg_image_desktop_wrapper').style.display = 'none';
            document.getElementById('bg_image_mobile_wrapper').style.display = 'none';
        } else {
            document.getElementById('bg_color_wrapper').style.display = 'none';
            document.getElementById('bg_image_desktop_wrapper').style.display = 'block';
            document.getElementById('bg_image_mobile_wrapper').style.display = 'block';
        }
    });
</script>
@stop
