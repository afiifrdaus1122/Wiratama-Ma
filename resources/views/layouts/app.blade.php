<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Global Company Profile for SEO -->
    @php
        $globalCompanyProfile = \App\Models\CompanyProfile::first();
        $seoTitle = $globalCompanyProfile->meta_title ?? config('app.name', 'Wiratama-MA');
        $seoDesc = $globalCompanyProfile->meta_description ?? 'PT Wiratama Mitra Abadi - Provider of industrial automation, sensors, and measurement instruments.';
        $seoKeywords = $globalCompanyProfile->meta_keywords ?? 'industrial, automation, sensor, flow meter, level meter, wiratama';
    @endphp

    <!-- Dynamic SEO Meta Tags -->
    <title>@yield('meta_title', $seoTitle)</title>
    <meta name="description" content="@yield('meta_description', $seoDesc)">
    <meta name="keywords" content="@yield('meta_keywords', $seoKeywords)">

    <!-- Analytics -->
    @if($globalCompanyProfile && $globalCompanyProfile->google_analytics)
        {!! $globalCompanyProfile->google_analytics !!}
    @endif

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- AOS Animation CSS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    
    <style>
        /* Smooth Scroll & Custom Scrollbar */
        html {
            scroll-behavior: smooth;
        }
        ::-webkit-scrollbar {
            width: 9px;
        }
        ::-webkit-scrollbar-track {
            background: #f8fafc;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
            border: 2px solid #f8fafc;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #0d47a1;
        }

        /* Smoother Page Transition Animation */
        body {
            font-family: 'Inter', sans-serif;
            color: #333;
            background-color: #fcfcfd;
            animation: fadeInPage 0.4s ease-out forwards;
        }
        @keyframes fadeInPage {
            0% { opacity: 0; transform: translateY(4px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        
        /* Image Zoom Utility */
        .img-hover-zoom {
            overflow: hidden;
            border-radius: 16px;
        }
        .img-hover-zoom img {
            transition: transform 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .img-hover-zoom:hover img {
            transform: scale(1.06);
        }

        /* Modern UI Hover Enhancements - Softer, smoother */
        .card, .glass-card, .cat-card {
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
            border: 1px solid rgba(0,0,0,0.04);
            border-radius: 20px;
        }
        .card:hover, .glass-card:hover, .cat-card:hover {
            transform: translateY(-6px) scale(1.008);
            box-shadow: 0 20px 35px rgba(10, 37, 64, 0.07) !important;
        }
        .btn {
            transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1);
            border-radius: 50px !important;
        }
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(13, 71, 161, 0.18);
        }

        /* Sticky Glass Navbar with Scroll Transition */
        .navbar {
            background: rgba(255, 255, 255, 0.92) !important;
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(0,0,0,0.05);
            transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .navbar.nav-scrolled {
            background: rgba(255, 255, 255, 0.98) !important;
            box-shadow: 0 10px 30px rgba(10, 37, 64, 0.08) !important;
            padding-top: 4px !important;
            padding-bottom: 4px !important;
        }
        .navbar-brand {
            font-weight: 700;
            color: #0d47a1 !important;
            letter-spacing: 0.5px;
        }
        .nav-link {
            font-weight: 500;
            color: #555 !important;
            transition: color 0.3s;
        }
        .nav-link:hover {
            color: #0d47a1 !important;
        }
        /* Modern Footer Styles */
        .footer {
            background: linear-gradient(135deg, #0b1528 0%, #1a2a44 100%);
            color: #a8b2c1;
            position: relative;
            border-top: 4px solid #0d47a1;
        }
        .footer::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; height: 1px;
            background: rgba(255,255,255,0.1);
        }
        .footer-heading {
            color: #ffffff;
            font-weight: 600;
            letter-spacing: 0.5px;
            margin-bottom: 1.5rem;
            position: relative;
            padding-bottom: 0.75rem;
        }
        .footer-heading::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 40px;
            height: 3px;
            background: #0d47a1;
            border-radius: 2px;
        }
        .footer-link {
            color: #a8b2c1;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-block;
        }
        .footer-link:hover {
            color: #64ffda;
            transform: translateX(5px);
        }
        .footer-social-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(255,255,255,0.05);
            color: #ffffff;
            transition: all 0.3s ease;
            text-decoration: none;
        }
        .footer-social-link:hover {
            background: #0d47a1;
            color: #ffffff;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(13, 71, 161, 0.4);
        }
        .footer-contact-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 1rem;
            transition: opacity 0.3s ease;
        }
        .footer-contact-item:hover {
            opacity: 0.8;
        }
        .footer-contact-icon {
            color: #64ffda;
            font-size: 1.2rem;
            margin-right: 1rem;
            margin-top: 0.2rem;
        }
        .hover-opacity {
            transition: opacity 0.2s ease;
        }
        .hover-opacity:hover {
            opacity: 0.7;
        }
        @media all and (min-width: 992px) {
            .navbar .nav-item .dropdown-menu { display: none; }
            .navbar .nav-item:hover .nav-link { }
            .navbar .nav-item:hover .dropdown-menu { display: block; }
            .navbar .nav-item .dropdown-menu { margin-top: 0; }
        }
    </style>
</head>
<body>
    <!-- Global Preloader -->
    <div id="global-preloader" style="position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background: #ffffff; z-index: 99999; display: flex; align-items: center; justify-content: center; transition: opacity 0.2s ease, visibility 0.2s ease;">
        <div class="text-center">
            <img src="{{ asset('images/logo.png') }}" alt="Wiratama Logo" style="height: 70px; margin-bottom: 20px; animation: pulse-logo 1.2s infinite;">
            <div class="d-flex justify-content-center">
                <div class="spinner-border text-primary" role="status" style="width: 2rem; height: 2rem; border-width: 0.25em;">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
            <div class="mt-3 text-muted fw-bold" style="font-size: 0.85rem; letter-spacing: 1px;">PT WIRATAMA MITRA ABADI</div>
        </div>
    </div>
    <style>
        @keyframes pulse-logo {
            0% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.05); opacity: 0.8; }
            100% { transform: scale(1); opacity: 1; }
        }
        body.preloader-active { overflow: hidden; }
    </style>

    <div id="app">
        <!-- Topbar -->
        @php
            $globalCompanyProfile = \App\Models\CompanyProfile::first();
            $address = $globalCompanyProfile ? $globalCompanyProfile->address : 'Jl. Satria Raya Blok IV No. 7, Bekasi';
            $email = $globalCompanyProfile ? $globalCompanyProfile->email : 'sales@wma.co.id';
            $phone = $globalCompanyProfile ? $globalCompanyProfile->phone : '(021) 8949 1561';
            $mapsUrl = 'https://maps.google.com/?q=' . urlencode($address);
        @endphp
        <div class="bg-primary text-white py-2 d-none d-lg-block">
            <div class="container d-flex justify-content-between align-items-center small">
                <div>
                    <a href="{{ $mapsUrl }}" target="_blank" class="text-white text-decoration-none hover-opacity">
                        <i class="bi bi-geo-alt-fill me-2"></i> {{ Str::limit($address, 40) }}
                    </a>
                    <span class="mx-3 text-white-50">|</span>
                    <a href="mailto:{{ $email }}" class="text-white text-decoration-none hover-opacity">
                        <i class="bi bi-envelope-fill me-2"></i> {{ $email }}
                    </a>
                </div>
                <div>
                    <a href="tel:{{ preg_replace('/[^0-9+]/', '', $phone) }}" class="text-white text-decoration-none hover-opacity">
                        <i class="bi bi-telephone-fill me-2"></i> {{ $phone }}
                    </a>
                </div>
            </div>
        </div>

        <nav class="navbar navbar-expand-lg navbar-light shadow-sm sticky-top">
            <div class="container py-2">
                <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
                    <img src="{{ asset('images/logo.png') }}" alt="Wiratama-MA Logo" style="height: 40px;" class="me-2 d-md-none">
                    <img src="{{ asset('images/logo.png') }}" alt="Wiratama-MA Logo" style="height: 50px;" class="me-2 d-none d-md-block">
                    <div class="d-flex flex-column justify-content-center" style="color: #0d47a1; margin-top: 2px; line-height: 1.1;">
                        <span class="fw-bold fs-6 fs-md-5 mb-1">Wiratama-MA</span>
                        <style>
                            @media (min-width: 768px) {
                                .brand-subtitle-mobile { display: none; }
                                .brand-subtitle-desktop { display: inline; font-size: 0.85rem; }
                            }
                            @media (max-width: 767.98px) {
                                .brand-subtitle-mobile { display: inline; font-size: 0.65rem; }
                                .brand-subtitle-desktop { display: none; }
                            }
                        </style>
                        <span class="fw-semibold text-muted brand-subtitle-desktop">PT. Wiratama Mitra Abadi <span class="fw-normal">(E-Commerce)</span></span>
                        <span class="fw-semibold text-muted brand-subtitle-mobile">PT. Wiratama Mitra Abadi</span>
                    </div>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link px-3" href="{{ url('/') }}">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link px-3" href="{{ route('about') }}">About Us</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link px-3 dropdown-toggle" href="{{ route('products.index') }}" id="navbarProductsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Products
                            </a>
                            <ul class="dropdown-menu shadow border-0 mt-0" aria-labelledby="navbarProductsDropdown">
                                <li><a class="dropdown-item fw-bold text-primary" href="{{ route('products.index') }}">All Products</a></li>
                                <li><hr class="dropdown-divider"></li>
                                @php
                                    $navCategories = \App\Models\Category::orderBy('name')->get();
                                @endphp
                                @foreach($navCategories as $cat)
                                    <li><a class="dropdown-item" href="{{ route('products.index', ['category' => $cat->slug]) }}">{{ $cat->name }}</a></li>
                                @endforeach
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link px-3 dropdown-toggle" href="{{ route('blog.index') }}" id="navbarArticlesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                News & Articles
                            </a>
                            <ul class="dropdown-menu shadow border-0 mt-0" aria-labelledby="navbarArticlesDropdown">
                                <li><a class="dropdown-item fw-bold text-primary" href="{{ route('blog.index') }}">All Articles</a></li>
                                <li><hr class="dropdown-divider"></li>
                                @php
                                    $navArticleCategories = \App\Models\ArticleCategory::orderBy('name')->get();
                                @endphp
                                @foreach($navArticleCategories as $acat)
                                    <li><a class="dropdown-item" href="{{ route('blog.index', ['category' => $acat->slug]) }}">{{ $acat->name }}</a></li>
                                @endforeach
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link px-3" href="{{ route('gallery.index') }}">Gallery</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link px-3" href="{{ route('contact.index') }}">Contact</a>
                        </li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto align-items-center">
                        

                        <li class="nav-item me-3">
                            <a href="{{ route('cart.index') }}" class="nav-link position-relative px-2" title="Keranjang">
                                <i class="bi bi-cart3 fs-5"></i>
                                @php $cartCount = count(session('cart', [])); @endphp
                                @if($cartCount > 0)
                                    <span class="position-absolute top-0 inset-s-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.65rem;">
                                        {{ $cartCount }}
                                    </span>
                                @endif
                            </a>
                        </li>
                        @guest
                            <li class="nav-item d-flex align-items-center ms-lg-3 mt-3 mt-lg-0">
                                <a href="{{ route('customer.login') }}" class="btn btn-link text-decoration-none fw-semibold" style="color: #4a5568;">Log in</a>
                                <a href="{{ route('customer.register') }}" class="btn btn-primary rounded-pill px-4 py-2 ms-2 fw-semibold shadow-sm" style="background: #0d47a1; border: none; font-size: 0.95rem;">Sign up</a>
                            </li>
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle px-3" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <i class="bi bi-person-circle me-1"></i> {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end shadow border-0 mt-0" aria-labelledby="navbarDropdown">
                                    @if(Auth::user()->role == 'admin' || Auth::user()->role == 'superadmin')
                                        <a class="dropdown-item fw-bold text-primary" href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2 me-2"></i> Admin Panel</a>
                                        <div class="dropdown-divider"></div>
                                    @endif
                                    <a class="dropdown-item" href="{{ route('customer.dashboard') }}"><i class="bi bi-box-seam me-2"></i> My Orders</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item text-danger" href="{{ route('customer.logout') }}"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="bi bi-box-arrow-right me-2"></i> {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('customer.logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main>
            @yield('content')
        </main>

        <footer class="footer pt-5 mt-auto">
            <div class="container pt-4">
                <div class="row gx-lg-5">
                    @php
                        $companyProfile = \App\Models\CompanyProfile::first();
                    @endphp
                    <!-- Brand Section -->
                    <div class="col-lg-4 mb-5">
                        <div class="d-flex align-items-center mb-4">
                            <div class="bg-white rounded p-2 shadow-sm d-inline-block me-3">
                                <img src="{{ asset('images/logo.png') }}" alt="Wiratama-MA Logo" height="45">
                            </div>
                            <h4 class="text-white mb-0 fw-bold" style="letter-spacing: 0.5px;">WIRATAMA MITRA ABADI</h4>
                        </div>
                        <p class="mb-4" style="line-height: 1.8; font-size: 0.95rem;">
                            Platform E-Commerce PT Wiratama Mitra Abadi penyedia solusi industrial instrumen terpercaya di Indonesia. Kami berkomitmen memberikan kualitas dan pelayanan terbaik.
                        </p>
                        <div class="d-flex gap-3">
                            <a href="https://wma.co.id" target="_blank" class="footer-social-link" title="Main Website"><i class="bi bi-globe"></i></a>
                            @if($companyProfile && $companyProfile->linkedin)
                                <a href="{{ $companyProfile->linkedin }}" target="_blank" class="footer-social-link" title="LinkedIn"><i class="bi bi-linkedin"></i></a>
                            @endif
                            @if($companyProfile && $companyProfile->youtube)
                                <a href="{{ $companyProfile->youtube }}" target="_blank" class="footer-social-link" title="YouTube"><i class="bi bi-youtube"></i></a>
                            @endif
                            @if($companyProfile && $companyProfile->facebook)
                                <a href="{{ $companyProfile->facebook }}" target="_blank" class="footer-social-link" title="Facebook"><i class="bi bi-facebook"></i></a>
                            @endif
                            @if($companyProfile && $companyProfile->instagram)
                                <a href="{{ $companyProfile->instagram }}" target="_blank" class="footer-social-link" title="Instagram"><i class="bi bi-instagram"></i></a>
                            @endif
                            <a href="https://www.tiktok.com/@wiratama_ma" target="_blank" class="footer-social-link" title="TikTok"><i class="bi bi-tiktok"></i></a>
                        </div>
                    </div>
                    
                    <!-- Quick Links Section -->
                    <div class="col-lg-2 col-md-4 mb-5">
                        <h5 class="footer-heading">Quick Links</h5>
                        <ul class="list-unstyled">
                            <li class="mb-3"><a href="{{ url('/') }}" class="footer-link"><i class="bi bi-chevron-right me-2" style="font-size: 0.7rem;"></i>Home</a></li>
                            <li class="mb-3"><a href="{{ route('about') }}" class="footer-link"><i class="bi bi-chevron-right me-2" style="font-size: 0.7rem;"></i>About Us</a></li>
                            <li class="mb-3"><a href="{{ route('products.index') }}" class="footer-link"><i class="bi bi-chevron-right me-2" style="font-size: 0.7rem;"></i>Our Products</a></li>
                            <li class="mb-3"><a href="{{ route('blog.index') }}" class="footer-link"><i class="bi bi-chevron-right me-2" style="font-size: 0.7rem;"></i>News & Articles</a></li>
                            <li class="mb-3"><a href="{{ route('gallery.index') }}" class="footer-link"><i class="bi bi-chevron-right me-2" style="font-size: 0.7rem;"></i>Gallery</a></li>
                        </ul>
                    </div>

                    <!-- Categories Section -->
                    <div class="col-lg-3 col-md-4 mb-5">
                        <h5 class="footer-heading">Core Categories</h5>
                        <ul class="list-unstyled">
                            @php
                                $footerCategories = \App\Models\Category::take(4)->get();
                            @endphp
                            @forelse($footerCategories as $fcat)
                            <li class="mb-3"><a href="{{ route('products.index', ['category' => $fcat->slug]) }}" class="footer-link"><i class="bi bi-chevron-right me-2" style="font-size: 0.7rem;"></i>{{ $fcat->name }}</a></li>
                            @empty
                            <li class="mb-3 text-muted">No categories found.</li>
                            @endforelse
                        </ul>
                    </div>

                    <!-- Contact Section -->
                    <div class="col-lg-3 col-md-4 mb-5">
                        <h5 class="footer-heading">Contact Us</h5>
                        @php
                            $fAddress = $companyProfile ? $companyProfile->address : 'Jl. Industrial Estate No. 1, Jakarta';
                            $fPhone = $companyProfile ? $companyProfile->phone : '+62 21 1234 5678';
                            $fEmail = $companyProfile ? $companyProfile->email : 'info@wiratama-ma.com';
                        @endphp
                        
                        <div class="footer-contact-item">
                            <i class="bi bi-geo-alt-fill footer-contact-icon"></i>
                            <div>
                                <h6 class="text-white mb-1" style="font-size: 0.9rem;">Head Office</h6>
                                <a href="https://maps.google.com/?q={{ urlencode($fAddress) }}" target="_blank" class="text-decoration-none" style="color: #a8b2c1; font-size: 0.9rem; transition: color 0.3s;" onmouseover="this.style.color='#64ffda'" onmouseout="this.style.color='#a8b2c1'">
                                    {{ $fAddress }}
                                </a>
                            </div>
                        </div>
                        
                        <div class="footer-contact-item">
                            <i class="bi bi-telephone-fill footer-contact-icon"></i>
                            <div>
                                <h6 class="text-white mb-1" style="font-size: 0.9rem;">Phone</h6>
                                <a href="tel:{{ preg_replace('/[^0-9+]/', '', $fPhone) }}" class="text-decoration-none" style="color: #a8b2c1; font-size: 0.9rem; transition: color 0.3s;" onmouseover="this.style.color='#64ffda'" onmouseout="this.style.color='#a8b2c1'">
                                    {{ $fPhone }}
                                </a>
                            </div>
                        </div>

                        <div class="footer-contact-item">
                            <i class="bi bi-envelope-fill footer-contact-icon"></i>
                            <div>
                                <h6 class="text-white mb-1" style="font-size: 0.9rem;">Email</h6>
                                <a href="mailto:{{ $fEmail }}" class="text-decoration-none" style="color: #a8b2c1; font-size: 0.9rem; transition: color 0.3s;" onmouseover="this.style.color='#64ffda'" onmouseout="this.style.color='#a8b2c1'">
                                    {{ $fEmail }}
                                </a>
                            </div>
                        </div>
                        
                        <div class="footer-contact-item mt-3 d-flex flex-column gap-2 w-100">
                            <a href="tel:{{ preg_replace('/[^0-9+]/', '', $fPhone) }}" class="btn btn-outline-light rounded-pill px-4 py-2 w-100 fw-semibold text-start" style="border-color: rgba(255,255,255,0.2); transition: all 0.3s;" onmouseover="this.style.backgroundColor='#0d47a1'; this.style.borderColor='#0d47a1'; this.style.color='white'" onmouseout="this.style.backgroundColor='transparent'; this.style.borderColor='rgba(255,255,255,0.2)';">
                                <i class="bi bi-telephone-fill me-2"></i> Call (021) 8949 1561
                            </a>
                            @if($companyProfile && $companyProfile->whatsapp)
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $companyProfile->whatsapp) }}" target="_blank" class="btn btn-outline-light rounded-pill px-4 py-2 w-100 fw-semibold text-start" style="border-color: rgba(255,255,255,0.2); transition: all 0.3s;" onmouseover="this.style.backgroundColor='#25D366'; this.style.borderColor='#25D366'; this.style.color='white'" onmouseout="this.style.backgroundColor='transparent'; this.style.borderColor='rgba(255,255,255,0.2)';">
                                <i class="bi bi-whatsapp me-2"></i> Chat WhatsApp
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Copyright Section -->
            <div style="background: rgba(0,0,0,0.3); border-top: 1px solid rgba(255,255,255,0.05);" class="py-4 mt-2">
                <div class="container text-center text-md-start d-md-flex justify-content-between align-items-center">
                    <p class="mb-2 mb-md-0" style="font-size: 0.85rem; color: #8892b0;">
                        &copy; {{ date('Y') }} <strong>PT Wiratama Mitra Abadi</strong>. All rights reserved.
                    </p>
                    <div style="font-size: 0.85rem; color: #8892b0;">
                        <a href="#" class="text-decoration-none text-muted me-3" style="transition: color 0.3s;" onmouseover="this.style.color='#64ffda'" onmouseout="this.style.color='#8892b0'">Privacy Policy</a>
                        <a href="#" class="text-decoration-none text-muted" style="transition: color 0.3s;" onmouseover="this.style.color='#64ffda'" onmouseout="this.style.color='#8892b0'">Terms of Service</a>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    <style>
        .floating-admin-btn {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 40px;
            height: 40px;
            background-color: rgba(0,0,0,0.1);
            color: rgba(255,255,255,0.5);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            transition: all 0.3s ease;
            z-index: 1000;
        }
        .floating-admin-btn:hover {
            background-color: #0d47a1;
            color: #fff;
            transform: scale(1.1);
        }
    </style>
    @guest
        <a href="{{ url('admin/login') }}" class="floating-admin-btn" title="Admin Login">
            <i class="bi bi-gear-fill" style="font-size: 1.2rem;"></i>
        </a>
    @endguest

    <!-- Back To Top Button -->
    <button id="back-to-top" class="back-to-top-btn" title="Back to Top">
        <i class="bi bi-arrow-up"></i>
    </button>
    <style>
        .back-to-top-btn {
            position: fixed;
            bottom: 25px;
            right: 25px;
            width: 44px;
            height: 44px;
            background-color: #0d47a1;
            color: #ffffff;
            border: none;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            cursor: pointer;
            box-shadow: 0 10px 25px rgba(13, 71, 161, 0.3);
            opacity: 0;
            visibility: hidden;
            transform: translateY(15px);
            transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1);
            z-index: 999;
        }
        .back-to-top-btn.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }
        .back-to-top-btn:hover {
            background-color: #00b4d8;
            color: #ffffff;
            transform: translateY(-4px) scale(1.05);
            box-shadow: 0 15px 30px rgba(0, 180, 216, 0.4);
        }
    </style>

    <!-- AOS Animation JS -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 800,
            once: true,
            offset: 40,
            easing: 'cubic-bezier(0.16, 1, 0.3, 1)'
        });

        // Scroll listener for Navbar shadow & Back-to-Top button
        const navbarEl = document.querySelector('.navbar');
        const backToTopBtn = document.getElementById('back-to-top');

        window.addEventListener('scroll', () => {
            if (window.scrollY > 40) {
                navbarEl?.classList.add('nav-scrolled');
            } else {
                navbarEl?.classList.remove('nav-scrolled');
            }

            if (window.scrollY > 280) {
                backToTopBtn?.classList.add('show');
            } else {
                backToTopBtn?.classList.remove('show');
            }
        });

        backToTopBtn?.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        // Preloader Logic
        document.addEventListener("DOMContentLoaded", () => {
            const preloader = document.getElementById('global-preloader');
            
            // Hide on initial load
            window.addEventListener('load', () => {
                if(preloader) {
                    preloader.style.opacity = '0';
                    setTimeout(() => {
                        preloader.style.visibility = 'hidden';
                        document.body.classList.remove('preloader-active');
                    }, 200); // match css transition duration
                }
            });

            // Show on navigation clicks
            document.querySelectorAll('a').forEach(link => {
                link.addEventListener('click', function(e) {
                    const target = this.getAttribute('target');
                    const href = this.getAttribute('href');
                    
                    // Ignore clicks that shouldn't trigger preloader
                    if (
                        !href || 
                        href.startsWith('#') || 
                        href.startsWith('javascript:') || 
                        href.startsWith('mailto:') ||
                        href.startsWith('tel:') ||
                        target === '_blank' ||
                        e.ctrlKey || 
                        e.metaKey ||
                        this.hasAttribute('data-bs-toggle')
                    ) {
                        return;
                    }

                    // Show preloader
                    if(preloader) {
                        preloader.style.visibility = 'visible';
                        preloader.style.opacity = '1';
                        document.body.classList.add('preloader-active');
                    }
                });
            });

            // Show on form submits (like login)
            document.querySelectorAll('form').forEach(form => {
                form.addEventListener('submit', function() {
                    // Ignore forms with target blank
                    if(this.getAttribute('target') !== '_blank') {
                        if(preloader) {
                            preloader.style.visibility = 'visible';
                            preloader.style.opacity = '1';
                            document.body.classList.add('preloader-active');
                        }
                    }
                });
            });
        });
        
        // Safety fallback if page gets stuck using browser back button
        window.addEventListener('pageshow', (e) => {
            if (e.persisted) {
                const preloader = document.getElementById('global-preloader');
                if (preloader) {
                    preloader.style.opacity = '0';
                    preloader.style.visibility = 'hidden';
                    document.body.classList.remove('preloader-active');
                }
            }
        });
    </script>
    @stack('scripts')
</body>
</html>
