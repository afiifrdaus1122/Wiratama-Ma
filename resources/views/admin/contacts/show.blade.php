@extends('adminlte::page')

@section('title', 'Detail Pesan Kontak')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Detail Pesan Kontak</h1>
        <a href="{{ route('admin.contacts.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
    </div>
@stop

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h3 class="card-title fw-bold">Informasi Pengirim</h3>
                </div>
                <div class="card-body">
                    <dl class="mb-0">
                        <dt>Nama Lengkap</dt>
                        <dd>{{ $contact->name }}</dd>
                        
                        <dt>Perusahaan</dt>
                        <dd>{{ $contact->company ?: '-' }}</dd>
                        
                        <dt>Email</dt>
                        <dd>
                            <a href="mailto:{{ $contact->email }}">{{ $contact->email }}</a>
                        </dd>
                        
                        <dt>Nomor Telepon / WhatsApp</dt>
                        <dd>
                            @if($contact->phone)
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $contact->phone) }}" target="_blank">
                                    <i class="fab fa-whatsapp text-success"></i> {{ $contact->phone }}
                                </a>
                            @else
                                -
                            @endif
                        </dd>
                        
                        <dt>Waktu Kirim</dt>
                        <dd>{{ $contact->created_at->format('d F Y, H:i') }} ({{ $contact->created_at->diffForHumans() }})</dd>
                    </dl>
                </div>
            </div>
        </div>
        
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h3 class="card-title fw-bold">Isi Pesan</h3>
                </div>
                <div class="card-body">
                    <h5 class="fw-bold mb-3 border-bottom pb-2">Subjek: {{ $contact->subject }}</h5>
                    
                    <div class="p-3 bg-light rounded" style="white-space: pre-wrap; font-size: 1.05rem; line-height: 1.6;">{{ $contact->message }}</div>
                </div>
                <div class="card-footer bg-white">
                    <a href="mailto:{{ $contact->email }}?subject=RE: {{ $contact->subject }}" class="btn btn-primary">
                        <i class="fas fa-reply"></i> Balas via Email
                    </a>
                    <form action="{{ route('admin.contacts.destroy', $contact->id) }}" method="POST" class="d-inline float-right" onsubmit="return confirm('Hapus pesan ini?');">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger"><i class="fas fa-trash"></i> Hapus Pesan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
