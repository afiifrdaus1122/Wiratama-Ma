@if($menuHeroBanners->isNotEmpty())
<style>
    .menu-hero-carousel {
        overflow: hidden;
    }

    .menu-hero-carousel .carousel-item {
        position: relative;
        isolation: isolate;
        overflow: hidden;
        height: clamp(520px, 72vh, 720px);
        min-height: 0 !important;
        box-sizing: border-box;
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
    }

    .menu-hero-carousel .carousel-item::before {
        content: '';
        position: absolute;
        inset: 0;
        background: var(--menu-overlay, rgba(0, 0, 0, 0.5));
        pointer-events: none;
        z-index: 0;
    }

    .menu-hero-carousel .carousel-content {
        position: relative;
        z-index: 1;
        min-height: 100%;
        padding-top: clamp(5rem, 12vh, 8rem);
        padding-bottom: clamp(5rem, 12vh, 8rem);
    }

    @media (max-width: 768px) {
        .menu-hero-carousel .carousel-item {
            height: 440px !important;
            min-height: 440px !important;
        }

        .menu-hero-carousel .carousel-content {
            min-height: 100%;
            padding-top: 6rem;
            padding-bottom: 6rem;
        }
    }
</style>
<div id="menuHeroCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
    <div class="carousel-inner">
        @foreach($menuHeroBanners as $index => $banner)
            @php
                $background = $sharedHeroImage
                    ? "background-image: url('" . asset('storage/' . $sharedHeroImage) . "');"
                    : ($banner->background_type === 'color'
                    ? 'background-color: ' . $banner->background_value . ';'
                    : ($banner->background_type === 'gradient'
                        ? 'background: ' . $banner->background_value . ';'
                        : "background-image: url('" . asset('storage/' . $banner->desktop_image) . "');"));
                $textAlignment = $banner->position === 'right' ? 'text-end ms-auto' : ($banner->position === 'center' ? 'text-center mx-auto' : 'text-start');
            @endphp
            <div class="carousel-item {{ $index === 0 ? 'active' : '' }} menu-hero-carousel-item" style="{{ $background }} min-height: {{ $banner->height_vh }}vh; --menu-overlay: {{ $banner->overlay_color ?: '#000000' }}{{ $banner->overlay_opacity ? ' / ' . $banner->overlay_opacity : ' / 0.50' }};">
                <div class="carousel-content d-flex align-items-center" style="min-height: {{ $banner->height_vh }}vh;">
                    <div class="container text-white {{ $textAlignment }} py-5">
                        <div class="col-lg-8 {{ $banner->position === 'right' ? 'ms-auto' : ($banner->position === 'center' ? 'mx-auto' : '') }}">
                            @if($banner->title)
                                <h1 class="display-4 fw-bold">{{ $banner->title }}</h1>
                            @endif
                            @if($banner->subtitle || $banner->description)
                                <p class="lead">{{ $banner->subtitle ?? $banner->description }}</p>
                            @endif
                            @if($banner->cta_text && $banner->cta_url)
                                <a href="{{ url($banner->cta_url) }}" target="{{ $banner->cta_target }}" class="btn btn-primary rounded-pill px-4">{{ $banner->cta_text }} <i class="bi bi-arrow-right ms-2"></i></a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    @if($menuHeroBanners->count() > 1)
        <button class="carousel-control-prev" type="button" data-bs-target="#menuHeroCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#menuHeroCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    @endif
</div>
@endif
