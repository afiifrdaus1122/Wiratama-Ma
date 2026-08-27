@extends('layouts.app')

@section('content')
<div class="position-relative py-5" style="background: url('https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?q=80&w=2070&auto=format&fit=crop') center/cover no-repeat; min-height: 400px; display: flex; align-items: center;">
    <!-- Dark gradient overlay -->
    <div class="position-absolute top-0 inset-s-0 w-100 h-100" style="background: linear-gradient(135deg, rgba(2, 12, 39, 0.92) 0%, rgba(13, 71, 161, 0.75) 100%);"></div>
    <!-- High-tech dot grid pattern overlay -->
    <div class="position-absolute top-0 inset-s-0 w-100 h-100 opacity-25" style="background-image: radial-gradient(rgba(255, 255, 255, 0.25) 1px, transparent 1px); background-size: 32px 32px;"></div>
    
    <div class="container position-relative text-center text-white" style="z-index: 2;">
        <h1 class="display-3 fw-bolder mb-4 text-white" style="letter-spacing: -1.5px; text-shadow: 0 4px 12px rgba(0,0,0,0.3);">Documentation <span class="text-info">&</span> Gallery</h1>
        <p class="lead mb-0 mx-auto text-light opacity-75" style="max-width: 650px; font-weight: 300; font-size: 1.25rem;">
            Explore our latest field activities, high-tech installations, and premium industrial solutions delivered directly to our clients.
        </p>
    </div>
</div>

<div class="container py-5">
    <!-- Category Filter (Dropdown UI) -->
    <div class="d-flex justify-content-start mb-4">
        <div style="width: 280px;">
            <div class="input-group shadow-sm" style="border-radius: 50px; overflow: hidden; background: white; border: 1px solid #f0f0f0;">
                <span class="input-group-text bg-white border-0 ps-3 py-2 text-muted">
                    <i class="fas fa-filter" style="font-size: 0.9rem;"></i>
                </span>
                <select class="form-select border-0 py-2 shadow-none text-secondary fw-semibold" style="cursor: pointer; appearance: none; font-size: 0.9rem;" onchange="if(this.value) window.location.href=this.value">
                    <option value="{{ route('gallery.index') }}" {{ !request('category') ? 'selected' : '' }}>All Projects</option>
                    @foreach($galleryCategories as $cat)
                        <option value="{{ route('gallery.index', ['category' => $cat]) }}" {{ request('category') == $cat ? 'selected' : '' }}>
                            {{ $cat }}
                        </option>
                    @endforeach
                </select>
                <span class="input-group-text bg-white border-0 pe-3 py-2 text-primary" style="pointer-events: none;">
                    <i class="fas fa-chevron-down" style="font-size: 0.8rem;"></i>
                </span>
            </div>
        </div>
    </div>

    <div class="row g-3">
        @forelse($galleries as $gallery)
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="card h-100 border-0 shadow-sm gallery-card-hover bg-white" style="border-radius: 12px; cursor: pointer; transition: all 0.3s ease; border: 1px solid #f1f5f9 !important;" data-bs-toggle="modal" data-bs-target="#galleryModal{{ $gallery->id }}">
                    <div class="position-relative overflow-hidden" style="height: 180px; border-radius: 12px 12px 0 0;">
                        <img src="{{ asset('storage/'.$gallery->image) }}" class="w-100 h-100 gallery-card-img" style="object-fit: cover; transition: transform 0.4s ease;" alt="{{ $gallery->title }}">
                        @if($gallery->gallery_category)
                            <div class="position-absolute top-0 inset-s-0 m-2">
                                <span class="badge bg-dark text-white bg-opacity-75 px-2 py-1 shadow-sm" style="font-size: 0.65rem; border-radius: 6px; letter-spacing: 0.5px;">{{ strtoupper($gallery->gallery_category) }}</span>
                            </div>
                        @endif
                    </div>
                    <div class="card-body p-3 text-start d-flex flex-column">
                        <h6 class="fw-bold text-dark mb-2" title="{{ $gallery->title }}" style="font-size: 1rem; line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">{{ $gallery->title }}</h6>
                        @if($gallery->description)
                            <p class="text-secondary small mb-0" style="font-size: 0.85rem; line-height: 1.5; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">{{ $gallery->description }}</p>
                        @endif
                    </div>
                </div>

                <!-- Modal for {{ $gallery->id }} -->
                <div class="modal fade" id="galleryModal{{ $gallery->id }}" tabindex="-1" aria-labelledby="galleryModalLabel{{ $gallery->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content border-0 shadow-lg" style="border-radius: 16px; overflow: hidden;">
                            <div class="position-absolute top-0 inset-e-0 p-3" style="z-index: 1055;">
                                <button type="button" class="btn-close bg-white shadow-sm p-2" data-bs-dismiss="modal" aria-label="Close" style="border-radius: 50%;"></button>
                            </div>
                            
                            <div class="modal-body p-0">
                                <div class="bg-light d-flex justify-content-center align-items-center" style="height: 400px; width: 100%;">
                                    @if($gallery->images && count($gallery->images) > 1)
                                        <div id="galleryCarousel{{ $gallery->id }}" class="carousel slide w-100 h-100" data-bs-ride="carousel">
                                            <div class="carousel-inner h-100">
                                                @foreach($gallery->images as $idx => $img)
                                                    <div class="carousel-item h-100 {{ $idx == 0 ? 'active' : '' }}">
                                                        <img src="{{ asset('storage/'.$img) }}" class="d-block w-100 h-100" style="object-fit: contain; padding: 20px;" alt="{{ $gallery->title }}">
                                                    </div>
                                                @endforeach
                                            </div>
                                            <button class="carousel-control-prev" type="button" data-bs-target="#galleryCarousel{{ $gallery->id }}" data-bs-slide="prev">
                                                <span class="carousel-control-prev-icon" aria-hidden="true" style="background-color: rgba(0,0,0,0.3); border-radius: 50%; padding: 15px;"></span>
                                                <span class="visually-hidden">Previous</span>
                                            </button>
                                            <button class="carousel-control-next" type="button" data-bs-target="#galleryCarousel{{ $gallery->id }}" data-bs-slide="next">
                                                <span class="carousel-control-next-icon" aria-hidden="true" style="background-color: rgba(0,0,0,0.3); border-radius: 50%; padding: 15px;"></span>
                                                <span class="visually-hidden">Next</span>
                                            </button>
                                        </div>
                                    @else
                                        <img src="{{ asset('storage/'.$gallery->image) }}" class="d-block w-100 h-100" style="object-fit: contain; padding: 20px;" alt="{{ $gallery->title }}">
                                    @endif
                                </div>
                                
                                <div class="p-4 p-md-5 bg-white text-start">
                                    <h3 class="fw-bold text-dark mb-3" style="letter-spacing: -0.5px;">{{ $gallery->title }}</h3>
                                    @if($gallery->description)
                                        <div class="text-secondary" style="white-space: pre-wrap; font-size: 1.05rem; line-height: 1.8;">{{ $gallery->description }}</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <div class="text-muted opacity-50 mb-3"><i class="bi bi-images" style="font-size: 4rem;"></i></div>
                <h4 class="fw-bold text-muted">No Gallery Photos Yet</h4>
                <p class="text-muted">Documentation of our projects will be uploaded soon.</p>
            </div>
        @endforelse
    </div>

    <div class="d-flex justify-content-center mt-5">
        {{ $galleries->links() }}
    </div>
</div>
@endsection
