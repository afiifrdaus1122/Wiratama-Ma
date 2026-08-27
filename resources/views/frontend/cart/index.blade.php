@extends('layouts.app')

@section('content')
<div class="bg-light py-5 border-bottom" style="background: linear-gradient(180deg, #f8fafc 0%, #ffffff 100%);">
    <div class="container">
        <h2 class="fw-bold text-dark mb-0" style="font-size: 2.5rem; letter-spacing: -0.03em;"><i class="bi bi-cart3 me-2 text-primary"></i> Keranjang Belanja</h2>
        <p class="text-muted mt-2">Tinjau kembali barang yang Anda butuhkan sebelum melanjutkan ke proses checkout.</p>
    </div>
</div>

<div class="container py-5">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-4 shadow-sm border-0" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show rounded-4 shadow-sm border-0" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-5">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm" style="border-radius: 24px; overflow: hidden; box-shadow: 0 15px 35px -5px rgba(0,0,0,0.05) !important;">
                <div class="card-header bg-white border-bottom-0 py-4 px-4 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold fs-4">Daftar Barang</h5>
                    <span class="badge bg-light text-dark rounded-pill px-3 py-2 border">{{ count($cart) }} Items</span>
                </div>
                <div class="card-body p-0">
                    @if(count($cart) > 0)
                        <div class="table-responsive">
                            <table class="table table-borderless align-middle mb-0">
                                <thead class="text-muted small" style="background-color: #f8fafc; border-top: 1px solid #f1f5f9; border-bottom: 1px solid #f1f5f9;">
                                    <tr>
                                        <th scope="col" class="ps-4 py-3 fw-semibold">Product Details</th>
                                        <th scope="col" width="120" class="py-3 fw-semibold">Price</th>
                                        <th scope="col" width="150" class="text-center py-3 fw-semibold">Quantity</th>
                                        <th scope="col" width="120" class="text-end py-3 fw-semibold">Subtotal</th>
                                        <th scope="col" width="80" class="text-center pe-4 py-3 fw-semibold"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($cart as $id => $details)
                                    <tr style="border-bottom: 1px solid #f1f5f9;">
                                        <td class="ps-4 py-4">
                                            <div class="d-flex align-items-center">
                                                @if($details['image'])
                                                    <img src="{{ asset('storage/'.$details['image']) }}" alt="{{ $details['name'] }}" class="rounded-3 me-3 border" style="width: 80px; height: 80px; object-fit: cover;">
                                                @else
                                                    <div class="bg-light text-muted d-flex align-items-center justify-content-center me-3 rounded-3 border" style="width: 80px; height: 80px;">
                                                        <i class="bi bi-box fs-3"></i>
                                                    </div>
                                                @endif
                                                <div>
                                                    <a href="{{ route('products.show', $details['slug'] ?? '#') }}" class="text-dark fw-bold text-decoration-none hover-primary mb-1 d-block" style="font-size: 1.05rem;">{{ $details['name'] }}</a>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="fw-semibold text-muted">Rp {{ number_format($details['price'], 0, ',', '.') }}</td>
                                        <td>
                                            <form action="{{ route('cart.update') }}" method="POST" class="d-flex align-items-center justify-content-center">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="product_id" value="{{ $id }}">
                                                <div class="input-group" style="width: 100px;">
                                                    <input type="number" name="quantity" value="{{ $details['quantity'] }}" class="form-control text-center rounded-pill border-light bg-light fw-bold" min="1" max="{{ $details['stock'] ?? 99 }}" onchange="this.form.submit()">
                                                </div>
                                            </form>
                                        </td>
                                        <td class="text-end fw-bold text-dark">Rp {{ number_format($details['price'] * $details['quantity'], 0, ',', '.') }}</td>
                                        <td class="text-center pe-4">
                                            <form action="{{ route('cart.remove') }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" name="product_id" value="{{ $id }}">
                                                <button type="submit" class="btn btn-sm btn-light text-danger rounded-circle p-2" style="width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; margin: 0 auto; transition: all 0.2s;" onmouseover="this.classList.remove('btn-light'); this.classList.add('btn-danger'); this.classList.remove('text-danger'); this.classList.add('text-white');" onmouseout="this.classList.add('btn-light'); this.classList.remove('btn-danger'); this.classList.add('text-danger'); this.classList.remove('text-white');">
                                                    <i class="bi bi-trash3-fill"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5 my-4">
                            <div class="d-inline-flex align-items-center justify-content-center bg-light rounded-circle mb-4" style="width: 120px; height: 120px;">
                                <i class="bi bi-cart-x text-muted" style="font-size: 3.5rem;"></i>
                            </div>
                            <h4 class="fw-bold text-dark mb-2">Keranjang belanja Anda kosong</h4>
                            <p class="text-muted mb-4 pb-2">Sepertinya Anda belum menambahkan produk apapun ke keranjang.</p>
                            <a href="{{ route('products.index') }}" class="btn btn-primary rounded-pill px-5 py-3 fw-bold shadow-sm">Lihat Katalog Produk</a>
                        </div>
                    @endif
                </div>
            </div>
            
            @if(count($cart) > 0)
                <div class="mt-4 ms-2">
                    <a href="{{ route('products.index') }}" class="text-decoration-none fw-semibold text-muted hover-primary transition-all"><i class="bi bi-arrow-left me-2"></i> Continue Shopping</a>
                </div>
            @endif
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm position-sticky" style="top: 20px; border-radius: 24px; box-shadow: 0 20px 40px -10px rgba(0,0,0,0.08) !important;">
                <div class="card-body p-4 p-xl-5">
                    <h5 class="mb-4 fw-bold fs-4">Ringkasan Belanja</h5>
                    
                    <div class="d-flex justify-content-between mb-3 text-muted">
                        <span>Estimasi Subtotal</span>
                        <span class="fw-semibold text-dark">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-4 text-muted">
                        <span>PPN (11%)</span>
                        <span class="fw-semibold text-dark">Rp {{ number_format($ppn, 0, ',', '.') }}</span>
                    </div>
                    
                    <div class="border-top border-dashed my-4" style="border-top-style: dashed !important; opacity: 0.5;"></div>
                    
                    <div class="d-flex justify-content-between mb-4 align-items-center">
                        <span class="fw-bold fs-5">Estimasi Total</span>
                        <span class="fw-black fs-4 text-primary" style="font-weight: 900;">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>

                    <div class="d-flex flex-column gap-2 mb-3">
                        @php
                            $globalCompanyProfile = \App\Models\CompanyProfile::first();
                            $rawWa = $globalCompanyProfile && $globalCompanyProfile->whatsapp ? $globalCompanyProfile->whatsapp : '6281189491561';
                            $waNumber = preg_replace('/[^0-9]/', '', $rawWa);
                            if (str_starts_with($waNumber, '0')) {
                                $waNumber = '62' . substr($waNumber, 1);
                            }

                            $waMessage = "*PERMINTAAN PENAWARAN HARGA (RFQ)*\n";
                            $waMessage .= "_PT Wiratama Mitra Abadi_\n\n";
                            $waMessage .= "*Daftar Barang:*\n";
                            $i = 1;
                            foreach($cart as $item) {
                                $waMessage .= $i++ . ". " . $item['name'] . " (" . $item['quantity'] . " Unit)\n";
                            }
                            $waMessage .= "\n*Estimasi Total:* Rp " . number_format($total, 0, ',', '.') . "\n\n";
                            $waMessage .= "Halo Tim Sales PT Wiratama Mitra Abadi, mohon kirimkan penawaran resmi (Quotation) untuk produk di atas. Terima kasih!";
                            
                            $waLink = "https://wa.me/" . $waNumber . "?text=" . rawurlencode($waMessage);

                            $emailBody = "Halo Tim Sales PT Wiratama Mitra Abadi,\n\nSaya tertarik dan ingin mengajukan penawaran (RFQ) untuk produk-produk berikut:\n\n";
                            foreach($cart as $item) {
                                $emailBody .= "- " . $item['name'] . " (" . $item['quantity'] . " Unit)\n";
                            }
                            $emailBody .= "\nMohon informasi harga terbaik dan ketersediaan stoknya.\n\nTerima kasih.";
                            $encodedBody = rawurlencode($emailBody);
                            $mailtoLink = "mailto:sales@wma.co.id?subject=" . rawurlencode("Request For Quotation (RFQ)") . "&body=" . $encodedBody;
                        @endphp
                        <a href="{{ $waLink }}" target="_blank" class="btn btn-success rounded-pill py-3 px-4 fw-bold shadow-sm {{ count($cart) == 0 ? 'disabled' : '' }}" style="font-size: 1.05rem; background-color: #25D366; border: none;">
                            <i class="bi bi-whatsapp me-2 fs-5 align-middle"></i> Ajukan via WhatsApp Sales
                        </a>
                        <a href="{{ $mailtoLink }}" class="btn btn-outline-primary rounded-pill py-2.5 px-4 fw-semibold {{ count($cart) == 0 ? 'disabled' : '' }}" style="font-size: 0.95rem;">
                            <i class="bi bi-envelope-check me-2"></i> Ajukan via Email (sales@wma.co.id)
                        </a>
                    </div>
                    
                    <div class="mt-4 text-center p-3 bg-light rounded-4 border">
                        <i class="bi bi-shield-check text-success fs-4 mb-2 d-block"></i>
                        <span class="text-muted small fw-semibold d-block">Layanan Pengadaan Terpercaya</span>
                        <span class="text-muted" style="font-size: 0.75rem;">Tim kami akan memberikan penawaran harga terbaik untuk kebutuhan Anda.</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .hover-primary:hover { color: #0070f3 !important; }
    .transition-all { transition: all 0.3s ease; }
</style>
@endsection
