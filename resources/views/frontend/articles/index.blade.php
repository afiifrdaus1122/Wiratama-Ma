@extends('layouts.app')

@section('content')
@php
    $heroBackground = optional(\App\Models\CompanyProfile::first())->hero_image;
    $heroBackgroundUrl = $heroBackground
        ? asset('storage/' . $heroBackground)
        : 'https://images.unsplash.com/photo-1504711434969-e33886168f5c?q=80&w=2070&auto=format&fit=crop';
@endphp
<style>
    .article-hero {
        background-image: linear-gradient(135deg, rgba(13, 71, 161, 0.9) 0%, rgba(27, 38, 59, 0.95) 100%), url('{{ $heroBackgroundUrl }}');
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
        padding: 100px 0;
        color: white;
        position: relative;
    }
    
    .article-card {
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        border: none;
        border-radius: 16px;
        background: #fff;
    }
    
    .article-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.08);
    }
    
    .article-img-wrapper {
        overflow: hidden;
        border-radius: 16px 16px 0 0;
        position: relative;
    }
    
    .article-img {
        width: 100%;
        height: 180px;
        object-fit: contain;
        background-color: #f8f9fa;
        transition: transform 0.6s ease;
    }
    
    .article-card:hover .article-img {
        transform: scale(1.05);
    }

    .article-badge {
        position: absolute;
        top: 20px;
        left: 20px;
        background: rgba(13, 71, 161, 0.9);
        backdrop-filter: blur(5px);
        color: white;
        font-weight: 700;
        font-size: 0.75rem;
        padding: 6px 15px;
        border-radius: 50px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.2);
        z-index: 2;
    }

    .sidebar-card {
        background: white;
        border-radius: 16px;
        border: 1px solid rgba(0,0,0,0.05);
        box-shadow: 0 5px 15px rgba(0,0,0,0.03);
    }

    .sidebar-title {
        font-weight: 800;
        color: #1b263b;
        position: relative;
        padding-bottom: 15px;
        margin-bottom: 25px;
    }

    .sidebar-title::after {
        content: '';
        position: absolute;
        left: 0;
        bottom: 0;
        width: 50px;
        height: 3px;
        background: #00b4d8;
        border-radius: 50px;
    }

    .cat-link {
        color: #4a5568;
        font-weight: 600;
        transition: all 0.2s;
        padding: 8px 0;
        display: block;
    }

    .cat-link:hover, .cat-link.active {
        color: #0d47a1;
        transform: translateX(5px);
    }
</style>

<!-- Page Header -->
<div class="article-hero">
    <div class="container text-center position-relative z-10">
        <span class="badge bg-white text-primary px-3 py-2 rounded-pill fw-bold mb-3 shadow-sm" style="font-size: 0.85rem;">
            <i class="bi bi-journal-text me-1"></i> WMA Knowledge Base
        </span>
        <h1 class="display-4 fw-bold mb-3" style="letter-spacing: -1px;">News & Articles</h1>
        <p class="lead opacity-75 mx-auto" style="max-width: 600px;">Stay updated with the latest industrial insights, technology trends, and official company news.</p>
    </div>
</div>

<div class="container py-5 mt-4">
    <div class="row g-5">
        <!-- Main Content -->
        <div class="col-lg-8">
            <div class="row g-4">
                @forelse($articles as $article)
                <div class="col-md-6">
                    <div class="card article-card h-100 shadow-sm border-0" style="border-radius: 12px; overflow: hidden;">
                        <div class="article-img-wrapper" style="position: relative;">
                            <span class="badge bg-primary-subtle text-primary position-absolute top-0 inset-s-0 m-2 rounded-pill px-2 py-1" style="font-size: 0.7rem; z-index: 10;">{{ $article->category ? $article->category->name : 'Uncategorized' }}</span>
                            @if($article->image)
                                <img src="{{ asset('storage/'.$article->image) }}" alt="{{ $article->title }}" style="width: 100%; height: 140px; object-fit: contain; background-color: #f8f9fa; padding: 10px; transition: transform 0.6s ease;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                            @else
                                <div class="bg-light d-flex align-items-center justify-content-center" style="height: 140px;">
                                    <i class="bi bi-image text-muted" style="font-size: 2rem;"></i>
                                </div>
                            @endif
                        </div>
                        <div class="card-body p-3 d-flex flex-column">
                            <h6 class="fw-bold mb-2" style="line-height: 1.3;">
                                <a href="{{ route('blog.show', $article->slug) }}" class="text-dark text-decoration-none hover-primary">{{ $article->title }}</a>
                            </h6>
                            <p class="text-muted mb-3 grow" style="font-size: 0.85rem; line-height: 1.4;">
                                {{ Str::limit(strip_tags($article->content), 70) }}
                            </p>
                            <div class="mt-auto">
                                <div class="d-flex align-items-center justify-content-between gap-2">
                                    <a href="{{ route('blog.show', $article->slug) }}" class="btn btn-outline-primary rounded-pill btn-sm px-3 fw-bold" style="font-size: 0.75rem;">Read <i class="bi bi-arrow-right ms-1"></i></a>
                                    @if($article->products_count > 0)
                                        <span class="text-muted small" title="Produk terkait">
                                            <i class="bi bi-box-seam me-1"></i>{{ $article->products_count }} produk
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center py-5">
                    <div class="p-5 bg-light rounded-4">
                        <i class="bi bi-journal-x display-1 text-muted mb-3 d-block"></i>
                        <h3 class="text-muted fw-bold">No articles found.</h3>
                        <p class="text-muted">We couldn't find any articles matching your search criteria.</p>
                    </div>
                </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-5 d-flex justify-content-center">
                {{ $articles->withQueryString()->links() }}
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Search -->
            <div class="sidebar-card p-4 mb-4">
                <h5 class="sidebar-title">Search Articles</h5>
                <form action="{{ route('blog.index') }}" method="GET">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control bg-light border-0" placeholder="Keywords..." value="{{ request('search') }}" style="padding: 12px 20px; border-radius: 50px 0 0 50px;">
                        <button class="btn btn-primary px-4" type="submit" style="border-radius: 0 50px 50px 0;"><i class="bi bi-search"></i></button>
                    </div>
                </form>
            </div>

            <!-- Categories -->
            <div class="sidebar-card p-4 mb-4">
                <h5 class="sidebar-title">Categories</h5>
                <ul class="list-unstyled mb-0">
                    <li class="border-bottom pb-2 mb-2">
                        <a href="{{ route('blog.index') }}" class="text-decoration-none cat-link {{ !request('category') ? 'active' : '' }}">
                            <div class="d-flex justify-content-between align-items-center">
                                <span>All Articles</span>
                                <i class="bi bi-chevron-right small opacity-50"></i>
                            </div>
                        </a>
                    </li>
                    @foreach($categories as $category)
                    <li class="border-bottom pb-2 mb-2 last-border-0">
                        <a href="{{ route('blog.index', ['category' => $category->slug]) }}" class="text-decoration-none cat-link {{ request('category') == $category->slug ? 'active' : '' }}">
                            <div class="d-flex justify-content-between align-items-center">
                                <span>{{ $category->name }}</span>
                                <span class="badge bg-light text-dark rounded-pill">{{ $category->articles_count }}</span>
                            </div>
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
