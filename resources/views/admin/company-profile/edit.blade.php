@extends('adminlte::page')

@section('title', 'Website & Menu Settings')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1><i class="fas fa-sliders-h text-primary me-2"></i> Website & Menu Settings</h1>
        <a href="{{ url('/') }}" target="_blank" class="btn btn-outline-primary btn-sm">
            <i class="fas fa-external-link-alt me-1"></i> Preview Website
        </a>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <form action="{{ route('admin.company-profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="card card-primary card-outline card-tabs">
                    <div class="card-header p-0 pt-1 border-bottom-0">
                        <ul class="nav nav-tabs" id="profileTabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active fw-bold" id="landing-tab" data-toggle="pill" href="#tab-landing" role="tab" aria-controls="tab-landing" aria-selected="true">
                                    <i class="fas fa-home text-primary me-1"></i> 1. Home Page Settings
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link fw-bold" id="about-tab" data-toggle="pill" href="#tab-about" role="tab" aria-controls="tab-about" aria-selected="false">
                                    <i class="fas fa-info-circle text-info me-1"></i> 2. About Us Page Content
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link fw-bold" id="contact-tab" data-toggle="pill" href="#tab-contact" role="tab" aria-controls="tab-contact" aria-selected="false">
                                    <i class="fas fa-envelope text-warning me-1"></i> 3. Contact & Company Info
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link fw-bold" id="seo-tab" data-toggle="pill" href="#tab-seo" role="tab" aria-controls="tab-seo" aria-selected="false">
                                    <i class="fas fa-search text-success me-1"></i> 4. SEO & General Settings
                                </a>
                            </li>
                        </ul>
                    </div>
                    
                    <div class="card-body">
                        <div class="tab-content" id="profileTabsContent">
                            
                            <!-- TAB 1: HOMEPAGE / LANDING CONTENT -->
                            <div class="tab-pane fade show active" id="tab-landing" role="tabpanel" aria-labelledby="landing-tab">
                                <h5 class="text-primary border-bottom pb-2 mb-3">1. Hero Banner Utama</h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Hero Title</label>
                                            <input type="text" name="hero_title" class="form-control" value="{{ old('hero_title', $profile->hero_title ?? 'Precision Instruments & Industrial Automation') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Hero Subtitle</label>
                                            <textarea name="hero_subtitle" class="form-control" rows="2">{{ old('hero_subtitle', $profile->hero_subtitle ?? 'Elevate your operational efficiency with PT Wiratama Mitra Abadi...') }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Hero Background Image</label>
                                            @if($profile->hero_image)
                                                <div class="mb-2">
                                                    <img src="{{ asset('storage/'.$profile->hero_image) }}" style="height: 100px; border-radius: 8px;">
                                                </div>
                                            @endif
                                            <input type="file" name="hero_image" class="form-control-file" accept="image/*">
                                        </div>
                                    </div>
                                </div>

                                <h5 class="text-primary border-bottom pb-2 mb-3 mt-4">2. Counter / Statistic Bar (Beranda)</h5>
                                <div class="row">
                                    @for($i = 0; $i < 4; $i++)
                                    <div class="col-md-3">
                                        <div class="card bg-light">
                                            <div class="card-body p-2">
                                                <div class="form-group mb-2">
                                                    <label class="small">Stat {{ $i+1 }} Number</label>
                                                    <input type="text" name="stats_number[]" class="form-control form-control-sm" value="{{ old('stats_number.'.$i, $profile->stats[$i]['number'] ?? '') }}" placeholder="Contoh: 500+">
                                                </div>
                                                <div class="form-group mb-0">
                                                    <label class="small">Stat {{ $i+1 }} Label</label>
                                                    <input type="text" name="stats_label[]" class="form-control form-control-sm" value="{{ old('stats_label.'.$i, $profile->stats[$i]['label'] ?? '') }}" placeholder="Contoh: Pelanggan Setia">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endfor
                                </div>

                                <h5 class="text-primary border-bottom pb-2 mb-3 mt-4">3. Ringkasan About us di Homepage</h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>About Title (Homepage)</label>
                                            <input type="text" name="about_title" class="form-control" value="{{ old('about_title', $profile->about_title ?? 'You Deserve Our Best Services') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>About Summary (Short text for Homepage)</label>
                                            <textarea name="about_summary" class="form-control" rows="3">{{ old('about_summary', $profile->about_summary ?? 'Established with a vision to be the leading provider...') }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <h5 class="text-primary border-bottom pb-2 mb-3 mt-4">4. Key Features / Poin Keunggulan</h5>
                                <div class="row">
                                    @for($i = 0; $i < 2; $i++)
                                    <div class="col-md-6">
                                        <div class="card border-primary">
                                            <div class="card-body p-2">
                                                <div class="form-group mb-2">
                                                    <label class="small">Keunggulan {{ $i+1 }} Judul</label>
                                                    <input type="text" name="features_title[]" class="form-control form-control-sm" value="{{ old('features_title.'.$i, $profile->features[$i]['title'] ?? '') }}" placeholder="Contoh: Kualitas Terjamin">
                                                </div>
                                                <div class="form-group mb-0">
                                                    <label class="small">Keunggulan {{ $i+1 }} Deskripsi</label>
                                                    <input type="text" name="features_desc[]" class="form-control form-control-sm" value="{{ old('features_desc.'.$i, $profile->features[$i]['desc'] ?? '') }}" placeholder="Deskripsi singkat...">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endfor
                                </div>

                                <h5 class="text-primary border-bottom pb-2 mb-3 mt-4">5. Who We Are Image (Homepage)</h5>
                                <div class="form-group">
                                    <label class="fw-bold">Homepage About Image</label>
                                    @if($profile->about_image)
                                        <div class="mb-2">
                                            <img src="{{ asset('storage/'.$profile->about_image) }}" alt="Homepage About" style="height: 110px; width: 180px; object-fit: cover; border-radius: 8px;">
                                        </div>
                                    @endif
                                    <input type="file" name="about_image" class="form-control-file" accept="image/*">
                                    <small class="text-muted">Gambar utama pada section Who We Are di homepage.</small>
                                </div>

                                <h5 class="text-primary border-bottom pb-2 mb-3 mt-4">6. Contact Page Header Details</h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Contact Page Title</label>
                                            <input type="text" name="contact_title" class="form-control" value="{{ old('contact_title', $profile->contact_title ?? 'Contact Us') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Contact Page Subtitle</label>
                                            <textarea name="contact_subtitle" class="form-control" rows="2">{{ old('contact_subtitle', $profile->contact_subtitle ?? 'We are ready to help you. Feel free to contact our team...') }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- TAB 2: ABOUT US PAGE CONTENT -->
                            <div class="tab-pane fade" id="tab-about" role="tabpanel" aria-labelledby="about-tab">

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="fw-bold">About Page Header Title</label>
                                            <input type="text" name="about_page_title" class="form-control" value="{{ old('about_page_title', $profile->about_page_title ?? 'Empowering Industry Through Precision') }}">
                                            <small class="text-muted">Judul utama di bagian paling atas halaman About Us.</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="fw-bold">About Subtitle / Showcase Heading</label>
                                            <input type="text" name="about_page_subtitle" class="form-control" value="{{ old('about_page_subtitle', $profile->about_page_subtitle ?? 'Dedicated to Your Success') }}">
                                            <small class="text-muted">Sub-judul untuk seksi profil perusahaan.</small>
                                        </div>
                                    </div>
                                </div>

                                <hr>

                                <div class="form-group">
                                    <label class="fw-bold text-primary"><i class="fas fa-file-alt me-1"></i> Full About Us Content (Profil Lengkap Perusahaan)</label>
                                    <textarea name="about_us" class="form-control summernote">{{ old('about_us', $profile->about_us) }}</textarea>
                                    <small class="text-muted">Tulis narasi lengkap tentang profil perusahaan, keunggulan, serta cakupan bisnis Anda.</small>
                                </div>
                                
                                <div class="row mt-4">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="fw-bold text-success"><i class="fas fa-eye me-1"></i> Company Vision (Visi Perusahaan)</label>
                                            <textarea name="vision" class="form-control summernote">{{ old('vision', $profile->vision) }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="fw-bold text-danger"><i class="fas fa-bullseye me-1"></i> Company Mission (Misi Perusahaan)</label>
                                            <textarea name="mission" class="form-control summernote">{{ old('mission', $profile->mission) }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mt-3">
                                    <label class="fw-bold text-info"><i class="fas fa-star me-1"></i> Company Values (Nilai-Nilai Utama / Core Values)</label>
                                    <textarea name="company_values" class="form-control summernote">{{ old('company_values', $profile->company_values) }}</textarea>
                                    <small class="text-muted">Tuliskan nilai-nilai integritas, kualitas, dan pelayanan perusahaan.</small>
                                </div>

                                <div class="form-group mt-3">
                                    <label class="fw-bold text-purple"><i class="fas fa-history me-1"></i> Company History & Milestones (Sejarah / Rekam Jejak)</label>
                                    <textarea name="company_history" class="form-control summernote">{{ old('company_history', $profile->company_history) }}</textarea>
                                    <small class="text-muted">Tuliskan sejarah singkat atau milestone perkembangan perusahaan.</small>
                                </div>

                                <div class="form-group mt-4">
                                    <label class="fw-bold"><i class="fas fa-images me-1"></i> Showcase Images / Gallery Fotos About Us</label>
                                    @if($profile->about_images && count($profile->about_images) > 0)
                                        <div class="mb-3 d-flex flex-wrap gap-2">
                                            @foreach($profile->about_images as $img)
                                            <div class="position-relative border p-1 rounded bg-light" style="display:inline-block; margin-right: 10px; margin-bottom: 10px;">
                                                <img src="{{ asset('storage/'.$img) }}" style="height: 90px; border-radius: 6px; object-fit: cover;">
                                                <label class="d-block small mt-1 text-danger mb-0">
                                                    <input type="checkbox" name="remove_about_images[]" value="{{ $img }}"> Hapus Foto
                                                </label>
                                            </div>
                                            @endforeach
                                        </div>
                                    @elseif($profile->about_image)
                                        <div class="mb-2">
                                            <img src="{{ asset('storage/'.$profile->about_image) }}" alt="About showcase" style="height: 100px; border-radius: 8px; object-fit: cover;">
                                        </div>
                                    @endif
                                    <input type="file" name="about_images[]" class="form-control-file" accept="image/*" multiple>
                                    <small class="text-muted">Unggah beberapa foto dokumentasi/fasilitas untuk ditampilkan pada showcase di halaman About Us.</small>
                                </div>
                            </div>

                            <!-- TAB 3: COMPANY INFO & SOCIAL MEDIA -->
                            <div class="tab-pane fade" id="tab-contact" role="tabpanel" aria-labelledby="contact-tab">
                                <h5 class="text-primary border-bottom pb-2 mb-3">Informasi Kontak Perusahaan</h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Nama Perusahaan</label>
                                            <input type="text" name="name" class="form-control" value="{{ old('name', $profile->name) }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Alamat Email</label>
                                            <input type="email" name="email" class="form-control" value="{{ old('email', $profile->email) }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>No. Telepon / Kantor</label>
                                            <input type="text" name="phone" class="form-control" value="{{ old('phone', $profile->phone) }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>No. WhatsApp</label>
                                            <input type="text" name="whatsapp" class="form-control" value="{{ old('whatsapp', $profile->whatsapp) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Alamat Lengkap Kantor</label>
                                            <textarea name="address" class="form-control" rows="2" required>{{ old('address', $profile->address) }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <h5 class="text-primary border-bottom pb-2 mb-3 mt-4">Media Sosial & Lokasi</h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><i class="fab fa-youtube text-danger me-1"></i> YouTube URL</label>
                                            <input type="url" name="youtube" class="form-control" value="{{ old('youtube', $profile->youtube) }}" placeholder="https://youtube.com/...">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><i class="fab fa-linkedin text-primary me-1"></i> LinkedIn URL</label>
                                            <input type="url" name="linkedin" class="form-control" value="{{ old('linkedin', $profile->linkedin) }}" placeholder="https://linkedin.com/...">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><i class="fab fa-facebook text-primary me-1"></i> Facebook URL</label>
                                            <input type="url" name="facebook" class="form-control" value="{{ old('facebook', $profile->facebook) }}" placeholder="https://facebook.com/...">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><i class="fab fa-instagram text-danger me-1"></i> Instagram URL</label>
                                            <input type="url" name="instagram" class="form-control" value="{{ old('instagram', $profile->instagram) }}" placeholder="https://instagram.com/...">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label><i class="fas fa-map-marker-alt text-danger me-1"></i> Google Maps Embed (iframe HTML)</label>
                                            <textarea name="maps_embed" class="form-control" rows="3" placeholder='<iframe src="..."></iframe>'>{{ old('maps_embed', $profile->maps_embed) }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- TAB 4: SEO & TRACKING -->
                            <div class="tab-pane fade" id="tab-seo" role="tabpanel" aria-labelledby="seo-tab">
                                <div class="form-group">
                                    <label>Meta Title</label>
                                    <input type="text" name="meta_title" class="form-control" value="{{ old('meta_title', $profile->meta_title) }}" placeholder="Contoh: PT Wiratama Mitra Abadi - Industrial Instrumentation">
                                </div>
                                <div class="form-group">
                                    <label>Meta Description</label>
                                    <textarea name="meta_description" class="form-control" rows="2" placeholder="Deskripsi ringkas website untuk mesin pencari Google...">{{ old('meta_description', $profile->meta_description) }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label>Meta Keywords</label>
                                    <input type="text" name="meta_keywords" class="form-control" value="{{ old('meta_keywords', $profile->meta_keywords) }}" placeholder="flow meter, level meter, wiratama, industri">
                                </div>
                                <div class="form-group">
                                    <label>Google Analytics Code (Script Tracking)</label>
                                    <textarea name="google_analytics" class="form-control" rows="3" placeholder="<script>...</script>">{{ old('google_analytics', $profile->google_analytics) }}</textarea>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="card-footer bg-light text-right">
                        <button type="submit" class="btn btn-primary btn-lg shadow-sm px-4">
                            <i class="fas fa-save mr-2"></i> Simpan Perubahan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop

@section('css')
    <!-- Summernote CSS -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
    <style>
        .note-editor .dropdown-toggle::after { all: unset; }
        .note-editor .note-dropdown-menu { box-sizing: content-box; }
        .note-editor .note-modal-footer { box-sizing: content-box; }
        .nav-tabs .nav-link.active { border-top: 3px solid #007bff !important; }
    </style>
@stop

@section('js')
    <!-- Summernote JS -->
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.summernote').summernote({
                height: 220,
                placeholder: 'Ketik konten di sini...',
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });
        });
    </script>
@stop
