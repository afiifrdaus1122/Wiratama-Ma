@extends('layouts.app')

@section('content')
<style>
    .contact-page-bg {
        background-color: #f8fafc;
        min-height: calc(100vh - 80px);
    }
    .contact-title {
        font-weight: 800;
        color: #0f172a;
        letter-spacing: -1px;
    }
    .contact-info-card {
        background: transparent;
        border: none;
    }
    .info-icon-box {
        width: 54px;
        height: 54px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        flex-shrink: 0;
    }
    .icon-blue { background: #eff6ff; color: #3b82f6; }
    .icon-green { background: #f0fdf4; color: #22c55e; }
    .icon-red { background: #fef2f2; color: #ef4444; }
    
    .social-icon-btn {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: white;
        color: #475569;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
        text-decoration: none;
    }
    .social-icon-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);
        color: #0d47a1;
    }

    .beautiful-form-card {
        background: #ffffff;
        border-radius: 24px;
        padding: 3rem;
        box-shadow: 0 20px 40px -10px rgba(13, 71, 161, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.5);
    }
    .form-control-beautiful {
        background-color: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 14px 18px;
        font-size: 1rem;
        color: #334155;
        transition: all 0.3s ease;
    }
    .form-control-beautiful:focus {
        background-color: #ffffff;
        border-color: #3b82f6;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
        outline: none;
    }
    .form-label-beautiful {
        font-weight: 600;
        color: #475569;
        margin-bottom: 8px;
        font-size: 0.95rem;
    }
    .btn-submit-beautiful {
        background: linear-gradient(135deg, #0d47a1 0%, #1d4ed8 100%);
        color: white;
        border: none;
        border-radius: 12px;
        padding: 14px 24px;
        font-weight: 600;
        letter-spacing: 0.5px;
        transition: all 0.3s ease;
    }
    .btn-submit-beautiful:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(13, 71, 161, 0.2);
    }
    @media (max-width: 991px) {
        .beautiful-form-card { padding: 2rem; }
    }
</style>

<div class="contact-page-bg py-5">
    <div class="container py-4">
        
        <div class="row mb-5">
            <div class="col-12 text-center" data-aos="fade-up">
                <h1 class="contact-title display-5 mb-3">{{ $profile->contact_title ?? 'Contact Us' }}</h1>
                <p class="text-muted fs-5 mx-auto" style="max-width: 600px;">
                    {{ $profile->contact_subtitle ?? 'We are ready to help you. Feel free to contact our team for product inquiries or technical support.' }}
                </p>
            </div>
        </div>

        <div class="row g-5 align-items-start">
            
            <!-- LEFT SIDE: Contact Info (Like 1st Image) -->
            <div class="col-lg-5" data-aos="fade-right" data-aos-delay="100">
                <div class="pe-lg-4">
                    <h3 class="fw-bold mb-4" style="color: #0f172a;">Contact Information</h3>
                    
                    <div class="d-flex align-items-start mb-4 pb-2">
                        <div class="info-icon-box icon-blue me-4">
                            <i class="bi bi-geo-alt-fill"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-2" style="color: #1e293b;">Our Office</h5>
                            <p class="text-muted mb-0" style="line-height: 1.6;">{{ $profile->address ?? 'Jl. Raya Perusahaan No. 123, Jakarta' }}</p>
                        </div>
                    </div>

                    <div class="d-flex align-items-start mb-4 pb-2">
                        <div class="info-icon-box icon-green me-4">
                            <i class="bi bi-whatsapp"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-2" style="color: #1e293b;">WhatsApp / Phone</h5>
                            @if(!empty($profile->phone))
                                <p class="text-muted mb-1"><i class="bi bi-telephone me-2"></i>{{ $profile->phone }}</p>
                            @endif
                            @if(!empty($profile->whatsapp))
                                <div class="d-flex align-items-center gap-3">
                                    <span class="text-muted"><i class="bi bi-whatsapp me-2"></i>{{ $profile->whatsapp }}</span>
                                </div>
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $profile->whatsapp) }}" target="_blank" class="btn btn-sm btn-success rounded-pill mt-2 px-3 fw-semibold shadow-sm">
                                    <i class="bi bi-chat-dots me-1"></i> Chat WhatsApp
                                </a>
                            @endif
                        </div>
                    </div>

                    <div class="d-flex align-items-start mb-5">
                        <div class="info-icon-box icon-red me-4">
                            <i class="bi bi-envelope-fill"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-2" style="color: #1e293b;">Company Email</h5>
                            <p class="text-muted mb-2">{{ $profile->email ?? 'info@wiratama-ma.com' }}</p>
                            <a href="mailto:{{ $profile->email ?? 'info@wiratama-ma.com' }}" class="text-decoration-none fw-semibold" style="color: #2563eb;">Send Email &rarr;</a>
                        </div>
                    </div>

                    <h5 class="fw-bold mb-3" style="color: #1e293b;">Social Media</h5>
                    <div class="d-flex flex-wrap gap-3">
                        <a href="https://wma.co.id" target="_blank" class="social-icon-btn" title="Website Utama"><i class="bi bi-globe"></i></a>
                        @if(!empty($profile->linkedin))
                            <a href="{{ $profile->linkedin }}" target="_blank" class="social-icon-btn" title="LinkedIn"><i class="bi bi-linkedin"></i></a>
                        @endif
                        @if(!empty($profile->facebook))
                            <a href="{{ $profile->facebook }}" target="_blank" class="social-icon-btn" title="Facebook"><i class="bi bi-facebook"></i></a>
                        @endif
                        @if(!empty($profile->instagram))
                            <a href="{{ $profile->instagram }}" target="_blank" class="social-icon-btn" style="color: #e1306c;" title="Instagram"><i class="bi bi-instagram"></i></a>
                        @endif
                        @if(!empty($profile->youtube))
                            <a href="{{ $profile->youtube }}" target="_blank" class="social-icon-btn" style="color: #ff0000;" title="YouTube"><i class="bi bi-youtube"></i></a>
                        @endif
                        <a href="https://www.tiktok.com/@wiratama_ma" target="_blank" class="social-icon-btn" style="color: #000000;" title="TikTok"><i class="bi bi-tiktok"></i></a>
                    </div>
                </div>
            </div>

            <!-- RIGHT SIDE: Beautiful Form -->
            <div class="col-lg-7" data-aos="fade-left" data-aos-delay="200">
                <div class="beautiful-form-card">
                    <h3 class="fw-bold mb-4" style="color: #0f172a;">Send Message</h3>
                    
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show rounded-3 border-0 bg-success text-white shadow-sm mb-4" role="alert">
                            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('contact.store') }}" method="POST">
                        @csrf
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label for="name" class="form-label-beautiful">Full Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-beautiful w-100" id="name" name="name" required>
                            </div>
                            <div class="col-md-6">
                                <label for="company" class="form-label-beautiful">Company Name</label>
                                <input type="text" class="form-control form-control-beautiful w-100" id="company" name="company">
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label-beautiful">Email Address <span class="text-danger">*</span></label>
                                <input type="email" class="form-control form-control-beautiful w-100" id="email" name="email" required>
                            </div>
                            <div class="col-md-6">
                                <label for="phone" class="form-label-beautiful">Phone / WA Number</label>
                                <input type="text" class="form-control form-control-beautiful w-100" id="phone" name="phone">
                            </div>
                            <div class="col-12">
                                <label for="subject" class="form-label-beautiful">Message Subject <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-beautiful w-100" id="subject" name="subject" required>
                            </div>
                            <div class="col-12">
                                <label for="message" class="form-label-beautiful">Message Content <span class="text-danger">*</span></label>
                                <textarea class="form-control form-control-beautiful w-100" id="message" name="message" rows="5" required></textarea>
                            </div>
                            <div class="col-12 mt-4 pt-2">
                                <button type="submit" class="btn-submit-beautiful w-100 d-flex justify-content-center align-items-center">
                                    Send Message <i class="bi bi-send-fill ms-2"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        @if(!empty($profile->maps_embed))
        <div class="row mt-5">
            <div class="col-12" data-aos="fade-up">
                <h4 class="fw-bold mb-3 text-dark"><i class="bi bi-geo-alt me-2 text-danger"></i> Location Map</h4>
                <div class="rounded-4 overflow-hidden shadow-sm border bg-white p-2" style="min-height: 350px;">
                    <div class="ratio ratio-21x9 rounded-3 overflow-hidden h-100" style="min-height: 350px;">
                        {!! $profile->maps_embed !!}
                    </div>
                </div>
            </div>
        </div>
        @endif

    </div>
</div>
@endsection
