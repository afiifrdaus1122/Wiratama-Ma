@extends('layouts.app')

@section('meta_title', ($company->about_page_title ?? 'About Us') . ' - PT Wiratama Mitra Abadi')
@section('meta_description', Str::limit(strip_tags($company->about_us ?? 'Learn more about PT Wiratama Mitra Abadi, a leading provider of industrial automation and measurement instruments in Indonesia.'), 160))

@section('content')
<style>
    :root {
        --about-primary: #0f172a;
        --about-accent: #0284c7;
        --about-light: #f8fafc;
    }
    .about-hero {
        background: linear-gradient(135deg, rgba(15, 23, 42, 0.95), rgba(2, 132, 199, 0.9)), url('{{ isset($company->hero_image) && $company->hero_image ? asset('storage/'.$company->hero_image) : 'https://images.unsplash.com/photo-1497366216548-37526070297c?q=80&w=2069&auto=format&fit=crop' }}') no-repeat center center;
        background-size: cover;
        background-attachment: fixed;
        padding: 110px 0 50px;
        color: white;
        position: relative;
    }
    .about-title {
        font-size: 2.25rem;
        font-weight: 800;
        letter-spacing: -1px;
        line-height: 1.2;
    }
    .about-subtitle {
        font-size: 1.2rem;
        font-weight: 300;
        opacity: 0.9;
        line-height: 1.6;
        max-width: 800px;
    }
    .glass-panel {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.6);
        border-radius: 24px;
        padding: 40px;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.08);
    }
    .value-card {
        background: white;
        border-radius: 20px;
        padding: 30px;
        height: 100%;
        transition: all 0.4s ease;
        border: 1px solid rgba(0,0,0,0.03);
    }
    .value-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.08);
    }
    .value-icon {
        width: 60px;
        height: 60px;
        background: rgba(2, 132, 199, 0.1);
        color: var(--about-accent);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        margin-bottom: 20px;
    }
    .gradient-text {
        background: linear-gradient(90deg, #0284c7, #38bdf8);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    /* WYSIWYG Editor Output Styling */
    .wysiwyg-content {
        color: #334155;
        line-height: 1.8;
        font-size: 1.05rem;
    }
    .wysiwyg-content p {
        margin-bottom: 1.25rem;
    }
    .wysiwyg-content h1, .wysiwyg-content h2, .wysiwyg-content h3, .wysiwyg-content h4 {
        color: #0f172a;
        font-weight: 700;
        margin-top: 1.5rem;
        margin-bottom: 0.75rem;
    }
    .wysiwyg-content ul, .wysiwyg-content ol {
        margin-bottom: 1.25rem;
        padding-left: 1.5rem;
    }
    .wysiwyg-content img {
        max-width: 100%;
        height: auto;
        border-radius: 16px;
        margin: 20px 0;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
    }
    .wysiwyg-content blockquote {
        border-left: 4px solid #0284c7;
        padding-left: 1.25rem;
        margin: 1.5rem 0;
        color: #64748b;
        font-style: italic;
    }
    @media (max-width: 768px) {
        .about-title { font-size: 1.85rem !important; }
        .about-hero { padding: 90px 0 40px !important; }
        .glass-panel { padding: 20px 15px !important; }
        .showcase-img-container { height: 240px !important; }
        .display-6 { font-size: 1.65rem !important; }
        .about-company-card { padding: 20px 16px !important; }
    }
</style>

<!-- Hero Section -->
<section class="about-hero text-center">
    <div class="container" data-aos="fade-up" data-aos-duration="1000">
        <span class="badge bg-white text-dark rounded-pill px-3 py-2 mb-4 fw-bold shadow-sm" style="letter-spacing: 1px;">COMPANY PROFILE</span>
        <h1 class="about-title mb-4">{!! $company->about_page_title ?? 'Empowering Industry <br>Through <span class="text-info">Precision</span>' !!}</h1>
        <p class="about-subtitle mx-auto">{{ $company->about_summary ?? 'PT Wiratama Mitra Abadi is a premier provider of industrial automation, instrumentation, and control solutions. We are dedicated to enhancing operational efficiency and precision across various industrial sectors in Indonesia.' }}</p>
    </div>
</section>

<!-- Vision & Mission Section -->
<section class="py-5 bg-light" style="margin-top: -50px; position: relative; z-index: 10;">
    <div class="container">
        <div class="glass-panel" data-aos="fade-up">
            <div class="row g-5">
                <div class="col-md-6 border-end-md border-light">
                    <div class="pe-md-4">
                        <div class="d-flex align-items-center mb-3">
                            <i class="bi bi-eye-fill text-primary fs-2 me-3"></i>
                            <h3 class="fw-bold mb-0">Our Vision</h3>
                        </div>
                        <div class="wysiwyg-content text-muted fs-5">
                            @if(!empty(trim(strip_tags($company->vision ?? ''))))
                                {!! $company->vision !!}
                            @else
                                <p>To be the most trusted and reliable partner in industrial automation and instrumentation, delivering innovative solutions that drive efficiency and growth.</p>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="ps-md-4">
                        <div class="d-flex align-items-center mb-3">
                            <i class="bi bi-bullseye text-danger fs-2 me-3"></i>
                            <h3 class="fw-bold mb-0">Our Mission</h3>
                        </div>
                        <div class="wysiwyg-content text-muted fs-5">
                            @if(!empty(trim(strip_tags($company->mission ?? ''))))
                                {!! $company->mission !!}
                            @else
                                <p>Providing top-tier products, unparalleled technical expertise, and exceptional customer service to solve complex industrial challenges and optimize plant performance.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Full About Us Rich Text Section -->
@php
    $cleanAboutUs = trim(strip_tags($company->about_us ?? '', '<img><iframe><svg>'));
@endphp
@if(!empty($cleanAboutUs) && strtolower($cleanAboutUs) !== 'haloo' && $company->about_us !== 'Default about us...')
<section class="py-5 bg-light">
    <div class="container py-4" data-aos="fade-up">
        <div class="row justify-content-center">
            <div class="col-lg-11">
                <div class="about-company-card p-4 p-md-5 rounded-4 shadow-sm bg-white border">
                    <!-- Header -->
                    <div class="d-flex flex-column flex-sm-row align-items-sm-center justify-content-between mb-4 pb-4 border-bottom" style="gap: 1.25rem;">
                        <div class="d-flex align-items-center">
                            <div class="company-logo-wrapper bg-white shadow-sm p-2 rounded-4 border d-flex align-items-center justify-content-center me-3" style="width: 72px; height: 72px; min-width: 72px;">
                                <img src="{{ asset('images/logo.png') }}" alt="PT Wiratama Mitra Abadi Logo" class="img-fluid" style="max-height: 52px; object-fit: contain;">
                            </div>
                            <div>
                                <span class="badge bg-dark text-white fw-semibold px-3 py-1 rounded-pill mb-1" style="font-size: 0.72rem; letter-spacing: 0.5px;">COMPANY PROFILE</span>
                                <h2 class="fw-bold mb-0 text-dark" style="font-size: 1.85rem; letter-spacing: -0.5px;">About PT Wiratama Mitra Abadi</h2>
                            </div>
                        </div>
                        <div class="d-none d-md-flex align-items-center text-muted small">
                            <i class="bi bi-patch-check-fill text-dark me-2 fs-5"></i>
                            <span class="fw-semibold">Official Company Profile</span>
                        </div>
                    </div>

                    <!-- Body Content -->
                    <div class="wysiwyg-content" style="font-size: 1.08rem; line-height: 1.85; color: #334155;">
                        {!! $company->about_us !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<style>
    .about-company-card {
        transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        border: 1px solid rgba(226, 232, 240, 0.9) !important;
    }
    .about-company-card:hover {
        box-shadow: 0 20px 40px -10px rgba(15, 23, 42, 0.08) !important;
        transform: translateY(-2px);
    }
    .company-logo-wrapper {
        transition: transform 0.3s ease;
    }
    .about-company-card:hover .company-logo-wrapper {
        transform: scale(1.03);
    }
</style>
@endif

<!-- Core Values Section -->
@php
    $cleanValues = trim(strip_tags($company->company_values ?? '', '<img><iframe><svg>'));
@endphp
@if(!empty($cleanValues))
<section class="py-5 bg-light">
    <div class="container py-4" data-aos="fade-up">
        <div class="text-center mb-5">
            <span class="badge bg-primary text-white rounded-pill px-3 py-2 mb-3 fw-bold" style="letter-spacing: 1px;">CORE VALUES</span>
            <h2 class="fw-bold display-6 mb-2">Our Core Values</h2>
            <p class="text-muted fs-5">The core principles guiding our service and commitment</p>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-11">
                <div class="p-4 p-md-5 bg-white rounded-4 shadow-sm border">
                    <div class="wysiwyg-content">
                        {!! $company->company_values !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif

<!-- Why Choose Us Grid -->
<section class="py-5 my-3">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="fw-bold display-5 mb-3">Why Choose Us?</h2>
            <p class="text-muted fs-5">The pillars of our commitment to excellence</p>
        </div>
        <div class="row g-4">
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="100">
                <div class="value-card">
                    <div class="value-icon"><i class="bi bi-award-fill"></i></div>
                    <h5 class="fw-bold mb-3">Quality Assurance</h5>
                    <p class="text-muted small mb-0">We supply only premium, internationally certified products from globally recognized brands.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="200">
                <div class="value-card">
                    <div class="value-icon"><i class="bi bi-gear-fill"></i></div>
                    <h5 class="fw-bold mb-3">Technical Expertise</h5>
                    <p class="text-muted small mb-0">Our team consists of highly skilled engineers ready to provide tailored technical solutions.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="300">
                <div class="value-card">
                    <div class="value-icon"><i class="bi bi-headset"></i></div>
                    <h5 class="fw-bold mb-3">Excellent Support</h5>
                    <p class="text-muted small mb-0">From pre-sales consultation to after-sales service, we are committed to your success.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="400">
                <div class="value-card">
                    <div class="value-icon"><i class="bi bi-lightning-charge-fill"></i></div>
                    <h5 class="fw-bold mb-3">Fast Delivery</h5>
                    <p class="text-muted small mb-0">Optimized logistics network ensuring timely delivery of critical components to minimize downtime.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Company History & Milestones Section -->
@if(!empty($company->company_history))
<section class="py-5 bg-white">
    <div class="container py-4" data-aos="fade-up">
        <div class="text-center mb-5">
            <span class="badge bg-secondary text-white rounded-pill px-3 py-2 mb-3 fw-bold" style="letter-spacing: 1px;">OUR JOURNEY</span>
            <h2 class="fw-bold display-6 mb-2">History & Milestones</h2>
            <p class="text-muted fs-5">Perjalanan dan rekam jejak pertumbuhan perusahaan kami</p>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-11">
                <div class="p-4 p-md-5 rounded-4 shadow-sm bg-light border">
                    <div class="wysiwyg-content">
                        {!! $company->company_history !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif

<!-- Company Showcase Details Section -->
<div class="container my-4">
    <section class="py-4 px-4 bg-dark text-white rounded-4 shadow-lg overflow-hidden" style="background-color: #0f172a !important;">
        <div class="row align-items-center g-4">
            <div class="col-lg-6" data-aos="fade-right">
                <span class="badge px-3 py-2 rounded-pill fw-bold mb-3 text-white shadow-sm" style="background: linear-gradient(90deg, #0284c7, #0369a1); letter-spacing: 1px; font-size: 0.75rem;">EXCELLENCE & INTEGRITY</span>
                <h3 class="fw-bold mb-3 text-white" style="font-size: 1.85rem; letter-spacing: -0.5px;">{{ $company->about_page_subtitle ?? 'Dedicated to Your' }} <span class="gradient-text">Success</span></h3>
                <p class="text-light opacity-75 mb-3 small" style="line-height: 1.6; font-size: 0.95rem;">
                    With years of experience in the industry, PT Wiratama Mitra Abadi has grown into a trusted partner for hundreds of companies across Indonesia. 
                </p>
                <p class="text-light opacity-75 mb-3 small" style="line-height: 1.6; font-size: 0.95rem;">
                    Our portfolio covers Flow & Level Measurement, Display & Indicators, and Industrial Sensors. We deliver comprehensive solutions designed to optimize your industrial processes.
                </p>
                <div class="row g-2 mt-3">
                    <div class="col-sm-6">
                        <div class="d-flex align-items-center text-light small fw-semibold">
                            <i class="bi bi-check-circle-fill text-info me-2 fs-6"></i> Official Global Brands
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="d-flex align-items-center text-light small fw-semibold">
                            <i class="bi bi-check-circle-fill text-info me-2 fs-6"></i> Technical Support
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="d-flex align-items-center text-light small fw-semibold">
                            <i class="bi bi-check-circle-fill text-info me-2 fs-6"></i> Customized Engineering
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="d-flex align-items-center text-light small fw-semibold">
                            <i class="bi bi-check-circle-fill text-info me-2 fs-6"></i> Nationwide Coverage
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6" data-aos="fade-left">
                <div class="position-relative rounded-3 overflow-hidden shadow bg-black showcase-img-container" style="height: 360px;">
                    @if(isset($company->about_images) && is_array($company->about_images) && count($company->about_images) > 1)
                        <!-- Carousel for multiple showcase images -->
                        <div id="aboutShowcaseCarousel" class="carousel slide h-100" data-bs-ride="carousel">
                            <div class="carousel-indicators">
                                @foreach($company->about_images as $index => $img)
                                    <button type="button" data-bs-target="#aboutShowcaseCarousel" data-bs-slide-to="{{ $index }}" class="{{ $index === 0 ? 'active' : '' }}"></button>
                                @endforeach
                            </div>
                            <div class="carousel-inner h-100">
                                @foreach($company->about_images as $index => $img)
                                    <div class="carousel-item h-100 {{ $index === 0 ? 'active' : '' }} bg-black">
                                        <img src="{{ asset('storage/'.$img) }}" class="d-block w-100 h-100" style="object-fit: contain;" alt="PT Wiratama Showcase {{ $index+1 }}">
                                    </div>
                                @endforeach
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#aboutShowcaseCarousel" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#aboutShowcaseCarousel" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    @elseif(isset($company->about_images) && is_array($company->about_images) && count($company->about_images) === 1)
                        <img src="{{ asset('storage/'.$company->about_images[0]) }}" class="w-100 h-100" style="object-fit: contain;" alt="PT Wiratama Mitra Abadi Facility">
                    @elseif(isset($company->about_image) && $company->about_image)
                        <img src="{{ asset('storage/'.$company->about_image) }}" class="w-100 h-100" style="object-fit: contain;" alt="PT Wiratama Mitra Abadi Facility">
                    @else
                        <img src="https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?q=80&w=2070&auto=format&fit=crop" class="w-100 h-100" style="object-fit: contain;" alt="Facility">
                    @endif
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Client & Partners Section -->
@if(isset($teams) && count($teams) > 0)
<section class="py-5 bg-light my-5">
    <div class="container py-4">
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="badge bg-primary text-white rounded-pill px-3 py-2 mb-3 fw-bold shadow-sm" style="letter-spacing: 1px;">TRUSTED BY</span>
            <h2 class="fw-bold display-6 mb-2">Our Clients & Partners</h2>
            <p class="text-muted fs-6">Leading companies that trust our products and services</p>
        </div>
        <div class="d-flex flex-wrap justify-content-center gap-3">
            @foreach($teams as $index => $team)
            <div data-aos="zoom-in" data-aos-delay="{{ ($index % 10) * 30 }}" style="width: 130px;">
                <div class="card h-100 border-0 shadow-sm text-center bg-white client-logo-card" style="border-radius: 8px; transition: all 0.3s ease;">
                    <div class="p-2 d-flex align-items-center justify-content-center" style="height: 60px;">
                        @if($team->photo)
                            <img src="{{ asset('storage/'.$team->photo) }}" alt="{{ $team->name }}" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                        @else
                            <i class="bi bi-building fs-4 text-muted"></i>
                        @endif
                    </div>
                    <div class="card-body border-top p-1 d-flex align-items-center justify-content-center bg-light">
                        <span class="fw-bold text-dark text-center w-100" style="font-size: 0.55rem; line-height: 1.2;">{{ $team->name }}</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
<style>
    .client-logo-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.08) !important;
    }
</style>
@endif

<!-- Contact CTA -->
<section class="py-5 text-center my-5">
    <div class="container py-5" data-aos="zoom-in">
        <h2 class="fw-bold mb-3">Ready to Upgrade Your Operations?</h2>
        <p class="text-muted fs-5 mb-5 mx-auto" style="max-width: 700px;">Get in touch with our engineering team today to discuss your specific requirements and discover how we can help you achieve maximum efficiency.</p>
        <a href="{{ route('contact.index') }}" class="btn btn-primary btn-lg rounded-pill px-5 py-3 fw-bold shadow-lg">Contact Us Today</a>
    </div>
</section>
@endsection
