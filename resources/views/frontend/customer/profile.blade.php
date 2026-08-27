@extends('layouts.app')

@section('content')
<div class="bg-light py-4 border-bottom">
    <div class="container">
        <h2 class="fw-bold text-dark mb-0"><i class="bi bi-person-gear me-2"></i> Pengaturan Profil</h2>
    </div>
</div>

<div class="container py-5">
    <div class="row g-4">
        <!-- Sidebar -->
        <div class="col-md-3">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body text-center">
                    <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px; font-size: 2rem;">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <h5 class="fw-bold mb-1">{{ $user->name }}</h5>
                    <p class="text-muted small">{{ $user->email }}</p>
                    
                    <form action="{{ route('customer.logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger btn-sm w-100">Logout</button>
                    </form>
                </div>
            </div>
            
            <div class="list-group shadow-sm border-0">
                <a href="{{ route('customer.dashboard') }}" class="list-group-item list-group-item-action">
                    <i class="bi bi-box-seam me-2"></i> My Orders
                </a>
                <a href="{{ route('customer.profile') }}" class="list-group-item list-group-item-action active fw-bold">
                    <i class="bi bi-person-circle me-2"></i> Edit Profile
                </a>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="col-md-9">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold">Detail Akun & Perusahaan</h5>
                </div>
                <div class="card-body p-4">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('customer.profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <h6 class="fw-bold text-primary mb-3 border-bottom pb-2">Informasi Kontak Dasar</h6>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="name" value="{{ old('name', $user->name) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" name="email" value="{{ old('email', $user->email) }}" required>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Nomor WhatsApp / Telepon</label>
                                <input type="text" class="form-control" name="phone" value="{{ old('phone', $user->phone) }}">
                            </div>
                        </div>

                        <h6 class="fw-bold text-primary mb-3 border-bottom pb-2">Data Perusahaan (B2B)</h6>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Nama Perusahaan</label>
                                <input type="text" class="form-control" name="company_name" value="{{ old('company_name', $user->company_name) }}" placeholder="PT / CV ...">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Nomor NPWP</label>
                                <input type="text" class="form-control" name="npwp" value="{{ old('npwp', $user->npwp) }}">
                            </div>
                        </div>

                        <h6 class="fw-bold text-primary mb-3 border-bottom pb-2">Buku Alamat</h6>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Kota</label>
                                <input type="text" class="form-control" name="city" value="{{ old('city', $user->city) }}">
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-bold">Alamat Lengkap</label>
                            <textarea class="form-control" name="address" rows="3">{{ old('address', $user->address) }}</textarea>
                            <small class="text-muted">Alamat ini akan otomatis terisi saat Anda melakukan Checkout pesanan berikutnya.</small>
                        </div>

                        <h6 class="fw-bold text-primary mb-3 border-bottom pb-2">Ubah Kata Sandi (Opsional)</h6>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Password Baru</label>
                                <input type="password" class="form-control" name="password" placeholder="Kosongkan jika tidak ingin mengubah">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Konfirmasi Password Baru</label>
                                <input type="password" class="form-control" name="password_confirmation" placeholder="Konfirmasi password baru">
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary btn-lg px-5 fw-bold"><i class="bi bi-save me-2"></i> Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
