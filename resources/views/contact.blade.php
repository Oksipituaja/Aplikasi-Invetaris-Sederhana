@extends('layouts.main')

@section('title', 'Kontak Kami')

@section('header')
    <h1>Kontak Kami</h1>
@endsection

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm">
        <div class="card-body">
            <p class="text-muted">Silahkan tinggalkan pesan anda, pada kolom yang tersedia.</p>

            <form method="POST" action="{{ route('contact.submit') }}">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label">Nama Anda</label>
                    <input type="text" name="name" id="name" class="form-control" required placeholder="Masukkan nama lengkap">
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">E-mail Anda</label>
                    <input type="email" name="email" id="email" class="form-control" required placeholder="Masukkan email aktif">
                </div>

                <div class="mb-3">
                    <label for="message" class="form-label">Pesan Anda</label>
                    <textarea name="message" id="message" rows="5" class="form-control" required placeholder="Tulis pesan anda di sini..."></textarea>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-paper-plane me-1"></i> Kirim Pesan
                </button>
            </form>
        </div>
    </div>
</div>
@endsection