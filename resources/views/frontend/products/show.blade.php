@extends('layouts.app')

@section('meta_title', $product->meta_title ?? $product->name . ' - PT Wiratama Mitra Abadi')
@section('meta_description', $product->meta_description ?? Str::limit(strip_tags($product->description), 160))
@section('meta_keywords', $product->meta_keywords ?? ($product->name . ', ' . ($product->brand ?? '') . ', ' . $product->category->name . ', PT Wiratama Mitra Abadi'))

@push('structured_data')
@php
    $productSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'Product',
        'name' => $product->name,
        'url' => route('products.show', $product->slug),
        'description' => Str::limit(strip_tags($product->description), 500),
        'image' => $product->image ? [asset('storage/' . $product->image)] : [asset('images/logo.png')],
        'brand' => ['@type' => 'Brand', 'name' => $product->brand ?: 'PT Wiratama Mitra Abadi'],
        'offers' => [
            '@type' => 'Offer',
            'url' => route('products.show', $product->slug),
            'priceCurrency' => 'IDR',
            'price' => (string) $product->price,
            'availability' => $product->stock > 0 ? 'https://schema.org/InStock' : 'https://schema.org/PreOrder',
        ],
    ];
    $breadcrumbSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'BreadcrumbList',
        'itemListElement' => [
            ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => url('/')],
            ['@type' => 'ListItem', 'position' => 2, 'name' => 'Products', 'item' => route('products.index')],
            ['@type' => 'ListItem', 'position' => 3, 'name' => $product->category->name, 'item' => route('products.index', ['category' => $product->category->slug])],
            ['@type' => 'ListItem', 'position' => 4, 'name' => $product->name, 'item' => route('products.show', $product->slug)],
        ],
    ];
    $faqQuestions = $product->questions->map(fn ($question) => [
        '@type' => 'Question',
        'name' => $question->question,
        'acceptedAnswer' => ['@type' => 'Answer', 'text' => strip_tags($question->answer)],
    ])->values()->all();
@endphp
<script type="application/ld+json">{!! json_encode($productSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
<script type="application/ld+json">{!! json_encode($breadcrumbSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
@if($faqQuestions)
<script type="application/ld+json">{!! json_encode(['@context' => 'https://schema.org', '@type' => 'FAQPage', 'mainEntity' => $faqQuestions], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
@endif
@endpush

@section('content')
<!-- Breadcrumb Navigation -->
<div class="bg-light border-bottom">
    <div class="container py-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small fw-bold">
                <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-decoration-none text-muted"><i class="bi bi-house-door-fill"></i> Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('products.index') }}" class="text-decoration-none text-muted">Catalog</a></li>
                <li class="breadcrumb-item"><a href="{{ route('products.index', ['category' => $product->category->slug]) }}" class="text-decoration-none text-muted">{{ $product->category->name }}</a></li>
                <li class="breadcrumb-item active text-dark" aria-current="page">{{ $product->name }}</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container py-5 product-detail-page">
    <div class="row g-5">
        <!-- Left: Product Image Gallery -->
        <div class="col-lg-4">
            <div class="position-sticky" style="top: 20px;">
                <!-- Main Image -->
                <div class="card border-0 shadow-sm rounded-4 mb-3 overflow-hidden position-relative main-img-wrapper" style="border: 1px solid #e0e0e0 !important; cursor: zoom-in;">
                    @if($product->image)
                        <img src="{{ asset('storage/'.$product->image) }}" class="img-fluid w-100 zoom-hover" id="mainImage" alt="{{ $product->name }}" style="object-fit: cover; height: 350px; transition: opacity 0.3s ease-in-out, transform 0.5s ease;">
                    @else
                        <div class="bg-light text-muted d-flex align-items-center justify-content-center p-5" style="height: 400px;">
                            <i class="bi bi-camera fs-1"></i>
                        </div>
                    @endif
                </div>

                <!-- Thumbnails (Simulated Gallery) -->
                <div class="row g-2">
                    @if($product->image)
                    <div class="col-3">
                        <div class="border rounded-3 overflow-hidden cursor-pointer h-100 thumbnail-container border-primary" onclick="changeMainImage('{{ asset('storage/'.$product->image) }}', this)" style="transition: all 0.2s;">
                            <img src="{{ asset('storage/'.$product->image) }}" class="img-fluid w-100 h-100" style="object-fit: cover; transition: opacity 0.2s;">
                        </div>
                    </div>
                    @if($product->images && $product->images->count() > 0)
                        @foreach($product->images as $img)
                            <div class="col-3">
                                <div class="border rounded-3 overflow-hidden cursor-pointer h-100 thumbnail-container" onclick="changeMainImage('{{ asset('storage/'.$img->image) }}', this)" style="transition: all 0.2s;">
                                    <img src="{{ asset('storage/'.$img->image) }}" class="img-fluid w-100 h-100" style="object-fit: cover; transition: opacity 0.2s;">
                                </div>
                            </div>
                        @endforeach
                    @endif
                    @endif
                    @if($product->video_url)
                    <div class="col-3">
                        <a href="{{ $product->video_url }}" target="_blank" class="border rounded-3 p-2 bg-dark text-center h-100 d-flex align-items-center justify-content-center text-decoration-none transition-hover">
                            <i class="bi bi-play-circle-fill text-white fs-4"></i>
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Right: Product Information & Cart -->
        <div class="col-lg-8">
            <!-- Brand & Category -->
            <div class="d-flex align-items-center mb-2 product-meta">
                <span class="text-uppercase fw-bold text-muted small tracking-wide me-3">{{ $product->brand ?? 'General' }}</span>
                <span class="badge bg-primary text-white rounded-0 px-2 py-1 me-2"><i class="bi bi-tag-fill me-1"></i>{{ $product->category->name }}</span>
            </div>
            
            <!-- Title -->
            <h1 class="fw-bold text-dark mb-3" style="font-size: 2.2rem; letter-spacing: -0.5px;">{{ $product->name }}</h1>
            
            <!-- Divider -->
            <div class="mb-4 pb-3 border-bottom"></div>
            
            <!-- Price -->
            <div class="mb-4">
                <h2 class="text-dark fw-bold mb-0" style="font-size: 2rem;">
                    Rp {{ number_format($product->price, 0, ',', '.') }}
                    <span class="fs-6 text-muted fw-normal align-middle">/ unit</span>
                </h2>
                <small class="text-muted">Excl. PPN 11% & Shipping</small>
            </div>

            <!-- Add to Cart Action Area -->
            <div class="mb-5">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show rounded-4 border-0 shadow-sm" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                        <a href="{{ route('cart.index') }}" class="alert-link ms-2">View Cart</a>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger rounded-4 border-0 shadow-sm">{{ session('error') }}</div>
                @endif
                
                <form action="{{ route('cart.add') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <div class="d-flex flex-column flex-md-row gap-3 align-items-md-end product-actions">
                        
                        <!-- Quantity Selector -->
                        <div style="width: 140px;">
                            <label class="form-label fw-bold small text-muted mb-2">Quantity</label>
                            <div class="input-group input-group-sm rounded-pill overflow-hidden border">
                                <button class="btn btn-light border-0 px-3" type="button" onclick="var el=document.getElementById('qty'); if(el.value>1)el.value--;" style="background: #f8f9fa;">-</button>
                                <input type="number" id="qty" name="quantity" class="form-control border-0 text-center fw-bold shadow-none bg-light" value="1" min="1" max="9999">
                                <button class="btn btn-light border-0 px-3" type="button" onclick="var el=document.getElementById('qty'); el.value++;" style="background: #f8f9fa;">+</button>
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div>
                            <button type="submit" class="btn btn-primary rounded-pill fw-bold shadow-sm py-2 px-4 d-flex align-items-center justify-content-center transition-hover" {{ $product->stock < 0 ? 'disabled' : '' }}>
                                <i class="bi bi-cart-plus-fill me-2 fs-6"></i> 
                                {{ $product->stock >= 0 ? 'TAMBAH KE KERANJANG' : 'TIDAK TERSEDIA' }}
                            </button>
                        </div>
                        <div>
                            <button type="button" class="btn btn-outline-dark rounded-pill fw-bold py-2 px-4 d-flex align-items-center justify-content-center transition-hover" data-bs-toggle="modal" data-bs-target="#rfqModal">
                                <i class="bi bi-envelope-paper me-2 fs-6"></i> KIRIM RFQ LANGSUNG
                            </button>
                        </div>

                    </div>
                </form>
            </div>

            <!-- RFQ Modal -->
            <!-- RFQ Email Composer Modal -->
            <div class="modal fade" id="rfqModal" tabindex="-1" aria-labelledby="rfqModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content border-0 shadow-lg" style="border-radius: 12px; overflow: hidden;">
                        
                        <!-- Email Header -->
                        <div class="modal-header bg-dark text-white border-0 py-3 d-flex align-items-center">
                            <h6 class="modal-title fw-bold mb-0" id="rfqModalLabel"><i class="bi bi-envelope-plus-fill me-2"></i> Pesan Baru</h6>
                            <div class="ms-auto d-flex gap-3">
                                <i class="bi bi-dash cursor-pointer" data-bs-dismiss="modal"></i>
                                <i class="bi bi-arrows-angle-expand cursor-pointer"></i>
                                <i class="bi bi-x-lg cursor-pointer" data-bs-dismiss="modal"></i>
                            </div>
                        </div>

                        <!-- Email Meta Info -->
                        <div class="bg-light px-4 py-2 border-bottom text-muted" style="font-size: 0.9rem;">
                            <div class="row mb-2 align-items-center">
                                <div class="col-sm-1 text-end fw-bold">Kepada:</div>
                                <div class="col-sm-11">
                                    <span class="badge bg-primary rounded-pill px-3 py-1 fw-normal">sales@wma.co.id <i class="bi bi-x ms-1"></i></span>
                                </div>
                            </div>
                            <div class="row align-items-center">
                                <div class="col-sm-1 text-end fw-bold">Subjek:</div>
                                <div class="col-sm-11">
                                    <input type="text" id="rfqSubject" class="form-control form-control-sm border-0 bg-transparent fw-bold text-dark px-0 shadow-none" value="Permohonan Penawaran Harga (RFQ) - {{ $product->name }}" readonly>
                                </div>
                            </div>
                        </div>

                        @php
                            $globalCompanyProfile = \App\Models\CompanyProfile::first();
                            $rawWa = $globalCompanyProfile && $globalCompanyProfile->whatsapp ? $globalCompanyProfile->whatsapp : '6281189491561';
                            $waNumber = preg_replace('/[^0-9]/', '', $rawWa);
                            if (str_starts_with($waNumber, '0')) {
                                $waNumber = '62' . substr($waNumber, 1);
                            }
                        @endphp
                        <form id="rfqForm" action="{{ route('products.rfq.send', $product->slug) }}" method="POST">
                            @csrf
                            
                            <!-- Sender Quick Info -->
                            <div class="bg-white px-4 py-3 border-bottom">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="rfqLanguage" class="form-label small fw-bold text-muted mb-1">Bahasa RFQ / RFQ Language</label>
                                        <select id="rfqLanguage" name="language" class="form-select border-0 border-bottom rounded-0 shadow-none px-1" required style="background-color: transparent;">
                                            <option value="id">Bahasa Indonesia</option>
                                            <option value="en">English</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="email" id="rfqEmail" name="email" class="form-control border-0 border-bottom rounded-0 shadow-none px-1" placeholder="Email Aktif *" required style="background: transparent;">
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" id="rfqName" name="name" class="form-control border-0 border-bottom rounded-0 shadow-none px-1" placeholder="Nama Lengkap PIC *" required style="background: transparent;">
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" id="rfqCompany" name="company" class="form-control border-0 border-bottom rounded-0 shadow-none px-1" placeholder="Nama Perusahaan *" required style="background: transparent;">
                                    </div>
                                    <div class="col-md-6">
                                        <input type="tel" id="rfqPhone" name="phone" class="form-control border-0 border-bottom rounded-0 shadow-none px-1" placeholder="Telepon / WhatsApp *" required style="background: transparent;">
                                    </div>
                                    <div class="col-md-6">
                                        <input type="number" id="rfqQuantity" name="quantity" class="form-control border-0 border-bottom rounded-0 shadow-none px-1" placeholder="Jumlah Unit *" value="1" min="1" max="9999" required style="background: transparent;">
                                    </div>
                                </div>
                            </div>

                            <!-- Email Body Template -->
                            <div class="p-0 bg-white">
                                <textarea id="rfqNotes" name="notes" class="form-control border-0 px-4 py-4 shadow-none text-dark" rows="10" style="resize: none; font-family: 'Segoe UI', Arial, sans-serif; font-size: 0.95rem; line-height: 1.6;" required></textarea>
                            </div>

                            <!-- Footer Actions -->
                            <div class="bg-light p-3 border-top d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">
                                <div class="d-flex gap-2 w-100 w-md-auto">
                                    <button type="button" class="btn btn-success fw-bold px-4 rounded-pill shadow-sm d-flex align-items-center justify-content-center" style="background-color: #25D366; border: none;" onclick="sendRfqWhatsApp('{{ $waNumber }}', '{{ addslashes($product->name) }}')">
                                        <i class="bi bi-whatsapp me-2 fs-5"></i> Send via WhatsApp
                                    </button>
                                    <button type="submit" class="btn btn-primary fw-bold px-4 rounded-pill shadow-sm d-flex align-items-center justify-content-center">
                                        <i class="bi bi-envelope-fill me-2"></i> Kirim Email
                                    </button>
                                </div>
                                <div class="text-muted small">
                                    <i class="bi bi-shield-check text-success me-1"></i> Fast response from Sales Engineer
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Documents Download -->
            @if($product->datasheet)
            <div class="mb-5 border-start border-3 border-danger ps-3">
                <h6 class="fw-bold text-dark text-uppercase mb-2">Technical Documents</h6>
                <a href="{{ asset('storage/'.$product->datasheet) }}" target="_blank" class="btn btn-outline-danger btn-sm rounded-0 fw-bold">
                    <i class="bi bi-file-earmark-pdf-fill me-1"></i> Download PDF Datasheet
                </a>
            </div>
            @endif

            <!-- Modern Dynamic Tabs Area -->
            <div class="mt-5 pt-4 border-top">
                <div class="bg-white rounded-4 p-4 border-0">
                    <ul class="nav nav-pills modern-tabs mb-4 pb-3 border-bottom" id="productTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active fw-bold px-4 py-2 me-2 rounded-pill d-flex align-items-center" id="desc-tab" data-bs-toggle="pill" data-bs-target="#desc" type="button" role="tab">
                            <i class="bi bi-card-text me-2"></i> Description
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link fw-bold px-4 py-2 me-2 rounded-pill d-flex align-items-center" id="specs-tab" data-bs-toggle="pill" data-bs-target="#specs" type="button" role="tab">
                            <i class="bi bi-gear-wide-connected me-2"></i> Detailed Specification
                        </button>
                    </li>
                    @if($product->attributes->count() > 0)
                    <li class="nav-item" role="presentation">
                        <button class="nav-link fw-bold px-4 py-2 me-2 rounded-pill d-flex align-items-center" id="attr-tab" data-bs-toggle="pill" data-bs-target="#attr" type="button" role="tab">
                            <i class="bi bi-list-check me-2"></i> Key Attributes
                        </button>
                    </li>
                    @endif
                    <li class="nav-item" role="presentation">
                        <button class="nav-link fw-bold px-4 py-2 rounded-pill d-flex align-items-center" id="qa-tab" data-bs-toggle="pill" data-bs-target="#qa" type="button" role="tab">
                            <i class="bi bi-chat-dots me-2"></i> Questions ({{ $product->questions()->count() }})
                        </button>
                    </li>
                </ul>

                <div class="tab-content" id="productTabsContent">
                    <!-- Tab 1: Description -->
                    <div class="tab-pane fade show active fade-up-animation" id="desc" role="tabpanel">
                        @if($product->description)
                            <div class="product-description text-dark" style="line-height: 1.8;">
                                {!! $product->description !!}
                            </div>
                        @else
                            <div class="text-center text-muted py-5">
                                <i class="bi bi-card-text display-4 opacity-25 mb-3"></i>
                                <p>No description provided for this product.</p>
                            </div>
                        @endif
                    </div>

                    <!-- Tab 2: Specification -->
                    <div class="tab-pane fade fade-up-animation" id="specs" role="tabpanel">
                        @if($product->specification)
                            <div class="specification-content text-dark bg-white p-4 rounded-3 shadow-sm border" style="line-height: 1.8; font-size: 0.95rem;">
                                {!! $product->specification !!}
                            </div>
                        @else
                            <div class="text-center text-muted py-5 w-100">
                                <i class="bi bi-gear display-4 opacity-25 mb-3 d-block"></i>
                                <p>No detailed specifications provided for this product.</p>
                            </div>
                        @endif
                    </div>

                    <!-- Tab 3: Key Attributes -->
                    @if($product->attributes->count() > 0)
                    <div class="tab-pane fade fade-up-animation" id="attr" role="tabpanel">
                        <div class="table-responsive bg-white rounded-3 shadow-sm border mb-4">
                            <table class="table table-hover mb-0">
                                <tbody>
                                    @foreach($product->attributes as $attr)
                                    <tr style="border-bottom: 1px solid #f1f5f9;">
                                        <th width="30%" class="text-dark px-4 py-3 align-middle bg-light" style="font-weight: 600; font-size: 0.95rem;">{{ $attr->name }}</th>
                                        <td class="text-dark px-4 py-3 align-middle" style="font-size: 0.95rem;">{{ $attr->value }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endif
                    
                    <!-- Tab 3: Questions -->
                    <div class="tab-pane fade fade-up-animation" id="qa" role="tabpanel">
                    <!-- Form Tanya -->
                    <div class="mb-5 bg-light p-4 rounded border">
                        <h5 class="fw-bold mb-3"><i class="bi bi-chat-dots text-primary me-2"></i>Tanyakan Sesuatu tentang Produk Ini</h5>
                        @auth
                            <form action="{{ route('products.question.store', $product->id) }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <textarea class="form-control" name="question" rows="3" placeholder="Tulis pertanyaan Anda di sini..." required></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary fw-bold px-4 rounded-pill">Kirim Pertanyaan</button>
                            </form>
                        @else
                            <div class="alert alert-info mb-0">
                                Silakan <a href="{{ route('customer.login') }}" class="fw-bold alert-link">Login</a> untuk bertanya mengenai produk ini.
                            </div>
                        @endauth
                    </div>

                    <!-- List Pertanyaan -->
                    <div class="qa-list">
                        <h5 class="fw-bold mb-4">Pertanyaan dari Pembeli</h5>
                        @php $questions = $product->questions()->latest()->get(); @endphp
                        @forelse($questions as $q)
                            <div class="mb-4 pb-4 border-bottom">
                                <div class="d-flex align-items-start mb-2">
                                    <div class="bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px; font-weight: bold;">
                                        {{ strtoupper(substr($q->user->name ?? 'G', 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="fw-bold">{{ $q->user->name ?? 'Guest' }} <span class="text-muted fw-normal ms-2 small">{{ $q->created_at->diffForHumans() }}</span></div>
                                        <p class="mb-0 mt-1">{{ $q->question }}</p>
                                    </div>
                                </div>
                                @if($q->answer)
                                    <div class="d-flex align-items-start mt-3 ms-5 bg-light p-3 rounded border-start border-3 border-primary">
                                        <div class="bg-white rounded-circle d-flex align-items-center justify-content-center me-3 shadow-sm border" style="width: 35px; height: 35px; overflow: hidden;">
                                            <img src="{{ asset('images/logo.png') }}" alt="PT. Wiratama Mitra Abadi" style="width: 100%; height: 100%; object-fit: contain; padding: 2px;">
                                        </div>
                                        <div>
                                            <div class="fw-bold text-primary">PT. Wiratama Mitra Abadi <span class="text-muted fw-normal ms-2 small">Membalas</span></div>
                                            <p class="mb-0 mt-1">{{ $q->answer }}</p>
                                        </div>
                                    </div>
                                @elseif($q->user_id == \Illuminate\Support\Facades\Auth::id())
                                    <div class="ms-5 mt-2 text-muted small fst-italic">
                                        <i class="bi bi-clock me-1"></i> Menunggu balasan dari admin.
                                    </div>
                                @endif
                            </div>
                        @empty
                            <div class="text-center text-muted py-4">
                                <i class="bi bi-chat-square-text display-4 mb-3 d-block opacity-50"></i>
                                Belum ada pertanyaan untuk produk ini.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>

    <!-- Related Products -->
    @if($related_products->count() > 0)
    <div class="row mt-5 pt-4">
        <div class="col-12 mb-4 d-flex justify-content-between align-items-end border-bottom pb-2">
            <h3 class="fw-bold text-dark mb-0">Frequently Bought Together</h3>
            <a href="{{ route('products.index', ['category' => $product->category->slug]) }}" class="text-primary text-decoration-none fw-bold small">View all in {{ $product->category->name }} <i class="bi bi-arrow-right"></i></a>
        </div>
        
        <div class="row g-4">
            @foreach($related_products as $related)
            <div class="col-lg-3 col-md-6">
                <div class="card h-100 border rounded-0 product-card position-relative bg-white">
                    <div class="p-3">
                        @if($related->image)
                            <img src="{{ asset('storage/'.$related->image) }}" class="card-img-top mx-auto d-block" alt="{{ $related->name }}" style="height: 160px; object-fit: contain;">
                        @else
                            <div class="bg-light text-muted d-flex align-items-center justify-content-center" style="height: 160px;">
                                <i class="bi bi-box fs-1"></i>
                            </div>
                        @endif
                    </div>
                    <div class="card-body border-top p-3 d-flex flex-column bg-light">
                        <h6 class="card-title fw-bold text-dark mb-3" style="font-size: 0.95rem;">
                            <a href="{{ route('products.show', $related->slug) }}" class="text-dark text-decoration-none stretched-link hover-primary">{{ Str::limit($related->name, 50) }}</a>
                        </h6>
                        <div class="mt-auto">
                            <span class="text-primary fw-bold d-block fs-5">Rp {{ number_format($related->price, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    @if($related_articles->isNotEmpty())
    <section class="row mt-5 pt-4 border-top" aria-labelledby="related-articles-title">
        <div class="col-12 mb-3">
            <h2 id="related-articles-title" class="h4 fw-bold text-dark">Artikel terkait {{ $product->category->name }}</h2>
        </div>
        @foreach($related_articles as $article)
        <div class="col-md-4 mb-3">
            <article class="border rounded-3 h-100 p-3 bg-white">
                <h3 class="h6 fw-bold mb-2"><a href="{{ route('blog.show', $article->slug) }}" class="text-dark text-decoration-none">{{ $article->title }}</a></h3>
                <p class="text-muted small mb-0">{{ Str::limit(strip_tags($article->content), 110) }}</p>
            </article>
        </div>
        @endforeach
    </section>
    @endif
</div>

<style>
    body { background-color: #fbfbfb; }
    #rfqModal .modal-dialog { max-height: calc(100vh - 2rem); }
    #rfqModal .modal-content { max-height: calc(100vh - 2rem); }
    #rfqModal .modal-content > form { flex: 1 1 auto; min-height: 0; overflow-y: auto; }
    @media (max-width: 575.98px) {
        #rfqModal .modal-dialog { margin: 0.5rem; }
        #rfqModal .modal-content { max-height: calc(100vh - 1rem); }
        .product-detail-page .container {
            padding-left: 1rem;
            padding-right: 1rem;
        }
        .product-detail-page h1 {
            font-size: 1.65rem !important;
            line-height: 1.2;
            overflow-wrap: anywhere;
        }
        .product-detail-page .product-meta {
            flex-wrap: wrap;
            gap: 0.45rem;
        }
        .product-detail-page .product-meta .me-3 {
            margin-right: 0 !important;
        }
        .product-detail-page .product-actions > div,
        .product-detail-page .product-actions button {
            width: 100%;
        }
        #rfqModal .modal-header,
        #rfqModal .modal-body,
        #rfqModal .modal-footer {
            padding-left: 1rem !important;
            padding-right: 1rem !important;
        }
        #rfqModal .modal-header .modal-title {
            max-width: 70%;
            overflow-wrap: anywhere;
        }
        #rfqModal .modal-content > form > .bg-light:last-child,
        #rfqModal .modal-content > form > div:last-child {
            align-items: stretch !important;
        }
        #rfqModal .modal-content > form button {
            width: 100%;
        }
        #rfqModal .modal-content > form .d-flex.gap-2 {
            flex-direction: column;
        }
        .modern-tabs {
            flex-wrap: nowrap;
            overflow-x: auto;
            padding-bottom: 0.75rem !important;
        }
        .modern-tabs .nav-link {
            white-space: nowrap;
            padding-left: 0.85rem !important;
            padding-right: 0.85rem !important;
        }
    }
    .cursor-pointer { cursor: pointer; }
    .tracking-wide { letter-spacing: 0.05em; }
    .product-card {
        transition: all 0.2s ease-in-out;
        border-color: #e0e0e0 !important;
    }
    .product-card:hover {
        border-color: #0d47a1 !important;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    }
    .hover-primary:hover { color: #0d47a1 !important; }
    .modern-tabs .nav-link {
        color: #6c757d;
        transition: all 0.3s ease;
        background-color: transparent;
        border: 1px solid transparent;
    }
    .modern-tabs .nav-link:hover {
        background-color: #f8f9fa;
        color: #0d47a1;
        border-color: #e9ecef;
    }
    .modern-tabs .nav-link.active {
        background-color: #0d47a1;
        color: white !important;
        box-shadow: 0 4px 12px rgba(13, 71, 161, 0.2);
    }
    .fade-up-animation {
        animation: fadeUp 0.4s ease forwards;
    }
    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .transition-hover {
        transition: opacity 0.2s;
    }
    .transition-hover:hover {
        opacity: 0.8;
    }
    /* Specific typography for technical feel */
    .product-description ul, .specification-content ul {
        padding-left: 1.5rem;
    }
    .product-description li, .specification-content li {
        margin-bottom: 0.5rem;
    }
    .main-img-wrapper:hover .zoom-hover {
        transform: scale(1.1);
    }
    /* Style tables inside specification content */
    .specification-content table {
        width: 100%;
        margin-bottom: 1rem;
        border-collapse: collapse;
    }
    .specification-content table th, .specification-content table td {
        padding: 0.75rem;
        vertical-align: top;
        border: 1px solid #dee2e6;
    }
    .specification-content table thead th, .specification-content table tr th:first-child {
        background-color: #f8f9fa;
        font-weight: 600;
    }
    .specification-content table tbody tr:hover {
        background-color: rgba(0,0,0,.02);
    }
</style>

@push('scripts')
<script>
    function changeMainImage(src, element) {
        const mainImage = document.getElementById('mainImage');
        // Fade out slightly
        mainImage.style.opacity = '0.5';
        
        setTimeout(() => {
            mainImage.src = src;
            // Fade back in
            mainImage.style.opacity = '1';
        }, 150);

        // Update active border state on thumbnails
        document.querySelectorAll('.thumbnail-container').forEach(el => {
            el.classList.remove('border-primary');
            el.classList.add('border-light');
        });
        element.classList.remove('border-light');
        element.classList.add('border-primary');
</script>
<script>
    // Automatically add Bootstrap table classes to any tables inside specification content
    document.addEventListener("DOMContentLoaded", function() {
        const specDiv = document.querySelector('.specification-content');
        if (specDiv) {
            const tables = specDiv.querySelectorAll('table');
            tables.forEach(table => {
                table.classList.add('table', 'table-bordered', 'table-hover');
                
                // Wrap in table-responsive
                const wrapper = document.createElement('div');
                wrapper.classList.add('table-responsive', 'mb-0');
                table.parentNode.insertBefore(wrapper, table);
                wrapper.appendChild(table);
            });
        }
    });

    const rfqProductName = @json($product->name);

    function updateRfqDraft() {
        const notes = document.getElementById('rfqNotes');
        if (!notes || notes.dataset.edited === 'true') {
            return;
        }

        const language = document.getElementById('rfqLanguage').value;
        const subject = document.getElementById('rfqSubject');
        subject.value = language === 'en'
            ? 'Request for Quotation (RFQ) - ' + rfqProductName
            : 'Permohonan Penawaran Harga (RFQ) - ' + rfqProductName;
        const name = document.getElementById('rfqName').value || '[Nama Lengkap PIC]';
        const company = document.getElementById('rfqCompany').value || '[Nama Perusahaan]';
        const email = document.getElementById('rfqEmail').value || '[Email]';
        const phone = document.getElementById('rfqPhone').value || '[Nomor Telepon / WhatsApp]';
        const quantity = document.getElementById('rfqQuantity').value || '1';

        if (language === 'en') {
            notes.value = `Dear Sales Team of PT Wiratama Mitra Abadi,

We would like to request a formal quotation from ${company} for the following product:
- Product name      : ${rfqProductName}
- Quantity          : ${quantity} unit(s)
- Required date     : [Please specify required date]
- Delivery location : [Please specify delivery address]

Please include your best price, product availability, estimated delivery time, quotation validity, warranty, and payment terms.

Please let us know if any additional information is required.

Thank you for your attention and cooperation. We look forward to receiving your quotation.

Best regards,

${name}
${company}
${phone}
${email}`;
            return;
        }

        notes.value = `Yth. Tim Sales PT. Wiratama Mitra Abadi,

Dengan hormat,

Kami dari ${company} bermaksud meminta penawaran harga resmi untuk produk berikut:
- Nama produk       : ${rfqProductName}
- Jumlah            : ${quantity} unit
- Waktu kebutuhan   : [Isi waktu kebutuhan]
- Lokasi pengiriman : [Isi alamat/lokasi pengiriman]

Mohon dapat diinformasikan harga terbaik, ketersediaan barang, estimasi waktu pengiriman, masa berlaku penawaran, garansi, serta ketentuan pembayaran.

Apabila diperlukan informasi tambahan, kami siap melengkapinya.

Demikian permohonan ini kami sampaikan. Atas perhatian dan kerja sama yang baik, kami ucapkan terima kasih.

Hormat kami,

${name}
${company}
${phone}
${email}`;
    }

    document.addEventListener('DOMContentLoaded', function() {
        const draftFields = ['rfqLanguage', 'rfqEmail', 'rfqName', 'rfqCompany', 'rfqPhone', 'rfqQuantity'];
        const notes = document.getElementById('rfqNotes');

        draftFields.forEach(function(fieldId) {
            document.getElementById(fieldId).addEventListener('input', updateRfqDraft);
        });
        document.getElementById('rfqLanguage').addEventListener('change', function() {
            notes.dataset.edited = 'false';
            updateRfqDraft();
        });
        notes.addEventListener('input', function() {
            notes.dataset.edited = 'true';
        });
        updateRfqDraft();
    });

    function sendRfqWhatsApp(waNum, productName) {
        const name = document.getElementById('rfqName').value || '-';
        const company = document.getElementById('rfqCompany').value || '-';
        const email = document.getElementById('rfqEmail').value || '-';
        const phone = document.getElementById('rfqPhone').value || '-';
        const quantity = document.getElementById('rfqQuantity').value || '1';
        const notes = document.getElementById('rfqNotes').value || '';
        const language = document.getElementById('rfqLanguage').value;

        let text = language === 'en' ? "*REQUEST FOR QUOTATION (RFQ)*\nPT Wiratama Mitra Abadi\n\nDear Sales Team of PT Wiratama Mitra Abadi,\n\nWe, " + company + ", would like to request a formal quotation for the following product:\n\n*Product name*: " + productName + "\n*Quantity*: " + quantity + " unit(s)\n\n*Contact details*\nContact person: " + name + "\nCompany: " + company + "\nEmail: " + email + "\nPhone/WhatsApp: " + phone + "\n\n*Additional requirements*:\n" + notes + "\n\nPlease include your best price, availability, estimated delivery, quotation validity, warranty, and payment terms.\n\nThank you for your attention and cooperation.\n\nBest regards,\n" + name + "\n" + company + "\n" + phone + "\n" + email : "*PERMOHONAN PENAWARAN HARGA (RFQ)*\nPT Wiratama Mitra Abadi\n\nYth. Tim Sales PT Wiratama Mitra Abadi,\n\nDengan hormat, kami dari " + company + " bermaksud meminta penawaran harga resmi untuk produk berikut:\n\n*Nama produk*: " + productName + "\n*Jumlah*: " + quantity + " unit\n\n*Data pemohon*\nNama PIC: " + name + "\nPerusahaan: " + company + "\nEmail: " + email + "\nTelepon/WhatsApp: " + phone + "\n\n*Detail kebutuhan*:\n" + notes + "\n\nMohon diinformasikan harga terbaik, ketersediaan barang, estimasi pengiriman, masa berlaku penawaran, garansi, dan ketentuan pembayaran.\n\nAtas perhatian dan kerja sama yang baik, kami ucapkan terima kasih.\n\nHormat kami,\n" + name + "\n" + company + "\n" + phone + "\n" + email;

        const url = "https://wa.me/" + waNum + "?text=" + encodeURIComponent(text);
        window.open(url, '_blank');
        const modalEl = document.getElementById('rfqModal');
        if (modalEl && bootstrap.Modal.getInstance(modalEl)) {
            bootstrap.Modal.getInstance(modalEl).hide();
        }
    }

</script>
@endpush
@endsection
