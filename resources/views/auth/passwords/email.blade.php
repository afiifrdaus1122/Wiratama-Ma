@extends('layouts.app')

@section('content')
<style>
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
        padding: 12px 15px;
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
</style>

<div class="customer-login-bg">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-5">
                <div class="glass-card p-4 p-md-5">
                    <div class="text-center mb-4">
                        <img src="{{ asset('images/logo.png') }}" alt="WMA Logo" height="50" class="mb-2">
                        <div class="d-flex flex-column justify-content-center" style="color: #0d47a1; line-height: 1.1;">
                            <span class="fw-bold fs-5 mb-1">Wiratama-MA</span>
                        </div>
                        <h3 class="fw-bold text-dark mt-4 mb-2">Lupa Kata Sandi?</h3>
                        <p class="text-muted small mb-0">Masukkan email Anda dan kami akan mengirimkan tautan untuk mengatur ulang kata sandi.</p>
                    </div>

                    @if (session('status'))
                        <div class="alert alert-success p-3 mb-4 rounded-3 small border-0 bg-success text-white">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger p-3 mb-4 rounded-3 small border-0 bg-danger text-white">
                            <ul class="mb-0 ps-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf
                        <div class="mb-4">
                            <label class="form-label fw-bold small text-dark">Alamat Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        </div>

                        <button type="submit" class="btn btn-customer w-100 mb-4 border-0">
                            Kirim Tautan Reset
                        </button>
                    </form>

                    <div class="text-center mt-3 pt-3 border-top">
                        <p class="text-muted small mb-0">Ingat kata sandi Anda? 
                            <a href="{{ route('customer.login') }}" class="fw-bold text-decoration-none" style="color: #0d47a1;">Kembali ke Login</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection