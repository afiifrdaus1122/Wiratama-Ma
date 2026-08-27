@extends('layouts.app')

@section('content')
<style>
    /* Customer Register Specific Styles */
    .customer-login-bg {
        background-image: linear-gradient(rgba(10, 30, 60, 0.7), rgba(10, 30, 60, 0.8)), url('https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        min-height: calc(100vh - 80px);
        margin-top: -80px;
        display: flex;
        align-items: center;
        padding: 100px 0;
    }
    .glass-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 20px;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        overflow: hidden;
    }
    .glass-card .form-control {
        background: #f8f9fa;
        border: 1px solid #e9ecef;
        border-radius: 10px;
        padding: 10px 15px;
        transition: all 0.3s ease;
    }
    .glass-card .form-control:focus {
        background: #fff;
        border-color: #0d47a1;
        box-shadow: 0 0 0 4px rgba(13, 71, 161, 0.1);
    }
    .btn-customer {
        background: #0d47a1;
        color: white;
        border-radius: 10px;
        padding: 12px;
        font-weight: 600;
        letter-spacing: 0.5px;
        transition: all 0.3s ease;
    }
    .btn-customer:hover {
        background: #0a3579;
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(13, 71, 161, 0.2);
    }
    
    /* Hide native Edge/IE password reveal icon */
    input[type="password"]::-ms-reveal,
    input[type="password"]::-ms-clear {
        display: none;
    }

    /* Mobile Responsiveness */
    @media (max-width: 768px) {
        .customer-login-bg {
            padding: 60px 0;
            margin-top: -60px; /* Adjusting for potentially smaller mobile header */
            min-height: 100vh;
        }
        .glass-card {
            padding: 1.5rem 1.25rem !important;
            border-radius: 16px;
        }
        .btn-customer {
            padding: 14px;
            font-size: 1.05rem;
        }
        .glass-card h3 {
            font-size: 1.4rem;
        }
    }
</style>

<div class="customer-login-bg">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-10 col-md-8 col-lg-5 col-xl-4">
                <div class="glass-card p-4">
                    <div class="text-center mb-4">
                        <img src="{{ asset('images/logo.png') }}" alt="WMA Logo" height="50" class="mb-2">
                        <div class="d-flex flex-column justify-content-center" style="color: #0d47a1; line-height: 1.1;">
                            <span class="fw-bold fs-5 mb-1">Wiratama-MA</span>
                            <span class="fw-semibold text-muted" style="font-size: 0.85rem;">PT. Wiratama Mitra Abadi <span class="fw-normal">(E-Commerce)</span></span>
                        </div>
                        <h3 class="fw-bold text-dark mt-4 mb-2">Create Account</h3>
                        <p class="text-muted small mb-0">Lengkapi data diri Anda untuk bergabung sebagai mitra kami.</p>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger p-3 mb-4 rounded-3 small border-0 bg-danger text-white">
                            <ul class="mb-0 ps-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('customer.register') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-bold small text-dark">Nama Lengkap</label>
                            <input type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold small text-dark">Alamat Email</label>
                            <input type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold small text-dark">Nomor Telepon / WhatsApp</label>
                            <input type="text" class="form-control" name="phone" value="{{ old('phone') }}" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold small text-dark">Kata Sandi</label>
                            <div class="input-group">
                                <input type="password" class="form-control border-end-0" name="password" id="regPassword" required>
                                <button class="btn btn-light border border-start-0" type="button" id="toggleRegPassword" style="background: #f8f9fa;">
                                    <i class="bi bi-eye-slash text-muted"></i>
                                </button>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label fw-bold small text-dark">Konfirmasi Kata Sandi</label>
                            <div class="input-group">
                                <input type="password" class="form-control border-end-0" name="password_confirmation" id="regPasswordConf" required>
                                <button class="btn btn-light border border-start-0" type="button" id="toggleRegPasswordConf" style="background: #f8f9fa;">
                                    <i class="bi bi-eye-slash text-muted"></i>
                                </button>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-customer w-100 mb-3 border-0">
                            Daftar Sekarang
                        </button>
                    </form>

                    <div class="text-center mt-3 pt-3 border-top">
                        <p class="text-muted small mb-0">Sudah memiliki akun? 
                            <a href="{{ route('customer.login') }}" class="fw-bold text-decoration-none" style="color: #0d47a1;">Masuk di sini</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function setupToggle(inputId, toggleId) {
        document.getElementById(toggleId).addEventListener('click', function (e) {
            const password = document.getElementById(inputId);
            const icon = this.querySelector('i');
            
            if (password.type === 'password') {
                password.type = 'text';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            } else {
                password.type = 'password';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            }
        });
        
        document.getElementById(inputId).addEventListener('focus', function() {
            document.getElementById(toggleId).style.borderColor = '#0d47a1';
            document.getElementById(toggleId).style.backgroundColor = '#fff';
        });
        document.getElementById(inputId).addEventListener('blur', function() {
            document.getElementById(toggleId).style.borderColor = '#e9ecef';
            document.getElementById(toggleId).style.backgroundColor = '#f8f9fa';
        });
    }

    setupToggle('regPassword', 'toggleRegPassword');
    setupToggle('regPasswordConf', 'toggleRegPasswordConf');
</script>
@endsection
