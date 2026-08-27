@extends('layouts.app')

@if(isset($activeCategory))
    @section('meta_title', $activeCategory->meta_title ?: $activeCategory->name . ' - PT Wiratama Mitra Abadi')
    @section('meta_description', $activeCategory->meta_description ?: 'Beli berbagai produk ' . $activeCategory->name . ' dengan harga terbaik dari PT Wiratama Mitra Abadi.')
    @if($activeCategory->meta_keywords)
        @section('meta_keywords', $activeCategory->meta_keywords)
    @endif
@else
    @section('meta_title', 'Semua Produk - PT Wiratama Mitra Abadi')
@endif

@section('content')
<style>
    .product-hero {
        background: linear-gradient(135deg, rgba(13, 71, 161, 0.85) 0%, rgba(27, 38, 59, 0.95) 100%), url('https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?q=80&w=2070&auto=format&fit=crop') no-repeat center center;
        background-size: cover;
        padding: 100px 0;
        color: white;
        position: relative;
        overflow: hidden;
    }
    
    .product-hero::after {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 50%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.05) 0%, transparent 70%);
        transform: rotate(-30deg);
        z-index: 0;
    }

    .product-card {
        transition: all 0.3s ease;
        border: 1px solid rgba(0,0,0,0.05);
        border-radius: 16px;
        background: #fff;
    }
    
    .product-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.08) !important;
        border-color: rgba(13,71,161,0.1);
    }
    
    .product-img-wrapper {
        position: relative;
        overflow: hidden;
        border-radius: 16px 16px 0 0;
        background: #fff;
        padding: 20px;
    }
    
    .product-img {
        width: 100%;
        aspect-ratio: 4 / 3;
        object-fit: contain;
        transition: transform 0.5s ease;
    }
    
    .product-card:hover .product-img {
        transform: scale(1.08);
    }

    .product-badge {
        position: absolute;
        top: 15px;
        right: 15px;
        background: rgba(255,255,255,0.9);
        backdrop-filter: blur(5px);
        color: #0d47a1;
        font-weight: 700;
        font-size: 0.7rem;
        padding: 5px 12px;
        border-radius: 50px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        z-index: 2;
    }

    .sidebar-card {
        background: white;
        border-radius: 16px;
        border: 1px solid rgba(0,0,0,0.05);
        box-shadow: 0 5px 15px rgba(0,0,0,0.02);
    }

    .sidebar-title {
        font-weight: 800;
        color: #1b263b;
        position: relative;
        padding-bottom: 12px;
        margin-bottom: 20px;
    }

    .sidebar-title::after {
        content: '';
        position: absolute;
        left: 0;
        bottom: 0;
        width: 40px;
        height: 3px;
        background: #0d47a1;
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
    
    /* Mobile Compact Styling */
    @media (max-width: 768px) {
        .product-hero {
            padding: 64px 0;
        }
        .product-hero h1 {
            font-size: 2rem !important;
            line-height: 1.15;
        }
        .product-hero p {
            font-size: 0.9rem;
            line-height: 1.5;
        }
        .sidebar-card {
            border-radius: 12px;
        }
        .sidebar-card.p-4 {
            padding: 1rem !important;
        }
        .product-card-body-mobile {
            padding: 12px !important;
        }
        .product-img-wrapper {
            padding: 10px !important;
        }
        .product-title-mobile {
            font-size: 0.85rem !important;
            margin-bottom: 8px !important;
        }
        .product-price-mobile {
            font-size: 0.9rem !important;
        }
        .product-btn-mobile {
            padding: 5px 10px !important;
            font-size: 0.75rem !important;
        }
        .product-badge {
            font-size: 0.55rem;
            padding: 3px 8px;
            top: 8px;
            right: 8px;
        }
        .product-card .card-title {
            overflow-wrap: anywhere;
        }
        .pagination {
            flex-wrap: wrap;
            justify-content: center;
        }
    }
</style>

<!-- Page Header -->
<div class="product-hero">
    <div class="container text-center position-relative" style="z-index: 10;">
        <span class="badge bg-white text-primary px-3 py-2 rounded-pill fw-bold mb-3 shadow-sm" style="font-size: 0.85rem;">
            <i class="bi bi-box-seam me-1"></i> Industrial Catalog
        </span>
        <h1 class="display-4 fw-bold text-white mb-3" style="letter-spacing: -1px;">Premium Products</h1>
        <p class="lead text-white-50 mx-auto" style="max-width: 600px;">Explore our extensive range of high-precision industrial instruments, sensors, and components.</p>
    </div>
</div>

<div class="container py-5">
    <div class="row g-5">
        <!-- Sidebar -->
        <div class="col-lg-3">
            <!-- Search -->
            <div class="sidebar-card p-4 mb-4">
                <h6 class="sidebar-title">Search Product</h6>
                <form action="{{ route('products.index') }}" method="GET">
                    @if(request('category'))
                        <input type="hidden" name="category" value="{{ request('category') }}">
                    @endif
                    <div class="input-group">
                        <div class="position-relative grow">
                            <input type="text" id="productSearch" name="search" autocomplete="off" class="form-control bg-light border-0 w-100" placeholder="SKU or Name..." value="{{ request('search') }}" style="padding: 10px 15px; border-radius: 8px 0 0 8px;">
                            <div id="searchSuggestions" class="list-group position-absolute w-100 shadow-sm" style="z-index: 20; top: 100%;"></div>
                        </div>
                        <button class="btn btn-primary px-3" type="submit" style="border-radius: 0 8px 8px 0;"><i class="bi bi-search"></i></button>
                    </div>
                </form>
            </div>
            <!-- Categories -->
            <div class="sidebar-card p-4 mb-4">
                <h6 class="sidebar-title">Categories</h6>
                <ul class="list-unstyled mb-0">
                    <li class="border-bottom pb-2 mb-2">
                        <a href="{{ route('products.index') }}" class="text-decoration-none cat-link {{ !request('category') ? 'active' : '' }}">
                            <div class="d-flex justify-content-between align-items-center">
                                <span>All Products</span>
                            </div>
                        </a>
                    </li>
                    @foreach($categories as $category)
                    <li class="border-bottom pb-2 mb-2 last-border-0">
                        <a href="{{ route('products.index', ['category' => $category->slug]) }}" class="text-decoration-none cat-link {{ request('category') == $category->slug ? 'active' : '' }}">
                            <div class="d-flex justify-content-between align-items-center">
                                <span>{{ $category->name }}</span>
                                <span class="badge bg-light text-muted rounded-pill" style="font-size: 0.7rem;">{{ $category->products_count }}</span>
                            </div>
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-lg-9">
            <!-- Active Filters -->
            @if(request('search') || request('category'))
                <div class="mb-4 p-3 bg-light rounded-3 d-flex align-items-center justify-content-between border" style="border-color: rgba(0,0,0,0.05)!important;">
                    <div>
                        <span class="text-muted me-2 small fw-bold">Showing results for:</span>
                        @if(request('search'))
                            <span class="badge bg-primary me-2 px-3 py-2 rounded-pill">Search: {{ request('search') }}</span>
                        @endif
                        @if(request('category'))
                            <span class="badge bg-primary px-3 py-2 rounded-pill">Category: {{ request('category') }}</span>
                        @endif
                    </div>
                    <a href="{{ route('products.index') }}" class="btn btn-sm btn-outline-danger rounded-pill fw-bold"><i class="bi bi-x-circle me-1"></i> Clear</a>
                </div>
            @endif

            <div class="row g-3 g-md-4">
                @forelse($products as $product)
                <div class="col-lg-4 col-md-6 col-6">
                    <div class="card h-100 border-0 shadow-sm product-card">
                        <div class="product-img-wrapper border-bottom" style="border-color: rgba(0,0,0,0.03)!important; padding: 15px;">
                            <span class="product-badge">{{ $product->category->name }}</span>
                            @if($product->image)
                                <img src="{{ asset('storage/'.$product->image) }}" class="product-img" alt="{{ $product->name }}">
                            @else
                                <div class="bg-light d-flex align-items-center justify-content-center product-img rounded">
                                    <i class="bi bi-box-seam text-muted" style="font-size: 2.5rem;"></i>
                                </div>
                            @endif
                        </div>
                        <div class="card-body p-3 product-card-body-mobile d-flex flex-column">
                            <div class="text-muted small mb-1 d-flex justify-content-end" style="font-size: 0.7rem;">
                                <span class="fw-bold">{{ $product->brand ?? 'WIRATAMA' }}</span>
                            </div>
                            <h5 class="card-title fw-bold text-dark mb-2 product-title-mobile" style="line-height: 1.3; font-size: 1rem;">
                                <a href="{{ route('products.show', $product->slug) }}" class="text-dark text-decoration-none hover-primary">{{ $product->name }}</a>
                            </h5>
                            <p class="text-muted small mb-3" style="font-size: 0.8rem; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis; line-height: 1.5;">
                                {{ strip_tags($product->description) }}
                            </p>
                            <div class="mt-auto d-flex flex-column gap-2">
                                <span class="text-primary fw-bold fs-6 product-price-mobile">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                <a href="{{ route('products.show', $product->slug) }}" class="btn btn-outline-primary rounded-pill w-100 fw-bold product-btn-mobile">Lihat Spesifikasi</a>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center py-5">
                    <div class="p-5 bg-light rounded-4">
                        <i class="bi bi-box-seam display-1 text-muted mb-3 d-block"></i>
                        <h3 class="text-muted fw-bold">No products found.</h3>
                        <p class="text-muted">Try adjusting your search criteria or explore other categories.</p>
                    </div>
                </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-5 d-flex justify-content-center">
                {{ $products->withQueryString()->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('productSearch');
    const suggestions = document.getElementById('searchSuggestions');
    let timer;
    input.addEventListener('input', function () {
        clearTimeout(timer);
        const query = input.value.trim();
        if (query.length < 2) { suggestions.innerHTML = ''; return; }
        timer = setTimeout(() => fetch('{{ route('products.autocomplete') }}?q=' + encodeURIComponent(query))
            .then(response => response.json())
            .then(products => {
                suggestions.innerHTML = products.map(product => `<a href="${product.url}" class="list-group-item list-group-item-action d-flex align-items-center gap-2"><img src="${product.image || ''}" style="width: 38px; height: 38px; object-fit: contain;" onerror="this.style.display='none'"><span><strong>${product.name}</strong><small class="d-block text-muted">${product.brand || ''} ${product.sku || ''}</small></span></a>`).join('');
            }), 250);
    });
    document.addEventListener('click', event => { if (!input.contains(event.target) && !suggestions.contains(event.target)) suggestions.innerHTML = ''; });
});
</script>
@endpush
