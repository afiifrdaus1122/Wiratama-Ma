@extends('layouts.app')

@section('content')

<style>
    /* ULTRA-MODERN PREMIUM DESIGN SYSTEM */
    :root {
        --primary: #0a2540;
        --secondary: #0070f3;
        --dark: #111827;
        --light: #f9fafb;
        --accent: #38bdf8;
        --text-muted: #64748b;
    }
    
    body {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        color: #334155;
        background-color: #ffffff;
        -webkit-font-smoothing: antialiased;
    }

    .hero-section {
        background: linear-gradient(135deg, rgba(13, 71, 161, 0.95) 0%, rgba(27, 38, 59, 0.95) 100%), 
                    url('{{ isset($company->hero_image) && $company->hero_image ? asset('storage/'.$company->hero_image) : 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?q=80&w=2070&auto=format&fit=crop' }}') no-repeat center center;
        background-size: cover;
        background-attachment: fixed;
        padding: 160px 0 140px;
        color: white;
        position: relative;
        overflow: hidden;
    }

    .hero-title {
        font-weight: 800;
        font-size: 3.5rem;
        line-height: 1.2;
        margin-bottom: 1.5rem;
        letter-spacing: -1px;
    }

    .hero-subtitle {
        font-size: 1.25rem;
        font-weight: 300;
        opacity: 0.9;
        margin-bottom: 2.5rem;
        line-height: 1.6;
        max-width: 90%;
    }

    /* Carousel Customization */
    .hero-carousel {
        position: relative;
    }
    
    .hero-carousel-item {
        background-size: cover;
        background-position: center center;
        background-repeat: no-repeat;
        color: white;
        position: relative;
        overflow: hidden;
    }

    .hero-carousel-item::after {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background: var(--overlay-bg, rgba(0,0,0,0.5));
        z-index: 1;
    }

    .hero-carousel-content {
        position: relative;
        z-index: 2;
        height: 100%;
        display: flex;
        align-items: center;
    }

    .hero-title {
        font-weight: 800;
        font-size: 3.5rem;
        line-height: 1.2;
        margin-bottom: 1.5rem;
        letter-spacing: -1px;
    }

    .hero-subtitle {
        font-size: 1.25rem;
        font-weight: 300;
        opacity: 0.9;
        margin-bottom: 2.5rem;
        line-height: 1.6;
        max-width: 90%;
    }

    .btn-glass {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: white;
        font-weight: 600;
        padding: 12px 30px;
        border-radius: 50px;
        transition: all 0.3s ease;
    }

    .btn-glass:hover {
        background: rgba(255, 255, 255, 0.2);
        transform: translateY(-2px);
        color: white;
    }

    .btn-solid-primary {
        background: #00b4d8;
        color: white;
        border: none;
        font-weight: 600;
        padding: 12px 30px;
        border-radius: 50px;
        box-shadow: 0 10px 20px rgba(0, 180, 216, 0.3);
        transition: all 0.3s ease;
    }

    .btn-solid-primary:hover {
        background: #0096c7;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 15px 25px rgba(0, 180, 216, 0.4);
    }

    .highlight-btn-glow {
        box-shadow: 0 10px 25px rgba(0, 112, 243, 0.4) !important;
    }
    .highlight-btn-glow:hover {
        transform: translateY(-3px) scale(1.02);
        box-shadow: 0 15px 35px rgba(0, 180, 216, 0.6) !important;
        color: #ffffff !important;
    }

    /* Floating Stats Bar */
    .stats-bar {
        background: white;
        border-radius: 20px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.08);
        padding: 30px;
        margin-top: -60px;
        position: relative;
        z-index: 10;
    }

    .stat-number {
        font-size: 2.5rem;
        font-weight: 800;
        color: #0d47a1;
        line-height: 1;
        margin-bottom: 5px;
    }

    /* Section Titles */
    .section-header {
        margin-bottom: 4rem;
        text-align: center;
    }

    .section-subtitle {
        color: var(--secondary);
        font-weight: 700;
        font-size: 0.95rem;
        letter-spacing: 0.5px;
        margin-bottom: 15px;
        display: inline-block;
        padding: 6px 16px;
        background: rgba(0, 112, 243, 0.08);
        border-radius: 50px;
        border: 1px solid rgba(0, 112, 243, 0.15);
    }

    .section-title {
        font-weight: 800;
        color: var(--dark);
        font-size: 2.75rem;
        letter-spacing: -0.03em;
        line-height: 1.2;
    }

    /* Modern Category Cards */
    .cat-card {
        background: #ffffff;
        border-radius: 24px;
        padding: 40px 30px;
        text-align: center;
        border: 1px solid rgba(0,0,0,0.03);
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        position: relative;
        z-index: 1;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02), 0 2px 4px -1px rgba(0, 0, 0, 0.01);
    }

    .cat-card-icon {
        width: 68px;
        height: 68px;
        background: #f1f5f9;
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        font-size: 1.75rem;
        color: #0a2540;
        border: 1px solid #e2e8f0;
        transition: all 0.3s ease;
    }

    .cat-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px -10px rgba(0,0,0,0.08);
        border-color: rgba(10, 37, 64, 0.15);
    }

    .cat-card:hover .cat-card-icon {
        background: #0a2540;
        color: #ffffff;
        border-color: #0a2540;
        transform: scale(1.05);
    }

    /* Product Cards */
    .product-card {
        background: #ffffff;
        border-radius: 24px;
        overflow: hidden;
        border: 1px solid rgba(0,0,0,0.04);
        box-shadow: 0 10px 30px -10px rgba(0,0,0,0.05);
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
    }

    .product-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 25px 50px -12px rgba(0,0,0,0.12);
    }

    .product-img-wrap {
        position: relative;
        height: 250px;
        background: #f8fafc;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }

    .product-badge {
        position: absolute;
        top: 20px;
        right: 20px;
        background: rgba(255,255,255,0.95);
        backdrop-filter: blur(8px);
        color: var(--primary);
        font-size: 0.75rem;
        font-weight: 700;
        padding: 6px 16px;
        border-radius: 100px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    }

    .product-info {
        padding: 30px;
    }

    /* Background Styles */
    .bg-premium-light {
        background: linear-gradient(135deg, #f8fafc 0%, #eff6ff 100%);
    }
    
    .feature-card-small {
        background: #ffffff;
        border-radius: 16px;
        padding: 15px 20px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.03);
        border: 1px solid rgba(0,0,0,0.02);
        transition: all 0.3s ease;
    }
    
    .feature-card-small:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.06);
        border-color: rgba(0, 112, 243, 0.1);
    }
    
    .feature-icon-wrapper {
        width: 50px;
        height: 50px;
        min-width: 50px;
        background: rgba(0, 112, 243, 0.08);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .bg-gradient-light {
        background: linear-gradient(180deg, #ffffff 0%, #f1f5f9 100%);
    }

    .bg-gradient-reverse {
        background: linear-gradient(180deg, #f1f5f9 0%, #ffffff 100%);
    }

    /* Modern Footer Overrides */
    .footer-link:hover {
        color: var(--secondary);
        transform: translateX(4px);
    }

    /* Mobile Responsiveness Improvements */
    @media (max-width: 768px) {
        .hero-carousel-item {
            background-image: var(--mobile-bg, var(--desktop-bg)) !important;
            min-height: 440px !important;
        }
        .hero-title {
            font-size: 1.85rem !important;
            line-height: 1.25 !important;
            margin-bottom: 0.85rem !important;
        }
        .hero-subtitle {
            font-size: 0.92rem !important;
            line-height: 1.5 !important;
            margin: 0 auto 1.5rem !important;
            max-width: 100% !important;
        }
        .hero-carousel-content {
            text-align: center;
        }
        .hero-carousel-content .d-flex {
            justify-content: center;
        }
        .btn-solid-primary, .btn-glass {
            padding: 10px 22px !important;
            font-size: 0.88rem !important;
        }
        .stats-bar {
            margin-top: -25px !important;
            padding: 16px 10px !important;
            border-radius: 16px !important;
        }
        .stat-number {
            font-size: 1.6rem !important;
        }
        .section-title {
            font-size: 1.65rem !important;
        }
        .section-subtitle {
            font-size: 0.78rem !important;
            padding: 4px 12px !important;
        }
        .section-header {
            margin-bottom: 2rem !important;
        }
        .cat-card {
            padding: 18px 10px !important;
            border-radius: 16px !important;
        }
        .cat-card-icon {
            width: 52px !important;
            height: 52px !important;
            font-size: 1.35rem !important;
            margin-bottom: 12px !important;
            border-radius: 14px !important;
        }
        .cat-card h4 {
            font-size: 0.88rem !important;
            margin-bottom: 6px !important;
        }
        .cat-card p {
            font-size: 0.72rem !important;
            line-height: 1.35 !important;
        }
        .product-img-wrap {
            height: 135px !important;
            padding: 8px !important;
        }
        .product-img-wrap img {
            object-fit: contain !important;
            max-height: 100% !important;
        }
        .mobile-border-remove {
            border-right: none !important;
        }
        
        /* Compact Articles Grid */
        .article-title-mobile {
            font-size: 0.85rem !important;
            margin-bottom: 4px !important;
        }
        .article-card-body-mobile {
            padding: 10px !important;
        }
        
        /* Compact Gallery */
        .gallery-img-mobile {
            height: 135px !important;
        }
        .gallery-title-mobile {
            font-size: 0.8rem !important;
            padding: 8px !important;
        }
    }
</style>

<!-- 1. Hero Section (Dynamic) -->
@if(isset($heroBanners) && count($heroBanners) > 0)
<div id="dynamicHeroCarousel" class="carousel slide hero-carousel" data-bs-ride="carousel" data-bs-pause="false">
    <div class="carousel-inner">
        @foreach($heroBanners as $index => $banner)
            @php
                $bgStyle = '';
                $desktopBg = '';
                $mobileBg = '';
                if ($banner->background_type == 'image') {
                    if ($banner->desktop_image) {
                        $desktopBg = asset('storage/' . $banner->desktop_image);
                    }
                    if ($banner->mobile_image) {
                        $mobileBg = asset('storage/' . $banner->mobile_image);
                    } else {
                        $mobileBg = $desktopBg;
                    }
                    $bgStyle = "background-image: url('{$desktopBg}');";
                } elseif ($banner->background_type == 'color') {
                    $bgStyle = "background-color: {$banner->background_value};";
                }

                // hex to rgba for overlay
                list($r, $g, $b) = sscanf($banner->overlay_color, "#%02x%02x%02x");
                $overlayBg = "rgba($r, $g, $b, {$banner->overlay_opacity})";
                
                // Alignment classes
                $textAlign = 'text-' . $banner->position;
                $alignClass = '';
                if ($banner->position == 'center') $alignClass = 'mx-auto';
                if ($banner->position == 'right') $alignClass = 'ms-auto';
            @endphp
            <div class="carousel-item hero-carousel-item {{ $index == 0 ? 'active' : '' }}" 
                 style="{{ $bgStyle }} min-height: {{ $banner->height_vh }}vh; --desktop-bg: url('{{ $desktopBg }}'); --mobile-bg: url('{{ $mobileBg }}'); --overlay-bg: {{ $overlayBg }};" 
                 data-bs-interval="5000">
                <div class="container hero-carousel-content">
                    <div class="row w-100">
                        <div class="col-lg-8 {{ $textAlign }} {{ $alignClass }}">
                            @if($banner->title)
                                <h1 class="hero-title" data-aos="fade-up" data-aos-delay="100">{!! nl2br(e($banner->title)) !!}</h1>
                            @endif
                            @if($banner->subtitle || $banner->description)
                                <p class="hero-subtitle {{ $alignClass }}" data-aos="fade-up" data-aos-delay="200">{{ $banner->subtitle ?? $banner->description }}</p>
                            @endif
                            
                            <div class="d-flex flex-wrap gap-3 {{ $banner->position == 'center' ? 'justify-content-center' : ($banner->position == 'right' ? 'justify-content-end' : '') }}" data-aos="fade-up" data-aos-delay="300">
                                @if($banner->cta_text && $banner->cta_url)
                                    <a href="{{ url($banner->cta_url) }}" target="{{ $banner->cta_target }}" class="btn-solid-primary">{{ $banner->cta_text }} <i class="bi bi-arrow-right ms-2"></i></a>
                                @endif
                                @if($index == 0)
                                    <a href="{{ route('about') }}" class="btn-glass">About Our Company</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    @if(count($heroBanners) > 1)
        <button class="carousel-control-prev" type="button" data-bs-target="#dynamicHeroCarousel" data-bs-slide="prev" style="z-index: 10;">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#dynamicHeroCarousel" data-bs-slide="next" style="z-index: 10;">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    @endif
</div>
@else
<!-- Fallback to original Hero Section if no dynamic banners found -->
<section class="hero-section" style="min-height: 80vh;">
    <div class="container position-relative" style="z-index: 10; height: 100%; display: flex; align-items: center;">
        <div class="row w-100">
            <div class="col-lg-8">
                <h1 class="hero-title" data-aos="fade-up" data-aos-delay="100">{!! nl2br(e($company->hero_title ?? 'Precision Instruments & Industrial Automation')) !!}</h1>
                <p class="hero-subtitle" data-aos="fade-up" data-aos-delay="200">{{ $company->hero_subtitle ?? 'Elevate your operational efficiency with PT Wiratama Mitra Abadi. We provide world-class measurement devices, sensors, and electrical solutions backed by technical expertise.' }}</p>
                <div class="d-flex flex-wrap gap-3" data-aos="fade-up" data-aos-delay="300">
                    <a href="{{ route('products.index') }}" class="btn-solid-primary">Explore Catalog <i class="bi bi-arrow-right ms-2"></i></a>
                    <a href="{{ route('about') }}" class="btn-glass">About Our Company</a>
                </div>
            </div>
        </div>
    </div>
</section>
@endif

<!-- 2. Floating Stats -->
<div class="container" data-aos="fade-up" data-aos-delay="400">
    <div class="stats-bar">
        <div class="row text-center g-4">
            @if(isset($company->stats) && is_array($company->stats) && count($company->stats) > 0)
                @foreach($company->stats as $index => $stat)
                <div class="col-md-3 col-6 mb-3 mb-md-0 {{ $index < count($company->stats) - 1 ? 'border-md-end' : '' }} {{ $index % 2 == 0 ? 'border-end' : '' }} border-light">
                    <div class="stat-number">{{ $stat['number'] }}</div>
                    <div class="text-muted fw-bold small text-uppercase tracking-wide">{{ $stat['label'] }}</div>
                </div>
                @endforeach
            @else
                <div class="col-md-3 col-6 mb-3 mb-md-0 border-end border-light">
                    <div class="stat-number">5.6K+</div>
                    <div class="text-muted fw-bold small text-uppercase tracking-wide">Satisfied Customers</div>
                </div>
                <div class="col-md-3 col-6 mb-3 mb-md-0 border-md-end border-light mobile-border-remove">
                    <div class="stat-number">15+</div>
                    <div class="text-muted fw-bold small text-uppercase tracking-wide">Years Experience</div>
                </div>
                <div class="col-md-3 col-6 border-end border-light">
                    <div class="stat-number">76</div>
                    <div class="text-muted fw-bold small text-uppercase tracking-wide">Business Partners</div>
                </div>
                <div class="col-md-3 col-6 mobile-border-remove">
                    <div class="stat-number">17</div>
                    <div class="text-muted fw-bold small text-uppercase tracking-wide">Global Brands</div>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Trust Signals: Client Logos -->
@if(isset($clientLogos) && count($clientLogos) > 0)
<div class="container py-5" data-aos="fade-up">
    <div class="text-center mb-4">
        <span class="text-muted fw-bold text-uppercase" style="letter-spacing: 1px; font-size: 0.85rem;">Dipercaya Oleh Perusahaan Terkemuka</span>
    </div>
    <div class="row align-items-center justify-content-center opacity-75">
        @foreach($clientLogos as $logo)
            <div class="col-4 col-md-3 col-lg-2 text-center mb-4">
                <img src="{{ asset('storage/'.$logo->image) }}" alt="{{ $logo->name }}" class="img-fluid" style="max-height: 50px; filter: grayscale(100%) contrast(50%); opacity: 0.7; transition: all 0.3s ease;" onmouseover="this.style.filter='grayscale(0%)'; this.style.opacity='1';" onmouseout="this.style.filter='grayscale(100%) contrast(50%)'; this.style.opacity='0.7';">
            </div>
        @endforeach
    </div>
</div>
@endif

@if(isset($highlight) && $highlight)
<!-- EVENT HIGHLIGHT -->
<div class="container mt-5 pt-5" data-aos="fade-up">
    <div class="row align-items-center bg-white rounded-4 shadow-lg overflow-hidden border-0 mx-auto" style="max-width: 1000px; transition: transform 0.3s ease; box-shadow: 0 15px 35px rgba(0,0,0,0.08) !important;">
        <div class="col-lg-auto p-0 d-flex align-items-center justify-content-center bg-dark">
            @if($highlight->type == 'video' && $highlight->media_path)
                <!-- Video with sound enabled and 50% volume -->
                <video src="{{ asset('storage/'.$highlight->media_path) }}" autoplay loop controls style="max-height: 450px; width: auto; max-width: 100%; display: block;" onloadedmetadata="this.volume=0.5" oncanplay="this.play()"></video>
            @elseif($highlight->media_path)
                <img src="{{ asset('storage/'.$highlight->media_path) }}" alt="{{ $highlight->title }}" style="max-height: 450px; width: auto; max-width: 100%; display: block;">
            @else
                <div class="w-100 bg-primary d-flex align-items-center justify-content-center" style="min-height: 450px;">
                    <i class="bi bi-star-fill text-white fs-1 opacity-50"></i>
                </div>
            @endif
        </div>
        <div class="col-lg p-4 p-md-5 d-flex flex-column justify-content-center bg-white">
            <div>
                <span class="badge bg-danger text-white px-3 py-2 rounded-pill fw-bold mb-3 shadow-sm d-inline-flex align-items-center" style="font-size: 0.75rem; letter-spacing: 1px;">
                    <i class="bi bi-megaphone-fill me-2 fs-6"></i> HIGHLIGHT / ANNOUNCEMENT
                </span>
                <h3 class="fw-bold text-dark mb-4" style="font-size: 2.25rem; letter-spacing: -0.5px; line-height: 1.2;">{{ $highlight->title }}</h3>
                @if($highlight->content)
                    <p class="text-secondary mb-4" style="line-height: 1.8; font-size: 1.1rem; font-weight: 300;">{{ $highlight->content }}</p>
                @endif
                @if($highlight->action_link)
                    <a href="{{ $highlight->action_link }}" class="btn btn-primary rounded-pill px-3 py-2 mt-2 fw-bold shadow-sm d-inline-flex align-items-center" style="font-size: 0.9rem; transition: all 0.3s ease;">
                        {{ $highlight->action_text ?? 'Read More' }} <i class="bi bi-arrow-right ms-2"></i>
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>
@endif

<!-- 3. About Us -->
<section id="about" class="py-5 bg-premium-light">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6" data-aos="fade-right">
                <div class="position-relative">
                    @if(isset($company->about_images) && is_array($company->about_images) && count($company->about_images) > 0)
                        <div id="aboutCarousel" class="carousel slide carousel-fade overflow-hidden" data-bs-ride="carousel" style="border-radius: 24px; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.15);">
                            <div class="carousel-inner">
                                @foreach($company->about_images as $index => $img)
                                    <div class="carousel-item {{ $index == 0 ? 'active' : '' }}" data-bs-interval="3000">
                                        <img src="{{ asset('storage/'.$img) }}" class="d-block w-100 object-fit-cover" alt="About Us {{ $index + 1 }}" style="height: 480px;">
                                    </div>
                                @endforeach
                            </div>
                            @if(count($company->about_images) > 1)
                                <button class="carousel-control-prev" type="button" data-bs-target="#aboutCarousel" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#aboutCarousel" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            @endif
                        </div>
                    @else
                        <img src="{{ isset($company->about_image) && $company->about_image ? asset('storage/'.$company->about_image) : 'https://images.unsplash.com/photo-1581092160562-40aa08e78837?q=80&w=2070&auto=format&fit=crop' }}" class="img-fluid object-fit-cover w-100" alt="About Us" style="border-radius: 24px; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.15); height: 480px;">
                    @endif
                </div>
            </div>
            <div class="col-lg-6 ps-lg-5" data-aos="fade-left">
                <span class="section-subtitle mb-2">Who We Are</span>
                <h2 class="section-title mb-3" style="font-size: 2.2rem;">{{ $company->about_title ?? 'You Deserve Our Best Services' }}</h2>
                <p class="text-muted mb-3" style="line-height: 1.6;">
                    {{ $company->about_summary ?? 'Established with a vision to be the leading provider of industrial automation and instrumentation solutions. We combine advanced technology with proven services to solve complex measurement and control challenges.' }}
                </p>
                <div class="row g-2 mt-1">
                    @if(isset($company->features) && is_array($company->features) && count($company->features) > 0)
                        @foreach($company->features as $index => $feature)
                        <div class="col-12">
                            <div class="feature-card-small d-flex align-items-start gap-3">
                                <div class="feature-icon-wrapper">
                                    <i class="bi {{ $index == 0 ? 'bi-award' : ($index == 1 ? 'bi-lightning' : 'bi-shield-check') }} text-primary fs-4"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold text-dark mb-1">{{ $feature['title'] }}</h6>
                                    <p class="text-muted small mb-0">{{ $feature['desc'] }}</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="col-12">
                            <div class="feature-card-small d-flex align-items-start gap-3">
                                <div class="feature-icon-wrapper">
                                    <i class="bi bi-award text-primary fs-4"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold text-dark mb-1">Excellent Quality</h6>
                                    <p class="text-muted small mb-0">Without excellent parts, you could be stuck in your driveway or worse. We brings only genuine and excellent parts for your satisfaction.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="feature-card-small d-flex align-items-start gap-3">
                                <div class="feature-icon-wrapper">
                                    <i class="bi bi-lightning text-primary fs-4"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold text-dark mb-1">Innovative Solution</h6>
                                    <p class="text-muted small mb-0">We support and dispatch new services so that the best solutions tend to be a combination of technology and services</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="feature-card-small d-flex align-items-start gap-3">
                                <div class="feature-icon-wrapper">
                                    <i class="bi bi-shield-check text-primary fs-4"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold text-dark mb-1">Trusted Partner</h6>
                                    <p class="text-muted small mb-0">Without excellent parts, you could be stuck in your driveway or worse. we brings only genuine and excellent parts for your satisfaction.</p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                <a href="{{ route('about') }}" class="btn btn-outline-primary rounded-pill px-4 py-2 mt-3 fw-bold">Read Full Profile</a>
            </div>
        </div>
    </div>
</section>

<!-- 4. Expertise / Categories (Dynamic) -->
<section class="py-5 bg-white">
    <div class="container">
        <div class="section-header">
            <span class="section-subtitle">Core Capabilities</span>
            <h2 class="section-title">Our Industrial Expertise</h2>
        </div>
        
        <div class="row g-4">
            @forelse($categories ?? [] as $index => $cat)
            @if(Str::contains(strtolower($cat->name), 'oil skimmer')) @continue @endif
            @php
                $catNameLower = strtolower($cat->name);
                if (Str::contains($catNameLower, 'flow')) {
                    $iconClass = 'bi-speedometer2';
                } elseif (Str::contains($catNameLower, 'level')) {
                    $iconClass = 'bi-bar-chart-steps';
                } elseif (Str::contains($catNameLower, 'display') || Str::contains($catNameLower, 'indicator') || Str::contains($catNameLower, 'control')) {
                    $iconClass = 'bi-display';
                } elseif (Str::contains($catNameLower, 'electric')) {
                    $iconClass = 'bi-lightning-charge';
                } elseif (Str::contains($catNameLower, 'mechanic')) {
                    $iconClass = 'bi-gear-wide-connected';
                } elseif (Str::contains($catNameLower, 'sensor')) {
                    $iconClass = 'bi-broadcast-pin';
                } else {
                    $iconClass = 'bi-box-seam';
                }
            @endphp
            <div class="col-lg-4 col-md-6 col-6" data-aos="fade-up" data-aos-delay="{{ (($index % 6) + 1) * 100 }}">
                <a href="{{ route('products.index', ['category' => $cat->slug]) }}" class="text-decoration-none">
                    <div class="cat-card h-100">
                        <div class="cat-card-icon">
                            @if(!empty($cat->image))
                                <img src="{{ asset('storage/'.$cat->image) }}" alt="{{ $cat->name }}" style="max-height: 45px; max-width: 45px; object-fit: contain;">
                            @else
                                <i class="bi {{ $iconClass }}"></i>
                            @endif
                        </div>
                        <h4 class="fw-bold text-dark mb-3 text-uppercase" style="font-size: 1.1rem; letter-spacing: 0.5px;">{{ $cat->name }}</h4>
                        <p class="text-muted small mb-0">{{ Str::limit(strip_tags($cat->description ?? ($cat->products_count . ' Products available in this category')), 90) }}</p>
                    </div>
                </a>
            </div>
            @empty
            <div class="col-12 text-center text-muted py-4">No categories available.</div>
            @endforelse
        </div>
    </div>
</section>

<!-- Latest Products -->
<section class="py-5 bg-premium-light border-top border-bottom">
    <div class="container">
        <div class="d-flex justify-content-between align-items-end mb-5">
            <div>
                <span class="section-subtitle">New Arrivals</span>
                <h2 class="section-title mb-0">Product</h2>
            </div>
            <a href="{{ route('products.index') }}" class="btn btn-outline-dark rounded-pill fw-bold d-none d-md-block">View All Catalog</a>
        </div>
        
        <div class="row g-4">
            @forelse($latestProducts ?? [] as $index => $product)
            <div class="col-lg-2 col-md-4 col-6" data-aos="fade-up" data-aos-delay="{{ ($index + 1) * 100 }}">
                <div class="card h-100 border-0 product-card position-relative bg-white shadow-sm" style="border-radius: 16px;">
                    <div class="p-2 bg-white" style="border-radius: 16px 16px 0 0;">
                        @if($product->image)
                            <img src="{{ asset('storage/'.$product->image) }}" class="card-img-top mx-auto d-block" alt="{{ $product->name }}" style="height: 120px; object-fit: contain;">
                        @else
                            <div class="bg-light text-muted d-flex align-items-center justify-content-center" style="height: 120px;">
                                <i class="bi bi-box fs-2"></i>
                            </div>
                        @endif
                    </div>
                    @if($product->category)
                    <div class="position-absolute top-0 inset-e-0 m-2 z-index-2">
                        <span class="badge bg-primary rounded-pill px-2 py-1 shadow-sm" style="font-size: 0.6rem;">{{ $product->category->name }}</span>
                    </div>
                    @endif
                    <div class="card-body border-top p-2 d-flex flex-column bg-light" style="border-radius: 0 0 16px 16px;">
                        <h6 class="card-title fw-bold text-dark mb-1" style="font-size: 0.85rem; line-height: 1.3;">
                            <a href="{{ route('products.show', $product->slug) }}" class="text-dark text-decoration-none stretched-link hover-primary">{{ Str::limit($product->name, 35) }}</a>
                        </h6>
                        <p class="text-muted small mb-2" style="font-size: 0.75rem; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis; line-height: 1.4;">
                            {{ strip_tags($product->description) }}
                        </p>
                        <div class="mt-auto">
                            <span class="text-primary fw-bold d-block" style="font-size: 0.85rem;">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center text-muted py-4">No products available yet.</div>
            @endforelse
        </div>
        <div class="text-center mt-4 d-md-none">
            <a href="{{ route('products.index') }}" class="btn btn-outline-dark rounded-pill fw-bold w-100">View All Catalog</a>
        </div>
    </div>
</section>

<!-- 5. Featured Articles -->
<section class="py-5 bg-gradient-light">
    <div class="container">
        <div class="d-flex justify-content-between align-items-end mb-5">
            <div>
                <span class="section-subtitle">Knowledge Base</span>
                <h2 class="section-title mb-0">Artikel & News</h2>
            </div>
            <a href="{{ route('blog.index') }}" class="btn btn-outline-dark rounded-pill fw-bold d-none d-md-block">View All Articles</a>
        </div>
        
        <div class="row row-cols-2 row-cols-md-3 row-cols-lg-5 g-3">
            @forelse($latestArticles ?? [] as $article)
            <div class="col" data-aos="fade-up" data-aos-delay="{{ $loop->iteration * 100 }}">
                <div class="card product-card h-100 border-0 shadow-sm">
                    <div class="product-img-wrap bg-light d-flex align-items-center justify-content-center gallery-img-mobile" style="height: 150px;">
                        <img src="{{ $article->image ? asset('storage/'.$article->image) : 'https://images.unsplash.com/photo-1581092335397-9583eb92d232?q=80&w=2070&auto=format&fit=crop' }}" alt="{{ $article->title }}" class="w-100 h-100" style="object-fit: contain; padding: 10px;">
                        @if($article->category)
                            <div class="product-badge bg-primary text-white" style="font-size: 0.55rem; padding: 3px 8px; top: 10px; right: 10px;">{{ $article->category->name }}</div>
                        @endif
                    </div>
                    <div class="card-body p-3 article-card-body-mobile">
                        <small class="text-muted fw-bold d-block mb-1 mb-md-2" style="font-size: 0.65rem;"><i class="bi bi-calendar3 me-1"></i> <span class="d-none d-md-inline">{{ $article->created_at->format('d F, Y') }}</span><span class="d-inline d-md-none">{{ $article->created_at->format('d M') }}</span></small>
                        <h6 class="fw-bold text-dark mb-2 mb-md-3 article-title-mobile" style="font-size: 0.9rem; line-height: 1.4;">{{ Str::limit($article->title, 35) }}</h6>
                        <p class="text-muted d-none d-md-block mb-3" style="font-size: 0.75rem; line-height: 1.5;">{{ Str::limit(strip_tags($article->content), 60) }}</p>
                        <a href="{{ route('blog.show', $article->slug) }}" class="text-primary text-decoration-none fw-bold" style="font-size: 0.75rem;">Read <span class="d-none d-md-inline">Article</span> <i class="bi bi-arrow-right ms-1"></i></a>
                    </div>
                </div>
            </div>
            @empty
                <div class="col-12 text-center text-muted">No articles available yet.</div>
            @endforelse
        </div>
        <div class="text-center mt-4 d-md-none">
            <a href="{{ route('blog.index') }}" class="btn btn-outline-dark rounded-pill fw-bold w-100">View All Articles</a>
        </div>
    </div>
</section>

<!-- Gallery Section -->
<section class="py-5 bg-white">
    <div class="container">
        <div class="d-flex justify-content-between align-items-end mb-5">
            <div>
                <span class="section-subtitle">Our Projects & Documentation</span>
                <h2 class="section-title mb-0 display-6 fw-bold">Company Gallery</h2>
            </div>
            <a href="{{ route('gallery.index') }}" class="btn btn-outline-primary rounded-pill px-4 fw-bold shadow-sm d-none d-md-block">View Full Gallery <i class="bi bi-arrow-right ms-2"></i></a>
        </div>
        
        <div class="row g-3">
            @forelse($galleries ?? [] as $index => $gallery)
                <div class="col-lg-3 col-md-4 col-sm-6" data-aos="fade-up" data-aos-delay="{{ ($loop->iteration % 4) * 100 }}">
                    <div class="card h-100 border-0 shadow-sm gallery-card-hover bg-white" style="border-radius: 12px; cursor: pointer; transition: all 0.3s ease; border: 1px solid #f1f5f9 !important;" data-bs-toggle="modal" data-bs-target="#homeGalleryModal{{ $gallery->id }}">
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
                </div>

                <!-- Modal for {{ $gallery->id }} -->
                <div class="modal fade" id="homeGalleryModal{{ $gallery->id }}" tabindex="-1" aria-labelledby="homeGalleryModalLabel{{ $gallery->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content border-0 shadow-lg" style="border-radius: 16px; overflow: hidden;">
                            <div class="position-absolute top-0 inset-e-0 p-3" style="z-index: 1055;">
                                <button type="button" class="btn-close bg-white shadow-sm p-2" data-bs-dismiss="modal" aria-label="Close" style="border-radius: 50%;"></button>
                            </div>
                            
                            <div class="modal-body p-0">
                                <div class="bg-light d-flex justify-content-center align-items-center" style="height: 400px; width: 100%;">
                                    @if($gallery->images && count($gallery->images) > 1)
                                        <div id="homeGalleryCarousel{{ $gallery->id }}" class="carousel slide w-100 h-100" data-bs-ride="carousel">
                                            <div class="carousel-inner h-100">
                                                @foreach($gallery->images as $idx => $img)
                                                    <div class="carousel-item h-100 {{ $idx == 0 ? 'active' : '' }}">
                                                        <img src="{{ asset('storage/'.$img) }}" class="d-block w-100 h-100" style="object-fit: contain; padding: 20px;" alt="{{ $gallery->title }}">
                                                    </div>
                                                @endforeach
                                            </div>
                                            <button class="carousel-control-prev" type="button" data-bs-target="#homeGalleryCarousel{{ $gallery->id }}" data-bs-slide="prev">
                                                <span class="carousel-control-prev-icon" aria-hidden="true" style="background-color: rgba(0,0,0,0.3); border-radius: 50%; padding: 15px;"></span>
                                                <span class="visually-hidden">Previous</span>
                                            </button>
                                            <button class="carousel-control-next" type="button" data-bs-target="#homeGalleryCarousel{{ $gallery->id }}" data-bs-slide="next">
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
            @empty
                <div class="col-12 text-center text-muted">No gallery photos available yet.</div>
            @endforelse
        </div>
        
        <div class="text-center mt-4 d-md-none">
            <a href="{{ route('gallery.index') }}" class="btn btn-outline-primary rounded-pill px-4 fw-bold shadow-sm w-100">View Full Gallery</a>
        </div>
    </div>
</section>

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const counters = document.querySelectorAll('.stat-number');
        
        const observer = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const el = entry.target;
                    const text = el.innerText.trim();
                    
                    // Regex to extract the number and any suffix (like K, +, etc)
                    const match = text.match(/^([\d\.]+)(.*)$/);
                    
                    if (match) {
                        const target = parseFloat(match[1]);
                        const suffix = match[2] || '';
                        const isFloat = match[1].includes('.');
                        
                        // Set immediately to 0 so it's ready when fading in
                        if (isFloat) {
                            el.innerText = "0.0" + suffix;
                        } else {
                            el.innerText = "0" + suffix;
                        }
                        
                        const duration = 2500; // 2.5 seconds animation
                        const frameDuration = 1000 / 60; // 60 FPS
                        const totalFrames = Math.round(duration / frameDuration);
                        
                        // Easing function for smooth deceleration
                        const easeOutQuart = t => 1 - (--t) * t * t * t;
                        
                        let frame = 0;
                        
                        // Delay the counting to wait for AOS fade-in animation
                        setTimeout(() => {
                            const timer = setInterval(() => {
                                frame++;
                                const progress = frame / totalFrames;
                                const currentVal = target * easeOutQuart(progress);
                                
                                if (frame >= totalFrames) {
                                    clearInterval(timer);
                                    el.innerText = target + suffix; // Ensure final exact value
                                } else {
                                    if (isFloat) {
                                        el.innerText = currentVal.toFixed(1) + suffix;
                                    } else {
                                        el.innerText = Math.floor(currentVal) + suffix;
                                    }
                                }
                            }, frameDuration);
                        }, 500); // 500ms delay
                        
                        observer.unobserve(el); // Only run once
                    }
                }
            });
        }, { threshold: 0.5 }); // Trigger when 50% of element is visible
        
        counters.forEach(counter => observer.observe(counter));
    });

</script>
@endpush

@endsection
