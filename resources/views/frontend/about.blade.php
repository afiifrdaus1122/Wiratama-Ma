@extends('layouts.app')

@section('meta_title', ($company->about_page_title ?? 'About Us') . ' - PT Wiratama Mitra Abadi')
@section('meta_description', Str::limit(strip_tags($company->about_us ?? 'Learn more about PT Wiratama Mitra Abadi, a leading provider of industrial automation and measurement instruments in Indonesia.'), 160))

@section('content')
<style>
    :root {
        --about-primary: #172a38;
        --about-accent: #1455a3;
        --about-light: #f3f0eb;
        --about-border: #ded9d1;
        --about-muted: #68737a;
        --about-ink: #263640;
    }
    .about-page {
        background: var(--about-light);
        color: var(--about-ink);
    }
    .about-hero {
        background: linear-gradient(90deg, rgba(20, 37, 48, 0.91) 0%, rgba(20, 37, 48, 0.63) 52%, rgba(20, 37, 48, 0.18) 100%), url('{{ isset($company->hero_image) && $company->hero_image ? asset('storage/'.$company->hero_image) : 'https://images.unsplash.com/photo-1497366216548-37526070297c?q=80&w=2069&auto=format&fit=crop' }}') no-repeat center center;
        background-size: cover;
        padding: 154px 0 142px;
        color: white;
        position: relative;
    }
    .about-hero::after {
        content: '';
        position: absolute;
        inset: auto 0 0;
        height: 1px;
        background: rgba(255,255,255,0.22);
    }
    .about-hero .container {
        max-width: 1180px;
        text-align: left;
    }
    .about-hero .container::before {
        content: 'PT WIRATAMA MITRA ABADI';
        display: block;
        color: #8db7e8;
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 0.2em;
        margin-bottom: 1.5rem;
    }
    .about-title {
        font-family: Georgia, 'Times New Roman', serif;
        font-size: clamp(2.7rem, 5vw, 5rem);
        font-weight: 400;
        letter-spacing: 0;
        line-height: 1.05;
        max-width: 820px;
    }
    .about-subtitle {
        font-size: 1.04rem;
        font-weight: 400;
        color: rgba(255,255,255,0.82);
        line-height: 1.8;
        max-width: 600px;
        margin-left: 0 !important;
    }
    .about-hero .badge {
        background: rgba(255,255,255,0.12) !important;
        color: #ffffff !important;
        border: 1px solid rgba(255,255,255,0.3);
        box-shadow: none !important;
    }
    .glass-panel {
        background: #ffffff;
        border: 1px solid var(--about-border);
        border-radius: 0;
        padding: 48px;
        box-shadow: 0 18px 45px rgba(38, 54, 64, 0.06);
    }
    .value-card {
        background: transparent;
        border-radius: 0;
        padding: 28px 24px 26px;
        height: 100%;
        transition: transform 0.25s ease, background-color 0.25s ease;
        border: 1px solid var(--about-border);
    }
    .value-card:hover {
        transform: translateY(-4px);
        background: #ffffff;
        border-color: var(--about-accent);
        box-shadow: 0 12px 28px rgba(38,54,64,0.07);
    }
    .value-icon {
        width: 48px;
        height: 48px;
        background: #e5eef9;
        color: var(--about-accent);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
        margin-bottom: 18px;
    }
    .gradient-text {
        color: #8db7e8;
    }
    /* WYSIWYG Editor Output Styling */
    .wysiwyg-content {
        color: #52616a;
        line-height: 1.85;
        font-size: 1rem;
    }
    .wysiwyg-content p {
        margin-bottom: 1.25rem;
    }
    .wysiwyg-content h1, .wysiwyg-content h2, .wysiwyg-content h3, .wysiwyg-content h4 {
        color: var(--about-primary);
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
        border-left: 3px solid var(--about-accent);
        padding-left: 1.25rem;
        margin: 1.5rem 0;
        color: var(--about-muted);
        font-style: italic;
    }
    .about-company-card,
    .about-page-section {
        border: 1px solid var(--about-border) !important;
        border-radius: 0 !important;
        box-shadow: 0 16px 35px rgba(38, 54, 64, 0.06) !important;
    }
    .about-section-heading {
        color: var(--about-primary);
        font-family: Georgia, 'Times New Roman', serif;
        font-size: 2.15rem;
        letter-spacing: 0;
    }
    .about-section-label {
        color: var(--about-accent);
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 0.12em;
        text-transform: uppercase;
    }
    .about-hero + section {
        margin-top: 0 !important;
    }
    .about-hero + section .glass-panel {
        margin-top: -48px;
        position: relative;
        z-index: 2;
    }
    .about-hero + section .border-end-md,
    .about-hero + section .border-start-md {
        border-color: var(--about-border) !important;
    }
    .about-hero + section .bi-eye-fill,
    .about-hero + section .bi-bullseye {
        font-size: 1.45rem !important;
        color: var(--about-accent) !important;
    }
    .about-company-card {
        background: #ffffff !important;
    }
    .about-company-card .company-logo-wrapper {
        border-radius: 8px !important;
        box-shadow: none !important;
    }
    .about-company-card h2 {
        font-size: 1.55rem !important;
    }
    .value-card {
        box-shadow: none;
    }
    .value-card h5 {
        font-size: 1rem;
    }
    .value-card p {
        line-height: 1.7;
    }
    .about-page-section {
        background: var(--about-light);
    }
    @media (max-width: 768px) {
        .about-title { font-size: 2.75rem !important; }
        .about-hero { padding: 90px 0 88px !important; }
        .glass-panel { padding: 30px 22px !important; }
        .showcase-img-container { height: 240px !important; }
        .display-6 { font-size: 1.65rem !important; }
        .about-company-card { padding: 20px 16px !important; }
        .about-section-heading { font-size: 1.6rem; }
    }
</style>

<!-- Hero Section -->
<section class="about-hero">
    <div class="container" data-aos="fade-up" data-aos-duration="1000">
        <span class="badge bg-white text-dark rounded-pill px-3 py-2 mb-4 fw-bold shadow-sm" style="letter-spacing: 1px;">ABOUT WIRATAMA</span>
        <h1 class="about-title mb-4">{!! $company->about_page_title ?? 'Industrial Solutions Built Around Your Needs' !!}</h1>
        <p class="about-subtitle mx-auto">{{ $company->about_summary ?? 'PT Wiratama Mitra Abadi supplies industrial instruments and technical solutions that help customers measure, control, and improve their operations.' }}</p>
    </div>
</section>

<!-- Vision & Mission Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="glass-panel" data-aos="fade-up">
            <div class="row g-5">
                <div class="col-md-6 border-end-md border-light">
                    <div class="pe-md-4 h-100">
                        <div class="d-flex align-items-center mb-3">
                            <i class="bi bi-eye-fill text-primary fs-2 me-3"></i>
                            <h3 class="fw-bold mb-0">Our Vision</h3>
                        </div>
                        <div class="wysiwyg-content text-muted fs-5">
                            @if(!empty(trim(strip_tags($company->vision ?? ''))))
                                {!! $company->vision !!}
                            @else
                                <p>To be a trusted partner for industrial measurement, instrumentation, and technical solutions in Indonesia.</p>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="ps-md-4 h-100 border-start-md border-light">
                        <div class="d-flex align-items-center mb-3">
                            <i class="bi bi-bullseye text-danger fs-2 me-3"></i>
                            <h3 class="fw-bold mb-0">Our Mission</h3>
                        </div>
                        <div class="wysiwyg-content text-muted fs-5">
                            @if(!empty(trim(strip_tags($company->mission ?? ''))))
                                {!! $company->mission !!}
                            @else
                                <p>To provide the right products, clear technical guidance, and dependable service for every customer application.</p>
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
            <span class="about-section-label mb-3 d-inline-block">How We Work</span>
            <h2 class="fw-bold display-6 mb-2">Simple, Reliable, Technical</h2>
            <p class="text-muted fs-5">The principles behind our products and service</p>
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
            <span class="about-section-label mb-3 d-inline-block">Why Wiratama</span>
            <h2 class="fw-bold display-5 mb-3">Support for the Work That Matters</h2>
            <p class="text-muted fs-5">From product selection to after-sales support</p>
        </div>
        <div class="row g-4">
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="100">
                <div class="value-card">
                    <div class="value-icon"><i class="bi bi-award-fill"></i></div>
                    <h5 class="fw-bold mb-3">Quality Products</h5>
                        <p class="text-muted small mb-0">We source dependable instruments and components from recognized industrial brands.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="200">
                <div class="value-card">
                    <div class="value-icon"><i class="bi bi-gear-fill"></i></div>
                    <h5 class="fw-bold mb-3">Technical Guidance</h5>
                        <p class="text-muted small mb-0">We help customers determine specifications that match the application and operating conditions.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="300">
                <div class="value-card">
                    <div class="value-icon"><i class="bi bi-headset"></i></div>
                    <h5 class="fw-bold mb-3">Complete Service</h5>
                        <p class="text-muted small mb-0">Consultation, repair, setting, calibration, installation, and commissioning support.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="400">
                <div class="value-card">
                    <div class="value-icon"><i class="bi bi-lightning-charge-fill"></i></div>
                    <h5 class="fw-bold mb-3">Long-Term Partnership</h5>
                        <p class="text-muted small mb-0">A responsive team focused on practical solutions and lasting customer relationships.</p>
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
