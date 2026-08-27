@extends('adminlte::page')

@section('title', 'Add New Product')

@section('content_header')
    <h1>Add New Product</h1>
@stop

@section('content')
    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-8">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">Product Information</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Product Name</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                        </div>
                        
                        <div class="form-group">
                            <label>Brand</label>
                            <input type="text" name="brand" class="form-control" value="{{ old('brand') }}">
                        </div>

                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="description" class="summernote" required>{{ old('description') }}</textarea>
                        </div>

                        <div class="form-group">
                            <label>Technical Specifications (Detailed description)</label>
                            <textarea name="specification" class="summernote">{{ old('specification') }}</textarea>
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
                            <input type="text" name="meta_title" class="form-control" value="{{ old('meta_title') }}" placeholder="Judul khusus di pencarian Google (Default: Nama Produk)">
                        </div>
                        <div class="form-group">
                            <label>Meta Keywords</label>
                            <input type="text" name="meta_keywords" class="form-control" value="{{ old('meta_keywords') }}" placeholder="Contoh: flow meter, oil skimmer, wma, supplier jakarta">
                        </div>
                        <div class="form-group">
                            <label>Meta Description</label>
                            <textarea name="meta_description" class="form-control" rows="3" placeholder="Deskripsi singkat produk yang tampil di snippet hasil pencarian Google">{{ old('meta_description') }}</textarea>
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
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Sub Category</label>
                            <select name="sub_category_id" id="sub_category_id" class="form-control select2-tags">
                                <option value="">-- Select or Type New Sub Category --</option>
                                @foreach($subCategories as $subCategory)
                                    <option value="{{ $subCategory->id }}" data-category="{{ $subCategory->category_id }}">{{ $subCategory->name }}</option>
                                @endforeach
                            </select>
                            <small class="text-muted">Optional. Options will be filtered based on the selected Category.</small>
                        </div>

                        <div class="form-group">
                            <label>Price (Rp)</label>
                            <input type="number" name="price" class="form-control" min="0" value="{{ old('price', 0) }}" required>
                        </div>

                        <div class="form-group">
                            <label>Related Articles</label>
                            <select name="article_ids[]" class="form-control select2-tags" multiple data-placeholder="-- Select related articles --">
                                @foreach($articles as $article)
                                    <option value="{{ $article->id }}" {{ in_array($article->id, old('article_ids', [])) ? 'selected' : '' }}>{{ $article->title }}</option>
                                @endforeach
                            </select>
                            <small class="text-muted">Pilih artikel yang ingin ditampilkan pada halaman produk ini.</small>
                        </div>

                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" name="is_active" class="custom-control-input" id="isActive" checked value="1">
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
                            <input type="file" name="image" class="form-control-file" accept="image/*">
                        </div>

                        <div class="form-group">
                            <label>Additional Images (Multiple)</label>
                            <input type="file" name="additional_images[]" class="form-control-file" accept="image/*" multiple>
                            <small class="text-muted">Select multiple files at once.</small>
                        </div>

                        <div class="form-group">
                            <label>Datasheet (PDF)</label>
                            <input type="file" name="datasheet" class="form-control-file" accept=".pdf">
                        </div>

                        <div class="form-group">
                            <label>Video URL (Youtube/Vimeo)</label>
                            <input type="url" name="video_url" class="form-control" value="{{ old('video_url') }}" placeholder="https://youtube.com/watch?v=...">
                        </div>

                        <hr>
                        <button type="submit" class="btn btn-primary btn-block"><i class="fas fa-save"></i> Save Product</button>
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
                
                // Keep the selected value if we're just loading, but clear if changing
                $subCategorySelect.val(null).trigger('change.select2');
                
                // Show/hide options based on data-category
                $subCategorySelect.find('option').each(function() {
                    if ($(this).val() == "") return; // Skip the placeholder
                    
                    if ($(this).data('category') == categoryId) {
                        $(this).prop('disabled', false);
                    } else {
                        $(this).prop('disabled', true);
                    }
                });
                
                // Re-initialize select2 to reflect disabled options
                $subCategorySelect.select2({
                    theme: 'bootstrap4',
                    tags: true,
                    allowClear: true
                });
            });

            // Trigger change on load if a category is already selected (e.g., old input)
            if($('#category_id').val()) {
                $('#category_id').trigger('change');
            }
            
            // Add initial empty row
            addAttributeRow();
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
