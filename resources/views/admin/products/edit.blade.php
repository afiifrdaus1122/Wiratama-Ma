@extends('adminlte::page')

@section('title', 'Edit Product')

@section('content_header')
    <h1>Edit Product: {{ $product->name }}</h1>
@stop

@section('content')
    <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-md-8">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">Product Information</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Product Name</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $product->name) }}" required>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label>SKU (Stock Keeping Unit)</label>
                                <input type="text" name="sku" class="form-control" value="{{ old('sku', $product->sku) }}" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Brand</label>
                                <input type="text" name="brand" class="form-control" value="{{ old('brand', $product->brand) }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="description" class="summernote" required>{{ old('description', $product->description) }}</textarea>
                        </div>

                        <div class="form-group">
                            <label>Technical Specifications (Detailed description)</label>
                            <textarea name="specification" class="summernote">{{ old('specification', $product->specification) }}</textarea>
                        </div>

                        <div class="form-group mt-4 border-top pt-3">
                            <label>Product Attributes (Key-Value)</label>
                            <div id="attributes-container">
                                <!-- JS will append here -->
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-primary mt-2" onclick="addAttributeRow()">
                                <i class="fas fa-plus"></i> Add Attribute
                            </button>
                        </div>
                    </div>
                </div>

                <div class="card card-warning card-outline mt-3">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-search me-1"></i> SEO Settings (Search Engine Optimization)</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Meta Title</label>
                            <input type="text" name="meta_title" class="form-control" value="{{ old('meta_title', $product->meta_title) }}" placeholder="Judul khusus di pencarian Google (Default: Nama Produk)">
                        </div>
                        <div class="form-group">
                            <label>Meta Keywords</label>
                            <input type="text" name="meta_keywords" class="form-control" value="{{ old('meta_keywords', $product->meta_keywords) }}" placeholder="Contoh: flow meter, oil skimmer, wma, supplier jakarta">
                        </div>
                        <div class="form-group">
                            <label>Meta Description</label>
                            <textarea name="meta_description" class="form-control" rows="3" placeholder="Deskripsi singkat produk yang tampil di snippet hasil pencarian Google">{{ old('meta_description', $product->meta_description) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Organization</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Category</label>
                            <select name="category_id" id="category_id" class="form-control select2-tags" required>
                                <option value="">-- Select or Type New Category --</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Sub Category</label>
                            <select name="sub_category_id" id="sub_category_id" class="form-control select2-tags">
                                <option value="">-- Select or Type New Sub Category --</option>
                                @foreach($subCategories as $subCategory)
                                    <option value="{{ $subCategory->id }}" data-category="{{ $subCategory->category_id }}" {{ $product->sub_category_id == $subCategory->id ? 'selected' : '' }}>{{ $subCategory->name }}</option>
                                @endforeach
                            </select>
                            <small class="text-muted">Optional. Options will be filtered based on the selected Category.</small>
                        </div>

                        <div class="form-group">
                            <label>Price (Rp)</label>
                            <input type="number" name="price" class="form-control" min="0" value="{{ old('price', $product->price) }}" required>
                        </div>

                        <div class="form-group">
                            <label>Stock</label>
                            <input type="number" name="stock" class="form-control" min="0" value="{{ old('stock', $product->stock) }}" required>
                        </div>

                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" name="is_active" class="custom-control-input" id="isActive" value="1" {{ $product->is_active ? 'checked' : '' }}>
                                <label class="custom-control-label" for="isActive">Product is Active</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card card-secondary">
                    <div class="card-header">
                        <h3 class="card-title">Media & Documents</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Product Image (Main)</label>
                            @if($product->image)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/'.$product->image) }}" class="img-fluid rounded" alt="Current Image">
                                </div>
                            @endif
                            <input type="file" name="image" class="form-control-file" accept="image/*">
                            <small class="text-muted">Leave empty to keep current image</small>
                        </div>

                        <div class="form-group">
                            <label>Additional Images (Multiple)</label>
                            @if($product->images && $product->images->count() > 0)
                                <div class="mb-2 row g-1">
                                    @foreach($product->images as $img)
                                        <div class="col-4">
                                            <img src="{{ asset('storage/'.$img->image) }}" class="img-fluid rounded border" alt="Additional">
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                            <input type="file" name="additional_images[]" class="form-control-file" accept="image/*" multiple>
                            <small class="text-muted">Upload more files here to append</small>
                        </div>

                        <div class="form-group">
                            <label>Datasheet (PDF)</label>
                            @if($product->datasheet)
                                <div class="mb-2">
                                    <a href="{{ asset('storage/'.$product->datasheet) }}" target="_blank" class="btn btn-sm btn-outline-danger"><i class="fas fa-file-pdf"></i> View Current PDF</a>
                                </div>
                            @endif
                            <input type="file" name="datasheet" class="form-control-file" accept=".pdf">
                            <small class="text-muted">Leave empty to keep current datasheet</small>
                        </div>

                        <div class="form-group">
                            <label>Video URL (Youtube/Vimeo)</label>
                            <input type="url" name="video_url" class="form-control" value="{{ old('video_url', $product->video_url) }}" placeholder="https://youtube.com/watch?v=...">
                        </div>

                        <hr>
                        <button type="submit" class="btn btn-primary btn-block"><i class="fas fa-save"></i> Update Product</button>
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
                height: 200,
            });
            $('.select2-tags').select2({
                theme: 'bootstrap4',
                tags: true,
                placeholder: function() {
                    $(this).data('placeholder');
                },
                allowClear: true
            });
            
            // Filter sub categories based on selected category
            $('#category_id').on('change', function() {
                var categoryId = $(this).val();
                var $subCategorySelect = $('#sub_category_id');
                var currentSubCategory = $subCategorySelect.val();
                
                // Keep the selected value if we're just loading, but clear if changing
                // Wait, if it's the initial load, we don't want to clear it if it's valid
                // We handle initial load below
                
                // Show/hide options based on data-category
                $subCategorySelect.find('option').each(function() {
                    if ($(this).val() == "") return; // Skip the placeholder
                    
                    if ($(this).data('category') == categoryId) {
                        $(this).prop('disabled', false);
                    } else {
                        $(this).prop('disabled', true);
                        if ($(this).val() == currentSubCategory) {
                            $subCategorySelect.val(null);
                        }
                    }
                });
                
                // Re-initialize select2 to reflect disabled options
                $subCategorySelect.select2({
                    theme: 'bootstrap4',
                    tags: true,
                    allowClear: true
                });
            });

            // Trigger change on load if a category is already selected
            if($('#category_id').val()) {
                $('#category_id').trigger('change');
            }
            
            @if(isset($product) && $product->attributes->count() > 0)
                @foreach($product->attributes as $attr)
                    addAttributeRow('{{ $attr->name }}', '{{ $attr->value }}');
                @endforeach
            @else
                addAttributeRow();
            @endif
        });

        function addAttributeRow(name = '', value = '') {
            const row = `
                <div class="row mb-2">
                    <div class="col-md-5">
                        <input type="text" name="attributes_name[]" class="form-control" placeholder="E.g. Voltage" value="${name}">
                    </div>
                    <div class="col-md-5">
                        <input type="text" name="attributes_value[]" class="form-control" placeholder="E.g. 220V" value="${value}">
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-danger btn-block" onclick="this.parentElement.parentElement.remove()">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            `;
            $('#attributes-container').append(row);
        }
    </script>
@stop
