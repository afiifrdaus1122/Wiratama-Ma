@extends('layouts.app')

@section('content')
@php
    $type = request('type', 'checkout');
    $isRfq = $type === 'rfq';
@endphp
<div class="bg-light py-5 border-bottom" style="background: linear-gradient(180deg, #f8fafc 0%, #ffffff 100%);">
    <div class="container">
        <h2 class="fw-bold text-dark mb-0 checkout-page-title" style="font-size: 2.5rem; letter-spacing: -0.03em;">
            @if($isRfq)
                <i class="bi bi-file-earmark-text me-2 text-primary"></i> Request Quotation
            @else
                <i class="bi bi-cart-check me-2 text-primary"></i> Checkout Pesanan
            @endif
        </h2>
        <p class="text-muted mt-2">
            @if($isRfq)
                Lengkapi data berikut untuk mendapatkan penawaran harga resmi dari kami.
            @else
                Lengkapi data berikut untuk memproses pesanan dan melakukan pembayaran.
            @endif
        </p>
    </div>
</div>

<div class="container py-5">
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show rounded-4 shadow-sm border-0" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-5">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm" style="border-radius: 24px; overflow: hidden; box-shadow: 0 15px 35px -5px rgba(0,0,0,0.05) !important;">
                <div class="card-header bg-white border-bottom-0 py-4 px-4 px-xl-5">
                    <h5 class="mb-0 fw-bold fs-4">Billing Details</h5>
                </div>
                <div class="card-body p-4 p-xl-5 pt-0">
                    <form action="{{ route('checkout.store') }}" method="POST" id="checkoutForm">
                        @csrf
                        <input type="hidden" name="checkout_type" value="{{ $type }}">
                        
                        <div class="row mb-4">
                            <div class="col-md-6 mb-4 mb-md-0">
                                <label for="contact_person" class="form-label fw-semibold text-muted">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-lg border-light bg-light @error('contact_person') is-invalid @enderror" id="contact_person" name="contact_person" value="{{ old('contact_person', Auth::user()->name) }}" required style="border-radius: 12px; font-size: 1rem;">
                                @error('contact_person')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label fw-semibold text-muted">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control form-control-lg border-light bg-light @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', Auth::user()->email) }}" required style="border-radius: 12px; font-size: 1rem;">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6 mb-4 mb-md-0">
                                <label for="phone" class="form-label fw-semibold text-muted">Nomor WhatsApp <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-lg border-light bg-light @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone', Auth::user()->phone) }}" required style="border-radius: 12px; font-size: 1rem;">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="company_name" class="form-label fw-semibold text-muted">Nama Perusahaan</label>
                                <input type="text" class="form-control form-control-lg border-light bg-light @error('company_name') is-invalid @enderror" id="company_name" name="company_name" value="{{ old('company_name', Auth::user()->company_name) }}" style="border-radius: 12px; font-size: 1rem;">
                                @error('company_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="city" class="form-label fw-semibold text-muted">Kota <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-lg border-light bg-light @error('city') is-invalid @enderror" id="city" name="city" value="{{ old('city', Auth::user()->city) }}" required style="border-radius: 12px; font-size: 1rem;">
                            @error('city')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="address" class="form-label fw-semibold text-muted">Alamat Lengkap <span class="text-danger">*</span></label>
                            <textarea class="form-control form-control-lg border-light bg-light @error('address') is-invalid @enderror" id="address" name="address" rows="3" required style="border-radius: 12px; font-size: 1rem;">{{ old('address', Auth::user()->address) }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="notes" class="form-label fw-semibold text-muted">Catatan (Opsional)</label>
                            <textarea class="form-control form-control-lg border-light bg-light @error('notes') is-invalid @enderror" id="notes" name="notes" rows="2" style="border-radius: 12px; font-size: 1rem;">{{ old('notes') }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm position-sticky checkout-summary-card" style="top: 20px; border-radius: 24px; box-shadow: 0 20px 40px -10px rgba(0,0,0,0.08) !important;">
                <div class="card-header bg-white border-bottom-0 py-4 px-4 px-xl-5">
                    <h5 class="mb-0 fw-bold fs-4">Your Order</h5>
                </div>
                <div class="card-body p-4 p-xl-5 pt-0">
                    <div class="mb-4">
                        @foreach($cart as $details)
                            <div class="d-flex justify-content-between mb-3 pb-3 border-bottom border-light checkout-order-row">
                                <div>
                                    <span class="text-dark fw-bold d-block">{{ Str::limit($details['name'], 30) }}</span>
                                    <small class="text-muted fw-semibold">x {{ $details['quantity'] }}</small>
                                </div>
                                <span class="fw-bold text-dark">Rp {{ number_format($details['price'] * $details['quantity'], 0, ',', '.') }}</span>
                            </div>
                        @endforeach
                    </div>

                    <div class="d-flex justify-content-between mb-3 text-muted">
                        <span>Subtotal</span>
                        <span class="fw-semibold text-dark">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">PPN (11%)</span>
                        <span class="fw-semibold text-dark">Rp {{ number_format($ppn, 0, ',', '.') }}</span>
                    </div>
                    
                    <div class="border-top border-dashed my-4" style="border-top-style: dashed !important; opacity: 0.5;"></div>
                    
                    <div class="d-flex justify-content-between mb-4 align-items-center">
                        <span class="fw-bold fs-5">Total</span>
                        <span class="fw-black fs-4 text-primary" style="font-weight: 900;">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>

                    <button type="submit" form="checkoutForm" class="checkout-submit-button btn btn-primary w-100 rounded-pill fw-bold shadow-sm">
                        @if($isRfq)
                            Kirim Permintaan Penawaran <i class="bi bi-arrow-right ms-2"></i>
                        @else
                            Proses Pesanan Sekarang <i class="bi bi-check-circle ms-2"></i>
                        @endif
                    </button>
                    
                    <div class="mt-4 text-center p-3 bg-light rounded-4 border">
                        <div class="d-flex align-items-center justify-content-center gap-2 mb-2">
                            <i class="bi bi-shield-check text-success fs-5"></i>
                        </div>
                        @if($isRfq)
                            <span class="text-muted small fw-semibold d-block">B2B RFQ System</span>
                            <span class="text-muted" style="font-size: 0.75rem;">Tim sales kami akan merespons permintaan Anda melalui email atau WhatsApp.</span>
                        @else
                            <span class="text-muted small fw-semibold d-block">Transaksi Aman Terpercaya</span>
                            <span class="text-muted" style="font-size: 0.75rem;">Data Anda dilindungi oleh enkripsi standar industri.</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @media (max-width: 767.98px) {
        .checkout-page-title {
            font-size: 1.75rem !important;
            line-height: 1.2;
        }
        .checkout-summary-card {
            position: static !important;
        }
        .checkout-order-row {
            gap: 0.75rem;
        }
        .checkout-order-row > span:last-child {
            white-space: nowrap;
            font-size: 0.9rem;
        }
    }
    .checkout-submit-button {
        min-height: 52px;
        padding: 0.8rem 1.25rem;
        font-size: 1rem;
        line-height: 1.35;
        transition: transform 0.2s ease, box-shadow 0.2s ease, background-color 0.2s ease;
    }
    .checkout-submit-button:hover {
        transform: translateY(-1px);
        box-shadow: 0 8px 18px rgba(15, 54, 112, 0.16) !important;
    }
</style>
@endsection
