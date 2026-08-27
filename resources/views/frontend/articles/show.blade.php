@extends('layouts.app')

@section('meta_title', $article->meta_title ?? $article->title . ' - PT Wiratama Mitra Abadi')
@section('meta_description', $article->meta_description ?? Str::limit(strip_tags($article->content), 160))
@section('meta_keywords', $article->meta_keywords ?? ($article->title . ', artikel, industrial news, PT Wiratama Mitra Abadi'))

@push('structured_data')
@php
    $articleSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'Article',
        'headline' => $article->title,
        'url' => route('blog.show', $article->slug),
        'description' => Str::limit(strip_tags($article->content), 500),
        'image' => $article->image ? [asset('storage/' . $article->image)] : [asset('images/logo.png')],
        'datePublished' => optional($article->published_at ?? $article->created_at)->toAtomString(),
        'dateModified' => optional($article->updated_at)->toAtomString(),
        'author' => ['@type' => 'Organization', 'name' => 'PT Wiratama Mitra Abadi'],
        'publisher' => ['@type' => 'Organization', 'name' => 'PT Wiratama Mitra Abadi', 'logo' => ['@type' => 'ImageObject', 'url' => asset('images/logo.png')]],
    ];
    $breadcrumbSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'BreadcrumbList',
        'itemListElement' => [
            ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => url('/')],
            ['@type' => 'ListItem', 'position' => 2, 'name' => 'Blog', 'item' => route('blog.index')],
            ['@type' => 'ListItem', 'position' => 3, 'name' => $article->title, 'item' => route('blog.show', $article->slug)],
        ],
    ];
@endphp
<script type="application/ld+json">{!! json_encode($articleSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
<script type="application/ld+json">{!! json_encode($breadcrumbSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
@endpush

@section('content')

<!-- In a real app, you would yield these to the head section of your layout -->

<style>
    /* Modern Article Typography & Layout */
    .article-wrapper {
        background-color: #ffffff;
    }
    .article-header {
        padding: 5rem 0 3rem;
        background: linear-gradient(to bottom, #f8fafc 0%, #ffffff 100%);
    }
    .article-category-badge {
        font-size: 0.85rem;
        font-weight: 700;
        letter-spacing: 1px;
        text-transform: uppercase;
        padding: 0.5rem 1.2rem;
        border-radius: 50px;
        background-color: #eff6ff;
        color: #2563eb;
        border: 1px solid #bfdbfe;
        display: inline-block;
        margin-bottom: 1.5rem;
    }
    .article-title {
        font-size: 3rem;
        font-weight: 800;
        line-height: 1.2;
        color: #0f172a;
        letter-spacing: -1px;
        margin-bottom: 1.5rem;
    }
    .article-meta {
        font-size: 0.95rem;
        color: #64748b;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 1.5rem;
    }
    .article-meta-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .article-image-wrapper {
        position: relative;
        border-radius: 24px;
        overflow: hidden;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.1);
        margin-top: -2rem;
        margin-bottom: 3rem;
        background: #f8fafc;
        border: 1px solid rgba(0,0,0,0.05);
        max-width: 800px;
        margin-left: auto;
        margin-right: auto;
    }
    .article-image {
        width: 100%;
        max-height: 400px;
        object-fit: contain; /* Using contain to preserve original image aspects like the UTG meter */
        background: radial-gradient(circle, #ffffff 0%, #f1f5f9 100%);
        padding: 1rem;
    }
    .article-content {
        font-size: 1.1rem;
        line-height: 1.85;
        color: #374151;
        font-family: 'Inter', sans-serif;
        font-weight: 400;
    }
    .article-content p,
    .article-content li,
    .article-content td,
    .article-content span {
        font-weight: 400 !important;
        line-height: 1.85;
    }
    .article-content strong,
    .article-content b {
        font-weight: 700 !important;
    }
    .article-content h1, .article-content h2, .article-content h3,
    .article-content h4, .article-content h5, .article-content h6 {
        color: #0f172a;
        font-weight: 700;
        margin-top: 2.5rem;
        margin-bottom: 1rem;
        letter-spacing: -0.5px;
        line-height: 1.3;
    }
    .article-content p {
        margin-bottom: 1.4rem;
    }
    .article-content ul, .article-content ol {
        margin-bottom: 1.5rem;
        padding-left: 1.5rem;
    }
    .article-content li {
        margin-bottom: 0.65rem;
    }
    .article-content img {
        max-width: 100%;
        border-radius: 12px;
        height: auto;
        margin: 2rem 0;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05);
    }
    .article-content a {
        color: #2563eb;
        text-decoration: underline;
        text-underline-offset: 3px;
    }
    .article-content blockquote {
        border-left: 4px solid #2563eb;
        padding: 1rem 1.5rem;
        margin: 1.5rem 0;
        background: #eff6ff;
        border-radius: 0 8px 8px 0;
        font-style: italic;
        color: #475569;
        font-weight: 400;
    }

    
    .related-card {
        transition: all 0.4s ease;
        border-radius: 16px;
        border: 1px solid #f1f5f9;
    }
    .related-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px -10px rgba(0,0,0,0.1) !important;
    }
    @media (max-width: 768px) {
        .article-title { font-size: 2.2rem; }
        .article-header { padding: 3rem 0 2rem; }
        .article-image { padding: 1rem; }
    }
</style>

<div class="article-wrapper">
    <!-- Header Section -->
    <header class="article-header">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-10 text-center">
                    <div class="mb-4 d-flex justify-content-center">
                        <a href="{{ route('blog.index') }}" class="text-decoration-none text-muted fw-bold small hover-primary" style="transition: color 0.3s;">
                            <i class="bi bi-arrow-left me-2"></i>Back to Knowledge Base
                        </a>
                    </div>
                    
                    <span class="article-category-badge">
                        {{ $article->category ? $article->category->name : 'Uncategorized' }}
                    </span>
                    
                    <h1 class="article-title">{{ $article->title }}</h1>
                    
                    <div class="article-meta justify-content-center">
                        <!-- Date and Author removed as requested -->
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <div class="container pb-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <!-- Featured Image -->
                @if($article->image)
                    <div class="article-image-wrapper" data-aos="fade-up">
                        <img src="{{ asset('storage/'.$article->image) }}" class="article-image" alt="{{ $article->title }}">
                    </div>
                @else
                    <div class="article-image-wrapper d-flex align-items-center justify-content-center" data-aos="fade-up" style="height: 300px; background: #f1f5f9;">
                        <i class="bi bi-journal-richtext text-muted opacity-25" style="font-size: 6rem;"></i>
                    </div>
                @endif
            </div>

            <div class="col-lg-8 col-md-10">
                <!-- Article Body -->
                <div class="article-content" data-aos="fade-up" data-aos-delay="100">
                    {!! $article->content !!}
                </div>

                <!-- Footer Actions -->
                <div class="d-flex justify-content-between align-items-center mt-5 pt-4 border-top">
                    <div class="d-flex align-items-center gap-3">
                        <span class="fw-bold text-muted small text-uppercase tracking-wide">Share</span>
                        
                        <!-- Salin Tautan -->
                        <button onclick="navigator.clipboard.writeText(window.location.href); alert('Tautan berhasil disalin!');" class="btn btn-light rounded-circle text-dark shadow-sm" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;" title="Salin Tautan">
                            <i class="bi bi-link-45deg fs-5"></i>
                        </button>
                        
                        <!-- WhatsApp -->
                        <a href="https://api.whatsapp.com/send?text={{ urlencode($article->title . ' - ' . url()->current()) }}" target="_blank" class="btn btn-light rounded-circle shadow-sm" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; color: #25D366;" title="Share to WhatsApp">
                            <i class="bi bi-whatsapp"></i>
                        </a>
                        
                        <!-- Facebook -->
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" class="btn btn-light rounded-circle shadow-sm" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; color: #1877F2;" title="Share to Facebook">
                            <i class="bi bi-facebook"></i>
                        </a>
                        
                        <!-- Instagram -->
                        <a href="https://www.instagram.com/" target="_blank" class="btn btn-light rounded-circle shadow-sm" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; color: #E4405F;" title="Instagram">
                            <i class="bi bi-instagram"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Related Articles -->
@if($related_articles->count() > 0)
<div class="bg-light py-5 border-top">
    <div class="container py-4">
        <div class="text-center mb-5">
            <span class="text-primary fw-bold tracking-wide text-uppercase small">Read More</span>
            <h2 class="fw-bold text-dark mt-2">Related Articles</h2>
        </div>
        
        <div class="row g-4 justify-content-center">
            @foreach($related_articles as $related)
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ $loop->iteration * 100 }}">
                <div class="card related-card h-100 shadow-sm overflow-hidden">
                    @if($related->image)
                        <div style="height: 220px; background: #f8fafc; padding: 1.5rem;" class="d-flex align-items-center justify-content-center">
                            <img src="{{ asset('storage/'.$related->image) }}" alt="{{ $related->title }}" style="max-height: 100%; max-width: 100%; object-fit: contain; mix-blend-mode: multiply;">
                        </div>
                    @else
                        <div style="height: 220px; background: #f1f5f9;" class="d-flex align-items-center justify-content-center text-muted">
                            <i class="bi bi-newspaper" style="font-size: 4rem; opacity: 0.3;"></i>
                        </div>
                    @endif
                    <div class="card-body p-4 bg-white">
                        <div class="mb-3 d-flex justify-content-between align-items-center">
                            <span class="badge bg-primary-subtle text-primary rounded-pill px-3">{{ $related->category ? $related->category->name : 'News' }}</span>
                        </div>
                        <h5 class="card-title fw-bold mb-3" style="line-height: 1.4;">
                            <a href="{{ route('blog.show', $related->slug) }}" class="text-dark text-decoration-none stretched-link">{{ $related->title }}</a>
                        </h5>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif

@if($related_products->isNotEmpty())
<section class="py-5 border-top" aria-labelledby="related-products-title">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 id="related-products-title" class="h4 fw-bold text-dark mb-0">Produk terkait</h2>
            <a href="{{ route('products.index') }}" class="text-primary text-decoration-none fw-semibold small">Lihat katalog <i class="bi bi-arrow-right"></i></a>
        </div>
        <div class="row g-3">
            @foreach($related_products as $product)
            <div class="col-md-3 col-6">
                <article class="border rounded-3 h-100 p-3 bg-white">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="img-fluid mb-3" style="height: 120px; width: 100%; object-fit: contain;">
                    @endif
                    <h3 class="h6 fw-bold mb-0"><a href="{{ route('products.show', $product->slug) }}" class="text-dark text-decoration-none">{{ $product->name }}</a></h3>
                </article>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection
